// library wifi
#include <ESP8266HTTPClient.h>;
#include <ESP8266WiFi.h>;

// library servo
#include <Servo.h>

//wifi dan password
const char* ssid = "Data_Soft";
const char* password = "";

//koneksi web server
const char* host = "canora.site";

//inisialisasi pin 
#define pin_relay 5
#define pin_servo 4

Servo myservo;

void setup() {
  Serial.begin(9600);  
  pinMode(LED_BUILTIN, OUTPUT);

  //koneksi ke wifi
  WiFi.hostname("NodeMCU");
  WiFi.begin(ssid, password);
  while(WiFi.status() != WL_CONNECTED)
  {
    Serial.print(".");
    delay(500);
  }
  Serial.println("berhasil koneksi");
  Serial.print("IP address :");
  Serial.println(WiFi.localIP());

  //set pin output
  pinMode(pin_relay,OUTPUT);
  myservo.attach(pin_servo);
}

// the loop function runs over and over again forever
void loop() {
  WiFiClient client ;
  const int httpPort = 2083;

  if (!client.connect(host, httpPort))
  {
    Serial.println("gagal koneksi ke server");
    return;
  }

 Serial.println("berhasil koneksi ke server");

  // baca data relay
  HTTPClient relay;
  String linkrelay = "http://" +String(host)+ "/IOT/bacadata.php?trol=relay";
  relay.begin(client,linkrelay);
  relay.GET();
  String responrelay = relay.getString();
  Serial.println(responrelay);
  relay.end();

  digitalWrite(pin_relay, responrelay.toInt());

  // baca data servo
  HTTPClient servo;
  String linkservo = "http://" +String(host)+ "/IOT/bacadata.php?trol=servo";
  servo.begin(client,linkservo);
  servo.GET();
  String responservo = servo.getString();
  Serial.println(responservo);
  servo.end();

  myservo.write(responservo.toInt());
  
  digitalWrite(LED_BUILTIN, LOW);  // Turn the LED on (Note that LOW is the voltage level
  // but actually the LED is on; this is because
  // it is active low on the ESP-01)
  delay(500);                      // Wait for a second
  digitalWrite(LED_BUILTIN, HIGH);  // Turn the LED off by making the voltage HIGH
  delay(500);                      // Wait for two seconds (to demonstrate the active low LED)
}
