<?php
// date_default_timezone_set('Asia/Kolkata');
$servername = "localhost";
$user_name = "root";
$pass = "";
$dbname = "attendance_db";

// Create connection
$conn = new mysqli($servername, $user_name, $pass, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
