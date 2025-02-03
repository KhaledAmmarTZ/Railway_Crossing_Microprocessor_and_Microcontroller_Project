import serial
import requests
from datetime import datetime

# Set up the serial connection (adjust COM port and baud rate as needed)
ser = serial.Serial('COM3', 9600)  # Replace COM3 with your actual port

# URL of the PHP script
server_url = "http://localhost/train/tran.php"

def send_data_to_php(train_arrival_time, train_departure_time):
    # Prepare the data to be sent to PHP
    data = {
        'trainnumber': 1,  # Update this with actual logic to increment train number
        'trainarrival': train_arrival_time,
        'traindeparture': train_departure_time,
        'time': calculate_time_difference(train_arrival_time, train_departure_time)
    }
    # Send the data using POST request
    try:
        response = requests.post(server_url, data=data)
        response.raise_for_status()  # Check for HTTP request errors
        print("Data sent successfully")
    except requests.exceptions.RequestException as e:
        print(f"Error sending data: {e}")

def calculate_time_difference(arrival_time, departure_time):
    # Convert string to datetime
    arrival = datetime.strptime(arrival_time, '%Y-%m-%d %H:%M:%S')
    departure = datetime.strptime(departure_time, '%Y-%m-%d %H:%M:%S')
    # Calculate difference
    time_diff = departure - arrival
    # Return the difference in minutes
    return str(int(time_diff.total_seconds() // 60)) + " minutes"

while True:
    if ser.in_waiting > 0:
        line = ser.readline().decode('utf-8').strip()
        # Check for the specific command from Arduino
        if line == "TRAIN_ARRIVED":
            train_arrival_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            print(f"Train arrived at: {train_arrival_time}")
        elif line == "TRAIN_DEPARTED":
            train_departure_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            print(f"Train departed at: {train_departure_time}")
            # Send the data to PHP
            send_data_to_php(train_arrival_time, train_departure_time)