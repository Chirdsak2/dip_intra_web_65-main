<?php
if($FlagX == "UPDATE"){
$limitNewsD = "<"."?"."\n";
$limitNewsD .= "$"."myemailconfig"." = "."\"".trim($myemailis)."\"".";"."\n";
$limitNewsD .= "$"."mynameconfig"." = "."\"".trim($mynameis)."\"".";"."\n";
$limitNewsD .= "?".">";
$fw1 = @fopen($UserPath."enewsletter_email.dll", "w");
if(!$fw1){ die("Cannot write default"); }
$FlagW1 = fwrite($fw1,$limitNewsD);
@fclose($fw1);
$msg = "Y";
}

include("authority.php");
include($UserPath."enewsletter_email.dll");
?>
<html>
<head>
<title>Newsletter Group Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<SCRIPT language=JavaScript>
<!--
	 function emptyField(textObj) {
	   if (textObj.value.length == 0)
    		 return true;
	   for (var i=0; i<textObj.value.length; ++i) {
		     var ch = textObj.value.charAt(i);
		     if (ch != ' ' && ch != '	')
		        return false;
	   }
	   return true;
	 } 
	 function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
	}
function validEMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			//return false;
			if (mailObj.value.search("^.+@.+\\..+$") != -1)
				return true;
			else return false;
 		}
		return true;
	}
	function  validateForm() {
if (emptyField(document.form1.mynameis)){
				alert("<?php echo $lang_config_alert_name; ?>");
				document.form1.mynameis.focus();
				return false;
		}
if (emptyField(document.form1.myemailis)){
				alert("<?php echo $lang_config_alert_email; ?>");
				document.form1.myemailis.focus();
				return false;
		}
if(!validEMail(document.form1.myemailis)){
alert('<?php echo $lang_config_alert_email_format; ?>');
document.form1.myemailis.select();
return false;
}		
return true;
	}																														//end function()
//-->
</script>
</head>

<body bgcolor="#FFFFFF">
<?php
include('menu.php');
?><br>
<?php if($msg == 'Y') {?>
<div align="center">
  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#333333" bgcolor="ECEBF0" <?php if($msg == 'Y') {?>border="1"<?php }?>align="center">
    <tr>
      <td>    
        <div align="center"><font face="MS Sans Serif" size="2"> 
          
          <font color="#000000" size="1"><strong><?php echo $lang_data_update; ?></strong></font></font></div>
      </td>
  </tr>
</table>
</div><br>

<?php }?>
<form name="form1" method="post" action="cofig_newsletter.php" onSubmit="return validateForm();">
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="B2B4BF">
    <tr bgcolor="#33CCFF"> 
      <td height="30" bgcolor="B2B4BF"> <b><font face="MS Sans Serif" size="1">&nbsp;<?php echo $lang_config_newsletter; ?> </font></b></td>
    </tr>
    <tr> 
      <td height="49"> 
        <table width="100%" border="0" cellpadding="2" cellspacing="1">
          <tr bgcolor="ECEBF0"> 
            <td width="22%" height="38"><b><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $lang_config_name; ?></strong></font></b></td>
            <td width="78%" height="38"><input name="mynameis" type="text" id="mynameis" value="<?php echo $mynameconfig; ?>" size="60">
</td>
          </tr>
          <tr bgcolor="ECEBF0">
            <td height="38"><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><b><font face="MS Sans Serif" size="1"><?php echo $lang_config_email; ?></font><font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong></strong></font></b></font></td>
            <td height="38"><input name="myemailis" type="text" id="myemailis" value="<?php echo $myemailconfig; ?>" size="60"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr bgcolor="#33CCFF"> 
      <td bgcolor="B2B4BF" height="27"> 
        <div align="right"> 
          <input name="FlagX" type="hidden" id="FlagX" value="UPDATE">
          <input type="submit" name="Submit" value="<?php echo $lang_config_save; ?>">
        </div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
