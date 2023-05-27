<?php
// Log the SQL query
error_log('SQL Query: ' . $sql);
// Get the POST data
$columnIndex = $_POST['columnIndex'];
$rowIndex = $_POST['rowIndex'];
$newValue = $_POST['newValue'];

// Connect to the database
$mysqli = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli)); 

// Check for errors
if ($mysqli->connect_errno) {
    die('Error connecting to database: ' . $mysqli->connect_error);
}

// Build the SQL query to update the record
$sql = "UPDATE data SET ";

switch ($columnIndex) {
    case 0:
        $sql .= "name = '" . $mysqli->real_escape_string($newValue) . "'";
        break;
    case 1:
        $sql .= "position = '" . $mysqli->real_escape_string($newValue) . "'";
        break;
    case 2:
        $sql .= "sg = '" . $mysqli->real_escape_string($newValue) . "'";
        break;
    case 3:
        $sql .= "step = '" . $mysqli->real_escape_string($newValue) . "'";
        break;
    case 4:
        $sql .= "salary = '" . $mysqli->real_escape_string($newValue) . "'";
        break;
}

$sql .= " WHERE id = " . ($rowIndex + 1);

// Execute the SQL query
if (!$mysqli->query($sql)) {
    die('Error updating record: ' . $mysqli->error);
} else {
    // Get the updated record from the database
    $result = $mysqli->query("SELECT * FROM data WHERE id = " . ($rowIndex + 1));
    $record = $result->fetch_assoc();
    // Return the new value as a JSON object
    echo json_encode(array('newValue' => $record[$datatable->getColumn($columnIndex)->getName()]));
}
// Close database connection
$mysqli->close();
?>