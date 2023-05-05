<?
 	session_start();
	$start_time_counter = date("YmdHis");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	/*
	include("../../../ewt_block_function.php");
	include("../../../ewt_menu_preview.php");
	include("../../../ewt_article_preview.php");
	include("../../../ewt_public_function.php");
	*/ 	
	//$UserPath = "\\\\".$EWT_ROOT_HOST."\\".$EWT_FOLDER_USER."\\";
	//$Website = "http://192.168.0.250/ewtadmin/ewt/ictweb/";  ย้ายไปไว้ใน config.inc.php ของเราแล้ว
	//$Website = "http://".$EWT_ROOT_HOST."/ewtadmin/ewt/$EWT_FOLDER_USER/";  // ictweb
	
	$main_db = $EWT_DB_NAME; //"db_163_ictweb";   ใช้ ฐานข้อมูลลูกค้า เพื่ออ่านชื่อไฟล์มาให้เลือก 
	
	
	if(!$main_db) { // ถ้าไม่รู้ว่า จะดึงข้อมูลหน้าเว็บจาก db_name อันไหน  ให้ดีดออก
		echo "UnKnown Client Database";
		exit;
	}
	
	
	////////////////////////   connection สำหรับ W3C //////////////////////
    $path = "";
	include ($path.'include/config.inc.php');
	include ($path.'include/class_db.php');
	include ($path.'include/class_display.php');	
	$CLASS['db']   = new db2();
    $CLASS['db']->connect ();   
	$CLASS['disp'] = new display();
    //$CLASS['app'] = new application();   
		   
	$db2   = $CLASS['db'];
    $disp = $CLASS['disp'];
	//$app = $CLASS['app'];		
	
	$charac1 = $disp->convert_qoute_to_db("'");
	$charac2 = $disp->convert_qoute_to_db('"');
	
	
	$invalid = false;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title><?=$proj_title;?> - แสดงรายชื่อเว็บเพจ</title>
<link href="../../../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript1.2" src="js/AjaxRequest.js"></script>
<script type="text/javascript" language="javascript1.2" src="js/functions.js"></script>
<script type="text/javascript" language="javascript1.2">
function chkInput() {
	/*	if(frm.w3c_description.value == '') {
			 alert('กรุณากรอกคำอธิบายรายละเอียดเว็บเพจ');
			 frm.w3c_description.focus();
			 return false;
		}*/
		frm.run_edit.value=1; 	 
		frm.submit();
}
</script>
</head>
<body>
<table  width="90%"  border="0" cellspacing="0" cellpadding="0"  align="center">
   <tr valign="top">
	<td >
<H2 class="ewtfunction" >เลือกเว็บเพจที่ท่านต้องการให้ผ่านมาตรฐาน W3C</H2>
<form name="frmSch" method="get">
<div align="right">
  <input type="button" name="Button" value="แสดงเฉพาะหน้าที่มีการเปลี่ยนแปลง">
   <input type="button" name="Button" value="แสดงหน้าเว็บเพจทั้งหมด"></div>
<?  				
if($limit == ""){ $limit = 10;}
 //If $offset is set below zero (invalid) or empty, set to zero 
if (!$offset || $offset < 0) $offset=0; 

$filter = "";

if($keyword) { // script ช่วยค้นหาแบบ google 555

		$arr_words = split("[+ ]",trim($keyword));		
		for($i=0;$i<count($arr_words);$i++) {
				$filter .= " filename LIKE '%".$arr_words[$i]."%'   OR ";		
		}		
}
if($filter) {
	$filter = substr($filter,0,-4);
	$filter = " WHERE (".$filter." ) ";
}	
$sqlCnt= " SELECT  COUNT(filename) AS  totalrows FROM  temp_index  $filter  ORDER BY filename ";
//echo "$sqlMain<br>";
//exit;
$execCnt = $db->query($sqlCnt);
$recCnt = $db->db_fetch_array($execCnt);
$totalrows = $recCnt[totalrows];

$sqlMain= " SELECT  filename,Main_Group_ID FROM  temp_index  $filter  ORDER BY filename LIMIT $offset, $limit ";
//echo "$sqlMain<br>";
//exit;
$execMain = $db->query($sqlMain);
$numMain = $db->db_num_rows($execMain);

?>
ค้นหาหน้าเว็บเพจ <input name="keyword" type="text" size="30" class="Form-TextField" value="<?=$keyword;?>" onKeyPress="if(event.keyCode==13) frmSch.submit();"> 
	เรียงจาก 
	<select name="select">
	  <option>ชื่อเว็บเพจ</option>
	  <option>วันที่สร้าง</option>
	  <option>วันที่แก้ไข</option>
	  </select>
	<select name="select2">
	  <option>น้อยไปหามาก</option>
	  <option>มากไปน้อย</option>
	  </select>
	<img src="images/text_view.gif" alt="ค้นหา" align="absmiddle" style="cursor:hand"  onClick="frmSch.submit();"> <br>พบข้อมูลทั้งหมด <?=number_format($totalrows,0);?> แถว
<?php

