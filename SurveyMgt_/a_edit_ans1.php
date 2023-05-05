<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");


$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name),p_ans.option3,p_ans.a_weight 
					FROM p_ans,p_question 
					WHERE p_question.c_id = '{$path}' AND p_question.q_id = p_ans.q_id  
					ORDER BY p_ans.option3");	

?>
<html>
<head>
<title>WebAdmin</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="txt.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0"><form name="form1" method="post" action="function_eqa1.php" ><br>

<table width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt11">
  <tr bgcolor="B2B4BF">
    <td colspan="3"><div align="left"><strong><?php echo $lang_add_question_answerforpart; ?> <?php echo $post; ?> </strong><?php echo $lang_lefttoright; ?></div>      <div align="center"></div>      <div align="center"></div></td>
    </tr>
  <?php
  $i=0;
   while($Q = mysql_fetch_array($SQL2)){ ?>
  <tr bgcolor="ECEBF0">
    <td width="30%"><div align="center"><?php echo $lang_edit_ansnumber; ?><?php echo $i+1; ?></div></td>
    <td width="50%" ><input name="an<?php echo $i; ?>" type="text" id="an<?php echo $i; ?>" value="<?php echo $Q[a_name]; ?>" size="40">
      <input name="pos<?php echo $i; ?>" type="hidden" id="pos<?php echo $i; ?>" value="<?php echo $Q[option3]; ?>" >
	  <input name="oan<?php echo $i; ?>" type="hidden" id="oan<?php echo $i; ?>" value="<?php echo $Q[a_name]; ?>">    </td>
    <td width="20%" >คะแนน <input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="<?php echo $Q[a_weight]; ?>" size="4"></td>
  </tr>
  <?php
  $i++;
    }
	$SELL = $db->query("SELECT * FROM p_cate WHERE c_id = '$path'");
	$RRR = mysql_fetch_array($SELL);
	?>
  <tr bgcolor="ECEBF0">
    <td colspan="3" bgcolor="B2B4BF">      <div align="center">
    </div>      <div align="right">
	<input name="typeofpath" type="hidden" value="<?php echo $RRR[option1]; ?>">
      <input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id; ?>">
          <input name="post" type="hidden" id="post" value="<?php echo $post; ?>">
          <input name="type" type="hidden" id="type" value="<?php echo $type; ?>">
          <input name="path" type="hidden" id="path" value="<?php echo $path; ?>">
          <input name="all" type="hidden" id="num2" value="<?php echo $i; ?>">
          <input name="Flag" type="hidden" id="Flag" value="P">
          <input name="Submit" type="submit" value="<?php echo $lang_survey_save; ?>" onClick="return confirm('Are you sure to change answer?');">
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
