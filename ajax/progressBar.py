#!c:\Python26\python.exe

import getFileSize
import cgi, cgitb, urllib, urlparse, MySQLdb
import sys

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
    urls = urls.translate(None, " ")
    for url in urls.split('\n'):
        domain = getDomain(url)
        if len(url) > 0 and domain.startswith("Error ") == False:
            if checkDomain(domain):
                print "<table border=0 align='center' cellspacing='5px'><tr><td style='text-align:left'><strong>Download URL</strong></td><td width='200px' style='text-align:left'><strong>Progress</strong></td></tr><tr><td colspan='2'><hr></td></tr>"
                getFileSize.getSize(url)
                print "</table>"
            else:
                print domain + " Not supported<br>\n"
        else:
            print domain + "<br>"

if __name__ == '__main__':
    main()
