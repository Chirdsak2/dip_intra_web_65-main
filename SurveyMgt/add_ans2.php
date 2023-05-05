<?php
//include("inc.php");
//include("authority.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");
include("lang_config.php"); 

$SQL1 = $db->query("SELECT * FROM p_question WHERE q_id = '$q_id'");
$PR = mysqli_fetch_array($SQL1);
?>
<html>
<head>
<title>WebAdmin</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="txt.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0"><form name="form1" method="post" action="function_qa.php" onSubmit="return GoNext();"><br>

<table width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt10">
  <tr bgcolor="B2B4BF">
    <td colspan="4" class="txt11"><div align="left"><?php echo $lang_add_question_answerrank; ?> <?php echo $PR[q_name]; ?></div></td>
  <tr bgcolor="ECEBF0">
    <td width="27%" bgcolor="ECEBF0">
        <div align="left">
          นามสกุลไฟล์ที่อนุญาตให้ Upload
        </div>
      </td>
    <td colspan="3"><input name="stype" type="text" id="stype" size="40">
      <br>
      ถ้ามีมากกว่า 1 ชนิดให้คั่นด้วยจุลภาค (,) เช่น ( doc,xls,jpg ) เป็นต้น </td>
    </tr>
  <tr bgcolor="ECEBF0">
    <td>
        <div align="left">
          ขนาดไฟล์ไม่เกิน
        </div>
      </td>
    <td colspan="3"><input name="sdef" type="text" id="sdef" value="50" size="6"> 
    MB. </td>
  </tr>
  <tr bgcolor="ECEBF0">
    <td colspan="4" bgcolor="B2B4BF"><div align="right">
        <input name="q_id" type="hidden" id="q_id" value="<?php echo $q_id; ?>">
        <input name="Flag" type="hidden" id="Flag" value="E">
        <input type="submit" name="Submit" value="<?php echo $lang_survey_save; ?>">
        <input name="reset" type="reset" value="<?php echo $lang_survey_reset; ?>">
    </div></td>
  </tr>
</table>  
</form>
</body>
</html>
<script language="JavaScript">
function GoNext(){
if(document.form1.stype.value ==""){
alert("กรุณากรอกนามสกุลไฟล์ที่อนุญาตให้ Upload");
document.form1.stype.focus();
return false;
}
}
</script>

<?php @$db->db_close(); ?>
