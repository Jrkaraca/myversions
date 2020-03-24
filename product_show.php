<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Food truck</title>
<style type="text/css">
.picture_table {
	height: 200px;
	width: 200px;
	margin-left: 10px;
}
#product_show_information {
	float: left;
	height: 100%;
	width: 40%;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 14px;
}
#product_show_table {
	height: 100%;
	width: 40%;
	font-family: "Times New Roman", Times, serif;
	font-size: 16px;
	font-style: normal;
}
#product_show_recipe {
	float: left;
	height: 100%;
	width: 40%;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-size: 14px;
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
<?php include 'connect_db.php';
$id = @$_GET['id'];
$find = mysqli_query($baglan, "SELECT * FROM products WHERE product_id='$id'");
while ($show = mysqli_fetch_array($find))
{;
				$ingredients = explode(",", $show["ingredient"]);
				$quantities = explode(",", $show["quantities"]);
				$ingredient_up = explode(",", $show["ingredient_up"]);
				$ingredient_type = explode(",", $show["ingredient_type"]);
				$recipe_photos = explode(",", $show["recipe_photos"]);
				$ingredients_count = count($ingredients);
				echo '<table width="40%" height="250" cellspacing="1" cellpadding="1">
  <tr>
    <td rowspan="2" ><img src="' . $show['picture'] . '" width="200" height="200"/></td>
    <td height="30" width="250"><center>Comment</center></td>
  </tr>
  <tr>

    <td>' . $show['comment'] . '</td>
  </tr>
</table>
';
				echo '
<table width="100%" cellspacing="1"  cellpadding="1"style="background-color:#eeeeee">
  <tr>
    <td style="font-size:14px;"><strong><center>İngredients</strong></center></td>
    <td style="font-size:14px;"><strong><center>Recipe</strong></center></td>
  </tr>
  <tr>
    <td><table width="60%" cellspacing="1" cellpadding="1" style="font-size:14px;">
  <tr>
    	<td style="background-color:#1b9bff;" width="100px">Name</td>
    <td width="100px">' . $show["name"] . '</td>
        <td style="background-color:#1b9bff" width="100 px">location</td>
    <td width="100px">' . $show["location"] . '</td>
	<tr>
        <td style="background-color:#1b9bff" width="100 px">Quantity</td>
    <td width="100px">' . $show["quantity"] . '</td>
        <td style="background-color:#1b9bff" width="100 px">Type</td>
    <td width="100px">' . $show["type"] . '</td>
	</tr>

  </tr>
    <tr>
    	<td style="background-color:#1b9bff" width="100 px">Menu Price</td>
    <td width="100px">' . $show['menu_price'] . '€</td>
        <td style="background-color:#1b9bff" width="100 px">Difficult</td>
    <td width="100px">' . $show["difficult"] . '</td>
	<tr>
        <td style="background-color:#1b9bff" width="100 px">Preparing Time</td>
    <td width="100px">' . $show["time"] . ' Min.</td>
        <td style="background-color:#1b9bff" width="100 px">Tax</td>
    <td width="100px">' . $show["product_tax"] . '</td>
	</tr>
		<tr>
        <td style="background-color:#1b9bff ; float= rigth;">subtotal</td>
    <td width="100px">' . $show["product_up"] . '</td>
	        <td style="background-color:#1b9bff ; float= rigth;">Date</td>
    <td>' . $show["date"] . '</td>
	</tr>
	</table></td>
    <td rowspan="3" width="60%" style="font-size:14px;">' . $show['recipe'] . '</td>
  </tr>
  <tr>
    <td><table style="font-size:14px;">
  <tr>
    <td style="background-color:#1b9bff">İngredient</td>
    <td style="background-color:#1b9bff">Quantities</td>
    <td style="background-color:#1b9bff">Type</td>
    <td style="background-color:#1b9bff">Unit Price</td>
    <td style="background-color:#1b9bff">İngredient Subtotal</td>              
  </tr>
  ' ?>
 
<?php for ($i = 0;$i < $ingredients_count;$i++)
				{
								@printf(' 
    <tr>
    <td>' . $ingredients[$i] . '</td>
    <td>' . $quantities[$i] . '</td>
    <td>' . $ingredient_type[$i] . '</td>
    <td>' . $ingredient_up[$i] . '</td>
    <td>' . $quantities[$i] * $ingredient_up[$i] . '</td> 
  </tr>
 '); ?> <?php
				}
				' </table></td>

  </tr>
';
}

?>
</table>
</table>

<table border="0" cellspacing="1" cellpadding="1" style="margin-top:20px">
  <tr>
  <?php

$i = 0;
$photos_count = count($recipe_photos);
if ($photos_count != 0)
{
				for ($c = 0;$c < $photos_count;$c++)
				{
								$i++;
								echo '<td ><img src="' . $recipe_photos[$c] . '" width="250" height="250"/></td>';
								if (($i % 4) != 0) continue;
								echo "</tr>";
				}
}

?>
  </tr>
</table>


</div>
<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>

,
