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

if ($_POST)
{
				$name = $_POST['employe_name'];
				$age = $_POST['employe_age'];
				$gender = $_POST['employe_gender'];
				$employe_department = $_POST['employe_department'];
				$employe_position = $_POST['employe_position'];
				$employe_salary = $_POST['employe_salary'];
				$employe_tax = $_POST['employe_tax'];
				$employe_date = $_POST['date'];
				$employe_detail = $_POST['detail'];

				//veri ekle
				$add = mysqli_query($baglan, "insert into employes (employe_name,employe_age,employe_gender,employe_department,employe_position,employe_salary,employe_tax,employe_start_date,employe_details) values ('$name','$age','$gender','$employe_department','$employe_position','$employe_salary','$employe_tax','$employe_date','$employe_detail')");

				if ($add)
				{
								echo "<font color='green'>Employe is Added</font>";
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
    <h1New Employe</h1>
    <form action="" method="post">
   <table width="400" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>Name: </td>
    <td><input type="text" name="employe_name" /></td>
  </tr>
   <tr>
    <td>Age: </td>
    <td><input type="text" name="employe_age" />
    </td>
  </tr>
  <tr>
    <td>Gender: </td>
    <td><input type="radio" name="employe_gender" value="male" checked>Male
<input type="radio" name="employe_gender" value="female" >Female</td>
  </tr>
    <tr>
    <td>Department: </td>
    <td><select class="other" name="employe_department">
      <option>Choose One</option>
  <option value="kitchen" selected>Kitchen</option>
  </select></td>
  </tr>
    <tr>
    <td>Position: </td>
    <td><select class="other" name="employe_position">
  <option value="commis">Commis</option>
    <option value="dcdp">Demi Chef de Part</option>
    <option value="cdp">Chef de Part</option>
      <option value="sc">Sous Chef</option>
      <option value="ec">Executive Chef</option>
  </select></td>
  </tr>
  <tr>
    <td>Net Salary: </td>
    <td><input type="text" name="employe_salary" /></td>
  </tr>
  <tr>
    <td>Tax Rate:</td>
    <td><input type="text" name="employe_tax" /></td>
  </tr>
    <tr>
    <td>Start Date:</td>
    <td><input type="date" name="date"  value="<?php echo date('Y-m-d'); ?>"/></td>
  </tr>
  <tr>
    <td>Details: </td>
    <td><textarea rows="4" cols="20" name="detail"></textarea></td>
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
