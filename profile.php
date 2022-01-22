<html>
<head>
	<?php
		include_once "connection.php";
	?>
	<title><?php echo $appname?></title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/smallstyle.css">
</head>
<body>
	<?php
		include_once "header.php";
		
		if(isset($_POST["ppicsbt"])) {
			if(isset($_FILES)) {
				$img = sanitizeString($con,$_FILES['ppicval']['name']);
				if($img != "") {
					if(!file_exists("imgs/$username"))
						mkdir("imgs/$username");
					if(isset($_FILES["ppicval"]["name"])) {
						move_uploaded_file($_FILES["ppicval"]["tmp_name"],"imgs/$username/$img");
						mysqli_query($con,"update user set img='$img' where user_name='$username'");
					} else dmsg("file err");
				} else dmsg("message empty");
			} else dmsg("not file");
		}
		if(isset($_POST["albpicsbt"])) {
			if(isset($_FILES)) {
				$img = sanitizeString($con,$_FILES['albpicval']['name']);
				if($img != "") {
					if(!file_exists("imgs/$username"))
						mkdir("imgs/$username");
					if(isset($_FILES["albpicval"]["name"])) {
						move_uploaded_file($_FILES["albpicval"]["tmp_name"],"imgs/$username/$img");
						dmsg("Successfull");
					} else dmsg("Failed To Upload file");
				}
			}
		}
		$genprofsuccmsg = "";
		$genproferrmsg = "";
		if(isset($_POST["genprofsbt"])) {
			$fullname	= sanitizeString($con,$_POST["fullname"]);
			$bio		= sanitizeString($con,$_POST["bio"]);
			$age		= sanitizeString($con,$_POST["age"]);
			$phone		= sanitizeString($con,$_POST["phone"]);
			$email		= sanitizeString($con,$_POST["email"]);
			$location	= sanitizeString($con,$_POST["location"]);
			if(isset($_POST["sex"])) {
				$sex = sanitizeString($con,$_POST["sex"]);
				mysqli_query($con,"update user set sex='$sex' where user_name='$username'");
			}
			
			if($fullname != "" && $bio != "" && $age != "" && $phone != "" && $email != "" && $location != "") {
				mysqli_query($con,"update user set full_name='$fullname',age='$age',phone='$phone',email='$email',location='$location',bio='$bio' where user_name='$username'");
				$genprofsuccmsg = "Successfull :) ";
			} else {
				$genproferrmsg = "Error : All fields must be entered!";
			}
		}
		
		$identproferrmsg = "";
		$identprofsuccmsg = "";
		$typeproferrmsg = "";
		$typeprofsuccmsg = "";
		
		if(isset($_POST["identsbt"])) {
			$music = sanitizeString($con,$_POST["music"]);
			$favsport = sanitizeString($con,$_POST["favsport"]);
			$favmovie = sanitizeString($con,$_POST["favmovie"]);
			$religion = sanitizeString($con,$_POST["religion"]);
			$status = sanitizeString($con,$_POST["status"]);
			$workstatus = sanitizeString($con,$_POST["workstatus"]);
			$hobby = sanitizeString($con,$_POST["hobby"]);
			
			if(!mysqli_num_rows(mysqli_query($con,"select * from identity where user_name='$username'"))) {
				mysqli_query($con,"insert into identity(user_name) values('$username')");
			}
			$sq = mysqli_query($con,"update identity set music_type='$music',fav_sport='$favsport',movie_type='$favmovie',religion='$religion',status='$status',work_status='$workstatus',hobby='$hobby' where user_name='$username'");
			if($sq) $identprofsuccmsg = "Successfull";
			else $identproferrmsg = "Failed submiting the form";
		}
		if(isset($_POST["typesbt"])) {
			$music = sanitizeString($con,$_POST["music"]);
			$favsport = sanitizeString($con,$_POST["favsport"]);
			$favmovie = sanitizeString($con,$_POST["favmovie"]);
			$religion = sanitizeString($con,$_POST["religion"]);
			$status = sanitizeString($con,$_POST["status"]);
			$workstatus = sanitizeString($con,$_POST["workstatus"]);
			$hobby = sanitizeString($con,$_POST["hobby"]);
			
			if(!mysqli_num_rows(mysqli_query($con,"select * from type where user_name='$username'"))) {
				mysqli_query($con,"insert into type(user_name) values('$username')");
			}
			$sq = mysqli_query($con,"update type set music_type='$music',fav_sport='$favsport',movie_type='$favmovie',religion='$religion',status='$status',work_status='$workstatus',hobby='$hobby' where user_name='$username'");
			if($sq) $typeprofsuccmsg = "Successfull";
			else $typeproferrmsg = "Failed submiting the form";
		}
	?>
	<div class="maincont">
		<div class="rightcont">
			<?php include_once "search.php" ?>
		</div>
		<?php
		if(isset($_GET["user"])) {
			$profuser = sanitizeString($con,$_GET["user"]);
			$uexist = mysqli_query($con,"select * from user where user_name='$profuser'");
			$rows = mysqli_fetch_row($uexist);
			$profname = $rows[1];
			
		echo <<<_END
		<div class="midcont">
			<div>
				<div class="frontbig">
					<div class='cover'>
						
						<span>
_END;
						if($username == $profuser)
							echo "
							<a id='changepic' class='button'>Change Pic</a>
						"; else {
							$frndsql = mysqli_query($con,"select * from contact where user_name='$profuser' AND friend='$username' || user_name='$username' && friend='$profuser'");
							$frndrow = mysqli_fetch_row($frndsql);
							if($frndrow) {
								if($frndrow[0] == "$username") {
									if($frndrow[2] == '0') {
										echo "<a href='profile.php?user=$profuser&unfrnd' class='button'>Cancel Request</a>";
									} else echo "<a href='profile.php?user=$profuser&unfrnd' class='button'>UnFriend</a> <a href='index.php?message=$profuser' class='button'>Chat</a>";
								} else {
									if($frndrow[2] == '0') {
										echo "<a href='profile.php?user=$profuser&conffrnd' class='button'>Accept</a>";
										echo "<a href='profile.php?user=$profuser&unfrnd' class='button'>Refuse</a>";
									} else echo "<a href='profile.php?user=$profuser&unfrnd' class='button'>UnFriend</a> <a href='index.php?message=$profuser' class='button'>Chat</a>";
								}
							} else {
								echo "<a href='profile.php?user=$profuser&reqfrnd' class='button'>Add Friend</a>";
							}
						}
		echo <<<_END
						</span>
						
						<div class="ppcont">
							<span class="pic">
