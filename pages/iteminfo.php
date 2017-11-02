<!DOCTYPE html>
<html>
<head>
	<title>Item info</title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/info.css">
</head>
<body>
	<?php
	include_once('classes.php');
	$itemid=$_GET['item'];
	$item=Item::fromDb($itemid);
	$title=$item->itemname;
	echo '<h1 class="title">'.$title.'</h1>';
	echo '<div style="width:70%; margin:auto;">';
	$item->carusel();
	echo '</div>';
?>	

  <script src="http://code.jquery.com/jquery-latest.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>
</html>