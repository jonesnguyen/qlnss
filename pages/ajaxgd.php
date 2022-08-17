<?php
// connect database
require_once '../config.php';
$taikhoan = $_POST['taiKhoan'];
$texttaikhoan = "";
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
$doanhthu = $loinhuan = $chiphi = 0;
//doanh thu
$Dthu = "SELECT SUM(amount) as soluong FROM thu_chi WHERE time1>='$stday' AND time1<='$enday' AND amount>0";
$resultDthu = mysqli_query($conn, $Dthu);
$rowDthu = mysqli_fetch_array($resultDthu);
$tongDthu = $rowDthu['soluong'];
//ket thu
//ketthuc
//Chi phi
$Cp = "SELECT SUM(amount) as soluong FROM thu_chi WHERE time1>='$stday' AND time1<='$enday' AND amount<0";
$resultCp = mysqli_query($conn, $Cp);
$rowCp = mysqli_fetch_array($resultCp);
$tongCp = $rowCp['soluong'];
//ketthuc
?>
<div class="row">
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?php echo number_format($tongDthu).'đ'; ?></h3>
                <p>Doanh thu</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="return false;">Từ ngày <?php echo $stday; ?> - <?php echo $enday; ?><i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo number_format($tongCp).'đ'; ?></h3>
                <p>Chi phí</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="return false;">Từ ngày <?php echo $stday; ?> - <?php echo $enday; ?><i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo number_format(($tongDthu + $tongCp)).'đ'; ?></h3>
                <p>Lợi nhuận</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer" onclick="return false;">Từ ngày <?php echo $stday; ?> - <?php echo $enday; ?><i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<?php


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
?>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table id="toanbogd1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã GD</th>
                        <th>STK</th>
                        <th>Ngày GD</th>
                        <th>Nội dung GD</th>
                        <th>Đối tác</th>
                        <th>Loại</th>
                        <th>Giá trị</th>
                    </tr>
                </thead>
                <tbody id="noidungGD">
                    <?php
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
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.box-body -->
</div>