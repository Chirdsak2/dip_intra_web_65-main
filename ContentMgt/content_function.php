<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");

	function GenLen($data,$op){
		$s = explode($op,$data);
		return count($s);
	}
	if($_POST["Flag"] == "CreateFile") {
		$sql_check = $db->query("SELECT filename FROM temp_index WHERE filename = '".$_POST["fname"]."'");
		if($db->db_num_rows($sql_check) > 0) {
?>
<script language="javascript">
	alert("\"<?php echo $_POST["fname"]; ?>\" is already exist!!!!");
	self.location.href = "content_view.php?gid=<?php echo $_POST["gid"]; ?>";
</script>
<?php
			exit;
		} else {
			$db->query("INSERT INTO temp_index (filename,Main_Group_ID) VALUES ('".$_POST["fname"]."','".$_POST["gid"]."')");
		//	$db->query("INSERT INTO temp_magic (filename,html_content,object,position) VALUES ('".$_POST["fname"]."','','Text','0')");
?>
<script language="javascript">
	//self.top.content_left.location.reload();
	self.location.href = "content_view.php?gid=<?php echo $_POST["gid"]; ?>";
</script>
<?php
		}
	}
	if($_POST["Flag"] == "edit") {
		$sql_check = $db->query("SELECT filename FROM temp_index WHERE filename = '".$_POST["file_name"]."'");
		$update = "
			UPDATE temp_index 
			SET 
				filename ='".$_POST["file_name"]."', Main_Group_ID = '".$_POST["group_id"]."',
				cms_keyword = '".$_POST["keyword"]."',cms_description = '".$_POST["description"]."',
				title = '".$_POST["title"]."' where filename = '".$_POST["filenameold"]."'";
		$db->query($update);
		$update_blockfunction = "update block_function SET filename ='".$_POST["file_name"]."' where filename = '".$_POST["filenameold"]."'";
		$db->query($update_blockfunction);
		$update_blocktext = "update block_text SET filename ='".$_POST["file_name"]."' where filename = '".$_POST["filenameold"]."'";
		$db->query($update_blocktext);
		session_unregister("EWT_OPEN_SAVE");
?>
<script language="javascript">
	self.top.window.opener.top.ewt_main.location.href="content_mgt.php?filename=<?php echo $_POST["file_name"]; ?>"
	self.close();
</script>
<?php
	}
	if($_POST["Flag"] == "Add") {
		$sql_check = $db->query("SELECT filename FROM temp_index WHERE filename = '".$_POST["file_name"]."'");
		if($db->db_num_rows($sql_check) > 0) {
?>
<script language="javascript">
	alert("\"<?php echo $_POST["file_name"]; ?>\" is already exist!!!!");
	self.location.href = "content_new.php";
</script>
<?php
			exit;
		} else {
			$sql_temp = $db->query("SELECT * FROM design_list WHERE d_id = '".$_POST["template"]."' ");
			$TP = $db->db_fetch_array($sql_temp);
				$d_site_align = $TP["d_site_align"];
				$d_site_width = $TP["d_site_width"];
				$d_site_left = $TP["d_site_left"];
				$d_site_content = $TP["d_site_content"];
				$d_site_right = $TP["d_site_right"];
				$d_site_bg_c = $TP["d_site_bg_c"];
				$d_site_bg_p = $TP["d_site_bg_p"];
				$d_top_height = $TP["d_top_height"];
				$d_top_bg_c = $TP["d_top_bg_c"];
				$d_top_bg_p = $TP["d_top_bg_p"];
				$d_body_bg_c = $TP["d_body_bg_c"];
				$d_body_bg_p = $TP["d_body_bg_p"];
				$d_left_bg_c = $TP["d_left_bg_c"];
				$d_left_bg_p = $TP["d_left_bg_p"];
				$d_right_bg_c = $TP["d_right_bg_c"];
				$d_right_bg_p = $TP["d_right_bg_p"];
				$d_bottom_height = $TP["d_bottom_height"];
				$d_bottom_bg_c = $TP["d_bottom_bg_c"];
				$d_bottom_bg_p = $TP["d_bottom_bg_p"];
			$db->query("
				INSERT INTO temp_index (
					filename, Main_Group_ID, template_id, d_site_align, d_site_width, 
					d_site_left, d_site_content, d_site_right, d_site_bg_c, d_site_bg_p, 
					d_top_height, d_top_bg_c, d_top_bg_p, d_body_bg_c, d_body_bg_p, 
					d_left_bg_c, d_left_bg_p, d_right_bg_c, d_right_bg_p, d_bottom_height, 
					d_bottom_bg_c, d_bottom_bg_p, title, cms_description, cms_keyword, 
					Created_Date, Modified_Date, filename_link) 
				VALUES (
					'".$_POST["file_name"]."', '".$_POST["group_id"]."', '".$_POST["template"]."', '".$d_site_align."', '".$d_site_width."', 
					'".$d_site_left."', '".$d_site_content."', '".$d_site_right."', '".$d_site_bg_c."', '".$d_site_bg_p."', 
					'".$d_top_height."', '".$d_top_bg_c."', '".$d_top_bg_p."', '".$d_body_bg_c."', '".$d_body_bg_p."', 
					'".$d_left_bg_c."', '".$d_left_bg_p."', '".$d_right_bg_c."', '".$d_right_bg_p."', '".$d_bottom_height."', 
					'".$d_bottom_bg_c."', '".$d_bottom_bg_p."', '".$_POST["title"]."', '".$_POST["description"]."', '".$_POST["keyword"]."', 
					NOW(), NOW(), 'E')");
			$sql_block = $db->query("SELECT *,block.BID AS b_id  FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.d_id = '".$_POST["template"]."' ORDER BY design_block.side,design_block.position ASC");
			while($B = $db->db_fetch_array($sql_block)) {
				if($B["block_edit"] == "Y") {
					$db->query("INSERT INTO block (block_name,block_type,block_html,block_link,filename,block_edit) VALUES ('".$B["block_name"]."','".$B["block_type"]."','".addslashes(stripslashes($B["block_html"]))."','".$B["block_link"]."','".$_POST["file_name"]."','Y')");
					$sql_max = $db->query("SELECT MAX(BID) FROM block WHERE block_name = '".$B["block_name"]."' AND filename = '".$_POST["file_name"]."' ");
					$BM = $db->db_fetch_row($sql_max);
					if($B["block_type"] == "text" OR $B["block_type"] == "code" OR $B["block_type"] == "images" OR $B["block_type"] == "flash" OR $B["block_type"] == "media"){
						$sql_text = $db->query("SELECT * FROM block_text WHERE text_id = '".$B["block_link"]."' ");
						$T = $db->db_fetch_array($sql_text);
						$db->query("INSERT INTO block_text (BID,text_html,filename) VALUES ('".$BM[0]."','".addslashes(stripslashes($T["text_html"]))."','".$_POST["file_name"]."')");
						$sql_textm = $db->query("SELECT MAX(text_id) FROM block_text WHERE filename = '".$_POST["file_name"]."' ");
						$TM = $db->db_fetch_row($sql_textm);
						$db->query("UPDATE block SET block_link = '".$TM[0]."' WHERE BID = '".$BM[0]."' ");
					}
					$BID = $BM[0];
				} else { $BID = $B["b_id"]; }
				$db->query("INSERT INTO block_function (BID,UID,side,position,filename) VALUES ('".$BID."','".$B["UID"]."','".$B["side"]."','".$B["position"]."','".$_POST["file_name"]."') ");
			}
?>
<script language="javascript">
	self.top.window.opener.top.ewt_main.location.href="content_mgt.php?filename=<?php echo $_POST["file_name"]; ?>"
	self.close();
</script>
<?php
		}
	}
	if($_POST["Flag"] == "Choose") {
		function bname($type,$file) {
			if($type == "text") 	{ $b_name = "T".date("YmdHis"); }
			if($type == "code") 	{ $b_name = "C".date("YmdHis"); }
			if($type == "graph") 	{ $b_name = "G".date("YmdHis"); }
			if($type == "article") 	{ $b_name = "A".date("YmdHis"); }
			if($type == "menu") 	{ $b_name = "M".date("YmdHis"); }
			if($type == "fontsize") { $b_name = "Font Size Control"; }
			if($type == "poll") 	{ $b_name = "Poll"; }
			if($type == "enews") 	{ $b_name = "E-News Letter"; }
			if($type == "survey") 	{ $b_name = "Survey"; }
			if($type == "calendar") { $b_name = "Calendar"; }
			if($type == "webboard") { $b_name = "Webboard"; }
			if($type == "faq")		{ $b_name = "FAQ"; }
			if($type == "complain")	{ $b_name = "Complain"; }
			if($type == "sitemap")	{ $b_name = "Sitemap"; }
			if($type == "gallery")	{ $b_name = "Gallery Picture"; }
			if($type == "search")	{ $b_name = "Search Box"; }
			if($type == "banner")	{ $b_name = "Banner List"; }
			if($type == "guest")	{ $b_name = "Guestbook"; }
			if($type == "login")	{ $b_name = "Member Login"; }
			if($type == "rss")		{ $b_name = "Rss Reader"; }
			if($type == "link")		{ $b_name = "Related Link"; }
			if($type == "online")	{ $b_name = "User Online"; }
			if($type == "ebook")	{ $b_name = "E-Book"; }
			if($type == "blog")		{ $b_name = "Blog"; }
			if($type == "news")		{ $b_name = "News"; }
			if($type == "vdo")		{ $b_name = "vdo"; }
			if($type == "language")		{ $b_name = "language"; }
			if($type == "tooltips")		{ $b_name = "Tool Tips"; }
			if($type == "virtual")		{ $b_name = "Virtual Tour"; }
			if($type == "download")		{ $b_name = "Download"; }
			if($type == "gadget")		{ $b_name = "Module Plugin"; }
			if($type == "ecard")		{ $b_name = "E Card"; }
			if($type == "printer")		{ $b_name = "Printer"; }
			if($type == "tor")		{ $b_name = "Tor"; }
			if($type == "images" OR $type == "flash" OR $type == "media"){//
				$fp = explode("/",$file);
				$cp = count($fp);
				$buse = $fp[($cp -1)];
				$buse = ereg_replace(" ","",$buse);
				$b_name = ereg_replace("\"","",$buse);
			}
			return $b_name;
		}
		
		$block_name = bname($_POST["stype"],$_POST["objfile"]);
		$db->write_log("create","main","สร้าง block ".$block_name."  ในหน้า web page :".$_POST["filename"]);
		$block_html = "";
		$sql_def =$db->query("SELECT design_list.d_bottom_content as def_block FROM temp_index,design_list where d_id=template_id and filename ='".$_POST["filename"]."'");
		$rec_def=$db->db_fetch_array($sql_def);
		$block_themes = '';//$rec_def[def_block];
		$db->query("INSERT INTO block (block_name,block_type,block_link,filename,block_edit,block_themes) VALUES ('".$block_name."','".$_POST["stype"]."','','".$_POST["filename"]."','Y','".$block_themes."')");
		$sql_max = $db->query("SELECT MAX(BID) FROM block WHERE block_name = '".$block_name."' AND filename = '".$_POST["filename"]."' ");
		$BM = $db->db_fetch_row($sql_max);

		if($_POST["stype"] == "text" OR $_POST["stype"] == "code" OR $_POST["stype"] == "gadget" OR $_POST["stype"] == "images" OR $_POST["stype"] == "flash" OR $_POST["stype"] == "media"){
			if($_POST["stype"] == "images"){
				$block_html =  $_POST["align"]."@@##@@".$_POST["height"]."@@##@@".$_POST["width"]."@@##@@@@##@@@@##@@".$_POST["objfile"]."@@##@@".$_POST["border"];
			}
			if($_POST["stype"] == "flash"){
				$block_html =  $_POST["align"]."@@##@@".$_POST["height"]."@@##@@".$_POST["width"]."@@##@@@@##@@@@##@@".$_POST["objfile"];
			}
			if($_POST["stype"] == "media"){
				if($_POST["hide"] == "Y"){
					$_POST["height"] = 0;
					$_POST["width"] = 0;
				}
				if($_POST["auto"] != "1"){
					$_POST["auto"] = 0;
				}
				if($_POST["repeat"] != "1"){
					$_POST["repeat"] = 0;
				}else{
					$_POST["repeat"] = 50;
				}
				$block_html =  $_POST["align"]."@@##@@".$_POST["height"]."@@##@@".$_POST["width"]."@@##@@".$_POST["auto"]."@@##@@".$_POST["repeat"]."@@##@@".$_POST["objfile"];
			}
	
			$db->query("INSERT INTO block_text (BID,text_html,filename) VALUES ('".$BM[0]."','".$block_html."','".$_POST["filename"]."')");
			$sql_text = $db->query("SELECT MAX(text_id) FROM block_text WHERE filename = '".$_POST["filename"]."' ");
			$TM = $db->db_fetch_row($sql_text );
			$db->query("UPDATE block SET block_link = '".$TM[0]."' WHERE BID = '".$BM[0]."' ");
		}
		include("../ewt_block_function.php");
		if($_POST["stype"] == "media"){
			$block_html = "<img src=\"../../images/media_preview.gif\" width=\"194\" height=\"155\">";
		}
		if($_POST["stype"] == "graph"){
			$block_html = "<img src=\"../../images/graph_preview.gif\" width=\"194\" height=\"155\">";
		}
		if($_POST["stype"] == "images"){
			$block_html = "<div align=".$_POST["align"]."><img src=\"".$_POST["objfile"]."\" width=".$_POST["width"]." height=".$_POST["height"]."></div>";
		}
		if($_POST["stype"] == "flash"){
			$block_html = "<div  align=\"".$_POST["align"]."\" ><object   classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"".$_POST["width"]."\" height=\"".$_POST["height"]."\"><param name=\"movie\" value=\"".$_POST["objfile"]."\"><param name=\"quality\" value=\"high\"><embed src=\"".$_POST["objfile"]."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".$_POST["width"]."\" height=\"".$_POST["height"]."\"></embed></object></div>";
		}
?>
<script language="javascript">
	function CreateDragContainer(){
		/*
		Create a new "Container Instance" so that items from one "Set" can not
		be dragged into items from another "Set"
		*/
		var DragDrops   = [];
		var cDrag = DragDrops.length;
		DragDrops[cDrag] = [];
		
		/*
		Each item passed to this function should be a "container".  Store each
		of these items in our current container
		*/
		for(var i=0; i<arguments.length; i++){
			var cObj = arguments[i];
			DragDrops[cDrag].push(cObj);
			cObj.setAttribute('DropObj', cDrag);
	
			/*
			Every top level item in these containers should be draggable.  Do this
			by setting the DragObj attribute on each item and then later checking
			this attribute in the mouseMove function
			*/
			for(var j=0; j<cObj.childNodes.length; j++){
	
				// Firefox puts in lots of #text nodes...skip these
				if(cObj.childNodes[j].nodeName=='#text') continue;
				
				cObj.childNodes[j].setAttribute('DragObj', cDrag);
			}
		}
	}
	
	
	self.parent.iframe_data.document.all.tbcontent.innerHTML = self.parent.iframe_data.document.all.tbcontent.innerHTML + "<DIV class=DragBox id=EWTID_S<?php echo $BM[0]; ?>EWTID_E overClass=OverDragBox dragClass=DragDragBox align=left> :: <?php echo $block_name; ?> :: <table width=100% border=0 cellspacing=0 cellpadding=0> <tr style=cursor:hand><td height=20 bgcolor=F3F3EE><img src=\"<?php echo icon_block($_POST["stype"]); ?>\" width=20 height=20 align=absmiddle>&nbsp;&nbsp;&nbsp;&nbsp;<img id=EWTpospic src=../../images/bar_down.gif title=\"แสดงตัวอย่าง\" width=20 height=20 onClick=show_d(this,'tr<?php echo $BM[0]; ?>')>&nbsp;&nbsp;<img src=../../images/bar_edit.gif title=\"แก้ไข\" width=20 height=20 onClick=\"edit_d('<?php echo base64_encode(z.$BM[0].z00); ?>')\">&nbsp;&nbsp;<img src=../../images/bar_delete.gif title=\"ลบ\" width=20 height=20 onClick=\"delete_d('<?php echo $BM[0]; ?>')\"></td></tr><tr id=tr<?php echo $BM[0]; ?> style=display:none> <td id=td<?php echo $BM[0]; ?>   style=cursor: no-drop; onClick=return false;><?php echo addslashes($block_html); ?></td></tr></table></DIV>" ;
	CreateDragContainer(self.parent.iframe_data.document.all.tbcontent);
	self.parent.iframe_data.document.all.tbbottom.focus();
	self.parent.iframe_data.auto_save.document.form1.tagdetect.value=self.parent.iframe_data.document.all.Demo4.innerHTML;
	self.parent.iframe_data.auto_save.form1.submit();
</script>
<?php
	}
	if($_POST["Flag"] == "delcontent"){
		$sql_pos = $db->query("SELECT position FROM temp_magic WHERE text_id = '".$_POST["text_id"]."'");
		$P = $db->db_fetch_row($sql_pos);
		$db->query("UPDATE temp_magic SET position = position - 1 WHERE filename = '".$_POST["filename"]."' AND position > '".$P[0]."'");
		$db->query("DELETE FROM temp_magic WHERE text_id = '".$_POST["text_id"]."'");
?>
<script language="javascript">
	self.location.href = "../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_preview.php?filename=<?php echo $_POST["filename"]; ?>";
</script>
<?php
	}
	if($_POST["Flag"] == "SaveEditor"){
		$bcode = base64_decode($_POST["B"]);
		$bid_a = explode("z",$bcode);
		$BID = $bid_a[1];
		$sql_file = $db->query("SELECT block_link FROM block WHERE BID = '".$BID."'");

		if($db->db_num_rows($sql_file) == 1){
			$R = $db->db_fetch_array($sql_file);
			$Content = addslashes(stripslashes(stripslashes($_POST["contentHtml"])));
			$db->query("UPDATE block_text SET text_html = '".$Content."' WHERE BID = '".$BID."' AND text_id = '".$R["block_link"]."'");
			$b_name = stripslashes(htmlspecialchars($_POST["bname"],ENT_QUOTES));
			$db->query("UPDATE block SET block_name = '$b_name' , block_type='$ctype' WHERE BID = '".$BID."' ");
			if($ctype == "asp" OR $ctype == "php" OR $ctype == "jsp" OR $ctype == "gadget"){
				if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/code")){
					@mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/code", 0777);
				}
				$FileCode = "../ewt/".$_SESSION["EWT_SUSER"]."/code/code".$R["block_link"].".".$ctype;
				$Content1 = stripslashes(stripslashes($_POST["contentHtml"]));
				$fw = @fopen($FileCode, "w");
				if(!$fw){ die("Cannot write $FileCode"); }
				$FlagW = fwrite($fw, $Content1);
				@fclose($fw);
			}
		}
		$db->write_log("update","main","แก้ไข block name :".$_POST["bname"]);
?>
<script language="javascript">
	self.close();	
</script>
<?php 
	}
		function chk_w3c($text,$bid){
$arr_tag = array();//เก็บประเภทของ tag
$attribute_tag = array();//เก็บ attribute ภานใน tag
$text_value = array();//เก็บข้อความที่อยู่ระหว่าง tag
$htmlcode = eregi_replace("/>",">",stripcslashes($text)); // แก้ /> ไปก่อนเลย
$arr_words = explode("<",$htmlcode);
for($i=0;$i<count($arr_words);$i++) {
$arr_temp = array();
	if(eregi("<",$htmlcode)) {
		$tempword = eregi_replace(">"," ",$arr_words[$i]);//หา attribute ภานใน tag ปิดระหว่าง tag
		$arr_temp = explode(" ",$tempword,2);	
		$arr_tag[$i] = strtolower($arr_temp[0]);
		
		
		
								$arr_temp2 = $arr_temp3 = array();										
								$arr_temp2 = explode(">",$arr_words[$i],2); // $arr_temp[1]
								$arr_temp3 = explode(" ",$arr_temp2[0],2);
								$attribute_pack[$i] = $arr_temp3[1];  // เก็บ attribute แบบไม่ค่อยดี  ( เอาไปก่อน )
								$text_value[$i] = $arr_temp2[1];
	}
}
//ลองเอามาต่อใหม่
for($i=0;$i<count($arr_tag);$i++){
if($arr_tag[$i] != ''){
$attib = '';

	if($arr_tag[$i] == 'tr' || $arr_tag[$i] == 'td' || $arr_tag[$i] == 'table'){
		
			if (!eregi("background", $attribute_pack[$i])) {
					$attib .= $explode[$att]." ";
			}else{
			$attib .= '';
			}
			if (!eregi("height", $attribute_pack[$i])) {
					$attib .= $explode[$att]." ";
			}else{
			$attib .= '';
			}
	}else{
	$attib .= $attribute_pack[$i];
	}
	$txt .= "<".$arr_tag[$i]." ".$attib.">".$text_value[$i];
}
}
$line = ereg_replace ("images/", "../images/", $txt);//ย้อน1path
echo '';
					if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/w3cfile")) {
						@mkdir("../ewt/".$_SESSION["EWT_SUSER"]."/w3cfile",0700);
						@chmod ("../ewt/".$_SESSION["EWT_SUSER"]."/w3cfile", 0777);
					}
					$Current_Dir1 = "../ewt/".$_SESSION["EWT_SUSER"]."/w3cfile/w3c_".$bid.".html";
							if (!$fp = fopen($Current_Dir1, 'w')) {
							 //print "Cannot open file ($filename)";
							 ?>
							 <script language="JavaScript">
							 alert("Cannot open file(<?php echo $Current_Dir1;?>)");
							</script>
							 <?php
							 //exit;
							 }
							 if (!fwrite($fp, $line)) {
							//print "Cannot write to file ($filename)";
							print($line);
							 ?>
							 <script language="JavaScript">
							 alert("Cannot write to file(<?php echo $Current_Dir1;?>)");
							</script>
							 <?php
							//exit;
						  }
					fclose($fp);

}
	if($_POST["Flag"] == "SaveEditor1"){
		$bcode = base64_decode($_POST["B"]);
		$bid_a = explode("z",$bcode);
		$BID = $bid_a[1];
		$sql_file = $db->query("SELECT block_link FROM block WHERE BID = '".$BID."'");
		
		if($db->db_num_rows($sql_file) == 1){
			$R = $db->db_fetch_array($sql_file);
			$Content = addslashes(stripslashes(stripslashes($_POST["txtContent"])));
			$db->query("UPDATE block_text SET text_html = '".$Content."' WHERE BID = '".$BID."' AND text_id = '".$R["block_link"]."'");
			$b_name = stripslashes(htmlspecialchars($_POST["bname"],ENT_QUOTES));
			$db->query("UPDATE block SET block_name = '$b_name' WHERE BID = '".$BID."' ");
		}
		if($Content != ''){
		//chk_w3c($Content,$BID);
		}
		$db->write_log("edit","WebBlock","แก้ไข WebBlock   ".$_POST["bname"]);
?>
<script language="javascript">
	self.close();	
</script>
<?php 
	}
	if($_POST["Flag"] == "CreateFolder"){
		$_POST["gname"] = stripslashes(htmlspecialchars($_POST["gname"],ENT_QUOTES));

		$sql_check = $db->query("SELECT Main_Group_ID FROM temp_main_group WHERE Main_Group_Name = '".$_POST["gname"]."' ");
		if($db->db_num_rows($sql_check) > 0){
?>
<script language="javascript">
	alert("\"<?php echo $_POST["gname"]; ?>\" is already exist!!!!");
	self.location.href = "content_view.php?gid=<?php echo $_POST["gid"]; ?>";
</script>
<?php
			exit;
		}

		$sql_group = $db->query("SELECT * FROM temp_main_group WHERE Main_Group_ID = '".$_POST["gid"]."' ");
		$G = $db->db_fetch_array($sql_group);

		$exec = $db->query("SELECT * FROM temp_main_group WHERE Main_Position LIKE '".$G["Main_Position"]."_%' ORDER BY Main_Position DESC");
		if($row = $db->db_num_rows($exec)){
			$R = $db->db_fetch_array($exec);
			$m = explode("_",$R[Main_Position]);
			$len = GenLen($G[Main_Position],"_");
			$Nmenu = $m[$len]+1;
			$gen_menu = $G["Main_Position"]."_".sprintf("%04d",$Nmenu);
		}else{
			$gen_menu = $G["Main_Position"]."_0001";
		}

		$db->query("INSERT INTO temp_main_group (Main_Group_Name,Main_Position) VALUES('".$_POST["gname"]."' ,'$gen_menu' )");
		$sql_max = $db->query("SELECT MAX(Main_Group_ID) FROM temp_main_group WHERE Main_Group_Name = '".$_POST["gname"]."' ");
		$GM = $db->db_fetch_row($sql_max);
?>
<script language="javascript">
	self.top.content_left.location.reload();
	self.location.href = "content_view.php?gid=<?php echo $_POST["gid"]; ?>&select=Fo<?php echo $GM[0] ?>";
</script>
<?php
	}
	if($_POST["Flag"] == "CreateSubFolder"){
		$_POST["gname"] = stripslashes(htmlspecialchars($_POST["gname"],ENT_QUOTES));
		
		$sql_check = $db->query("SELECT Main_Group_ID FROM temp_main_group WHERE Main_Group_Name = '".$_POST["gname"]."' ");
		if($db->db_num_rows($sql_check) > 0){
?>
<script language="javascript">
	alert("\"<?php echo $_POST["gname"]; ?>\" is already exist!!!!");
	self.location.href = "content_index.php";
</script>
<?php
			exit;
		}

		$exec = $db->query("SELECT * FROM temp_main_group ORDER BY Main_Position DESC");
		if($row = $db->db_num_rows($exec)){
			$R = $db->db_fetch_array($exec);
			$m = explode("_",$R[Main_Position]);
			$Nmenu = $m[1]+1;
			$gen_menu = "0001_".sprintf("%04d",$Nmenu);
		}else{
			$gen_menu = "0001_0001";
		}
		$db->query("INSERT INTO temp_main_group (Main_Group_Name,Main_Position) VALUES('".$_POST["gname"]."' ,'$gen_menu' )");
		$sql_max = $db->query("SELECT MAX(Main_Group_ID) FROM temp_main_group WHERE Main_Group_Name = '".$_POST["gname"]."' ");
		$GM = $db->db_fetch_row($sql_max);
?>
<script language="javascript">
	self.top.content_left.location.reload();
	self.location.href = "content_index.php?select=Fo<?php echo $GM[0] ?>";
</script>
<?php
	}
	if($_POST["Flag"] == "Remove"){

           $cannot_del=0;
           // if remove is file intro
		   if($_POST["r_type"] == "Fi"){ 
					$sql_chk="SELECT filename   FROM temp_index  WHERE   filename = '".$_POST["r_name"]."' AND set_intro = 'Y' ";
					$query_chk=$db->query($sql_chk);
					
					 if($db->db_num_rows($query_chk)>0){  
						 $cannot_del=1;
						 $type_names="intro file.";
					} 
					if(strtolower($_POST["r_name"])=='index'){  
						 $cannot_del=1;
						 $type_names="index file.";
					}
		   //if remove is floder that have intro or index 
		   }elseif($_POST["r_type"] == "Fo"){
			   $sql_chk="SELECT Main_Position  FROM temp_main_group WHERE Main_Group_ID = '".$_POST["r_id"]."' ";
			   $query_chk=$db->query($sql_chk);
			   $data_chk=$db->db_fetch_array($query_chk);

				$sql_chk="SELECT filename,Main_Group_Name,set_intro
									  FROM temp_index LEFT OUTER JOIN temp_main_group ON temp_index.Main_Group_ID = temp_main_group.Main_Group_ID
									  WHERE Main_Position like '$data_chk[Main_Position]%' and (set_intro = 'Y' or filename = 'index') ";
				$query_chk=$db->query($sql_chk);
				if($db->db_num_rows($query_chk)>0){
				   $cannot_del=1;
				}
				$type_names='this folder.\nHave the index or intro file under.';
		   }

       
		if($cannot_del==1){
		        ?> 
				<script language="javascript">  
					alert('Can not delete <?php echo $type_names?>');
				    <?php if($_POST["r_type"] == "Fo"){ ?>   self.top.content_left.location.reload();  <?php } ?>
				    self.location.href = "<?php echo $_POST["direct"]; ?>";
				</script> 
				<?php
			    exit;
		}

		if($_POST["r_type"] == "Fi"){
			$db->query("DELETE FROM temp_index WHERE filename = '".$_POST["r_name"]."'");
			$db->query("DELETE FROM temp_magic WHERE filename = '".$_POST["r_name"]."'");
			$db->query("DELETE FROM block_function WHERE filename = '".$_POST["r_name"]."'");
                //multi search function
				if($search_center == "Y"){  
					$db->ms_module='P'; 
					$db->ms_link_id=$_POST["r_name"]; 
					$db->multi_search_delete();
				}
		}elseif($_POST["r_type"] == "Fo"){
			$sql_group = $db->query("SELECT * FROM temp_main_group WHERE Main_Group_ID = '".$_POST["r_id"]."' ");
			$G = $db->db_fetch_array($sql_group);
			$POS = $G[Main_Position];
			$sql_sub = $db->query("SELECT * FROM temp_main_group WHERE Main_Position LIKE '".$POS."_%' ");
			while($R=$db->db_fetch_array($sql_sub)){
				$sql_file = $db->query("SELECT filename FROM temp_index WHERE Main_Group_ID = '$R[Main_Group_ID]' ");
				while($F = $db->db_fetch_row($sql_file)){
					$db->query("DELETE FROM temp_index WHERE filename = '".$F[0]."'");
					$db->query("DELETE FROM temp_magic WHERE filename = '".$F[0]."'");
					$db->query("DELETE FROM block_function WHERE filename = '".$F[0]."'");
				}
				$db->query("DELETE FROM temp_main_group WHERE Main_Group_ID = '$R[Main_Group_ID]'");
			}
			$db->query("DELETE FROM temp_main_group WHERE Main_Group_ID = '$G[Main_Group_ID]'");

			$len = GenLen($POS,"_");
			$len--;
			$numr = strlen($POS);
			$rest = substr($POS, 0, -4);

			if($EWT_DB_TYPE == "MYSQL"){
				$sql = $db->query("SELECT * FROM temp_main_group WHERE Main_Position LIKE '$rest%' AND Main_Position > '".$POS."'  AND length(Main_Position) >= '$numr' ORDER BY Main_Position ASC");
			}elseif($EWT_DB_TYPE == "MSSQL"){
				$sql = $db->query("SELECT * FROM temp_main_group WHERE Main_Position LIKE '$rest%' AND Main_Position > '".$POS."'  AND len(Main_Position) >= '$numr' ORDER BY Main_Position ASC");
			}

			while($R = $db->db_fetch_array($sql)){
				$data = explode("_",$R[Main_Position]);
				$num_array = count($data);
				$field_change = $data[$len]-1;
				$field_change = sprintf("%04d",$field_change);
				$total = "";
				for($i=0;$i<$num_array;$i++){
					if($i == $len ){
						$total .= $field_change."_";
					}else{
						$total .= $data[$i]."_";
					}
				}
				$total = substr($total, 0, -1);
				$sel = "UPDATE temp_main_group SET Main_Position = '$total' WHERE Main_Group_ID = '$R[Main_Group_ID]'  ";
				$db->query($sel);
			}
		}
?>
<script language="javascript">
<?php if($_POST["r_type"] == "Fo"){ ?>
	self.top.content_left.location.reload();
<?php } ?>
	self.location.href = "<?php echo $_POST["direct"]; ?>";
</script>
<?php
	}
	if($_POST["Flag"] == "Close"){
		if(!(session_is_registered("EWT_OPEN_SAVE"))){
			session_register("EWT_OPEN_SAVE");
			$_SESSION["EWT_OPEN_SAVE"] = array();
		}	

		$num = count($_SESSION["EWT_OPEN_SAVE"]);
		for($i=0;$i<$num;$i++){
			if($_SESSION["EWT_OPEN_SAVE"][$i] == $_POST["file_name"]){
				array_splice($_SESSION["EWT_OPEN_SAVE"],$i,1);
			}
		}
?>
<script language="JavaScript">
	self.top.ewt_main.location.href='../ewt_main.php';
</script>
<?php
	}
	if($_POST["Flag"] == "MoveUp"){
		$sql = $db->query("SELECT position FROM temp_magic WHERE text_id = '".$_POST["text_id"]."'");
		$P = $db->db_fetch_row($sql);
		
		$P_before = ($P[0] -1);
		
		$db->query("UPDATE temp_magic SET position = '".$P[0]."' WHERE filename = '".$_POST["filename"]."' AND position = '".$P_before."' ");
		$db->query("UPDATE temp_magic SET position = '".$P_before."' WHERE text_id = '".$_POST["text_id"]."' ");
?>
<script language="JavaScript">
	self.location.href = "../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_preview.php?filename=<?php echo $_POST["filename"]; ?>#text<?php echo $_POST["text_id"]; ?>";
</script>
<?php
	}
	if($_POST["Flag"] == "MoveDown"){
		$sql = $db->query("SELECT position FROM temp_magic WHERE text_id = '".$_POST["text_id"]."'");
		$P = $db->db_fetch_row($sql);
		
		$P_after = ($P[0] +1);
		
		$db->query("UPDATE temp_magic SET position = '".$P[0]."' WHERE filename = '".$_POST["filename"]."' AND position = '".$P_after."' ");
		$db->query("UPDATE temp_magic SET position = '".$P_after."' WHERE text_id = '".$_POST["text_id"]."' ");

?>
<script language="JavaScript">
	self.location.href = "../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_preview.php?filename=<?php echo $_POST["filename"]; ?>#text<?php echo $_POST["text_id"]; ?>";
</script>
<?php
	}
	if($_POST["Flag"] == "HiddenD"){
		if(!(session_is_registered("EWT_HIDDEN_DESIGN"))){
			session_register("EWT_HIDDEN_DESIGN");
		}	
		$_SESSION["EWT_HIDDEN_DESIGN"] = "Y";
?>
<script language="JavaScript">
	self.location.href='content_head.php?filename=<?php echo $_POST["file_name"]; ?>';
</script>
<?php
	}
	if($_POST["Flag"] == "ShowD"){
		if(!(session_is_registered("EWT_HIDDEN_DESIGN"))){
			session_register("EWT_HIDDEN_DESIGN");
		}	
		$_SESSION["EWT_HIDDEN_DESIGN"] = "N";
?>
<script language="JavaScript">
	self.location.href='content_head.php?filename=<?php echo $_POST["file_name"]; ?>';
</script>
<?php
	}
	if($_POST["Flag"] == "SaveDataConfig"){
		$_POST["keyword"] = stripslashes(htmlspecialchars($_POST["keyword"],ENT_QUOTES));
		$_POST["description"] = stripslashes(htmlspecialchars($_POST["description"],ENT_QUOTES));
			$sql_check = $db->query("SELECT filename FROM temp_index WHERE filename = '".$_POST["file_name"]."'");
		$update = "UPDATE temp_index  SET  Main_Group_ID = '".$_POST["group_id"]."', cms_keyword = '".$_POST["keyword"]."', cms_description = '".$_POST["description"]."', title = '".$_POST["title"]."' where filename = '".$_POST["filename"]."'";
		$db->query($update);
		if($_POST["no_bgsite"] == "Y")		{ $_POST["d_site_bg_p"] = ""; }
		if($_POST["no_bgtop"] == "Y")		{ $_POST["d_top_bg_p"] = ""; }
		if($_POST["no_bgleft"] == "Y")		{ $_POST["d_left_bg_p"] = ""; }
		if($_POST["no_bgcontent"] == "Y")	{ $_POST["d_body_bg_p"] = ""; }
		if($_POST["no_bgright"] == "Y")		{ $_POST["d_right_bg_p"] = ""; }
		if($_POST["no_bgbottom"] == "Y")	{ $_POST["d_bottom_bg_p"] = ""; }
		//SET intro
		if($_POST["chk_for_intro"] == 'Y'){
			$sql_intro = "select * from temp_index";
			$query_intro = $db->query($sql_intro);
			while($rec_intro = $db->db_fetch_array($query_intro)){
				$db->query("UPDATE temp_index SET set_intro = '' WHERE filename = '".$rec_intro[filename]."' ");
			}
		}
		$Update = "
			UPDATE temp_index 
			SET 
				d_site_align = '".$_POST["d_site_align"]."',
				d_site_width = '".$_POST["d_site_width"]."',
				d_site_left = '".$_POST["d_site_left"]."',
				d_site_content = '".$_POST["d_site_content"]."',
				d_site_right = '".$_POST["d_site_right"]."',
				d_site_bg_c = '".$_POST["d_site_bg_c"]."',
				d_site_bg_p = '".$_POST["d_site_bg_p"]."',
				d_top_height = '".$_POST["d_top_height"]."',
				d_top_bg_c = '".$_POST["d_top_bg_c"]."',
				d_top_bg_p = '".$_POST["d_top_bg_p"]."',
				d_body_bg_c = '".$_POST["d_body_bg_c"]."',
				d_body_bg_p = '".$_POST["d_body_bg_p"]."',
				d_left_bg_c = '".$_POST["d_left_bg_c"]."',
				d_left_bg_p = '".$_POST["d_left_bg_p"]."',
				d_right_bg_c = '".$_POST["d_right_bg_c"]."',
				d_right_bg_p = '".$_POST["d_right_bg_p"]."',
				d_bottom_height = '".$_POST["d_bottom_height"]."',
				d_bottom_bg_c = '".$_POST["d_bottom_bg_c"]."',
				d_bottom_bg_p = '".$_POST["d_bottom_bg_p"]."',
				template_id = '".$_POST["select_template"]."',
				template_id_w3c = '".$_POST["select_template_w3c"]."',
				set_intro = '".$_POST["chk_for_intro"]."' 
			WHERE filename = '".$_POST["filename"]."'";
		$db->query($Update);

		if($_POST["select_template"] != $_POST["templade_old"]){

			##update template
			
			$sql_temp1 = $db->query("SELECT * FROM design_list WHERE d_id = '".$_POST["select_template"]."' ");
			$R = $db->db_fetch_array($sql_temp1);
			for($i=1;$i<6;$i++){
				$sql_block = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON block.BID = design_block.BID WHERE block.block_edit != 'Y' AND design_block.side = '".$i."' AND design_block.d_id = '".$_POST["select_template"]."' ORDER BY design_block.position ASC");
				$x = 0;
				while($B = $db->db_fetch_row($sql_block)){
					$bid[$i][$x] = $B[0];
					$x++;
				}
			}

			//SET intro
			if($_POST["chk_for_intro"] == 'Y'){
				$sql_intro = "select * from temp_index";
				$query_intro = $db->query($sql_intro);
				while($rec_intro = $db->db_fetch_array($query_intro)){
					$db->query("UPDATE temp_index SET set_intro = '' WHERE filename = '".$rec_intro[filename]."' ");
				}
			}
			$db->query("UPDATE temp_index SET d_site_align = '".$R["d_site_align"]."' , d_site_width = '".$R["d_site_width"]."' , d_site_left = '".$R["d_site_left"]."' , d_site_content = '".$R["d_site_content"]."' , d_site_right = '".$R["d_site_right"]."' , d_site_bg_c = '".$R["d_site_bg_c"]."' , d_site_bg_p = '".$R["d_site_bg_p"]."' , d_top_height = '".$R["d_top_height"]."' , d_top_bg_c = '".$R["d_top_bg_c"]."' , d_top_bg_p = '".$R["d_top_bg_p"]."' , d_top_content = '".$R["d_top_content"]."' , d_body_bg_c = '".$R["d_body_bg_c"]."' , d_body_bg_p = '".$R["d_body_bg_p"]."' , d_left_bg_c = '".$R["d_left_bg_c"]."' , d_left_bg_p = '".$R["d_left_bg_p"]."' , d_right_bg_c = '".$R["d_right_bg_c"]."' , d_right_bg_p = '".$R["d_right_bg_p"]."' , d_bottom_height = '".$R["d_bottom_height"]."' , d_bottom_bg_c = '".$R["d_bottom_bg_c"]."' , d_bottom_bg_p = '".$R["d_bottom_bg_p"]."' , d_bottom_content = '".$R["d_bottom_content"]."',set_intro = '".$_POST["chk_for_intro"]."' WHERE filename = '".$_POST["filename"]."' ");

			for($i=1;$i<6;$i++){
				$sql_block = $db->query("SELECT block.BID FROM block INNER JOIN block_function ON block.BID = block_function.BID WHERE block.block_edit = 'Y' AND block_function.side = '".$i."' AND block_function.filename = '".$_POST["filename"]."' ORDER BY block_function.position ASC");
				$x = count($bid[$i]);
				while($B = $db->db_fetch_row($sql_block)){
					$bid[$i][$x] = $B[0];
					$x++;	
				}
				$db->query("DELETE FROM block_function WHERE side = '".$i."' AND filename = '".$_POST["filename"]."'");
				$c = count($bid[$i]);
				for($y=0;$y<$c;$y++){
					if($bid[$i][$y] != ""){
						$db->query("INSERT INTO block_function (BID,side,position,filename) VALUES ('".$bid[$i][$y]."','".$i."','".$y."','".$_POST["filename"]."')");
					}
				}
			}

		}
	//set block design
		if($_POST[select_block_desing] != ''){
			$db->query("UPDATE block SET block_themes = '".$_POST[select_block_desing]."' WHERE filename = '".$_POST["filename"]."' ");
			
			//$db->query("UPDATE design_list SET d_bottom_content = '".$_POST[select_block_desing]."' WHERE d_id = '".$_POST["select_template"]."' ");
			$sql_block = $db->query("SELECT * FROM block,design_block WHERE block.BID=design_block.BID and  design_block.d_id  = '".$_POST["select_template"]."'  and block_edit ='Y'");
			while($R=$db->db_fetch_array($sql_block)){
				$update = "update block set block_themes = '".$_POST[select_block_desing]."' where BID = '".$R[BID]."'";
				$db->query($update);
			}

		}
##update template

?>
<script language="javascript">
	window.opener.iframe_data.location.reload();
	self.close();
</script>
<?php 
	}
	if($_POST["Flag"] == "SaveTemplateConfig"){

		if($_POST["no_bgsite"] == "Y")		{ $_POST["d_site_bg_p"] = ""; }
		if($_POST["no_bgtop"] == "Y")		{ $_POST["d_top_bg_p"] = ""; }
		if($_POST["no_bgleft"] == "Y")		{ $_POST["d_left_bg_p"] = ""; }
		if($_POST["no_bgcontent"] == "Y")	{ $_POST["d_body_bg_p"] = ""; }
		if($_POST["no_bgright"] == "Y")		{ $_POST["d_right_bg_p"] = ""; }
		if($_POST["no_bgbottom"] == "Y")	{ $_POST["d_bottom_bg_p"] = ""; }
		//SET intro

		$Update = "
			UPDATE temp_index 
			SET 
				d_site_align = '".$_POST["d_site_align"]."',
				d_site_width = '".$_POST["d_site_width"]."',
				d_site_left = '".$_POST["d_site_left"]."',
				d_site_content = '".$_POST["d_site_content"]."',
				d_site_right = '".$_POST["d_site_right"]."',
				d_site_bg_c = '".$_POST["d_site_bg_c"]."',
				d_site_bg_p = '".$_POST["d_site_bg_p"]."',
				d_top_height = '".$_POST["d_top_height"]."',
				d_top_bg_c = '".$_POST["d_top_bg_c"]."',
				d_top_bg_p = '".$_POST["d_top_bg_p"]."',
				d_body_bg_c = '".$_POST["d_body_bg_c"]."',
				d_body_bg_p = '".$_POST["d_body_bg_p"]."',
				d_left_bg_c = '".$_POST["d_left_bg_c"]."',
				d_left_bg_p = '".$_POST["d_left_bg_p"]."',
				d_right_bg_c = '".$_POST["d_right_bg_c"]."',
				d_right_bg_p = '".$_POST["d_right_bg_p"]."',
				d_bottom_height = '".$_POST["d_bottom_height"]."',
				d_bottom_bg_c = '".$_POST["d_bottom_bg_c"]."',
				d_bottom_bg_p = '".$_POST["d_bottom_bg_p"]."'
			WHERE filename = '".$_POST["filename"]."'";
		$db->query($Update);

if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/intro")) {
	@mkdir("../ewt/".$_SESSION["EWT_SUSER"]."/intro",0700);
}
//SET default
		if($_POST["chk_t_default"] == 'Y'){
			$sql_default = "select d_id from design_list";
			$query_default = $db->query($sql_default);
			while($rec_default = $db->db_fetch_array($query_default)){
				$db->query("UPDATE design_list SET d_default = '' WHERE d_id = '".$rec_default[d_id]."' ");
			}
		}
