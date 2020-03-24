<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Food truck</title>
<style type="text/css">
.changebutton {
	background-image: url(../img/triangular42%20-%20Kopya.png);
	background-attachment: fixed;
	background-repeat: no-repeat;
}
</style>
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

<table border="0" cellspacing="5" cellpadding="5" style="text-align:center" border="2" >
  <tr>
    <td>Bill</td>

    <td>location</td>
    <td>Status</td>
    <td>Type</td>
    <td>Subtotal</td>
        <td>Per Day Price</td>
    <td>Enter Date</td>
    <td>Expression Date</td>
    <td>Comment</td>
    <td>Change</td>
    <td>Delete</td>
  </tr>
<?php
$find = mysqli_query($baglan, "select * FROM bills ORDER BY date_start DESC");
while ($show = mysqli_fetch_array($find))
{
				echo '<tr>
    <td> ' . $show["bill"] . ' </td>
    <td> ' . $show["location"] . ' </td>
    <td> ' . $show["status"] . ' </td>
    <td> ' . $show["type"] . ' </td>
    <td> ' . $show["subtotal"] . ' </td>
	    <td> ' . $show["per_day"] . ' </td>
    <td> ' . $show["date_start"] . ' </td>
	<td> ' . $show["date_end"] . ' </td>
    <td> ' . $show["comment"] . ' </td>
    <td> <a href="change.php?id=' . $show["bill_id"] . '"><img src="../img/web_icons/triangular42.png" width="16" height="16" /></a></td>
    <td> <a href="delete.php?id=' . $show["bill_id"] . '"><img src="../img/web_icons/cross97.png" width="16" height="16" /></a></td>
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
