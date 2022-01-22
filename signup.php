<?php

	include_once "connection.php";

	$nameerr=$passerr=$name=$pass=$repasserr=$repass="";
	$namecorrect=$passcorrect=false;
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
    	$name = $_POST['username'];
    	$pass = $_POST['pass'];
    	$repass=$_POST['re-pass'];
    	if (empty($name)) 
    	{
        	$nameerr="Name is empty <br />";
    	} 
    	else 
    	{
        	$name=finishup($name);
        	if(strlen($name)<4 || strlen($name)>15)
        	{
        		$nameerr="username length must be greater than 3 or less than 16 <br />";
        	}
        	else if(!preg_match("/^[a-zA-Z0-9]*$/",$name))
			{
				$nameerr="no spaces only letters <br />";
			}
			else
			{
				$namecorrect=true;
			}
    	}
    	if (empty($pass)) 
    	{
        	$passerr="Password is empty <br />";
    	}
    	else 
    	{
    		$pass=finishup($pass);
    		if(strlen($pass)<5 || strlen($pass)>15)
        	{
        		$passerr="password length must be greater than 4 or less than 16 <br />";
        	}
        	else if(!preg_match("/^[a-zA-Z0-9]*$/",$pass))
			{
				$passerr="numbers and letters please <br />";
			}
			else if(!preg_match("/[0-9]/",$pass))
			{
				$passerr="at least 1 number <br />";
			}
			else if(!preg_match("/[A-Z]/",$pass))
			{
				$passerr="At least 1 capital letter <br />";
			}
			else
			{
				$passcorrect=true;
			}
    	}
    	if($namecorrect)
    	{
	    	if(empty($repass))
	    	{
	    		if($passcorrect)
	    			$repasserr="confirm password please<br />";
	    	}
	    	else
	    	{
	    		if($passcorrect)
	    		{
	    			if($pass!=$repass)
	    				$repasserr="doesnt match with password <br />";
	    			else
	    			{
						$sqlval="select * from user where user_name='".$name."'";
						$sql = mysqli_query($con,$sqlval);

						$num = mysqli_num_rows($sql);
						if($num>0)
						{
							$nameerr="Username already exists choose another <br />";
						}
						else
						{
							$sqlval="INSERT INTO `user`(USER_NAME, PASSWORD) VALUES ('".$name."', '".$pass."')";
							$sql = mysqli_query($con,$sqlval);
							mysqli_query("insert into identity('user_name') value('$name')");
							mysqli_query("insert into type('user_name') value('$name')");
							$_SESSION["dtuser"] = $name;
							setCookie("dtacnt",$_SESSION["dtuser"],time()+60*60*24*30) or die("failed creating cookie");
							echo "<meta http-equiv='refresh' content='0,url=index.php'>";	
						}
	    			}
	    		}
	    		else
	    			$repasserr="fill your password please<br />";
	    	}
	    }
	}
	function finishup($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		return $data;
	}
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/logcss.css">
</head>
<body>
	<div id="top_div">
		<h1><b><i><img height="40" alt="ourlogo"src="imgs/a.png" />The Golden Date</i></b></h1>
		<div id="base_links">
			<a href="login.php">Login</a>
			<a href="signup.php">Signup</a>
		</div>
	</div>

	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	<div id="form_div">
			<div id="input_div">
				<br /><br />
				<input type="text" name="username" placeholder="username" id="username_tx" class="ins" onkeyup="checkit()">
				<div style="color:yellow;" id="username_w">
					<?php echo "$nameerr";?>
					<br/>
				</div>
				<input type="password" name="pass" placeholder="password" id="pass_tx" class ="ins" onkeyup="checkit()"><div style="color:yellow;" id="pass_w"><?php echo $passerr;?><br/></div>
				<input type="password" name="re-pass" placeholder="Confirm password" id="re-pass_tx" class ="ins" onkeyup="checkit()"><div style="color:yellow;" id="re-pass_w"><?php echo $repasserr;?><br/></div>
				<input type="submit" name="submit_this_bitch" value="Sign up" id="login_bt">
			</div>
	</div>
	</form>
</body>
</html>