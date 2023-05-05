<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");	
	
	//================================================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($orderby){ $orderby=checkPttVar($orderby); }
	if($_GET["orderby"]){ $_GET["orderby"]=checkPttVar($_GET["orderby"]); }
	if($_POST["orderby"]){ $_POST["orderby"]=checkPttVar($_POST["orderby"]); }
	
	if($TTYPE){ $TTYPE=checkPttVar($TTYPE); }
	if($_GET["TTYPE"]){ $_GET["TTYPE"]=checkPttVar($_GET["TTYPE"]); }
	if($_POST["TTYPE"]){ $_POST["TTYPE"]=checkPttVar($_POST["TTYPE"]); }
	
	if($adesc){ $adesc=checkPttVar($adesc); }
	if($_GET["adesc"]){ $_GET["adesc"]=checkPttVar($_GET["adesc"]); }
	if($_POST["adesc"]){ $_POST["adesc"]=checkPttVar($_POST["adesc"]); }
	
	if($wcad){ $wcad = checkNumeric($wcad); }
	if($_GET["wcad"]){ $_GET["wcad"] = checkNumeric($_GET["wcad"]); }
	if($_POST["wcad"]){ $_POST["wcad"] = checkNumeric($_POST["wcad"]); }
	if($_REQUEST["wcad"]){ $_REQUEST["wcad"]=checkNumeric($_REQUEST["wcad"]); }
	
	
	if($t){ $t=checkNumeric($t); }
	if($_GET[t]){ $_GET[t]=checkNumeric($_GET[t]); }
	if($_POST[t]){ $_POST[t]=checkNumeric($_POST[t]); }
	if($_REQUEST[t]){ $_REQUEST[t]=checkNumeric($_REQUEST[t]); }
	
	if($countrow){ $countrow = checkNumeric($countrow); }
	if($_GET["countrow"]){ $_GET["countrow"] = checkNumeric($_GET["countrow"]);  }
	if($_POST["countrow"]){ $_POST["countrow"] = checkNumeric($_POST["countrow"]); }
	
	if($offset){ $offset = checkNumeric($offset); }
	if($_GET["offset"]){ $_GET["offset"] = checkNumeric($_GET["offset"]); }
	if($_POST["offset"]){ $_POST["offset"] = checkNumeric($_POST["offset"]); }
	//===============================================================================

