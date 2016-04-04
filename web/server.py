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
	    ]
	)
	httpServer = tornado.httpserver.HTTPServer(app)
	httpServer.listen(options.port)
	print "Listening on port:", options.port

	mainLoop = tornado.ioloop.IOLoop.instance()

	scheduler_interval = 100
	scheduler = tornado.ioloop.PeriodicCallback(checkQueue, scheduler_interval, io_loop = mainLoop)
	scheduler.start()
	mainLoop.start()
