<?php
	session_start();
	header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	$db->query("USE datawarehouse");
	$sql = "select name,date_update,yearno,year,num,session_name,detail from data_wh where meeting_id = '$mid' and status = 'U'  group by meeting_id"; 
	$query = $db->query($sql);
	$R = $db->db_fetch_array($query);
	//link  list
	$thai_number = array('๑','๒','๓','๔','๕','๖','๗','๘','๙','๐');
	$eng_number = array('1','2','3','4','5','6','7','8','9','0');
if($_GET["id"]==1){
$main = "<a href=\"#G\" onClick=\"show_datawarehouse_list('','','');\" >หน้าหลัก</a>&nbsp;";
}else if($_GET["id"]==2){
$main = "<a href=\"#G\" onClick=\"change_value(5,0,0,'MY','','');\" >หน้าหลัก</a>&nbsp;";
}else if($_GET["id"]==3){
$main = "<a href=\"#G\" onClick=\"change_value(2,'1','','','','');\" >หน้าหลัก</a>&nbsp;";
}else{
$main = "<a href=\"#G\" onClick=\"show_datawarehouse_list('','','');\" >หน้าหลัก</a>&nbsp;";
}
if($R[yearno] != "" AND $R[yearno] != "0"){
$link_yearno = "<a href=\"#G\" onClick=\"change_value(2,'".$R[yearno]."','','','','');\"  > ชุดที่ ".str_replace($eng_number,$thai_number,$R[yearno])."</a>&nbsp;";
}
if($R[year] != "" AND $R[year] != "0"){
$link_year = "<a href=\"#G\" onClick=\"change_value(3,'".$R[yearno]."','".$R[year]."','','','');\"  > ปีที่ ".str_replace($eng_number,$thai_number,$R[year])."</a>&nbsp;";
}
if($R[num] != "" AND $R[num] != "0"){
$link_num = "<a href=\"#G\" onClick=\"change_value(4,'".$R[yearno]."','".$R[year]."','".$R[num]."','','');\"  > ครั้งที่ ".str_replace($eng_number,$thai_number,$R[num])."</a>&nbsp;";
}
if($R['session_name'] != "" AND $R['session_name'] != "0"){
$link_session_name = "<a href=\"#G\" onClick=\"change_value(5,'".$R[yearno]."','".$R[year]."','".urlencode($R['session_name'])."','".$R[num]."','');\"  >  ".str_replace($eng_number,$thai_number,$R['session_name'])."</a>&nbsp;";
}
?>
<table width="100%" border="0">
  <tr>
    <td><?php echo $main;?>><?php echo $link_yearno;?>><?php echo $link_year;?>><?php echo $link_session_name;?><hr width="100%"></td>
  </tr>
   <tr>
    <td><strong><?php echo $R[name];?></strong></td>
  </tr>
  <tr>
    <td><a href="#detail" onClick="if(document.all.mydetail.style.display == ''){ document.all.mydetail.style.display = 'none';document.all.mysrc.src='mainpic/arrow3.gif'; }else{ document.all.mydetail.style.display = '';document.all.mysrc.src='mainpic/arrow2.gif'; }"><strong>เรื่องที่พิจารณา</strong> <img id="mysrc" src="mainpic/arrow3.gif" width="7" height="7"align="absmiddle" border="0"  /></a></td>
  </tr>
  <tr id="mydetail" style="display:none">
    <td><?php echo $R[detail];?><br><br ></td>
  </tr>

  <?php
  $i=1; 
	$sql_file = "select path_file from data_wh where meeting_id = '$mid' and status = 'U' AND path_file != '' group by path_file";
	$query_file = $db->query($sql_file);
  if($db->db_num_rows($query_file) > 0){
	  ?>
  <tr>
    <td><strong>ข้อมูลการประชุม</strong></td>
  </tr>	  
	  <?php
  while($R_file = $db->db_fetch_array($query_file)){

  $sql_file_list = "select * from attach_file where attach_file_id ='".$R_file[path_file]."'";
  $query_file_list = $db->query($sql_file_list);
  $RF = $db->db_fetch_array($query_file_list);
  
  ?>
  <tr>
    <td><?php echo str_replace($eng_number,$thai_number,$i++);?>. <a href="##F" onclick="download('<?php echo $RF[attach_file_id];?>','<?php echo $_GET[mid];?>');" ><?php 
	 if($RF[status]=='0'){
	 echo "รายงานการประชุม";
	 }else if($RF[status]=='1'){
	 echo "บันทึกการประชุม";
	  }else if($RF[status]=='2'){
	 echo "บันทึกการออกเสียงและลงคะแนน";
	  }else if($RF[status]=='3'){
	 echo "สรุปเหตุการณ์";
	 }
	?></a></td>
  </tr>
  <?php }} ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php $db->db_close(); ?>