//include("language/language.php");
include("webboard_log.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
			$lang_sh1 = explode('___',$F[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			include("language/language".$lang_sh.".php");
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$F = $db->db_fetch_array($sql_temp);
$design_id = $F["d_id"];

$global_theme = $F["d_bottom_content"];
$mainwidth = "0";

$target = '_self';
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);

  if($TTYPE !='Y'){
	$wh= "AND w_question.s_id = '1'";
	}
	
$subsql='';
if($orderby==''){
    $orderby='t_id';
	$adesc='DESC';
}else{
     $orderby=$orderby;
	  if($orderby=='answers'){
	       $subsql=",  (SELECT COUNT(a_id) FROM w_answer WHERE t_id = w_question.t_id AND s_id = '1') as answers";
	  }//t_count
	  if($adesc=='DESC'){  $adesc='ASC';  }else{  $adesc='DESC';  }
}
$sel = "SELECT * $subsql  FROM  w_question  WHERE t_sts=1 AND w_question.c_id = '$wcad'  $wh ORDER BY  $orderby  $adesc"; 
?>

<script>
function orderby(field,adesc){
     
     location.href='index_question.php?orderby='+field+'&adesc='+adesc+'&wcad=<?php echo $wcad;?>&TTYPE=<?php echo $TTYPE?>&filename=<?php echo  $filename?>';
}
</script>

<?php
//echo  $sel;
function CheckVulgar($msg){
$BanWord="***";
$Sql="SELECT * FROM vulgar_table";
$ExecSql=  mysql_query($Sql);
$total=mysql_num_rows($ExecSql);
if($total>0){
while($R=mysql_fetch_array($ExecSql)){
$Vtext=$R['vulgar_text'];
$msg=eregi_replace($Vtext,$BanWord,$msg);
}
}
return $msg;
}

   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = $CO[c_number];
if(empty($limit)){
$limit = 10;
}
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = $db->query($Show);

$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);

if($QQ["c_rss"]=='Y'){
			 $filename01="rss/webboard".$QQ["c_id"].".xml";
			 if(file_exists($filename01)){
			     $link='<a href="rss/webboard'.$QQ["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0" align="absmiddle"> </a>';
			 }else{
			     $link='';
			 }
		}else{ $link='';
		}
if(($QQ[c_view] == "2" || $QQ[c_view] == "3" ) AND $_SESSION["EWT_MID"] == ""){
 
?>
<script language="JavaScript">
alert("<?php echo $text_genwebboard_alertlogin;?>");
top.location.href="ewt_login.php?fn=index_question.php?wcad=<?php echo $wcad; ?>&t=<?php echo $_GET[t];?>";
</script>
<?php
exit;
}
if(($QQ[c_view] == "3"   AND $_SESSION["EWT_MID"] != "" AND ($_SESSION["EWT_TYPE_ID"]  != 1)) && $TTYPE != 'Y'){
?>
<script language="JavaScript">
alert("<?php echo $text_genwebboard_alertnotview;?>");
window.location.href = "m_webboard.php?t=<?php echo $_GET[t];?>";
</script>
<?php
}
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php if($MyTitle==""){?>===== Welcome =====<?php }else{ echo $MyTitle; }?></title>
<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-weight: bold;
}
.style2 {color: #000000}
.style4 {font-size: 14}
-->
</style>
<?php
include("ewt_script.php");	
?></head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"];?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>">
	<?php
			$mainwidth = $F["d_site_content"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
	   <tr>
        <td width="50%"><table border="0" cellpadding="3" cellspacing="0" class="styleMe">
          <form name="formSearchWEBB" method="post" action="search_result.php?filename=<?php echo $filename; ?>&search_mode=4" target="<?php echo $target;?>">
            <tr>
              <td align="right"><input type="text" name="keyword" class="styleMe">
                  <input type="submit" name="search" value="<?php echo $text_genwebboard_buttom_search; ?>" class="styleMe">              </td>
            </tr>
          </form>
        </table></td>
        <td width="50%" align="right"><table border="0" cellspacing="0" cellpadding="1">
          <tr>
            <td align="right"><img src="mainpic/webboard_bullet.gif" align="absmiddle">
               <?php 	if($_SESSION["EWT_MID"] != ""){ echo ereg_replace("<#username#>","".$_SESSION["EWT_NAME"]."",$text_GenLogoin_textwelcome); ?>
              &nbsp; &nbsp;<a href="#change" onClick="window.open('member_pwd.php','','width=300,height=200');">
                <!--&lt;&lt; 
      เปลี่ยนรหัสผ่าน-->
                </a> &nbsp; |&nbsp;<a href="logout.php"> <?php echo $text_GenLogout_name;?> </a>
              <?php }else{ ?>
              <a href="ewt_login.php?fn=<?php echo urlencode("index_question.php?t=".$_GET[t]."&filename=".$_GET[filename]."&wcad=".$_GET[wcad]); ?>"><strong><?php echo $text_GenLogin_name;?></strong></a>
              <?php } ?></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
	   </tr>
	   <?php
	      if($_GET[t] != '' && $_GET[t] != '0'){
				$_GET[t] = $_GET[t];
			}else{
				$_GET[t] = $global_theme;
			}
	   if($_GET[t]){
	   $namefolder = "themes".($_GET[t]);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		$bg_width  ='100%';
		//	if($themes_type == 'F'){
			$buffer = "";
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
			$fd = @fopen ($Current_Dir1.$themes_file, "r");
			 while (!@feof ($fd)) {
			$buffer .= @fgets($fd, 4096);
			 }
			@fclose ($fd);
			$design = explode('<?php#htmlshow#?>',$buffer);
		 }
		}else{
			$bg_img='';
			$bg_color='#646464';
			$bg_width='100%';
			$head_img='';
			$head_color='#DADADA';
			$head_font_face='';
			$head_font_face2='';
			$head_font_size='';
			$head_font_size2='';
			$head_font_color='#000000';
			$head_font_color2='#000000';
			$head_height='30';
			$body_bg_img='';
			$body_color='#FFFFFF';
			$body_font_face='';
			$body_font_face2='';
			$body_font_face3='';
			$body_font_size='12px';
			$body_font_size2='11px';
			$body_font_size3='9px';
			$body_font_color='#000000';
			$body_font_color2='#000000';
			$body_font_color3='#CC0000';
			$bottom_img='';
			$bottom_color='';
			$bottom_height='0';
			$Current_Dir1 = "";
		}
			if($lang_sh != ''){
		   $QQ[c_name] = select_lang_detail($wcad,$lang_shw,"c_name",w_cate);
		   }
	   ?>
      <tr>
        <td colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="2"><?php echo $design[0];?><table width="<?php echo $bg_width;?>"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
                        <tr>
                          <td height="23">&nbsp;&nbsp;<strong ><a href="m_webboard.php?t=<?php echo $_GET[t];?>&filename=<?php echo $_GET[filename];?>"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>"><?php echo $text_genwebboard_pagemain;?></span></font></span></a><img src="mainpic/arrow_r.gif" width="7" height="7" align="absmiddle"> <a href="index_question.php?wcad=<?php echo $wcad; ?>&t=<?php echo $_GET[t];?>&filename=<?php echo $_GET[filename];?>"><span class="text_normal"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>"><?php echo $QQ[c_name]; ?></span></font></span></a>&nbsp;&nbsp;&nbsp;<?php echo $link;?></strong></td>
                          <td width="11"><div align="right"><?php if($themes_type != 'F'){ ?><img src="mainpic/content_r2_c4.gif" width="10" height="23"><?php }?></div></td>
                        </tr>
                      </table>
                        <!--#F4F4F4-->
                        <table  width="<?php echo $bg_width;?>"  border="0" align="center" cellpadding="3" cellspacing="2" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
						 <tr >
                                <td colspan="2" valign="top" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><a href="addquestion.php?wcad=<?php echo $wcad; ?>&t=<?php echo $_GET[t]?>&filename=<?php echo $_GET[filename];?>"><img src="mainpic/contact.gif" width="16" height="16" border="0" align="absmiddle"><span class="text_head"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size:<?php echo $head_font_size2;?>"><?php echo $text_genwebboard_newboard;?></span></font></span></a></td>
                          </tr>
                          <tr>
                            <td colspan="2" width="100%" valign="top" class="text11" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_img;?>"s><!--Content-->
                                <table width="98%" height="0" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><!--detail-->
                                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                                          <tr>
                                            <td align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_img;?>"><table width="100%" border="0" align="left" cellpadding="4" cellspacing="0">
                                            <tr> 
                                              <td colspan="2" align="left" ><strong><span class="text_normal"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size:<?php echo $head_font_size2;?>">&nbsp;<?php echo $text_genwebboard_headboard;?></span></font></span></strong></td>
                                              <td width="20%" align="center" ><strong><span class="text_normal"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size:<?php echo $head_font_size2;?>"><?php echo $text_genwebboard_bypost;?></span></font></span></strong></td>
                                              <td width="5%" align="center" ><a href="javascript:orderby('t_count','<?php echo $adesc;?>')"><strong><span class="text_normal"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size:<?php echo $head_font_size2;?>"><?php echo $text_genwebboard_byread;?></span></font></span></strong></a></td>
                                              <td width="5%" align="center" ><a href="javascript:orderby('answers','<?php echo $adesc;?>')"><strong><span class="text_normal"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size:<?php echo $head_font_size2;?>"><?php echo $text_genwebboard_numanw;?></span></font></span></strong></a></td>
                                              <td width="20%" align="center" ><strong><span class="text_normal"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size:<?php echo $head_font_size2;?>"><?php echo $text_genwebboard_RepliesLate;?></span></font></span></strong></td>
                                            </tr>
                                            <tr> 
                                              <td colspan="6" bgcolor="#DEDCDE" height="1"></td>
                                            </tr>
                                            <?php
											  if($rows > 0){
											  $nu = $rows - $offset;
											   while($R = mysql_fetch_array($Execsql)){ 
											    $db->query("USE ".$EWT_DB_USER);
													$sql_img = "select * from gen_user where gen_user_id = '$R[user_id]'";
													$query = $db->query($sql_img);
													$rec_img = $db->db_fetch_array($query);
													
													$db->query("USE ".$EWT_DB_NAME);
											 if($R[user_id] == '0'){
												if($R[q_name] != ""){ 
													$name_a = stripslashes($R[q_name]); 
													$name_u = "";
													$mail = $R[q_email];
												}
											}else{
												if($rec_img[webb_name] != ''){
													$name_a = stripslashes($rec_img[webb_name]); 
													$name_u = "";
												}else{
													$name_a = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
													$name_u = "";
													//$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
												}
												$mail = $rec_img[email_person];
											}
											   $count = $db->query("SELECT * FROM w_answer WHERE t_id = '$R[t_id]' AND s_id = '1' ORDER BY a_id DESC");
											   $countrow = mysql_num_rows($count);
											   $Z = mysql_fetch_array($count);
											   $timer = explode("-",$R[t_date]); 
											    if($lang_sh1[1] != ''){
													  $YearT = $timer[0];
													  }else{
													  $YearT = $timer[0]+543;
													  } ;
											    $db->query("USE ".$EWT_DB_USER);
												$sql_img = "select * from gen_user where gen_user_id = '$Z[user_id]'";
												$query = $db->query($sql_img);
												$rec_img = $db->db_fetch_array($query);
												$db->query("USE ".$EWT_DB_NAME);
												if($Z[user_id] == '0'){
													if($Z[a_name] != ""){ 
														$name_aa = stripslashes($Z[a_name]); 
														$name_ua = "";
														$mail2 = $Z[a_email];
													}
												}else{
													if($rec_img[webb_name] != ''){
														$name_aa = stripslashes($rec_img[webb_name]); 
														$name_ua = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
													}else{
														$name_aa = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
														$name_ua = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
														//$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
													}
													$mail2 = $rec_img[email_person];
												}
											   ?>
                                            <tr> 
                                              <td  width="5%" valign="top"><img src="mainpic/edit_user.gif"></td>
                                              <td valign="top"><a href="index_answer.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $R[t_id]; ?>&t=<?php echo $_GET[t]?>&filename=<?php echo $_GET[filename];?>" target="<?php echo $target;?>"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">
                                                <?php  $name =  stripslashes($R[t_name]);  echo CheckVulgar($name); ?>
                                              </span></font></span></a></td>
                                              <td align="center" valign="top"> 
                                               <span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>"><span style="font-size:<?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"> <?php  echo stripslashes($name_a); ?> <?php if(!empty($mail)){ ?><a href="mailto:<?php echo $mail; ?>"><img src="mainpic/m_mail.gif" border="0" alt="<?php echo $mail; ?>"></a><?php } ?></span></font></span>
                                                <br> <span class="text_normal"><font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>"><span style="font-size:<?php echo $body_font_size3;?>"> (<?php echo $timer[2]."/".$timer[1]."/".$YearT." ".$R[t_time]; ?>)</span></font></span></td>
                                              <td align="center" valign="top"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>"><span style="font-size:<?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $R[t_count]; ?></span></font></span></td>
                                              <td align="center" valign="top"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>"><span style="font-size:<?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"><?php echo $countrow; ?></span></font></span></td>
                                              <td align="center" valign="top"> <span class="text_normal"><font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>"><span style="font-size:<?php echo $body_font_size3;?><?php  if($body_font_italic3=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold3=='Y'){ ?>;font-weight:bold<?php } ?>">
                                                <?php if($countrow > 0){ ?>
                                                <div><?php echo stripslashes($name_aa); ?><?php if(!empty($mail2)){ ?><a href="mailto:<?php echo $mail2; ?>"><img src="mainpic/m_mail.gif" border="0" alt="<?php echo $mail2; ?>"></a><?php } ?></div>
                                                <span class="text_normal"><font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>"><span style="font-size:<?php echo $body_font_size3;?>">( 
                                                <?php $timer = explode("-",$Z[a_date]); 
													 if($lang_sh1[1] != ''){
													  $YearT = $timer[0];
													  }else{
													  $YearT = $timer[0]+543;
													  } ; ?>
                                                <?php echo $timer[2]."/".$timer[1]."/".$YearT." ".$Z[a_time]; ?> 
                                                )</span></font></span>
                                                <?php }else{ echo "<center>-</center>"; } ?>       </span></font></span>                                       </td>
                                            </tr>
                                            <tr> 
                                              <td colspan="6" bgcolor="#DEDCDE" height="1"></td>
                                            </tr>
                                            <?php $nu--; }}else{ ?>
                                            <tr > 
                                              <td height="30" colspan="11"><div align="center"><font color="#FF0000"><span class="text_normal"><font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>"><span style="font-size:<?php echo $body_font_size3;?>"><strong><?php echo $text_genwebboard_nodata;?></strong></span></font></span></font></div></td>
                                            </tr>
                                            <?php } ?>
                                            <tr > 
                                              <td height="30" colspan="11"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>"><?php echo $text_general_page;?>: 
                                                <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='index_question.php?offset=$prevoffset&wcad=$wcad&t=".$_GET[t]."&filename=".$_GET[filename]."'>
<font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ".$text_general_previous."</font></a>\n\n";
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
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">[ $i ] </font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='index_question.php?offset=$newoffset&wcad=$wcad&t=".$_GET[t]."&filename=".$_GET[filename]."' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='index_question.php?offset=$newoffset&wcad=$wcad&t=".$_GET[t]."&filename=".$_GET[filename]."'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">".$text_general_next.">></font></a>"; 
    }
?>                                              </span></font></span></td>
                                            </tr>
                                          </table></td>
                                          </tr>
                                        </table>
                                      <!--detail-->                                    </td>
                                  </tr>
                                </table>
                              <!--Content-->                            </td>
                          </tr>
                      </table><?php echo $design[1];?></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
   
    </table></td>
          <td id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth = $F["d_site_right"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>
<?php $db->db_close(); ?>