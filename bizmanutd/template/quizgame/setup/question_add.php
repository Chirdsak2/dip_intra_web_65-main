<?php
	$path = "../";
	include($path."include/config.inc.php");
	include($path."include/class_db.php");
	include($path."include/class_display.php");
	include($path."include/class_application.php");
	
   $CLASS['db']   = new db();
   $CLASS['db']->connect ();
   $CLASS['disp'] = new display();
   $CLASS['app'] = new application();   
		   
	$db   = $CLASS['db'];
    $disp = $CLASS['disp'];
	$app = $CLASS['app'];

	
	if($_POST["accept"]) {
			
			if(trim($_POST["new_topic_name"])) {
					$arrNewName=explode("-",trim($_POST["new_topic_name"]));
					
					if(!$_POST["sel_topic"]) {
					
							$sql_chk = " SELECT topic_id FROM topic WHERE  topic_code = '".$_POST["new_topic_code"]."'  ";
							// WHERE topic_name = '".$disp->convert_qoute_to_db($arrNewName[0])."'
							$exec_chk = $db->query($sql_chk);
							$num_chk = $db->num_rows($exec_chk);
							
							if($num_chk==0) {
									$INSERT = " INSERT INTO topic (topic_name, topic_code) VALUES ('".$disp->convert_qoute_to_db($arrNewName[0])."',  '".$_POST["new_topic_code"]."' ) ";
									$db->query($INSERT); 
									$_POST["sel_topic"] = $_POST["new_topic_code"]; //= mysql_insert_id();
							}				
										
					} else {					
							$up_code = "";
							
							$sql_chk = " SELECT topic_id FROM topic WHERE  topic_code = '".$_POST["new_topic_code"]."'  ";
							// WHERE topic_name = '".$disp->convert_qoute_to_db($arrNewName[0])."'
							$exec_chk = $db->query($sql_chk);
							$num_chk = $db->num_rows($exec_chk);
							
							if($num_chk==0) {  // เธ–เนเธฒเธขเธฑเธเนเธกเนเธกเธต new_topic_code เธ•เธฑเธงเธ—เธตเนเธเธฃเธญเธเนเธซเธกเน เธเธถเธเธเธฐ update  topic_code เนเธ”เน				
									$up_code = " , topic_code = '".$_POST["new_topic_code"]."' "; 
							}
															
									$UPDATE = " UPDATE topic SET topic_name = '".$disp->convert_qoute_to_db($arrNewName[0])."' $up_code WHERE  topic_code = '".$_POST["sel_topic"]."'  ";
									$db->query($UPDATE); 				
									
							if($num_chk==0) {	// เธ–เนเธฒ update  topic_code เธเธถเธเธเธฐเน€เธเนเธเธเนเธฒเนเธซเธกเนเธกเธฒเนเธเน  เนเธกเนเธเธฑเนเธเธเนเนเธเน sel_topic เธ•เธฑเธงเน€เธ”เธดเธก
									$_POST["sel_topic"] = $_POST["new_topic_code"];
							}
							
					}
			}
			
			$sql_chk = " SELECT question_id FROM questions WHERE question_id = '".$_POST["question_id"]."' ";
			$exec_chk = $db->query($sql_chk);
			$num_chk = $db->num_rows($exec_chk);
			
			if($num_chk==0) {
					
					$sqlMax = " SELECT max(question_rank)  AS max_rank FROM questions WHERE topic_code = '".$_POST["sel_topic"]."' ";
					$execMax = $db->query($sqlMax);
					$recMax = $db->fetch_array($execMax);						
					$next_rank = $recMax[max_rank]+1;
								
				
				 $INSERT = " INSERT INTO questions (question_name, topic_code, c_id, correct_choice, question_score, addtime, question_rank) 
				 					VALUES ('".$disp->convert_qoute_to_db(trim($_POST["question_name"]))."', '".$_POST["sel_topic"]."', '".($_POST["c_id"]*1)."', '".$disp->convert_qoute_to_db($_POST["correct_choice"])."', '".($_POST["question_score"]*1)."', NOW(), '$next_rank' ) ";
									
				$db->query($INSERT);
				/*
				$sqlMax = " SELECT max(question_id)  AS max_id FROM questions WHERE correct_choice = '".$disp->convert_qoute_to_db($_POST["correct_choice"])."' ";
				$execMax = $db->query($sqlMax);
				$recMax = $db->fetch_array($execMax);				
				$_POST["question_id"] = $recMax[max_id];
				*/
				$_POST["question_id"] = mysql_insert_id();
			} else {
				
				$UPDATE = "UPDATE questions SET question_name='".$disp->convert_qoute_to_db(trim($_POST["question_name"]))."', 
								topic_code = '".$_POST["sel_topic"]."', c_id = '".($_POST["c_id"]*1)."', correct_choice = '".$disp->convert_qoute_to_db($_POST["correct_choice"])."', question_score = '".($_POST["question_score"]*1)."' WHERE question_id = '".$_POST["question_id"]."' ";
								
				$db->query($UPDATE);
			}
			
			for($ch=1;$ch<=4;$ch++) {
					$sql_choice = " SELECT choice_id FROM choices WHERE question_id = '".$_POST["question_id"]."' AND choice_no = '".$_POST["choice_no".$ch]."' ";
					$exec_choice = $db->query($sql_choice);
					$have_choice = $db->num_rows($exec_choice);
					
					if($have_choice==0) {
							$INSERT = " INSERT INTO choices (question_id, choice_no, choice_text) 
				 					VALUES ('".$_POST["question_id"]."', '".$_POST["choice_no".$ch]."', '".$disp->convert_qoute_to_db(trim($_POST["choice_text".$ch]))."' ) ";
									
							$db->query($INSERT);
														
					} else {
					
							$UPDATE = "UPDATE choices SET 
												choice_text='".$disp->convert_qoute_to_db(trim($_POST["choice_text".$ch]))."'	WHERE question_id = '".$_POST["question_id"]."' AND choice_no = '".$_POST["choice_no".$ch]."' 												
											";
								
							$db->query($UPDATE);
					}
			
			}
			
			
			?>
			<script type="text/javascript">
			alert('เธเธฑเธเธ—เธถเธเธเธณเธ–เธฒเธก-เธเธณเธ•เธญเธ เน€เธฃเธตเธขเธเธฃเนเธญเธขเนเธฅเนเธง');
			opener.location = 'question_list.php?sel_topic=<?php echo $_POST["sel_topic"];?>'; //.reload();
			window.close();
			</script>
			<?php
	}
	/*
	$sql_quiz = " SELECT * FROM  questions  LEFT JOIN topic ON  questions.topic_id = topic.topic_id
	  					 WHERE questions.topic_id = '$sel_topic'
						  ORDER BY question_rank ASC 
						 $LIMIT ";
	$exec_quiz = $db->query($sql_quiz);
	$num_quiz = $db->num_rows($exec_quiz);
	*/
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title>เน€เธเธดเนเธก/เนเธเนเนเธ เธเธณเธ–เธฒเธก-เธเธณเธ•เธญเธ</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<link rel="stylesheet" type="text/css" href="../css/basestyle.css">
	<style type="text/css">
	.bgBar {
	background-image:url(<?php echo $path;?>images/top_08.jpg);
	background-repeat:repeat-x;
	}
	</style>	