//SET default w3c
		if($_POST["chk_t_default_w3c"] == 'Y'){
			$sql_default = "select d_id from design_list";
			$query_default = $db->query($sql_default);
			while($rec_default = $db->db_fetch_array($query_default)){
				$db->query("UPDATE design_list SET d_default_w3c = '' WHERE d_id = '".$rec_default[d_id]."' ");
			}
		}
		//SET intro
		if($_POST["d_intro_cancel"] == "Y"){
		    $d_intro1 = "";
		}else{
			if($_FILES["file_html"]['size'] > 0 ){
			    $tmpname = "intro_".$_POST["d_id"].".html";
			    copy($_FILES["file_html"]["tmp_name"],"../ewt/".$_SESSION["EWT_SUSER"]."/intro/".$tmpname);
			    $d_intro1= "Y";
			}else{
			    $d_intro1 =$_POST["d_intro"];
			}
		}
		$d_name_tn = stripslashes(htmlspecialchars($_POST["d_name_t"],ENT_QUOTES));
		$Update = "UPDATE design_list SET d_name = '".$d_name_tn."',d_default = '".$_POST["chk_t_default"]."',d_default_w3c = '".$_POST["chk_t_default_w3c"]."', d_bottom_content = '".$_POST[select_block_design]."' ,d_intro = '".$d_intro1."',d_top_content = '".$_POST["img_floder"]."' WHERE d_id = '".$_POST["d_id"]."'";
		$db->query($Update);
		
		$sql_block = $db->query("SELECT block.BID FROM block,design_block WHERE block.BID=design_block.BID and  design_block.d_id  = '".$_POST["d_id"]."' ");
		while($R=$db->db_fetch_array($sql_block)){
			$update = "update block set block_themes = '".$_POST[select_block_desing]."' where BID = '".$R[BID]."'";
			$db->query($update);
		}

