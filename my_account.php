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
$find_account = mysqli_query($baglan, "select * from account");
$show_account = mysqli_fetch_array($find_account);

$find_property = mysqli_query($baglan, "select SUM(subtotal) as property from passive_item");
$sum_property = mysqli_fetch_assoc($find_property);

$find_purchase = mysqli_query($baglan, "select SUM(subtotal) as purchase from purchase_stock");
$sum_purchase = mysqli_fetch_assoc($find_purchase);

$find_bill = mysqli_query($baglan, "select SUM(subtotal) as bill from bills");
$sum_bill = mysqli_fetch_assoc($find_bill);

$find_employe = mysqli_query($baglan, "select SUM(employe_tax) as employe from employes");
$sum_employe = mysqli_fetch_assoc($find_employe);

$balance_cash = $show_account['cash'] - ($sum_purchase["purchase"] + $sum_employe["employe"] + $sum_bill["bill"]);

?>
<table width="60%" cellspacing="1" cellpadding="1" style="text-transform:capitalize; margin-top:20px">
  <tr>
    <td>Start Capital</td>
    <td>Capital</td>
    <td>Current Capital</td>
    <td>Cash</td>
    <td>Properties</td>
    <td>Profit</td>
  </tr>
  <tr>
    <td>200,000.00 €</td>
    <td><?php echo $show_account['capital']; ?></td>
    <td><?php echo $show_account['current_capital']; ?></td>
    <td><?php echo $balance_cash; ?></td>
    <td><?php echo $sum_property["property"]; ?></td>
    <td><?php echo $profit = ((($show_account['current_capital'] + $sum_property["property"]) - $show_account['capital']) + $balance_cash) + $show_account['cash']; ?></td>
  </tr>
    <tr>
    <td>&nbsp;</td>

    <td><a href="account_process.php?account_process=add_capital" title="Add value into capital account of company from owner account."><input type="button" value="Add Capital"></a></td>
    <td><a href="account_process.php?account_process=withdraw" title="Withdraw money from current capital account of company to owner account."><input type="button" value="Withdraw"></td>
    <td><a href="account_process.php?account_process=add_cash" title="Add money into cash account of company from capital account. "><input type="button" value="Add Cash"></a></td>
    <td>Balance: </td>
    <td><?php echo $show_account['current_capital'] + $sum_property["property"] + $show_account['cash']; ?></td>
  </tr>
</table>

<table width="60%" height="400" cellspacing="1" cellpadding="1" style="margin-top:30px">
  <tr>
    <td style=" vertical-align:top">  <table width="150" cellspacing="1" cellpadding="1"  style="display:block">
    <tr>
    <td  width="100">Cash Account</td>
    <td width="75"><?php echo $show_account['cash']; ?></td>
  </tr>
      <tr>
    <td width="100">Purchase Cost</td>
    <td width="75"><?php echo "-" . $sum_purchase['purchase']; ?></td>
  </tr>
  <tr>
    <td width="100">Bills Cost</td>
    <td width="75"><?php echo "-" . $sum_bill["bill"]; ?></td>
  </tr>
  <tr>
    <td width="100">Employe Costs</td>
    <td width="75"><?php echo "-" . $sum_employe["employe"]; ?></td>
  </tr>
  <tr>
    <td width="100">Balance</td>
    <td width="75"><?php
echo $balance_cash; ?></td>
  </tr></table></td>
    <td width="600" height="400" style="overflow:scroll; display:block"><?php
$find_process = mysqli_query($baglan, "select * from process_log where process_type='incoming' OR process_type='outgoing' order by process_date DESC");
?><table width="100%" height="400" >
	<tr>
    <td>Process</td>
    <td>Process Type</td>
    <td>Process Subtotal</td>
    <td>Process Date</td>
    <td>Process Code</td>
    <td>Process Details</td>
    </tr>
	
	<?php
while ($show_process = mysqli_fetch_array($find_process))
{
				if ($show_process['process_type'] == "incoming")
				{
								echo '<tr>
    <td>' . $show_process['process'] . '</td>
    <td bgcolor="#55FF55">' . $show_process['process_type'] . '</td>
    <td> +' . $show_process['process_subtotal'] . '</td>
    <td>' . $show_process['process_date'] . '</td>
    <td>' . $show_process['process_code'] . '</td>
	<td><a href="process_detail.php?id=' . $show_process['id'] . ' title="This link shows defail of process."">Details</a></td>
    </tr>';
				}
				else
				{
								echo '<tr ">
    <td>' . $show_process['process'] . '</td>
    <td bgcolor="#FF3333">' . $show_process['process_type'] . '</td>
    <td> -' . $show_process['process_subtotal'] . '</td>
    <td>' . $show_process['process_date'] . '</td>
    <td>' . $show_process['process_code'] . '</td>
	<td><a href="process_detail.php?id=' . $show_process['id'] . ' title="This link shows defail of process."">Details</a></td>
    </tr>';
				}
}
?></table></td>
  </tr>
</table>


	
	
	
	
</div>


<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>