if($numMain > 0) {
	?>
	<table width="100%"  border="0" cellpadding="3" cellspacing="1" class="ewttableuse">
	  <tr valign="top" class="ewttablehead">
		<th scope="col" width="30%">ชื่อเว็บเพจ</th>
		<th scope="col" width="15%">หมวด</th>
		<th scope="col" width="20%">แปลงเว็บเพจ<br>
		  เบื้องต้น</th>
		<th scope="col" width="15%" >แก้ไข/ตรวจสอบ<br>เว็บเพจ</th>
		<th scope="col" width="10%">อนุมัติ W3C </th>
		<th scope="col" width="10%">วันที่ปรับปรุง</th>
	  </tr>	  
	<?
	$bgC="#FFFFCC";
	while($rec = $db->db_fetch_array($execMain)) {
		$sql_g = $db->query("SELECT Main_Group_Name FROM temp_main_group WHERE Main_Group_ID = '".$rec["Main_Group_ID"]."' ");
		$G = $db->db_fetch_row($sql_g);
		$bgC = ($bgC=="#FFFFCC")? "#FEF2C2": "#FFFFCC"; //"#33CC99";
		
		$FileName = $rec[filename];
		
		$sql_check = " SELECT  * FROM  webpage_info  WHERE filename = '$FileName' AND db_name = '".$main_db."'   ";
		
		$exec_check = $db2->query($sql_check);
		$num_check = $db2->num_rows($exec_check);
		$rec_check = $db2->fetch_array($exec_check);
		
		//$user_preview = $UserPath."w3c".$sign_local."checked".$sign_local.$FileName.".php"; 
		$user_preview = $Website.$folder."/checked/".$FileName.".php";  
		
		//$url_check =   $Website."w3c/checked/".$FileName.".php"; 
		$url_check = $Website."main_body.php?filename=".$FileName;
		?>
		<tr bgcolor="<?=$bgC;?>" >
			<td><a href="<?=$url_check;?>" target="_blank"><?=$FileName;?></a> <? //echo "<br>$user_preview"; ?></td>
			<td><?php echo $G[0]; ?></td>
			<td align="center"><img src="images/import1.gif" border="0" alt="โหลด content" width="24" height="24" align="middle" style="cursor:pointer" onClick="
			<?  if($rec_check[w3c_status]){
				   			if($rec_check[w3c_status]=='w3c') {
									$warn = "หน้าเว็บ $FileName นี้ผ่านมาตรฐาน W3C แล้ว\\nท่านต้องการ load หน้าเว็บมาแปลงอีกหรือไม่?";
							} else {
									$warn = "หน้าเว็บ $FileName นี้อยู่ในระหว่างการแก้ไขให้ผ่าน W3C\\nท่านต้องการ เริ่มแปลงหน้าเว็บใหม่อีกหรือไม่?";							
							}
							?>
							if(confirm('<?=$warn;?>')) { 
			
									
			<?  } ?>
									window.open('w3c_loadcontent.php?filename=<?=$FileName;?>');
			<? if($rec_check[w3c_status]){ ?>
							}
			<? } ?>
			">
			<? if($num_check) { ?><a href="w3c_validator.php?filename=<?=$FileName;?>" target="_blank"><img src="images/funnel_add.gif" border="0" alt="แปลงเว็บเพจเบื้องต้น" width="24" height="24" align="middle"></a><? } ?></td>
			<td align="center">
			<? if(@file_get_contents($user_preview)) { ?>
			<a href="<?=$user_preview;?>" target="_blank">
			<img src="images/text_view.gif" border="0" alt="Preview" width="24" height="24" align="middle"></a> <a href="w3c_editor.php?filename=<?=$FileName;?>" target="_blank"><img src="images/edit_24.gif" border="0" alt="แก้ไขโดย Editor" width="24" height="24" align="middle"></a> 
			<? } ?>
			<a href="http://validator.w3.org/check?uri=<?=$user_preview;?>" target="_blank">
			<img src="images/funnel_preferences.gif" border="0" alt="ตรวจสอบด้วย Validator" width="24" height="24" align="middle">	</a>			</td>
			<td align="center">
			<? if(@file_get_contents($user_preview)) { ?>
			
					<? if($rec_check[w3c_status]=='w3c') { ?>
								<img src="images/pass.gif" border="0" alt="ผ่าน W3C แล้ว" width="24" height="24" align="middle">
					<? } else { ?>
							<a href="w3c_save.php?filename=<?=$FileName;?>" target="_blank">
							<img src="images/disk_blue.gif" border="0" alt="ยืนยันการใช้งาน" width="24" height="24" align="middle">							</a>
					<? } ?>
			<? } ?></td>
			<td align="center">&nbsp;</td>
	  	</tr>
		<?	
	}
	?>
	</table>
	<br><?
echo "ข้ามไปยังหน้า ";
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
	if ($offset !=0) {   
	$prevoffset=$offset-$limit; 
	echo   "<a href='w3c_index.php?offset=$prevoffset&limit=$limit&by=$by&keyword=$keyword'>
	<font face='Verdana'  size='2' color='blue'><<</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($totalrows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($totalrows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font face='Verdana' size='2' color='black'>$i </font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='w3c_index.php?offset=$newoffset&limit=$limit&by=$by&keyword=$keyword' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face='Verdana' size='2' color='black'>$i</font></a>\n\n"; 
        } 
    } 
         
    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='w3c_index.php?offset=$newoffset&limit=$limit&by=$by&keyword=$keyword'>
		  <font face='Verdana' size='2'  color='blue'>>></font></a><p>\n"; 
    }

} else {

		?>
		
		<table  border="0" cellspacing="1" cellpadding="3">
			<tr><td width="600" height="400" align="center" style="color:#FF0000">ไม่พบเว็บเพจในระบบ</td></tr>
		</table><?
}
$db2->close_db();
$db->db_close();			?>
</form>
</td></tr></table>
</body>
</html>
