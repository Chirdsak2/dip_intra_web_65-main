<?php
include("authority.php");
?>
<?php 

$Sel = "select * from n_temp order by t_id desc";
//$r = $db->query($sel);
/***************** Start Seperate Page ****************/
 //    If $offset is set below zero (invalid) or empty, set to zero 
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = mysql_query($Sel);
$nof = mysql_num_fields($ExecSel); 
$totalrows = mysql_num_rows($ExecSel);
	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $Sel." LIMIT $offset, $limit ";
//echo $Show;
//exit();
$ExecShow = mysql_query($Show);
$db->write_log("view","enews","เข้าสู่ การจัดการจดหมายข่าว");
?>
<html>
<head>
<title>Newsletter Group Modify Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/enews_function.gif" width="32" height="32" align="absmiddle" border="0"> 
      <span class="ewtfunction">จดหมายข่าว</span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("จดหมายข่าว");?>&module=newsletter&url=<?php echo urlencode("temp_mod.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/temp_add.php?Flag=Add','TempAdd','height=550,width=600,resizable=1,scrollbars=1');"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มจดหมายข่าว </a>
      <hr>
    </td>
  </tr>
</table>
        <table width="90%" align="center" class="table table-bordered">
	
          <form name="form1" method="post" action="temp_function.php">
          <tr bgcolor="B2B4BF" class="ewttablehead"> 
		  <td width="5%" align="center">&nbsp;</td>
            <td> <?php echo $lang_temp_name; ?>            </td>
            <td width="5%" align="center"> <?php echo $lang_temp_delete; ?>            </td>
          </tr>
          <?php
		  if($totalrows != 0){
$i = 0;
while($R = mysql_fetch_array($ExecShow )){
?>
          <tr bgcolor="ECEBF0"> 
		  <td align="center" bgcolor="#FFFFFF"><nobr>
		  <a href="#" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/temp_preview.php?tid=<?php echo $R['t_name'];?>','TempPreview','height=550,width=600,resizable=1,scrollbars=1');"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" alt="เรียกดู"> </a>
      <a href="#" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/temp_add.php?tid=<?php echo $R['t_id'];?>&Flag=Edit','TempEdit','height=550,width=600,resizable=1,scrollbars=1');"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" alt="แก้ไข"></a>
	  <a href="#" onClick="window.open('temp_บันทึก.php?tid=<?php echo $R['t_name'];?>','TempSave','height=80,width=200,resizable=0,scrollbars=0');"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" alt="บันทึก Template As..."></a> </nobr></td>
            <td height="29" bgcolor="#FFFFFF">
              <?php echo $R['t_name'];?></td>
            
            <td align="center" bgcolor="#FFFFFF">
                <input type="checkbox" name="gid<?php echo $i;?>" value="<?php echo $R['t_id'];?>">
                <input name="tname<?php echo $i; ?>" type="hidden" id="tname<?php echo $i; ?>" value="<?php echo $R['t_name'];?>">            </td>
          </tr>
          <?php 
$i++;
}
}else{
?>
<tr bgcolor="#CC3300"> 
            <td height="29" colspan="3" align="center" bgcolor="#FFFFFF"><?php echo $lang_temp_noitem; ?></td>
          </tr>
<?php } ?>
<tr bgcolor="B2B4BF"> 
      <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF"> 
         <input type="hidden" name="all" value="<?php echo $i;?>">
         <input type="hidden" name="Flag" value="Delete">
         <input class="btn btn-danger btn-ml" type="submit" name="Submit" value="  <?php echo $lang_temp_delete; ?>  " <?php   if($totalrows==0){ echo "disabled"; }?> onClick="return confirm('<?php echo $lang_temp_confirm; ?>');">      </td>
</tr></form>
</table>
<?php   if($totalrows>0){ ?>
<br>
<table width="95%" border="0" cellspacing="0" cellpadding="3" bgcolor="ECEBF0" height="20" align="center">
  <tr> 
    <td width="8%" align="right"><?php echo $lang_page_num; ?></td>
    <td width="92%"> <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&limit=$limit&mname=".$mname."&email=$email'><font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><<</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($totalrows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($totalrows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">$i </font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&limit=$limit&mname=".$mname."&email=$email' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 
         
    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&limit=$limit&mname=".$mname."&email=$email'\>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\"\>>></font></a>\n"; 
    }
?></td>
  </tr>
</table>
<?php } ?>
</body>
</html>
