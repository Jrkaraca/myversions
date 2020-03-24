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
   <li class='last'><a href="menu.php"><span>Menu</span></a></li>
</ul>
</div>



<div id="concentmenu" >
<?php include 'connect_db.php'; ?>
<table style="text-align:center; margin-left:50px" width="80%">
<tr>
<?php
$i=0;
$find = mysqli_query($baglan,"select * FROM products WHERE type LIKE 'main' ORDER BY name ASC");
while ($show = mysqli_fetch_array($find)){
	$i++;
	echo'<td >
	<table style="background-color:#e1f1e7"><tr><td><img src="'.$show['picture'].'" width="150" height="150"/></td></tr>
	<tr><td>'.$show['name'].'</td></tr>
	<tr><td>'.$show['menu_price'].'€</td></tr></table>
	</td>';
 if(($i%5)!=0)  continue;
  echo "</tr>";
	
}
?></tr>
</table>

<table style="text-align:center; margin-left:50px" width="auto">
<tr>
<?php
$i=0;
$find = mysqli_query($baglan,"select * FROM products WHERE type LIKE 'salad' ORDER BY name ASC");
while ($show = mysqli_fetch_array($find)){
	$i++;
	echo'<td >
	<table style="background-color:#e1f1e7;margin-right:50px"><tr><td><img src="'.$show['picture'].'" width="150" height="150"/></td></tr>
	<tr><td>'.$show['name'].'</td></tr>
	<tr><td>'.$show['menu_price'].'€</td></tr></table>
	</td>';
 if(($i%5)!=0)  continue;
  echo "</tr>";
	
}
?></tr>
</table>

<table style="text-align:center; margin-left:50px" width="auto">
<tr>
<?php
$i=0;
$find = mysqli_query($baglan,"select * FROM products WHERE type LIKE 'dessert' ORDER BY name ASC");
while ($show = mysqli_fetch_array($find)){
	$i++;
	echo'<td>
	<table style="background-color:#e1f1e7;margin-right:50px"><tr><td><img src="'.$show['picture'].'" width="150" height="150"/></td></tr>
	<tr><td>'.$show['name'].'</td></tr>
	<tr><td>'.$show['menu_price'].'€</td></tr></table>
	</td>';
 if(($i%5)!=0)  continue;
  echo "</tr>";
	
}
?></tr>
</table>
<table style="text-align:center; margin-left:50px" width="auto">
<tr>
<?php
$i=0;
$find = mysqli_query($baglan,"select * FROM products WHERE type LIKE 'drink' ORDER BY name ASC");
while ($show = mysqli_fetch_array($find)){
	$i++;
	echo'<td>
	<table style="background-color:#e1f1e7;margin-right:50px"><tr><td><img src="'.$show['picture'].'" width="150" height="170"/></td></tr>
	<tr><td>'.$show['name'].'</td></tr>
	<tr><td>'.$show['menu_price'].'€</td></tr></table>
	</td>';
 if(($i%5)!=0)  continue;
  echo "</tr>";
	
}
?></tr>
</table>
</div>
<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>