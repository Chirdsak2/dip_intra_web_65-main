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
			if($_POST["dtopic_code"]) {
				$sql0 = " SELECT * FROM  topic  WHERE  topic_code = '".$_POST["dtopic_code"]."' ";
				$exec0 = $db->query($sql0);	
				$rec0 = $db->fetch_array($exec0);
				
				$sql1 = " SELECT question_id, question_name FROM  questions  WHERE topic_code = '".$_POST["dtopic_code"]."' ";
				$exec1 = $db->query($sql1);				
				while($rec1 = $db->fetch_array($exec1)) {			
					$question_id = $rec1[question_id];
					
					$DELETE = " DELETE FROM choices WHERE question_id = '$question_id' ";
					$db->query($DELETE);
					
					$DELETE = " DELETE FROM questions WHERE question_id = '$question_id' ";
					$db->query($DELETE);
				}
				$DELETE = " DELETE FROM topic WHERE topic_code = '".$_POST["dtopic_code"]."' ";
				$db->query($DELETE);
				
						?>
						<script type="text/javascript">
						alert('เธฅเธเธซเธกเธงเธ” <?php echo $rec0[topic_name];?> เนเธฅเธฐ เธเธณเธ–เธฒเธก-เธเธณเธ•เธญเธเธเธญเธเธซเธกเธงเธ”  เน€เธฃเธตเธขเธเธฃเนเธญเธขเนเธฅเนเธง');
						window.location = 'topic_list.php'; 			
						</script>
						<?php
			} // SELECT * FROM topic  ORDER BY topic_name
	}
	
	$filter = "";
	
	if($keyword) {
		$filter .= " (  topic_code LIKE '%$keyword%' OR topic_name LIKE '%$keyword%' )  AND ";
	}
	if($filter) {
		$filter = substr($filter,0,-4);
		$filter = " WHERE ".$filter;
	}
	$rowsPerPage = 10;
	
	$sql = " SELECT COUNT(topic_code) AS tot_rows FROM  topic 
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
					
	$sql_quiz = " SELECT * FROM  topic 
	  					 $filter
						  ORDER BY topic_code 
						 $LIMIT ";
	$exec_quiz = $db->query($sql_quiz);
	$num_quiz = $db->num_rows($exec_quiz);
	
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
	<title>เธฃเธฒเธขเธเธฒเธฃเธซเธกเธงเธ”เธเธณเธ–เธฒเธก</title>
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

function chkDel() {
	
	if(frm.dtopic_code.value=='') {
		alert('เธเธฃเธธเธ“เธฒเน€เธฅเธทเธญเธเธซเธกเธงเธ”เธ—เธตเนเธ•เนเธญเธเธเธฒเธฃเธฅเธ');
		//frm.dtopic_code.focus();
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
<form name="frm" method="get" > <input name="dtopic_code" type="hidden">
<H3>เธฃเธฒเธขเธเธฒเธฃเธซเธกเธงเธ”เธเธณเธ–เธฒเธก</H3>

	<img src="<?php echo $path;?>images/document_add.gif" border="0" align="absmiddle" style="cursor:pointer" alt="เน€เธเธดเนเธกเธเธณเธ–เธฒเธก" onClick="topic = window.open('topicicon_add.php','topic_add','menubar=no,location=no,scrollbars=yes,status=yes, resizable=no, left=100,top=100, width=500, height=480'); topic.focus(); "> <input name="keyword" type="text" class="textBox" size="20" value="<?php echo $keyword;?>"> <img src="<?php echo $path;?>images/text_view.gif" border="0" align="absmiddle" onClick="frm.accept.value='search'; frm.submit()" style="cursor:pointer"><br>
	<table  border="1" bordercolor="#0066FF" cellspacing="0" cellpadding="2">
	<?php
			if($num_quiz) {
					?>
					<tr align="center" bgcolor="#0099FF">			
						
						<td width="50" ><strong>เธฅเธณเธ”เธฑเธเธ—เธตเน</strong></td>
						<td width="150" ><strong>topic code</strong></td>
						<td width="150" ><strong>เธเธทเนเธญเธซเธกเธงเธ”</strong></td>
						<td width="200" ><strong>Flash Icon</strong></td>
						<td width="80" ><strong>เธชเธ–เธฒเธเธฐ</strong></td>						
						<td width="100" >&nbsp;</td>
						
					  </tr>
					  <?php 
					  $i=$start_row+1;
					  
					  $bgC="#99CCFF";
					  while($rec_quiz = $db->fetch_array($exec_quiz)) { 
					  $bgC=($bgC=="#DAF1FE")? "#99CCFF":"#DAF1FE";
					  
					 
					  ?>
					  <tr bgcolor="<?php echo $bgC;?>" valign="top">
					  	
						<td align="center"> <?php echo $i;?>. <input name="topic_code<?php echo $i;?>" type="hidden" value="<?php echo $rec_quiz[topic_code];?>"></td>
						<td align="left"> <?php echo $rec_quiz[topic_code];?></td>
						<td align="left"> <?php echo $rec_quiz[topic_name];?></td>
						<td align="center"> <?php  if($rec_quiz[icon_path] && file_exists($path.$rec_quiz[icon_path])) { ?>
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,19,0" width="130" height="130"  >
  <param name="movie" value="<?php echo $path.$rec_quiz[icon_path];?>">
  <param name="quality" value="high">
  <param name="wmode" value="transparent">
  <embed src="<?php echo $path.$rec_quiz[icon_path];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="130" height="130" wmode="transparent" swLiveConnect="true"></embed>
</object>
						<?php } ?>&nbsp;</td>		
						<td align="center"> <?php echo ($rec_quiz[topic_use]=='1')? "เนเธเนเธญเธขเธนเน":"&nbsp;";?> </td>
						<td align="center"> <img src="<?php echo $path;?>images/edit.gif" border="0" width="20" height="20" style="cursor:pointer" alt="เนเธเนเนเธ" align="middle" onClick="topic = window.open('topicicon_add.php?topic_code=<?php echo $rec_quiz[topic_code];?>','topic_edit','menubar=no,location=no,scrollbars=yes,status=yes, resizable=no, left=100,top=100, width=500, height=480'); topic.focus();"> <img src="<?php echo $path;?>images/document_delete.gif" border="0" width="20" height="20" style="cursor:pointer" alt="เธฅเธ" align="middle" onClick="if(confirm('เธ•เนเธญเธเธเธฒเธฃเธฅเธเธซเธกเธงเธ” <?php echo $rec_quiz[topic_name];?> เธซเธฃเธทเธญเนเธกเน')) { 
						frm.dtopic_code.value = '<?php echo $rec_quiz[topic_code];?>';
						chkDel();
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
		 <?php } ?> <input name="accept" type="hidden"></form>
</td></tr>
<tr>
    <td ><?php include($path."include/comadmin_bottom.php");?></td>
  </tr>
 </table>
</body>
</html>