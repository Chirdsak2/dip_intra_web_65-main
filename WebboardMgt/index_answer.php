<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
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
		$temp = eregi_replace ( "\[\-\-\-\]", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" , $temp ) ;
		$temp = eregi_replace ( "\[color=red\]", "<font color=red>" , $temp ) ;
		$temp = eregi_replace ( "\[color=green\]", "<font color=green>" , $temp ) ;
		$temp = eregi_replace ( "\[color=blue\]", "<font color=blue>" , $temp ) ;
		$temp = eregi_replace ( "\[color=orange\]", "<font color=FF6600>" , $temp ) ;
		$temp = eregi_replace ( "\[color=pink\]", "<font color=FF00FF>" , $temp ) ;
		$temp = eregi_replace ( "\[color=gray\]", "<font color=999999>" , $temp ) ;
		$temp = eregi_replace ( "\[/color\]", "</font>" , $temp ) ;
		$temp = eregi_replace ("\[img\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]])\[/img\]", "<img src=\"\\1://\\2\\3\">",$temp ) ;
		$temp = eregi_replace ("\[url\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])\[/url\]","<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>",$temp ) ;
		$temp = eregi_replace ("([^[:space:]]*)@([^[:space:]]*)([[:alnum:]])","<a href=\"./mail2me/mail2me.php?wemail=\\1@\\2\\3&name=\\1@\\2\\3\" target=\"_blank\">\\1@\\2\\3</a>",$temp ) ;
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
			$temp = eregi_replace($text[$i],"<img src=\"./pic/$pic[$i]\">",$temp);
		}
		return($temp);
	}
$db->query("UPDATE w_question SET t_count = t_count + 1 WHERE t_id = '$wtid'");
$Execsql = $db->query("SELECT * FROM w_question WHERE t_id = '$wtid' ");
$R = mysql_fetch_array($Execsql);
//$answer_detail = CheckTag($R[t_detail]);
//$answer_detail = CheckSmile($answer_detail);

 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript" src="../scripts/innovaeditor.js"></script>
<script language="javascript" src="../ewt/thailand/js/AjaxRequest.js"></script>


<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>


<body leftmargin="0" topmargin="0">
<?php
$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);	
$Execsql1 = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$QQ= mysql_fetch_array($Execsql1);

  if( $db->check_permission("webboard","a",$wcad) ||  $db->check_permission("webboard","a",0)){ $pass_a='Y';   }
    if( $db->check_permission("webboard","g",$wcad) ||  $db->check_permission("webboard","g",0) ){ $pass_g='Y';   }
