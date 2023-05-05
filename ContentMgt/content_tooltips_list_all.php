<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("cms","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.close();
				</script>
				<?php
}
function chk_list($tips_id,$type_id){
global $db;
$sql = "select tips_main_id from tips_main where tips_main_type_id='".$type_id."' and tips_list_id='".$tips_id."'";
$query = $db->query($sql);
if($db->db_num_rows($query)>0){
return FALSE;
}else{
return TRUE;
}
}
	?>
<html>
<head>
<title>Page Properties [<?php echo $R[filename];?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function adddata(F,tips_id,filename){
var type = window.top.document.getElementById('type').value;
var filename = window.top.document.getElementById('filename').value;
	if(F == 'H'){
	self.location.href= "content_tooltips_list.php?type="+type+"&filename="+filename;
	}else if(F == 'SL'){
	self.location.href= "content_tooltips_function.php?type="+type+"&filename="+filename+"&flag=add_page2&tips_id="+tips_id+"&filename2="+filename;
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">Tool Tips</span> </td>
      </tr>
</table>
      <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
        <tr>
          <td align="right">
                <img src="../images/bar_home.gif" width="20" height="20" align="absmiddle"> <a href="##H"  onClick="adddata('H','','');">กลับหน้าหลัก </a>&nbsp;&nbsp;&nbsp;&nbsp;
              <hr>
          </td>
        </tr>
      </table>
	    <form name="form1" method="post" action="">
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="87%" colspan="2" ><table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewttableuse" style="border-collapse:collapse">
                  <tr>
                    <td>
                      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#B2B2B2" >
                <tr class="ewttablehead"> 
                  <td colspan="2">ค้นหา</td>
                </tr>
                <tr> 
                  <td width="28%" align="left" bgcolor="#FFFFFF"> <span class="head_font">Tool Tips</span> :</td>
                  <td width="72%" align="left" bgcolor="#FFFFFF"><input name="txt_title" type="text" size="50" value="<?php echo $_POST[txt_title];?>" /></td>
                </tr>
                <tr>
                  <td align="left" bgcolor="#FFFFFF">กลุ่ม</td>
                  <td width="72%" align="left" bgcolor="#FFFFFF">
				  <select name="group_id">
				  <option value="">--เลือกกลุ่ม--</option>
		  <?php
		  $sql_g = "select tips_group_id,tips_group_name from tips_group";
		  $query_g = $db->query($sql_g);
		  while($RG = $db->db_fetch_array($query_g)){
		  ?>
              <option value="<?php echo $RG[tips_group_id];?>" <?php if($RG[tips_group_id] ==$_POST[group_id] ){ echo 'selected';} ?> ><?php echo $RG[tips_group_name];?></option>
			  <?php  } ?>
          </select>
                  </td>
                </tr>
                <tr align="right"> 
                  <td colspan="2" bgcolor="#FFFFFF"> <input name="Submit" type="submit" value="ค้นหา"  > 
                    &nbsp; <input type="hidden" name="limit" value="20"> 
                    <input type="hidden" name="offset" value="0">
					<input type="hidden" name="hddflag" value="search"></td>
                </tr>
              </table></td>
                  </tr>
              </table></td>
    </tr>
  </table></form>
<table width="94%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
         <tr>
             <td valign="top"  class="MemberTitle">  
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse" >
					  <tr  bgcolor="#FFCC99" class="ewttablehead">
						<td width="58" height="25" align="center" class="head_font"></td>
						<td height="25" class="head_font">หัวข้อ Tool Tips </td>
						<td class="head_font">กลุ่ม</td>
					  </tr>
						<?php
						$wh = '';
						if($_POST[hddflag]=="search"){
							if($_POST[txt_title] != ''){
								$wh .= " and (tips_list_title like '%".$_POST[txt_title]."%' or tips_list_detail like '%".$_POST[txt_title]."%')";
							}
							if($_POST[group_id] != ''){
								$wh .= " and tips_list.tips_group_id = '".$_POST[group_id]."'";
							}
						}
						$sql = "select * from tips_main inner join tips_list on tips_main.tips_list_id = tips_list.tips_list_id  inner join tips_group on tips_group.tips_group_id = tips_list.tips_group_id where tips_main_type_id <> '".$_GET[filename]."' $wh GROUP BY tips_main.tips_list_id";
						$query = $db->query($sql);
						while($R = $db->db_fetch_array($query)){
						
						?>
							
					  <tr bgcolor="#FFFFFF" >
						<td width="58" align="left">
						<?php if(chk_list($R[tips_list_id],$_GET[filename]) == TRUE){?>
						<a href="#SL" onClick="adddata('SL','<?php echo $R[tips_list_id];?>','<?php echo $R[tips_main_type_id];?>');">เลือก</a>&nbsp;	 <?php } ?></td>
						<td width="426" valign="top" bgcolor="#FFFFFF" ><img src="../images/content_bg_line.gif" width="5" height="4" align="absmiddle">&nbsp;<?php echo $R[tips_list_title];?></td>
					    <td width="427" valign="top" bgcolor="#FFFFFF" ><?php echo $R[tips_group_name];?></td>
					  </tr>
							 
						<?php } ?>
					</table>
		   </td>
  </tr>
</table>
<table width="94%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
