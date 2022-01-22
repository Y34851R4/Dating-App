<?php
$str=array();
	$final=array();
	$search_str="";
	if(isset($_POST["search"]))
	{
		$search_str=$_POST['search_str'];
		if(empty($search_str))
		{

		}
		elseif(preg_match("/:+.+,+/",$search_str))
		{
			$index=0;
			$str[$index]="";
			$terminal=false;
			for ($i=0; $i < strlen($search_str); $i++) { 
				if($search_str[$i]==":")
				{ 
					$terminal=true;
					$i++;
				}
				if($search_str[$i]==",")
					$terminal=false;
				if($terminal)
				{
					$str[$index].=$search_str[$i];
					$j=$i;
					$j++;
					if($search_str[$j]==',')
					{
						$index++;
						$str[$index]="";
					}
				}
			}
		}
		else
		{
			$str[0]=$search_str;
		}
	}
	if(isset($_POST["find"]))
	{
		if(!empty($_POST['from']))
			$str[count($str)]="f" . $_POST['from'];
		else
		{
			$str[count($str)]="f" . 18;
		}
		if(!empty($_POST['to']))
		{
			$str[count($str)]="t" . $_POST['to'];
		}
		else
		{
			$str[count($str)]="f" . 99;
		}
		if(!empty($_POST['status']))
		{
			$str[count($str)]=$_POST['status'];
		}
		if(!empty($_POST['hobby']))
		{
			$str[count($str)]=$_POST['hobby'];
		}
		if(!empty($_POST['religion']))
		{
			$str[count($str)]=$_POST['religion'];
		}
		if(!empty($_POST['location']))
		{
			$str[count($str)]=$_POST['location'];
		}
		if(!empty($_POST['work']))
		{
			$str[count($str)]=$_POST['work'];
		}
		if(!empty($_POST['work']))
		{
			$str[count($str)]=$_POST['work'];
		}
		if(!empty($_POST['music']))
		{
			$str[count($str)]=$_POST['music'];
		}

	}
	$sn="localhost";
	$un="root";
	$pw="";
	$db="dating_app";
	$con=mysqli_connect($sn,$un,$pw,$db);
	if(!$con)
	{
		die("error has occured" . $con_connect_error);
	}
	else
	{
		$sql_temp="";
		if (count($str)==0) 
		{
			
		}
		else
		{
			if(preg_match("/f[0-9]{2}/",$str[0]))
			{
				$sql_temp.="user.age>=" . $str[0][1] . $str[0][2] . " or ";
				$sql_temp.="user.age<=" . $str[1][1] . $str[1][2] . " or ";
				for ($i=2; $i < count($str); $i++) 
				{
					if($str[$i]=="")
					{

					}
					else
					{
						$sql_temp.="user.user_name like '%" . $str[$i] . "%' or ";
						$sql_temp.="identity.status like '%" . $str[$i] . "%' or ";
						$sql_temp.="identity.religion like '%" . $str[$i] . "%' or ";
						$sql_temp.="user.location like '%" . $str[$i] . "%' or ";
						$sql_temp.="identity.work_status like '%" . $str[$i] . "%' or ";
						$sql_temp.="identity.music_type like '%" . $str[$i] . "%' or ";
						$sql_temp.="user.full_name like '%" . $str[$i] . "%' or ";
						if($i==count($str)-1)
						{
							$sql_temp.="identity.hobby like '%" . $str[$i] . "%'";
						}
						else
						{
							$sql_temp.="identity.hobby like '%" . $str[$i] . "%' or ";
						}
					}
				}
			}
			else
			{
				for ($i=0; $i < count($str); $i++) 
				{
					if($str[$i]=="")
					{

					}
					else
					{
						$sql_temp.="user.user_name like '%" . $str[$i] . "%' or ";
						$sql_temp.="user.full_name like '%" . $str[$i] . "%' or ";
						$sql_temp.="identity.status like '%" . $str[$i] . "%' or ";
						$sql_temp.="identity.religion like '%" . $str[$i] . "%' or ";
						$sql_temp.="user.location like '%" . $str[$i] . "%' or ";
						$sql_temp.="identity.work_status like '%" . $str[$i] . "%' or ";
						$sql_temp.="identity.music_type like '%" . $str[$i] . "%' or ";
						if($i==count($str)-1||$str[$i+1]=="")
						{
							$sql_temp.="identity.hobby like '%" . $str[$i] . "%'";
						}
						else
						{
							$sql_temp.="identity.hobby like '%" . $str[$i] . "%' or ";
						}
					}
				}
			}
		}
		$sql="select user.user_name,full_name,img,sex from user,identity where " . $sql_temp ;
		$result=mysqli_query($con,$sql);

		$sqlsex="select sex from user where user_name='" . $username . "'";
		$usersex=mysqli_query($con,$sqlsex);
		$sexvalue=null;	
		
		if($usersex!=false)
		{
			$sexvalue=mysqli_fetch_row($usersex);
		}
		if($result==false)
			$num=0;
		else
			$num=mysqli_num_rows($result);
		if($num>0)
		{
			$index=0;
			$temp=array();
			while ($num>0) 
			{
				#if there is time filter the input.....
				$value=mysqli_fetch_row($result);
				$temp[0]=$value[0];
				$temp[1]=$value[1];
				$temp[2]=$value[2];
				if($value[3]!=$sexvalue[0])
				{
					$final[$index]=$temp;
					$index++;
				}
				$num--;
			}
		}
	 }

	 if(count($final)==0)
	 {

	 }
	 else
	 {
	 	$tempbool=false;
	 	$notfinal=$final;
	 	$final=array();
	 	$final[0]=$notfinal[0];
	 	$index=0;
	 	for ($i=1; $i < count($notfinal); ++$i) 
	 	{ 
	 		
	 		if($notfinal[$i]==$username)
	 		{
				$i++;
	 		}
	 		for ($j=0; $j < count($final); $j++) 
	 		{ 
	 			$tempbool=true;
		 		if($final[$j]==$notfinal[$i])
		 		{
		 			$tempbool=false;
		 		}
	 		}
	 		if($tempbool)
	 		{
	 			$index++;
	 			$final[$index]=$notfinal[$i];
	 		}
	 	}
	 
	 }
