<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Food truck</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="header">
<h1>Food Truck Virtual Cashier</h1>
<p><strong>Simple R2-D2 of Your Food Truck</strong></p>
</div>
<div id='cssmenu'>
<ul>
   <li><a href="../index.php"><span>Home Page</span></a></li>
   <li class='active has-sub'><a href="#"><span>Purchase</span></a>
      <ul>
         <li class='has-sub'><a href="purchase_current.php"><span>Current Purchase</span></a></li>
         <li class='has-sub'><a href="sellers.php"><span>Sellers</span></a></li>
      </ul>
   </li>
        <li class='active has-sub'><a href="#"><span>Bills</span></a>
      <ul>
         <li class='has-sub'><a href="bills.php"><span>Add Bills</span></a> </li>
         <li class='has-sub'><a href="bills_show.php"><span>Bills</span></a></li>
      </ul>
   </li>
     <li class='active has-sub'><a href="#"><span>Stocks</span></a>
      <ul>
         <li class='has-sub'><a href="stock.php"><span>Active Stocks</span></a> </li>
         <li class='has-sub'><a href="passive_stock.php"><span>Passive Stocks</span></a></li>
         
      </ul>
   </li>
            <li class='active has-sub'><a href="#"><span>Human Resources</span></a>
      <ul>
         <li class='has-sub'><a href="new_employe.php"><span>New Employe</span></a></li>
         <li class='has-sub'><a href="employe_archive.php"><span>Current Employes</span></a></li>
      </ul>
      </li>
     <li class='active has-sub'><a href="#"><span>Products</span></a>
      <ul>
         <li class='has-sub'><a href="productstock.php"><span>Product Stock</span></a></li>
         <li class='has-sub'><a href="newproduct.php"><span>New Products</span></a></li>
      </ul>
   </li>
      <li class='active has-sub'><a href="#"><span>Account</span></a>
      <ul>
         <li class='has-sub'><a href="my_account.php"><span>My Account</span></a></li>
      </ul>
   </li>
   <li class='last'><a href="aboutme.php"><span>About Me</span></a></li>
</ul>
</div>



<div id="concent" >
<?php 
include 'connect_db.php';

	
$id=@$_GET['id'];
if($_POST)
{

	$item = $_POST['item'];
	$location = $_POST['location'];
	$quantity = $_POST['quantity'];
	$type = $_POST['type'];
	$subtotal = $_POST['subtotal'];
	$date = $_POST['date'];
	$comment = $_POST['comment'];
$update = mysqli_query($baglan,"UPDATE purchase_stock SET item='$item', location='$location', quantity='$quantity', type='$type', subtotal='$subtotal', date='$date', comment='$comment' WHERE id='$id'");
if($update){
	echo '<font class="green">Updating is Succesfull</font>';
	header ("Refresh:4; url=../index.php?go=stock");
}

else
{ echo '<font color="red"> Proccess is not Succesfull'.mysqli_error().'</font>';

}
	
}
else {

$find = mysqli_query($baglan,"select * FROM purchase_stock WHERE id='$id'");
$show = mysqli_fetch_array($find);
extract ($show);

switch($location){
	case "drystore";
	$location1 = "checked";
	break;
	case "fridge";
	$location2 = "checked";
	break;
    default;
	$location3 = "checked";
	break;
}
switch($type){
	case "kg";
	$type1 = "checked";
	break;
	default;
	$type2 = "checked";
	break;
}
echo '<h1>Product Update</h1>
<form action="" method="post">

<table border="0" cellspacing="5" cellpadding="5" style="text-align:center">
  <tr>
    <td>Item</td>
	   <td> <input type="text" name="item" value="'.$item.'"/></td>
	   </tr>
	   <tr>
    <td>location</td> 
		<td><input type="radio" name="location" value="drystore" '.@$location1.'>Dry Storage
    	<input type="radio" name="location" value="fridge"  '.@$location2.'>Fridge +4
    	<input type="radio" name="location" value="freezer"  '.@$location3.' >Freeze -18</td>
		</tr><tr>
    <td>Quantity</td>
	    <td><input type="text" name="quantity" value="'.$quantity.'"  /></td></tr>
		<tr>
    <td>Type</td>
	    <td><input type="radio" name="type" value="'.$type.'"  '.@$type1.'>kg	
    <input type="radio" name="type" value="'.$type.'"  '.@$type2.'>unit</td></tr>
    <tr>
	<td>Subtotal</td>
	    <td><input type="text" name="subtotal" value="'.$subtotal.'"/> €</td></tr>
    <tr><td>Date</td>
		<td><input type="date" name="date" value="'.$date.'"/></td></tr>
    <tr><td>Comment</td>
	    <td><input type="comment" name="comment" value="'.$comment.'"></td></tr>
	<tr><td></td>
		<td><input type="submit" value="update"></td></tr>
  </tr>
	</tr>
	</table>
	</form>';
}	
?>

</div>
<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>


</body>
</html>