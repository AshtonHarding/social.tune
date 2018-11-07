#! /bin/bash

import socket, threading, time, msvcrt

print "Please enter the following information"
_url = raw_input("URL: ")
_port = raw_input("Port: ")
print "Starting IIM client on port: " + _port

socketOut = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
socketOut.connect((_url, int(_port)))

# clear screen here

print "Enter your user details"
_from = raw_input("User id: ")
_to = raw_input("Buddy id: ")

print '\n'
print "Connecting to server..."
print '\n'

# send user details and receive response
socketOut.sendall('@@@'+_from+'##'+_to)
response = socketOut.recv(8192)

def listener():
    while 1:
        time.sleep(5)
        socketOut.sendall('$$$'+_from)
        response = socketOut.recv(8192)
        if response != " ":
            print "\n" + response


if response == 'AUTH_OK':
    data = ""
    th = threading.Thread(target=listener)
    th.setDaemon(1)
    th.start()
    print "Background polling thread started"
    while 1:

        if msvcrt.kbhit():
            ch = msvcrt.getche()
        else:
            ch = None
        if ch:
            if ch != '\r':
                data += ch
            else:
                print '\n'
                socketOut.sendall('###'+_from+'##'+data)
                response = socketOut.recv(8192)
                if response != " ":
                    print response
                data = ""

else:
    print "Auhentication failed!"
        
socketOut.close()