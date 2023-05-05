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
	
	include("ewt_template.php");

					if($temp_html == 'w3c' && $page_html == 'w3c'){
						$logo = file_get_contents("bottom_401.html"); 
						}
						if($temp_wai == 'w3c' && $page_wai == 'w3c'){
						$logo .= file_get_contents("bottom_wcag.html"); 
						}
						if($temp_css == 'w3c' && $page_css == 'w3c'){
						$logo .= file_get_contents("bottom_css.html"); 
						}

	$db->access=200;
			//กรณีไม่มีการแปลง page ไว้จะแสดง auto
			echo $template_design[0];
			$mainwidth = $F["d_site_content"];
			?><?php
			
		  $sql_content = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' AND block.block_edit='Y' ORDER BY block_function.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		 // echo $CB[0];
		  ?>
<DIV><?php if($CB[1] == "text" OR $CB[1] == "code"  OR $CB[1] == "images" OR $CB[1] == "flash" OR $CB[1] == "media" OR $CB[1] == "menu" ){ echo stripslashes($CB[2]); }else{ echo show_block($CB[0]); } ?></DIV>
		<?php }		
	if(!session_is_registered("EWT_VISITOR_STAT")){
	session_register("EWT_REFERER");
	$_SESSION["EWT_REFERER"] = $HTTP_REFERER;
	}
	$end_time_counter = date("YmdHis");
	$gap = $end_time_counter - $start_time_counter;
?>
<script language="javascript" type="text/javascript">
document.write("<img src=\"../ewt_stat.php?t=page&uw3c=Y&filename=<?php echo $_GET["filename"]; ?>&load=<?php echo $gap; ?>&res="+screen.width+"x"+screen.height+"\" width=\"1\" height=\"1\" style=\"display:none\">");	
</script>
<?php 
echo eregi_replace("#htmlw3c_spliter#",$logo,$template_design[1]); 

?>

<?php $db->db_close(); ?>