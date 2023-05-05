<?php
session_start();
$start_time_counter = date("YmdHis");
ini_set("session.gc_maxlifetime", 60*60); 

include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");	
	//=======================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($nid){
		$nid  = checkNumeric($nid);
	}
	if($_GET["nid"]){
		$_GET["nid"] = checkNumeric($_GET["nid"]);
	}
	if($_POST["nid"]){
		$_POST["nid"] = checkNumeric($_POST["nid"]);
	}
	//========================================================
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");



if(!is_numeric($_GET["nid"])){
//echo stripslashes(htmlspecialchars(trim($_GET["filename"]),ENT_QUOTES));
exit;
}
$_POST["filename"] = stripslashes(htmlspecialchars(trim($_POST["filename"]),ENT_QUOTES));
$_GET["filename"] = stripslashes(htmlspecialchars(trim($_GET["filename"]),ENT_QUOTES));
$_REQUEST["filename"] = stripslashes(htmlspecialchars(trim($_REQUEST["filename"]),ENT_QUOTES));
$filename = $_GET["filename"];
$news_id = $_GET["nid"];
$nid = $_GET["nid"];
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

if($_GET["filename"] == ''){
$_GET["filename"] = 'index';
}
/*if($_GET["filename"] != ""){
//echo "SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ";
$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{ */
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
//}

$lang_sh1 = explode('___',$_GET["filename"]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
//if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}

$sql_lang_comfig = $db->db_fetch_array($db->query("select lang_config_id from lang_config where lang_config_suffix = '$lang_shw' "));
$lang_config_id = $sql_lang_comfig[lang_config_id];
if($lang_shw != ''){
//echo "SELECT *,article_list.c_id AS CID FROM article_list,lang_article_list ,lang_config WHERE article_list.n_id = lang_article_list.c_id AND lang_config.lang_config_id = lang_article_list.lang_name AND lang_config.lang_config_suffix = '".$lang_shw."'  AND lang_article_list.lang_field = 'n_topic' AND n_id = '".$_GET["nid"]."'";
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
//echo "SSSS".$did."SSSSS";
if($did != ""){
$RR["d_id"] = $did;
}
//if($d_idtemp != ''){

//}
$date =  number_format($date[2],0)."/".number_format($date[1],0)."/".($date[0]-543);
}

$nid = $_GET["nid"];
if($RR["d_id"] == '0' || $RR["d_id"] == ''){
$_GET["d_id"] = $d_idtemp;
}else{
$_GET["d_id"] = $RR["d_id"];
}
$page = 'news';
include("ewt_function.php");
if($use_template != ""){
$_GET["d_id"] =$use_template;
}
$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);

$global_theme = $R["d_bottom_content"];
$mainwidth = "0";

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

if(chk_permission_article($RR["c_id"]) == true){

?>
<html>
<head>
<title><?php echo $RR["n_topic"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript">
function chk_comment(){
var name_comment = document.getElementById('name_comment').value;
var detail = document.getElementById('detail').value;
	if (detail=='' || name_comment == ''){
		alert('<?php echo $text_genarticle_alerttext1;?>');
		return false;
	}else{
		//open_data('', 'show_comment','','');
		if(document.getElementById('chkpic11').value == ""){
			alert('Please input picture text.');
			document.getElementById('chkpic11').focus();
			return false;
		}
		return true;
	}
}


function open_data(url, divId,account_sub_type_id,bank_account_id) {
	var name_comment = document.getElementById('name_comment').value;
	var detail = document.getElementById('detail').value;		
	var news_id = '<?php echo $_GET["nid"]; ?>';
	var objDiv = document.getElementById(divId);
	url='ewt_comment_news.php?news_id='+news_id+'&name_comment='+name_comment+'&detail='+detail;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					document.getElementById('name_comment').value = '';
					document.getElementById('detail').value = '';
					objDiv.innerHTML = req.responseText;
			}
			//,'onSuccess':function(req) { }
		}
	);
}
</script>
<?php
include("ewt_script.php");	
?>
<script type="text/javascript" src="js/jquery/jquery.lightbox.js"></script>
		<style type="text/css">
		#lightbox{
	position: absolute;
	left: 0;
	width: 100%;
	z-index: 100;
	text-align: center;
	line-height: 0;
	}

#lightbox a img{ border: none; }

#outerImageContainer{
	position: relative;
	background-color: #fff;
	width: 250px;
	height: 250px;
	margin: 0 auto;
	}

#imageContainer{
	padding: 10px;
	}

#loading{
	position: absolute;
	top: 40%;
	left: 0%;
	height: 25%;
	width: 100%;
	text-align: center;
	line-height: 0;
	}
