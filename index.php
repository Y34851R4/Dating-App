<html>
<head>
	<?php
		include_once "connection.php";
	?>
	<title><?php echo $appname?> - Home Page</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/smallstyle.css">
</head>
<body>
	<?php
		include_once "header.php";
		
		if(isset($_POST["msgsbt"])) {
			$msg	= sanitizeString($con,$_POST["msg"]);
			$frnd	= sanitizeString($con,$_POST["sentto"]);
			if($msg != "" && $frnd !="") {
				mysqli_query($con,"insert into message values('','$username','$frnd','$msg','$time')") or die("failed sending message");
				echo "<meta http-equiv='refresh' content='0;url=index.php?message=$frnd'>";
			}
		}
		if(isset($_POST["delmsgsbt"])) {
			$msgid  = $_POST["msgid"];
			$frnd	= sanitizeString($con,$_POST["sentto"]);
			
			if($msgid != "") {
				mysqli_query($con,"delete from message where id=$msgid");
				echo "<meta http-equiv='refresh' content='0;url=index.php?message=$frnd'>";
			}
		}
		if(isset($_POST["editmsgsbt"])) {
			$msgid = $_POST["msgid"];
			$msgval = sanitizeString($con,$_POST["msgval"]);
			$frnd	= sanitizeString($con,$_POST["sentto"]);
			if($msgval != "") {
				mysqli_query($con,"update message set msg='$msgval' where id=$msgid");
				echo "<meta http-equiv='refresh' content='0;url=index.php?message=$frnd'>";
			}
		}
		if(!ready($con,$username)) {
			echo "<meta http-equiv='refresh' content='0;profile.php?user=$username&editprofile=general'>";
		}
	?>
	<div class="maincont">
		<div class="rightcont">
			<?php include_once "search.php" ?>
		</div>
		<div class="midcont chat">
			<div>
				<?php
					$val = identfilled($con,$username);
					if($val == "false exist") {
						echo "<span class='msg'>Enter Identity</span>";
					} else if($val == "bad") {
						echo "<span class='msg'>Fill Your Identity profile for better suggestion results. <a href='profile.php?user=$username&editprofile=identity'>Click Here</a></span>";
					}
					$val2 = typefilled($con,$username);
					if($val2 == "false exist") {
						echo "<span class='msg'>Enter Identity</span>";
					} else if($val2 == "bad") {
						echo "<span class='msg'>Fill Your Type profile for better suggestion results. <a href='profile.php?user=$username&editprofile=type'>Click Here</a></span>";
					}
				?>
				<table>
					<tr>
						<td><a href="?message" class='toplnk active'>Message</a></td>
						<td><a href="?friends" class='toplnk'>Friends</a></td>
					</tr>
				</table>
				<div class="chatcont">
					<?php
						if(isset($_GET["message"])) {
							echo "
								<script>
									document.getElementsByClassName('toplnk')[0].className='toplnk active';
									document.getElementsByClassName('toplnk')[1].className='toplnk';
								</script>
							";
							$val = sanitizeString($con,$_GET["message"]);
							
							if($val == "") {
							

							$sql = mysqli_query($con,"select * from contact where user_name='$username' || friend='$username' AND approved=1");
							$num = mysqli_num_rows($sql);
							
							if(!mysqli_num_rows(mysqli_query($con,"select * from message where sender='$username' || reciever='$username'"))) echo "<div style='padding: 40px 20px; text-align: center; font-weight: bold; color: #888;'>No Messages Yet</div>";
							
							$frnd = "";
							
							echo "
					<div>
						<br />
						<table class='frndlst'>
							";
							for($i=0;$i<$num;$i++) {
								$rows = mysqli_fetch_row($sql);
								if($rows[0] == "$username")
									$frnd = $rows[1];
								else $frnd = $rows[0];

								$sql2 = mysqli_query($con,"select * from message where sender='$username' && reciever='$frnd' || sender='$frnd' && reciever='$username'");
								$num2 = mysqli_num_rows($sql2);
								
								if($num2) {
									$rows2 = "";
									for($j=0;$j<$num2;$j++) {
										$rows2 = mysqli_fetch_row($sql2);
									}
							echo "
							<tr>
								<td><span class='imgCont small'>
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
									<a href='?message=$frnd'>
									$frnd
									<pre>$rows2[3]</pre>
									</a>
								</td>
								<td>($num2)</td>
							</tr>
							";
								}
							}
							echo "
						</table>
					</div>
							";
							} else {
								$val = "";
								$val = sanitizeString($con,$_GET["message"]);
								$sql = mysqli_query($con,"select * from message where sender='$username' && reciever='$val' || sender='$val' && reciever='$username'");
								$num = mysqli_num_rows($sql);

								echo "
						<a href='profile.php?user=$val'>
						<span class='header'>
							$val";
							if($val == $username) echo " (You)";
							echo "
						</span>
						</a>
						<div class='footer'>
							<form action=\"\" method='post'>
							<div class='body'>
								";
								for($i=0;$i<$num;$i++) {
									$rows = mysqli_fetch_row($sql);
									$msgown = "";
									if($rows[1] == "$username") {
										$msgown = "ownmsg";
									} else if($rows[1] == "$val") {
										$msgown = "frndmsg";
									}
										echo "
								<span class='$msgown'>
									<pre id='$rows[0]' class='$msgown' name='$val' onclick='prop(this)'>$rows[3]</pre>
								</span>
										";
								}
								echo "
							</div>
							<span class='st'>
								<input type='hidden' name='sentto' value='$val'>
								<textarea placeholder='Message...' name='msg'></textarea>
							</span>
							<span class='st'>
								<input type='submit' value='Send' name='msgsbt'>
							</span>
							</form>
						</div>
								";
							}
						} else if(isset($_GET["friends"])) {
							echo "
								<script>
									document.getElementsByClassName('toplnk')[0].className='toplnk';
									document.getElementsByClassName('toplnk')[1].className='toplnk active';
								</script>
							";

							$sql = mysqli_query($con,"select * from contact where user_name='$username'|| friend='$username' AND approved=1");
							$num = mysqli_num_rows($sql);
							
							$frnd = "";
							
							if(!$num) echo "<div style='padding: 40px 20px; text-align: center; font-weight: bold; color: #888;'>No Friends Yet. &nbsp; <a href='suggestion.php'>Click here to see friends</a></div>";

							echo "
					<div>
						<br />
						<table class='frndlst'>
							";
							for($i=0;$i<$num;$i++) {
								$rows = mysqli_fetch_row($sql);
								if($rows[0] == "$username")
									$frnd = $rows[1];
								else $frnd = $rows[0];
							
							echo "
							<tr style='border-bottom: 1px solid #bbb;'>
								<td style='width: 10%;'>
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
								<td style='width: 50%;'>
									<a href='?message=$frnd' style='border: 0;'>
									$frnd
									<br />
									<br />
									</a>
								</td>
								<td>
									<a href='profile.php?user=$frnd&viewprofile' style='border: 0;'>
									View Profile
									</a>
								</td>
							</tr>
							";
							
							}
							echo "
						</table>
					</div>
							";
						} else {
							echo "<meta http-equiv='refresh' content='0;url=index.php?message'>";
						}
					?>
					<script>
						
						function closeprop2() {
							document.getElementById("msgprop").style.display = "none";
						}
						function closeprop(val) {
							if(val == 'disp')
								clearTimeout(t);
							else
								t = setTimeout(closeprop2,1000);
						}
						function prop(ev) {
							var msgprop = document.getElementById("msgprop");
							msgprop.innerHTML = "";
							msgprop.action = "index.php?message="+ev.getAttribute("name");
							msgprop.innerHTML += "<input type='hidden' name='msgid' value='"+ev.id+"'>";
							msgprop.innerHTML += "<input type='hidden' name='sentto' value='"+ev.getAttribute('name')+"'>";
							if(ev.className == "ownmsg") {
								msgprop.innerHTML += "<textarea placeholder='Edit Message here' name='msgval'>"+ev.innerHTML+"</textarea>";
								msgprop.innerHTML += "<input type='submit' name='editmsgsbt' value='Edit'>";
								msgprop.style.left = event.clientX-290;
							} else {
								msgprop.style.left = event.clientX;
							}
							msgprop.innerHTML += "<input type='submit' value='Delete' name='delmsgsbt'>";
							msgprop.style.display = "block";
							msgprop.style.top = event.clientY;
						}

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
				</div>
			</div>
		</div>
	</div>
</body>
</html>