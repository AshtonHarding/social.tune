#! /bin/bash


## The IM Server.
####
## Taken from some guy. Will modify in the future.

import SocketServer

_port = 8881
_clients = {}


# a connected client
class Client:
    # queue of messages sent to this client
    queue = []
    def __init__(self, _sock, _src, _dest):
        print "Creating IM client"
        self.socket = _sock
        print "Incoming socket: %s" % self.socket
        self.user = _src
        print "Username: " + self.user
        # buddies should be a list
        self.buddy = _dest
        print "Buddy: " + self.buddy
        print "Created IM client"

# the server handling requests
class Broker(SocketServer.BaseRequestHandler):
    def handle(self):
        print "Connected from", self.client_address
        while True:
            receivedData = self.request.recv(8192)
            if not receivedData:
                break
            
            # if handshake packet, extract client details
            if receivedData.startswith('@@@',0,3):
                print "Received handshake packet"
                # strip handshake code
                receivedData = receivedData.replace('@@@', '', 1).lstrip()
                l = receivedData.split('##',1)
                socket = self.request
                src = l[0]
                dest = l[1]
                c = Client(socket, src, dest)
                # use username as key on hashmap
                _clients[src] = c
                # send success message
                socket.sendall('AUTH_OK')
                print "Client " + src + " authenticated"

            # if polling packet, extract sender details and send messages
            if receivedData.startswith('$$$',0,3):
                # strip polling message
                print "Received polling packet"
                src = receivedData.replace('$$$', '', 1).lstrip()
                # only poll if more than 1 user
                if len(_clients) > 1:                
                    # use username as key on hashmap
                    _clients[src] = c
                    if len(c.queue) < 1:
                        c.socket.sendall(" ")
                    else:
                        msgs = ""
                        for q in c.queue:
                            msgs += q + '\n'
                            # send queued messages
                        c.socket.sendall(msgs)
                        c.queue = []
                        print "Sent all pending messages for " + c.user
                else:
                    socket.sendall(" ")

            # if message packet, extract data and append to target queue
            if receivedData.startswith('###',0,3):
                print "Received message packet"
                receivedData = receivedData.replace('###', '', 1).lstrip()
                l = receivedData.split('##',1)
                src = l[0]
                text = l[1]
                if text.strip != "":
                    print "Message not empty"
                    # extract client
                    clientSrc = _clients[src]
                    # ...and its buddy
                    clientDest = _clients[clientSrc.buddy]
                    msg = src+": "+text
                    print "Appended message to queue of " + clientSrc.buddy
                    clientDest.queue.append(msg)
                    print "Queue of: " + clientDest.user + " = %s" % clientDest.queue
                clientDest.socket.sendall(" ")
            else:
                if len(_clients) < 2:
                    self.request.sendall(receivedData)

        for c in _clients.values():
            if self.request == c.socket:
                c.socket.close()
                # remove from hashmap
                del _clients[c.user]
                print "Removed " + c.user + " from hashmap"

        print "Disconnected from", self.client_address
        
srv = SocketServer.ThreadingTCPServer(('',_port),Broker)
print "Started IIM server on port %d" % _port
srv.serve_forever()