<?php
session_start();
$username =  "admin";
$password =  "0tcc@dmin";

		if(trim($_POST["uBiz"]) == $username AND trim($_POST["uPass"]) == $password AND $_SESSION["BizAdminLogin"] != "Y" AND $_POST["BizAdmin"] == "Pass"){
			@session_register("BizAdminLogin");
			$_SESSION["BizAdminLogin"] = "Y";
		}
		
		
if($_SESSION["BizAdminLogin"] != "Y"){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Please Login</title>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style>
td {
padding:5px;	
}
label {
	float:right;
}
.login {
	border: 1px gray solid;
	width: 300px;
	padding: 20px;
	margin: auto;
	top: 30%;
	position: relative;
	background-color: #ACFF91;
	layer-background-color: #66FF33;
	border-radius: 4px;
}
#button {
	padding:5px;
	width: 80px;	
	border: 1px gray solid;
	border-radius: 4px;
}
</style>
</head>

<body>
    <div  style="position: fixed; width: 100%; height: 100%;">
        <div  class="login" >
            <form id="formB" name="formB" method="post" action="">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="30%"><label for="uBiz">Username</label></td>
                    <td><input style="clear:both; width:100%" type="text" name="uBiz" id="uBiz" /></td>
                  </tr>
                  <tr>
                    <td width="30%"><label for="uPass">Password</label></td>
                    <td><input style="clear:both; width:100%" type="password" name="uPass" id="uPass" /></td>
                  </tr>
                </table>
                <div style="width:100%; display: table;">
                  <input style="float:right; margin-right:5px" type="submit" name="Submit" id="button" value="Login" />
                  <input name="BizAdmin" type="hidden" id="BizAdmin" value="Pass" />
                </div>
            </form>
        </div>
</div>
</body>
</html>
<?php 
exit;
} ?>