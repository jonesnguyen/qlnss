<?php

// create session
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
	// include file
	include '../layouts/header.php';
	include '../layouts/topbar.php';
	include '../layouts/sidebar.php';

	// dem so luong nhan vien
	$nv = "SELECT count(id) as soluong FROM nhanvien";
	$resultNV = mysqli_query($conn, $nv);
	$rowNV = mysqli_fetch_array($resultNV);
	$tongNV = $rowNV['soluong'];

	// dem so luong nhan vien nghỉ việc
	$nghiViec = "SELECT count(id) as soluong FROM nhanvien WHERE trang_thai = 0";
	$resultNghiViec = mysqli_query($conn, $nghiViec);
	$rowNghiViec = mysqli_fetch_array($resultNghiViec);
	$tongNghiViec = $rowNghiViec['soluong'];

	// dem so phong ban
	$pb = "SELECT count(id) as soluong FROM phong_ban";
	$resultPB = mysqli_query($conn, $pb);
	$rowPB = mysqli_fetch_array($resultPB);
	$tongPB = $rowPB['soluong'];

	// dem so phong ban
	$tk = "SELECT count(id) as soluong FROM tai_khoan";
	$resultTK = mysqli_query($conn, $tk);
	$rowTK = mysqli_fetch_array($resultTK);
	$tongTK = $rowTK['soluong'];

	// danh sach phong ban
	$phongBan = "SELECT ma_phong_ban, ten_phong_ban, ngay_tao FROM phong_ban ORDER BY id DESC";
	$resultPhongBan = mysqli_query($conn, $phongBan);
	$arrPhongBan = array();
	while ($rowPhongBan = mysqli_fetch_array($resultPhongBan)) {
		$arrPhongBan[] = $rowPhongBan;
	}

	// danh sach chuc vu
	$chucVu = "SELECT ma_chuc_vu, ten_chuc_vu, ngay_tao FROM chuc_vu ORDER BY id DESC";
	$resultChucVu = mysqli_query($conn, $chucVu);
	$arrChucVu = array();
	while ($rowChucVu = mysqli_fetch_array($resultChucVu)) {
		$arrChucVu[] = $rowChucVu;
	}

	// danh sach luong nhan vien thang hien tai
	$thangLuongHienTai = date_format(date_create(date("Y-m-d H:i:s")), "m/Y");
	$thangHienTai = date_format(date_create(date("Y-m-d H:i:s")), "m");
	$namHienTai = date_format(date_create(date("Y-m-d H:i:s")), "Y");
	$luongThang = "SELECT ma_luong, hinh_anh, ten_nv, gioi_tinh, ngay_sinh, luong_thang, ngay_cong, khoan_nop, thuc_lanh, trang_thai from luong l, nhanvien nv WHERE l.nhanvien_id = nv.id AND year(ngay_cham) = '$namHienTai' AND month(ngay_cham) = '$thangHienTai' ORDER BY l.id DESC";
	$resultLuongThang = mysqli_query($conn, $luongThang);
	$arrLuongThang = array();
	while ($rowLuongThang = mysqli_fetch_array($resultLuongThang)) {
		$arrLuongThang[] = $rowLuongThang;
	}
	// danh sach chi tiet toan bo giao dich
	$chiTietGD = "SELECT id, time1, bank_sub_acc_id, description1, loai, amount, virtualAccount FROM thu_chi ORDER BY id DESC";
	$resultchiTietGD = mysqli_query($conn, $chiTietGD);
	$arrchiTietGD = array();
	while ($rowchiTietGD = mysqli_fetch_array($resultchiTietGD)) {
		$arrchiTietGD[] = $rowchiTietGD;
	}

