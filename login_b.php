<?php
	include_once "connection.php";
	
	if(isset($_POST["lgn"])) {
		$un = sanitizeString($con,$_POST["username"]);
		$pw = sanitizeString($con,$_POST["pass"]);
		
		$sql = mysqli_query($con,"select * from user where user_name='$un' AND password='$pw'");
		if(mysqli_num_rows($sql)) {
			$_SESSION["dtuser"] = $un;
			setCookie("dtacnt",$_SESSION["dtuser"],time()+60*60*24*30) or die("failed creating cookie");
			echo "<meta http-equiv='refresh' content='0,url=index.php'>";
		} else {
			echo "Invalid Login";
		}
	}
?>
<form action="login.php" method="post" autocomplete=off>
	<input type="text" name='username'>
	<input type="text" name='pass'>
	<input type="submit" value="Login" name='lgn'>
</form>