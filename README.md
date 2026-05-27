# Xtrip: Laser Tripwire Alarm System

## Overview
Xtrip: Laser Tripwire Alarm System is an IoT-based security and intrusion detection system designed to protect restricted areas such as stock rooms, private facilities, resorts, and business establishments.

The system uses laser tripwire technology combined with ESP32 and ESP32-CAM modules to detect unauthorized access, trigger alarms, capture visual evidence, and provide real-time monitoring through a web-based application.

This capstone project was developed as a requirement for the degree of Bachelor of Science in Information Technology at PHINMA University of Iloilo.

---

## Features

- Laser-based intrusion detection
- Real-time alarm notification
- ESP32-CAM image capture
- Web-based monitoring system
- Intrusion event logging
- Database storage for records
- Remote system monitoring
- Arm and disarm system controls
- Timestamped event recording
- IoT-enabled communication

---

## Technologies Used

### Hardware
- ESP32 Microcontroller
- ESP32-CAM
- Laser Module
- LDR (Light Dependent Resistor)
- Buzzer
- Wi-Fi Module

### Software
- Arduino IDE
- HTML/CSS/JavaScript
- PHP
- MySQL Database

---

## System Architecture

The system consists of the following modules:

### Intrusion Detection Module
Uses a laser emitter and LDR sensor to detect beam interruptions caused by intruders.

### Alert and Alarm Module
Triggers a buzzer alarm and sends notifications upon intrusion detection.

### Visual Evidence Capture Module
Uses ESP32-CAM to capture images during intrusion events.

### Web Monitoring Module
Allows users to monitor logs, captured images, and system status remotely.

### Database Module
Stores:
- Date
- Time
- Intrusion Status
- Captured Images

---

## Objectives

The project aims to:

- Develop a low-cost intrusion detection system
- Improve real-time security monitoring
- Capture visual evidence of unauthorized access
- Reduce false alarms
- Provide remote monitoring capabilities

---

## Scope of the System

The system is designed for:
- Resorts
- Stock rooms
- Small businesses
- Restricted indoor areas

Detection range:
- Approximately 10–20 meters indoors

---

## Researchers

- Julian Jacob P. Casimiro
- Luzel A. Ambugana
- Dan Rytchy Magneser

---

## Adviser

- Kriz Anthony Zuniega

---

## School

PHINMA University of Iloilo  
College of Information Technology Education

---

## Installation Guide

### Hardware Setup
1. Connect the laser module and LDR sensor
2. Connect ESP32 and ESP32-CAM
3. Connect buzzer module
4. Power the system

### Software Setup
1. Install Arduino IDE
2. Upload ESP32 firmware
3. Configure Wi-Fi credentials
4. Import database `.sql` file
5. Run the web application server

---

## How the System Works

1. The laser continuously points toward the LDR sensor
2. When the beam is interrupted:
   - The buzzer alarm activates
   - ESP32-CAM captures an image
   - Data is stored in the database
   - Notification is sent to the user
3. Users can monitor events using the web application

---

## Project Structure

```text
Xtrip-Laser-Tripwire-Alarm-System/
│
├── Arduino_Code/
├── ESP32_CAM/
├── Web_Application/
├── Database/
├── Documentation/
├── Images/
└── README.md
```

---

## Results

Based on system testing:

- Detection accuracy reached up to 98.5%
- Response time achieved below 150ms for local alarms
- Users reported high satisfaction with system usability and security performance

---

## Future Improvements

- Live video streaming
- Mobile application integration
- Smart home ecosystem support
- Advanced AI/object detection
- Improved outdoor environmental resistance

---

## License

This project is for academic and educational purposes only.

---

## Acknowledgment

The researchers would like to thank:
- PHINMA University of Iloilo
- College of Information Technology Education
- Project adviser
- Family and friends
- Everyone who supported the development of this capstone project
