Railway Crossing System
This project is developed by Khaled Ammar (1008) and Showrup Das (1005) for the Spring 2024 semester, 5th semester, 41st batch, Section A. The Railway Crossing System is designed to manage train arrival and departure schedules using a combination of PHP, MySQL, Python, and Arduino.

Project Overview
The Railway Crossing System consists of the following components:

Database: A MySQL database to store train arrival and departure information.
PHP Scripts: To handle data insertion and retrieval from the database.
Python Script: To read data from an Arduino and send it to the PHP script.
Arduino Code: To detect train arrival and departure using sensors and control the crossing gates.

read the mmlPROJECT.txt for full guide 

🛠️ Hardware Specifications
1. Microcontroller
Arduino Uno (or compatible board)

2. Sensors
PIR Motion Sensor x 2

pirSensor1: Connected to Digital Pin 2

pirSensor2: Connected to Digital Pin 3

Function: Detects train movement at either end of the crossing

3. Servo Motors
Servo Motor x 2 (for crossing gates)

servo1: Signal wire connected to Digital Pin 5

servo2: Signal wire connected to Digital Pin 6

Function: Opens and closes the gates

4. LED Indicators
Gate 1 (Entry Side)
Green LED: Pin 8 – Indicates normal operation (gate open)

Yellow LED: Pin 9 – Warning signal during transition

Red LED: Pin 10 – Stop signal (gate closed)

Gate 2 (Exit Side)
Green LED: Pin 11

Yellow LED: Pin 12

Red LED: Pin 13

Each LED should have a 220Ω resistor in series to prevent burning out.

5. Power Supply
Arduino can be powered via:

USB (when connected to PC for serial communication)

9V battery with adapter

5V regulated power supply
| Component     | Arduino Pin | Notes                       |
| ------------- | ----------- | --------------------------- |
| PIR Sensor 1  | D2          | Output pin of first sensor  |
| PIR Sensor 2  | D3          | Output pin of second sensor |
| Servo Motor 1 | D5          | Signal wire                 |
| Servo Motor 2 | D6          | Signal wire                 |
| Green LED 1   | D8          | With resistor               |
| Yellow LED 1  | D9          | With resistor               |
| Red LED 1     | D10         | With resistor               |
| Green LED 2   | D11         | With resistor               |
| Yellow LED 2  | D12         | With resistor               |
| Red LED 2     | D13         | With resistor               |



Installation Instructions

1. Clone the Repository: Clone this repository to your local machine.
2. Set Up the Database: Execute the SQL commands provided above to create the database and table.
3. Configure PHP: Ensure your PHP environment is set up (e.g., XAMPP) and place the PHP files in the appropriate directory (e.g., C:\xampp\htdocs\train).
4. Install Python Libraries: Navigate to the directory containing read_serial.py and run:

pip install pyserial requests

Run the Python Script: Execute the script using:

python read_serial.py

5. Upload Arduino Code: Upload the Arduino code to your Arduino board and ensure the correct COM port is set.

Usage:
1. The system will detect train arrivals and departures using the sensors.
2. Data will be sent to the PHP script, which will update the database and display the train schedule.

Acknowledgments:
This project is developed by Khaled Ammar (1008) and Showrup Das (1005) for the Spring 2024 semester, 5th semester, 41st batch, Section A, Premier University. 
