<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/menu_language.php");/**/

/*if(!session_is_registered("EWT_MENU_POSITION")){
session_register("EWT_MENU_POSITION");
}*/

$_SESSION["EWT_MENU_POSITION"] = "";

 $data = $_REQUEST['data'];
 $wh = "";
 if (!empty($data)) {
			        $wh = " and m_name like '%$data%' ";
}


$sql_text = "";
$ptype = "menu";
$ppms = "w";
if($_SESSION["EWT_SMTYPE"] != "Y"){
	$ExecSel1 = $db->query("SELECT s_name FROM ".$EWT_DB_USER.".permission where p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."'
	AND s_type = '".$ptype."' AND s_permission = '".$ppms."' and s_name > 0");
	$rows1 = $db->db_num_rows($ExecSel1);
	if($rows1>0){
		$wh .= "and m_id in (SELECT s_name FROM ".$EWT_DB_USER.".permission where p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."'
		AND (s_type = '".$ptype."' AND s_permission = '".$ppms."'))"; 
	}
}


$sel = "SELECT m_id,m_name FROM menu_list where 1=1 $wh ORDER BY m_name ASC";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = $db->db_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = $db->query($Show); 

//$sql_menu = $db->query("SELECT m_id,m_name FROM menu_list ORDER BY m_name ASC ");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script language="JavaScript">
		function CHK(t){
			if(t.menu_name.value ==''){
			alert('กรุณาใส่ชื่อเมนู  !');
			return false;
			}
			return true;
		}
		function editmenu(c){
			location.href = "menu_main.php?m_id=" + c;
		}
		function applymenu(c){
			if(confirm('Are you sure you want to apply this menu to WebBlock?')){
				location.href = "menu_apply.php?m_id=" + c;
			}
		}
		function delmenu(c){
			if(confirm('Are you sure you want to delete this menu ?')){
				location.href = "menu_apply.php?flag=del&m_id=" + c;
			}
		}
		function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
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
		function txt_data(w,n) {
	
	var mytop = findPosY(document.getElementById("save"+w)) +document.getElementById("save"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("save"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='saveas_menu.php?m_id='+ w+'&m_name='+n;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}

	</script>
	<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="form1" method="post" action="menu_list.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/menu_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $text_menu_mname; ?></span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode('บริหารเมนู');?>&module=menu&url=<?php echo urlencode("menu_list.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>
	<?php if($_SESSION["EWT_SMTYPE"] == "Y"){ ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="menu_add.php"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      <?php echo $text_menu_menuadd; ?></a><?php } ?>
      <hr>
    </td>
  </tr>
</table>

   <table width="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
    <tr>
      <td valign="top"  class="MemberTitle">  
					<table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" >
							<tr>
								<td >
								<input type="hidden" name="curPage" value="1"> ค้นหาเมนู
								<input type="text" name="data" value="<?php echo $data;?>" class="form-control" style="width:30%;" />
								<input type="submit" name="Submit" value="ค้นหา" class="btn btn-success">
								</td>
							</tr>
					</table>
					<br>
					<table width="100%" border="0" align="center" class="table table-bordered">
					  <tr bgcolor="#E6E6E6" class="ewttablehead"> 
						<td width="5%" align="center">&nbsp;</td>
							  <td width="95%"><strong><?php echo $text_menu_menuname; ?></strong></td>
							</tr>
							<?php
							if($db->db_num_rows($Execsql) > 0){
							while($R=$db->db_fetch_array($Execsql)){
							$sql_count = $db->query("SELECT COUNT(BID) FROM block WHERE block_type = 'menu' AND block_link = '".$R["m_id"]."' ");
							  $S = $db->db_fetch_row($sql_count);
							?>
							<tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'">
							<td align="center"><nobr><a href="#view" onClick="window.open('menu_preview.php?m_id=<?php echo $R["m_id"]; ?>','viewmenu','height=500,width=600,scrollbars=1,resizable=1');"><img src="../theme/main_theme/g_view.gif" alt="<?php echo $text_menu_view; ?>" width="16" height="16" border="0" align="absmiddle"></a> 
							
							<a href="#edit" onClick="editmenu('<?php echo $R["m_id"]; ?>')"><img src="../theme/main_theme/g_edit.gif" alt="<?php echo $text_menu_edit; ?>" width="16" height="16" border="0" align="absmiddle"></a> 
							
							<?php /*
							<a href="#apply" onClick="applymenu('<?php echo $R["m_id"]; ?>')"><img src="../theme/main_theme/g_apply.gif" alt="<?php echo $text_menu_apply; ?>" width="16" height="16" border="0" align="absmiddle"></a> 
							*/ ?>
							<?php if($_SESSION["EWT_SMTYPE"] == "Y"){ ?>
							<?php if($S[0] > 0){ ?> <img src="../theme/main_theme/g_not_allow.png" alt="<?php echo $text_menu_notdelete; ?>" width="16" height="16" border="0" align="absmiddle"><?php }else{ ?> <a href="#del" onClick="delmenu('<?php echo $R["m_id"]; ?>')"><img src="../theme/main_theme/g_garbage.png" alt="<?php echo $text_menu_delete; ?>" width="16" height="16" border="0" align="absmiddle"></a>
						  <?php } ?>
						  <a href="##" onClick="txt_data('<?php echo $R["m_id"]; ?>','<?php echo $R["m_name"]; ?>')"><img id="save<?php echo $R["m_id"]; ?>" src="../theme/main_theme/g_saveas.gif" alt="Save AS" width="16" height="16" border="0" align="absmiddle" ></a></nobr></td> 
						  <?php } ?> 
						<td> <a href="#view" onClick="window.open('menu_preview.php?m_id=<?php echo $R["m_id"]; ?>','viewmenu','height=500,width=600,scrollbars=1,resizable=1');"><?php echo $R["m_name"]; ?></a> 
						</td>
							</tr>
							<?php
							}
							}
							?>
							<?php if($rows > 0){ ?>
												<tr bgcolor="#FFFFFF"> 
												  <td height="25" colspan="15" valign="top"><?php echo $text_general_page;?> :
													<?php
														// Begin Prev/Next Links 
														// Don't display PREV link if on first page 
														if ($offset !=0) {   
														$prevoffset=$offset-$limit; 
														echo   "<a href='$PHP_SELF?offset=$prevoffset&data=$data'>
														<font  color=\"red\">$text_general_previous</font></a>\n\n";
														}
														$pages = intval($rows/$limit); 
														if ($rows%$limit) { 
																$pages++; 
														} 
														for ($i=1;$i<=$pages;$i++) { 
															if (($offset/$limit) == ($i-1)) { 
																	echo "<b>[ $i ] </b>"; 
															} else { 
																	$newoffset=$limit * ($i-1); 
																	echo  "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\"". 
																	"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
															} 
														} 
														if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
																$newoffset=$offset+$limit; 
																echo   "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\">
																<font color=\"red\">$text_general_next</font></a>"; 
														}
														?>
												  </td>
												</tr>
												<?php }else{?>
												<tr bgcolor="#FFFFFF"> 
												  <td height="30" colspan="15"  align="center"><font color="#FF0000"><?php echo $text_general_notfound;?></font></td>
												</tr>
												<?php }?>
						  </table>
				 </td>
			</tr>
	  </table> 
</form>
</body>
</html>
<?php
$db->db_close(); ?>
