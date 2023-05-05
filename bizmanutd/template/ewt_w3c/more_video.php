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
	$db->access=200;
?>
<?php echo $template_design[0];?>
<?php
			$mainwidth = $F["d_site_content"];
			?>
	
	
	<?
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
      <td colspan="2" ><h1><?php echo $data1[vdog_name];?></h1><hr> </td>
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

 <? } ?>  </td>
    <td valign="top"><table width="100%" border="0">
	 <tr  > 
	    <td >
	       <ul><li><a href="#view" onClick="play('<?php echo $data1[vdo_filename];?>'); " accesskey=<?php echo $db->genaccesskey();?>>
			 <?php echo $data1[vdo_name];?></a></li></ul>		</td> 
	</tr>
  <?php 
	while($data1=$db->db_fetch_array($Execsql)){ ?>
    <tr  > 
	    <td  ><a href="#view" onClick="play('<?php echo $data1[vdo_filename];?>'); " accesskey=<?php echo $db->genaccesskey();?>>
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
echo   "<a href='$PHP_SELF?offset=$prevoffset&gid=$gid&filename=$filename&BID=$BID' accesskey=".$db->genaccesskey().">
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
                  "onMouseOver=\"window.status='Page $i'; return true\"; accesskey=".$db->genaccesskey()."><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a> \n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href='$PHP_SELF?offset=$newoffset&gid=$gid&filename=$filename&BID=$BID' accesskey=".$db->genaccesskey().">
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">$text_general_next>></font></a> "; 
    }
	}
?>
	 </td>
  </tr>
</table>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>