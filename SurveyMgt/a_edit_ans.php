<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 

$SQL1 = $db->query("SELECT * FROM p_question WHERE q_id = '$qid'");
$PR = mysql_fetch_array($SQL1);
$SQL2 = $db->query("SELECT * FROM p_ans WHERE q_id = '$qid' ORDER BY option3 ASC");
$row = mysql_num_rows($SQL2);
?>
<html>
<head>
<title>WebAdmin</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="txt.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0"><form name="form1" enctype="multipart/form-data" method="post" action="function_eqa1.php" onSubmit="return GoNext();"><br>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" class="txt11">
  <tr>
    <td bgcolor="B2B4BF"><?php echo $lang_add_question_answerrank; ?> <?php echo $qname; ?>  : <?php if($PR[q_anstype]=="A"){ echo "Radio Box"; } ?><?php if($PR[q_anstype]=="B"){ echo "Check Box"; } ?><?php if($PR[q_anstype]=="C"){ echo "Select Box"; } ?><?php if($PR[q_anstype]=="D"){ echo "Text Box"; } ?>
		<input name="Flag" type="hidden" value="A">
    <input name="qname" type="hidden" id="qname" value="<?php echo $qname; ?>">
    <input name="qid" type="hidden" id="qid" value="<?php echo $qid; ?>">
    <input name="sel" type="hidden" id="sel" value="<?php echo $PR[q_anstype]; ?>">
</td>
  </tr>
</table>
<table id="tb1" style="display:'<?php if($PR[q_anstype]=="D" OR $PR[q_anstype]=="E"){ echo "none";} ?>'" width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt10">
  <tr bgcolor="B2B4BF">
    <td colspan="3">&nbsp;</td>
    </tr>
  <?php
  $i = 0;
if(($PR[q_anstype]!="D" AND $PR[q_anstype]!="E")and($row>0)){
   while($R = mysql_fetch_array($SQL2)){ ?>
  <tr bgcolor="ECEBF0">
    <td bgcolor="ECEBF0"><div align="center"><?php echo $lang_add_question_answerrank; ?> <?php echo $i+1; ?></div></td>
    <td width="50%" > <?php
	  $answer_ex = explode("#@form#img@#",$R[a_name]);
	  if($answer_ex[1] != ""){
	  echo "<img src=\"../ewt/".$_SESSION["EWT_SUSER"]."/".$answer_ex[1]."\" width=\"50\" height=\"50\"><br>";
	  }
	  ?>
        <?php if($PR[q_anstype] != "C"){  ?><input type="file" name="file<?php echo $i; ?>">
        <input type="hidden" name="pic<?php echo $i; ?>" value="<?php echo $answer_ex[1]; ?>">
        <br><?php } ?><input name="an<?php echo $i; ?>" type="text" id="an<?php echo $i; ?>" value="<?php echo $answer_ex[0]; ?>" size="35">
      <input name="ch<?php echo $i; ?>" type="hidden" id="ch<?php echo $i; ?>" value="<?php echo $R[a_id]; ?>">
	 <input name="oan<?php echo $i; ?>" type="hidden" id="oan<?php echo $i; ?>" value="<?php echo $R[a_name]; ?>">    </td>
    <td width="20%" >คะแนน <input name="weight<?php echo $i; ?>" type="text" id="weight<?php echo $i; ?>" value="<?php echo $R[a_weight]; ?>" size="4"></td>
  </tr>
  <?php $i++; }}else{ ?>
    <tr bgcolor="ECEBF0" id="sho">
    <td colspan="3"><div align="center"><font color="#FF0000"><?php echo $lang_edit_noans; ?></font></div></td>
    </tr>
  <?php
  $m="Y";
   } ?>
  <tr bgcolor="ECEBF0">
    <td colspan="3" bgcolor="B2B4BF"><div align="right">
    <input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id; ?>">
    <input name="addf" type="hidden" id="addf">
          <input name="all" type="hidden" id="all" value="<?php echo $i; ?>">
          <input name="SubmitY" type="submit" id="SubmitY" value="<?php echo $lang_survey_save; ?>" <?php if($m=="Y"){ echo "disabled"; } ?> onClick="return confirm('Are you sure to change answer?');">
      </div></td>
    </tr>
