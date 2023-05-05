<?php
$path = "../";
	session_start();
	if($_GET["SSMID"]!=''){
	$_SESSION["EWT_MID"] = $_GET["SSMID"];
	}
	$_SESSION["EWT_MAIL"] = $_GET["SSMAIL"];
	$_SESSION["EWT_ORG"] = $_GET["SSorg"];
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
		include($path."language/language".$lang_sh.".php");
include("ewt_template.php");
	$db->access=200;
	function CheckVulgar($msg){
$BanWord="***";
$Sql="SELECT * FROM vulgar_table";
$ExecSql=  mysql_query($Sql);
$total=mysql_num_rows($ExecSql);
if($total>0){
while($R=mysql_fetch_array($ExecSql)){
$Vtext=$R['vulgar_text'];
$msg=eregi_replace($Vtext,$BanWord,$msg);
}
}
return $msg;
}

$Execsql = $db->query("SELECT * FROM w_cate WHERE c_use = 'Y' ORDER BY c_level,c_id ASC");

$row = mysql_num_rows($Execsql);
?><?php echo $template_design[0];?>
<?php
			$mainwidth = $F["d_site_content"];
			?>
			
			
			
			<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		 <tr>
            <td width="50%"><form name="formSearchWEBB" method="post" action="search_result.php?filename=<?php echo $filename; ?>&amp;search_mode=4" target="_blank">
			<table border="0" cellpadding="3" cellspacing="0" class="styleMe">
                <tr>
                  <td align="left"><input type="text" name="keyword" class="styleMe" alt="Search">
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
           <td align="center"><h2><span class="text_head"><?php echo $text_genwebboard_cat;?></span></h2></td>
           <td width="20%" align="center"><h2><span class="text_head"><?php echo $text_genwebboard_numqu;?></span></h2></td>
           <td width="20%" align="center"><h2><span class="text_head"><?php echo $text_genwebboard_numanw;?></span></h2></td>
         </tr>
       </table></td>
                                                    </tr>
                                                    <tr>
                                                      
                                              <td colspan="2"  height="3"></td>
                                                    </tr>
													<?php
													 if($row > 0){
													   while($R = mysql_fetch_array($Execsql)){ 
													   if($lang_sh != ''){
													   $R[c_name] = $R[lang_detail];
													   $R[c_detail] = select_lang_detail($R[c_id],$lang_shw,"c_detail",w_cate);
													   }
													   if($R["c_rss"]=='Y'){
																 $filename="rss/webboard".$R["c_id"].".xml";
																 if(file_exists($filename)){
																	 $link='<a href="rss/webboard'.$R["c_id"].'.xml" target="_blank" accesskey=a><img src="mainpic/ico_rss.gif" border="0" alt="RSS";> </a>';
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
        <? if($R[c_view] == "Y"){ ?><img src="../mainpic/lock.gif" width="24" height="24" alt="lock.gif"><? }else{ ?><img src="../mainpic/book_blue.gif" width="24" height="24" alt="book_blue.gif"><? } ?></td>
      
    <td  valign="top" >
	 <a href="index_question.php?wcad=<? echo $R[c_id]; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename];?>" target="<?php echo $target;?>" accesskey=<?php echo $db->genaccesskey();?>><span class="text_normal"><?php  echo stripslashes($R[c_name]); ?></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $link;?>
     	<span class="text_normal"><?php  echo stripslashes(nl2br ($R[c_detail])); ?></span></td>
      <td width="20%" align="center"><span class="text_normal"><? echo $countrow; ?></span></td>
      <td width="20%"  align="center"><span class="text_normal"><? echo $countrow1; ?></span></td>
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
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>
