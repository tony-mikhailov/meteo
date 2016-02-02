
/*  
   CONNECTIONS:
   - GND
   - Pin 2 to HC-05 TXD
   - Pin 3 to HC-05 RXD
   - Pin 4 to HC-05 KEY
   - Pin 5+6 to HC-05 VCC for power control
 */

#include <SoftwareSerial.h>  
#include <SFE_BMP180.h>

#define HC_05_TXD_ARDUINO_RXD 2
#define HC_05_RXD_ARDUINO_TXD 3
#define HC_05_SETUPKEY        4
#define HC_05_PWR1            5  // Connect in parallel to HC-05 VCC
#define HC_05_PWR2            6  // Connect in parallel to HC-05 VCC
#define CMD_W                 1100 // msec

#define msg(x) Serial.println(x)

const int board = 0; // 0 -- for outdoor, 1 -- indor module

SoftwareSerial BTSerial(HC_05_TXD_ARDUINO_RXD, HC_05_RXD_ARDUINO_TXD); // RX | TX

enum BTDeviceState {
  error = -2,
  off = -1,
  data = 0,
  at = 1,
};

class BTDevice 
{
private:
  BTDeviceState m_state;
  
public:
  BTDevice(): m_state(off) {  };

  void setState(BTDeviceState state) {
    if (m_state == state) {
      msg("try to set BT to the same state " + state);
      
      return;
    }
    switch (state) {
      case off: {
        
        msg("Power off");
        digitalWrite(HC_05_PWR1, LOW);
        digitalWrite(HC_05_PWR2, LOW);  
        delay(CMD_W);
        m_state = off;
        return;        
      }
      case data: {
        if (m_state == off) {
          digitalWrite(HC_05_SETUPKEY, LOW);  // Set command mode when powering up
          delay(CMD_W);       
          digitalWrite(HC_05_PWR1, HIGH);
          digitalWrite(HC_05_PWR2, HIGH);  
          delay(CMD_W);
                    
          m_state = data;
          return;        
        }
      }
      case at: {
        if (m_state == off) {
          digitalWrite(HC_05_SETUPKEY, HIGH);  // Set command mode when powering up
          delay(CMD_W);       
          digitalWrite(HC_05_PWR1, HIGH);
          digitalWrite(HC_05_PWR2, HIGH);  
          delay(CMD_W);        

          m_state = at;
          return;
        }
        
      }
      
    }
  };

  BTDeviceState state() {return m_state;};
  
};

/*
void BTDevice::initPins() {
  pinMode(HC_05_SETUPKEY, OUTPUT);  // this pin will pull the HC-05 pin 34 (key pin) HIGH to switch module to AT mode
  pinMode(HC_05_PWR1, OUTPUT);      // Connect in parallel to HC-05 VCC
  pinMode(HC_05_PWR2, OUTPUT);      // Connect in parallel to HC-05 VCC
};
*/

BTDevice *bt = new BTDevice();

SFE_BMP180 pressure;

void setup()   /****** SETUP: RUNS ONCE ******/
{

  pinMode(HC_05_SETUPKEY, OUTPUT);  // this pin will pull the HC-05 pin 34 (key pin) HIGH to switch module to AT mode
  pinMode(HC_05_PWR1, OUTPUT);      // Connect in parallel to HC-05 VCC
  pinMode(HC_05_PWR2, OUTPUT);      // Connect in parallel to HC-05 VCC

  pinMode(10, INPUT);
  pinMode(8, INPUT);
  
//  digitalWrite(HC_05_SETUPKEY, HIGH);  // Set command mode when powering up
  
  Serial.begin(9600);   // For the Arduino IDE Serial Monitor
  BTSerial.begin(38400);  // HC-05 default speed in AT command mode

  bt->setState(data);

  if (pressure.begin())
    Serial.println("BMP180 init success");
  else
    Serial.println("BMP180 init failed!!!");

/*
  msg("Pwr on");
  delay(2000);
  
  msg("Applying VCC Power. LED should blink SLOWLY: 2 Seconds ON/OFF");
  
  digitalWrite(HC_05_PWR1, HIGH); // Power VCC
  digitalWrite(HC_05_PWR2, HIGH);  
  
  delay(2000);

  Serial.println("Enter AT commands in top window.");
  BTSerial.begin(38400);  // HC-05 default speed in AT command mode
*/

}

int cnt = 0;

const int aInPin = A0;
int analogPin = 3;
     
int v0 = 0;           
int v1 = 0;           
int v2 = 0;           
int v3 = 0;
int d10 = 0;           
int d8 = 0;           
double T = -10.0;
double P = -10.0;

#define bt_echo_send(x) Serial.print(x); BTSerial.print(x);
#define fbt_echo_send(x) bt_echo_send(x); bt_echo_send(" ");

void loop()
{
  int btIn = -1;

  if (BTSerial.available() && (btIn = BTSerial.read()) ) {
    Serial.write(btIn);
  }

  if (Serial.available()) {
    char inChar = (char)Serial.read();

    if (inChar == '*') {
      bt->setState(off);
      bt->setState(data);
    }
    if (inChar == '?') {
      bt->setState(off);
      bt->setState(at);
    }
    
    String fromSerialStr = String(inChar);
    
    BTSerial.write(fromSerialStr.c_str());
    Serial.write(fromSerialStr.c_str());
    //BTSerial.print(fromSerialStr);
    //Serial.print(fromSerialStr);
  }


  v0 = analogRead(A0);
  v1 = analogRead(A1);
  v2 = analogRead(A2);
  v3 = analogRead(A3);

  d10 = digitalRead(10);
  d8 = digitalRead(8);

  char status;

  if (board == 0) {

  
    // abirvalg!!!
    status = pressure.startTemperature();
    if (status != 0)  {
      delay(status);
      status = pressure.getTemperature(T);
      //Serial.println(T);
      if (status != 0) {
        status = pressure.startPressure(3);
        if (status != 0) {
          delay(status);
    
          status = pressure.getPressure(P,T);
          if (status != 0) {
    
          } else { T = -1.0; P = -1.0; }
        } else { T = -1.0; P = -1.0; }
      } else { T = -1.0; P = -1.0; }
    } else { T = -1.0; P = -1.0; }

    bt_echo_send("(")
    fbt_echo_send(cnt); 
    fbt_echo_send(v0); 
    fbt_echo_send(-1);
    fbt_echo_send(-1);
    fbt_echo_send(v1); 
    fbt_echo_send(d8);
    fbt_echo_send(d10);
    fbt_echo_send(T);
    fbt_echo_send(P);
    bt_echo_send(")")

    bt_echo_send("\r\n")
        
    delay(100);
  }
  cnt++;
}


