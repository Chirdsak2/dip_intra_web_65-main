<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_thumbnail.php");

$global_height = "790";
$global_width = "800";

$_host = $_SERVER['HTTP_HOST'];	
$_name = $_SERVER['SCRIPT_NAME'];
$_url = $_SERVER['REQUEST_URI'];	
$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';
	
	function getEwt1($_url){
	
   $s_method = strtok($_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/";
		
		return  $chk_site;
	}
}



$_directory = getEwt1($_url);

//print_r($_POST);
//print_r($_FILES);
//exit;
if($_POST['proc'] == 'EditLoc'){
$nid = $_POST['nid'];

$s_article = $db->query("SELECT * FROM `article_list` WHERE `n_id` ='{$nid}' ");
$a_row = $db->db_num_rows($s_article);

$a_article = $db->db_fetch_array($s_article);
$address = "";	

if($a_article['n_address']){
$n_address = explode("###",$a_article['n_address']);
for($i = 0; $i < count($n_address); $i++ ){	
 
$article = explode("#@#",$n_address[$i]);

if($article[0] != '' OR $article[1]){	

if($i == $_POST[num]){ 
$article[0] = $_POST['n_address1'.$_POST[num]];
$article[1] = $_POST['n_address2'.$_POST[num]];
}	

$address .= $article[0]."#@#".$article[1]."###";
}
	}
		}

$s_update = "UPDATE `article_list` SET  `n_address`  = '{$address}' WHERE n_id = '{$nid}' ";
$db->query($s_update);				
?>	
<script >
self.location.href = "article_video.php?nid=<?=$nid;?>";
</script>	

<?php
exit;
}

if($_POST['proc'] == 'AddLoc'){
$nid = $_POST['nid'];

$s_article = $db->query("SELECT * FROM `article_list` WHERE n_id ='{$nid}' ");
$a_row = $db->db_num_rows($s_article);

$a_article = $db->db_fetch_array($s_article);
$address = "";	

if($a_article['n_address']){
	
$n_address = explode("###",$a_article['n_address']);

for($i = 0; $i < count($n_address); $i++ ){	
 
$article = explode("#@#",$n_address[$i]);

if($article[0] != '' OR $article[1]){	

$address .= $article[0]."#@#".$article[1]."###";

}
	}
		}

if($_POST["n_address1"] != '' OR $_POST["n_address2"]){	
$address .= $_POST["n_address1"]."#@#".$_POST["n_address2"]."###";
}

	
$s_update = "UPDATE `article_list` SET  `n_address`  = '{$address}' WHERE n_id = '{$nid}' ";
$db->query($s_update);				
?>	
<script >
self.location.href = "article_video.php?nid=<?=$nid;?>";
</script>	

<?php
exit;
}

if($_POST['Flag'] == 'AddVdo'){
	
$nid = $_POST['nid'];
	
$Current_DirVdo = "../ewt/".$_SESSION["EWT_SUSER"]."/download/file_vdo/";


if($_POST['showvdo'] == '1'){
		

if($_FILES['file']['tmp_name'] != ""){
	
$MAXIMUM_FILESIZE = 10 * 1024 * 1024; 
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(mp4){1}$/i"; 
$dir_base = "files/"; 

$isFile = is_uploaded_file($_FILES['file']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "article_vdo_".date("YmdHis")."_".$i.$type_file;
	 
    if ($_FILES['file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file ($_FILES['file']['tmp_name'],$Current_DirVdo.$newfile);
		  } 
	$pate = $newfile;
      }else{
		  $pate = "";		  	  
	  } 
	  
	  
	  
	 $Sql_n1 = "INSERT INTO `article_video` (
										`n_id`,
										`av_filename`,
										`av_filenameyoutube`,
										`av_type`,
										`av_createdate`
										) 
										VALUES (
												'{$nid}',
												'{$pate}',
												'',
												'V',											
												NOW( )
												)";
$db->query($Sql_n1);	
}
	
	}



if($_POST['showvdo'] == '2'){
	

if($_POST['vdo_youtube'] != ""){

	  
	 $Sql_n2 = "INSERT INTO `article_video` (
										`n_id`,
										`av_filename`,
										`av_filenameyoutube`,
										`av_type`,
										`av_createdate`
										) 
										VALUES (
												'{$nid}',
												'',
												'{$_POST[vdo_youtube]}',
												'T',											
												NOW( )
												)";
$db->query($Sql_n2);	
}
	
	}
	