?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td> <span class="ewtfunction"><a href="index_cate.php"><img src="../theme/main_theme/logo.gif" border="0" width="32" height="32" align="absmiddle">หน้าหลักกระทู้</a> <img border="0" src="../wb_pic/arrow_r.gif" width="7" height="7" align="absmiddle"> <a href="index_question.php?wcad=<?php echo $wcad; ?>"><?php echo $QQ[c_name]; ?></a></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp;<hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="1" class="ewttableuse">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="25" valign="top" bgcolor="#E7E7E7"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr align="center" class="ewttablehead">
                        <td align="left"><font class=size3><span class="mytext_bold2 style3">หัวข้อกระทู้ :
                          <?php biz($R[t_name]); ?>
                          </span></font></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                  <tr>
                    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#E7E7E7">
						<?php
						
					 			$db->query("USE ".$EWT_DB_USER);
								$sql_img = "select * from gen_user where gen_user_id = '".$R[user_id]."'";
								$query = $db->query($sql_img);
								$rec_img = $db->db_fetch_array($query);
								$img_port = "../ewt/pic_upload_webboard/".$rec_img[webb_pic];
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
													$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
												}else{
													$name_a = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
													$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
												}
												$mail = $rec_img[email_person];
											}
					?>		
                        <tr>
                          <td width="29%" valign="top" bgcolor="#FFFFCC">โดย :
                            <?php if($mail !=""){ ?>
                            <a href="mailto:<?php echo $mail; ?>"><?php echo $name_a.$name_u; ?></a><?php if($TTYPE == 'Y' && $admin==$RR[user_id]){ echo "[ผู้ดูแลระบบ]";}?>
                            <?php }else{ ?>
                            <?php echo $name_a.$name_u; ?><?php if($TTYPE == 'Y' && $admin==$RR[user_id]){ echo "[ผู้ดูแลระบบ]";}?>
                            <?php } ?>
                              <br>
							  <?php 
							   
							  $folder_pic = "../ewt/pic_upload_webboard/";
							if (file_exists($img_port) && !empty($rec_img[webb_pic])) {
							?>
							<img src="img.php?p=<?php echo base64_encode($img_port); ?>" width="70" height="70" >
							<?php 
							} ?>
							<br>
                            - 
                            <?php $timer = explode("-",$R[t_date]); $YearT = $timer[0]+543; ?>
                            <?php echo $timer[2]."/".$timer[1]."/".$YearT." ".$R[t_time]; ?><br>
                          - IP:<?php echo $R[t_ip]; ?><br><?php if($rec_img[post_num] != 0){ echo 'ตอบ : '.$rec_img[post_num];} ?></td>
                          <td valign="top" bgcolor="#FFFFFF"><?php 
						     $t_detail =  stripslashes($R[t_detail]);
			   
						  if(!empty($R[keyword])){
						  $type_expl = explode('.',$R[keyword]);
						  $a= 1;
						  if(strtolower($type_expl[$a]) == 'jpg'  || strtolower($type_expl[$a]) == 'gif' ||  strtolower($type_expl[$a]) == 'png' || strtolower($type_expl[$a]) == 'bmp'){
							echo  '<br><img src="'.$Globals_Dir.'userpic/'.$R[keyword].'" border="0" >';//<a href="userpic/'.$R[keyword].'" target="_blank">'.$R[keyword].' </a>';
						   echo "<br><br>";
						   }else if(strtolower($type_expl[$a]) == 'swf'){
						    echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="400" height="325">
								  <param name="flash_component" value="ImageViewer.swc" />
								  <param name="movie" value="'.$Globals_Dir.'userpic/'.$R[keyword].'" />
								  <param name="quality" value="high" />
								  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
								  <embed src="'.$Globals_Dir.'userpic/'.$R[keyword].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="400" height="325"> </embed>
								</object>';
								echo "<br><br>";
						   }else{
							echo  'เอกสารแนบ:<br><a href="'.$Globals_Dir.'userpic/'.$R[keyword].'" target="_blank">'.$R[keyword].' </a>';
						  }
						  }
						  $t_detail = eregi_replace("&lt;br&gt;","<br>", $t_detail);
						echo biz($t_detail);
						
						  if(!empty($R[t_fign])){
						  echo "<br><hr><br>".$R[t_fign];
						  }
						   if(!empty($rec_img[fign])){
						  echo "<br><br><div align=\"left\"><hr size=1  width=\"200\"></div>".nl2br($rec_img[fign]);
						  }
						  ?>						  </td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="3%" height="25" valign="bottom" bgcolor="#E7E7E7">&nbsp;</td>
                    <td width="94%" align="right" bgcolor="#E7E7E7">
					<?php if($pass_g=='Y'){ ?>
					<a href="question_function.php?flag=deltopic&wcad=<?php echo $wcad; ?>&wtid=<?php echo $R[t_id]; ?>" onClick="return confirm('คุณแน่ใจที่จะลบกระทู้นี้?');"><img src="../theme/main_theme/g_del.gif" alt="ลบทั้งหัวข้อนี้" width="16" height="16"  border="0"></a><a href="question_function.php?flag=deltopic&wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>" onClick="return confirm('Are you sure to delete?');"></a> | <a href="#" onClick="popo=window.open('chang_grouupquestion.php?wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>','popug','width=500,height=250,scrollbars=1,resizable=1');popo.focus();">จัดหมวดหมู่คำถาม</a>
					<?php }?></td>
                    <td width="3%" align="right" valign="bottom" bgcolor="#E7E7E7">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
</table>
<br>
     <?php 
	 
