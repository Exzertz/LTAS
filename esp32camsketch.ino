#include "esp_camera.h"
#include <WiFi.h>
#include <HTTPClient.h>
#include <time.h> // For NTP time sync

// ==== AI Thinker ESP32-CAM PIN Definitions ====
#define PWDN_GPIO_NUM     32
#define RESET_GPIO_NUM    -1
#define XCLK_GPIO_NUM      0
#define SIOD_GPIO_NUM     26
#define SIOC_GPIO_NUM     27
#define Y9_GPIO_NUM       35
#define Y8_GPIO_NUM       34
#define Y7_GPIO_NUM       39
#define Y6_GPIO_NUM       36
#define Y5_GPIO_NUM       21
#define Y4_GPIO_NUM       19
#define Y3_GPIO_NUM       18
#define Y2_GPIO_NUM        5
#define VSYNC_GPIO_NUM    25
#define HREF_GPIO_NUM     23
#define PCLK_GPIO_NUM     22

// ==== WIFI CREDENTIALS ====
const char* ssid = "Free Wifi 4G";
const char* password = "swIX*kl-!cr53rEwudru";

// ==== SERVER / PHP UPLOAD URL ====
const char* serverUrl = "http://192.168.1.17/ltaw_final/process/upload.php";

// Device Identifier
const char* device_id = "BC42A61F8A3C";

// HTTP server for listening to capture commands on ESP32CAM
WiFiServer httpServer(80);

// NTP time
const char* ntpServer = "pool.ntp.org";
const long gmtOffset_sec = 0;  // Adjust for your timezone if needed
const int daylightOffset_sec = 0;

// WiFi reconnect function with debug
void reconnectWiFi() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("WiFi lost connection. Reconnecting...");
    WiFi.disconnect();
    WiFi.begin(ssid, password);
    unsigned long startAttemptTime = millis();

    // Wait up to 10 seconds for connection
    while (WiFi.status() != WL_CONNECTED && millis() - startAttemptTime < 10000) {
      delay(500);
      Serial.print(".");
    }
    Serial.println();
    if (WiFi.status() == WL_CONNECTED) {
      Serial.println("WiFi reconnected.");
      Serial.print("IP Address: ");
      Serial.println(WiFi.localIP());
    } else {
      Serial.println("Failed to reconnect to WiFi.");
    }
  }
}

String getFormattedTime() {
  time_t now = time(nullptr);
  struct tm *timeinfo = localtime(&now);
  char buf[20];
  sprintf(buf, "%04d-%02d-%02d %02d:%02d:%02d",
          timeinfo->tm_year + 1900,
          timeinfo->tm_mon + 1,
          timeinfo->tm_mday,
          timeinfo->tm_hour,
          timeinfo->tm_min,
          timeinfo->tm_sec);
  return String(buf);
}

void startCamera() {
  camera_config_t config = {0};
  config.ledc_channel = LEDC_CHANNEL_0;
  config.ledc_timer = LEDC_TIMER_0;
  config.pin_d0 = Y2_GPIO_NUM;
  config.pin_d1 = Y3_GPIO_NUM;
  config.pin_d2 = Y4_GPIO_NUM;
  config.pin_d3 = Y5_GPIO_NUM;
  config.pin_d4 = Y6_GPIO_NUM;
  config.pin_d5 = Y7_GPIO_NUM;
  config.pin_d6 = Y8_GPIO_NUM;
  config.pin_d7 = Y9_GPIO_NUM;
  config.pin_xclk = XCLK_GPIO_NUM;
  config.pin_pclk = PCLK_GPIO_NUM;
  config.pin_vsync = VSYNC_GPIO_NUM;
  config.pin_href = HREF_GPIO_NUM;
  config.pin_sscb_sda = SIOD_GPIO_NUM;
  config.pin_sscb_scl = SIOC_GPIO_NUM;
  config.pin_pwdn = PWDN_GPIO_NUM;
  config.pin_reset = RESET_GPIO_NUM;
  config.xclk_freq_hz = 20000000;
  config.pixel_format = PIXFORMAT_JPEG;
  config.frame_size = FRAMESIZE_VGA;
  config.jpeg_quality = 12;
  config.fb_count = 1;

  esp_err_t err = esp_camera_init(&config);
  if (err != ESP_OK) {
    Serial.printf("Camera init failed with error 0x%x\n", err);
  } else {
    Serial.println("Camera initialized");
  }
}

