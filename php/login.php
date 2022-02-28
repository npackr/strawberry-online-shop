<?php
require_once('server.php');
require_once('ip_tools.php');
require_once('sign_tools.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

$request = $_POST['request'];
$user_logintime = date('Y/m/d H:i:s');
$user_loginip = get_ip_address();
$user_onlinekey = $_POST['onlinekey'];
$user_loginid = $_POST['loginid'];
$user_username = $_POST['username'];
$user_password = md5($_POST['password']);

function setLoginStatus($obj_username, $obj_loginip, $obj_logintime, $obj_conn)
{
    $obj_loginid = generateRandomString(10);
    $obj_onlinekey = generateRandomString(10);
    $setlogin_query = "INSERT INTO TrucTuyen(TT_ID, TT_TaiKhoan, TT_DangNhapLanCuoi, TT_IP, TT_Ma) VALUES ('".$obj_loginid."' , '".$obj_username."','".$obj_logintime . "', '" . $obj_loginip . "', '" . $obj_onlinekey . "')";
    $setlogin_result = mysqli_query($obj_conn, $setlogin_query);

    if ($setlogin_result == 1) {
        return getLoginUser($obj_loginid, $obj_onlinekey, $obj_conn);
    } else {
        return null;
    }
}

function getLoginUser($obj_loginid, $obj_onlinekey, $obj_conn) {
    $checkinglogin_query = "SELECT TT_TaiKhoan FROM TrucTuyen WHERE TT_ID = '".$obj_loginid."' AND TT_Ma = '".$obj_onlinekey."';";
    $checkinglogin_result = mysqli_query($obj_conn, $checkinglogin_query);

    if (mysqli_num_rows($checkinglogin_result) > 0) {
        while ($row = mysqli_fetch_assoc($checkinglogin_result)) {
            $server_username = $row['TT_TaiKhoan'];
        }
        return $server_username;
    } else {
        return null;
    }
}

function getOnlineKey($obj_username, $obj_conn)
{
    $getonlinekey_query = "SELECT TT_Ma FROM TrucTuyen WHERE TT_TaiKhoan = '".$obj_username."';";
    $getonlinekey_result = mysqli_query($obj_conn, $getonlinekey_query);
    if (mysqli_num_rows($getonlinekey_result) > 0) {
        while ($row = mysqli_fetch_assoc($getonlinekey_result)) {
            $server_onlinekey = $row['TT_Ma'];
        }
        return $server_onlinekey;
    } else {
        return '';
    }
}

function getLoginId($obj_username, $obj_conn)
{
    $getloginid_query = "SELECT TT_ID FROM TrucTuyen WHERE TT_TaiKhoan = '".$obj_username."';";
    $getloginid_result = mysqli_query($obj_conn, $getloginid_query);
    if (mysqli_num_rows($getloginid_result) > 0) {
        while ($row = mysqli_fetch_assoc($getloginid_result)) {
            $server_loginid = $row['TT_ID'];
        }
        return $server_loginid;
    } else {
        return '';
    }
}

function clearLoginStatus($obj_username, $obj_loginid, $obj_onlinekey, $obj_conn)
{
    $deletelogin_query = "DELETE FROM TrucTuyen WHERE TT_TaiKhoan = '" .$obj_username. "' AND TT_ID = '".$obj_loginid."' AND TT_Ma = '".$obj_onlinekey."'; ";
    $deletelogin_result = mysqli_query($obj_conn, $deletelogin_query);
    if ($deletelogin_result == 1) {
        return 1;
    } else {
        return 0;
    }
}

function getUserFullName($obj_username, $obj_conn) {
    $getname_query = "SELECT TTCN_Ten FROM ThongTinCaNhan INNER JOIN KhachHang ON ThongTinCaNhan.KH_ID = KhachHang.KH_ID INNER JOIN DangNhap ON DangNhap.KH_ID = KhachHang.KH_ID WHERE DN_TaiKhoan = '" . $obj_username . "'; ";
    $getname_result = mysqli_query($obj_conn, $getname_query);

    if (mysqli_num_rows($getname_result) > 0) {
        while ($row = mysqli_fetch_assoc($getname_result)) {
            $server_fullname = $row['TTCN_Ten'];
        }
        return $server_fullname;
    } else {
        return '';
    }
}

function updateLoginSession($obj_loginid, $obj_conn) {
    $updatesession_query = "UPDATE TrucTuyen SET TT_DangNhapLanCuoi = now() WHERE TT_ID = '".$obj_loginid."'; ";
    $updatesession_result = mysqli_query($obj_conn, $updatesession_query);

    if ($updatesession_result == 1) {
        return 1;
    } else {
        return 0;
    }
}

switch ($request) {
    case 'login':
        $jsonData['request'] = 'login';
        $checklogin_query = "SELECT DN_MatKhau FROM `DangNhap` WHERE DN_TaiKhoan = '" .$user_username. "'; ";
        $checklogin_result = mysqli_query($conn, $checklogin_query);

        if (mysqli_num_rows($checklogin_result) > 0) {
            while ($row = mysqli_fetch_assoc($checklogin_result)) {
                $server_password = $row['DN_MatKhau'];
            }

            if ($server_password == $user_password) {
                if (setLoginStatus($user_username, $user_loginip, $user_logintime, $conn) != null) {
                    $jsonData['result'] = 1;
                    $jsonData['result_description'] = 'Đăng nhập thành công!';
                    $jsonData['user_username'] = $user_username;
                    $jsonData['user_fullname'] = getUserFullName($user_username, $conn);
                    $jsonData['user_loginid'] = getLoginId($user_username, $conn);
                    $jsonData['user_onlinekey'] = getOnlineKey($user_username, $conn);
                } else {
                    $jsonData['result'] = 0;
                    $jsonData['error_code'] = '8';
                    $jsonData['error_description'] = 'Ghi nhận đăng nhập không thành công, vui lòng liên hệ quản trị viên!';
                };
            } else {
                $jsonData['result'] = 0;
                $jsonData['error_code'] = '2';
                $jsonData['error_description'] = 'Mật khẩu không chính xác!';
            }

        } else {
            $jsonData['result'] = 0;
            $jsonData['username'] = $user_username;
            $jsonData['error_code'] = '1';
            $jsonData['error_description'] = 'Tài khoản không tồn tại!';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;
    case 'login_checking':
        $jsonData['request'] = 'login_checking';
        $checklogin_query = "SELECT TT_ID, TT_Ma, TT_IP, TT_DangNhapLanCuoi FROM TrucTuyen WHERE TT_TaiKhoan = '".$user_username."';";
        $checklogin_result = mysqli_query($conn, $checklogin_query);

        if (mysqli_num_rows($checklogin_result) > 0) {
            while ($row = mysqli_fetch_assoc($checklogin_result)) {
                $server_onlinekey = $row['TT_Ma'];
                $server_loginip = $row['TT_IP'];
                $server_loginid = $row['TT_ID'];
                $server_lastlogintime = $row['TT_DangNhapLanCuoi'];
                $user_offline_time = date_diff($server_lastlogintime, $user_logintime);
            }

            if ($user_offline_time < 8) {
                if ($server_onlinekey == $user_onlinekey) {
                    if ($server_loginid == $user_loginid) {
                        if ($server_loginip == $user_loginip) {
                            if (updateLoginSession($user_loginid, $conn) == 1) {
                                $jsonData['result'] = 1;
                                $jsonData['result_description'] = 'Đăng nhập hợp lệ, bảo lưu trạng thái đăng nhập';
                            } else {
                                $jsonData['result'] = 0;
                                $jsonData['erorr_code'] = '10';
                                $jsonData['error_description'] = 'Ghi nhớ thời gian đăng nhập không thành công, vui lòng liên hệ quản trị viên';
                            }
                        } else {
                            $jsonData['result'] = 0;
                            $jsonData['erorr_code'] = '5';
                            $jsonData['error_description'] = 'Đăng xuất đăng nhập do IP bảo lưu đăng nhập không trùng khớp';
                        }
                    } else {
                        $jsonData['result'] = 0;
                        $jsonData['erorr_code'] = '4';
                        $jsonData['error_description'] = 'Đăng xuất đăng nhập do ID bảo lưu đăng nhập không trùng khớp';
                    }
                } else {
                    $jsonData['result'] = 0;
                    $jsonData['erorr_code'] = '3';
                    $jsonData['error_description'] = 'Đăng xuất đăng nhập do Mã bảo lưu đăng nhập không trùng khớp';
                }
            } else {
                if (clearLoginStatus($user_username, $user_loginid, $user_onlinekey, $conn) == 1) {
                    $jsonData['result'] = 0;
                    $jsonData['erorr_code'] = '7';
                    $jsonData['error_description'] = 'Bạn đăng nhập lần trước đã quá 7 ngày nhưng đăng xuất thất bại, vui lòng liên hệ quản trị viên!';
                } else {
                    $jsonData['result'] = 0;
                    $jsonData['erorr_code'] = '6';
                    $jsonData['error_description'] = 'Đăng xuất đăng nhập do lần đăng nhập trước đã quá 7 ngày';
                }
            }
        } else {
            $jsonData['result'] = '0';
            $jsonData['error_code'] = '9';
            $jsonData['error_description'] = 'Đăng nhập không tìm thấy';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;

    case 'logout':
        if (clearLoginStatus($user_username, $user_loginid, $user_onlinekey, $conn) == 1) {
            $jsonData['result'] = 1;
            $jsonData['result_description'] = 'Đăng xuất thành công';
        } else {
            $jsonData['result'] = 0;
            $jsonData['erorr_code'] = '11';
            $jsonData['error_description'] = 'Đăng xuất trên máy chủ thất bại, máy chủ sẽ tự động đăng xuất sau lần đăng nhập của 7 ngày nữa';   
        }
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
    break;
        
    default : echo 'Unknown request';
    break;
}
