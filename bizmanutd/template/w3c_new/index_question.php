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
		include($path."language/language".$lang_sh.".php");
	include("ewt_template.php");
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
<?php include("ewt_script.php");?>
  <script language="JavaScript"  type="text/javascript">
function orderby(field,adesc){
     
     location.href='index_question.php?orderby='+field+'&amp;adesc='+adesc+'&amp;wcad=<?php echo $wcad;?>&amp;TTYPE=<?php echo $TTYPE?>&amp;filename=<?php echo  $filename?>';
}
</script>
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

			<table width="98%" border="0" align="center" cellpadding="0" cellspacing="2">
	   <tr>
        <td width="50%"><form name="formSearchWEBB" method="post" action="search_result.php?filename=<?php echo $filename; ?>&amp;search_mode=4" target="<?php echo $target;?>"><table border="0" cellpadding="3" cellspacing="0" class="styleMe">
          
            <tr>
              <td align="right"><input type="text" name="keyword" class="styleMe">
                  <input type="submit" name="search" value="<?php echo $text_genwebboard_buttom_search; ?>" class="styleMe">              </td>
            </tr>
          
        </table></form></td>
	   </tr>
	   <?php
	     $target = '_self';
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = $db->db_fetch_array($chk_config);

  if($TTYPE !='Y'){
	$wh= "AND w_question.s_id = '1'";
	}
	
$subsql='';
if($orderby==''){
    $orderby='t_id';
	$adesc='DESC';
}else{
     $orderby=$orderby;
	  if($orderby=='answers'){
	       $subsql=",  (SELECT COUNT(a_id) FROM w_answer WHERE t_id = w_question.t_id AND s_id = '1') as answers";
	  }//t_count
	  if($adesc=='DESC'){  $adesc='ASC';  }else{  $adesc='DESC';  }
}
$sel = "SELECT * $subsql  FROM  w_question  WHERE w_question.c_id = '$wcad'  $wh ORDER BY  $orderby  $adesc"; 
?>



<?php
//echo  $sel;
function CheckVulgar($msg){
$BanWord="***";
$Sql="SELECT * FROM vulgar_table";
$ExecSql=  mysql_query($Sql);
$total=mysql_num_rows($ExecSql);
if($total>0){
while($R=$db->db_fetch_array($ExecSql)){
$Vtext=$R['vulgar_text'];
$msg=eregi_replace($Vtext,$BanWord,$msg);
}
}
return $msg;
}

   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = $CO[c_number];
if(empty($limit)){
$limit = 10;
}
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

$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= $db->db_fetch_array($Execsql1);

if($QQ["c_rss"]=='Y'){
			 $filename01="rss/webboard".$QQ["c_id"].".xml";
			 if(file_exists($filename01)){
			     $link='<a href="rss/webboard'.$QQ["c_id"].'.xml" target="_blank"><img src="../mainpic/ico_rss.gif" border="0" alt="ico_rss.gif"> </a>';
			 }else{
			     $link='';
			 }
		}else{ $link='';
		}
