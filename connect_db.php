<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<?php 
//mysql bağlanma

@$baglan = mysqli_connect("localhost","MariaDB","");
$database = "test";
if ($baglan){
	echo "<font color='#00CC00'>You Connected to the Database</font><br/>";	
	//veritabanı seçme
	$db_c = mysqli_select_db($baglan,$database);
	if ($db_c) {
			echo "<font color='#00CC00'>You Choised Database</font><br/>";	
	}
		else {
		die("You Couldnt Select Database!"); 	
	}

}
	else {
		die("You Couldnt Connect to the Database!"); 	
	}












?>
<body>
</body>
</html>