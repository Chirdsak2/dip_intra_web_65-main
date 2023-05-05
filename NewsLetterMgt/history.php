<?php
include("authority.php");
?>
<?php 
$db->write_log("view","enews","ดูรายงานการส่งจดหมายข่าว  ");
$Sel = "select * from n_history order by h_id desc";
//$r = $db->query($sel);
/***************** Start Seperate Page ****************/
 //    If $offset is set below zero (invalid) or empty, set to zero 
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 40;
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
      <span class="ewtfunction">ข้อมูลการส่ง </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ข้อมูลการส่ง");?>&module=newsletter&url=<?php echo urlencode("history.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <hr>
    </td>
  </tr>
</table>
        
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <form name="form1" method="post" action="temp_function.php">
    <tr bgcolor="B2B4BF" class="ewttablehead"> 
      <td align="center"> Subject</td>
      <td align="center">ผู้ส่ง</td>
      <td align="center">วันที่</td>
      <td align="center"> เวลา</td>
      <td align="center">จำนวนผู้รับ</td>
    </tr>
    <?php
		  if($totalrows != 0){
$i = 0;
while($R = mysql_fetch_array($ExecShow )){
?>
    <tr bgcolor="ECEBF0"> 
      <td width="33%" height="29" align="center" bgcolor="#FFFFFF">
        <a href="#" onClick="open('mail_body.php?hid=<?php echo $R['h_id']?>','','height=300, width=500, scrollBars=1');"><?php echo $R['h_subject'];?></a></td>
      <td width="30%" height="29" align="center" bgcolor="#FFFFFF"> <?php echo $R['h_from_n'];?><br>
      &lt;<?php echo $R['h_from_e'];?>&gt;</td>
      <td width="14%" height="29" align="center" bgcolor="#FFFFFF"><?php echo $R['h_date'];?></td>
      <td width="12%" height="29" align="center" bgcolor="#FFFFFF"><?php echo $R['h_time'];?></td>
	  <?php
	  $sql = $db->query("SELECT COUNT(s_id) FROM n_send WHERE h_id = '$R[h_id]'");
	  $C = mysql_fetch_row($sql);
	  ?>
      <td width="11%" height="29" align="center" bgcolor="#FFFFFF"><a href="#" onClick="open('mail_body.php?nid=<?php echo $R['h_id']?>','','height=300, width=500 , scrollBars=yes');"><?php echo $C[0];?></a></td>
    </tr>
    <?php 
$i++;
}
}else{
?>
    <tr bgcolor="#CC3300"> 
      <td height="29" colspan="5" align="center" bgcolor="#FFFFFF"><?php echo $lang_temp_noitem; ?></td>
    </tr>
    <?php } ?>
  </form>
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
?> </td>
  </tr>
</table>
<?php } ?>
</body>
</html>
