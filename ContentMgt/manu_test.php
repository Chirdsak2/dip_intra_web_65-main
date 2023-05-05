<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");	
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script type='text/javascript' src='../js/jquery/jquery-1.2.3.min.js'></script>
<script type='text/javascript' src='../js/jquery/jquery.jqDock.js'></script>

<style type="text/css">
<!--
#menu1 {
	PADDING-LEFT: 131px; POSITION: relative; TOP: 100px
}
#menu2 {
	RIGHT: 0px; WIDTH: 50px; POSITION: absolute; TOP: 0px
}
#menu3 {
	PADDING-LEFT: 131px; POSITION: relative; TOP: 552px
}
#menu4 {
	LEFT: 131px; POSITION: absolute; TOP: 510px
}
#menu4 IMG {
	PADDING-RIGHT: 4px; PADDING-LEFT: 4px; PADDING-BOTTOM: 0px; PADDING-TOP: 0px
}
#menu5 {
	LEFT: 0px; POSITION: absolute; TOP: 0px
}
#menu6 {
	RIGHT: 200px; WIDTH: 0px; POSITION: absolute; TOP: 30px
}
#menu7 {
	DISPLAY: none; LEFT: 580px; POSITION: absolute; TOP: 150px
}
DIV.jqDock {
	BACKGROUND-COLOR: transparent
}
#menu2 DIV.jqDock {
	BORDER-RIGHT: #999999 0px; BORDER-TOP: #999999 2px solid; BORDER-LEFT: #999999 2px solid; BORDER-BOTTOM: #999999 2px solid
}
#menu3 DIV.jqDock {
	BORDER-RIGHT: #ff9900 2px solid; BORDER-TOP: #ff9900 2px solid; BORDER-LEFT: #ff9900 2px solid; BORDER-BOTTOM: #ff9900 2px solid
}
#menu4 DIV.jqDock {
	BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid; BACKGROUND-COLOR: #cccccc
}
#menu5 DIV.jqDock {
	BACKGROUND-COLOR: #000000
}
#menu6 DIV.jqDock {
	BORDER-RIGHT: #0000ff 3px solid; BORDER-TOP: #0000ff 3px solid; BORDER-LEFT: #0000ff 3px solid; BORDER-BOTTOM: #0000ff 3px solid; BACKGROUND-COLOR: #e0e0ff
}
#menu7 DIV.jqDock {
	BORDER-RIGHT: #0000cc 1px solid; BORDER-TOP: #0000cc 1px solid; BORDER-LEFT: #0000cc 1px solid; BORDER-BOTTOM: #0000cc 1px solid
}
DIV.jqDockLabel {
	BORDER-RIGHT: 0px; PADDING-RIGHT: 4px; BORDER-TOP: 0px; PADDING-LEFT: 4px; FONT-WEIGHT: bold; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; BORDER-LEFT: 0px; COLOR: #000000; PADDING-TOP: 0px; BORDER-BOTTOM: 0px; FONT-STYLE: italic; WHITE-SPACE: nowrap; BACKGROUND-COLOR: transparent
}
DIV.jqDockLabelLink {
	CURSOR: pointer
}
DIV.jqDockLabelImage {
	CURSOR: default
}
#menu2 DIV.jqDockLabel {
	PADDING-RIGHT: 1px; PADDING-LEFT: 1px; FONT-WEIGHT: normal; FONT-SIZE: 12px; PADDING-BOTTOM: 1px; COLOR: #cc0000; PADDING-TOP: 1px; BACKGROUND-COLOR: #ffffff
}
#menu5 DIV.jqDockLabel {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; COLOR: #ffffff; PADDING-TOP: 0px
}

