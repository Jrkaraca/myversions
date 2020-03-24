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
<p><strong>Own R2-D2 in Your Food Truck</strong></p>
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
$table_id=@$_GET['id'];

$id_array=array();
$quantity_array=array();
$table_products=array();
$table_product_quantities=array();
 $find_table = mysqli_query($baglan,"select * FROM tables where table_id=$table_id ");
$show_table = mysqli_fetch_array($find_table);
	


$table_products=explode(",",$show_table['table_products']);
$table_product_quantities=explode(",",$show_table['table_quantities']);
$table_products_count=count($table_products);

if (isset($_POST['submit'])){
	
		for ($c=1; $c<$table_products_count; $c++)
{
	if($table_products[$c]==$_POST["id"]){
	array_push($id_array,$table_products[$c]);
	$quantity_add=$table_product_quantities[$c]+$_POST['quantity'][$id];
	array_push($quantity_array,$quantity_add);		
	}

}
		

foreach (($_POST["id"]) AS $id){
$find_newdata = mysqli_query($baglan,"select * FROM products where product_id='$id'");
$newdata = mysqli_fetch_array($find_newdata);

if(@$table_products[$id]!=$id){
array_push($table_products,$newdata['product_id']);
	array_push($table_product_quantities,$_POST['quantity'][$id]);
}
}


	$id_last_array=implode(",",$table_products);
$quantity_last_array=implode(",",$table_product_quantities);

$update=mysqli_query($baglan,"update tables set table_products='$id_last_array',table_quantities='$quantity_last_array',table_status='1' where table_id='$table_id' LIMIT 1");

}

?>

<table width="40%" border="0" cellspacing="1" cellpadding="1">
  <tr>
      <td>&nbsp;</td>
    <td>Product Name</td>
    <td>Quantity</td>
        <td>Menu Price</td>
  </tr>
<?php 
  
 $find_product = mysqli_query($baglan,"select * FROM products");
while ($row = mysqli_fetch_assoc($find_product)){
      echo '<form action="" method="post" enctype="multipart/form-data">
 <tr>
<td><input type="checkbox" name="id[]" value="'.$row["product_id"].'"></input></td>
    <td> '.$row["name"].'</td>
    <td><input type="text" name="quantity['.$row["product_id"].']" /></td>
    <td> '.$row["menu_price"].' </td>

	
  </tr>';
	
}
	?>

  <tr>
      <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td><input type="submit" name="submit" value="Add" /></a></td>
  </tr>
</table>
</form>


</div>


<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>