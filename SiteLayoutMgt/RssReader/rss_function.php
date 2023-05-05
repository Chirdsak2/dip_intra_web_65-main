<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/rss_language.php");

$c_title = stripslashes(htmlspecialchars($_POST["rss_title"],ENT_QUOTES));
$c_url = stripslashes(htmlspecialchars($_POST["rss_url"],ENT_QUOTES));
$c_row= stripslashes(htmlspecialchars($_POST["rss_row"],ENT_QUOTES));
$cid=$_POST["cid"];

if($_POST["Flag"] == "AddNew"){
$db->query("Insert into rss(rss_title,rss_url,rss_row) values('$c_title','$c_url','$c_row')");
$db->write_log("create","rss","สร้าง rss reader   ".$c_title);
?>
			<script language="javascript">
				alert('<?php echo $text_genrss_complete1;?>');
				self.location.href = "rss.php";
			</script>
<?php
			exit;
}

if($_POST["Flag"] == "DelGroup"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
			if($chk != ""){
				$rec = $db->db_fetch_array($db->query("select * from rss WHERE rss_id = '$chk' "));
				$db->write_log("delete","rss","ลบ rss reader   ".$rec["rss_title"]);
				$db->query("DELETE FROM rss WHERE rss_id = '$chk'");
			}
	}
				?>
			<script language="javascript">
				alert('<?php echo $text_genrss_complete3;?>');
				self.location.href = "rss.php";
			</script>
		<?php
}		

if($_POST["Flag"] == "EditRSS"){

$db->query("Update  rss set  rss_title='$c_title',rss_url='$c_url',rss_row='$c_row' WHERE rss_id = '$cid'");
$db->write_log("update","rss","แก้ไข rss reader   ".$c_title);
				?>
			<script language="javascript">
			    alert('<?php echo $text_genrss_complete2;?>');
				self.location.href = "rss.php";
			</script>
		<?php
}	


		if($_POST["Flag"] == "CreateFolder"){
			$c_name = stripslashes(htmlspecialchars($_POST["gname"],ENT_QUOTES));
$sql_check = $db->query("SELECT * FROM article_group WHERE c_name = '".$c_name."' ");
	if($db->db_num_rows($sql_check) > 0){
		?>
			<script language="javascript">
				alert("\"<?php echo $c_name; ?>\"<?php echo $text_genrss_complete4;?>");
				self.location.href = "rss.php";
			</script>
		<?php
			exit;
	}

$db->query("INSERT INTO article_group (c_name) VALUES ('".$c_name."') ");
				?>
			<script language="javascript">
				self.location.href = "rss.php#bottom";
			</script>
		<?php
}
		if($_POST["Flag"] == "EditGroup"){
			if(trim($_POST["c_name"]) == ""){
					?>
			<script language="javascript">
				self.location.href = "article_gedit.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
			exit;
			}
			$c_name = stripslashes(htmlspecialchars($_POST["c_name"],ENT_QUOTES));
$sql_check = $db->query("SELECT * FROM article_group WHERE c_name = '".$c_name."' AND c_id != '".$_POST["cid"]."' ");
	if($db->db_num_rows($sql_check) > 0){
		?>
			<script language="javascript">
				alert("\"<?php echo $c_name; ?>\" is already exist!!!!");
				self.location.href = "article_gedit.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
			exit;
	}

$db->query("UPDATE article_group SET c_name = '".$c_name."' WHERE c_id = '".$_POST["cid"]."' ");
				?>
			<script language="javascript">
				self.location.href = "article_gedit.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
}
		if($_POST["Flag"] == "AddArticle"){
$topic = stripslashes(htmlspecialchars($_POST["topic"],ENT_QUOTES));
$description = stripslashes(htmlspecialchars($_POST["description"],ENT_QUOTES));
$picture = stripslashes(htmlspecialchars($_POST["picture"],ENT_QUOTES));
$link = stripslashes(htmlspecialchars($_POST["link"],ENT_QUOTES));
$source = stripslashes(htmlspecialchars($_POST["source"],ENT_QUOTES));
$source_url = stripslashes(htmlspecialchars($_POST["source_url"],ENT_QUOTES));
$keyword = stripslashes(htmlspecialchars($_POST["keyword"],ENT_QUOTES));

$date = explode("/",$_POST["date_n"]);
$date_n = $date[2]."-".$date[1]."-".$date[0];

$date1 = explode("/",$_POST["date_e"]);
$date_e = $date1[2]."-".$date1[1]."-".$date1[0];

$insert = "INSERT INTO article_list (c_id,n_date,n_timestamp,n_topic,n_des,source,sourceLink,keyword,picture,news_use,at_id,link_html,target,expire,logo) VALUES ('".$_POST["cid"]."','$date_n','".date("Y-m-d H:i:s")."','$topic','$description','$source','$source_url','$keyword','$picture','".$_POST["detail_use"]."','".$_POST["at_id"]."','$link','".$_POST["target"]."','$date_e','".$_POST["icon"]."')";

$db->query($insert);

// rss  Thailand //
Gen_RSS($_POST["cid"]);

$sql_max = $db->query("SELECT MAX(n_id) FROM article_list WHERE c_id = '".$_POST["cid"]."' AND n_topic = '$topic' ");
$M = $db->db_fetch_row($sql_max);
$nid = $M[0];

$nfile = "n".date("Ymd")."_".$nid;
$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$nid;
@mkdir ($Current_Dir, 0777);

if($_FILES['file']['size'] > 0 AND $_FILES['file']['size'] < 204800){
		$F = explode(".",$_FILES["file"]["name"]);
		$C = count($F);
		$CT = $C-1;
		$dir = strtolower($F[$CT]);
		if($dir == "jpeg"){
		$dir = "jpg";
		}
		$picname = $nfile.".".$dir;
		if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
		copy($_FILES["file"]["tmp_name"],$Current_Dir."/".$picname);
		@chmod ($Current_Dir."/".$picname, 0777);
		$db->query("UPDATE article_list SET picture = '$picname' WHERE n_id = '$nid' ");
		include("../ewt_thumbnail.php");
					if($dir == "jpg"){
						thumb_jpg($Current_Dir."/".$picname,$Current_Dir."/t".$picname, "120", "120");
					}
					if($dir == "gif"){
						thumb_gif($Current_Dir."/".$picname,$Current_Dir."/t".$picname, "120", "120");
					}
					if($dir == "png"){
						thumb_png($Current_Dir."/".$picname,$Current_Dir."/t".$picname, "120", "120");
					}
		}
}