<script type="text/javascript" src="<?php echo $path;?>js/functions.js"></script>	
<script type="text/javascript">
choice_char = new Array('A','B','C','D');

function chkInput() {
	if(frm.new_topic_name.value == '') {
		alert('เธเธฃเธธเธ“เธฒเธฃเธฐเธเธธเธซเธกเธงเธ”เธเธณเธ–เธฒเธก');
		frm.new_topic_name.focus();
		return false;
	}
	if(frm.new_topic_code.value == '') {
		alert('เธเธฃเธธเธ“เธฒเธฃเธฐเธเธธ Topic Code');
		frm.new_topic_code.focus();
		return false;
	} else if(frm.new_topic_code.value.search(/\W/) != -1  ) {	//  Match any single non-word character. Equivalent to [^a-zA-Z0-9_].
			// frm.new_topic_code.value.search('(")|(@)|(&)|([)|(])') != -1 || frm.new_topic_code.value.search("'") != -1 
		alert('เธเธฃเธธเธ“เธฒเธญเธขเนเธฒเนเธเนเธญเธฑเธเธเธฃเธฐเธเธดเน€เธจเธฉ');
		frm.new_topic_code.focus();
		return false;		
	}
	qText = Trim(frm.question_name.value);	
	if(qText.length<3) {
		alert('เธเธฃเธธเธ“เธฒเธเธฃเธญเธเธเธณเธ–เธฒเธกเนเธซเนเธเธฑเธ”เน€เธเธ');
		frm.question_name.focus();
		return false;
	} 
	if(frm.question_score.value*1 < 1000) {
		alert('เธเธฃเธธเธ“เธฒเธเธฃเธญเธเธเธฐเนเธเธเธเธญเธเธเธณเธ–เธฒเธก เธเนเธญเธฅเธฐเนเธกเนเธเนเธญเธขเธเธงเนเธฒ 1000 เธเธฐเนเธเธ');
		frm.question_score.focus();
		return false;
	}
	for(ch=1;ch<=4;ch++) {
		if(frm['choice_text'+ch].value=='') {
			alert('เธเธฃเธธเธ“เธฒเธเธฃเธญเธเธเธณเธ•เธญเธ '+choice_char[ch-1]);
			frm['choice_text'+ch].focus();
			return false;
		} 
	}
	if(frm.correct_choice.value == '') {
		alert('เธเธฃเธธเธ“เธฒเน€เธฅเธทเธญเธเธเธณเธ•เธญเธเน€เธเธฅเธข');
		frm.correct_choice.focus();
		return false;
	}
	
}
</script>
</head>
<body><H3>เน€เธเธดเนเธก/เนเธเนเนเธ เธเธณเธ–เธฒเธก-เธเธณเธ•เธญเธ</H3>
<?php
	$filter = "";
	
	
	
	if($filter) {
		$filter = substr($filter,0,-4);
		$filter = " WHERE ".$filter;
	}
	
	$sql_quiz = " SELECT * FROM  questions  WHERE question_id = '$question_id' ";
	$exec_quiz = $db->query($sql_quiz);
	$num_quiz = $db->num_rows($exec_quiz);
	if($num_quiz>0) {
		$rec_quiz = $db->fetch_array($exec_quiz);
		$question_name = $rec_quiz[question_name];
		$question_score = $rec_quiz[question_score];
		$sel_topic = $rec_quiz[topic_code];
		$correct_choice = $rec_quiz[correct_choice];
		$c_id = $rec_quiz[c_id];
		
		$sql_compo = " SELECT * FROM q_component WHERE c_id = '$c_id' ";
		$exec_compo = $db->query($sql_compo);		
		$rec_compo = $db->fetch_array($exec_compo);
		$c_name = $rec_compo[c_name];
		
		$sql_ans = " SELECT * FROM  choices  WHERE question_id = '$question_id' ORDER BY choice_no, choice_id ";
		$exec_ans = $db->query($sql_ans);		
		$ch=1;
		while($rec_ans = $db->fetch_array($exec_ans)) {
			${"choice_text".$ch} = $rec_ans[choice_text];
			$ch++;
		}
	}
