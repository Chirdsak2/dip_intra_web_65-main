<?php
   if($keyword != ""){ 
$limit = "40";
$today=date('Y-m-d');
$ip_address=getenv("REMOTE_ADDR");
$pkw = explode(" ",$keyword);
$sum = count($pkw);
//echo $sum;
$seld = " ( ";
	for($q = 0;$q<$sum;$q++){
			if($pkw[$q] != ""){
			 $seld .= " ( img_name REGEXP  '$pkw[$q]' OR img_detail REGEXP  '$pkw[$q]'  )".$oper;
			}
	}
 $sql_search =  "SELECT * FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id 
 							WHERE";
$summ = strlen($oper);
$seld = substr($seld,0,-$summ);
$seld .= " )  ";
$sql_search .= $seld;
$sql_search .= " ORDER BY cat_img_id";


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
	 
	 //echo  $sql_search;
	 $img_list = array();
	 $img_list1 = array();
	 $img_list2 = array();
	 $cid = array();
	 $category_id = array();
	$query_search = $db->query($sql_search);
	$numfile = mysql_num_rows($query_search);
  ?>
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
              <tr> 
                <td align="left" bgcolor="F7F7F7"><font size="1" face="MS Sans Serif, MS Sans Serif, sans-serif">รายการที่ 
                  <strong><?php echo $offset + 1; ?> - <?php echo $offset + $limit; ?></strong> 
                  จากผลการค้นหาทั้งหมด <strong><?php echo number_format($totalrows,0); ?></strong> 
                  รายการของคำค้น <strong><?php echo $keyword ?></strong></font></td>
              </tr>
              <td height="1" align="left" bgcolor="#666666"></td>
              </tr>
              <?php if(mysql_num_rows($query_search)){ ?>
              <?php while($R=mysql_fetch_array($query_search)){ 
			  		array_push ($img_list,$R[img_name]);
					array_push ($img_list1,$$R[img_detail]);
					array_push ($img_list2,$R[img_path_s]);
					array_push ($cid,$R[img_id]);
					array_push ($category_id,$R[category_id]);
			  }
			  ?>
              <tr> 
                <td bgcolor="#FFFFFF">
				  <!--search start-->
			  			<table width="98%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
							<?php
								for($y=0;$y<$numfile;$y++){
									if($i%4 == 0){
										echo "<tr bgcolor=\"#FFFFFF\"  align=center height=\"55\">";
									}
									$pos = strpos($img_list[$y], $pkw[0]);
											if (!($pos === false)) { // note: three equal signs
											$pos1 = $pos - 100;
											if($pos1 < 0){
											$pos1 = 0;
											}
									 $rest = substr($img_list[$y], $pos1, 200);
									 $rest = htmlspecialchars($rest,ENT_QUOTES);
											for($q = 0;$q<$sum;$q++){
																if($pkw[$q] != ""){
																$rest = ereg_replace($pkw[$q],"<b>".$pkw[$q]."</b>", $rest);
																}
											}
									}
																		$preview_path = $img_list2[$y];
									$preview_path_en = base64_encode($preview_path);
									
						  ?>
									<td width="25%" align="center" valign="top"  >
										<table width="82" height="82" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">
												<tr>
												  <td align="center" valign="middle" bgcolor="#FFFFFF"><a href="gallery_view_img_comment.php?category_id=<?php echo $category_id[$y]?>&filename=<?php echo $filename; ?>&img_id=<?php echo $cid[$y]?>&page_cat=1"   target="_blank"><img src="phpThumb.php?src=<?php echo $preview_path; ?>&h=82&w=82" border="0" hspace="0" vspace="0" ></a></td>
												</tr>
											  </table>
									<div style="font-size:12px; font:'Microsoft Sans Serif'">...<?php echo stripslashes($rest); ?>...</div>
									</td>
						  <?php 
									if($i%4 == 3){
										echo "</tr>";
									}
						  $i++; } ?>
						  <?php 
									  if($i%4 == 0){
										echo "<tr align=center height=\"55\"><td width=25% valign=top>
										<span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
										
										</td>
										<td width=25%></td><td width=25%></td><td width=25%></td></tr>";
									}elseif($i%4 == 1){
										echo "<td width=25% align=center valign=top><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\"  onKeyDown=\"chkKeyFo(this)\"></div></span>
										</td>
										<td width=25% ></td><td width=25%></td></tr>";
									}elseif($i%4 == 2){
										echo "<td width=25% align=center valign=top><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
										</td>
										<td width=25% </td></tr>";
									}elseif($i%4 == 3){
										echo "<td width=25% align=center valign=top><span id=\"new_fo\" style=\"display:none\"><img src=\"../images/content_folder.gif\" width=\"24\" height=\"24\" border=\"0\" align=\"absmiddle\"><div ><input name=\"new_folder\" type=\"text\" id=\"new_folder\" size=\"6\" onBlur=\"create_fo(this)\" onKeyDown=\"chkKeyFo(this)\"></div></span>
										</td></tr>";
									}
						  ?>
						</table>
				   <!--search end-->
			    </td>
              </tr>
              <?php //} end while ?>
              <tr> 
                <td align="center"> <table  border="0" cellpadding="1" cellspacing="0">
                    <tr valign="bottom"> 
                      <td width="120" align="right"><font size="2" face="MS Sans Serif"><strong>ผลการค้นหาหน้าที่:</strong></font></td>
                      <td align="center" ><font size="2" face="MS Sans Serif"> 
                        <?php if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='search_images.php?offset=$prevoffset&keyword=$keyword&oper=$oper&filename=$filename'>
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
                  echo  "<td align=\"center\" width=16><a href='search_images.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'><font size=\"2\" face=\"MS Sans Serif\">$i</font></a></td>"; 
        } 
    } 

?></font>
                      <td width="65" align="center"><font size="2" face="MS Sans Serif"> 
                        <?php 
			if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='search_images.php?offset=$newoffset&keyword=$keyword&oper=$oper&filename=$filename'>ถัดไป</a>"; 
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