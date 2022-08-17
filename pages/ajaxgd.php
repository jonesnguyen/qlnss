<?php

// connect database
require_once '../config.php';
$taikhoan = $_POST['taiKhoan'];
$texttaikhoan = '';
$num = count($taikhoan);
for ($i = 0; $i < $num; $i++) {
    $texttaikhoan = $texttaikhoan . " OR bank_sub_acc_id='" . $taikhoan[$i] . "'";
}
$texttaikhoan = substr($texttaikhoan, 4);
//echo $texttaikhoan;
$stday = $_POST['stday'];
//$stday = date('Y-m-d H:i:s',strtotime($stday));
$enday = $_POST['enday'];
//$enday = date('Y-m-d H:i:s',strtotime($enday));
$loai = $_POST['loai'];

// danh sach chi tiet toan bo giao dich
if ($loai == 'Tất cả') {
    $chiTietGD = "SELECT id, time1, bank_sub_acc_id, description1, loai, amount, virtualAccount FROM thu_chi WHERE time1>='$stday' AND time1<='$enday' AND (" . $texttaikhoan . ") ORDER BY id DESC";
} else if ($loai == 'Doanh thu') {
    $chiTietGD = "SELECT id, time1, bank_sub_acc_id, description1, loai, amount, virtualAccount FROM thu_chi WHERE time1>='$stday' AND time1<='$enday' AND loai='Doanh thu' AND (" . $texttaikhoan . ") ORDER BY id DESC";
} else {
    $chiTietGD = "SELECT id, time1, bank_sub_acc_id, description1, loai, amount, virtualAccount FROM thu_chi WHERE time1>='$stday' AND time1<='$enday' AND loai='Chi phí' AND (" . $texttaikhoan . ") ORDER BY id DESC";
}
//echo '<br/>' . $chiTietGD;
$resultchiTietGD = mysqli_query($conn, $chiTietGD);
$arrchiTietGD = array();
while ($rowchiTietGD = mysqli_fetch_array($resultchiTietGD)) {
    $arrchiTietGD[] = $rowchiTietGD;
}
$count = 1;

foreach ($arrchiTietGD as $lt) {
    ?>
    <tr>
        <td><?php echo $count; ?></td>
        <td><?php echo $lt['id']; ?></td>
        <td><?php echo $lt['bank_sub_acc_id']; ?></td>
        <td><?php echo $lt['time1']; ?></td>
        <td><?php echo $lt['description1']; ?></td>
        <td><?php echo $lt['virtualAccount']; ?></td>
        <td>
    <?php
    if ($lt['amount'] < 0) {
        echo "Chi phí";
    } else {
        echo "Doanh thu";
    }
    ?>
        </td>
        <td><?php echo $lt['amount']; ?></td>
    </tr>
    <?php
    $count++;
}


?>