#hoverNav{
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	width: 100%;
	z-index: 10;
	}
#imageContainer>#hoverNav{ left: 0;}
#hoverNav a{ outline: none;}

#prevLink, #nextLink{
	width: 49%;
	height: 100%;
	background: transparent url(mainpic/lightbox/blank.gif) no-repeat; /* Trick IE into showing hover */
	display: block;
	}
#prevLink { left: 0; float: left;}
#nextLink { right: 0; float: right;}
#prevLink:hover, #prevLink:visited:hover { background: url(mainpic/lightbox/prev.gif) left 50% no-repeat; }
#nextLink:hover, #nextLink:visited:hover { background: url(mainpic/lightbox/next.gif) right 50% no-repeat; }

/*** START : next / previous text links ***/
#nextLinkText, #prevLinkText{
color: #FF9834;
font-weight:bold;
text-decoration: none;
}
#nextLinkText{
padding-left: 0px;
}
#prevLinkText{
padding-right: 0px;
}
/*** END : next / previous text links ***/
/*** START : added padding when navbar is on top ***/

.ontop #imageData {
    padding-top: 5px;
}

/*** END : added padding when navbar is on top ***/

#imageDataContainer{
	font: 12px Verdana, Helvetica, sans-serif;
	background-color: #fff;
	margin: 0 auto;
	line-height: 1.4em;
	}

#imageData{
	padding:0 10px;
	}
#imageData #imageDetails{ width: 70%; float: left; text-align: left; }	
#imageData #caption{ font-weight: bold;	}
#imageData #numberDisplay{ display: block; clear: center; padding-bottom: 1.0em;	}
#imageData #bottomNavClose{ width: 10px; float: right;  padding-bottom: 0.7em;	}
#imageData #helpDisplay {clear: left; float: left; display: block; }

#overlay{
	position: absolute;
	top: 0;
	left: 0;
	z-index: 90;
	width: 100%;
	height: 500px;
	background-color: #000;
	filter:alpha(opacity=60);
	-moz-opacity: 0.6;
	opacity: 0.6;
	display: none;
	}
	

.clearfix:after {
	content: "."; 
	display: block; 
	height: 0; 
	clear: both; 
	visibility: hidden;
	}

* html>body .clearfix {
	display: inline-block; 
	width: 100%;
	}

* html .clearfix {
	/* Hides from IE-mac \*/
	height: 1%;
	/* End hide from IE-mac */
	}	
		body,td,th {
	font-family: Tahoma;
}
        </style>
</head>
<body  leftmargin="0" topmargin="0" <?php if($R["d_site_bg_c"] != ""){ echo "bgcolor=\"".$R["d_site_bg_c"]."\""; } ?> <?php if($R["d_site_bg_p"] != ""){ echo "background=\"".$R["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $R["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $R["d_site_align"]; ?>">
  <tr  valign="top" > 
    <td id="ewt_main_structure_top" height="<?php echo $R["d_top_height"]; ?>" bgcolor="<?php echo $R["d_top_bg_c"]; ?>" colspan="3" background="<?php echo $R["d_top_bg_p"]; ?>"> 
      <?php
			$mainwidth = $R["d_site_width"];

		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
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

		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
      <DIV><?php echo show_block($LB[0]); ?></DIV>
      <?php } ?>
    </td>
    <td  id="ewt_main_structure_body" width="<?php echo $R["d_site_content"]; ?>" bgcolor="<?php echo $R["d_body_bg_c"]; ?>" height="160" background="<?php echo $R["d_body_bg_p"]; ?>" align="center"> 
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

		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
      <DIV><?php echo show_block($LB[0]); ?>
      </DIV>
      <?php }
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
		  <?php }
	####### select ข้อมูลเพื่อดูจำนวนคนอ่าน ###############		
	$sql_view ="SELECT count(id_view) as count_view FROM news_view WHERE news_id LIKE '$news_id' ";
	$query_view = mysql_query($sql_view);
	$res_view = $db->db_fetch_array($query_view);
		  ?>
		  <?php 	if($RR[show_topic] == '1'){ ?>
                  <tr>
            <td class="text_head"><div style="FONT: 17px 'Tahoma';"><?php echo $RR["n_topic"]; ?></div><hr size="1">
			<?php } ?>
			<?php 	if($RR[show_date] == '1'){ ?>
			<span style="FONT: 12px 'Tahoma';"><?php echo $date_txt;?> <?php echo $date ; ?> <?php echo $RR["n_time"]; ?></span>
			<?php } ?>
			<?php if($RR['show_count']=='1') { ?><span style="FONT: 12px 'Tahoma';"><?php echo "(".$text_genarticle_numread.$res_view[count_view]."คน)"; } ?></span>
			<?php } ?>
			<br><span style="FONT: 12px 'Tahoma';"><?php echo $text_genarticle_textsource;?><?php if($RR["sourceLink"] ==''){echo $RR["source"];}else{ ?><a href="<?php echo $RR["sourceLink"];?>" target="_blank" ><?php echo $RR["source"]; ?></a><?php } ?></span>
