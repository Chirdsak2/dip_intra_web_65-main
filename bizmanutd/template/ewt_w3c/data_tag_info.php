<?php  
	session_start();
	$start_time_counter = date("YmdHis");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	
	
	$main_db = $EWT_DB_NAME; //"db_163_ictweb";  อาจไม่ต้องใช้ ฐานข้อมูลลูกค้าเลย  เพราะเราอ่านข้อมูลจากหน้าเวบ url โดยตรง
	
	
	if(!$main_db) { // ถ้าไม่รู้ว่า จะดึงข้อมูลหน้าเว็บจาก db_name อันไหน  ให้ดีดออก
		echo "UnKnown Client Database";
		exit;
	}
	
	
	////////////////////////   connection สำหรับ W3C //////////////////////
    $path = "./";
	include ($path.'include/config.inc.php');
	include ($path.'include/class_db.php');
	include ($path.'include/class_display.php');	
	include ($path.'include/class_application.php');	
	$CLASS['db']   = new db2();
    $CLASS['db']->connect ();   
	$CLASS['disp'] = new display();
    $CLASS['app'] = new application();   
		   
	$db2   = $CLASS['db'];
    $disp = $CLASS['disp'];
	$app = $CLASS['app'];		
	
	$charac1 = $disp->convert_qoute_to_db("'");
	$charac2 = $disp->convert_qoute_to_db('"');		
		
	$invalid = false;
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Possible Attribute</title>
<script type="text/javascript" language="javascript1.2" src="js/AjaxRequest.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/functions.js"></script>
<script type="text/javascript" language="javascript1.2">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  return window.open(theURL,winName,features);
}
 
</script>
</head>
<?php
	
	if($cmd=='del') {
			$DELETE = " DELETE FROM  tag_info WHERE tag_id = '$tag_id' ";
			$db2->query($DELETE);
			?>
			<script type="text/javascript">alert('Record has been already deleted');</script>
			<?php
	}
 
	if($_POST["accept"]) {
	
				if(!$_POST["tag_id"]) {
				
						$sql_chk = " SELECT  tag_name  FROM  tag_info  WHERE tag_name = '".$_POST["tag_name"]."' ";
						$exec_chk = $db2->query($sql_chk);
						$num_chk = $db2->num_rows($exec_chk);
						
						if($num_chk==0) {  // ถ้า tag name นี้ยังไม่เคยมี จึงจะ insert 
				 
							$INSERT = " INSERT INTO tag_info (tag_name, section_id, need_status, need_close, tag_grand, tag_parent, tag_parent2, tag_parent3, w3c_notallow  ) 
												VALUES ('".$_POST["tag_name"]."', '".$_POST["section_id"]."','".$_POST["need_status"]."','".$_POST["need_close"]."' ,'".$_POST["tag_grand"]."' ,'".$_POST["tag_parent"]."','".$_POST["tag_parent2"]."','".$_POST["tag_parent3"]."' ,'".$_POST["w3c_notallow"]."'  )";
							$db2->query($INSERT);
					   } else {
					   		
					   			?>
								<script type="text/javascript">
									alert('Tag นี้มีในฐานข้อมูลอยู่แล้ว');					
									parent.location = 'tag_info.php';
								</script>
								<?php
					   }
			   } else {
			   
			   		$UPDATE = " UPDATE tag_info  SET  tag_name = '".$_POST["tag_name"]."',  section_id = '".$_POST["section_id"]."', need_status = '".$_POST["need_status"]."', need_close = '".$_POST["need_close"]."', tag_grand = '".$_POST["tag_grand"]."', tag_parent = '".$_POST["tag_parent"]."', tag_parent2 = '".$_POST["tag_parent2"]."', tag_parent3 = '".$_POST["tag_parent3"]."', w3c_notallow = '".$_POST["w3c_notallow"]."'  WHERE  tag_id = '".$_POST["tag_id"]."' ";
					
					$db2->query($UPDATE);
					
					?>
					<script type="text/javascript">
						alert('แก้ไขข้อมูลเรียบร้อยแล้ว.');					
						parent.location = 'tag_info.php';
					</script>
					<?php
			   
			   }
										
	}	
	
	if(!$curPage) $curPage = 1;
	
	 $sql_count = " SELECT COUNT(*)  AS total_records  FROM  tag_info  ORDER BY  tag_name ";
 	   $exec_count = $db2->query($sql_count);
	   $rec_count = $db2->fetch_array($exec_count);
	   $total_records = $rec_count[total_records];
       $rowsPerPage = 100;
	   $total_pages = ceil($total_records/$rowsPerPage);	
	   
	   if($curPage=='All') {
	   			$LIMIT = "";
	   } else {
			  		   
			   $start_rows = $rowsPerPage*($curPage-1);
			   
			   $LIMIT = " LIMIT $start_rows, $rowsPerPage ";
		} 
	?>
