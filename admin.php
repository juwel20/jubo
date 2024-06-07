<?php
// Start the session
session_start();

// Database connection details
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "jubo"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve email and password from POST request
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("SELECT name, email, password FROM admin WHERE email = ?");
if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}
$stmt->bind_param("s", $email);

// Execute the statement
if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

// Bind result variables
$stmt->bind_result($name, $email, $stored_password);

// Fetch the result
if ($stmt->fetch()) {
    // Compare the plain text password
    if ($password === $stored_password) {
        // Password is correct, start the session
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $name;
        header("Location: a.html"); // Redirect to a.html
        exit();
    } else {
        // Password is incorrect
        echo "Invalid email or password.";
    }
} else {
    // No user found with that email
    echo "Invalid email or password.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
