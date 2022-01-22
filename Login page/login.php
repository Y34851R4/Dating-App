<?php
	$nameerr=$passerr=$name=$pass="";
	$realpassword="";
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
    	$name = $_POST['username'];
    	$pass = $_POST['pass'];
    	if (empty($name)) 
    	{
        	$nameerr="Name is empty <br />";
    	} 
    	else 
    	{
        	$name=finishup($name);
        	if(strlen($name)<5 || strlen($name)>15)
        	{
        		$nameerr="username length must be greater than 4 or less than 16 <br />";
        	}
        	else if(!preg_match("/^[a-zA-Z0-9]*$/",$name))
			{
				$nameerr="no spaces only letters <br />";
			}
			else if(true)
			{
				$servername = "localhost";
				$username = "root";
				$password = "";
				$database="dating_site";
				$con = mysqli_connect($servername,$username, $password,$database);
				if (!$con) 
				{
				    die("Connection failed: Error 404");
				}
				$sqlval="select password from user where user_name='".$name."'";
				$sql = mysqli_query($con,$sqlval);

				$num = mysqli_num_rows($sql);
				if($num>0)
				{
					for($i=0;$i<$num;$i++) 
					{
						$rows = mysqli_fetch_row($sql);
						$realpassword=$rows[0];
					}
				}
				else
				{
					$nameerr="Username not in database";
				}
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
        	else if($realpassword=="")
			{
				$passerr="";
			}
			else if($realpassword!=$pass)
			{
				$passerr="Password incorrect";
			}
			else
			{
				$passerr="You may finally sign in";
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
	<link rel="stylesheet" type="text/css" href="logcss.css">
</head>
<body>
	<div id="top_div">
		<h1><b><i><img height="40" alt="ourlogo"src="a.png" />The Golden Date</i></b></h1>
		<div id="base_links">
			<a href="">Login</a>
			<a href="http://localhost/dashboard/myphp/Login page/signup.php">Signup</a>
		</div>
	</div>

	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
	<div id="form_div">
			<div id="input_div">
				<br /><br />
				<input type="text" name="username"placeholder="username" id="username_tx" class="ins" onkeyup="checkit()"><div style="color:yellow;" id="username_w"><?php echo $nameerr;?><br/></div>
				<input type="password" name="pass" placeholder="password" id="pass_tx" class ="ins" onkeyup="checkit()"><div style ="color:yellow;"id="pass_w"><?php echo $passerr;?><br /></div><br />
				<input type="submit" name="submit_this_bitch" value="login" id="login_bt">
			</div>
	</div>
	</form>
	<div id="links_div">
		<a class="asdfa" href="">forgotpassword</a>
	</div>
</body>
</html>
