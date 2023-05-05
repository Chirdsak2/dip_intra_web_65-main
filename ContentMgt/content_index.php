<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

		$_SESSION["EWT_OPEN_FOLDER"] = "";

	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
				function hlah(c,cc,e,f){
				var d = document.form1.num.value;
				document.Removeform.r_id.value = cc;
				document.Removeform.r_name.value = e;
				document.Removeform.r_type.value = f;
				document.all.r_img.src = "../images/content_delete.gif";
				document.all.s_img.src = "../images/security_set.gif";
					document.getElementById('ah'+d).removeAttribute("style");
					document.getElementById('ah'+c).style.backgroundColor = "#D5D6DB";
					document.form1.num.value = c;

			}
			function create_folder(){
				document.all.new_fo.style.display = '';
				document.all.tbemp.style.display = 'none';
				document.form1.new_folder.focus();
			}
			function create_fo(c){
				if(c.value == ""){
					document.all.new_fo.style.display = 'none';
					document.all.tbemp.style.display = '';
				}else if (c.value.search("^[A-Za-z0-9_]+$")){
					alert("Folder name is limited to English character  (upper and lower case), number, and underscore only!");
					c.select();
				}else{
					var gname = c.value;
					/*document.write("<form name=\"createform\" method=\"post\" action=\"content_function.php\">");
					document.write("<input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateSubFolder\">");
					document.write("<input name=\"gname\" type=\"hidden\" id=\"gname\" value=\"");
					document.write(gname);
					document.write("\">");
					document.write("<br><br><br><br><br><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div>");
					document.write("</form>"); */

										document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"content_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateSubFolder\"><input name=\"gname\" type=\"hidden\" id=\"gname\" value=\""+ gname + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";

					createform.submit();


				}
			}
			function del_file(){
				if(document.Removeform.r_name.value == "" || document.Removeform.r_type.value == ""){
					alert("Please selected file or folder to delete!!!");
					return false;
				}else{
					if(document.Removeform.r_type.value =="Fo"){
					 c  = "Are you sure you want to remove the folder \"" + document.Removeform.r_name.value + "\" and move all its conents?";
					 }else if(document.Removeform.r_type.value =="Fi"){
					c  = "Are you sure you want to delete \"" + document.Removeform.r_name.value + "\" ?";
					}
					var r = confirm(c);
					if(r == true){
						Removeform.submit();
					}else{
						return false;
					}
				}
			
			}
			function setting_file(){
				if(document.Removeform.r_name.value == "" || document.Removeform.r_type.value == ""){
					alert("Please selected file or folder to setting!!!");
					return false;
				}else{
				
					win4=window.open('setting_member.php?s_type=' + document.Removeform.r_type.value + '&s_id=' + document.Removeform.r_id.value + '&s_name=' + document.Removeform.r_name.value + '','secure','width=500,height=500,scrollbars=1,resizable=1');
					win4.focus();
				}
			}
			function chkKeyFo(c){
			 		if(event.keyCode == 13){
						create_fo(c);
					}
			 }
			 			function findPosY(obj)
				{
				 var curtop = 0;
				 if (document.getElementById || document.all)
				 {
				  while (obj.offsetParent)
				  {
				   curtop += obj.offsetTop
				   obj = obj.offsetParent;
				  }
				 }
				 else if (document.layers)
				  curtop += obj.y;
				 return curtop;
				}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<span id="formtext"></span>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="40" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<img src="../images/content_folder_up_off.gif" width="24" height="24" border="0" align="absmiddle"> 
      <font color="#999999">Up</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/content_home_off.gif" width="24" height="24" border="0" align="absmiddle"> 
      <font color="#999999">Home</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="content_search.php"><img src="../images/content_folder_search.gif" width="24" height="24" border="0" align="absmiddle"> 
      Search</a></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td height="<?php if($db->check_permission("cms","w","")){ echo "40"; }else{ echo "1"; } ?>" bgcolor="F3F3EE"><span <?php if(!$db->check_permission("cms","w","")){ echo "style=\"display:none\""; } ?>>&nbsp;&nbsp;&nbsp;<a href="#new" onClick="create_folder();"><img src="../images/content_new_folder.gif" width="24" height="24" border="0" align="absmiddle"> 
      New Folder</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/content_document_new_off.gif" width="24" height="24" border="0" align="absmiddle"> 
      <font color="#999999">New Page</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#del" onClick="del_file();"><img src="../images/content_delete_off.gif" name="r_img" width="24" height="24" border="0" align="absmiddle" id="r_img"> 
      Delete</a> <span style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#security" onClick="setting_file();"><img src="../images/security_set_off.gif" name="s_img" width="24" height="24" border="0" align="absmiddle" id="s_img"> 
      Security</a></span></span></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <form name="Removeform" method="post" action="content_function.php"><input name="direct" type="hidden" id="direct" value="content_index.php"> 
              <input name="r_id" type="hidden" id="r_id">
              	<input name="r_name" type="hidden" id="r_name">
              	<input name="r_type" type="hidden" id="r_type">
              	<input name="Flag" type="hidden" value="Remove">
  <tr> 
    <td height="20" bgcolor="F3F3EE"><table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="10%" nowrap>Address : </td>
          <td width="90%"><table width="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="66667E">
              <tr>
                <td bgcolor="#FFFFFF"><img src="../images/workplace.gif" width="20" height="20" border="0" align="absmiddle"> My Website</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  </form>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <?php
  	if($EWT_DB_TYPE == "MYSQL"){
		$sql_folder = "SELECT * FROM temp_main_group WHERE length(Main_Position) = '9' ORDER BY Main_Position ASC";
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql_folder = "SELECT * FROM temp_main_group WHERE len(Main_Position) = '9' ORDER BY Main_Position ASC";
	}
  
  $sql_group = $db->query($sql_folder);
  $i = 0;
  $select_num = 0;
  ?>
    <form name="form1" method="post" action="">
  <tr>
    <td valign="top"><a id="divstart">
	<DIV id="divheight" align="center"  style="HEIGHT: 300;OVERFLOW-Y: scroll;WIDTH: 100%;margin-right:scroll; margin-left:scroll;position:relative;"><br>

	<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" >
  <?php
  $count_folder =0;
  	while($R = $db->db_fetch_array($sql_group)){
if($db->check_permission("Fo","w",$R[Main_Group_ID])){
		if($i%4 == 0){
			echo "<tr bgcolor=\"#FFFFFF\"  align=center height=\"55\">";
		}
  ?>
         
         <td width="25%" align="center" id="ah<?php echo $i; ?>" onClick="hlah('<?php echo $i; ?>','<?php echo $R["Main_Group_ID"]; ?>','<?php echo $R["Main_Group_Name"]; ?>','Fo')" onDblClick="self.location.href='content_view.php?gid=<?php echo $R["Main_Group_ID"]; ?>';" <?php if($_GET["select"] == "Fo".$R["Main_Group_ID"]){ echo "style=\"background-Color:#EEEEEE\""; } $select_num = $i; ?>><img src="../images/content_folder.gif" width="24" height="24" border="0" align="absmiddle"><div ><?php echo $R["Main_Group_Name"]; ?></div> 
              </td>
  <?php
    $count_folder++;
  		if($i%4 == 3){
			echo "</tr>";
		}
   $i++; }} ?>
 <?php 
 			  if($i%4 == 0){
				echo "<tr align=center height=\"55\"><td width=25% >
				<span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				</td>
				<td width=25%></td><td width=25%></td><td width=25%></td></tr>";
			}elseif($i%4 == 1){
				echo "<td width=25% align=center><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				<td width=25% ></td><td width=25%></td></tr>";
			}elseif($i%4 == 2){
				echo "<td width=25% align=center ><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				<td width=25% </td></tr>";
			}elseif($i%4 == 3){
				echo "<td width=25% align=center ><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				</td></tr>";
			}
  ?>
</table>
<?php 
if($i == 0){
?>
<table id="tbemp" width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr> 
              <td height="50" align="center">This folder is empty.</td>
  </tr>
</table>
<?php
  }else{
?>
<table id="tbemp" width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
              <td height="1" align="center"></td>
  </tr>
</table>
<?php
}
  ?>
</DIV>
</td>
  </tr>
    <input name="num" type="hidden" id="num" value="<?php echo $select_num; ?>">
  </form>
  <?php $text_status = "My Website : ".$count_folder." Folder";
				if($count_folder >1){
				$text_status .= "s"; 
				} 
				$text_status .= "."; 
  ?>
</table>
<a id="divend">
<script language="javascript">
var hei = findPosY(document.all.divend) - findPosY(document.all.divstart);
document.all.divheight.style.height = hei;
</script>
</body>
</html>
<?php $db->db_close(); ?>