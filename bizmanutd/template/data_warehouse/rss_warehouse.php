<?php
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE datawarehouse");


	$myURL="http://www.parliament.go.th";
 
	$xml_text='<'.'?xml version="1.0" encoding="utf-8"?'.'>
	<rss version="2.0">
	<channel>
		  <title>Thai Parliament</title> 
		  <link>'.$myURL.'</link> 
		  <description>'.$myURL.'</description> 
		  <language>th-TH</language> 
		  <pubDate>'.date('D,d M Y H:i:s e').'</pubDate>
		  <copyright>Copyright 2006-2009 All rights reserved. Bizpotential CO.,LTD.</copyright> 
	';

//$query_rss=$db->query(" SELECT * FROM attach_file  WHERE attach_file.meeting_id='$mid' ");

$SQL="SELECT name,detail,date_update,attach_file,attach_filetype,attach_filesize,yearno,year,num,session_name,
attach_file_title,attach_file_author,attach_file_subject,attach_file_description,attach_file_identifier,attach_file_used
FROM data_wh INNER JOIN attach_file ON data_wh.path_file = attach_file.attach_file_id
";
//WHERE attach_file.meeting_id='$mid' 

$query_rss=$db->query($SQL);


	while($rss=$db->db_fetch_array($query_rss)){

	if(trim($rss[attach_file_author]) == ''){ $author=$myURL;
	}else{  $author=$rss[attach_file_author]; }

	if(trim($rss[attach_file_title]) == ''){   $title="Untitled";
	    if(trim($rss[attach_file_used]) == ''){   $title="Untitled";
	    }else{    $title=$rss[attach_file_used]; }
	}else{    $title=$rss[attach_file_title]; }

	if(trim($rss[attach_file_description]) == '' && trim($rss[detail]) == ''){   $desc="Untitled";
	}else{    $desc=$rss[attach_file_description].' '.$rss[detail]; } 
	$desc.=" ( ชุดที่ $rss[yearno] ปีที่ $rss[year] ครั้งที่ $rss[num] สมัย $rss[session_name] )";
 


	$title.=' (ขนาดไฟล์ : '.number_format($rss[attach_filesize]/1024,2).' KB)';
	$xml_text.='<item>
					<title>'.$title.'</title>
					<link>'.$myURL.'/ewtadmin0850/data_warehouse/file/'.$rss["attach_file"].'</link>
					<description>'.$desc.'</description>
					<author>'.$author.'</author>
					<category>'.$rss[attach_filetype].'</category>
					<lastBuildDate>'.$rss[date_update].'</lastBuildDate> 
					<guid>'.$rss[attach_file_identifier].'</guid>
				</item>
				';
	}
	$xml_text.='</channel>
</rss>
	';
	//$fp=fopen("../ewt/".$_SESSION["EWT_SUSER"]."/rssfile/group".$mid.".xml","w");
	//fputs($fp,$xml_text);
	//fclose($fp);
	echo $xml_text;

$db->db_close(); 

?>
