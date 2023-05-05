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

$Execsql = $db->query("SELECT * FROM w_cate WHERE c_use = 'Y' ORDER BY c_level,c_id ASC");

$row = mysql_num_rows($Execsql);
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
			
			
			
			<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		 <tr>
            <td width="50%"><form name="formSearchWEBB" method="post" action="search_result.php?filename=<?php echo $filename; ?>&amp;search_mode=4" target="_blank">
			<table border="0" cellpadding="3" cellspacing="0" class="styleMe">
                <tr>
                  <td align="left"><input type="text" name="keyword" class="styleMe">
                    <input type="submit" name="search2" value="<?php echo $text_genwebboard_buttom_search;?>" class="styleMe"></td>
                </tr>
            </table>
			</form>
			</td>
            <td width="50%" align="right">
			</td>
		 </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="2">
                          
                            <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
                              
                          <tr> 
                            <td colspan="2" width="100%" valign="top" class="text11" >
							<table width="100%" border="0" align="left" cellpadding="3" cellspacing="0">
                                                    <tr>
                                                      <td colspan="4"  >
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td align="center"><span class="text_head"><?php echo $text_genwebboard_cat;?></span></td>
           <td width="20%" align="center"><span class="text_head"><?php echo $text_genwebboard_numqu;?></span></td>
           <td width="20%" align="center"><span class="text_head"><?php echo $text_genwebboard_numanw;?></span></td>
         </tr>
       </table></td>
                                                    </tr>
                                                    <tr>
                                                      
                                              <td colspan="2"  height="3"></td>
                                                    </tr>
													<?php
													 if($row > 0){
													   while($R = $db->db_fetch_array($Execsql)){ 
													   if($lang_sh != ''){
													   $R[c_name] = $R[lang_detail];
													   $R[c_detail] = select_lang_detail($R[c_id],$lang_shw,"c_detail",w_cate);
													   }
													   if($R["c_rss"]=='Y'){
																 $filename="rss/webboard".$R["c_id"].".xml";
																 if(file_exists($filename)){
																	 $link='<a href="rss/webboard'.$R["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0" alt="RSS";> </a>';
																 }else{
																	 $link='';
																 }
															}else{ $link='';
															}
													 $count = $db->query("SELECT * FROM w_question WHERE c_id = '$R[c_id]' AND s_id = '1' AND t_date >= '$dateshowl'");
   $countrow = mysql_num_rows($count);
  $count1 = $db->query("SELECT DISTINCT(w_answer.a_id) FROM w_answer,w_question WHERE w_question.t_id = w_answer.t_id AND w_question.c_id = '$R[c_id]' AND w_answer.s_id = '1' ");
   $countrow1 = mysql_num_rows($count1);
   ?>
    <tr onMouseOver="this.style.backgroundColor='#E7E7E7'" onMouseOut="this.style.backgroundColor='<?php echo $body_color;?>'"  > 
      <td width="4%" align="center" valign="top"><br >
        <?php if($R[c_view] == "Y"){ ?><img src="../mainpic/lock.gif" width="24" height="24" alt="lock.gif"><?php }else{ ?><img src="../mainpic/book_blue.gif" width="24" height="24" alt="book_blue.gif"><?php } ?></td>
      
    <td  valign="top" >
	 <a href="index_question.php?wcad=<?php echo $R[c_id]; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename];?>" target="<?php echo $target;?>" ><span class="text_normal"><?php  echo stripslashes($R[c_name]); ?></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $link;?>
     	<span class="text_normal"><?php  echo stripslashes(nl2br ($R[c_detail])); ?></span></td>
      <td width="20%" align="center"><span class="text_normal"><?php echo $countrow; ?></span></td>
      <td width="20%"  align="center"><span class="text_normal"><?php echo $countrow1; ?></span></td>
    </tr>
													<?php } } ?>
                                                </table></td>
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