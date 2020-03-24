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
$table_id = @$_GET['id'];

$find_table = mysqli_query($baglan, "select * FROM tables where table_id=$table_id ");
$show_table = mysqli_fetch_array($find_table);
if ($show_table['table_status'] == "1")
{
				$table_status = "open";
}

else
{
				$table_status = "closed";
}

if (isset($_POST['pay']))
{
				$find_cash = mysqli_query($baglan, "select * FROM account");
				$show_cash = mysqli_fetch_array($find_cash);
				$final_cash = $show_cash['cash'] + $show_table['table_subtotal'];
				$update_cash = mysqli_query($baglan, "update account set cash='$final_cash'");
				$table_subtotal = $show_table['table_subtotal'];
				$update = mysqli_query($baglan, "update tables set table_products='',table_quantities='', table_status='0', table_subtotal='0',table_status='0' where table_id='$table_id' LIMIT 1");

				$process_code = rand(1, 9999) . "sell" . rand(1, 9999);
				$find_process_code = mysqli_query($baglan, "SELECT * FROM process_log WHERE process_code LIKE '$process_code'");
				if ($find_process_code)
				{
								$process_code = rand(1, 9999) . "sell" . rand(1, 9999);
				}
				else
				{
								$process_code = $process_code;
				}
				$log_sell_array = array();
				$find_table_products = mysqli_query($baglan, "select * FROM tables where table_id='$table_id'");
				$row = mysqli_fetch_array($find_table_products);
				$products = explode(",", $row["table_products"]);
				$quantities = explode(",", $row["table_quantities"]);
				$product_count = count($products);
				for ($c = 0;$c < $product_count;$c++)
				{
								$product_id = $products[$c];
								$find_newdata_log = mysqli_query($baglan, "select * FROM products where product_id='$product_id'");
								$show_newdata_log = mysqli_fetch_array($find_newdata_log);
								$item_subtotal = $quantities[$c] * $show_newdata_log["menu_price"];
								$log_sell = $show_newdata_log['product_name'] . " " . $quantities[$c] . " " . $show_newdata_log["menu_price"] . " " . $item_subtotal;
								array_push($log_sell_array, $log_sell);
				}

				if ($update)
				{
								$date = date('Y-d-m');
								$log_sell_array_last = implode("/-/", $log_sell_array);
								$insert_log = mysqli_query($baglan, "insert into process_log (process,process_type,process_subtotal,process_code,process_date,process_detail) values ('selling','incoming','$table_subtotal','$process_code','$date','$log_sell_array_last')");
				}

				echo "Bill is paid";
}
if (isset($_POST['cancel']))
{

				$update = mysqli_query("update tables set table_products='',table_quantities='', table_status='0', table_subtotal='0',table_status='0'  where table_id='$table_id'LIMIT 1");
				echo "Table is Closed";
}

echo '
<table width="400" cellspacing="2" cellpadding="2" style="margin-top:20 px ;">
  <tr>
    <td width="100">Table Name</td>
    <td>' . $show_table['table_name'] . '</td>
  </tr>
  <tr>
    <td width="100">Status</td>
    <td>' . $table_status . '</td>
  </tr>
  <tr>
    <td width="100">Products</td>
    <td><table><tr>
    <td>Product</td>
    <td>Quantity</td>
	    <td>Menu Price</td>
    <td>Subtotal</td>

	
  </tr>';

$find_table_products = mysqli_query($baglan, "select * FROM tables where table_id='$table_id'");
$row = mysqli_fetch_array($find_table_products);
$products = explode(",", $row["table_products"]);
$quantities = explode(",", $row["table_quantities"]);
$product_count = count($products);
$final_subtotal = 0;
?><form action="" method="post" enctype="multipart/form-data"><?php
for ($i = 0;$i < $product_count;$i++)

{
				$product_id = $products[$i];
				$find_newdata = mysqli_query($baglan, "select * FROM products where product_id='$product_id'");
				$show_newdata = mysqli_fetch_array($find_newdata);
				$subtotal = $quantities[$i] * $show_newdata['menu_price'];
				@printf('  <tr>
    <td> ' . $show_newdata["name"] . '</td>
    <td  style="text-align:center">  ' . $quantities[$i] . '</td>
	    <td style="text-align:center"> ' . $show_newdata["menu_price"] . ' €</td>
    <td style="text-align:center"> ' . $subtotal . ' € </td>

	
  </tr>
');
				$final_subtotal = $final_subtotal + $subtotal;
				$update = mysqli_query($baglan, "update tables set table_subtotal='$final_subtotal' where table_id='$table_id' LIMIT 1");
}
echo '</table></td>
  </tr>
  <tr>
    <td width="100"></td>
    <td style="text-align:right"><a href="table_product_add.php?id=' . $show_table['table_id'] . '"><input type="button" value="Add"></a>     <a href="table_product_delete.php?id=' . $show_table['table_id'] . '"><input type="button" value="delete"></a></td>
  </tr>
      <tr>
    <td width="100">subtotal</td>
    <td style="text-align:right">' . $final_subtotal . ' €</td>
  </tr>
';

?>
    <tr>
    <td width="100" style="text-align:right"><input type="submit" name="cancel" value="Cancel"></td>
    <td style="text-align:right"><input type="submit" name="pay" value="Pay"></td>
  
  </tr>
</table>
</form>

</div>


<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>
