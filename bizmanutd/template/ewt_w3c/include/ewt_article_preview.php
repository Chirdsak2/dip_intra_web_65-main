<?php
function GenCodeText($id,$type){
		 $txt = "<div id=\"code".$id.$type."\"></div>\n";
		 $txt .= "<script language=\"JavaScript\" type=\"text/JavaScript\">\n";
		 $txt .= "url='code/code".$id.".".$type."';\n";
		 $txt .= "AjaxRequest.get(\n";
		 $txt .= "{\n";
		 $txt .= "'url':url\n";
		 $txt .= ",'onLoading':function() { }\n";
		 $txt .= ",'onLoaded':function() { }\n";
		 $txt .= ",'onInteractive':function() { }\n";
		 $txt .= ",'onComplete':function() { }\n";
		 $txt .= ",'onSuccess':function(req) {\n";
		 $txt .= "document.all.code".$id.$type.".innerHTML = req.responseText; \n";
		 $txt .= "}\n";
		 $txt .= "}\n";
		 $txt .= ");\n";
		 $txt .= "</script>\n";
return $txt;
	 }
function chk_permission_article($c_id){
	global $db,$EWT_DB_NAME,$EWT_DB_USER;
//set permission
	//file grouppermission
	$db->query("USE ".$EWT_DB_USER);
	if($_SESSION["EWT_MID"] != ''){
		$group_id = array();
		$sql_permission="select * from user_group_member where ugm_tid = '".$_SESSION["EWT_MID"]."' ";
		$query = $db->query($sql_permission);
		while($rec = $db->db_fetch_array($query)){
			array_push($group_id,$rec[ug_id]);
		}
		if(count($group_id) == ''){
		$g_id = "";
		}else{
		$g_id = " or ug_id in (".implode ( ',', $group_id).")";
		}
	}
	$db->query("use ".$EWT_DB_NAME);
	//chk 
$sql = "select article_group.c_id from article_group,article_group_permission where article_group_permission.c_id=article_group.c_id and article_group.c_id = '".$c_id."'";
	$query = $db->query($sql);
	if($db->db_num_rows($query)==0){
		return true;
	}else{
//	echo $_SESSION["EWT_MID"];
		if($_SESSION["EWT_MID"] != ''){
			$sql2 = "select * from article_group_permission where c_id = '".$c_id."' and (gen_user_id = '".$_SESSION["EWT_MID"]."' or org_id = '".$_SESSION["EWT_ORG"]."' or emp_type_id='".$_SESSION["EWT_TYPE_ID"]."' $g_id)";
			$query2 = $db->query($sql2);
			if($db->db_num_rows($query2)==0){
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	
}
function to_child($cid){
 global $db;
 global $glo_sql;
	$sqlc = $db->query("SELECT c_id FROM article_group WHERE c_parent = '".$cid."' ");
	while($cr = $db->db_fetch_row($sqlc)){
		$glo_sql .= " OR c_id = '".$cr[0]."' ";
		to_child($cr[0]);
	}
 }
 function tomultigroup($cid){
 global $db;
 global $glo_sql;
	$sqlc = $db->query("SELECT multi_cid FROM article_multigroup WHERE c_id = '".$cid."' ");
	while($cr = $db->db_fetch_row($sqlc)){
		$glo_sql .= " OR c_id = '".$cr[0]."' ";
	}
 }
function GenArticle($bid,$Website) {
	global $filename;
	global $db,$access;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;
	global $glo_sql;
	
	$defwidth = "120";
	$defheight = "120";

	@include("../language/language".$lang_sh.".php");
	$lang_shw = substr($lang_sh, -2);
	$date_now = (date("Y")+543).'-'.date('m-d H:i:s');
	$themeid = $global_theme;
	$namefolder = "themes".($themeid);
	@include("../themesdesign/".$namefolder."/".$namefolder.".php");

	$sql_show = $db->query("SELECT block_link FROM block WHERE BID = '".$bid."' ");
	$B = $db->db_fetch_row($sql_show);
			if($lang_shw != ''){
		$sql_article_group =$db->query("
		SELECT * FROM article_group 
		INNER JOIN article_apply ON article_group.c_id = article_apply.c_id  
		INNER JOIN lang_article_group ON lang_article_group.c_id =article_group.c_id
		INNER JOIN lang_config ON lang_config.lang_config_id = lang_article_group.lang_name 
		WHERE article_apply.text_id = '".$bid."' AND article_apply.a_active = 'Y' AND 
		lang_config.lang_config_suffix = '".$lang_shw."' ORDER BY article_apply.a_pos ASC");
	}else{
		$sql_article_group = $db->query("SELECT * FROM article_group INNER JOIN article_apply ON article_group.c_id = article_apply.c_id  WHERE article_apply.text_id = '".$bid."'  AND article_apply.a_active = 'Y' ORDER BY article_apply.a_pos ASC");
}
	$i = 0;
	$row = $db->db_num_rows($sql_article_group);
	while($AG = $db->db_fetch_array($sql_article_group)){
				if($lang_shw != ''){
					$AG["c_name"] = $AG[lang_detail];
					$AMMORE = $text_genarticle_textMoreNews;
				}
				if($AMMORE ==''){
				$AMMORE = 'อ่านทั้งหมด';
				}
			
	$txt .= "<h1>".$AG["c_name"]."";
	if($AG["c_rss"] == "Y") { $txt .= " <a href=\"../rss/group".$AG["c_id"].".xml\" target=\"_blank\"><img src=\"mainpic/ico_rss.gif\"  border=\"0\" align=\"absmiddle\" alt=\"Rss Feeds\"></a>"; }
	$txt .= "</h1><hr><ul>";
										if($lang_shw != ''){
										$sql_article = $db->query("SELECT * FROM article_list,lang_article_list ,lang_config  WHERE article_list.n_id = lang_article_list.c_id AND lang_config.lang_config_id = lang_article_list.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."'  AND lang_article_list.lang_field = 'n_topic' AND article_list.c_id = '".$AG["c_id"]."' AND n_approve = 'Y' and (('$date_now' between n_date_start  and n_date_end) or (n_date_start = '' and n_date_end = '')) GROUP BY lang_article_list.c_id ORDER BY n_date DESC,n_timestamp DESC");
										}else{
										$sql_article = $db->query("SELECT n_id,n_topic,n_des,n_date,news_use,link_html,target,picture,picture_alt FROM article_list WHERE c_id = '".$AG["c_id"]."' AND n_approve = 'Y' and (('$date_now' between n_date_start  and n_date_end) or (n_date_start = '' and n_date_end = '')) ORDER BY n_date DESC,n_timestamp DESC LIMIT 0,".$AG["a_show"]);
										}
							
						while($A = $db->db_fetch_array($sql_article)){
						$date = explode("-",$A["n_date"]);
						$date =  $date[2]."/".$date[1]."/".$date[0];
						if($lang_shw != ''){
							$A[n_topic] = $A[lang_detail];
							$date = explode("-",$A["n_date"]);
							$date =  number_format($date[2],0)."/".number_format($date[1],0)."/".($date[0]-543);
							$A["link_html"] = select_lang_detail($A["n_id"],$lang_shw,'link_html','article_list');
							$A["picture_alt"] = select_lang_detail($A["n_id"],$lang_shw,'picture_alt','article_list');
						}
							
								$MPNAME = str_replace("’","",str_replace("”","",str_replace("“"," ",urlencode($A["n_topic"]))));
								$MPNAME = eregi_replace("%93"," ",$MPNAME);
								$MPNAME = eregi_replace("%94"," ",$MPNAME);
								$MPNAME1 = urldecode($MPNAME);
								$MPNAME1 = eregi_replace(" – "," - ",$MPNAME1);
								$txt .= "<li>";
								if($AG["AMBulletBP"] == "@first_news#" || $AG["AMBulletSP"] != "@first_news#" || $AG["AMBodyBP"] != "@detail_news#"){ 
													if($AG["AMBodyBPW"] == "" AND $AG["AMBodyBPH"] == ""){
														$ewtw = '90';
														$ewth = '90';
													}else{
				
														$ewtw = $AG["AMBodyBPW"];
														$ewth = $AG["AMBodyBPH"];
													}
											if($A["picture"] != ''){
											if($A["picture_alt"] == ''){
											$A["picture_alt"] = $MPNAME1;
											}
											if(file_exists("../images/article/news".$A["n_id"]."/".$A["picture"])){
				
												$txt .= "<img src=\"../phpThumb.php?w=".$ewtw."&amp;h=".$ewth."&amp;src=".$Website."images/article/news".$A["n_id"]."/".$A["picture"]."\" alt=\"".$A["picture_alt"]."\"    align=\"middle\"  >&nbsp;";
											}else{
													$sql_pic_detail = $db->query("SELECT ad_pic_b FROM article_detail WHERE n_id = '".$A["n_id"]."' AND ad_pic_b != '' ORDER BY ad_id ASC LIMIT 0,1");
													if($db->db_num_rows($sql_pic_detail) > 0){
													$pd = $db->db_fetch_row($sql_pic_detail);
														 if(file_exists("../images/article/news".$A["n_id"]."/".$pd[0])){
															$txt .= "<img src=\"../phpThumb.php?w=".$ewtw."&amph;=".$ewth."&amp;src=".$Website."images/article/news".$A["n_id"]."/".$A["picture"]."\" alt=\"".$A["picture_alt"]."\"    align=\"absmiddle\"  hspace=\"1\" vspace=\"1\" style=\"border-color:'#C3C3C3'\"  border=\"1\">&nbsp;";
														 }
													}
											}
											}
				}
								if($A["news_use"] == "2" || $A["news_use"] == "3"){
									$txt .= "<a href=\"ewt_news.php?filename=".$_GET["filename"]."&amp;nid=".$A["n_id"]."\" target=\"".$A["target"]."\" accesskey=".$db->genaccesskey().">";
								} elseif($A["news_use"] == "4") { 
								$txt .= "<a href=\"ewt_dl.php?filename=".$_GET["filename"]."&amp;nid=".$A["n_id"]."\" target=\"".$A["target"]."\" accesskey=".$db->genaccesskey().">";
								}else{
								$txt .= "<a href=\"ewt_dl_link.php?filename=".$_GET["filename"]."&amp;nid=".$A["n_id"]."\" target=\"".$A["target"]."\" accesskey=".$db->genaccesskey().">";
								}
								
								$txt .= $MPNAME1;
								if($AG["AMDate"]=="Y"){ 
									$txt .= " (".$date.") ";
								}
									$txt .= "</a></li> ";
						}
						
						$txt .= "</ul><br><br>";
						$txt  = ereg_replace ("<ul></ul>", "", $txt );
						$txt .= "<a href=\"more_news.php?filename=".$_GET["filename"]."&amp;cid=".$AG["c_id"]."\" accesskey=".$db->genaccesskey().">".$AMMORE."</a>";
						$txt .= "<br><br>";
					}
					
	return $txt;
}
	 function GenRss($BID){
		global $db,$access;
		global $mainwidth;
		global $global_theme;

	 $sql = $db->query("select  block_themes,block_link  from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$rss_id=$rec[block_link];

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);
		
		@include("../themesdesign/".$namefolder."/".$namefolder.".php");
	 //if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				}
				@fclose ($fd);
				$design = explode('<?#htmlshow#?>',$buffer);
		 }
       //echo $design[0];
}else{
	$head_font_color='#FFFFFF';
	$bg_color='#864420';
	$Current_Dir1='mainpic/';
	$bg_img='';
	$head_img='';
	$head_height=30;
	$body_color='#EBECE2';
	$body_font_color='#000099';
}

	 $query=$db->query("SELECT  *  FROM  rss WHERE rss_id = '$rss_id' "); 
	 $data = $db->db_fetch_array($query);
		$random = date("His");

		$spacial_text= "";
		 if($head_font_italic=='Y'){$spacial_text= ";font-style:italic"; } 
		 if($head_font_bold=='Y'){ $spacial_text.= ";font-weight:bold";}

		 $spacial_text2= "";
		 if($body_font_italic=='Y'){$spacial_text2= ";font-style:italic"; } 
		 if($body_font_bold=='Y'){ $spacial_text2.= ";font-weight:bold";}
		
		$txt ='<h1>'.$data[rss_title]."</h1><hr>";

        
        $txt .= "<script language=\"JavaScript\" type=\"text/JavaScript\"";
	    $txt .= "src=\"http://www.rssthai.com/rssreader.aspx?";
		$txt .= "rssuri=$data[rss_url]&amp;rowcount=$data[rss_row]&amp;datetype=thaifull\"></script>\n";
		$txt .= "\n";

return $txt;
	 }
 function GenNewsBlock($id,$BID){
		 global $db;
		 global $filename;
		 global $mainwidth;
		 global $global_theme;
		 global $lang_sh;
		 @include("../language/language".$lang_sh.".php");
		$dfg = explode('_',$lang_sh);
		$lang_sh = $dfg[1];
		if($id == ''){
			if($lang_sh != ''){
				$sql ="SELECT * FROM article_list,lang_article_list ,lang_config WHERE article_list.n_id = lang_article_list.c_id AND lang_config.lang_config_id = lang_article_list.lang_name AND lang_config.lang_config_suffix = '".$lang_sh."'  AND lang_article_list.lang_field = 'n_topic' AND n_approve = 'Y'  GROUP BY lang_article_list.c_id order by article_list.n_timestamp desc limit 0,5 ";
		 }else{
			$sql ="SELECT  * FROM article_list  WHERE n_approve = 'Y' order by article_list.n_timestamp desc limit 0,5";
			}
		$lable =$text_Gennewstop5_later;
		}else if($id == '1'){
			if($lang_sh != ''){
				$sql ="SELECT article_list.n_id, count(news_view.id_view) AS count_view, article_list.n_topic, article_list.news_use, article_list.link_html,lang_detail  FROM article_list,news_view,lang_article_list ,lang_config WHERE article_list.n_id = news_view.news_id and article_list.n_id = lang_article_list.c_id AND lang_config.lang_config_id = lang_article_list.lang_name AND lang_config.lang_config_suffix = '".$lang_sh."'  AND lang_article_list.lang_field = 'n_topic' AND n_approve = 'Y'  GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc limit 0,5 ";
		 }else{
		$sql ="SELECT  article_list.n_id, count(news_view.id_view) AS count_view, article_list.n_topic, article_list.news_use, article_list.link_html FROM article_list  INNER JOIN news_view ON (article_list.n_id = news_view.news_id) WHERE article_list.n_approve = 'Y' 
													GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc limit 0,5";
			}
		$lable = $text_Gennewstop5_hit;
		}	else if($id == '2'){
		if($lang_sh != ''){
				$sql ="SELECT sum(point)/count(news_id) as rating ,n_topic,article_list.n_id, article_list.news_use, article_list.link_html,lang_detail  FROM article_list,news_vote,lang_article_list ,lang_config WHERE article_list.n_id = news_vote.news_id and article_list.n_id = lang_article_list.c_id AND lang_config.lang_config_id = lang_article_list.lang_name AND lang_config.lang_config_suffix = '".$lang_sh."'  AND lang_article_list.lang_field = 'n_topic' AND n_approve = 'Y'  GROUP BY  news_id
											ORDER BY rating DESC  limit 0,5 ";
		 }else{
		$sql ="SELECT sum(point)/count(news_id) as rating ,n_topic,article_list.n_id, article_list.news_use, article_list.link_html
											FROM  article_list  INNER JOIN news_vote ON (article_list.n_id = news_vote.news_id) WHERE article_list.n_approve = 'Y'  
											GROUP BY  news_id
											ORDER BY rating DESC  limit 0,5";
		}
		$lable = $text_Gennewstop5_vote;
		}	

	
     ?>
   <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr > 
          <td  > <h1><span class="text_head">&nbsp;<?php echo $lable ;?></span></h1></td>
        </tr>
		 <tr align="center" > 
          <td  align="center">
		  <table width="100%" border="0" cellpadding="1" cellspacing="1">
        <?php
								$query = $db->query($sql);
                              $num = $db->db_num_rows($query);
								while($rs = $db->db_fetch_array($query)){
								$i++;

								$dt=explode(' ',$rs[n_timestamp]);
								$d=explode('-',$dt[0]);
								$d=$d[2].'/'.$d[1].'/'.$d[0];
							if($lang_sh != ''){
							$rs[n_topic] = $rs[lang_detail];
							}

								?>
									<tr valign="top" > 
									  <td width="1%" align="right"><img src="../mainpic/news_bullet.gif" alt="news_bullet"></td>
									  <td width="99%" align="left"><a href="<?
								if($rs[news_use] == "2" or $rs[news_use] == "3"){
								echo "ewt_news.php?filename=".$filename."&amp;nid=".$rs[n_id];
								}elseif($rs[news_use] == "4"){
								echo "ewt_dl.php?nid=".$rs[n_id];
								}else{
									if(eregi('http://',$rs["link_html"]) || eregi('mailto:',$rs["link_html"])){
									 $txt = $rs["link_html"];
									 }else{
									$txt = "../".$rs["link_html"];
									}
								echo $txt ;
								}
								?>" target="_blank" accesskey=<?php echo $db->genaccesskey();?>><span class="text_normal"><?php echo $rs[n_topic]?> <?php if($id == ''){ ?>(<?php echo $d.' '.$dt[1];?>)<? } ?></span></a></td>
									</tr>
        <?php
								}
        ?>
	        </table>
		   </td>
        </tr>
</table>
<?php
	 }
?>
