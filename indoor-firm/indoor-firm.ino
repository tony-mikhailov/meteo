
/*  
   CONNECTIONS:
   - GND
   - Pin 2 to HC-05 TXD
   - Pin 3 to HC-05 RXD
   - 3.3v to HC-05 Vcc 
   - GND
 */

#include <SoftwareSerial.h>  

#define HC_05_TXD_ARDUINO_RXD 2
#define HC_05_RXD_ARDUINO_TXD 3

SoftwareSerial BTSerial(HC_05_TXD_ARDUINO_RXD, HC_05_RXD_ARDUINO_TXD);

void setup()
{

  Serial.begin(9600); 
  BTSerial.begin(38400);
}

void loop()
{
  int btIn = -1;
  if (BTSerial.available() && (btIn = BTSerial.read()) ) {
    Serial.write(btIn);
  }
}


