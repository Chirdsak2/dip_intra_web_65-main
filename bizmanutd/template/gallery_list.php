<?php
header ("Content-Type:text/html;charset=UTF-8");
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
	//===============================================================================
	if($offset){ $offset = checkNumeric($offset); }
	if($_GET["offset"]){ $_GET["offset"] = checkNumeric($_GET["offset"]); }
	if($_POST["offset"]){ $_POST["offset"] = checkNumeric($_POST["offset"]); }
	//===============================================================================
?>

	<!-----add code for gallery-->
		<!-----group id = 0-->
		<?php
			$offset = $_GET[offset];
			$category_id =  $_GET[category_id];
			$col = $_GET[col];
			$row = $_GET[row];
			$hi = $_GET[hi];
			$wi = $_GET[wi];
			if ($offset=='' || $offset < 0) { 
    	 	   $offset=0; 
			} 
			if ($category_id=='' || $category_id< 0) { 
    	 	   $category_id = 0;
			} 
			if ($col=='' || $col< 0) { 
    	 	   $col = 0;
			}
			if ($row=='' || $row< 0) { 
    	 	   $row = 0;
			}
			if ($hi=='' || $hi< 0) { 
    	 	   $hi = 0;
			}
			if ($wi=='' || $wi< 0) { 
    	 	   $wi = 0;
			}
			//    Set $limit,  $limit = Max number of results per 'page' 
			if($limit==''){
			$limit = $col*$row;
			}
		
		$i=0;
		$sql = "SELECT * FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_cat_img.category_id = '".$category_id."' ORDER BY cat_img_id,gallery_image.img_id";
		$rows  = $db->db_num_rows($db->query($sql));
		if($rows > 0){
		$cal = $col;
		$w = number_format((100/$cal),0,'','');
		$sql_category =  $sql." LIMIT $offset,$limit ";
		$query_category = $db->query($sql_category);
		$num_rows_2  = $db->db_num_rows($query_category);

?>
				 <table width="100%" border="0"  cellpadding="5" cellspacing="1" >
		<?php
		while($rs_img = $db->db_fetch_array($query_category)){

							$img_p = $rs_img[img_path_s];
							if (!file_exists($rs_img[img_path_s]) ) {
									$img_p = "mainpic/no-download.gif";
							}
		if($i%$cal == 0 ) {?> <tr ><?php }?>
		 <td width="<?php echo $w ;?>%" align="center" valign="top" >
		
		<?php
			//chk img or swf
																			$filetypename = explode('.',$img_p);
																			
																			if($filetypename[1] == 'swf'){
																			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'.$wi.'" height="'.$hi.'">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$img_p.'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$img_p.'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'.$wi.'" height="'.$hi.'"> </embed>
										</object><br><br>';
																			}else{
		?>
		<a href="<?php echo $rs_img[img_path_b]?>" class="lightbox" rel="flowers" title="<?php echo $rs_img[img_name]?>" id="<?php echo $rs_img[img_id]?>"><img src="phpThumb.php?src=<?php echo $img_p?>&h=<?php echo $wi;?>&w=<?php echo $hi;?>" hspace="0" vspace="0" border="0" align="top"  style="border:1px #C3C3C3 double ; padding:5px;"  ></a><?php } ?>
		
																					
																					<div class="text_normal"><?php echo $rs_img[img_name]?></div></td>
			  									
		  </td>
						<?php  if($i%$cal == ($cal-1)) {?></tr> <?php }?>
					
						<?php
						$i++;
		}//end while
		$d = $i%$cal;
		for($b=$d;$b<$cal;$b++){
		?><td width="<?php echo $w ;?>%" align="center" valign="top" >&nbsp;
		 </td>
		<?php 
		}
		?>
			</table>
			
			<table width="100%" border="0">
			  <tr>
				<td align="right"><?php if($rows>0){ ?><span class="text_normal">หน้าที่ :&nbsp;</span>
				<?php
				// Begin Prev/Next Links 
				// Don't display PREV link if on first page 
				if ($offset !=0) {   
				$prevoffset=$offset-$limit; 
				echo   "<a href='#u' onclick=\"galery_show2('".$prevoffset."','".$category_id."','".$col."','".$row."','".$hi."','".$wi."');\"><font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ก่อนหน้า</font></a>\n\n";
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
						echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">&nbsp;[$i]&nbsp;</font>\n\n"; 
					} else { 
						// $i is NOT the current page, so display a link to page $i 
						$newoffset=$limit * ($i-1); 
							  echo  "<a href='#u' onclick=\"galery_show2('".$newoffset."','".$category_id."','".$col."','".$row."','".$hi."','".$wi."');\"><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">&nbsp;$i&nbsp;</font></a>\n\n"; 
					} 
				} 
				// Check to see if current page is last page 
			   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
					// Not on the last page yet, so display a NEXT Link 
					$newoffset=$offset+$limit; 
					echo   "<a href='#u' onclick=\"galery_show2('".$newoffset."','".$category_id."','".$col."','".$row."','".$hi."','".$wi."');\">
					  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
				}
				?>
				&nbsp;&nbsp;&nbsp;<?php }
				}
				?></td>
			  </tr>
			</table>
		<!-----add code for gallery-->
<?php
$db->db_close(); 
?>
