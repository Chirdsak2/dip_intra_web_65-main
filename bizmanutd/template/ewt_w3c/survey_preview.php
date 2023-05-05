<?php
session_start();
$path = '../';
include($path."lib/function.php");
include($path."lib/user_config.php");
include($path."lib/connect.php");
@include($path."language/language.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<title>Confirm Form</title>
<script language="JavaScript1.2" type="text/javascript">
<!--
top.window.moveTo(0,0);
if (document.all) {
top.window.resizeTo(screen.availWidth,screen.availHeight);
}
else if (document.layers||document.getElementById) {
if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
top.window.outerHeight = screen.availHeight;
top.window.outerWidth = screen.availWidth;
}
}
//-->
</script>
<link id="stext" href=".../css/normal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
</style>
</head>
<body>
<div align="center"><strong><font size="4" face="Tahoma">กรุณาตรวจสอบข้อมูลก่อนส่ง</font></strong></div>
<?
$mainwidth = "90%";
//echo $_POST[s_id];
if($_POST[s_id] != ""){
$sql = $db->query("select * from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];

 $bg_width="84%";

		
if($s_id != ""){
	global $filename;
	global $EWT_FOLDER_USER;
	@include("../language/language.php");
	$Yn = date("Y")+543;
	$dn = date("m-d");
	$dn = $Yn."-".$dn;

			$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
			$PR= mysql_fetch_array($SQLX);
@include("../survey_default.ewt");
?>
<?
$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");
?>
<form name="Surveyform" method="post" onSubmit="return GoNext();" action="survey_preview.php" target="_blank">
<div align="center"><br>
    <font color="<? echo $SubjectMainC; ?>" size="<? echo $SubjectMainS; ?>" face="<? echo $SubjectMainF; ?>"><? if($SubjectMainB=="Y"){ echo "<b>"; } ?><? if($SubjectMainI=="Y"){ echo "<em>"; } ?><? echo $PR[s_title]; ?><? if($SubjectMainI=="Y"){ echo "</em>"; } ?><? if($SubjectMainB=="Y"){ echo "</b>"; } ?></font></div>

  <? 
if($PR[file_page] != ""){
  ?>
<div align="left"><font  size="2" face="<? echo $SubjectMainF; ?>"><a href="<?php echo $PR[file_page]; ?>" target="_blank">เอกสารแนบ : <?php echo $PR[file_page]; ?></a></font></div>
  <?
  }	  
  while($R=mysql_fetch_array($SQL)){  
  
  ?>
  <br>
	<?
	if($R[c_gp] =="Y" ){
	?>
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1" >
	  <tr>
	    <td colspan="<? echo $R[option2]+2; ?>" ><? if($SubjectPartB=="Y"){ echo "<b>"; } ?><? if($SubjectPartI=="Y"){ echo "<em>"; } ?><? echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><? if($SubjectPartI=="Y"){ echo "</em>"; } ?><? if($SubjectPartB=="Y"){ echo "</b>"; } ?>
	    <? if($DescPartB=="Y"){ echo "<b>"; } ?><? if($DescPartI=="Y"){ echo "<em>"; } ?><?  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><? if($DescPartI=="Y"){ echo "</em>"; } ?><? if($DescPartB=="Y"){ echo "</b>"; } ?></td>
      </tr>
		
	  <tr>
	    <td width="1%" rowspan="2" align="center" ><? if($Head1B=="Y"){ echo "<b>"; } ?><? if($Head1I=="Y"){ echo "<em>"; } ?><? echo $HeadName1; ?><? if($Head1I=="Y"){ echo "</em>"; } ?><? if($Head1B=="Y"){ echo "</b>"; } ?></td>
	    <td width="50%" rowspan="2" align="center" ><? if($Head1B=="Y"){ echo "<b>"; } ?><? if($Head1I=="Y"){ echo "<em>"; } ?><? echo $HeadName2; ?><? if($Head1I=="Y"){ echo "</em>"; } ?><? if($Head1B=="Y"){ echo "</b>"; } ?></td>
	    <td colspan="<? echo $R[option2]; ?>" align="center" ><? if($Head1B=="Y"){ echo "<b>"; } ?><? if($Head1I=="Y"){ echo "<em>"; } ?><? echo $HeadName3; ?><? if($Head1I=="Y"){ echo "</em>"; } ?><? if($Head1B=="Y"){ echo "</b>"; } ?></td>
	  </tr>
	<tr>
	    <?
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		 while($Q = mysql_fetch_array($SQL2)){  ?>		
	    <td align="center" ><? if($Head2B=="Y"){ echo "<b>"; } ?><? if($Head2I=="Y"){ echo "<em>"; } ?>
<? echo $Q[a_name]; ?>
	    <? if($Head2I=="Y"){ echo "</em>"; } ?><? if($Head2B=="Y"){ echo "</b>"; } ?></td>
<? } ?>	
	</tr>
	<? $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){
	?>
		  <tr>		  
	    <td ><? if($Question2B=="Y"){ echo "<b>"; } ?><? if($Question2I=="Y"){ echo "<em>"; } ?>     
	      <? echo $X[q_name]; ?><? if($Question2I=="Y"){ echo "</em>"; } ?><? if($Question2B=="Y"){ echo "</b>"; } ?><? if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td ><? if($Question2B=="Y"){ echo "<b>"; } ?><? if($Question2I=="Y"){ echo "<em>"; } ?><? echo $X[q_des]; ?><? if($Question2I=="Y"){ echo "</em>"; } ?><? if($Question2B=="Y"){ echo "</b>"; } ?></td>
	   <?
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		$a=0;
		 while($Q = mysql_fetch_array($SQL2)){ ?>		
	    
      <td align="center" > 
        <? if($R[option1]=="A"){ ?>
        <?php if($_POST["ans".$X[q_id]] == $Q[a_name]){ echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; }else{ echo "&nbsp;"; } ?>
        <? }else{ ?>
        <?php if($_POST["ans".$X[q_id]."_".$a] == $Q[a_name]){ echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; }else{ echo "&nbsp;"; } ?> 
        <? } ?>
      </td>
<?
$a++;
 } ?>
	  </tr>
<? } ?>	  	
  </table>
	<? 
	}else{
	?>
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" >
	  <tr bgcolor="<? echo $SubjectPartBGC; ?>">
	    <td colspan="2"  ><? if($SubjectPartB=="Y"){ echo "<b>"; } ?><? if($SubjectPartI=="Y"){ echo "<em>"; } ?><? echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><? if($SubjectPartI=="Y"){ echo "</em>"; } ?><? if($SubjectPartB=="Y"){ echo "</b>"; } ?>
	    <? if($DescPartB=="Y"){ echo "<b>"; } ?><? if($DescPartI=="Y"){ echo "<em>"; } ?><?  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><? if($DescPartI=="Y"){ echo "</em>"; } ?><? if($DescPartB=="Y"){ echo "</b>"; } ?></td>
    </tr>
	<? $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){
		$qreq = $X[q_req];
	?>		
	  <tr >
	    <td ><? if($Question1B=="Y"){ echo "<b>"; } ?><? if($Question1I=="Y"){ echo "<em>"; } ?><? echo $X[q_name]; ?><? if($Question1I=="Y"){ echo "</em>"; } ?><? if($Question1B=="Y"){ echo "</b>"; } ?> <? if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td width="100%" >	      
	      <? if($Question1B=="Y"){ echo "<b>"; } ?><? if($Question1I=="Y"){ echo "<em>"; } ?><? echo $X[q_des]; ?><? if($Question1I=="Y"){ echo "</em>"; } ?><? if($Question1B=="Y"){ echo "</b>"; } ?>
        </td>
    </tr>

		  <tr >		  
	    <td width="143" >&nbsp;</td>
	    <td width="809" ><div align="left"><? if($Answer1B=="Y"){ echo "<b>"; } ?><? if($Answer1I=="Y"){ echo "<em>"; } ?>
			<?	
			$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
			if($X[q_anstype]=="D"){ 
			if($RrRows = mysql_num_rows($SSS1)){
			$Z = mysql_fetch_array($SSS1);
			if($Z[a_other]=="S"){  ?>
			<?php echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?> <?php echo $_POST["ans".$X[q_id]]; ?>
	<?		}else{ ?>
	<?php echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?> <?php echo $_POST["ans".$X[q_id]]; ?>
<?	}			
			}else{ ?>
			<?php echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?> <?php echo $_POST["ans".$X[q_id]]; ?>
		<?		}
			}elseif($X[q_anstype]=="A"){
			$p=0;
		?>
		<?php echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?> <?php $answer_ex = explode("#@form#img@#",$_POST["ans".$X[q_id]]); echo $answer_ex[0]; ?> <?php echo $_POST["oth".$X[q_id]]; ?>
		<?
		
		}elseif($X[q_anstype]=="B"){
		$p = 0;
while($Z = mysql_fetch_array($SSS1)){
	$answer_ex = explode("#@form#img@#",$Z[a_name]);
	
	?>
		<?php if($_POST["ans".$X[q_id]."_".$p] != ""){ echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?>
		<? 
		echo $answer_ex[0]; ?><?php echo $_POST["oth".$X[q_id]."_".$p]; ?><br>
		<? }$p++;  }		
		}elseif($X[q_anstype]=="C"){ ?>
<?php echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?> <?php $answer_ex = explode("#@form#img@#",$_POST["ans".$X[q_id]]); echo $answer_ex[0]; ?> <?php echo $_POST["oth".$X[q_id]]; ?>
		<?		
		}else if($X[q_anstype]=="E"){
		$Z = mysql_fetch_array($SSS1);
		//chk file format
		$_FILES["file".$X[q_id].""]['size'];
		if($_FILES["file".$X[q_id].""]['size'] >($Z[a_other]*1024)){
		$alert1 = "<span class=\"style2\">*(ขนาดไฟล์ที่ท่านใช้มากกว่าที่กำหนดที่กำหนด ".$Z[a_other]." kb.)</span>";

		$disable = "disabled";

		}
		//file uplode
		$chk = 1;
		$F = explode('.',$_FILES["file".$X[q_id].""]["name"]);
		$C = count($F);
		$CT = $C-1;
		$lfname =strtolower($F[$CT]);
		//print_r($F);
		$filetype = explode(',',trim($Z[a_name]));
		//print_r($filetype);
		for($f=0;$f<count($filetype)+1;$f++){
			if(strtolower($filetype[$f])==trim($lfname)){
			$chk = 1;
			break;
			}
		}
		if($_FILES["file".$X[q_id].""]["name"] != ''){
			if($chk  == 0){
		$alert = "<span class=\"style2\">*(ไฟล์ที่ท่านใช้นามสกุลไม่ตรงกับที่กำหนด  ".$Z[a_name].")</span>";
		
		$disable = "disabled";
			}
		}
		
		echo $_FILES["file".$X[q_id].""]["name"].$alert.$alert1;
		
		}else if($X[q_anstype]=="F"){
		 echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?> <?php echo $_POST["start_date".$X[q_id]]; 
		}else if($X[q_anstype]=="G"){
		$db->query("USE ".$EWT_DB_USER);
		$sql_province = $rec_prov=$db->db_fetch_array($db->query("select p_name from province where p_code = '".$_POST["addr_prov".$X[q_id]]."'"));
		$sql_amphur = $rec_amphur=$db->db_fetch_array($db->query("select a_name from amphur where p_code = '".$_POST["addr_prov".$X[q_id]]."' and a_code = '".$_POST["addr_amp".$X[q_id]]."'"));
		$sql_tumpon = $rec_tumpon=$db->db_fetch_array($db->query("select t_name from tumpon where p_code = '".$_POST["addr_prov".$X[q_id]]."' and a_code = '".$_POST["addr_amp".$X[q_id]]."' and t_code = '".$_POST["addr_tamb".$X[q_id]]."' "));
		$db->query("USE ".$EWT_DB_NAME);
		echo "<img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?> ตำบล <?php echo $sql_tumpon[t_name]; 
		echo "<br><img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?> อำเภอ <?php echo $sql_amphur[a_name]; 
		echo "<br><img src=\"../mainpic/document_check.gif\" width=\"24\" height=\"24\" alt=\"document\">"; ?> จังหวัด <?php echo $sql_province[p_name]; 
		
		
		}
		?>
		<? if($Answer1I=="Y"){ echo "</em>"; } ?><? if($Answer1B=="Y"){ echo "</b>"; } ?></div></td>

	  </tr>
<? } ?>	  	
  </table>	
	<? } ?>
  <? } ?><br>

  <table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"   >
  <tr>
    <td align="center" nowrap> 
        <input name="s_id" type="hidden" id="s_id" value="<? echo $s_id; ?>">
		<input name="mid" type="hidden" id="mid" value="<? echo $mid; ?>">
        <input type="button" <?php echo $disable;?> name="Button2" value="ยืนยันการกรอกข้อมูล" onClick="window.opener.document.all.tbsuccess<?php echo $BID; ?>.style.display='';window.opener.document.Surveyform<?php echo $BID; ?>.style.display='none';window.opener.document.Surveyform<?php echo $BID; ?>.setflag.value = '1';window.opener.Surveyform<?php echo $BID; ?>.target = '_self';
window.opener.Surveyform<?php echo $BID; ?>.action = 'survey_function.php';window.opener.Surveyform<?php echo $BID; ?>.submit();self.close();">
        <input type="button" name="Submit2" value="   กลับไปแก้ไขข้อมูล   " onClick="self.close();">
     </td></tr>
</table>
<?php  include("ewt_span.php");?>
  
</form>

<?php
echo $design[1];
	}
	}
?>
</body>
</html>
