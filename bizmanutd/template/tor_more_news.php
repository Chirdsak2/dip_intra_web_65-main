<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');

if($_GET["filename"] != ""){
	$sql_index = $db->query("SELECT template_id FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
	$XX = $db->db_fetch_array($sql_index);
	$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_id = '$XX[0]'  ");
}else{
	$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
}
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
if($_GET["filename"] == ''){
$_GET["filename"] = 'index';
}
$lang_sh1 = explode('___',$_GET["filename"]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
//$page = 'news';
include("ewt_function.php");
if($use_template != ""){
$d_idtemp =$use_template;
}	

$global_theme = $R["d_bottom_content"];
$mainwidth = "0";
	
	 $temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);
$design_id = $R["d_id"];

	?>
<html>
<head>
<title>TOR</title>
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
			?>
      <!--body-->
	  <?php
	  $db->query("USE db_moc_tor");
	  //config
	  $sql_config =$db->query("select config_row from tor_config where config_id='1'");
	  $C = $db->db_fetch_array($sql_config);
	  $rowconfig = $C["config_row"];
		   if (empty($offset) || $offset < 0) { 
			$offset=0; 
		} 
		//    Set $limit,  $limit = Max number of results per 'page' 
		$limit = $rowconfig;
		if(empty($limit)){
		$limit = 20;
		}
	  
	  
	  $sql_query = "select * from tor_main order by tg_id DESC";
	 $sql = $sql_query." LIMIT $offset,$limit ";	
	  $query = $db->query($sql);
	  ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  class="text_head"> <span style="FONT: 17px 'Tahoma';">ร่างประกาศ TOR</span> <div><hr size="1"></div></td>
  </tr>
  <?php
   $rows = mysql_num_rows($db->query($sql_query));
	$nu = $rows-$offset;
 while($F = $db->db_fetch_array($query)){
  ?>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="1" class="text_normal">
              <tr> 
                <td width="5" valign="top">&nbsp; 
                  </td>
                <td valign="top"><ul><li><a href="tor_news.php?tid=<?php echo $F["tg_id"];?>" target="_blank"> <?php echo $F["tg_name"];?>(<?php echo $F["org_name"];?>)</a><div class="text_normal"><span  style="FONT: 12px 'Tahoma';">วงเงินงบประมาณเบื้องต้น <?php echo number_format($F["tg_budget"]);?> บาท</span></div></li></ul>
				
                </td>
              </tr>
            </table></td>
  </tr>
  <?php  }?>
  <tr>
    <td class="text_normal">
<hr size="1">
<?php echo $text_general_page;?> :    <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($_GET[offset] !=0) {   
$prevoffset=$_GET[offset]-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&filename=$_GET[filename]'>
<font  color=\"red\"><< $text_general_previous</font></a>\n\n";
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
        if (($_GET[offset]/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font color=\"blue\">[$i]</font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  " <a href='$PHP_SELF?offset=$newoffset&filename=$_GET[filename]' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";>$i</a> \n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($_GET[offset]/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href='$PHP_SELF?offset=$newoffset&filename=$_GET[filename]'>
		  <font color=\"red\">$text_general_next>></font></a> "; 
    }
?></td>
  </tr>
</table>

	  <?php $db->query("USE ".$EWT_DB_NAME);?>
	   <!--body-->
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
