<?php
class Tools
{
	static function connect(
	 $host="localhost:3306",
	 $user="root",
	 $pass="AndGud/760247",
	 $dbname="shop1")
	{
		 $cs='mysql:host='.$host.';dbname='.$dbname.';charset=utf8;';
		 $options=array(
			 PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
			 PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
			 PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'
		 );
		 try {
			 $pdo=new PDO($cs,$user,$pass,$options);
			 return $pdo;
		 }
		 catch(PDOException $e)
		 {
		 echo $e->getMessage();
		 return false;
		 }
	}
	static function register($name,$pass1,$pass2,$imagepath)
	{
		$name=trim($name);
		$pass1=trim($pass1);
		$pass2=trim($pass2);
		$imagepath =trim($imagepath);
		if ($name=="" || $pass1=="" || $pass2=="")
		{
		 echo "<h3/><span style='color:red;'>
		 Fill All Required Fields!</span><h3/>";
		 return false;
		}
		if ($pass1!=$pass2){
			echo "<h3/><span style='color:red;'> pass1<>pass2</span><h3/>";
		 	return false;
		}
		if (strlen($name)<3 || strlen($name)>30 || strlen($pass1)<3 || strlen($pass1)>30)
		{
		 echo "<h3/><span style='color:red;'>Values Length Must Be Between 3 And 30!</span><h3/>";
		 return false;
		}
		Tools::connect();
		$pass=md5($pass1);
		$customer=new Customer($name,$pass,$imagepath);
		$err=$customer->intoDb();
		if ($err)
		{
			if($err==1062)
			echo "<h3/><span
			style='color:red;'>
			This Login Is Already Taken!</
			span><h3/>";
			else
			echo "<h3/><span
			style='color:red;'>
			Error code:".$err."!</span><h3/>";
			return false;
		}
		return true;
	}
}

class Customer
{
	protected $id; //user id
	protected $login;
	protected $pass;
	protected $roleid;
	protected $discount; //customer’s personal discount
	protected $total; //total ammount of purchases
	protected $imagepath; //path to the image
	function __construct($login,$pass,$imagepath,$id=0)
	{
		$this->login=$login;
		$this->pass=$pass;
		$this->imagepath=$imagepath;
		$this->id=$id;
		$this->total=0;
		$this->discount=0;
		$this->roleid=2;
	}
	function intoDb()
	{
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare("INSERT INTO Customers
				(login,pass,roleid,discount,total,imagepath,id)
				VALUES (?, ?, ?, ?, ?, ?, ?)");
			$ps->execute(array(
				$this->login,
				$this->pass,
				$this->roleid,
				$this->discount,
				$this->total,
				$this->imagepath,
				$this->id
			));
		}
		catch(PDOException $e)
		{
			$err=$e->getMessage();
			if(substr($err,0,strrpos($err,":"))=='SQLSTATE[23000]:Integrity constraint violation')
				return 1062;
			else
				return $e->getMessage();
		}
	}
	static function fromDb($id)
	{
		$customer=null;
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare("SELECT * FROM Customers WHERE id=?");
			$res=$ps->execute(array($id));
			$row=$res->fetch();
			$customer=new Customer($row['login'], $row['pass'], $row['imagepath'], $row['id']);
			return $customer;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}

