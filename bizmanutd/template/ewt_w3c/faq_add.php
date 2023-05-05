<?php
$path = "../";
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
include($path."language/language.php");

 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
<link  href="../css/interface.css" rel="stylesheet" type="text/css">
<link id="stext" href="../css/normal.css" rel="stylesheet" type="text/css">
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
<script language="JavaScript" type="text/javascript">
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

</head>
<body>
<?php
$today=date("Y-m_d");
if($flag == "addfaq"){
		$fdetail = eregi_replace(chr(13)," <br> ", $fdetail );
		$fans = eregi_replace(chr(13)," <br> ", $fans );
		$fname = eregi_replace(chr(13)," <br> ", $fname );
$db->query("INSERT INTO faq_user (faq_user_id,f_id,faq_user_name,faq_user_detail,faq_user_ask,faq_user_ans,f_sub_id,faq_date,faq_status) VALUES ('','$f_id','$fname','$fdetail','$fask','$fans','$f_sub_id','$today','0')");
?>
<script language="JavaScript" type="text/javascript">
	alert("เพิ่มข้อมูล  FAQ เรียบร้อยแล้ว รออนุมัติ");
	window.close();
</script>
	<?
}
?>
 <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B07331" >
 	<tr>
 		<td>
				 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
				   <?
				$Execsql1 = $db->query("SELECT * FROM f_cat  inner join f_subcat  on   f_cat.f_id =f_subcat.f_id WHERE f_sub_id = '$f_sub_id'");
				$QQ= mysql_fetch_array($Execsql1);
				?>
					 <tr >
					  <td  width="10%" valign="TOP"  bgcolor="#FFFFFF"><img src="../mainpic/faq.gif" width="64" height="80"  alt="FAQ"> </td>   
					 <td  width="90%" valign="TOP" bgcolor="#FFFFFF" > <span class="style1"><font size="6">FAQ</font></span><br>
					  <font size="2" face="Tahoma"><?php echo $text_genfaq_catfaq;?> "<? echo $QQ[f_cate]; ?>"  
					   <br>  
					   <?php echo $text_genfaq_subfaq;?> "<? echo $QQ[f_subcate]; ?>" <br>
					   <?php echo $text_genfaq_toadmin;?></font></strong></td>   
					</tr>
				</table>
		</td>
	</tr>
</table>
  <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
    <td height="25" bgcolor="#CCCCCC" >&nbsp; <?php echo $text_genfaq_adddetail;?></strong></td>
    </tr>
  <tr>
    <td valign="top" colspan="2"> 
	<form name="faq_add" method="post" action="faq_add.php"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#333333" class="normal_font">
                  
                    <tr bgcolor="#FFFFFF"> 
                      <td width="17%" bgcolor="#F8F8F8"><?php echo $text_genfaq_question2;?></td>
                      <td width="83%"><textarea name="fname" cols="50" rows="3"  id="fname"></textarea></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8"><?php echo $text_genfaq_detail;?></td>
                      <td><textarea name="fdetail" cols="50" rows="4"  id="fdetail"></textarea></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8"><?php echo $text_genfaq_questionby;?></td>
                      <td><input type="text" name="fask" size="40" value="<?=$_SESSION["EWT_NAME"]?>"></td>
                    </tr>
                    <tr bgcolor="#FFFFFF" style="display:none"> 
                      <td bgcolor="#F8F8F8"><?php echo $text_genfaq_answer;?></td>
                      <td><textarea name="fans" cols="50" rows="5"  id="fans"></textarea></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8">&nbsp;</td>
                      <td> <input type="submit" name="Submit" value="<?php echo $text_general_submit;?>"> 
                        <input name="flag" type="hidden" id="flag" value="addfaq"> 
                        <input name="f_id" type="hidden" id="f_id" value="<? echo $f_id; ?>"> <input name="f_sub_id" type="hidden" id="f_sub_id" value="<? echo $f_sub_id; ?>"></td>
                    </tr>
               
                </table>   </form><a href="http://validator.w3.org/check?uri=referer"><img src="images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?></td>
  </tr>
</table>	  
</body>
</html>
