<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	$db=new PHPDB($EWT_DB_TYPE,$EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD,$EWT_DB_USER );
	$connectdb=$db->CONNECT_SERVER();
	$db->query("USE ".$EWT_DB_NAME);
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	$sql_Mindex = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
	$MF = $db->db_fetch_array($sql_Mindex);
	$ewt_mytitle = "";
	$ewt_mykeyword = "";
	$ewt_mydescription = "";
	$sql_website = $db->query("SELECT site_info_title,site_info_keyword,site_info_description FROM site_info  ");
	$SF = $db->db_fetch_array($sql_website);
	if($MF["title"] != ""){
		$ewt_mytitle = addslashes($MF["title"]);
	}else{
		$ewt_mytitle = addslashes($SF["site_info_title"]);
	}
	if($MF["cms_keyword"] != ""){
		$ewt_mykeyword = addslashes($F["cms_keyword"]);
	}else{
		$ewt_mykeyword = addslashes($SF["site_info_keyword"]);
	}
	if($MF["cms_description"] != ""){
		$ewt_mydescription = addslashes($MF["cms_description"]);
	}else{
		$ewt_mydescription = addslashes($SF["site_info_description"]);
	}

		if($_GET["filenametemplate"] == ''){
		$_GET["filenametemplate"] = 'index';
		}
			$lang_sh = explode('___',$_GET["filename"]);
		if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
		$sql_index = $db->query("SELECT * FROM design_list WHERE d_name = '".$_GET["filenametemplate"]."' ");
		$F = $db->db_fetch_array($sql_index);
	$file_template2 ='template_html/template_'.$F[d_id].'.php';
