<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    // Get the user ID from the request
    $id = $_GET['id'];
$con = new mysqli('bsu-info.tech', 'u455679702_cps', 'OpK3RKh]!h9', 'u455679702_cps') or die(mysqli_error($mysqli));
    // Query the database for the specified user's data
    $sql = "SELECT id, name, email, role FROM usertable WHERE id = '$id'";
    $result = mysqli_query($con, $sql);

    // Check if the query returned any results
    if (mysqli_num_rows($result) > 0) {
        // Fetch the user's data
        $row = mysqli_fetch_assoc($result);
        // Return the data as a JSON object
        echo json_encode($row);
    } else {
        // If the query did not return any results, return an error message
        echo json_encode(array('error' => 'User not found'));
    }
?>
