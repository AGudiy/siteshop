<?php 
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Site Shop</title>
	<meta charset="utf-8">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.12.3.min.js"></script>
</head>
<body>
<?php 
include_once('pages/classes.php');
?>

<nav class="navbar navbar-inverse">
	<?php 
	include_once('pages/menu.php');
	?>
</nav>


<section>
	<?php
	if(isset($_GET['page'])){
		$page=$_GET['page'];
		if($page==1) include_once('pages/catalog.php');
		if($page==2) include_once('pages/cart.php');
		if($page==3) include_once('pages/reglog.php');
		if($page==4) include_once('pages/admin.php');
	}
	?>
</section>
<script type="text/javascript" src="js/jquery-ui.js"></script>
</body>
</html>