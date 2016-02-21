#include <SoftwareSerial.h>  

#include <SFE_BMP180.h>
#include <DHT.h>
#include <OneWire.h>
#include <DallasTemperature.h>

#define HC_05_TXD_ARDUINO_RXD 2
#define HC_05_RXD_ARDUINO_TXD 3
#define HC_05_SETUPKEY        4
#define HC_05_PWR1            5  
#define HC_05_PWR2            6

#define DHT_PIN 7
#define ONE_WIRE_BUS 9

#define LOOP_TIME                 1000 // msec

#define msg(x) Serial.println(x)

SoftwareSerial BTSerial(HC_05_TXD_ARDUINO_RXD, HC_05_RXD_ARDUINO_TXD); // RX | TX
DHT dht(DHT_PIN, DHT22);
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);
SFE_BMP180 pressure;

void setup() 
{

  pinMode(HC_05_SETUPKEY, OUTPUT);  
  pinMode(HC_05_PWR1, OUTPUT);      // Connect in parallel to HC-05 VCC
  pinMode(HC_05_PWR2, OUTPUT);      // Connect in parallel to HC-05 VCC

  pinMode(10, INPUT);
  pinMode(8, INPUT);


  digitalWrite(HC_05_SETUPKEY, LOW);

  //delay(CMD_W);       
  digitalWrite(HC_05_PWR1, HIGH);
  digitalWrite(HC_05_PWR2, HIGH);  
  //delay(CMD_W);
                
  Serial.begin(9600);   // For the Arduino IDE Serial Monitor
  BTSerial.begin(38400);  // HC-05 default speed in AT command mode

  if (pressure.begin())
    Serial.println("BMP180 init success");
  else
    Serial.println("BMP180 init failed!!!");

  sensors.begin();
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
double H = -0.0;

#define bt_echo_send(x) Serial.print(x); BTSerial.print(x);
#define fbt_echo_send(x) bt_echo_send(#x); bt_echo_send(" "); bt_echo_send(x); bt_echo_send(" ");


int getPT(double &P, double &T) {
  char status = pressure.startTemperature();
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
          return 0;
        } else { T = -1.0; P = -1.0; }
      } else { T = -1.0; P = -1.0; }
    } else { T = -1.0; P = -1.0; }
  } else { T = -1.0; P = -1.0; }
  return -1;
}

void loop()
{
  unsigned long StartTime = millis();
  
  v0 = analogRead(A0);
  v1 = analogRead(A1);
  v2 = analogRead(A2);
  v3 = analogRead(A3);

  d10 = digitalRead(10);
  d8 = digitalRead(8);

  float h = dht.readHumidity();
  float t = dht.readTemperature();

  getPT(P, T);
  
  sensors.requestTemperatures();
  float tX = sensors.getTempCByIndex(0);

  unsigned long CurrentTime = millis();
  unsigned long ElapsedTime = CurrentTime - StartTime;
  unsigned long dt = ElapsedTime > LOOP_TIME ? 0 : LOOP_TIME - ElapsedTime;

  bt_echo_send("(")
  fbt_echo_send(cnt); 
  fbt_echo_send(v0); 
  fbt_echo_send(tX);
  fbt_echo_send(t);
  fbt_echo_send(v1); 
  fbt_echo_send(d8);
  fbt_echo_send(d10);
  fbt_echo_send(T);
  fbt_echo_send(P);
  fbt_echo_send(h);
  fbt_echo_send(dt);
  bt_echo_send(")");

  bt_echo_send("\r\n");
  
  delay(dt);

  cnt++;
}


