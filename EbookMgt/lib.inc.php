<?php
function remove_dir($dir)
 {
 $dh = opendir($dir);
 while ($item = readdir($dh))
  {
  if ($item == "." || $item == "..")
   continue;
  else if (is_dir("$dir/$item"))
   remove_dir("$dir/$item");
  else
   unlink("$dir/$item");
  }
 closedir($dh);
 rmdir($dir);
 }
 
function copy_dir($src,$dest)
 {
 //$src_pathinfo = pathinfo($src);
 //$dest_pathinfo = pathinfo($dest);
 if (!file_exists($dest))
  mkdir($dest,0755);
 
 $dh = opendir($src);
 while ($file = readdir($dh))
  {
  //echo $file;
  if ($file == "." || $file == ".." || $file == "Thumbs.db")
   continue;
  else if (is_dir($src."/".$file))
   {
   //echo " copy_dir_content";
   //mkdir($dest."/".$file);
   copy_dir($src."/".$file,$dest."/".$file);
   }
  else
   {
   //echo " copy";
   copy($src."/".$file,$dest."/".$file);
   }
  //echo "<br>";
  }
 }

function wirteFile ($filename,$somecontent) {
// Let's make sure the file exists and is writable first.
if (is_writable($filename)) {

    // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence 
    // that's where $somecontent will go when we fwrite() it.
    if (!$handle = fopen($filename, 'w')) {
         echo "Cannot open file ($filename)";
         exit;
    }

    // Write $somecontent to our opened file.
    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }
    
    //echo "Success, wrote ($somecontent) to file ($filename)";
    
    fclose($handle);

} else {
    echo "The file $filename is not writable";
  }
}
/*
function getContent_Index ($title) {
   $content = '<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>'.$title.'</title>
<script src="js/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="js/PopUpWin.js" type="text/javascript"></script>
<style type="text/css">
<!--
body {
	background-color: #ccc;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<body><script type="text/javascript">
AC_FL_RunContent( \'codebase\',\'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\',\'width\',\'100%\',\'height\',\'100%\',\'src\',\'swf/Magazine\',\'quality\',\'high\',\'pluginspage\',\'http://www.macromedia.com/go/getflashplayer\',\'bgcolor\',\'#cccccc\',\'allowFullScreen\',\'true\',\'allowScriptAccess\',\'sameDomain\',\'movie\',\'swf/Magazine\' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100%" height="100%">
  <param name="movie" value="swf/Magazine.swf" />
  <param name="quality" value="high" />
  <param name="bgcolor" value="#cccccc" />
  <param name="allowFullScreen" value="true" />
  <param name="allowScriptAccess" value="sameDomain" />
  <embed src="swf/Magazine.swf" width="100%" height="100%" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" allowFullScreen="true" allowScriptAccess="sameDomain"></embed>
</object></noscript></body></html>';

return $content;
}*/
function getContent_Index ($title) {
    $content = '<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="monitor-signature" content="monitor:player:html5">
 <meta name="apple-mobile-web-app-status-bar-style" content="black" />
 
<meta name="Keywords" content="" />
<meta name="Description" content="'.$title.'" />
<meta name="Generator" content="Flip PDF Professional 2.4.6  at http://www.flipbuilder.com" />
<link rel="image_src" href="files/shot.png">
 <link rel="apple-touch-icon" href="files/thumb/1.jpg" />
<meta name="og:image" content="files/shot.png">
<meta property="og:image" content="files/shot.png">
<title>'.$title.'</title>

<link rel="stylesheet" href="style/style.css" />
<link rel="stylesheet" href="style/player.css" />
<link rel="stylesheet" href="style/phoneTemplate.css" />

<script src="javascript/jquery-1.9.1.min.js"></script>

<script src="javascript/config.js"></script>



</head>	
<body>
<!--<script src="javascript/search_config.js"></script>--><script src="javascript/bookmark_config.js"></script>
<script src="javascript/LoadingJS.js"></script>

<script src="javascript/main.js"></script>

<link rel="stylesheet" href="style/template.css" />
<script type="text/javascript">

		
	var sendvisitinfo = function(type,page){};
	
</script>



<noscript><div><hr width="80%"/><ul align="left"><li><a href="files/basic-html/index.html">Pages</a></li></ul><hr width="80%"/></div></noscript>
</body>
<script>
	$(window).load(function(){
		$("#pbToolBar").append("<img title=\'Full Screen\' id=\'Fullscreen_btn\' src=\'" + bookConfig.appLogoIcon +"\' style=\'cursor:pointer;position:absolute;right:0px;width:35px;height:35px;\' onclick=\'toggleFullScreen(document.body);\'/>");
		$(\'#logo\').remove();
		isPhone() || isPad() || (this.controlBar || (this.controlBar = new zoomControlBar(bookContainer), this.controlBar.setPosition((windowWidth -
            this.controlBar.width) / 2, toolBar.getTopHeight() + 5)), this.controlBar && this.controlBar.setVisible(!0), this.bookMap && (this.bookMap.show(), this.bookMap.fillContent(this.currentPageIndex)));
        this.status_zoom = !0;
        this.adContainer && this.adContainer.css({"z-index": 1});
	});
	function toggleFullScreen(elem) {
    // ## The below if statement seems to work better ## if ((document.fullScreenElement && document.fullScreenElement !== null) || (document.msfullscreenElement && document.msfullscreenElement !== null) || (!document.mozFullScreen && !document.webkitIsFullScreen)) {
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (elem.requestFullScreen) {
			// mozilla proposal
			elem.requestFullScreen();
		}else if (elem.webkitRequestFullScreen) { 
			// Webkit (works in Safari and Chrome Canary)
			elem.webkitRequestFullScreen();
		}else if (elem.mozRequestFullScreen) {
			// Firefox (works in nightly)
			elem.mozRequestFullScreen();
		}
		if((window.fullScreen) || (window.innerWidth == screen.width && window.innerHeight == screen.height)) {
			$(\'#Fullscreen_btn\').remove();
			$(\'#pbToolBar\').append("<img title=\'Full Screen\' id=\'Fullscreen_btn\' src=\'" + bookConfig.appLogoIcon +"\' style=\'cursor:pointer;position:absolute;right:0px;width:35px;height:35px;\' onclick=\'toggleFullScreen(document.body);\'/>");
		} else {
			$(\'#Fullscreen_btn\').remove();
			$(\'#pbToolBar\').append("<img title=\'Full Screen\' id=\'Fullscreen_btn\' src=\'" + bookConfig.appLogoIconOut +"\' style=\'cursor:pointer;position:absolute;right:0px;width:35px;height:35px;\' onclick=\'toggleFullScreen(document.body);\'/>");
		}
    } else {
		if (elem.requestFullScreen) {
			// mozilla proposal
			document.cancelFullScreen(); 
		}else if (elem.webkitRequestFullScreen) { 
			// Webkit (works in Safari and Chrome Canary)
			document.webkitCancelFullScreen(); 
		}else if (elem.mozRequestFullScreen) {
			// Firefox (works in nightly)
			document.mozCancelFullScreen(); 
		}
		if((window.fullScreen) || (window.innerWidth == screen.width && window.innerHeight == screen.height)) {
			$(\'#Fullscreen_btn\').remove();
			$(\'#pbToolBar\').append("<img title=\'Full Screen\' id=\'Fullscreen_btn\' src=\'" + bookConfig.appLogoIcon +"\' style=\'cursor:pointer;position:absolute;right:0px;width:35px;height:35px;\' onclick=\'toggleFullScreen(document.body);\'/>");
		} else {
			$(\'#Fullscreen_btn\').remove();
			$(\'#pbToolBar\').append("<img title=\'Full Screen\' id=\'Fullscreen_btn\' src=\'" + bookConfig.appLogoIconOut +"\' style=\'cursor:pointer;position:absolute;right:0px;width:35px;height:35px;\' onclick=\'toggleFullScreen(document.body);\'/>");
		}
    }
}
</script>
</html>';

    return $content;
}
function getContent_Page ($w,$h,$ebookCode) {
global $db;
 /* Blue Color*/ 
   $panelcolor="3a6dac";
   $buttoncolor="3a6dac";
   $textcolor="d0e5f7";
 
 /* Blabk Color
    $panelcolor="5d5d61";
    $buttoncolor="5d5d61";
    $textcolor="ffffff";
 */
  $content = '<content width="'.$w.'" height="'.$h.'" bgcolor="cccccc" loadercolor="ffffff" panelcolor="'.$panelcolor.'" buttoncolor="'.$buttoncolor.'" textcolor="'.$textcolor.'">'."\n";
  $content .= genPage($ebookCode);
  $content .= '</content>';
  return $content;
}

function genPage ($ebookCode) {
	global $db;
	$page = '';
	$query = $db->query ("select * from ebook_page where ebook_code like '$ebookCode' order by ebook_page");
	while ($rec = $db->db_fetch_array ($query)) {
      $page .='<page src="pages/'.$rec['ebook_page_file'].'"/>'."\n";
	}// while
	return $page;
}

function getType_File ($file) {
	$arr = explode ('.',$file);
	return $arr[1];
}
?>
