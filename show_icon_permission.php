<table width="100%" border="0">
  <tr>
    <td align="right" valign="top"><?php
if($db->check_permission("cms","w","")){
?>
    <?php if($cms_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onClick="openPage()" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><img src="theme/main_theme/icon_jquery_gif64/bar_open.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Open</span></div><?php } ?>
	    <?php if($cms_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onClick="newPage()" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><img src="theme/main_theme/icon_jquery_gif64/home_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Edit <br>Homepage </span></div><?php } ?>
    <?php if($cms_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onClick="window.open('ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/index.php','','');" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><img src="theme/main_theme/icon_jquery_gif64/bar_new.gif" width="56" height="56" border="0" /><br />
    <span class="style1">New Web <br>Page </span></div><?php } ?>
	<?php
}
?>
<?php
		if($db->check_permission("menu","w","")){
	?>
	    <?php if($menu_hidden){ ?><div align="center"  style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onClick="self.top.ewt_main.location.href='MenuMgt/menu_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><img src="theme/main_theme/g_menu_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Menu</span></div><?php } ?>
		<?php
}
?>

<?php
		if($db->check_permission("art","","")){
	?>
	<?php if($art_hidden){ ?><div align="center"  style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onClick="self.top.ewt_main.location.href='ContentMgt/article_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><img src="theme/main_theme/g_article_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Article</span></div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("guest","w","")){ ?>
	 <?php if($guest_hidden){ ?> <div align="center"  style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onClick="self.top.ewt_main.location.href='GuestMgt/guest_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><img src="theme/main_theme/g_guestbook_64.gif" width="56" height="56" border="0" /><br />
      Guest Book </div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("newsl","w","")){ ?>
	  <?php if($newsl_hidden){ ?> <div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='NewsLetterMgt/news_index.php';"><img src="theme/main_theme/g_enews_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">E-Newsletter</span></div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("survey","w","")){ ?>
	<?php if($survey_hidden){ ?>  <div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='SurveyMgt/survey_index.php';"><img src="theme/main_theme/g_survey_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Form <br>Generator</span></div><?php } ?>
	<?php } ?>
	
	<?php
		if($db->check_permission("webboard","w","")){
	?>
	<?php if($webboard_hidden){ ?> <div align="center"style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='WebboardMgt/webboard_index.php';"><img src="theme/main_theme/g_webboard_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Web Board </span></div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("faq","w","")){ ?>
	 <?php if($faq_hidden){ ?> <div align="center"   style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='WebboardMgt/faq_index.php';"><img src="theme/main_theme/g_faq_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">FAQ</span></div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("language","w","")){ ?>
	 <?php if($language_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='LanguageMgt/language_index.php';"><img src="theme/main_theme/g_multilang_64.gif" width="56" height="56" border="0" /><br />
     Multi<br>language </div>
	<?php } ?>
	<?php } ?>
	
	<?php 	if($db->check_permission("poll","w","")){ ?>
	<?php if($poll_hidden){ ?> <div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onClick="self.top.ewt_main.location.href='PollMgt/poll_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><img src="theme/main_theme/g_poll_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Polls</span></div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("sitemap","w","")){ ?>
	 <?php if($sitemap_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='MenuMgt/sitemap_index.php';"><img src="theme/main_theme/g_sitemap_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Site Map </span></div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("calendar","w","")){ ?>
	 <?php if($calendar_hidden){ ?> <div align="center"style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='CalendarMgt/calendar_index.php';"><img src="theme/main_theme/g_calendar_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Calendar</span></div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("sdes","w","")){ ?>
	  <?php if($sdes_hidden){ ?><div align="center"style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='LookMgt/look_index.php';"><img src="theme/main_theme/icon_jquery_gif64/bar_save_as.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Site Template </span></div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("vdo","w","")){ ?>
	  <?php if($vdo_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='vdoMgt/index_vdo.php';"><img src="theme/main_theme/g_vdo_64.gif" width="56" height="56" border="0" /><br />
      Video Clip
    </div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("Gallery","w","")){ ?>
	 <?php if($Gallery_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onClick="self.top.ewt_main.location.href='GalleryMgt/gallery_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><img src="theme/main_theme/g_gallery_64.gif" width="56" height="56" border="0" /><br />
      Gallery
    </div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("Ebook","w","")){ ?>
	<?php if($Ebook_hidden){ ?> <div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='EbookMgt/index.php';"><img src="theme/main_theme/g_ebook_64.gif" width="56" height="56" border="0" /><br />
      E-book</div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("Banner","w","")){ ?>
	<?php if($Banner_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='BannerMgt/banner_index.php';"><img src="theme/main_theme/g_banner_64.gif" width="56" height="56" border="0" /><br />
      Banner
    </div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("Blog","w","")){ ?>
	 <?php if($Blog_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='BlogMgt/index.php';"><img src="theme/main_theme/g_blog_64.gif" width="56" height="56" border="0" /><br />
      Web Blog</div><?php } ?>
	<?php } ?>
	
	<?php if($db->check_permission("rss","w","")){ ?>
	 <?php if($rss_hidden){ ?><div align="center" style="cursor:pointer; width:100px; height:100px;border:solid 1px;border-color:'#FFFFFF';" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='RssReader/rss_index.php';"><img src="theme/main_theme/g_rss_64.gif" width="56" height="56" border="0" /><br />
      Rss
    </div><?php } ?>
	<?php } ?></td>
  </tr>
</table>
