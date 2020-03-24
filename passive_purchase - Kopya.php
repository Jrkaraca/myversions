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

if ($_POST){
	$item = $_POST['item'];
	$location = $_POST['location'];
	$mobility = $_POST['mobility'];
	$seller= $_POST['seller'];
	$status = $_POST['status'];
	$quantity = $_POST['quantity'];
	$subtotal = $_POST['subtotal'];
	$purchase_date = $_POST['purchase_date'];
	$end_date = $_POST['end_date'];
	$comment = $_POST['comment'];
	$details = $_POST['details'];

	$days = (strtotime($end_date) - strtotime($purchase_date)) / (60 * 60 * 24);
// echo $days=$days+1;
 		$per_unit=$subtotal/$quantity;
		$per_day=$per_unit/$days;
		round($per_day,2);
		//veri ekle
		
		$find_account=mysql_query("select * from account");
$show_account = mysql_fetch_array($find_account);
$new_current_capital=$show_account['current_capital']-$subtotal;
if ($new_current_capital<0)
{ echo "You dont have enough money in your cash account.<br />";}
else 
{ $update_capital=mysql_query("update account set current_capital='$new_current_capital'");
echo "Account is updated.<br />";

		$add = mysql_query("insert into passive_item (item,seller_id,location,status,quantity,mobility,per_day,subtotal,p_date,e_date,comment,details) values ('$item','$seller','$location','$status','$quantity','$mobility','$per_day','$subtotal','$purchase_date','$end_date','$comment','$details')");
		
				$process_code =rand(1,9999)."out".rand(1,9999);
		$find_process_code = mysql_query("SELECT * FROM process_log WHERE process_code LIKE '$process_code'");
		if($find_process_code)
		{  $process_code = rand(1,9999)."out".rand(1,9999);}
		else {$process_code=$process_code;}
		
	$log_seller = mysql_query("SELECT * FROM seller WHERE seller_id='$seller'");
$process_seller = mysql_fetch_array($log_seller);
$seller_name=$process_seller['seller_name'];
	$date = date('Y-m-d');
		$log_item_name=$item." ".$mobility." ".$per_unit." ".$quantity."  ".$subtotal." ".$status."->".$seller_name."/-/";
		$process_name="";
		if($mobility=="active")
		{$process_name="active";}
		else {$process_name="passive";}
		$insert_log=mysql_query("insert into process_log (process,process_type,process_subtotal,process_code,process_date,process_detail) values ('$process_name','outgoing','$subtotal','$process_code','$date','$log_item_name')");
		
		$new_subtotal=$process_seller['seller_subtotal'] + $_POST['subtotal'];
		$update_seller=mysql_query("update seller set seller_subtotal='$new_subtotal' where seller_id='$seller' LIMIT 1");

		if ($add) { 
		echo "<font color='green'>Product is Added</font>";
		}
			else
			{
			echo "<font color='red'>Process is not Successfull</font>";
			}
			
}
		}




else {
	?>
    <h1>Add İtem</h1>
    <form action="" method="post">
   <table width="200" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>İtem: </td>
    <td><input type="text" name="item" /></td>
  </tr>
    <tr>
    <td>Location: </td>
    <td><input type="text" name="location" /></td>
  </tr>
  <tr>
    <td>Mobility; </td>
    <td><input type="radio" name="mobility" value="active" >Active
    <input type="radio" name="mobility" value="passive" checked>Passive
    </td>
  </tr>
  <tr>
    <td>Seller: </td>
    <td><select class="other" name="seller">
  <option selected value="0">Chose One</option>
  <?php
 
   $find_seller = mysql_query("SELECT * FROM seller "); // dws_config_city tablosundan  adi alanını listeliyoruz.
   while ($row_seller = mysql_fetch_array($find_seller))
   {
    print "<option value=".$row_seller['seller_id'].">".$row_seller['seller_name']."</option>";
   };
  ?>
  </select></td>
  </tr>
   <tr>
    <td>Status: </td>
    <td><input type="radio" name="status" value="paid" checked>Paid
    <input type="radio" name="status" value="bill" checked>Bill</td>
  </tr>
  <tr>
    <td>Quantity: </td>
    <td><input type="text" name="quantity" /></td>
  </tr>
    <tr>
    <td>Subtotal: </td>
    <td><input type="text" name="subtotal" /></td>
  </tr>
  <tr>
    <td>Purchase Date: </td>
    <td><input type="date" name="purchase_date"  value="<?php echo date('Y-m-d'); ?>"/></td>
  </tr>
    <tr>
    <td>Economic Life: </td>
    <td><input type="date" name="end_date"/></td>
  </tr>
    <tr>
    <td>Details: </td>
    <td><textarea rows="4" cols="20" name="details"></textarea></td>
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