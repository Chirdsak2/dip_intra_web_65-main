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
<title>Correct Attribute</title>
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
			$DELETE = " DELETE FROM  value_edit_attr_tag WHERE edit_id = '$edit_id' ";
			$db2->query($DELETE);
			?>
			<script type="text/javascript">alert('ลบรายการเรียบร้อยแล้ว');</script>
			<?php
	}
 
	if($_POST["accept"]) {
			
			// data_type เฉพาะของ attribute value 
			
			if(!$_POST["edit_id"]) {	
					
					$sql_chk0 = " SELECT  * FROM  value_edit_attr_tag  WHERE tag_name = '".$_POST["tag_name"]."' AND 
					attribute_name = '".$_POST["attribute_name"]."' AND wrong_value = '".$_POST["wrong_value"]."' AND 
					correct_value = '".$_POST["correct_value"]."' AND wrong_attribute = '".$_POST["wrong_attribute"]."' ";
					$exec_chk0 = $db2->query($sql_chk0);
					$num_chk0 = $db2->num_rows($exec_chk0);
					
					if($num_chk0==0) {
						$INSERT = " INSERT INTO value_edit_attr_tag (tag_name, attribute_name, wrong_value, correct_value, wrong_attribute, recommend, notnull, data_type ) 
											VALUES ('".$_POST["tag_name"]."', '".$_POST["attribute_name"]."','".$_POST["wrong_value"]."','".$_POST["correct_value"]."' ,'".$_POST["wrong_attribute"]."' ,'".$disp->convert_qoute_to_db($_POST["recommend"])."', '".$_POST["notnull"]."',  '".$_POST["data_type"]."' )";
						$db2->query($INSERT);
						
					} else {
						
							?>
							<script type="text/javascript">
								alert('ท่านกรอกรายการแก้ไขหน้าเวบซ้ำ');					
								parent.location = 'correct_attribute.php';
							</script>
							<?php
				   }
			} else {
					
					$UPDATE = " UPDATE value_edit_attr_tag  SET  tag_name = '".$_POST["tag_name"]."',  attribute_name = '".$_POST["attribute_name"]."', 
					wrong_value = '".$_POST["wrong_value"]."', correct_value = '".$_POST["correct_value"]."' , 
					wrong_attribute = '".$_POST["wrong_attribute"]."' , recommend = '".$disp->convert_qoute_to_db($_POST["recommend"])."', notnull =  '".$_POST["notnull"]."', data_type = '".$_POST["data_type"]."'  WHERE  edit_id = '".$_POST["edit_id"]."' ";
					
					$db2->query($UPDATE);
					
					?>
					<script type="text/javascript">
						alert('แก้ไขข้อมูลเรียบร้อยแล้ว');					
						parent.location = 'correct_attribute.php';
					</script>
					<?php			   
			
			}
										
	}	
	
	if(!$curPage) $curPage = 1;
	
	 $sql_count = " SELECT COUNT(*)  AS total_records  FROM  value_edit_attr_tag  ORDER BY  tag_name, attribute_name ";
 	   $exec_count = $db2->query($sql_count);
	   $rec_count = $db2->fetch_array($exec_count);
	   $total_records = $rec_count[total_records];
       $rowsPerPage = 100;
	   $total_pages = ceil($total_records/$rowsPerPage);	
	   
	   if($curPage=='All') {
	   			$LIMIT = "";
				$start_rows = 0;
	   } else {
			  		   
			   $start_rows = $rowsPerPage*($curPage-1);
			   
			   $LIMIT = " LIMIT $start_rows, $rowsPerPage ";
		} 
	?>
<body leftmargin="0" bgcolor="#F3F3F3">
<form name="frm1" method="get"  >
<table  border="0" cellspacing="1" cellpadding="2" style="font-family:MS Sans Serif; font-size:10pt;">
<caption align="right">Page <select name="curPage" onChange="frm1.submit();" >
			<option value="All">All</option>
			<?php		 
			for($page=1;$page<=$total_pages;$page++) {
				 ?><option value="<?php echo $page;?>" <?php if($page==$curPage) echo "selected"; ?>><?php echo $page;?></option><?php
			}
			?>
			</select>&nbsp;&nbsp;</caption>
  <tr align="center" bgcolor="#FF9900"  valign="top">
  	<td width="50">ลำดับที่</td>
    <td width="100">Tag Name</td>   	
    <td width="120">Wrong<br>Attribute Name</td>    
	<td width="120">Correct<br>Attribute Name</td>    
	<td width="120">Wrong<br>Attribute Value</td>    
	<td width="120">Correct<br>Attribute Value</td> 
	<td width="160">Recommend</td> 
	<td>Command</td>
  </tr>  
 <?php  $sql_data = " SELECT *  FROM  value_edit_attr_tag  ORDER BY tag_name, attribute_name $LIMIT ";
 	   $exec_data = $db2->query($sql_data); // edit_id DESC, 
	   $page_records = $db2->num_rows($exec_data); 
	   //$i = 1;
	    $i = $start_rows+1;
	while( $rec_data = $db2->fetch_array($exec_data) ) { 
	
		$bgC=($bgC=="#FEF2C2")? "#FFFFCC":"#FEF2C2";
		?>
	  <tr bgcolor="<?php echo $bgC;?>">
	  		<td align="center"><?php echo $i;?></td>
			<td><?php echo $rec_data[tag_name];?></td>  
	  		<td><?php echo $rec_data[wrong_attribute];?></td>  
			<td><?php echo $rec_data[attribute_name];?></td> 
			<td><?php echo $rec_data[wrong_value];?></td>  
			<td><?php echo $rec_data[correct_value];?></td>
			<td><?php echo $rec_data[recommend];?><?php if($rec_data[notnull]) { echo " ( Not Null )"; } ?></td>
			<td align="center">
			<img src="images/edit.gif" border="0" width="20" height="20" align="absmiddle" onClick=" parent.location = 'correct_attribute.php?cmd=edit&edit_id=<?php echo $rec_data[edit_id];?>'  " style="cursor:pointer">
			<img src="images/notpass.gif" border="0" width="20" height="20" onClick="if(confirm('ต้องการลบรายการ ลำดับที่ <?php echo $i;?> หรือไม่?')) { window.location = 'data_correct_attribute.php?cmd=del&edit_id=<?php echo $rec_data[edit_id];?>' } " style="cursor:pointer"></td>
		</tr>
	<?php
			$i++;
	 } ?>
</table>	
</form>
<?php	if($_POST["accept"]) {
			?>
					<script type="text/javascript">
						parent.frm.reset();
					</script>
					<?php
		}
?>

</body>
</html>
