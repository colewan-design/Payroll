<?php 
// Define a list of approved IP addresses
$allowed_ips = array('2001:4452:4e1:c500:2126:99e9:18e4:5bca', '103.125.149.71','192.168.72.254', '192.168.72.42', '192.168.1.1', '10.0.0.1', '192.168.0.106', '112.206.152.98', '49.151.11.217', '119.92.59.242');


// Get the IP address of the user
$user_ip = $_SERVER['REMOTE_ADDR'];
echo $user_ip;

// Check if the user's IP address is in the list of approved IPs
if (!in_array($user_ip, $allowed_ips)) {
    // If the user's IP address is not in the list, deny access
    http_response_code(403);
    die("Access denied. Please Contact CBOO Admin.".  $user_ip);
}
?>