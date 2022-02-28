<?php
require_once('server.php');
$chungloai = $_GET['chungloai'];
$xuatxu = $_GET['xuatxu'];

switch ($chungloai) {
  case '0':
    $query = 'SELECT * FROM `ChungLoai` ORDER BY `CL_ID` DESC LIMIT 5;';
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $re_chungloai['maso'] = $row['CL_ID'];
        $re_chungloai['tengiong'] = $row['CL_TenGiong'];
        echo '<li class="npackr_cl_id_' .$re_chungloai['maso']. ' uppercase">
              <a data-toggle="modal" href="#npackr-categories-detail-view" onclick="getItemDescription('.$re_chungloai['maso'].')" title="' .$re_chungloai['tengiong']. '">' .$re_chungloai['tengiong']. ' <b class=" fa fa-angle-right"></b></a>
              </li>';
      }
    } else {
    }
    break;
    break;
  default:
    $query = 'SELECT * FROM `ChungLoai` WHERE CL_ID = "' . $chungloai . '"; ';
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $re_chungloai['maso'] = $row['CL_ID'];
        $re_chungloai['tengiong'] = $row['CL_TenGiong'];
        $re_chungloai['xuatxu'] = $row['CL_MoTa'];
        $re_chungloai['giaban'] = $row['CL_GiaBan'];
        echo $re_chungloai['maso'] . ' ' . $re_chungloai['tengiong'];
      }
    } else {
    }
    break;
    break;
}

switch ($xuatxu) {
  case 'unknown':
    $query = 'SELECT XX_ID, XX_Ten FROM `XuatXu`; ';
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $re_xuatxu['maso'] = $row['XX_ID'];
        $re_xuatxu['ten'] = $row['XX_Ten'];
        echo '<li class="npackr_cl_id_' .$re_xuatxu['maso']. ' uppercase">
              <a href="#" onclick="comingSoonAlert()" title="' .$re_xuatxu['ten']. '">' .$re_xuatxu['ten']. ' <b class=" fa fa-angle-right"></b></a>
              </li>';
      }
    } else {
    }
    break;
    break;
  default:
    $query = 'SELECT * FROM `XuatXu` WHERE XX_ID = "' . $xuatxu . '"; ';
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $re_xuatxu['maso'] = $row['XX_ID'];
        $re_xuatxu['ten'] = $row['XX_Ten'];
        $re_xuatxu['mota'] = $row['XX_MoTa'];
        echo $re_xuatxu['maso'] . ' ' . $re_xuatxu['ten'];
      }
    } else {
    }
    break;
    break;
}

