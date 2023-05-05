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
	include("ewt_template.php");
	include("../language/language".$lang_sh.".php");
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
			
			
			<table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#FFFFFF">
<?php
$sel = "SELECT * FROM faq WHERE f_sub_id = '$f_sub_id'   and faq_use='Y'  $seld ORDER BY  faq_top DESC ,faq_date DESC";
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
$Execsql1 = $db->query("SELECT * FROM f_subcat WHERE f_sub_id = '$f_sub_id'");
$QQ= $db->db_fetch_array($Execsql1);
?>
 <tr>
   <td>
       <form name="search_faq" method="post" action="search_result.php"><table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
    <td width="40%" valign="top">&nbsp;</td>
    <td width="60%" height="25" align="right" valign="top">
      <input type="text" name="keyword" class="styleMe">
	  <input name="filename" type="hidden"  value="<?php echo $_REQUEST["filename"]; ?>">
	  <input name="search_mode" type="hidden" id="search_mode" value="5">
	  <input name="oper" type="hidden" value="OR">
      <input type="submit" name="search" value="<?php echo $text_genfaq_buttonsrarch;?>" class="styleMe">
    </td>
  </tr>
      </table></form>   </td>
 </tr>
 <tr>
 	<td><a href="#add" onClick="c=window.open('faq_add.php?f_id=<?php echo $f_id?>&amp;f_sub_id=<?php echo $f_sub_id?>','showass1','scrollbars=yes,width=650,height=450');c.focus();"><strong><?php  echo $text_genfaq_question;?></strong></a></td>
 </tr>
  <tr>
          <td height="260" colspan="2" valign="top"> 
            <?php
	
$sql = $db->query("select * from block where BID = '".$_GET[BID]."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];
		
	
	function current_faq_level($fid){
	global $db,$filename;
	$sql = "select * from f_subcat where f_sub_id = '$fid' ";
	$query = $db->query($sql); 
	$R = $db->db_fetch_array($query);
	if($R[f_id] > 0){  current_faq_level($R[f_parent]); }
	if($fid<>0){
		 echo ' => <a href="faq_list.php?filename='.$filename.'&amp;f_sub_id='.$R[f_sub_id].'">'.$R[f_subcate].'</a>';
	}
}
	$f_sub_id=$_GET[f_sub_id] ;
	
	$Execsql1 = $db->query("SELECT * FROM f_subcat  WHERE f_sub_id = '$f_sub_id'");
	$QQ= $db->db_fetch_array($Execsql1);
	?>
            <?php echo $text_genfaq_catfaq;?> "<strong><?php echo current_faq_level($f_sub_id)?></strong>"
			<?php
			$sql_subcat="select * from f_subcat where f_parent='$QQ[f_sub_id]'  and f_use='Y'  ORDER BY f_sub_no ASC "  ;
			$query_subcat=$db->query($sql_subcat);
			if($db->db_num_rows($query_subcat)>0){
			echo "<ul>";
			while($R_SUB=$db->db_fetch_array($query_subcat)){
			    echo '<li><a href="faq_list.php?filename='.$filename.'&amp;f_sub_id='.$R_SUB[f_sub_id].'">'.$R_SUB[f_subcate].'</a></li>';
			}
			echo "</ul>";
			}
			?>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
              <tbody>
                <tr> 
                  <td align="center"> <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC"   id="tbbg" >
                      <tr> 
                        <td  align="center" bgcolor="#FFFFFF"  ><?php echo $text_genfaq_question2;?></td>
                        <td align="center" bgcolor="#FFFFFF"  ><?php echo $text_genfaq_nummember;?></td>
                      </tr>
                      <?php
	  if($rows > 0){
   while($Q = $db->db_fetch_array($Execsql)){ 
	?>
                      <tr > 
                        <td width="79%" align="left" bgcolor="#FFFFFF" > 
                          <?php if($Q[faq_top] == "Y"){ echo "<img src=\"../mainpic/edit_user.gif\" width=\"25\" height=\"25\"  alt =\"icon user\">"; }else{ echo "&diams;&nbsp;"; } ?>
                          &nbsp;<a href="#view"  onClick="c=window.open('faq_open.php?fa_id=<?php echo $Q['fa_id'];?>','showass','scrollbars=yes,width=650,height=450');c.focus();" <?php if($Q[faq_top] == "Y"){ echo "style=\"background-color=\""; } ?>> 
                          <b> <?php echo $Q[fa_name]; ?></b></a><br> 
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?php echo substr($Q[faq_date],8,2); ?>-<?php echo substr($Q[faq_date],5,2); ?>-<?php echo substr($Q[faq_date],0,4); ?> 
                          <?php echo substr($Q[faq_date],11,8); ?> <?php echo $text_genfaq_questionby;?> 
                          : <?php echo $Q[fa_user_ask]; ?></em> 
                          <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?php echo substr($Q[faq_dateans],8,2); ?>-<?php echo substr($Q[faq_dateans],5,2); ?>-<?php echo substr($Q[faq_dateans],0,4); ?> 
                          <?php echo substr($Q[faq_dateans],11,8); ?> <?php echo $text_genfaq_answerby;?> 
                        : <?php echo $Q[fa_user_ans]; ?></em></td>
                        <td width="18%" align="center" bgcolor="#FFFFFF" > 
                          <?php $count= $db->query("SELECT fa_id  FROM faq_stat WHERE fa_id = '$Q[fa_id]' ");
   							echo $countrow2 = mysql_num_rows($count);?>                        </td>
                      </tr>
                      <?php }}else{ ?>
                      <tr bgcolor="#F7F7F7"> 
                        <td colspan="2" align="center" bgcolor="#FFFFFF"><font color="#FF0000"><strong><?php echo $text_genfaq_nodetail;?></strong></font></td>
                      </tr>
                      <tr bgcolor="#F7F7F7"> 
                        <td colspan="2" bgcolor="#F7F7F7">&nbsp;</td>
                      </tr>
                      <?php } ?>
                    </table></td>
                </tr>
                <tr> 
                  <td ></td>
                </tr>
              </tbody>
            </table>
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
echo   "<a href='$PHP_SELF?offset=$prevoffset&amp;f_id=$f_id&amp;f_sub_id=$f_sub_id&amp;filename=$filename&BID=$BID'>
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
                  echo  "<a href='$PHP_SELF?offset=$newoffset&amp;f_id=$f_id&amp;f_sub_id=$f_sub_id&amp;filename=$filename&BID=$BID' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&amp;f_id=$f_id&amp;f_sub_id=$f_sub_id&amp;filename=$filename&BID=$BID' >
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\"> ".$text_general_next.">></font></a>"; 
    }
?></td>
  </tr>
</table></td>
    </tr>
  <?php } ?>
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