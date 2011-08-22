#!c:\Python26\python.exe

import os
import sys
import MySQLdb
import cgi, cgitb

db_host = 'localhost'
db_user = 'root'
db_password = ''
db_name = 'rpz'

def getSize(url):
    db = MySQLdb.connect(host=db_host, user=db_user, passwd=db_password, db=db_name)
    cursor = db.cursor()
    cursor.execute("select * from `files` where `url` = '" + url + "'")
    result = cursor.fetchall()
    cursor.close()
    if len(result) == 0:
        print "<tr><td style='text-align:left'><a href='" + url + "' style='text-decoration:underline' target='_blank'>" + url + "</a></td><td style='text-align:left'>Starting download...</td></tr>"
        return
    else:
        row = result[0]
        
        if row[2] == 1:
            print "<tr><td style='text-align:left'><a href='" + url + "' style='text-decoration:underline' target='_blank'>" + url + "</a></td><td style='text-align:left'>Download complete.</td></tr>"
            return
        else:
            fname = row[1]
            size = row[3]
            direc = os.path.abspath(os.path.dirname(os.path.realpath(__file__)))
            res = direc.partition("ajax")
            dire = res[0] + "data"
            files = os.listdir(dire)
            
            current_size = 0
            for filename in files:
                if fname in filename:
                    file = os.path.join(dire, filename)
                    filesize = int(os.path.getsize(file))
                    current_size += filesize

            if current_size > size:
                print "Error in filesize"
            else:
                complete = float(float(current_size) / float(size)) * 100
                print "<tr><td style='text-align:left'><a href='" + url + "' style='text-decoration:underline' target='_blank'>" + url + "</a></td><td bgcolor='#FF6600' style='text-align:left'><img src='i/progress.png' width='%.2f' align='left'/> </td></tr>" %(2*complete)

def main():
    cgitb.enable()
    print "Content-Type: text/html\n\n"
    form = cgi.FieldStorage()
    url = form.getvalue("url")
    getSize(url)

if __name__=="__main__":
    main()
