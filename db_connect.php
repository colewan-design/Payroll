<?php


$host = "bsu-info.tech";
$username = "u455679702_cps";
$password = "OpK3RKh]!h9";
$dbName = "u455679702_cps";

$conn= new mysqli($host, $username, $password,$dbName);
if(!$conn){
    die("Database Connection Error: ".$conn->error);
}

