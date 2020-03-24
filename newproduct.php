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
$quantities = array();
$unit_prices = array();
$ingredients = array();
$ingredient_types = array();
$ingredient_id = array();
$ingredient_unit_prices = array();
$recipe_photos = array();
if (isset($_POST['submit']))
{

				$product_name = $_POST['product_name'];
				//	$product_quantity=$_POST['product_quantity'];
				$product_type = $_POST['product_type'];
				$product_location = $_POST['product_location'];
				$product_date = $_POST['product_date'];
				$product_comment = $_POST['product_comment'];
				$product_recipe = $_POST['product_recipe'];
				$product_quantity = $_POST['product_quantity'];
				$difficult = $_POST['difficult'];
				$product_time = $_POST['product_time'];
				$product_tax = $_POST['product_tax'];
				foreach (($_POST["id"]) AS $id)
				{
								$find2 = mysqli_query($baglan, "select * FROM purchase_stock where id='$id'");
								$newdata = mysqli_fetch_array($find2);

								$quantity = $newdata['quantity'] - $_POST['quantity'][$id];
								$subtotal = $quantity * $newdata['unit_price'];
								$new_unit_price = $_POST['quantity'][$id] * $newdata['unit_price'];
								array_push($ingredient_id, $newdata['id']);
								array_push($ingredients, $newdata['item']);
								array_push($quantities, $_POST['quantity'][$id]);
								array_push($unit_prices, $new_unit_price);
								array_push($ingredient_types, $newdata['type']);
								array_push($ingredient_unit_prices, $newdata['unit_price']);
								$date = $_POST['date'][$id];
								$comment = $_POST['comment'][$id];

								if ($quantity < 0)
								{
												echo "You dont have enough " . $newdata['item'] . " in your stocks. Please get that ingredient and try again";
												die();

								}
								else
								{
												$update = mysqli_query($baglan, "update purchase_stock set quantity='$quantity',subtotal='$subtotal', date='$date',comment='$comment' where id='$id' LIMIT 1");
								}
				}
				//var_dump(array_filter($ingredients));
				//var_dump(array_filter($quantities));
				//var_dump(array_filter($subtotals));
				//print_r($ingredient_unit_prices);
				//print_r($quantities);
				//print_r($unit_prices);
				$ingredient_id_array = implode(",", $ingredient_id);;
				$product_subtotal = array_sum($unit_prices);
				$ingredients_array = implode(",", $ingredients);
				$ingredient_type_array = implode(",", $ingredient_types);
				$quantities_array = implode(",", $quantities);
				$unit_prices_array = implode(",", $unit_prices);
				$ingredient_unit_price = implode(",", $ingredient_unit_prices);
				$product_up = $product_subtotal + (($product_subtotal / 100) * 5);

				if ($_FILES["picture"]["size"] < 2048 * 2048)
				{ //Dosya boyutu 1Mb tan az olsun
								if ($_FILES["picture"]["type"] == "image/jpeg" or "image/png")
								{ //dosya tipi jpeg olsun
												$aciklama = $_POST["product_name"];
												$dosya_adi = $_FILES["picture"]["name"];
												//Dosyaya yeni bir isim oluşturuluyor
												$uret = array(
																"as",
																"rt",
																"ty",
																"yu",
																"fg"
												);
												$uzanti = substr($dosya_adi, -4, 4);
												$random_number = rand(1, 10000);
												$new_picture_name = str_replace(" ", "_", $product_name);
												$picture_name = "../img/menu_images/" . $uret[rand(0, 4) ] . $new_picture_name . $random_number . $uzanti;
												//Dosya yeni adıyla dosyalar klasörüne kaydedilecek
												if (move_uploaded_file($_FILES["picture"]["tmp_name"], $picture_name))
												{

																echo 'File uploaded succesful.';
																$photo_count = count($_FILES['photo']['name']);
																for ($c = 0;$c < $photo_count;$c++)
																{
																				if (!empty($_FILES['photo']['name'][$c]))
																				{
																								$upload_name = $_FILES["photo"]["name"][$c];
																								$create_photo = array(
																												"as",
																												"rt",
																												"ty",
																												"yu",
																												"fg"
																								);
																								$random_number_photo = rand(1, 10000);
																								$uzanti_photo = substr($upload_name, -4, 4);
																								$photo_name = "../img/recipe_images/" . $create_photo[rand(0, 4) ] . $new_picture_name . $random_number_photo . $uzanti;
																								move_uploaded_file($_FILES["photo"]["tmp_name"][$c], $photo_name);
																								array_push($recipe_photos, $photo_name);
																				}
																}
																//Bilgiler veri tabanına kaydedilsin
																//$add = mysqli_query("insert into products name='$product_name', ingredient='$ingredients_array', quantities='$quantities_array', quantity='$product_quantity', type='$product_type', subtotal='$product_subtotal', product_up='$product_up' date='$product_date', location='$product_location', comment='$product_comment', picture='$picture_name' ");
																$recipe_photos_array = implode(",", $recipe_photos);
																$add = mysqli_query($baglan, "insert into products (name,ingredient,quantities,ingredient_up,ingredient_type,type,subtotal,product_up,date,location,comment,recipe,picture,quantity,difficult,time,product_tax,ingredient_id,recipe_photos) values ('$product_name','$ingredients_array','$quantities_array','$ingredient_unit_price','$ingredient_type_array','$product_type','$product_subtotal','$product_up','$product_date','$product_location','$product_comment','$product_recipe','$picture_name','$product_quantity','$difficult','$product_time','$product_tax','$ingredient_id_array','$recipe_photos_array')");

																if ($add)
																{
																				echo 'Product Added';
																}
																else
																{
																				echo 'Process is not succesful!';
																				mysqli_error($add);
																}
												}
												else
												{
																echo 'File couldnt upload!';
												}
								}
								else
								{
												echo 'You can upload only jpeg or png file.';
								}
				}
				else
				{
								echo 'Picture size cannot be more than 4mb!';
				}
}
?>

