<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 $sel = "SELECT * FROM faq WHERE f_sub_id = '$f_sub_id'   and faq_use='Y' ORDER BY  faq_top DESC ,faq_date DESC";
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = $CO[c_number];

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
$Execsql = $db->query($Show); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
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
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" class="normal_font">
<?php
$Execsql1 = $db->query("SELECT * FROM f_subcat WHERE f_sub_id = '$f_sub_id'");
$QQ= mysql_fetch_array($Execsql1);
?>
  <tr>
    <td valign="top" align="right" height="25"><form name="form1" method="post" action="">
      <input type="text" name="keyword">
      <input type="submit" name="search" value="ค้นหา FAQ">
    </form></td>
  </tr>
  <tr>
    <td width="100%" valign="top"><DIV align="center"  ><strong><font size="4" face="Tahoma"><?php
$Execsql1 = $db->query("SELECT * FROM f_cat  inner join f_subcat  on   f_cat.f_id =f_subcat.f_id WHERE f_sub_id = '$f_sub_id'");
$QQ= mysql_fetch_array($Execsql1);
?>
 FAQ ในหมวด "<?php echo $QQ[f_cate]; ?>"</font></strong> <br>
                <strong><font size="4" face="Tahoma">หมวดย่อย "<?php echo $QQ[f_subcate]; ?>"</font></strong>  
                <br>
                <br>
                <?php
	  if($rows > 0){
   while($R = mysql_fetch_array($Execsql)){ 
	?>
                <table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#0000FF" class="normal_font">
                  <tr bgcolor="#3399FF" class="head_font"> 
                    <td width="13%">คำถาม</td>
                    <td width="87%"> 
                      <?php echo ($R[fa_name]); ?>
                    </td>
                  </tr>
                  <tr bgcolor="#F7F7F7"> 
                    <td>รายละเอียด</td>
                    <td width="87%"> 
                      <?php echo ($R[fa_detail]); ?>
                    </td>
                  </tr>
                  <tr bgcolor="#FFFFFF"> 
                    <td>คำตอบ</td>
                    <td> 
                      <?php echo ($R[fa_ans]); ?>
                    </td>
                  </tr>
                  <tr align="right" bgcolor="#FFFFFF"> 
                    <td colspan="2">&nbsp;                      </td>
                  </tr>
                </table>

                <br>
                  <?php }}else{ ?>
				   <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#0000FF" class="normal_font">
                  <tr bgcolor="#FFFFFF"> 
                    <td height="30" colspan="2"><div align="center"><font color="#FF0000"><strong>ไม่มี 
                        FAQ ในหมวดนี้</strong></font></div></td>
                  </tr>
				  </table>
                  <?php } ?>
	</DIV></td>
  </tr>
  <?php  if($rows > 0){ ?>
  <tr bgcolor="#FFF4EA">
    <td height="25" valign="top"><strong>หน้าที่ :</strong>     <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&fcad=$fcad'>
<font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ก่อนหน้า</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($rows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($rows%$limit) { 
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
                  echo  "<a href='$PHP_SELF?offset=$newoffset&fcad=$fcad' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&fcad=$fcad'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
    }
?></td>
  </tr>
  <?php } ?>
</table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
</div>
</body>
</html>
