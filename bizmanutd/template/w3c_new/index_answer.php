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
	
	$target = '_self';
$color_websearch = array("#FFFF00","#00FFFF","#6666FF","#FF9999","#CC6633","#999999","#339900");
function CheckTag($temp){
		global $url;
		$temp = stripslashes(htmlspecialchars($temp));
		$temp = eregi_replace ( chr(13), "<br>" , $temp ) ;
		$temp = eregi_replace ( "\[b\]", "<b>" , $temp ) ;
		$temp = eregi_replace ( "\[/b\]", "</b>" , $temp ) ;
		$temp = eregi_replace ( "\[br\]", "<br>" , $temp ) ;
		$temp = eregi_replace ( "\[i\]", "<i>" , $temp ) ;
		$temp = eregi_replace ( "\[/i\]", "</i>" , $temp ) ;
		$temp = eregi_replace ( "\[u\]", "<u>" , $temp ) ;
		$temp = eregi_replace ( "\[/u\]", "</u>" , $temp ) ;
		$temp = eregi_replace ( "\[hr\]", "<hr>" , $temp ) ;
		$temp = eregi_replace ( "\[\-\-\-\]", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" , $temp ) ;
		$temp = eregi_replace ( "\[color=red\]", "<font color=red>" , $temp ) ;
		$temp = eregi_replace ( "\[color=green\]", "<font color=green>" , $temp ) ;
		$temp = eregi_replace ( "\[color=blue\]", "<font color=blue>" , $temp ) ;
		$temp = eregi_replace ( "\[color=orange\]", "<font color=FF6600>" , $temp ) ;
		$temp = eregi_replace ( "\[color=pink\]", "<font color=FF00FF>" , $temp ) ;
		$temp = eregi_replace ( "\[color=gray\]", "<font color=999999>" , $temp ) ;
		$temp = eregi_replace ( "\[/color\]", "</font>" , $temp ) ;
		$temp = eregi_replace ("\[img\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]])\[/img\]", "<img src=\"\\1://\\2\\3\">",$temp ) ;
		$temp = eregi_replace ("\[img1\]([[:alnum:]])\[/img1\]", "<a href=\"../userpic/\\1\" target=\"_blank\"><img src=\"../userpic/\\1\"  width=\"100\" height=\"100\">\\1</a>",$temp ) ;
		$temp = eregi_replace ("\[url\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])\[/url\]","<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>",$temp ) ;
	//	$temp = eregi_replace ("([^[:space:]]*)@([^[:space:]]*)([[:alnum:]])","<a href=\"./mail2me/mail2me.php?wemail=\\1@\\2\\3&name=\\1@\\2\\3\" target=\"_blank\">\\1@\\2\\3</a>",$temp ) ;
		return ( $temp ) ;
	}
	
	function CheckSmile($temp){
		global $url;
		$text = array(
		":sad:",":red:", ":big:", ":ent:", ":shy:", ":sleepy:", ":sun:", ":sg:", ":embarass:", 
		":dead:", ":cool:", ":clown:", ":pukey:", ":eek:", ":roll:", ":smoke:", ":angry:", ":confused:", ":cry:", 
		":lol:", ":yawn:", ":devil:", ":tongue:", ":alien:",":tasty:",":crazy:",":agree:",":disagree:",":bawling:", 
		":crap:",":crying1:",":dunce:",":error:",":evil:",":lookaroundb:",":laugh:",":pimp:",":spiny:",":wavey:",":smash:",":angry:",
		":brain:",":phone:",":zip:",":download:",":beer:",":censore:",":nolove:",":cranium:");

		$pic =array(
		"frown.gif","redface.gif","biggrin.gif","blue.gif","shy.gif","sleepy.gif","sunglasses.gif", "supergrin.gif","embarass.gif",
		"dead.gif","cool.gif","clown.gif","pukey.gif","eek.gif","sarcblink.gif","smokin.gif","reallymad.gif","confused.gif","crying.gif",
		"lol.gif","yawn.gif","devil.gif","tongue.gif","aysmile.gif","tasty.gif","grazy.gif","agree.gif","disagree.gif","bawling.gif",
		"crap.gif","crying1.gif","dunce.gif","error.gif","evil.gif","lookaroundb.gif","laugh.gif","pimp.gif","spiny.gif","wavey.gif","smash.gif","angry.gif",
		"brain.gif","phone.gif","zip.gif","download.gif","beer.gif","censore.gif","nolove.gif","cranium.gif");

		for ($i=0 ; $i<sizeof($text) ; $i++) {
			$temp = eregi_replace($text[$i],"<img src=\"pic/$pic[$i]\">",$temp);
		}
		return($temp);
	}
$db->query("UPDATE w_question SET t_count = t_count + 1 WHERE t_id = '$wtid'");
if($TTYPE !='Y'){
$wh= "AND s_id = '1'";
}

$Execsql = $db->query("SELECT * FROM w_question WHERE t_id = '$wtid' $wh ");
$R = $db->db_fetch_array($Execsql);
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
			
			
			
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
<tr>
    <td height="25">&nbsp;</td>
  </tr>
  <?php
  $Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= $db->db_fetch_array($Execsql1);
if($QQ["c_rss"]=='Y'){
			 $filename01="rss/webboard".$QQ["c_id"].".xml";
			 if(file_exists($filename01)){
			     $link='<a href="rss/webboard'.$QQ["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0" alt="ico_rss.gif"> </a>';
			 }else{
			     $link='';
			 }
		}else{ $link='';
		}
$sql = $db->query("SELECT * FROM w_config WHERE c_config = '1'");

?>
  <tr>
    <td height="25"><?php if($target=='_self'){?>&nbsp;&nbsp;<strong ><a href="m_webboard.php?t=<?php echo $_GET[t];?>&amp;filename=<?php echo $_GET[filename];?>"><span class="text_head"><?php echo $text_genwebboard_pagemain;?></span></a><img src="../mainpic/arrow_r.gif" alt="arrow_r.gif" width="7" height="7" > <a href="index_question.php?wcad=<?php echo $wcad; ?>&amp;t=<?php echo $_GET[t];?>&amp;filename=<?php echo $_GET[filename];?>"><span class="text_normal"><?php echo $QQ[c_name]; ?></span></a>&nbsp;&nbsp;&nbsp;<?php echo $link;?></strong><?php }?></td>
  </tr>
  <tr>
    <td height="25"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="2"><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td ><span class="text_head"> <?php  $name =  stripslashes($R[t_name]);  echo CheckVulgar($name); ?></span></td>
                          <td width="11"><div align="right"><?php if($themes_type != 'F'){ ?><img src="../mainpic/content_r2_c4.gif" width="10" height="23" alt="content_r2_c4.gif"><?php }?></div></td>
                        </tr>
                      </table>
                        <!--#F4F4F4-->
                        <table width="100%"  border="0" align="center" cellpadding="5" cellspacing="2" >
                          <tr>
                            <td colspan="2" width="100%" valign="top" class="text11" bgcolor="white"><!--Content-->
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><!--detail-->
                                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                                          <tr>
                                            <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="171" valign="top"><span class="text_normal"><?php echo $text_genwebboard_by;?> : 
              <?php 
			  $db->query("USE ".$EWT_DB_USER);
		$sql_img = "select * from gen_user where gen_user_id = '$R[user_id]'";
		$query = $db->query($sql_img);
		$rec_img = $db->db_fetch_array($query);
		//$img_port = "../pic_uploads_webboard/".$rec_img[webb_pic];
														if($rec_img[webb_pic] != ""){
													if(file_exists("../../pic_upload_webboard/".$rec_img[webb_pic])){
														$img_port = "../../pic_upload_webboard/".$rec_img[webb_pic];
													}else{
													$img_port = "";
													}
												}
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
			}
			$mail = $rec_img[email_person];
		}
			if(!empty($mail)){ ?>
        <a href="mailto:<?php echo $mail; ?>"><?php echo stripslashes($name_a);?></a><?php if($TTYPE == 'Y' && $admin==$R[user_id]){ echo $name_u. "[".$text_genwebboard_modulater."]";}?>
		 <?php }else{ ?>
        <?php echo stripslashes($name_a);?><?php if($TTYPE == 'Y' && $admin==$R[user_id]){ echo $name_u."[".$text_genwebboard_modulater."]";}?>
        <?php } ?>
              <br> 
              <?php 
		if (file_exists($img_port) && !empty($rec_img[webb_pic])) {
		?>
		<img src="img.php?p=<?php echo base64_encode($img_port); ?>" width="70" height="70" alt="<?php echo base64_encode($img_port); ?>" >
		<?php 
		} ?>
              <br>
              <?php $timer = explode("-",$R[t_date]); 
			  if($lang_sh1[1] != ''){
			  $YearT = $timer[0];
			  }else{
			  $YearT = $timer[0]+543;
			  } 
			  ?>
              <?php 
			  
			  if($X[c_showip]=='Y'){$show_ip='<br>IP: '.$R[t_ip]; }else{$show_ip='';}
			  echo $timer[2]."/".$timer[1]."/".$YearT." ".$R[t_time].$show_ip;?>
			  <br>
			  <?php if($rec_img[post_num] != 0){ echo $text_genwebboard_ans.' : '.$rec_img[post_num];} ?></span>
			  </td>
                                                <td width="10" >&nbsp;</td>
                                                <td valign="top"><?php 
			  
			 
			   $t_detail =  stripslashes($R[t_detail]);
			    $keyword = trim($keyword);
			  $pkw = explode(" ",$keyword);
			  $sum = count($pkw);
				for($q = 0;$q<$sum;$q++){
									if($pkw[$q] != ""){
									$t_detail = ereg_replace($pkw[$q],"<span style=\"background-color:".$color_websearch[$q]."\" >".$pkw[$q]."</span>", $t_detail);
									}
				}
			 ?>
              <?php 
	  if(!empty($R[keyword])){
	  $type_expl = explode('.',$R[keyword]);
	  $a= 1;
		  if(($QQ[c_view_porf] == "2" || $QQ[c_view_porf] == "3" ) AND $_SESSION["EWT_MID"] == ""){
			echo "<table width=\"151\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#000000\">
					  <tr>
						<td bgcolor=\"#FFFFFF\" align=\"center\">".$text_genwebboard_blogfile."</td>
					  </tr>
					</table>";
			}else if($QQ[c_view_porf] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1){
				echo "<table width=\"151\"  border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#000000\">
					  <tr>
						<td bgcolor=\"#FFFFFF\" align=\"center\">".$text_genwebboard_blogfile."</td>
					  </tr>
					</table>";
			}else{
			  if(strtolower($type_expl[$a]) == 'jpg' || strtolower($type_expl[$a]) == 'gif' ||  strtolower($type_expl[$a]) == 'png' || strtolower($type_expl[$a]) == 'bmp'  || strtolower($type_expl[$a]) == 'jpeg'){
				echo  '<br><img src="../userpic/'.$R[keyword].'" border="0" alt="'.$R[keyword].'" >';//<a href="userpic/'.$R[keyword].'" target="_blank">'.$R[keyword].' </a>';
			   echo "<br><br>";
			   }else if(strtolower($type_expl[$a]) == 'swf'){
				echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="400" height="325">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$Globals_Dir.'../userpic/'.$R[keyword].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$Globals_Dir.'../userpic/'.$R[keyword].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="400" height="325"> </embed>
										</object><br><br>';
			   }else{
					
					echo  $text_genwebboard_attactfile.$text_genwebboard_attact.':<br><a href="../userpic/'.$R[keyword].'" target="_blank">'.$R[keyword].' </a><br>';
				
			  }
		  }
	  }
	  $t_detail = eregi_replace("&lt;br&gt;","<br>", $t_detail);
	echo CheckVulgar($t_detail);
	
	  if(!empty($R[t_fign])){
	//  echo "<br><hr><br>".$R[t_fign];
	  }
	   if(!empty($rec_img[fign])){
	   echo "<br><br><div align=\"left\"><hr size=1  width=\"200\"></div>".nl2br($rec_img[fign]);
	  }
	  
	  ?>
                <?php if($TTYPE == 'Y'){ ?>
                <a href="question_function.php?flag=deltopic&amp;wcad=<?php echo $wcad; ?>&amp;wtid=<?php echo $wtid; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename]?>" onClick="return confirm('<?php echo $text_genwebboard_delete;?>?');"><img src="img.php?p=<?php echo base64_encode("../../../images/b_delete.gif"); ?>" alt="<?php echo $text_general_del;?>" border="0" align="absmiddle"></a>
				<?php } ?>
				<?php if($TTYPE == 'Y' || $_SESSION["EWT_MID"] == $R[user_id]){ ?>
				|<a href="editquestion.php?wcad=<?php echo $wcad; ?>&amp;wtid=<?php echo $wtid; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename]?>" target="_blank"><img src="img.php?p=<?php echo base64_encode("../../../images/b_edit.gif"); ?>" alt="<?php echo $text_general_edit;?>" border="0" align="absmiddle"></a>&nbsp;&nbsp;
				<?php } ?>
				<?php if($TTYPE == 'Y'){ ?>
				|&nbsp;<a href="#" onClick="window.open('chang_grouupquestion.php?wcad=<?php echo $wcad; ?>&amp;wtid=<?php echo $wtid; ?>&amp;filename=<?php echo $_GET[filename]?>','keyword','menubar=0,toolbar=0,location=0,scrollbars=1,status=1,width=400,height=250');"><?php echo $text_genwebboard_catboard;?></a> 
                <?php } ?></td>
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
    </table></td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
  <?php 

