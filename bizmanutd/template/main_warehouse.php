<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
if($_GET[formtype] == 'advancedS'){
	//ทุกคำ
	$all = $_GET[as_q];
	if($all != ''){
		$allexp = explode(' ',$all);
		for($i=0;$i<count($allexp);$i++){
			if($kwd != ''){$per = ' ';}
			if($i==0){
			$kwd .= $per.$allexp[$i];
			}else{
			$kwd .= $per.$allexp[$i];
			}
		}
	}
	
	//อย่างน้อย ใช้
		$least = $_GET[as_oq];
	if($least != ''){
		$leastexp = explode(' ',$least);
		for($i=0;$i<count($leastexp);$i++){
			//if($kwd != ''){$per = ' OR ';}
			$per = ' OR ';
			if($i==0){
			$kwd .= $per.$leastexp[$i];
			}else{
			$kwd .= $per.$leastexp[$i];
			}
		}
		
			
	}
	//วลี ใช้ " XXX"
	$remark = $_GET[as_epq];
	if($remark != ''){
			if($kwd != ''){$per = ' ';}
			$kwd .= $per."\"".$remark."\"";
	}
	//ไม่มี
	$not = $_GET[as_eq];
	if($not != ''){
		$notexp = explode(' ',$not);
		for($i=0;$i<count($notexp);$i++){
		if($kwd != ''){$per = ' ';}
			if($i==0){
			$kwd .= $per."-".$notexp[$i];
			}else{
			$kwd .= $per."-".$notexp[$i];
			}
		}
	}
 	//ชุดที่
	$gov = $_GET[yearno];
	if($gov != ''){
		$per = ' government:';
			$kwd .= $per.$gov;
	}
	//ปีที่
	$year = $_GET[year];
	if($year != ''){
		$per = ' year:';
			$kwd .= $per.$year;
	}
	//ครั้งที่
	$time = $_GET[num];
	if($time != ''){
		$per = ' time:';
			$kwd .= $per.$time;
	}
	//สมัยที่
	$session = $_GET[session_id];
	if($session != ''){
		$per = ' session:';
			$kwd .= $per.$session;
	}
	//ชนิดเอกสาร
	$as_filetype = $_GET[as_filetype];
	if($as_filetype != ''){
		$per = ' filetype:';
			$kwd .= $per.$as_filetype;
	}
	//ประเภทการประชุม
	$as_type = $_GET[as_type];
	if($as_type != ''){
		$per = ' doctype:';
			$kwd .= $per.$as_type;
	}
	$_REQUEST["keyword"] .= $kwd;
}else{
	//ประเภทการประชุม
	$as_type = $_GET[as_type];
	if($as_type != ''){
		$per = ' type:';
			$kwd .= $per.$as_type;
	}
	$_REQUEST["keyword"] .= $kwd;
}

