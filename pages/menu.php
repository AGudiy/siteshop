<ul class="nav navbar-nav">
	<li <?php if ($_GET['page']==1){echo "class='active'"; } ?> >
		<a href="index.php?page=1">Catalog</a></li>
	<li <?php if ($_GET['page']==2){echo "class='active'"; } ?> >
		<a href="index.php?page=2">Cart</a></li>
	<li <?php if ($_GET['page']==3){echo "class='active'"; } ?> >
		<a href="index.php?page=3">Reg/Log</a></li>
	<li <?php if ($_GET['page']==4){echo "class='active'"; } ?> >
		<a href="index.php?page=4">Admin</a></li>
</ul>