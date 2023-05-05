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
	
	$db->access=200;
function datetime($str){
  $y=substr($str,0,4);
  $m=substr($str,4,2);
  $d=substr($str,6,2);
  $h=substr($str,8,2);
  $i=substr($str,10,2);
  $s=substr($str,12,2);
  
  $str=" [$d/$m/$y - $h:$i:$s]";
  if(trim($str)=="[// - ::]"){ return ''; }else{ return  $str;}
}
function lang_detail($c_id,$lang_name,$lang_field,$module){
global $db;
$tb = "lang_".$module;
///echo "select lang_detail from $tb where c_id = '".$c_id."' and lang_name = '".$lang_name."' and lang_field = '".$lang_field."'";
	$sql = $db->query("select lang_detail from $tb where c_id = '".$c_id."' and lang_name = '".$lang_name."' and lang_field = '".$lang_field."'");
	if($db->db_num_rows($sql)>0){
	$rec = $db->db_fetch_array($sql);
		if($lang_field == 'n_date' && $rec["lang_detail"] != ''){ 
		$date = explode("-",$rec["lang_detail"]); 
		$rec[lang_detail] = date ("d M Y",mktime(0,0,0,$date[1],$date[2],$date[0]));
		}
		return $rec[lang_detail];
	}
}


$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'W'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
include("ewt_template_ewt_news.php");
if($lang_sh != ''){
				$dfg = explode('_',$lang_sh);
				$lang_shw = $dfg[1];
				$lang_sh = $lang_sh;
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("../language/language".$lang_sh.".php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
$sql_lang_comfig = $db->db_fetch_array($db->query("select lang_config_id from lang_config where lang_config_suffix = '$lang_shw' "));
$lang_config_id = $sql_lang_comfig[lang_config_id];

if($lang_shw != ''){
$sql_article = $db->query("SELECT *,article_list.c_id AS CID FROM article_list,lang_article_list ,lang_config WHERE article_list.n_id = lang_article_list.c_id AND lang_config.lang_config_id = lang_article_list.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."'  AND lang_article_list.lang_field = 'n_topic' AND n_id = '".$_GET["nid"]."'");
}else{
$sql_article = $db->query("SELECT * FROM article_list WHERE n_id = '".$_GET["nid"]."'");
}
$RR= $db->db_fetch_array($sql_article);
	if($RR["html"] == 'Y'){
	$logo = file_get_contents("bottom_401.html"); 
	}
	if($RR["wcag"] == 'Y'){
	$logo .= file_get_contents("bottom_wcag.html"); 
	}
	if($RR["css"] == 'Y'){
	$logo .= file_get_contents("bottom_css.html"); 
	}
	if($RR["news_use"] == "1"){
									if(eregi('http://',$RR["link_html"]) || eregi('mailto:',$RR["link_html"])){
									 $txt = $RR["link_html"];
									 }else{
									$txt = "../".$RR["link_html"];
									}
	?>
	<script type="text/javascript"  language="javascript">
	window.location.href="<?php echo $txt; ?>";	
	</script>
	<?php
		exit;
	}
	if($RR["news_use"] == "4"){
	?>
	<script type="text/javascript"  language="javascript">
	window.location.href="ewt_dl.php?nid=<?php echo $_GET["nid"]; ?>";	
	</script>
	<?php
		exit;
	}

$date_txt = 'วันที่';
$date = explode("-",$RR["n_date"]);
$date =  number_format($date[2],0)." ".$monthname[number_format($date[1],0)]." ".$date[0];
if($lang_shw != ''){
$RR[c_id] = $RR["CID"];
$RR[n_topic] = $RR[lang_detail];
$date_txt = 'Date ';
$date = explode("-",$RR["n_date"]);
$did = lang_detail($_GET["nid"],$RR[lang_config_id],'d_id','article_list');
if($did != ""){
$RR["d_id"] = $did;
}

$date =  number_format($date[2],0)."/".number_format($date[1],0)."/".($date[0]-543);
}

$nid = $_GET["nid"];

$sql_rude="SELECT * FROM vulgar_table ";
$query_rude=$db->query($sql_rude);
while($data = $db->db_fetch_array($query_rude)){ 
	 $array_rude[]=$data[vulgar_text];
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
function cencer_rude($str){
		global  $array_rude;
		for($i=0;$i<sizeof($array_rude);$i++){
				$str=ereg_replace($array_rude[$i],'***',$str);
				//str_replace($array_rude[$i],$str
		}
		return  $str;
}

if(chk_permission_article($RR["c_id"]) == true){

$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");
?>
<?php echo $template_design[0];?>
 	<?php if($RR[show_textsize] == "1"){ ?>
	<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0>
<TBODY>
<TR>
<TD align=right>
<TABLE cellSpacing=1 cellPadding=6 width=120  border=0>
<TBODY>
<TR>
<TD style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #555555; FONT-FAMILY: Tahoma; TEXT-DECORATION: none" >FONTSIZE <A onClick="changeStyle('small');" href="#size"><IMG height=10 src="../mainpic/s.gif" width=10 border=0 alt="small"></A> <A onClick="changeStyle('normal');" href="#size"><IMG height=10 src="../mainpic/n.gif" width=10 border=0 alt="normal"></A> <A onClick="changeStyle('big');" href="#size"><IMG height=10 src="../mainpic/b.gif" width=10 border=0 alt="big"></A> </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
      <?php
	  		}
			$mainwidth = $R["d_site_content"];
	  if($lang_shw != ''){
	  $sql_group ="select * from  article_group,lang_article_group,lang_config where lang_article_group.c_id =article_group.c_id AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_id = '".$RR[c_id]."'";
	  }else{
	 $sql_group ="select * from  article_group where c_id = '".$RR[c_id]."'";
	 }
	 $query_group = $db->query($sql_group);
	 $U = $db->db_fetch_array($query_group);
	 if($lang_shw != ''){
	$U[c_name] = $U[lang_detail];
	}
	 ?>
	     <table width="99%" border="0" cellpadding="5" cellspacing="0" >
		 <?php 	if($RR[show_group] == '1'){ ?>
          <tr>
            <td class="text_normal"><h3><?php echo findparent($U["c_parent"]); ?> <a href="more_news.php?cid=<?php echo $RR[c_id]; ?>&amp;filename=<?php echo $filename;?>"   accesskey=<?php echo $db->genaccesskey();?>> <?php echo $U[c_name]; ?></a> <?php if($U[c_rss] == "Y"){ ?><a href="../rss/group<?php echo $U[c_id]; ?>.xml" target="_blank" accesskey=<?php echo $db->genaccesskey();?>><img src="../mainpic/ico_rss.gif" alt="RSS"  border="0" ></a><?php } ?></h3>
</td>
          </tr>
		  <?php } ?>
		    <?php 	if($U[c_show_all] == 'Y'){ 
			  if($lang_shw != ''){
			 $sql_show_all_list =$db->query("select n_id,n_topic,lang_detail from article_list,lang_article_list,lang_config 
where lang_article_list.c_id =article_list.n_id AND lang_config.lang_config_id = lang_article_list.lang_name  AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_list.c_id = '".$RR[c_id]."' AND article_list.n_approve = 'Y' GROUP BY article_list.n_id ORDER BY article_list.n_id DESC");
			  }else{
		  $sql_show_all_list = $db->query("SELECT n_id,n_topic FROM article_list WHERE c_id = '$RR[c_id]' AND n_approve = 'Y' ORDER BY n_id DESC");
		  }
		  ?>
                  <tr>
            <td  class="text_normal">
			<?php
			while($AL = $db->db_fetch_array($sql_show_all_list)){
			if($lang_shw != ''){
			$AL[n_topic] = $AL[lang_detail];
			}
				echo " [ ";
				if($_GET["nid"] != $AL[n_id]){ ?>
				<a href="ewt_news.php?nid=<?php echo $AL[n_id]; ?>&amp;filename=<?php echo $_GET["filename"]; ?>" accesskey=<?php echo $db->genaccesskey();?>>
				<?php
				}
			
				echo $AL[n_topic];
				if($_GET["nid"] != $AL[n_id]){ ?>
				</a>
				<?php
				}
				echo " ] ";
			}
			?><hr></td>
          </tr>
			<?php } ?><tr>
            <td class="text_head">
		  <?php 	if($RR[show_topic] == '1'){ ?>
                <h1><?php echo str_replace("’","",str_replace("”","",str_replace("“"," ",$RR["n_topic"]))); ?></h1><hr>
			<?php } ?>
			<?php 	if($RR[show_date] == '1'){ ?>
			<?php echo $date_txt;?> <?php echo $date ; ?> <?php echo $RR["n_time"]; ?>
			<?php } ?>
			<br><?php echo $text_genarticle_textsource;?><?php if($RR["sourceLink"] ==''){echo $RR["source"];}else{ ?><a href="<?php echo $RR["sourceLink"];?>" target="_blank" accesskey=<?php echo $db->genaccesskey();?>><?php echo $RR["source"]; ?></a><? } ?>
</td>
          </tr>
	  </table>
	  <?php
	//  echo "SELECT * FROM article_template WHERE at_id = '$RR[at_id]'";
	$sql_t = $db->query("SELECT * FROM article_template WHERE at_id = '$RR[at_id]'");
	$A = $db->db_fetch_array($sql_t);
	
	@include("article_template/".$A["at_use"]);
//echo "article_template/".$A["at_use"];
$news_id = $_GET["nid"];	  
					if($_SERVER["REMOTE_ADDR"]){
						$ip_view = $_SERVER["REMOTE_ADDR"];
					}else{
						$ip_view = $_SERVER["REMOTE_HOST"];
					}
	$date_view = date("Y-m-d");
	$time_view = date("h:i:s");

		//cese shere from site other
		if($RR[n_shareuse] =='Y'){
		$db->query("USE ".$EWT_DB_USER);
		$sql_A = "select db_db from user_info where EWT_User ='".$RR[n_sharename]."'";
		$query_A = $db->query($sql_A);
		$N = $db->db_fetch_array($query_A);
		$db_name_parent = $N[db_db];
		//file parent id
		$sql_parent_id = "select user_t from share_article where share_article.sg_id='".$RR[n_shareid]."'";
		$query_parent_id = $db->query($sql_parent_id);
		$R_parent_id = $db->db_fetch_array($query_parent_id);
		$db->query("USE ".$EWT_DB_NAME);
		}
	############ บันทึกข้อมูล ผู้ที่ทำการ vote #############
	if ($vote_status != "" && !session_is_registered("newsvote".$news_id)) {	
	 	$point = $vote_status;
		$sql_vote = "INSERT INTO news_vote (news_id,ip_vote,point) VALUE ('$news_id','$ip_view','$point')";
		$query_vote = mysql_query($sql_vote);			
		session_register("newsvote".$news_id);
		unset($vote_status);		
		$db->query("update  article_list set n_last_modi='".date('YmdHis')."' where n_id = '$news_id' ");
		//cese shere from site other to parent
		if($RR[n_shareuse] =='Y'){
		$db->query("USE ".$db_name_parent);
		$sql_vote = "INSERT INTO news_vote (news_id,ip_vote,point) VALUE ('".$R_parent_id[n_id]."','$ip_view','$point')";
		$query_vote = mysql_query($sql_vote);	
		$db->query("update  article_list set n_last_modi='".date('YmdHis')."' where n_id = '".$RR[n_shareid]."' ");
		$db->query("USE ".$EWT_DB_NAME);
		}
		//cese shere from site other to child
		if($RR[n_share] =='Y'){
			$db->query("USE ".$EWT_DB_USER);
			$sql_B = "select * from share_article where n_id ='".$news_id."' and user_s ='".$EWT_FOLDER_USER."' and s_status ='Y'";
			$query_B = $db->query($sql_B);
			while($RRR=$db->db_fetch_array($query_B)){
				$sql2 = "select db_db from user_info where EWT_User ='".$RRR[user_t]."'";
				$query2 = $db->query($sql2);
				$N = $db->db_fetch_array($query2);
				$db_name_parent = $N[db_db];
				$db->query("USE ".$db_name_parent);
				$sql_vote = "INSERT INTO news_vote (news_id,ip_vote,point) VALUE ('".$RRR[n_id_t]."','$ip_view','$point')";
				$query_vote = mysql_query($sql_vote);	
				$db->query("update  article_list set n_last_modi='".date('YmdHis')."' where n_id = '".$RRR[n_id_t]."' ");
			$db->query("USE ".$EWT_DB_USER);
			}
			$db->query("USE ".$EWT_DB_NAME);
		}
	}

	####### บันทึกข้อมูล ข้อมูลจำนวนคนเข้ามาอ่าน ###########
	if(!session_is_registered("newsvisit".$news_id)){
	$sql = "INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('$news_id','$ip_view','$date_view','$time_view','".$_SESSION["EWT_MID"]."') ";
	$query = mysql_query($sql);	
	//cese shere from site other to parent
		if($RR[n_shareuse] =='Y'){
		$db->query("USE ".$db_name_parent);
		$sql = "INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('".$R_parent_id[n_id]."','$ip_view','$date_view','$time_view','".$_SESSION["EWT_MID"]."') ";
	$query = mysql_query($sql);	
		$db->query("USE ".$EWT_DB_NAME);
		}
		//cese shere from site other to child
		if($RR[n_share] =='Y'){
			$db->query("USE ".$EWT_DB_USER);
			$sql = "select * from share_article where n_id ='".$news_id."' and user_s ='".$EWT_FOLDER_USER."' and s_status ='Y'";
			$query = $db->query($sql);
			while($RRR=$db->db_fetch_array($query)){
				$sql2 = "select db_db from user_info where EWT_User ='".$RRR[user_t]."'";
				$query2 = $db->query($sql2);
				$N = $db->db_fetch_array($query2);
				$db_name_parent = $N[db_db];
				$db->query("USE ".$db_name_parent);
				$sql = "INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('".$RRR[n_id_t]."','$ip_view','$date_view','$time_view','".$_SESSION["EWT_MID"]."') ";
				$query = mysql_query($sql);	
			$db->query("USE ".$EWT_DB_USER);
			}
			$db->query("USE ".$EWT_DB_NAME);
		}
	session_register("newsvisit".$news_id);
	}
	####### select ข้อมูลเพื่อดูจำนวนคนอ่าน ###############		
	$sql_view ="SELECT count(id_view) as count_view FROM news_view WHERE news_id LIKE '$news_id' ";
	$query_view = mysql_query($sql_view);
	$res_view = mysql_fetch_array($query_view);
	
	####### select ข้อมูลเพื่อดูจำนวนคน vote ###############		
	$sql_vote ="SELECT count(id_vote) as count_vote  FROM news_vote WHERE news_id LIKE '$news_id' ";
	$query_vote = mysql_query($sql_vote);
	$res_vote = mysql_fetch_array($query_vote);

	####### select ข้อมูลเพื่อดูสถานะการ vote ###############		
   $sql_status="SELECT point,count(id_vote) as count_vote  FROM news_vote where news_id='$news_id' GROUP BY point  order by point ";
   $query_status = mysql_query($sql_status);
   $rating=0;
   while($res_status=mysql_fetch_array($query_status)){
		  @$per_score[$res_status[point]]= number_format($res_status[count_vote]/$res_vote[count_vote]*100);
          $sum_score=$sum_score+$res_status[point]*$res_status[count_vote];
  }
 @$rating=$sum_score/$res_vote[count_vote];
if($RR[show_newstop] == '1'){
$show="111";
$dis0='';
$dis1='';
$dis2='';

if($show[0]=='0'){$dis0="style=\"display:none\" ";}
if($show[1]=='0'){$dis1="style=\"display:none\" ";}
if($show[2]=='0'){$dis2="style=\"display:none\" ";}

?>
      <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#999999"  class="text_head">
        <tr align="center" bgcolor="#CCCCCC" > 
          <td <?php echo $dis0?>align="center" ><h2><?php echo $text_Gennewstop5_hit ;?></h2></td>
          <td <?php echo $dis1?>align="center" ><h2><?php echo $text_Gennewstop5_vote;?></h2></td>
          <td <?php echo $dis2?>align="center" ><h2><?php echo $text_Gennewstop5_later;?></h2></td>
        </tr>
        <tr> 
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis0?>> 
            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1"   class="text_normal" bgcolor="#FFFFFF">

              <?php
					            $sql ="SELECT  news_view.news_id, count(news_view.id_view) AS count_view, article_list.n_topic
													FROM article_list  INNER JOIN news_view ON (article_list.n_id = news_view.news_id) WHERE article_list.c_id = '".$RR["c_id"]."' 
													GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc limit 0,5";
								$query = $db->query($sql);
                                $num = $db->db_num_rows($query);
								while($rs = $db->db_fetch_array($query)){
								$i++;
								?>
              <tr valign="top" bgcolor="#FFFFFF"> 
                <td width="16" align="left"><img src="../mainpic/news_bullet.gif" alt="news_bullet" width="16" height="16"  ></td>
                <td align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]?>" accesskey=<?php echo $db->genaccesskey();?>><?php echo  str_replace("’","",str_replace("”","",str_replace("“"," ",$rs[n_topic])));?></a></td>
              </tr>
              <?
								}
        ?>
            </table></td>
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis1?>> 
		  <?php
		    $sql ="SELECT sum(point)/count(news_id) as rating ,n_topic,news_id
											FROM  article_list  INNER JOIN news_vote ON (article_list.n_id = news_vote.news_id) WHERE article_list.c_id = '".$RR["c_id"]."' 
											GROUP BY  news_id
											ORDER BY rating DESC  limit 0,5";
								$query = $db->query($sql);
                                $num = $db->db_num_rows($query);
								if($num > 0){
		  ?>
            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text_normal"  bgcolor="#FFFFFF">
              <?php

					          
								$i=0;
								while($rs = $db->db_fetch_array($query)){
								$i++;
								?>
              <tr valign="top" bgcolor="#FFFFFF"> 
                <td width="16" align="left"><img src="../mainpic/news_bullet.gif" alt="news_bullet" width="16" height="16"  ></td>
                <td align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]?>"><?php echo  str_replace("’","",str_replace("”","",str_replace("“"," ",$rs[n_topic])));?></a></td>
              </tr>
              <?php
								}
        ?>
            </table><?php } ?></td>
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis2?>> 
            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text_normal"  bgcolor="#FFFFFF">
             
              <?php

					            $sql ="SELECT n_id,n_topic,n_new_modi,n_last_modi FROM  article_list WHERE article_list.c_id = '".$RR["c_id"]."'   ORDER BY  n_new_modi desc,n_last_modi desc limit 0,5";
								$query = $db->query($sql);
                                //$num = $db->db_num_rows($query);
								$i=0;
								while($rs = $db->db_fetch_array($query)){
								
								$i++;
								?>
              <tr align="left" valign="top" bgcolor="#FFFFFF"> 
                <td width="16" align="left"><img src="../mainpic/news_bullet.gif" alt="news_bullet" width="16" height="16"  ></td>
                <td><a href="ewt_news.php?nid=<?php echo $rs[n_id]?>"><?php echo str_replace("’","",str_replace("”","",str_replace("“"," ",$rs[n_topic])));?></a>                </td>
              </tr>
              <?
								}
        ?>
            </table></td>
        </tr>
      </table>
	  <?php }   if($RR[show_vote] == '1'){
	  ?>
      <form name="form1" method="post" action="">
        <table width="90%" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999" class="text_normal">
          <tr bgcolor="#CCCCCC"> 
            <td  class="text_head"><h2><? print $text_genarticle_numread." $res_view[count_view] คน";?></h2></td>
            <td align="right"   class="text_head"><h2><? print  $text_genarticle_numvote." $res_vote[count_vote] คน";?></h2></td>
          </tr>
          <tr> 
            <td width="50%" align="center" valign="top" bgcolor="#FFFFFF" ><table width="90%" border="0" align="center" cellpadding="6" cellspacing="1" class="text_normal">
                <tr> 
                  <td colspan="5" align="center"><? print $text_genarticle_votearticle;?></td>
                </tr>
                <tr> 
                  <td align="center"><input name="vote_status" type="radio" value="1" alt="<? print $text_genarticle_votearticle;?>ให้1คะแนน">
                    1</td>
                  <td align="center"><input name="vote_status" type="radio" value="2" alt="<? print $text_genarticle_votearticle;?>ให้2คะแนน">
                    2</td>
                  <td align="center"><input name="vote_status" type="radio" value="3" alt="<? print $text_genarticle_votearticle;?>ให้3คะแนน">
                    3</td>
                  <td align="center"><input name="vote_status" type="radio" value="4" alt="<? print $text_genarticle_votearticle;?>ให้4คะแนน">
                    4</td>
                  <td align="center"><input name="vote_status" type="radio" value="5" alt="<? print $text_genarticle_votearticle;?>ให้5คะแนน">
                    5</td>
                </tr>
                <tr> 
                  <td colspan="5" align="center" valign="middle"><input type="submit" name="Submit" value="<?php echo $text_genarticle_valuevotearticle;?>"   class="text_normal"></td>
                </tr>
              </table>
              <br></td>
            <td width="50%" align="center" valign="middle" bgcolor="#FFFFFF"> 
              <?  if ($res_vote[count_vote] >0){  ?>
			  <table width="80%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
                <tr bgcolor="#FFFFFF"> 
                  <td >
				  
              <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="text_normal">
                <tr bgcolor="#FFFFFF"> 
                  <td width="100">&nbsp;&nbsp;ระดับ&nbsp;  </td>
				  <td> <?php 
                               $star=explode('.',number_format($rating,1));
                               for($s=1;$s<=$star[0];$s++){?>
                    <img src="../mainpic/star_yellow.gif" alt="star_yellow" width="16" height="16">
                    <? }
                               if($star[1]>=5){?>
                    <img src="../mainpic/half_star_yellow.gif" alt="half_star_yellow" width="8" height="16">
                    <? };
                      ?></td>
                </tr>
              </table>                  </td>
                </tr>
              </table>
              <br> 
              <? } ?>
              <table width="80%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999"  class="text_normal">
                <tr> 
                  <td bgcolor="#FFFFFF"> 
                    <? 
				if ($res_vote[count_vote] >0){
				?>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0"  class="text_normal">
                      <?php    for($p=1;$p<=5;$p++){  $per_score[$p]=$per_score[$p]*1;?>
                      <tr> 
                        <td  width="100">&nbsp;&nbsp;ให้ <?php echo $p;?> คะแนน                        </td>
                        <td><?php if($per_score[$p] > 0){ ?><table width="<? echo  $per_score[$p] ."%"; ?>"  style="height:10px" border="0" cellpadding="0" cellspacing="0" bgcolor="#009900">
                            <tr> 
                              <td height="10"><?php echo "&nbsp;"; ?></td>
                            </tr>
                          </table><?php } ?>					    </td>
						<td width="23%"><?php echo  $per_score[$p]."%"; ?></td>
                      </tr>
                      <?    } //end for($p=1;$p<$i;$p++) ?>
                    </table>
                    <? }else{ ?>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td align="center"><?php echo $text_genarticle_nodatavotearticle;?></td>
                      </tr>
                    </table>
                    <? } ?>                  </td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form>
	 <?php }  if($RR[show_comment] == '1'){
	 ?>
      <div id="show_comment"> 
        <?
		   $sql_comment = "SELECT * FROM news_comment   news_id WHERE news_id LIKE '$news_id' AND status_comment LIKE 'Y' ORDER BY id_ans DESC";
		   $query_comment  = mysql_query($sql_comment);
		   $num_rows = mysql_num_rows($query_comment);
		   if ($num_rows >0){
					   while($res_comment = mysql_fetch_array($query_comment)){
					  ?>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"  class="text_normal">
          <tr bgcolor="#E9E9E9" > 
            <td width="31%" align="left"  class="text_head"><li>
              <h2><?php echo $text_genarticle_commentat;?> <? print $res_comment[id_ans];?></h2>
            </li></td>
            <td width="69%" align="right" bgcolor="#E9E9E9" > <h2><a href="#post" onClick="window.open('comment_alt_del.php?id_ans=<?=$res_comment[id_ans]?>&news_id=<?=$news_id?>','','width=400 , height=200, location=0');" accesskey=<?php echo $db->genaccesskey();?> ><?php echo $text_general_commentdel;?> 
            </a> </h2></td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;<? echo str_replace("\n","<br>",cencer_rude($res_comment[comment])); ?></td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;<span style="color:#FF9900"><?php  echo cencer_rude($res_comment[name_comment]);
					  if($res_comment[id_member] != 0 AND $res_comment[id_member] != ""){
					  ?>
					   <img src="../mainpic/member.gif" align="absmiddle" border="0" alt="member"> 
					  <?php
					  }
					  echo datetime($res_comment[timestamp]);?></span></td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
        <?
					  }//end while
		  }//end if  
  ?>
      </div>
	  
	  	  <?php 

	    if($RR[comment_type]==1){ 
		   $show='Y';  
		}else  if($RR[comment_type]==2){
		  if($_SESSION["EWT_NAME"]){
		      $show='Y';  
		  }else{
		     $show='N'; 
		  }
		}
	  ?>
	  
	  <?php if($show=='Y'){?>
      <table width="90%" border="0" cellpadding="0" cellspacing="0"  class="text_normal">
        <tr > 
          <td height="20" align="center"   class="text_head"><h2><?php echo $text_genarticle_commentaddtoadd;?></h2></td>
        </tr>
        <tr> 
          <td align="center"> <form name="form2" method="post" action="ewt_comment_news.php">
              <table width="100%" border="0" cellpadding="1" cellspacing="1"  class="text_normal">
                <tr> 
                  <td><table width="100%" border="0" cellpadding="4" cellspacing="1"  class="text_normal">
                      <tr> 
                        <td width="36%" align="right"><?php echo $text_genarticle_commentaddtoname;?> :</td>
                        <td width="64%" align="left"><input type="text" name="name_comment" id="name_comment" value="<?php echo $_SESSION["EWT_NAME"];?>" alt="<?php echo $text_genarticle_commentaddtoname;?>" > 
                          <span class="style2">*</span> </td>
                      </tr>
                      <tr> 
                        <td align="right" valign="top"><?php echo $text_genarticle_commentaddtocomment;?> :</td>
                        <td align="left" valign="top" nowrap><textarea name="detail" cols="40" rows="4" id="detail" title="<?php echo $text_genarticle_commentaddtocomment;?>"></textarea> 
                          <span class="style2">*</span></td>
                      </tr>
                      <tr> 
                        <td colspan="2" align="center"><label> 
						<input type="hidden" name="news_id" value="<?=$_GET["nid"];?>">
                          <input type="submit" name="button" value="<?php echo $text_genarticle_commentaddtosubmit;?>" onClick="return chk_comment();"  class="text_normal">
                          </label></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>
	  <?php }
	  }
?>


<?php
	if(!session_is_registered("EWT_VISITOR_STAT")){
	session_register("EWT_REFERER");
	$_SESSION["EWT_REFERER"] = $HTTP_REFERER;
	}
	$end_time_counter = date("YmdHis");
	$gap = $end_time_counter - $start_time_counter;
?>
<script language="javascript1.2" type="text/javascript">
document.write("<img src=\"../ewt_stat.php?uw3c=Y&filename=<?php echo $_GET["nid"]; ?>&t=news&load=<?php echo $gap; ?>&res="+screen.width+"x"+screen.height+"\" width=\"1\" height=\"1\" style=\"display:none\">");	
</script>
<? }else{
?>
	<script language="javascript1.2" type="text/javascript">
	alert("<?php echo $text_genarticle_alertnoreadarticle;?>");
	window.location.href="<?php echo $RR["link_html"]; ?>";	
	</script>
	<?php
		exit;
}?>
<?php 

echo eregi_replace("#htmlw3c_spliter#",$logo,$template_design[1]); ?>
<?php $db->db_close(); ?>