_END;
						$sql = mysqli_query($con,"select * from user where user_name='$profuser'");
						$rows = mysqli_fetch_row($sql);

						if($rows[9]=='Open' || $rows[9]=='') {
							echo "
								<img src='imgs/defaultprofile.png' class='ppic'>
							";
						} else echo "
								<img src='imgs/$profuser/$rows[9]' class='ppic'>
						";
		echo <<<_END
							</span>
							<span class="name">
								<span>
									$profname
								</span>
								<span>
									@$profuser
								</span>
							</span>
						</div>
					</div>
				</div>
				<br />
				<br />
				<br clear="both">
				<br />
				<ul>
					<a href="?user=$profuser&viewprofile"><li>View Profile</li></a>
_END;
				if($username == $profuser) echo "
					<a href='?user=$profuser&editprofile'><li>Edit Profile</li></a>
				";
		echo <<<_END
					<a href="?user=$profuser&viewphotos"><li>Photos</li></a>
					<a href="?user=$profuser&viewfriends"><li>Friends</li></a>
				</ul>
				<div class="profcont">
_END;
					if(isset($_GET["viewprofile"])) {
						$val = sanitizeString($con,$_GET["viewprofile"]);

						$sql = mysqli_query($con,"select * from user where user_name='$profuser'");
						$rows = mysqli_fetch_row($sql);
						echo "
					<div>
						<span>
							<h3>Biography</h3>
							<p style='max-width: 330px;'>
								$rows[7]
							</p>
						</span>
						<ul class='list'>
							<li><span onclick='list(this)'> > &nbsp; General</span>
								<div class='profactive'>
									<table>
										<tr>
											<td>Sex: </td>
											<td>$rows[3]</td>
										</tr>
										<tr>
											<td>Age: </td>
											<td>$rows[2]</td>
										</tr>
										<tr>
											<td>Phone: </td>
											<td>$rows[4]</td>
										</tr>
										<tr>
											<td>Email: </td>
											<td>$rows[5]</td>
										</tr>
										<tr>
											<td>Location: </td>
											<td>Utopia</td>
										</tr>
									</table>
								</div>
							</li>
						";
						
						
						$sql = mysqli_query($con,"select * from identity where user_name='$profuser'");
						$rows = mysqli_fetch_row($sql);
						
						
						echo"
							<li><span onclick='list(this)'> > &nbsp; Identity</span>
								<div class='profactive'>
						";
					if(identfilled($con,$profuser) == "good") {
						echo "
									<table>
										<tr>
											<td>Music Type: </td>
											<td>$rows[1]</td>
										</tr>
										<tr>
											<td>Fav Sport: </td>
											<td>$rows[2]</td>
										</tr>
										<tr>
											<td>Movie Type: </td>
											<td>$rows[3]</td>
										</tr>
										<tr>
											<td>Religion: </td>
											<td>$rows[4]</td>
										</tr>
										<tr>
											<td>R/n Status: </td>
											<td>$rows[5]</td>
										</tr>
										<tr>
											<td>Work Status: </td>
											<td>$rows[6]</td>
										</tr>
										<tr>
											<td>Hobby: </td>
											<td>$rows[7]</td>
										</tr>
						";
					} else echo "<div style='padding: 40px 20px; text-align: center; font-weight: bold; color: #888;'>Not Filled</div>";

						echo"
									</table>
								</div>
							</li>
						";

					$sql = mysqli_query($con,"select * from type where user_name='$profuser'");
					$rows = mysqli_fetch_row($sql);
						
						echo"
							<li><span onclick='list(this)'> > &nbsp; Type</span>
								<div class='profactive'>
						";
					if(typefilled($con,$profuser) == "good") {
						echo "
									<table>
										<tr>
											<td>Music Type: </td>
											<td>$rows[1]</td>
										</tr>
										<tr>
											<td>Fav Sport: </td>
											<td>$rows[2]</td>
										</tr>
										<tr>
											<td>Movie Type: </td>
											<td>$rows[3]</td>
										</tr>
										<tr>
											<td>Religion: </td>
											<td>$rows[4]</td>
										</tr>
										<tr>
											<td>R/n Status: </td>
											<td>$rows[5]</td>
										</tr>
										<tr>
											<td>Work Status: </td>
											<td>$rows[6]</td>
										</tr>
										<tr>
											<td>Hobby: </td>
											<td>$rows[7]</td>
										</tr>
						";
					} else echo "<div style='padding: 40px 20px; text-align: center; font-weight: bold; color: #888;'>Not Filled</div>";

						echo"
									</table>
								</div>
							</li>
						</ul>

					</div>
							";

						if($val == "general") {
							echo "
								<script>
									var prvlst = document.getElementsByClassName('list')[0];
									prvlst.children[0].children[1].className = 'profactive';
									prvlst.children[1].children[1].className = '';
									prvlst.children[2].children[1].className = '';
								</script>
							";
						} else if($val == "identity") {
							echo "
								<script>
									var prvlst = document.getElementsByClassName('list')[0];
									prvlst.children[0].children[1].className = '';
									prvlst.children[1].children[1].className = 'profactive';
									prvlst.children[2].children[1].className = '';
								</script>
							";
						} else if($val == "type") {
							echo "
								<script>
									var prvlst = document.getElementsByClassName('list')[0];
									prvlst.children[0].children[1].className = '';
									prvlst.children[1].children[1].className = '';
									prvlst.children[2].children[1].className = 'profactive';
								</script>
							";
						} else {
							echo "
								<script>
								<script>
									var prvlst = document.getElementsByClassName('list')[0];
									prvlst.children[0].children[1].className = 'profactive';
									prvlst.children[1].children[1].className = '';
									prvlst.children[2].children[1].className = '';
								</script>
								</script>
							";
						}

					} else if(isset($_GET["editprofile"])) {

						$val = sanitizeString($con,$_GET["editprofile"]);

							$sql = mysqli_query($con,"select * from user where user_name='$profuser'");
							$rows = mysqli_fetch_row($sql);
							echo "
					<div>
						<ul style='display: block;' class='list'>
							<li><span onclick='list(this)'> > &nbsp; General</span>
								<div class='profactive'>
									<form action='' method='post'>
									<table width='90%'>
										<tr>
											<td></td>
											<td>
												<span class='errmsg'>$genproferrmsg</span>
												<span class='succmsg'>$genprofsuccmsg</span>
											</td>
										</tr>
										<tr>
											<td>Full Name : </td>
											<td><input type='text' value='$rows[1]' name='fullname'></td>
										</tr>
										<tr>
										<tr>
											<td>Bio : </td>
											<td><textarea style='max-width: 400px;' name='bio'>$rows[7]</textarea></td>
										</tr>
										<tr>
											<td>Age : </td>
											<td>
												<input type='number' min=18 max=99 value='$rows[2]' name='age'>
											</td>
										</tr>
							";
							$sexsql = mysqli_query($con,"select sex from user where user_name='$rows[0]'");
							if(mysqli_fetch_row($sexsql)[0] == 'm' || mysqli_fetch_row($sexsql)[0] == 'f') {
								
							} else {
							echo "
										<tr>
											<td>Sex : </td>
											<td>
												<select name='sex'>
													<option value='m'>Male</option>
													<option value='f'>Female</option>
												</select>
											</td>
										</tr>
							";
							}
							echo "
										<tr>
											<td>Phone : </td>
											<td>
												<input type='text' value='$rows[4]' name='phone'>
											</td>
										</tr>
										<tr>
											<td>Email : </td>
											<td>
												<input type='email' value='$rows[5]' name='email'>
											</td>
										</tr>
										<tr>
											<td>Location : </td>
											<td><input type='text' value='$rows[6]' name='location'></td>
										</tr>
										<tr>
											<td></td>
											<td><input type='submit' value='change' name='genprofsbt'></td>
										</tr>
									</table>
									</form>
								</div>
							</li>
							<li><span onclick='list(this)'> > &nbsp; Identity</span>
							";
								$sql = mysqli_query($con,"select * from identity where user_name='$profuser'");
								$rows = mysqli_fetch_row($sql);
							echo "
								<div>
									<form action='' method='post'>
									<table width='90%'>
										<tr>
											<td></td>
											<td>
												<span class='errmsg'>$identproferrmsg</span>
												<span class='succmsg'>$identprofsuccmsg</span>
											</td>
										</tr>
										<tr>
											<td> Music Type : </td>
											<td>
							";
							echo '
									<input style="width:65%;" type="text" list="music" name="music" value="'.$rows[1].'">
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

							';
							echo "
											</td>
										</tr>
										<tr>
											<td>Fav Sport : </td>
											<td><input type='text' name='favsport' value='$rows[2]'></td>
										</tr>
										<tr>
											<td>Movie Genre : </td>
											<td>
												<input type='text' name='favmovie' value='$rows[3]'>
											</td>
										</tr>
										<tr>
											<td>Religion : </td>
											<td>
							"; echo '
												<input style="width:65%;" type="text" list="religion" name="religion" value="'.$rows[4].'">
												<datalist id="religion">
													<option value="i do not care"></option>
													<option value="muslim"></option>
													<option value="catholic"></option>
													<option value="protectant"></option>
													<option value="orthodox"></option>
													<option value=""></option>
													<option value=""></option>
												</datalist>
							';
							echo "
											</td>
										</tr>
										<tr>
											<td>Status : </td>
											<td>
							";
							echo '
											<select name="status">
												<option value="single">single</option>
												<option value="divorced">divorced</option>
												<option value="widow/er">widow/er</option>
											</select>
							';
							echo "
											</td>
										</tr>
										<tr>
											<td>Work Status : </td>
											<td>
							";
							echo '
											<select name="workstatus">
												<option value="employed">employed</option>
												<option value="unemployed">unemployed</option>
												<option value="student">student</option>
											</select>
							';
							echo "
											</td>
										</tr>
										<tr>
											<td>Hobby : </td>
											<td>
										<input style='width:65%;' type='text' list='hobby' name='hobby' value='$rows[7]'>
										"; echo '
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
										'; echo "

											</td>
										</tr>
										<tr>
											<td></td>
											<td><input type='submit' value='submit' name='identsbt'></td>
										</tr>
									</table>
									</form>
								</div>
							</li>
							<li><span onclick='list(this)'> > &nbsp; Type</span>
							";
								$sql = mysqli_query($con,"select * from type where user_name='$profuser'");
								$rows = mysqli_fetch_row($sql);
							echo "
								<div>
									<form action='' method='post'>
									<table width='90%'>
										<tr>
											<td></td>
											<td>
												<span class='errmsg'>$typeproferrmsg</span>
												<span class='succmsg'>$typeprofsuccmsg</span>
											</td>
										</tr>
										<tr>
											<td> Music Type : </td>
											<td>
							";
							echo '
									<input style="width:65%;" type="text" list="music" name="music" value="'.$rows[1].'">
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

							';
							echo "
											</td>
										</tr>
										<tr>
											<td>Fav Sport : </td>
											<td><input type='text' name='favsport' value='$rows[2]'></td>
										</tr>
										<tr>
											<td>Movie Genre : </td>
											<td>
												<input type='text' name='favmovie' value='$rows[3]'>
											</td>
										</tr>
										<tr>
											<td>Religion : </td>
											<td>
							"; echo '
												<input style="width:65%;" type="text" list="religion" name="religion" value="'.$rows[4].'">
												<datalist id="religion">
													<option value="i do not care"></option>
													<option value="muslim"></option>
													<option value="catholic"></option>
													<option value="protectant"></option>
													<option value="orthodox"></option>
													<option value=""></option>
													<option value=""></option>
												</datalist>
							';
							echo "
											</td>
										</tr>
										<tr>
											<td>Status : </td>
											<td>
							";
							echo '
											<select name="status">
												<option value="single">single</option>
												<option value="divorced">divorced</option>
												<option value="widow/er">widow/er</option>
											</select>
							';
							echo "
											</td>
										</tr>
										<tr>
											<td>Work Status : </td>
											<td>
							";
							echo '
											<select name="workstatus">
												<option value="employed">employed</option>
												<option value="unemployed">unemployed</option>
												<option value="student">student</option>
											</select>
							';
							echo "
											</td>
										</tr>
										<tr>
											<td>Hobby : </td>
											<td>
										<input style='width:65%;' type='text' list='hobby' name='hobby' value='$rows[7]'>
										"; echo '
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
										'; echo "

											</td>
										</tr>
										<tr>
											<td></td>
											<td><input type='submit' value='submit' name='typesbt'></td>
										</tr>
									</table>
									</form>
								</div>
							</li>
						</ul>
					</div>
							";

						if($val == "general") {
							echo "
								<script>
									var prvlst = document.getElementsByClassName('list')[0];
									prvlst.children[0].children[1].className = 'profactive';
									prvlst.children[1].children[1].className = '';
									prvlst.children[2].children[1].className = '';
								</script>
							";
						} else if($val == "identity") {
							echo "
								<script>
									var prvlst = document.getElementsByClassName('list')[0];
									prvlst.children[0].children[1].className = '';
									prvlst.children[1].children[1].className = 'profactive';
									prvlst.children[2].children[1].className = '';
								</script>
							";
						} else if($val == "type") {
							echo "
								<script>
									var prvlst = document.getElementsByClassName('list')[0];
									prvlst.children[0].children[1].className = '';
									prvlst.children[1].children[1].className = '';
									prvlst.children[2].children[1].className = 'profactive';
								</script>
							";
						} else {
							echo "
								<script>
								<script>
									var prvlst = document.getElementsByClassName('list')[0];
									prvlst.children[0].children[1].className = 'profactive';
									prvlst.children[1].children[1].className = '';
									prvlst.children[2].children[1].className = '';
								</script>
								</script>
							";
						}

						} else if(isset($_GET["viewfriends"])) {
							$sql = mysqli_query($con,"select * from contact where user_name='$profuser' || friend='$profuser' AND approved=1");
							$num = mysqli_num_rows($sql);
							
							if(!$num) echo "<div style='padding: 40px 20px; text-align: center; font-weight: bold; color: #888;'>No Friends</div>";
							
							echo "
					<div>
						<table class='frndlst'>
							";
							for($i=0;$i<$num;$i++) {
								$rows = mysqli_fetch_row($sql);
								if($rows[0] == "$profuser")
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
									<a href='index.php?message=$frnd' style='border: 0;'>
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
						} else if(isset($_GET["viewphotos"])) {
							echo "
					<div class='albcont'>
						<div>
						";
						if(file_exists("imgs/$profuser")) {
							$imgs = glob("imgs/$profuser/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
							foreach($imgs as $img) {
								echo "<span><img src='$img' alt='Loading Image'></span>";
							}
						} else
							echo "<div style='padding: 40px 20px; text-align: center; font-weight: bold; color: #888;'>No Photos</div>";

						echo "
						</div>
					</div>
							";
						} else {
							echo "<meta http-equiv='refresh' content='0;url=profile.php?user=$profuser&viewprofile'>";
						}
					echo <<<_END
						<script>
							var prvlst = document.getElementsByClassName('profactive')[0];
							list(prvlst);
							function list(ev) {
								prvlst.style.height = "0px";
								prvlst.style.padding = "0px";
								if(ev.parentNode.children[1].style.height == "auto") {
									ev.parentNode.children[1].style.height = "0px";
									ev.parentNode.children[1].style.padding = "0px";
								} else {
									ev.parentNode.children[1].style.height = "auto";
									ev.parentNode.children[1].style.padding = "10px 50px";
								}
								prvlst = ev.parentNode.children[1];
							}
						</script>
				</div>
				<br clear="both" />
			</div>
		</div>
_END;
		} else {
			echo "<meta http-equiv='refresh' content='0;url=?user=$username'>";
		}
		?>
	</div>
	<div class="picmodal_cont">
		<div class='picmodal'>
			<form action='' method='post' enctype="multipart/form-data">
				<h3>Change Profile Pic</h3>
				<input type='file' name='ppicval'>
				<input type='submit' name='ppicsbt' value='Change'>
			</form>
			<form action='' method='post' enctype="multipart/form-data">
				<h3>Add Album Photo</h3>
				<input type='file' name='albpicval'>
				<input type='submit' name='albpicsbt' value='+'>
			</form>
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