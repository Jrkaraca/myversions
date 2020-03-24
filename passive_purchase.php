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
//if($show_picture_name)
//{ $uret=array("as","rt","ty","yu","fg");
//			$uzanti=substr($dosya_adi,-4,4);
//			$random_number=rand(1,10000);
//			$new_picture_name=str_replace(" ","_",$item);
//			$picture_name="../img/properties/".$uret[rand(0,4)].$new_picture_name.$random_number.$uzanti; }
if (isset($_POST['submit']))
{
				$item = $_POST['item'];
				$location = $_POST['location'];
				$mobility = $_POST['mobility'];
				$seller = $_POST['seller'];
				$status = $_POST['status'];
				$quantity = $_POST['quantity'];
				$subtotal = $_POST['subtotal'];
				$purchase_date = $_POST['purchase_date'];
				$end_date = $_POST['end_date'];
				$comment = $_POST['comment'];
				$details = $_POST['details'];

				$days = (strtotime($end_date) - strtotime($purchase_date)) / (60 * 60 * 24);
				// echo $days=$days+1;
				$per_unit = $subtotal / $quantity;
				@$per_day = $per_unit / $days;
				round($per_day, 2);

				if ($_FILES["picture"]["size"] < 2048 * 2048)
				{ //Dosya boyutu 1Mb tan az olsun
								if ($_FILES["picture"]["type"] == "image/jpeg" or "image/png")
								{ //dosya tipi jpeg olsun
												$aciklama = $_POST["item"];
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
												$new_picture_name = str_replace(" ", "_", $item);
												$picture_name = "../img/properties/" . $uret[rand(0, 4) ] . $new_picture_name . $random_number . $uzanti;
												//Dosya yeni adıyla dosyalar klasörüne kaydedilecek
												if (move_uploaded_file($_FILES["picture"]["tmp_name"], $picture_name))
												{
																echo '<font color="green">File uploaded succesful.<br \></font>';
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

				$find_account = mysqli_query($baglan, "select * from account");
				$show_account = mysqli_fetch_array($find_account);
				$new_current_capital = $show_account['current_capital'] - $subtotal;
				if ($new_current_capital < 0)
				{
								echo "<font color='red'>You dont have enough money in your cash account.<br /></font>";
				}
				else
				{
								$update_capital = mysqli_query("update account set current_capital='$new_current_capital'");
								echo "<font color='green'>Account is updated.<br /></font>";
				}

				$unit_price = $subtotal / $quantity;

				$add = mysqli_query($baglan, "insert into passive_item (item,seller_id,location,status,quantity,mobility,per_day,subtotal,p_date,e_date,comment,details,picture) values ('$item','$seller','$location','$status','$quantity','$mobility','$per_day','$subtotal','$purchase_date','$end_date','$comment','$details','$picture_name')");

				$process_code = rand(1, 9999) . "out" . rand(1, 9999);
				$find_process_code = mysqli_query("SELECT * FROM process_log WHERE process_code LIKE '$process_code'");
				if ($find_process_code)
				{
								$process_code = rand(1, 9999) . "out" . rand(1, 9999);
				}
				else
				{
								$process_code = $process_code;
				}

				$log_seller = mysqli_query($baglan, "SELECT * FROM seller WHERE seller_id='$seller'");
				$process_seller = mysqli_fetch_array($log_seller);
				$seller_name = $process_seller['seller_name'];
				$date = date('Y-m-d');
				$log_item_name = $item . " " . $mobility . " " . $per_unit . " " . $quantity . "  " . $subtotal . " " . $status . "->" . $seller_name . "/-/";
				$process_name = "";
				if ($mobility == "active")
				{
								$process_name = "active";
				}
				else
				{
								$process_name = "passive";
				}
				$insert_log = mysqli_query($baglan, "insert into process_log (process,process_type,process_subtotal,process_code,process_date,process_detail) values ('$process_name','outgoing','$subtotal','$process_code','$date','$log_item_name')");

				$new_subtotal = $process_seller['seller_subtotal'] + $_POST['subtotal'];
				$update_seller = mysqli_query("update seller set seller_subtotal='$new_subtotal' where seller_id='$seller' LIMIT 1");

				if ($add)
				{
								echo "<font color='green'>Product is Added</font>";
				}
				else
				{
								echo "<font color='red'>Process is not Successfull</font>";
								mysqli_error($add);
				}

}

else
{
?>
    <h1>Add İtem</h1>
  <form action="" method="post" enctype="multipart/form-data">
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
				$find_seller = mysqli_query($baglan, "SELECT * FROM seller "); // dws_config_city tablosundan  adi alanını listeliyoruz.
				while ($row_seller = mysqli_fetch_array($find_seller))
				{
								print "<option value=" . $row_seller['seller_id'] . ">" . $row_seller['seller_name'] . "</option>";
				};
?>
  </select></td>
  </tr>
   <tr>
    <td>Status: </td>
    <td><input type="radio" name="status" value="paid" checked>Paid
    <input type="radio" name="status" value="bill">Bill</td>
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
    <td>Picture: </td>
    <td><input type="file" name="picture" value="Upload File"/></td>
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
    <td><input type="submit" name="submit"value="send"</td>
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
