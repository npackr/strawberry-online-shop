<?php
require_once('server.php');
require_once('sign_tools.php');

$request = $_POST['request'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$loginid = generateRandomString(10);
$customerid = generateRandomString(10);
$profileid = generateRandomString(10);
$accounttype = 1;
$registerstatus = 0;

date_default_timezone_set('Asia/Ho_Chi_Minh');
$registertime = date('Y/m/d H:i:s');

switch ($request) {
    case 'signup' :
        $jsonData['request'] = 'signup';
        $setlogin_query = "INSERT INTO DangNhap(DN_ID, KH_ID, DN_TaiKhoan, DN_MatKhau, DN_LoaiTaiKhoan) VALUES ('" .$loginid. "', '".$customerid."', '" .$username. "', '".$password."', '".$accounttype."'); ";
        $setlogin_result = mysqli_query($conn, $setlogin_query);
        $setcustomer_query = "INSERT INTO KhachHang(DN_ID, KH_ID, KH_MaSoThongTin) VALUES ('".$loginid."', '".$customerid."', '".$profileid."');";
        $setcustomer_result = mysqli_query($conn, $setcustomer_query);
        $setprofile_query = "INSERT INTO ThongTinCaNhan(TTCN_Ten, TTCN_DiaChi, TTCN_SoDienThoai, TTCN_NgayDangKy, TTCN_ID, KH_ID, TTCN_GioiTinh) VALUES ('".$name."', '".$address."', '".$phone."', '".$registertime."', '".$profileid."', '".$customerid."', '".$gender."');";
        $setprofile_result = mysqli_query($conn, $setprofile_query);

        if ($setlogin_result == 1) {
            if ($setcustomer_result == 1) {
                if ($setprofile_result == 1) {
                    $jsonData['result'] = 1;
                } else {
                    $jsonData['result'] = 0;
                }
            }
        }
        echo json_encode($jsonData);
        break;

    case 'checking_username' :
        $jsonData['request'] = 'checking_username';
        $search_query = "SELECT DN_TaiKhoan FROM DangNhap WHERE DN_TaiKhoan = '" .$username. "';";
        $search_result = mysqli_query($conn, $search_query);
        if (mysqli_num_rows($search_result) > 0) {
            $jsonData['exists'] = 1;
        } else {
            $jsonData['exists'] = 0;
        }
        echo json_encode($jsonData);
        break;

    case 'checking_phone_number':
        $jsonData['request'] = 'checking_phone_number';
        $search_query = "SELECT TTCN_SoDienThoai FROM ThongTinCaNhan WHERE TTCN_SoDienThoai = '" .$phone. "';";
        $search_result = mysqli_query($conn, $search_query);
        if (mysqli_num_rows($search_result) > 0) {
            $jsonData['exists'] = 1;
        } else {
            $jsonData['exists'] = 0;
        }
        echo json_encode($jsonData);
        break;
    default : echo 'Unknown request';
    break;
}