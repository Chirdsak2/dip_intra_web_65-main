<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
@include("language/language.php");
?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Confirm Form</title>
<script language="JavaScript1.2">
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
<link id="stext" href="css/normal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
</style>
</head>
<body>
<div align="center"><strong><font size="4" face="Tahoma">กรุณาตรวจสอบข้อมูลก่อนส่ง</font></strong></div>
<?php
$mainwidth = "90%";
if($_POST[s_id] != ""){
$sql = $db->query("select * from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];

 $bg_width="84%";

			if($rec[block_themes] !=0){
				$themes = $rec[block_themes];
			}else{
				$themes = $global_theme;
			}
if($themes!= '0' && $themes != ''){
			$namefolder = "themes".($themes);
//@include("themesdesign/configthemes.php");
@include("themesdesign/".$namefolder."/".$namefolder.".php");
 //if($themes_type == 'F'){
 	$buffer = "";
	if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
 	$fd = @fopen ($Current_Dir1.$themes_file, "r");
	 while (!@feof ($fd)) {
		$buffer .= @fgets($fd, 4096);
	 }
 	@fclose ($fd);
	$design = explode('<?php#htmlshow#?>',$buffer);
 }
?>
<?php echo $design[0];
}
if($s_id != ""){
	global $filename;
	global $EWT_FOLDER_USER;
	@include("language/language.php");
	$Yn = date("Y")+543;
	$dn = date("m-d");
	$dn = $Yn."-".$dn;

			$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
			$PR= mysql_fetch_array($SQLX);
@include("survey_default.ewt");
?>
<?php
$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");
?>
<form name="Surveyform" method="post" onSubmit="return GoNext();" action="survey_preview.php" target="_blank"><!--survey_function.php?filename=<?php//php echo $filename; ?>-->
<div align="center"><br>
    <font color="<?php echo $SubjectMainC; ?>" size="<?php echo $SubjectMainS; ?>" face="<?php echo $SubjectMainF; ?>"><?php if($SubjectMainB=="Y"){ echo "<b>"; } ?><?php if($SubjectMainI=="Y"){ echo "<em>"; } ?><?php echo $PR[s_title]; ?><?php if($SubjectMainI=="Y"){ echo "</em>"; } ?><?php if($SubjectMainB=="Y"){ echo "</b>"; } ?></font></div>

  <?php 
if($PR[file_page] != ""){
  ?>
<div align="left"><font  size="2" face="<?php echo $SubjectMainF; ?>"><a href="<?php echo $PR[file_page]; ?>" target="_blank">เอกสารแนบ : <?php echo $PR[file_page]; ?></a></font></div>
  <?php
  }	  
  while($R=mysql_fetch_array($SQL)){  
  
  ?>
  <br>
	<?php
	if($R[c_gp] =="Y" ){
	?>
	<table border="0" width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" >
	  <tr>
	    <td colspan="<?php echo $R[option2]+2; ?>"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><?php if($SubjectPartB=="Y"){ echo "<b>"; } ?><?php if($SubjectPartI=="Y"){ echo "<em>"; } ?><?php echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><?php if($SubjectPartI=="Y"){ echo "</em>"; } ?><?php if($SubjectPartB=="Y"){ echo "</b>"; } ?></font>
	    <font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size: <?php echo $head_font_size2;?>"><?php if($DescPartB=="Y"){ echo "<b>"; } ?><?php if($DescPartI=="Y"){ echo "<em>"; } ?><?php  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><?php if($DescPartI=="Y"){ echo "</em>"; } ?><?php if($DescPartB=="Y"){ echo "</b>"; } ?></font></td>
      </tr>
		
	  <tr>
	    <td width="1%" rowspan="2" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName1; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	    <td width="50%" rowspan="2" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName2; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	    <td colspan="<?php echo $R[option2]; ?>" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName3; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	  </tr>
	<tr>
	    <?php
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		 while($Q = mysql_fetch_array($SQL2)){  ?>		
	    <td align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><?php if($Head2B=="Y"){ echo "<b>"; } ?><?php if($Head2I=="Y"){ echo "<em>"; } ?>
<?php echo $Q[a_name]; ?>
	    <?php if($Head2I=="Y"){ echo "</em>"; } ?><?php if($Head2B=="Y"){ echo "</b>"; } ?></span></font></td>
<?php } ?>	
	</tr>
	<?php $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){
	?>
		  <tr>		  
	    <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><?php if($Question2B=="Y"){ echo "<b>"; } ?><?php if($Question2I=="Y"){ echo "<em>"; } ?>     
	      <?php echo $X[q_name]; ?><?php if($Question2I=="Y"){ echo "</em>"; } ?><?php if($Question2B=="Y"){ echo "</b>"; } ?></font><?php if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><?php if($Question2B=="Y"){ echo "<b>"; } ?><?php if($Question2I=="Y"){ echo "<em>"; } ?><?php echo $X[q_des]; ?><?php if($Question2I=="Y"){ echo "</em>"; } ?><?php if($Question2B=="Y"){ echo "</b>"; } ?></font> </td>
	   <?php
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		$a=0;
		 while($Q = mysql_fetch_array($SQL2)){ ?>		
	    
      <td align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"> 
        <?php if($R[option1]=="A"){ ?>
        <?php if($_POST["ans".$X[q_id]] == $Q[a_name]){ echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; }else{ echo "&nbsp;"; } ?>
        <?php }else{ ?>
        <?php if($_POST["ans".$X[q_id]."_".$a] == $Q[a_name]){ echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; }else{ echo "&nbsp;"; } ?> 
        <?php } ?>
      </td>
<?php
$a++;
 } ?>
	  </tr>
<?php } ?>	  	
  </table>
	<?php 
	}else{
	?>
<table border="0" width="<?php echo $bg_width;?>" align="center" cellpadding="0" cellspacing="0"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" >
	  <tr bgcolor="<?php echo $SubjectPartBGC; ?>">
	    <td colspan="2"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><?php if($SubjectPartB=="Y"){ echo "<b>"; } ?><?php if($SubjectPartI=="Y"){ echo "<em>"; } ?><?php echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><?php if($SubjectPartI=="Y"){ echo "</em>"; } ?><?php if($SubjectPartB=="Y"){ echo "</b>"; } ?></font>
	    <font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size: <?php echo $head_font_size2;?>"><?php if($DescPartB=="Y"){ echo "<b>"; } ?><?php if($DescPartI=="Y"){ echo "<em>"; } ?><?php  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><?php if($DescPartI=="Y"){ echo "</em>"; } ?><?php if($DescPartB=="Y"){ echo "</b>"; } ?></font></td>
    </tr>
	<?php $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){
	?>		
	  <tr >
	    <td bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>" nowrap><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php if($Question1B=="Y"){ echo "<b>"; } ?><?php if($Question1I=="Y"){ echo "<em>"; } ?><?php echo $X[q_name]; ?><?php if($Question1I=="Y"){ echo "</em>"; } ?><?php if($Question1B=="Y"){ echo "</b>"; } ?></font> <?php if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td width="100%" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">	      
	      <font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><?php if($Question1B=="Y"){ echo "<b>"; } ?><?php if($Question1I=="Y"){ echo "<em>"; } ?><?php echo $X[q_des]; ?><?php if($Question1I=="Y"){ echo "</em>"; } ?><?php if($Question1B=="Y"){ echo "</b>"; } ?></font> 
        </td>
    </tr>

		  <tr >		  
	    <td width="143" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">&nbsp;</td>
	    <td width="809" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><div align="left"><font color="<?php echo $Answer1C; ?>" size="<?php echo $Answer1S; ?>" face="<?php echo $Answer1F; ?>"><?php if($Answer1B=="Y"){ echo "<b>"; } ?><?php if($Answer1I=="Y"){ echo "<em>"; } ?>
			<?php	
			$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
			if($X[q_anstype]=="D"){ 
			if($RrRows = mysql_num_rows($SSS1)){
			$Z = mysql_fetch_array($SSS1);
			if($Z[a_other]=="S"){  ?>
			<?php echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?> <?php echo $_POST["ans".$X[q_id]]; ?>
	<?php		}else{ ?>
	<?php echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?> <?php echo $_POST["ans".$X[q_id]]; ?>
<?php	}			
			}else{ ?>
			<?php echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?> <?php echo $_POST["ans".$X[q_id]]; ?>
		<?php		}
			}elseif($X[q_anstype]=="A"){
			$p=0;
		?>
		<?php echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?> <?php $answer_ex = explode("#@form#img@#",$_POST["ans".$X[q_id]]); echo $answer_ex[0]; ?> <?php echo $_POST["oth".$X[q_id].'_'.$X[q_name]]; ?>
		<?php
		
		}elseif($X[q_anstype]=="B"){
		$p = 0;
while($Z = mysql_fetch_array($SSS1)){
	$answer_ex = explode("#@form#img@#",$Z[a_name]);
	
	?>
		<?php if($_POST["ans".$X[q_id]."_".$p] != ""){ echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?>
		<?php 
		echo $answer_ex[0]; ?><?php echo $_POST["oth".$X[q_id]."_".$p]; ?><br>
		<?php }$p++;  }		
		}elseif($X[q_anstype]=="C"){ ?>
<?php echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?> <?php $answer_ex = explode("#@form#img@#",$_POST["ans".$X[q_id]]); echo $answer_ex[0]; ?> <?php echo $_POST["oth".$X[q_id]]; ?>
		<?php		
		}else if($X[q_anstype]=="E"){
		$Z = mysql_fetch_array($SSS1);
		//chk file format
		$_FILES["file".$X[q_id].""]['size'];
		if($_FILES["file".$X[q_id].""]['size'] >($Z[a_other]*1024)){
		$alert1 = "<span class=\"style2\">*(ขนาดไฟล์ที่ท่านใช้มากกว่าที่กำหนดที่กำหนด ".$Z[a_other]." kb.)</span>";
		$disable = "disabled";
		}
		//file uplode
		$chk = 0;
		$F = explode('.',$_FILES["file".$X[q_id].""]["name"]);
		$C = count($F);
		$CT = $C-1;
		$lfname = strtolower($F[$CT]);
		//print_r($F);
		$filetype = explode(',',$Z[a_name]);
		//print_r($filetype);
		for($f=0;$f<count($filetype);$f++){
			if(strtolower($filetype[$f])==$lfname){
			$chk = 1;
			break;
			}
		}
		if($chk  == 0){
		$alert = "<span class=\"style2\">*(ไฟล์ที่ท่านใช้นามสกุลไม่ตรงกับที่กำหนด  ".$Z[a_name].")</span>";
		$disable = "disabled";
		}
		
		echo $_FILES["file".$X[q_id].""]["name"].$alert.$alert1;
		
		}else if($X[q_anstype]=="F"){
		 echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?> <?php echo $_POST["start_date".$X[q_id]]; 
		}else if($X[q_anstype]=="G"){
		$db->query("USE ".$EWT_DB_USER);
		$sql_province = $rec_prov=$db->db_fetch_array($db->query("select p_name from province where p_code = '".$_POST["addr_prov".$X[q_id]]."'"));
		$sql_amphur = $rec_amphur=$db->db_fetch_array($db->query("select a_name from amphur where p_code = '".$_POST["addr_prov".$X[q_id]]."' and a_code = '".$_POST["addr_amp".$X[q_id]]."'"));
		$sql_tumpon = $rec_tumpon=$db->db_fetch_array($db->query("select t_name from tumpon where p_code = '".$_POST["addr_prov".$X[q_id]]."' and a_code = '".$_POST["addr_amp".$X[q_id]]."' and t_code = '".$_POST["addr_tamb".$X[q_id]]."' "));
		$db->query("USE ".$EWT_DB_NAME);
		echo "<img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?> ตำบล <?php echo $sql_tumpon[t_name]; 
		echo "<br><img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?> อำเภอ <?php echo $sql_amphur[a_name]; 
		echo "<br><img src=\"mainpic/document_check.gif\" width=\"24\" height=\"24\" align=\"absmiddle\">"; ?> จังหวัด <?php echo $sql_province[p_name]; 
		
		
		}
		?>
		<?php if($Answer1I=="Y"){ echo "</em>"; } ?><?php if($Answer1B=="Y"){ echo "</b>"; } ?></font></div></td>

	  </tr>
<?php } ?>	  	
  </table>	
	<?php } ?>
  <?php } ?><br>
  <center>
