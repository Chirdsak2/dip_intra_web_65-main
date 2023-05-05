<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");
	//include("language/language.php");
	$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
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

	if($_REQUEST["keyword"] != "") {
		$_REQUEST["keyword"] = stripslashes(htmlspecialchars(trim($_REQUEST["keyword"]),ENT_QUOTES));
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

	if($oper == "") { $oper = "OR"; }
	if($search_mode == "") { $search_mode = "1"; }
	function like_word($w) {
		global $db;
		global $EWT_DB_NAME,$EWT_DB_USER;
		if(trim($w) != "") {
			$like = "";
			$w = stripslashes(htmlspecialchars(trim($w),ENT_QUOTES));
			$db->query("USE ".$EWT_DB_USER);
			$sql_dict = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD = '".trim($w)."' ");
			if($db->db_num_rows($sql_dict) == 0) {
				$sql_dict1 = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '".trim($w)."%' ORDER BY DICT_WORD LIMIT 0,1");
				if($db->db_num_rows($sql_dict1) > 0) {
					$D = $db->db_fetch_row($sql_dict1);
					$like = $D[0];
				} else {
					$sql_dict2 = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '%".trim($w)."' ORDER BY DICT_WORD  LIMIT 0,1");
					if($db->db_num_rows($sql_dict2) > 0) {
						$D = $db->db_fetch_row($sql_dict2);
						$like = $D[0];
					} else {
						$countw = strlen($w);
						//if($countw > 2){
						for($x=1; $x<($countw); $x++) {
							$newword = substr($w, 0,-$x);
							$sql_dict3 = $db->query("SELECT DICT_WORD FROM dictionary WHERE DICT_WORD LIKE '".$newword."%' ORDER BY DICT_WORD LIMIT 0,1");
							if($db->db_num_rows($sql_dict3) > 0) {
								$D = $db->db_fetch_row($sql_dict3);
								$like = $D[0];
								$x = $countw;
							}
							//}
						}
					}
				}
			}
		}
		$db->query("USE ".$EWT_DB_NAME);
		return $like;
	}
	
	function next_word($w) {
		global $db;
		global $EWT_DB_NAME,$EWT_DB_USER;
		if(trim($w) != "") {
			$w = stripslashes(htmlspecialchars(trim($w),ENT_QUOTES));
			$db->query("USE ".$EWT_DB_USER);
			$like = "";
			$sql_dict1 = $db->query("SELECT DICT_SEARCH FROM dictionary WHERE DICT_WORD = '".trim($w)."' ");
			if($db->db_num_rows($sql_dict1) > 0) {
				$D = $db->db_fetch_row($sql_dict1);
				$like = trim($D[0]);
			}
			$db->query("USE ".$EWT_DB_NAME);
		}
		return $like;
	}
	
	function diff_word($w){
		global $db;
		global $EWT_DB_NAME,$EWT_DB_USER;
		if(trim($w) != "") {
			$w = stripslashes(htmlspecialchars(trim($w),ENT_QUOTES));
			$db->query("USE ".$EWT_DB_USER);
			$like = "";
			$sql_dict1 = $db->query("SELECT DICT_SYNONYM FROM dictionary WHERE DICT_WORD = '".trim($w)."' ");
			if($db->db_num_rows($sql_dict1) > 0) {
				$D = $db->db_fetch_row($sql_dict1);
				$like = trim($D[0]);
			}
			$db->query("USE ".$EWT_DB_NAME);
		}
		return $like;
	}
	
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
<html>
<head>
<title>Search Result...</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php include("ewt_script.php");	 ?>
</head>
<script language="javascript">
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
</script>
<script language="JavaScript">


function ChkStatus() {
	if(document.formSearchAEWT.search_mode.value == "1") {
		formSearchAEWT.action = "search_result.php";
		return true;
	} else if(document.formSearchAEWT.search_mode.value == "2") {
		formSearchAEWT.action = "search_images.php";
		return true;
	} else if(document.formSearchAEWT.search_mode.value == "3") {
		formSearchAEWT.action = "search_webboard.php";
		return true;
	} else if(document.formSearchAEWT.search_mode.value == "4") {
		formSearchAEWT.action = "search_faq.php";
		return true;
	}
}
</script>
<body  leftmargin="0" topmargin="0" <?php if($RR["d_site_bg_c"] != ""){ echo "bgcolor=\"".$RR["d_site_bg_c"]."\""; } ?> <?php if($RR["d_site_bg_p"] != ""){ echo "background=\"".$RR["d_site_bg_p"]."\""; } ?> onBlur="document.getElementById('nav').style.display='none';"  >
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
<table id="ewt_main_structure" width="<?php echo $RR["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $RR["d_site_align"]; ?>" onClick="document.getElementById('nav').style.display='none';">
	<tr  valign="top" > 
		<td id="ewt_main_structure_top" height="<?php echo $RR["d_top_height"]; ?>" bgcolor="<?php echo $RR["d_top_bg_c"]; ?>" background="<?php echo $RR["d_top_bg_p"]; ?>" colspan="3" >
			<?php
				$mainwidth = $RR["d_site_width"];
			?>
			<?php
				$sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($TB = $db->db_fetch_row($sql_top)) {
			?>
			<DIV><?php echo show_block($TB[0]); ?></DIV>
			<?php 
				} 
			?>
		</td>
	</tr>
	<tr valign="top" > 
		<td id="ewt_main_structure_left" width="<?php echo $RR["d_site_left"]; ?>" bgcolor="<?php echo $RR["d_left_bg_c"]; ?>" background="<?php echo $RR["d_left_bg_p"]; ?>">
			<?php
				$mainwidth = $RR["d_site_left"];
			?>
			<?php
				$sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($LB = $db->db_fetch_row($sql_left)){
			?>
			<DIV><?php echo show_block($LB[0]); ?></DIV>
			<?php 
				} 
			?>
		</td>
		<td id="ewt_main_structure_body" width="<?php echo $RR["d_site_content"]; ?>" bgcolor="<?php echo $RR["d_body_bg_c"]; ?>" height="160" background="<?php echo $RR["d_body_bg_p"]; ?>">
			<?php
				$mainwidth = $RR["d_site_content"];
			?>
			<?php
				$sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($CB = $db->db_fetch_row($sql_content)) {
			?>
			<DIV ><?php echo show_block($CB[0]); ?></DIV>
			<?php 
				} 
			?>
			<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
							<tr>
							
								<td width="90" height="25" align="center" background="mainpic/bg_off.gif" id="mytd2" style="cursor:hand;FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">Exhibition</td>
								<td background="mainpic/bg_line.gif">&nbsp;</td>
							</tr>
						</table>
						
							<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
							<tr> 
							<form name="myExhibition" action="search_exhibition.php?filename=<?php echo $filename;?>"  method="post">
							<td   height="25" align="center" >ค้นหา <input type="text" name="keyword" value="<?php echo $_REQUEST[keyword]?>"> 
							  หมวด  <select  name="keygroup">
							      <option value="">-----------เลือกหมวด-----------</option>
							  <?php
							  $query_exg = $db->query("SELECT * FROM   pk_group  WHERE  pkg_parent = '0' ");
							  while($data_exg = $db->db_fetch_array($query_exg)){ ?>
							        <option value="<?php echo $data_exg[pkg_id];?>" <?php if($_REQUEST[keygroup]==$data_exg[pkg_id]){ echo 'selected';}?>><?php echo $data_exg[pkg_name];?></option>
									<?php $query_exg2 = $db->query("SELECT * FROM   pk_group  WHERE  pkg_parent = '$data_exg[pkg_id]' ");
									while($data_exg2 = $db->db_fetch_array($query_exg2)){ ?>
									         <option value="<?php echo $data_exg2[pkg_id];?>" <?php if($_REQUEST[keygroup]==$data_exg2[pkg_id]){ echo 'selected';}?>> &nbsp;  &nbsp; <?php echo $data_exg2[pkg_name];?></option>
									<?php  } ?>
							  <?php  } ?> 
							  </select> 
							  
							  <input type="submit" value="ค้นหา">
							  </td>
							  </form>
							</tr>
						</table>
						<hr>
						<?php
						
function SearchGroup($gid){
	   global $db;
	   global $arrG;
	   $sql="SELECT * FROM pk_group  WHERE pkg_parent='$gid'   ";
	   $query=$db->query($sql);
	   /*
	   if($db->db_num_rows($query)){
		   $data=$db->db_fetch_array($query);
		   SearchGroup($data[pkg_id]);
		   $arrG[]=$data[pkg_id];
	   }*/
	   while($data=$db->db_fetch_array($query)){
	      $arrG[]=$data[pkg_id];
	   } 
}
						    if( $_REQUEST[keygroup] <> ''){
							   $arrG = array();
							   
							   SearchGroup($_REQUEST[keygroup]);
							   
							   $wh =  "AND  (pk_dlgid = '$_REQUEST[keygroup]' ";
							   for($i=0;$i<  sizeof($arrG);$i++){
							      $wh.=  "OR  pk_dlgid = '".$arrG[$i]."'  "; 
							   }
							   $wh.=" )";
							   $query_exg = $db->query("SELECT pkg_name  FROM   pk_group  WHERE  pkg_id = '$_REQUEST[keygroup]' ");
							    $numg=$db->db_fetch_row($query_exg);
								$sch_group=$numg[0];
							}else{
							   $sch_group=$_REQUEST[keygroup] = '- ไม่ระบุ -';
							}
							$num=0;
							if($_REQUEST[keyword]!='' or $wh!=''){
						    $query_ex = $db->query("SELECT * FROM  pk_list  INNER JOIN pk_group ON  pk_dlgid = pkg_id  WHERE  pk_name like '%$_REQUEST[keyword]%'  $wh"); 
							$num=$db->db_num_rows($query_ex);
							}
							
						 ?>
						คำค้น : <?php echo $_REQUEST[keyword];?><br>
						หมวด : <?php echo $sch_group;?><br>
                        ผลการค้นหา พบ  <?php echo  $num; ?> รายการ<hr>
						<?php
						   if($num>0){
						       while($data_ex = $db->db_fetch_array($query_ex)){ ?>
							      รายชื่อ :  <?php echo $data_ex[pk_name];?><br>
							      หมวด :  <?php echo $data_ex[pkg_name];?><br>
                                  <font color="#FF0000">เลขที่(ที่ตั้ง) :  <?php echo $data_ex[pk_detail];?></font><br><br>
							  <?php  }
						   }else{
						      echo 'ไม่พบข้อมูล';
						   }
						?>
			</td>
		<td id="ewt_main_structure_right" width="<?php echo $RR["d_site_right"]; ?>" bgcolor="<?php echo $RR["d_right_bg_c"]; ?>" background="<?php echo $RR["d_right_bg_p"]; ?>">
			<?php
				$mainwidth = $RR["d_site_right"];
			?>
			<?php
				$sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($RRB = $db->db_fetch_row($sql_right)){
			?>
			<DIV ><?php echo show_block($RRB[0]); ?></DIV>
			<?php 
				} 
			?>
		</td>
	</tr>
	<tr valign="top" > 
		<td id="ewt_main_structure_bottom" height="<?php echo $RR["d_bottom_height"]; ?>" bgcolor="<?php echo $RR["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $RR["d_bottom_bg_p"]; ?>">
			<?php
				$mainwidth = $RR["d_site_width"];
			?>
			<?php
				$sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($BB = $db->db_fetch_row($sql_bottom)) {
			?>
			<DIV><?php echo show_block($BB[0]); ?></DIV>
			<?php 
				} 
			?>
		</td>
	</tr>
</table>
</body>
</html>
 
<?php $db->db_close(); ?>