	static function Login($login,$pass)
	{
		$login=trim($login);
		$pass=trim($pass);
		if ($login=="" || $pass==""){
			echo "<h3/><span style='color:red;'> Fill All Required Fields!</span><h3/>";
			return false;
		}
		$pass=md5($pass);
		$customer=null;
		try{	
			$pdo=Tools::connect();
			$ps=$pdo->prepare('select * from Customers where
			login=? and pass=?');
			$ps->execute(array($login, $pass));
			if($row=$ps->fetch()){
				$customer=new Customer($row['login'],$row['pass'], $row['imagepath'], $row['id']);
				$_SESSION['ruser']=$row['login'];
				if($row['roleid']==1){
				 	$_SESSION['radmin']=$login;
				 }
				 return $customer;
			}
			else
			{
				echo "<h3/><span style='color:red;'>No Such User!</span><h3/>";
				return false;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}
}

class Item
{
	public $id, $itemname, $catid, $pricein,
	$pricesale, $info, $rate,
	$imagepath, $action;

	function __construct($itemname, $catid,
	$pricein, $pricesale, $info,
	$imagepath, $rate=0, $action=0, $id=0)
	{
		$this->id=$id;
		$this->itemname=$itemname;
		$this->catid=$catid;
		$this->pricein=$pricein;
		$this->pricesale=$pricesale;
		$this->info=$info;
		$this->rate=$rate;
		$this->imagepath=$imagepath;
		$this->action=$action;
	}

	function intoDb()
	{
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare("INSERT INTO Items
			(id, itemname, catid, pricein,
			pricesale, info, rate,
			imagepath, action)
			VALUES (?,?,?,?,?,?,?,?,?)");
			$ps->execute(array(
				$this->id, 
				$this->itemname, 
				$this->catid, 
				$this->pricein, 
				$this->pricesale, 
				$this->info,  
				$this->rate, 
				$this->imagepath, 
				$this->action
			));
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}

	static function fromDb($id)
	{
		$item=null;
		try{
		$pdo=Tools::connect();
		$ps=$pdo->prepare("SELECT * FROM Items WHERE id=?");
		$ps->execute(array($id));
		$row=$ps->fetch();
		$item=new Item($row['itemname'], $row['catid'], $row['pricein'], $row['pricesale'], $row['info'], $row['imagepath'], $row['rate'], $row['action'],$row['id']);
		return $item;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}
	}
	static function GetItems($catid=0)
	{
		$ps=null;
		$items=null;
		try{
			$pdo=Tools::connect();
			if($catid == 0)
			{
				$ps=$pdo->prepare('select * from items');
				$ps->execute();
			}
			else
			{
				$ps=$pdo->prepare
				('select * from items where catid=?');
				$ps->execute(array($catid));
			}
		while ($row=$ps->fetch())
		{
			$item=new Item($row['itemname'],
			$row['catid'],
			$row['pricein'],
			$row['pricesale'], $row['info'],
			$row['imagepath'], $row['rate'],
			$row['action'],$row['id']);
			$items[]=$item;
		}
		return $items;
		}
		catch(PDOException $e)
		{
		echo $e->getMessage();
		return false;
		}
	}

	function Draw(){
		echo "<div class='col-sm-3 col-md-3 col-lg-3' style='height:300px'>";
		echo "<h3 style='color:blue;'><a href='pages/iteminfo.php?item=".$this->id."' target='_blank'>".$this->itemname."</a></h3>";
		echo "<div><img src='".$this->imagepath."' height='100px' style='max-width:150px'>".
			"<span class='pull-center iprice' style='font-size:18pt; color:red;'>".$this->pricesale."₴</span></div>";
		echo "<div style='overflow:hidden;height:45px; width:90%;'>".$this->info."</div>";

		echo "<div class='row' style='margin-top:2px;'>";
		//creating cookies for the cart
		//will be explained later
		$ruser='';
		if(!isset($_SESSION['ruser']) || $_SESSION['ruser']=="")
		{
		 $ruser="cart_".$this->id;
		}
		else
		{
		 $ruser=$_SESSION['ruser']."_".$this->id;
		}
		echo "<button class='btn btn-success btn-lg'
		onclick=createCookie('".$ruser."','".$this->id."')>Add To My Cart</button>";
		echo "</div>";
		echo "</div>";
	}
	function DrawForCart()
	{
		echo "<div class='row' style='margin:2px;'>";
		echo "<img src='".$this->imagepath."'  width='70px' class='col-sm-1 col-md-1 col-lg-1'/>";
		echo "<span style='margin-right:10px;background-color:#ddeeaa; color:blue;font-size:16pt' class='col-sm-3 col-md-3 col-lg-3'>";
		echo $this->itemname;
		echo "</span>";
		echo "<span style='margin-left:10px;color:red;font-size:16pt;background-color:#ddeeaa;' class='col-sm-2 col-md-2 col-lg-2' >";
		echo "&nbsp;".$this->pricesale;
		echo " ₴</span>";
		$ruser='';
		if(!isset($_SESSION['ruser']) || $_SESSION['ruser']=="")
		{
			 $ruser="cart_".$this->id;
		}
		else
		{
			 $ruser=$_SESSION['ruser']."_".$this->id;
		}

		echo "<button class='btn btn-sm btn-danger'nstyle='margin-left:10px;' onclick=eraseCookie('".$ruser."')>x</button>";
		echo "</div>";
	}

	function Sale()
	{
		try{
			$pdo=Tools::connect();
			$ruser='cart';
			if(isset($_SESSION['ruser']) && $_SESSION['ruser'] !="")
			{
				$ruser=$_SESSION['ruser'];
			}
			//Incresing total field for Customer
			$sql = "UPDATE Customers SET total=total + ?
			WHERE login = ?";
			$ps = $pdo->prepare($sql);
			$ps->execute(array($this->pricesale,$ruser));
			//Inserting info about sold item into table Sales
			$ins = "insert into Sales
			(customername,itemname,pricein,pricesale,datesale)
			values(?,?,?,?,?)";
			$ps = $pdo->prepare($ins);
			$ps->execute(array($ruser,$this->itemname, $this->pricein,$this->pricesale,@date("Y/m/d H:i:s")));
			//deleting item from Items table
			$del = "DELETE FROM Items WHERE id = ?";
			$ps = $pdo->prepare($del);
			$ps->execute(array($this->id));
		}
		catch(PDOException $e)
		{
		 echo $e->getMessage();
		 return false;
		}
	}
	function carusel()
	{
		$pdo=Tools::connect();
		$sel='select imagepath from images where itemid=?';
		$ps=$pdo->prepare($sel);
		$ps->execute(array($this->id));
		echo '<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">';
	    echo '<div class="carousel-inner" role="listbox" >';
		$i=0;
		while($row=$ps->fetch()){
			if ($i==0) $active="active"; else $active="";
			echo '<div class="item '.$active.'" id="carusel"><img src="../'.$row['imagepath'].'" alt="..." width="100%"></div>';
			$i++;
		}  
		echo '</div>';
		//Controls
		echo'<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">';
	    echo'<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
	    echo '<span class="sr-only">Previous</span> </a>';
	    echo '<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
	    		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>	
	    		<span class="sr-only">Next</span></a>';
	    echo '</div>';
	    echo '</div>';	
	}
}

Class Images
{
	protected $id;
	protected $itemid;
	protected $imagepath;
	function __construct($itemid, $imagepath, $id=0)
	{
		$this->id=$id;
		$this->itemid=$itemid;
		$this->imagepath=$imagepath;
	}
	function intoDb()
	{
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare("INSERT INTO Images 
				(itemid, imagepath) 
				VALUES (?,?)");
			$ps->execute(array(
				$this->itemid,
				$this->imagepath
			));
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
	static function fromDb($id)
	{
		$images=null;
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare('select * from images where id=?');
			$ps->execute(array($itemid));
			$row=$ps->fetch();
			$images=new Images($row['id'],$row['itemid'],$row['imagepath']);
			return $images;
		}
		catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}
	}
}

Class Categories
{
	protected $id;
	protected $category;
	function __construct($category,$id=0)
	{
		$this->id=$id;
		$this->category=$category;
	}
	function intoDb()
	{
		try{
			$pdo=Tools::connect();
			$ps=$pdo->prepare('insert into categories (category) value(?)');
				$data=array($this->category);
				$ps->execute($data);
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}
	}
}