if (file_exists($file_template2)) {
				$fw = @fopen($file_template2, "r");
				 if($fw){ 
					while($html = @fgets($fw, 1024)){
					$line .= $html;
					}
				}
				if($F["d_html"] == 'Y' && $MF["html"] == 'Y'){
					$logo_used .= file_get_contents("bottom_401.html"); 
					}
					if($F["d_wcag"] == 'Y' && $MF["wcag"] == 'Y'){
					$logo_used .= file_get_contents("bottom_wcag.html"); 
					}
					if($F["d_css"] == 'Y' && $MF["css"] == 'Y'){
					$logo_used .= file_get_contents("bottom_css.html"); 
					}
					$arr_html = split("#htmlw3c_spliter#",$line,2);
								
							echo	$newcontents = $arr_html[0].$logo_used.$arr_html[1];
}else{
	$ewt_mykeyword = eregi_replace(chr(13)," ",$ewt_mykeyword);
	$ewt_mykeyword = eregi_replace("  "," ",$ewt_mykeyword);
	$ewt_mydescription = eregi_replace(chr(13)," ",$ewt_mydescription);
	$ewt_mydescription = eregi_replace("  "," ",$ewt_mydescription);
		$use_template = $F["d_id"];
		if($use_template != ""){
		$_GET["d_id"] =$use_template;
		}else{
		$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'W'  ");
		$FF = $db->db_fetch_array($sql_index);
		$d_idtemp = $FF[d_id];
		$_GET["d_id"] =$d_idtemp;
		}
	$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
	$sql_temp= $db->query($temp);
	$RR = $db->db_fetch_array($sql_temp);

	$global_theme = $RR["d_bottom_content"];
	$mainwidth = "0";

			?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML lang="th">
<HEAD>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">

<?php
include("ewt_script.php");	
?>

</HEAD><body   <?php if($RR["d_site_bg_c"] != ""){ echo "bgcolor=\"".$RR["d_site_bg_c"]."\""; } ?> <?php if($RR["d_site_bg_p"] != ""){ echo "background=\"".$RR["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" <?php if($RR["d_site_width"] != ''){?>width="<?php echo $RR["d_site_width"]; ?>"<?php } ?> border="0" cellpadding="0" cellspacing="0"  <?php if($RR["d_site_align"] != ''){ ?>align="<?php echo $RR["d_site_align"]; ?>"<?php }?> >
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" <?php if($RR["d_top_bg_p"] != '' || $RR["d_top_bg_c"] != '' || $RR["d_top_height"] != ''){ ?>style=" <?php if($RR["d_top_bg_p"] != ''){ ?>background:url(<?php echo $RR["d_top_bg_p"]; ?>);<?php } ?> <?php if($RR["d_top_bg_c"] != ''){ ?>background-color:<?php echo $RR["d_top_bg_c"]; ?>; <?php } ?> <?php if($RR["d_top_height"] != ''){ ?>height:<?php echo $RR["d_top_height"]; ?>px;<?php } ?> " <?php } ?> colspan="3" >
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left"  <?php if($RR["d_site_left"] != ''){ ?>width="<?php echo $RR["d_site_left"]; ?>" <?php }?> <?php if($RR["d_left_bg_p"] != '' || $RR["d_left_bg_c"] != ''){?> style=" <?php if($RR["d_left_bg_p"] != ''){ ?>background:url(<?php echo $RR["d_left_bg_p"]; ?>);<?php } ?><?php if($RR["d_left_bg_c"] != ''){?> background-color:<?php echo $RR["d_left_bg_c"]; ?><?php } ?>" <?php } ?>>
		  <?php
			$mainwidth = $RR["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" <?php if($RR["d_site_content"] != ''){ ?> width="<?php echo $RR["d_site_content"]; ?>" <?php } ?> style=" <?php if($RR["d_body_bg_p"] != ''){?>background:url(<?php echo $RR["d_body_bg_p"]; ?>);<?php } ?><?php if($RR["d_body_bg_c"] != ''){?> background-color:<?php echo $RR["d_body_bg_c"]; ?>;<?php }?> height:160px;">#w3c_spliter#
	<?php
			$mainwidth = $RR["d_site_content"];
			?><?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		<?php } ?>
        
	</td>
          <td id="ewt_main_structure_right"  <?php if($RR["d_site_right"] != ''){ ?>width="<?php echo $RR["d_site_right"]; ?>"<?php } ?><?php if($RR["d_right_bg_p"] != '' || $RR["d_right_bg_c"] != ''){ ?>style="<?php if($RR["d_right_bg_p"] != ''){ ?>background:url(<?php echo $RR["d_right_bg_p"]; ?>);<?php } ?><?php if($RR["d_right_bg_c"] != ''){ ?> background-color:<?php echo $RR["d_right_bg_c"]; ?>;<?php } ?>" <?php } ?> >
		  <?php
			$mainwidth = $RR["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($RRB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RRB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td   id="ewt_main_structure_bottom"  <?php if($RR["d_bottom_bg_p"] != '' || $RR["d_bottom_bg_c"] != '' || $RR["d_bottom_height"] != ''){?>style=" <?php if($RR["d_bottom_bg_p"] != ''){ ?>background:url(<?php echo $RR["d_bottom_bg_p"]; ?>);<?php } ?><?php if($RR["d_bottom_bg_c"] != ''){?> background-color:<?php echo $RR["d_bottom_bg_c"]; ?>;<?php } ?><?php if($RR["d_bottom_height"] != ''){?> height:<?php echo $RR["d_bottom_height"]; ?>px;<?php } ?>" <?php }?> colspan="3">
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
		<tr><td colspan="3" align="center"><?php  include("ewt_span.php");?>
		<?php 
		$page_manual = file_exists("checked/".$_GET["filename"].".php");
		$html_tp = $F["d_html"];
		$wcag_tp = $F["d_wcag"];
		$css_tp = $F["d_css"];
		if($F["d_html"] == 'Y' && $MF["html"] == 'Y'){
		$logo2 = file_get_contents("bottom_401.html"); 
		}
		if($F["d_wcag"] == 'Y' && $MF["wcag"] == 'Y'){
		$logo2 .= file_get_contents("bottom_wcag.html"); 
		}
		if($F["d_css"] == 'Y' && $MF["css"] == 'Y'){
		$logo2 .= file_get_contents("bottom_css.html"); 
		}
		if(file_exists("checked/".$_GET["filename"].".php") ) { //page manual
				function showiconw3c($filename,$type,$page_type){
					global $db,$EWT_DB_NAME;
					$db->query("USE w3c_ictweb");
					$sql = "select * from webpage_info where filename = '".$filename."' and page_type ='".$page_type."' and db_name = '".$EWT_DB_NAME."'";
					$query = $db->query($sql);
					$R = $db->db_fetch_array($query);
					$db->query("USE ".$EWT_DB_NAME);
					if($type == '1'){
					return $html = $R["w3c_html"];
					}else if($type == '2'){
					return $wai = $R["w3c_wcag"];
					}else if($type == '3'){
					return $css = $R["w3c_css"];
					}
				}
					$page_html = showiconw3c($_GET["filename"],'1','1');
					$page_wai= showiconw3c($_GET["filename"],'2','1');
					$page_css = showiconw3c($_GET["filename"],'3','1');
						if($page_html == 'w3c' && $html_tp == 'Y'){
						$logo = file_get_contents("bottom_401.html"); 
						}
						if($page_wai == 'w3c' && $wcag_tp == 'Y'){
						$logo .= file_get_contents("bottom_wcag.html"); 
						}
						if($page_css == 'w3c' && $css_tp == 'Y'){
						$logo .= file_get_contents("bottom_css.html"); 
						}
						echo $logo;
		}else if($_GET["n_id"] != '' || $logo2 == '' || $_GET["c_id"] != ''){
		echo "#htmlw3c_spliter#";
		}else{ //auto tween
			echo $logo2;
		}
	?></td></tr>
      </table>
	  
</body>
</html>
<?php }
$db->db_close(); ?>