if($_GET["filename"] == ''){
$_GET["filename"] = "index";
}
if($_GET["filename"] != ""){
$sql_file = $db->query("SELECT template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$Design = $db->db_fetch_row($sql_file);
$did = $Design[0];
}else{
$sql_file = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y' ");
$Design = $db->db_fetch_row($sql_file);
$did = $Design[0];
}

$sql_index = $db->query("SELECT * FROM design_list WHERE d_id = '".$did."' ");
$F = $db->db_fetch_array($sql_index);

$global_theme = $F[d_bottom_content];
$mainwidth = "0";
$lang_sh = explode('___',$_GET["filename"]);
if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
	?>
<html>
<head>
<title>ระบบฐานข้อมูลรายงานและบันทึกการประชุม</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<?php
include("ewt_script.php");	
?>
<script language="javascript1.2">
function ajax_search_word(keyword_b) {
		document.formSearchAEWT.keyword.value = keyword_b;
		//ajax_search_datawh();
		document.formSearchAEWT.submit();
		
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
		url='ewt_nav_pad.php?d='+encodeURIComponent(w);
		
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
function ajax_search_datawh(){
var objDiv = document.getElementById("show_datawarehouse");
	objDiv.style.display = '';
	var keyword =encodeURIComponent(document.formSearchAEWT.keyword.value);
	var as_type =encodeURIComponent(document.formSearchAEWT.as_type.value);
	url='main_warehouse_list.php?id=<?php echo $_GET[id];?>&level=6&seach=Y&keyword='+keyword+' type:'+as_type;
		alert(url);
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
}
function show_datawarehouse_list(type,keyword,offset,id){
var objDiv = document.getElementById("show_datawarehouse");
	objDiv.style.display = '';
	if(id == ''){
	var addlink = '&id=1';
	}else{
	var addlink = '&id='+id;
	}
	if( type == ''){
	url='main_warehouse_list.php?id=<?php echo $_GET[id];?>&level=1&fieldname=yearno&fieldnameold=&value='+addlink;
	}else{
	url='main_warehouse_list.php?id=<?php echo $_GET[id];?>&level='+type+'&keyword='+keyword+'&offset='+offset+addlink;
	} 
	
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
}
function change_value(level,yearno,year,session_name,num,offset){
var objDiv = document.getElementById("show_datawarehouse");
	objDiv.style.display = '';
	
	url='main_warehouse_list.php?id=<?php echo $_GET[id];?>&level='+level+'&yearno='+yearno+'&year='+year+'&num='+num+'&session_name='+session_name+'&offset='+offset;

						
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
}
function show_detail(mid){
var objDiv = document.getElementById("show_datawarehouse");
	objDiv.style.display = '';
	url='main_warehouse_detail.php?id=<?php echo $_GET[id];?>&mid='+mid;
	
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
add_stat(mid);//stat view meeting
}
function add_stat(mid){
<?php

	if(!session_is_registered("DWH_VISITOR_STAT")){
	session_register("DWH_REFERER");
	$_SESSION["DWH_REFERER"] = $HTTP_REFERER;
	}
	$end_time_counter = date("YmdHis");
	$gap = $end_time_counter - $start_time_counter;
?>
var objDiv = document.getElementById("addstat");
	objDiv.style.display = '';
	url='main_warehouse_stat.php?id=<?php echo $_GET[id];?>&mid='+mid+'&load=<?php echo $gap; ?>&res='+screen.width+'x'+screen.height;
	
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function download(aid,mid){
		var link_t = 'main_warehouse_dll.php';
		var link_target = '_blank';
		document.getElementById("aid").value = aid;
		document.getElementById("mid").value = mid;
		frmwh.action = link_t;
		frmwh.target =link_target;
		frmwh.submit();
		adddownload(aid,mid);
}
function adddownload(aid,mid){
<?php

	if(!session_is_registered("DL_VISITOR_STAT")){
	session_register("DL_REFERER");
	$_SESSION["DL_REFERER"] = $HTTP_REFERER;
	}
	$end_time_counter = date("YmdHis");
	$gap = $end_time_counter - $start_time_counter;
?>
var objDiv = document.getElementById("addstat");
	objDiv.style.display = '';
	url='main_warehouse_stat_download.php?id=<?php echo $_GET[id];?>&aid='+aid+'&mid='+mid+'&load=<?php echo $gap; ?>&res='+screen.width+'x'+screen.height;
	
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
}
</script>
</head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"><?php
			$mainwidth = $F["d_site_content"];
			?>
			
			<?php
			//data warehouse
			$db->query("USE datawarehouse");
			?>
			<form name="formSearchAEWT" method="get" action="main_warehouse.php">
			<table width="100%" border="0" style="display:none" >
			  <tr>
				<td align="right">ค้นหา
			    <input name="keyword" type="text" value="<?php echo addslashes(htmlspecialchars($_REQUEST["keyword"]));?>" autocomplete="off" onKeyUp="txt_data(this.value)" >
				<input type="Submit" name="Submit"  value="ค้นหา.."><br><select name="as_type" >
				  <option value="">ประเภทเอกสารใดก็ได้</option>
					  <option value="รายงานการประชุม" <?php if($_REQUEST[as_type]=='รายงานการประชุม'){  echo 'selected';}?> >รายงานการประชุม</option>
					  <option value="บันทึกการประชุม" <?php if($_REQUEST[as_type]=='บันทึกการประชุม'){  echo 'selected';}?>>บันทึกการประชุม</option>
					  <option value="บันทึกการออกเสียงลงคะแนน" <?php if($_REQUEST[as_type]=='บันทึกการออกเสียงลงคะแนน'){  echo 'selected';}?>>บันทึกการออกเสียงลงคะแนน</option>
					  <option value="สรุปเหตุการณ์" <?php if($_REQUEST[as_type]=='สรุปเหตุการณ์'){  echo 'selected';}?>>สรุปเหตุการณ์</option>
					</select> <br><a href="main_warehouse_advanced_search.php?filename=<?php echo $filename;?>">[การค้นหาขั้นสูง]</a>
				<input name="type" type="hidden" value="6">
				<input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>"></td>
			  </tr>
			</table>
			<table width="100%" border="0">
			  <tr>
				<td align="right" class="text_head"><br> 
			    <a href="ewt_servicemain.php"><strong><img src="mainpic/webservice.gif" width="24" height="24" border="0" align="absmiddle"> Webservice</strong></a></td>
			  </tr>
			</table>
            </form>
			<form action="main_warehouse.php" method="post" name="frmwh">
			<input name="aid" id="aid" type="hidden" value="">
			<input name="mid"  id="mid" type="hidden" value="">
			<div id="show_datawarehouse"><img src="mainpic/loading.gif" width="150" height="50"></div>
				<script language="javascript1.2">
				<?php if($_GET[id]=='2'){ ?>
				 change_value(5,0,0,'MY','','')
				<?php }else if($_GET[id]=='3'){?>
				change_value(2,1,'','','','')
				<?php }else{?>
				show_datawarehouse_list('<?php echo $_REQUEST[type];?>','<?php echo urlencode ( $_REQUEST["keyword"]);?>','','<?php echo $_REQUEST[id];?>');
				<?php } ?>
				</script>
			<div id="addstat"></div>
			</form>
			
			
			
			<?php
			$db->query("USE ".$EWT_DB_NAME);
			?>
			
		  </td>
          <td id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth =  $F["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?>
				  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>

<?php $db->db_close(); ?>