$ExcAns = $db->query("SELECT * FROM w_answer WHERE t_id = '$wtid' ORDER BY a_id ASC");
$i = $db->db_num_rows($ExcAns);
$b=1;
?>
            <br>
            <table width="94%" border="0" align="center" cellpadding="0" cellspacing="1" class="ewttableuse">
              <tr>
                <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="<?php echo  $bgc; ?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="3%" height="25" valign="top" bgcolor="#E7E7E7">&nbsp;</td>
                            <td width="94%" bgcolor="#E7E7E7">&nbsp;</td>
                            <td width="3%" align="right" valign="top" bgcolor="#E7E7E7">&nbsp;</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td bgcolor="<?php print $bgc; ?>"><table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td>
                                <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                  <?php while($RR = mysql_fetch_array($ExcAns)){ 
											  $db->query("USE ".$EWT_DB_USER);
												$sql_img = "select * from gen_user where gen_user_id = '$RR[user_id]'";
												$query = $db->query($sql_img);
												$rec_img = $db->db_fetch_array($query);
												$img_port = "../ewt/pic_upload_webboard/".$rec_img[webb_pic];
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
														$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
													}else{
														$name_a = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
														$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
														//$name_u = "<br>[". stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai])."]";
													}
													$maila = $rec_img[email_person];
												}
												?>
								  <tr>
                                    <td width="30%" rowspan="4" valign="top" bgcolor="#FFFFCC">โดย :
                                      <?php if($maila !=""){ ?>
                                        <a href="mailto:<?php echo $maila; ?>"><?php echo $name_a.$name_u; ?></a><?php if($TTYPE == 'Y' && $admin==$RR[user_id]){ echo "[ผู้ดูแลระบบ]";}?>
                                        <?php }else{ ?>
                                        <?php echo $name_a.$name_u; ?><?php if($TTYPE == 'Y' && $admin==$RR[user_id]){ echo "[ผู้ดูแลระบบ]";}?>
                                        <?php } ?>
                                        <br>
										<?php 
										  //$folder_pic = "../ewt/".$EWT_FOLDER_USER."/";
										 
										  $folder_pic = "../ewt/pic_upload_webboard/";
										if (file_exists($img_port) && !empty($rec_img[webb_pic])) { ?>
										<img src="img.php?p=<?php echo base64_encode($img_port); ?>" width="70" height="70" >
										<?php } ?>
										<br>
                                      - 
                                      <?php $timer = explode("-",$RR[a_date]); $YearT = $timer[0]+543; ?>
                                      <?php echo $timer[2]."/".$timer[1]."/".$YearT." ".$RR[a_time]; ?><br>
                                    - IP:<?php echo $RR[a_ip]; ?><br><?php if($rec_img[post_num] != 0){ echo 'ตอบ : '.$rec_img[post_num];} ?></td>
                                    <td width="70%"><strong>ความเห็นที่ <?php echo $b; ?></strong></td>
                                    <td width="16%">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php 
										$a_detail = eregi_replace("&lt;br&gt;","<br>", $RR[a_detail]);
					 ?>
					                  <?php 
						  if(!empty($RR[a_attact])){
					  $type_expl = explode('.',$RR[a_attact]);
					  $a= 1;
					 if(strtolower($type_expl[$a]) == 'jpg'  || strtolower($type_expl[$a]) == 'gif' ||  strtolower($type_expl[$a]) == 'png' || strtolower($type_expl[$a]) == 'bmp'){
					 	echo  '<br><img src="'.$Globals_Dir.'userpic/'.$RR[a_attact].'" border="0">';//<a href="userpic/'.$RR[a_attact].'" target="_blank">'.$RR[a_attact].' </a>';
						echo "<br><br>";
					  }else if(strtolower($type_expl[$a]) == 'swf' ){
					  echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="400" height="325">
								  <param name="flash_component" value="ImageViewer.swc" />
								  <param name="movie" value="'.$Globals_Dir.'userpic/'.$RR[a_attact].'" />
								  <param name="quality" value="high" />
								  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
								  <embed src="'.$Globals_Dir.'userpic/'.$RR[a_attact].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="400" height="325"> </embed>
								</object>';
								echo "<br><br>";
					  }else{
						echo  'เอกสารแนบ:<br><a href="'.$Globals_Dir.'userpic/'.$RR[a_attact].'" target="_blank">'.$RR[a_attact].' </a>';
					  }
					  }
					  $answer_detail = eregi_replace("&lt;br&gt;","<br>", $a_detail);
							 print biz($a_detail);
							
						 if(!empty($rec_img[fign])){
					  echo "<br><br><div align=\"left\"><hr size=1  width=\"200\"></div>".nl2br($rec_img[fign]);
					  }
						  ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"> 
									<?php
									 $sql_vote = "select * from w_vote where a_id = '$RR[a_id]'";
									   $query_vote = $db->query($sql_vote);
									   if($db->db_num_rows($query_vote)>0){
									
									 ?>
									<br><br>
									<iframe name="vote_body" src="w_vote.php?a_id=<?php echo $RR[a_id];?>"  frameborder="0"  width="30%" height="70" scrolling="no"></iframe>
							<?php 
							}		?>
                     </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" align="right" valign="bottom">
