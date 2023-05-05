<?php
include("lib/permission.php");
include("lib/include.php");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
		if(!(session_is_registered("EWT_OPEN_SAVE"))){
			session_register("EWT_OPEN_SAVE");
			$_SESSION["EWT_OPEN_SAVE"] = array();
		}	
function chkBrowser($nameBroser){
	return preg_match("/".$nameBroser."/",$_SERVER['HTTP_USER_AGENT']);
}

	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript">
var i = 0;
var o = 0;
function chkKeyFunction(){
o = i;
i = event.keyCode;
	if(i == "78" && o == "18"){
		newPage();
	}
		if(i == "79" && o == "18"){
		openPage();
	}
}
function button_over(eButton){
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "#E7E7E7 solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "#E7E7E7 solid 1px ";
		eButton.style.color = "#FF3300";
		eButton.style.fontWeight = "bold";
	}
				
	function button_out(eButton){
	eButton.style.borderColor = "#FFFFFF";
	eButton.style.color = "#000000";
	eButton.style.fontWeight ="normal";
	}
</script>
<link href="theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="808080" leftmargin="0" topmargin="0" onKeyDown="chkKeyFunction();">
<?php include("FavoritesMgt/favorites_include.php");?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <tr> 
    <td height="28" bgcolor="#F3F3EE">
      
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td width="32">
		  <a  href="<?=$MAIN_PATH; ?>EWT_ADMIN/ewt_main.php">
		  <img src="theme/main_theme/ewt_logo.gif" width="28" height="28" align="absmiddle">
		  </a>
		  </td>
		  
          <td>
		  <?php 
		  //if($_SERVER['REMOTE_ADDR'] == "134.236.16.213"){
			  
		  include("ewt_menu.php");
		  

		// }		  
		  ?></td>
        </tr>
      </table> </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
   <tr> 
    <td height="20" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr> 
          <td align="right">Website : <?php echo $_SESSION["EWT_SUSER"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User : <?php echo $_SESSION["EWT_SMUSER"]; ?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>
	  <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr> 
    <td width="60" height="53"><img src="theme/main_theme/images_module.gif" width="50" height="50"> </td>
                
          <td><span class="ewthead">Welcome to EasyWebTime</span>
          </td>
  </tr>
</table>
	  </td>
  </tr>
  <tr> 
    <td height="10" background="theme/main_theme/bg.gif" bgcolor="#FF3300"></td>
  </tr>
  <tr> 
    <td align="center" valign="top" bgcolor="#FFFFFF"><br>
	  <table width="98%" border="0" cellpadding="1" cellspacing="2" bgcolor="#FFFFFF">
        <tr>
          <td width="70%" valign="top">
		  <?php 
		   if($_SESSION["EWT_SMTYPE"] == "Y"){
			  
			echo "<h2 style=\"color:red;\">ปิดปรับปรุงกรุณาติดต่อ คุณสาลี่ คุณติ้งขาใหญ่</h2>";  
			  
		  }else if($_SESSION["EWT_SMTYPE"] == "E"){
			  
		  
		  ?>
		  <fieldset style="padding:10px; " >
 <table  border="1" align="center" cellpadding="14" cellspacing="0" bordercolor="#FFFFFF"  bgcolor="#FFFFFF">
  <tr bgcolor="#F8F8F8">
    
	<td width="100" align="center" valign="middle" bgcolor="#FFFFFF" style="" onClick="window.open('ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/index.php','','');" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><div align="center"><img src="theme/main_theme/icon_jquery_gif64/bar_view.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Preview</span></div></td>
   <?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0')!== false&& strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0;')!== false){ ?>
   <?php if($cms_hidden){ ?><td width="100" align="center" valign="middle" bgcolor="#FFFFFF" style="" onClick="OpenFile('index')" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><div align="center"><img src="theme/main_theme/icon_jquery_gif64/home_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Edit <br>Homepage </span></div></td><?php } ?>
	<?php if($cms_hidden){ ?><td width="100" height="100" align="center" valign="middle" bgcolor="#FFFFFF" style="" onClick="openPage()" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><div align="center"><img src="theme/main_theme/icon_jquery_gif64/bar_open.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Open</span></div></td><?php } ?>
    <?php if($cms_hidden){ ?><td width="100" align="center" valign="middle" bgcolor="#FFFFFF" style="" onClick="newPage()" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><div align="center"><img src="theme/main_theme/icon_jquery_gif64/bar_new.gif" width="56" height="56" border="0" /><br />
    <span class="style1">New Web <br>Page </span></div></td><?php } ?>
    
	<?php }else{ ?>
		<?php if($rss_hidden){ $sh = 1;?> <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='RssReader/rss_index.php';"><div align="center"><img src="theme/main_theme/g_rss_64.gif" width="56" height="56" border="0" /><br />
		  Rss
		</div></td><?php } ?>
		<?php if($language_hidden){$sh = 1; ?><td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='LanguageMgt/language_index.php';"><div align="center"><img src="theme/main_theme/g_multilang_64.gif" width="56" height="56" border="0" /><br />
     Multi<br>language </div></td><?php } ?>
	
	<?php } ?>
    <?php if($menu_hidden){ ?><td width="100" align="center" valign="middle" bgcolor="#FFFFFF" style="" onClick="self.top.ewt_main.location.href='MenuMgt/menu_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><div align="center"><img src="theme/main_theme/g_menu_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Menu</span></div></td><?php }?>
	<?php if($art_hidden){ ?><td width="100" align="center" valign="middle" bgcolor="#FFFFFF" style="" onClick="self.top.ewt_main.location.href='ContentMgt/article_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><div align="center"><img src="theme/main_theme/g_article_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Article</span></div></td><?php } ?>
  </tr>
  <tr bgcolor="#F8F8F8">
 <?php if($guest_hidden){ ?> <td height="100" align="center" valign="middle" bgcolor="#FFFFFF" style="" onClick="self.top.ewt_main.location.href='GuestMgt/guest_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><div align="center"><img src="theme/main_theme/g_guestbook_64.gif" width="56" height="56" border="0" /><br />
      Guest Book </div></td><?php } ?>
   <?php if($newsl_hidden){ ?>  <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='NewsLetterMgt/news_index.php';"><div align="center"><img src="theme/main_theme/g_enews_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">E-Newsletter</span></div></td><?php } ?>
  <?php if($survey_hidden){ ?>  <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='SurveyMgt/survey_index.php';"><div align="center"><img src="theme/main_theme/g_survey_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Form <br>Generator</span></div></td><?php } ?>
   <?php if($webboard_hidden){ ?> <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='WebboardMgt/webboard_index.php';"><div align="center"><img src="theme/main_theme/g_webboard_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Web Board </span></div></td><?php } ?>
    <?php if($faq_hidden){ ?> <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='WebboardMgt/faq_index.php';"><div align="center"><img src="theme/main_theme/g_faq_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">FAQ</span></div></td><?php } ?>
	 <?php if($language_hidden&&$sh!="1"){ ?><td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='LanguageMgt/language_index.php';"><div align="center"><img src="theme/main_theme/g_multilang_64.gif" width="56" height="56" border="0" /><br />
     Multi<br>language </div></td><?php } ?>
  </tr>
  <tr bgcolor="#F8F8F8">
   <?php if($poll_hidden){ ?>  <td height="100" align="center" valign="middle" bgcolor="#FFFFFF" style="" onClick="self.top.ewt_main.location.href='PollMgt/poll_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><div align="center"><img src="theme/main_theme/g_poll_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Polls</span></div></td><?php } ?>
     <?php if($sitemap_hidden){ ?><td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='MenuMgt/sitemap_index.php';"><div align="center"><img src="theme/main_theme/g_sitemap_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Site Map </span></div></td><?php } ?>
    <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='StatMgt/stat_index.php';"><div align="center"><img src="theme/main_theme/g_sitestats_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Site Stats </span></div></td>
    <?php if($calendar_hidden){ ?> <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='CalendarMgt/calendar_index.php';"><div align="center"><img src="theme/main_theme/g_calendar_64.gif" width="56" height="56" border="0" /><br />
    <span class="style1">Calendar</span></div></td><?php } ?>
     <?php if($sdes_hidden){if (strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0')!== false&& strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0;')!== false){ ?><td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='LookMgt/look_index.php';"><div align="center"><img src="theme/main_theme/icon_jquery_gif64/bar_save_as.gif" width="56" height="56" border="0" /><br />
	 <span class="style1">Site Template </span></div></td><?php }} ?>
	 <?php if($vdo_hidden){ ?><td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='vdoMgt/index_vdo.php';"><div align="center"><img src="theme/main_theme/g_vdo_64.gif" width="56" height="56" border="0" /><br />
      Video Clip
    </div></td><?php } ?>
  </tr>
  <tr bgcolor="#F8F8F8">
    <?php if($Gallery_hidden){ ?><td height="100" align="center" valign="middle" bgcolor="#FFFFFF" style="" onClick="self.top.ewt_main.location.href='GalleryMgt/gallery_index.php';" onMouseOver="button_over(this)" onMouseOut="button_out(this)"><div align="center"><img src="theme/main_theme/g_gallery_64.gif" width="56" height="56" border="0" /><br />
      Gallery
    </div></td><?php } ?>
	<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0')!== false&& strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0;')!== false){ ?>
		<?php if($sdes_hidden){ ?> <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='DesignMgt/index.php';"><div align="center"><img src="theme/main_theme/g_block_64.gif" width="56" height="56" border="0" /><br />
		  WebBlock<br>Design</div></td><?php } ?>
	<?php } ?>
    <?php if($Ebook_hidden){ ?> <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='EbookMgt/index.php';"><div align="center"><img src="theme/main_theme/g_ebook_64.gif" width="56" height="56" border="0" /><br />
      E-book</div></td><?php } ?>
     <?php if($Banner_hidden){ ?><td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='BannerMgt/banner_index.php';"><div align="center"><img src="theme/main_theme/g_banner_64.gif" width="56" height="56" border="0" /><br />
      Banner
    </div></td><?php } ?>
     <?php if($Blog_hidden){ ?><td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='BlogMgt/index.php';"><div align="center"><img src="theme/main_theme/g_blog_64.gif" width="56" height="56" border="0" /><br />
      Web Blog</div></td><?php } ?>
	  <?php if($rss_hidden&&$sh!="1"){ ?> <td align="center" valign="middle" bgcolor="#FFFFFF" style="" onMouseOver="button_over(this)" onMouseOut="button_out(this)" onClick="self.top.ewt_main.location.href='RssReader/rss_index.php';"><div align="center"><img src="theme/main_theme/g_rss_64.gif" width="56" height="56" border="0" /><br />
      Rss
    </div></td><?php } ?>
  </tr>
</table>
		  </fieldset>
<?php }else{ 
	include("show_icon_permission.php"); 
}  ?></td>
          <td width="30%" valign="top"  ><fieldset style="padding:10px;" ><div style="scrollbar-face-color: # ff6699; left: 306px; float: right; overflow-x: hidden; overflow: scroll;  scrollbar-3dlight-color: #000000; scrollbar-arrow-color: #ffffff; scrollbar-base-color: #ffffff; HEIGHT: 440px"><img src="images/star_yellow_preferences.gif" width="24" height="24"><span class="ewtfunction">Favorites</span><br>
            <br>
		  	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
			<?php
			$sql_module = "select favoristes_module from favoristes where favoristes_user = '".$_SESSION["EWT_SMID"]."' group by favoristes_module";
			$query_module = $db->query($sql_module);
			while($M = $db->db_fetch_array($query_module)){
			if($M[favoristes_module] == 'article'){
			$module_name = 'Article Management';
			}else if($M[favoristes_module] == 'menu'){
			$module_name = 'Menu Management';
			}else if($M[favoristes_module] == 'language'){
			$module_name = 'Language Management';
			}else if($M[favoristes_module] == 'vulgar'){
			$module_name = 'Rude Words Filter ';
			}else if($M[favoristes_module] == 'dictionary'){
			$module_name = 'Dictionary Management ';
			}else if($M[favoristes_module] == 'rss'){
			$module_name = 'RSS News Feed ';
			}else if($M[favoristes_module] == 'document'){
			$module_name = 'Document Download Management ';
			}else if($M[favoristes_module] == 'sitemap'){
			$module_name = 'Sitemap Management ';
			}else if($M[favoristes_module] == 'gallery'){
			$module_name = 'Gallery Management ';
			}else if($M[favoristes_module] == 'banner'){
			$module_name = 'Banner Management ';
			}else if($M[favoristes_module] == 'ebook'){
			$module_name = 'E-Book Management ';
			}else if($M[favoristes_module] == 'video'){
			$module_name = 'Video Management ';
			}else if($M[favoristes_module] == 'ecard'){
			$module_name = 'E-Card Management ';
			}else if($M[favoristes_module] == 'virtual'){
			$module_name = 'Virtual Tour Management  ';
			}else if($M[favoristes_module] == 'complain'){
			$module_name = 'Complain Management  ';
			}else if($M[favoristes_module] == 'webboard'){
			$module_name = 'Webboard Management  ';
			}else if($M[favoristes_module] == 'guestbook'){
			$module_name = 'Guestbook Management  ';
			}else if($M[favoristes_module] == 'faq'){
			$module_name = 'FAQ Management  ';
			}else if($M[favoristes_module] == 'newsletter'){
			$module_name = 'NewsLetter Management  ';
			}else if($M[favoristes_module] == 'calendar'){
			$module_name = 'Calendar Management  ';
			}else if($M[favoristes_module] == 'blog'){
			$module_name = 'Web Blog Management  ';
			}else if($M[favoristes_module] == 'poll'){
			$module_name = 'Poll Management  ';
			}else if($M[favoristes_module] == 'survey'){
			$module_name = 'Form Generator  Management  ';
			}else if($M[favoristes_module] == 'member'){
			$module_name = 'Member Management  ';
			}else if($M[favoristes_module] == 'org'){
			$module_name = 'Organization Management ';
			}else if($M[favoristes_module] == 'weblink'){
			$module_name = 'Web Site Link Management  ';
			}
			?>
			<tr><td colspan="2"><span class="ewtsubmenu"><font color="#0033FF"><strong><?php echo $module_name;?></strong></font></span><br><br></td></tr>
			<?php
			$sqlF = "select * from favoristes where favoristes_user = '".$_SESSION["EWT_SMID"]."' and favoristes_module = '".$M[favoristes_module]."'";
			$queryF = $db->query($sqlF);
			$numF = $db->db_num_rows($queryF);
			while($F = $db->db_fetch_array($queryF)){
			$F[favoristes_url] = urlencode ($F[favoristes_url]);
			if($F[favoristes_module] == 'article'){
			$link = 'ContentMgt/article_index.php?url='.$F[favoristes_url];
			$click = '';
			}else if($F[favoristes_module] == 'menu'){
			$link = 'MenuMgt/menu_index.php?url='.$F[favoristes_url];
			$click = '';
			}else if($F[favoristes_module] == 'language'){
			$link = 'LanguageMgt/language_index.php?url='.$F[favoristes_url];
			$click = '';
			}else if($F[favoristes_module] == 'vulgar'){
			$link = 'VulgarMgt/vul_index.php?url='.$F[favoristes_url];
			$click = '';
			}else if($F[favoristes_module] == 'dictionary'){
			$link = 'DictionaryMgt/dict_index.php?url='.$F[favoristes_url];
			$click = '';
			}else if($F[favoristes_module] == 'rss'){
			$link = 'RssReader/rss_index.php?url='.$F[favoristes_url];
			$click = '';
			}else if($F[favoristes_module] == 'document'){
			$link = 'DocumentMgt/doc_index.php?url='.$F[favoristes_url];
			$click = '';
			}else if($F[favoristes_module] == 'sitemap'){
				if($F[favoristes_type] == 'popup'){
				$link  = '##G';
				$click = "onClick=\"window.open('MenuMgt/".urldecode ($F[favoristes_url])."', 'sitemapMgt', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');\"";
				}else{
				$link = 'MenuMgt/sitemap_index.php?url='.$F[favoristes_url];
				$click = '';
				}
			}else if($F[favoristes_module] == 'gallery'){
				$link = 'GalleryMgt/gallery_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'banner'){
				$link = 'BannerMgt/banner_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'ebook'){
				$link = 'EbookMgt/index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'video'){
				$link = 'vdoMgt/index_vdo.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'ecard'){
				$link = 'EcardlMgt/ecard_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'virtual'){
				$link = 'VirtualMgt/virtual_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'complain'){
				$link = 'ComplainMgt/complain_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'webboard'){
				$link = 'WebboardMgt/webboard_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'guestbook'){
				$link = 'GuestMgt/guest_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'faq'){
				$link = 'WebboardMgt/faq_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'newsletter'){
				$link = 'NewsLetterMgt/news_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'calendar'){
				$link = 'CalendarMgt/calendar_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'blog'){
				$link = 'BlogMgt/index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'poll'){
				$link = 'PollMgt/poll_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'survey'){
				$link = 'SurveyMgt/survey_index.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'member'){
				$link = 'MemberMgt/index_member_out.php?url='.$F[favoristes_url];
				$click = '';
			}else if($F[favoristes_module] == 'org'){
				if($F[favoristes_type] == 'popup'){
				$link  = '##G';
				$click = "onClick=\"window.open('MemberMgt/".urldecode ($F[favoristes_url])."','editmember', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=600, width=800, left=10,top=10');\"";
				}else{
				$link = 'MemberMgt/index_member.php?url='.$F[favoristes_url];
				$click = '';
				}
				
			}else if($F[favoristes_module] == 'weblink'){
				$link = 'LinkMgt/link_index.php?url='.$F[favoristes_url];
				$click = '';
			}
			?>
			  <tr>
				<td><img src="images/icon_more.gif" align="middle">&nbsp;<a href="<?php echo $link;?>" <?php echo $click;?>><?php echo $F[favoristes_name];?></a>					</td>
			    <td width="25" align="center" valign="middle"><a href="FavoritesMgt/favorites_function.php?flag=del&Fid=<?php echo $F[favoristes_id];?>"><img src="images/b_delete.gif" width="14" height="14" alt="ลบ" border="0"  onClick="return confirm('ต้องการลบข้อมูลหรือไม่');" onMouseOver="this.style.cursor='hand';" ></a></td>
			    <td width="30" align="center" valign="middle">&nbsp;&nbsp;<a href="#G" onClick="load_divForm('FavoritesMgt/favorites_add.php?Fid=<?php echo $F[favoristes_id];?>', 'divForm', 300, 80, -1,433, 1);"><img src="images/article_pencil.gif" width="14" height="14" border="0"></a>&nbsp;&nbsp;</td>
			  </tr>
			  <tr>
			    <td colspan="3"><HR style="BORDER-RIGHT: 1px dotted; BORDER-TOP: 1px dotted; BORDER-LEFT: 1px dotted; BORDER-BOTTOM: 1px dotted" color=#111111 SIZE=1>			</td>
			    </tr>
			 <?php }
			 }
			 if($numF==0){
			  ?>
			  <tr>
				<td colspan="3" align="center">---ไม่พบข้อมูล---</td>
			  </tr>
			  <?php } ?>
			</table></div>
          </fieldset></td>
        </tr>
      </table>
	  
