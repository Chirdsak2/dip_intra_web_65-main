<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

	include("ewt_template.php");
	if($_REQUEST["keyword"] != "") {
		$_REQUEST["keyword"] = stripslashes(htmlspecialchars(trim($_REQUEST["keyword"]),ENT_QUOTES));
	}
	

	if($oper == "") { $oper = "OR"; }
	if($search_mode == "") { $search_mode = "1"; }
	function cuttag($tag) {
		$search = array (
			"'<script[^>]*?>.*?</script>'si",  // Strip out javascript
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
		
		$RReplace = array (
			"",
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
		
		$detail = preg_replace ($search, $RReplace, $tag);
		return $detail;
	}
	if($_REQUEST["date_s"] != "") {
		$sh_date = "date_s=".$_REQUEST["date_s"]."&";
	}
	if($_REQUEST["date_e"] != "") {
	$sh_date .= "date_e=".$_REQUEST["date_e"]."&";
	}
	if($_REQUEST["g"] != "") {
	$sh_date .= "g=".$_REQUEST["g"]."&";
	}
	if (!empty($offset)) { 
        $page .= "offset=".$offset."&";
    } 
	if (!empty($p)) { 
        $page .= "p=".$p."&";
    }

			if($_SERVER["REMOTE_ADDR"]){
						$ip_address = $_SERVER["REMOTE_ADDR"];
					}else{
						$ip_address = $_SERVER["REMOTE_HOST"];
					}
	 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
<?php include("ewt_script.php");?>
<script language="javascript"  type="text/javascript">
	function ajax_search_word(keyword_b) {
		document.formSearchAEWT.keyword.value = keyword_b;
		ajax_search(document.formSearchAEWT.search_mode.value);
	}
	
	function ajax_search(tab) {
		if(tab == '0') {
			document.formgoogle.q.value=document.formSearchAEWT.keyword.value;
			formgoogle.submit();
		} else {
			var objDiv = document.getElementById("divSearchResult");
			document.formSearchAEWT.search_mode.value=tab;
			var keyword = document.formSearchAEWT.keyword.value;
			var search_mode = document.formSearchAEWT.search_mode.value;
			var filename = document.formSearchAEWT.filename.value;
			if(document.formSearchAEWT.oper[0].checked == true) {
				oper = document.formSearchAEWT.oper[0].value;
			} else {
				oper = document.formSearchAEWT.oper[1].value;
			}
			var ip_address = '<?php echo $ip_address; ?>';
			var sh_date_now = '<?php echo $sh_date;?>';
			if(tab != '<?php echo $search_mode; ?>'){
			var page_now = '';
			}else{
			var page_now = '<?php echo $page;?>';
			}
			changebg(eval(tab))
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
	}
	function findPosX(obj) {
		var curleft = 0;
		if (document.getElementById || document.all) {
			while (obj.offsetParent) {
				curleft += obj.offsetLeft
				obj = obj.offsetParent;
			}
		}
		else if (document.layers)
		curleft += obj.x;
		return curleft;
	}
	
	function findPosY(obj) {
		var curtop = 0;
		if (document.getElementById || document.all) {
			while (obj.offsetParent) {
				curtop += obj.offsetTop
				obj = obj.offsetParent;
			}
		}
		else if (document.layers)
		curtop += obj.y;
		return curtop;
	}
	
	function txt_data(w) {
		var mytop = findPosY(document.formSearchAEWT.keyword) + document.formSearchAEWT.keyword.offsetHeight;
		var myleft = findPosX(document.formSearchAEWT.keyword);	
		var objDiv = document.getElementById("nav");
		objDiv.style.top = mytop;
		objDiv.style.left = myleft;
		objDiv.style.display = '';
		url='ewt_nav_pad.php?d='+ w;
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
function changebg(tab){
var objDiv = document.getElementById("divSearchMenu");
url='ewt_search_tab.php?search_mode='+ tab;
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
</head>
<body<?php if($F["d_site_bg_c"] != ""){ echo " bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo " background=\"".$F["d_site_bg_p"]."\""; } ?>>
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
<table <?php if($F["d_site_width"] != ""){ echo "width=\"".$F["d_site_width"]."\""; } ?> border="0" cellpadding="0" cellspacing="0" <?php if($F["d_site_align"] != ""){ echo "align=\"".$F["d_site_align"]."\""; } ?>>
  <tr>
    <td  <?php if($F["d_top_height"] != ""){ echo "height=\"".$F["d_top_height"]."\""; } ?> <?php  if($F["d_top_bg_c"] != ""){ echo "bgcolor=\"".$F["d_top_bg_c"]."\""; } ?>  colspan="3" >
	  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
	</td>
  </tr>
  <tr>
    <td <?php if($F["d_site_left"] != ""){ echo "width=\"".$F["d_site_left"]."\""; } ?> <?php  if($F["d_left_bg_c"] != ""){ echo "bgcolor=\"".$F["d_left_bg_c"]."\""; } ?>>
	  <?php
			$mainwidth = $F["d_site_left"];
			?>
<?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?></td>
    <td height="160"  <?php if($F["d_site_content"] != ""){ echo "width=\"".$F["d_site_content"]."\""; } ?> <?php  if($F["d_body_bg_c"] != ""){ echo "bgcolor=\"".$F["d_body_bg_c"]."\""; } ?>>
	<?php
			$mainwidth = $R["d_site_content"];
			?>
		<form name="formgoogle" method="get" action="http://www.google.co.th/search" target="_blank">
					<input type="hidden" name="q">
			</form>
			<form name="formSearchAEWT" method="get" action="search_result.php">
		<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
				<tr> 
					<td>
						<div id="divSearchMenu">&nbsp;</div>
				  </td>
		  </tr>
				<tr align="right"> 
					<td  >
						ค้นหา 
						<input name="keyword" type="text" id="keyword"  size="30" value="<?php echo stripslashes(trim($_REQUEST["keyword"])); ?>" onKeyUp="txt_data(this.value)"  > 
						<input name="search_mode" type="hidden" id="search_mode" value="<?php echo $search_mode; ?>">
						<input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>">
						<input type="button" name="Submit" value=" ค้นหา... " onClick="ajax_search('<?php echo $search_mode;?>')">
						<br>
						<input name="oper" type="radio" value="OR" <?php if($oper == "OR"){ echo "checked"; } ?>>
						ค้นหาเฉพาะ<strong><font color="#FF0000">บางคำ</font></strong>  
						<input type="radio" name="oper" value="AND" <?php if($oper == "AND"){ echo "checked"; } ?>>
						ค้นหา<strong><font color="#FF0000">ทุกเงื่อนไข</font></strong>
				  </td>
				</tr>
				<tr> 
					<td   >
					<script language="JavaScript" type="text/javascript">
					document.formSearchAEWT.keyword.focus();
					//changebg('<?php echo $search_mode; ?>');
				</script>
					<div id="divSearchResult">&nbsp;</div>
					</td>
				</tr>
		  </table>
		</form>
	</td>
    <td <?php if($F["d_site_right"] != ""){ echo "width=\"".$F["d_site_right"]."\""; } ?> <?php  if($F["d_right_bg_c"] != ""){ echo "bgcolor=\"".$F["d_right_bg_c"]."\""; } ?>>
	 <?php
			$mainwidth =  $F["d_site_right"];
			?>
	<?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?></td>
  </tr>
  <tr valign="top" > 
          <td  colspan="3"  valign="top"  <?php if($F["d_bottom_height"] != ""){ echo "height=\"".$F["d_bottom_height"]."\""; } ?> <?php  if($F["d_bottom_bg_c"] != ""){ echo "bgcolor=\"".$F["d_bottom_bg_c"]."\""; } ?> <?php if($F["d_bottom_bg_p"] != ""){ echo "background=\"".$F["d_bottom_bg_p"]."\""; } ?>>	 
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
</table>
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
<script type="text/javascript" language="javascript">
<?php
						if($search_mode != "") {
							?>
							ajax_search('<?php echo $search_mode; ?>');
							<?php
						}
?>
</script>
</body>
</html>
<?php $db->db_close(); ?>