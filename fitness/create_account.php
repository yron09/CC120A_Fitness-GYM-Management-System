<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Basic validation (you can add more robust validation based on your needs)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters!";
        exit;
    }

    // Hash the password (for security reasons, you should never store plain-text passwords)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Save the data to a database (assuming you have a database connection setup)
    $servername = "localhost";
    $dbUsername = "root"; // Database username
    $dbPassword = ""; // Database password
    $dbname = "mydatabase"; // Database name

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database
    $sql = "INSERT INTO users (email, phone, username, password)
            VALUES ('$email', '$phone', '$username', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Account created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>