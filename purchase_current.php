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
<H3>NOTE: To use this page: if you would like to update product, you should click checkbox otherwise it will not update. This burocrasy exist to avoid update every product. Wich will be updated.</H3>
<?php include 'connect_db.php';
$log_item = array();
$process_subtotal = 0;
$new_cash_subtotal = 0;
if (isset($_POST['submit']))
{

				foreach(($_POST["id"]) AS $id)
				{
								$find_newdata = mysqli_query($baglan, "SELECT * FROM purchase_stock where id='$id'");
								$newdata = mysqli_fetch_array($find_newdata);
								$seller_id = $newdata['seller_id'];

								$pay_type = $_POST['pay_type'][$id];
								$quantity = $_POST['quantity'][$id] + $newdata['quantity'];
								$subtotal = $_POST['subtotal'][$id] + $newdata['subtotal'] + (($_POST['subtotal'][$id] * 8) / 100);
								$new_cash_subtotal = $new_cash_subtotal + $_POST['subtotal'][$id];
								$date = date('Y-m-d');
								$comment = $_POST['comment'][$id];

								$unit_price = $subtotal / $quantity;
								$log_u_p = $_POST['subtotal'][$id] / $_POST['quantity'][$id];
								$process_unit_price = number_format($log_u_p, 2);
								$find_seller = mysqli_query($baglan, "select * FROM seller where seller_id='$seller_id' ");
								$newdata_seller = mysqli_fetch_array($find_seller);

								$new_subtotal = $newdata_seller['seller_subtotal'] + $_POST['subtotal'][$id];
								$update_seller = mysqli_query($baglan, "update seller set seller_subtotal='$new_subtotal' where seller_id='$seller_id' LIMIT 1");

								$log_item_name = $newdata['item'] . " " . $_POST['quantity'][$id] . " " . $newdata['type'] . " " . $process_unit_price . "  " . $_POST['subtotal'][$id] . " " . $pay_type . "->" . $newdata_seller['seller_name'] . "/-/";
								$process_subtotal = ($process_subtotal + $_POST['subtotal'][$id]);
								array_push($log_item, $log_item_name);

								$update = mysqli_query($baglan, "update purchase_stock set quantity='$quantity',subtotal='$subtotal', unit_price='$unit_price', date='$date',comment='$comment', pay_type='$pay_type' where id='$id' LIMIT 1");
				}
				$log_item_array = implode("/-/", $log_item);
				$process_code = rand(1, 9999) . "out" . rand(1, 9999);
				$find_process_code = mysqli_query($baglan, "SELECT * FROM process_log WHERE process_code LIKE '$process_code'");
				if ($find_process_code)
				{
								$process_code = rand(1, 9999) . "out" . rand(1, 9999);
				}
				else
				{
								$process_code = $process_code;
				}
				$process_date = date('Y-m-d');
				if ($update)
				{
								echo "<font color='green'>Product is Updated.</font>";
								$insert_log = mysqli_query($baglan, "insert into process_log (process,process_type,process_subtotal,process_code,process_date,process_detail) values ('purchase','outgoing','$process_subtotal','$process_code','$process_date','$log_item_array')");

								$find_account = mysqli_query($baglan, "select * from account");
								$show_account = mysqli_fetch_array($find_account);
								$new_cash = $show_account['cash'] - $new_cash_subtotal;
								if ($new_cash < 0)
								{
												echo "You dont have enough money in your cash account.<br />";
								}
								else
								{
												$update_capital = mysqli_query($baglan,"update account set cash='$new_cash'");
												echo "Account is updated.<br />";
								}

				}
				else
				{
								echo "<font color='red'>Process is not Succesfull!</font>";
				}

}
?>

<table border="0" cellspacing="5" cellpadding="5" style="text-align:left ; text-transform:capitalize" border="2" >
  <tr>
<td></td>
    <td>Item</td>
    <td>location</td>
    <td>Unit Price</td>
    <td>Quantity</td>
    <td>Type</td>
    <td>Subtotal</td>
    <td>Pay Type</td>
    <td>Seller</td>
    <td>Date</td>
    <td>Comment</td>
  </tr>

<?php

$find = mysqli_query($baglan, "select * FROM purchase_stock ORDER BY item ASC");
$find_seller = mysqli_query($baglan, "select * FROM seller, purchase_stock WHERE purchase_stock.seller_id=seller.seller_id");
if (mysqli_num_rows($find) > 0)
{
				while ($row = mysqli_fetch_assoc($find))
				{

								//$purchase_id=$row['id'];
								//	$purchase_subtotal_withouttax=$row['unit_price']*$row['quantity'];
								//	$purchase_subtotal=($purchase_subtotal_withouttax+(($purchase_subtotal_withouttax/100)*8));
								//	$update_purchaces=mysqli_query("update purchase_stock set subtotal='$purchase_subtotal' where id='$purchase_id' LIMIT 1");
								switch ($row['pay_type'])
								{
												case "cash":
																$pay_type_option = '<option value=' . $row['pay_type'] . ' selected>Cash</option>
  		<option value="credit">Credit</option>
  		<option value="cek">Cek</option>';
												break;
												case "credit":
																$pay_type_option = '<option value=' . $row['pay_type'] . ' selected>Credit</option>
  		<option value="cash">Cash</option>
  		<option value="cek">Cek</option>';
												break;
												case "cek":
																$pay_type_option = '<option value=' . $row['pay_type'] . ' selected>Cek</option>
  		<option value="credit">Credit</option>
  		<option value="cash">Cash</option>';
												break;

								}
								$row_seller = mysqli_fetch_array($find_seller);
								echo '<form action="" method="post">
 <tr>
<td><input type="checkbox" name="id[]" value="' . $row["id"] . '"></input></td>
    <td> ' . $row["item"] . '</td>
    <td> ' . $row["location"] . ' </td>
    <td> ' . $row["unit_price"] . ' </td>
    <td>' . $row['quantity'] . '<input type="text" name="quantity[' . $row["id"] . ']" /></td>
    <td> ' . $row["type"] . ' </td>
    <td>' . $row['subtotal'] . '<input type="text" name="subtotal[' . $row["id"] . ']" /> €</td>
	<td><select class="other" name="pay_type[' . $row["id"] . ']">' . $pay_type_option . '
  </select></td>
	<td>' . $row_seller['seller_name'] . '</td>
 
	<td><input type="date" name="date[' . $row["id"] . ']" value="' . $row['date'] . '"/></td>
    <td><textarea name="comment[' . $row["id"] . ']" value="' . $row['comment'] . '" rols="3" rows="1">' . $row['comment'] . '</textarea></td>
	
  </tr>
';

				}
}
?>  
</table>
<table style="margin-left: 900px;">
<tr>
<td><input type="submit" name="submit" value="update"></td>
<td><a href="purchase.php"><input type="button" value="Add New Item"></a></td>
</tr>
  </table>
</form>

</div>
<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>
