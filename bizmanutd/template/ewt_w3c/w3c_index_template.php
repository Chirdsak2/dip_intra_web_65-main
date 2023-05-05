<?php
 	session_start();
	$start_time_counter = date("YmdHis");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	
	
	$main_db = $EWT_DB_NAME;  
	
	
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

<title><?php echo $proj_title;?> - แสดงรายชื่อ Template</title>
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
<table width="100%"   border="0" cellpadding="0" cellspacing="0" >
   <tr valign="top">	
    <td width="100%"><?php // include("w3c_menu.php"); ?>
        <table  width="90%"  border="0" cellspacing="0" cellpadding="0"  align="center">
           <tr valign="top">
            <td >
        <H2 class="ewtfunction" >เลือก Template ที่ท่านต้องการให้ผ่านมาตรฐาน W3C </H2>
        <form name="frmSch" method="get">        
        <?php  				
        if($limit == ""){ $limit = 10;}
         //If $offset is set below zero (invalid) or empty, set to zero 
        if (!$offset || $offset < 0) $offset=0; 
        
        $filter = "";
        
        if($keyword) { // script ช่วยค้นหาแบบ google 555
        
                $arr_words = split("[+ ]",trim($keyword));		
                for($i=0;$i<count($arr_words);$i++) {
                        $filter .= " t1.d_name LIKE '%".$arr_words[$i]."%'   OR ";		
                }		
        }
		if($_GET["sourse"] == '1'){
			 $by2 = " ORDER BY  t1.d_name ASC ";		
		}else if($_GET["sourse"] == '2'){
			 $by2 = "  ORDER BY t1.d_modifi_date DESC ";		
		}else{
			 $by2 = "  ORDER BY t1.d_name  ASC ";		
		}
		// AND ( t2.w3c_html = 'w3c' AND  t2.w3c_wcag = 'w3c' AND t2.w3c_css = 'w3c' )
   /*     if($filter != '' && $chk_status != '2') {
            $filter = substr($filter,0,-4);
            $filter = " WHERE (".$filter." ) ";
        }else if($filter != '' && $chk_status == '2') {
			$filter = substr($filter,0,-4);
            $filter = " AND (".$filter." ) ";
		} */				
		
		if($chk_status == '1'){
			
			if($filter) {
				$filter = substr($filter,0,-4);
				$filter = " AND (".$filter." ) ";
			}
			
		$sqlCnt = "SELECT COUNT(t1.d_name) AS  totalrows FROM ".$EWT_DB_NAME.".design_list AS t1 INNER JOIN  w3c_ictweb.webpage_info AS t2 ON t1.d_name=t2.filename AND t2.db_name = '".$main_db."'  AND t2.page_type = '2'  WHERE  ( t2.w3c_html = 'w3c' AND  t2.w3c_wcag = 'w3c' AND t2.w3c_css = 'w3c' ) and t1.d_flag_w3c ='Y'   $filter   $by2  ";
		$sqlMain = " SELECT t1.d_id, t1.d_name, t1.d_modifi_date FROM ".$EWT_DB_NAME.".design_list AS t1 INNER JOIN  w3c_ictweb.webpage_info AS t2 ON t1.d_name=t2.filename AND t2.db_name = '".$main_db."'  AND t2.page_type = '2'  WHERE  ( t2.w3c_html = 'w3c' AND  t2.w3c_wcag = 'w3c' AND t2.w3c_css = 'w3c' ) and t1.d_flag_w3c ='Y'  $filter  $by2  LIMIT $offset, $limit ";
		
		} else if($chk_status == '3'){
			
			if($filter) {
				$filter = substr($filter,0,-4);
				$filter = " AND (".$filter." ) ";
			}
			
		$sqlCnt = "SELECT COUNT(t1.d_name) AS  totalrows FROM ".$EWT_DB_NAME.".design_list AS t1 INNER JOIN  w3c_ictweb.webpage_info AS t2 ON t1.d_name=t2.filename AND t2.db_name = '".$main_db."'  AND t2.page_type = '2'  WHERE  ( t2.w3c_html <> 'w3c' OR  t2.w3c_wcag <> 'w3c' OR t2.w3c_css <> 'w3c' OR t2.w3c_html is null OR  t2.w3c_wcag is null OR t2.w3c_css is null )   and t1.d_flag_w3c ='Y' $filter   $by2  ";
		$sqlMain = " SELECT t1.d_id, t1.d_name, t1.d_modifi_date FROM ".$EWT_DB_NAME.".design_list AS t1 INNER JOIN  w3c_ictweb.webpage_info AS t2 ON t1.d_name=t2.filename AND t2.db_name = '".$main_db."'  AND t2.page_type = '2'  WHERE  ( t2.w3c_html <> 'w3c' OR  t2.w3c_wcag <> 'w3c' OR t2.w3c_css <> 'w3c' OR t2.w3c_html is null OR  t2.w3c_wcag is null OR t2.w3c_css is null )  and t1.d_flag_w3c ='Y' $filter  $by2  LIMIT $offset, $limit ";
		
		} else if($chk_status == '2'){
				//ตรวจสอบก่อนว่า db2 มีข้อมูลหรือเปล่าอะไรบ้าง
				$begin_filter = $filter;
				
				if($begin_filter) {
					$begin_filter = substr($begin_filter,0,-4);
					$begin_filter = " AND (".$begin_filter." ) ";
				}							
				
				$dataname = array();
				$chk =$db->query("SELECT t1.d_id, t1.d_name, t1.d_modifi_date FROM ".$EWT_DB_NAME.".design_list AS t1 INNER JOIN  w3c_ictweb.webpage_info AS t2 ON t1.d_name=t2.filename AND t2.db_name = '".$main_db."'  AND t2.page_type = '2'  WHERE t1.d_flag_w3c ='Y' $begin_filter  $by2   ");
				if($db->db_num_rows($chk)>0){
					while($CK = $db->db_fetch_array($chk)){
						array_push($dataname,$CK["d_id"]);
					}
					$imp = implode(',',$dataname);
					$wh_ck = "AND  t1.d_id NOT IN ($imp) ";
					
						if($filter) {
							$filter = substr($filter,0,-4);
							$filter = " AND (".$filter." ) ";
						}
				}else{
					$wh_ck = '';
					
						if($filter) {
							$filter = substr($filter,0,-4);
							$filter = " AND (".$filter." ) ";
						}
				}
				$sqlCnt = "SELECT COUNT(t1.d_name) AS  totalrows FROM ".$EWT_DB_NAME.".design_list AS t1 LEFT JOIN  w3c_ictweb.webpage_info AS t2 ON t1.d_name=t2.filename AND t2.db_name = '".$main_db."'  AND t2.page_type = '2'  WHERE t1.d_flag_w3c ='Y'  $wh_ck $filter   $by2 ";
				$sqlMain = " SELECT t1.d_id, t1.d_name, t1.d_modifi_date FROM ".$EWT_DB_NAME.".design_list AS t1 LEFT JOIN  w3c_ictweb.webpage_info AS t2 ON t1.d_name=t2.filename AND t2.db_name = '".$main_db."'  AND t2.page_type = '2'  WHERE t1.d_flag_w3c ='Y'  $wh_ck  $filter  $by2  LIMIT $offset, $limit ";

		} else {
		
			if($filter) {
				$filter = substr($filter,0,-4);
				$filter = " AND (".$filter." ) ";
			}
		
			$sqlCnt= " SELECT  COUNT(t1.d_name) AS  totalrows FROM  ".$EWT_DB_NAME.".design_list AS t1  WHERE t1.d_flag_w3c ='Y'  $filter  $by2 ";
			$sqlMain = " SELECT t1.d_id, t1.d_name, t1.d_modifi_date FROM ".$EWT_DB_NAME.".design_list AS t1 WHERE  t1.d_flag_w3c ='Y'  $filter  $by2 LIMIT $offset, $limit ";
		}
        
        //echo "$sqlMain<br>";
        //exit;
        $execCnt = $db->query($sqlCnt);
        $recCnt = $db->db_fetch_array($execCnt);
        $totalrows = $recCnt[totalrows];
        
		
        //$sqlMain= " SELECT  filename,Main_Group_ID FROM  temp_index  WHERE  Main_Group_ID ='6' $filter  ORDER BY filename LIMIT $offset, $limit ";  //  เฉพาะ Template  
        //echo "$sqlMain<br>";
        //exit;
        $execMain = $db->query($sqlMain);
        $numMain = $db->db_num_rows($execMain);
        
        ?>
        ค้นหาหน้าเว็บเพจ <input name="keyword" type="text" size="30" class="Form-TextField" value="<?php echo $keyword;?>" onKeyPress="if(event.keyCode==13) frmSch.submit();"> 
		<br>
			การแสดงผล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<select name="sourse">
			<option value="">---กรุณาเลือก---</option>
			<option value="1" <?php if($_GET["sourse"]=='1'){ echo 'selected';}?>>เรียงตามชื่อเว็บเพจ</option>
			<option value="2" <?php if($_GET["sourse"]=='2'){ echo 'selected';}?>>ว/ด/ป ที่สร้าง/แก้ไขล่าสุด</option>
			</select><br>
		เลือกตามสถานะ&nbsp;&nbsp;
		<select name="chk_status">
		<option value="" <?php if($chk_status == ''){ echo 'selected';}?>>--เลือกสถานะ--</option>
		<option value="1" <?php if($chk_status == '1'){ echo 'selected';}?> >แปลง W3C แล้ว</option>
		<option value="3" <?php if($chk_status == '3'){ echo 'selected';}?> >แปลงเว็บเพจเบื้องต้น</option>
		<option value="2" <?php if($chk_status == '2'){ echo 'selected';}?>>ยังไม่แปลง W3C</option>
		</select>
             
            <!--select name="select">
              <option>ชื่อเว็บเพจ</option>
              <option>วันที่สร้าง</option>
              <option>วันที่แก้ไข</option>
              </select>
            <select name="select2">
              <option>น้อยไปหามาก</option>
              <option>มากไปน้อย</option>
              </select-->
            <img src="images/text_view.gif" alt="ค้นหา" align="absmiddle" style="cursor:hand"  onClick="frmSch.submit();"> <br>พบข้อมูลทั้งหมด <?php echo number_format($totalrows,0);?> แถว
         </form>
        <?php
        
        if($numMain > 0) {
            ?>        
            <table width="100%"  border="0" cellpadding="3" cellspacing="1" class="ewttableuse">
              <tr valign="top" class="ewttablehead">
                <th scope="col" width="20%">ชื่อ Template</th>
                <th scope="col" width="10%">หมวด</th>
                <th scope="col" width="10%">แปลงเว็บเพจ<br>
                  เบื้องต้น</th>
                <th scope="col" width="15%" >แก้ไข/ตรวจสอบ<br>เว็บเพจ</th>
                <th scope="col" width="10%">ผลการอนุมัติ W3C </th>
                <th scope="col" width="10%">วันที่แปลง<br>
เว็บเพจ</th>
                <th scope="col" width="10%">วันที่ปรับปรุง<br>
ล่าสุด</th>
                <th scope="col" width="5%">ยกเลิก</th>
                <th scope="col" width="5%">สถานะการแก้ไข</th>
              </tr>	  
            <?php
            $bgC="#FFFFCC";
            while($rec = $db->db_fetch_array($execMain)) {
			/*
                $sql_g = $db->query("SELECT Main_Group_Name FROM temp_main_group WHERE Main_Group_ID = '".$rec["Main_Group_ID"]."' ");
                $G = $db->db_fetch_row($sql_g);*/
                $bgC = ($bgC=="#FFFFCC")? "#FEF2C2": "#FFFFCC"; //"#33CC99";
                
                $FileName = $rec[d_name];
                
                $sql_check = " SELECT  * FROM  webpage_info  WHERE filename = '$FileName' AND db_name = '".$main_db."'  AND page_type = '2'  ";
                
                $exec_check = $db2->query($sql_check);
                $num_check = $db2->num_rows($exec_check);
                $rec_check = $db2->fetch_array($exec_check);
                
                //$user_preview = $UserPath."w3c".$sign_local."checked".$sign_local.$FileName.".php"; 
                //$user_preview = $dir1.$FileName.".php";  // $Website."w3c/checked/".$FileName.".php";  
                 $user_preview = "main_template.php?filename=".$FileName;			
                //$url_check =   $Website."w3c/checked/".$FileName.".php"; 
                $url_check = $phpMainTemplate2.$FileName;
                ?>
                <tr bgcolor="<?php echo $bgC;?>" >
                    <td><a href="<?php echo $url_check;?>" target="_blank"><?php echo $FileName;?></a> <?php //echo "<br>$user_preview"; ?></td>
                    <td>Template </td>
                    <td align="center"><img src="images/import1.gif" border="0" title="โหลด content" alt="โหลด content" width="24" height="24" align="middle" style="cursor:pointer" onClick="
                    <?php  if($rec_check[w3c_html]){
                                    if($rec_check[w3c_html]=='w3c') {
                                            $warn = "หน้าเว็บ $FileName นี้ผ่านมาตรฐาน W3C แล้ว\\nท่านต้องการ load หน้าเว็บมาแปลงอีกหรือไม่?";
                                    } else {
                                            $warn = "หน้าเว็บ $FileName นี้อยู่ในระหว่างการแก้ไขให้ผ่าน W3C\\nท่านต้องการ เริ่มแปลงหน้าเว็บใหม่อีกหรือไม่?";							
                                    }
                                    ?>
                                    if(confirm('<?php echo $warn;?>')) { 
                    
                                            
                    <?php  } ?>
                                            window.open('w3c_loadcontent.php?filename=<?php echo $FileName;?>&page_type=2');
                    <?php if($rec_check[w3c_html]){ ?>
                                    }
                    <?php } ?>
                    ">
                    <?php if($num_check) { ?><a href="w3c_validator.php?filename=<?php echo $FileName;?>&page_type=2" target="_blank"><img src="images/funnel_add.gif" border="0" title="แปลงเว็บเพจเบื้องต้น" alt="แปลงเว็บเพจเบื้องต้น" width="24" height="24" align="middle"></a><?php } ?></td>
                    <td align="center">
                    <?php if($num_check) { ?>
                    <a href="<?php echo $user_preview;?>" target="_blank">
                    <img src="images/text_view.gif" border="0" title="Preview" alt="Preview" width="24" height="24" align="middle"></a> <a href="w3c_editor.php?filename=<?php echo $FileName;?>&page_type=2" target="_blank"><img src="images/edit_24.gif" border="0" title="แก้ไขโดย Editor" alt="แก้ไขโดย Editor" width="24" height="24" align="middle"></a> 			       
                    <a href="result_return.php?filename=<?php echo $FileName;?>&w3c_type=1&page_type=2" target="_blank">
                    <img src="images/funnel_preferences.gif" border="0" title="ตรวจสอบด้วย Markup Validation Service" alt="ตรวจสอบด้วย Markup Validation Service" width="24" height="24" align="middle">	</a>	                    			
                    <a href="result_return.php?filename=<?php echo $FileName;?>&w3c_type=2&page_type=2" target="_blank">
                    <img src="images/document_preferences.gif" border="0" title="ตรวจสอบด้วย WCAG Validator" alt="ตรวจสอบด้วย WCAG Validator" width="24" height="24" align="middle"></a>
                    <a href="result_return.php?filename=<?php echo $FileName;?>&w3c_type=3&page_type=2" target="_blank">
                    <img src="images/window_preferences.gif" border="0" title="ตรวจสอบด้วย CSS Validation Service" alt="ตรวจสอบด้วย CSS Validation Service" width="24" height="24" align="middle"></a>	  
                    <?php } ?>                  </td>
                    <td align="center">
                   
                            <?php if($rec_check[w3c_html]=='w3c') { ?>
                                        <img src="images/pass.gif" border="0" title="ผ่าน W3C - HTML 4.01 แล้ว" alt="ผ่าน W3C - HTML 4.01 แล้ว" width="24" height="24" align="middle">
                            <?php } ?>						
                            
                            <?php if($rec_check[w3c_wcag]=='w3c') { ?>
                                        <img src="images/pass.gif" border="0" title="ผ่าน W3C - WCAG 1.0 แล้ว" alt="ผ่าน W3C - WCAG 1.0 แล้ว" width="24" height="24" align="middle">
                            <?php }  ?>
                                    
                            
                            <?php if($rec_check[w3c_css]=='w3c') { ?>
                                        <img src="images/pass.gif" border="0" title="ผ่าน W3C - CSS แล้ว" alt="ผ่าน W3C - CSS แล้ว" width="24" height="24" align="middle">
                            <?php } ?>                    </td>
                    <td align="center">&nbsp;
					<?php if(file_exists($dir2.$FileName.".php")) {  
									echo $date_file = date("Y-m-d H:i",filemtime($dir2.$FileName.".php"));
									if($date_file != ' '){
									
										$epl_date_file = explode(' ',$date_file);
										$epl_date_file_d = explode('-',$epl_date_file[0]);
										$epl_date_file_t = explode(':',$epl_date_file[1]);
										$d1 = mktime($epl_date_file_t[0], $epl_date_file_t[1], 0,$epl_date_file_d[1], $epl_date_file_d[2], $epl_date_file_d[0]);
										$epl_date_db = explode(' ',$rec["d_modifi_date"]);
										$epl_date_db_d = explode('-',$epl_date_db[0]);
										$epl_date_db_t = explode(':',$epl_date_db[1]);
										$d2 = mktime($epl_date_db_t[0], $epl_date_db_t[1], $epl_date_db_t[2],$epl_date_db_d[1], $epl_date_db_d[2], $epl_date_db_d[0]);
										if($d1 < $d2){
											$img_wan = "<img src=\"images\warning.gif\" width=\"25\" height=\"25\" alt=\"แจ้งเตือนมีการปรับปรุงหน้าเว็บ\">";
										}
									}
						} ?></td>
                     <td align="center"><?php echo $rec[d_modifi_date]?></td>
                     <td align="center"> 
                    <?php if($num_check) { ?>
                    <a href="w3c_del.php?filename=<?php echo $FileName;?>&page_type=2" target="_blank">
                    <img src="images/undo.gif" border="0" title="ยกเลิกการแปลง W3C" alt="ยกเลิกการแปลง W3C" width="24" height="24" align="middle"></a>
                    <?php } ?></td>
                     <td align="center"><?php echo $img_wan;?></td>
                </tr>
                <?php	
            }
            ?>
            </table>
            <br><?php echo "ข้ามไปยังหน้า ";
        // Begin Prev/Next Links 
        // Don't display PREV link if on first page 
            if ($offset !=0) {   
            $prevoffset=$offset-$limit; 
            echo   "<a href='w3c_index_template.php?offset=$prevoffset&limit=$limit&by=$by&keyword=$keyword&chk_status=$chk_status'>
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
                    echo "<font face='Verdana' size='2' color='black'><b>[$i]</b> </font>"; 
                } else { 
                    // $i is NOT the current page, so display a link to page $i 
                    $newoffset=$limit * ($i-1); 
                          echo  "<a href='w3c_index_template.php?offset=$newoffset&limit=$limit&by=$by&keyword=$keyword&chk_status=$chk_status' ". 
                          "onMouseOver=\"window.status='Page $i'; return true\";><font face='Verdana' size='2' color='black'>$i</font></a>\n\n"; 
                } 
            } 
                 
            // Check to see if current page is last page 
           if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
                // Not on the last page yet, so display a NEXT Link 
                $newoffset=$offset+$limit; 
                echo   "<a href='w3c_index_template.php?offset=$newoffset&limit=$limit&by=$by&keyword=$keyword&chk_status=$chk_status'>
                  <font face='Verdana' size='2'  color='blue'>>></font></a><p>\n"; 
            }
                     
        } else {
        
                ?>
                
                <table  border="0" cellspacing="1" cellpadding="3">
                    <tr><td width="600" height="400" align="center" style="color:#FF0000">ไม่พบเว็บเพจในระบบ</td></tr>
                </table><?php
        }
        $db2->close_db();
        $db->db_close();			
		//echo date("H:i");
		?>
        </td></tr></table>

</td></tr></table>
</body>
</html>