<body leftmargin="0" bgcolor="#F3F3F3">
<form name="frm1" method="get"  >
<table  border="0" cellspacing="1" cellpadding="2">
<caption align="right">Page <select name="curPage" onChange="frm1.submit();" >
			<option value="All">All</option>
			<?php		 
			for($page=1;$page<=$total_pages;$page++) {
				 ?><option value="<?php echo $page;?>" <?php if($page==$curPage) echo "selected"; ?>><?php echo $page;?></option><?php
			}
			?>
			</select>&nbsp;&nbsp;</caption>
  <tr align="center" bgcolor="#FF9900"  valign="top">
    <td width="100">Tag Name</td>   
	<td width="100">Tag Section</td>    
	<td width="50">ต้องมี</td>	
	<td width="80">ต้องมี Tag ปิด</td>	
	<td width="100">Tag แม่</td>
	<td width="100">Tag นำหน้า 1</td>
	<td width="100">Tag นำหน้า 2</td>
	<td width="80">หมายเหตุ</td>
	<td  >Command</td>
	<td width="100">Tag นำหน้า 3</td>
  </tr>  
 <?php  $sql_data = " SELECT tag_info.*,  section_name FROM  tag_info LEFT JOIN tag_section ON  tag_info.section_id = tag_section.section_id ORDER BY tag_name  $LIMIT ";
 		//echo "$sql_data<br>";
 	   $exec_data = $db2->query($sql_data); // edit_id DESC, 
	   $page_records = $db2->num_rows($exec_data); 
	   $i = 1;
	while( $rec_data = $db2->fetch_array($exec_data) ) { 
	
		$bgC=($bgC=="#FEF2C2")? "#FFFFCC":"#FEF2C2";
		?>
	  <tr bgcolor="<?php echo $bgC;?>"><td><?php echo $rec_data[tag_name];?></td>  
	  		<td><?php echo $rec_data[section_name];?></td>  
			<td align="center">&nbsp;<?php echo ($rec_data[need_status]=='1')? "ใช่":"&nbsp;";?> </td> 
			<td align="center">&nbsp<?php echo ($rec_data[need_close]=='1')? "ใช่":"&nbsp;";?> </td>  
			<td><?php echo $rec_data[tag_grand];?></td>
			<td><?php echo $rec_data[tag_parent];?></td>
			<td><?php echo $rec_data[tag_parent2];?></td>
			<td><?php echo ($rec_data[w3c_notallow]=='N')? "Not Allow":"&nbsp;";?></td>
			<td align="center">
				<img src="images/edit.gif" border="0" width="20" height="20" align="absmiddle" onClick=" parent.location = 'tag_info.php?cmd=edit&tag_id=<?php echo $rec_data[tag_id];?>'  " style="cursor:pointer">
				<img src="images/notpass.gif" border="0" width="20" height="20" align="absmiddle" onClick="if(confirm('ต้องการลบ Tag <?php echo $rec_data[tag_name];?> หรือไม่?')) { window.location = 'data_tag_info.php?cmd=del&tag_id=<?php echo $rec_data[tag_id];?>' } " style="cursor:pointer"></td>
			<td><?php echo $rec_data[tag_parent3];?></td>
		</tr>
	<?php
			$i++;
	 } ?>
</table>	
</form>
<?php	if($_POST["accept"]) {
			?>
					<script type="text/javascript">
						<?php if(!$_POST["tag_id"]) { ?>
									parent.frm.reset();
						<?php } ?>
					</script>
					<?php
			}
?>

</body>
</html>