<?php if($pass_g=='Y'){?>
									<a href="faq_function.php?flag=send&wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>&waid=<?php echo $RR[a_id]; ?>"><img src="../images/bar_complain.gif" alt="ส่งออก FAQ" width="20" height="20" border="0" align="absmiddle">|</a><a href="question_function.php?flag=delans&wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>&waid=<?php echo $RR[a_id]; ?>" onClick="return confirm('คุณแน่ใจที่จะลบความคิดเห็นนี้?');"><img src="../theme/main_theme/g_del.gif" alt="ลบความเห็นนี้" width="16" height="16" border="0" align="absmiddle"></a>
<?php  } if($pass_a=='Y'){?>|
                                      <?php if($RR[s_id] !="1"){ ?>
                                        <a href="question_function.php?flag=appans&wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>&waid=<?php echo $RR[a_id]; ?>" onClick="return confirm('คุณต้องการอนุมัติ?');"><img src="../theme/main_theme/g_add_document.gif" alt="อนุมัติความเห็นนี้" width="16" height="16" border="0" align="absmiddle"></a>
                                        <?php }else{ ?>
                                    <a href="question_function.php?flag=unappans&wcad=<?php echo $wcad; ?>&wtid=<?php echo $wtid; ?>&waid=<?php echo $RR[a_id]; ?>" onClick="return confirm('คุณต้องการยกเลิกการอนุมัติ?');"><img src="../theme/main_theme/g_approve.gif" alt="คลิ๊กเพื่อยกเลิกการอนุมัตื" width="16" height="16" border="0" align="absmiddle"></a><?php } 
}?></td>
                                  </tr>
                                  <tr>
                                    <td height="0" bgcolor="#FFFFCC"><hr></td>
                                    <td height="0" colspan="2"><hr></td>
                                  </tr>  
								  <?php $b++;}
									if(($i) == 0){
									 ?>  <tr>  <td height="0" colspan="3" align="center" class="ewthead">ไม่มีผู้แสดงความคิดเห็น</td>
									  </tr><?php
									}
									?>
                              </table>
 



 </td>
                          </tr>
						  
                      </table></td>
                    </tr>
                    <tr>
                      <td bgcolor="<?php echo $bgc; ?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="3%" height="25" valign="bottom" bgcolor="#E7E7E7">&nbsp;</td>
                            <td width="94%" bgcolor="#E7E7E7">&nbsp;</td>
                            <td width="3%" align="right" valign="bottom" bgcolor="#E7E7E7">&nbsp;</td>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
            </table>
            <br>
              <form name="myForm" enctype="multipart/form-data" method="post" action="question_function.php" onSubmit="return CHK()" target="save_function_form1">
              <table width="500" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF" class="ewttableuse" >
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="ewttablehead">
                        <td height="25" align="center" class="MemberHead">เชิญร่วมตอบคำถาม</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width=100% border=0 cellpadding=2 cellspacing=1 align="center">
                      <tr >
                        <td bgcolor="#FFFFFF" ><table border=0 width=100% cellpadding="2" cellspacing="0">
                            <tr>
                              <td align=right valign=top><div align="right"><b><font color="686898">ความคิดเห็น</font></b></div></td>
                              <td><textarea  name="amsg" cols=45 rows= 5 class=orenge></textarea>
                              </td>
                            </tr>
							<tr >
							  <td width="20%" align="right" ><b><font color="686898">เอกสารแนบ</font></b></td>
							  <td width="80%"><input type="file" name="file">
						      <span class="style1">(ขนาดไฟล์ต้องไม่เกิน <?php echo $CO[c_sizeupload];?> KB.)</span></td>
							</tr>
                            <tr>
                              <td align=right>
                                  <b><font color="686898">โดย</font></b></span></td>
                              <td><input  size=47 type=text name="aname" maxlength=50 class=orenge value="<?php echo $_SESSION['EWT_SMUSER']; ?>" readonly="true">
                              </td>
                            </tr>
                            <tr>
                              <td align=right>
                                  <b><font color="686898">E-mail</font></b></span></td>
                              <td><input  size=35 type=text name="aemail" maxlength=50 class=orenge>
                                  <input name="board_id" type="hidden" id="board_id" value="<?php echo $board_id; ?>">
                              </td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr  valign="bottom">
                        <td align=center bgcolor="#FFFFFF" ><a href="javascript:setURL()"><img src="../WebboardMgt/pic/link.gif" border=0 alt="แทรกลิงค์ URL"></a> <a href="javascript:setImage()"><img src="../WebboardMgt/pic/tree.gif" border=0 alt="แทรกรูป"></a> <a href="javascript:setsmile('[---]')"><img src="../WebboardMgt/pic/indent.gif" border=0 alt="ย่อหน้า"></a> <a href="javascript:setBold()"><img src="../WebboardMgt/pic/b.gif" border=0 alt="ตัวหนา"></a> <a href="javascript:setItalic()"><img src="../WebboardMgt/pic/i.gif" border=0 alt="ตัวเอียง"></a> <a href="javascript:setUnderline()"><img src="../WebboardMgt/pic/u.gif" border=0 alt="เส้นใต้"></a> <a href="javascript:setColor('red','แดง')"><img src="../WebboardMgt/pic/redcolor.gif" border=0 alt="สีแดง"></a> <a href="javascript:setColor('green','เขียว')"><img src="../WebboardMgt/pic/greencolor.gif" border=0 alt="สีเขียว"></a> <a href="javascript:setColor('blue','น้ำเงิน')"><img src="../WebboardMgt/pic/bluecolor.gif" border=0 alt="สีน้ำเงิน"></a> <a href="javascript:setColor('orange','ส้ม')"><img src="../WebboardMgt/pic/orangecolor.gif" border=0 alt="สีส้ม"></a> <a href="javascript:setColor('pink','ชมพู')"><img src="../WebboardMgt/pic/pinkcolor.gif" border=0 alt="สีชมพู"></a> <a href="javascript:setColor('gray','เทา')"><img src="../WebboardMgt/pic/graycolor.gif" border=0 alt="สีเทา"></a>&nbsp;&nbsp;&nbsp;
                            <!--<input type="button" name="Button" value="แสดง icon" onClick="document.getElementById('icon').style.display='';">
                          &nbsp;
                          <input type="button" name="Button" value="ปิด icon" onClick="document.getElementById('icon').style.display='none';"> style="display:none"--></td>
                      </tr>
                      <tr bgcolor="#FFDEAD" id="icon">
                        <td align=center bgcolor="#FFFFFF">
						<?php
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
						?>
						
						
						<!--<a href="javascript:setsmile(':angry:')"><img src="../WebboardMgt/pic/angry.gif" border=0 width="15" height="15"></a> <a href="javascript:setsmile(':sad:')"><img src="../WebboardMgt/pic/frown.gif" border=0></a> <a href="javascript:setsmile(':red:')"><img src="../WebboardMgt/pic/redface.gif" border=0></a> <a href="javascript:setsmile(':big:')"><img src="../WebboardMgt/pic/biggrin.gif" border=0></a> <a href="javascript:setsmile(':ent:')"><img src="../WebboardMgt/pic/blue.gif" border=0></a> <a href="javascript:setsmile(':shy:')"><img src="../WebboardMgt/pic/shy.gif" border=0></a> <a href="javascript:setsmile(':sleepy:')"><img src="../WebboardMgt/pic/sleepy.gif" border=0></a> <a href="javascript:setsmile(':sun:')"><img src="../WebboardMgt/pic/sunglasses.gif" border=0></a> <a href="javascript:setsmile(':sg:')"><img src="../WebboardMgt/pic/supergrin.gif" border=0></a> <a href="javascript:setsmile(':embarass:')"><img src="../WebboardMgt/pic/embarass.gif" border=0></a> <a href="javascript:setsmile(':dead:')"><img src="../WebboardMgt/pic/dead.gif" border=0></a> <a href="javascript:setsmile(':cool:')"><img src="../WebboardMgt/pic/cool.gif" border=0></a> <a href="javascript:setsmile(':clown:')"><img src="../WebboardMgt/pic/clown.gif" border=0></a> <a href="javascript:setsmile(':pukey:')"><img src="../WebboardMgt/pic/pukey.gif" border=0></a> <a href="javascript:setsmile(':eek:')"><img src="../WebboardMgt/pic/eek.gif" border=0></a> <a href="javascript:setsmile(':roll:')"><img src="../WebboardMgt/pic/sarcblink.gif" border=0></a> <a href="javascript:setsmile(':smoke:')"><img src="../WebboardMgt/pic/smokin.gif" border=0></a> <a href="javascript:setsmile(':angry:')"><img src="../WebboardMgt/pic/reallymad.gif" border=0></a> <a href="javascript:setsmile(':confused:')"><img src="../WebboardMgt/pic/confused.gif" border=0></a> <a href="javascript:setsmile(':cry:')"><img src="../WebboardMgt/pic/crying.gif" border=0></a> <a href="javascript:setsmile(':lol:')"><img src="../WebboardMgt/pic/lol.gif" border=0></a> <a href="javascript:setsmile(':yawn:')"><img src="../WebboardMgt/pic/yawn.gif" border=0></a> <a href="javascript:setsmile(':devil:')"><img src="../WebboardMgt/pic/devil.gif" border=0></a> <a href="javascript:setsmile(':brain:')"><img src="../WebboardMgt/pic/brain.gif" border=0 width="17" height="15"></a> <a href="javascript:setsmile(':phone:')"><img src="../WebboardMgt/pic/phone.gif" border=0 width="9" height="24"></a> <a href="javascript:setsmile(':zip:')"><img src="../WebboardMgt/pic/zip.gif" border=0 width="14" height="14"></a><br>
                            <a href="javascript:setsmile(':tongue:')"><img src="../WebboardMgt/pic/tongue.gif" border=0></a> <a href="javascript:setsmile(':alien:')"><img src="../WebboardMgt/pic/aysmile.gif" border=0></a> <a href="javascript:setsmile(':tasty:')"><img src="../WebboardMgt/pic/tasty.gif" border=0></a> <a href="javascript:setsmile(':agree:')"><img src="../WebboardMgt/pic/agree.gif" border=0></a> <a href="javascript:setsmile(':disagree:')"><img src="../WebboardMgt/pic/disagree.gif" border=0></a> <a href="javascript:setsmile(':bawling:')"><img src="../WebboardMgt/pic/bawling.gif" border=0></a> <a href="javascript:setsmile(':crap:')"><img src="../WebboardMgt/pic/crap.gif" border=0></a> <a href="javascript:setsmile(':crying1:')"><img src="../WebboardMgt/pic/crying1.gif" border=0></a> <a href="javascript:setsmile(':dunce:')"><img src="../WebboardMgt/pic/dunce.gif" border=0></a> <a href="javascript:setsmile(':error:')"><img src="../WebboardMgt/pic/error.gif" border=0></a> <a href="javascript:setsmile(':evil:')"><img src="../WebboardMgt/pic/evil.gif" border=0></a> <a href="javascript:setsmile(':lookaroundb:')"><img src="../WebboardMgt/pic/lookaroundb.gif" border=0></a> <a href="javascript:setsmile(':laugh:')"><img src="../WebboardMgt/pic/laugh.gif" border=0></a> <a href="javascript:setsmile(':pimp:')"><img src="../WebboardMgt/pic/pimp.gif" border=0></a> <a href="javascript:setsmile(':spiny:')"><img src="../WebboardMgt/pic/spiny.gif" border=0></a> <a href="javascript:setsmile(':wavey:')"><img src="../WebboardMgt/pic/wavey.gif" border=0></a> <a href="javascript:setsmile(':smash:')"><img src="../WebboardMgt/pic/smash.gif" border=0 width="30" height="26"></a> <a href="javascript:setsmile(':crazy:')"><img src="../WebboardMgt/pic/grazy.gif" border=0 width="16" height="16"></a> <a href="javascript:setsmile(':download:')"><img src="../WebboardMgt/pic/download.gif" border=0></a> <a href="javascript:setsmile(':cranium:')"><img src="../WebboardMgt/pic/cranium.gif" border=0></a> <a href="javascript:setsmile(':censore:')"><img src="../WebboardMgt/pic/censore.gif" border=0></a> <a href="javascript:setsmile(':nolove:')"><img src="../WebboardMgt/pic/nolove.gif" border=0></a> <a href="javascript:setsmile(':beer:')"><img src="../WebboardMgt/pic/beer.gif" border=0></a>--><br>
                            <font color="blue">คลิกที่รูป เพื่อแทรกรูปลงในข้อความ</font> </td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="2">
                              <tr align="center" valign="middle">
                                <td height="25"><font color="#FFFFFF" class=size3>
                                  <input  type=submit value='ส่งคำตอบ' name="submit">
                                  &nbsp;&nbsp;
                                  <input  type=reset value='เคลียร์' name="reset">
                                  <input name="flag" type="hidden" id="flag" value="answer">
                                  <input name="wcad" type="hidden" id="wcad" value="<?php echo $wcad; ?>">
                                  <input name="wtid" type="hidden" id="wtid" value="<?php echo $wtid; ?>">
                                </font></td>
                              </tr>
                                                </table></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
            </form>
			  <iframe name="save_function_form1" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
