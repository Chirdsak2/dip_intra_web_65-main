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
									$txt = "<div align=".$im[0]."><span title=\"".$im[6]."\"><img src=\"".$p.$im[5]."\" width=".$im[2]." height=".$im[1]." alt=".$im[6]."></div>";
									return $txt;
								}elseif($R["block_type"] == "flash"){
									$im = explode("@@##@@",$T["text_html"]);
									$txt = "<div  align=\"".$im[0]."\" ><span title=\"".$im[6]."\"><script type=\"text/javascript\" src=\"js/media.js\" language=\"javascript1.1\"></script><div id=\"flash".$BID."\"></div>
								<script type=\"text/javascript\"   language=\"javascript1.1\">
									var flash_src =  '".$p.$im[5]."';
									var player = new GMedia('player' , flash_src,".$im[2].",".$im[1].",'".$im[6]."'); 
									player.addParam('flashvars','file=' +  flash_src,".$im[2].",".$im[1].",'".$im[6]."'); 
									player.write('flash".$BID."'); 
								</script></span></div>";
									return $txt;
								}elseif($R["block_type"] == "media"){
									$im = explode("@@##@@",$T["text_html"]);
									$txt = "<div  align=".$im[0]." ><span title=\"".$im[6]."\"><script type=\"text/javascript\"   language=\"javascript1.1\">
									var str = '<object type=\"application/x-mplayer2\"  data=\"http://server.burtondns.org:PORT/\"  height=".$im[1]." width=".$im[2]."   classid=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\"  id=\"mediaplayer".$BID."\"  title=".$im[6].">';
									str +='<param name=\"Filename\" value=\"".$p.$im[5]."\">';
									str +='<param name=\"movie\" value=\"ttp://server.burtondns.org:PORT/\" >';
									str +='<param name=\"AutoStart\" value=\"False\">';
									str +='<param name=\"ShowControls\" value=\"True\">';
									str +='<param name=\"ShowStatusBar\" value=\"True\">';
									str +='<param name=\"ShowDisplay\" value=\"False\">';
									str +='<param name=\"AutoRewind\" value=\"False\">';
									str +='<param NAME=\"WindowlessVideo\" value=\"1\">';
									 str += '</object>';
								document.write(str);</script></span></div>";
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
									return stripslashes($line);*/
									$line = $T["text_html"];
									return stripslashes($line);
								}
								
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