#!c:\Python26\python.exe

import download
import getFileSize
import cgi, cgitb, urllib, urlparse, MySQLdb
import sys
import md5
import time

chunked_conns = 35
site_root = 'http://localhost/rpz/'
db_host = 'localhost'
db_user = 'root'
db_password = ''
db_name = 'rpz'

def getDomain(url):
    x = urlparse.urlparse(url)
    try:
        domain = x.netloc.split('.')[-2]
        if domain == 'co':
            domain = x.netloc.split('.')[-3]
    except IndexError:
        return 'Error ' + url 
    return domain

def checkDomain(domain):
    db = MySQLdb.connect(host=db_host, user=db_user, passwd=db_password, db=db_name)
    cursor = db.cursor()
    cursor.execute("select * from `domains` where `domain_name` = '" + domain + "'")
    result = cursor.fetchall()
    cursor.close()
    if len(result) > 0:
        return True
    else:
        return False

def main():
    #cgitb.enable()
    print "Content-Type: text/html\n\n"
    form = cgi.FieldStorage()
    urls = form.getvalue("urls")
    uid = form.getvalue("uid")
    urls = urls.translate(None, " ")
    jhash = str(md5.md5(str(uid) + str(time.time())).hexdigest())
    nonerror = 0
    for url in urls.split('\n'):
        if url == "":
            continue
        domain = getDomain(url)
        if len(url) > 0 and domain.startswith("Error ") == False:
            if checkDomain(domain):
                t = download.Handler(url, chunked_conns, uid, jhash)
                print "<a href='" + site_root + "data/download.php?id=" + t.hash + "' target='_blank' style='text-decoration:underline;'>" + site_root + "data/download.php?id=" + t.hash + "</a><br>"
                nonerror = 1
                sys.stdout.flush()
            else:
                print domain + " Not supported<br>"
        else:
            print domain + "<br>"
    if nonerror:
        print "<br><br><b>JDownloader Link</b><br><br><a href='" + site_root + "data/jdownload.php?id=" + jhash + "' target='_blank' style='text-decoration:underline;'>" + site_root + "data/jdownload.php?id=" + jhash + "</a><br>"

if __name__ == '__main__':
    main()