</td>
          </tr>
	  </table>
	
	  <?php
	$sql_t = $db->query("SELECT * FROM article_template WHERE at_id = '$RR[at_id]'");
	$A = $db->db_fetch_array($sql_t);
	@include("../../article_template/".$A["at_use"]);
//show attach file
	$sql_attach = "select * from article_attach where n_id = '".$_GET["nid"]."' order by fileattact_id  ASC";
	$query_attach = $db->query($sql_attach);
	if($db->db_num_rows($query_attach) > 0 ){
	?>
	<table width="60%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" class="text_head">หัวข้อ<hr width="100%" size="1"></td>
    <td width="50" align="center" class="text_head">Download
      <hr width="100%" size="1"></td>
  </tr>
  <?php
  while($attach = $db->db_fetch_array($query_attach)){
 								 $type_file = explode('.',$attach["fileattach_path"]);
									if(strtolower($type_file[1]) == 'doc' OR strtolower($type_file[1]) == 'docx'){$icon_attch =  "<img src=\"mainpic/file_type/doc.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'pdf'){$icon_attch =  "<img src=\"mainpic/file_type/pdf.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'txt'){$icon_attch =  "<img src=\"mainpic/file_type/txt.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'xls' OR strtolower($type_file[1]) == 'xlsx'){$icon_attch =  "<img src=\"mainpic/file_type/excel.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'ppt' OR strtolower($type_file[1]) == 'pptx'){$icon_attch =  "<img src=\"mainpic/file_type/ppt.gif\" align=\"absmiddle\" border=\"0\">";
									}else if(strtolower($type_file[1]) == 'zip' OR strtolower($type_file[1]) == 'rar'){$icon_attch =  "<img src=\"mainpic/file_type/winzip.gif\" align=\"absmiddle\" border=\"0\">";
									}else{ $icon_attch =  "<img src=\"mainpic/file_type/save.gif\" align=\"absmiddle\" border=\"0\">";}
  ?>
  <tr>
    <td valign="top"><?php echo $attach["fileattach_name"];?></td>
    <td align="center" valign="top"><?php echo "<a href=\"article_attach/".$attach["fileattach_path"]."\" target=\"_blank\">".$icon_attch."</a>";?></td>
  </tr>
  <?php } ?>
</table>
	<?php
	}
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
	$vote_status=$_POST['vote_status'];
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
	$res_view = $db->db_fetch_array($query_view);
	
	####### select ข้อมูลเพื่อดูจำนวนคน vote ###############		
	$sql_vote ="SELECT count(id_vote) as count_vote  FROM news_vote WHERE news_id LIKE '$news_id' ";
	$query_vote = mysql_query($sql_vote);
	$res_vote = $db->db_fetch_array($query_vote);

	####### select ข้อมูลเพื่อดูสถานะการ vote ###############		
   $sql_status="SELECT point,count(id_vote) as count_vote  FROM news_vote where news_id='$news_id' GROUP BY point  order by point ";
   $query_status = mysql_query($sql_status);
   $rating=0;
   while($res_status=$db->db_fetch_array($query_status)){
		  @$per_score[$res_status[point]]= number_format($res_status[count_vote]/$res_vote[count_vote]*100);
          $sum_score=$sum_score+$res_status[point]*$res_status[count_vote];
  }
 @$rating=$sum_score/$res_vote[count_vote];
