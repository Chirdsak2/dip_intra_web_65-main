<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/guest_language.php");

$sql = "SELECT * FROM guest_cate";
$query = $db->query($sql);
$rows = $db->db_num_rows($query);
//$rec = $db->db_fetch_array($query);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div align="center">
<form name="form1" method="post" action="" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/guest_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_genguest_function1;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genguest_function1);?>&module=guestbook&url=<?php echo urlencode("guest_group.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <a href="guest_gadd.php?flag=add"> 
	  <img src="../theme/main_theme/g_edit.gif" width="16" height="16" align="absmiddle" border="0">เพิ่มหัวข้อ</a>
	  
	  <hr>
    </td>
  </tr>
</table>
  <table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="94%" height="100%" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font">
          <tr> 
            <td colspan="2" valign="top"> <DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"> 
                <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B74900"  class="ewttableuse">
								  <tr align="center" class="ewttablehead"> 
										<td width="10%" ></td>
										<td align="left" >หัวข้อ</td>
								  </tr>
					<?php
							
						  if($rows > 0){
								   while($rec = $db->db_fetch_array($query)){ 
											/*$count = $db->query("SELECT * FROM guestbook_list WHERE id_guest = '$rec[id_guest]' ");
											$countrow = mysql_num_rows($count);
											$date_print = chg_date_th($rec['date_guest']);*/
				?>
								  <tr bgcolor="#FFFFFF" > 
										<td align="center"  >
										<a href="guest_gadd.php?gc_id=<?php echo $rec['gc_id']?>&flag=edit"><img src="../theme/main_theme/g_edit.gif" border="0" alt="<?php echo $text_genguest_altedit?>"></a>
										<img src="../theme/main_theme/g_del.gif" onClick=" if(confirm('<?php echo $text_genguest_confirm_del?>')){window.location.assign('guest_gadd.php?gc_id=<?php echo $rec['gc_id']?>&flag=del');}" style="cursor:hand" alt="<?php echo $text_genguest_altdel?>">										</td>
										<td align="left"  ><?php echo $rec["gc_name"]; ?></td>
   					</tr>
	
					<?php		
								}
							 }else{ 
					?>
								  <tr bgcolor="#FFFFFF"> 
										<td  align="center" colspan="2"><font color="#FF0000"><strong><?php echo $text_genguest_notfound;?></strong></font></td>
								  </tr>
					  <?php } 
				   /* if($rows > 0){ ?>
						<tr bgcolor="#FFFFFF">
								<td height="25" colspan="2" valign="top"><?php echo $text_genguest_page;?> :     <?php
								// Begin Prev/Next Links 
								// Don't display PREV link if on first page 
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?offset=$prevoffset'>
								<font  color=\"red\">$text_genguest_pre</font></a>\n\n";
								}
								$pages = intval($rows/$limit); 
								if ($rows%$limit) { 
										$pages++; 
								} 
								for ($i=1;$i<=$pages;$i++) { 
									if (($offset/$limit) == ($i-1)) { 
											echo "<font  color=\"blue\">[ $i ] </font>"; 
									} else { 
											$newoffset=$limit * ($i-1); 
											echo  "<a href='$PHP_SELF?offset=$newoffset' ". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href='$PHP_SELF?offset=$newoffset'>
										<font color=\"red\">$text_genguest_next</font></a>"; 
								}
								?></td>
						</tr>
					<?php }*/ ?>
                </table>
                <br>
            </DIV></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
  </form>
</div>
</body>
</html>
<script language="JavaScript">
function CHK(){
	if(document.form1.gc_name.value == ""){
		alert("กรุณาใส่หัวข้อ");
		document.form1.gc_name.focus();
		return false;
	}
	return true;
}
</script>
<?php $db->db_close(); ?>
