#include <LiquidCrystal.h>


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

LiquidCrystal lcd(8, 9, 4, 5, 6, 7); 


void setup()
{
  Serial.begin(9600); 
  BTSerial.begin(38400);
  lcd.begin(16, 2);     
  lcd.print("Yarrr!!!");
}

#define IN_MAX 100

char inMsg[IN_MAX];
int msgPos = -1;

enum Phase {
  resetMsg = -1,
  waitMsg = 0,
  appendMsg = 1,
  msgDone = 2
  
} parsePhase = resetMsg;


void processMsg(char* msg)
{
    Serial.println(msg); // send to Serial to process by web server
    //parse and show telemetry data
    lcd.print(msg);
    
}

void loop()
{
  if (Phase::resetMsg == parsePhase) {
    memset(inMsg, '\0', IN_MAX);
    parsePhase = Phase::waitMsg;
  }
  char btIn = -1;
  if (BTSerial.available() && (btIn = BTSerial.read()) ) {
//    Serial.write(btIn);

    if (Phase::waitMsg == parsePhase) {
      if ('(' == btIn) {
        parsePhase = Phase::appendMsg;
        msgPos = 0;
      }
    }

    if (msgPos >= 0 && (Phase::appendMsg == parsePhase)) {
        inMsg[msgPos] = btIn;
        msgPos++;
        if (msgPos >= IN_MAX) {
           parsePhase = Phase::resetMsg;
        }
        if (('(' == btIn) && (msgPos > 1)) {
           parsePhase = Phase::resetMsg;
        }
    }

    if (Phase::appendMsg == parsePhase) {
      if (')' == btIn) {
        parsePhase = Phase::msgDone;
      }
    }

    if (Phase::msgDone == parsePhase) {
        processMsg(inMsg);     
        parsePhase = Phase::resetMsg;
    }
  }
}