<input type="checkbox"  name="wantMail" value="Y">ต้องการอีเมล์ตอบกลับ <br>
ระบุอีเมล์ : <input name="user_mail" type="text" id="user_mail"  value="" size="50">
</center><br>

  <table border="0" width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" >
  <tr>
    <td nowrap>      <div align="right">
        <input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id; ?>">
		<input name="mid" type="hidden" id="mid" value="<?php echo $mid; ?>"> 
		<input type="button"  name="Button2" value="บันทึกเป็นไฟล์ PDF " onClick="
		window.opener.Surveyform<?php echo $BID; ?>.action = 'survey_pdf.php?BID=<?php echo $BID; ?>';
		window.opener.Surveyform<?php echo $BID; ?>.target = '_blank';
		window.opener.Surveyform<?php echo $BID; ?>.submit(); ">
        <input type="button" <?php echo $disable;?> name="Button2" value="ยืนยันการกรอกข้อมูล" onClick="
		if(document.all.wantMail.checked==true &&  document.all.user_mail.value==''){
		    alert('โปรระบุอีเมล์ที่ต้องการให้ตอบกลับ');
			 window.opener.document.all.user_mail.value='';
			return false;
		}else 	if(document.all.wantMail.checked==true &&  document.all.user_mail.value!=''){
		     window.opener.document.all.user_mail.value=document.all.user_mail.value;
		}
		window.opener.document.all.tbsuccess<?php echo $BID; ?>.style.display='';window.opener.document.Surveyform<?php echo $BID; ?>.style.display='none';window.opener.document.Surveyform<?php echo $BID; ?>.setflag.value = '1';window.opener.Surveyform<?php echo $BID; ?>.target = '_self';
window.opener.Surveyform<?php echo $BID; ?>.action = 'survey_function.php';window.opener.Surveyform<?php echo $BID; ?>.submit();self.close();">
        <input type="button" name="Submit2" value="   กลับไปแก้ไขข้อมูล   " onClick="self.close();">
      </div></td></tr>
</table>

  
</form>

<?php
echo $design[1];
	}
	}
?>
</body>
</html>
