<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/rss_language.php");

if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
	session_register("EWT_OPEN_ARTICLE");
}
$_SESSION["EWT_OPEN_ARTICLE"] = "";

 $data = $_REQUEST['data'];
 if (!empty($data)) {
		$wh = " where rss_title like '%$data%'  OR  rss_url like '%$data%' ";
}

$sel = "SELECT * FROM rss $wh ORDER BY rss_id ASC";

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

	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
   function chkdel(maxs){
       var i;
       for(i=0;i<maxs;i++){  if(document.getElementById('chk'+i).checked) return true;    }
	   return false;
   }
</script>
</head>
<body leftmargin="0" topmargin="0">
<span id="formtext"></span>
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/rss_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_genrss_function1;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ("รายการ RSS ");?>&module=rss&url=<?php echo urlencode ("rss.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="rss_addedit.php" target="_self">&nbsp;<img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0">&nbsp;<?php echo $text_genrss_addnew;?></a>
      <hr>    </td>
  </tr>
</table>


   <table width="94%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
    <tr>
      <td valign="top"  class="MemberTitle">  
	           
				<table width="100%" border="0" cellspacing="1" cellpadding="3">
				 <form method="post" action="rss.php">
								<tr>
								  <td ><input type="hidden" name="curPage" value="1">
									ค้นหา RSS
									<input type="text" name="data" value="<?php echo $data;?>">
								  <input type="submit" name="Submit" value="ค้นหา"></td>
								</tr>
				</form>	
				</table>

				
				  <table width="100%"  border="0" cellpadding="5" cellspacing="1" bgcolor="#808080" align="center" class="ewttableuse">
				   <form name="form1" method="post" action="rss_function.php">
					<input type="hidden" name="Flag" value="DelGroup">
					<input type="hidden" name="cid" >
					<input type="hidden" name="rss_title" >
					<input type="hidden" name="rss_url" >
					<input type="hidden" name="rss_row" >
					<tr align="center" class="ewttablehead"> 
					  <td width="4%" height="18" ></td>
					  <td width="23%"  ><?php echo $text_genrss_column1;?></td>
					  <td width="47%"  ><?php echo $text_genrss_column2;?></td>
					  <td width="10%" ><?php echo $text_genrss_column3;?></td>
					  <td width="5%" ><?php echo $text_genrss_column4;?></td>
					</tr>
					<?php
					$i = 0;
					 while($G = $db->db_fetch_array($Execsql)){ ?>
					<tr bgcolor="#FFFFFF"> 
					  <td  align="center"><nobr><a href="#article" onClick="location.href='rss_addedit.php?cid=<?php echo $G["rss_id"]; ?>';"><img src="../theme/main_theme/g_edit.gif" alt="<?php echo $text_genrss_altedit;?>" width="16" height="16" border="0"  align="absmiddle"></a> 
						<a href="<?php echo $G["rss_url"]; ?>"  target="_blank"><img src="../theme/main_theme/g_rss.gif" alt="<?php echo $text_genrss_altview;?>" width="16" height="16" border="0"   align="absmiddle"></a></nobr></td>
					  <td height="25" valign="top" ><?php echo $G["rss_title"]; ?> </td>
					  <td  align="left"><a href="<?php echo $G["rss_url"]; ?>"  target="_blank"><?php echo $G["rss_url"]; ?></a></td>
					  <td align="center"> <?php echo $G["rss_row"]; ?></td>
					  <td width="5%" align="center"> <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="<?php echo $G["rss_id"]; ?>"> 
					  </td>
					</tr>
					<?php $i++; } ?>
					<tr bgcolor="#FFFFFF"> 
					  <td colspan="4" valign="top" >&nbsp;<a id="#bottom"></a></td>
					  <td width="5%" align="center">&nbsp; <input type="submit" value="<?php echo $text_genrss_altdel;?>" onClick="if(chkdel(<?php echo $i; ?>)){return confirm('<?php echo $text_genrss_confirm_del;?>');}else{confirm('<?php echo $text_genrss_confirm_chk;?>'); return false;};"></td>
					</tr>
					<input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
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
						</form>
				  </table>  
		     </td>
        </tr>
  </table> 

</body>
</html>
<?php $db->db_close(); ?>
