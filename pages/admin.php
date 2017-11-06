<div class="container adm">
<div class="row">
	<script type="text/javascript">
		$(function(){
			$('#tabs').tabs()
		});
	</script>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Категории товаров</a></li>
		<li><a href="#tabs-2">Товары</a></li>
		<li><a href="#tabs-3">Картинки</a></li>
	</ul>


<div  id="tabs-1">
	  <form action='' method='post'>
			<label for="category">Введите категорию</label><br>
		<input type="text" name="category"><br><br>
		<input type='submit' name='addcat' class="btn btn-primary" value='Добавить категорию'>
		<input type='submit' name='delcat' value='Удалить'>
		<?php 
			if (isset($_POST['addcat'])) {
				$category=$_POST['category'];
				$cat=new Categories($category);
				$cat->intoDb();
				/*$ps=$pdo->prepare('insert into categories (category) value(?)');
				$data=array($category);
				$ps->execute($data);*/
			}
		?>
		<br><br>
	</form>
</div>

<div  id="tabs-2">
<form action="" method="post" enctype="multipart/form-data" >
<label for="catid">Category:</label>
<select class="inputreg" name="catid">
<?php
$pdo=Tools::connect();
$list=$pdo->query("SELECT * FROM Categories");
while ($row=$list->fetch())
{
 echo '<option value="'.$row['id'].'">'.$row['category'].
 '</option>';
}
?>
 </select>
 <div class="form-group">
 <label for="name">Name:</label>
 <input type="text" class="inputreg" name="name">
 </div>
 <div class="form-group">
 <label for="pricein">Incoming Price and Sale Price:</label>
 <div class="form-inline">
 <input type="number" class="price" name="pricein">
 <input type="number" class="price" name="pricesale">
 </div>
 </div>

 <div class="form-group">
 <label for="info">Description:</label>
 <div>
 	<textarea class="textarea" name="info" placeholder="info"></textarea>
 </div>
 </div>
 <div class="form-group">
 <label for="imagepath">Select image:</label>
 <input type="file" class="" name="imagepath">
 </div>
 <button type="submit" class="btn
 btn-primary"
 name="addbtn">Add Item</button>
<?php
if(isset($_POST['addbtn']))
{
	if(is_uploaded_file($_FILES['imagepath']['tmp_name']))
	 {
		 $path="images/".$_FILES['imagepath']['name'];
		 move_uploaded_file($_FILES['imagepath']['tmp_name'], $path);
	 }
	$catid=$_POST['catid'];
	$pricein=$_POST['pricein'];
	$pricesale=$_POST['pricesale'];
	$name=trim(htmlspecialchars($_POST['name']));
	$info=trim(htmlspecialchars($_POST['info']));
	$item=new Item($name,$catid,$pricein,$pricesale,$info,$path);
	$item->intoDb();
}
?>
</form>
</div>

<div  id="tabs-3">
	<form action="" method="post" enctype="multipart/form-data" >
	<label for="itemid">Item:</label>
	<select class="inputreg" name="itemid">
	<?php
	$pdo=Tools::connect();
	$list=$pdo->query("SELECT * FROM items");
	while ($row=$list->fetch())
	{
	 echo '<option value="'.$row['id'].'">'.$row['itemname'].
	 '</option>';
	}
	?>
	 </select>
	 <div class="form-group">
	 <label for="file">Select image:</label>
	 <input type="file" class="" name="file[]" multiple accept="image/*">
	 </div>
	 <button type="submit" class="btnbtn-primary"
	 name="addimg">Add Image</button>
	<?php
	if(isset($_POST['addimg']))
	{
		foreach($_FILES['file']['name'] as $k => $v)
		{
			if($_FILES['file']['error'][$k]!=0)
			{
				echo '<script>alert("Upload file error:'.$v.'")</script>';
				continue;
			}
			if(move_uploaded_file($_FILES['file']['tmp_name'][$k], 'images/'.$v))
			{
				$itemid=$_POST['itemid'];
				$imagepath="images/".$v;
				/*$ins='insert into images 
				(itemid, imagepath) 
				VALUES (?,?)';
				$pdo=Tools::connect();
				$ps=$pdo->prepare($ins);
				$ps->execute(array($itemid,$imagepath));
				*/
				$images=new Images($itemid,$imagepath);
				$images->intoDb();
				
			}
		}
	}
	?>
	</form>
</div>

</div>
</div>
</div>