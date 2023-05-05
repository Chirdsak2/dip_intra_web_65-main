<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
function show_detail($id,$link){
global $db;
	$sql = "select * from virtual_group where vg_id = '".$id."'";
	$query = $db->query($sql);
	$R = $db->db_fetch_array($query);
	if($R[vg_parent] =='0'){
	echo $name = '>>'.$R[vg_name];
	}else{
	//$name = '<a href="virtual_choose.php?G_id='.$R[vg_parent].'" >'.$R[vg_name].' </a>>>';
	
	}
}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<form name="myFrom" method="post" >
<?php
	if($_GET[G_id] == '' || $_GET[G_id] == '0'){
	$_GET[G_id]  = '0';
	}
?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/virtual_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><a href="virtual_choose.php" >ข้อมูล Virtual </a><?php echo show_detail($_GET[G_id],'');?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr> 
      <td align="right">
	  <a href="virtual_choose.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
        <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td height="30">รายชื่อ</td>
    </tr>
	<?php
	function chk_cate_chid($id){
	global $db;
	$sql = "select count(vg_id) as counter from virtual_group where vg_parent = '".$id."' ";
	$query = $db->query($sql);
	$R = $db->db_fetch_array($query);
	return $R[counter];
	}
	$sql = "select * from virtual_group where vg_parent = '".$_GET[G_id] ."' ";
	$query = $db->query($sql);
	while($R = $db->db_fetch_array($query)){
			 
				$num_child = chk_cate_chid($R[vg_id]);
	?>
			  <tr bgcolor="#FFFFFF" > 
				<td><img src="../images/minus.gif"  id="img_<?php echo $R[vg_id];?>"  width="21" height="21" align="absmiddle" onClick="show_datachid(<?php echo $R[vg_id];?>,this)">&nbsp;
				<?php if($num_child > 0 ){ ?>
				<a href="virtual_choose.php?G_id=<?php echo $R[vg_id];?>"><?php echo $R[vg_name];?></a>
				<?php echo '['.$num_child.' หมวด]';?>
				<?php }else{  echo $R[vg_name]; }?>
				<span id="G<?php echo $R[vg_id];?>" ><!--style="display:none"-->
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  
			  <?php
			 $sql_chid = "select * from virtual_list where vg_id ='$R[vg_id]' order by v_id ASC";
			  $query_chid = $db->query($sql_chid);
				while($R_chid = $db->db_fetch_array($query_chid)){
			  ?><tr onMouseOver="this.style.backgroundColor='#FF9933'" onMouseOut="this.style.backgroundColor='FFFFFF'"><td height="25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../theme/main_theme/arrow_r.gif" align="absmiddle">&nbsp;<?php echo $R_chid[v_name];?></td>
			  <td width="20%" align="center"><a href="#t" onClick="choose_id(<?php echo $R_chid[v_id];?>,'<?php echo $R_chid[v_name];?>');">คลิกที่นี่เพื่อเลือก</a></td>
			  </tr>
			  <?php  }
			  if($db->db_num_rows($query_chid)==0){
			  echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../theme/main_theme/arrow_r.gif" align="absmiddle">&nbsp;ไม่มีข้อมูล</td></tr>';
			  }
			   ?>
                </table></span>				</td>
			  </tr>
			  
	<?php } ?>
	<?php if($db->db_num_rows($query )==0){ ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center" ><strong>ไม่มีข้อมูล</strong></td>
			  </tr>
			  
	<?php } ?>
	<tr bgcolor="#FFFFFF">
			    <td ><strong><font color="#FF0000">หมายเหตุ สามารถคลิกที่หมวดเพื่อเลือกหมวดย่อยได้ คลิกที่เครื่องหมายบวกเพื่อเลือกรายการ</font></strong></td>
    </tr>
</table>
</form>
</body>
</html>
<script language="javascript1.2">
function show_datachid(gid,obj){
if(obj.src.search("plus.gif") != -1){ obj.src = "../images/minus.gif";}else { obj.src = "../images/plus.gif";}
							if(document.getElementById("G"+gid).style.display != "none") {
							document.getElementById("G"+gid).style.display = "none";
							}else{
							document.getElementById("G"+gid).style.display = "";
							}
}
function choose_id(id,name){
		window.opener.document.getElementById('virtual_id').value = id;
		window.opener.document.all.listid.innerHTML = name;
		//alert('เลือกเรียบร้อยแล้วค่ะ');
		window.close();
}
</script>
<?php
$db->db_close(); ?>