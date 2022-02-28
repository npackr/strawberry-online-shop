<?php
$hostname = 'localhost';
$username = 'npackrco_qlsach';
$password = 'AnhKiet1603';
$dbname = 'npackrco_qlsach';
$conn = mysqli_connect($hostname, $username, $password,$dbname);

if (!$conn) {
 die('Không thể kết nối: ' . mysqli_error($conn));
 exit();
}
mysqli_set_charset($conn,'UTF8');
