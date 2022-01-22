<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="mycss.css" />
</head>
<body style="background:black; color :white;">
	<div id="Yeabsiras">
		<div>
		<?php
		$bitch="bitch";
		$name="yared101";
		$servername = "localhost";
		$username = "root";
		$password = "";
		$database="dating_site";
		$con = mysqli_connect($servername,$username,$password,$database);
		if (!$con) 
		{
		    die("Connection failed: Error 404");
		}
		$sqlval="select * from type where user_name='".$name."'";
		$sex="";
		$sql= mysqli_query($con,$sqlval);
		$type= mysqli_fetch_row($sql);
		$sqlval="select sex from user where user_name='".$name."'";
		$sex="";
		$sql= mysqli_query($con,$sqlval);
		$rows = mysqli_fetch_row($sql);
		$sex=$rows[0];

		$sqlval="select location from user where user_name='".$name."'";
		$sql = mysqli_query($con,$sqlval);
		$rows = mysqli_fetch_row($sql);
		$location=$rows[0];

		$sqlval="select age from user where user_name='".$name."'";
		$sql = mysqli_query($con,$sqlval);
		$rows = mysqli_fetch_row($sql);
		$age=$rows[0];
		$minage="";
		$maxage="";
		if($sex=='m')
		{
			$minage=$age-5;
			$maxage=$age+2;
		}
		else
		{
			$minage=$age-2;
			$maxage=$age+5;
		}
		$sqlval="select * from user where sex<>"."'$sex'"." and location like \""."%"."$location%"."\""." and age>= $minage and age<= $maxage";
		$sql = mysqli_query($con,$sqlval);
		$num= mysqli_num_rows($sql);
		$tots=array();
		$ranks=array();
		for($i=0;$i<$num;$i++)
		{
			$tots[$i]= mysqli_fetch_row($sql);
			$ranks[$i]=0;
			if($sex=='m')
			{
				if($age>$tots[$i][2])
					$ranks[$i]+=100;
				else if($age==$tots[$i][2])
					$ranks[$i]+=80;
				else 
					$ranks[$i]+=60;
			}
			else
			{
				if($age>$tots[$i][2])
					$ranks[$i]+=60;
				else if($age==$tots[$i][2])
					$ranks[$i]+=80;
				else 
					$ranks[$i]+=100;
			}
			$username=$tots[$i][0];
			$sqlval="select * from identity where user_name='$username'";
			$sqlp = mysqli_query($con,$sqlval);
			$tots[$i] = mysqli_fetch_row($sqlp);
		}
		$vals=array();
		for($i=0;$i<$num;$i++)
		{
			$arr=array();
			$arr[1]=$arr[4]=$arr[6]=80;
			$arr[2]=$arr[3]=$arr[5]=60;
			$arr[7]=70;
			for($j=1;$j<8;$j++)
			{
				if(!strcasecmp( $type[$j] , $tots[$i][$j] ))
				{
					$ranks[$i]+=$arr[$j];
				}
			}
			$vals[$tots[$i][0]]=$ranks[$i];
		}
		//echo $vals['leela101'];
		arsort($vals);
		$fuser=array();
		$o=0;
		foreach($vals as $x => $x_value)
		{
			 $fuser[$o]=$x;
			 $o++;
		}
		$id=array();
		$me=array();
		for($i=0;$i<$num;$i++)
		{
			$fuse=$fuser[$i];
			$sqlval="select * from identity where user_name='$fuse'";
			$sql = mysqli_query($con,$sqlval);
			$id= mysqli_fetch_row($sql);
			$sqlval="select * from user where user_name='$fuse'";
			$sql = mysqli_query($con,$sqlval);
			$me = mysqli_fetch_row($sql);
			echo<<<_END

			<div class="sugi" id="sugi
_END;
			echo$i;
			echo<<<_END
" style="
_END;
			echo "background-size:100% 100%;background-image:url('images/ $fuser /');";
			echo<<<_END
">
		<div id="profile"><img src="this.png" style="width:100%;height:100%; object-fit:fit;"></div>
			<div class="links">
				<a href="
_END;
			echo "";
			echo<<<_END
">
					<span>$me[0]</span><br><br>
					<span>$me[2]</span><br><br>
					<span>$id[4]</span><br><br>
					<span>$id[5]</span><br><br>
					<span>$id[1]</span><br><br>
					<span>$id[7]</span><br><br>
					<span>$me[7]</span><br><br>
				</a>
			</div>
			</div>
_END;
		}
				
		 ?>
	</div>
	<script type="text/javascript" src="myjs.js"></script>
</body>
</html>