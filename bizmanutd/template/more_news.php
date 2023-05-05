<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//===========================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($cid){
		$cid  = checkNumeric($cid);
	}
	if($_GET[cid]){
		$_GET[cid]  = checkNumeric($_GET[cid]);
	}
	if($_POST[cid]){
		$_POST[cid]  = checkNumeric($_POST[cid]);
	}
	
	if($offset){
		$offset = checkNumeric($offset);
	}
	if($_GET["offset"]){
		$_GET["offset"] = checkNumeric($_GET["offset"]);
	}
	if($_POST["offset"]){
		$_POST["offset"] = checkNumeric($_POST["offset"]);
	}
	/*	foreach ($_GET as $key => $value) {
		$_GET[$key]=addslashes(strip_tags(trim($value)));
	}//foreach
	if ($_GET['cid'] !='') { 
		$_GET['cid'] = (int) $_GET['cid']; 
		}//if
	
	extract($_GET);*/
	//===========================================================
	
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

if($_GET["filename"] != ""){
	$sql_index = $db->query("SELECT template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
	$XX = $db->db_fetch_array($sql_index);
	$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '$XX[0]'  ");
}else{
	$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
}
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
if($_GET["filename"] == ''){
$_GET["filename"] = 'index';
}
$lang_sh1 = explode('___',$_GET["filename"]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
//$page = 'news';
include("ewt_function.php");
if($use_template != ""){
$d_idtemp =$use_template;
}	

$global_theme = $R["d_bottom_content"];
$mainwidth = "0";

	 $sql_group ="select * from  article_group where c_id = '".$_GET["cid"]."'";

	 $query_group = $db->query($sql_group);
	 $U = $db->db_fetch_array($query_group);
	  if($lang_shw != ''){	
	  $lang_detail = array();
	   $sql_group2 ="select * from  article_group,lang_article_group,lang_config where lang_article_group.c_id =article_group.c_id AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_id = '".$_GET["cid"]."'";
	   $query_group2 = $db->query($sql_group2);
	 while($U2 = $db->db_fetch_array($query_group2)){
	 array_push($lang_detail,$U2[lang_detail]);
	 }
	$U[c_name] = $lang_detail[0];
	$U[d_id] = $lang_detail[1];
	
	 }
	 if($U[d_id] != "" AND $U[d_id] != "0"){
	 $d_idtemp = $U[d_id];
	 }
	 $temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);
$design_id = $R["d_id"];
	 function findparent($id){
	 global $db;
	 global $filename;
	 global $lang_shw;
	 if($lang_shw != ''){
	 $sql =$db->query("select * from  article_group,lang_article_group,lang_config where lang_article_group.c_id =article_group.c_id AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_id = '".$id."' and lang_field = 'c_name'");
	  }else{
	 $sql = $db->query("SELECT * FROM article_group WHERE c_id = '$id' ");
	 }
	 	if($db->db_num_rows($sql)){
	 		$G = $db->db_fetch_array($sql);
			 if($lang_shw != ''){	
			 $G[c_name] = $G[lang_detail];
			 }
			$txt = " <a href = \"more_news.php?cid=".$G["c_id"]."&filename=".$filename."\"><span style=\"FONT: 12px 'Tahoma';\">".$G["c_name"]."</span></a> &gt;&gt; ";
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
<html>
<head>
<title><?php echo $U["c_name"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($R["d_site_bg_c"] != ""){ echo "bgcolor=\"".$R["d_site_bg_c"]."\""; } ?> <?php if($R["d_site_bg_p"] != ""){ echo "background=\"".$R["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $R["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $R["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $R["d_top_height"]; ?>" bgcolor="<?php echo $R["d_top_bg_c"]; ?>" background="<?php echo $R["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $R["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $R["d_site_left"]; ?>" bgcolor="<?php echo $R["d_left_bg_c"]; ?>" background="<?php echo $R["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $R["d_site_content"]; ?>" bgcolor="<?php echo $R["d_body_bg_c"]; ?>" height="160" background="<?php echo $R["d_body_bg_p"]; ?>">
	<?php
			$mainwidth = $R["d_site_content"];
			?><?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		<?php } ?>
	  <?php
	  
 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
	//=================== ป้องกันช่องโหว่===========================
		if (!is_numeric($offset)) {
			exit;
		}
	//=======================================================
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
            <td><span  style="FONT: 12px 'Tahoma';"><a href="index.php"  style="FONT: 12px 'Tahoma';">หน้าหลัก</a> >><a href="more_news.php?cid=<?php echo $U[c_id]; ?>&filename=index"  style="FONT: 12px 'Tahoma';"> <?php echo $U[c_name]; ?></a> <?php if($U[c_rss] == "Y"){ ?><a href="rss/group<?php echo $U[c_id]; ?>.xml" target="_blank"><img src="mainpic/ico_rss.gif"  border="0" align="absmiddle"></a><?php } ?></span>
</td>
          </tr>
		  </table>
      <table width="95%" border="0" align="center" cellpadding="8" cellspacing="1">
	  <?php if($U[c_show_search] == "Y" ){ ?>
        <tr><form name="form1" method="get" action="search_result.php">
          <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td align="right" class="text_normal"><?php echo $text_Gencalendar_textdatestart;?> :
                  <input name="date_s" type="text"  style="FONT: 11px 'Tahoma';" value="" size="10"><a href="#show" onClick="return showCalendar('date_s', 'dd-mm-y');"><img src="mainpic/b_calendar.gif"  border=0 align="absmiddle"></a> <?php echo $text_Gencalendar_textdateend;?> :
                <input name="date_e" type="text"  style="FONT: 11px 'Tahoma';" value="" size="10"><a href="#show" onClick="return showCalendar('date_e', 'dd-mm-y');"><img src="mainpic/b_calendar.gif" border=0 align="absmiddle"></a> <br>
                <?php echo $text_general_search;?> :
                <input name="keyword" type="text"  style="FONT: 11px 'Tahoma';" value="" size="35">
                  <input type="submit" name="Submit" value="<?php echo $text_general_search;?>"  style="FONT: 11px 'Tahoma';">
                <input name="search_mode" type="hidden" value="2">
                <br>
                  <input name="g" type="radio" value="<?php echo trim($U[c_id]); ?>" checked>
                  <?php echo $text_genarticle_textchoice1.trim($U[c_name]); ?>
                  <input name="g" type="radio" value="">
                  <?php echo $text_genarticle_textchoice2;?>
                  <input name="filename" type="hidden" value="<?php echo $_REQUEST["filename"]; ?>"></td>
            </tr>
          </table></td>
        </form>
        </tr>
		<?php } ?>
		<tr>
          <td  class="text_normal"> <div><?php echo findparent($U["c_parent"]); ?><hr size="1"></div>
            <span style="FONT: 17px 'Tahoma';"><?php echo $U["c_name"]; ?></span> 
            <?php if($U[c_rss] == "Y"){ ?>
            <a href="rss/group<?php echo $U[c_id]; ?>.xml" target="_blank"><img src="mainpic/ico_rss.gif"  border="0" align="absmiddle"></a> 
            <?php } ?>          </td>
        </tr>
		<?php
		 if($U[c_show_sub] == "Y"){ ?>
			<tr>
          <td> <?php
		  if($lang_shw != ''){

		  $sql_sub =$db->query("select * from  article_group,lang_article_group,lang_config where lang_article_group.c_id =article_group.c_id  AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_parent = '".$_GET[cid]."' and lang_field = 'c_name'");
	  }else{	
			$sql_sub = $db->query("SELECT * FROM article_group WHERE c_parent = '".$U[c_id]."' ");
			}
			if($db->db_num_rows($sql_sub)){
			?>
			<table width="100%" border="0" cellpadding="3" cellspacing="0">
			  <tr>
				<td  class="text_head"><hr size="1">
                  <em><?php echo $text_genarticle_textsubcat ;?></em></td>
			  </tr>
			  			<?php
			while($S = $db->db_fetch_array($sql_sub)){
						if($lang_shw != ''){
						$S[c_name] = $S[lang_detail];
						}
				if(chk_permission_article($S["c_id"]) == true){
				echo '<tr><td>&nbsp;&nbsp;<a href = "more_news.php?cid='.$S["c_id"].'&filename='.$filename.'"><img src="mainpic/folder_closed.gif" width="16" height="16" align="absmiddle" border=0> <span  class="text_head">'.$S[c_name]."</span></a></td></tr>";
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
					  if($A["news_use"] == "2" || $A["news_use"] == "3"){
								echo "<a href=\"ewt_news.php?nid=".$A["n_id"]."&filename=".$filename."\" target=\"".$A["target"]."\">";
							}elseif($A["news_use"] == "4"){
								echo "<a href=\"ewt_dl.php?nid=".$A["n_id"]."\" target=\"".$A["target"]."\">";
							}else{
								if($lang_shw != ''){
								$A["link_html"] = select_lang_detail($A["n_id"],$lang_shw,'link_html','article_list');
								}
								echo "<a href=\"".$A["link_html"]."\" target=\"".$A["target"]."\">";
							}
					  ?><img src="phpThumb.php?src=<?php echo "images/article/news".$A[n_id]."/t".$A[picture]; ?>&h=80&w=80" border="0" hspace="0" vspace="0" ></a></td>
                    </tr>
                  </table>
                  <?php
			}
		}else{
			if(file_exists($U["c_show_pic"])){ ?>
                  <img src="<?php echo $U["c_show_pic"]; ?>" align="absmiddle" > 
                <?php }
		}
	}
	?>                </td>
                <td valign="top"> 
                  <?php if($A["news_use"] == "2" || $A["news_use"] == "3"){
								echo "<a href=\"ewt_news.php?nid=".$A["n_id"]."&filename=".$filename."\" target=\"".$A["target"]."\"><b>";
							}elseif($A["news_use"] == "4"){
								echo "<a href=\"ewt_dl.php?nid=".$A["n_id"]."\" target=\"".$A["target"]."\"><b>";
							}else{
								if($lang_shw != ''){
								$A["link_html"] = select_lang_detail($A["n_id"],$lang_shw,'link_html','article_list');
								}
								//echo "<a href=\"".$A["link_html"]."\" target=\"".$A["target"]."\"><b>";
								echo "<a href=\"ewt_dl_link.php?nid=".$A["n_id"]."\" target=\"".$A["target"]."\"><b>";
								if($show_file_type == 'Y'){
									$type_file = explode('.',$A["link_html"]);
									if(strtolower($type_file[1]) == 'doc'){echo "<img src=\"mainpic/file_type/doc.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'pdf'){echo "<img src=\"mainpic/file_type/pdf.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'txt'){echo "<img src=\"mainpic/file_type/txt.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'xls'){echo "<img src=\"mainpic/file_type/excel.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'ppt'){echo "<img src=\"mainpic/file_type/ppt.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'zip'){echo "<img src=\"mainpic/file_type/winzip.gif\" align=\"absmiddle\" border=\"0\">";}
								}
							}
						
						echo "<span class=\"text_head\">".$A["n_topic"]."</span>";
						echo "</b></a>    "; 
						$date_exp = eregi_replace("-","",$A["expire"]);
						$date_now1 = (date("Y")+543).date("md");
						if(file_exists("icon/".$A["logo"]) and $A["logo"] != '' and $date_exp >= $date_now1  ){
						echo " <img  src=\"icon/".$A["logo"]."\"   align=\"absmiddle\" border=0>"; 
						}
						 if($U["c_show_date"] == 'C'){ echo  " <span class=\"text_normal\">(".$date.")</span>"; }
						?>
                  <?php
						if($_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_MID"] == $A["n_owner"]){
						echo " [<a href=\"#edit\" onClick=\"wina=window.open('ewt_article.php?N=".base64_encode($A[n_id])."','articleedit','width=400,height=300,scrollbars=1');wina.focus();\">แก้ไข</a>]";
						}
						?>
                  <?php if($U["c_show_date"] == "N"){?>
                <div class="text_normal"><?php echo  $date." ".$A["n_time"]; ?></div><?php }?>
                <?php if($U["c_show_detail"] == "Y"){?>
                <div class="text_normal"><?php echo  $A[n_des]; ?></div><?php }?>
				<?php if($A["show_count"] == '1'){ ?><div class="text_normal"><?php  echo 'อ่าน  '.count_articlr($A["n_id"]).'   ครั้ง';?></div><?php }
				if($A["show_count"] == '2'){ ?><div class="text_normal"><?php  echo 'ดาวน์โหลด  '.count_articlr($A["n_id"]).'   ครั้ง';?></div><?php }
				if($A["show_count"] == '3'){ ?><div class="text_normal"><?php  echo 'ดาวน์โหลด  '.count_articlr($A["n_id"]).'   ครั้ง';?></div><?php }?></td>
              </tr>
            </table>		</td></tr><?php $nu--; } ?>
		
		<tr>
        <td height="44" colspan="2" class="text_normal">
		<?php if($rows > 0){ ?>
<hr size="1">
<?php echo $text_general_page;?> :    <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($_GET[offset] !=0) {   
$prevoffset=$_GET[offset]-$limit; 
echo   "<a href='more_news.php?offset=$prevoffset&cid=$_GET[cid]&filename=$_GET[filename]'>
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
        if (($_GET[offset]/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font color=\"blue\">[$i]</font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  " <a href='more_news.php?offset=$newoffset&cid=$_GET[cid]&filename=$_GET[filename]' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";>$i</a> \n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($_GET[offset]/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href='more_news.php?offset=$newoffset&cid=$_GET[cid]&filename=$_GET[filename]'>
		  <font color=\"red\">$text_general_next>></font></a> "; 
    }
	}
?></td>
        </tr>
      </table>
      </td>
          <td id="ewt_main_structure_right" width="<?php echo $R["d_site_right"]; ?>" bgcolor="<?php echo $R["d_right_bg_c"]; ?>" background="<?php echo $R["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $R["d_bottom_height"]; ?>" bgcolor="<?php echo $R["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $R["d_bottom_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
      </table>

</body>
</html>
<?php }else{
?>
	<script language="javascript">
	alert("ท่านไม่สามารถอ่านข่าว/บทความนี้ได้เนื่องจากมีการกำหนดสิทธิ์การเข้าใช้");
	window.location.href="<?php echo $RR["link_html"]; ?>";	
	</script>
	<?php
		exit;
}?>
<?php $db->db_close(); ?>
