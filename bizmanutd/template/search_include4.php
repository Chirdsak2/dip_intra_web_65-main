<?php
   if($keyword != ""){ 
$limit = "10";
$today=date('Y-m-d');
$ip_address=getenv("REMOTE_ADDR");
$pkw = explode(" ",$keyword);
$sum = count($pkw);
//echo $sum;
$seld = " ( ";
	for($q = 0;$q<$sum;$q++){
			if($pkw[$q] != ""){
				if($q==0){
					 $seld .= " ( t_name REGEXP  '$pkw[$q]' OR t_detail REGEXP  '$pkw[$q]'  OR  a_detail REGEXP  '$pkw[$q]' )";
				 }else{
				 	$seld .= " OR ( t_name REGEXP  '$pkw[$q]' OR t_detail REGEXP  '$pkw[$q]'   OR  a_detail REGEXP  '$pkw[$q]'    )";
				}
			 //$seld .= " OR ( a_detail REGEXP  '$pkw[$q]'    ))";
			}
	}
$seld .= " ) ";

//$sql_search = "select * from w_question,w_answer
							 	//WHERE w_question.t_id = w_answer.t_id ";
$sql_search = "SELECT  w_question.t_name, w_question.t_detail,w_answer.a_detail, w_question.c_id, w_question.t_id
FROM w_question
LEFT JOIN w_answer ON w_question.t_id = w_answer.t_id WHERE 1=1 ";

/*$summ = strlen($oper);
$seld = substr($seld,0,-$summ);
 $seld2 = substr($seld2,0,-3);
$seld .= " )  ";
 $seld2 =" and (". $seld2.")";*/
 if($seld != ''){ $sql_search .= "and"; }
$sql_search .= $seld;
$sql_search .= $seld2;
$sql_search .= "GROUP BY w_question.t_id  order by w_question.t_name DESC";

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
	$rest = '';
	$filename1 = $R[t_name];
	$block =  ereg_replace("&lt;br&gt;","",$R[t_name].$R[t_detail].$R[a_detail]);
	$pos = strpos($block, $pkw[0]);
	if(empty($pos) ){
	$pos = strpos($block, $pkw[1]);
	}
		if (!($pos === false)) { // note: three equal signs
		$pos1 = $pos - 100;
		if($pos1 < 0){
		$pos1 = 0;
		}

 $rest .= substr($R[t_detail], $pos1, 200);
 $rest .= substr($R[a_detail], $pos1, 200);
 $filename1.= substr($R[t_name], $pos1, 200);
 $rest = htmlspecialchars($rest,ENT_QUOTES);
 $filename1 = htmlspecialchars($filename1,ENT_QUOTES);
		for($q = 0;$q<$sum;$q++){
							if($pkw[$q] != ""){
							$rest = ereg_replace($pkw[$q],"<b>".$pkw[$q]."</b>", $rest);
							$filename1 = ereg_replace($pkw[$q],"<b>".$pkw[$q]."</b>", $filename1);
							}
		}
}
	?>
    <tr>
      <td bgcolor="#F3F3F3"><font size="2" face="MS Sans Serif, MS Sans Serif, sans-serif"><a href="<?php echo $R[filename]; ?>.html" target="_blank"></a></font></td>
    </tr>
	<tr>
	  <td><a href="index_answer.php?wcad=<?php echo  $R[c_id]; ?>&wtid=<?php echo $R[t_id]; ?>&filename=<?php echo $filename; ?>&keyword=<?php echo $keyword; ?>" target="_blank"><font size="2" face="MS Sans Serif, MS Sans Serif, sans-serif"><?php echo $filename1; ?></font></a></td>
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
echo   "<a href='search_webboard.php?offset=$prevoffset&keyword=$keyword&oper=$oper&filename=$filename'>
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
                  echo  "<td align=\"center\" width=16><a href='search_webboard.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'><font size=\"2\" face=\"MS Sans Serif\">$i</font></a></td>"; 
        } 
    } 

?>
        </font> 
            <td width="65" align="center"><font size="2" face="MS Sans Serif"><?php 
			if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='search_webboard.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'>ถัดไป</a>"; 
    }  ?></font></td>
          </tr>
        </table>
      </td>
    </tr>
	<?php
	}else{
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
  <?php } ?>