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
			if ($offset=='' || $offset < 0) { 
    	 	   $offset=0; 
			} 
			if ($category_id=='' || $category_id< 0) { 
    	 	   $category_id = 0;
			} 
			//    Set $limit,  $limit = Max number of results per 'page' 
			if($limit==''){
			$limit = 12;
			}
		$cal = 6;
		$w = number_format((100/$cal),0,'','');
		$i=0;
		$sql = "SELECT * FROM gallery_category  where parent_id = '".$category_id."' order by cat_timestamp DESC,category_id DESC";
		$rows  = $db->db_num_rows($db->query($sql));
		$sql_category =  $sql." LIMIT $offset,$limit ";
		$query_category = $db->query($sql_category);
		//$num_rows_2  = $db->db_num_rows($query_category);
		?>
		 <table width="100%" border="0"  cellpadding="5" cellspacing="1" >
		<?php
		while($rs_img = $db->db_fetch_array($query_category)){
		$sql_img = $db->query("select img_path_s from gallery_image,gallery_cat_img where gallery_cat_img.img_id=gallery_image.img_id and gallery_cat_img.category_id = '".$rs_img[category_id]."' order by gallery_image.img_id ASC limit 0,1");
							$rec_img = $db->db_fetch_array($sql_img);
							$img_p = $rec_img[img_path_s];
							if (!file_exists($rec_img[img_path_s]) ) {
									$img_p = "mainpic/no-download.gif";
							}
		if($i%$cal == 0 ) {?> <tr ><?php }?>
		 <td width="<?php echo $w ;?>%" align="center" valign="top" style="cursor:hand"  onClick="location.href='gallery_view_catelogy.php?category_id=<?php echo $rs_img[category_id];?>'">  <table  border="0" cellspacing="0" cellpadding="0">
                      <tr  >
                        <td width="30" height="31"><img src="mainpic/gallery/b01_01.jpg" width="31" height="31" ></td>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td height="31" background="mainpic/gallery/b01_03.jpg">&nbsp;</td>
									<td width="14" height="31"><img src="mainpic/gallery/b01_05.jpg" width="14" height="31" /></td>
								  </tr>
								</table>
						</td>
                        <td width="17" height="30"><img src="mainpic/gallery/b01_06.jpg" width="17" height="31" ></td>
                      </tr>
                      <tr>
                        <td width="31" valign="top" background="mainpic/gallery/b01_10.jpg">&nbsp;</td>
                        <td align="center">  
						<?php
			//chk img or swf
																			$filetypename = explode('.',$img_p);
																			//print_r($filetypename);
																			if($filetypename[1] == 'swf'){
																			echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="100" height="100">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$img_p.'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$img_p.'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="100" height="100"> </embed>
										</object>';
																			}else{
		?>
                      <img src="<?php echo $img_p;?>" hspace="0" height="100" width="100" vspace="0"   border="1" alt="<?php echo $rs_img[category_name];?>" align="top"  style="border:1px #C3C3C3 double ; padding:5px;"><?php } ?>  	<div class="text_normal"><?php echo $rs_img[category_name];?></div>
                        </td>
                            <td width="17" valign="bottom" background="mainpic/gallery/b01_12.jpg"></td>
              </tr>
                          <tr>
                            <td width="30" height="41"><img src="mainpic/gallery/b01_15.jpg" width="31" height="41" ></td>
                            <td height="41" background="mainpic/gallery/b01_16.jpg">&nbsp;</td>
                            <td width="17" height="41"><img src="mainpic/gallery/b01_17.jpg" width="17" height="41" ></td>
                          </tr>
                        </table>
																					
																				</td>
			  									
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
				echo   "<a href='#u' onclick=\"galery_show('".$prevoffset."','".$category_id."');\"><font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ก่อนหน้า</font></a>\n\n";
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
							  echo  "<a href='#u' onclick=\"galery_show('".$newoffset."','".$category_id."');\"><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">&nbsp;$i&nbsp;</font></a>\n\n"; 
					} 
				} 
				// Check to see if current page is last page 
			   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
					// Not on the last page yet, so display a NEXT Link 
					$newoffset=$offset+$limit; 
					echo   "<a href='#u' onclick=\"galery_show('".$newoffset."','".$category_id."');\">
					  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
				}
				?>
				&nbsp;&nbsp;&nbsp;<?php }?></td>
			  </tr>
			</table>
<?php			if($rows > 0){
?>
		<table width="96%" border="0" align="center">
		  <tr>
			<td ><br><span class="text_head"><div style="FONT: 17px 'Tahoma';">ภาพกิจกรรม<?php //echo $name;?></div><hr size="1"></span></td>
		</tr>
		</table>
<?php } ?>
		<!-----add code for gallery-->

<?php
$db->db_close(); 
?>
