<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

		if(!(session_is_registered("EWT_OPEN_FOLDER"))){
			session_register("EWT_OPEN_FOLDER");
		}
		$_SESSION["EWT_OPEN_FOLDER"] = $_GET["gid"];

function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}


$group = "SELECT * FROM temp_main_group WHERE Main_Group_ID = '".$_GET["gid"]."'";
$sql_group= $db->query($group);
$G = $db->db_fetch_array($sql_group);

$sql_select_left = $db->query("SELECT COUNT(*) FROM temp_main_group WHERE Main_Position <= (SELECT Main_Position FROM temp_main_group WHERE Main_Group_ID = '".$_GET["gid"]."')");
$CTL = $db->db_fetch_row($sql_select_left);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>

			function hlah(c,cc,e,f){
				var d = document.form1.num.value;
				document.Removeform.r_id.value = cc;
				document.Removeform.r_name.value = e;
				document.Removeform.r_type.value = f;
				document.all.r_img.src = "../images/content_delete.gif"
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
					document.write("<input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateFolder\">");
					document.write("<input name=\"gid\" type=\"hidden\" id=\"gid\" value=\"<?php echo $_GET["gid"]; ?>\">");
					document.write("<input name=\"gname\" type=\"hidden\" id=\"gname\" value=\"");
					document.write(gname);
					document.write("\">");
					document.write("<br><br><br><br><br><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div>");
					document.write("</form>"); */
					document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"content_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateFolder\"><input name=\"gid\" type=\"hidden\" id=\"gid\" value=\"<?php echo $_GET["gid"]; ?>\"><input name=\"gname\" type=\"hidden\" id=\"gname\" value=\""+ gname + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
					createform.submit();

				}
			}
			function create_file(){
				document.all.new_fi.style.display = '';
				document.all.tbemp.style.display = 'none';
				document.form1.new_file.focus();
			}
						function create_fi(c){
				if(c.value == ""){
					document.all.new_fi.style.display = 'none';
					document.all.tbemp.style.display = '';
				}else if (c.value.search("^[A-Za-z0-9_]+$")){
					alert("File name is limited to English character  (upper and lower case), number, and underscore only!");
					c.select();
				}else{
					var fname = c.value;
					/* document.write("<form name=\"createform\" method=\"post\" action=\"content_function.php\">");
					document.write("<input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateFile\">");
					document.write("<input name=\"gid\" type=\"hidden\" id=\"gid\" value=\"<?php echo $_GET["gid"]; ?>\">");
					document.write("<input name=\"fname\" type=\"hidden\" id=\"fname\" value=\"");
					document.write(fname);
					document.write("\">");
					document.write("<br><br><br><br><br><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div>");
					document.write("</form>"); */
					document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"createform\" method=\"post\" action=\"content_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"CreateFile\"><input name=\"gid\" type=\"hidden\" id=\"gid\" value=\"<?php echo $_GET["gid"]; ?>\"><input name=\"fname\" type=\"hidden\" id=\"fname\" value=\"" + fname + "\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
					createform.submit();

				}
			}
			function Editfile(c){
				self.top.window.opener.top.ewt_main.location.href="content_mgt.php?filename=" + c;
				top.close();
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
			 function chkKeyFo(c){
			 		if(event.keyCode == 13){
						create_fo(c);
					}
			 }
			 function chkKeyFi(c){
			 		if(event.keyCode == 13){
						create_fi(c);
					}
			 }
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<span id="formtext"></span>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <?php
  if(strlen($G["Main_Position"]) == 9){
  				$up_link = "website_index.php";
				$up_title = "My Website";
  }else{
  		$up = substr($G["Main_Position"], 0, -5);
		$sql_up = $db->query("SELECT * FROM temp_main_group WHERE Main_Position = '".$up."'");
		$U = $db->db_fetch_array($sql_up);
		  		$up_link = "website_view.php?gid=".$U["Main_Group_ID"];
				$up_title = $U["Main_Group_Name"];	
  }
  ?>
  <tr>
    <td height="40" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<a href="<?php echo $up_link; ?>" title="<?php echo $up_title; ?>"><img src="../images/content_folder_up.gif" width="24" height="24" border="0" align="absmiddle"> 
      Up</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="website_index.php"><img src="../images/content_home.gif" width="24" height="24" border="0" align="absmiddle"> 
      Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="website_search.php"><img src="../images/content_folder_search.gif" width="24" height="24" border="0" align="absmiddle"> 
      Search</a></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
    <tr>
    <td height="40" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<a href="#new" onClick="create_folder();"><img src="../images/content_new_folder.gif" width="24" height="24" border="0" align="absmiddle"> 
      New Folder</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#new" onClick="create_file();"><img src="../images/content_document_new.gif" width="24" height="24" border="0" align="absmiddle"> 
      New Page</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#del" onClick="del_file();"><img src="../images/content_delete_off.gif" name="r_img" width="24" height="24" border="0" align="absmiddle" id="r_img"> 
      Delete</a></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr><form name="Removeform" method="post" action="content_function.php"><input name="direct" type="hidden" id="direct" value="website_view.php?gid=<?php echo $_GET["gid"]; ?>"> 
              <input name="r_id" type="hidden" id="r_id">
              	<input name="r_name" type="hidden" id="r_name">
              	<input name="r_type" type="hidden" id="r_type">
              	<input name="Flag" type="hidden" value="Remove">
  <tr> 
    <td height="20" bgcolor="F3F3EE"><table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td width="10%" nowrap>Address :
              </td>
          <td width="90%"><table width="90%" border="0" cellpadding="2" cellspacing="1" bgcolor="66667E">
              <tr>
                <td bgcolor="#FFFFFF"><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> 
                  <?php echo $G["Main_Group_Name"]; ?></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr></form>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <?php
  $count_folder = 0;
  $count_file = 0;
  $num = strlen($G["Main_Position"]);
  $num_len = $num + 5;
  	if($EWT_DB_TYPE == "MYSQL"){
		$sql_folder = "SELECT * FROM temp_main_group WHERE Main_Position LIKE '".$G["Main_Position"]."_%' AND length(Main_Position) = '$num_len' ORDER BY Main_Position ASC";
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql_folder = "SELECT * FROM temp_main_group WHERE Main_Position LIKE '".$G["Main_Position"]."_%' AND len(Main_Position) = '$num_len' ORDER BY Main_Position ASC";
	}
  
  $sql_group = $db->query($sql_folder);
  $i=0;
  $select_num = 0;
  ?>
  <form name="form1" method="post" action="">
  <tr>
    <td valign="top">
	<DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: scroll;WIDTH: 100%"><br>
          <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" >
  <?php
  	while($R = $db->db_fetch_array($sql_group)){
		if($i%4 == 0){
			echo "<tr bgcolor=\"#FFFFFF\"  align=center height=\"55\">";
		}
  ?>
         
         <td width="25%"  align="center" id="ah<?php echo $i; ?>" onClick="hlah('<?php echo $i; ?>','<?php echo $R["Main_Group_ID"]; ?>','<?php echo $R["Main_Group_Name"]; ?>','Fo')" onDblClick="self.location.href='website_view.php?gid=<?php echo $R["Main_Group_ID"]; ?>';" <?php if($_GET["select"] == "Fo".$R["Main_Group_ID"]){ echo "style=\"background-Color:#EEEEEE\""; } $select_num = $i; ?>><img src="../images/content_folder.gif" width="24" height="24" border="0" align="absmiddle"><div ><?php echo $R["Main_Group_Name"]; ?></div> 
            </a> </td>
  <?php
  $count_folder++;
  		if($i%4 == 3){
			echo "</tr>";
		}
   $i++; } ?>
    <?php
  $sql_page = $db->query("SELECT * FROM temp_index WHERE Main_Group_ID = '".$G[Main_Group_ID]."' ORDER BY filename ASC");
  	while($P = $db->db_fetch_array($sql_page)){
			if($i%4 == 0){
				echo "<tr bgcolor=\"#FFFFFF\"  align=center height=\"55\">";
			}
  ?>
            <td width="25%" align="center"  id="ah<?php echo $i; ?>"  onClick="hlah('<?php echo $i; ?>','','<?php echo $P["filename"]; ?>','Fi')" onDblClick="Editfile('<?php echo $P["filename"]; ?>')"><img src="../images/content_page.gif" width="24" height="24" border="0" align="absmiddle"><div><?php echo $P["filename"]; ?></div>
            </td>
  <?php 
  $count_file++;
    		if($i%4 == 3){
				echo "</tr>";
			}
  $i++; } ?>
  <?php 
 			  if($i%4 == 0){
				echo "<tr align=center height=\"55\"><td width=25% >
				<span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				<span  id=\"new_fi\" style=\"display:none\"><img src=\"../images/content_page.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_file\" type=\"text\" id=\"new_file\" size=\"6\" onBlur=\"create_fi(this)\" onKeyDown=\"chkKeyFi(this)\"></div></span>
				</td>
				<td width=25%></td><td width=25%></td><td width=25%></td></tr>";
			}elseif($i%4 == 1){
				echo "<td width=25% align=center><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\"  onKeyDown=\"chkKeyFo(this)\"></div></span>
				<span  id=\"new_fi\" style=\"display:none\"><img src=\"../images/content_page.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_file\" type=\"text\" id=\"new_file\" size=\"6\" onBlur=\"create_fi(this)\" onKeyDown=\"chkKeyFi(this)\"></div></span></td>
				<td width=25% ></td><td width=25%></td></tr>";
			}elseif($i%4 == 2){
				echo "<td width=25% align=center ><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				<span  id=\"new_fi\" style=\"display:none\"><img src=\"../images/content_page.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_file\" type=\"text\" id=\"new_file\" size=\"6\" onBlur=\"create_fi(this)\" onKeyDown=\"chkKeyFi(this)\"></div></span></td>
				<td width=25% </td></tr>";
			}elseif($i%4 == 3){
				echo "<td width=25% align=center ><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
				<span  id=\"new_fi\" style=\"display:none\"><img src=\"../images/content_page.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_file\" type=\"text\" id=\"new_file\" size=\"6\" onBlur=\"create_fi(this)\" onKeyDown=\"chkKeyFi(this)\"></div></span></td></tr>";
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
</table>

<?php $text_status = $G["Main_Group_Name"]." : ".$count_folder." Folder";
				if($count_folder >1){
				$text_status .= "s"; 
				} 
            	$text_status .= " and ".$count_file." file";
				if($count_file >1){
				$text_status .= "s"; 
				}
				$text_status .= "."; 
  ?>
<script language="JavaScript">
						<!--//
							
							function auto_select(){
							var n = top.website_bar.document.form1.num.value;
							top.website_left.document.getElementById('ah'+n).removeAttribute("style");
							top.website_left.document.getElementById('ah<?php echo $CTL[0]; ?>').style.backgroundColor = "#B2B4BF";
							top.website_bar.document.form1.num.value = "<?php echo $CTL[0]; ?>";
							}
							setTimeout("auto_select()",500);
							//-->
</script>
</body>
</html>
<?php $db->db_close(); ?>