if($_POST["detail_use"] == "2"){
	$temp = $db->query("SELECT at_file_new FROM article_template WHERE at_id = '".$_POST["at_id"]."'");
	$T = $db->db_fetch_row($temp);
	include("../article_template/code/".$T[0]); 
			?>
				<script language="javascript">
					self.location.href = "article_detail.php?nid=<?php echo $nid; ?>";
				</script>
			<?php
}else{
				?>
				<script language="javascript">
					self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
				</script>
			<?php
}
}		
if($_POST["Flag"] == "NewsDetail"){
				include("../ewt_thumbnail.php");
				$db->query("UPDATE article_list SET d_id = '".$_POST["template"]."' WHERE n_id = '".$_POST["nid"]."' ");
				$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$_POST["nid"]."/";
	for($x=1;$x<=$_POST["allx"];$x++){
			for($y=0;$y<$_POST["ally"];$y++){
				$chsize = "Y";
				$ad_pic_h = $_POST["hx".$x."y".$y];
				$ad_pic_w = $_POST["wx".$x."y".$y];
				$ad_des = eregi_replace(" ","&nbsp;",$_POST["dx".$x."y".$y]);
				$ad_des = stripslashes(htmlspecialchars($_POST["dx".$x."y".$y],ENT_QUOTES));
				$ad_des = eregi_replace(" ","&nbsp;",$ad_des);
				$ad_font = $_POST["fx".$x."y".$y];
				$ad_size = $_POST["sx".$x."y".$y];
				$ad_bold = $_POST["bx".$x."y".$y];
				$ad_italic = $_POST["ix".$x."y".$y];
				$ad_color = $_POST["cx".$x."y".$y];
				$ad_align = $_POST["ax".$x."y".$y];
				$ad_pic_s = $_POST["spx".$x."y".$y];
				$ad_pic_b = $_POST["bpx".$x."y".$y];
				$remove = $_POST["rx".$x."y".$y];
				$ad_id = $_POST["adx".$x."y".$y];
				$create_t = $_POST["tx".$x."y".$y];
	
				if($ad_id != ""){
					if($remove == "Y"){
						if($ad_pic_s != ""){
							@unlink($Current_Dir.$ad_pic_s);
							$ad_pic_s = "";
						}
						if($ad_pic_b != ""){
							@unlink($Current_Dir.$ad_pic_b);
							$ad_pic_b = "";
						}
					}else{
						$nfile = "n".date("YmdHis")."_".$ad_id;
						$tfile = "t".date("YmdHis")."_".$ad_id;
						if($_FILES["filex".$x."y".$y]['size'] > 0 ){
							if($_FILES["filex".$x."y".$y]['size'] <= 500000){
							$F = explode(".",$_FILES["filex".$x."y".$y]["name"]);
							$C = count($F);
							$CT = $C-1;
							$dir = strtolower($F[$CT]);
								if($dir == "jpeg"){
									$dir = "jpg";
								}
							$picname = $nfile.".".$dir;
								if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
									copy($_FILES["filex".$x."y".$y]["tmp_name"],$Current_Dir.$picname);
									@chmod ($Current_Dir.$picname, 0777);
										if($ad_pic_b != ""){
											@unlink($Current_Dir.$ad_pic_b);
										}
										$ad_pic_b = $picname;

								}else{
								$chsize="N";
								}
						}else{
								$chsize="N";
							}
						
						}
					
									if($create_t == "Y" AND $ad_pic_b != "" AND $chsize == "Y"){
																						
												$F = explode(".",$ad_pic_b);
												$dir = strtolower($F[1]);
												$tpicname = $tfile.".".$dir;
												if($dir == "jpg"){
													thumb_jpg($Current_Dir.$ad_pic_b,$Current_Dir.$tpicname, $ad_pic_w, $ad_pic_h);
												}
												if($dir == "gif"){
													thumb_gif($Current_Dir.$ad_pic_b,$Current_Dir.$tpicname, $ad_pic_w, $ad_pic_h);
												}
												if($dir == "png"){
													thumb_png($Current_Dir.$ad_pic_b,$Current_Dir.$tpicname, $ad_pic_w, $ad_pic_h);
												}
																						if($ad_pic_s != "" AND $ad_pic_s != $ad_pic_b){
																							@unlink($Current_Dir.$ad_pic_s);
																						}
										$ad_pic_s = $tpicname;
									}else{
										if($ad_pic_s != "" AND $ad_pic_s != $ad_pic_b){
													@unlink($Current_Dir.$ad_pic_s);
												$ad_pic_s = $ad_pic_b;
												}
										
									}


					}
				$update = "UPDATE article_detail SET ad_pic_s = '$ad_pic_s', ";
				if($chsize != "N"){
$update .= "ad_pic_h = '$ad_pic_h', ad_pic_w = '$ad_pic_w', ";
				}
$update .= "ad_pic_b = '$ad_pic_b',
ad_des = '$ad_des',
ad_font = '$ad_font',
ad_size = '$ad_size',
ad_bold = '$ad_bold',
ad_italic = '$ad_italic',
ad_color = '$ad_color',
ad_align = '$ad_align' WHERE article_detail.ad_id ='$ad_id' ";

				$db->query($update);
				}
			}


	}
	if($_POST["n_action"] == "save"){
			?>
			<script language="javascript">
				self.location.href = "article_detail.php?nid=<?php echo $_POST["nid"]; ?>";
			</script>
		<?php
	}
	if($_POST["n_action"] == "preview"){
			?>
			<script language="javascript">
				window.open("../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_news.php?nid=<?php echo $_POST["nid"]; ?>","","width=800,height=550,resizable=1,scrollbars=1");
				self.location.href = "article_detail.php?nid=<?php echo $_POST["nid"]; ?>";
			</script>
		<?php
	}
	if($_POST["n_action"] == "exit"){
			?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
	}

}
					if($_POST["Flag"] == "EditArticle"){
$topic = stripslashes(htmlspecialchars($_POST["topic"],ENT_QUOTES));
$description = stripslashes(htmlspecialchars($_POST["description"],ENT_QUOTES));
$link = stripslashes(htmlspecialchars($_POST["link"],ENT_QUOTES));
$source = stripslashes(htmlspecialchars($_POST["source"],ENT_QUOTES));
$source_url = stripslashes(htmlspecialchars($_POST["source_url"],ENT_QUOTES));
$keyword = stripslashes(htmlspecialchars($_POST["keyword"],ENT_QUOTES));

$date = explode("/",$_POST["date_n"]);
$date_n = $date[2]."-".$date[1]."-".$date[0];

$date1 = explode("/",$_POST["date_e"]);
$date_e = $date1[2]."-".$date1[1]."-".$date1[0];

$update = "UPDATE article_list SET c_id = '".$_POST["cid"]."',n_date = '$date_n', n_timestamp = '".date("Y-m-d H:i:s")."',n_topic = '$topic',n_des = '$description',source = '$source',sourceLink = '$source_url',keyword = '$keyword',link_html = '$link',target = '".$_POST["target"]."',expire = '$date_e',logo = '".$_POST["icon"]."' WHERE n_id = '".$_POST["nid"]."' ";

// rss  Thailand //
$db->query($update);

Gen_RSS($_POST["cid"]);
				?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
}		
if($_POST["Flag"] == "DelArticle"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
			if($chk != ""){
				$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '$chk' ");
				$R = $db->db_fetch_array($sql_edit);
				$cid=$R[c_id];
	
				$db->query("DELETE FROM article_list WHERE n_id = '$chk'");
				
				Gen_RSS($cid);	
			}
	}
	
	
	?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
	<?php
}	
	


											if($_POST["Flag"] == "AppArticle"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["app".$i];
		$nid = $_POST["nid".$i];
			if($chk == "Y"){
				$db->query("UPDATE article_list SET n_approve = 'Y' , n_approvedate = '".date("Y-m-d")."' WHERE n_id = '$nid'");
			}else{
				$db->query("UPDATE article_list SET n_approve = '' , n_approvedate = '".date("Y-m-d")."' WHERE n_id = '$nid'");
			}
	}
				?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
}		
								if($_POST["Flag"] == "DelGroup"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
			if($chk != ""){
				$db->query("DELETE FROM article_group WHERE c_id = '$chk'");
				$db->query("DELETE FROM article_apply WHERE c_id = '$chk'");
				$db->query("DELETE FROM article_list WHERE c_id = '$chk'");
			}
			
			$filename = "../ewt/".$_SESSION["EWT_SUSER"]."/rss/group".$chk.".xml";
            unlink($filename);
	}
				?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
}		

