<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	@include("../language/language".$lang_sh.".php");
	include("ewt_template.php");
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
 <?php include("ewt_script.php");?>
</head>
<body <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?>>
<table <?php if($F["d_site_width"] != ""){ echo "width=\"".$F["d_site_width"]."\""; } ?> border="0" cellpadding="0" cellspacing="0" <?php if($F["d_site_align"] != ""){ echo "align=\"".$F["d_site_align"]."\""; } ?>>
  <tr>
    <td  <?php if($F["d_top_height"] != ""){ echo "height=\"".$F["d_top_height"]."\""; } ?> <?php  if($F["d_top_bg_c"] != ""){ echo "bgcolor=\"".$F["d_top_bg_c"]."\""; } ?>  colspan="3" >
	  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
	</td>
  </tr>
  <tr>
    <td  valign="top"  <?php if($F["d_site_left"] != ""){ echo "width=\"".$F["d_site_left"]."\""; } ?> <?php  if($F["d_left_bg_c"] != ""){ echo "bgcolor=\"".$F["d_left_bg_c"]."\""; } ?>>
	  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
	
	
	
	</td>
    <td height="160"  valign="top"  <?php if($F["d_site_content"] != ""){ echo "width=\"".$F["d_site_content"]."\""; } ?> <?php  if($F["d_body_bg_c"] != ""){ echo "bgcolor=\"".$F["d_body_bg_c"]."\""; } ?>>
	<?php
			$mainwidth = $F["d_site_content"];
			?>
	
	
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
	
	if($vdo_WIDTH==''){  $vdo_WIDTH=200; }
	if($vdo_HEIGHT==''){  $vdo_HEIGHT=200; }
	if($vdo_AUTOPLAY==''){  $vdo_AUTOPLAY='N'; }
	if($vdo_LIST=='' || $vdo_LIST=='0'){  $vdo_LIST=''; }else{ $vdo_LIST='LIMIT 0,3';}

	 if($gid){
 	$sql = "SELECT vdog_name FROM vdo_group  WHERE vdog_id = '".$gid."'";
	$query=$db->query($sql);
	$data1=$db->db_fetch_array($query);
	
	$Current_Dir="../download/file_vdo/mediaplayer";
	$Current_Dir2="../download/file_vdo/mediaplayer";
 ?>
<script language="javascript" type="text/javascript" src="../swfobject.js"></script>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
      <td colspan="2" ><?php echo $data1[vdog_name];?><hr> </td>
  </tr> 
  <tr>
    <td rowspan="2"><table  width="100%" border="0">
 
  <tr>
       <td align="center">
	   <?php
			$sql = "SELECT * FROM vdo_list  WHERE vdo_group = '$gid' order by vdo_id ASC ";
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
	   ?>
	   <script language="javascript" type="text/javascript"  >

var urlname = document.URL.split("/");
var urlen = (urlname.length - 2);
var myurl = "";
for(i=0;i<urlen;i++){
myurl = myurl + urlname[i] + "/";
}
//alert(myurl);
		    function play(vdoFile) {
				var s = new SWFObject("../media/mediaplayer.swf","single","<?php echo $vdo_WIDTH;?>","<?php echo $vdo_HEIGHT;?>","1");
				s.addParam("allowfullscreen","true");
				s.addVariable("file",myurl + vdoFile);
				//if (previewFile!='') s1.addVariable("image","http://203.154.183.2/ewt/cadweb_2007/vdo/"+previewFile);
				s.addVariable("width","<?php echo $vdo_WIDTH;?>");
				s.addVariable("height","<?php echo $vdo_HEIGHT;?>");
				s.addVariable("autostart","true");
				s.write("player");	
			}
	   </script>
			 <p id="player"><a href="http://www.macromedia.com/go/getflashplayer"><?php echo $data1[vdo_name];?></a></p>
	        <script language="javascript" type="text/javascript" >
				var s = new SWFObject("../media/mediaplayer.swf","single","<?php echo $vdo_WIDTH;?>","<?php echo $vdo_HEIGHT;?>","1");
				s.addParam("allowfullscreen","true");
				s.addVariable("file",myurl + "<?php echo $data1[vdo_filename];?>");
				s.addVariable("image","<?php echo $data1[vdo_image];?>");
				s.addVariable("width","<?php echo $vdo_WIDTH;?>");
				s.addVariable("height","<?php echo $vdo_HEIGHT;?>");
               <?php if($vdo_AUTOPLAY=='Y'){?>  s.addVariable("autostart","true");  <?php } ?>
				s.write("player");
			</script>	   </td>
   </tr>
   
</table>

 <?php } ?>  </td>
    <td valign="top"><table width="100%" border="0">
	 <tr  > 
	    <td >
	       <ul><li><a href="#view" onClick="play('<?php echo $data1[vdo_filename];?>'); ">
			 <?php echo $data1[vdo_name];?></a></li></ul>		</td> 
	</tr>
  <?php 
	while($data1=$db->db_fetch_array($Execsql)){ ?>
    <tr  > 
	    <td  ><a href="#view" onClick="play('<?php echo $data1[vdo_filename];?>'); ">
			 <?php echo $data1[vdo_name];?>
			 </a></td> 
	</tr>
	<?php  } ?>
</table></td>
  </tr>
  <tr>
    <td valign="bottom"><?php if($rows > 0){ ?><?php echo $text_general_page;?> :<?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&gid=$gid&filename=$filename&BID=$BID'>
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
                  echo  " <a href='$PHP_SELF?offset=$newoffset&gid=$gid&filename=$filename&BID=$BID' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a> \n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href='$PHP_SELF?offset=$newoffset&gid=$gid&filename=$filename&BID=$BID'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">$text_general_next>></font></a> "; 
    }
	}
?>
	 </td>
  </tr>
</table>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	</td>
    <td  valign="top"  <?php if($F["d_site_right"] != ""){ echo "width=\"".$F["d_site_right"]."\""; } ?> <?php  if($F["d_right_bg_c"] != ""){ echo "bgcolor=\"".$F["d_right_bg_c"]."\""; } ?>>	 
	 <?php
			$mainwidth =  $F["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?></td>
  </tr>
  <tr valign="top" > 
          <td  colspan="3"  valign="top"  <?php if($F["d_bottom_height"] != ""){ echo "height=\"".$F["d_bottom_height"]."\""; } ?> <?php  if($F["d_bottom_bg_c"] != ""){ echo "bgcolor=\"".$F["d_bottom_bg_c"]."\""; } ?> <?php if($F["d_bottom_bg_p"] != ""){ echo "background=\"".$F["d_bottom_bg_p"]."\""; } ?>>	 
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
</table>
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</body>
</html>
<?php $db->db_close(); ?>