<?php
include("inc.php");
include("authority.php");

$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id'");
$PR = mysql_fetch_array($SQL1);
//@include("../ewt/".$EWT_FOLDER_USER."/survey_default.ewt");
genjava_ddwlist1call2 ("SELECT p_code, a_code, a_name FROM   amphur","p_code","a_name","a_code",1,'Y',"- เลือกอำเภอ -                            ");

?>
<html>
<head>
<title>Preview</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script language="javascript1.2">
function txt_data(prov,amph,gid) {
	var objDiv = document.getElementById("nav"+gid);
	objDiv.style.display = '';
	url='list_tumbon.php?prov='+prov+'&&amph='+amph+'&gid='+gid;

					
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
</script>
</head>
<?php
function  genjava_ddwlist1call2 ($sql,$fieldGrp,$fieldTxt,$fieldValue,$ddwlistNum,$showFunc,$firstField) {
global $db,$EWT_DB_NAME,$EWT_DB_USER;
$db->query("USE ".$EWT_DB_USER);
								
								
		 //Use in page : onchange="selectChange(this, form1.sale_id, arrItemsTxt,arrItemsValue ,arrItemsGrp);"
		 $nl = "\n"; // New line
         echo '<SCRIPT LANGUAGE="JavaScript">'.$nl;
         echo '<!-- Begin '.$nl;
		 echo 'var arrItemsTxt'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsValue'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsGrp'.$ddwlistNum.' = new Array();'.$nl.$nl;
         //Create variable
		  $query         = $db->query ($sql);
		  $numRows  = $db->db_num_rows ($query);
          for ($i=0;$i < $numRows;$i++) {
          $result = $db->db_fetch_array ($query);
          echo 'arrItemsGrp'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldGrp].'";'.$nl;
          echo 'arrItemsTxt'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldTxt].'";'.$nl;
          echo 'arrItemsValue'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldValue].'";'.$nl;
		  }//for
		 // Java function
		 if ($showFunc=='Y') {
         echo $nl.'function selectChange(control, controlToPopulate, ItemArrayTxt,ItemArrayValue, GroupArray,selectedValue)'.$nl;
         echo '{'.$nl;
         echo 'var myEle ;'.$nl;
         echo 'var x ;'.$nl;
         echo '// Empty the second drop down box of any choices'.$nl;
		 echo 'for (var q=controlToPopulate.options.length;q>=0;q--) controlToPopulate.options[q]=null;'.$nl;
         echo '// ADD Default Choice - in case there are no values'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
		
		 if (!empty($firstField)) {
			  echo 'myEle.value=0;'.$nl;
			  echo 'myEle.text="'.$firstField.'";'.$nl;
			  echo 'controlToPopulate.add(myEle) ;'.$nl;
		 }
		 echo 'for ( x = 0 ; x < ItemArrayTxt.length  ; x++ )'.$nl;
         echo   '{'.$nl;
         echo '    if ( GroupArray[x] == control.value)'.$nl;
         echo '   {'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
         echo ' myEle.text = ItemArrayTxt[x] ;'.$nl;
		 echo ' myEle.value= ItemArrayValue[x] ;'.$nl;

		 echo 'if (ItemArrayValue[x]==selectedValue)'.$nl;
		 echo '   myEle.selected=true;'.$nl;
         echo '   controlToPopulate.add(myEle) ;'.$nl;
         echo '   }'.$nl;
         echo ' }'.$nl;
         echo '}'.$nl;
		 }
		 echo '//  End -->'.$nl;
		 echo '</SCRIPT>';
		 $db->query("USE ".$EWT_DB_NAME);
	 }
$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");
?>
<body leftmargin="0" topmargin="0"><form action="function_survey.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return GoNext();">

