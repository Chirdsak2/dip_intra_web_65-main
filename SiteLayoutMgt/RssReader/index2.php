<html>
<head>
<title>RSS Reader</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_rss.css" rel="stylesheet" type="text/css">
<link href="../css/geo_rss.css" rel="stylesheet" type="text/css">
</head>
<body>
<br><br>

	<?php
	
	$map = array();
	$data = array();
	
	function startElement($parser,$name,$att){
				global $map;
				global $data;
				array_push($map,$name);
				
				if ($name == "ITEM"){
					$data[sizeof($data)] = array();
				}
	}
	
	function endElement($parser,$name){
			global $map;
			array_pop($map);
	}
	
	function startContents($parser,$contents){
			global $map;
			global $data;

			switch($map[sizeof($map)-1]){
				case "TITLE" : 
					if ($map[sizeof($map)-2] == "ITEM")
						$data[sizeof($data)-1]['TITLE'] = $contents;
					break;
				case "LINK" : 
					if ($map[sizeof($map)-2] == "ITEM")
						$data[sizeof($data)-1]['LINK'] = $contents;
					break;
				}
	}
	
	function KMRssReader($rss_file,$row){
			global $data;
			if (($contents = file_get_contents($rss_file))){
				$xml_parser = xml_parser_create();
				xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,true);
				xml_set_element_handler($xml_parser,"startElement","endElement");
				xml_set_character_data_handler($xml_parser,"startContents");
			
				if (!(xml_parse($xml_parser,$contents,true))){
					die(sprintf("XML error: %s at line %d",
					xml_error_string(xml_get_error_code($xml_parser)),
					xml_get_current_line_number($xml_parser)));
				}
		
				for($i=0;$i < sizeof($data) && $i < $row;$i++){
							?><li><a target="_blank" href='<?php echo trim($data[$i]['LINK']);?>'><?php echo trim($data[$i]['TITLE']);?></a></li><?php
				}
				$data = array();
			}else{
				    echo "Error : Cannot Open the XML File";
			}
	}
	

	$rss_url="http://192.168.0.64/ewtadmin/ewt/thailand/rss/group16.xml";
	if (trim($rss_url)){
		if (!function_exists("file_get_contents")){
				function file_get_contents($file){
					$fh = fopen($file,"r");
					while (!feof($fh)){
					     $contents .= fread($fh,4000);
					}
					return $contents;
				}
	    }

		ob_start();
		KMRssReader($rss_url,($row ? $row : 50));
		$contents = ob_get_contents();
		$contents = str_replace('"','\"',$contents);
		$contents = str_replace("\r\n","",$contents);
		ob_end_clean();
}  ?>

	<table width="95%" cellpadding="2">
			<tr>
				<td style="font-size: .83em;font-family: Arial;color: #7c56a7;font-weight: bold;">&nbsp;<img src="../css/images/gcp_arw_down.gif"  valign=baseline border=0 height=12 width=12>แสดงเอกสาร ( RSS )</td>
			</tr>
			<tr><td><?php echo $contents;?></td></tr>
</table>


</body>