if($_POST["Flag"] == "SetRSS"){
    $db->query("Update article_group SET c_rss='' WHERE c_id = '$chk'");
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chkrss".$i];
		$nid = $_POST["chkrssH".$i];
		if($chk != ""){
			$db->query("Update article_group SET c_rss='Y' WHERE c_id = '$chk'");
			Gen_RSS($chk);
		}else{
			$db->query("Update article_group SET c_rss=NULL WHERE c_id = '$nid'");
			$filename = "../ewt/".$_SESSION["EWT_SUSER"]."/rss/group".$nid.".xml";
			if(file_exists($filename)){
               unlink($filename);
			}
		}
	}
	?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
	<?php
}

							if($_POST["Flag"] == "Design"){

$amd_mode = $_POST["amd_mode"];
$AMBulletBP = $_POST["AMBulletBP"];
$AMBulletSP = $_POST["AMBulletSP"];
$AMHeadBG = $_POST["AMHeadBG"];  
$AMHeadP = $_POST["AMHeadP"];
$AMHeadF = $_POST["AMHeadF"];
$AMHeadS = $_POST["AMHeadS"];
$AMHeadC = $_POST["AMHeadC"];
$AMHeadB = $_POST["AMHeadB"];
$AMHeadI = $_POST["AMHeadI"];
$AMBodyBP = $_POST["AMBodyBP"];
$AMBodyBG = $_POST["AMBodyBG"];
$AMBodyF = $_POST["AMBodyF"]; 
$AMBodyS = $_POST["AMBodyS"];
$AMBodyC = $_POST["AMBodyC"];
$AMBodyB = $_POST["AMBodyB"];
$AMBodyI = $_POST["AMBodyI"];
$AMMorePic = $_POST["AMMorePic"];
$AMMORE = $_POST["AMMORE"];
$AMBottomF = $_POST["AMBottomF"];
$AMBottomS = $_POST["AMBottomS"];
$AMBottomC = $_POST["AMBottomC"];
$AMBottomB = $_POST["AMBottomB"];
$AMBottomI = $_POST["AMBottomI"];
$AMBOTTOMP = $_POST["AMBOTTOMP"];
$AMBOTTOMH = $_POST["AMBOTTOMH"];
$AMBOTTOMBG = $_POST["AMBOTTOMBG"];
$code_html = addslashes($_POST["code_html"]);
$AMDetailF = $_POST["AMDetailF"]; 
$AMDetailS = $_POST["AMDetailS"];
$AMDetailC = $_POST["AMDetailC"];
$AMDetailB = $_POST["AMDetailB"];
$AMDetailI = $_POST["AMDetailI"];
$a_show = $_POST["a_show"];
$AMWidth = $_POST["AMWidth"];
$AMDate = $_POST["AMDate"];
$AMUseHead = $_POST["AMUseHead"];
$AMHeadH = $_POST["AMHeadH"];
$AMUseDetail = $_POST["AMUseDetail"];

/////////////////////////////font////////////////////////////////////

if($AMHeadS == ""){
$AMHeadST = "";
}elseif($AMHeadS == "8"){
$AMHeadST = "1";
}elseif($AMHeadS == "10"){
$AMHeadST = "2";
}elseif($AMHeadS == "12"){
$AMHeadST = "3";
}elseif($AMHeadS == "14"){
$AMHeadST = "4";
}elseif($AMHeadS == "18"){
$AMHeadST = "5";
}elseif($AMHeadS == "24"){
$AMHeadST = "6";
}elseif($AMHeadS == "36"){
$AMHeadST = "7";
}
//////////////////////////////////////////////////////////////////
if($AMBodyS == ""){
$AMBodyST = "";
}elseif($AMBodyS == "8"){
$AMBodyST = "1";
}elseif($AMBodyS == "10"){
$AMBodyST = "2";
}elseif($AMBodyS == "12"){
$AMBodyST = "3";
}elseif($AMBodyS == "14"){
$AMBodyST = "4";
}elseif($AMBodyS == "18"){
$AMBodyST = "5";
}elseif($AMBodyS == "24"){
$AMBodyST = "6";
}elseif($AMBodyS == "36"){
$AMBodyST = "7";
}
////////////////////////////////////////////////////////////////
if($AMBottomS == ""){
$AMBottomST = "";
}elseif($AMBottomS == "8"){
$AMBottomST = "1";
}elseif($AMBottomS == "10"){
$AMBottomST = "2";
}elseif($AMBottomS == "12"){
$AMBottomST = "3";
}elseif($AMBottomS == "14"){
$AMBottomST = "4";
}elseif($AMBottomS == "18"){
$AMBottomST = "5";
}elseif($AMBottomS == "24"){
$AMBottomST = "6";
}elseif($AMBottomS == "36"){
$AMBottomST = "7";
}
//////////////////////////////////////////////////////////////////
if($AMDetailS == ""){
$AMDetailST = "";
}elseif($AMDetailS == "8"){
$AMDetailST = "1";
}elseif($AMDetailS == "10"){
$AMDetailST = "2";
}elseif($AMDetailS == "12"){
$AMDetailST = "3";
}elseif($AMDetailS == "14"){
$AMDetailST = "4";
}elseif($AMDetailS == "18"){
$AMDetailST = "5";
}elseif($AMDetailS == "24"){
$AMDetailST = "6";
}elseif($AMDetailS == "36"){
$AMDetailST = "7";
}
//////////////////////////////////////////////////////////////////
$update = "UPDATE article_apply SET amd_mode = '$amd_mode',code_html = '$code_html',AMBulletBP = '$AMBulletBP',AMBulletSP = '$AMBulletSP',AMHeadBG = '$AMHeadBG',AMHeadP = '$AMHeadP',AMHeadF = '$AMHeadF',AMHeadS = '$AMHeadST',AMHeadC = '$AMHeadC',AMHeadB = '$AMHeadB',AMHeadI = '$AMHeadI',AMBodyBP = '$AMBodyBP',AMBodyBG = '$AMBodyBG',AMBodyF = '$AMBodyF',AMBodyS = '$AMBodyST',AMBodyC = '$AMBodyC',AMBodyB = '$AMBodyB',AMBodyI = '$AMBodyI',AMMorePic = '$AMMorePic',AMMORE = '$AMMORE',AMBottomF = '$AMBottomF',AMBottomS = '$AMBottomST',AMBottomC = '$AMBottomC',AMBottomB = '$AMBottomB',AMBottomI = '$AMBottomI',AMBOTTOMP = '$AMBOTTOMP',AMBOTTOMH = '$AMBOTTOMH',AMBOTTOMBG = '$AMBOTTOMBG',AMDetailF = '$AMDetailF',AMDetailS = '$AMDetailST',AMDetailC = '$AMDetailC',AMDetailB = '$AMDetailB',AMDetailI = '$AMDetailI',a_show = '$a_show',AMWidth = '$AMWidth',AMDate = '$AMDate',AMUseHead = '$AMUseHead',AMHeadH = '$AMHeadH',AMUseDetail = '$AMUseDetail' WHERE a_id = '".$_POST["aid"]."' ";

$db->query($update);

if($_POST["usedef"] == "Y"){
$db->query("UPDATE  article_apply SET AMDefault = '' ");
$db->query("UPDATE  article_apply SET AMDefault = 'Y' WHERE a_id = '".$_POST["aid"]."' ");
}
		?>
		<script language="JavaScript">
			//	self.top.window.opener.location.reload();
			<?php if($_POST["applyto"] == "Y"){ ?>
				self.location.href = "article_apply.php?B=<?php echo $_POST["B"]; ?>&aid=<?php echo $_POST["aid"]; ?>";
			<?php }else{ ?>
				//self.location.href = "article_gdesign.php?B=<?php echo $_POST["B"]; ?>";
				self.close();
			<?php } ?>
		</script>
	<?php
		}
		if($_POST["Flag"] == "SetDisp"){
				$bcode = base64_decode($_POST["B"]);
				$bid_a = explode("z",$bcode);
				$BID = $bid_a[1];
				$db->query("UPDATE block SET block_link = '".$_POST["show_type"]."' WHERE BID = '".$BID."'");
				?>
		<script language="JavaScript">
				self.location.href = "article_gdesign.php?B=<?php echo $_POST["B"]; ?>";
		</script>
	<?php
		}
				if($_POST["Flag"] == "Apply"){
						$sql_design = $db->query("SELECT * FROM article_apply WHERE a_id = '".$_POST["aid"]."' ");
						$R = $db->db_fetch_array($sql_design);
						for($i=0;$i<$_POST["alli"];$i++){
							$a_id = $_POST["chk".$i];
							if($a_id != ""){
							
								$db->query("UPDATE article_apply SET a_show = '".$R["a_show"]."' ,amd_mode = '".$R["amd_mode"]."' ,code_html = '".$R["code_html"]."' ,AMBulletBP = '".$R["AMBulletBP"]."' ,AMBulletSP = '".$R["AMBulletSP"]."' ,AMHeadBG = '".$R["AMHeadBG"]."' ,AMHeadP = '".$R["AMHeadP"]."' ,AMHeadF = '".$R["AMHeadF"]."' ,AMHeadS = '".$R["AMHeadS"]."' ,AMHeadC = '".$R["AMHeadC"]."' ,AMHeadB = '".$R["AMHeadB"]."' ,AMHeadI = '".$R["AMHeadI"]."' ,AMBodyBP = '".$R["AMBodyBP"]."' ,AMBodyBG = '".$R["AMBodyBG"]."' ,AMBodyF = '".$R["AMBodyF"]."' ,AMBodyS = '".$R["AMBodyS"]."' ,AMBodyC = '".$R["AMBodyC"]."' ,AMBodyB = '".$R["AMBodyB"]."' ,AMBodyI = '".$R["AMBodyI"]."' ,AMMorePic = '".$R["AMMorePic"]."' ,AMMORE = '".$R["AMMORE"]."' ,AMBottomF = '".$R["AMBottomF"]."' ,AMBottomS = '".$R["AMBottomS"]."' ,AMBottomC = '".$R["AMBottomC"]."' ,AMBottomB = '".$R["AMBottomB"]."' ,AMBottomI = '".$R["AMBottomI"]."' ,AMBOTTOMP = '".$R["AMBOTTOMP"]."' ,AMBOTTOMBG = '".$R["AMBOTTOMBG"]."' ,AMBOTTOMH = '".$R["AMBOTTOMH"]."' ,AMWidth = '".$R["AMWidth"]."' ,AMUseHead = '".$R["AMUseHead"]."' ,AMHeadH = '".$R["AMHeadH"]."' ,AMUseDetail = '".$R["AMUseDetail"]."' ,AMDetailF = '".$R["AMDetailF"]."' ,AMDetailS = '".$R["AMDetailS"]."' ,AMDetailC = '".$R["AMDetailC"]."' ,AMDetailB = '".$R["AMDetailB"]."' ,AMDetailI = '".$R["AMDetailI"]."' ,AMDate = '".$R["AMDate"]."' WHERE a_id = '".$a_id."' ");
							}
						}
				?>
		<script language="JavaScript">
				//self.location.href = "article_gdesign.php?B=<?php echo $_POST["B"]; ?>";
				self.close();
		</script>
	<?php
		}
		
		
