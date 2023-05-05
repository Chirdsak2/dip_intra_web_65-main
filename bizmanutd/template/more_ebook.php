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
	
	if($EGID){ $EGID = checkNumeric($EGID); }
	if($_GET["EGID"]){ $_GET["EGID"] = checkNumeric($_GET["EGID"]); }
	if($_POST["EGID"]){ $_POST["EGID"] = checkNumeric($_POST["EGID"]); }
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
	
		<!--Ebook-->
	<?php
if($_GET["EGID"] != ''){
$wh = "AND g_ebook_id ='".$_GET["EGID"]."'";
}
$sql = "select * from ebook_info where show_status='Y'  $wh order by ebook_id DESC,ebook_name ASC";
$query = $db->query ($sql);
$numRows = $db->db_num_rows ($query);
?>
<table width="100%"  border="0" cellpadding="0" cellspacing="0" >
<?php     if($numRows>0){ 
			  while($rec = $db->db_fetch_array($query)){

			  $querypage=$db->query("select ebook_code,ebook_page_file from ebook_page where ebook_code  like '$rec[ebook_code]' ORDER BY ebook_page");
			  $datapage = $db->db_fetch_array($querypage);
			  $sizeOfPage=$db->db_num_rows($querypage);
?>
            <tr > 
			   <td  width="25%" align="center" valign="top">
			   <table width="100" height="100" border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><a href="<?php print "ebook/".$dest.$rec['ebook_code'];?>/index.html" target="_blank" ><img src="phpThumb.php?src=ebook/<?php echo $datapage[ebook_code].'/pages/'.$datapage[ebook_page_file];?>&h=85&w=85" hspace="0" vspace="0" align="middle" border=0></a></td>
  </tr>
</table>
			   </td>
			   <td width="75%" valign="top" class="text_normal"><a href="ebook/<?php print $dest.$rec['ebook_code'];?>/index.html" target="_blank"><font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>"><span class="text_head"><?php echo $rec['ebook_name'];?></span></span></font></a>
			   <br>
			   <br> 
			   <font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span id="Bfont2" style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>">&nbsp; &nbsp; &nbsp; <span class="text_normal"><?php echo $rec['ebook_desc'];?></span></span></font>
			   <br><br><font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>" ><span id="Bfont3" style="font-size: <?php echo $body_font_size3;?><?php  if($body_font_italic3=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold3=='Y'){ ?>;font-weight:bold<?php } ?>"> <span class="text_normal"><?php echo $text_GenEbook_lblsize;?> <?php echo $rec['ebook_w'];?> x <?php echo $rec['ebook_h'];?> <?php echo $text_GenEbook_lblpix;?> <?php echo $sizeOfPage ?>  <?php echo $text_GenEbook_lblpage;?></span>  <br>
                <?php echo $text_GenEbook_lblby;?> <?php echo $rec['ebook_by'];?> <br ><a href="ebook_print.php?ebook_id=<?php echo $rec['ebook_code'];?>" target="_blank"><span class="text_normal">Download File</span></a></span></font>
              </td>
            </tr>
          
         <?php 
			  }
		 }else{?>
		 <tr > 
			   <td  colspan="2" align="center" valign="top"><?php echo $text_GenEbook_notfound;?></td>
        </tr>
		<?php } //if?>
      </table>
	
		<!--Ebook-->
	
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
