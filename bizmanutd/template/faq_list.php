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
		
	if($f_id){
		$f_id  = checkNumeric($f_id);
	}
	if($_GET[f_id]){
		$_GET[f_id]  = checkNumeric($_GET[f_id]);
	}
	if($_POST[f_id]){
		$_POST[f_id]  = checkNumeric($_POST[f_id]);
	}
	
	if($f_sub_id){
		$f_sub_id  = checkNumeric($f_sub_id);
	}
	if($_GET[f_sub_id]){
		$_GET[f_sub_id]  = checkNumeric($_GET[f_sub_id]);
	}
	if($_POST[f_sub_id]){
		$_POST[f_sub_id]  = checkNumeric($_POST[f_sub_id]);
	}
	//===========================================================
	
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
//include("language/language.php");

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
			if($_GET["orderby"]!=''){
				 $orderby=$_GET["orderby"];
				  if($_GET["adesc"]=='DESC'){  $adesc='ASC';  }else{  $adesc='DESC';  }
				  $orderby_now = "ORDER BY faq_top DESC ,faq_date DESC";
			}else{
				$orderby_now = "ORDER BY  faq_top DESC ,faq_date DESC";
			}
			

//$sel = "SELECT * FROM faq WHERE f_sub_id = '$f_sub_id'   and faq_use='Y'  $seld $orderby_now ";	
 $sel = "SELECT *  FROM  faq  WHERE f_sub_id = '$f_sub_id'   and faq_use='Y'  $seld $orderby_now ";
//$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
//$CO = $db->db_fetch_array($chk_config);
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
<title>FAQ</title>
<?php
include("ewt_script.php");	
?>
<script language="javascript" type="text/javascript">
function orderby(field,adesc){
     
     location.href='faq_list.php?orderby='+field+'&adesc='+adesc+'&f_id=<?php echo $_GET[f_id];?>&f_sub_id=<?php echo $_GET[f_sub_id];?>&filename=<?php echo $_GET[filename];?>';
}
</script>
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