.demo {
	DISPLAY: none
}
.demo IMG {
	BORDER-RIGHT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; VERTICAL-ALIGN: top; BORDER-LEFT: 0px; WIDTH: 48px; PADDING-TOP: 0px; BORDER-BOTTOM: 0px; HEIGHT: 48px
}
-->
</style></head>
<body bgcolor="808080" leftmargin="0" topmargin="0">
<DIV  id=menu3 class=demo> 
			<a href="#editor" onClick="choose('text')"><img src="../images/bar_etext.gif" width="60" height="60"  title="Insert Block"></a>
		  <a href="#coding" onClick="choose('code')"><img src="../images/bar_code.gif" width="60" height="60"  title="Insert Coding"></a>
		  <a href="#graph" onClick="choose('graph')"><img src="../images/bar_graph.gif" width="60" height="60"  title="Insert Graph"></a>
		  <a href="#article" onClick="choose('article')"><img src="../images/bar_article.gif"  width="60" height="60" title="Insert Article"></a>
		  <a href="#img" onClick="choose_p('images')"><img src="../images/bar_img.gif"  width="60" height="60" title="Insert Image"></a>
		  <a href="#flash" onClick="choose_p('flash')"><img src="../images/bar_flash.gif" width="60" height="60"  title="Insert Flash"></a>
		  <a href="#media" onClick="choose_d('media')"><img src="../images/bar_media.gif" width="60" height="60"  title="Insert Media"></a>
		  <a href="#menu" onClick="choose('menu')"><img src="../images/bar_link.gif" width="60" height="60"  title="Insert Menu"></a>
		   <a href="#share" onClick="choose_share('<?php echo $_GET["filename"]; ?>')"><img src="../images/bar_share.gif"  width="60" height="60" title="Insert Share Content"></a>
		  <a href="#share" onClick="choose_org('<?php echo $_GET["filename"]; ?>')"><img src="../images/bar_org.gif"  width="60" height="60" title="Insert Organization Chart"></a>
		  <a href="#size" onClick="choose('fontsize')"><img src="../images/bar_fontsize.gif" width="60" height="60"  title="Insert Font Size Control"></a>
		  <a href="#poll" onClick="choose('poll')"><img src="../images/bar_poll.gif" width="60" height="60" title="Insert Poll Block"></a>
		  <a href="#enews" onClick="choose('enews')"><img src="../images/bar_enews.gif"  width="60" height="60" title="Insert E-News Letter"></a>
		  <a href="#survey" onClick="choose('survey')"><img src="../images/bar_survey.gif"  width="60" height="60" title="Insert Survey"></a>
		  <a href="#calendar" onClick="choose('calendar')"><img src="../images/bar_calendar.gif"  width="60" height="60" title="Insert Calendar"></a>
		  <a href="#webboard" onClick="choose('webboard')"><img src="../images/bar_wb.gif"  width="60" height="60" title="Insert Webboard"></a>
		  <a href="#faq" onClick="choose('faq')"><img src="../images/bar_faq.gif"  width="60" height="60" title="Insert FAQ"></a>
		  <a href="#complain" onClick="choose('complain')"><img src="../images/bar_complain.gif"  width="60" height="60" title="Insert Complain"></a>
		  <a href="#sitemap" onClick="choose('sitemap')"><img src="../images/bar_sitemap.gif"  width="60" height="60" title="Insert Sitemap"></a>
		  <a href="#gallery" onClick="choose('gallery')"><img src="../images/bar_gallery.gif" width="60" height="60"  title="Insert Gallery Picture"></a>
		  <a href="#search" onClick="choose('search')"><img src="../images/bar_search.gif"  width="60" height="60" title="Insert Search Box"></a>
		  <a href="#banner" onClick="choose('banner')"><img src="../images/bar_banner.gif" width="60" height="60"  title="Insert Banner List"></a>
		  <a href="#guest" onClick="choose('guest')"><img src="../images/bar_guest.gif"  width="60" height="60" title="Insert Guestbook"></a>
		  <a href="#login" onClick="choose('login')"><img src="../images/bar_login.gif" width="60" height="60"  title="Insert Login Form"></a>
		  <a href="#rss" onClick="choose('rss')"><img src="../images/bar_rss.gif"  width="60" height="60" title="Insert Rss Reader"></a>
		  <a href="#link" onClick="choose('link')"><img src="../images/bar_link2.gif" width="60" height="60"  title="Insert Related Link"></a>
		  <a href="#user" onClick="choose('online')"><img src="../images/bar_user.gif" width="60" height="60"  title="Insert User Online Block"></a>
		  <a href="#ebook" onClick="choose('ebook')"><img src="../images/bar_ebook.gif"  width="60" height="60" title="Insert E-Book Block"></a>
		  <a href="#blog" onClick="choose('blog')"><img src="../images/bar_blog.gif"  width="60" height="60" title="Insert Blog"></a>
		 <a href="#news" onClick="choose('news')"><img src="../images/bar_news.gif"  width="60" height="60" title="Insert News Block"></a>
		 <a href="#media" onClick="choose('vdo')"><img src="../images/bar_media1.gif"  width="60" height="60" title="Insert Video Clip"></a>
		 <a href="#language" onClick="choose('language')"><img src="../images/bar_language.gif"  width="60" height="60" title="Insert language Block"></a></DIV>
</body>
</html>
<script>
	jQuery(document).ready(function(){
		var opts =
		{ align: 'top'
		, size: 17
		, labels: true
		, source: function(i){ return this.src.replace(/(jpg|png)$/,'gif'); }
		};
		jQuery('#menu3').jqDock(opts);
	});
</script>
<?php $db->db_close(); ?>