//SET thumbnail picture
if($_POST[d_thumb_cancel]=='Y'){
	      $thumb_name = "../ewt/template/images/thumbnails/template_".$_POST["d_id"];
          @unlink($thumb_name);
}else{
		if($_FILES["file_thumb"]['size'] > 0 ){
			$d=explode('.',$_FILES["file_thumb"]["name"]);
			$index=sizeof($d)-1;
			$dir=$d[$index];

			if(!file_exists("../ewt/template/images/thumbnails")) {
				@mkdir("../ewt/template/images/thumbnails",0700);
			}

			if($dir=='jpg' or $dir=='png' or $dir=='gif' or $dir=='jpeg'){
			   $thumb_name = "template_".$_POST["d_id"];
			   
			   copy($_FILES["file_thumb"]["tmp_name"],"../ewt/template/images/thumbnails/".$thumb_name);
			}else{
			   ?><script>alert('File type is not (jpeg, jpg, gif, bmp)')</script><?php
			}
		}
}




		$db->write_log("update","Site Design","ปรับปรุง properties template  ".$_POST["d_name"]);
?>
<script language="javascript">
	window.opener.iframe_data.location.reload();
	self.close();
</script>
<?php 
	}
	if($_POST["Flag"] == "SaveToTemp"){ 
		$sql_temp = $db->query("SELECT * FROM temp_index WHERE filename = '".$_POST["filename"]."' ");
		$TP = $db->db_fetch_array($sql_temp);
		$d_site_align = $TP["d_site_align"];
		$d_site_width = $TP["d_site_width"];
		$d_site_left = $TP["d_site_left"];
		$d_site_content = $TP["d_site_content"];
		$d_site_right = $TP["d_site_right"];
		$d_site_bg_c = $TP["d_site_bg_c"];
		$d_site_bg_p = $TP["d_site_bg_p"];
		$d_top_height = $TP["d_top_height"];
		$d_top_bg_c = $TP["d_top_bg_c"];
		$d_top_bg_p = $TP["d_top_bg_p"];
		$d_body_bg_c = $TP["d_body_bg_c"];
		$d_body_bg_p = $TP["d_body_bg_p"];
		$d_left_bg_c = $TP["d_left_bg_c"];
		$d_left_bg_p = $TP["d_left_bg_p"];
		$d_right_bg_c = $TP["d_right_bg_c"];
		$d_right_bg_p = $TP["d_right_bg_p"];
		$d_bottom_height = $TP["d_bottom_height"];
		$d_bottom_bg_c = $TP["d_bottom_bg_c"];
		$d_bottom_bg_p = $TP["d_bottom_bg_p"];
		$tname=stripslashes(htmlspecialchars($_POST["file_name"],ENT_QUOTES));

		$sql_check_name = $db->query("SELECT d_id FROM design_list WHERE d_name = '".$tname."' ");
		if($db->db_num_rows($sql_check_name) > 0){
			$BP = $db->db_fetch_row($sql_check_name);
			$Update = "UPDATE design_list SET d_site_align = '".$TP["d_site_align"]."',
			d_site_width = '".$TP["d_site_width"]."',
			d_site_left = '".$TP["d_site_left"]."',
			d_site_content = '".$TP["d_site_content"]."',
			d_site_right = '".$TP["d_site_right"]."',
			d_site_bg_c = '".$TP["d_site_bg_c"]."',
			d_site_bg_p = '".$TP["d_site_bg_p"]."',
			d_top_height = '".$TP["d_top_height"]."',
			d_top_bg_c = '".$TP["d_top_bg_c"]."',
			d_top_bg_p = '".$TP["d_top_bg_p"]."',
			d_body_bg_c = '".$TP["d_body_bg_c"]."',
			d_body_bg_p = '".$TP["d_body_bg_p"]."',
			d_left_bg_c = '".$TP["d_left_bg_c"]."',
			d_left_bg_p = '".$TP["d_left_bg_p"]."',
			d_right_bg_c = '".$TP["d_right_bg_c"]."',
			d_right_bg_p = '".$TP["d_right_bg_p"]."',
			d_bottom_height = '".$TP["d_bottom_height"]."',
			d_bottom_bg_c = '".$TP["d_bottom_bg_c"]."',
			d_bottom_bg_p = '".$TP["d_bottom_bg_p"]."' WHERE d_id = '".$BP[0]."'";
			$db->query($Update);
			$db->query("DELETE FROM design_block WHERE d_id = '".$BP[0]."' ");
		}else{
			$db->query("INSERT INTO design_list (d_name,d_site_align,d_site_width,d_site_left,d_site_content,d_site_right,d_site_bg_c,d_site_bg_p,d_top_height,d_top_bg_c,d_top_bg_p,d_top_content,d_body_bg_c,d_body_bg_p,d_left_bg_c,d_left_bg_p,d_right_bg_c,d_right_bg_p,d_bottom_height,d_bottom_bg_c,d_bottom_bg_p,d_bottom_content) VALUES ('".$tname."','".$d_site_align."','".$d_site_width."','".$d_site_left."','".$d_site_content."','".$d_site_right."','".$d_site_bg_c."','".$d_site_bg_p."','".$d_top_height."','".$d_top_bg_c."','".$d_top_bg_p."','".$d_top_content."','".$d_body_bg_c."','".$d_body_bg_p."','".$d_left_bg_c."','".$d_left_bg_p."','".$d_right_bg_c."','".$d_right_bg_p."','".$d_bottom_height."','".$d_bottom_bg_c."','".$d_bottom_bg_p."','".$d_bottom_content."')");
			$sql_max = $db->query("SELECT MAX(d_id) FROM design_list WHERE d_name = '".$tname."' ");
			$BP = $db->db_fetch_row($sql_max);
		}

		$block_position = $db->query("SELECT block_function.* FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE  block_function.filename = '".$_POST["filename"]."' ORDER BY block_function.side,block_function.position ASC");
		while($P = $db->db_fetch_array($block_position)){

			$bedit = $_POST["chk".$P["BID"]];
			if($bedit == "Y"){

				$sql_block = $db->query("SELECT * FROM block WHERE BID = '".$P["BID"]."' ");
				$B = $db->db_fetch_array($sql_block);
				$db->query("INSERT INTO block (block_name,block_type,block_html,block_link,filename,block_edit) VALUES ('".$B["block_name"]."','".$B["block_type"]."','".addslashes(stripslashes($B["block_html"]))."','".$B["block_link"]."','','Y')");
				$sql_max = $db->query("SELECT MAX(BID) FROM block WHERE block_name = '".$B["block_name"]."' AND block_edit = 'Y' ");
				$BM = $db->db_fetch_row($sql_max);
				if($B["block_type"] == "text" OR $B["block_type"] == "code" OR $B["block_type"] == "images" OR $B["block_type"] == "flash" OR $B["block_type"] == "media"){
					$sql_text = $db->query("SELECT * FROM block_text WHERE text_id = '".$B["block_link"]."' ");
					$T = $db->db_fetch_array($sql_text);
					$db->query("INSERT INTO block_text (BID,text_html) VALUES ('".$BM[0]."','".addslashes(stripslashes($T["text_html"]))."')");
					$sql_textm = $db->query("SELECT MAX(text_id) FROM block_text WHERE BID = '".$BM[0]."' ");
					$TM = $db->db_fetch_row($sql_textm);
					$db->query("UPDATE block SET block_link = '".$TM[0]."' WHERE BID = '".$BM[0]."' ");
				}
				$BID_ID = $BM[0];
			}else{
				$BID_ID = $P["BID"];
				$db->query("UPDATE block SET filename = '',block_edit = '' WHERE BID = '".$P["BID"]."' ");
			}

			$db->query("INSERT INTO design_block (BID,side,position,d_id) VALUES ('".$BID_ID."','".$P["side"]."','".$P["position"]."','".$BP[0]."') ");

		}
?>
<script language="javascript">
	window.opener.location.reload();
	self.close();	
</script>
<?php
	}
	if($_POST["Flag"] == "SetShare"){
		$block_name = "BlockNO".date("YmdHis");
		$db->query("INSERT INTO block (block_name,block_type,block_link,filename,block_edit) VALUES ('".$block_name."','share','".$_POST["inc"]."','".$_POST["filename"]."','Y')");
		$sql_max = $db->query("SELECT MAX(BID) FROM block WHERE block_name = '".$block_name."' AND filename = '".$_POST["filename"]."' ");
		$BM = $db->db_fetch_row($sql_max);
		$db->write_log("create","main","สร้าง block ที่ได้ทำการ share : ".$block_name." ใน web page : ".$_POST["filename"]);
		$block_html = "<img src=\"../../images/preview_cs.gif\" width=\"194\" height=\"155\">";
		include("../ewt_block_function.php");
?>
<script language="javascript">
	function CreateDragContainer(){
		/*
		Create a new "Container Instance" so that items from one "Set" can not
		be dragged into items from another "Set"
		*/
		var DragDrops   = [];
		var cDrag = DragDrops.length;
		DragDrops[cDrag] = [];
		
		/*
		Each item passed to this function should be a "container".  Store each
		of these items in our current container
		*/
		for(var i=0; i<arguments.length; i++){
			var cObj = arguments[i];
			DragDrops[cDrag].push(cObj);
			cObj.setAttribute('DropObj', cDrag);
	
			/*
			Every top level item in these containers should be draggable.  Do this
			by setting the DragObj attribute on each item and then later checking
			this attribute in the mouseMove function
			*/
			for(var j=0; j<cObj.childNodes.length; j++){
				
				// Firefox puts in lots of #text nodes...skip these
				if(cObj.childNodes[j].nodeName=='#text') continue;
				
				cObj.childNodes[j].setAttribute('DragObj', cDrag);
			}
		}
	}
	
	
	self.parent.iframe_data.document.all.tbcontent.innerHTML = self.parent.iframe_data.document.all.tbcontent.innerHTML + "<DIV class=DragBox id=EWTID_S<?php echo $BM[0]; ?>EWTID_E overClass=OverDragBox dragClass=DragDragBox align=left> :: <?php echo $block_name; ?> :: <table width=100% border=0 cellspacing=0 cellpadding=0> <tr style=cursor:hand><td height=20 bgcolor=F3F3EE><img src=\"<?php echo icon_block("share"); ?>\" width=20 height=20 align=absmiddle>&nbsp;&nbsp;&nbsp;&nbsp;<img id=EWTpospic src=../../images/bar_down.gif width=20 height=20 onClick=show_d(this,'tr<?php echo $BM[0]; ?>')>&nbsp;&nbsp;<img src=../../images/bar_block.gif width=20 height=20 >&nbsp;&nbsp;<img src=../../images/bar_delete.gif width=20 height=20 onClick=\"delete_d('<?php echo $BM[0]; ?>')\"></td></tr><tr id=tr<?php echo $BM[0]; ?> style=display:none> <td id=td<?php echo $BM[0]; ?>   style=cursor: no-drop; onClick=return false;><?php echo addslashes($block_html); ?></td></tr></table></DIV>" ;
	CreateDragContainer(self.parent.iframe_data.document.all.tbcontent);
	self.parent.iframe_data.document.all.tbbottom.focus();
	self.parent.iframe_data.auto_save.document.form1.tagdetect.value=self.parent.iframe_data.document.all.Demo4.innerHTML;
	self.parent.iframe_data.auto_save.form1.submit();
</script>
<?php
	}
	if($_POST["Flag"] == "EditChoose"){
		$bcode = base64_decode($_POST["filename"]);
		$bid_a = explode("z",$bcode);
		$BID = $bid_a[1];
		$sql_file = $db->query("SELECT block_link FROM block WHERE BID = '".$BID."'");
		if($db->db_num_rows($sql_file) == 1){
			$R = $db->db_fetch_array($sql_file);
			if($_POST["stype"] == "images"){
				$b_html = $_POST["align"]."@@##@@".$_POST["height"]."@@##@@".$_POST["width"]."@@##@@@@##@@@@##@@".$_POST["objfile"]."@@##@@".$_POST["border"];
				$block_html = "<div align=".$_POST["align"]."><img src=\"".$_POST["objfile"]."\" width=".$_POST["width"]." height=".$_POST["height"]."></div>";
			}
			if($_POST["stype"] == "flash"){
				$b_html = $_POST["align"]."@@##@@".$_POST["height"]."@@##@@".$_POST["width"]."@@##@@@@##@@@@##@@".$_POST["objfile"];
				$block_html = "<div  align=\"".$_POST["align"]."\" ><object   classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"".$_POST["width"]."\" height=\"".$_POST["height"]."\"><param name=\"movie\" value=\"".$_POST["objfile"]."\"><param name=\"quality\" value=\"high\"><embed src=\"".$_POST["objfile"]."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"".$_POST["width"]."\" height=\"".$_POST["height"]."\"></embed></object></div>";
			}
			if($_POST["stype"] == "media"){
				if($_POST["hide"] == "Y"){
					$_POST["height"] = 0;
					$_POST["width"] = 0;
				}
				if($_POST["auto"] != "1"){
					$_POST["auto"] = 0;
				}
				if($_POST["repeat"] != "1"){
					$_POST["repeat"] = 0;
				}else{
					$_POST["repeat"] = 50;
				}
				$b_html =  $_POST["align"]."@@##@@".$_POST["height"]."@@##@@".$_POST["width"]."@@##@@".$_POST["auto"]."@@##@@".$_POST["repeat"]."@@##@@".$_POST["objfile"];
				$block_html = "<img src=\"../../images/media_preview.gif\" width=\"194\" height=\"155\">";
			}

			$db->query("UPDATE block_text SET text_html = '$b_html' WHERE BID = '".$BID."' AND text_id = '".$R["block_link"]."'");

?>
<script language="javascript">
	if(self.parent.iframe_data){
		self.parent.iframe_data.document.getElementById('td<?php echo $BID; ?>').innerHTML = "<?php echo addslashes($block_html); ?>";
	}
	if(self.parent.block_body_index){
		self.parent.block_body_index.iframe_data.document.getElementById('td<?php echo $BID; ?>').innerHTML = "<?php echo addslashes($block_html); ?>";
	}
	if(self.parent.look_body_index){
		self.parent.look_body_index.look_top.document.getElementById('td<?php echo $BID; ?>').innerHTML = "<?php echo addslashes($block_html); ?>";
	}
</script>
<?php
		}
	}
	if($_GET["Flag"] == "ChangeLanguage"){
		$default_filename = $_GET["file_name"];
		if($_GET["file_suffix"] == '') {
			$lang_filename = $_GET["file_name"];
		} else {
			$lang_filename = $_GET["file_name"]."___".$_GET["file_suffix"];
		}
		$sql_check = $db->query("SELECT filename FROM temp_index WHERE filename = '".$lang_filename."'");
		if($db->db_num_rows($sql_check) > 0) {
?>
<script language="javascript">
	self.top.window.opener.top.ewt_main.location.href="content_mgt.php?filename=<?php echo $lang_filename; ?>"
	self.close();
</script>
<?php
			exit;
		} else {
			$sql_temp_default = $db->query("SELECT * FROM temp_index WHERE filename = '".$default_filename."' ");
			$TP = $db->db_fetch_array($sql_temp_default);
				$group_id = $TP["Main_Group_ID"];
				$template_id = $TP["template_id"];
				$d_site_align = $TP["d_site_align"];
				$d_site_width = $TP["d_site_width"];
				$d_site_left = $TP["d_site_left"];
				$d_site_content = $TP["d_site_content"];
				$d_site_right = $TP["d_site_right"];
				$d_site_bg_c = $TP["d_site_bg_c"];
				$d_site_bg_p = $TP["d_site_bg_p"];
				$d_top_height = $TP["d_top_height"];
				$d_top_bg_c = $TP["d_top_bg_c"];
				$d_top_bg_p = $TP["d_top_bg_p"];
				$d_body_bg_c = $TP["d_body_bg_c"];
				$d_body_bg_p = $TP["d_body_bg_p"];
				$d_left_bg_c = $TP["d_left_bg_c"];
				$d_left_bg_p = $TP["d_left_bg_p"];
				$d_right_bg_c = $TP["d_right_bg_c"];
				$d_right_bg_p = $TP["d_right_bg_p"];
				$d_bottom_height = $TP["d_bottom_height"];
				$d_bottom_bg_c = $TP["d_bottom_bg_c"];
				$d_bottom_bg_p = $TP["d_bottom_bg_p"];
				$title = $TP["title"];
				$description = $TP["cms_description"];
				$keyword = $TP["cms_keyword"];
			$db->query("
				INSERT INTO temp_index (
					filename, Main_Group_ID, template_id, d_site_align, d_site_width, 
					d_site_left, d_site_content, d_site_right, d_site_bg_c, d_site_bg_p, 
					d_top_height, d_top_bg_c, d_top_bg_p, d_body_bg_c, d_body_bg_p, 
					d_left_bg_c, d_left_bg_p, d_right_bg_c, d_right_bg_p, d_bottom_height, 
					d_bottom_bg_c, d_bottom_bg_p, title, cms_description, cms_keyword, 
					Created_Date, Modified_Date, filename_link) 
				VALUES (
					'".$lang_filename."', '".$group_id."', '".$template_id."', '".$d_site_align."', '".$d_site_width."', 
					'".$d_site_left."', '".$d_site_content."', '".$d_site_right."', '".$d_site_bg_c."', '".$d_site_bg_p."', 
					'".$d_top_height."', '".$d_top_bg_c."', '".$d_top_bg_p."', '".$d_body_bg_c."', '".$d_body_bg_p."', 
					'".$d_left_bg_c."', '".$d_left_bg_p."', '".$d_right_bg_c."', '".$d_right_bg_p."', '".$d_bottom_height."', 
					'".$d_bottom_bg_c."', '".$d_bottom_bg_p."', '".$title."', '".$description."', '".$keyword."', 
					NOW(), NOW(), 'E')");
			$sql_block = $db->query("SELECT *,block.BID AS b_id  FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.d_id = '".$template_id."' ORDER BY design_block.side,design_block.position ASC");
			while($B = $db->db_fetch_array($sql_block)) {
				if($B["block_edit"] == "Y") {
					$db->query("INSERT INTO block (block_name,block_type,block_html,block_link,filename,block_edit) VALUES ('".$B["block_name"]."','".$B["block_type"]."','".addslashes(stripslashes($B["block_html"]))."','".$B["block_link"]."','".$lang_filename."','Y')");
					$sql_max = $db->query("SELECT MAX(BID) FROM block WHERE block_name = '".$B["block_name"]."' AND filename = '".$lang_filename."' ");
					$BM = $db->db_fetch_row($sql_max);
					if($B["block_type"] == "text" OR $B["block_type"] == "code" OR $B["block_type"] == "images" OR $B["block_type"] == "flash" OR $B["block_type"] == "media"){
						$sql_text = $db->query("SELECT * FROM block_text WHERE text_id = '".$B["block_link"]."' ");
						$T = $db->db_fetch_array($sql_text);
						$db->query("INSERT INTO block_text (BID,text_html,filename) VALUES ('".$BM[0]."','".addslashes(stripslashes($T["text_html"]))."','".$lang_filename."')");
						$sql_textm = $db->query("SELECT MAX(text_id) FROM block_text WHERE filename = '".$lang_filename."' ");
						$TM = $db->db_fetch_row($sql_textm);
						$db->query("UPDATE block SET block_link = '".$TM[0]."' WHERE BID = '".$BM[0]."' ");
					}
					$BID = $BM[0];
				} else { $BID = $B["b_id"]; }
				$db->query("INSERT INTO block_function (BID,UID,side,position,filename) VALUES ('".$BID."','".$B["UID"]."','".$B["side"]."','".$B["position"]."','".$lang_filename."') ");
			}//end if else
			$sql_block = $db->query("SELECT * FROM block WHERE filename = '".$default_filename."'");
			while($B = $db->db_fetch_array($sql_block)) {
				$db->query("
				INSERT INTO block (
					block_name, block_type, block_html, block_link, filename, 
					block_edit, block_share, block_themes) 
				VALUES (
					'".$B["block_name"]."', '".$B["block_type"]."', '".addslashes(stripslashes($B["block_html"]))."', '".$B["block_link"]."', '".$lang_filename."', 
					'".$B["block_edit"]."', '".$B["block_share"]."', '".$B["block_themes"]."')");
				$sql_max = $db->query("SELECT MAX(BID) FROM block");
				$BPMAX = $db->db_fetch_row($sql_max);
				
						$sql_text = $db->query("SELECT * FROM block_text WHERE BID = '".$B["BID"]."' ");
						$T = $db->db_fetch_array($sql_text);
						$db->query("INSERT INTO block_text (BID,text_html,filename) VALUES ('".$BPMAX[0]."','".addslashes(stripslashes($T["text_html"]))."','".$lang_filename."')");
						$sql_textm = $db->query("SELECT MAX(text_id) FROM block_text WHERE filename = '".$lang_filename."' ");
						$TM = $db->db_fetch_row($sql_textm);
						$db->query("UPDATE block SET block_link = '".$TM[0]."' WHERE BID = '".$BPMAX[0]."' ");
				
				
				$sql_block_pos = $db->query("SELECT * FROM block_function WHERE BID = '".$B["BID"]."' and filename = '".$default_filename."'");
				$BP = $db->db_fetch_array($sql_block_pos);
				$db->query("
				INSERT INTO block_function (
					BID, UID, side, position, filename) 
				VALUES (
					'".$BPMAX[0]."', '".$BP["UID"]."', '".$BP["side"]."', '".$BP["position"]."', '".$lang_filename."')");
					
				
			}
?>
<script language="javascript">
	self.top.window.opener.top.ewt_main.location.href="content_mgt.php?filename=<?php echo $lang_filename; ?>"
	self.close();
</script>
<?php
		}
	}
if($_POST["Flag"] == "Gets"){
$url = explode("ContentMgt",$_POST["openurl"]);
						$myurl = $url[0]."ewt/".$_SESSION["EWT_SUSER"]."/main_body.php?filename=".$_POST["filename1"];
									$fp = fopen ($myurl, "r");
									$line = "";
									while($html = @fgets($fp, 1024)){
									$line .= $html;
									}
									fclose ($fp);
									$tag = addslashes($line);

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

$detail = preg_replace ($search, $replace, $tag);
echo "<span id=\"movto\">";
echo trim($detail);
echo "</span>";
?>
<script language="JavaScript">
self.parent.document.form2.<?php echo $_POST["objto"] ?>.value = document.all.movto.innerHTML;
</script>
<?php
	}
	$db->db_close(); 
?>
