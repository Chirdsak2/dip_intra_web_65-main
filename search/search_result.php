<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <form name="form1" method="post" action="search_result.php">
    <tr> 
      <td height="25" align="right" bgcolor="E7E7E7">
<font size="1" face="MS Sans Serif, MS Sans Serif, sans-serif">ค้นหา</font> 
        <input name="keyword" type="text" id="keyword" style="font-family:'MS Sans Serif';font-size:12px;color:#000000;" value="<?php echo $keyword; ?>" size="30"> <input name="oper" type="radio" value="AND" <?php if($oper == "AND" OR $oper == ""){ echo "checked"; } ?>>
          <font size="1" face="MS Sans Serif, MS Sans Serif, sans-serif">ค้นหาทุกคำ 
          <input type="radio" name="oper" value="OR" <?php if($oper == "OR"){ echo "checked"; } ?>>
        ค้นหาบางคำ 
        <input type="submit" name="Submit" value="ค้นหา..."> <input type="button" name="Button" value="กลับหน้าหลัก" onClick="window.location.href='search_stat.php';">
          </font></td>
    </tr>
    <tr>
      <td bgcolor="#666666" height="1"></td>
    </tr></form><script language="JavaScript">
document.form1.keyword.focus();
</script>
  </table></td>
  </tr>
  <tr>
    <td valign="top"><?php
  $keyword = trim($keyword);
   if($keyword != ""){ 
$limit = "10";
$today=date('Y-m-d');
$ip_address=getenv("REMOTE_ADDR");
$pkw = explode(" ",$keyword);
$sum = count($pkw);
$db->write_log("Search","search_stat","ค้นหาคำค้น   ".$keyword);
//echo $sum;
$seld = " ( ";
	for($q = 0;$q<$sum;$q++){
			if($pkw[$q] != ""){
			 $seld .= " ( block_html REGEXP  '$pkw[$q]' OR temp_index.filename REGEXP  '$pkw[$q]'     )".$oper;
 			$seld2 .=  "search_stat.search_word= '$pkw[$q]'  OR ";
if(!$search_chk){	$db->query("insert into search_stat (search_word,search_date,search_ip)  values ('$pkw[$q]','$today','$ip_address') "); }

			}
	}
 $sql_search = "SELECT  count(search_word ) as sum_word,block.block_html, block.BID,temp_index.filename
									FROM  block
								  	INNER JOIN block_function ON (block.BID = block_function.BID)
								  	INNER JOIN temp_index ON (block_function.filename = temp_index.filename)							
									INNER JOIN search_stat ON ( block.block_html REGEXP  search_stat.search_word) 
							 	WHERE";
$summ = strlen($oper);
$seld = substr($seld,0,-$summ);
 $seld2 = substr($seld2,0,-3);
$seld .= " )  ";
 $seld2 =" and (". $seld2.")";
$sql_search .= $seld;
$sql_search .= $seld2;
   $sql_search .= "GROUP BY BID  order by sum_word DESC";

 $query_search = $db->query($sql_search);
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
	 $totalrows = mysql_num_rows($query_search);

	// Set $begin and $end to record range of the current page 
 $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
	 $sql_search .= " LIMIT $offset, $limit ";
	$query_search = $db->query($sql_search);
  ?>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr>
      <td align="left" bgcolor="F7F7F7"><font size="1" face="MS Sans Serif, MS Sans Serif, sans-serif">รายการที่ <strong><?php echo $offset + 1; ?> 
        - <?php echo $offset + $limit; ?></strong> จากผลการค้นหาทั้งหมด <strong><?php echo number_format($totalrows,0); ?></strong> 
        รายการของคำค้น <strong><?php echo $keyword ?></strong></font></td>
    </tr>
	<td height="1" align="left" bgcolor="#666666"></td>
    </tr>
	<?php if(mysql_num_rows($query_search)){ 
	?>
	<?php while($R=mysql_fetch_array($query_search)){ ?>
	<?php
	$filename = $R[filename];
$pos = strpos($R[block_html], $pkw[0]);
		if (!($pos === false)) { // note: three equal signs
		$pos1 = $pos - 100;
		if($pos1 < 0){
		$pos1 = 0;
		}
 $rest = substr($R[block_html], $pos1, 200);
 $rest = htmlspecialchars($rest,ENT_QUOTES);
		for($q = 0;$q<$sum;$q++){
							if($pkw[$q] != ""){
							$rest = ereg_replace($pkw[$q],"<b>".$pkw[$q]."</b>", $rest);
							$filename = ereg_replace($pkw[$q],"<b>".$pkw[$q]."</b>", $filename);
							}
		}
}
	?>
    <tr>
      <td bgcolor="#F3F3F3"><font size="2" face="MS Sans Serif, MS Sans Serif, sans-serif"><a href="<?php echo $R[filename]; ?>.html" target="_blank"></a></font></td>
    </tr>
	<tr>
	  <td><a href="search_open.php?filename=<?php echo $filename; ?>&keyword=<?php echo $keyword; ?>" target="_blank"><?php echo $filename; ?></a></td>
	  </tr>
	<tr>
      <td><font size="1" face="MS Sans Serif, MS Sans Serif, sans-serif">...<?php echo stripslashes($rest); ?>...</font></td>
    </tr>
	 <tr>
      <td><font color="#006600" size="2" face="MS Sans Serif">&nbsp;  
        </font></td>
    </tr>
    <tr> 
      <td height="15">&nbsp;</td>
    </tr>
	<tr> 
      <td height="1" bgcolor="#999999"></td>
    </tr>
	<?php } ?>
	<tr> 
      <td align="center"> 
        <table  border="0" cellpadding="1" cellspacing="0">
          <tr valign="bottom"> 
            
          <td width="120" align="right"><font size="2" face="MS Sans Serif"><strong>ผลการค้นหาหน้าที่:</strong></font></td>
            <td align="center" ><font size="2" face="MS Sans Serif"><?php if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='search_result.php?offset=$prevoffset&keyword=$keyword&oper=$oper'>
ย้อนกลับ</a> ";
}
     ?></font></td>
              <?php

    // Calculate total number of pages in result 
   $pages = intval($totalrows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($totalrows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     $current = ($offset/$limit) - 1;
	 $start = $current - 10;
	 if($start < 1){
	 $start = 1;
	 }
	 $end = $current + 10;
	 	 if($end > $pages){
	 $end = $pages;
	 }
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=$start;$i<=$end;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<td align=\"center\" width=16><font size=\"2\" face=\"MS Sans Serif\"><b>$i</b></font></td>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<td align=\"center\" width=16><a href='search_result.php?offset=$newoffset&keyword=$keyword&oper=$oper'><font size=\"2\" face=\"MS Sans Serif\">$i</font></a></td>"; 
        } 
    } 

?>
        </font> 
            <td width="65" align="center"><font size="2" face="MS Sans Serif"><?php 
			if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='search_result.php?offset=$newoffset&keyword=$keyword&oper=$oper'>ถัดไป</a>"; 
    }  ?></font></td>
          </tr>
        </table>
      </td>
    </tr>
	<?php}else{

	?>
	<tr>
      <td><br>
        <font size="2" face="MS Sans Serif">ผลการค้นหา - <?php echo $keyword; ?> - ไม่ตรงกับเอกสารใดเลย 
        <br>
        คำแนะนำ:<br>
        - ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br>
        - ลองคำหลักที่ต่างจากนี้<br>
        - ลองใช้คำหลักทั่วๆไป<br>
        - ลองใช้คำให้น้อยลง</font><br>
        <br>
      </td>
    </tr><?php
	} ?>
	<tr>
      <td bgcolor="#666666" height="1"></td>
    </tr>
  </table>
  <?php } ?></td>
  </tr>
  <tr> 
      
    <td height="10" align="center" bgcolor="E7E7E7">&nbsp;</td>
    </tr>
</table>
</body>
</html>
