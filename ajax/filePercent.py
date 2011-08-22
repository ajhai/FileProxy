#!c:\Python26\python.exe

import cgi, cgitb, os


def main():
    cgitb.enable()
    print "Content-Type: text/html\n\n"
    form = cgi.FieldStorage()
    filename = form.getvalue("filename")
    size = form.getvalue("size")

    

if __name__ == '__main__':
    main()
