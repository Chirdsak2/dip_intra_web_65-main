<script type="text/javascript" language="JavaScript1.2" src="<?php echo $EWT_PATH; ?>js/stm31.js"></script>
<?php
include($EWT_PATH."ewt_module_hidden.php");
if($_SESSION["EWT_SMTYPE"] == "Y"){
?>
<script type="text/javascript" language="JavaScript1.2">
<!--
var mybrowser=navigator.userAgent;
stm_bm(["menu2ee9",430,"","<?php echo $EWT_PATH; ?>images/o.gif",0,"","",0,3,10,0,10,1,0,0,"","",0],this);
stm_bp("p0",[0,4,0,0,1,4,0,0,100,"",-2,"",-2,50,0,0,"#9d9da1","#f3f3ee","",3,0,0,"#000000"]);
stm_ai("p0i0",[0,"  File  ","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_r.gif","",0,0,0,0,1,"#f3f3ee",0,"#b2b4bf",0,"","",3,3,0,0,"#fffff7","#000000","#000000","#000000","8pt Tahoma","8pt Tahoma",0,0]);
stm_bp("p1",[1,4,0,0,1,6,0,0,100,"",-2,"",-2,50,2,1,"#9d9da1","#ffffff","",3,1,1,"#bbb7c7"]);
if(mybrowser.indexOf('MSIE')>0|| !!navigator.userAgent.match(/Trident.*rv\:11\./)){
<?php if($cms_hidden){ ?>stm_aix("p1i0","p0i0",[0,"New...                             ","","",-1,-1,0,"javascript:newPage();","_self","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);<?php } ?>
<?php if($cms_hidden){ ?>stm_aix("p1i1","p1i0",[0,"Open...","","",-1,-1,0,"javascript:openPage();"]);<?php } ?>
<?php if($cms_hidden){ ?>stm_ai("p1i2",[6,1,"#bbb7c7","",-1,-1,0]);<?php } ?>
}
stm_aix("p1i3","p0i0",[0,"Close Page     ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>EWT_ADMIN/ewt_main.php","ewt_main","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);
stm_aix("p1i4","p1i3",[0,"Logout","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt_logout.php","_top"]);
stm_ep();
stm_aix("p0i1","p0i0",[0,"  Site  "]);
stm_bpx("p2","p1",[]);
stm_aix("p2i0","p1i3",[0,"Site Properties                 ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt_info.php"]);
<?php if($personalweb_hidden){ ?>stm_aix("p2i0","p1i3",[0,"Personal Web Setting ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt_customsite.php"]);<?php } ?>
stm_aix("p2i0","p1i3",[0,"Preview Site                           ","","",-1,-1,0,"javascript:Preview('<?php echo $_GET['filename'];?>');","_self","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);

stm_ai("p1i2",[6,1,"#bbb7c7","",-1,-1,0]);

stm_aix("p2i0","p1i3",[0,"Permission ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>SiteMgt/ewt_permission.php"]);

stm_ai("p1i2",[6,1,"#bbb7c7","",-1,-1,0]);
<?php if($pageapp_hidden){ ?>stm_aix("p2i0","p1i3",[0,"Page Approval   ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt_approve.php"]);<?php } ?>
<?php if($schpageapp_hidden){ ?>stm_aix("p2i0","p1i3",[0,"Scheduled Page Approval        ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt_setting_approve.php"]);<?php } ?>
<?php if($pageapp_hidden || $schpageapp_hidden){ ?>stm_ai("p1i2",[6,1,"#bbb7c7","",-1,-1,0]);<?php } ?>
stm_aix("p2i0","p1i3",[0,"System Logs                 ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>StatMgt/log_index.php"]);
<?php if($visitstats_hidden){ ?>stm_aix("p2i0","p1i3",[0,"Visitor Stats                 ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>StatMgt/stat_index.php"]);<?php } ?>

<?php if($art_hidden && $artstats_hidden){ ?>stm_aix("p2i0","p1i3",[0,"News/Article Stats                  ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ContentMgt/article_stat_index.php"]);<?php } ?>
<?php if($keyword_hidden){ ?>stm_aix("p2i0","p1i3",[0,"Keyword Stats                 ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>search/stat_index.php"]);<?php } ?>
stm_ep();


stm_aix("p0i4","p0i0",[0," Tools  "]);
stm_bpx("p5","p1",[]);

		<?php if($main_Utilities){ ?>
		stm_aix("p0i3","p1i3",[0,"Utilities                         ","","",-1,-1,0,"",""]);
		stm_bpx("p4","p1",[2,2]);
				<?php if($language_hidden){ ?>stm_aix("p4i0","p1i3",[0,"Multilanguage","","",-1,-1,0,"<?php echo $EWT_PATH; ?>LanguageMgt/language_index.php","ewt_main"]);<?php } ?>
				<?php if($Vulgar_hidden){ ?>stm_aix("p4i1","p1i3",[0,"Rude Words Filter","","",-1,-1,0,"<?php echo $EWT_PATH; ?>VulgarMgt/vul_index.php","ewt_main"]);<?php } ?>
				<?php if($dl_hidden){ ?>stm_aix("p4i2","p1i3",[0,"My Download     ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>FileMgt/file_download.php","ewt_main"]);<?php } ?> 
				<?php if($img_hidden){ ?>stm_aix("p4i3","p1i3",[0,"My Gallery     ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>FileMgt/file_images.php","ewt_main"]);<?php } ?>
				<?php if($mobile_hidden){ ?>stm_aix("p4i4","p1i3",[0,"Mobile Updater","","",-1,-1,0,"<?php echo $EWT_PATH; ?>mobileMgt/mobile_index.php","ewt_main"]);<?php } ?>
				<?php if($downloadmgt_hidden){ ?>stm_aix("p4i4","p1i3",[0,"Download Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>DocumentMgt/doc_index.php","ewt_main"]);<?php } ?>
				<?php if($dict_hidden){ ?>stm_aix("p4i4","p1i3",[0,"Dictionary Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>DictionaryMgt/dict_index.php","ewt_main"]);<?php } ?>
				<?php if($datawh_hidden){ ?>stm_aix("p4i4","p1i3",[0,"Data Warehouse","","",-1,-1,0,"<?php echo $EWT_PATH; ?>data_warehouse/index_datawaerhouse.php","ewt_main"]);<?php } ?>
				<?php if($tor_hidden){ ?>stm_aix("p4i4","p1i3",[0,"TOR Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>TorMgt/tor_index.php","ewt_main"]);<?php } ?>
				<?php if($w3c_hidden){ ?>stm_aix("p4i4","p1i3",[0,"W3C","","",-1,-1,0,"<?php echo $EWT_PATH; ?>w3c/index_w3c.php","ewt_main"]);<?php } ?>
		stm_ep();
		
		<?php } ?>
		
		<?php if($main_News){ ?>
		stm_aix("p0i3","p1i3",[0,"News/Article  ","","",-1,-1,0,"",""]);
		stm_bpx("p4","p1",[2,2]);
				<?php if($art_hidden){ ?>stm_aix("p4i0","p1i3",[0,"News/Article Management ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ContentMgt/article_index.php","ewt_main"]);<?php } ?>
				<?php if($rss_hidden){ ?>stm_aix("p4i1","p1i3",[0,"RSS News Feed     ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>RssReader/rss_index.php","ewt_main"]);<?php } ?>
		stm_ep();
		
		<?php } ?>
		
		<?php if($main_Content){ ?>
		stm_aix("p0i3","p1i3",[0,"Content/Design  ","","",-1,-1,0,"",""]);
		stm_bpx("p4","p1",[2,2]);
				<?php if($menu_hidden){ ?>stm_aix("p4i0","p1i3",[0,"Menu Management                    ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>MenuMgt/menu_index.php","ewt_main"]);<?php } ?>
				<?php if($block_hidden){ ?>stm_aix("p4i1","p1i3",[0,"WebBlock Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>BlockMgt/block_main.php","ewt_main"]);<?php } ?>
				<?php if($link_hidden){ ?>stm_aix("p4i2","p1i3",[0,"Web Site Link Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>LinkMgt/link_index.php"]);<?php } ?>
				<?php if($sitemap_hidden){ ?>stm_aix("p4i4","p1i3",[0,"Sitemap Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>MenuMgt/sitemap_index.php","ewt_main"]);<?php } ?>
		stm_ep();
		
		<?php } ?>
		
		<?php if($main_Multimedia){ ?>
		stm_aix("p0i3","p1i3",[0,"Multimedia  ","","",-1,-1,0,"",""]);
		stm_bpx("p4","p1",[2,2]);
				<?php if($Gallery_hidden){ ?>stm_aix("p4i0","p1i3",[0,"Gallery Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>GalleryMgt/gallery_index.php","ewt_main"]);<?php } ?>
				<?php if($Banner_hidden){ ?>stm_aix("p4i1","p1i3",[0,"Banner Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>BannerMgt/banner_index.php","ewt_main"]);<?php } ?>
				<?php if($Ebook_hidden){ ?>stm_aix("p4i2","p1i3",[0,"E-Books Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>EbookMgt/index.php","ewt_main"]);<?php } ?>
				<?php if($vdo_hidden){ ?>stm_aix("p4i2","p1i3",[0,"Video Clip Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>vdoMgt/index_vdo.php","ewt_main"]);<?php } ?>
				<?php if($ecard_hidden){ ?>	stm_aix("p4i2","p1i3",[0,"E-Card Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>EcardlMgt/ecard_index.php","ewt_main"]);<?php } ?>
				<?php if($virtual_hidden){ ?>	stm_aix("p4i2","p1i3",[0,"Virtual Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>VirtualMgt/virtual_index.php","ewt_main"]);<?php } ?>
		stm_ep();
		
		<?php } ?>

		<?php if($main_Services){ ?>
		stm_aix("p0i3","p1i3",[0,"Services  ","","",-1,-1,0,"",""]);
		stm_bpx("p4","p1",[2,2]);
				<?php if($complain_hidden){ ?>stm_aix("p4i0","p1i3",[0,"Complaint Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ComplainMgt/complain_index.php","ewt_main"]);<?php } ?>
				<?php/* if($webboard_hidden){ ?>stm_aix("p4i1","p1i3",[0,"Webboard Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>WebboardMgt/webboard_index.php","ewt_main"]);<?php } */?>
				<?php if($guest_hidden){ ?>stm_aix("p4i2","p1i3",[0,"Guestbook Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>GuestMgt/guest_index.php","ewt_main"]);<?php } ?>
				<?php if($faq_hidden){ ?>stm_aix("p4i3","p1i3",[0,"FAQ Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>WebboardMgt/faq_index.php","ewt_main"]);<?php } ?>
				<?php if($newsl_hidden){ ?>stm_aix("p4i4","p1i3",[0,"E-News Letter Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>NewsLetterMgt/news_index.php","ewt_main"]);<?php } ?>
				<?php if($calendar_hidden){ ?>stm_aix("p4i5","p1i3",[0,"Calendar Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>CalendarMgt/calendar_index.php","ewt_main"]);<?php } ?>
				<?php if($Blog_hidden){ ?>stm_aix("p4i6","p1i3",[0,"Web Blog Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>BlogMgt/index.php","ewt_main"]);<?php } ?>
				<?php if($_SESSION["EWT_SUSER"]=='policy'){ ?>stm_aix("p4i2","p1i3",[0,"ระบบสถิติ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>StatPleMgt/stat_index.php","ewt_main"]);<?php } ?>
				<?php ?>stm_aix("p4i2","p1i3",[0,"ระบบสร้างกราฟ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>GrapMgt/grap_index.php","ewt_main"]);<?php  ?>
		stm_ep();
		
		<?php } ?>

		<?php if($main_Form){ ?>
				stm_aix("p0i3","p1i3",[0,"Survey/Form  ","","",-1,-1,0,"",""]);
				stm_bpx("p4","p1",[2,2]);
				
				<?php if($survey_hidden){ ?>stm_aix("p4i0","p1i3",[0,"Form Generator","","",-1,-1,0,"<?php echo $EWT_PATH; ?>SurveyMgt/survey_index.php","ewt_main"]);<?php } ?>
				<?php if($poll_hidden){ ?>stm_aix("p4i1","p1i3",[0,"Poll Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>PollMgt/poll_index.php","ewt_main"]);<?php } ?>
		stm_ep();
		
		<?php } ?>

<?php
if($org_hidden && $_SESSION['EWT_SMUSER']==$_SESSION['EWT_SUSER']){ ?>stm_aix("p5i6","p0i0",[0,"Organization Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>MemberMgt/index_member.php","ewt_main","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);<?php } ?>
stm_aix("p5i7","p0i0",[0,"Member Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>MemberMgt/index_member_out.php","ewt_main","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);
<?php
if($_SESSION["EWT_SMID"] != ""){
?>stm_aix("p5i7","p0i0",[0,"Edit Profile","","",-1,-1,0,"<?php echo $EWT_PATH; ?>MemberMgt/index_member_out2.php","ewt_main","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);
<?php
}else{
?>stm_aix("p5i7","p0i0",[0,"Edit Password","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt_password_edit.php","ewt_main","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);
<?php } ?>


stm_ep();


<?php
$numpage = count($_SESSION["EWT_OPEN_SAVE"]);
			for($n=0;$n<$numpage;$n++){
?>
stm_aix("p5i0","p1i3",[0,"  <?php echo $_SESSION["EWT_OPEN_SAVE"][$n]; ?>               ","","",-1,-1,0,"javascript:OpenFile('<?php echo $_SESSION["EWT_OPEN_SAVE"][$n]; ?>')","_self"]);
<?php } ?>
stm_ep();
stm_aix("p0i5","p0i0",[0," Help  "]);
stm_bpx("p6","p1",[]);
stm_aix("p6i0","p1i3",[0,"Contents &amp; Index           ","","",-1,-1,0,"#ci"]);
stm_aix("p6i3","p1i3",[0,"Report Bugs","","",-1,-1,0,"javascript:reportBugsEWT();"]);
stm_aix("p6i1","p1i2",[]);
stm_aix("p6i2","p1i3",[0,"About EasyWebTime","","",-1,-1,0,"javascript:aboutEWT();","ewt_main"]);

stm_ep();
stm_ep();
stm_em();
//-->
</script>
<?php }else{ ?>
<script type="text/javascript" language="JavaScript1.2">
<!--
stm_bm(["menu2ee9",430,"","<?php echo $EWT_PATH; ?>images/o.gif",0,"","",0,3,10,0,10,1,0,0,"","",0],this);
stm_bp("p0",[0,4,0,0,1,4,0,0,100,"",-2,"",-2,50,0,0,"#9d9da1","#f3f3ee","",3,0,0,"#000000"]);
stm_ai("p0i0",[0,"  File  ","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_r.gif","",0,0,0,0,1,"#f3f3ee",0,"#b2b4bf",0,"","",3,3,0,0,"#fffff7","#000000","#000000","#000000","8pt Tahoma","8pt Tahoma",0,0]);
stm_bp("p1",[1,4,0,0,1,6,0,0,100,"",-2,"",-2,50,2,1,"#9d9da1","#ffffff","",3,1,1,"#bbb7c7"]);
<?php
	if($db->check_permission("cms","w","")){
?>
stm_aix("p1i0","p0i0",[0,"New...   ","","",-1,-1,0,"javascript:newPage();","_self","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);
stm_aix("p1i1","p1i0",[0,"Open...","","",-1,-1,0,"javascript:openPage();"]);
stm_ai("p1i2",[6,1,"#bbb7c7","",-1,-1,0]);
<?php } ?>
stm_aix("p1i0","p0i0",[0,"Preview                            ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/index.php","_blank","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);
stm_aix("p1i3","p0i0",[0,"Close                      ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt_main.php","ewt_main","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);
stm_aix("p1i4","p0i0",[0,"Exit","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt_logout.php","_top","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);
stm_ep();
stm_aix("p0i1","p0i0",[0,"  Site  "]);
stm_bpx("p2","p1",[]);
<?php
		if($db->check_permission("cms","a","")){
	?>

stm_aix("p2i0","p1i3",[0,"Approve Webpage   ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt_approve.php"]);
<?php }
if($_SESSION["EWT_SMID"] != ""){

	$db->query("USE ".$EWT_DB_USER);	
	$sql_clt = $db->query("SELECT COUNT(*) FROM leader_list WHERE leader_id = '".$_SESSION["EWT_SMID"]."'  ");
	$CLT = $db->db_fetch_row($sql_clt);
	if($CLT[0] > 0){
?>
	stm_aix("p2i0","p1i3",[0,"Permission ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>SiteMgt/ewt_permission.php"]);
<?php
$db->query("USE ".$_SESSION["EWT_SDB"]);	
}} ?>
stm_ep();
stm_aix("p0i2","p0i0",[0,"  Format  "]);
stm_bpx("p3","p1",[1,4,0,0,1,6,0,0,100,"",-2,"",-2,50,2,2]);
<?php
		if($db->check_permission("sdes","w","")){
	?>
stm_aix("p3i0","p1i3",[0,"Site Design                    ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>LookMgt/look_index.php"]);
	<?php } ?>
stm_ep();
/* stm_aix("p0i3","p0i0",[0,"  Insert  "]);
stm_bpx("p4","p1",[]);
stm_aix("p4i0","p1i0",[0,"Text Box                    ","","",-1,-1,0,"#t1"]);
stm_aix("p4i1","p1i0",[0,"Menu","","",-1,-1,0,"#t2"]);
stm_aix("p4i2","p1i0",[0,"Advance Code","","",-1,-1,0,"#t3"]);
stm_aix("p4i3","p1i0",[0,"Graph","","",-1,-1,0,"#t4"]);
stm_aix("p4i4","p1i0",[0,"Images","","",-1,-1,0,"#t5"]);
stm_aix("p4i5","p1i0",[0,"Upload File","","",-1,-1,0,"#t6"]);
stm_ep(); */
stm_aix("p0i4","p0i0",[0," Tools  "]);
stm_bpx("p5","p1",[]);
<?php
		if($db->check_permission("art","","")){
	?>
stm_aix("p5i0","p1i3",[0,"Article Management               ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ContentMgt/article_index.php"]);
stm_aix("p5i22","p1i3",[0,"Mobile Updater","","",-1,-1,0,"<?php echo $EWT_PATH; ?>mobileMgt/mobile_index.php","ewt_main"]);
<?php
		}
		if($db->check_permission("menu","w","")){
	?>
stm_aix("p5i1","p1i3",[0,"Menu Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>MenuMgt/menu_index.php"]);
	<?php
		}
		if($db->check_permission("block","w","")){
	?>
stm_aix("p5i2","p1i3",[0,"WebBlock Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>BlockMgt/block_main.php"]);
<?php
		}

	?>
<?php if($img_hidden){ ?>stm_aix("p5i3","p1i3",[0,"Images Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>FileMgt/file_images.php"]);<?php } ?>
<?php if($dl_hidden){ ?>stm_aix("p5i4","p1i3",[0,"Upload File Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>FileMgt/file_download.php"]);<?php } ?>
//stm_aix("p5i4","p1i3",[0,"File Manager Online","","",-1,-1,0,"<?php echo $EWT_PATH; ?>FileMgt/file_share.php"]);
<?php
		if($db->check_permission("webboard","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Webboard Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>WebboardMgt/webboard_index.php"]);
	<?php
		}
		if($db->check_permission("faq","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"FAQ Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>WebboardMgt/faq_index.php"]);
	<?php
		}
		if($db->check_permission("survey","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Form Generator","","",-1,-1,0,"<?php echo $EWT_PATH; ?>SurveyMgt/survey_index.php"]);
	<?php
		}
		if($db->check_permission("newsl","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"E-News Letter Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>NewsLetterMgt/news_index.php"]);
	<?php
		}
		if($db->check_permission("poll","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Poll Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>PollMgt/poll_index.php"]);
	<?php
		}
		if($db->check_permission("sitemap","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Sitemap Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>MenuMgt/sitemap_index.php"]);
	<?php
		}
		if($db->check_permission("calendar","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Calendar Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>CalendarMgt/calendar_index.php"]);
	<?php
		}
		if($db->check_permission("complain","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Complain Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ComplainMgt/complain_index.php"]);
	<?php
		}
		if($db->check_permission("Gallery","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Gallery Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>GalleryMgt/gallery_index.php"]);
	<?php
		}
		if($db->check_permission("Banner","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Banner Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>BannerMgt/banner_index.php"]);
	<?php
		}
		if($db->check_permission("guest","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Guestbook Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>GuestMgt/guest_index.php"]);
	<?php
		}
		if($db->check_permission("Vulgar","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Rude Word Setting","","",-1,-1,0,"<?php echo $EWT_PATH; ?>VulgarMgt/vul_index.php"]);
	<?php
		}
		if($db->check_permission("language","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Language Setting","","",-1,-1,0,"<?php echo $EWT_PATH; ?>LanguageMgt/language_index.php"]);
	<?php
		}
		if($db->check_permission("rss","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"RSS Reader Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>RssReader/rss_index.php"]);
	<?php
		}
		if($db->check_permission("link","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Web Site Link Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>LinkMgt/link_index.php"]);
	<?php
		}
		if($db->check_permission("Ebook","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"E-Book Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>EbookMgt/index.php"]);
	<?php
		}
		if($db->check_permission("Blog","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Web Blog Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>BlogMgt/index.php"]);
	<?php
		}
		if($db->check_permission("org","w","")){
	?>
stm_aix("p5i5","p1i3",[0,"Organization Management","","",-1,-1,0,"<?php echo $EWT_PATH; ?>MemberMgt/index_member.php"]);
	<?php
		}
	?>
stm_aix("p5i7","p1i3",[0,"Edit Profile","","",-1,-1,0,"<?php echo $EWT_PATH; ?>MemberMgt/index_member_out2.php","ewt_main","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);
		<?php 
						//		$querychk = $db->query_db("SELECT COUNT(permission.p_id) as ccs FROM permission WHERE ( p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' ) AND permission.s_type = 'asset' ",$EWT_DB_USER);
					//			$CH = $db->db_fetch_row($querychk);
					//			$db->query("USE ".$_SESSION["EWT_SDB"]);
if($db->check_permission("asset","","") AND $EWT_FOLDER_USER == "dmr_web"){
?>
<?php if($monitor_hidden){ ?>stm_aix("p5i6","p0i0",[0,"ระบบจัดการทรัพย์สิน","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt/w2/asset/Synchronize.php","_blank","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);<?php } ?>
<?php } 
if($_SESSION["EWT_SMID"] != "" AND $EWT_FOLDER_USER == "dmr_web"){
?>
	<?php if($reserve_hidden){ ?>stm_aix("p5i6","p0i0",[0,"ระบบจัดการงานที่รับผิดชอบ","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt/w2/monitoring/Synchronize.php","_blank","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);<?php } ?>
	<?php if($asset_hidden){ ?>stm_aix("p5i6","p0i0",[0,"ระบบจอง ยืม คืน อุปกรณ์","","",-1,-1,0,"<?php echo $EWT_PATH; ?>ewt/w2/reserve/Synchronize.php","_blank","","","","",0,0,0,"","",0,0,0,0,1,"#ffffff",0,"#bbb7c7"]);<?php } ?>
<?php
}
?>
stm_ep();
stm_aix("p0i4","p0i0",[0," Window  "]);
stm_bpx("p5","p1",[]);
<?php
$numpage = count($_SESSION["EWT_OPEN_SAVE"]);
			for($n=0;$n<$numpage;$n++){
?>
stm_aix("p5i0","p1i1",[0,"  <?php echo $_SESSION["EWT_OPEN_SAVE"][$n]; ?>               ","","",-1,-1,0,"javascript:OpenFile('<?php echo $_SESSION["EWT_OPEN_SAVE"][$n]; ?>')"]);
<?php } ?>
stm_ep();
stm_aix("p0i5","p0i0",[0," Help  "]);
stm_bpx("p6","p1",[]);
stm_aix("p6i0","p1i3",[0,"Contents &amp; Index           ","","",-1,-1,0,"#ci"]);
stm_aix("p6i2","p1i3",[0,"Report Bugs","","",-1,-1,0,"javascript:reportBugsEWT();"]);
stm_aix("p6i3","p1i3",[0,"About EasyWebTime","","",-1,-1,0,"javascript:aboutEWT();"]);

stm_ep();
stm_ep();
stm_em();
//-->
</script>
<?php } ?>
<script type="text/javascript" language="JavaScript1.2">
	function newPage(){
				win2 = window.open('<?php echo $EWT_PATH; ?>ContentMgt/content_new.php','ContentNew','top=20,left=80,width=800,height=550,resizable=1,status=0');
				win2.focus();
	}
	function Wizard(){
				win2 = window.open('<?php echo $EWT_PATH; ?>sitewizardMgt/site_wizard_01.php','site_wizard_01','top=20,left=80,width=605,height=580,resizable=0,status=0');
				win2.focus();
	}
	function openPage(){
				win2 = window.open('<?php echo $EWT_PATH; ?>ContentMgt/content_main.php','ContentOpen','top=60,left=80,width=800,height=480,resizable=1,status=0');
				win2.focus();
	}
	function OpenFile(c){
				self.top.ewt_main.location.href="<?php echo $EWT_PATH; ?>ContentMgt/content_mgt.php?filename=" + c;
	}
	function aboutEWT(){
				win2 = window.open('<?php echo $EWT_PATH; ?>ewt_about.php','AboutUs','top=100,left=200,width=440,height=300,resizable=0,status=0');
				win2.focus();
	}
		function reportBugsEWT(){
				//ดึง url in frame
				var url_referer = window.iframe_data.location.href;
				
				win2 = window.open('<?php echo $EWT_PATH; ?>ewt_report_bugs.php?url='+url_referer,'Reportbugs','top=100,left=200,width=440,height=400,resizable=0,status=0');
				win2.focus();
	}
	function Preview(c){
		if(c != ""){
				win2 = window.open('<?php echo $EWT_PATH; ?>ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/site_preview.php?filename='+c+'','ContentPreview','top=100,left=80,width=800,height=480,resizable=1,status=0,scrollbars=1');
				win2.focus();
		}else{
				win2 = window.open('<?php echo $EWT_PATH; ?>ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/site_preview.php?filename=index','ContentPreview','top=100,left=80,width=800,height=480,resizable=1,status=0,scrollbars=1');
				win2.focus();
		}
	}
	function ActPreview(c){
		if(c != ""){
				win2 = window.open('<?php echo $EWT_PATH; ?>ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/main.php?filename='+c+'','ContentPreview','top=100,left=80,width=800,height=480,resizable=1,status=0,scrollbars=1');
				win2.focus();
		}else{
				win2 = window.open('<?php echo $EWT_PATH; ?>ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/index.php','ContentPreview','top=100,left=80,width=800,height=480,resizable=1,status=0,scrollbars=1');
				win2.focus();
		}
	}
	function ActPreview_w3c(c){
		if(c != ""){
				win2 = window.open('<?php echo $EWT_PATH; ?>ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_w3c/main.php?filename='+c+'','ContentPreview','top=100,left=80,width=800,height=480,resizable=1,status=0,scrollbars=1');
				win2.focus();
		}else{
				win2 = window.open('<?php echo $EWT_PATH; ?>ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_w3c/index.php','ContentPreview','top=100,left=80,width=800,height=480,resizable=1,status=0,scrollbars=1');
				win2.focus();
		}
	}
	</script>
