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
				$new_current_capital = 0;
				$find_account = mysqli_query($baglan, "select * from account");
				$show_account = mysqli_fetch_array($find_account);
				foreach ((@$_POST["id"]) AS $id)
				{
								$find2 = mysqli_query($baglan, "select * FROM passive_item where id='$id'");
								$newdata = mysqli_fetch_array($find2);
								$quantity = $_POST['quantity'][$id] + $newdata['quantity'];
								$subtotal = $_POST['subtotal'][$id] + $newdata['subtotal'];
								$purchase_date = $_POST['p_date'][$id];
								$end_date = $_POST['e_date'][$id];
								$comment = $_POST['comment'][$id];
								$days = (strtotime($end_date) - strtotime($purchase_date)) / (60 * 60 * 24);
								// echo $days=$days+1;
								$per_unit = $subtotal / $quantity;
								$per_day = $per_unit / $days;
								round($per_day, 2);

								$new_current_capital = $show_account['current_capital'] - $_POST['subtotal'][$id];
								if ($new_current_capital < 0)
								{
												echo "You dont have enough money in your capital account.<br />";
								}
								else
								{
												$update_capital = mysqli_query($baglan, "update account set current_capital='$new_current_capital'");
												echo "Account is updated.<br />";

												$update = mysqli_query($baglan, "update passive_item set quantity='$quantity',subtotal='$subtotal', per_day='$per_day', p_date='$purchase_date', e_date='$end_date',comment='$comment' where id='$id' LIMIT 1");
								}
								if (@$update)
								{
												echo "<font color='green'>Item is Updated.</font>";
								}
								else
								{
												echo "<font color='red'>Process is not Succesfull!</font>";
								}
				}

}
?>

<table border="0" cellspacing="5" cellpadding="5" style="text-align:center" width="100%" >
<tr>
<td>Active Items</td>
</tr>
  <tr>
<td colspan="2">Item</td>

    <td>location</td>
    <td>Per Day Price</td>
    <td>Quantity</td>
    <td>Subtotal</td>
    <td>Status</td>
    <td>Seller Name</td>
    <td>Purchase Date</td>
    <td>End Date</td>
    <td>Comment</td>
  </tr>

<?php

$find_active = mysqli_query($baglan, "select * FROM passive_item WHERE mobility LIKE 'active'");
$find_seller = mysqli_query($baglan, "select * FROM seller, purchase_stock WHERE purchase_stock.seller_id=seller.seller_id");
if (mysqli_num_rows($find_active) > 0)
{
				while ($row_active = mysqli_fetch_assoc($find_active))
				{
								$row_seller = mysqli_fetch_array($find_seller);
								echo '<form action="" method="post">
 <tr>
<td><input type="checkbox" name="id[]" value="' . $row_active["id"] . '"></input></td>
    <td> ' . $row_active["item"] . '</td>
    <td> ' . $row_active["location"] . ' </td>
    <td> ' . $row_active["per_day"] . ' </td>
    <td>' . $row_active['quantity'] . ' <input type="text" name="quantity[' . $row_active["id"] . ']" size="5"/></td>
    <td>' . $row_active['subtotal'] . '€ <input type="text" name="subtotal[' . $row_active["id"] . ']" size="5" /></td>
    <td> ' . $row_active["status"] . ' </td>
	<td>' . $row_seller['seller_name'] . '</td>
	
	<td><input type="date" name="p_date[' . $row_active["id"] . ']" value="' . $row_active['p_date'] . '"/></td>
	<td><input type="date" name="e_date[' . $row_active["id"] . ']" value="' . $row_active['e_date'] . '"/></td>
</td>
    <td><textarea name="comment[' . $row_active["id"] . ']" value="' . $row_active['comment'] . '" rols="2" rows="1">' . $row_active['comment'] . '</textarea>
</td>
	
  </tr>
';
				}
}
?>  
</table>
<table border="0" cellspacing="5" cellpadding="5" style="text-align:center" width="100%" >
<tr>
<td>Passive Items</td>
</tr>
  <tr>
<td colspan="2">Item</td>

    <td>location</td>
    <td>Per Day Price</td>
    <td>Quantity</td>
    <td>Subtotal</td>
    <td>Status</td>
    <td>Seller Name</td>
    <td>Purchase Date</td>
    <td>End Date</td>
    <td>Comment</td>
  </tr>

<?php

$find_active = mysqli_query($baglan, "select * FROM passive_item WHERE mobility LIKE 'passive'");
$find_seller = mysqli_query($baglan, "select * FROM seller, purchase_stock WHERE purchase_stock.seller_id=seller.seller_id");
if (mysqli_num_rows($find_active) > 0)
{
				while ($row_active = mysqli_fetch_assoc($find_active))
				{
								$row_seller = mysqli_fetch_array($find_seller);
								echo '<form action="" method="post">
 <tr>
<td><input type="checkbox" name="id[]" value="' . $row_active["id"] . '"></input></td>
    <td> ' . $row_active["item"] . '</td>
    <td> ' . $row_active["location"] . ' </td>
    <td> ' . $row_active["per_day"] . ' </td>
    <td>' . $row_active['quantity'] . ' <input type="text" name="quantity[' . $row_active["id"] . ']" size="5"/></td>
    <td>' . $row_active['subtotal'] . '€ <input type="text" name="subtotal[' . $row_active["id"] . ']" size="5" /></td>
    <td> ' . $row_active["status"] . ' </td>
	<td>' . $row_seller['seller_name'] . '</td>
	
	<td><input type="date" name="p_date[' . $row_active["id"] . ']" value="' . $row_active['p_date'] . '"/></td>
	<td><input type="date" name="e_date[' . $row_active["id"] . ']" value="' . $row_active['e_date'] . '"/></td>
    <td><textarea name="comment[' . $row_active["id"] . ']" value="' . $row_active['comment'] . '" rols="2" rows="1">' . $row_active['comment'] . '</textarea>
</td>
	
  </tr>
';
				}
}
?>  
</table>

<table style="margin-left: 900px;">
<tr>
<td>
<input type="submit" name="submit" value="update"></td>
<td><a href="passive_purchase.php"><input type="button" value="Add New Item"></a>
<a href="passive_stock_list.php"><input type="button" value="  List  "></a></td>
</tr>
  </table>
</form>

</div>
<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>