$Execsql1 = $db->query("SELECT * FROM f_subcat  WHERE f_sub_id = '$f_sub_id'");
$QQ= $db->db_fetch_array($Execsql1);
?>
 <tr>
   <td>
       <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
    <td width="40%" valign="top">
	<?php //if($_SESSION["EWT_MID"] != ""){ ?>
	     <a href="#add" onClick="c=window.open('faq_add.php?f_id=<?php echo $f_id?>&f_sub_id=<?php echo $f_sub_id?>','showass1','scrollbars=yes,width=650,height=450');c.focus();"><strong><?php  echo $text_genfaq_question;?></strong></a>
    <?php // } ?>	</td>
    <form name="search_faq" method="post" action="search_result.php"><td width="60%" height="25" align="right" valign="top">
      <!--input type="text" name="keyword" class="styleMe">
	  <input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>">
	  <input name="search_mode" type="hidden" id="search_mode" value="5">
	  <input name="oper" type="hidden" id="oper" value="OR">
      <input type="submit" name="search" value="<?php echo $text_genfaq_buttonsrarch;?>" class="styleMe"-->
    </td></form>
  </tr>
      </table>   </td>
 </tr>
  <tr>
          <td height="260" colspan="2" valign="top" align="center"> <span style="FONT-SIZE: 10pt; COLOR: #993300; FONT-FAMILY: Tahoma"><strong> 
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
	$head_color='#CCCCCC';
	$head_font_size='10pt';
	$bg_color='#6A2B00';
	$Current_Dir1='mainpic/';
	$bg_img='';
	$head_img='toolbars.gif';
	$head_height=30;
	$body_color='#FFFFFF';
	$body_font_color='#000099';
	$body_font_size='10pt';
	$body_font_size2='10pt';
}

	function current_faq_level($fid){
	global $db,$filename,$BID;
	$sql = "select * from f_subcat where f_sub_id = '$fid' ";
	$query = $db->query($sql); 
	$R = $db->db_fetch_array($query);
	if($R[f_id] > 0){  current_faq_level($R[f_parent]); }
	if($fid<>0){
		 echo '<a href="faq_list.php?filename='.$filename.'&f_sub_id='.$R[f_sub_id].'&BID='.$BID.'">'.$R[f_subcate].'</a>';
	}
}
	$f_sub_id=$_GET[f_sub_id] ;
	
	//$Execsql1 = $db->query("SELECT * FROM f_cat  inner join f_subcat  on   f_cat.f_id =f_subcat.f_id WHERE f_sub_id = '$f_sub_id'");
	$Execsql1 = $db->query("SELECT * FROM f_subcat  WHERE f_sub_id = '$f_sub_id'");
	$QQ= $db->db_fetch_array($Execsql1);
	?>
            <p style="width:90%; text-align:left;"><strong><?php echo current_faq_level($f_sub_id)?></strong><br/>
            </p><h1 size="1">
			<?php
			/*$sql_subcat="select * from f_subcat  where f_parent='$QQ[f_parent]'  and f_use='Y'  ORDER BY f_sub_no ASC "  ;
			$query_subcat=$db->query($sql_subcat);
			while($R_SUB=$db->db_fetch_array($query_subcat)){
			    echo '<a href="faq_list.php?filename='.$_REQUEST[filename].'&f_sub_id='.$R_SUB[f_sub_id].' &BID='.$_REQUEST[BID].'"><li>'.$R_SUB[f_subcate].'</li></a>';
			}*/
			?>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
              <tbody>
                <tr> 
                  <td align="center"> <table border="0" width="<?php if($bg_width!= ''){ echo $bg_width;}else{ echo '90%';}?>" align="center" cellpadding="0" cellspacing="0" id="tbbg" >
                      <tr> 
                        <td  align="center"  id="Htdcolor"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" ><font  color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face ;?>"><span  id="Hfont" style="font-size: <?php echo $head_font_size;?>"><strong><?php echo $text_genfaq_question2;?></span></font></td>
                        <td align="center"  id="Htdcolor"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" >
						 
						<font  color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span  id="Hfont" style="font-size: <?php echo $head_font_size;?>"><strong><?php echo $text_genfaq_nummember;?></span></font>
						</td>
                      </tr>
<?php
	  if($rows > 0){
   while($Q = $db->db_fetch_array($Execsql)){	// start while
	?>
                      <tr > 
                        <td width="79%" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"> 
                          <?php if($Q[faq_top] == "Y"){ echo "<img src=\"mainpic/edit_user.gif\" width=\"25\" height=\"25\" align=\"absmiddle\">"; }else{ echo "&diams;&nbsp;"; } ?>
                          &nbsp;<a href="#view"  onClick="c=window.open('faq_open.php?fa_id=<?php echo $Q['fa_id'];?>','showass','scrollbars=yes,width=650,height=450');c.focus();" <?php if($Q[faq_top] == "Y"){ echo "style=\"background-color=\""; } ?>> 
                          <b> <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?>">
                          <?php echo $Q[fa_name]; ?>
                          </span></font> </b></a><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span id="Bfont2" style="font-size: <?php echo $body_font_size2;?>"></span></font></em></td>
                        <td width="18%" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"> 
                          <b> <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?>"><?php $count= $db->query("SELECT fa_id  FROM faq_stat WHERE fa_id = '$Q[fa_id]' ");
   							echo $countrow2 = mysql_num_rows($count);?></span></font></b></td>
                      </tr>
                      <?php }}else{ ?>
                      <tr bgcolor="#F7F7F7"> 
                        <td colspan="2" align="center" bgcolor="#F7F7F7"><font color="#FF0000"><strong><?php echo $text_genfaq_nodetail;?></strong></font></td>
                      </tr>
                      <tr bgcolor="#F7F7F7"> 
                        <td colspan="2" bgcolor="#F7F7F7">&nbsp;</td>
                      </tr>
                      <?php } ?>
                    </table></td>
                </tr>
                <tr> 
                  <td background="images/new_design/krom1_11.jpg"></td>
                </tr>
              </tbody>
            </table>
			<?php  echo $design[1];?> </td>
    </tr>
  <?php if($rows > 0){ ?>
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
