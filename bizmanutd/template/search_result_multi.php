<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");
	//include("language/language.php");
	
	$type=$_REQUEST[type];
	$keyword=$_REQUEST[keyword]; 
	if($type==''){ $type='A'; 	}
	
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
		document.formSearchAEWT.search_mode.value=keyword_b;
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
			//changebg(eval(tab))
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
			<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
				<form name="formgoogle" method="get" action="http://www.google.co.th/search" target="_blank">
					<input type="hidden" name="q">
				</form>
				
				<form name="formSearchAEWT" method="get" action="">
				<tr> 
					<td>
						<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
							<tr>
							<?php 
								$bg_a='bg_off.gif';  $bg_p='bg_off.gif';  $bg_g='bg_off.gif';  $bg_w='bg_off.gif';  $bg_f='bg_off.gif'; 
								if($_REQUEST[type]=='A'){ $bg_a='bg_on.gif'; } 
								if($_REQUEST[type]=='P'){ $bg_p='bg_on.gif'; } 
								if($_REQUEST[type]=='G'){ $bg_g='bg_on.gif'; }
								if($_REQUEST[type]=='W'){ $bg_w='bg_on.gif'; } 
								if($_REQUEST[type]=='F'){ $bg_f='bg_on.gif'; } 
								?>
								<td width="90" height="25" align="center" background="mainpic/<?php echo $bg_a;?>" id="mytd2" 
								onClick="location.href='?filename=<?php echo $filename?>&type=A&keyword='+formSearchAEWT.keyword.value" 
								style="cursor:hand;FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">ข่าว/บทความ</td>
									
								<td width="90" height="25" align="center" background="mainpic/<?php echo $bg_p;?>" id="mytd1" 
								onClick="location.href='?filename=<?php echo $filename?>&type=P&keyword='+formSearchAEWT.keyword.value" 
								style="cursor:hand;FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">เนื้อหา</td>
								
								<td width="90" height="25" align="center" background="mainpic/<?php echo $bg_g;?>" id="mytd3" 
								onClick="location.href='?filename=<?php echo $filename?>&type=G&keyword='+formSearchAEWT.keyword.value" 
								style="cursor:hand;FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">รูปภาพ</td>
								
								<td width="90" height="25" align="center" background="mainpic/<?php echo $bg_w;?>" id="mytd4" 
								onClick="location.href='?filename=<?php echo $filename?>&type=W&keyword='+formSearchAEWT.keyword.value" 
								style="cursor:hand;FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">Webboard</td>
								
								<td width="90" height="25" align="center" background="mainpic/<?php echo $bg_f;?>" id="mytd5" 
								onClick="location.href='?filename=<?php echo $filename?>&type=F&keyword='+formSearchAEWT.keyword.value" 
								style="cursor:hand;FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">FAQ</td>
								
								<td width="90" height="25" align="center" background="mainpic/bg_off.gif" id="mytd6" 
								onClick="ajax_search('0');document.getElementById('nav').style.display='none';"  
								style="cursor:hand;FONT-WEIGHT: normal; FONT-SIZE: 11px; COLOR: #000000; TEXT-DECORATION: none;FONT-FAMILY: Tahoma;">ค้นหาจากภายนอก</td>
								<td background="mainpic/bg_line.gif">&nbsp;</td>
							</tr>
						</table>				  </td>
				</tr>
				<tr> 
					<td  align="right">
						ค้นหา 
						<input name="keyword" type="text" id="keyword"  size="30" value="<?php echo stripslashes(trim($keyword)); ?>" autocomplete="off" onKeyUp="txt_data(this.value)" > 
						<input name="type" type="hidden" id="type" value="<?php echo $type; ?>">
						<input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>">
						<input type="submit"  value=" ค้นหา... "  >
						<!--br>
						<input name="oper" type="radio" value="OR" <?php if($oper == "OR"){ echo "checked"; } ? >>
						ค้นหาเฉพาะ<strong><font color="#FF0000">บางคำ</font></strong>  
						<input type="radio" name="oper" value="AND" <?php if($oper == "AND"){ echo "checked"; } ? >
						ค้นหา<strong><font color="#FF0000">ทุกเงื่อนไข</font></strong>-->				  </td>
				</tr>
				</form>
				<tr> 
					<td  align="right" >	
					<?php 
	                 $keyword2 = stripslashes(htmlspecialchars(trim($_REQUEST[keyword]),ENT_QUOTES));
					 $keyword3=like_word($keyword2);
					 if($keyword!=''){
					  
					$db->query("USE $EWT_DB_USER");
					$sql_search=" SELECT multi_search.*,EWT_User,url ,WebsiteName FROM  multi_search INNER JOIN user_info ON ms_uid = uid  WHERE ms_module='$type' 
					AND ( ms_topic like '%$keyword%' OR ms_keyword like '%$keyword%'  )";
					//echo  $sql_search; 
					$query_search=$db->query($sql_search);
					
					$totalRec=$db->db_num_rows($query_search);
					$pages_num = 25;
					$pagesize = $pages_num;
					$totalpage = (int)($totalRec/$pagesize);
					if(($totalRec%$pagesize)!=0){
					$totalpage +=1;
					}
					if(isset($pageid)){
					$start = $pagesize*($pageid-1);
					}else{
					$pageid=1;
					$start=0;
					}
 
					$query_search=$db->query($sql_search."  LIMIT $start,$pagesize ");
					if($db->db_num_rows($query_search)>0){
					?><br><hr>
					 <table width="100%" border="0" cellspacing="3" cellpadding="3">
					 <tr> <td  colspan="2">&nbsp;<strong>ผลการค้นหาคำว่า :</strong> <?php echo $keyword?><br><br> </td> </tr>
					 <?php
							while($rec_search = $db->db_fetch_array($query_search)){
								//echo  $rec_search[ms_topic].$rec_search[ms_keyword].$rec_search[ms_update].'<br>';
								$details=preg_replace($search, $replace, $rec_search[ms_keyword]); 
								 $url_popup='';
								 $url_target='target="_blank"';
								switch($type){ 
									 case 'A'			:   $url_link="$rec_search[url]ewt_news.php?nid=$rec_search[ms_link_id]";  break;	 //Article 
									 case 'F'			:   $url_link="#faq";  
									 $url_popup="window.open('$rec_search[url]faq_detail.php?fa_id=$rec_search[ms_link_id]','showass1','scrollbars=yes,width=650,height=450')";
									 $url_target='';
									                            break;		 //FAQ 
									 case 'G'		:   $url_link="$rec_search[url]gallery_view_img_comment.php?img_id=$rec_search[ms_link_id]";  break;		 //Gallery 
									 case 'P'			:   $url_link="$rec_search[url]main.php?filename=$rec_search[ms_link_id]";  break;		 //Page  
									 case 'W'		:   $url_link="$rec_search[url]index_answer.php?&wtid=$rec_search[ms_link_id]";  break;		 //Webboard 
								}
								
								?> 
					            <tr>  
								 <?php if(trim($rec_search[ms_picture])!=''){?> 
								  <td width="0%"><a href="<?php echo $url_link;?>" <?php echo $url_target;?>><img src="phpThumb.php?src=../<?php echo $rec_search[EWT_User]?>/<?php echo $rec_search[ms_picture]?>&h=80&w=80" border="0"></a></td>
								 <?php } ?> 
								<td width="100%"><a href="<?php echo $url_link;?>" onclick="<?php echo $url_popup; ?>"  <?php echo $url_target;?>><strong>
							    <?php if(trim($rec_search[ms_topic])!=''){echo $rec_search[ms_topic];}else{echo "- ไม่มีหัวเรื่อง -".$rec_search[url];}?></strong></a><br>
                                 <?php  if(strlen($details) > 150 ){ echo substr($details,0,150).'....';  }else{ echo  $details;  }   ?><br><br>
								 <?php  
								 
								   $y=substr($rec_search[ms_update],0,4); 
								   $m=substr($rec_search[ms_update],4,2)*1; 
								   $d=substr($rec_search[ms_update],6,2); 
								   echo "วันที่ : $d $monthname[$m] ".($y+543).' เว็บไซต์ : '.$rec_search[WebsiteName];
								      ?>
								</td> </tr>
								 <tr>
								<td width="100%" height="1" colspan="2" bgcolor="#999999"></td> </tr>
								<?php
							} ?>
										<tr>
					  <td  height="5"  bgcolor="#FFFFFF"  colspan="2">
					 หน้า  : 
									<?php 
									$countPer=0;
									$countNext=0;
									$condition="&filename=$filename&type=$type&keyword=$keyword";
									for($i=1;$i<=$pageid;$i++){ 
										$countPer++;
										if($countPer>5){ break; }
									} 
									if(abs($pageid-$totalpage)>5){
										$davar=0;
									}else{
										$davar=4-abs($pageid-$totalpage);
									}
									if($countPer>=6){
									  echo   "<a href = \"?pageid=1&num_p=$num_p&veiw=$veiws$condition\">&lt;&lt;หน้าแรก</a>&nbsp;";
									  echo   "<a href = \"?pageid=".($pageid-6-$davar)."&num_p=$num_p&veiw=$veiws$condition\">&lt;ก่อนหน้า</a>&nbsp;";
									  $until=$pageid-5-$davar;
									}else{
										$until=1;
									}
									if($until<=0){ $until=1; }
									for($i=$until;$i<=$pageid-1;$i++){ 
										echo("[<a href = \"?pageid=$i&num_p=$num_p&veiw=$veiws$condition\">$i</a>]&nbsp; "); 
									}
									echo '<font color="#FF0000"><b>'.$i."</b></font>&nbsp;";
									$until=$totalpage; 
									$diver=5-$countPer;
									for($i=$totalpage;$i>$pageid;$i--){ 
										  $countNext++; 
										  if($countNext>5){
											  $until=$pageid+5+$diver;
											  break;
										  }
									}  
									for($i=$pageid+1;$i<=$until;$i++){  
									   echo("[<a href = \"?pageid=$i&num_p=$num_p&veiw=$veiws$condition\">$i</a>]&nbsp; $br"); 
									}
									if($countNext>5){
										echo   "<a href = \"?pageid=$i&num_p=$num_p&veiw=$veiws$condition\">ถัดไป&gt;</a>&nbsp;";
										echo   "<a href = \"?pageid=$totalpage&num_p=$num_p&veiw=$veiws$condition\">สุดท้าย&gt;&gt;</a>&nbsp;";
									 }  
									 
									 
						 ?>
					  
							  </td>
						  </tr>
					</table><?php
					}else if($keyword != ''){?><br><hr>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr> <td>&nbsp;<strong>คำใกล้เคียง :</strong> <?php echo $keyword3?><br><br> </td> </tr>
						  <tr>
							<td>ผลการค้นหา - <?php echo $keyword?> - ไม่ตรงกับเอกสารใดเลย <br>
										คำแนะนำ:<br>
										- ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br>
										- ลองคำหลักที่ต่างจากนี้<br>
										- ลองใช้คำหลักทั่วๆไป<br>
										- ลองใช้คำให้น้อยลง</td>
						  </tr>
						</table>

					<?php }
					$db->query("USE $EWT_DB_NAME");
					}
					?>	
					
					</td>
				</tr>
		  </table>
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