?>
<style type="text/css">
	.filterer
	{
		display:none;
	}
	.search > div > div > button {
		border: 1px solid #333;
		padding: 5px 10px;
		color: #eee;
		border: 1px solid #333;
		background: rgba(0,0,0,0.3);
		cursor: pointer;
	}
	.search > div > div input[type='search'] {
		padding: 5px;
		border: 1px solid #333;
		background: rgba(255,255,255,0.8);
	}
	.search > div > div input[type='submit'] {
		padding: 5px;
		font-weight: bold;
		cursor: pointer;
		border: 1px solid #333;
		color: #eee;
		background: rgba(0,0,0,0.3);
	}
	.filterer {
		background: rgba(255,255,255,0.9);
		border: 1px solid #111;
		z-index: 9;
		position: absolute;
		top: 0;
	}
	.filterer > form > div input {
		border: 1px solid #aaa;
		padding: 5px;
		background: rgba(255,255,255,0.5);
	}
	.filterer > form > div input[type='submit']:hover {
		background: rgba(255,50,60,0.5);
	}
	.filterer > form > div input[type='submit'] {
		padding: 5px 15px;
		cursor: pointer;
	}
</style>
<script type="text/javascript">
	function actions()
	{
		var button = document.getElementsByClassName('filterer')[0];
		if(button.style.display == "block")
			button.style.display = "none";
		else button.style.display = "block";
	}
	function actionundu()
	{
		document.getElementsByClassName('filterer')[0].style.display="none";
	}
