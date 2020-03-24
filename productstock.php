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
<?php include 'connect_db.php'; ?>

<table border="0" cellspacing="5" cellpadding="5" style="text-align:center ; text-transform:capitalize" border="2" >
  <tr>
    <td>Name</td>
     <td>Type</td>
    <td>Food Cost</td>
    <td>Tax</td>
    <td>H.R. Cost</td>
    <td>Prep Costs</td>
    <td>Other Cost</td>
    <td>Total Cost</td>
    <td>Menu Price</td>
    <td>Profit</td>
    <td>Location</td>
    <td>Date</td>
  </tr>
<?php
$find_bills = mysqli_query($baglan, "SELECT SUM(per_day) FROM bills");
$show_bill_prices = mysqli_fetch_array($find_bills);
$find_quantities = mysqli_query($baglan, "SELECT SUM(quantity) FROM products");
$show_quantities = mysqli_fetch_array($find_quantities);
$unit_cost = (($show_bill_prices['0'] / 8) / 60) + (($show_bill_prices['0'] / 24) / 60);

$find_hrcost = mysqli_query($baglan, "SELECT SUM(employe_tax) FROM employes");
$show_hrcost = mysqli_fetch_array($find_hrcost);
$hr_cost = (($show_hrcost['0'] / 30) / 8) + (($show_hrcost['0'] / 30) / 4) + ((($show_hrcost['0'] / 30) / 4) * 0.80);

$find_extra_cost = mysqli_query($baglan, "SELECT * FROM employes");
$show_extra_cost = mysqli_fetch_array($find_extra_cost);

//count page
$query1 = mysqli_query($baglan, "select employe_position,count(employe_position) as commis from employes where employe_position='commis'");
$count1 = mysqli_fetch_assoc($query1);
$count1["commis"] . " ";

$query2 = mysqli_query($baglan, "select employe_position,count(employe_position) as dcdp from employes where employe_position='dcdp'");
$count2 = mysqli_fetch_assoc($query2);
$count2["dcdp"] . " ";

$query3 = mysqli_query($baglan, "select employe_position,count(employe_position) as cdp from employes where employe_position='cdp'");
$count3 = mysqli_fetch_assoc($query3);
$count3["cdp"] . " ";

$query4 = mysqli_query($baglan, "select employe_position,count(employe_position) as sc from employes where employe_position='sc'");
$count4 = mysqli_fetch_assoc($query4);
$count4["sc"] . " ";

$query5 = mysqli_query($baglan, "select employe_position,count(employe_position) as ec from employes where employe_position='ec'");
$count5 = mysqli_fetch_assoc($query5);
$count5["ec"] . " ";
$count_all = ($count1["commis"] + $count2["dcdp"] + $count3["cdp"] + $count4["sc"] + $count5["ec"]);

$find = mysqli_query($baglan, "select * FROM products ORDER BY name ASC");
while ($show = mysqli_fetch_array($find))
{
				$product_up = $show["product_up"] / $show["quantity"];
				$product_id = $show['product_id'];
				$cost = ($unit_cost * $show["time"]) + (($unit_cost / 100) * 15);
				$tax = ($product_up * $show['product_tax']) / 100;
				$show_hr_cost = (($product_up / 75) * ($hr_cost));

				$commis = 5;
				$dcdp = 4;
				$cdp = 3;
				$sc = 2;
				$ec = 1;
				for ($diff_count = 1;$diff_count < $show['difficult'];$diff_count++)

				{
								$commis = $commis + 5;
								$dcdp = $dcdp + 4;
								$cdp = $cdp + 3;
								$sc = $sc + 2;
								$ec = $ec + 1;
				}
				$cost_rate = (($commis * $count1["commis"]) + ($dcdp * $count2["dcdp"]) + ($cdp * $count3["cdp"]) + ($sc * $count4["sc"]) + ($ec * $count5["ec"])) / $count_all;
				$other_cost = (($product_up + $cost) / 100) * $cost_rate;
				$total_cost = $product_up + $tax + $show_hr_cost + $cost + $other_cost;
				$menu_price = (($total_cost / 100) * 20) + $total_cost;
				echo '<tr>
    <td> ' . $show["name"] . ' </td>
     <td> ' . $show["type"] . ' </td>
    <td> ' . number_format($product_up, 2) . '€</td>
	<td>' . number_format($tax, 2) . '</td>
    <td>' . number_format($show_hr_cost, 2) . '</td>
	<td>' . number_format($cost, 2) . '</td>
	<td>' . number_format($other_cost, 2) . '</td>
	<td>' . number_format($total_cost, 2) . '</td>
	<td>' . number_format($menu_price, 2) . '</td>
	<td>20%</td>
		<td> ' . $show["location"] . ' </td>
	<td> ' . $show["date"] . ' </td>
    <td> <a href="product_show.php?id=' . $show["product_id"] . '" target="_blank">Details</a></td>
  </tr>';

				$update_menu_price = mysqli_query($baglan, "update products set menu_price='$menu_price' where product_id='$product_id' LIMIT 1");
}

?>
</table>

</div>
<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>
