<?php
$path = "../";
	session_start();
	if($_GET["SSMID"]!=''){
	$_SESSION["EWT_MID"] = $_GET["SSMID"];
	}
	$_SESSION["EWT_MAIL"] = $_GET["SSMAIL"];
	$_SESSION["EWT_ORG"] = $_GET["SSorg"];
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

include("ewt_template_more_news.php");
			if($lang_sh != ''){
				$dfg = explode('_',$lang_sh);
				$lang_shw = $dfg[1];
				$lang_sh = $lang_sh;
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("../language/language".$lang_sh.".php");
$db->access=200;
if($lang_shw != ''){
	 $sql_group ="select * from  article_group,lang_article_group,lang_config where lang_article_group.c_id =article_group.c_id AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_id = '".$_GET["cid"]."'";
	  }else{
	 $sql_group ="select * from  article_group where c_id = '".$_GET["cid"]."'";
	 }
	 $query_group = $db->query($sql_group);
	 $U = $db->db_fetch_array($query_group);
	   if($lang_shw != ''){	
	$U[c_name] = $U[lang_detail];
	 }
	 function findparent($id){
	 global $db;
	 global $filename;
	 global $lang_shw;
	 if($lang_shw != ''){
	 $sql =$db->query("select * from  article_group,lang_article_group,lang_config where lang_article_group.c_id =article_group.c_id AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_id = '".$id."'");
	  }else{
	 $sql = $db->query("SELECT * FROM article_group WHERE c_id = '$id' ");
	 }
	 	if($db->db_num_rows($sql)){
	 		$G = $db->db_fetch_array($sql);
			 if($lang_shw != ''){	
			$G[c_name] = $G[lang_detail];
			 }
			$txt = " <a href = \"more_news.php?cid=".$G["c_id"]."&amp;filename=".$filename."\">".$G["c_name"]."</a> &gt;&gt; ";
			if($G[c_parent] != "0" AND $G[c_parent] != ""){
				$txt = findparent($G[c_parent]).$txt;
			}		
	 	}
		return $txt;
	 }
function count_articlr($n_id){
global $db;

$wh = "WHERE  n_id='".$n_id."'  ";

$sql_article = $db->query("SELECT news_view.news_id, count(news_view.id_view) AS count_view, article_list.n_topic,c_id
													FROM article_list  LEFT JOIN news_view ON (article_list.n_id = news_view.news_id) $wh
													GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc  ");
$R = $db->db_fetch_array($sql_article);
return  $R[count_view];
}
	 if(chk_permission_article($_GET["cid"]) == true){
	 ?>
<?php echo $template_design[0];?>
	<?php
			$mainwidth = $R["d_site_content"];
			?>
	  <?php
	  
 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
if(empty($limit)){
$limit = 20;
}
	  	if(!empty($_POST["search_txt"])){
		$pkw = explode(" ",$_POST["search_txt"]);
		$sum = count($pkw);
		//$seld .= " AND article_list.n_id = article_detail.n_id AND ";
		$seld .= " AND ( ";
			for($q = 0;$q<$sum;$q++){
					if($q ==0){
					 $seld .= "  (n_topic REGEXP  '$pkw[$q]' OR n_des REGEXP  '$pkw[$q]'   )";
					}else{
					 $seld .= "  OR (n_topic REGEXP  '$pkw[$q]' OR n_des REGEXP  '$pkw[$q]'   )";
					}
			}
			$seld .= " ) ";
		}
		$date_st = explode("/",$_POST["date_s"]);
		$date_en = explode("/",$_POST["date_e"]);
		$date_1 = ($date_st[2])."-".$date_st[1]."-".$date_st[0];
		$date_2 = ($date_en[2])."-".$date_en[1]."-".$date_en[0];
		if(!empty($_POST["date_s"]) && !empty($_POST["date_e"])){
		 $seld .= "  AND (n_date  between   '".$date_1."' and '".$date_2."' ) ";
		}else if(!empty($_POST["date_s"]) && empty($_POST["date_e"])){
		$seld .= "  AND (n_date  between   '".$date_1."' and '".$date_1."' ) ";
		}else if(empty($_POST["date_s"]) && !empty($_POST["date_e"])){
		$seld .= "  AND (n_date  between   '".$date_2."' and '".$date_2."' ) ";
		}
		$date_now = (date("Y")+543).'-'.date('m-d H:i:s');
		
		$glo_sql = " ( c_id = '".$_GET["cid"]."' ";
		if($U["c_show_subnew"] == "Y"){
			
			function tochild($cid){
			 global $db;
			 global $glo_sql;
				$sqlc = $db->query("SELECT c_id FROM article_group WHERE c_parent = '".$cid."' ");
				while($cr = $db->db_fetch_row($sqlc)){
					$glo_sql .= " OR c_id = '".$cr[0]."' ";
					tochild($cr[0]);
				}
			 }
		tochild($_GET["cid"]);
		
		}
		if($U["c_type"]=='M'){
			function tomultigroup1($cid){
			 global $db;
			 global $glo_sql;
				$sqlc = $db->query("SELECT multi_cid FROM article_multigroup WHERE c_id = '".$cid."' ");
				while($cr = $db->db_fetch_row($sqlc)){
					$glo_sql .= " OR c_id = '".$cr[0]."' ";
				}
			 }
		tomultigroup1($_GET["cid"]);
		}
			
		$glo_sql .= " ) ";
		if($lang_shw != ''){
		$sql_query = "SELECT * FROM article_list,lang_article_list ,lang_config $wh WHERE article_list.n_id = lang_article_list.c_id AND lang_config.lang_config_id = lang_article_list.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."'  AND lang_article_list.lang_field = 'n_topic' AND article_list.c_id = '".$_GET["cid"]."' AND n_approve = 'Y' and (('$date_now' between n_date_start  and n_date_end) or (n_date_start = '' and n_date_end = '')) $seld GROUP BY lang_article_list.c_id ORDER BY n_date DESC,n_timestamp DESC ";
		}else{
		$sql_query = "SELECT * FROM article_list $wh WHERE  ".$glo_sql." AND n_approve = 'Y' AND (('$date_now' between n_date_start  and n_date_end) or (n_date_start = '' and n_date_end = '')) $seld ORDER BY n_date DESC,n_timestamp DESC ";
		}
		$sql_article = $sql_query." LIMIT $offset,$limit ";	
		//echo $sql_article;
		  $sql_article = $db->query($sql_article);
		  

		  ?>
		  <table width="95%" border="0" align="center" cellpadding="5" cellspacing="0" style="display:none">
          <tr>
            <td><span  style="FONT: 12px 'Tahoma';"><a href="index.php"  style="FONT: 12px 'Tahoma';" accesskey=<?php echo $db->genaccesskey();?>>หน้าหลัก</a> >><a href="more_news.php?cid=<?php echo $U[c_id]; ?>&amp;filename=index"  style="FONT: 12px 'Tahoma';" accesskey=<?php echo $db->genaccesskey();?>> <?php echo $U[c_name]; ?></a> <?php if($U[c_rss] == "Y"){ ?><a href="rss/group<?php echo $U[c_id]; ?>.xml" target="_blank" accesskey=<?php echo $db->genaccesskey();?>><img src="mainpic/ico_rss.gif" alt="RSS"  border="0" ></a><?php } ?></span>
</td>
          </tr>
		  </table>
		  
		  <table width="95%" border="0" align="center" cellpadding="8" cellspacing="1">
		<tr>
          <td  class="text_normal"> <div><h3><?php echo findparent($U["c_parent"]); ?></h3><hr size="1"></div>
            <h1><?php echo $U["c_name"]; ?>
            <?php if($U[c_rss] == "Y"){ ?>
            <a href="../rss/group<?php echo $U[c_id]; ?>.xml" target="_blank" accesskey=<?php echo $db->genaccesskey();?>><img src="../mainpic/ico_rss.gif"  border="0" alt="RSS"></a> 
            <?php } ?> </h1></td>
        </tr>
		<?php
		 if($U[c_show_sub] == "Y"){ ?>
			<tr>
          <td> <?php
		  if($lang_shw != ''){

		  $sql_sub =$db->query("select * from  article_group,lang_article_group,lang_config where lang_article_group.c_id =article_group.c_id  AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_parent = '".$_GET[cid]."'");
	  }else{	
			$sql_sub = $db->query("SELECT * FROM article_group WHERE c_parent = '".$U[c_id]."' ");
			}
			if($db->db_num_rows($sql_sub)){
			?>
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
			  <tr>
				<td  class="text_head"><hr size="1">
                  <em><h3><?php echo $text_genarticle_textsubcat ;?></h3></em></td>
			  </tr>
			  			<?php
			while($S = $db->db_fetch_array($sql_sub)){
						if($lang_shw != ''){
						$S[c_name] = $S[lang_detail];
						}
				if(chk_permission_article($S["c_id"]) == true){
				echo '<tr><td>&nbsp;&nbsp;<h3><a href = "more_news.php?cid='.$S["c_id"].'&amp;filename='.$filename.'"><img src="../mainpic/folder_closed.gif" width="16" height="16" border="0" alt="หมวดย่อย"> <span  class="text_head">'.$S[c_name]."</span></a></h3></td></tr>";
				}
			}
			?>
			</table>
			<?php
			}
			?>
			<hr size="1"></td>
        </tr>
		<?php  
		}
		 $rows = mysql_num_rows($db->query($sql_query));
		  $nu = $rows-$offset;
		while($A = $db->db_fetch_array($sql_article)){
						$date = explode("-",$A["n_date"]);
						$date =  number_format($date[2],0)." ".$monthname[number_format($date[1],0)]." ".$date[0];
						if($lang_shw != ''){
						$A["n_topic"] = $A[lang_detail];
						$date = explode("-",$A["n_date"]);
						$date =  number_format($date[2],0)."/".number_format($date[1],0)."/".($date[0]-543);
						}
							
?><tr>
          <td>
		  <table width="100%" border="0" cellspacing="0" cellpadding="1">
              <tr> 
                <td width="5" valign="top"> 
                  <?php
	if($U["c_show_pic"] != ""){
		if($U["c_show_pic"] ==  "@detail_news#"){
			if(($A[picture] != "") AND (file_exists("images/article/news".$A[n_id]."/t".$A[picture]))){
				?>
                  <table width="80" height="80" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#999999">
                    <tr> 
                      <td align="center" valign="middle" bgcolor="#FFFFFF"><?php
					  if($A["news_use"] == "2"){
								echo "<a href=\"ewt_news.php?nid=".$A["n_id"]."&amp;filename=".$filename."\" target=\"".$A["target"]."\" accesskey=".$db->genaccesskey().">";
							}elseif($A["news_use"] == "4"){
								echo "<a href=\"ewt_dl.php?nid=".$A["n_id"]."\" target=\"".$A["target"]."\" accesskey=".$db->genaccesskey().">";
							}else{
								if($lang_shw != ''){
								$A["link_html"] = select_lang_detail($A["n_id"],$lang_shw,'link_html','article_list');
								}
								echo "<a href=\"../".$A["link_html"]."\" target=\"".$A["target"]."\" accesskey=".$db->genaccesskey().">";
							}
					  ?><img src="phpThumb.php?src=<?php echo "images/article/news".$A[n_id]."/t".$A[picture]; ?>&h=80&w=80" border="0" hspace="0" vspace="0" ></a></td>
                    </tr>
                  </table>
                  <?php
			}
		}else{
			if(file_exists($U["c_show_pic"])){ ?>
                  <img src="<?php echo $U["c_show_pic"]; ?>" > 
                <?php }
		}
	}
	?>                </td>
                <td valign="top"> 
                  <?php if($A["news_use"] == "2"){
								echo "<a href=\"ewt_news.php?nid=".$A["n_id"]."&amp;filename=".$filename."\" target=\"".$A["target"]."\" accesskey=".$db->genaccesskey()."><h2>";
							}elseif($A["news_use"] == "4"){
								echo "<a href=\"ewt_dl.php?nid=".$A["n_id"]."\" target=\"".$A["target"]."\" accesskey=".$db->genaccesskey()."><h2>";
							}else{
								if($lang_shw != ''){
								$A["link_html"] = select_lang_detail($A["n_id"],$lang_shw,'link_html','article_list');
								}
								//echo "<a href=\"../".$A["link_html"]."\" target=\"".$A["target"]."\"><b>";
								echo "<a href=\"ewt_dl_link.php?nid=".$A["n_id"]."\" target=\"".$A["target"]."\" accesskey=".$db->genaccesskey()."><h2>";
								if($show_file_type == 'Y'){
									$type_file = explode('.',$A["link_html"]);
									if(strtolower($type_file[1]) == 'doc'){echo "<img src=\"mainpic/file_type/doc.gif\"  border=\"0\">";
									}else if(strtolower($type_file[1]) == 'pdf'){echo "<img src=\"mainpic/file_type/pdf.gif\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'txt'){echo "<img src=\"mainpic/file_type/txt.gif\"  border=\"0\">";
									}else if(strtolower($type_file[1]) == 'xls'){echo "<img src=\"mainpic/file_type/excel.gif\"  border=\"0\">";
									}else if(strtolower($type_file[1]) == 'ppt'){echo "<img src=\"mainpic/file_type/ppt.gif\"  border=\"0\">";
									}else if(strtolower($type_file[1]) == 'zip'){echo "<img src=\"mainpic/file_type/winzip.gif\"  border=\"0\">";}
								}
							}
						
						echo "<span class=\"text_normal\">".str_replace("’","",str_replace("”","",str_replace("“"," ",$A["n_topic"])))."</span>";
						echo "</h2></a>    "; 
						 if($U["c_show_date"] == 'C'){ echo  " <span class=\"text_normal\">(".$date.")</span>"; }
						?>
                  <?php
						if($_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_MID"] == $A["n_owner"]){
						echo " [<a href=\"#edit\" onClick=\"wina=window.open('ewt_article.php?N=".base64_encode($A[n_id])."','articleedit','width=400,height=300,scrollbars=1');wina.focus();\">แก้ไข</a>]";
						}
						?>
                  <?php if($U["c_show_date"] == "N"){?>
                <div class="text_normal"><?php echo  $date." ".$A["n_time"]; ?></div><? }?>
                <?php if($U["c_show_detail"] == "Y"){?>
                <div class="text_normal"><?php echo  $A[n_des]; ?></div><? }?>
				<?php if($A["show_count"] == '1'){ ?><div class="text_normal"><?php  echo 'อ่าน  '.count_articlr($A["n_id"]).'   ครั้ง';?></div><?php }
				if($A["show_count"] == '2'){ ?><div class="text_normal"><?php  echo 'ดาวน์โหลด  '.count_articlr($A["n_id"]).'   ครั้ง';?></div><?php }?></td>
              </tr>
            </table>		</td></tr><?php $nu--; } ?>
		
		<tr>
        <td height="44" colspan="2" class="text_normal">
		<?php if($rows > 0){ ?>
<hr size="1">
<?php echo $text_general_page;?> :    <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='more_news.php?offset=$prevoffset&amp;cid=$cid&amp;filename=$filename' accesskey=".$db->genaccesskey().">
<font  color=\"red\"><< $text_general_previous</font></a>\n\n";
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
            echo "<font color=\"blue\">[$i]</font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  " <a href='more_news.php?offset=$newoffset&amp;cid=$cid&amp;filename=$filename' ". 
                  "onMouseOver=\"window.status='Page $i'; return true;\" accesskey=".$db->genaccesskey().">$i</a> \n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href='more_news.php?offset=$newoffset&amp;cid=$cid&amp;filename=$filename'>
		  <font color=\"red\" accesskey=".$db->genaccesskey().">$text_general_next>></font></a> "; 
    }
	}
?></td>
        </tr>
      </table>

<? }else{
?>
	<script language="javascript1.2" type="text/javascript">
	alert("ท่านไม่สามารถอ่านข่าว/บทความนี้ได้เนื่องจากมีการกำหนดสิทธิ์การเข้าใช้");
	window.location.href="<?php echo $RR["link_html"]; ?>";	
	</script>
	<?php
		exit;
}?>
<?php 
	if($temp_html == 'w3c'){
	$logo = file_get_contents("bottom_401.html"); 
	}
	if($temp_wai == 'w3c'){
	$logo .= file_get_contents("bottom_wcag.html"); 
	}
	if($temp_css == 'w3c'){
	$logo .= file_get_contents("bottom_css.html"); 
	}
 echo eregi_replace("#htmlw3c_spliter#",$logo,$template_design[1]); ?>
<?php $db->db_close(); ?>