</table>
<?php
if($PR[q_anstype]=="D" OR $PR[q_anstype]=="E"){
$PV = mysql_fetch_array($SQL2);
}
?>
<!--<table  id="tb2" style="display:'<?php if($PR[q_anstype]!="D"){ echo "none";} ?>'"  width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt10">
  <tr bgcolor="ECEBF0">
    <td width="27%" bgcolor="ECEBF0"><div align="left"><?php echo $lang_edit_textbox; ?></div></td>
    <td colspan="3"><input type="radio" name="de" value="S" onClick="document.all.T2.style.display='<?php if($PV[a_other]=="S"){ echo "none"; } ?>';document.all.T1.style.display='<?php if($PV[a_other]!="S"){ echo "none"; } ?>';" <?php if($PV[a_other]=="S"){ echo "checked"; } ?>>
      <?php echo $lang_edit_singleline; ?><br>
      <input name="de" type="radio" value="M" onClick="document.all.T1.style.display='<?php if($PV[a_other]=="S"){ echo "none"; } ?>';document.all.T2.style.display='<?php if($PV[a_other]!="S"){ echo "none"; } ?>';" <?php if($PV[a_other]!="S"){ echo "checked"; } ?>>
      <?php echo $lang_edit_multiline; ?></td>
    </tr>
  <tr bgcolor="ECEBF0">
    <td>
      <div align="left"><?php echo $lang_edit_default_answer; ?></div></td>
    <td colspan="3"><input name="def" type="text" id="def" value="<?php echo $PV[a_name]; ?>" size="40"></td>
  </tr>
  <tr id="T1" bgcolor="ECEBF0" style="display:'<?php if($PV[a_other]=="S"){ echo "none"; } ?>'">
    <td><?php echo $lang_edit_linenumber; ?></td>
    <td width="24%"><input name="line" type="text" id="line" value="<?php if($PV[a_other]=="M"){  echo $PV[option3]; } ?>" size="3"> 
      <?php echo $lang_edit_line; ?></td>
    <td width="21%"><?php echo $lang_edit_width; ?></td>
    <td width="28%"><input name="wid1" type="text" id="wid1" value="<?php if($PV[a_other]=="M"){  echo $PV[option4]; } ?>" size="3">
      <?php echo $lang_edit_character; ?></td>
  </tr>
  <tr id="T2" bgcolor="ECEBF0" style="display:'<?php if($PV[a_other]!="S"){ echo "none"; } ?>'">
    <td><?php echo $lang_edit_maxchar; ?></td>
    <td width="24%"><input name="wor" type="text" id="wor" value="<?php if($PV[a_other]=="S"){ echo $PV[option3]; } ?>" size="3">
        <?php echo $lang_edit_character; ?>
      </td>
      <td width="21%">
        <?php echo $lang_edit_width; ?>
      </td>
    <td width="28%"><input name="wid2" type="text" id="wid2" value="<?php if($PV[a_other]=="S"){  echo $PV[option4]; } ?>" size="3">
        <?php echo $lang_edit_character; ?>
      </td>
  </tr>
  <tr bgcolor="ECEBF0">
    <td colspan="4" bgcolor="B2B4BF"><div align="right">
        <input name="ANSID" type="hidden" id="ANSID" value="<?php echo $PV[a_id]; ?>">
        <input type="submit" name="Submit" value="<?php echo $lang_survey_save; ?>">
        <input name="reset" type="reset" value="<?php echo $lang_survey_reset; ?>">
    </div></td>
  </tr>
</table>  
<table  id="tb3" style="display:'<?php if($PR[q_anstype]!="E"){ echo "none";} ?>'"  width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="B2B4BF" class="txt10">
    <tr bgcolor="ECEBF0"> 
      <td width="27%" bgcolor="ECEBF0"> 
        <div align="left"><font face="MS Sans Serif">นามสกุลไฟล์ที่อนุญาตให้ Upload</font></div>      </td>
      <td width="73%"><font face="MS Sans Serif"> 
        <input name="stype" type="text" id="stype" value="<?php echo $PV[a_name] ?>" size="40">
      <br>
      ถ้ามีมากกว่า 1 ชนิดให้คั่นด้วยจุลภาค (,) เช่น ( doc,xls,jpg ) เป็นต้น</font></td>
    </tr>
    <tr bgcolor="ECEBF0"> 
      <td> 
        <div align="left"><font face="MS Sans Serif">ขนาดไฟล์ไม่เกิน</font></div>      </td>
      <td><input name="sdef" type="text" id="sdef" value="<?php echo $PV[a_other] ?>" size="6"> 
    KB. </td>
    </tr>
    <tr bgcolor="ECEBF0"> 
      <td colspan="2" bgcolor="B2B4BF"> 
        <div align="right"> <font face="MS Sans Serif"> <input name="ANSID" type="hidden" id="ANSID" value="<?php echo $PV[a_id]; ?>">
        <input type="submit" name="Submit" value="<?php echo $lang_survey_save; ?>">
        <input name="reset" type="reset" value="<?php echo $lang_survey_reset; ?>">
          </font></div>      </td>
    </tr>
  </table>-->
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
function add1(){
if(document.all.hid.style.display == "none"){
document.all.hid.style.display = '';
document.all.Submit3.disabled = true;
document.form1.FlagA.value = "A";
document.all.SubmitX.disabled = false;
document.all.SubmitY.disabled = false;
document.all.sho.style.display = 'none';
}
}

function ChangeBox(c){
if(c =="D"){
document.all.tb2.style.display = '';
document.all.tb1.style.display = 'none';
}else{
document.all.tb1.style.display = '';
document.all.tb2.style.display = 'none';
}
}
</script>
<?php @$db->db_close(); ?>
