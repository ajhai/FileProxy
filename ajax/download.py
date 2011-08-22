#!/usr/bin/env python
#
# pyget2.py
# A python download accelerator
#
# This file uses multiprocessing along with
# chunked/parallel downloading to speed up
# the download of files (if possible).
#
# @author  Benjamin Hutchins
# @project Lead Bulb Download Manager
#
# Copyright 2010 Benjamin Hutchins
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#   http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#
#
# @author  ajhai
# @license MIT License
#


import sys
import time
import cookielib
import urllib
import urllib2
import urlparse
import os
import cgi
import multiprocessing
import MySQLdb
import md5

first_connection = None
byte_size = 1024*8
site_root = 'http://localhost/rpz/'

db_host = 'localhost'
db_user = 'root'
db_password = ''
db_name = 'rpz'

def write(text):
    '''Write and then flush, useful for multi-process'''
    print text
    sys.stdout.flush()

def log(text, lock = None):
    '''Log events for debugging and to see what broke later on'''
    t = str(time.strftime("%a, %d %b %Y %H:%M:%S: ", time.localtime()))
    t += text
    if lock: lock.acquire(block=True, timeout=None)
    f = open("download_log","a")
    f.write(t)
    f.close()
    if lock: lock.release()

class Header(str):
    '''This is a custom String Object,
    used to manipulate HTTP Header returns'''
    pass

class Connection:

    def __init__(self, handler):
        self.handler = handler
        self.parse = self.handler.parse
        self.url = self.handler.uri

    def connectme(self, parse, url):
        self.parse = parse
        self.url = url
        connect(self)

    def connect(self, start = 0, end = 0):
        url = self.url
        parse = self.parse
		
        if parse.scheme in ('http', 'https',):
            cj = cookielib.LWPCookieJar()

            if self.getDomain() in ('hotfile',):
                cj.load('hotcookie.txt')
            elif self.getDomain() in ('rapidshare',):
                cj.load('rapidcookie.txt')
            elif self.getDomain() in ('megaupload',):
                cj.load('megacookie.txt')
            else:
                pass

            opener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cj))
            urllib2.install_opener(opener)

            request = urllib2.Request(url)
            request.add_header('User-agent', 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.1) Gecko/2008071615 Fedora/3.0.1-1.fc9 Firefox/3.0.1')

            if start > 0:
                request.add_header('Range', 'bytes=%i-%i' % (start, end))

            self.conn = urllib2.urlopen(request)

            uri = str(self.conn.geturl())

            if len(uri):
                self.handler.uri = uri # update so we can try and connect directly

            if self.headers.get('Accept-Ranges', False):
                ret = True
            else:
                ret = False
        else:
            exit('Unsupported scheme!')

        return ret

    @property
    def filesize(self):
        filesize = self.headers.get('Content-Length', None)

        if filesize is not None:
            return int(str(filesize)) # go to str first for headers
        else:
            return None

    @property
    def filename(self):
        '''Wrapper to get filename sent by server'''
        filename = self.headers.get('Content-Disposition', False)
        if filename:
            if 'filename' in filename:
                filename = filename.filename
            else:
                filename = "temp"
        if not filename: filename = os.path.basename(self.handler.parse.path)
        return filename

    @property
    def headers(self):
        headers = {}
        for header in str(self.conn.info()).split('\n'):
            if ':' in header:
                # Find header name
                parts = header.split(':')
                name = parts.pop(0).strip()
                value = ':'.join(parts).strip()

                # Turn value into a custom str object
                value = Header(value)

                # Assign extras
                (junk, parts) = cgi.parse_header(header)
                for key in parts.keys():
                    setattr(value, key, parts[key])

                # Add header to dict
                headers[name] = value

        return headers


    def getDomain(self):
        x = self.parse
        try:
            domain = x.netloc.split('.')[-2]
            if domain == 'co':
                domain = x.netloc.split('.')[-3]
        except IndexError:
            return 'Error ' + url 

        return domain


    def read(self, bytes = None):
        if bytes:   return self.conn.read(bytes)
        else:       return self.conn.read()


    def close(self):
        try:
            self.conn.close()
        except:
            pass


