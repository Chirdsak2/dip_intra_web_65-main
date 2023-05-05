<?php
include("admin.php");
?>
<?php
if($Flag == "Change"){
$datatxt = "<"."?\n";
$datatxt .= "$"."username = \"".$uname."\";"."\n";
$datatxt .= "$"."password = \"".$pass."\";"."\n";
$datatxt .= "?".">";

$fw1 = @fopen("config.php","w");
if(!$fw1){ die("Cannot write list"); }
$FlagW1 = fwrite($fw1,$datatxt);
@fclose($fw1);
$TR = "1";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Vote Administrator</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="onbody.css" type="text/css">
</head>

<body leftmargin="0" topmargin="0">
<?php
include("menu.php");
?><br>
	<?php if($TR == "1"){ ?>
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="normal_font">
  <tr>
    <td bgcolor="#CCCCCC"><div align="center">Change Username &amp; Password Successfully</div></td>
  </tr>
</table>
<?php } ?>
<?php include("config.php"); ?>
	 <br>
	 <div align="center">
      <form name="form1" method="post" action="password.php" onSubmit="return CHK();">
	<FIELDSET style="width: 500; text-align: center; ">
	<LEGEND><span class="grey_heading">Change System Username & Password</span></LEGEND>
      <table width="90%" border="0" cellspacing="0" cellpadding="2" align="center"  class="normal_font">
        <tr>
          <td width="47%"></td>
          <td width="53%">&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><span class="normal_font">Username</span> </td>
          <td><input name="uname" type="text" class="normal_font" id="or_name4" value="<?php echo $username; ?>" size="10">
</td>
        </tr>
		<tr>
          <td width="47%" align="right">Password</td>
          <td width="53%"><input name="pass" type="password" class="normal_font" id="or_name22" value="<?php echo $password; ?>" size="10"></td>
        </tr>
		<tr>
		  <td align="right">Confirm Password</td>
		  <td><input name="cpass" type="password" class="normal_font" id="or_name32" value="<?php echo $password; ?>" size="10"></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="submit" name="Submit2" value="เปลี่ยน" class="normal_font">
		    <input name="Flag" type="hidden" id="Flag" value="Change"></td>
	    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	    </tr>
      </table>
    </FIELDSET></form>
	</div>
</body>
</html>
<SCRIPT language=JavaScript>
function CHK()
{

	        var v3 = document.form1.uname.value;
 	  var v4 = document.form1.pass.value;
	        var v5 = document.form1.cpass.value;
 
		          if ( v3.length==0)
           {
           alert("Please insert New Username");
           document.form1.uname.focus();           
           return false;
           }
		   else if ( v4.length==0)
           {
           alert("Please insert New Password");
           document.form1.pass.focus();           
           return false;
           }
		          if ( v5.length==0)
           {
           alert("Please insert Confirm New Password");
           document.form1.cpass.focus();           
           return false;
           }
		   else if ( v4 != v5 )
           {
           alert("Please insert your new password and confirm");
           document.form1.cpass.select();           
           return false;
           }
        else
           return true;
}
</SCRIPT>
