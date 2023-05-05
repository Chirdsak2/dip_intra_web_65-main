<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
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
			if($type == "survey") 	{ $b_name = "Survey";}
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
			if($type == "images" OR $type == "flash" OR $type == "media"){//
				$fp = explode("/",$file);
				$cp = count($fp);
				$buse = $fp[($cp -1)];
				$buse = ereg_replace(" ","",$buse);
				$b_name = ereg_replace("\"","",$buse);
			}
			return $b_name;
		}
		//chk data
		$sql_chk = "select ad_des,block_type,block_name,block_link from article_detail,block where article_detail.ad_des =  block.BID and ad_id='".$_POST[ad_id]."'";
		$query_chk = $db->query($sql_chk);
		$rec_chk = $db->db_fetch_array($query_chk);
		if(!empty($rec_chk[ad_des]) && $rec_chk[block_type]!=$_POST["stype"]){
				$db->query("delete from block where BID = '".$rec_chk[ad_des]."'");
		}
if($_POST["stype"]!='' && $rec_chk[block_type]!=$_POST["stype"]){
		$block_name = bname($_POST["stype"],$_POST["objfile"]);
		//$db->write_log("create","main","สร้าง block ".$block_name."  ในหน้า web page :".$_POST["filename"]);
		$block_html = "";
		$block_themes = '';//$rec_def[def_block];
		$db->query("INSERT INTO block (block_name,block_type,block_link,filename,block_edit,block_themes) VALUES ('".$block_name."','".$_POST["stype"]."','','".$_POST["filename"]."','Y','".$block_themes."')");
		$sql_max = $db->query("SELECT MAX(BID) FROM block WHERE block_name = '".$block_name."' AND filename = '".$_POST["filename"]."' ");
		$BM = $db->db_fetch_row($sql_max);

		if($_POST["stype"] == "text" OR $_POST["stype"] == "code" OR $_POST["stype"] == "images" OR $_POST["stype"] == "flash" OR $_POST["stype"] == "media"){
			if($_POST["stype"] == "images"){
				$block_html =  $_POST["align"]."@@##@@".$_POST["height"]."@@##@@".$_POST["width"]."@@##@@@@##@@@@##@@".$_POST["objfile"];
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
		//include("../ewt_block_function.php");
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
		$update_ardetail = "update article_detail set ad_des='".$BM[0]."' where ad_id ='".$_POST[ad_id]."'";
		$db->query($update_ardetail);
?>
<script language="javascript">
top.location.href = "block_update.php?B=<?php echo base64_encode("z".$BM[0]."z00"); ?>";
top.opener.parent.article_data.location.reload();
//window.open('block_update.php?B=<?php//php echo base64_encode("z".$BM[0]."z00"); ?>','BlockEdit','top=20,left=80,width=640,height=550,resizable=1,status=0,scrollbars=1')
</script>
<?php
}else if($_POST["stype"]!='' && $rec_chk[block_type]==$_POST["stype"]){
?>
<script language="javascript">
top.location.href = "block_update.php?B=<?php echo base64_encode("z".$rec_chk[ad_des]."z00"); ?>";
//top.opener.parent.article_data.location.reload();
//window.open('block_update.php?B=<?php//php echo base64_encode("z".$BM[0]."z00"); ?>','BlockEdit','top=20,left=80,width=640,height=550,resizable=1,status=0,scrollbars=1')
</script>
<?php
}else{
			$update_ardetail = "update article_detail set ad_des='' where ad_id ='".$_POST[ad_id]."'";
			$db->query($update_ardetail);
			?>
			<script language="javascript">
			top.opener.parent.article_data.location.reload();
			top.close();
			</script>
			<?php
		}
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function choose(c){
		document.form1.stype.value = c;
		form1.submit();
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
<form name="form1" method="post" action="module_list.php">
		  <input name="stype" type="hidden" id="stype" value="">
        <input name="Flag" type="hidden" id="Flag" value="Choose">
		<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $_GET[ad_id];?>">
</form>
<?php
$sql = "select ad_des,block_type,block_name,block_link from article_detail,block where article_detail.ad_des =  block.BID and ad_id='".$_GET[ad_id]."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$B = $rec[ad_des];
$B_name = $rec[block_name];
$B_type = $rec[block_type];
?>
  <tr bgcolor="#E6E6E6"> 
    <td width="70%"><strong>Module name</strong></td>
    <td width="30%" align="center"><STRONG>Apply to WebBlock</STRONG></td>
  </tr>
   <tr bgcolor="#FFFFFF" >
    <td><?php if($B==''){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>Module No Select</td>
    <td align="center"><a href="#survey" onClick="choose('')">Apply</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" > 
    <td><?php if($B_type=='survey'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>แบบสอบถาม(From Generetor)</td>
    <td align="center"><a href="#survey" onClick="choose('survey')">Apply</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td><?php if($B_type=='poll'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>แบบสำรวจออนไลน์(Poll)</td>
    <td align="center"><a href="#poll" onClick="choose('poll')">Apply</a></td>
  <tr bgcolor="#FFFFFF" >
    <td><?php if($B_type=='article'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>Article</td>
    <td align="center"><a href="#article" onClick="choose('article')">Apply</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td><?php if($B_type=='faq'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>FAQ</td>
    <td align="center"><a href="#faq" onClick="choose('faq')">Apply</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td><?php if($B_type=='vdo'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>VIDEO CLIP </td>
    <td align="center"><a href="#vdo" onClick="choose('vdo')">Apply</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td><?php if($B_type=='gallery'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>ห้องแสดงภาพ(Gallery)</td>
    <td align="center"><a href="#gallery" onClick="choose('gallery')">Apply</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td><?php if($B_type=='ebook'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>E-Book</td>
    <td align="center"><a href="#ebook" onClick="choose('ebook')">Apply</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td><?php if($B_type=='banner'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>Banner</td>
    <td align="center"><a href="#banner" onClick="choose('banner')">Apply</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td><?php if($B_type=='rss'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>Rss</td>
    <td align="center"><a href="#rss" onClick="choose('rss')">Apply</a></td>
  </tr>
  <tr bgcolor="#FFFFFF" >
    <td><?php if($B_type=='rss'){echo"<img src=\"../theme/main_theme/g_select.gif\">&nbsp;&nbsp;";} ?>
    Virtual </td>
    <td align="center"><a href="#virtual" onClick="choose('virtual')">Apply</a></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
