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
          <?php echo $lang_edit_textbox; ?>
        </div>
      </td>
    <td colspan="3"><input type="radio" name="de" value="S" onClick="document.all.T2.style.display='';document.all.T1.style.display='none';">
        <?php echo $lang_edit_singleline; ?>
        <br>
      <input name="de" type="radio" value="M" onClick="document.all.T1.style.display='';document.all.T2.style.display='none';" checked>
        <?php echo $lang_edit_multiline; ?>
      </td>
    </tr>
  <tr bgcolor="ECEBF0">
    <td>
        <div align="left">
          <?php echo $lang_edit_default_answer; ?>
        </div>
      </td>
    <td colspan="3"><input name="def" type="text" id="def" size="40"></td>
  </tr>
  <tr id="T1" bgcolor="ECEBF0" >
      <td>
        <?php echo $lang_edit_linenumber; ?>
      </td>
    <td width="24%"><input name="line" type="text" id="line" size="3">
        <?php echo $lang_edit_line; ?>
      </td>
      <td width="21%">
        <?php echo $lang_edit_width; ?>
      </td>
    <td width="28%"><input name="wid1" type="text" id="wid1" size="3">
        <?php echo $lang_edit_character; ?>
      </td>
  </tr>
  <tr id="T2" bgcolor="ECEBF0" style="display:none">
      <td>
        <?php echo $lang_edit_maxchar; ?>
      </td>
    <td width="24%"><input name="wor" type="text" id="wor" size="3">
        <?php echo $lang_edit_character; ?>
      </td>
      <td width="21%">
        <?php echo $lang_edit_width; ?>
      </td>
    <td width="28%"><input name="wid2" type="text" id="wid2" size="3">
        <?php echo $lang_edit_character; ?>
      </td>
  </tr>
  <tr bgcolor="ECEBF0">
    <td colspan="4" bgcolor="B2B4BF"><div align="right">
        <input name="q_id" type="hidden" id="q_id" value="<?php echo $q_id; ?>">
        <input name="Flag" type="hidden" id="Flag" value="D">
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
if(document.form1.name.value ==""){
alert("<?php echo $lang_add3_pleasequestion; ?>");
document.form1.name.focus();
return false;
}
}


function ChangeBox(c){
if(document.form1.sel.value =="D"){
document.form1.num.disabled = true;
document.form1.just.disabled = false;
}else if(document.form1.sel.value =="B"){
document.form1.just.disabled = true;
document.form1.num.disabled = false;
}else{
document.form1.just.disabled = false;
document.form1.num.disabled = false;
}
}
</script>

<?php @$db->db_close(); ?>
