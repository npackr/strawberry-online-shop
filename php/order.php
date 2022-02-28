<?php
require_once('server.php');
require_once('sign_tools.php');

$request = $_POST['request'];
$customer_id = $_POST['username'];
$customer_loginkey = $_POST['onlinekey'];
$order_id = generateRandomString(10);
$invoice_id = generateRandomString(10);
$item_id = $_POST['itemid'];
$item_amount = $_POST['itemamount'];

function addToCart($obj_order_id, $obj_item_id, $obj_customer_id, $obj_item_amount, $obj_conn) {
    $additem_query = "INSERT INTO PhieuMuaHang(PMH_ID, CL_ID, KH_ID, PMH_SoLuong) VALUES ('".$obj_order_id."','".$obj_item_id."','".$obj_customer_id."', ".$obj_item_amount.");";
    $additem_result = mysqli_query($obj_conn, $additem_query);

    if ($additem_result == 1) {
        return 1;
    } else {
        return 0;
    }
}

function buyNow($obj_order_id, $obj_invoice_id, $obj_customer_id, $obj_conn) {
    $addinvoice_query = "INSERT INTO PhieuMuaHang(HD_MaHoaDon) VALUES ('".$obj_invoice_id."');";
    $addinvoice_result = mysqli_query($obj_conn, $addinvoice_query);

    $createinvoice_query = "INSERT INTO HoaDon(HD_MaHoaDon, LP_ID, HD_KhachHang, HD_LoaiHoaDon) VALUES ('".$obj_order_id."', 1,'".$obj_customer_id."', 1);";
    $createinvoice_result = mysqli_query($obj_conn, $createinvoice_query);

    if ($addinvoice_result == 1) {
        if ($createinvoice_result == 1) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return -1;
    }
}

function checkLoginKey($obj_username, $obj_onlinekey, $obj_conn) {
    $checkloginkey_query = "SELECT TT_Ma FROM `TrucTuyen` WHERE TT_TaiKhoan = '".$obj_username."';";
    $checkloginkey_result = mysqli_query($obj_conn, $checkloginkey_query);

    if (mysqli_num_rows($checkloginkey_result) > 0) {
        while ($row = mysqli_fetch_assoc($checkloginkey_result)) {
            $server_loginkey = $row['TT_Ma'];
        }
        if ($server_loginkey == $obj_onlinekey) {
            return 1;
        } else {
            return 0;
        }
    }
}

function getInvoiceInformation($obj_invoice_id, $obj_conn) {
    $getinfo_query = "SELECT * FROM `HoaDon` INNER JOIN `PhieuMuaHang` INNER JOIN `ChungLoai` ON CL_ID = CL_ID ON HD_MaHoaDon = HD_MaHoaDon GROUP BY CL_ID WHERE HD_MaHoaDon = '".$obj_invoice_id."';";
    $getinfo_result = mysqli_query($obj_conn, $getinfo_query);

    if (mysqli_num_rows($getinfo_result) > 0) {
        while ($row = mysqli_fetch_assoc($getinfo_result)) {
            $server_invoice_id = $row['HD_MaHoaDon'];
        }
    }
}

function checkExistsItem() {

}

switch ($request) {
    case 'addtocart' :
        $jsonData['request'] = 'add_to_cart';

        if (checkLoginKey($customer_id, $customer_loginkey, $conn) == 1) {
            if (addToCart($order_id, $item_id, $customer_id, $item_amount, $conn) == 1) {
                $jsonData['result'] = 1;
            } else {
                $jsonData['result'] = 0;
                $jsonData['error_code'] = 11;
                $jsonData['error_description'] = 'Thêm vật phẩm vào giỏ hàng thất bại';
            };
        } else {
            $jsonData['result'] = 0;
                $jsonData['error_code'] = 14;
                $jsonData['error_description'] = 'Khóa đăng nhập không trùng khớp với dữ liệu lưu trên hệ thống';
        }
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;
    default :
        echo 'Unknown Request';
        break;
}