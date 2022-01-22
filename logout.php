<?php
	session_start();
	setCookie("dtacnt","",time()-1);
	session_destroy();
	echo "<meta http-equiv='refresh' content='0;login.php'>";
?>