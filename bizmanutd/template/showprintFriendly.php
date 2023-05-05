<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");
	if($_GET["filename"] != "") {
		$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);
		$_GET["d_id"] = $F["template_id"];
	} else {
		$_GET["filename"] = "index";
		$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
		$FF = $db->db_fetch_array($sql_index);
		$_GET["d_id"] = $FF[d_id];
	}


			$lang_sh1 = explode('___',$F[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
	$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
	$sql_temp= $db->query($temp);
	$RR = $db->db_fetch_array($sql_temp);

	$global_theme = $RR["d_bottom_content"];
	$mainwidth = "0";


?>
<html>
<head>
<title>Search Result...</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php include("ewt_script.php");	 ?>
</head>
<body  leftmargin="0" topmargin="0" >
<table width="100%" border="0" cellpadding="0" cellspacing="0"  class="text_normal">
	<tr > 
		<td ><img src="mainpic/logo.gif"></td>
	    <td align="right" valign="bottom" ><input type="button" name="Button01" value="พิมพ์"  onclick="document.all.Button01.style.display='none';window.print();document.all.Button01.style.display='';"></td>
	</tr>
	<tr >
	  <td colspan="2" ><hr ></td>
  </tr>
	<tr valign="top" > 
		<td colspan="4">
		
			<?php
				$mainwidth = "100%";
			?>
			<?php
			//main.php
			if($_GET[flag]=='1'){
		  $sql_content = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
          <DIV><?php echo show_block($CB[0]); ?></DIV>          <?php } 
		  
		  }
		  //ewt_news.php
		  if($_GET[flag]=='2'){
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
				//echo "select lang_detail from $tb where c_id = '".$c_id."' and lang_name = '".$lang_name."' and lang_field = '".$lang_field."'";
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
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');


$sql_lang_comfig = $db->db_fetch_array($db->query("select lang_config_id from lang_config where lang_config_suffix = '$lang_shw' "));
$lang_config_id = $sql_lang_comfig[lang_config_id];
if($lang_shw != ''){
$sql_article = $db->query("SELECT *,article_list.c_id AS CID FROM article_list,lang_article_list ,lang_config WHERE article_list.n_id = lang_article_list.c_id AND lang_config.lang_config_id = lang_article_list.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."'  AND lang_article_list.lang_field = 'n_topic' AND n_id = '".$_GET["nid"]."'");

	if($db->db_num_rows($sql_article) == 0){
	$alert_lang = str_replace("<#lang#>",$lang_shw,$text_general_alert_nopage);
		?>
		<script language="javascript">
		alert("<?php echo $alert_lang;?>");
		window.location.href="ewt_news.php?nid=<?php echo $_GET["nid"]; ?>";	
		</script>
		<?php
			exit;
	}
$RR= $db->db_fetch_array($sql_article);
}else{
$sql_article = $db->query("SELECT * FROM article_list WHERE n_id = '".$_GET["nid"]."'");
$RR= $db->db_fetch_array($sql_article);
	if($RR["news_use"] == "1"){
	?>
	<script language="javascript">
	window.location.href="<?php echo $RR["link_html"]; ?>";	
	</script>
	<?php
		exit;
	}
	if($RR["news_use"] == "4"){
	?>
	<script language="javascript">
	window.location.href="ewt_dl.php?nid=<?php echo $_GET["nid"]; ?>";	
	</script>
	<?php
		exit;
	}
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

$date =  number_format($date[2],0)."/".number_format($date[1],0)."/".($date[0]-543);
}


$page = 'news';
include("ewt_function.php");

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
					$txt = " <a href = \"more_news.php?cid=".$G["c_id"]."&filename=".$filename."\"><span style=\"FONT: 12px 'Tahoma';\">".$G["c_name"]."</span></a> &gt;&gt; ";
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

		  ?>
		  
		  <?php if($RR[show_textsize] == "1"){ ?>
	<TABLE cellSpacing=1 cellPadding=2 width="100%" border=0>
<TBODY>
<TR>
<TD align=right>
<TABLE cellSpacing=1 cellPadding=6 width=120 bgColor=#dddddd border=0>
<TBODY>
<TR>
<TD style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #555555; FONT-FAMILY: Tahoma; TEXT-DECORATION: none" align=middle bgColor=#ffffff>FONTSIZE <A onClick="changeStyle('small');" href="#size"><IMG height=10 src="mainpic/s.gif" width=10 border=0></A> <A onClick="changeStyle('normal');" href="#size"><IMG height=10 src="mainpic/n.gif" width=10 border=0></A> <A onClick="changeStyle('big');" href="#size"><IMG height=10 src="mainpic/b.gif" width=10 border=0></A> </TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE>
      <?php
	  		}
			$mainwidth = $R["d_site_content"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
      <DIV><?php //echo show_block($LB[0]); ?>
      </DIV>
      <?php } ?><?php
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
            <td class="text_normal"><span  style="FONT: 12px 'Tahoma';"><?php echo findparent($U["c_parent"]); ?> <a href="more_news.php?cid=<?php echo $RR[c_id]; ?>&filename=<?php echo $filename;?>"  style="FONT: 12px 'Tahoma';"> <?php echo $U[c_name]; ?></a> <?php if($U[c_rss] == "Y"){ ?><a href="rss/group<?php echo $U[c_id]; ?>.xml" target="_blank"><img src="mainpic/ico_rss.gif"  border="0" align="absmiddle"></a><?php } ?></span>
</td>
          </tr>
		  <?php } ?>
		  <?php 	if($RR[show_topic] == '1'){ ?>
                  <tr>
            <td class="text_head"><div style="FONT: 17px 'Tahoma';"><?php echo $RR["n_topic"]; ?></div><hr size="1">
			<?php } ?>
			<?php 	if($RR[show_date] == '1'){ ?>
			<span style="FONT: 12px 'Tahoma';"><?php echo $date_txt;?> <?php echo $date ; ?> <?php echo $RR["n_time"]; ?></span>
			<?php } ?>
			<br><span style="FONT: 12px 'Tahoma';"><?php echo $text_genarticle_textsource;?><?php if($RR["sourceLink"] ==''){echo $RR["source"];}else{ ?><a href="<?php echo $RR["sourceLink"];?>" target="_blank" ><?php echo $RR["source"]; ?></a><?php } ?></span>
</td>
          </tr>
	  </table>
	
	  <?php
	$sql_t = $db->query("SELECT * FROM article_template WHERE at_id = '$RR[at_id]'");
	$A = $db->db_fetch_array($sql_t);
	@include("../../article_template/".$A["at_use"]);

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
/*
	$sql_status_Y ="SELECT count(id_vote) as count_vote  FROM news_vote WHERE news_id LIKE '$news_id' AND point = '1' GROUP BY point ";
	$query_status_Y = mysql_query($sql_status_Y);
	$res_status_y = mysql_fetch_array($query_status_Y);
	
	$sql_status_N ="SELECT count(id_vote) as count_vote  FROM news_vote WHERE news_id LIKE '$news_id' AND point = '0' GROUP BY point ";
	$query_status_N = mysql_query($sql_status_N);
	$res_status_N = mysql_fetch_array($query_status_N);

	$total = $res_vote[count_vote];	
	$per_Y =  @number_format(($res_status_y[count_vote]/$total)*100); 		
	$per_N =  @number_format(($res_status_N[count_vote]/$total)*100); 		
	*/
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
          <td <?php echo $dis0?>align="center" ><?php echo $text_Gennewstop5_hit ;?></td>
          <td <?php echo $dis1?>align="center" ><?php echo $text_Gennewstop5_vote;?></td>
          <td <?php echo $dis2?>align="center" ><?php echo $text_Gennewstop5_later;?></td>
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
                <td width="16" align="left"><img src="mainpic/news_bullet.gif"  ></td>
                <td align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]?>"><?php echo $rs[n_topic]?></a></td>
              </tr>
              <?php
								}
        ?>
            </table></td>
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis1?>> 
            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="text_normal"  bgcolor="#FFFFFF">
              <?php

					            $sql ="SELECT sum(point)/count(news_id) as rating ,n_topic,news_id
											FROM  article_list  INNER JOIN news_vote ON (article_list.n_id = news_vote.news_id) WHERE article_list.c_id = '".$RR["c_id"]."' 
											GROUP BY  news_id
											ORDER BY rating DESC  limit 0,5";
								$query = $db->query($sql);
                                $num = $db->db_num_rows($query);
								$i=0;
								while($rs = $db->db_fetch_array($query)){
								$i++;
								?>
              <tr valign="top" bgcolor="#FFFFFF"> 
                <td width="16" align="left"><img src="mainpic/news_bullet.gif"  ></td>
                <td align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]?>"><?php echo $rs[n_topic]?></a></td>
              </tr>
              <?php
								}
        ?>
            </table></td>
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
                <td width="16" align="left"><img src="mainpic/news_bullet.gif"  ></td>
                <td><a href="ewt_news.php?nid=<?php echo $rs[n_id]?>"><?php echo $rs[n_topic]?></a>
                </td>
              </tr>
              <?php
								}
        ?>
            </table></td>
        </tr>
      </table>
	  <?php } 
	  if($RR[show_vote] == '1'){
	  ?>
      <form name="form1" method="post" action="">
        <table width="90%" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999" class="text_normal">
          <tr bgcolor="#CCCCCC"> 
            <td  class="text_head"><?php print $text_genarticle_numread." $res_view[count_view] คน";?></td>
            <td align="right"   class="text_head"><?php print  $text_genarticle_numvote." $res_vote[count_vote] คน";?></td>
          </tr>
          <tr> 
            <td width="50%" align="center" valign="top" bgcolor="#FFFFFF" ><table width="90%" border="0" align="center" cellpadding="6" cellspacing="1" class="text_normal">
                <tr> 
                  <td colspan="5" align="center"><?php print $text_genarticle_votearticle;?></td>
                </tr>
                <tr> 
                  <td align="center"><input name="vote_status" type="radio" value="1">
                    1</td>
                  <td align="center"><input name="vote_status" type="radio" value="2">
                    2</td>
                  <td align="center"><input name="vote_status" type="radio" value="3">
                    3</td>
                  <td align="center"><input name="vote_status" type="radio" value="4">
                    4</td>
                  <td align="center"><input name="vote_status" type="radio" value="5">
                    5</td>
                </tr>
                <tr> 
                  <td colspan="5" align="center" valign="middle"><input type="submit" name="Submit" value="<?php echo $text_genarticle_valuevotearticle;?>"   class="text_normal"></td>
                </tr>
              </table>
              <br></td>
            <td width="50%" align="center" valign="middle" bgcolor="#FFFFFF"> 
              <?php  if ($res_vote[count_vote] >0){  ?>
			  <table width="80%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
                <tr bgcolor="#FFFFFF"> 
                  <td >
				  
              <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="text_normal">
                <tr bgcolor="#FFFFFF"> 
                  <td width="100">&nbsp;&nbsp;ระดับ&nbsp;  </td>
				  <td> <?php 
                               $star=explode('.',number_format($rating,1));
                               for($s=1;$s<=$star[0];$s++){?>
                    <img src="mainpic/star_yellow.gif">
                    <?php }
                               if($star[1]>=5){?>
                    <img src="mainpic/half_star_yellow.gif">
                    <?php };
                      ?></td>
                </tr>
              </table>
			  
                  </td>
                </tr>
              </table>
              <br> 
              <?php } ?>
              <table width="80%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999"  class="text_normal">
                <tr> 
                  <td bgcolor="#FFFFFF"> 
                    <?php 
				if ($res_vote[count_vote] >0){
				?>
                    <table width="100%" border="0" cellspacing="1" cellpadding="0"  class="text_normal">
                      <?php    for($p=1;$p<=5;$p++){  $per_score[$p]=$per_score[$p]*1;?>
                      <tr> 
                        <td  width="100">&nbsp;&nbsp;ให้ <?php echo $p;?> คะแนน 
                        </td>
                        <td><table width="<?php echo  $per_score[$p] ."%"; ?>" height="10" border="0" cellpadding="0" cellspacing="0" bgcolor="#009900">
                            <tr> 
                              <td height="10"><?php if($per_score[$p])echo "&nbsp;"; ?></td>
                            </tr>
                          </table>
					    </td>
						<td width="23%"><?php echo  $per_score[$p]."%"; ?></td>
                      </tr>
                      <?php    } //end for($p=1;$p<$i;$p++) ?>
                    </table>
                    <?php }else{ ?>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td align="center"><?php echo $text_genarticle_nodatavotearticle;?></td>
                      </tr>
                    </table>
                    <?php } ?>
                  </td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form>
	 <?php } 
	  if($RR[show_comment] == '1'){
	 ?>
      <div id="show_comment"> 
        <?php
		   $sql_comment = "SELECT * FROM news_comment   news_id WHERE news_id LIKE '$news_id' AND status_comment LIKE 'Y' ORDER BY id_ans DESC";
		   $query_comment  = mysql_query($sql_comment);
		   $num_rows = mysql_num_rows($query_comment);
		   if ($num_rows >0){
					   while($res_comment = mysql_fetch_array($query_comment)){
					  ?>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"  class="text_normal">
          <tr bgcolor="#E9E9E9" > 
            <td width="31%" align="left"  class="text_head"><li><?php echo $text_genarticle_commentat;?> <?php print $res_comment[id_ans];?></li></td>
            <td width="69%" align="right" bgcolor="#E9E9E9" > <a href="#post" onClick="window.open('comment_alt_del.php?id_ans=<?php echo $res_comment[id_ans]?>&news_id=<?php echo $news_id?>','','width=400 , height=200, location=0');" ><?php echo $text_general_commentdel;?> 
              </a> </td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;<?php echo str_replace("\n","<br>",cencer_rude($res_comment[comment])); ?></td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;&nbsp;<span style="color:#FF9900"><?php  echo cencer_rude($res_comment[name_comment]);
					  if($res_comment[id_member] != 0 AND $res_comment[id_member] != ""){
					  ?>
					   <img src="mainpic/member.gif" align="absmiddle" border="0"> 
					  <?php
					  }
					  echo datetime($res_comment[timestamp]);?></span></td>
          </tr>
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table>
        <?php
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
        <tr bgcolor="#E9E9E9"> 
          <td height="20" align="center"  bgcolor="#E9E9E9"  class="text_head"><?php echo $text_genarticle_commentaddtoadd;?></td>
        </tr>
        <tr> 
          <td align="center"> <form name="form2" method="post" action="ewt_comment_news.php">
              <table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC"  class="text_normal">
                <tr> 
                  <td><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#F4F4F4"  class="text_normal">
                      <tr> 
                        <td width="36%" align="right"><?php echo $text_genarticle_commentaddtoname;?> :</td>
                        <td width="64%" align="left"><input type="text" name="name_comment" id="name_comment" value="<?php echo $_SESSION["EWT_NAME"];?>"> 
                          <span class="style2">*</span> </td>
                      </tr>
                      <tr> 
                        <td align="right" valign="top"><?php echo $text_genarticle_commentaddtocomment;?> :</td>
                        <td align="left" valign="top" nowrap><textarea name="detail" cols="40" rows="4" id="detail"></textarea> 
                          <span class="style2">*</span></td>
                      </tr>
                      <tr> 
                        <td colspan="2" align="center"><label> 
						<input type="hidden" name="news_id" value="<?php echo $_GET["nid"];?>">
                          <input type="submit" name="button" value="<?php echo $text_genarticle_commentaddtosubmit;?>" onClick="return chk_comment();"  class="text_normal">
                          </label></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table>
	  <?php }?>
	  <?php } ?>
		  
		  
		  
		  
		  <?php
		  }
		  
		  //ewt_snews.php
		  if($_GET[flag]=='3'){
		  $enc = base64_decode($_GET["s"]);
			$ex = explode("@@@",$enc);
			$pathall = "../".$ex[0]."/article/TEMP".$ex[1].".tmp";
			//File url
			$db->query("USE ".$EWT_DB_USER);
			$sql_url = "select url,EWT_User from user_info where EWT_User = '".$ex[0]."'";
			$RU = $db->db_fetch_array($db->query($sql_url));
			$URL = $RU[EWT_User];
			$db->query("USE ".$EWT_DB_NAME);
			$temp = "SELECT * FROM design_list WHERE d_default = 'Y' ";
			$sql_temp= $db->query($temp);
			$RR = $db->db_fetch_array($sql_temp);
			
			$global_theme = $RR["d_bottom_content"];
			$mainwidth = "0";

		  ?>
		  	<?php $fw = @fopen($pathall, "r");
				 if($fw){ 
					while($html = @fgets($fw, 1024)){
					$line .= $html;
					}
				}
			echo ereg_replace ("href=\"", " href=\"ewt_dl_file.php?path=".$URL."&url=", $line);//$line;
		  @fclose($fw);
		  ?>
		  <?php
		  }
		    //more_news.php
		  if($_GET[flag]=='4'){
		  $monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
$lang_sh1 = explode('___',$_GET["filename"]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");

include("ewt_function.php");


$global_theme = $R["d_bottom_content"];
$mainwidth = "0";
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
            <td><span  style="FONT: 12px 'Tahoma';"><a href="index.php"  style="FONT: 12px 'Tahoma';">หน้าหลัก</a> >><a href="more_news.php?cid=<?php echo $U[c_id]; ?>&filename=index"  style="FONT: 12px 'Tahoma';"> <?php echo $U[c_name]; ?></a> <?php if($U[c_rss] == "Y"){ ?><a href="rss/group<?php echo $U[c_id]; ?>.xml" target="_blank"><img src="mainpic/ico_rss.gif"  border="0" align="absmiddle"></a><?php } ?></span>
</td>
          </tr>
		  </table>
      <table width="95%" border="0" align="center" cellpadding="8" cellspacing="1">
	  <?php if($U[c_show_search] == "Y" ){ ?>
        <tr><form name="form1" method="get" action="search_result.php">
          <td><table width="100%" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td align="right" class="text_normal">วันที่ :
                  <input name="date_s" type="text"  style="FONT: 11px 'Tahoma';" value="" size="10"><a href="#show" onClick="return showCalendar('date_s', 'dd-mm-y');"><img src="mainpic/b_calendar.gif"  border=0 align="absmiddle"></a> ถึงวันที่ :
                <input name="date_e" type="text"  style="FONT: 11px 'Tahoma';" value="" size="10"><a href="#show" onClick="return showCalendar('date_e', 'dd-mm-y');"><img src="mainpic/b_calendar.gif" border=0 align="absmiddle"></a> <br>
                คำค้น :
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

		  $sql_sub =$db->query("select * from  article_group,lang_article_group,lang_config where lang_article_group.c_id =article_group.c_id  AND lang_config.lang_config_id = lang_article_group.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."' AND  article_group.c_parent = '".$_GET[cid]."'");
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
					  if($A["news_use"] == "2"){
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
                  <?php if($A["news_use"] == "2"){
								echo "<a href=\"ewt_news.php?nid=".$A["n_id"]."&filename=".$filename."\" target=\"".$A["target"]."\"><b>";
							}elseif($A["news_use"] == "4"){
								echo "<a href=\"ewt_dl.php?nid=".$A["n_id"]."\" target=\"".$A["target"]."\"><b>";
							}else{
								if($lang_shw != ''){
								$A["link_html"] = select_lang_detail($A["n_id"],$lang_shw,'link_html','article_list');
								}
								echo "<a href=\"".$A["link_html"]."\" target=\"".$A["target"]."\"><b>";
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
echo   "<a href='$PHP_SELF?offset=$prevoffset&cid=$cid&filename=$filename'>
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
                  echo  " <a href='$PHP_SELF?offset=$newoffset&cid=$cid&filename=$filename' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";>$i</a> \n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href='$PHP_SELF?offset=$newoffset&cid=$cid&filename=$filename'>
		  <font color=\"red\">$text_general_next>></font></a> "; 
    }
	}
?>
		  <?php
		  }
		  //search_re
		  if($_GET[flag]=='5'){
		  ?>
		  <script language="javascript">
	function ajax_search_word(keyword_b) {
		document.formSearchAEWT.keyword.value = keyword_b;
		ajax_search(document.formSearchAEWT.search_mode.value);
	}
	
	function ajax_search(tab) {
		
			var objDiv = document.getElementById("divSearchResult");
			var keyword = '<?php echo $_GET[keyword]; ?>';
			var search_mode = '<?php echo $_GET[search_mode]; ?>';
			var filename = '<?php echo $_GET[filename]; ?>';
			var oper ='';
			var ip_address = '<?php echo $ip_address; ?>';
			var sh_date_now = '<?php echo $sh_date;?>';
			if(tab != '<?php echo $search_mode; ?>'){
			var page_now = '';
			}else{
			var page_now = '<?php echo $page;?>';
			}
			url='search_include1.php?'+sh_date_now+page_now+'keyword='+ keyword+'&search_mode='+search_mode+'&filename='+filename+'&oper='+oper+'&ip_address'+ip_address;
			AjaxRequest.get({
				'url':url
				,'onLoading':function() { }
				,'onLoaded':function() { }
				,'onInteractive':function() { }
				,'onComplete':function() { }
				,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
				}
			});
		
	}
</script>
		  <div id="divSearchResult">&nbsp;</div>	
		  <script language="javascript"><?php
						if($search_mode != "") {
							?>
							ajax_search('<?php echo $search_mode; ?>');
							<?php
						}
					?>
</script>
		  <?php
		}
		  ?>				</td>
	</tr>
	<tr valign="top" > 
		<td colspan="2" align="center"  class="text_normal"><hr><img src="mainpic/ecat_t_33.jpg"></td>
	</tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
