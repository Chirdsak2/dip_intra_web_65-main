<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//===========================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);

	if($gid){ $gid = checkNumeric($gid); }
	if($_GET["gid"]){ $_GET["gid"] = checkNumeric($_GET["gid"]); }
	if($_POST["gid"]){ $_POST["gid"] = checkNumeric($_POST["gid"]); }
	
	if($BID){ $BID = checkNumeric($BID); }
	if($_GET["BID"]){ $_GET["BID"] = checkNumeric($_GET["BID"]); }
	if($_POST["BID"]){ $_POST["BID"] = checkNumeric($_POST["BID"]); }
	//===========================================================
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}

$lang_sh1 = explode('___',$F[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
			
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);
$design_id = $R["d_id"];

$global_theme = $R["d_bottom_content"];
$mainwidth = "0";

	?>
<html>
<head>
<title><?php echo $U["c_name"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($R["d_site_bg_c"] != ""){ echo "bgcolor=\"".$R["d_site_bg_c"]."\""; } ?> <?php if($R["d_site_bg_p"] != ""){ echo "background=\"".$R["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $R["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $R["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $R["d_top_height"]; ?>" bgcolor="<?php echo $R["d_top_bg_c"]; ?>" background="<?php echo $R["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $R["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $R["d_site_left"]; ?>" bgcolor="<?php echo $R["d_left_bg_c"]; ?>" background="<?php echo $R["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $R["d_site_content"]; ?>" bgcolor="<?php echo $R["d_body_bg_c"]; ?>" height="160" background="<?php echo $R["d_body_bg_p"]; ?>">
	<?php
			$mainwidth = $R["d_site_content"];
			?><?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		<?php } ?>
	
		 <?php
	$BIDN = base64_decode($BID);
	$bid_a = explode("ZY",$BIDN);
	$BIDN = $bid_a[1];
	$sql = $db->query("select block_themes,block_link from block where BID = '".$BIDN."' ");
	$rec = $db->db_fetch_array($sql);
	$x=explode(',',$rec[block_link]);
	$vdo=$x[0];									//link ID  vdo group
	$vdo_WIDTH=$x[1];                //vdo width
	$vdo_HEIGHT=$x[2];              //vdo height
	$vdo_AUTOPLAY=$x[3];                   //vdo play type
	$vdo_LIST=$x[4];
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);

	@include("themesdesign/".$namefolder."/".$namefolder.".php");
	$bg_color1=ereg_replace ("#", "0x", $bg_color);
	$head_color1=ereg_replace ("#", "0x", $head_color);
	$body_color1=ereg_replace ("#", "0x", $body_color);
	$head_font_face1 = ereg_replace ("#", "0x", $head_font_face);
	//if($themes_type == 'F'){
		$buffer = "";
	if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
		$fd = @fopen ($Current_Dir1.$themes_file, "r");
		 while (!@feof ($fd)) {
			$buffer .= @fgets($fd, 4096);
		 }
		@fclose ($fd);
		$design = explode('<?#htmlshow#?>',$buffer);
		$bg_color1=ereg_replace ("#", "0x", '#333333');
		$head_color1=ereg_replace ("#", "0x", '#F8F8F8');
		$body_color1=ereg_replace ("#", "0x", '#FFFFFF');
		$head_font_face1 = ereg_replace ("#", "0x", '#000099');
	 }
	}
		 if($bg_color1 == ''){$bg_color1 = '0x333333';}
	if($head_color1 == ''){$head_color1 = '0xF8F8F8';}
	if($body_color1 == ''){$body_color1 = '0x000000';}
	if($head_font_face1 == ''){$head_font_face1 = '0x000099';}
	if($bg_color == ''){$bg_color = '#333333';}
	if($vdo_WIDTH==''){  $vdo_WIDTH=200; }
	if($vdo_HEIGHT==''){  $vdo_HEIGHT=200; }
	if($vdo_AUTOPLAY==''){  $vdo_AUTOPLAY='N'; }
	if($vdo_LIST=='' || $vdo_LIST=='0'){  $vdo_LIST=''; }else{ $vdo_LIST='LIMIT 0,3';}
// $Current_Dir = "file_vdo/vdo_".$vdo.'.xml';
 //if (file_exists($Current_Dir)) {
	 if($gid){
 	$sql = "SELECT vdog_name FROM vdo_group  WHERE vdog_id = '".$gid."'";
	$query=$db->query($sql);
	$data1=$db->db_fetch_array($query);
	
	$Current_Dir="download/file_vdo/mediaplayer";
	$Current_Dir2="download/file_vdo/mediaplayer";
 ?>
 <?php echo $design[0]; ?>

<script type="text/javascript" src="swfobject.js"></script>
 <table width="<?php echo $bg_width;?>" border="0" cellspacing="0" cellpadding="0" bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" align="center">
  <tr>
      <td colspan="2" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>">
	  
	       <strong><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?>"><?php echo $data1[vdog_name];?></span></font></strong>	  </td>
  </tr> 
  <tr>
    <td rowspan="2" width="480"><table  width="100%" border="0">
 
  <tr>
       <td align="center"> 
	   <?php
			$sql = "SELECT vl.*, vg.vdog_downloadable FROM vdo_list vl JOIN vdo_group vg ON vg.vdog_id=vl.vdo_group WHERE vdo_group = '$gid' ORDER BY vdo_id DESC";
			$offset=$_GET[offset];
			   if (empty($offset) || $offset < 0) { 
					$offset=0; 
				} 
			//    Set $limit,  $limit = Max number of results per 'page' 
			$limit = 3;
			
			//    Set $totalrows = total number of rows that unlimited query would return 
			//    (total number of records to display across all pages) 
			$ExecSel = mysql_query($sql);
			$rows = mysql_num_rows($ExecSel);
			
				// Set $begin and $end to record range of the current page 
				$begin =($offset+1); 
				$end = ($begin+($limit-1)); 
				if ($end > $totalrows) { 
					$end = $totalrows; 
				} 
			$Show = $sql." LIMIT $offset, $limit ";
			
			$Execsql = mysql_query($Show); 
				$data1=$db->db_fetch_array($Execsql);
	  $filetype = explode('.',$data1[vdo_filename]);
				//echo $data1[vdo_filename];

	   ?><script type="text/javascript" src="js/jquery.media.js"></script>
	   <script>

var urlname = document.URL.split("/");
var urlen = (urlname.length - 1);
var myurl = "";
for(i=0;i<urlen;i++){
myurl = myurl + urlname[i] + "/";
}
		    function play(vdoFile, fileName) {
			var url = vdoFile.split(".");
				
				if(url[1] == 'wma' || url[1] == 'wmv'  || url[1] == 'avi'){
				 document.getElementById('SM').innerHTML = '';
				 $(function() {
						$('div.media').media(
						{
						width:<?php echo $vdo_WIDTH;?>, 
						height:<?php echo $vdo_HEIGHT;?>, 
						autoplay: true , 
						src :      vdoFile
						}
						);
					});
					document.getElementById('vdo_detail').innerHTML='รายละเอียด : '+document.getElementById("hdDetail_"+fileName).value;
				}else{
					var s = new SWFObject("media/mediaplayer.swf","single","<?php echo $vdo_WIDTH;?>","<?php echo $vdo_HEIGHT;?>","1");
					s.addParam("allowfullscreen","true");
					s.addVariable("file",myurl + vdoFile);
					//if (previewFile!='') s1.addVariable("image","http://203.154.183.2/ewt/cadweb_2007/vdo/"+previewFile);
					s.addVariable("width","<?php echo $vdo_WIDTH;?>");
					s.addVariable("height","<?php echo $vdo_HEIGHT;?>");
					s.addVariable("autostart","true");
					s.write("SM");
					document.getElementById('vdo_detail').innerHTML='รายละเอียด : '+document.getElementById("hdDetail_"+fileName).value;
				}
			}
	   </script>
	
		<div id="SM"  class="media" ><a href="http://www.macromedia.com/go/getflashplayer"><?php echo $data1[vdo_name];?></a></div>
	  <?php 		if($filetype[1] == 'wmv' || $filetype[1] == 'wma' || $filetype[1] == 'avi'){ ?> 
	  <script>

	   $(function() {
        $('div.media').media(
		{
		width:<?php echo $vdo_WIDTH;?>, 
		height:<?php echo $vdo_HEIGHT;?>, 
		<?php if($vdo_AUTOPLAY=='Y'){?> autoplay: true ,  <?php } ?>
		src :       '<?php echo $data1[vdo_filename];?>'
		}
		);
   		});
	</script>
<?php }else{ ?>
	        <script type="text/javascript">
				var s = new SWFObject("media/mediaplayer.swf","single","<?php echo $vdo_WIDTH;?>","<?php echo $vdo_HEIGHT;?>","1");
				s.addParam("allowfullscreen","true");
				s.addVariable("file",myurl + "<?php echo $data1[vdo_filename];?>");
				s.addVariable("image","<?php echo $data1[vdo_image];?>");
				s.addVariable("width","<?php echo $vdo_WIDTH;?>");
				s.addVariable("height","<?php echo $vdo_HEIGHT;?>");
               <?php if($vdo_AUTOPLAY=='Y'){?>  s.addVariable("autostart","true");  <?php } ?>
				s.write("SM");
			</script>	  <?php } ?> </td>
   </tr>
   
</table>

 <?php
 			}
			$firstDetail=$data1['vdo_detail'];
 ?>
 <table width="100%" border="0">
   <tr  >
     <td  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><li><a href="#view" onClick="play('<?php echo $data1[vdo_filename];?>','<?php echo $data1[vdo_name];?>'); "> <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>"><span id="Bfont" style="font-size: <?php echo $body_font_size;?>"><?php echo $data1[vdo_name];?></span></font> </a></li>
         <input type="hidden" name="hdDetail_<?php echo $data1['vdo_name']; ?>" id="hdDetail_<?php echo $data1['vdo_name']; ?>" value="<?php echo $firstDetail; ?>" />
     </td>
   </tr>
   <?php 
	while($data1=$db->db_fetch_array($Execsql)){ ?>
   <tr  >
     <td  bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><li><a href="#view" onClick="play('<?php echo $data1[vdo_filename];?>','<?php echo $data1[vdo_name];?>'); "> <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>"><span id="Bfont" style="font-size: <?php echo $body_font_size;?>"><?php echo $data1[vdo_name];?></span></font> </a> </li>
         <input type="hidden" name="hdDetail_<?php echo $data1['vdo_name']; ?>2" id="hdDetail_<?php echo $data1['vdo_name']; ?>" value="<?php echo $data1['vdo_detail']; ?>" />
     </td>
   </tr>
   <?php  } ?>
 </table>
 <?php if($rows > 0){ ?>
 <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>"><span id="Bfont" style="font-size: <?php echo $body_font_size;?>"> <font size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong><?php echo $text_general_page;?> :</strong></font>
 <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='more_video.php?offset=$prevoffset&gid=$gid&filename=$filename&BID=$BID'>
<font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< $text_general_previous</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($rows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($rows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">[$i]</font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  " <a href='more_video.php?offset=$newoffset&gid=$gid&filename=$filename&BID=$BID' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a> \n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href='more_video.php?offset=$newoffset&gid=$gid&filename=$filename&BID=$BID'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">$text_general_next>></font></a> "; 
    }
	}
?>
 </span></font></td>
    <td valign="top"><?php echo $design[1]; ?></td>
  </tr>
  <tr>
    <td valign="bottom">&nbsp;</td>
  </tr>
</table>
 <br/>
		<div id="vdo_detail" style="text-align:left; padding:0 10px 0 10px;">รายละเอียด : <?php echo $firstDetail; ?></div>
      </td>
          <td id="ewt_main_structure_right" width="<?php echo $R["d_site_right"]; ?>" bgcolor="<?php echo $R["d_right_bg_c"]; ?>" background="<?php echo $R["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $R["d_bottom_height"]; ?>" bgcolor="<?php echo $R["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $R["d_bottom_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
      </table>

</body>
</html>
<?php $db->db_close(); ?>