?>
<script >
self.location.href = "article_video.php?nid=<?=$nid;?>";
</script>
<?php
exit;	
}	
	

if($_POST['Flag'] == 'EditVdo'){
	
$nid = $_POST['nid'];
$vid = $_POST['vid'];
	
$Current_DirVdo = "../ewt/".$_SESSION["EWT_SUSER"]."/download/file_vdo/";


if($_POST['showvdo'] == 'V'){
		

if($_FILES['file']['tmp_name'] != ""){
	
$MAXIMUM_FILESIZE = 10 * 1024 * 1024; 
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(mp4){1}$/i"; 
$dir_base = "files/"; 

$dir_file_old = "../ewt/".$_SESSION["EWT_SUSER"]."/download/file_vdo/".$_POST['file_old']; 

$isFile = is_uploaded_file($_FILES['file']['tmp_name']); 
if ($isFile){    //  do we have a file? 
   //  sanatize file name 
    //     - remove extra spaces/convert to _, 
    //     - remove non 0-9a-Z._- characters, 
    //     - remove leading/trailing spaces 
    //  check if under 5MB, 
    //  check file extension for legal file types 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['file']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "article_vdo_".date("YmdHis").$type_file;
	 
    if ($_FILES['file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file ($_FILES['file']['tmp_name'],$Current_DirVdo.$newfile);
		  } 
	$pate = $newfile;
      if(file_exists($dir_file_old) && $_POST['file_old'] != '')
				{
				unlink($dir_file_old);
				}
      }else{
		  $pate = $_POST['file_old'];		  	  
	  } 
	  
	  
	  $Sql_Up1 = "UPDATE `article_video` SET  `av_filename`  = '{$pate}' WHERE av_id = '{$vid}' ";
	  $db->query($Sql_Up1);
	  	
}
	
	}


if($_POST['showvdo'] == 'T'){
	
if($_POST['vdo_youtube'] != ""){

	 $Sql_Up2 = "UPDATE `article_video` SET  `av_filenameyoutube`  = '{$_POST[vdo_youtube]}' WHERE av_id = '{$vid}' ";
	  $db->query($Sql_Up2); 
	
}
	
	}
		
?>
<script >
self.location.href = "article_video.php?nid=<?=$nid;?>";
</script>
<?php
exit;
	
}

	
if($_POST["Flag"] == "EUpload" AND $_POST["nid"] != "" AND $_POST["ad_id"] != ""){


	$a_ad_des = $_POST[ad_des];	
	$txt = $a_ad_des; 
	//$txt = eregi_replace($_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/","images/",$txt);
	//$txt = eregi_replace("images/",$_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/",$txt);

	//$txt = str_replace($_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/","images/",$txt);
		
	$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$_POST["nid"]."/";
	$sql_Imsize = "select site_info_max_img from site_info";
	$query_Imsize = $db->query($sql_Imsize);
	$rec_Imsize = $db->db_fetch_array($query_Imsize);
	$ad_id = $_POST["ad_id"];
	$max_img_size=$rec_Imsize[site_info_max_img]*1024;
	$MAXIMUM_FILESIZE = 10 * 1024 * 1024; 
	$ad_pic_w = $_POST["wb"];
	$ad_pic_h = $_POST["hb"];

						$nfile = "n".date("YmdHis")."_".$ad_id;
						$tfile = "t".date("YmdHis")."_".$ad_id;
						if($_FILES["fileb"]['size'] > 0 ){
							if($_FILES["fileb"]['size'] <= $MAXIMUM_FILESIZE){
									$F = explode(".",$_FILES["fileb"]["name"]);
									$C = count($F);
									$CT = $C-1;
									$dir = strtolower($F[$CT]);

									if($dir == "jpeg"){
										$dir = "jpg";
									}

									$picname = $nfile.".".$dir;
									if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
											copy($_FILES["fileb"]["tmp_name"],$Current_Dir.$picname);
											@chmod ($Current_Dir.$picname, 0777);
											if($ad_pic_b != ""){
												@unlink($Current_Dir.$ad_pic_b);
											}
											$ad_pic_b = $picname;
									}else{
										$chsize="N"; 
											?>
								<script language="JavaScript">alert('Image type is not correct (*.jpg, *.gif, *.png).');</script>
								<?php	
									}
						}else{
								$chsize="N"; 
							    ?>
								<script language="JavaScript">alert('Image file size of \"<?php echo $_FILES["fileb"]["name"]."\" size[".number_format($_FILES["fileb"]['size']/1024,2)." Kb]";?> is over maximum.\nPlease change or resize your file.');</script>
								<?php	
						}
						
						

										if($chsize != "N"){								
												$F = explode(".",$ad_pic_b);
												$dir = strtolower($F[1]);
												$tpicname = $tfile.".".$dir;
												            $size = @getimagesize($Current_Dir.$ad_pic_b);
															$chi = $size[1];
															$cwi = $size[0];
																	// resize orginal
																	if($chi > $global_height OR $cwi > $global_width){
																			if($dir == "jpg"){
																				thumb_jpg($Current_Dir.$ad_pic_b,$Current_Dir.$ad_pic_b, $global_width, $global_height);
																			}
																			if($dir == "gif"){
																				thumb_gif($Current_Dir.$ad_pic_b,$Current_Dir.$ad_pic_b, $global_width, $global_height);
																			}
																			if($dir == "png"){
																				thumb_png($Current_Dir.$ad_pic_b,$Current_Dir.$ad_pic_b, $global_width, $global_height);
																			}
																	}

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
																						//	@unlink($Current_Dir.$ad_pic_s);
																						}
										$ad_pic_s = $tpicname;
									}else{
										if($ad_pic_s != "" AND $ad_pic_s != $ad_pic_b){
												//	@unlink($Current_Dir.$ad_pic_s);
												$ad_pic_s = $ad_pic_b;
												}
										
									}
						}

		if($chsize != "N"){
			$update = "UPDATE article_detail SET ad_pic_s = '{$ad_pic_s}', ";
							
			$update .= "ad_pic_h = '{$ad_pic_h}', ad_pic_w = '{$ad_pic_w}', ";

			$update .= "ad_pic_b = '{$ad_pic_b}' WHERE article_detail.ad_id ='{$ad_id}' ";
			$db->query($update);

			$txt = esc($txt);
			$update_ad_des = "UPDATE article_detail SET ad_des = '{$txt}'  WHERE ad_id ='{$ad_id}' ";
			
			$db->query($update_ad_des);

		}
	?>		
	<script >
	self.location.href = "article_detail.php?nid=<?=$nid;?>";
	</script>		

