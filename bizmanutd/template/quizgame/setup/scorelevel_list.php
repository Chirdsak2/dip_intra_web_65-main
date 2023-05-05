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
			if($_POST["dslevel_id"]) {
				$sql0 = " SELECT slevel_id, slevel_name  FROM  score_level  WHERE  slevel_id = '".$_POST["dslevel_id"]."' ";
				$exec0 = $db->query($sql0);	
				$rec0 = $db->fetch_array($exec0);
				
			
				$DELETE = " DELETE FROM score_level WHERE slevel_id = '".$_POST["dslevel_id"]."' ";
				$db->query($DELETE);
				
						?>
						<script type="text/javascript">
						alert('เธฅเธเธฃเธฐเธ”เธฑเธเธเธฐเนเธเธ <?php echo $rec0[slevel_name];?> เน€เธฃเธตเธขเธเธฃเนเธญเธขเนเธฅเนเธง');
						window.location = 'scorelevel_list.php'; 			
						</script>
						<?php
			} // SELECT * FROM topic  ORDER BY topic_name
	}
	
	$filter = "";
	
	if($keyword) {
		$filter .= " (  slevel_name LIKE '%$keyword%' )  AND ";
	}
	if($filter) {
		$filter = substr($filter,0,-4);
		$filter = " WHERE ".$filter;
	}
	$rowsPerPage = 10;
	
	$sql = " SELECT COUNT(slevel_id) AS tot_rows FROM  score_level 
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
					
	$sql_quiz = " SELECT * FROM  score_level 
	  					 $filter
						  ORDER BY slevel_id 
						 $LIMIT ";
	$exec_quiz = $db->query($sql_quiz);
	$num_quiz = $db->num_rows($exec_quiz);
	
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
	<title>เธฃเธฒเธขเธเธฒเธฃเธฃเธฐเธ”เธฑเธเธเธฐเนเธเธ</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
	<link rel="stylesheet" type="text/css" href="../css/basestyle.css">

<script type="text/javascript" src="<?php echo $path;?>js/functions.js"></script>		
<script type="text/javascript">

function chkDel(del_id, delWhat) {
		
	if(confirm('เธ•เนเธญเธเธเธฒเธฃเธฅเธเธฃเธฐเธ”เธฑเธเธเธฐเนเธเธ '+delWhat+' เธซเธฃเธทเธญเนเธกเน')) { 
		frm.dslevel_id.value = del_id;
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
<form name="frm" method="get" > <input name="dslevel_id" type="hidden">
<H3>เธฃเธฒเธขเธเธฒเธฃเธฃเธฐเธ”เธฑเธเธเธฐเนเธเธ</H3>

	<img src="<?php echo $path;?>images/document_add.gif" border="0" align="absmiddle" style="cursor:pointer" alt="เน€เธเธดเนเธกเธเธณเธ–เธฒเธก" onClick="scorelevel = window.open('scorelevel_add.php','scorelevel_add','menubar=no,location=no,scrollbars=yes,status=yes, resizable=no, left=100,top=100, width=500, height=480'); scorelevel.focus(); "> <input name="keyword" type="text" class="textBox" size="20" value="<?php echo $keyword;?>"> <img src="<?php echo $path;?>images/text_view.gif" border="0" align="absmiddle" onClick="frm.accept.value='search'; frm.submit()" style="cursor:pointer"><br>
	<table  border="1" bordercolor="#0066FF" cellspacing="0" cellpadding="2">
	<?php
			if($num_quiz) {
					?>
					<tr align="center" bgcolor="#0099FF">			
						
						<td width="50" ><strong>เธฅเธณเธ”เธฑเธเธ—เธตเน</strong></td>
						<td width="100" ><strong>เธเธทเนเธญเธฃเธฐเธ”เธฑเธเธเธฐเนเธเธ</strong></td>
						<td width="150" ><strong>เธเนเธงเธเธเธฐเนเธเธ</strong></td>
						<td width="100" ><strong>เธ เธฒเธเธเธทเนเธเธซเธฅเธฑเธ</strong></td>
						<td width="100" ><strong>เธซเธฅเธญเธ”เธเธฐเนเธเธ</strong></td>						
						<td width="100" >&nbsp;</td>
						
					  </tr>
					  <?php 
					  $i=$start_row+1;
					  
					  $bgC="#99CCFF";
					  while($rec_quiz = $db->fetch_array($exec_quiz)) { 
					  $bgC=($bgC=="#DAF1FE")? "#99CCFF":"#DAF1FE";
					  
					 
					  ?>
					  <tr bgcolor="<?php echo $bgC;?>" valign="top">
					  	
						<td align="center"> <?php echo $i;?>. <input name="slevel_id<?php echo $i;?>" type="hidden" value="<?php echo $rec_quiz[slevel_id];?>"></td>
						<td align="left"> <?php echo $rec_quiz[slevel_name];?></td>
						<td align="center"> <?php echo $rec_quiz[score_min];?>-<?php echo $rec_quiz[score_max];?></td>
						<td align="center"> <?php  if($rec_quiz[bg_path1] && file_exists($path.$rec_quiz[bg_path1])) { ?>
							<img src="<?php echo $path;?>images/text_view.gif" border="0" align="absmiddle" onClick="view = window.open('<?php echo $path.$rec_quiz[bg_path1];?>','view','menubar=no,location=no,scrollbars=yes,status=yes, resizable=yes, left=100,top=100, width=800, height=600'); view.focus();" style="cursor:pointer">
						<?php } ?>&nbsp;</td>		
						<td align="center"> <?php  if($rec_quiz[gauge_path1] && file_exists($path.$rec_quiz[gauge_path1])) { ?>
							<img src="<?php echo $path;?>images/text_view.gif" border="0" align="absmiddle" onClick="view = window.open('<?php echo $path.$rec_quiz[gauge_path1];?>','view','menubar=no,location=no,scrollbars=yes,status=yes, resizable=yes, left=300,top=100, width=155, height=410'); view.focus();" style="cursor:pointer">
						<?php } ?>&nbsp;</td>
						<td align="center"> <img src="<?php echo $path;?>images/edit.gif" border="0" width="20" height="20" style="cursor:pointer" alt="เนเธเนเนเธ" align="middle" onClick="scorelevel = window.open('scorelevel_add.php?slevel_id=<?php echo $rec_quiz[slevel_id];?>','scorelevel_edit','menubar=no,location=no,scrollbars=yes,status=yes, resizable=no, left=100,top=100, width=500, height=480'); scorelevel.focus();"> <img src="<?php echo $path;?>images/document_delete.gif" border="0" width="20" height="20" style="cursor:pointer" alt="เธฅเธ" align="middle" onClick="chkDel('<?php echo $rec_quiz[slevel_id];?>', '<?php echo $rec_quiz[slevel_name];?>');"></td>				
						
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