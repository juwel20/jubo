<?php

// Replace with your database connection details
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

// Get form data
$name = $_POST["name"];
$mobile = $_POST["mobile"];
$gender = $_POST["gender"];
$course = $_POST["course"];

$table_name = "";

// Determine table name based on selected course
if ($course == "4444tk") {
  $table_name = "4444tk";
} else if ($course == "2222tk") {
  $table_name = "2222tk";
} else {
  echo "Invalid course selection";
  exit; // Terminate script if course is invalid
}

// Prepare SQL statement
$sql = "INSERT INTO " . $table_name . " (name, mobile, gender) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters to prevent SQL injection
$stmt->bind_param("sss", $name, $mobile, $gender);

if ($stmt->execute()) {
  // Information saved successfully, redirect to A.html
  header("Location: payment.html");
  exit;
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