$ExcAns = $db->query("SELECT * FROM w_answer WHERE t_id = '$wtid' AND s_id = '1'  ORDER BY a_id ASC");
$num = $db->db_num_rows($ExcAns);
$i=1;
while($RR = $db->db_fetch_array($ExcAns)){
?>
  <tr>
    <td height="25"><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td><span class="text_head"><?php echo $text_genwebboard_comment;?> <?php echo $i; ?>:</span></td>
                          <td width="11"><div align="right"><?php if($themes_type != 'F'){ ?><img src="../mainpic/content_r2_c4.gif" width="10" height="23" alt="content_r2_c4.gif"><?php }?></div></td>
                        </tr>
                      </table>
                        <!--#F4F4F4-->
                        <table width="100%" border="0" align="center" cellpadding="5" cellspacing="2" >
                          <tr>
                            <td colspan="2" width="100%" valign="top" class="text11" bgcolor="#FFFFCC"><!--Content-->
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td><!--detail-->
                                        <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">
                                          <tr>
                                            <td align="center"><table width="96%" border="0" cellspacing="0" cellpadding="1">
                                              <tr>
                                                <td width="170" valign="top"><span class="text_normal"><?php echo $text_genwebboard_by;?> :
											  <?php 
												$db->query("USE ".$EWT_DB_USER);
												$sql_img = "select * from gen_user where gen_user_id = '$RR[user_id]'";
												$query = $db->query($sql_img);
												$rec_img = $db->db_fetch_array($query);
												//$img_port = "../pic_uploads_webboard/".$rec_img[webb_pic];
												if($rec_img[webb_pic] != ""){
													if(file_exists("../../pic_upload_webboard/".$rec_img[webb_pic])){
													$img_port = "../../pic_upload_webboard/".$rec_img[webb_pic];
													}else{
													$img_port = "";
													}
												}
												$db->query("USE ".$EWT_DB_NAME);
												if($RR[user_id] == '0'){
													if($RR[a_name] != ""){ 
														$name_a = stripslashes($RR[a_name]); 
														$name_u = "";
														$maia = $RR[q_email];
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
													$maila = $rec_img[email_person];
												}
												/*if($RR[a_name] != ""){ 
													$name_a = stripslashes($RR[a_name]); 
													$name_u = "";
												}else{ 
													$name_a = stripslashes($rec_img[webb_name]); 
													$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
												}*/
											  if($maila !=""){ ?>
											  <a href="mailto:<?php echo $maila; ?>"><?php echo $name_a;?></a><?php if($TTYPE == 'Y' && $admin==$RR[user_id]){ echo $name_u."[".$text_genwebboard_modulater."]";}?>
											  <?php }else{ ?>
											  <?php echo CheckVulgar(stripslashes($name_a)); ?><?php if($TTYPE == 'Y' && $admin==$RR[user_id]){ echo $name_u."[".$text_genwebboard_modulater."]";}?>
											  <?php } ?>
											  <br>
												<?php if (file_exists($img_port) && !empty($rec_img[webb_pic])) { ?>
												<img src="img.php?p=<?php echo base64_encode($img_port); ?>" width="70" height="70" >
												<?php } ?>
											<br>
													  <?php $timer = explode("-",$RR[a_date]);  
													  if($lang_sh1[1] != ''){
													  $YearT = $timer[0];
													  }else{
													  $YearT = $timer[0]+543;
													  } ; ?>
											    <?php 
												if($X[c_showip]=='Y'){$show_ip='<br>IP: '.$RR[a_ip]; }else{$show_ip='';}
												echo $timer[2]."/".$timer[1]."/".$YearT." ".$RR[a_time] .$show_ip; ?><br><?php if($rec_img[post_num] != 0){ echo $text_genwebboard_ans.' : '.$rec_img[post_num];} ?></span></td>
                                                <td width="1" >&nbsp;</td>
                                                <td valign="top"><span class="text_normal"><?php 
	  	 $a_detail =  stripslashes($RR[a_detail]);
			    $keyword = trim($keyword);
			  $pkw = explode(" ",$keyword);
			  $sum = count($pkw);
				for($q = 0;$q<$sum;$q++){
									if($pkw[$q] != ""){
									$a_detail = ereg_replace($pkw[$q],"<span style=\"background-color:".$color_websearch[$q]."\" >".$pkw[$q]."</span>", $a_detail);
									}
				}
		  //$answer_detail = CheckTag($RR[a_detail]);
			//$answer_detail = CheckSmile($answer_detail);
			
		 
	  if(!empty($RR[a_attact])){
	  $type_expl = explode('.',$RR[a_attact]);
	  $a= 1;
	  if(($QQ[c_view_porf] == "2" || $QQ[c_view_porf] == "3" ) AND $_SESSION["EWT_MID"] == ""){
	echo "<table width=\"151\"  border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#000000\">
					  <tr>
						<td background=\"mainpic/no-download.gif\" bgcolor=\"#FFFFFF\" alt=\"no-download.gif\">".$text_genwebboard_blogfile."</td>
					  </tr>
					</table>";

		}else if($QQ[c_view_porf] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1){
			echo "<table width=\"151\"  border=\"0\" cellpadding=\"3\" cellspacing=\"1\" bgcolor=\"#000000\">
					  <tr>
						<td background=\"mainpic/no-download.gif\" bgcolor=\"#FFFFFF\" alt=\"no-download.gif\">".$text_genwebboard_blogfile."</td>
					  </tr>
					</table>";
		}else{
			  if(strtolower($type_expl[$a]) == 'jpg' || strtolower($type_expl[$a]) == 'gif' ||  strtolower($type_expl[$a]) == 'png' || strtolower($type_expl[$a]) == 'bmp'  || strtolower($type_expl[$a]) == 'jpeg'){
				echo  '<br><img src="../userpic/'.$RR[a_attact].'" border="0">';//<a href="userpic/'.$RR[a_attact].'" target="_blank">'.$RR[a_attact].' </a>';
				echo "<br><br>";
			   }else if(strtolower($type_expl[$a]) == 'swf'){
				 echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="400" height="325">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$Globals_Dir.'../userpic/'.$RR[a_attact].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$Globals_Dir.'../userpic/'.$RR[a_attact].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="400" height="325"> </embed>
										</object><br><br>';
			  }else{
					echo  text_genwebboard_attactfile.':<br><a href="../userpic/'.$RR[a_attact].'" target="_blank">'.$RR[a_attact].' </a><br>';
			 }
		 }
	  }
	  $answer_detail = eregi_replace("&lt;br&gt;","<br>", $a_detail);
			echo CheckVulgar(stripslashes($answer_detail));
			
	     if(!empty($rec_img[fign])){
	  echo "<br><br><div align=\"left\"><hr size=1  width=\"200\"></div>".nl2br($rec_img[fign]);
	  }
	  ?>
	                   
	  
                <?php if($TTYPE=='Y'){?>
                <a href="question_function.php?flag=delans&amp;wcad=<?php echo $wcad; ?>&amp;wtid=<?php echo $wtid; ?>&amp;waid=<?php echo $RR[a_id]; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename]?>" onClick="return confirm('<?php echo $text_genwebboard_deletecomment;?>?');"><img src="img.php?p=<?php echo base64_encode("../../images/b_delete.gif"); ?>" alt="<?php echo $text_general_del;?>" border="0" align="absmiddle"></a>
                <?php } ?><?php if($_SESSION["EWT_MID"] == $RR[user_id] ){ ?>
                |<a href="editanswer.php?wcad=<?php echo $wcad; ?>&amp;wtid=<?php echo $wtid; ?>&amp;waid=<?php echo $RR[a_id]; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename]?>" target="_blank"><img src="img.php?p=<?php echo base64_encode("../../images/b_edit.gif"); ?>" alt="<?php echo $text_general_edit;?>" border="0" align="absmiddle"></a>
                <?php } ?>
                <?php if($RR[s_id] !="1" && $TTYPE=='Y' ){ ?>
                <a href="question_function.php?flag=appans&amp;wcad=<?php echo $wcad; ?>&amp;wtid=<?php echo $wtid; ?>&amp;waid=<?php echo $RR[a_id]; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename]?>" onClick="return confirm('<?php echo $text_genwebboard_approve;?>?');"><img src="img.php?p=<?php echo base64_encode("../../images/article_newfile.gif"); ?>" alt="<?php echo $text_genwebboard_approve2;?>" border="0" align="absmiddle"></a> 
                <?php }else if($RR[s_id] =="1" && $TTYPE=='Y'){ ?>
                | <a href="question_function.php?flag=unappans&amp;wcad=<?php echo $wcad; ?>&amp;wtid=<?php echo $wtid; ?>&amp;waid=<?php echo $RR[a_id]; ?>&amp;t=<?php echo $_GET[t]?>&amp;filename=<?php echo $_GET[filename]?>" onClick="return confirm('<?php echo $text_genwebboard_approve3;?>?');"><img src="img.php?p=<?php echo base64_encode("../../images/bar_public.gif"); ?>" alt="<?php echo $text_genwebboard_approve4;?>" border="0" align="absmiddle"></a> 
                <?php } ?>
              </span></td>
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
    </table></td>
  </tr>
  <?php $i++; }?>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top">
	<?php
	if(($QQ[c_view] == "2" || $QQ[c_view] == "3" ) AND $_SESSION["EWT_MID"] == ""){
 
		?>
		<script language="JavaScript" type="text/javascript">
		alert("<?php echo $text_genwebboard_alertlogin;?>");
		top.location.href="ewt_login.php?fn=index_question.php?wcad=<?php echo $wcad; ?>&amp;t=<?php echo $_GET[t];?>";
		</script>
		<?php
		exit;
	}
	if(($QQ[c_view] == "3"   AND $_SESSION["EWT_MID"] != "" AND ($_SESSION["EWT_TYPE_ID"]  != 1)) and $TTYPE != 'Y'){
		?>
		<script language="JavaScript" type="text/javascript">
		alert("<?php echo $text_genwebboard_alertnotview.$TTYPE ;?>vvv");
		window.location.href = "m_webboard.php?t=<?php echo $_GET[t];?>";
		</script>
		<?php
	}
	if(($QQ[c_answer] == "2" || $QQ[c_answer] == "3" ) AND $_SESSION["EWT_MID"] == ""){
		
	}else if(($QQ[c_answer] == "3"   AND $_SESSION["EWT_MID"] != "" AND $_SESSION["EWT_TYPE_ID"]  != 1)  and $TTYPE != 'Y'){
	
	}else {
	?>
       <form name="myForm" enctype="multipart/form-data" method="post" action="question_function.php" onSubmit="return CHK()" target="save_function_form1">
	  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"  class="normal_font">
 
          
          <tr align="center">
            <td  class="head_font"><span class="text_head"><?php echo $text_genwebboard_addcomment ;?> <?php echo $text_genwebboard_addcomment2;?> </span></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td><table width="100%" border="0" cellpadding="2" cellspacing="1" align="center">
                <tr >
                  <td><table border="0" width="100%" cellpadding="2" cellspacing="0">
                      <tr>
                        <td width="30%" align=right valign=top><span class="text_normal"><?php echo $text_genwebboard_detail;?></span><span class="style1">*</span></td>
                        <td><textarea  name="amsg" cols=60 rows= 10 class=orenge></textarea>
                        </td>
                      </tr>
					  <?php if($_SESSION["EWT_MID"] != ""){ ?>
                      <tr >
                        <td width="30%" align="right" ><span class="text_normal"><?php echo $text_genwebboard_attactfile;?></span></td>
                        <td width="70%"><input type="file" name="file">
                          <!--( ไม่เกิน 100 Kb)--> <span class="style1"><?php echo ereg_replace ("<#size#>", $X[c_sizeupload], $text_genwebboard_filesize);?></span></td>
                      </tr>
					  <?php } ?>
                      <?php
		$db->query("USE ".$EWT_DB_USER);
		$sql_img = "select * from gen_user where gen_user_id = '".$_SESSION["EWT_MID"]."'";
		$query = $db->query($sql_img);
		$rec_img = $db->db_fetch_array($query);
		$img_port = "../pic_upload_webboard/".$rec_img[webb_pic];
		$db->query("USE ".$EWT_DB_NAME);
		
		
		 if(empty($rec_img[webb_name])){ 
		 $name_a= stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]);
		 }else{ 
		 $name_a= stripslashes($rec_img[webb_name]); 
		 }
		 if(!empty($rec_img[email_person])){ 
		 $mail= $rec_img[email_person];
		 $read = 'readonly';
		 }else{ 
		 $mail= '';
		  $read = '';
		 }
			?>
                      <tr>
                        <td align=right><span class="text_normal"><?php echo $text_genwebboard_by;?></span><span class="style1">*</span></td>
                        <td><input name="aname" type=text class=orenge value="<?php echo trim($name_a);?>"  size=60 maxlength=50 <?php if($_SESSION["EWT_MID"] != ""){ echo 'readonly';}?>>
                        </td>
                      </tr>
                      <tr>
                        <td align=right><span class="text_normal"><?php echo $text_genwebboard_email;?></span><span class="style1">*</span></td>
                        <td><input  size=60 type=text name="aemail" maxlength=50 class=orenge value="<?php echo $mail;?>" <?php echo $read;?>>
                            <input name="board_id" type="hidden" id="board_id" value="<?php echo $board_id; ?>">
                            <input type="hidden" name="fign" value="<?php echo $rec_img[fign];?>">
							<input type="hidden" name="filename" value="<?php echo $_GET[filename];?>">
                        </td>
                      </tr>
                  </table></td>
                </tr>
                <tr  valign="bottom">
                  <td align=center ><a href="javascript:setURL()"><img src="../pic/link.gif" alt="<?php echo $text_genwebboard_linkurl;?>" width="18" height="17" border=0></a> <a href="javascript:setImage()"><img src="../pic/tree.gif" alt="<?php echo $text_genwebboard_imgurl;?>" width="18" height="17" border=0></a> <a href="javascript:setsmile('[---]')"><img src="../pic/indent.gif" alt="<?php echo $text_genwebboard_indent;?>" width="18" height="17" border=0></a> <a href="javascript:setBold()"><img src="../pic/b.gif" alt="<?php echo $text_genwebboard_b;?>" width="18" height="17" border=0></a> <a href="javascript:setItalic()"><img src="../pic/i.gif" alt="<?php echo $text_genwebboard_i;?>" width="18" height="17" border=0></a> <a href="javascript:setUnderline()"><img src="../pic/u.gif" alt="<?php echo $text_genwebboard_u;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('red','<?php echo $text_genwebboard_redcolor;?>')"><img src="../pic/redcolor.gif" alt="<?php echo $text_genwebboard_redcolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('green','<?php echo $text_genwebboard_greencolor;?>')"><img src="../pic/greencolor.gif" alt="<?php echo $text_genwebboard_greencolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('blue','<?php echo $text_genwebboard_bluecolor;?>')"><img src="../pic/bluecolor.gif" alt="<?php echo $text_genwebboard_bluecolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('orange','<?php echo $text_genwebboard_orangecolor;?>')"><img src="../pic/orangecolor.gif" alt="<?php echo $text_genwebboard_orangecolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('pink','<?php echo $text_genwebboard_pinkcolor;?>')"><img src="../pic/pinkcolor.gif" alt="<?php echo $text_genwebboard_pinkcolor;?>" width="18" height="17" border=0></a> <a href="javascript:setColor('gray','<?php echo $text_genwebboard_graycolor;?>')"><img src="../pic/graycolor.gif" alt="<?php echo $text_genwebboard_graycolor;?>" width="18" height="17" border=0></a>&nbsp;&nbsp;&nbsp;                      </td>
                </tr>
                <tr  id="icon" >
                  <td align=center><?php
						$i=1;
						$sql_emotion = "select * from emotion";
						$query_emotion = $db->query($sql_emotion);
						while($rec_emotion = $db->db_fetch_array($query_emotion)){
						echo "&nbsp;<a href=\"javascript:setsmile('".$rec_emotion[emotion_character]."')\"><img src=\"".$rec_emotion[emotion_img]."\" border=0 ></a>&nbsp;&nbsp;&nbsp;";
						if($i=='10'){
						echo "<br>";
						$i=0;
						}
						$i++;
						}
						?><br>
                     <span class="text_normal"><?php echo $text_genwebboard_text;?></span></td>
                </tr>
            </table></td>
          </tr>
          <?php if($X[c_pic] == "Y"){  ?>
          <?php } ?>
          <tr bgcolor="#FFFFFF">
            <td align="center" ><input type="submit" name="Submit" value="<?php echo $text_general_submit;?>" class="normaltxt">
                <input type="reset" name="Submit2" value="<?php echo $text_general_reset;?>" class="normaltxt">
                <input name="flag" type="hidden"  value="answer">
                <input name="wcad" type="hidden" id="wcad" value="<?php echo $wcad; ?>">
				<input name="themes" type="hidden" id="themes" value="<?php echo $_GET[t]; ?>">
				<input name="filename" type="hidden"  value="<?php echo $_GET[filename]; ?>">
                <input name="wtid" type="hidden" id="wtid" value="<?php echo $wtid; ?>"></td>
          </tr>
        
      </table></form>
		<?php } ?>
	</td>
  </tr>
  <tr>
    <td height="10">&nbsp;</td>
  </tr>
</table>
 <iframe name="save_function_form1" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
			
			
			
			
			
			
	</td>
    <td  valign="top"  <?php if($F["d_site_right"] != ""){ echo "width=\"".$F["d_site_right"]."\""; } ?> <?php  if($F["d_right_bg_c"] != ""){ echo "bgcolor=\"".$F["d_right_bg_c"]."\""; } ?>>	 
	 <?php
			$mainwidth =  $F["d_site_right"];
			?>
<?php
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