<form action="" method="post" enctype="multipart/form-data">
<table border="0" cellspacing="2" cellpadding="2" style="text-align:center; " >
<tr>
<td>Product Name</td>
<td>Type</td>
<td>Location</td>
<td>Date</td>
<td colspan="2">Picture</td>
<tr>
</tr>
</tr>


 <tr>
<tr>
<td><input type="text" name="product_name" /></td>
<td><input type="radio" name="product_type" value="main" checked>Main
    <input type="radio" name="product_type" value="dessert" >Dessert
    <input type="radio" name="product_type" value="salad" >Salad
    <input type="radio" name="product_type" value="drink" >Drink</td>
<td><input type="radio" name="product_location" value="drystore" checked>Dry Storage
    <input type="radio" name="product_location" value="fridge" checked>Fridge +4
    <input type="radio" name="product_location" value="freezer" checked>Freeze -18</td>
    <td><input type="date" name="product_date"  value="<?php echo date('Y-m-d'); ?>"/></td>
<td><input type="file" name="picture" value="Upload File"/></td>
</tr>
<tr>
<td>Quantity</td>
<td>Difficult Level</td>
<td>Time Min.</td>
<td>Tax</td>
<td>Recipe Photos</td>

</tr>
<tr>

<td><input type="text" name="product_quantity" /></td>
<td><input type="radio" name="difficult" value="1" checked>1
    <input type="radio" name="difficult" value="2">2
    <input type="radio" name="difficult" value="3">3
    <input type="radio" name="difficult" value="1">4
    <input type="radio" name="difficult" value="1">5</td>
    <td><input type="text" name="product_time" /></td>
	<td><input type="text" name="product_tax" /></td>
    <td><input type="file" name="photo[]" id="photo[]" multiple="multiple" value="Upload File"/></td>

</tr>
</table>
<table border="0" cellspacing="5" cellpadding="5" style="text-align:left; "  >
  <tr>
    <td>Item</td>
    <td>location</td>
    <td>Unit Price</td>
    <td>Quantity</td>
    <td>Type</td>
    <td>Subtotal</td>
    <td>Date</td>
    <td>Comment</td>
  </tr>
<?php
$find = mysqli_query($baglan, "select * FROM purchase_stock ORDER BY item ASC");
if (mysqli_num_rows($find) > 0)
{
				while ($row = mysqli_fetch_assoc($find))
				{
								echo '
 <input type="hidden" name="date[' . $row["id"] . ']" value="' . $row["date"] . '"></input>
  <input type="hidden" name="comment[' . $row["id"] . ']" value="' . $row["comment"] . '"></input>
 <tr>
    <td><input type="checkbox" name="id[]" value="' . $row["id"] . '">' . $row["item"] . '</input></td>
    <td> ' . $row["location"] . ' </td>
    <td> ' . $row["unit_price"] . ' </td>
    <td>' . $row['quantity'] . '<input type="text" name="quantity[' . $row["id"] . ']" /></td>
    <td>' . $row["type"] . '</input></td>
    <td>' . $row['subtotal'] . '€</td></td>
	<td>' . $row['date'] . '</td>
    <td>' . $row['comment'] . '</td>
	
  </tr>
';
				}
}
?>
  </table>
  <table border="0" cellspacing="5" cellpadding="5" style="text-align:left; " border="2"  >
  <td>Recipe</td>
  <td><textarea rows="8" cols="50" name="product_recipe"></textarea></td>
   <td>Comment</td>
<td><textarea rows="8" cols="50" name="product_comment"></textarea></td></tr>
  <tr>
<td><input type="submit" name="submit" value="update"></td>
</tr>
</table>
</form>

</div>
<div id="footer">
<strong>All Rights Reserved @ 2015 Barış KARACA</strong>


</div>




</body>
</html>