if(($QQ[c_view] == "2" || $QQ[c_view] == "3" ) AND $_SESSION["EWT_MID"] == ""){
 
?>
<script language="JavaScript"  type="text/javascript">
alert("<?php echo $text_genwebboard_alertlogin;?>");
top.location.href="ewt_login.php?fn=index_question.php?wcad=<?php echo $wcad; ?>&amp;t=<?php echo $_GET[t];?>";
</script>
<?php
exit;
}
if(($QQ[c_view] == "3"   AND $_SESSION["EWT_MID"] != "" AND ($_SESSION["EWT_TYPE_ID"]  != 1)) and $TTYPE != 'Y'){
?>
<script language="JavaScript"  type="text/javascript">
alert("<?php echo $text_genwebboard_alertnotview;?>");
window.location.href = "m_webboard.php?t=<?php echo $_GET[t];?>";
</script>
<?php
}
	?>
      <tr>
        <td colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="2"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td height="23">&nbsp;&nbsp;<strong ><a href="m_webboard.php?t=<?php echo $_GET[t];?>&amp;filename=<?php echo $_GET[filename];?>"><span class="text_head"><?php echo $text_genwebboard_pagemain;?></span></a><img src="../mainpic/arrow_r.gif" width="7" height="7" alt="arrow_r.gif"> <a href="index_question.php?wcad=<?php echo $wcad; ?>&amp;t=<?php echo $_GET[t];?>&amp;filename=<?php echo $_GET[filename];?>"><span class="text_normal"><?php echo $QQ[c_name]; ?></span></a>&nbsp;&nbsp;&nbsp;<?php echo $link;?></strong></td>
                          <td width="11"><div align="right"><?php if($themes_type != 'F'){ ?><img src="../mainpic/content_r2_c4.gif" width="10" height="23" alt="content_r2_c4.gif"><?php }?></div></td>
                        </tr>
                      </table>
                        <!--#F4F4F4-->
                        <table  width="100%"  border="0" align="center" cellpadding="3" cellspacing="2" >
						 <tr >
                                <td colspan="2" valign="top"><a href="addquestion.php?wcad=<?php echo $wcad; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename];?>"><img src="../mainpic/contact.gif" width="16" height="16" border="0" alt="contact.gif"><span class="text_head"><font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size:<?php echo $head_font_size2;?>"><?php echo $text_genwebboard_newboard;?></span></font></span></a></td>
                          </tr>
                          <tr>
                            <td colspan="2" width="100%" valign="top" class="text11" ><!--Content-->
                                <table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><!--detail-->
                                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                                          <tr>
                                            <td align="center" ><table width="100%" border="0" align="left" cellpadding="4" cellspacing="0">
                                            <tr> 
                                              <td colspan="2" align="left" ><strong><span class="text_normal"><?php echo $text_genwebboard_headboard;?></span></strong></td>
                                              <td width="20%" align="center" ><strong><span class="text_normal"><?php echo $text_genwebboard_bypost;?></span></strong></td>
                                              <td width="5%" align="center" ><a href="javascript:orderby('t_count','<?php echo $adesc;?>')"><strong><span class="text_normal"><?php echo $text_genwebboard_byread;?></span></strong></a></td>
                                              <td width="5%" align="center" ><a href="javascript:orderby('answers','<?php echo $adesc;?>')"><?php echo $text_genwebboard_numanw;?></a></td>
                                              <td width="20%" align="center" ><?php echo $text_genwebboard_RepliesLate;?></td>
                                            </tr>
                                            <tr> 
                                              <td colspan="6" bgcolor="#DEDCDE" height="1"></td>
                                            </tr>
                                            <?php
											  if($rows > 0){
											  $nu = $rows - $offset;
											   while($R = $db->db_fetch_array($Execsql)){ 
											    $db->query("USE ".$EWT_DB_USER);
													$sql_img = "select * from gen_user where gen_user_id = '$R[user_id]'";
													$query = $db->query($sql_img);
													$rec_img = $db->db_fetch_array($query);
													
													$db->query("USE ".$EWT_DB_NAME);
											 if($R[user_id] == '0'){
												if($R[q_name] != ""){ 
													$name_a = stripslashes($R[q_name]); 
													$name_u = "";
													$mail = $R[q_email];
												}
											}else{
												if($rec_img[webb_name] != ''){
													$name_a = stripslashes($rec_img[webb_name]); 
													$name_u = "";
												}else{
													$name_a = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
													$name_u = "";
													//$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
												}
												$mail = $rec_img[email_person];
											}
											   $count = $db->query("SELECT * FROM w_answer WHERE t_id = '$R[t_id]' AND s_id = '1' ORDER BY a_id DESC");
											   $countrow = mysql_num_rows($count);
											   $Z = $db->db_fetch_array($count);
											   $timer = explode("-",$R[t_date]); 
											    if($lang_sh1[1] != ''){
													  $YearT = $timer[0];
													  }else{
													  $YearT = $timer[0]+543;
													  } ;
											    $db->query("USE ".$EWT_DB_USER);
												$sql_img = "select * from gen_user where gen_user_id = '$Z[user_id]'";
												$query = $db->query($sql_img);
												$rec_img = $db->db_fetch_array($query);
												$db->query("USE ".$EWT_DB_NAME);
												if($Z[user_id] == '0'){
													if($Z[a_name] != ""){ 
														$name_aa = stripslashes($Z[a_name]); 
														$name_ua = "";
														$mail2 = $Z[a_email];
													}
												}else{
													if($rec_img[webb_name] != ''){
														$name_aa = stripslashes($rec_img[webb_name]); 
														$name_ua = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
													}else{
														$name_aa = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
														$name_ua = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
														//$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
													}
													$mail2 = $rec_img[email_person];
												}
											   ?>
                                            <tr> 
                                              <td  width="5%" valign="top"><img src="../mainpic/edit_user.gif" alt="edit_user.gif"></td>
                                              <td valign="top"><a href="index_answer.php?wcad=<?php echo $wcad; ?>&amp;wtid=<?php echo $R[t_id]; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename];?>" target="<?php echo $target;?>"><?php  $name =  stripslashes($R[t_name]);  echo CheckVulgar($name); ?></a></td>
                                              <td align="center" valign="top"> 
                                              <?php  echo stripslashes($name_a); ?> <?php if(!empty($mail)){ ?><a href="mailto:<?php echo $mail; ?>"><img src="../mainpic/m_mail.gif" border="0" alt="<?php echo $mail; ?>"></a><?php } ?>
                                                <br>  (<?php echo $timer[2]."/".$timer[1]."/".$YearT." ".$R[t_time]; ?>)</td>
                                              <td align="center" valign="top"><?php echo $R[t_count]; ?></td>
                                              <td align="center" valign="top"><?php echo $countrow; ?></td>
                                              <td align="center" valign="top"> 
                                                <?php if($countrow > 0){ ?>
                                                <div><?php echo stripslashes($name_aa); ?><?php if(!empty($mail2)){ ?><a href="mailto:<?php echo $mail2; ?>"><img src="../mainpic/m_mail.gif" border="0" alt="<?php echo $mail2; ?>"></a><?php } ?></div>
                                               ( 
                                                <?php $timer = explode("-",$Z[a_date]); 
													 if($lang_sh1[1] != ''){
													  $YearT = $timer[0];
													  }else{
													  $YearT = $timer[0]+543;
													  } ; ?>
                                                <?php echo $timer[2]."/".$timer[1]."/".$YearT." ".$Z[a_time]; ?> 
                                                )
                                                <?php }else{ echo "<center>-</center>"; } ?>                                       </td>
                                            </tr>
                                            <tr> 
                                              <td colspan="6" bgcolor="#DEDCDE" height="1"></td>
                                            </tr>
                                            <?php $nu--; }}else{ ?>
                                            <tr > 
                                              <td height="30" colspan="11"><div align="center"><strong><?php echo $text_genwebboard_nodata;?></strong></div></td>
                                            </tr>
                                            <?php } ?>
                                            <tr > 
                                              <td height="30" colspan="11"><?php echo $text_general_page;?>: 
                                                <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&amp;wcad=$wcad&amp;t=".$_GET[t]."&amp;filename=".$_GET[filename]."'>
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
                  echo  "<a href='$PHP_SELF?offset=$newoffset&amp;wcad=$wcad&amp;t=".$_GET[t]."&amp;filename=".$_GET[filename]."' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&amp;wcad=$wcad&amp;t=".$_GET[t]."&amp;filename=".$_GET[filename]."'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">".$text_general_next.">></font></a>"; 
    }
?>                                              </td>
                                            </tr>
                                          </table></td>
                                          </tr>
                                        </table>
                                      <!--detail-->                                    </td>
                                  </tr>
                                </table>
                              <!--Content-->                            </td>
                          </tr>
                      </table></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
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