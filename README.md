# Xtrip: Laser Tripwire Alarm System

## Overview

Xtrip is an IoT-based Laser Tripwire Alarm System designed to provide real-time intrusion detection, visual evidence capture, and remote monitoring for restricted areas such as stock rooms, warehouses, resorts, and other secured facilities.

The system utilizes an ESP32 microcontroller, ESP32-CAM module, laser emitter, Light Dependent Resistor (LDR), and a web-based monitoring platform to detect unauthorized access and immediately notify users while recording intrusion events.

---

## Project Objectives

* Detect unauthorized entry using laser tripwire technology.
* Capture visual evidence upon intrusion detection.
* Generate real-time alerts and notifications.
* Store intrusion records in a database.
* Provide remote monitoring through a web application.
* Improve security while maintaining low deployment costs.

---

## Key Features

### Laser Tripwire Detection

A laser beam is continuously projected toward an LDR sensor. Any interruption in the beam triggers the intrusion detection process.

### Real-Time Alarm System

Upon detection:

* Buzzer alarm is activated.
* Intrusion event is recorded.
* Notification is generated.

### Image Capture

The ESP32-CAM captures images when an intrusion is detected, providing visual evidence for investigation.

### Web-Based Monitoring

Users can remotely:

* Monitor system status
* View intrusion logs
* Access captured images
* Arm or disarm the alarm system

### Database Logging

All intrusion events are stored in a centralized database containing:

* Date
* Time
* Status
* Captured Images

---

## System Architecture

### Hardware Components

* ESP32 Microcontroller
* ESP32-CAM
* Laser Module
* LDR Sensor
* Buzzer
* Power Supply

### Software Components

* Arduino IDE
* PHP
* MySQL
* HTML
* CSS
* JavaScript

### Architecture Flow

```text
Laser Module → LDR Sensor → ESP32 → ESP32-CAM → Web Server → Database → User Dashboard
```

---

## Technologies Used

| Category                | Technology            |
| ----------------------- | --------------------- |
| Microcontroller         | ESP32                 |
| Camera Module           | ESP32-CAM             |
| Sensor                  | LDR                   |
| Detection Method        | Laser Tripwire        |
| Database                | MySQL                 |
| Backend                 | PHP                   |
| Frontend                | HTML, CSS, JavaScript |
| Communication           | Wi-Fi                 |
| Development Environment | Arduino IDE           |

---

## Development Methodology

The project follows the Iterative Prototyping Software Development Life Cycle (SDLC), allowing continuous improvement through testing, evaluation, and user feedback.

### SDLC Phases

1. Planning and Requirement Analysis
2. System Design
3. Development
4. Testing
5. Deployment
6. Maintenance and Support

---

## Scope

The system is intended for:

* Resorts
* Warehouses
* Stock Rooms
* Offices
* Small Businesses
* Restricted Facilities

---

## Limitations

* Performance may be affected by extreme environmental conditions.
* Advanced facial recognition is not implemented.
* Continuous HD video streaming is not supported.
* Requires stable network connectivity for remote monitoring.

---

## Installation Guide

### Step 1: Install Required Software

Download and install:

1. XAMPP
2. Arduino IDE

### Step 2: Download the Project

1. Download the repository as a ZIP file or clone it from GitHub.
2. Extract the ZIP file if necessary.

### Step 3: Move the Project to XAMPP

1. Open your XAMPP installation folder.
2. Navigate to:

```text
xampp/htdocs/
```

3. Copy the entire `xtrip` folder into `htdocs`.

```text
xampp/
└── htdocs/
    └── xtrip/
```

### Step 4: Start XAMPP

1. Open XAMPP Control Panel.
2. Start Apache.
3. Start MySQL.

### Step 5: Create the Database

1. Open your browser.
2. Go to:

```text
http://localhost/phpmyadmin
```

3. Click **New**.
4. Create a database named:

```text
ltaw
```

5. Click **Create**.

### Step 6: Import the Database File

1. Select the `ltaw` database.
2. Click **Import**.
3. Choose:

```text
ltawfinal.sql
```

4. Click **Go**.

### Step 7: Configure the Database Connection

Verify:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "ltaw";
```

### Step 8: Open the Web Application

Visit:

```text
http://localhost/xtrip
```

### Step 9: Login as Administrator

**Username:** `jikobcsmro@gmail.com`

**Password:** `Jacob123!`

> Note: For security purposes, it is recommended to change the default password after the first login.

### Step 10: Upload the ESP32 DevKit Code

1. Open Arduino IDE.
2. Open `esp32devkitsketch.ino`.
3. Select the correct ESP32 board.
4. Select the correct COM Port.
5. Click **Upload**.

### Step 11: Upload the ESP32-CAM Code

1. Open Arduino IDE.
2. Open `esp32camsketch.ino`.
3. Select **AI Thinker ESP32-CAM**.
4. Select the correct COM Port.
5. Click **Upload**.

### Step 12: Connect the Hardware

1. Connect the ESP32 DevKit.
2. Connect the ESP32-CAM.
3. Connect the Laser Module.
4. Connect the LDR Sensor.
5. Connect the Buzzer.

### Step 13: Test the System

1. Power on the ESP32 devices.
2. Connect them to Wi-Fi.
3. Open the dashboard.
4. Interrupt the laser beam.

Verify that:

* The buzzer activates.
* An intrusion event is recorded.
* An image is captured.
* The event appears on the dashboard.

### Local Access URL

```text
http://localhost/xtrip
```

---

## Future Improvements

* Mobile Application Development
* Live Camera Streaming
* Advanced Intruder Recognition
* Cloud Storage Integration
* Smart Home Integration
* Enhanced Notification System

---

## Researchers

### Bachelor of Science in Information Technology

**PHINMA University of Iloilo**

**Researchers**

* Julian Jacob P. Casimiro
* Luzel A. Ambugana
* Dan Rytchy Magneser

**Adviser**

* Kriz Anthony Zuniega

**Academic Year**

* 2025–2026

---

## License

This project was developed for academic and research purposes as part of the Bachelor of Science in Information Technology Capstone Project requirements.
