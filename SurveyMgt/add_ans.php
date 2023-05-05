<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
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
<body leftmargin="0" topmargin="0"><form action="function_qa.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return GoNext();"><br>

<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="B2B4BF" class="txt11">
  <tr bgcolor="B2B4BF" class="ewttablehead">
    <td colspan="2"><?php echo $PR[q_name]; ?><?php echo $PR[q_des]; ?></td>
    <!-- <td>คะแนน/น้ำหนัก</td> -->
    <!-- <td><div align="center"><?php echo $lang_edit_default_answer; ?></div></td> -->
  </tr>
  <?php for($i=0;$i<$num;$i++){ ?>
  <tr bgcolor="ECEBF0">
    <td width="30%"><div align="center"><?php echo $lang_add_question_answerrank; ?> <?php echo $i+1; ?></div></td>
    <td width="53%"><?php if($PR[q_anstype] != "C"){ ?><!--<input type="file" name="file<?php echo $i; ?>"><br>--><?php } ?>
        <input name="an<?php echo $i; ?>" type="text" id="an<?php echo $i; ?>" size="40"><?php if($PR[q_anstype] != "C"){ ?><br>
      <input name="ch<?php echo $i; ?>" type="checkbox" value="Y">
      <?php echo $lang_edit_type_other; ?>    <?php } ?></td>
    <!-- <td width="9%" align="center"><input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="0" size="4"></td>
    <td width="8%" align="center"><input type="radio" name="def" value="<?php echo $i+1; ?>"></td> -->
  </tr>
  <?php  }?>
  <tr bgcolor="B2B4BF">
    <td colspan="4"><div align="right">
      <input name="q_id" type="hidden" id="q_id" value="<?php echo $q_id; ?>">
      <input name="num" type="hidden" id="num" value="<?php echo $num; ?>">
      <input name="Flag" type="hidden" id="Flag" value="A">
      <input type="submit" name="Submit" value="<?php echo $lang_survey_save; ?>"><input name="reset" type="reset" value="<?php echo $lang_survey_reset; ?>">
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