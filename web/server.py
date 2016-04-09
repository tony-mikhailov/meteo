import tornado.httpserver
import tornado.ioloop
import tornado.web
import tornado.websocket
import tornado.gen
from tornado.options import define, options
import os
import time
import multiprocessing
import serialworker
import json
 
define("port", default=8080, help="run on the given port", type=int)
 
clients = [] 

input_queue = multiprocessing.Queue()
output_queue = multiprocessing.Queue()

class MyStaticFileHandler(tornado.web.StaticFileHandler):
    def set_extra_headers(self, path):
        self.set_header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        
class IndexHandler(tornado.web.RequestHandler):
    def get(self):
        self.set_header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        self.render('index.html')
 
class WebSocketHandler(tornado.websocket.WebSocketHandler):
    def open(self):
        print 'new connection'
        clients.append(self)
        self.write_message("connected")
 
    def on_message(self, message):
        print 'tornado received from client: %s' % json.dumps(message)
        print '^ ignored'
        #self.write_message('ack')
        #input_queue.put(message)
 
    def on_close(self):
        print 'connection closed'
        clients.remove(self)

def checkQueue():
	if not output_queue.empty():
		message = output_queue.get()
                msg = message[1:-2]
                print msg
                T = -1.0
                H  = -1.0
                P = -1.0
                windSpeed = -1.0
                windDir = -1.0
                try:
                    windSpeed = msg.split(' ')[3]
                    rps = msg.split(' ')[5]
                    a0 = msg.split(' ')[11]
                    a0f = float(a0)
                    windDir = 1.5 + (358.5 - 1.5)  * (a0f - 500.0) / (1012.0 - 500.0);
                    P = msg.split(' ')[13]
                    H = msg.split(' ')[15]
                    T = msg.split(' ')[17]
                finally:
                    print "outTemp=" + str(T)
                    print "barometer=" + str(P)
                    print "outHumidity=" + str(H)
                    print "windSpeed=" + str(windSpeed)
                    print "windDir=" + str(windDir)
                    f = open('datafile', 'w')
                    f.write("outTemp=" + str(T) + '\n')
                    f.write("barometer=" + str(P) + '\n')
                    f.write("outHumidity=" + str(H) + '\n')
                    f.write("windSpeed=" + str(windSpeed) + '\n')
                    f.write("windDir=" + str(windDir) + '\n')
 
		for c in clients:
			c.write_message(message)

if __name__ == '__main__':
	sp = serialworker.SerialProcess(input_queue, output_queue)
	sp.daemon = True
	sp.start()
	tornado.options.parse_command_line()
	app = tornado.web.Application(
	    handlers=[
                (r"/", IndexHandler),
                (r"/ws", WebSocketHandler),
                (r"/(.*)", MyStaticFileHandler, {'path':  '/home/pi/wrk/meteo/web/'})
#	        (r"/", IndexHandler),
#            (r"/ws", WebSocketHandler),
#	        (r"/img/(.*)", MyStaticFileHandler, {'path':  '../img/'}),
#	        (r"/(.*)", MyStaticFileHandler, {'path':  './'})
	    ]
	)
	httpServer = tornado.httpserver.HTTPServer(app)
	httpServer.listen(options.port)
	print "Listening on port:", options.port

	mainLoop = tornado.ioloop.IOLoop.instance()

	scheduler_interval = 1000
	scheduler = tornado.ioloop.PeriodicCallback(checkQueue, scheduler_interval, io_loop = mainLoop)
	scheduler.start()
	mainLoop.start()
