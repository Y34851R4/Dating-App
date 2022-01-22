<?php
	session_start();
	
	$username = "";
	$fullname = "";
	
	if(!isset($_COOKIE["dtacnt"])) {
		echo "<meta http-equiv='refresh' content='0,url=login.php'>";
	} else {
		$username = $_COOKIE["dtacnt"];
		$sql = mysqli_query($con,"select full_name from user where user_name='$username'");
		$fullname = mysqli_fetch_row($sql)[0];
		if($fullname == '') {
			$fullname = "No Name";
		}
	}
	
	function dmsg($val) {
		echo "
			<script>
				alert('$val');
			</script>
		";
	}
	function ready($con,$username) {
		$sql = mysqli_query($con,"select * from user where user_name='$username'");
		$rows = mysqli_fetch_row($sql);
		for($j=1;$j<8;$j++) {
			if($rows[$j] == "") return false;
		}
		return true;
	}
	
	function identfilled($con,$username) {
		$sql = mysqli_query($con,"select * from identity where user_name='$username'");
		$rows = mysqli_fetch_row($sql);
		for($j=1;$j<8;$j++) {
			if($rows[$j] == "") return "bad";
		}
		return "good";
	}
	function typefilled($con,$username) {
		$sql = mysqli_query($con,"select * from type where user_name='$username'");
		$num = mysqli_num_rows($sql);
		$rows = mysqli_fetch_row($sql);
		for($j=1;$j<8;$j++) {
			if($rows[$j] != "") return "good";
		}
		return "bad";
	}
	
	
	
	// Friends
	
		if(isset($_GET["reffrnd"])) {
			$frnd = sanitizeString($con,$_GET["user"]);
			if($frnd != "") {
				mysqli_query($con,"delete from contact where user_name='$username' AND friend='$frnd' || user_name='$frnd' AND friend='$username'");
				echo "<meta http-equiv='refresh' content='0;friends.php'>";
			}
		}
		if(isset($_GET["conffrnd"])) {
			$frnd = sanitizeString($con,$_GET["user"]);
			if($frnd != "") {
				mysqli_query($con,"update contact set approved=1 where (user_name='$username' AND friend='$frnd') || (user_name='$frnd' AND friend='$username')");
				echo "<meta http-equiv='refresh' content='0;friends.php'>";
			}
		}
		if(isset($_GET["unfrnd"])) {
			$frnd = sanitizeString($con,$_GET["user"]);
			if($frnd != "") {
				mysqli_query($con,"delete from contact where user_name='$username' AND friend='$frnd' || user_name='$frnd' AND friend='$username'");
				echo "<meta http-equiv='refresh' content='0;friends.php'>";
			}
		}
		if(isset($_GET["reqfrnd"])) {
			$frnd = sanitizeString($con,$_GET["user"]);
			if($frnd != "") {
				mysqli_query($con,"insert into contact values('$username','$frnd','0')");
				echo "<meta http-equiv='refresh' content='0;friends.php'>";
			}
		}

	
?>
<div class="navslide" id="asdf">
	<span id="sldbtn" onclick="navslide()">></span>
	<div>
		<div>
			<span class="imgCont">
			<?php
				$sql = mysqli_query($con,"select * from user where user_name='$username'");
				$rows = mysqli_fetch_row($sql);
				if($rows[9]=='Open' || $rows[9]=='') {
					echo "
						<img src='imgs/defaultprofile.png' class='ppic'>
					";
				} else echo "
						<img src='imgs/$username/$rows[9]' class='ppic'>
				";
			?>
			</span>
		</div>
		<span><?php echo "$fullname" ?></span>
		<br />
		<hr />
		<ul>
			<a href="index.php"><li>Home</li></a>
			<?php
			echo "
			<a href='profile.php?user=$username'><li>Profile</li></a>
			";
			echo "
			<a href='index.php?message=$username'><li>Cloud Chat</li></a>
			";
			?>
			<a href="friends.php"><li>Friend</li></a>
			<a href="suggestion.php"><li>Suggestions</li></a>
			<a href="logout.php"><li>Logout</li></a>
		</ul>
	</div>
</div>

<div class="picmodal_cont">
	<div id="viewpicmodal">
		<img id="modalpic">
	</div>
</div>

<form action='' method='post' id="msgprop" onmouseleave="closeprop('hide')" onmouseover="closeprop('disp')"></form>
<script>
	function navslide() {
		var cont = document.getElementById("asdf");
		if(cont.style.left == "0%") {
			cont.style.cssText = "right: 100%;";
			document.getElementById("sldbtn").innerHTML = ">";
		} else {
			cont.style.cssText = "left: 0%;";
			document.getElementById("sldbtn").innerHTML = "&cross;";
		}
	}
</script>