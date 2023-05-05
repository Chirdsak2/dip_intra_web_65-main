<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/menu_language.php");
if(!session_is_registered("EWT_MENU_POSITION")){
session_register("EWT_MENU_POSITION");
}
$_SESSION["EWT_MENU_POSITION"] = "";

 $data = $_REQUEST['data'];
 if (!empty($data)) {
			        $wh = " where m_name like '%$data%' ";
}

$sel = "SELECT m_id,m_name FROM menu_list $wh ORDER BY m_name ASC";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = $db->query($Show); 

$sql = " SELECT ml_menu_id,count(ml_id) as clog FROM menu_log GROUP BY ml_menu_id ";
$query = $db->query($sql); 
$arr_log=array();
while($rs=$db->db_fetch_array($query)){
		$index_log=$rs[ml_menu_id];
		$arr_log[$index_log]=$rs[clog];
}


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
			self.location.href = "menu_main.php?m_id=" + c;
		}
		function applymenu(c){
			if(confirm('Are you sure you want to apply this menu to WebBlock?')){
				self.location.href = "menu_apply.php?m_id=" + c;
			}
		}
		function delmenu(c){
			if(confirm('Are you sure you want to delete this menu ?')){
				self.location.href = "menu_apply.php?flag=del&m_id=" + c;
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
<form name="form1" method="post" action="menu_log.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/menu_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $text_menu_mlogname; ?></span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode('สถิติเมนู');?>&module=menu&url=<?php echo urlencode("menu_log.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>
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
								<input type="submit" name="Submit" value="ค้นหา" class="btn btn-success" />
								</td>
							</tr>
					</table>
					<br>
					<table width="100%" border="0" align="center" class="table table-bordered">
					  <tr bgcolor="#E6E6E6" class="ewttablehead"> 
						
							  <td width="90%"><strong><?php echo $text_menu_menuname; ?></strong></td>
							  <td width="10%" align="center"><?php echo $text_menu_count; ?></td>
							</tr>
							<?php
							if($db->db_num_rows($Execsql) > 0){
							while($R=$db->db_fetch_array($Execsql)){
							   //echo "SELECT COUNT(BID) FROM block WHERE block_type = 'menu' AND block_link = '".$R["m_id"]."'";
							   //$sql_count = $db->query("SELECT COUNT(BID) FROM block WHERE block_type = 'menu' AND block_link = '".$R["m_id"]."' ");
							   //$S = $db->db_fetch_row($sql_count);
							?>
							<tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'">
							
							  
						<td> <a href="menu_logsub.php?m_id=<?php echo $R["m_id"]; ?>"><?php echo $R["m_name"]; ?></a> 
						</td>
						<td align="center">
						<?php 
						$idx=$R["m_id"]; 
						echo number_format($arr_log[$idx],0) ;
						//$idx=$R["m_id"]*1; 
						//echo number_format($S[0],0);
						?></td> 
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