?>
<form name="frm" method="post"><input name="question_id" type="hidden" value="<?php echo $question_id;?>"><input name="sel_build_id" type="hidden" value="<?php echo $sel_build_id;?>">

<table  border="1" bordercolor="#0066FF" cellspacing="0" cellpadding="2">
<tr><td height="300" valign="top">	
<?php $sql_options = " SELECT * FROM topic  $filter  ORDER BY  topic_name ";	
?>เธซเธกเธงเธ”เธเธณเธ–เธฒเธก <select name="sel_topic" onChange="frm.new_topic_name.value = frm.sel_topic.options[frm.sel_topic.selectedIndex].text; frm.new_topic_code.value = frm.sel_topic.value;" >	
	<?php $exec_options = $db->query($sql_options);
			while($rec_options = $db->fetch_array($exec_options)) {
					$selected = ($rec_options[topic_code]==$sel_topic)? "selected":"";
				?><option value="<?php echo $rec_options[topic_code];?>"  <?php echo $selected;?>><?php echo $rec_options[topic_name];?> - <?php echo $rec_options[building_name];?></option><?php
			}
	?>
		<option value="">เธซเธกเธงเธ”เนเธซเธกเน</option>
	</select> 
<input name="new_topic_name" type="text" class="textBox" size="30"> Topic Code <input name="new_topic_code" type="text" class="textBox" size="20"> 
<br>
<br>

