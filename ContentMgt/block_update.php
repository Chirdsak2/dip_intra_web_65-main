<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_type,block_link FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_array($sql_file);

if($R["block_type"] == "text"){
?>
<script language="JavaScript">
self.location.href = "../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_editor.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "code" OR $R["block_type"] == "asp" OR $R["block_type"] == "php" OR $R["block_type"] == "jsp"){
?>
<script language="JavaScript">
self.location.href = "content_coding.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "gadget"  ){
?>
<script language="JavaScript">
self.location.href = "content_gadget.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "menu"){
?>
<script language="JavaScript">
self.location.href = "menu_list.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "banner"){
?>
<script language="JavaScript">
self.location.href = "banner_list.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "blog"){
?>
<script language="JavaScript">
self.location.href = "blog_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "complain"){
?>
<script language="JavaScript">
self.location.href = "complain_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "enews"){
?>
<script language="JavaScript">
self.location.href = "enews_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}

if($R["block_type"] == "fontsize"){
?>
<script language="JavaScript">
self.location.href = "fontsize_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "language"){
?>
<script language="JavaScript">
self.location.href = "language_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "login"){
?>
<script language="JavaScript">
self.location.href = "login_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "link"){
?>
<script language="JavaScript">
self.location.href = "link_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "ebook"){
?>
<script language="JavaScript"> self.location.href = "ebook_main.php?B=<?php echo $_GET["B"]; ?>"; </script>
<?php
}
if($R["block_type"] == "faq"){
?>
<script language="JavaScript">
self.location.href = "faq_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "org"){
?>
<script language="JavaScript">
self.location.href = "content_org_edit.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "poll"){
?>
<script language="JavaScript">
self.location.href = "poll_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "search"){
?>
<script language="JavaScript">
self.location.href = "search_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "survey"){
?>
<script language="JavaScript">
self.location.href = "survey_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "sitemap"){
?>
<script language="JavaScript">
self.location.href = "sitemap_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}


if($R["block_type"] == "webboard"){
?>
<script language="JavaScript">
self.location.href = "webboard_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "gallery"){
?>
<script language="JavaScript">
self.location.href = "gallery_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}

if($R["block_type"] == "guest"){
?>
<script language="JavaScript">
self.location.href = "guestbook_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "rss"){
?>
<script language="JavaScript">
self.location.href = "rss_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "online"){
?>
<script language="JavaScript">
self.location.href = "online_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "calendar"){
?>
<script language="JavaScript">
self.location.href = "calendar_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "news"){
?>
<script language="JavaScript">
self.location.href = "news_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "images" OR $R["block_type"] == "flash" ){//OR $R["block_type"] == "media"
?>
<form name="formPopUpIns" method="post" action="../FileMgt/<?php if($R["block_type"] == "images" OR $R["block_type"] == "flash"){ echo "gallery"; }elseif($R["block_type"] == "media"){ echo "download"; } ?>_insert.php">
		<input name="stype" type="hidden" id="stype" value="<?php echo $R["block_type"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="EditChoose">
        <input name="filename" type="hidden" id="filename" value="<?php echo $_GET["B"]; ?>">
	</form>
<script language="JavaScript">
formPopUpIns.submit();
</script>
<?php
}
if($R["block_type"] == "vdo"){
?>
<script language="JavaScript">
self.location.href = "vdo_main.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}

if($R["block_type"] == "article"){
?>
<script language="JavaScript">
self.location.href = "article_position.php?B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}

if($R["block_type"] == "graph"){?>
	 		<script language="JavaScript">
				self.location.href = "graph_main.php?graph_id=<?php echo $R["block_link"]; ?>&B=<?php echo $_GET["B"]; ?>";
			</script>
<?php
}
if($R["block_type"] == "tooltips"){
?>
<script language="JavaScript">
self.location.href = "content_tooltips.php?type=p&B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "virtual"){
?>
<script language="JavaScript">
self.location.href = "virtual_main.php?type=p&B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "download"){
?>
<script language="JavaScript">
self.location.href = "download_main.php?type=p&B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "ecard"){
?>
<script language="JavaScript">
self.location.href = "ecard_main.php?type=p&B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
if($R["block_type"] == "tor"){
?>
<script language="JavaScript">
self.location.href = "tor_main.php?type=p&B=<?php echo $_GET["B"]; ?>";
</script>
<?php
}
}else{
echo "#ERROR ID";
}

 $db->db_close(); ?>
