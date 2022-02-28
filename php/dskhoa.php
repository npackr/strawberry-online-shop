<?php
$hostname = 'localhost';
$username = '';
$password = '';
$dbname = '';
$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die('Không thể kết nối: ' . mysqli_error($conn));
    exit();
}
mysqli_set_charset($conn, 'UTF8');

$giaibaitap = $_GET['cauhoi'];

$query = "SELECT * FROM `Khoa`;";
$result = mysqli_query($conn, $query);

switch ($giaibaitap) {
    case 'caua':
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $jsonData1['makhoa'] = $row['makhoa'];
                $jsonData1['tenkhoa'] = $row['tenkhoa'];
                $jsonData2[$jsonData1['makhoa']] = $jsonData1;
            }
            $jsonData3['items'] = $jsonData2;
            echo json_encode($jsonData3);
        } else {
            echo -1;
        }
        break;

    case 'caub':

        if (mysqli_num_rows($result) > 0) {
            $x2 = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                $jsonData2['makhoa'] = $row['makhoa'];
                $jsonData2['tenkhoa'] = $row['tenkhoa'];
                $query2 = "SELECT * FROM `BoMon` WHERE makhoa = '" .$jsonData2['makhoa']. "';";
                $result2 = mysqli_query($conn, $query2);
                $x1 = 0;
                $jsonData1 = [];
                $jsonData2['items'] = [];

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $jsonData1['id'] = $row2['id'];
                    $jsonData1['tenbomon'] = $row2['tenbomon'];
                    $jsonData2['items'][$x1] = $jsonData1;
                    $x1++;
                }
                $jsonData3['data'][$x2] = $jsonData2;
                $x2++;
            }
            
            echo json_encode($jsonData3);
        } else {
            echo -1;
        }
        break;
    default:
        break;
}