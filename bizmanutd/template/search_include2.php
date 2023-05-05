<?php
	if(trim($_REQUEST["keyword"]) != ""){
		$data_default = stripslashes(htmlspecialchars(trim($_REQUEST["keyword"]),ENT_QUOTES));
		$data = $data_default;
		$data = str_replace('+',' ',$data);
		$data = str_replace('*',' ',$data);
		$dt = explode(" ",$data);
		$num = count($dt);
		$word_b = "";
		$word_a = "";
		$word_ah = "";
		for($i=0;$i<$num;$i++){
			if(trim($dt[$i]) != ""){
				$check = like_word($dt[$i]);
				$word_b .= $check." ";
						if($check != ""){
							$word_a .= "<font color=red>".$check."</font> ";
							$word_ah .= $check." ";
						}else{
							$word_a .= $dt[$i]." ";
							$word_ah .= $dt[$i]." ";
						}
						$db->query("insert into search_stat (search_word,search_date,search_ip)  values ('$dt[$i]','$today','$ip_address') ");
					if($search_mode == "1"){
						$seld .= " ( article_list.n_topic REGEXP  '$dt[$i]' OR article_list.n_des REGEXP  '$dt[$i]' )".$oper;
					}elseif($search_mode == "2"){
						$seld .= " ( temp_index.cms_keyword REGEXP  '$dt[$i]' OR temp_index.filename REGEXP  '$dt[$i]' )".$oper;
					}elseif($search_mode == "3"){
						$seld .= " ( temp_index.cms_keyword REGEXP  '$dt[$i]' OR temp_index.filename REGEXP  '$dt[$i]' )".$oper;
					}elseif($search_mode == "4"){
						$seld .= " ( temp_index.cms_keyword REGEXP  '$dt[$i]' OR temp_index.filename REGEXP  '$dt[$i]' )".$oper;
					}elseif($search_mode == "5"){
						$seld .= " ( temp_index.cms_keyword REGEXP  '$dt[$i]' OR temp_index.filename REGEXP  '$dt[$i]' )".$oper;
					}else
				}
		}
		//echo $seld;
		$word_b = trim($word_b);
		$summ = strlen($oper);
		$seld = substr($seld,0,-$summ);

$limit = "10";

 $sql_search = "SELECT  temp_index.filename,temp_index.cms_keyword FROM  temp_index  WHERE ".$seld." ORDER BY temp_index.filename  ";

 $query_search = $db->query($sql_search);
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
	 $totalrows = $db->db_num_rows($query_search);

	// Set $begin and $end to record range of the current page 
 $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
	 $sql_search .= " LIMIT $offset, $limit ";
	 
	 //echo  $sql_search;
	$query_search = $db->query($sql_search);
  ?>
            
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr> 
    <td align="left" bgcolor="F7F7F7"> 
      <?php
						if($word_b != ""){
			echo "คำใกล้เคียง : <a href=\"search_result.php?keyword=".$word_ah."\">".$word_a."</a>";
		}
				?>
    </td>
  </tr>
  <tr> 
    <td align="left" bgcolor="F7F7F7" >รายการที่ <strong><?php echo $offset + 1; ?> 
      - <?php echo $offset + $limit; ?></strong> จากผลการค้นหาทั้งหมด <strong><?php echo number_format($totalrows,0); ?></strong> 
      รายการของคำค้น <strong><?php echo $data_default; ?><hr width="100%"></td>
  </tr></tr>
  <?php 
			  if($db->db_num_rows($query_search)){ 
			  while($R=$db->db_fetch_array($query_search)){ 
					$filename1 = $R[filename];
					$pos = strpos($R[cms_keyword], $dt[0]);
							if (!($pos === false)) { // note: three equal signs
							$pos1 = $pos - 100;
							if($pos1 < 0){
							$pos1 = 0;
							}
								 $rest = substr($R[cms_keyword], $pos1, 200);
								 $rest = htmlspecialchars($rest,ENT_QUOTES);
										for($q = 0;$q<$num;$q++){
																		if($dt[$q] != ""){
																		$rest = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $rest);
																		$filename1 = ereg_replace($dt[$q],"<b>".$dt[$q]."</b>", $filename1);
																		}
										}
					}
	?>
  <tr> 
    <td bgcolor="#F3F3F3"></td>
  </tr>
  <tr> 
    <td><a href="search_open.php?filename=<?php echo $filename1; ?>&keyword=<?php echo $keyword; ?>" target="_blank"><b><?php echo $filename1; ?></b></a></td>
  </tr>
  <tr> 
    <td>...<?php echo stripslashes($rest); ?>...</td>
  </tr>
  <tr> 
    <td height="15">&nbsp;</td>
  </tr>
  <?php } ?>
  <tr> 
    <td align="center"> <table  border="0" cellpadding="1" cellspacing="0">
        <tr valign="bottom"> 
          <td width="120" align="right"><font size="2" face="MS Sans Serif"><strong>ผลการค้นหาหน้าที่:</strong></font></td>
          <td align="center" ><font size="2" face="MS Sans Serif"> 
            <?php if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='search_result.php?offset=$prevoffset&keyword=$keyword&oper=$oper&filename=$filename'>
ย้อนกลับ</a> ";
}
     ?>
            </font></td>
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
                  echo  "<td align=\"center\" width=16><a href='search_result.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'><font size=\"2\" face=\"MS Sans Serif\">$i</font></a></td>"; 
        } 
    } 

?></font>
          <td width="65" align="center"><font size="2" face="MS Sans Serif"> 
            <?php 
			if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='search_result.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'>ถัดไป</a>"; 
    }  ?>
            </font></td>
        </tr>
      </table></td>
  </tr>
  <?php
	}else{
	?>
  <tr> 
    <td><br> <font size="2" face="MS Sans Serif">ผลการค้นหา - <?php echo $keyword; ?> 
      - ไม่ตรงกับเอกสารใดเลย <br>
      คำแนะนำ:<br>

      - ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br>
      - ลองคำหลักที่ต่างจากนี้<br>
      - ลองใช้คำหลักทั่วๆไป<br>
      - ลองใช้คำให้น้อยลง</font><br> <br> </td>
  </tr>
  <?php
	} ?>
  <tr> 
    <td bgcolor="#666666" height="1"></td>
  </tr>
</table>
            <?php } ?>