</script>
<div class="search" style="position: relative;font-size:20px; border-radius:12px; padding:10px; width:90%;">
	<div style="text-align:center; padding-top:15px; margin:0px;">
		<div style="display: inline-block;  ">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
				<input placeholder="Search... ( For filter use ':search,' )" type="search" size="30" name="search_str">
				<input type="submit" value="Search" onclick="actionundu()" name="search">
			</form>
		</div>
		<div class="search_filter" style="display: inline-block;">
			<button onclick="actions()" type="button"><b>Filter</b></button> 
		</div>
	</div>
	<div class="filterer" style="position:absolute; top:80%; left:0; border-radius:8px 0px 8px 0px; margin:3px; " class="filter"> 
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
			<div style="font-size:25px; text-align:center; margin:5px; padding:25px; border-radius:8px;">
				<b>FILTER</b>
			</div>
			<div style="font-size:18px; text-align:right; padding-right:10%; border-top: 1px solid #333; margin:5px;">
				
				<div style=" margin:20px 5px; padding:2px;">
					Age : 
					<input style="width:30%;" placeholder="from" type="number" name="from"> - 
					<input style="width:30%;" placeholder="to	" type="number" name="to">
				</div>
				<div style=" margin:20px 5px; padding:2px;">
					Status : 
					<input style="width:65%;" type="text" list="status" name="status">
					<datalist id="status">
						<option value="single"></option>
						<option value="divorced"></option>
						<option value="widow/er"></option>
					</datalist>
				</div>
				<div style=" margin:20px 5px; padding:2px;">
					Hobby : 
					<input style="width:65%;" type="text" list="hobby" name="hobby">
					<datalist id="hobby">
						<option value="bicycling"></option>
						<option value="cooking"></option>
						<option value="dancing"></option>
						<option value="exercise"></option>
						<option value="fishing"></option>
						<option value="golf"></option>
						<option value="horseback riding"></option>
						<option value="hunting"></option>
						<option value="motorcycling"></option>
						<option value="painting"></option>
						<option value="racing"></option>
						<option value="reading"></option>
						<option value="running"></option>
						<option value="swimming"></option>
						<option value="tennis"></option>
						<option value="theater"></option>
						<option value="traveling"></option>
						<option value="walking"></option>
						<option value="writing"></option>
					</datalist>
				</div>
				<div style=" margin:20px 5px; padding:2px;">
					Religion : 
					<input style="width:65%;" type="text" list="religion" name="religion">
					<datalist id="religion">
						<option value="i do not care"></option>
						<option value="muslim"></option>
						<option value="catholic"></option>
						<option value="protectant"></option>
						<option value="orthodox"></option>
						<option value=""></option>
						<option value=""></option>
					</datalist>
				</div>
				<div style=" margin:20px 5px; padding:2px;">
					Location : 
					<input style="width:65%;" type="text" name="location">
				</div>
				<div style=" margin:20px 5px; padding:2px;">
					Work Status : 
					<input style="width:65%;" type="text" list="work" name="work">
					<datalist id="work">
						<option value="employed"></option>
						<option value="unemployed"></option>
						<option value="student"></option>
					</datalist>
				</div>
				<div style=" margin:20px 5px; padding:2px;">
					Music Type : 
					<input style="width:65%;" type="text" list="music" name="music">
					<datalist id="music">
						<option value="pop"></option>
						<option value="rap"></option>
						<option value="hip hop"></option>
						<option value="rock"></option>
						<option value="country"></option>
						<option value="afro"></option>
						<option value="EDM"></option>
						<option value="jazz"></option>
						<option value="blues"></option>
						<option value="ambasel"></option>
						<option value="bati"></option>
						<option value="anchihoye"></option>
						<option value="tzta"></option>
					</datalist>
				</div>
				<div style=" margin:20px 5px; padding:0px;">
					<input type="submit" onclick="actionundu()" value="Find" name="find">
				</div>
			</div>		
		</form>
	</div>
</div>
<link rel="stylesheet" type="text/css" href="mycss.css">
<div id="jos" >
		<?php
			for($i=0;$i<count($final);$i++)
			{
				$finale=$final[$i];
				echo<<<_END
				<div class="searchi">
				<div class="profile">
_END;
				if($finale[2] == "" || $finale[2] == "Open") {
					echo "<img src='imgs/defaultprofile.png' style='height:100%; width:100%; object-fit:fit; '/>";
				} else echo "<img src='imgs/$finale[0]/$finale[2]' style='height:100%; width:100%; object-fit:fit; '/>";

				echo <<<_END
					</div>
				<a href="profile.php?user=$finale[0]">
					<div class="names">
						<h5 style="margin:0px;"><span class='foolname'>$finale[1]</span></h5>
						<h5 style=" margin:0px;"><span class='name'>@$finale[0]</span></h5>
					</div>
				</a>
				</div>
_END;
			}
		?>
	</div>

<style type="text/css">
#jos {
	max-height:600px;
	overflow-y: auto;
	overflow-x: auto;
}
#jos > span {
	font-weight: bold;
	padding: 5px;
	display: inline-block;
}
.searchi {
	min-width:99%;
	border:1px solid green;
	display: inline-block;
	background:-webkit-linear-gradient(left,rgba(250,0,0,0.4),rgba(250,0,0,0.2));
	padding-top: 5px;
	padding-bottom: 5px;
	border-radius:5px;
}
a {
	text-decoration: none;
	color:black;
}
.profile {
	margin:5px 15 5px 20px;
	border-radius: 100px;
	display: inline-block;
	width:55px;
	height:55px;
	background-color:gray;
	overflow:hidden;
	float:left;
	box-shadow: 0 0 5px 0 #333;
}
.names {
	float:center;
	padding-left: 5px;
	display: inline-block; 
	padding-top: 10px;
	font-family:"times new roman",times,serif;
	font-style: italic;
}
	</style>