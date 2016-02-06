import serial
import time
import multiprocessing

## Change this to match your local settings
SERIAL_BAUDRATE = 9600
#SERIAL_PORT = '/dev/tty.usbmodem1411'
SERIAL_PORT = '/dev/ttyACM0'

class SerialProcess(multiprocessing.Process):
 
    def __init__(self, input_queue, output_queue):
        multiprocessing.Process.__init__(self)
        self.input_queue = input_queue
        self.output_queue = output_queue
        try:
            self.sp = serial.Serial(SERIAL_PORT, SERIAL_BAUDRATE, timeout=1)
            self.sp.flushInput()
            print "connected to " + SERIAL_PORT        
        except:
            print "couldn`t conect to " + SERIAL_PORT        
 
    def close(self):
        self.sp.close()
 
    def writeSerial(self, data):
        self.sp.write(data)
        # time.sleep(1)
        
    def readSerial(self):
        return self.sp.readline().replace("\n", "")
 
    def run(self):
        self.output_queue.put("()");
        while True:
            if not self.input_queue.empty():
                data = self.input_queue.get()
                #do nothing for sec reasons
                #self.writeSerial(data)
 
            try:
                if (self.sp.inWaiting() > 0):
                    data = self.readSerial()
                    self.output_queue.put(data)
            except:
                self.output_queue.put("()");
                try:
                    self.sp = serial.Serial(SERIAL_PORT, SERIAL_BAUDRATE, timeout=1)
                    self.sp.flushInput()
                    print "connected to " + SERIAL_PORT        
                except:
                    print "couldn`t conect to " + SERIAL_PORT        
                    time.sleep(1)
