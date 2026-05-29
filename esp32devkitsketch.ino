#include <WiFi.h>
#include <HTTPClient.h>

// ==== WiFi Config ====
const char* ssid = "Free Wifi 4G";
const char* password = "swIX*kl-!cr53rEwudru";

// ==== ESP32-CAM IP ====
const String esp32cam_ip = "http://192.168.1.22";

// ==== Laser Sensor (Digital - LM393 Module) ====
#define LASER_SENSOR_PIN 34  // Digital input from LM393 module
bool lastState = true;       // true = beam intact (HIGH), false = broken (LOW)

// ==== Buzzer ====
#define BUZZER_PIN 13        // Digital output for buzzer
const unsigned long alarmDuration = 5000;  // 5 seconds

// ==== Trigger & Alarm Timing ====
unsigned long lastTriggerTime = 0;
const unsigned long triggerCooldown = 5000;  // 5 seconds debounce delay

unsigned long alarmStartTime = 0;
bool alarmActive = false;

void setup() {
  Serial.begin(115200);
  delay(500);
  Serial.println("Starting ESP32 Dev Kit...");

  // Wi-Fi connection
  WiFi.begin(ssid, password);
  Serial.print("Connecting to Wi-Fi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\n✅ Wi-Fi connected!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  // Buzzer setup
  pinMode(BUZZER_PIN, OUTPUT);
  digitalWrite(BUZZER_PIN, LOW);  // Ensure off

  // Laser sensor setup
  pinMode(LASER_SENSOR_PIN, INPUT);

  // Read initial sensor state
  int initialValue = digitalRead(LASER_SENSOR_PIN);
  lastState = (initialValue == HIGH);  // HIGH = beam intact
  Serial.printf("Initial sensor value: %d (state: %s)\n", initialValue, lastState ? "intact" : "broken");

  Serial.println("System ready. Monitoring laser beam...");
}

void loop() {
  // Handle WiFi connection
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("⚠️ WiFi disconnected, attempting reconnect...");
    WiFi.disconnect();
    WiFi.begin(ssid, password);
    delay(2000);
  }

  // Read laser sensor
  int sensorValue = digitalRead(LASER_SENSOR_PIN);
  bool currentState = (sensorValue == HIGH);  // HIGH = intact, LOW = broken

  // Print sensor state every second
  static unsigned long lastPrint = 0;
  if (millis() - lastPrint > 1000) {
    Serial.printf("Sensor value: %d (state: %s)\n", sensorValue, currentState ? "intact" : "broken");
    lastPrint = millis();
  }

  // Detect falling edge: intact -> broken
  if (!currentState && lastState) {
    unsigned long currentMillis = millis();
    if (currentMillis - lastTriggerTime > triggerCooldown) {
      Serial.println("🚨 Beam broken! Triggering alarm and camera...");
      triggerAlarmStart();
      triggerCamera();
      lastTriggerTime = currentMillis;
    }
  }
  lastState = currentState;

  // Handle buzzer (non-blocking)
  if (alarmActive && (millis() - alarmStartTime >= alarmDuration)) {
    digitalWrite(BUZZER_PIN, LOW);
    alarmActive = false;
    Serial.println("Buzzer alarm completed.");
  }

  delay(50);
}

void triggerAlarmStart() {
  digitalWrite(BUZZER_PIN, HIGH);
  alarmStartTime = millis();
  alarmActive = true;
}

void triggerCamera() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("⚠️ Wi-Fi disconnected when triggering camera, attempting reconnect...");
    WiFi.disconnect();
    WiFi.begin(ssid, password);
    delay(2000);
    if (WiFi.status() != WL_CONNECTED) {
      Serial.println("❌ WiFi reconnection failed, skipping camera trigger.");
      return;
    }
    Serial.println("✅ WiFi reconnected!");
  }

  HTTPClient http;
  String url = esp32cam_ip + "/capture";
  Serial.print("📡 Sending GET request to: ");
  Serial.println(url);

  int attempts = 3;
  int httpCode = -1;
  while (attempts > 0 && httpCode != 200) {
    http.begin(url);
    httpCode = http.GET();

    if (httpCode == 200) {
      String payload = http.getString();
      Serial.println("✅ Camera triggered successfully! Response: " + payload);
      http.end();
      break;
    } else {
      Serial.printf("❌ Attempt failed (code: %d), retries left: %d\n", httpCode, attempts - 1);
      http.end();
      attempts--;
      delay(1000);
    }
  }
  if (httpCode != 200) {
    Serial.println("❌ All camera trigger attempts failed.");
  }
}