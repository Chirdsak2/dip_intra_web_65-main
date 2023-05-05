<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$text_status = "Search File & Folder.";
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
			function hlah(c){
				var d = document.form1.num.value;
				//	document.getElementById('ah'+d).removeAttribute("style");
				//	document.getElementById('ah'+c).style.backgroundColor = "#B2B4BF";
				//	document.form1.num.value = c;
			}
			function Editfile(c){
			
				if(self.parent.module_obj.document.formTodo.stype.value =="link"  && self.parent.module_obj.document.formTodo.Flag.value == "Link" ){
					sendfile(c);
				}else if(self.parent.module_obj.document.formTodo.Flag.value == "LinkReturn" ){
					 if(navigator.appName.indexOf('Microsoft')!=-1)
									 window.returnValue = "main.php?filename=" + c;
								else
									window.opener.setAssetValue("main.php?filename=" + c);
									
									self.close();
				}else{
					self.parent.window.opener.top.ewt_main.location.href="content_mgt.php?filename=" + c;
				top.close();
				}
			}
									function sendfile(c){
					self.top.module_obj.document.formTodo.objfile.value = "main.php?filename=" + c;
					self.top.module_obj.document.formTodo.target = "_top";
					self.top.module_obj.document.formTodo.action = "module_confirm.php";
					self.top.module_obj.document.formTodo.submit();
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
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <form name="formSearch" method="post" action="content_search.php"><tr>
    <td height="40" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<a href="<?php if($_SERVER["HTTP_REFERER"] != ""){ echo $_SERVER["HTTP_REFERER"]; }else{ echo "content_index.php"; } ?>" ><img src="../images/content_back.gif" width="24" height="24" border="0" align="absmiddle"> 
      Back</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/content_folder_search.gif" width="24" height="24" border="0" align="absmiddle"> 
      Search 
      
        <input name="c_search" type="text" id="c_search" value="<?php echo $_POST["c_search"]; ?>" size="30">
        <input type="submit" name="Submit" value="Search">
        <input name="Flag" type="hidden" id="Flag" value="Search"> </td>
  </tr></form>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
<tr>
    <td height="20" bgcolor="F9FAFD"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="60%" align="center">Name</td>
          <td width="1"><font color="#9D9EB7" size="2">|</font></td>
          <td align="center">Location</td>
        </tr>
      </table></td>
  </tr>
    <tr>
    <td height="1" bgcolor="B5B6C8"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td valign="top"> 
      <?php
	if($_POST["Flag"] == "Search"){
	$i = 0;
	$count_folder = 0;
   	$count_file = 0;
	?>
      <a id="divstart">
              <DIV id="divheight" align="center"  style="HEIGHT: 300;OVERFLOW-Y: scroll;WIDTH: 100%;margin-right:scroll; margin-left:scroll;position:relative;">
		  <table width="100%"  border="0" align="center" cellpadding="3" cellspacing="0">
		  <form name="form1" method="post" action="">
          <?php
  		$sql_folder = "SELECT * FROM temp_main_group WHERE Main_Group_Name LIKE '%".$_POST["c_search"]."%' ORDER BY Main_Position ASC";  
  $sql_group = $db->query($sql_folder);
  	while($R = $db->db_fetch_array($sql_group)){
	if($db->check_permission("Fo","w",$R[Main_Group_ID])){
  ?>
          <tr> 
            <td width="65%" height="30" bgcolor="F7F7F7" >&nbsp;&nbsp;<a id="ah<?php echo $i; ?>" onClick="hlah('<?php echo $i; ?>')" onDblClick="self.location.href='content_view.php?gid=<?php echo $R["Main_Group_ID"]; ?>';"><img src="../images/content_folder.gif" width="24" height="24" border="0" align="absmiddle"> <?php echo $R["Main_Group_Name"]; ?> 
              </a> </td>
            <td width="35%">&nbsp;</td>
          </tr>
          <?php
  $count_folder++;
   $i++; } }
  $sql_page = $db->query("SELECT temp_index.filename,temp_main_group.Main_Group_Name,temp_main_group.Main_Group_ID FROM temp_index INNER JOIN temp_main_group ON temp_index.Main_Group_ID = temp_main_group.Main_Group_ID WHERE temp_index.filename LIKE '%".$_POST["c_search"]."%' ORDER BY temp_index.filename ASC");
  	while($P = $db->db_fetch_row($sql_page)){
	if($db->check_permission("Fo","w",$P[2])){
  ?>
          <tr> 
            <td height="30" bgcolor="F7F7F7">&nbsp;&nbsp;<a id="ah<?php echo $i; ?>"  onClick="hlah('<?php echo $i; ?>')" onDblClick="Editfile('<?php echo $P[0]; ?>')"><img src="../images/content_page.gif" width="24" height="24" border="0" align="absmiddle"> <?php echo $P[0]; ?> </a> 
            </td>
            <td><?php echo $P[1]; ?></td>
          </tr>
          <?php
  $count_file++;
   $i++; }} ?>
            <tr> 
              <td  bgcolor="F7F7F7">&nbsp;</td>
              <td>&nbsp;</td>
          </tr>
     <input name="num" type="hidden" id="num" value="0">
  </form>
        </table>
<?php 
if($i == 0){
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr> 
            <td height="50" align="center"><font color="#FF0000">There are no 
              results for '<?php echo $_POST["c_search"]; ?>'</font></td>
  </tr>
</table>
<?php  }  ?>
</DIV>
<?php $text_status = "Found : ".$count_folder." Folder";
				if($count_folder >1){
				$text_status .= "s"; 
				} 
            	$text_status .= " and ".$count_file." file";
				if($count_file >1){
				$text_status .= "s"; 
				}
				$text_status .= "."; 
  ?>
<?php } ?>
</td>
  </tr>
</table>
<a id="divend">
<?php if($_POST["Flag"] == "Search" OR $i != 0){ ?>
<script language="javascript">
var hei = findPosY(document.all.divend) - findPosY(document.all.divstart);
document.all.divheight.style.height = hei;
</script>
<?php } ?>
<script language="JavaScript">
document.formSearch.c_search.focus();
parent.content_bottom.document.all.txt_status.innerHTML = "<?php echo $text_status; ?>";
</script>
</body>
</html>
<?php $db->db_close(); ?>