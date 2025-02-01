<?php
	$con=mysqli_connect("localhost","root","","train") or (myslq_error());
	//if ($conn->connect_error) {
    //die("Connection failed: " . $conn->connect_error);
//}
?>

# Then create train.php

<?php
session_start();
include("connect.php"); // Include the database connection file

// Fetch POST data
$trainarrival = $_POST['trainarrival'] ?? null;
$traindeparture = $_POST['traindeparture'] ?? null;

// Calculate time difference
function calculateTimeDifference($arrival, $departure) {
    $arrivalTime = new DateTime($arrival);
    $departureTime = new DateTime($departure);
    $interval = $arrivalTime->diff($departureTime);
    return $interval->format('%H:%I:%S'); // Format as hours:minutes:seconds
}

if ($trainarrival && $traindeparture) {
    $timeDifference = calculateTimeDifference($trainarrival, $traindeparture);

    // Insert the data into the database
    $query = "INSERT INTO train (trainarrival, traindeparture, time) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sss", $trainarrival, $traindeparture, $timeDifference);
    $stmt->execute();
    $stmt->close();
}

// Fetch train data from the database
$query = "SELECT trainnumber, trainarrival, traindeparture, time FROM train";
$result = mysqli_query($con, $query);

// Count the total number of trains
$totalTrainsQuery = "SELECT COUNT(*) AS totalTrains FROM train";
$totalTrainsResult = mysqli_query($con, $totalTrainsQuery);
$totalTrainsRow = mysqli_fetch_assoc($totalTrainsResult);
$totalTrains = $totalTrainsRow['totalTrains'];

// Sum the total time for all trains
$totalTimeQuery = "SELECT time FROM train";
$totalTimeResult = mysqli_query($con, $totalTimeQuery);

$totalSeconds = 0;

while ($row = mysqli_fetch_assoc($totalTimeResult)) {
    $timeParts = explode(':', $row['time']);
    $seconds = ($timeParts[0] * 3600) + ($timeParts[1] * 60) + $timeParts[2];
    $totalSeconds += $seconds;
}

// Convert total seconds back to HH:MM:SS
$hours = floor($totalSeconds / 3600);
$minutes = floor(($totalSeconds % 3600) / 60);
$seconds = $totalSeconds % 60;

$totalTimeFormatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Arrival and Departure</title>
	<meta http-equiv="refresh" content="3">
    <style>
        body {
		background: linear-gradient(105deg, rgba(255,255,255,1) 0%, rgba(0,93,93,1) 100%);
		margin: 0;
		padding: 0;
		font-family: Arial, sans-serif;
		display: flex;
		flex-direction: column;
		min-height: 100vh;
        }
		header {
			background-color: #cffdff; /* Set the header background to black */
			color: white; /* Set the text color to white for contrast */
			padding: 10px 20px;
			text-align: center;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
			border-bottom-left-radius: 30px;
			border-bottom-right-radius: 30px;
		}
		.container {
            background-color: black;
            padding: 1px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);	
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 80%;
            margin: 20px auto;
			padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
		main {
			flex: 1; /* This makes the main content area flexible, filling the space between header and footer */
			padding: 20px;
		}

		footer {
			background-color: #cffdff; /* Set the footer background to black */
			color: white; /* Set the text color to white for contrast */
			text-align: center;
			border-top-left-radius: 30px;
			border-top-right-radius: 30px;
			bottom: 0;
			width: 100%;
		}
    </style>
</head>
<body>
	<header>
        <h1>Railway Crossing system </h1>
    </header>

    <h1>Train Arrival and Departure Schedule</h1>
    <table>
        <thead>
            <tr>
                <th>Train Number</th>
                <th>Arrival Time</th>
                <th>Departure Time</th>
                <th>Total Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if the query returned any results
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row of data and display it in the table
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['trainnumber']) . "</td>";
                    echo "<td>" . (!empty($row['trainarrival']) ? date("Y-m-d h:i:s A", strtotime($row['trainarrival'])) : 'N/A') . "</td>";
                    echo "<td>" . (!empty($row['traindeparture']) ? date("Y-m-d h:i:s A", strtotime($row['traindeparture'])) : 'N/A') . "</td>";
                    echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                    echo "</tr>";
                }
            } else {
                // If no data is returned, display a message
                echo "<tr><td colspan='4'>No train data available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
	<h6 class="container"></h6>
	<h1> Total Train Crossed and Combined Time </h1>
	<table>
        <thead>
            <tr>
                <th>Total Train</th>
                <th>Total Time</th>
            </tr>
        </thead>
        <tbody>
            <td><?php echo $totalTrains; ?></td>
            <td><?php echo $totalTimeFormatted; ?></td>
        </tbody>
    </table>
	<h6 class="container"></h6>
	<footer>
        <h1>MML Project</h1>
		<font size="2" color="black"> 
			THIS PROJECT IS DEVELOPED BY KHALED AMMAR(1008) AND SHOWRUP DAS(1005).SPRING-2024,5TH SEMESTER,41TH BATCH,SECTION A.
		</font>
		Design:KHALED AMMAR(1008)
    </footer>
</body>
</html>
<?php
// Close the database connection
mysqli_close($con);
?>