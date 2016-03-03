#include <SoftwareSerial.h>  

#include <SFE_BMP180.h>
#include <DHT.h>
#include <OneWire.h>
#include <DallasTemperature.h>

#define HC_05_TXD_ARDUINO_RXD 11
#define HC_05_RXD_ARDUINO_TXD 12

#define HC_05_SETUPKEY        4
#define HC_05_PWR1            5  
#define HC_05_PWR2            6

#define DHT_PIN 7
#define ONE_WIRE_BUS 9
#define COUNTER_PIN 2

#define LOOP_TIME                 1000 // msec

#define bt_echo_send(x) Serial.print(x); BTSerial.print(x);
#define fbt_echo_send(x) bt_echo_send(#x); bt_echo_send(" "); bt_echo_send(x); bt_echo_send(" ");

#define msg(x) Serial.println(x)

SoftwareSerial BTSerial(HC_05_TXD_ARDUINO_RXD, HC_05_RXD_ARDUINO_TXD); // RX | TX
DHT dht(DHT_PIN, DHT22);
OneWire oneWire(ONE_WIRE_BUS);
DallasTemperature sensors(&oneWire);
SFE_BMP180 pressure;

volatile long int counter = 0;

void pin2int() {
  counter++;
}

void setup() 
{

  pinMode(HC_05_SETUPKEY, OUTPUT);  
  pinMode(HC_05_PWR1, OUTPUT);      // Connect in parallel to HC-05 VCC
  pinMode(HC_05_PWR2, OUTPUT);      // Connect in parallel to HC-05 VCC


attachInterrupt(digitalPinToInterrupt(COUNTER_PIN), pin2int, FALLING);

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

long int msg = 0;
int a0 = 0;           
int a1 = 0;           
int a2 = 0;           
int a3 = 0;
int d10 = 0;           
int d8 = 0;
           
float H = -1.0;

void loop()
{
  unsigned long StartTime = millis();
  
  a0 = analogRead(A0);
  a1 = analogRead(A1);
  a2 = analogRead(A2);
  a3 = analogRead(A3);

  d10 = digitalRead(10);
  d8 = digitalRead(8);

  float H = dht.readHumidity();
  float Th = dht.readTemperature();

  double P = -1.0;
  double Tp = -1.0;
  getPT(P, Tp);

  float T0 = -1.0;
  float T1 = -1.0;
  
  
  sensors.requestTemperatures();
  T0 = sensors.getTempCByIndex(0);
  T1 = sensors.getTempCByIndex(1);
  

  bt_echo_send("(")
  fbt_echo_send(msg); 
  fbt_echo_send(a0); 
  fbt_echo_send(a1); 
  fbt_echo_send(d8);
  fbt_echo_send(d10);
  fbt_echo_send(P);
  fbt_echo_send(H);
  fbt_echo_send(Th);
  fbt_echo_send(Tp);
  fbt_echo_send(T0);
  fbt_echo_send(T1);
  fbt_echo_send(counter);
  
  bt_echo_send(")");

  bt_echo_send("\r\n");
  
  unsigned long CurrentTime = millis();
  unsigned long ElapsedTime = CurrentTime - StartTime;
  unsigned long dt = ElapsedTime > LOOP_TIME ? 0 : LOOP_TIME - ElapsedTime;
  delay(dt);

  msg++;
}