// Optional function to test if server is reachable
bool testServerConnection() {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("WiFi not connected");
    return false;
  }

  HTTPClient http;
  if (!http.begin(serverUrl)) {
    Serial.println("HTTPClient begin failed");
    http.end();
    return false;
  }
  int httpCode = http.GET();
  Serial.printf("Server test HTTP code: %d\n", httpCode);
  http.end();

  return (httpCode == 200 || httpCode == 404);
}

// Sends photo to server via binary-safe multipart HTTP POST
void sendPhoto(camera_fb_t* fb) {
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("Cannot upload photo: WiFi not connected");
    return;
  }

  if (!testServerConnection()) {
    Serial.println("Server unreachable, skipping upload.");
    return;
  }

  HTTPClient http;

  Serial.print("Starting HTTP POST to: ");
  Serial.println(serverUrl);

  if (!http.begin(serverUrl)) {
    Serial.println("HTTP begin() failed");
    http.end();
    return;
  }

  String boundary = "----ESP32Boundary";
  String contentType = "multipart/form-data; boundary=" + boundary;
  http.addHeader("Content-Type", contentType);

  WiFiClient *stream = http.getStreamPtr();
  if (!stream) {
    Serial.println("Failed to get stream pointer");
    http.end();
    return;
  }

  String formDataStart =
    "--" + boundary + "\r\n"
    "Content-Disposition: form-data; name=\"device_id\"\r\n\r\n" + device_id + "\r\n"
    "--" + boundary + "\r\n"
    "Content-Disposition: form-data; name=\"event_time\"\r\n\r\n" + getFormattedTime() + "\r\n"
    "--" + boundary + "\r\n"
    "Content-Disposition: form-data; name=\"captured_image\"; filename=\"photo.jpg\"\r\n"
    "Content-Type: image/jpeg\r\n\r\n";

  if (!stream->print(formDataStart)) {
    Serial.println("Failed to send form headers");
    http.end();
    return;
  }

  size_t sent = stream->write(fb->buf, fb->len);
  if (sent != fb->len) {
    Serial.printf("Failed to send image data. Sent %d of %d bytes\n", sent, fb->len);
    http.end();
    return;
  }

  String formDataEnd = "\r\n--" + boundary + "--\r\n";
  if (!stream->print(formDataEnd)) {
    Serial.println("Failed to send form ending");
    http.end();
    return;
  }

  int httpResponseCode = http.sendRequest("POST");

  Serial.printf("HTTP Response code: %d\n", httpResponseCode);
  if (httpResponseCode == HTTP_CODE_OK) {
    String response = http.getString();
    Serial.println("Upload success. Server response:");
    Serial.println(response);
  } else {
    Serial.printf("Upload failed with HTTP code: %d\n", httpResponseCode);
  }

  http.end();
}

void setup() {
  Serial.begin(115200);
  delay(1000);
  Serial.println("\nESP32-CAM Starting...");

  WiFi.begin(ssid, password);
  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println();
  Serial.print("WiFi connected. IP: ");
  Serial.println(WiFi.localIP());

  // Sync time via NTP
  configTime(gmtOffset_sec, daylightOffset_sec, ntpServer);
  Serial.print("Waiting for NTP time sync");
  while (time(nullptr) < 100000) {
    delay(500);
    Serial.print(".");
  }
  Serial.println();
  Serial.println("Time synchronized: " + getFormattedTime());

  startCamera();

  // Start HTTP server to listen for /capture command
  httpServer.begin();
  Serial.println("HTTP Server started - waiting for /capture requests.");
}

void loop() {
  reconnectWiFi();

  WiFiClient client = httpServer.available();
  if (!client) {
    delay(10);
    return;
  }

  // Read HTTP request line, safely
  String request = client.readStringUntil('\r');
  client.read(); // Consume '\n'

  Serial.println("HTTP Request: " + request);

  // Check for capture command
  if (request.startsWith("GET /capture")) {
    Serial.println("Capture request received.");

    camera_fb_t *fb = esp_camera_fb_get();
    if (!fb) {
      Serial.println("Camera capture failed.");
      client.println("HTTP/1.1 500 Internal Server Error\r\nContent-Type: text/plain\r\n\r\nCamera capture failed");
      client.stop();
      return;
    }

    sendPhoto(fb);

    esp_camera_fb_return(fb);

    client.println("HTTP/1.1 200 OK");
    client.println("Content-Type: text/plain");
    client.println("Connection: close");
    client.println();
    client.println("Capture completed");
  } else {
    client.println("HTTP/1.1 404 Not Found");
    client.println("Content-Type: text/plain");
    client.println("Connection: close");
    client.println();
    client.println("Not Found");
  }
  delay(10);
}
