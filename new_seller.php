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
      <li class='last'><a href="menu.php"><span>Menu</span></a></li>
</ul>
</div>



<div id="concent" >
<?php
include 'connect_db.php'; 

if ($_POST){
	$name = $_POST['seller_name'];
	$location = $_POST['seller_location'];
	$subtotal = $_POST['subtotal'];
	$info = $_POST['seller_info'];
	$comment = $_POST['comment'];
	$seller_type=$_POST['seller_type'];
	$find = mysqli_query($baglan,"select * FROM seller");
	while ($show = mysqli_fetch_array($find)){
	if($name == $show['seller_name']){
		$new_subtotal=$subtotal+$show['seller_subtotal'];


		
		$update=mysqli_query($baglan,"update purchase_stock set seller_subtotal='$new_subtotal' where item='$item'");
		if($update){ echo "<font color='green'>Product is Updated</font>";			}
			}
	}
		if(@!$update) {
		//veri ekle
		$add = mysqli_query($baglan,"insert into seller (seller_name,seller_type,seller_location,seller_subtotal,seller_info,seller_comment) values ('$name','$seller_type','$location','$subtotal','$info','$comment')");

		if ($add) { 
		echo "<font color='green'>Seller is Added</font>";
		}
			else
			{
			echo "<font color='red'>Process is not Successfull</font>";
			mysqli_error($add);
			}
		}



}

else {
	?>
    <h1>Add Seller</h1>
    <form action="" method="post">
   <table width="400" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>Name: </td>
    <td><input type="text" name="seller_name" /></td>
  </tr>
   <tr>
    <td>Seller Type: </td>
    <td><input type="radio" name="seller_type" value="grocery" checked>Grocery
    <input type="radio" name="seller_type" value="fabric" >Fabric
    <input type="radio" name="seller_type" value="material" >Material</td>
  </tr>
  <tr>
    <td>Subtotal: </td>
    <td><input type="text" name="subtotal" /></td>
  </tr>
    <tr>
    <td>Location: </td>
    <td><input type="text" name="seller_location" /></td>
  </tr>
    <tr>
    <td>Seller Info: </td>
    <td><textarea rows="4" cols="20" name="seller_info"></textarea></td>
  </tr>
  <tr>
    <td>Comment: </td>
    <td><textarea rows="4" cols="20" name="comment"></textarea></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" value="send"</td>
  </tr>
</table></form>
<?php }

?>
</div>


<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>