<?php
// Connect to the database
$dbHost = 'bsu-info.tech';
$dbUsername = 'u455679702_cps';
$dbPassword = 'OpK3RKh]!h9';
$dbName = 'u455679702_cps';
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Get the file path from the form submission
$file_path = $_POST['file_path'];

// Prepare the MySQL query to insert or update the file path
$sql = "INSERT INTO file_path (id, folder_path) VALUES (1, '$file_path') 
        ON DUPLICATE KEY UPDATE folder_path='$file_path'";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "File path inserted or updated successfully";
} else {
    echo "Error inserting or updating file path: " . $conn->error;
}
header('Location: settings.php');

// Close the database connection
$conn->close();
?>
