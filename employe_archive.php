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

<table border="0" cellspacing="5" cellpadding="5" style="text-align:center; text-transform:capitalize" border="2" >
  <tr>
    <td>Name</td>
     <td>Age</td>
    <td>Gender</td>
    <td>Department</td>
    <td>Position</td>
    <td>Net Salary</td>
      <td>Brut Salary</td>
    <td>Tax Rate</td>
    <td>Start Date</td>
    <td>Details</td>
  </tr>
<?php
$find = mysqli_query($baglan, "select * FROM employes");
while ($show = mysqli_fetch_array($find))
{

				$tax_diff = $show['employe_salary'] / 100;
				$tax_rate = $show['employe_tax'] / $tax_diff - 100;
				$salary = (($show['employe_salary'] / 100) * $show['employe_tax']) + $show['employe_salary'];

				echo '<tr>
    <td> ' . $show["employe_name"] . ' </td>
     <td> ' . $show["employe_age"] . ' </td>
    <td> ' . $show["employe_gender"] . '</td>
	<td>' . $show["employe_department"] . '</td>
    <td>' . $show["employe_position"] . '</td>
	<td>' . $show["employe_salary"] . ' €</td>
	<td>' . $show["employe_tax"] . ' €</td>
	<td>' . number_format($tax_rate, 2) . '%</td>
	<td>' . $show["employe_start_date"] . '</td>
		<td> ' . $show["employe_details"] . ' </td>
  </tr>';
}

?>
</table>

</div>
<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>