</td>
  </tr>
  <tr> 
    <td height="30" valign="bottom" bgcolor="#F8F8F8"> <br>
	<table  border="0" cellspacing="0" cellpadding="0">
      <?php
			$num = count($_SESSION["EWT_OPEN_SAVE"]);
			for($i=0;$i<$num;$i++){
					if($i%3 == 0){
			echo "<tr  align=center width=\"210\">";
					}
			?>
			<td>
			<table width="200" border="0" cellpadding="1" cellspacing="0" bgcolor="#333333">
			<form name="formClose<?php echo $i; ?>" method="post" action="ContentMgt/content_function.php"><input name="file_name" type="hidden" id="file_name" value="<?php echo $_SESSION["EWT_OPEN_SAVE"][$i]; ?>"><input name="Flag" type="hidden" id="Flag" value="Close">
        <tr>
          <td><table width="200" height="19" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000" style="border-Bottom:'buttonshadow solid 1px';border-Left:'buttonhighlight solid 1px';border-Right:'buttonshadow solid 1px';border-Top:'buttonhighlight solid 1px'">
        <tr bgcolor="F3F3EE">
          <td ><img src="images/bar_new.gif" width="20" height="20" border="0" align="absmiddle"> <?php echo $_SESSION["EWT_OPEN_SAVE"][$i]; ?></td>
                      <td width="18" align="center" ><a href="#restore" onClick="OpenFile('<?php echo $_SESSION["EWT_OPEN_SAVE"][$i]; ?>')"><img src="images/bar_restore.gif" width="15" height="13" border="1" align="absmiddle" style="border-Color:threedface"   onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Restore Up"></a></td>
                      <td width="18" align="center" ><a href="#close" onClick="formClose<?php echo $i; ?>.submit();"><img src="images/bar_close.gif" width="15" height="13" border="1" align="absmiddle" style="border-Color:threedface"   onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Close"></a></td>
        </tr>
      </table></td>
        </tr>
		</form>
      </table></td>
				<?php
				  		if($i%3 == 3){
							echo "</tr>";
						}
			}
			
		?>
    </table>
	<iframe name="iframe_data" src=""  frameborder="0"  width="1" height="1" scrolling="no"></iframe  >
    </td>
  </tr>
  <tr>
    <td height="1" bgcolor="716F64"></td>
  </tr>
  <tr> 
  <td height="24" bgcolor="F3F3EE">
        &nbsp;&copy; 
      Copyright 2007 - BizPotential Co., Ltd. - All Rights Reserved. 
      </td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
