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
				$bill = $_POST['bill'];
				$location = $_POST['location'];
				$status = $_POST['status'];
				$type = $_POST['type'];
				$subtotal = $_POST['subtotal'];
				$date_start = $_POST['date_start'];
				$date_end = $_POST['date_end'];
				$comment = $_POST['comment'];
				$days = (strtotime($date_end) - strtotime($date_start)) / (60 * 60 * 24);
				if($days=0 or $days<=0)
					{
						$days++;
					}
				// echo $days=$days+1;
				$per_day = $subtotal / $days;
				round($per_day, 2);
				$find = mysqli_query($baglan, "select * FROM purchase_stock");
				//veri ekle
				$add = mysqli_query($baglan, "insert into bills (bill,location,status,type,subtotal,per_day,date_start,date_end,comment) values ('$bill','$location','$status','$type','$subtotal','$per_day','$date_start','$date_end','$comment')");

				$process_code = rand(1, 9999) . "out" . rand(1, 9999);
				$find_process_code = mysqli_query($baglan, "SELECT * FROM process_log WHERE process_code LIKE '$process_code'");
				if ($find_process_code)
				{
								$process_code = rand(1, 9999) . "bill" . rand(1, 9999);
				}
				else
				{
								$process_code = $process_code;
				}

				$process_date = date('Y-m-d');
				$log_bill_name = $bill . " " . $location . " " . $type . " " . $subtotal . "  " . $status . "/-/";

				$insert_log = mysqli_query($baglan, "insert into process_log (process,process_type,process_subtotal,process_code,process_date,process_detail) values ('bill','outgoing','$subtotal','$process_code','$process_date','$log_bill_name')");

				if ($add)
				{
								echo "<font color='green'>Product is Added</font>";
				}
				else
				{
								echo "<font color='red'>Process is not Successfull</font>";
				}
}

else
{
?>
    <h1>Add Bill</h1>
    <form action="" method="post">
   <table width="200" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>İtem: </td>
    <td><input type="text" name="bill" /></td>
  </tr>
  <tr>
    <td>Location: </td>
<td><input type="text" name="location" /></td>
  </tr>
  <tr>
    <td>Status: </td>
    <td><input type="radio" name="status" value="paid" checked>Paid
    <input type="radio" name="status" value="bill" checked>Bill</td>
  </tr>

  <tr>
    <td>Type: </td>
    <td><input type="radio" name="type" value="cash" checked>cash	
    <input type="radio" name="type" value="credit" checked>credit
    <input type="radio" name="type" value="cek" checked>cek</td>
  </tr>
  <tr>
    <td>Subtotal: </td>
    <td><input type="text" name="subtotal" /></td>
  </tr>
  <tr>
    <td>Date Enter: </td>
    <td><input type="date" name="date_start" value="<?php echo date('Y-m-d'); ?>"/></td>
  </tr>
    <tr>
    <td>Date End: </td>
    <td><input type="date" name="date_end" value="<?php echo date('Y-m-d'); ?>" /></td>
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


</body>
</html>