</body>
</html>



<script language="JavaScript">
function CHK(){
if(document.myForm.amsg.value == ""){
alert("กรุณาใส่รายละเอียด");
document.myForm.amsg.focus();
return false;
}
if(document.myForm.aname.value == ""){
alert("กรุณาใส่ชื่อ");
document.myForm.aname.focus();
return false;
}
}
</script>
<script language="JavaScript">
function setURL()
{
	var temp = window.prompt('ใส่ URL ที่คุณต้องการสร้างเป็นลิงค์','http://'); 
	if(temp) setsmile('[url]'+temp+'[/url]');
}

function setImage()
{
	var temp = window.prompt('ใส่ URL ของรูปที่คุณต้องการให้แสดงในกระทู้ของคุณ','http://'); 
	if(temp) setsmile('[img]'+temp+'[/img]');
}

function setBold()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวหนา',''); 
	if(temp) setsmile('[b]'+temp+'[/b]');
}

function setItalic()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการทำเป็นตัวเอียง',''); 
	if(temp) setsmile('[i]'+temp+'[/i]');
}

function setUnderline()
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้มีเส้นใต้',''); 
	if(temp) setsmile('[u]'+temp+'[/u]');
}

function setColor(color,name)
{
	var temp = window.prompt('ใส่ข้อความที่คุณต้องการให้เป็นสี'+name,''); 
	if(temp) setsmile('[color='+color+']'+temp+'[/color]');
}

function setsmile(what)
{
	document.myForm.amsg.value = document.myForm.elements.amsg.value+" "+what;
	document.myForm.amsg.focus();
}
</script>
<?php @$db->db_close(); ?>