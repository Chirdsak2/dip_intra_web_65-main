<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("language/language.php");

	//==================================================================
	if($fa_id){ $fa_id = checkNumeric($fa_id); }
	if($_GET["fa_id"]){ $_GET["fa_id"] = checkNumeric($_GET["fa_id"]); }
	if($_POST["fa_id"]){ $_POST["fa_id"] = checkNumeric($_POST["fa_id"]); }
	//==================================================================
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
.style1 {
	color: #993333;
	font-weight: bold;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">

 <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B07331" >
 	<tr>
 		<td>
				 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
				   <?php
				$Execsql1 = $db->query("SELECT * FROM faq   WHERE fa_id = '$fa_id'");
				$QQ= $db->db_fetch_array($Execsql1);
				?>
					 <tr >
					  <td  width="10%" valign="TOP"  bgcolor="#FFFFFF"><img src="mainpic/faq.gif"> </td>   
					 <td  width="90%" valign="TOP" bgcolor="#FFFFFF" > <span class="style1"><font size="6">FAQ</font></span><br>
					  <strong><font size="2" face="Tahoma"><?php echo $text_genfaq_catfaq;?> "<?php echo $QQ[f_cate]; ?>"  
					   <br>  
					   <?php echo $text_genfaq_subfaq;?> "<?php echo $QQ[f_subcate]; ?>" <br>
					   <?php echo $text_genfaq_toadmin;?></font></strong></td>   
					</tr>
				</table>
		</td>
	</tr>
</table>
  <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
    <td height="25" bgcolor="#CCCCCC" background="mainpic/toolbars.gif">&nbsp; <strong><?php echo $text_genfaq_adddetail;?></strong></td>
    </tr>
  <tr>
    <td valign="top" colspan="2"> 
	<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#333333" class="normal_font">
                  <form name="faq_add" method="post" action="faq_function.php">
                    <tr bgcolor="#FFFFFF"> 
                      <td width="17%" bgcolor="#F8F8F8"><?php echo $text_genfaq_question2;?></td>
                      <td width="83%"><textarea name="fname" cols="50" rows="3" wrap="VIRTUAL" id="fname"></textarea></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8"><?php echo $text_genfaq_detail;?></td>
                      <td><textarea name="fdetail" cols="50" rows="4" wrap="VIRTUAL" id="fdetail"></textarea></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8"><?php echo $text_genfaq_questionby;?></td>
                      <td><input type="text" name="fask" size="40" value="<?php echo $_SESSION["EWT_NAME"]?>"></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8"><?php echo 'e-mail';?></td>
                      <td><input type="text"  name="email" cols="50" rows="5" wrap="VIRTUAL" id="email"></textarea></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8">&nbsp;</td>
                      <td> <input type="submit" name="Submit" value="<?php echo $text_general_submit;?>"> 
                        <input name="flag" type="hidden" id="flag" value="addfaq_sub"> 
                        <input name="fa_id" type="hidden" id="fa_id" value="<?php echo $fa_id; ?>"> </td>
                    </tr>
                  </form>
                </table></td>
  </tr>
</table>	  </td> 
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</body>
</html>
<script language="JavaScript">
function CHK(){
if(document.form1.a_detail.value == ""){
alert("<?php echo $text_genfaq_adddetail;?>");
document.faq_add.a_detail.focus();
return false;
}
if(document.faq_add.t_name.value == ""){
alert("<?php echo text_genfaq_answer;?>");
document.form1.t_name.focus();
return false;
}
}
</script>