function Gen_RSS($cid){
		global $db;
		$sql="SELECT * FROM article_group WHERE c_id='$cid'  ";
		$query_rss=$db->query($sql);
		$rss=$db->db_fetch_array($query_rss);

		if($rss["c_rss"]=='Y'){

			$xml_text='<'.'?xml version="1.0" encoding="utf-8"?'.'>
			<rss version="2.0">
			<channel>
				  <title>'.$rss["c_name"].'</title> 
				  <link>http://www.bizpotential.com</link> 
				  <description>http://www.bizpotential.com</description> 
				  <language>th-TH</language> 
				  <lastBuildDate>'.date('D,d M Y H:i:s e').'</lastBuildDate> 
				  <copyright>Copyright ? 2006 All rights reserved. Bizpotential CO.,LTD.</copyright> 
			';

			$query_rss=$db->query("SELECT * FROM article_list WHERE c_id='$cid' and n_approve='y'  ORDER BY n_id DESC limit 0,10 ");
			while($rss=$db->db_fetch_array($query_rss)){
			$xml_text.='<item>
							<title>'.$rss["n_topic"].'</title>
							<link>http://www.bizpotential.com</link>
							<description>'.$rss["n_des"].'</description>
							<pubDate>'.$rss["n_timestamp"].'</pubDate>
							<guid>http://www.bizpotential.com</guid>
						</item>
						';
			}
			$xml_text.='</channel>
			</rss>
			';
			$fp=fopen("../ewt/".$_SESSION["EWT_SUSER"]."/rss/group".$cid.".xml","w");
			fputs($fp,$xml_text);
			fclose($fp);
		}
}

$db->db_close(); ?>
