<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE datawarehouse");
include("meeting_datashow1.php");
	if($_REQUEST[flag]=='search'){
		if($_REQUEST[keyword]!=''){
			if($wh == ''){
			$li = 'where ';
			}else{
			$li = 'and ';
			}
			$wh_search = $li." (meeting_name REGEXP '".$_REQUEST[keyword]."' or meeting_detail REGEXP '".$_REQUEST[keyword]."')";
			$gopage = "&flag=search&keyword=".$_REQUEST[keyword];
		}
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0">

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/banner_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><a href="meeting_group.php">การจัดการข้อมูลรายงานและบันทึกการประชุม</a><a href="meeting_group.php" target="_self"></a> <?php echo $title;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp;&nbsp;&nbsp;<a href="meeting_group.php" target="_self"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> กลับหน้าหลัก</a>   
		&nbsp;&nbsp;&nbsp;<a href="meeting_add.php?groupid=<?php echo $_REQUEST["groupid"];?>" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> เพิ่มการประชุม</a>&nbsp;&nbsp;&nbsp;
      <hr>
    </td>
  </tr>
</table>
<form action="meeting_list.php" method="post"><table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td  valign="middle"> 
		คำค้น : <input name="keyword" type="text">&nbsp;<input name="submit" type="submit" value="ค้นหา">
		<input type="hidden" name="flag" value="search">   <input type="hidden" name="groupid" value="<?php echo $_REQUEST["groupid"];?>"> </td>
  </tr>
</table></form>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead">
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td >รายการการประชุม</td>
    <td >จำนวนเอกสาร</td>
    <td >ครั้งที่ประชุม</td>
    <td >สมัยการประชุม</td>
    <td >ประเภทการประชุม</td>
    <td >สถานะ</td>
    <!--<td width="5%" align="center" >อนุมัติ</td>-->
  </tr>
	<?php
	$i=0;
						$limit = "20";
					  if (empty($offset) || $offset < 0) { 
							$offset=0; 
						} 
						 if (empty($pages) || $pages < 0) { 
							$pages=1; 
						} 
	echo $sql = "select meeting.*, meeting_session.meeting_session_name from meeting inner join meeting_session on meeting.meeting_session_id=meeting_session.meeting_session_id    $wh  $wh_search order by meeting_num DESC";
	 $query_search = $db->query($sql);
	$sql .= " LIMIT $offset, $limit ";
	 $totalrows = $db->db_num_rows($query_search);
	$query = $db->query($sql);
	while($R = $db->db_fetch_array($query)){
	?>
  <tr bgcolor="#FFFFFF">
    <td align="center"><nobr><?php if($R["staus"] != "Y"){ ?><a href="meeting_add.php?mid=<?php echo $R[meeting_id];?>&groupid=<?php echo $_REQUEST["groupid"];?>"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไข" width="16" height="16" border="0">&nbsp;</a><a href="wh_function.php?flag=mt_del&mid=<?php echo $R[meeting_id];?>&groupid=<?php echo $_REQUEST["groupid"];?>"><img src="../theme/main_theme/g_del.gif" alt="ลบ" width="16" height="16" border="0" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');">&nbsp;</a><a href="meeting_file.php?mid=<?php echo $R[meeting_id];?>&groupid=<?php echo $_REQUEST["groupid"];?>"><img src="../images/workplace.gif" alt="ไฟล์เอกสารแนบ" width="16" height="16" border="0"></a><?php } ?>
	<a href="#view" onClick="window.open('wh_view.php?mid=<?php echo $R[meeting_id];?>', 'view', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=550, width=800, left=150,top=100');">&nbsp;<img src="../theme/main_theme/g_view.gif" alt="ดู" width="16" height="16" border="0"></a> 
	&nbsp;
	</nobr></td>
    <td><?php echo $R[meeting_name];?>
	<?php
	 if($_REQUEST[flag]=='search'){ 
	 echo '<DIV><br><font color="#999999">';
		 echo $R[meeting_type].'>ชุดที่ :'.$R[meeting_yearno].'>ปีที่ :'.$R[meeting_year];
		echo '</font></DIV>';
	 }
	 ?></td>
    <td><?php 
	$sql_nf = $db->query("select count(attach_file_id) as num from attach_file where meeting_id='$R[meeting_id]'");
	$N = $db->db_fetch_array($sql_nf);
	echo $N["num"];
	?></td>
    <td><?php echo $R[meeting_num];?></td>
    <td><?php echo $R[meeting_session_name];?></td>
    <td><?php echo $R[meeting_type];?></td>
    <td><?php if($R["staus"] == "Y"){ ?><a href="wh_function.php?flag=noapp&mid=<?php echo $R[meeting_id];?>&groupid=<?php echo $_REQUEST["groupid"];?>"><img src="../images/check_24.gif" alt="คลิกเพื่อยกเลิกการอนุมัติ" width="24" height="24" border="0"></a>&nbsp;
	<?php }else{ ?><a href="wh_function.php?flag=app&mid=<?php echo $R[meeting_id];?>&groupid=<?php echo $_REQUEST["groupid"];?>"><img src="../images/check_24d.gif" alt="คลิกเพื่ออนุมัติ" width="24" height="24" border="0"></a><?php } ?>&nbsp;</td>
    <!--  <td align="center"><input type="checkbox" name="app<?php echo $i;?>" value="Y" <?php if($R["staus"] == "Y"){ echo "checked"; } ?>>
      <input type="hidden" name="mid<?php echo $i;?>" value="<?php echo $R[meeting_id];?>"></td>-->
  </tr>
<?php 
$i++;
}
 ?>

<?php if($db->db_num_rows($query)==0){ ?>
  <tr align="right" bgcolor="#FFFFFF">
    <td colspan="8" align="center"><font color="#FF0000">--ไม่พบรายการ--</font></td>
    </tr>
<?php }else{ ?>
  <tr bgcolor="#FFFFFF">
    <td align="center">&nbsp;</td>
    <td colspan="6">&nbsp;</td>
    <!--<td align="center"><input type="button" name="Button" value="อนุมัติ" onClick="document.form1.Flag.value='Appmeeting';form1.submit();">
      <input type="hidden" name="Flag" value="">
	  <input type="hidden" name="num" value="<?php echo $i;?>"></td>-->
  </tr>
	  <tr bgcolor="#FFFFFF">
    	<td colspan="8">หน้าที่ :
    <?php if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href=\"meeting_list.php?groupid=".$_REQUEST["groupid"].$gopage."&offset=$prevoffset\" >
ย้อนกลับ</a> ";
}


    // Calculate total number of pages in result 
   $pages = intval($totalrows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($totalrows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     $current = ($offset/$limit) - 1;
	 $start = $current - 10;
	 if($start < 1){
	 $start = 1;
	 }
	 $end = $current + 10;
	 