class Handler:
    
    def __init__(self, url, conns, uid, jhash):
        # Parse URI
        self.chunked_conns = int(conns)
        self.uri = url
        self.uid = uid
        self.original_url = url
        self.jhash = jhash
        self.parse = urlparse.urlparse(self.uri)
        #self.dir = os.path.abspath(os.path.dirname(os.path.realpath(__file__)))
        direc = os.path.abspath(os.path.dirname(os.path.realpath(__file__)))
        res = direc.partition("ajax")
        self.dir = res[0] + "data"
        
        # Gather fileinfo from Request
        self.gather()
        
    
    def gather(self):
        connection = Connection(self)
        self.can_resume = connection.connect()

        self.filesize = connection.filesize
        self.filename = connection.filename
        download = True

        
        log(self.uri + ' ' + self.filename + ' ' + str(self.filesize) + ' ' + str(self.can_resume) + '\n')
	db = MySQLdb.connect(host=db_host, user=db_user, passwd=db_password, db=db_name)
	cursor = db.cursor()
	cursor.execute("select * from `files` where `fname` = '" + self.filename + "' and size = '" + str(self.filesize) + "'")
	result = cursor.fetchall()
	cursor.close()
	if len(result) > 0:
            log(self.filename + ' already exists\n')
            row = result[0]
            insert_id = row[0]
	    hsh = str(self.uid) + str(insert_id) + str(time.time())
	    hsh = str(md5.md5(hsh).hexdigest())
	    self.hash = hsh
	    cursor = db.cursor()
	    cursor.execute("replace into `downloads` (fid, uid, hash, jhash) values ('" + str(insert_id) + "','" + str(self.uid) + "','" + hsh +"','" + str(self.jhash) + "')")
            sys.stdout.flush()
            cursor.close()
	    return True
	else:
            log(self.filename + ' doesnot exist. Need to download now\n')
	    cursor = db.cursor()
	    cursor.execute("insert into `files` (fname, size, url) values ('" + self.filename + "', '" + str(self.filesize) + "', '" + self.original_url +"')")
	    insert_id = db.insert_id()
	    hsh = str(self.uid) + str(insert_id) + str(time.time())
	    hsh = str(md5.md5(hsh).hexdigest())
	    self.hash = hsh
	    cursor.execute("replace into `downloads` (fid, uid, hash, jhash) values ('" + str(insert_id) + "','" + str(self.uid) + "','" + hsh +"','" + str(self.jhash) + "')")
	    cursor.close()
        if self.can_resume and self.filename:
            # Confirm number of connections
            #  is greater than one
            if self.chunked_conns > 1:
                global first_connection
                first_connection = connection
                self.chunks = self.chunk(self.chunked_conns)
                self.start(self.chunks)
                while not self.rebuild():
                    log(self.uri + ' Download not done. Trying again!\n')
                    self.start(self.chunks)

                download = False

        if download:
            savepath = os.path.join(self.dir, self.filename)
            log(self.uri + ' Downloading with single connection to %s\n' % savepath)
            log(self.uri + ' ' + str(connection.headers) + '\n')
            output_file = open(savepath, 'wb')

            while 1:
                chunk = connection.read(byte_size)
                if not chunk: # EOF
                    break
                output_file.write(chunk)

            output_file.close()
            connection.close()

        # Update Status
        log(self.uri + ' Download complete\n')

        filename = os.path.join(self.dir, self.filename)
        fna = md5.md5(str(time.time())).hexdigest()
        newname = os.path.join(self.dir, fna)
        os.rename(filename, newname)
	db = MySQLdb.connect(host=db_host, user=db_user, passwd=db_password, db=db_name)
	cursor = db.cursor()
	cursor.execute("update `files` set `downloaded` = 1, `final_fname` = '" + fna + "' where `fname` = '" + self.filename + "' and `size` = '" + str(self.filesize) + "' limit 1")
        cursor.close()
        

    def chunk(self, chunked_conns):
        '''Divide the file into chunk sizes
        to download.'''

        chunks = [] # chunks
        handled = 0 # to confirm every byte is accounted for


        # Look to resume the download
        files = os.listdir(self.dir)
        if 1:
            per_conn = int(self.filesize / chunked_conns)
            for i in range(0, chunked_conns):
                filename = '%s.%.2i.%i.%i.part' % (self.filename, i, handled, handled + per_conn)
                chunks.append((
                    i,                      # number
                    handled,                # start
                    handled + per_conn,     # end
                    per_conn,               # number of bytes
                    filename,               # file to write to
                    ))
                handled = handled + per_conn


            # check difference of handled
            diff = self.filesize - handled
            if diff > 0:
                (i, start, end, bytes, filename) = chunks.pop()
                end = end + diff
                bytes = bytes + diff
                filename = '%s.%.2i.%i.%i.part' % (self.filename, i, start, end)
                chunks.append((i, start, end, bytes, filename))
            elif diff < 0:
                (i, start, end, bytes, filename) = chunks.pop()
                end = end - diff
                bytes = bytes - diff
                filename = '%s.%.2i.%i.%i.part' % (self.filename, i, start, end)
                chunks.append((i, start, end, bytes, filename))

        return chunks

    def start(self, chunks):
        '''Start subprocesses for each chunk connection'''
        ps = []
        lock = multiprocessing.Lock()

        # Start connections
        for chunk in chunks:
            p = multiprocessing.Process(target=self.connect, args=chunk + (lock,))
            p.start()
            ps.append(p)

        # Wait for all to finish
        for p in ps:
            p.join()


    def connect(self, number, start, end, totalbytes, filename, lock):
        '''Connect to server, download this chunk

        number      connection number
        connection  active connection, can be None
                        if None must open a connection
        start       first byte to get
        end         last byte to get
        totalbytes  total amount of bytes to download'''

        # Start a timer
        tic = time.time()
        log(self.uri + ' connection %i: started (time now is %i)\n' % (number, tic), lock)


        # Start a connection
        global first_connection
        if number == 0 and first_connection:
            connection = first_connection
        else:
            connection = Connection(self)
            connection.connect(start, end-1) # -1 on end HTTP 1.1
            

        # Check filesize
        size = connection.filesize
        if not size:
            log(self.uri + ' connection %i: filesize was not returned\n' % number, lock)
            return

        if self.filesize != size and totalbytes != size:
            log(self.uri + 'connection %i: received different filesize, killing this connection (got: %i, wanted %i or %i)\n' % (number, size, self.filesize, totalbytes), lock)
            return


        # Start file
        filename = os.path.join(self.dir, filename)
        if os.path.exists(filename):    filepart = open(filename, 'ab')
        else:                           filepart = open(filename, 'wb')
        fetched = 0 # number of bytes downloaded through this connection


        # Start Downloading
        log(self.uri + ' connection %i: receiving data (want to get %i)\n' % (number, totalbytes), lock)
        while totalbytes > fetched:
            # Determine amount of bytes to get
            bytes = byte_size

            # Should we only get remaining bytes?
            if fetched + bytes > totalbytes:
                bytes = totalbytes - fetched

            # Grab the chunk
            #log('connection %i: getting %i bytes' % (number, bytes), lock)
            chunk = connection.read(bytes)

            # Write the chunk to file
            filepart.write(chunk)

            # Continue
            fetched = fetched + len(chunk)


        # Close stuff
        log(self.uri + ' connection %i: closing connection and part file\n' % number, lock)
        connection.close()  # close the connection
        filepart.close()    # close the file


        # Finish timer
        toc = time.time()
        t = toc-tic
        log(self.uri + ' connection %i: time %i, average speed %f bps, downloaded %i bytes\n' % (number, t, float(fetched / t), fetched), lock)

    def rebuild(self):

        # Get list of part files
        files = os.listdir(self.dir)
        files.sort() # sort in order to make sure we append properly
        # Confirm file sizes, make sure we have all data
        bytes = 0
        for filename in files:
           fname = self.filename + '.'
           if fname in filename:
                for p in self.chunks:
                    if filename == p[4]:
                        self.chunks.remove(p)
                    
                file = os.path.join(self.dir, filename)
                filesize = int(os.path.getsize(file))
                bytes = bytes + filesize

                fils = filename.split('.')
                ext = fils[-1]
                end = fils[-2]
                start = fils[-3]
                total = int(end) - int(start)
                log(self.uri + ' Part File: %s, should be %s, is %i, needs %i\n' % (filename, total, filesize, total - filesize))


        if bytes != self.filesize:
            log(self.uri + ' Filesizes do not match! Something went wrong!\n')
            return False


        # Create output file
        path = os.path.join(self.dir, self.filename)
        log(self.uri + ' Rebuilding file to %s\n' % path)
        output_file = open(path, 'wb')


        # Rebuild file
        for filename in files:
            fname = self.filename + '.'
            if fname in filename:
                # Open part file
                f = os.path.join(self.dir, filename)
                file = open(f, 'rb')

                # Write contents to output file
                output_file.write(file.read()) # TODO: make this go through a "while" to have a percentage bar

                # Close file part, so we can delete it (not-in-use)
                file.close()

                # Delete part file
                os.remove(f)


        # Close output file
        output_file.close()
        return True



def main(argv):
    Handler(argv[1], argv[2])

if __name__=='__main__':
    main(sys.argv)
