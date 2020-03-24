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

if ($_POST)
{
				$item = $_POST['item'];
				$location = $_POST['location'];
				$status = $_POST['status'];
				$quantity = $_POST['quantity'];
				$type = $_POST['type'];
				$post_subtotal = $_POST['subtotal'];
				$subtotal = $_POST['subtotal'];
				$date = $_POST['date'];
				$comment = $_POST['comment'];
				$seller = $_POST['seller'];
				$pay_type = $_POST['pay_type'];
				$log_seller = mysqli_query($baglan, "SELECT * FROM seller WHERE seller_id='$seller'");
				$process_seller = mysqli_fetch_array($log_seller);
				$seller_name = $process_seller['seller_name'];
				$find = mysqli_query($baglan, "select * FROM purchase_stock");

				$find_account = mysqli_query($baglan, "select * from account");
				$show_account = mysqli_fetch_array($find_account);
				$new_cash = $show_account['cash'] - $_POST['subtotal'];
				if ($new_cash < 0)
				{
								echo "You dont have enough money in your cash account";
				}
				else
				{
								$update_capital = mysqli_query($baglan, "update account set cash='$new_cash'");

								while ($show = mysqli_fetch_array($find))
								{
												if ($item == $show['item'])
												{
																$quantity = $quantity + $show['quantity'];
																$subtotal = $subtotal + $show['subtotal'] + (($show['subtotal'] * 8) / 100);
																$unit_price = $subtotal / $quantity;

																$update = mysqli_query($baglan, "update purchase_stock set quantity='$quantity',subtotal='$subtotal', unit_price='$unit_price' where item='$item'");
																if ($update)
																{
																				echo "<font color='green'>Product is Updated</font>";
																}
												}
								}
								if (@!$update)
								{
												$unit_price = $subtotal / $quantity;
												$subtotal_tax = $_POST['subtotal'] + (($_POST['subtotal'] * 8) / 100);
												//veri ekle
												$add = mysqli_query($baglan, "insert into purchase_stock (item,seller_id,location,status,pay_type,quantity,type,unit_price,subtotal,date,comment) values ('$item','$seller','$location','$status','$pay_type','$quantity','$type','$unit_price','$subtotal_tax','$date','$comment')");

												$process_code = rand(1, 9999) . "out" . rand(1, 9999);
												$find_process_code = mysqli_query("SELECT * FROM process_log WHERE process_code LIKE '$process_code'");
												if ($find_process_code)
												{
																$process_code = rand(1, 9999) . "out" . rand(1, 9999);
												}
												else
												{
																$process_code = $process_code;
												}

												$log_item_name = $item . " " . $_POST['quantity'] . " " . $type . " " . $unit_price . "  " . $post_subtotal . " " . $pay_type . "->" . $seller_name . "/-/";

												if ($add)
												{

																$insert_log = mysqli_query($baglan, "insert into process_log (process,process_type,process_subtotal,process_code,process_date,process_detail) values ('purchase','outgoing','$post_subtotal','$process_code','$date','$log_item_name')");

																$new_subtotal = $process_seller['seller_subtotal'] + $subtotal;
																$update_seller = mysqli_query($baglan, "update seller set seller_subtotal='$new_subtotal' where seller_id='$seller' LIMIT 1");

																echo "<font color='green'>Product is Added</font>";
												}
												else
												{
																echo "<font color='red'>Process is not Successfull</font>";
												}
								}

				}
}

else
{
?>
    <h1>Add Product</h1>
    <form action="" method="post">
   <table width="200" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>İtem: </td>
    <td><input type="text" name="item" /></td>
  </tr>
  <tr>
    <td>Location: </td>
    <td><input type="radio" name="location" value="drystore" >Dry Storage
    <input type="radio" name="location" value="fridge" checked>Fridge +4
    <input type="radio" name="location" value="freezer" >Freeze -18</td>
  </tr>
  <tr>
    <td>Seller: </td>
    <td><select class="other" name="seller">
  <option selected>Chose One</option>
  <?php
				$find_seller = mysqli_query($baglan, "SELECT * FROM seller ");
				while ($row_seller = mysqli_fetch_array($find_seller))
				{
								print "<option value=" . $row_seller['seller_id'] . ">" . $row_seller['seller_name'] . "</option>";
				};
?>
  </select></td>
  </tr>
   <tr>
    <td>Status: </td>
    <td><input type="radio" name="status" value="paid" checked>Paid
    <input type="radio" name="status" value="bill">Bill</td>
  </tr>
   <tr>
    <td>Type: </td>
    <td><input type="radio" name="pay_type" value="cash" checked>cash	
    <input type="radio" name="pay_type" value="credit">credit
    <input type="radio" name="pay_type" value="cek">cek</td>
  </tr>
  <tr>
    <td>Quantity: </td>
    <td><input type="text" name="quantity" /></td>
  </tr>
  <tr>
    <td>Type: </td>
    <td><input type="radio" name="type" value="kg" checked>Kg
    <input type="radio" name="type" value="unit">Unit
    <input type="radio" name="type" value="lt">Lt</td>
  </tr>
  <tr>
    <td>Subtotal: </td>
    <td><input type="text" name="subtotal" /></td>
  </tr>
  <tr>
    <td>Date: </td>
    <td><input type="date" name="date"  value="<?php echo date('Y-m-d'); ?>"/></td>
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
<?php
}

?>
</div>


<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>
