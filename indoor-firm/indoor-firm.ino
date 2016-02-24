

/*  
   CONNECTIONS:
   - GND
   - Pin 2 to HC-05 TXD
   - Pin 3 to HC-05 RXD
   - 3.3v to HC-05 Vcc 
   - GND
 */

#include <LiquidCrystal.h>

#include <SoftwareSerial.h>  

#define HC_05_TXD_ARDUINO_RXD 2
#define HC_05_RXD_ARDUINO_TXD 3

SoftwareSerial BTSerial(HC_05_TXD_ARDUINO_RXD, HC_05_RXD_ARDUINO_TXD);

LiquidCrystal lcd(8, 9, 4, 5, 6, 7); 

uint8_t dotdotdot[8] = {B0, B00000, B0, B0, B0, B0, B10101};

uint8_t ru_D[8] = {
  B01111, 
  B00101, 
  B00101, 
  B01001, 
  B10001, 
  B11111, 
  B10001,
  B00000,
};

uint8_t ru_O_hi_cap[8] = {
  B01100, 
  B10010, 
  B10010, 
  B01100, 
  B00000, 
  B00000, 
  B00000,
  B00000,
};


uint8_t ru_M_sm_cap[8] = {
  B00000, 
  B00000, 
  B01010, 
  B10101, 
  B10101, 
  B10101,
  B10101,
  B00000, 
};

uint8_t ru_P_sm_cap[8] = {
  B00000, 
  B00000, 
  B11100, 
  B10010, 
  B11100, 
  B10000,
  B10000,
  B00000, 
};

uint8_t ru_S_sm_cap[8] = {
  B00000, 
  B00000, 
  B01100, 
  B10010, 
  B10000, 
  B10010,
  B01100,
  B00000, 
};


uint8_t ru_T_sm_cap[8] = {
  B00000, 
  B00000, 
  B01110, 
  B00100, 
  B00100, 
  B00100,
  B00100,
  B00000, 
};

uint8_t ru_U[8] = {
  B10010, 
  B10101, 
  B10101, 
  B11101, 
  B10101, 
  B10101, 
  B10010,
  B00000,
};

uint8_t ru_Z[8] = {
  B00110, 
  B01001, 
  B00001, 
  B00110, 
  B00001, 
  B01001, 
  B00110,
  B00000,
};

void setup()
{
  Serial.begin(9600); 
  BTSerial.begin(38400);

  lcd.createChar(0, ru_D);
  lcd.createChar(1, ru_O_hi_cap);
  lcd.createChar(2, ru_M_sm_cap);
  lcd.createChar(3, ru_P_sm_cap);
  lcd.createChar(4, ru_S_sm_cap);
  lcd.createChar(5, ru_T_sm_cap);
  lcd.createChar(6, ru_U);
  lcd.createChar(7, ru_Z);
  
  lcd.begin(16, 2);     
  lcd.setCursor(0, 0);
  
  lcd.write("Wait for data...");
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


String fget(String msg, char* f)
{
    String s = msg;
    char* p = strstr(s.c_str(), f);
    if (p) {
      String cs(p);
      String val = cs.substring(cs.indexOf(' ') + 1, cs.indexOf(' ', cs.indexOf(' ') + 1));
      return val;
    }
    return String();
}

float s_round(String inStr, float &f) {
//  f = s.toFloat();
}

void processMsg(char* msg)
{
    Serial.println(msg); // send to Serial to process by web server
    //parse and show telemetry data

    String s(msg);

   //String val = fget(s, "msg");
    //lcd.setCursor(0,0);
    //lcd.print(val);

    String sTp = fget(s, "Tp");
    String sP = fget(s, "P");
    String sH = fget(s, "H");
    
    lcd.setCursor(0, 0);
    lcd.print("T:");

    lcd.print(sTp.toInt());
    lcd.write(1);    
    
    
    lcd.print(" "); lcd.write((uint8_t)0); lcd.print(":");
    String pTorr(sP.toFloat() * 0.7501);
    lcd.print(pTorr.toInt());
    lcd.write(2);    
    lcd.write(2);    
    lcd.write(3);    
    lcd.write(4);    
    lcd.write(5);    

    lcd.setCursor(0,1);
    lcd.print("O:");
    lcd.print(sH.toInt());
    lcd.print("% B:5.5 ");
    lcd.write(6);    
    lcd.write(6);    
    lcd.write(7);    

}

volatile unsigned int err_cnt = 0;

void loop()
{
  if (Phase::resetMsg == parsePhase) {
    memset(inMsg, '\0', IN_MAX);
    parsePhase = Phase::waitMsg;
  }
  signed char btIn = -1;
  if (BTSerial.available() && (btIn = BTSerial.read()) ) {
//    Serial.write(btIn);
    err_cnt = 0;
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
  } else {
    err_cnt++;/*
    if (err_cnt > 7000) {
      Serial.println("(outdoor-fail)");
      lcd.setCursor(0, 0);
//      lcd.write("errcnt");    
      lcd.print("No out-door ... ");
      lcd.setCursor(0, 1);
      lcd.print(err_cnt);
      //lcd.print(" ");

    }  
    */
  }
  
  if (err_cnt > 50000) {
      Serial.println("(outdoor-fail)");
      lcd.setCursor(0, 0);
      lcd.print("AHTUNG !!!      ");
      lcd.setCursor(0, 1);
      lcd.print("No out-door ... ");
      delay(1000);
  }
  
}

 
