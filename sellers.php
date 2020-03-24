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

<?php include 'connect_db.php';

if (isset($_POST['submit']))
{

				foreach (($_POST["id"]) AS $id)
				{
								$find2 = mysql_query("select * FROM seller where id='$id'");
								$newdata = mysql_fetch_array($find2);
								$seller_name = $_POST['seller_name'][$id];
								$comment = $_POST['comment'][$id];
								$location = $_POST['seller_location'][$id];
								$info = $_POST['seller_info'][$id];

								$unit_price = $subtotal / $quantity;
								$update = mysql_query("update seller set seller_name='$seller_name',seller_subtotal='$subtotal', seller_comment='$comment', seller_location='$location', seller_info='$info' where id='$id' LIMIT 1");
				}
				if ($update)
				{
								echo "<font color='green'>Seller is updated.</font>";
				}
				else
				{
								echo "<font color='red'>Process is not Succesfull!</font>";
				}

}
?>

<table border="0" cellspacing="5" cellpadding="5" style="text-align:left" border="2" >
  <tr>
<td></td>
    <td>Seller Name</td>
        <td>Seller Type</td>
    <td>Seller Location</td>
    <td>Seller Subtotal</td>
    <td>Seller İnfo</td>
    <td>Seller Comment</td>
  </tr>
<?php
$find = mysqli_query($baglan, "select * FROM seller");
if (mysqli_num_rows($find) > 0)
{
				while ($row = mysqli_fetch_assoc($find))
				{
								echo '<form action="" method="post">
 <tr>
<td><input type="checkbox" name="id[]" value="' . $row["seller_id"] . '"></input></td>
    <td> <input type="text" name="seller_name[]" value="' . $row["seller_name"] . '""></input></td>
	<td>' . $row['seller_type'] . '</td>
    <td><input type="text" name="location_name[]" value="' . $row["seller_location"] . '"></input></td></td>
    <td> ' . $row["seller_subtotal"] . ' €</td>
	 <td><textarea name="info[' . $row["seller_id"] . ']" value="' . $row['seller_info'] . '" rols="5" rows="3">' . $row['seller_info'] . '</textarea></td>	
	 <td><textarea name="comment[' . $row["seller_id"] . ']" value="' . $row['seller_comment'] . '" rols="3" rows="1">' . $row['seller_comment'] . '</textarea></td>	
  </tr>
';
				}
}
?>  
</table>
<table style="margin-left: 750px;">
<tr>
<td><input type="submit" name="submit" value="update"></td>
<td><a href="new_seller.php"><input type="button" value="Add New Seller"></a></td>
</tr>
  </table>
</form>



</div>
<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>
