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
	@include("../language/language".$lang_sh.".php");
	if($_REQUEST["keyword"] != "") {
		$_REQUEST["keyword"] = stripslashes(htmlspecialchars(trim($_REQUEST["keyword"]),ENT_QUOTES));
	}
	

	if($oper == "") { $oper = "OR"; }
	if($search_mode == "") { $search_mode = "2"; }
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
<?php echo $template_design[0];?>
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
			url='search_include1.php?'+sh_date_now+page_now+'keyword='+ keyword+'&search_mode='+search_mode+'&lang_sh=<?php echo $lang_sh;?>&filename='+filename+'&oper='+oper+'&ip_address'+ip_address;
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
url='ewt_search_tab.php?lang_sh=<?php echo $lang_sh;?>&search_mode='+ tab;
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
</script><?php
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
						<?php echo $text_gensearch_lblsearch;?>
						<input name="keyword" type="text" id="keyword"  size="30" value="<?php echo stripslashes(trim($_REQUEST["keyword"])); ?>"  alt="keyword"> <!--onKeyUp="txt_data(this.value)"  -->
						<input name="search_mode" type="hidden" id="search_mode" value="<?php echo $search_mode; ?>" alt="hidden">
						<input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>" alt="hidden">
						<input type="button" name="Submit" value=" <?php echo $$text_gensearch_buttonsubmit;?>... " onClick="ajax_search('<? echo $search_mode;?>')" alt="hidden">
						<br>
						<input name="oper" type="radio" value="OR" <?php if($oper == "OR"){ echo "checked"; } ?> alt="<?php echo $text_gensearch_lbl_select1_sub;?>">
						<?php echo $text_gensearch_lbl_select1;?>  
						<input type="radio" name="oper" value="AND" <?php if($oper == "AND"){ echo "checked"; } ?> alt="<?php echo $text_gensearch_lbl_select2_sub;?>">
						<?php echo $text_gensearch_lbl_select2;?>
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
		<script type="text/javascript" language="javascript">
<?php
						if($search_mode != "") {
							?>
							ajax_search('<?php echo $search_mode; ?>');
							<?php
						}
?>
</script>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>