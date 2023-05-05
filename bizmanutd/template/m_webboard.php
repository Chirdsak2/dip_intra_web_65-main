<?php
session_start();
//session_destroy();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
	//=========================================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($t){ $t=checkNumeric($t); }
	if($_GET[t]){ $_GET[t]=checkNumeric($_GET[t]); }
	if($_POST[t]){ $_POST[t]=checkNumeric($_POST[t]); }
	if($_REQUEST[t]){ $_REQUEST[t]=checkNumeric($_REQUEST[t]); }
	//========================================================================
//include("language/language.php");
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
		if($_GET[t] != '' && $_GET[t] != '0'){
				$_GET[t] = $_GET[t];
			}else{
				$_GET[t] = $global_theme;
			}
		if($_GET[t]){
	   $namefolder = "themes".($_GET[t]);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		$bg_width  ='100%';
		 //if($themes_type == 'F'){
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
	$Execsql = $db->query("SELECT * FROM w_cate 
		INNER JOIN lang_w_cate ON lang_w_cate.c_id =w_cate.c_id
		INNER JOIN lang_config ON lang_config.lang_config_id = lang_w_cate.lang_name 
		WHERE  c_use = 'Y' and lang_field = 'c_name' ORDER BY w_cate.c_level,w_cate.c_id ASC");
	}else{
$Execsql = $db->query("SELECT * FROM w_cate WHERE c_use = 'Y' ORDER BY c_level,c_id ASC");
}
$row = mysql_num_rows($Execsql);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php if($MyTitle==""){?>===== Welcome =====<?php }else{ echo $MyTitle; }?></title>
<?php
include("ewt_script.php");	
?>
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
</head>
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
          
    <td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>">
	<?php
			$mainwidth = $F["d_site_content"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
	<?php echo $design[0];?><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		 <tr>
            <td width="50%"><table border="0" cellpadding="3" cellspacing="0" class="styleMe">
              <form name="formSearchWEBB" method="post" action="search_result.php?filename=<?php echo $filename; ?>&search_mode=4" target="_blank">
                <tr>
                  <td align="left"><input type="text" name="keyword" class="styleMe">
                    <input type="submit" name="search2" value="<?php echo $text_genwebboard_buttom_search;?>" class="styleMe"></td>
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
                    </a> &nbsp; |&nbsp;<a href="ewt_login.php"> <?php echo $text_GenLogout_name;?> </a>
                  <?php }else{ ?>
                  <a href="ewt_login.php?fn=m_webboard.php?t=<?php echo $_GET[t]?>&filename=<?php echo $filename; ?>"><strong><?php echo $text_GenLogin_name;?></strong></a>
                  <?php } ?></td>
              </tr>
            </table></td>
		 </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="2"><!--<table width="<?php echo $bg_width;?>"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
                            <tr>
                              <td width="17">&nbsp;</td>
                              <td height="23">&nbsp;</td>
                              <td width="11"><div align="right"><?php if($themes_type != 'F'){ ?><img src="mainpic/content_r2_c4.gif" width="10" height="23"><?php }?></div></td>
                            </tr>
                          </table>-->
                          
                            <table width="<?php echo $bg_width;?>" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>">
                              
                          <tr> 
                            <td colspan="2" width="100%" valign="top" class="text11"  bgcolor="<?php echo $body_color;?>"><table width="100%" border="0" align="left" cellpadding="3" cellspacing="0">
                                                    <tr>
                                                      <td colspan="4"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td align="center"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>"><?php echo $text_genwebboard_cat;?></span></font></span></td>
           <td width="20%" align="center"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>"><?php echo $text_genwebboard_numqu;?></span></font></span></td>
           <td width="20%" align="center"><span class="text_head"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size:<?php echo $head_font_size;?>"><?php echo $text_genwebboard_numanw;?></span></font></span></td>
         </tr>
       </table></td>
                                                    </tr>
                                                    <tr>
                                                      
                                              <td colspan="2"  height="3"></td>
                                                    </tr>
													<?php
													//$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
													//$QQ= mysql_fetch_array($Execsql1);
													 if($row > 0){
													   while($R = mysql_fetch_array($Execsql)){ 
													   if($lang_sh != ''){
													   $R[c_name] = $R[lang_detail];
													   $R[c_detail] = select_lang_detail($R[c_id],$lang_shw,"c_detail",w_cate);
													   }
													   if($R["c_rss"]=='Y'){
																 $filename="rss/webboard".$R["c_id"].".xml";
																 if(file_exists($filename)){
																	 $link='<a href="rss/webboard'.$R["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0"> </a>';
																 }else{
																	 $link='';
																 }
															}else{ $link='';
															}
													 $count = $db->query("SELECT * FROM w_question WHERE c_id = '$R[c_id]' AND s_id = '1' AND t_date >= '$dateshowl'");
   $countrow = mysql_num_rows($count);
  $count1 = $db->query("SELECT DISTINCT(w_answer.a_id) FROM w_answer,w_question WHERE w_question.t_id = w_answer.t_id AND w_question.c_id = '$R[c_id]' AND w_answer.s_id = '1' ");
   $countrow1 = mysql_num_rows($count1);
   ?>
    <tr onMouseOver="this.style.backgroundColor='#E7E7E7'" onMouseOut="this.style.backgroundColor='<?php echo $body_color;?>'"  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"> 
      <td width="4%" align="center" valign="top"><br >
        <?php if($R[c_view] == "Y"){ ?><img src="mainpic/lock.gif" width="24" height="24"><?php }else{ ?><img src="mainpic/book_blue.gif" width="24" height="24"><?php } ?></td>
      
    <td  valign="top" >
	 <a href="index_question.php?wcad=<?php echo $R[c_id]; ?>&t=<?php echo $_GET[t]?>&filename=<?php echo $_GET[filename];?>" target="<?php echo $target;?>" ><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>"><?php  echo stripslashes($R[c_name]); ?></span></font></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $link;?></div>
     	<span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>"><span style="font-size:<?php echo $body_font_size2;?>"><?php  echo stripslashes(nl2br ($R[c_detail])); ?></span></font></span></td>
      <td width="20%" align="center"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>"><?php echo $countrow; ?></span></font></span></td>
      <td width="20%"  align="center"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>"><?php echo $countrow1; ?></span></font></span></td>
    </tr>
													<?php } } ?>
                                                </table></td>
                              </tr>
                          </table></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
         
        </table><?php echo $design[1];?></td>
          <td  id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
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