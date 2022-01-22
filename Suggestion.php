<!DOCTYPE html>
<html>
<head>
	<?php include_once "connection.php" ?>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/mycss_2.css" />
</head>
<body>
<body>
	<?php
		include_once "header.php";
	?>
	<div class="maincont">
		<div class="rightcont">
			<?php include_once "search.php" ?>
		</div>
		<div class="midcont">
			<span>
			<h1>Suggestions</h1>
			</span>

			<div id="Yeabsiras">
		<?php
		$name=$username;

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
		
		if(!$num) echo "<div style='padding: 40px 20px; text-align: center; font-weight: bold; color: #888;'>No Suggestions</div>";

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
			echo "background-size: cover;background-image:url('css/cover.jpg');";
			echo<<<_END
">
		<div id="profile">
_END;
		if($me[9]!="" && $me[9]!="Open")
			echo '<img src="imgs/'.$me[0].'/'.$me[9].'" style="width:100%;height:100%; object-fit:fit;">';
		else echo '<img src="imgs/defaultprofile.png" style="width:100%;height:100%; object-fit:fit;">';
			echo <<<_END
		</div>
			<div class="links">
				<a href="profile.php?user=$me[0]&viewprofile">
_END;
			if($me[0]!="")
				echo "<span>Username : $me[0]</span>";
			if($me[2]!="")
				echo "<span>Age : $me[2]</span>";
			if($id[4]!="")
				echo "<span>Religion : $id[4]</span>";
			if($id[5]!="")
				echo "<span>R/n Status : $id[5]</span>";
			if($id[1]!="")
				echo "<span>Fav Music Genre : $id[1]</span>";
			if($id[7]!="")
				echo "<span>Hobby : $id[7]</span>";
			if($me[7]!="")
				echo "<span>Bio : $me[7]</span>";

			echo<<<_END
				</a>
			</div>
			</div>
_END;
		}
				
		 ?>
			</div>
		</div>
	</div>
	<script>
		document.addEventListener("click",function(ev) {
			if(ev.target.className == "picmodal_cont") {
				ev.target.style.display = "none";
			}
			if(ev.target.id == "changepic") {
				document.getElementsByClassName("picmodal_cont")[1].style.display = "block";
			}
			if(ev.target.tagName == "IMG") {
				document.getElementsByClassName("picmodal_cont")[0].style.display = "block";
				var cont = document.getElementById("modalpic");
				cont.src = ev.target.src;
			}
		});
	</script>
	<script type="text/javascript" src="myjs.js">
	</script>
</body>
</html>