<table width="100%" border="1" bordercolor="#0000FF" cellspacing="0" cellpadding="2" style="border-collapse:collapse" >
  <tr>
    <td bgcolor="#0099FF" class="labelHead"><strong>เธเธณเธ–เธฒเธก</strong></td>
	<td bgcolor="#0099FF" class="labelHead" align="center"><strong>เธเธฐเนเธเธ</strong></td>
  </tr>
  <tr valign="top">
    <td><textarea name="question_name" rows="3" cols="50" class="textBox" style="background-color:#FFFFCC; border: 1px solid red;"><?php echo $question_name;?></textarea><br><!--br>
	เน€เธเธทเนเธญเธซเธฒเธเธฃเธฐเธเธญเธเธเธณเธ–เธฒเธก <input name="c_name" type="text" class="clickable" readonly style="cursor:pointer" size="40" maxlength="255" value="<?php //=$c_name;?>" onClick="window.open('search_compo.php','popup1', 'menubar=no, location=no, status=yes, scrollbars=yes, width=500, height=300, left=100, top=100');" ><input name="c_id" type="hidden" value="<?php //=$c_id;?>"><br--></td>
	<td align="center" ><input name="question_score" type="text" class="qty" size="6" maxlength="5" value="<?php echo $question_score;?>"></td>
  </tr>
  <tr>
    <td bgcolor="#0099FF" class="labelHead" colspan="2"><strong>เธเธณเธ•เธญเธ</strong></td>
  </tr>
  <tr>
	<td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="2">
		  <tr>
			<td width="12%" align="center">A.<input name="choice_no1" type="hidden" value="1"></td>
			<td width="88%"><input name="choice_text1" type="text" class="textBox" style="background-color:#FFFFCC; border: 1px solid blue;" size="70" maxlength="255" value="<?php echo $choice_text1;?>"></td>
		  </tr>
		  <tr>
			<td align="center">B.<input name="choice_no2" type="hidden" value="2"></td>
			<td><input name="choice_text2" type="text" class="textBox" style="background-color:#FFFFCC; border: 1px solid blue;" size="70" maxlength="255" value="<?php echo $choice_text2;?>"></td>
		  </tr>
		  <tr>
			<td align="center">C.<input name="choice_no3" type="hidden" value="3"></td>
			<td><input name="choice_text3" type="text" class="textBox" style="background-color:#FFFFCC; border: 1px solid blue;" size="70" maxlength="255" value="<?php echo $choice_text3;?>"></td>
		  </tr>
		  <tr>
			<td align="center">D.<input name="choice_no4" type="hidden" value="4"></td>
			<td><input name="choice_text4" type="text" class="textBox" style="background-color:#FFFFCC; border: 1px solid blue;" size="70" maxlength="255" value="<?php echo $choice_text4;?>"></td>
		  </tr>
		</table>
	</td>
  </tr>
   <tr>
    <td colspan="2"><strong>เน€เธเธฅเธข</strong> : <select name="correct_choice">
														  <option value="">เนเธเธฃเธ”เน€เธฅเธทเธญเธ</option>
														  <option value="1" <?php if($correct_choice=="1") echo "selected"; ?>>A</option>
														  <option value="2" <?php if($correct_choice=="2") echo "selected"; ?>>B</option>
														  <option value="3" <?php if($correct_choice=="3") echo "selected"; ?>>C</option>
														  <option value="4" <?php if($correct_choice=="4") echo "selected"; ?>>D</option>
														  </select></td>
  </tr>
</table><br>
<div align="center"><input name="accept" type="submit" value="เธเธฑเธเธ—เธถเธ" style="width:100px; height:35px" onClick="return chkInput()">&nbsp;&nbsp;<input name="reset" type="reset" value="เธเธทเธเธเนเธฒเน€เธฃเธดเนเธกเธ•เนเธ" style="width:100px; height:35px"></div>
</td></tr></table></form><script type="text/javascript"> frm.new_topic_name.value = frm.sel_topic.options[frm.sel_topic.selectedIndex].text;
frm.new_topic_code.value = frm.sel_topic.value;
</script>
</body>
</html>