/*
	$sql_status_Y ="SELECT count(id_vote) as count_vote  FROM news_vote WHERE news_id LIKE '$news_id' AND point = '1' GROUP BY point ";
	$query_status_Y = mysql_query($sql_status_Y);
	$res_status_y = $db->db_fetch_array($query_status_Y);
	
	$sql_status_N ="SELECT count(id_vote) as count_vote  FROM news_vote WHERE news_id LIKE '$news_id' AND point = '0' GROUP BY point ";
	$query_status_N = mysql_query($sql_status_N);
	$res_status_N = $db->db_fetch_array($query_status_N);

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
          <td <?php echo $dis0; ?>align="center" ><?php echo $text_Gennewstop5_hit ;?></td>
          <td <?php echo $dis1; ?>align="center" ><?php echo $text_Gennewstop5_vote;?></td>
          <td <?php echo $dis2; ?>align="center" ><?php echo $text_Gennewstop5_later;?></td>
        </tr>
        <tr> 
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis0; ?>> 
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
                <td align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]; ?>"><?php echo $rs[n_topic]; ?></a></td>
              </tr>
              <?php
								}
        ?>
            </table></td>
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis1; ?>> 
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
                <td align="left"><a href="ewt_news.php?nid=<?php echo $rs[news_id]; ?>"><?php echo $rs[n_topic]; ?></a></td>
              </tr>
              <?php
								}
        ?>
            </table></td>
          <td width="30%" align="center" valign="top" bgcolor="#FFFFFF" <?php echo $dis2; ?>> 
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
                <td><a href="ewt_news.php?nid=<?php echo $rs[n_id]; ?>"><?php echo $rs[n_topic]; ?></a>
                </td>
              </tr>
              <?php
								}
        ?>
            </table></td>
        </tr>
      </table>
	  <?php } ?>
	   <?php
	  if($RR[show_vote] == '1'){
	  ?>
      <table width="90%" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999" class="text_normal">
          <tr bgcolor="#CCCCCC"> 
            <td  class="text_head"><? print $text_genarticle_numread." $res_view[count_view] คน";?></td>
            <td align="right"   class="text_head"><? print  $text_genarticle_numvote." $res_vote[count_vote] คน";?></td>
          </tr>
      </table><br/>
     
      <form name="form1" method="post" action="">
        <table width="90%" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999" class="text_normal">
          <tr bgcolor="#CCCCCC"> 
            <td  class="text_head">&nbsp;</td>
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
                  <td width="100">&nbsp;&nbsp;ระ�&rdquo;ับ&nbsp;  </td>
				  <td> <?php 
                               $star=explode('.',number_format($rating,1));
                               for($s=1;$s<=$star[0];$s++){?>
                    <img src="mainpic/star_yellow.gif">
                    <?php }
                               if($star[1]>=5){?>
                    <img src="mainpic/half_star_yellow.gif">
                    <?php }
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
                      <?php    for($p=1;$p<=5;$p++){  $per_score[$p] =$per_score[$p]*1;?>
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
		   $sql_comment = "SELECT * FROM news_comment WHERE news_id LIKE '$news_id' AND status_comment LIKE 'Y' ORDER BY id_ans DESC";
		   $query_comment  = mysql_query($sql_comment);
		   $num_rows = mysql_num_rows($query_comment);
		   if ($num_rows >0){
					   while($res_comment = $db->db_fetch_array($query_comment)){
					  ?>
        <table width="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"  class="text_normal">
          <tr bgcolor="#E9E9E9" > 
            <td width="31%" align="left"  class="text_head"><li><?php echo $text_genarticle_commentat;?> <?php print $res_comment[id_ans];?></li></td>
            <td width="69%" align="right" bgcolor="#E9E9E9" > <a href="#post" onClick="window.open('comment_alt_del.php?id_comment=<?php echo $res_comment['id_comment']; ?>&news_id=<?php echo $news_id; ?>','','width=400 , height=200, location=0');" ><?php echo $text_general_commentdel;?> 
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
                        <td align="center" valign="top" colspan="2"><!-- capcha -->
                        <?php include('inc_capcha.php'); ?>
                        <!-- capcha --></td>
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
	  <?php } ?></td>
              <td id="ewt_main_structure_right" width="<?php echo $R["d_site_right"]; ?>" bgcolor="<?php echo $R["d_right_bg_c"]; ?>" background="<?php echo $R["d_right_bg_p"]; ?>">
			<?php
			$mainwidth = $R["d_site_right"];

		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
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
 
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
      <DIV><?php echo show_block($BB[0]); ?></DIV>
      <?php } ?>
    </td>
  </tr>
</table>
<?php
	if(!session_is_registered("EWT_VISITOR_STAT")){
	session_register("EWT_REFERER");
	$_SESSION["EWT_REFERER"] = $HTTP_REFERER;
	}
	$end_time_counter = date("YmdHis");
	$gap = $end_time_counter - $start_time_counter;
?>
<script language="javascript">
document.write("<img src=\"ewt_stat.php?t=news&filename=<?php echo $_GET["nid"]; ?>&load=<?php echo $gap; ?>&res="+screen.width+"x"+screen.height+"\" width=\"1\" height=\"1\" style=\"display:none\">");	
</script>

</body>
</html>
<script>
	$(document).ready(function(){
		$(".lightbox").lightbox({
			category_id : '',
			filename : '<?php echo $filename; ?>',
			page : '',
			BID : '',
			vote : '0',
			comment : '0',
			send : '0',
			showimg : 1
		});
	});
</script>
<?php $db->db_close(); ?>