<!DOCTYPE html>
<html lang="en">

<head>

	<?php
 $identitas = parse_ini_file("identitas.txt");
 $nama = isset($identitas["nama"]) ? $identitas["nama"] : "";
 $nim = isset($identitas["nim"]) ? $identitas["nim"] : "";
 ?>
	<title><?php echo htmlspecialchars($nim); ?>-<?php echo htmlspecialchars(
    $nama,
); ?></title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<!-- Favicon icon -->
	<link rel="icon" href="assets/images/favicon.svg" type="image/x-icon">
	<!-- fontawesome icon -->
	<link rel="stylesheet" href="assets/fonts/fontawesome/css/fontawesome-all.min.css">
	<!-- animation css -->
	<link rel="stylesheet" href="assets/plugins/animation/css/animate.min.css">

	<!-- vendor css -->
	<link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	<?php include "section/navigation.php"; ?>
	<!-- [ navigation menu ] end -->

	<!-- [ Header ] start -->
	<?php include "section/header.php"; ?>
	<!-- [ Header ] end -->


    <?php
    //ambil parameter halaman yang akan di load dari $_GET['page']
    $page = isset($_GET["page"]) ? $_GET["page"] : "dashboard";
    //apakah ada karakter / jika tidak ada maka load index.php saja
    $loadFile =
        strpos($page, "/") !== false ? $page . ".php" : $page . "/index.php";

    if (file_exists($loadFile)) {
        include $loadFile;
    } else {
        include "dashboard/index.php";
    }
    ?>



<!-- Required Js -->
<script src="assets/js/vendor-all.min.js"></script>
<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/pcoded.min.js"></script>
<script src="assets/js/crud-helper.js"></script>

</body>

</html>
