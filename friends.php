<html>
<head>
	<?php include_once "connection.php"?>
	<title><?php echo $appname?></title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/smallstyle.css">
</head>
<body>
	<?php
		include_once "header.php";
	?>
	<div class="maincont">
		<div class="rightcont">
			<?php include_once "search.php" ?>
		</div>
		<div class="midcont friends">
			<div>
		<?php
			$sql = mysqli_query($con,"select * from contact where (friend='$username') AND approved=0");
			$num = mysqli_num_rows($sql);
			
			echo "
			<span><h3>Friend Requests</h3></span>
			<form action='friends.php' method='get'>
			<table>
			";
			if($num) {
				for($i=0;$i<$num;$i++) {
					$rows = mysqli_fetch_row($sql);
					if($rows[0] == $username)
						$frnd = $rows[1];
					else $frnd = $rows[0];
					echo "
						<tr>
							<td>
								<span class='imgCont small'>
					";
							$picsql = mysqli_query($con,"select * from user where user_name='$frnd'");
							$picrows = mysqli_fetch_row($picsql);

							if($picrows[9]=='Open' || $picrows[9]=='') {
								echo "
									<img src='imgs/defaultprofile.png' class='ppic'>
								";
							} else echo "
									<img src='imgs/$frnd/$picrows[9]' class='ppic'>
							";
					echo "
								</span>
							</td>
							<td>
								@$frnd
							</td>
							<td>
								<input type='hidden' value='$frnd' class='button' name='user'>
								<input type='submit' value='Confirm' class='button' name='conffrnd'>
								<input type='submit' value='Refuse' class='button' name='reffrnd'>
							</td>
						</tr>
					";
				}
			} else {
				echo "<div style='padding: 40px 20px; text-align: center; font-weight: bold; color: #eee;'>No Friend Requests</div>";
			}
			echo "
			</table>
			</form>
			";

			$sql2 = mysqli_query($con,"select * from contact where (user_name='$username' || friend='$username') AND approved=1");
			$num2 = mysqli_num_rows($sql2);

			echo "
			<span><h3>Friends List</h3></span>
			<form action='friends.php' method='get'>
			<table>
			";

			if($num2) {
				for($i=0;$i<$num2;$i++) { 
					$rows = mysqli_fetch_row($sql2);
					if($rows[0] == $username)
						$frnd = $rows[1];
					else $frnd = $rows[0];
					echo "
						<tr>
							<td>
								<span class='imgCont small'>
					";
							$picsql = mysqli_query($con,"select * from user where user_name='$frnd'");
							$picrows = mysqli_fetch_row($picsql);

							if($picrows[9]=='Open' || $picrows[9]=='') {
								echo "
									<img src='imgs/defaultprofile.png' class='ppic'>
								";
							} else echo "
									<img src='imgs/$frnd/$picrows[9]' class='ppic'>
							";
					echo "
								</span>
							</td>
							<td>
								@$frnd
							</td>
							<td>
								<input type='hidden' value='$frnd' class='button' name='user'>
								<a href='index.php?message=$frnd' class='button'>Chat</a>
								<input type='submit' value='Unfriend' class='button' name='unfrnd'>
							</td>
						</tr>
					";
				}
			} else {
				echo "<div style='padding: 40px 20px; text-align: center; font-weight: bold; color: #888;'>You Have No Friends <a href='suggestion.php'>click here for suggestion</a></div>";
			}
			echo "
			</table>
			</form>
			";

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
</body>
</html>