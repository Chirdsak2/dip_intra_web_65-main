<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language.php");
$limit =20;
   if (empty($_REQUEST["offset"]) || $_REQUEST["offset"] < 0) { 
        $offset=0; 
    } else{
	$offset=$_REQUEST["offset"]; 
	}
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
	if($_REQUEST["Flag"] == "View"){
	$start_date = $_REQUEST["start_date"];
	$end_date = $_REQUEST["end_date"];
	if($start_date == "" AND $end_date == ""){
	$con = "";
	}elseif($start_date != "" AND $end_date == ""){
	$st = explode("/",$start_date);
	$con = " WHERE (faq_stat_dateate = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	}elseif($start_date == "" AND $end_date != ""){
	$st = explode("/",$end_date);
	$con = " WHERE (faq_stat_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	}else{
	$st = explode("/",$start_date);
	$en = explode("/",$end_date);
	$con = " WHERE (faq_stat_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
	}
	}
$db->write_log("view","faq","ดูรายงาน สถิติ FAQ");
$Show = " LIMIT $offset, $limit ";
 $sql_all="SELECT  faq.fa_id,  count(faq_stat.fa_id) AS sum_fa_id,  faq.fa_name FROM  faq  LEFT JOIN faq_stat ON (faq.fa_id = faq_stat.fa_id) $con
GROUP BY  faq.fa_id,  faq.fa_name ORDER BY sum_fa_id DESC ";
 $sql= $sql_all.$Show;
$Execsql = $db->query($sql);
$Execsql_all = $db->query($sql_all);
 $row = mysql_num_rows($Execsql_all); 

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar-th.js"></script>
<link href="../StatMgt/lib_carendar/style_calendar.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="246" colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
 <form name="form1" method="post" action=""> <tr>
      <td><img src="../images/column-chart.gif" width="24" height="24" border="0" align="left"> 
        <?php echo $text_genfaq_stat;?> <font size="2"><?php echo $text_genfaq_statbegin;?>
        <input type="text" name="start_date" size="15" value="<?php print  $start_date; ?>">
      <img src="../images/calendar.gif" alt="<?php echo $text_general_catendar_open;?>" width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('start_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      <?php echo $text_genfaq_statto ;?></font> 
      <input type="text" name="end_date" size="15" value="<?php print  $end_date;  ?>">
      <img src="../images/calendar.gif" alt="<?php echo $text_general_catendar_open;?>" width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('end_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      
      
        <input type="submit" name="Submit" value="<?php echo $text_general_View ;?>">
        <input name="Flag" type="hidden" id="Flag" value="View"></td>
  </tr> </form>
  <tr height="4">
    <td height="4" bgcolor="#000066"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td align="right">&nbsp;</td>
  </tr>
  <tr> 
    <td width="47%" align="center"><table width="95%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" class="ewttableuse">
        <tr> 
          <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF"  class="ewttableuse">
              <tr align="center" bgcolor="#999999" class="ewttablehead"> 
                <td width="70%"><?php echo $text_genfaq_ask;?></td>
					<td width="11%" ><?php echo $text_genfaq_faqcount;?></td>
                <td width="19%">&nbsp;</td>
              </tr>
              <?php
 if($row > 0){
   while($R = mysql_fetch_array($Execsql)){ 
?>
              <tr  > 
                <td align="left" bgcolor="#FFFFFF" ><a href="#"  onClick="c=window.open('faq_view.php?fa_id=<?php echo $R['fa_id'];?>','showass','scrollbars=yes,width=650,height=400');c.focus();"><?php echo $R[fa_name]; ?>
                    </a></td>
                <td align="right" bgcolor="#FFFFFF">(
                      <?php echo $R[sum_fa_id];?>
                  )</td>
                <td bgcolor="#FFFFFF">
                  
                  <?php }} ?>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</td>
          </tr>
          <tr>
            <td height="25" colspan="2" valign="top"><?php echo $text_general_pageNo;?> :
              <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&Flag=".$_REQUEST["Flag"]."&start_date=".$start_date."&end_date=".$end_date."'>
<font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ".$text_general_previous."</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($row/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($row%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">[ $i ] </font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&Flag=".$_REQUEST["Flag"]."&start_date=".$start_date."&end_date=".$end_date."' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&Flag=".$_REQUEST["Flag"]."&start_date=".$start_date."&end_date=".$end_date."'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">".$text_general_next.">></font></a>"; 
    }
?></td>
          </tr>
        </table>
      </td>
    </tr>
 
  </table>
</div>
</body>
</html>