<div align="left"><br>
    <font color="<?php echo $SubjectMainC; ?>" size="<?php echo $SubjectMainS; ?>" face="<?php echo $SubjectMainF; ?>"><?php if($SubjectMainB=="Y"){ echo "<b>"; } ?><?php if($SubjectMainI=="Y"){ echo "<em>"; } ?><?php echo $PR[s_title]; ?><?php if($SubjectMainI=="Y"){ echo "</em>"; } ?><?php if($SubjectMainB=="Y"){ echo "</b>"; } ?></font></div>

  <?php while($R=mysql_fetch_array($SQL)){  
  
  ?>
  <br>
	<?php
	//$DescPartC='#000000';
	if($R[c_gp] =="Y" ){
	?>
	<table  width="<?php if($SubjectPartW!=""){ echo $SubjectPartW; }else{ echo "98%"; } ?>" border="0" align="center" cellpadding="0" cellspacing="1">
	  <tr>
	    <td colspan="<?php echo $R[option2]+2; ?>" bgcolor="<?php echo $SubjectPartBGC; ?>"><font color="<?php echo $SubjectPartC; ?>" size="<?php echo $SubjectPartS; ?>" face="<?php echo $SubjectPartF; ?>"><?php if($SubjectPartB=="Y"){ echo "<b>"; } ?><?php if($SubjectPartI=="Y"){ echo "<em>"; } ?><?php echo $PartName1.$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><?php if($SubjectPartI=="Y"){ echo "</em>"; } ?><?php if($SubjectPartB=="Y"){ echo "</b>"; } ?></font>
	    <font color="<?php echo $DescPartC; ?>" size="<?php echo $DescPartS; ?>" face="<?php echo $DescPartF; ?>"><?php if($DescPartB=="Y"){ echo "<b>"; } ?><?php if($DescPartI=="Y"){ echo "<em>"; } ?><?php  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><?php if($DescPartI=="Y"){ echo "</em>"; } ?><?php if($DescPartB=="Y"){ echo "</b>"; } ?></font></td>
      </tr>
		
	  <tr>
	    <td width="30" rowspan="2" align="center" bgcolor="<?php echo $Head1BGC; ?>"><font color="<?php echo $Head1C; ?>" size="<?php echo $Head1S; ?>" face="<?php echo $Head1F; ?>"><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName1; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	    <td width="250" rowspan="2" align="center" bgcolor="<?php echo $Head1BGC; ?>" ><font color="<?php echo $Head1C; ?>" size="<?php echo $Head1S; ?>" face="<?php echo $Head1F; ?>"><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName2; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	    <td colspan="<?php echo $R[option2]; ?>" align="center" bgcolor="<?php echo $Head1BGC; ?>" ><font color="<?php echo $Head1C; ?>" size="<?php echo $Head1S; ?>" face="<?php echo $Head1F; ?>"><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName3; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></font></td>
	  </tr>
	<tr>
	    <?php
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		 while($Q = mysql_fetch_array($SQL2)){ ?>		
	    <td align="center" bgcolor="<?php echo $Head2BGC; ?>"><font color="<?php echo $Head2C; ?>" size="<?php echo $Head2S; ?>" face="<?php echo $Head2F; ?>"><?php if($Head2B=="Y"){ echo "<b>"; } ?><?php if($Head2I=="Y"){ echo "<em>"; } ?>
<?php echo $Q[a_name]; ?>
	    <?php if($Head2I=="Y"){ echo "</em>"; } ?><?php if($Head2B=="Y"){ echo "</b>"; } ?></font></td>
<?php } ?>	
	</tr>
	<?php $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){
	?>
		  <tr>		  
	    <td width="30" align="center" bgcolor="<?php echo $Question2BGC; ?>"><font color="<?php echo $Question2C; ?>" size="<?php echo $Question2S; ?>" face="<?php echo $Question2F; ?>"><?php if($Question2B=="Y"){ echo "<b>"; } ?><?php if($Question2I=="Y"){ echo "<em>"; } ?>     
	      <?php echo $X[q_name]; ?><?php if($Question2I=="Y"){ echo "</em>"; } ?><?php if($Question2B=="Y"){ echo "</b>"; } ?></font><?php if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td width="250" bgcolor="<?php echo $Question2BGC; ?>"><font color="<?php echo $Question2C; ?>" size="<?php echo $Question2S; ?>" face="<?php echo $Question2F; ?>"><?php if($Question2B=="Y"){ echo "<b>"; } ?><?php if($Question2I=="Y"){ echo "<em>"; } ?><?php echo $X[q_des]; ?><?php if($Question2I=="Y"){ echo "</em>"; } ?><?php if($Question2B=="Y"){ echo "</b>"; } ?></font> </td>
	   <?php
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		$a=0;
		 while($Q = mysql_fetch_array($SQL2)){ ?>		
	    <td align="center" bgcolor="<?php echo $Answer2BGC; ?>">
		<?php if($R[option1]=="A"){ ?>
	      <input type="radio" name="ans<?php echo $X[q_id]; ?>" value="<?php echo $Q[a_name]; ?>" >
		  <?php }else{ ?>
	      <input type="checkbox" name="ans<?php echo $X[q_id]; ?>_<?php echo $a; ?>" value="<?php echo $Q[a_name]; ?>" >
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
<table  width="<?php if($SubjectPartW!=""){ echo $SubjectPartW; }else{ echo "98%"; } ?>" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#ECEBF0">
	  <tr bgcolor="<?php echo $SubjectPartBGC; ?>">
	    <td colspan="2"><font color="<?php echo $SubjectPartC; ?>" size="<?php echo $SubjectPartS; ?>" face="<?php echo $SubjectPartF; ?>"><?php if($SubjectPartB=="Y"){ echo "<b>"; } ?><?php if($SubjectPartI=="Y"){ echo "<em>"; } ?><?php echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><?php if($SubjectPartI=="Y"){ echo "</em>"; } ?><?php if($SubjectPartB=="Y"){ echo "</b>"; } ?></font>
	    <font color="<?php echo $DescPartC; ?>" size="<?php echo $DescPartS; ?>" face="<?php echo $DescPartF; ?>"><?php if($DescPartB=="Y"){ echo "<b>"; } ?><?php if($DescPartI=="Y"){ echo "<em>"; } ?><?php  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><?php if($DescPartI=="Y"){ echo "</em>"; } ?><?php if($DescPartB=="Y"){ echo "</b>"; } ?></font></td>
    </tr>
	<?php $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = mysql_fetch_array($SSS)){
	?>		
	  <tr bgcolor="<?php echo $Question1BGC; ?>">
	    <td><font color="<?php echo $Question1C; ?>" size="<?php echo $Question1S; ?>" face="<?php echo $Question1F; ?>"><?php if($Question1B=="Y"){ echo "<b>"; } ?><?php if($Question1I=="Y"){ echo "<em>"; } ?><?php echo $X[q_name]; ?><?php if($Question1I=="Y"){ echo "</em>"; } ?><?php if($Question1B=="Y"){ echo "</b>"; } ?></font> <?php if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td  width="100%">	      
	      <font color="<?php echo $Question1C; ?>" size="<?php echo $Question1S; ?>" face="<?php echo $Question1F; ?>"><?php if($Question1B=="Y"){ echo "<b>"; } ?><?php if($Question1I=="Y"){ echo "<em>"; } ?><?php echo $X[q_des]; ?><?php if($Question1I=="Y"){ echo "</em>"; } ?><?php if($Question1B=="Y"){ echo "</b>"; } ?></font>        </td>
    </tr>

		  <tr bgcolor="<?php echo $Answer1BGC; ?>">		  
	    <td width="143">&nbsp;</td>
	    <td width="809"><div align="left"><font color="<?php echo $Answer1C; ?>" size="<?php echo $Answer1S; ?>" face="<?php echo $Answer1F; ?>"><?php if($Answer1B=="Y"){ echo "<b>"; } ?><?php if($Answer1I=="Y"){ echo "<em>"; } ?>
			<?php	
			$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
			if($X[q_anstype]=="D"){ 
			if($RrRows = mysql_num_rows($SSS1)){
			$Z = mysql_fetch_array($SSS1);
			if($Z[a_other]=="S"){  ?>
			<input name="ans<?php echo $X[q_id]; ?>" type="text" <?php if($Z[option4] != ""){ echo " size=\"$Z[option4]\" ";}  if($Z[option3] != ""){ echo " maxlength=\"$Z[option3]\" ";} ?> value="<?php echo $Z[a_name] ?>">
	<?php		}else{ ?>
	<textarea name="ans<?php echo $X[q_id]; ?>" <?php if($Z[option4] != ""){ echo " cols=\"$Z[option4]\" ";}  if($Z[option3] != ""){ echo " rows=\"$Z[option3]\" ";} ?> wrap="VIRTUAL" ><?php echo $Z[a_name] ?></textarea>
<?php	}			
			}else{ ?>
			<textarea name="ans<?php echo $X[q_id]; ?>" cols="50" rows="3" wrap="VIRTUAL" id="ans<?php echo $X[q_id]; ?>"></textarea>
	<?php		}
			}elseif($X[q_anstype]=="E"){ 
			if($RrRows = mysql_num_rows($SSS1)){
			$Z = mysql_fetch_array($SSS1);?>
			เฉพาะไฟล์นามสกุล <?php echo $Z[a_name]; ?><br>
			<input type="file" name="file"><br>
ขนาดไม่เกิน <?php echo number_format($Z[a_other],0); ?> KB.
	<?php		}}elseif($X[q_anstype]=="F"){ ?>
			 <input name="start_date" type="text" size="15" value="<?php echo date("d")."/".date("m")."/".(date("Y")+543); ?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../ewt/dmr_web/mainpic/b_calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>
      <?php		}elseif($X[q_anstype]=="G"){ ?>
			 <table width="500"  border="0" cellspacing="1" cellpadding="1">
                            <tr>
                              <td > จังหวัด </td>
                              <td ><select name="addr_prov<?php echo $X[q_id];?>"  id="addr_prov<?php echo $X[q_id];?>"  
															onChange="
																selectChange(this, document.getElementById('addr_amp<?php echo $X[q_id];?>'), arrItemsTxt1,arrItemsValue1,arrItemsGrp1,'');
																">
                                <option value="" selected>- เลือกจังหวัด -
                                  <?php echo $tab.' '.$tab?>
                                  </option>
                                <?php
								$db->query("USE ".$EWT_DB_USER);
								$sql_province = "select * from province ORDER BY p_name ASC";
								$query_province = $db->query($sql_province);
								while($rec_province = mysql_fetch_array($query_province)){
								?>
								<option value="<?php echo $rec_province[p_code];?>"><?php echo $rec_province[p_name];?></option>
								<?php
								}
								$db->query("USE ".$EWT_DB_NAME);
								?>
                              </select>                                        </td>
                              <td >อำเภอ</td>
                              <td ><select name="addr_amp<?php echo $X[q_id];?>"  id="addr_amp<?php echo $X[q_id];?>"
															onFocus="
																if(document.getElementById('addr_prov<?php echo $X[q_id];?>').value==''){
																	alert('กรุณาเลือกจังหวัด'); 
																	document.getElementById('addr_prov<?php echo $X[q_id];?>').focus();
																}"
																onChange="
																txt_data( document.getElementById('addr_prov<?php echo $X[q_id];?>').value,this.value,'<?php echo $X[q_id];?>');
																"
															>
                                <option value="">- เลือกอำเภอ -
                                  <?php echo $tab.$tab.$tab?>
                                  </option>
                                 
                              </select>                                              </td>
                            </tr>
                            <tr>
                              <td > ตำบล</td>
                              <td ><div id="nav<?php echo $X[q_id];?>" >
								<select name="addr_tamb<?php echo $X[q_id];?>"  id="addr_tamb<?php echo $X[q_id];?>"
															onFocus="
																if(document.getElementById('addr_amp<?php echo $X[q_id];?>').value==''){
																	alert('กรุณาเลือกอำเภอ'); 
																}"
															>
                                <option value="">- เลือกตำบล -
                                  <?php echo $tab.$tab.$tab?>
                                  </option>
                              </select></div></td>
                              <td >&nbsp;</td>
                              <td >&nbsp;</td>
                            </tr>
                          </table>
      <?php		}elseif($X[q_anstype]=="A"){
			$p=0;
	while($Z = mysql_fetch_array($SSS1)){
	$answer_ex = explode("#@form#img@#",$Z[a_name]);
	?>
		<input name="ans<?php echo $X[q_id]; ?>" type="radio" value="<?php echo $answer_ex[0]; ?>" <?php if($Z[option4] == "Y"){  echo "checked"; } ?>> 
		<?php 
			  if($answer_ex[1] != ""){
	  echo "<img src=\"../ewt/".$_SESSION["EWT_SUSER"]."/".$answer_ex[1]."\"  align=\"absmiddle\">";
	  }
		echo $answer_ex[0]; ?>
		<?php if($Z[a_other]=="Y"){ ?> <input name="oth<?php echo $X[q_id]; ?>_<?php echo $p; ?>" type="text">  
		<?php } ?>&nbsp;&nbsp;
		
		<?php $p++; }
		}elseif($X[q_anstype]=="B"){
		$p = 0;
while($Z = mysql_fetch_array($SSS1)){
$answer_ex = explode("#@form#img@#",$Z[a_name]);
	?>
		<input name="ans<?php echo $X[q_id]; ?>_<?php echo $p; ?>" type="checkbox" value="<?php echo $answer_ex[1]; ?>" <?php if($Z[option4] == "Y"){  echo "checked"; } ?>> 
		<?php 
			  if($answer_ex[1] != ""){
	  echo "<img src=\"../ewt/".$_SESSION["EWT_SUSER"]."/".$answer_ex[1]."\" align=\"absmiddle\">";
	  }
		echo $answer_ex[0]; ?>
		<?php if($Z[a_other]=="Y"){ ?>  <input name="oth<?php echo $X[q_id]; ?>_<?php echo $p; ?>" type="text">  
		<?php } ?><br>
		
		<?php $p++;  }		
		}elseif($X[q_anstype]=="C"){ ?>
		<select name="ans<?php echo $X[q_id]; ?>" >
<?php while($Z = mysql_fetch_array($SSS1)){
$answer_ex = explode("#@form#img@#",$Z[a_name]);
	?>
		 <option value="<?php echo $answer_ex[0]; ?>" <?php if($Z[option4] == "Y"){  echo "selected"; } ?>><?php echo $answer_ex[0]; ?></option>
		
		<?php } ?>
		</select>
		<?php		
		}
		?>
		<?php if($Answer1I=="Y"){ echo "</em>"; } ?><?php if($Answer1B=="Y"){ echo "</b>"; } ?></font></div></td>
	  </tr>
<?php } ?>	  	
  </table>	
	<?php } ?>
  <?php } ?><br>



</form><form name="form2" method="post" action="function_approve.php">
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td bgcolor="#666666">      <div align="center">
        <?php if($PR[s_approve]=="N"){ ?> 
         
           <input type="submit" name="Submit" value="Approve" onClick="return confirm('Are you sure to approve this survey form ?');">
        <?php } ?>
        <input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id; ?>">
</div></td></tr>
</table>
</form>

</body>
</html>
<script language="javascript">
function GoNext(){
<?php
$SSSS = $db->query("SELECT * FROM p_question,p_cate WHERE p_cate.s_id='$s_id' AND p_cate.c_id = p_question.c_id AND p_question.q_req = 'Y' ");
if($gg = mysql_num_rows($SSSS)){
while($TT = mysql_fetch_array($SSSS)){
if($TT[q_anstype]=="D"){
?>
if(document.form1.elements["ans"+<?php echo $TT[q_id]; ?>].value =="" ){
alert("กรุณาตอบคำถามข้อที่ <?php echo $TT[q_name]; ?> ในส่วนที่ <?php echo $TT[c_d]; ?> ด้วยครับ");
document.form1.elements["ans"+<?php echo $TT[q_id]; ?>].focus();
return false;
}
<?php
}elseif(($TT[q_anstype]=="A")or($TT[q_anstype]=="")){
echo "
var x = 0;
for (var i=0; i<document.form1.ans".$TT[q_id].".length; i++) {
         if (document.form1.ans".$TT[q_id]."[i].checked) {
            var x = 1;
         }
      }
	if(x==0){
	alert(\"กรุณาตอบคำถามข้อที่ ".$TT[q_name]." ในส่วนที่ ".$TT[c_d]." ด้วยครับ\");
	document.form1.ans".$TT[q_id]."[0].focus();
	return false;
	}  
	  ";
}
}}else{  echo "return true;";  }
?>
}
	</script>
<?php @$db->db_close(); ?>