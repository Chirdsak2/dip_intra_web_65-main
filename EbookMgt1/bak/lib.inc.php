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