<?php				
	}
	
if($_POST["Flag"] == "EEdit" AND $_POST["nid"] != "" AND $_POST["ad_id"] != ""){
$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$_POST["nid"]."/";
$ad_id = $_POST["ad_id"];
$ad_pic_b = $_POST["ad_pic_b"];
$ad_pic_w = $_POST["wbb"];
$ad_pic_h = $_POST["hbb"];

						$nfile = "n".date("YmdHis")."_".$ad_id;
						$tfile = "t".date("YmdHis")."_".$ad_id;
		
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

										$ad_pic_s = $tpicname;


				$update = "UPDATE article_detail SET ad_pic_s = '$ad_pic_s', ";
				$update .= "ad_pic_h = '$ad_pic_h', ad_pic_w = '$ad_pic_w' ";
				$update .= "  WHERE article_detail.ad_id ='$ad_id' ";
				$db->query($update);

	}
	if($_POST["Flag"] == "EDel" AND $_POST["nid"] != "" AND $_POST["ad_id"] != ""){
$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$_POST["nid"]."/";
$ad_id = $_POST["ad_id"];
$ad_pic_b = $_POST["ad_pic_b"];
$ad_pic_s = $_POST["ad_pic_s"];
$ad_pic_w = "200";
$ad_pic_h = "200";
@unlink($Current_Dir.$ad_pic_b);
@unlink($Current_Dir.$ad_pic_s);
				$update = "UPDATE article_detail SET ad_pic_s = '',ad_pic_b = '', ";
				$update .= "ad_pic_h = '$ad_pic_h', ad_pic_w = '$ad_pic_w' ";
				$update .= "  WHERE article_detail.ad_id ='$ad_id' ";
				$db->query($update);

	}
	/*if($_POST["posdisp"] != ""){
							$sql_l = $db->query("SELECT * FROM article_detail WHERE ad_id = '".$_POST["ad_id"]."' ");
							$C1 = $db->db_fetch_array($sql_l);
	?>
	<body id="Move01">
	<form action="article_upload.php" method="post" enctype="multipart/form-data" name="form<?php echo $_POST["posdisp"]; ?>" target="ftarget"><strong>รูปภาพ: </strong><?php  if($C1["ad_pic_s"] != ""){ ?><div align = "right"><a href="#change" onClick="ShowEdit(document.all.whc<?php echo $_POST["posdisp"]; ?>);"><img src="../theme/main_theme/photo_scenery.jpg" width="16" height="16" border="0" align="absmiddle"> แก้ไขขนาดภาพ</a> <a href="#del" onClick="DelP(document.form<?php echo $_POST["posdisp"]; ?>,document.all.pv<?php echo $_POST["posdisp"]; ?>);"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" align="absmiddle"> ลบรูปภาพ</a></div>
						<div id="whc<?php echo $_POST["posdisp"]; ?>" style="display:none">แก้ไขขนาดภาพ สูง: 
							<input name="hbb" type="text" id="hbb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wbb" type="text" id="wbb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> <input type="Button" name="Button" value=" Save " style="width:60 px" onClick="chkE(document.form<?php echo $_POST["posdisp"]; ?>,document.all.pv<?php echo $_POST["posdisp"]; ?>)">
						  </div>
						<?php } ?>
						<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $C1["ad_id"]; ?>">
						<input name="ad_pic_b" type="hidden" id="ad_pic_b" value="<?php echo $C1["ad_pic_b"]; ?>">
						<input name="ad_pic_s" type="hidden" id="ad_pic_s" value="<?php echo $C1["ad_pic_s"]; ?>">
						<input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>">
						<input name="posdisp" type="hidden" id="posdisp" value="<?php echo $_POST["posdisp"]; ?>">
						  <input name="Flag" type="hidden" id="Flag" value="EUpload">
						  <table width="<?php echo $C1["ad_pic_w"]; ?>" height="<?php echo $C1["ad_pic_h"]; ?>" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" >
							<tr> 
							  <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php if($C1["ad_pic_s"] != ""){ echo "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$nid."/".$C1["ad_pic_s"]; }else{ echo "../images/pic_preview.gif"; } ?>" ></td>
							</tr>
						  </table>
						  <input name="fileb" type="file" id="fileb"  size="10" onChange="activeC(this,document.all.wh<?php echo $_POST["posdisp"]; ?>,document.all.Button<?php echo $_POST["posdisp"]; ?>);"><input type="Button" name="Button<?php echo $_POST["posdisp"]; ?>" value=" Upload " style="width:60 px" onClick="chkU(document.form<?php echo $_POST["posdisp"]; ?>,document.all.pv<?php echo $_POST["posdisp"]; ?>)" disabled>
						  <div id="wh<?php echo $_POST["posdisp"]; ?>" style="display:none">สูง: 
							<input name="hb" type="text" id="hb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wb" type="text" id="wb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> 
						  </div>
						  </form><img style="display:none" name="pv<?php echo $_POST["posdisp"]; ?>" id="pv<?php echo $_POST["posdisp"]; ?>" src= "../images/o.gif" >
	</body>
	<script language="javascript">
	self.parent.document.all.previewp<?php echo $_POST["posdisp"]; ?>.innerHTML = document.all.Move01.innerHTML;
	</script>
	<?php
	}*/
$db->db_close(); ?>
