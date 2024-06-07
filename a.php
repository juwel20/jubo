<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jubo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the table name from the URL
$table = $_GET['table'];

// Validate the table name
if (!in_array($table, ['2222tk', '4444tk'])) {
    die("Invalid table name.");
}

// Query the database
$result = $conn->query("SELECT * FROM $table");

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    // Fetch and display the table headers
    while ($field = $result->fetch_field()) {
        echo "<th>{$field->name}</th>";
    }
    echo "</tr>";

    // Fetch and display the table rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $data) {
            echo "<td>$data</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found.";
}

$conn->close();
?>