?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">

		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Tổng quan
				<small>Quản lý nhân sự tại công ty TNHH Vạn Thành Vi Na</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Tổng quan</a></li>
				<li class="active">Thống kê</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<!-- ./col -->
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3>EXCEL</h3>
							<p>Xuất báo cáo</p>
						</div>
						<div class="icon">
							<i class="fa fa-file"></i>
						</div>
						<a href="export-nhan-vien.php" class="small-box-footer">Danh sách nhân viên <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3>EXCEL</h3>
							<p>Xuất báo cáo</p>
						</div>
						<div class="icon">
							<i class="fa fa-file"></i>
						</div>
						<a href="export-bang-luong.php" class="small-box-footer">Lương nhân viên <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
			<form action="" method="POST">
				<div class="row">
					<!-- Danh sach chi tiet toan bo luong -->
					<div class="col-lg-12">
						<div class="box">
							<div class="col-sm-4">
								<label>Tài khoản:</label>
								<select id="Alltaikhoan" class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Select a State" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
									<option data-select2-id="29" value="104876503702">104876503702</option>
									<option data-select2-id="30" value="34234">34234</option>
									<option data-select2-id="31" value="104876503702">88888888</option>
									<option data-select2-id="32" value="104876503702">104876503702</option>
								</select>

							</div>
							<!-- Thoi gian -->
							<div class="col-sm-4">
								<label>Từ ngày</label>
								<input type="date" id="stday" value="Từ ngày" min="2022-01-01" max="2050-01-01">
								<label>Đến ngày</label>
								<input type="date" id="enday" value="Đến ngày" min="2022-01-01" max="2050-01-01">

							</div>
							<div class="col-sm-4">
								<label>Loại</label>
								<select id="loai" class="form-control">
									<option>Tất cả</option>
									<option>Doanh thu</option>
									<option>Chi phí</option>
								</select>
							</div>

						</div>
					</div>
					<div class="col-lg-12">
						<div class="col-sm-4"></div>
						<div class="col-sm-4">

							<button type="button" class="btn btn-block btn-danger" id="loc">
								<i class="fa fa-fw fa-filter"></i>
								Lọc
							</button>
						</div>
						<div class="col-sm-4"></div>
					</div>
				</div>
			</form>
			<!-- Main row -->
			<div class="row">
				<!-- Danh sach chi tiet toan bo luong -->
				<div class="col-lg-12" id="danhsachgd">
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
					<!-- /.box -->
				</div>
				<!-- Ket thuc chi tiet tien luong -->
				<div class="col-lg-6">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Danh sách phòng ban</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">
								<table id="example2" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>STT</th>
											<th>Mã Phòng</th>
											<th>Tên phòng</th>
											<th>Ngày tạo</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										foreach ($arrPhongBan as $pb) {
										?>
											<tr>
												<td><?php echo $count; ?></td>
												<td><?php echo $pb['ma_phong_ban']; ?></td>
												<td><?php echo $pb['ten_phong_ban']; ?></td>
												<td><?php echo $pb['ngay_tao']; ?></td>
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
					<!-- /.box -->
				</div>
				<!-- col-lg-6 -->
				<div class="col-lg-6">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Danh sách chức vụ</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">
								<table id="example3" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>STT</th>
											<th>Mã chức vụ</th>
											<th>Tên chức vụ</th>
											<th>Ngày tạo</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										foreach ($arrChucVu as $cv) {
										?>
											<tr>
												<td><?php echo $count; ?></td>
												<td><?php echo $cv['ma_chuc_vu']; ?></td>
												<td><?php echo $cv['ten_chuc_vu']; ?></td>
												<td><?php echo $cv['ngay_tao']; ?></td>
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
					<!-- /.box -->
				</div>
				<!-- col-lg-6 -->
				<div class="col-lg-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">Danh sách lương tháng: <?php echo $thangLuongHienTai; ?></h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">
								<table id="example4" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>STT</th>
											<th>Mã nhân viên</th>
											<th>Ảnh</th>
											<th>Tên nhân viên</th>
											<th>Giới tính</th>
											<th>Lương tháng</th>
											<th>Ngày công</th>
											<th>Khoản nộp</th>
											<th>Thực lãnh</th>
											<th>Trạng thái</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										foreach ($arrLuongThang as $lt) {
										?>
											<tr>
												<td><?php echo $count; ?></td>
												<td><?php echo $lt['ma_luong']; ?></td>
												<td><img src="../uploads/staffs/<?php echo $lt['hinh_anh']; ?>" width="80"></td>
												<td><?php echo $lt['ten_nv']; ?></td>
												<td>
													<?php
													if ($lt['gioi_tinh'] == 1) {
														echo "Nam";
													} else {
														echo "Nữ";
													}
													?>
												</td>
												<td><?php echo number_format($lt['luong_thang']) . "vnđ"; ?></td>
												<td><?php echo $lt['ngay_cong']; ?></td>
												<td><?php echo "<span style='color: red; font-weight: bold;'>" . number_format($lt['khoan_nop']) . "vnđ </span>"; ?></td>
												<td><?php echo "<span style='color: blue; font-weight: bold;'>" . number_format($lt['thuc_lanh']) . "vnđ </span>"; ?></td>
												<td>
													<?php
													if ($lt['trang_thai'] == 1) {
														echo '<span class="badge bg-blue"> Đang làm việc </span>';
													} else {
														echo '<span class="badge bg-red"> Đã nghỉ việc </span>';
													}
													?>
												</td>
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
					<!-- /.box -->
				</div>
				<!-- col-lg-12 -->
			</div>
			<!-- /.row (main row) -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
<?php
	// include
	include '../layouts/footer.php';
} else {
	// go to pages login
	header('Location: dang-nhap.php');
}

?>