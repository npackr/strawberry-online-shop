<?php
require_once('server.php');

$request = $_GET['request'];
$item_id = $_GET['id'];

function getItemCountry($obj_country_id, $obj_conn) {
    $getcountry_query = "SELECT XX_Ten, XX_MoTa FROM XuatXu WHERE XX_ID ='".$obj_country_id."';";
    $getcountry_result = mysqli_query($obj_conn, $getcountry_query);

    if (mysqli_num_rows($getcountry_result) > 0) {
        while ($row = mysqli_fetch_assoc($getcountry_result)) {
            $country_name = $row['XX_Ten'];
            $country_description = $row['XX_MoTa'];
        }
        $jsonData['id'] = $obj_country_id;
        $jsonData['name'] = $country_name;
        $jsonData['description'] = $country_description;
    } else {
        $jsonData['id'] = -1;
    }
    return json_encode($jsonData, JSON_UNESCAPED_UNICODE);
}

switch ($request) {
    case 'getitem' :
        $getitem_query = "SELECT * FROM ChungLoai WHERE CL_ID ='".$item_id."';";
        $getitem_result = mysqli_query($conn, $getitem_query);
        if (mysqli_num_rows($getitem_result) > 0) {
            while ($row = mysqli_fetch_assoc($getitem_result)) {
                $item_name = $row['CL_TenGiong'];
                $item_country_id = $row['CL_XuatXu'];
                $item_description = $row['CL_MoTa'];
                $item_price = $row['CL_GiaBan'];
                $item_picnum = $row['CL_HinhAnh'];
            }

            $item_country = getItemCountry($item_country_id, $conn);
            $item_country_set = json_decode($item_country, JSON_UNESCAPED_UNICODE);

            $jsonData['item_name'] = $item_name;
            $jsonData['item_country_id'] = $item_country_set['id'];
            $jsonData['item_country_name'] = $item_country_set['name'];
            $jsonData['item_description'] = $item_description;
            $jsonData['item_price'] = $item_price;
            $jsonData['item_picnum'] = $item_picnum;
            
            echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        }

        break;
    default :
        echo 'Unknown Request';
        break;
}