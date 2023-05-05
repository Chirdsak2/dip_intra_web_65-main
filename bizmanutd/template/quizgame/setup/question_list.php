<?php
	$path = "../";
	$path_comp = "../";
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
	
	
	if($_POST["accept"]=="deltopic") {	
			if($_POST["chk_del"]=='1') {
				$sql0 = " SELECT * FROM  topic  WHERE  topic_code = '".$_POST["sel_topic"]."' ";
				$exec0 = $db->query($sql0);	
				$rec0 = $db->fetch_array($exec0);
				
				$sql1 = " SELECT question_id, question_name FROM  questions  WHERE topic_code = '".$_POST["sel_topic"]."' ";
				$exec1 = $db->query($sql1);				
				while($rec1 = $db->fetch_array($exec1)) {			
					$question_id = $rec1[question_id];
					
					$DELETE = " DELETE FROM choices WHERE question_id = '$question_id' ";
					$db->query($DELETE);
					
					$DELETE = " DELETE FROM questions WHERE question_id = '$question_id' ";
					$db->query($DELETE);
				}
				$DELETE = " DELETE FROM topic WHERE topic_code = '".$_POST["sel_topic"]."' ";
				$db->query($DELETE);
				
						?>
						<script type="text/javascript">
						alert('เธฅเธเธซเธกเธงเธ” <?php echo $rec0[topic_name];?> เนเธฅเธฐ เธเธณเธ–เธฒเธก-เธเธณเธ•เธญเธเธเธญเธเธซเธกเธงเธ”  เน€เธฃเธตเธขเธเธฃเนเธญเธขเนเธฅเนเธง');
						window.location = 'question_list.php'; 			
						</script>
						<?php
			}
	}
	if($cmd=="delete1") {
				$sql0 = " SELECT question_id, question_name FROM  questions  WHERE question_id = '$question_id' ";
				$exec0 = $db->query($sql0);				
				$rec0 = $db->fetch_array($exec0);
			
				$DELETE = " DELETE FROM choices WHERE question_id = '$question_id' ";
				$db->query($DELETE);
				
				$DELETE = " DELETE FROM questions WHERE question_id = '$question_id' ";
				$db->query($DELETE);
			
				?>
			<script type="text/javascript">
			alert('เธฅเธเธเธณเธ–เธฒเธก <?php echo $rec0[question_name];?> เนเธฅเธฐเธเธณเธ•เธญเธเธเธญเธเธเนเธญเธเธตเน เน€เธฃเธตเธขเธเธฃเนเธญเธขเนเธฅเนเธง');
			window.location = 'question_list.php?sel_topic=<?php echo $sel_topic;?>'; 			
			</script>
			<?php
	}
	
	if($_POST["accept"]=="save") {
			for($x=$_POST["first_row"];$x<=$_POST["end_row"];$x++) {
				
				$UPDATE = "UPDATE questions SET question_rank = '".($_POST["question_rank".$x]*1)."' WHERE question_id = '".$_POST["question_id".$x]."' ";								
				$db->query($UPDATE);
			}	
			
				?>
			<script type="text/javascript">
			alert('เธเธฃเธฑเธเน€เธฃเธตเธขเธเธฅเธณเธ”เธฑเธเธเนเธญ เน€เธฃเธตเธขเธเธฃเนเธญเธขเนเธฅเนเธง');
			window.location = 'question_list.php?sel_topic=<?php echo $_POST["sel_topic"];?>'; 			
			</script>
			<?php
	}
	//if(!$sel_topic) $sel_topic = 1;
	$filter = "";
	
	if($sel_topic) {
		$filter .= " questions.topic_code = '$sel_topic'  AND ";  
	}
	if($keyword) {
		$filter .= " ( question_name LIKE '%$keyword%' )  AND ";
	}
	if($filter) {
		$filter = substr($filter,0,-4);
		$filter = " WHERE ".$filter;
	}
	$rowsPerPage = 10;
	
	$sql = " SELECT COUNT(question_id) AS tot_rows FROM  questions  LEFT JOIN topic ON  questions.topic_code = topic.topic_code
	  					 $filter  ";
	$exec = $db->query($sql);
	$rec = $db->fetch_array($exec);
	$tot_rows = $rec[tot_rows];
	
	$totalPages = ceil($tot_rows/$rowsPerPage);
	
	if(!$curPage) $curPage=1;
	
	if($curPage=="All") {
			$start_row = 0;
			$LIMIT = "";		
	} else {
			$start_row = $rowsPerPage*($curPage-1);
			$LIMIT = " LIMIT  $start_row, $rowsPerPage ";	
	}
					
	$sql_quiz = " SELECT * FROM  questions  LEFT JOIN topic ON  questions.topic_code = topic.topic_code
	  					 $filter
						  ORDER BY questions.topic_code, question_rank ASC 
						 $LIMIT ";
	$exec_quiz = $db->query($sql_quiz);
	$num_quiz = $db->num_rows($exec_quiz);
	
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
	<title>เธฃเธฒเธขเธเธฒเธฃเธเธณเธ–เธฒเธกเธเธญเธเน€เธเธกเธชเน</title>
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
function chkInput() {	
	arrRank = new Array();
	for(i=frm.first_row.value;i<=frm.end_row.value;i++) {
			for(j=0;j<arrRank.length;j++) {
				if(frm['question_rank'+i].value==arrRank[j]) {
					alert('เธเธฃเธธเธ“เธฒเธญเธขเนเธฒเธฃเธฐเธเธธเธฅเธณเธ”เธฑเธเธเนเธญเธเนเธณเธเธฑเธ');
					frm['question_rank'+i].focus();
					return false;
				}
			}
			arrRank.push(frm['question_rank'+i].value);
	}
	if(confirm('เธเธฑเธเธ—เธถเธเธเธฒเธฃเน€เธฃเธตเธขเธเธฅเธณเธ”เธฑเธเธเนเธญเธซเธฃเธทเธญเนเธกเน')) {
		frm.method='post';
		frm.accept.value='save';
		frm.submit();
	} 
}
function chkDel() {
	
	if(frm.sel_topic.value=='') {
		alert('เธเธฃเธธเธ“เธฒเน€เธฅเธทเธญเธเธซเธกเธงเธ”เธ—เธตเนเธ•เนเธญเธเธเธฒเธฃเธฅเธ');
		frm.sel_topic.focus();
		return false;
	}
	if(confirm('เธเธณเธ–เธฒเธก-เธเธณเธ•เธญเธ เธ เธฒเธขเนเธ•เนเธซเธกเธงเธ”เธเธตเนเธเธฐเธ–เธนเธเธฅเธเนเธเธ”เนเธงเธข')) {
		frm.method='post';
		frm.accept.value='deltopic';
		frm.submit();
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" rightmargin="0">
<table width="1000" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="100"><?php include($path."include/comadmin_top.php");?></td>
  </tr>
  <tr>
    <td height="400" valign="top" background="../images/images/bg_admin02.jpg">
<form name="frm" method="get" >
<H3>เธฃเธฒเธขเธเธฒเธฃเธเธณเธ–เธฒเธกเธเธญเธเน€เธเธกเธชเน</H3>

<?php $sql_options = " SELECT * FROM topic  ORDER BY topic_name ";	
?>เธซเธกเธงเธ”เธเธณเธ–เธฒเธก <select name="sel_topic" onChange="frm.submit();" >	
	<option value="">เธ—เธธเธเธซเธกเธงเธ”</option>
	<?php $disp->ddw_list_selected($sql_options, "topic_name", "topic_code", $sel_topic); ?>
	</select> 
<input name="chk_del" type="checkbox" value="1"  > &nbsp;&nbsp;เธฅเธเธซเธกเธงเธ”เธเธตเน  <input name="bt_del" type="button" value=" Apply " onClick="return chkDel();"><br>
	<img src="<?php echo $path;?>images/document_add.gif" border="0" align="absmiddle" style="cursor:pointer" alt="เน€เธเธดเนเธกเธเธณเธ–เธฒเธก" onClick="question = window.open('question_add.php?sel_topic='+frm.sel_topic.value,'question_add','menubar=no,location=no,scrollbars=yes,status=yes, resizable=no, left=100,top=100, width=500, height=480'); question.focus(); "> <input name="keyword" type="text" class="textBox" size="20" value="<?php echo $keyword;?>"> <img src="<?php echo $path;?>images/text_view.gif" border="0" align="absmiddle" onClick="frm.accept.value='search'; frm.submit()" style="cursor:pointer"><br>
	<table  border="1" bordercolor="#0066FF" cellspacing="0" cellpadding="2">
	<?php
			if($num_quiz) {
					?>
					<tr align="center" bgcolor="#0099FF">			
						
						<td width="50" ><strong>เธฅเธณเธ”เธฑเธเธ—เธตเน</strong></td>
						<td width="250" ><strong>เธเธณเธ–เธฒเธก</strong></td>
						<td width="150" ><strong>เธซเธกเธงเธ”</strong></td>
						<td width="80" ><strong>เธเธฐเนเธเธ</strong></td>
						<td width="60" ><strong>เธฅเธณเธ”เธฑเธเธเนเธญ</strong></td>
						<td width="100" >&nbsp;</td>
						
					  </tr>
					  <?php 
					  $i=$start_row+1;
					  
					  $bgC="#99CCFF";
					  while($rec_quiz = $db->fetch_array($exec_quiz)) { 
					  $bgC=($bgC=="#DAF1FE")? "#99CCFF":"#DAF1FE";
					  ?>
					  <tr bgcolor="<?php echo $bgC;?>">
					  	
						<td align="center"> <?php echo $i;?>. <input name="question_id<?php echo $i;?>" type="hidden" value="<?php echo $rec_quiz[question_id];?>"></td>
						<td align="left"> <?php echo $rec_quiz[question_name];?></td>
						<td align="center"> <?php echo $rec_quiz[topic_name];?></td>
						<td align="center"> <?php echo number_format($rec_quiz[question_score],0);?></td>		
						<td align="center"> <input name="question_rank<?php echo $i;?>" type="text" class="qty" size="3" value="<?php echo $rec_quiz[question_rank];?>" onKeyPress="return NumberOnly(this)"></td>
						<td align="center"> <img src="<?php echo $path;?>images/edit.gif" border="0" width="20" height="20" style="cursor:pointer" alt="เนเธเนเนเธเธเธณเธ–เธฒเธก" align="middle" onClick="question = window.open('question_add.php?question_id=<?php echo $rec_quiz[question_id];?>','question_edit','menubar=no,location=no,scrollbars=yes,status=yes, resizable=no, left=100,top=100, width=500, height=480'); question.focus();"> <img src="<?php echo $path;?>images/document_delete.gif" border="0" width="20" height="20" style="cursor:pointer" alt="เธฅเธเธเธณเธ–เธฒเธก" align="middle" onClick="if(confirm('เธ•เนเธญเธเธเธฒเธฃเธฅเธเธเธณเธ–เธฒเธก <?php echo $rec_quiz[question_name];?> เธซเธฃเธทเธญเนเธกเน')) { 
						window.location = 'question_list.php?cmd=delete1&question_id=<?php echo $rec_quiz[question_id];?>&sel_topic='+frm.sel_topic.value;
			} "></td>				
						
					  </tr>
						 <?php
						 $i++;
					  } // end while
				
			}	else {	  ?>
					<tr>
						<td width="450" height="100" align="center" >เนเธกเนเธเธเธเนเธญเธกเธนเธฅ</td>
					</tr>
			<?php } ?>
			</table><input name="first_row" type="hidden" value="<?php echo $start_row+1;?>"> <input name="end_row" type="hidden" value="<?php echo --$i;?>">
			<?php
?>
<?php if($totalPages) { ?>
<br>เธซเธเนเธฒ <select name="curPage" onChange="frm.submit();" >									
									<?php for($p=1;$p<=$totalPages;$p++) { 
													?><option value="<?php echo $p;?>" <?php if($p==$curPage) echo "selected"; ?>><?php echo $p;?></option><?php
											} 									
									 ?>
									 <option value="All" <?php if($curPage=="All") echo "selected"; ?> >==เนเธชเธ”เธเธ—เธฑเนเธเธซเธกเธ”==</option>
									 </select>
			<?php if($sel_topic) { ?><input name="bt_accept" type="button" value=" Apply " onClick="return chkInput()"><?php } ?> <?php } ?> <input name="accept" type="hidden"></form>
</td></tr>
<tr>
    <td ><?php include($path."include/comadmin_bottom.php");?></td>
  </tr>
 </table>
</body>
</html>