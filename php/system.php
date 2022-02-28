<?php
require_once('server.php');

$request = $_POST['request'];
$num_of_posts = $_POSTS['numofposts'];

switch ($request) {
    case 'aboutus':
        $jsonData['request'] = 'about_us';

        $getcontent_query = "SELECT HT_GioiThieu FROM `HeThong` WHERE HT_ID = '1';";
        $getcontent_result = mysqli_query($conn, $getcontent_query);

        if (mysqli_num_rows($getcontent_result) > 0) {
            while ($row = mysqli_fetch_assoc($getcontent_result)) {
                $content = $row['HT_GioiThieu'];
            }
            $jsonData['result'] = 1;
            $jsonData['result_title'] = 'Về chúng tôi';
            $jsonData['result_content'] = $content;
        } else {
            $jsonData['result'] = 0;
            $jsonData['error_code'] = 13;
            $jsonData['error_description'] = 'Có lỗi khi lấy thông tin từ máy chủ';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;

    case 'tos':
        $jsonData['request'] = 'tos';

        $getcontent_query = "SELECT HT_DieuKhoanSuDung FROM `HeThong` WHERE HT_ID = '1';";
        $getcontent_result = mysqli_query($conn, $getcontent_query);

        if (mysqli_num_rows($getcontent_result) > 0) {
            while ($row = mysqli_fetch_assoc($getcontent_result)) {
                $content = $row['HT_DieuKhoanSuDung'];
            }
            $jsonData['result'] = 1;
            $jsonData['result_title'] = 'Điều khoản sử dụng';
            $jsonData['result_content'] = $content;
        } else {
            $jsonData['result'] = 0;
            $jsonData['error_code'] = 13;
            $jsonData['error_description'] = 'Có lỗi khi lấy thông tin từ máy chủ';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;

    case 'top':
        $jsonData['request'] = 'top';

        $getcontent_query = "SELECT HT_ThongBaoQuyenRiengTu FROM `HeThong` WHERE HT_ID = '1';";
        $getcontent_result = mysqli_query($conn, $getcontent_query);

        if (mysqli_num_rows($getcontent_result) > 0) {
            while ($row = mysqli_fetch_assoc($getcontent_result)) {
                $content = $row['HT_ThongBaoQuyenRiengTu'];
            }
            $jsonData['result'] = 1;
            $jsonData['result_title'] = 'Thông báo quyền riêng tư';
            $jsonData['result_content'] = $content;
        } else {
            $jsonData['result'] = 0;
            $jsonData['error_code'] = 13;
            $jsonData['error_description'] = 'Có lỗi khi lấy thông tin từ máy chủ';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;

    case 'toud':
        $jsonData['request'] = 'toud';

        $getcontent_query = "SELECT HT_ChinhSachSuDungDuLieu FROM `HeThong` WHERE HT_ID = '1';";
        $getcontent_result = mysqli_query($conn, $getcontent_query);

        if (mysqli_num_rows($getcontent_result) > 0) {
            while ($row = mysqli_fetch_assoc($getcontent_result)) {
                $content = $row['HT_ChinhSachSuDungDuLieu'];
            }
            $jsonData['result'] = 1;
            $jsonData['result_title'] = 'Chính sách sử dụng dữ liệu';
            $jsonData['result_content'] = $content;
        } else {
            $jsonData['result'] = 0;
            $jsonData['error_code'] = 13;
            $jsonData['error_description'] = 'Có lỗi khi lấy thông tin từ máy chủ';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;
    case 'tog':
        $jsonData['request'] = 'tog';

        $getcontent_query = "SELECT HT_ChinhSachBaoDam FROM `HeThong` WHERE HT_ID = '1';";
        $getcontent_result = mysqli_query($conn, $getcontent_query);

        if (mysqli_num_rows($getcontent_result) > 0) {
            while ($row = mysqli_fetch_assoc($getcontent_result)) {
                $content = $row['HT_ChinhSachBaoDam'];
            }
            $jsonData['result'] = 1;
            $jsonData['result_title'] = 'Chính sách bảo đảm';
            $jsonData['result_content'] = $content;
        } else {
            $jsonData['result'] = 0;
            $jsonData['error_code'] = 13;
            $jsonData['error_description'] = 'Có lỗi khi lấy thông tin từ máy chủ';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;
    case 'tod':
        $jsonData['request'] = 'tod';

        $getcontent_query = "SELECT HT_ChinhSachVanChuyen FROM `HeThong` WHERE HT_ID = '1';";
        $getcontent_result = mysqli_query($conn, $getcontent_query);

        if (mysqli_num_rows($getcontent_result) > 0) {
            while ($row = mysqli_fetch_assoc($getcontent_result)) {
                $content = $row['HT_ChinhSachVanChuyen'];
            }
            $jsonData['result'] = 1;
            $jsonData['result_title'] = 'Chính sách vận chuyển';
            $jsonData['result_content'] = $content;
        } else {
            $jsonData['result'] = 0;
            $jsonData['error_code'] = 13;
            $jsonData['error_description'] = 'Có lỗi khi lấy thông tin từ máy chủ';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;

    case 'tor':
        $jsonData['request'] = 'tor';

        $getcontent_query = "SELECT HT_TuyenDung FROM `HeThong` WHERE HT_ID = '1';";
        $getcontent_result = mysqli_query($conn, $getcontent_query);

        if (mysqli_num_rows($getcontent_result) > 0) {
            while ($row = mysqli_fetch_assoc($getcontent_result)) {
                $content = $row['HT_TuyenDung'];
            }
            $jsonData['result'] = 1;
            $jsonData['result_title'] = 'Cơ hội việc làm';
            $jsonData['result_content'] = $content;
        } else {
            $jsonData['result'] = 0;
            $jsonData['error_code'] = 13;
            $jsonData['error_description'] = 'Có lỗi khi lấy thông tin từ máy chủ';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;

    case 'getpostslist':
        $jsonData['request'] = 'posts';

        $getcontent_query = "SELECT BV_ID, BV_TieuDe FROM `BaiViet` ORDER BY BV_NgayDang ASC LIMIT 4;";
        $getcontent_result = mysqli_query($conn, $getcontent_query);

        if (mysqli_num_rows($getcontent_result) > 0) {
            $x = 1;
            while ($row = mysqli_fetch_assoc($getcontent_result)) {
                $content[$x]['post_title'] = $row['BV_TieuDe'];
                $content[$x]['post_id'] = $row['BV_ID'];
                $x++;
            }
            $jsonData['result'] = 1;
            $jsonData['result_content'] = $content;
        } else {
            $jsonData['result'] = 0;
            $jsonData['error_code'] = 13;
            $jsonData['error_description'] = 'Có lỗi khi lấy thông tin từ máy chủ';
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        break;
    default:
        echo 'Unknown Request';
        break;
}