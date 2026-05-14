<?php
$dbserver = 'localhost';
$dbuser = 'root';
$dbuserpass = '';
$dbname = 'puttalamsalon';

$conn = new mysqli($dbserver, $dbuser, $dbuserpass, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>
