function checkit()
{
	//alert("cool");
	var username=document.getElementById("username_tx").value;
	document.getElementById("username_w").innerHTML="<br />";
	document.getElementById("login_bt").disabled=false;
	var pass=document.getElementById("pass_tx").value;
	document.getElementById("pass_w").innerHTML="<br />";
	var repass=document.getElementById("re-pass_tx").value;
	document.getElementById("re-pass_w").innerHTML="<br />";
	//username.search(/[A-Z]/)<0
	if(username.length<5 || username.length>16)
	{
		document.getElementById("username_w").innerHTML="Not a real username";
		document.getElementById("login_bt").disabled=true;
	}
	if(pass.length<5 || pass.length>16)
	{
		document.getElementById("pass_w").innerHTML="Not a real password";
		document.getElementById("login_bt").disabled=true;
	}
	if(repass!==pass)
	{
		document.getElementById("re-pass_w").innerHTML="!!!";
		document.getElementById("login_bt").disabled=true;
	}
}