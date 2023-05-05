<?php
function show_block($BID){
	global $db;
	global $share_path;

	if($share_path == "Y"){
	$p = "../../".$_SESSION["EWT_SUSER"]."/";
	}else{
	$p = "../";
	}

	$sql_file = $db->query("SELECT block_type,block_link FROM block WHERE BID = '".$BID."'");
		if($db->db_num_rows($sql_file) == 1){
			$R = $db->db_fetch_array($sql_file);
				if($R["block_type"] == "text" OR $R["block_type"] == "code" OR $R["block_type"] == "images" OR $R["block_type"] == "flash" OR $R["block_type"] == "media"){ 
						$sql_text = $db->query("SELECT * FROM block_text WHERE BID = '".$BID."' AND text_id = '".$R["block_link"]."'");
						$T = $db->db_fetch_array($sql_text);
								if($R["block_type"] == "images"){
									$im = explode("@@##@@",$T["text_html"]);
									$txt = "<div align=".$im[0]."><img src=\"".$p.$im[5]."\" width=".$im[2]." height=".$im[1]."></div>";
									return $txt;
								}elseif($R["block_type"] == "flash"){
									$im = explode("@@##@@",$T["text_html"]);
									$txt = "<div  align=\"".$im[0]."\" ><object   classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"".$im[2]."\" height=\"".$im[1]."\"><param name=\"movie\" value=\"".$p.$im[5]."\"><param name=\"quality\" value=\"high\"><embed src=\"".$p.$im[5]."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".$im[2]."\" height=\"".$im[1]."\"></embed></object></div>";
									return $txt;
								}elseif($R["block_type"] == "media"){
									$im = explode("@@##@@",$T["text_html"]);
									$txt = "<div  align=".$im[0]." ><OBJECT height=".$im[1]." width=".$im[2]." classid=CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6><PARAM NAME=\"url\" VALUE=\"".$p.$im[5]."\"><param name=\"playCount\" value=\"".$im[4]."\"><param name=\"autoStart\"  value=\"".$im[3]."\"><embed type=\"application/x-mplayer2\" pluginspage=\"http://www.microsoft.com/Windows/Downloads/Contents/MediaPlayer/\" width=\"".$_POST["width"]."\" height=\"".$im[1]."\" src=\"".$p.$im[5]."\" filename=\"".$p.$im[5]."\" autostart=\"".$im[3]."\" ></embed></OBJECT></div>";
									return $txt;
								}else{
								/*$pathall = "../w3cfile/w3c_".$BID.".html";
								$fw = @fopen($pathall, "r");
								 if($fw){ 
									while($html = @fgets($fw, 1024)){
									$line .= $html;
									}
								}
								  @fclose($fw);
									return stripslashes($line);
								}*/
								return stripslashes($T["text_html"]);
				}
				if($R["block_type"] == "graph"){ 
					$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$R["block_link"]."'");
					if($db->db_num_rows($sql_graph)){
					$G = $db->db_fetch_array($sql_graph);
					
					$sql = $db->query("select * from block where BID = '".$BID."' ");
					$rec = $db->db_fetch_array($sql);
					$graph_id=$rec[block_link];
					
					if($rec[block_themes]!= '0'){
							$namefolder = "themes".($rec[block_themes]);
							@include("themesdesign/configthemes.php");
							@include("themesdesign/".$namefolder."/".$namefolder.".php");
							 if($themes_type == 'F'){
									$buffer = "";
									$fd = @fopen ($Current_Dir1.$themes_file, "r");
									 while (!@feof ($fd)) {
										$buffer .= @fgets($fd, 4096);
									 }
									@fclose ($fd);
									$design = explode('<?#htmlshow#?>',$buffer);
							 }
					}

                 ?>
				 <?php
						$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$graph_id."'");
						$R = $db->db_fetch_array($sql_graph);
						?>
						<table width="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
													<tr> 
													  <td  bgcolor="#FFFFFF"><div align="<?php echo $R["graph_align"]; ?>">
						<?php
							 
							 $fileGraph="../graph/graph_".$graph_id.'.xml';		  
							 
							 if($R['graph_type']=='Area'){
								 $Graph_swf="FCF_MSArea2D.swf";
							 }else  if($R['graph_type']=='Line'){
								 $Graph_swf="FCF_MSLine.swf";
							 }else if($R['graph_type']=='Column'){
								 $Graph_swf="FCF_MSColumn2D.swf";
							 }else if($R['graph_type']=='Column3d'){
								 $Graph_swf="FCF_MSColumn3D.swf";
							 }else if($R['graph_type']=='Bar' or $R['graph_type']=='Bar3d'){
								 $Graph_swf="FCF_MSBar2D.swf";
							 }else if($R['graph_type']=='Pie'){
								 $Graph_swf="FCF_Pie2D.swf";
								  $fileGraph="../graph/gpie_".$graph_id.'.xml';
							 }else if($R['graph_type']=='Pie3d'){
								 $Graph_swf="FCF_Pie3D.swf";
								  $fileGraph="../graph/gpie_".$graph_id.'.xml';
							 }
							 
						?>
						     <OBJECT  type="application/x-shockwave-flash" data="../chart/<?php echo $Graph_swf; ?>"  id="Column3D"  width="<?php echo $R["graph_width"]; ?>" height="<?php echo $R["graph_height"]; ?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"  >
         <param name="movie" value="../chart/<?php echo $Graph_swf; ?>" >
         <param name="FlashVars" value="&amp;dataURL=<?php echo $fileGraph; ?>&amp;chartWidth=<?php echo $R["graph_width"]; ?>&amp;chartHeight=<?php echo $R["graph_height"]; ?>">
         <param name="quality" value="high" >
      </object>
						</div></td>
                            </tr>
                          </table>
				 <?php
					echo $design[1];
					//return $Gaph_text;
					}
				}
				if($R["block_type"] == "vdo"){ 
										return GenVdo($R["block_link"],$BID);
				}
				if($R["block_type"] == "language"){ 
										return Genlanguage($R["block_link"],$BID);
				}
				if($R["block_type"] == "menu"){ 
										return GenMenu($R["block_link"]);
				}
				if($R["block_type"] == "article"){ 
										return GenArticle($BID,"");
				}
				if($R["block_type"] == "share"){ 
										$line = "";
										$fp = @fopen("../../share_content/".$R["block_link"].".inc", "r");
										while($html = @fgets($fp, 1024)){
										$line .= $html;
										}
										@fclose($fp);
										return $line;
				}
				if($R["block_type"] == "org"){ 
										return GenChart($R["block_link"]);
				}
				if($R["block_type"] == "fontsize"){ 
														return GenFontSize($BID);
				}
				if($R["block_type"] == "poll"){ 
										return GenPoll($R["block_link"],$BID);
				}
				if($R["block_type"] == "enews"){ 
										return GenENews($BID);
				}
				if($R["block_type"] == "survey"){ 
										return GenSurvey($BID);
				}
				if($R["block_type"] == "calendar"){ 
										return GenCalendar($BID);
				}
				if($R["block_type"] == "webboard"){ 
										return GenWebboard($R["block_link"],$BID);
				}
				if($R["block_type"] == "search"){ 
										return GenSearch($BID);
				}
				if($R["block_type"] == "banner"){ 
										return GenBanner($R["block_link"],$BID);
				}
				if($R["block_type"] == "guest"){ 
										return GenGuestbook($BID);
				}
				if($R["block_type"] == "login"){ 
										return GenLogin($BID);
				}
				if($R["block_type"] == "sitemap"){ 
										return GenSitemap($BID);
				}
				if($R["block_type"] == "faq"){ 
										return GenFaq($BID);
				}
				if($R["block_type"] == "complain"){ 
										return GenComplain($BID);
				}
				if($R["block_type"] == "gallery"){ 
										return GenGallery($BID);
				}
				if($R["block_type"] == "rss"){ 
										return GenRss($BID);
				}
				if($R["block_type"] == "link"){ 
										return GenLink($BID);
				}
				if($R["block_type"] == "asp" OR $R["block_type"] == "php" OR $R["block_type"] == "jsp"){
										return GenCodeText($R["block_link"],$R["block_type"]);
				}
				if($R["block_type"] == "online"){ 
										return GenOnline($R["block_link"],$BID);
				}
				if($R["block_type"] == "ebook"){  
										return GenEBook($BID);
				}
				if($R["block_type"] == "blog"){ 
										return GenBlog($BID);
				}
				if($R["block_type"] == "news"){ 
										return GenNewsBlock($R["block_link"],$BID);
				}
				if($R["block_type"] == "tooltips"){ 
										return GenTooltipsBlock($BID);
				}
		}
}
?>