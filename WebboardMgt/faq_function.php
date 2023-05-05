<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");

$Execsql = $db->query("SELECT * FROM w_question WHERE t_id = '$wtid' ");
$R = mysql_fetch_array($Execsql);
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" class="normal_font">
<?php
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);
?>
<?php 
$ExcAns = $db->query("SELECT * FROM w_answer WHERE a_id = '$waid' ORDER BY a_id ASC");
$RR = mysql_fetch_array($ExcAns); ?>
  <tr>
    <td height="25" bgcolor="#CCCCCC"><strong><a href="index_cate.php">หน้าหลักกระทู้</a> <img src="../wb_pic/arrow_r.gif" width="7" height="7" align="absmiddle"> <a href="index_question.php?wcad=<?php echo $wcad; ?>"><?php echo $QQ[c_name]; ?></a></strong></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">
	<DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"><br>
                <strong><font size="4" face="Tahoma">ส่งข้อมูลไป FAQ</font></strong> 
                <br> <br>
                <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000" class="normal_font"><form name="form1" method="post" action="question_function.php">
                  <tr bgcolor="#FFFFFF"> 
                    <td width="17%" bgcolor="#FFCC99">หมวดหลัก-หมวดย่อย</td>
					<?php $sql_faq = $db->query("SELECT * FROM f_subcat  WHERE f_parent='0'"); 
					
					function child($id,$tag){
					      global  $db;
					      $sql = $db->query("SELECT * FROM f_subcat  WHERE f_parent='$id' "); 
						  while($F=mysql_fetch_array($sql)){
					          ?><option value="<?php echo $F[f_sub_id]; ?>"><?php echo $tag.$F[f_subcate]; ?></option><?php 
							    $sql_faq = $db->query("SELECT * FROM f_subcat  WHERE f_parent='$F[f_sub_id]' "); 
								if($db->db_num_rows($sql_faq)>0){
								   child($F[f_sub_id],$tag.$tag);
								}
						  } 
					}
					
					?>
                    <td width="83%"><select name="fid" id="fid">
					<?php while($F=mysql_fetch_array($sql_faq)){ ?>
					<option value="<?php echo $F[f_sub_id]; ?>"><?php echo $F[f_subcate]; ?></option>
					<?php 
					
					    $sql_faq2 = $db->query("SELECT * FROM f_subcat  WHERE f_parent='$F[f_sub_id]' "); 
						if($db->db_num_rows($sql_faq2)>0){
						   child($F[f_sub_id],'&nbsp;&nbsp;&nbsp;&nbsp;');
						}
					
					} ?>
                        </select></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td bgcolor="#FFCC99">หัวข้อ</td>
                    <td><textarea name="fname" cols="50" rows="3" wrap="VIRTUAL" id="fname"><?php biz($R[t_name]); ?></textarea></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td bgcolor="#FFCC99">รายละเอียด</td>
                    <td><textarea name="fdetail" cols="50" rows="4" wrap="VIRTUAL" id="fdetail"><?php echo biz($R[t_detail]); ?></textarea></td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td bgcolor="#FFCC99">คำตอบ</td>
                    <td><textarea name="fans" cols="50" rows="5" wrap="VIRTUAL" id="fans"><?php biz($RR[a_detail]); ?></textarea></td>
                  </tr>
                  <tr bgcolor="#FFFFFF">
                    <td bgcolor="#FFCC99">&nbsp;</td>
                    <td>
                        <input type="submit" name="Submit" value="Submit">
                        <input name="flag" type="hidden" id="flag" value="sendfaq">
                        <input name="wcad" type="hidden" id="wcad" value="<?php echo $wcad; ?>">
                        <input name="wtid" type="hidden" id="wtid" value="<?php echo $wtid; ?>"></td>
                  </tr></form>
                </table>
              </DIV></td>
  </tr>
</table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
</div>
</body>
</html>
<script language="JavaScript">
function CHK(){
if(document.form1.a_detail.value == ""){
alert("กรุณาใส่รายละเอียด");
document.form1.a_detail.focus();
return false;
}
if(document.form1.t_name.value == ""){
alert("กรุณาใส่ชื่อ");
document.form1.t_name.focus();
return false;
}
}
</script>
<?php @$db->db_close(); ?>