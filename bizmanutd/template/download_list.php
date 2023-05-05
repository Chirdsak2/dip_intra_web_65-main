<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
//include("language/language.php");
include("lib/utilities_function.php");

if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
$lang_sh = explode('___',$F[filename]);
			if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
			include("language/language".$lang_sh.".php");
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);
$design_id = $R["d_id"];

$mainwidth = 0;
$global_theme = $R["d_bottom_content"];

 $sel = "SELECT * FROM docload_list WHERE dl_dlgid = '$f_sub_id'  AND dl_open='Y' ORDER BY dl_createdate";
//$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
//$CO = mysql_fetch_array($chk_config);
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
//$limit = $CO[c_number];
$limit =20;
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = $db->query($Show); 
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Download</title>
<?php
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($R["d_site_bg_c"] != ""){ echo "bgcolor=\"".$R["d_site_bg_c"]."\""; } ?> <?php if($R["d_site_bg_p"] != ""){ echo "background=\"".$R["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $R["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $R["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $R["d_top_height"]; ?>" bgcolor="<?php echo $R["d_top_bg_c"]; ?>" background="<?php echo $R["d_top_bg_p"]; ?>" colspan="3" id="ewt_main_structure_top">
			<?php
			$mainwidth = $R["d_site_width"];
			?>
		  <?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $R["d_site_left"]; ?>" bgcolor="<?php echo $R["d_left_bg_c"]; ?>" background="<?php echo $R["d_left_bg_p"]; ?>">
		<?php
		$mainwidth = $R["d_site_left"];
		?>
		  <?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $R["d_site_content"]; ?>" bgcolor="<?php echo $R["d_body_bg_c"]; ?>" height="160" background="<?php echo $R["d_body_bg_p"]; ?>">
		<?php
		$mainwidth = $R["d_site_content"];
		?>
<?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		
      <?php } ?>
 
 
 
 
 
 
 
 
 
 
<?php  echo $design[0];?>
<table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#FFFFFF" class="styleMe">
<?php
$Execsql1 = $db->query("SELECT * FROM f_subcat WHERE f_sub_id = '$f_sub_id'");
$QQ= mysql_fetch_array($Execsql1);
?>
 <tr>
   <td>
       <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
    <td width="40%" valign="top">	</td>
	<form name="formSearchFile" method="post" action="search_download.php?filename=<?php echo $_REQUEST["filename"];?>">
	<td width="60%" height="25" align="right" valign="top">
      <input type="text" name="keyword" class="styleMe"> 
	  <input name="search_mode" type="hidden" id="search_mode" value="1">
	  <input name="oper" type="hidden" id="oper" value="OR">
      <input type="submit" name="search" value="ค้นหาไฟล์เอกสาร" class="styleMe" onClick="return chkSchButt(document.formSearchFile.keyword)">
    </td>
	</form>
	<script>    function chkSchButt(c){   if(c.value!=''){ return true; }else{ return false;}  } </script>
  </tr>
  <tr>
    <td  >	</td>
    <td align="right"><a href="search_download_adv.php">ค้นหาขั้นสูง</a></td>
  </tr>
      </table>   </td>
 </tr>
  <tr>
          <td height="260" colspan="2" valign="top"> <span style="FONT-SIZE: 10pt; COLOR: #993300; FONT-FAMILY: Tahoma"><strong> 
            <?php
	
$sql = $db->query("select * from block where BID = '".$_GET[BID]."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];
			if($rec[block_themes] !=0){
				$themes = $rec[block_themes];
			}else{
				$themes = $global_theme;
			}
if($themes!= '0' && $themes != ''){
		$namefolder = "themes".($themes);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		 //if($themes_type == 'F'){
				$buffer = "";
			if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
		
}else{
	$head_font_color='#666666';
	$bg_color='#6A2B00';
	$Current_Dir1='mainpic/';
	$bg_img='';
	$head_img='toolbars.gif';
	$head_height=30;
	$body_color='#FFFFFF';
	$body_font_color='#000099';
}
	
	function current_level($fid){
	global $db;
	$sql = "select * from docload_group where dlg_id = '$fid' ";
	//echo  $sql;
	$query = $db->query($sql); 
	$R = mysql_fetch_array($query);
	if($R[dlg_id] > 0){  current_level($R[dlg_parent]); }
	if($fid<>0){
		 echo ' > <a href="download_list.php?filename='.$filename.'&f_sub_id='.$R[dlg_id].'">'.$R[dlg_name].'</a>';
	}
}
	$f_sub_id=$_GET[f_sub_id] ;
	
	//$Execsql1 = $db->query("SELECT * FROM f_cat  inner join f_subcat  on   f_cat.f_id =f_subcat.f_id WHERE f_sub_id = '$f_sub_id'");
	$Execsql1 = $db->query("SELECT * FROM docload_group WHERE dlg_id = '$f_sub_id' ");
	$QQ= $db->db_fetch_array($Execsql1);
	?>
            <a href="main.php?filename=<?php echo $filename ?>">ดาวน์โหลด</a>
			<strong>	<?php 	echo current_level($f_sub_id); ?></strong><hr>
			<?php
            $sql_subcat="select * from docload_group where dlg_parent='$QQ[dlg_id]'  ORDER BY dlg_name ASC "  ;
			$query_subcat=$db->query($sql_subcat);
			while($R_SUB=$db->db_fetch_array($query_subcat)){
			   $kount++;
			    echo '<a href="download_list.php?filename='.$filename.'&f_sub_id='.$R_SUB[dlg_id].'"><li>'.$R_SUB[dlg_name].'</li></a>';
			}
			if($kount>0){ echo "<br><br>";}
			?>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
              <tbody>
                <tr> 
                  <td align="center"> <table border="0" width="<?php if($bg_width!= ''){ echo $bg_width;}else{ echo '90%';}?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" id="tbbg" >
                      <tr> 
                        <td  align="center"  id="Htdcolor"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font  color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span  id="Hfont" style="font-size: <?php echo $head_font_size;?>"><strong>ชื่อเอกสาร</span></font></td>
                        <td align="center"  id="Htdcolor"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font  color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span  id="Hfont" style="font-size: <?php echo $head_font_size;?>"><strong>ขนาด (KB.)</span></font></td>
                        <td align="center"  id="Htdcolor"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font  color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span  id="Hfont" style="font-size: <?php echo $head_font_size;?>"><strong>จำนวนโหลด</span></font></td>
                      </tr>
                      <?php
	  if($rows > 0){
   while($Q = $db->db_fetch_array($Execsql)){ 
	?>
                      <tr > 
                        <td width="79%" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"> 
                          <?php if($Q[dl_type] == "jpg" || $Q[dl_type] == "gif" || $Q[dl_type] == "png"  || $Q[dl_type] == "jpeg"  || $Q[dl_type] == "bmp" ){ 
						       $filepath="download_doc/dl_".$Q[dl_dlgid]."/$Q[dl_name]";
						        //echo "<img src=\"$filepath\"  height=\"50\" align=\"absmiddle\"><br>"; 
								?><img src="phpThumb.php?src=<?php echo $filepath;?>&h=80&w=80" border="1"><br><?php
							  }//else{ 
							  echo "&diams;&nbsp;";
							  // } ?>
                          &nbsp;<a href="#view"  onClick="c=window.open('download_detail.php?dl_id=<?php echo $Q['dl_id'];?>','showass','scrollbars=yes,width=650,height=450');c.focus();" <?php if($Q[faq_top] == "Y"){ echo "style=\"background-color=\""; } ?>> 
                          <b> <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?>">
                          <?php echo $Q[dl_name]; ?><br><?php echo $Q[dl_detail]; ?>
                          </span></font> </b></a><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span id="Bfont2" style="font-size: <?php echo $body_font_size2;?>">วันที่สร้าง : <?php echo date_display($Q[dl_createdate],'YmdHis','DT3Th');?></span></font></em> 
                          <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span id="Bfont2" style="font-size: <?php echo $body_font_size2;?>">วันที่แก้ไขล่าสุด : <?php echo date_display($Q[dl_update],'YmdHis','DT3Th');?></span></font></em></td>
                        <td width="18%" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><?php echo number_format($Q[dl_filesize]/1024,2); ?></td>
                        <td width="18%" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img*1;?>"><?php echo number_format($Q[dl_count],0); ?></td>
                      </tr>
                      <?php }}else{ ?>
                      <tr bgcolor="#F7F7F7"> 
                        <td colspan="3" align="center" bgcolor="#F7F7F7"><font color="#FF0000"><strong>No category found in Download</strong></font></td>
                      </tr>
                      <tr bgcolor="#F7F7F7"> 
                        <td colspan="3" bgcolor="#F7F7F7">&nbsp;</td>
                      </tr>
                      <?php } ?>
                    </table></td>
                </tr>
                <tr> 
                  <td background="images/new_design/krom1_11.jpg"></td>
                </tr>
              </tbody>
            </table>
			<?php  echo $design[1];?> 
			
			
			
			
			
			
			
			</td>
    </tr>
  <?php  if($rows > 0){ ?>
  <tr>
    <td height="25" colspan="2" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><strong><?php echo $text_general_page;?> :</strong>      <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&f_id=$f_id&f_sub_id=$f_sub_id&filename=$filename&BID=$BID'>
<font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ".$text_general_previous."</font></a>\n\n";
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
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">[ $i ] </font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&f_id=$f_id&f_sub_id=$f_sub_id&filename=$filename&BID=$BID' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&f_id=$f_id&f_sub_id=$f_sub_id&filename=$filename&BID=$BID' >
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\"> ".$text_general_next.">></font></a>"; 
    }
?></td>
  </tr>
</table></td>
    </tr>
  <?php } ?>
</table>    </td>
          <td id="ewt_main_structure_right" width="<?php echo $R["d_site_right"]; ?>" bgcolor="<?php echo $R["d_right_bg_c"]; ?>" background="<?php echo $R["d_right_bg_p"]; ?>">	  
		<?php
		$mainwidth = $R["d_site_right"];
		?>
		<?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?>		  </td>
        </tr>
        <tr valign="top" > 
          <td  id="ewt_main_structure_bottom" height="<?php echo $R["d_bottom_height"]; ?>" bgcolor="<?php echo $R["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $R["d_bottom_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_width"];
			?>
			<?php
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
