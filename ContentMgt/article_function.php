<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

/*echo "<pre>";
print_r($_POST);
print_r($_FILES);
echo "</pre>";*/


//exit;

$global_height = "400";
$global_width = "500";

$sql_Imsize = "select * from site_info";
$query_Imsize = $db->query($sql_Imsize);
$rec_Imsize = $db->db_fetch_array($query_Imsize);

$max_img_size=$rec_Imsize[site_info_max_img]*1024;

if($_POST["Flag"] == "UploadIcon" AND $_FILES["icon"]['size'] > 0){
	if($_FILES['icon']['size'] < $max_img_size ){

		    $Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/icon/";
			$F = explode(".",$_FILES["icon"]["name"]);
			$C = count($F);
			$CT = $C-1;
			$dir = strtolower($F[$CT]);
			if($dir == "jpeg"){ $dir = "jpg"; } 
            
			$picname = 'icon'.date("YmdHis").".".$dir;

		/*
		    include("../ewt_thumbnail.php");
            $size = @getimagesize($icon);
			$hi = $size[1];
			$wi = $size[0];
            
			if($hi > 30){
				$hi_p=30/$hi;
				$wi=$wi*$hi_p;

					if($ftype[1] == "jpg"){
							thumb_jpg($icon,'../ewt/'.$EWT_FOLDER_USER.'/icon/'.$picname, $wi, "30");
							thumb_jpg($icon,'pic/'.$picname, $wi, "30");
						} // if jpg
						if($ftype[1] == "gif"){
							thumb_gif($icon,'../ewt/'.$EWT_FOLDER_USER.'/icon/'.$picname, $wi, "30");
							thumb_gif($icon,'pic/'.$picname, $wi, "30");
						} // if gif
						if($ftype[1] == "png"){
							thumb_png($icon,'../ewt/'.$EWT_FOLDER_USER.'/icon/'.$picname, $wi, "30");
							thumb_png($icon,'pic/'.$picname,$wi, "30");
						} // if png

			}
*/

			if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
					copy($_FILES["icon"]["tmp_name"],$Path_true.$picname);
					@chmod ($Path_true.$picname, 0777);
			       $Err_msg='เพิ่ม Icon ใหม่เรียบร้อย';
			}else{
			  $Err_msg='ไฟล์ภาพต้องเป็นนามสกุล .jpeg .png	หรือ .gif เท่านั้น';
			}
	}else{
			 $Err_msg='ไฟล์ ภาพต้องมีขนาดไม่เกิน  '.($max_img_size/1024).' Kb.';
	}
	?><script language="javascript">  
		alert('<?php echo $Err_msg;?>');
		location.href="article_iconmgt.php"; 
	</script><?php
}

if($_POST["Flag"] == "Del_Icon"){

        for($i=0;$i<$_POST[all_count];$i++){
			$a=$_POST[chkdel.$i];
			if($a<>''){
				$Path_del = "../ewt/".$_SESSION["EWT_SUSER"]."/icon/".$a;
				@unlink($Path_del);
			}
		}
	$Err_msg='ลบ Icon เรียบร้อย';

	?><script language="javascript">  
		alert('<?php echo $Err_msg;?>');
		location.href="article_iconmgt.php"; 
	</script><?php
}


		if($_POST["Flag"] == "CreateFolder"){
			$c_name = stripslashes(htmlspecialchars($_POST["gname"],ENT_QUOTES));

if($_POST["gshowpic"]=='Y'){
   $gpic=$_POST["link"];
}else{
   $gpic=$_POST["gshowpic"];
}
$db->query("INSERT INTO 
article_group (c_name,c_parent,c_show_search,c_show_sub,c_show_pic,c_show_date,c_show_detail,c_show_subnew,c_type,d_id,d_id_w3c) 
VALUES ('".$c_name."','".$_POST["p"]."','".$_POST["gshowsearch"]."','".$_POST["gshowsub"]."','".$gpic."','".$_POST["gshowdate"]."','".$_POST["gshowdetail"]."','$_POST[gshowsubnew]','$_POST[gtype]','".$_POST["select_template"]."','1') ");

//add order
$sql_u = "select * from article_group WHERE c_parent = '".$_POST["p"]."'";
$query1 = $db->query($sql_u);
$j=0;
while($rec1 = $db->db_fetch_array($query1)){
	$j++;
	if($rec1['d_id_w3c']=='1' || $j>0){
		$db->query("update article_group set d_id = '".($j)."',d_id_w3c = '0' WHERE c_id = '".$rec1['c_id']."'");
	}else{
		$db->query("update article_group set d_id = (d_id+1) WHERE c_id = '".$rec1['c_id']."'");
	}
}

//add permission
$sql_max = "select max(c_id) as cid from article_group";
$query = $db->query($sql_max);
$rec = $db->db_fetch_array($query);
$uid = explode(",",$_POST["hdd_uid"]);
$uorgid = explode(",",$_POST["hdd_uorg"]);
$ugroupid = explode(",",$_POST["hdd_ugroup"]);
$ugroup_personalid = explode(",",$_POST["hdd_ugroup_personal"]);
//user
if(count($uid)>0 && $_POST["hdd_uid"] != ''){
	for($i=0;$i<count($uid);$i++){
		$db->query("insert into article_group_permission (c_id,gen_user_id) values ('".$rec[cid]."','".$uid[$i]."')");
	}
}
//org
if(count($uorgid)>0 && $_POST["hdd_uorg"] != ''){
	for($i=0;$i<count($uorgid);$i++){
	$db->query("insert into article_group_permission (c_id,org_id) values ('".$rec[cid]."','".$uorgid[$i]."')");
	}
}
//gruop
if(count($ugroupid)>0 && $_POST["hdd_ugroup"] != ''){
	for($i=0;$i<count($ugroupid);$i++){
	$db->query("insert into article_group_permission (c_id,ug_id) values ('".$rec[cid]."','".$ugroupid[$i]."')");
	}
}
//type
if(count($ugroup_personalid)>0 && $_POST["hdd_ugroup_personal"] != ''){
	for($i=0;$i<count($ugroup_personalid);$i++){
	$db->query("insert into article_group_permission (c_id,emp_type_id) values ('".$rec[cid]."','".$ugroup_personalid[$i]."')");
	}
}

$db->write_log("create","article","สร้าง folder กลุ่ม article   ".$c_name);

   if($_POST[gtype]=='M'){ ?>
            <script language="javascript">
				//window.open('article_gselect.php?cid=<?php echo $rec[cid]; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');
                self.location.href = "article_gselect.php?cid=<?php echo $rec[cid]; ?>";
			</script>
  <?php    }else{
		if($_POST["p"] == ""){ ?>
			<script language="javascript">
				self.location.href = "article_group.php#bottom";
			</script>
		<?php }else{ ?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["p"]; ?>";
			</script>
		<?php }
    }
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

$R_name_old = $db->db_fetch_array($db->query("SELECT c_name FROM article_group WHERE  c_id = '".$_POST["cid"]."' "));
$db->write_log("update","article"," folder  article    " .$R_name_old[c_name]. "   " .$c_name);
//$db->query("UPDATE article_group SET c_name = '".$c_name."',c_parent = '".$_POST["c_parent"]."'  WHERE c_id = '".$_POST["cid"]."' ");


if($_POST["gshowpic"]=='Y'){
   $gpic=$_POST["link"];
}else{
   $gpic=$_POST["gshowpic"];
}
$db->query("UPDATE article_group SET 
c_name = '".$c_name."',
c_parent = '".$_POST["c_parent"]."' ,
c_show_search = '".$_POST["gshowsearch"]."' ,
c_show_sub = '".$_POST["gshowsub"]."' ,
c_show_pic = '".$gpic."' ,
c_show_date = '".$_POST["gshowdate"]."' ,
c_show_detail = '".$_POST["gshowdetail"]."' ,
c_show_subnew = '".$_POST["gshowsubnew"]."' ,
c_type = '".$_POST["gtype"]."' ,
d_id = '".$_POST["c_order"]."' ,
d_id_w3c = '".$_POST["select_template_w3c"]."' 
WHERE c_id = '".$_POST["cid"]."' ");

//d_id = '".$_POST["select_template"]."' ,

//edit permission
$db->query("delete from article_group_permission where c_id = '".$_POST["cid"]."' ");
$uid = explode(",",$_POST["hdd_uid"]);
$uorgid = explode(",",$_POST["hdd_uorg"]);
$ugroupid = explode(",",$_POST["hdd_ugroup"]);
$ugroup_personalid = explode(",",$_POST["hdd_ugroup_personal"]);
//user
if(count($uid)>0 && $_POST["hdd_uid"] != ''){
	for($i=0;$i<count($uid);$i++){
		$db->query("insert into article_group_permission (c_id,gen_user_id) values ('".$_POST["cid"]."','".$uid[$i]."')");
	}
}
//org
if(count($uorgid)>0 && $_POST["hdd_uorg"] != ''){
	for($i=0;$i<count($uorgid);$i++){
	$db->query("insert into article_group_permission (c_id,org_id) values ('".$_POST["cid"]."','".$uorgid[$i]."')");
	}
}
//gruop
if(count($ugroupid)>0 && $_POST["hdd_ugroup"] != ''){
	for($i=0;$i<count($ugroupid);$i++){
	$db->query("insert into article_group_permission (c_id,ug_id) values ('".$_POST["cid"]."','".$ugroupid[$i]."')");
	}
}
//type
if(count($ugroup_personalid)>0 && $_POST["hdd_ugroup_personal"] != ''){
	for($i=0;$i<count($ugroup_personalid);$i++){
	$db->query("insert into article_group_permission (c_id,emp_type_id) values ('".$_POST["cid"]."','".$ugroup_personalid[$i]."')");
	}
}
$sqlc = $db->query("SELECT c_parent FROM article_group WHERE c_id = '".$_POST["cid"]."' ");
$R = $db->db_fetch_row($sqlc);
			if($R[0] == "" OR $R[0] == "0"){
 			?>
			<script language="javascript">
				self.location.href = "article_group.php";
			</script>
			<?php
				}else{

			?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $R[0]; ?>";
			</script>
			<?php
				}
}
		if($_POST["Flag"] == "AddArticle"){
$topic = stripslashes(htmlspecialchars($_POST["topic"],ENT_QUOTES));
$description = stripslashes(htmlspecialchars($_POST["description"],ENT_QUOTES));
$picture = stripslashes(htmlspecialchars($_POST["picture"],ENT_QUOTES));
if($_POST["browsefile"]=='1'){
$link = addslashes($_POST["link"]);
}else{

$Current_Dir2 = "../ewt/".$_SESSION["EWT_SUSER"]."/download/article";
$Current_Dir3 = "download/article";
@mkdir ($Current_Dir2, 0777);
	if($_FILES["filebrowse"]['size'] > 0 ){
	$F = explode(".",$_FILES["filebrowse"]["name"]);
	$C = count($F);
	$CT = $C-1;
	$dir = strtolower($F[$CT]);
	
	//find type File
	
	$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
	$query_type_file = $db->query($sql_type_file);
	$R_type_file = $db->db_fetch_array($query_type_file);
	$type_file = $R_type_file[site_type_file];
	$pos = strpos($type_file,$dir);
		if($pos === FALSE){
		?>
		<script language="javascript1.2">
		alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด   <?php echo $type_file;?>   ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
		self.location.href = "article_new.php?cid=<?php echo $_POST["cid"]; ?>";
		</script>
		<?php
		}else{
			$nfile = "article_".date("YmdHis");
			$picname = $nfile.".".$dir;
			copy($_FILES["filebrowse"]["tmp_name"],$Current_Dir2."/".$picname);
			@chmod ($Current_Dir2."/".$picname, 0777);
			$link = $Current_Dir3."/".$picname;
		}
	}
}
$source = stripslashes(htmlspecialchars($_POST["source"],ENT_QUOTES));
$source_url = stripslashes(htmlspecialchars($_POST["source_url"],ENT_QUOTES));
$keyword = stripslashes(htmlspecialchars($_POST["keyword"],ENT_QUOTES));
$time_n = stripslashes(htmlspecialchars($_POST["time_n"],ENT_QUOTES));

$date = explode("/",$_POST["date_n"]);
$date_n = $date[2]."-".$date[1]."-".$date[0];

$date1 = explode("/",$_POST["date_e"]);
$date_e = $date1[2]."-".$date1[1]."-".$date1[0];

if($_POST["date_start"] != '' && $_POST["date_end"] != ''){
	if($_POST["time_H_start"] == ''){$_POST["time_H_start"] = '00';}
	if($_POST["time_s_start"] == ''){$_POST["time_s_start"] = '00';}
	if($_POST["time_H_end"] == ''){$_POST["time_H_end"] = '00';}
	if($_POST["time_s_end"] == ''){$_POST["time_s_end"] = '00';}
$time_st = $_POST["time_H_start"].':'.$_POST["time_s_start"].':00';
$time_ed = $_POST["time_H_end"].':'.$_POST["time_s_end"].':00';
$date_st = explode("/",$_POST["date_start"]);
$date_start = $date_st[2]."-".$date_st[1]."-".$date_st[0].' '.$time_st ;
$date_ed = explode("/",$_POST["date_end"]);
$date_end = $date_ed[2]."-".$date_ed[1]."-".$date_ed[0].' '.$time_ed ;
}else{
$date_start = '';
$date_end = '';
}

if($_SESSION["EWT_SMID"] != ""){
	$db->query("USE ".$EWT_DB_USER);
	$org = $db->query("SELECT name_org FROM `gen_user`  INNER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  WHERE gen_user_id = '".$_SESSION["EWT_SMID"]."'");
	$O = $db->db_fetch_row($org);
	$org_own = $O[0];
	$db->query("USE ".$_SESSION["EWT_SDB"]);
}
if($_POST["apl"] == "AP"){
$appove_a = "Y";
$dapp = date("Y-m-d");
}
if($_POST["detail_use"] == "1"){
$chk_count = $_POST["chk_show_count_level1"];
}else if($_POST["detail_use"] == "4"){
$chk_count = $_POST["chk_show_count"];
}

$address = $_POST["address1"]."#@#".$_POST["address2"];

$insert = "INSERT INTO article_list 
									(c_id,
									n_date,
									n_time,
									n_timestamp,
									n_topic,
									n_des,
									source,
									sourceLink,
									keyword,
									picture,
									news_use,
									at_id,
									link_html,
									target,
									expire,
									logo,
									n_new_modi,
									n_last_modi,
									n_owner,
									n_date_start,
									n_date_end,
									n_owner_org,
									n_approve,
									n_approvedate,
									show_count,
									n_address
									)  VALUES 
									('".$_POST["cid"]."',
									'$date_n',
									'$time_n',
									'".date("Y-m-d H:i:s")."',
									'$topic',
									'$description',
									'$source',
									'$source_url',
									'$keyword',
									'$picture',
									'".$_POST["detail_use"]."',
									'".$_POST["at_id"]."',
									'$link',
									'".$_POST["target"]."',
									'$date_e',
									'{$_POST["icon"]}',
									'".date('YmdHis')."',
									'".date('YmdHis')."',
									'{$_SESSION["EWT_SMID"]}',
									'{$date_start}',
									'{$date_end}',
									'{$org_own}',
									'{$appove_a}',
									'{$dapp}',
									'{$chk_count}',
									'{$address}' 
									)";

$db->query($insert);
$db->write_log("create","article","สร้าง article " .$topic);

// rss  Thailand //
Gen_RSS($_POST["cid"]);

$sql_max = $db->query("SELECT MAX(n_id) FROM article_list WHERE c_id = '".$_POST["cid"]."' AND n_topic = '$topic' ");
$M = $db->db_fetch_row($sql_max);
$nid = $M[0];

$Current_DirVdo = "../ewt/".$_SESSION["EWT_SUSER"]."/download/file_vdo";


if($_POST['showvdo'] == '1'){
	
for($i=0;$i<$_POST['temp_num'];$i++){
	

if($_FILES['filevdo']['tmp_name'][$i] != ""){
	
$MAXIMUM_FILESIZE = 10 * 1024 * 1024; 
//  Valid file extensions (images, word, excel, powerpoint) 
$rEFileTypes = 
  "/^\.(mp4){1}$/i"; 
$dir_base = "files/"; 

$isFile = is_uploaded_file($_FILES['filevdo']['tmp_name'][$i]); 
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
                     trim($_FILES['filevdo']['name'][$i]));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	
	$newfile = "article_vdo_".date("YmdHis")."_".$i.$type_file;
	 
    if ($_FILES['filevdo']['size'][$i] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {
		
		  $isMove = move_uploaded_file ($_FILES['filevdo']['tmp_name'][$i],$Current_DirVdo.$newfile);
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
}


if($_POST['showvdo'] == '2'){
	
for($i=0;$i<$_POST['temp_num2'];$i++){
	

if($_POST['vdo_youtube'][$i] != ""){

	  
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
												'{$_POST[vdo_youtube][$i]}',
												'T',											
												NOW( )
												)";
$db->query($Sql_n2);	
}
	
	}
}



if($appove_a=="Y" && $_POST[approve_user] ==''){
	$db->query("USE ".$EWT_DB_USER);
			$sql_ewt =$db->db_fetch_array($db->query("select * from user_info where UID='".$_SESSION["EWT_SUID"]."'"));
			$db->query("USE ".$EWT_DB_NAME);
				$text_name =$topic;
				$text_dec =$description;
						if($_POST["detail_use"] == "2"){
							$text_link = "<a href=\"".$sql_ewt[url]."news_view.php?nid=".$nid."\" target=\"_blank\">";
						}else{
						$rest = substr($link, 0, 4);
							if($rest=='http'){
							$text_link .= "<a href=\"".$link."\" target=\"_blank\">";
							}else{
							$text_link .= "<a href=\"".$sql_ewt[url]."/".$link."\" target=\"_blank\">";
							}
						}
				$txt .= "- ".$text_link.$text_name."</a><br>";
				$txt .= $text_dec;
				$txt .= '<br>';
	$body = "ถึงท่านสมาชิกทุกท่าน  มีข่าวสารใหม่ขอแจ้งให้ทราบดังนี้";
	$G=$db->db_fetch_array($db->query("select * from article_group  WHERE c_id = '".$_POST["cid"]."' "));
	$subject = "<b>เรื่อง : ".$G['c_name']."</b>";
//File user login
		$db->query("USE ".$EWT_DB_USER);
		$sql_info =$db->db_fetch_array($db->query("select * from gen_user where gen_user_id='".$_SESSION["EWT_SMID"]."'"));
		$db->query("USE ".$EWT_DB_NAME);
		$name = $sql_info[name_thai].''.$sql_info[surname_thai];
		$db->query("INSERT INTO n_history (h_subject,h_from_n,h_from_e,h_body,h_attach,h_date,h_time,h_user) VALUES ('".addslashes($subject)."','".addslashes($name)."','".addslashes($sql_info[email_kh])."','".addslashes($body)."','',NOW( ),NOW( ),'0')");
		$hid = mysql_insert_id();
		$sql_group_enew =$db->query( "select * from n_group inner join n_group_member on n_group.g_id=n_group_member.g_id inner join n_member on  n_group_member.m_id=n_member.m_id where   g_name= '".$_POST["cid"]."' and m_active ='Y'");
		
		$nnn=$db->db_num_rows($sql_group_enew);
		$email_member = array();
		while($R_M=$db->db_fetch_array($sql_group_enew)){
			array_push($email_member,$R_M[m_email]);
			$db->query("INSERT INTO n_send (h_id,s_date,s_time,s_email) VALUES ('$hid',NOW( ),NOW( ),'$R_M[m_email]')");
		}
		
		$strTo2 = implode(",", $email_member);
		//$strTo2 = "atit604@gmail.com";
		$strSubject2 = "=?UTF-8?B?".base64_encode("แจ้งการอัพเดทข่าสาร")."?=";
		$strHeader2 = "MIME-Version: 1.0' . \r\n";
		$strHeader2 .= "Content-type: text/html; charset=utf-8\r\n"; 
		//$strHeader2 .= "From: <webmaster@".$_SERVER['PHP_SELF'].">\r\n";
		$strHeader2 .= "From: ".$mailmaster."\r\n";
		$strMessage .= "=================================<br>";
		$strMessage .= $subject."<br>";
		$strMessage .= $body."<br>";
		$strMessage .= "=================================<br>";
		$strMessage .= $txt."<br>";
		$strMessage .= "=================================<br>";

		$flgSends = @mail($strTo2,$strSubject2,$strMessage,$strHeader2);
		/*if($flgSends){
			echo $_SERVER['PHP_SELF'];
		}else{
			echo "on";
		}*/
			
//end send mail
}
//send mail
if($_POST[approve_user] =='Y'){

//multi search function
if($search_center == "Y"){    
	$db->ms_module='A'; 
	$db->ms_link_id=$nid;
	$db->multi_search_update();
}

$db->query("UPDATE article_list SET n_approve = 'Y' , n_approvedate = '".date("Y-m-d")."' WHERE n_id = '$nid'");
//send mail
			$db->query("USE ".$EWT_DB_USER);
			$sql_ewt =$db->db_fetch_array($db->query("select * from user_info where UID='".$_SESSION["EWT_SUID"]."'"));
			$db->query("USE ".$EWT_DB_NAME);
				$text_name =$topic;
				$text_dec =$description;
						if($_POST["detail_use"] == "2"){
								$text_link = "<a href=\"".$sql_ewt[url]."/ewt_news.php?nid=".$nid."\" target=\"_blank\">";
							}else{
							$rest = substr($link, 0, 4);
								if($rest=='http'){
								$text_link .= "<a href=\"".$link."\" target=\"_blank\">";
								}else{
								$text_link .= "<a href=\"".$sql_ewt[url]."/".$link."\" target=\"_blank\">";
								}
							}
				$txt .= "- ".$text_link.$text_name."</a><br>";
				$txt .= $text_dec;
				$txt .= '<br>';
$body = "<font face='MS Sans Serif' size=2>ถึงท่านสมาชิกทุกท่าน  มีข่าวสารใหม่ขอแจ้งให้ทราบดังนี้<br>".$txt."</font>";
$G=$db->db_fetch_array($db->query("select * from article_group  WHERE c_id = '".$_POST["cid"]."' "));
$subject = "เรื่อง".$G['c_name'];
//File user login
		$db->query("USE ".$EWT_DB_USER);
		$sql_info =$db->db_fetch_array($db->query("select * from gen_user where gen_user_id='".$_SESSION["EWT_SMID"]."'"));
		$db->query("USE ".$EWT_DB_NAME);
		$name = $sql_info[name_thai].''.$sql_info[surname_thai];
		$db->query("INSERT INTO n_history (h_subject,h_from_n,h_from_e,h_body,h_attach,h_date,h_time,h_user) VALUES ('".addslashes($subject)."','".addslashes($name)."','".addslashes($sql_info[email_kh])."','".addslashes($body)."','',NOW( ),NOW( ),'0')");
		$hid = mysql_insert_id();
		$sql_group_enew =$db->query( "select * from n_group inner join n_group_member on n_group.g_id=n_group_member.g_id inner join n_member on  n_group_member.m_id=n_member.m_id where   g_name= '".$_POST["cid"]."' and m_active ='Y'");
		
		$nnn=$db->db_num_rows($sql_group_enew);
		echo  "num>>".$nnn;
		while($R_M=$db->db_fetch_array($sql_group_enew)){
		array_push($email_member,$R_M[m_email]);
		$db->query("INSERT INTO n_send (h_id,s_date,s_time,s_email) VALUES ('$hid',NOW( ),NOW( ),'$R_M[m_email]')");
		}
		$to = implode(",", $email_member);
		$message = '
						<html>
						<head>
						 <title>'.$subject.'</title>
						</head>
						<body>'.$body.'
						</body>
						</html>
						';
						/* To send HTML mail, you can set the Content-type header. */
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8\r\n";
				
				/* additional headers */
				$headers .= "From: ".$name." <".$sql_info[email_kh].">\r\n";
		//$headers .= "From: webmaster@prd.go.th<webmaster@prd.go.th>\r\n";
		@mail($to, $subject, $message, $headers);
//end send mail
}
$nfile = "n".date("Ymd")."_".$nid;
$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$nid;
if(!is_dir($Current_Dir)) {
mkdir ($Current_Dir, 0777,true);
}

if($_FILES['file']['size'] > 0 AND $_FILES['file']['size'] <= $max_img_size){
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
		
            $size = @getimagesize($Current_Dir."/".$picname);
			$chi = $size[1];
			$cwi = $size[0];
					// resize orginal
					if($chi > $global_height OR $cwi > $global_width){
							if($dir == "jpg"){
								thumb_jpg($Current_Dir."/".$picname,$Current_Dir."/".$picname, $global_width, $global_height);
							}
							if($dir == "gif"){
								thumb_gif($Current_Dir."/".$picname,$Current_Dir."/".$picname, $global_width, $global_height);
							}
							if($dir == "png"){
								thumb_png($Current_Dir."/".$picname,$Current_Dir."/".$picname, $global_width, $global_height);
							}
					}
					//resize thumb
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
}else{
	if($_FILES['file']['size'] > $max_img_size){
		     ?>
					<script language="JavaScript">alert('Image file size of \"<?php echo $_FILES["file"]["name"]."\" size[".number_format($_FILES['file']['size']/1024,2)." Kb]";?> is over maximum.\nPlease change or resize your file.')</script>
			<?php
	}
}

if($_POST["detail_use"] == "2"){
if($_POST["at_id"] != '10'){
	$temp = $db->query("SELECT at_file_new FROM article_template WHERE at_id = '".$_POST["at_id"]."'");
	$T = $db->db_fetch_row($temp);
	include("../article_template/code/".$T[0]); 
			?>
				<script language="javascript">
					self.location.href = "article_detail.php?nid=<?php echo $nid; ?>";
				</script>
			<?php
}else{
$db->query("INSERT INTO article_detail ( n_id , at_type_col , at_type_row , ad_pic_s , ad_pic_h , ad_pic_w , ad_pic_b , ad_des , ad_font , ad_size , ad_bold , ad_italic , ad_color, ad_align ) VALUES ( '$nid', '1', '1', '', '200', '200', '', NULL , 'MS Sans Serif', '1', NULL , NULL , '#000000', 'left')");

?>

				<script language="javascript">
					//window.open("../ewt/<?php echo $EWT_FOLDER_USER; ?>/article_freestype.php?nid=<?php echo $nid; ?>","","width=800,height=550,resizable=1,scrollbars=1");
					self.location.href = "../ewt/<?php echo $EWT_FOLDER_USER; ?>/article_freestype.php?nid=<?php echo $nid; ?>";
				</script>
			<?php
}
}else if($_POST["detail_use"] == "3"){
for($i=1;$i<=$_POST[txtrow];$i++){
	for($y=1;$y<=$_POST[txtcol];$y++){
	$db->query("INSERT INTO article_detail ( n_id , at_type_col , at_type_row , ad_pic_s , ad_pic_h , ad_pic_w , ad_pic_b , ad_des , ad_font , ad_size , ad_bold , ad_italic , ad_color, ad_align ) VALUES ( '$nid', '".$y."', '".$i."', '', '200', '200', '', NULL , 'MS Sans Serif', '1', NULL , NULL , '#000000', 'center')");
	}
}
			?>
				<script language="javascript">
					self.location.href = "article_detail.php?nid=<?php echo $nid; ?>";
				</script>
			<?php
}else if($_POST["detail_use"] == "4"){
					if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp")) {
						@mkdir("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp",0700);
					}
		if($_FILES['filedl']['size'] > 0 ){
		$myfile = "tmp".$_SESSION["EWT_SMID"]."A".$nid."O".date("YmdHis").".tmp";
		$myname = $_FILES['filedl']['name'];
		$mysize = $_FILES['filedl']['size'];
		$mytype = $_FILES['filedl']['type'];
		//find type File
			$F = explode(".",$_FILES["filedl"]["name"]);
			$C = count($F);
			$CT = $C-1;
			$dir = strtolower($F[$CT]);
			$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
			$query_type_file = $db->query($sql_type_file);
			$R_type_file = $db->db_fetch_array($query_type_file);
			$type_file = $R_type_file[site_type_file];
			$pos = strpos($type_file,$dir);
				if($pos === FALSE){
				?>
				<script language="javascript1.2">
					alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด   <?php echo $type_file;?>   ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
				self.location.href = "article_edit.php?cid=<?php echo $_POST["cid"]; ?>&nid=<?php echo $nid;?>";
				</script>
				<?php
				}else{
				copy($_FILES["filedl"]["tmp_name"],"../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$myfile);
				@chmod ("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$myfile, 0777);
				}
				$db->query("INSERT INTO download_list (dl_name,dl_userfile,dl_sysfile,dl_filetype,dl_filesize,dl_gid) VALUES ('".$_POST["chk_member"]."','".$myname."','".$myfile."','".$mytype."','".$mysize."','".$nid."')");
				
		}		
		?>
						<script language="javascript">
							self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
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
				$db->query("UPDATE article_list SET d_id = '".$_POST["template"]."' ,d_id_w3c = '".$_POST["template_w3c"]."' ,show_group = '".$_POST["chk_group"]."',show_topic = '".$_POST["chk_topic"]."',show_date = '".$_POST["chk_date"]."',show_newstop = '".$_POST["chk_newsshow"]."',show_vote = '".$_POST["chk_vote"]."',show_comment = '".$_POST["chk_comment"]."' ,comment_type='".$_POST["comment_type"]."',show_textsize='".$_POST[chk_textsize]."',show_count='".$_POST["chk_show_count"]."'  WHERE n_id = '".$_POST["nid"]."' ");
					/*			$url2 = "http://localhost/ewtadmin/ewt/".$EWT_FOLDER_USER."/ewt_news_body.php?nid=".$_POST["nid"]; 
								//$url2 = "../ewt/".$EWT_FOLDER_USER."/ewt_news_body.php?nid=".$_POST["nid"]; //pm
								$line = "";
								$fp = @fopen($url2 ,"r");
								if($fp){ 
									while($html = @fgets($fp, 1024)){
									$line .= $html;
									}
								}
								@fclose($fp);
								$line = eregi_replace("images/article/news","phpThumb.php?src=../".$EWT_FOLDER_USER."/images/article/news",$line);
								$fw = @fopen("../ewt/".$EWT_FOLDER_USER."/article/TEMP".$_POST["nid"].".html", "w");
								$FlagW = fwrite($fw, $line);
								@fclose($fw);
//multi search function
if($search_center == "Y"){    
	$db->ms_module='A'; 
	$db->ms_link_id=$_POST["nid"];
	$db->multi_search_update();
}

	*/		
				$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$_POST["nid"]."/";
	$keyword = "";
	$sql_keyword = $db->query("SELECT ad_des FROM article_detail WHERE n_id = '".$_POST["nid"]."' ORDER BY at_type_row,at_type_col ");
	while($D = $db->db_fetch_row($sql_keyword)){
	$keyword .= $D[0];
	}
$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");

$keyword = preg_replace ($search, $replace, $keyword);
$db->query("UPDATE article_list SET keyword = '".addslashes($keyword)."', n_last_modi='".date('YmdHis')."' WHERE  n_id = '".$_POST["nid"]."' ");

//multi search function
/*
if($search_center == "Y"){    
	$db->ms_module='A'; 
	$db->ms_link_id=$_POST["nid"];
	$db->multi_search_update();
}
*/
switch ($_POST["n_action"]) {
    case "save":
		?>
		<script language="javascript">
		//	self.location.href = "article_detail.php?nid=<?php echo $_POST["nid"]; ?>";
		</script>
		<?php
        break;
    case "preview":
			?>
			<script language="javascript">
				window.open("../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/news_view.php?nid=<?php echo $_POST["nid"]; ?>","artpv","width=800,height=550,resizable=1,scrollbars=1");
				//self.location.href = "article_detail.php?nid=<?php echo $_POST["nid"]; ?>";
			</script>
		<?php
        break;
    case "cancel":
            $db->query("UPDATE  article_list  SET n_approve='D' WHERE  n_id = '".$_POST["nid"]."'");
			?>
			<script language="javascript"> 
				self.parent.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
        break;
    case "exit":
			$db->query("update  article_list set n_last_modi='".date('YmdHis')."' where n_id = '".$_POST["cid"]."' ");
			?>
			<script language="javascript">
				self.parent.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
        break;
}
/*
	if($_POST["n_action"] == "save"){
			?>
			<script language="javascript">
			//	self.location.href = "article_detail.php?nid=<?php echo $_POST["nid"]; ?>";
			</script>
		<?php
	}
	if($_POST["n_action"] == "preview"){

			?>
			<script language="javascript">
				window.open("../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_news.php?nid=<?php echo $_POST["nid"]; ?>","artpv","width=800,height=550,resizable=1,scrollbars=1");
		//		self.location.href = "article_detail.php?nid=<?php echo $_POST["nid"]; ?>";
			</script>
		<?php
	}	*/
	/*
	if($_POST["n_action"] == "cancel"){
            //$db->query("Delete FROM article_list  WHERE  n_id = '".$_POST["nid"]."'");
            $db->query("UPDATE  article_list  SET n_approve='D' WHERE  n_id = '".$_POST["nid"]."'");

			?>
			<script language="javascript"> 
				self.parent.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
	}*/
	/*
	if($_POST["n_action"] == "exit"){
	$db->query("update  article_list set n_last_modi='".date('YmdHis')."' where n_id = '".$_POST["cid"]."' ");
			?>
			<script language="javascript">
				self.parent.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
		<?php
	}*/

}

if($_POST["Flag"] == "EditArticle"){

if($_POST["browsefile"]=='1'){
$link = addslashes($_POST["link"]);
}else{
$Current_Dir2 = "../ewt/".$_SESSION["EWT_SUSER"]."/download/article";
$Current_Dir3 = "download/article";
@mkdir ($Current_Dir2, 0777);
	if($_FILES["filebrowse"]['size'] > 0 ){
	$F = explode(".",$_FILES["filebrowse"]["name"]);
	$C = count($F);
	$CT = $C-1;
	$dir = strtolower($F[$CT]);
	
	//find type File
	
	$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
	$query_type_file = $db->query($sql_type_file);
	$R_type_file = $db->db_fetch_array($query_type_file);
	$type_file = $R_type_file[site_type_file];
	$pos = strpos($type_file,$dir);
		if($pos === FALSE){
		?>
		<script language="javascript1.2">
		alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด   <?php echo $type_file;?>   ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
		self.location.href = "article_edit.php?cid=<?php echo $_POST["cid"]; ?>&nid=<?php echo $_POST["nid"];?>";
		</script>
		<?php
		}else{
	
		$nfile = "article_".date("YmdHis");
		$picname = $nfile.".".$dir;
		copy($_FILES["filebrowse"]["tmp_name"],$Current_Dir2."/".$picname);
		unlink("../ewt/".$_SESSION["EWT_SUSER"]."/".$_POST["hdd_file"]);
		@chmod ($Current_Dir2."/".$picname, 0777);
		$link = $Current_Dir3."/".$picname;
		 }
	}
}
$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$_POST["nid"];
if(!file_exists($Current_Dir)){
@mkdir ($Current_Dir, 0777);
}
$picname = $_POST["pict"];
if($_POST["cpic"] == "Y"){
$picname ="";
}else{
$nfile = "n".date("Ymd")."_".$_POST["nid"];

if($_FILES['file']['size'] > 0 AND $_FILES['file']['size'] <= $max_img_size){
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

		include("../ewt_thumbnail.php");

						$size = @getimagesize($Current_Dir."/".$picname);
						$chi = $size[1];
						$cwi = $size[0];
								// resize orginal
								if($chi > $global_height OR $cwi > $global_width){
										if($dir == "jpg"){
											thumb_jpg($Current_Dir."/".$picname,$Current_Dir."/".$picname, $global_width, $global_height);
										}
										if($dir == "gif"){
											thumb_gif($Current_Dir."/".$picname,$Current_Dir."/".$picname, $global_width, $global_height);
										}
										if($dir == "png"){
											thumb_png($Current_Dir."/".$picname,$Current_Dir."/".$picname, $global_width, $global_height);
										}
								}

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
}
$topic = stripslashes(htmlspecialchars($_POST["topic"],ENT_QUOTES));
$description = stripslashes(htmlspecialchars($_POST["description"],ENT_QUOTES));

$source = stripslashes(htmlspecialchars($_POST["source"],ENT_QUOTES));
$source_url = addslashes($_POST["source_url"]);
$keyword = stripslashes(htmlspecialchars($_POST["keyword"],ENT_QUOTES));
$time_n = stripslashes(htmlspecialchars($_POST["time_n"],ENT_QUOTES));

$date = explode("/",$_POST["date_n"]);
$date_n = $date[2]."-".$date[1]."-".$date[0];

$date1 = explode("/",$_POST["date_e"]);
$date_e = $date1[2]."-".$date1[1]."-".$date1[0];


if($_POST["date_start"] != '' && $_POST["date_end"] != ''){
	if($_POST["time_H_start"] == ''){$_POST["time_H_start"] = '00';}
	if($_POST["time_s_start"] == ''){$_POST["time_s_start"] = '00';}
	if($_POST["time_H_end"] == ''){$_POST["time_H_end"] = '00';}
	if($_POST["time_s_end"] == ''){$_POST["time_s_end"] = '00';}
$time_st = $_POST["time_H_start"].':'.$_POST["time_s_start"].':00';
$time_ed = $_POST["time_H_end"].':'.$_POST["time_s_end"].':00';
$date_st = explode("/",$_POST["date_start"]);
$date_start = $date_st[2]."-".$date_st[1]."-".$date_st[0].' '.$time_st ;
$date_ed = explode("/",$_POST["date_end"]);
$date_end = $date_ed[2]."-".$date_ed[1]."-".$date_ed[0].' '.$time_ed ;
}else{
$date_start = '';
$date_end = '';
}
if($_POST["ctime"] == "Y"){
$date_start = '';
$date_end = '';
}
if($_POST["nuse"]== "1"){
$chk_count = $_POST["chk_show_count_level1"];
}else if($_POST["nuse"]== "4"){
$chk_count = $_POST["chk_show_count"];
}
$update = "UPDATE article_list SET c_id = '".$_POST["cid"]."',n_date = '$date_n',n_time = '$time_n', n_timestamp = '".date("Y-m-d H:i:s")."',n_topic = '$topic',n_des = '$description',source = '".$source."',sourceLink = '".$source_url."',link_html = '$link',target = '".$_POST["target"]."',picture = '$picname',expire = '$date_e',logo = '".$_POST["icon"]."' ,n_date_start = '".$date_start."' ,n_date_end ='".$date_end."' ,show_count='".$chk_count."' WHERE n_id = '".$_POST["nid"]."' ";
	$db->write_log("update","article"," article   ".$topic);
// rss  Thailand //
$db->query($update);

//multi search function
if($search_center == "Y"){    
	$db->ms_module='A'; 
	$db->ms_link_id=$_POST["nid"];
	$db->multi_search_update();
}

Gen_RSS($_POST["cid"]);
//if shere data to site other

$sql_shere = $db->query("select n_share,news_use,link_html from article_list where n_id ='".$_POST["nid"]."'");
$N = $db->db_fetch_array($sql_shere);
$typeuse = $N[news_use];
$typeshere =$N[n_share];
if($N[n_share] == 'Y'){
	$db->query('USE '.$EWT_DB_USER);
		//select site ยทาง
			$sql_sl = $db->query("select n_id_t,user_t,UID_t,user_s,UID_s from share_article where n_id = '".$_POST["nid"]."' and user_s = '".$_SESSION["EWT_SUSER"]."' ");
			while($SL = $db->db_fetch_array($sql_sl)){
			//update type  ewt_user
				$update = "UPDATE article_list SET n_date = '$date_n',n_topic = '$topic',n_des = '$description',source = '".$source."',sourceLink = '".$source_url."',link_html = '$link',target = '".$_POST["target"]."',picture = '$picname',expire = '$date_e',logo = '".$_POST["icon"]."'  WHERE n_id = '".$_POST["nid"]."' and user_share = '".$_SESSION["EWT_SUSER"]."' ";
			$db->query($update);

			//multi search function
			if($search_center == "Y"){    
				$db->ms_module='A'; 
				$db->ms_link_id=$_POST["nid"];
				$db->multi_search_update();
			}
				$sql_tb = $db->query("select * from user_info where UID ='".$SL[UID_s]."'");
					$T = $db->db_fetch_array($sql_tb);
					$url = $T[url];
					$sql_tb = $db->query("select * from user_info where UID ='".$SL[UID_t]."'");
					$TT = $db->db_fetch_array($sql_tb);
					$db_main = $TT[db_db];
				if($typeuse == "1"){
				$rest = substr($N[link_html], 0, 7);
					if($rest == "http://"){
						$linkhtml = $N[link_html];
					}else{
						$linkhtml = $url.$N[link_html];
					}
				}
		if($typeuse== "2" || $typeuse == "3"){
				$dec = base64_encode($SL[user_s]."@@@".$_POST["nid"]);
				$linkhtml = "ewt_snews.php?s=".$dec;
				

	/*			$url2 = "http://localhost/ewtadmin/ewt/".$SL[user_s]."/ewt_news_body.php?nid=".$_POST["nid"];
				//$url2 = "../ewt/".$SL[user_s]."/ewt_news_body.php?nid=".$_POST["nid"]; //pm
				$line = "";
				$fp = @fopen($url2 ,"r");
				if($fp){ 
					while($html = @fgets($fp, 1024)){
					$line .= $html;
					}
				}
				@fclose($fp);
				$line = eregi_replace("images/article/news","phpThumb.php?src=../".$SL[user_s]."/images/article/news",$line);
				
				$fw = @fopen("../ewt/".$SL[user_s]."/article/TEMP".$_POST["nid"].".html", "w");
				$FlagW = fwrite($fw, $line);
				@fclose($fw);	   */
			}
			if($typeuse == "4"){
				$linkhtml =$url."ewt_news.php?nid=".$_POST["nid"];
			}
		//tb
				
				$linkdata = $linkhtml;
				
				$db->query('USE '.$db_main);
				$update = "UPDATE article_list SET n_date = '$date_n',n_topic = '$topic',n_des = '$description',source = '".$source."',sourceLink = '".$source_url."',link_html = '$linkdata',target = '".$_POST["target"]."',picture = '$picname',expire = '$date_e',logo = '".$_POST["icon"]."',n_date_start = '".$date_start."' ,n_date_end ='".$date_end."'  WHERE n_id = '".$SL["n_id_t"]."' and n_shareuse = 'Y' ";
	
			$db->query($update);

			//multi search function
			if($search_center == "Y"){    
				$db->ms_module='A'; 
				$db->ms_link_id=$SL["n_id_t"];
				$db->multi_search_update();
			}
				$db->query('USE '.$EWT_DB_USER);
			}
			$db->query('USE '.$EWT_DB_NAME);
}
//End if 
if($_POST["nuse"] == "4"){
		if($_FILES['filedl']['size'] > 0 ){
		$myfile = "tmp".$_SESSION["EWT_SMID"]."A".$nid."O".date("YmdHis").".tmp";
		$myname = $_FILES['filedl']['name'];
		$mysize = $_FILES['filedl']['size'];
		$mytype = $_FILES['filedl']['type'];
		//find type File
			$F = explode(".",$_FILES["filedl"]["name"]);
			$C = count($F);
			$CT = $C-1;
			$dir = strtolower($F[$CT]);
			$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
			$query_type_file = $db->query($sql_type_file);
			$R_type_file = $db->db_fetch_array($query_type_file);
			$type_file = $R_type_file[site_type_file];
			$pos = strpos($type_file,$dir);
				if($pos === FALSE){
				?>
				<script language="javascript1.2">
				alert('ประเภทไฟล์ที่อนุญาติให้อัพโหลด   <?php echo $type_file;?>   ประเภทไฟล์ของท่านไม่ถูกต้องกรุณาลองอีกครั้ง');
				self.location.href = "article_edit.php?cid=<?php echo $_POST["cid"]; ?>&nid=<?php echo $_POST["nid"];?>";
				</script>
				<?php
				}else{
						if($mysize > 0 && $mysize <= 10240000){
						copy($_FILES["filedl"]["tmp_name"],"../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$myfile);
				    	@chmod ("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$myfile, 0777);
						@unlink("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$_POST["olddl_file"]);
					}else if($mysize > 10240000){
						copy($_FILES["filedl"]["tmp_name"],"../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$myname);
						@chmod ("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$myname, 0777);
						$myfile = "article_tmp/".$myname;
						@unlink("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$_POST["olddl_file"]);
					}
					$db->query("UPDATE download_list SET dl_userfile = '".$myname."',dl_sysfile = '".$myfile."',dl_filetype = '".$mytype."',dl_filesize = '".$mysize."' WHERE  dl_gid = '".$_POST["nid"]."' ");
				}
		}	
		$db->query("UPDATE download_list SET dl_name = '".$_POST["chk_member"]."' WHERE  dl_gid = '".$_POST["nid"]."' ");
}
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
						if($R["n_share"] == "Y"){

						$db->query("USE ".$EWT_DB_USER);

						$Share = $db->query("SELECT share_article.n_id_t,user_info.db_db FROM share_article INNER JOIN user_info ON share_article.user_t = user_info.EWT_User WHERE share_article.n_id = '".$chk."' AND share_article.user_s = '".$_SESSION["EWT_SUSER"]."' AND share_article.n_id_t != ''");
						while($S = $db->db_fetch_row($Share)){
							$db->query("USE ".$S[1]);
							$db->query("DELETE FROM article_list WHERE n_id = '".$S[0]."' ");
						}
							$db->query("USE ".$EWT_DB_USER);
							$db->query("DELETE FROM article_list  WHERE user_share = '".$_SESSION["EWT_SUSER"]."' AND n_id = '".$chk."' ");
							
							//multi search function
							if($search_center == "Y"){  
								$db->ms_module='A'; 
								$db->ms_link_id=$chk; 
								$db->multi_search_delete();
							}
					} 
				$db->query("USE ".$_SESSION["EWT_SDB"]);
				$db->write_log("delete","article","ลบ article    " .$R[n_topic]);
				//$db->query("DELETE FROM article_list WHERE n_id = '$chk'");
              //  $db->query("UPDATE  article_list  SET n_approve='D',n_share = '' WHERE  n_id = '$chk'  ");
				 $db->query("UPDATE  article_list  SET n_approve='D',n_share = '',n_delowner='".$_SESSION[EWT_SMID]."' ,n_deldate='".date('YmdHis')."' WHERE  n_id = '$chk'  ");
				Gen_RSS($cid);	
			}
	}
	
	
	?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["cid"]; ?>";
			</script>
	<?php
}	

			function LooPDel($p){
					$dir=@opendir($p);
					//echo $p;
					while($data=@readdir($dir)){
						if(($data!=".")and($data!="..")and($data!="")){
							if(!@unlink($p."/".$data)){
								LooPDel($p."/".$data);
							}
						}
					}
					@closedir($dir);
					@rmdir($p);
			}
if($_POST["Flag"] == "RemoveArticle"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
			if($chk != ""){
				$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '$chk' ");
				$R = $db->db_fetch_array($sql_edit);
				$cid=$R[c_id];
				$db->write_log("delete","article","ลบ article    " .$R[n_topic]);
				$db->query("DELETE FROM article_list WHERE n_id = '$chk'");

				//multi search function
							if($search_center == "Y"){  
								$db->ms_module='A'; 
								$db->ms_link_id=$chk; 
								$db->multi_search_delete();
							}
                //$db->query("UPDATE  article_list  SET n_approve='D' WHERE  n_id = '$chk'  ");
				//remove folder
				if($R[news_use] == '1'){
					$rest = substr($R[link_html], 0, 7);
					if($rest == "http://"){
					}else{
						@unlink("../ewt/".$_SESSION["EWT_SUSER"]."/images/article/freetemp/".$R[link_html]);
					}
			
				}else if($R[news_use] == '2' || $R[news_use] == '3'){
					$path = '../ewt/'.$EWT_FOLDER_USER."/images/article";
					if(!@rmdir($path."/news".$chk)){

					}
					LooPDel($path."/news".$chk);
					$pathall = "../ewt/".$EWT_FOLDER_USER."/article/TEMP".$chk.".html";
					@unlink($pathall);
				}else if($R[news_use] == '4'){
					$sql_f = "select * from download_list WHERE  dl_gid = '".$chk."' ";
					$query_f = $db->query($sql_f);
					$F = $db->db_fetch_array($query_f);
					$FileU = $F[dl_sysfile];
					@unlink("../ewt/".$_SESSION["EWT_SUSER"]."/article_tmp/".$FileU);
					$db->query("DELETE FROM download_list WHERE dl_gid = '$chk'");
				}
				Gen_RSS($cid);	
			}
	}
	
	
	?>
			<script language="javascript">
				self.location.href = "article_dellist.php";
			</script>
	<?php
}	

if($_POST["Flag"] == "CancelDelete"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
			if($chk != ""){
				$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '$chk' ");
				$R = $db->db_fetch_array($sql_edit);
				$cid=$R[c_id];
				$db->write_log("cancel delete","article","ลบ article    " .$R[n_topic]);
				//$db->query("DELETE FROM article_list WHERE n_id = '$chk'");
                $db->query("UPDATE  article_list  SET n_approve='' WHERE  n_id = '$chk'  ");
				
				Gen_RSS($cid);	
			}
	}
	
	
	?>
			<script language="javascript">
				self.location.href = "article_dellist.php";
			</script>
	<?php
}	
	


											if($_POST["Flag"] == "AppArticle"){
		$db->query("USE ".$EWT_DB_USER);
		$sql_ewt =$db->db_fetch_array($db->query("select * from user_info where UID='".$_SESSION["EWT_SUID"]."'"));
		$db->query("USE ".$EWT_DB_NAME);
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["app".$i];
		$nid = $_POST["nid".$i];
		$R=$db->db_fetch_array($db->query("select * from article_list  WHERE n_id = '$nid' "));
		
			if($chk == "Y"){
				if($R["n_approve"] <> "Y"){
				$text_name =$R[n_topic];
				$text_dec =$R[n_des];
							if($R["news_use"] == "2" || $R["news_use"] == "3"){
						/*		$url2 = "../ewt/".$EWT_FOLDER_USER."/ewt_news_body.php?nid=".$R["n_id"];
								$line = "";
								$fp = @fopen($url2 ,"r");
								if($fp){ 
									while($html = @fgets($fp, 1024)){
									$line .= $html;
									}
								}
								@fclose($fp);
								$line = eregi_replace("images/article/news","phpThumb.php?src=../".$EWT_FOLDER_USER."/images/article/news",$line);
								$fw = @fopen("../ewt/".$EWT_FOLDER_USER."/article/TEMP".$R["n_id"].".html", "w");
								$FlagW = fwrite($fw, $line);
								@fclose($fw);		 */
								$text_link = "<a href=\"".$sql_ewt[url]."/ewt_news.php?nid=".$R["n_id"]."\" target=\"_blank\">";
							}else{
							$rest = substr($R["link_html"], 0, 4);
								if($rest=='http'){
								$text_link .= "<a href=\"".$R["link_html"]."\" target=\"_blank\">";
								}else{
								$text_link .= "<a href=\"".$sql_ewt[url]."/".$R["link_html"]."\" target=\"_blank\">";
								}
							}
				$txt .= "- ".$text_link.$text_name."</a><br>";
				$txt .= $text_dec;
				$txt .= '<br>';
				}
				$db->query("UPDATE article_list SET n_approve = 'Y' , n_approvedate = '".date("Y-m-d")."' WHERE n_id = '$nid'");
				$db->write_log("approve","article","อนุมติ article    " .$R[n_topic]);
				
				//multi search function
				if($search_center == "Y"){  
					$db->ms_module='A'; 
					$db->ms_link_id=$nid;
					$db->multi_search_update();
				}

				/*	if($R["n_share"] == "Y"){
						$db->query("USE ".$EWT_DB_USER);
						$db->query("UPDATE article_list SET ");
					} */
			}else{
				$db->query("UPDATE article_list SET n_approve = '' , n_approvedate = '".date("Y-m-d")."' WHERE n_id = '$nid'");
				$db->write_log("approve","article","ยกเลิกการอนุมัติ article    " .$R[n_topic]);

				//multi search function
				if($search_center == "Y"){  
					$db->ms_module='A'; 
					$db->ms_link_id=$nid;
					$db->multi_search_update();
				}
			}
	}
	Gen_RSS($_POST["cid"]);
	//include('libmail.php');
	if(!empty($txt)){
	$email_member = array();
	$body = "<font face='MS Sans Serif' size=2>ถึงท่านสมาชิกทุกท่าน  มีข่าวสารใหม่ขอแจ้งให้ทราบดังนี้<br>".$txt."</font>";

		$G=$db->db_fetch_array($db->query("select * from article_group  WHERE c_id = '".$_POST["cid"]."' "));
		$subject = "เรื่อง".$G['c_name'];
		//File user login
		$db->query("USE ".$EWT_DB_USER);
		$sql_info =$db->db_fetch_array($db->query("select * from gen_user where gen_user_id='".$_SESSION["EWT_SMID"]."'"));
		$db->query("USE ".$EWT_DB_NAME);
		$name = $sql_info[name_thai].''.$sql_info[surname_thai];
		$db->query("INSERT INTO n_history (h_subject,h_from_n,h_from_e,h_body,h_attach,h_date,h_time,h_user) VALUES ('".addslashes($subject)."','".addslashes($name)."','".addslashes($sql_info[email_kh])."','".addslashes($body)."','',NOW( ),NOW( ),'0')");
		$hid = mysql_insert_id();
		$sql_group_enew =$db->query( "select * from n_group inner join n_group_member on n_group.g_id=n_group_member.g_id inner join n_member on  n_group_member.m_id=n_member.m_id where   g_name= '".$_POST["cid"]."' and m_active ='Y'");
		while($R_M=$db->db_fetch_array($sql_group_enew)){
		array_push($email_member,$R_M[m_email]);
		/*$m = new Mail();
		$m->From($name."<".trim($sql_info[email_kh]).">");
		$m->Subject($subject);
		$m->Body($body,"text/html");
		$m->To(trim($R_M[m_email]));
		$m->Send();*/
		$db->query("INSERT INTO n_send (h_id,s_date,s_time,s_email) VALUES ('$hid',NOW( ),NOW( ),'$R_M[m_email]')");
		}
		$to = implode(",", $email_member);
		$message = '
						<html>
						<head>
						 <title>'.$subject.'</title>
						</head>
						<body>'.$body.'
						</body>
						</html>
						';
						/* To send HTML mail, you can set the Content-type header. */
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8\r\n";
				
				/* additional headers */
				$headers .= "From: ".$name." <".$sql_info[email_kh].">\r\n";

		@mail($to, $subject, $message, $headers);
		$db->write_log("sendmail","enews","ส่ง E-mail จดหมายข่าว เรื่อง  ".$subject);
	}
				?>
			<script language="javascript">
					<?php if($_POST["backto"] != ""){ ?>
				self.location.href = "<?php echo $_POST["backto"]; ?>";
				<?php }else{ ?>
					self.location.href = "article_group.php";
					<?php } ?>
			</script>
		<?php
}		
	if($_POST["Flag"] == "DelGroup"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
			if($chk != ""){
			$R_name_old = $db->db_fetch_array($db->query("SELECT c_name FROM article_group WHERE  c_id = '".$chk."' "));
			$db->write_log("delete","article","ลบ".$R_name_old[c_name]);
				$db->query("DELETE FROM article_group WHERE c_id = '$chk'");
				$db->query("DELETE FROM article_apply WHERE c_id = '$chk'");
				$db->query("DELETE FROM article_list WHERE c_id = '$chk'");
	            $db->query("DELETE FROM article_multigroup WHERE c_id = '$chk' ");

				//multi search function
					if($search_center == "Y"){  
						$db->ms_module='A'; 
						$db->ms_link_id=$chk; 
						$db->multi_search_delete();
					}
					
					//update order
					if($_POST["p"]!=""){
						$sql_u = "select * from article_group WHERE c_parent = '".$_POST["p"]."' order by d_id asc";
						$query1 = $db->query($sql_u);
						$j=0;
						while($rec1 = $db->db_fetch_array($query1)){
							$j++;
							$db->query("update article_group set d_id = '".$j."' WHERE c_id = '".$rec1['c_id']."'");
						}
					}else{
						$sql_u = "select * from article_group WHERE c_parent = '0' order by d_id asc";
						$query1 = $db->query($sql_u);
						$j=0;
						while($rec1 = $db->db_fetch_array($query1)){
							$j++;
							$db->query("update article_group set d_id = '".$j."' WHERE c_id = '".$rec1['c_id']."'");
						}
					}		
							
			}
			
			$filename = "../ewt/".$_SESSION["EWT_SUSER"]."/rss/group".$chk.".xml";
            @unlink($filename);
	}
				if($_POST["p"] == ""){
				?>
			<script language="javascript">
				self.location.href = "article_group.php";
			</script>
		<?php
				exit;
			}else{
		?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["p"]; ?>";
			</script>
		<?php
				exit;
				}
}		

if($_POST["Flag"] == "SetRSS"){
    $db->query("Update article_group SET c_rss='' WHERE c_id = '$chk'");
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chkrss".$i];
		$nid = $_POST["chkrssH".$i];
		$R_name_old = $db->db_fetch_array($db->query("SELECT c_name FROM article_group WHERE  c_id = '".$chk."' "));
		if($chk != ""){
		$db->write_log("SetRSS","article","SetRSS กลุ่มข่าว/บทความ".$R_name_old[c_name]);
			$db->query("Update article_group SET c_rss='Y' WHERE c_id = '$chk'");
			Gen_RSS($chk);
		}else{
			$db->write_log("SetRSS","article","ยกเลิกการ SetRSS กลุ่มข่าว/บทความ".$R_name_old[c_name]);
			$db->query("Update article_group SET c_rss=NULL WHERE c_id = '$nid'");
			$filename = "../ewt/".$_SESSION["EWT_SUSER"]."/rss/group".$nid.".xml";
			if(file_exists($filename)){
               unlink($filename);
			}
		}
	}
				if($_POST["p"] == ""){
				?>
			<script language="javascript">
				self.location.href = "article_group.php";
			</script>
		<?php
				exit;
			}else{
		?>
			<script language="javascript">
				self.location.href = "article_list.php?cid=<?php echo $_POST["p"]; ?>";
			</script>
		<?php
				exit;
				}
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
$AMMORE = stripslashes(htmlspecialchars($_POST["AMMORE"],ENT_QUOTES));
$AMBottomF = $_POST["AMBottomF"];
$AMBottomS = $_POST["AMBottomS"];
$AMBottomC = $_POST["AMBottomC"];
$AMBottomB = $_POST["AMBottomB"];
$AMBottomI = $_POST["AMBottomI"];
$AMBOTTOMP = $_POST["AMBOTTOMP"];
$AMBOTTOMH = $_POST["AMBOTTOMH"];
$AMBOTTOMBG = $_POST["AMBOTTOMBG"];
$code_html1 = addslashes($_POST["code_html"]);
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
$AMBulletBPW = $_POST["AMBulletBPW"];
$AMBulletBPH = $_POST["AMBulletBPH"];
$AMBulletSPW = $_POST["AMBulletSPW"];
$AMBulletSPH = $_POST["AMBulletSPH"];
$AMBodyBPW = $_POST["AMBodyBPW"];
$AMBodyBPH = $_POST["AMBodyBPH"];

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
if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/article")) {
	@mkdir("../ewt/".$_SESSION["EWT_SUSER"]."/article",0700);
}
if($_POST["cancelCode"] == "Y"){
$code_html = "";
}else{
	if($_FILES["file_html"]['size'] > 0 ){
		$tmpname = "DA_".$_POST["aid"].".htm";
	copy($_FILES["file_html"]["tmp_name"],"../ewt/".$_SESSION["EWT_SUSER"]."/article/".$tmpname);
	$code_html = "Y";
	}else{
	$code_html = $code_html1;
	}
}
//////////////////////////////////////////////////////////////////

$update = "UPDATE article_apply SET amd_mode = '$amd_mode',code_html = '$code_html',AMBulletBP = '$AMBulletBP',AMBulletSP = '$AMBulletSP',AMHeadBG = '$AMHeadBG',AMHeadP = '$AMHeadP',AMHeadF = '$AMHeadF',AMHeadS = '$AMHeadST',AMHeadC = '$AMHeadC',AMHeadB = '$AMHeadB',AMHeadI = '$AMHeadI',AMBodyBP = '$AMBodyBP',AMBodyBG = '$AMBodyBG',AMBodyF = '$AMBodyF',AMBodyS = '$AMBodyST',AMBodyC = '$AMBodyC',AMBodyB = '$AMBodyB',AMBodyI = '$AMBodyI',AMMorePic = '$AMMorePic',AMMORE = '$AMMORE',AMBottomF = '$AMBottomF',AMBottomS = '$AMBottomST',AMBottomC = '$AMBottomC',AMBottomB = '$AMBottomB',AMBottomI = '$AMBottomI',AMBOTTOMP = '$AMBOTTOMP',AMBOTTOMH = '$AMBOTTOMH',AMBOTTOMBG = '$AMBOTTOMBG',AMDetailF = '$AMDetailF',AMDetailS = '$AMDetailST',AMDetailC = '$AMDetailC',AMDetailB = '$AMDetailB',AMDetailI = '$AMDetailI',a_show = '$a_show',AMWidth = '$AMWidth',AMDate = '$AMDate',AMUseHead = '$AMUseHead',AMHeadH = '$AMHeadH',AMUseDetail = '$AMUseDetail' ,AMBulletBPW = '$AMBulletBPW',AMBulletBPH = '$AMBulletBPH',AMBulletSPW = '$AMBulletSPW',AMBulletSPH = '$AMBulletSPH',AMBodyBPW = '$AMBodyBPW',AMBodyBPH = '$AMBodyBPH',block_theme = '".$_POST["select_block_design"]."' WHERE a_id = '".$_POST["aid"]."' ";

$db->query($update);

if($_POST["usedef"] == "Y"){
$db->query("UPDATE  article_apply SET AMDefault = '' ");
$db->query("UPDATE  article_apply SET AMDefault = 'Y' WHERE a_id = '".$_POST["aid"]."' ");
}
$sql_edit = $db->query("select block_name from block where BID ='".$_POST["B"]."'");
$R = $db->db_fetch_array($sql_edit);
$db->write_log("Design","article"," Design /".$R[block_name]);
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
				$block_link = $_POST["show_type"].'#'.$_POST["show_marquee"].'#'.$_POST["time_marquee"].'#'.$_POST["show_nextdata"];
				$block_name = $_POST['block_name'];
				$db->query("UPDATE block SET block_link = '".$block_link."', block_name = '".$block_name."' WHERE BID = '".$BID."'");
				$sql_edit = $db->query("select block_name from block where BID ='".$BID."'");
				$R = $db->db_fetch_array($sql_edit);
				$db->write_log("SetDisp","article","ตั้งค่าแสดงผลข่าว/บทความใน block : ".$R[block_name]);
				?>
		<script language="JavaScript">
				//window.close();
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
							
								$db->query("UPDATE article_apply SET a_show = '".$R["a_show"]."' ,amd_mode = '".$R["amd_mode"]."' ,code_html = '".$R["code_html"]."' ,AMBulletBP = '".$R["AMBulletBP"]."' ,AMBulletSP = '".$R["AMBulletSP"]."' ,AMHeadBG = '".$R["AMHeadBG"]."' ,AMHeadP = '".$R["AMHeadP"]."' ,AMHeadF = '".$R["AMHeadF"]."' ,AMHeadS = '".$R["AMHeadS"]."' ,AMHeadC = '".$R["AMHeadC"]."' ,AMHeadB = '".$R["AMHeadB"]."' ,AMHeadI = '".$R["AMHeadI"]."' ,AMBodyBP = '".$R["AMBodyBP"]."' ,AMBodyBG = '".$R["AMBodyBG"]."' ,AMBodyF = '".$R["AMBodyF"]."' ,AMBodyS = '".$R["AMBodyS"]."' ,AMBodyC = '".$R["AMBodyC"]."' ,AMBodyB = '".$R["AMBodyB"]."' ,AMBodyI = '".$R["AMBodyI"]."' ,AMMorePic = '".$R["AMMorePic"]."' ,AMMORE = '".$R["AMMORE"]."' ,AMBottomF = '".$R["AMBottomF"]."' ,AMBottomS = '".$R["AMBottomS"]."' ,AMBottomC = '".$R["AMBottomC"]."' ,AMBottomB = '".$R["AMBottomB"]."' ,AMBottomI = '".$R["AMBottomI"]."' ,AMBOTTOMP = '".$R["AMBOTTOMP"]."' ,AMBOTTOMBG = '".$R["AMBOTTOMBG"]."' ,AMBOTTOMH = '".$R["AMBOTTOMH"]."' ,AMWidth = '".$R["AMWidth"]."' ,AMUseHead = '".$R["AMUseHead"]."' ,AMHeadH = '".$R["AMHeadH"]."' ,AMUseDetail = '".$R["AMUseDetail"]."' ,AMDetailF = '".$R["AMDetailF"]."' ,AMDetailS = '".$R["AMDetailS"]."' ,AMDetailC = '".$R["AMDetailC"]."' ,AMDetailB = '".$R["AMDetailB"]."' ,AMDetailI = '".$R["AMDetailI"]."' ,AMDate = '".$R["AMDate"]."'  ,AMBulletBPW = '".$R["AMBulletBPW"]."',AMBulletBPH = '".$R["AMBulletBPH"]."',AMBulletSPW = '".$R["AMBulletSPW"]."',AMBulletSPH = '".$R["AMBulletSPH"]."',AMBodyBPW = '".$R["AMBodyBPW"]."',AMBodyBPH = '".$R["AMBodyBPH"]."',block_theme = '".$R["block_theme"]."' WHERE a_id = '".$a_id."' ");
								@copy("../ewt/".$_SESSION["EWT_SUSER"]."/article/DA_".$_POST["aid"].".htm","../ewt/".$_SESSION["EWT_SUSER"]."/article/DA_".$a_id.".htm");
							}
						}
						$sql_edit = $db->query("select block_name from block where BID ='".$_POST["B"]."'");
						$R = $db->db_fetch_array($sql_edit);
						$db->write_log("approve","article","อนุมัต ข่าว/บทความ".$R[block_name]);
				?>
		<script language="JavaScript">
				//self.location.href = "article_gdesign.php?B=<?php echo $_POST["B"]; ?>";
				self.close();
		</script>
	<?php
		}
		
		
function Gen_RSS($cid){
global $db,$EWT_DB_USER;
$db->query("USE ".$EWT_DB_USER);
$sql_url = $db->query("SELECT url FROM user_info WHERE UID = '".$_SESSION["EWT_SUID"]."' ");
$U = $db->db_fetch_row($sql_url);
$MyUrl = $U[0];
$db->query("USE ".$_SESSION["EWT_SDB"]);
$sql_url1 = $db->query("SELECT site_info_description,site_info_title  FROM site_info  ");
$U1 = $db->db_fetch_row($sql_url1);
$MyTitle = $U1[0];
$MyCopy = $U1[1];
$sql="SELECT * FROM article_group WHERE c_id='$cid'  ";
$query_rss=$db->query($sql);
$rss2=$db->db_fetch_array($query_rss);

			
if($rss2["c_rss"]=='Y'){

	$xml_text='<'.'?xml version="1.0" encoding="utf-8"?'.'>
	<rss version="2.0">
	<channel>
		  <title>'.$rss2["c_name"].'</title> 
		  <link>'.$MyUrl.'</link> 
		  <description>'.$MyTitle.'</description> 
		  <language>th-TH</language> 
		  <lastBuildDate>'.date('D,d M Y H:i:s e').'</lastBuildDate> 
		  <copyright>Copyright ? 2008 All rights reserved. '.$MyUrl.'</copyright> 
	';

	$query_rss=$db->query("SELECT * FROM article_list WHERE c_id='$cid' and n_approve='y'  ORDER BY n_id DESC limit 0,10 ");
	while($rss=$db->db_fetch_array($query_rss)){
	//$Urls="http://61.91.248.62/ewtadmin/ewt/".$_SESSION["EWT_SUSER"]."/ewt_news.php?nid=$rs[news_id]";
			if(eregi("www",$rss["link_html"]) AND !eregi("http://", $rss["link_html"])){
				$linkURL = str_replace('&',"&amp;","http://".$rss["link_html"]);
			}else if(eregi("http://", $rss["link_html"])){
				$linkURL = str_replace('&',"&amp;",$rss["link_html"]);
			}else{
				$aa = '&amp;';
				if($rss["news_use"] == "2" || $rss["news_use"] == "3"){
				$linkURL = $MyUrl."ewt_news.php?nid=".$rss["n_id"];
				}elseif($rss["news_use"] == "4"){
				$linkURL = $MyUrl."ewt_dl_link.php?nid=".$rss["n_id"];
				}else{
				$linkURL = $MyUrl.str_replace('&',"&amp;",$rss["link_html"]);
				}
				 	
			}
			if($rss["picture"] != ""){
				$rss_image = '<enclosure url="'.$MyUrl.'/images/article/news'.$rss["n_id"].'/'.$rss["picture"].'" />';
			}else{
			$rss_image = "";
			}
	$xml_text.='<item>
					<title>'.$rss["n_topic"].'</title>
					<link>'.$linkURL.'</link>
					'.$rss_image.'
					<description>'.$rss["n_des"].'</description>
					<pubDate>'.$rss["n_timestamp"].'</pubDate>
					<guid>'.$MyUrl.'</guid>
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
		
		
			$db->db_close(); 
			
function TIS620toUTF8($string) {
  //return $string;
     if ( ! ereg("[\241-\377]", $string) )
         return $string;
 
     $iso8859_11 = array(
				"\x93" => "\xe2\x80\x9c",
				"\x94" => "\xe2\x80\x9d",
				"\xa1" => "\xe0\xb8\x81",
				"\xa2" => "\xe0\xb8\x82",
				"\xa3" => "\xe0\xb8\x83",
				"\xa4" => "\xe0\xb8\x84",
				"\xa5" => "\xe0\xb8\x85",
				"\xa6" => "\xe0\xb8\x86",
				"\xa7" => "\xe0\xb8\x87",
				"\xa8" => "\xe0\xb8\x88",
				"\xa9" => "\xe0\xb8\x89",
				"\xaa" => "\xe0\xb8\x8a",
				"\xab" => "\xe0\xb8\x8b",
				"\xac" => "\xe0\xb8\x8c",
				"\xad" => "\xe0\xb8\x8d",
				"\xae" => "\xe0\xb8\x8e",
				"\xaf" => "\xe0\xb8\x8f",
				"\xb0" => "\xe0\xb8\x90",
				"\xb1" => "\xe0\xb8\x91",
				"\xb2" => "\xe0\xb8\x92",
				"\xb3" => "\xe0\xb8\x93",
				"\xb4" => "\xe0\xb8\x94",
				"\xb5" => "\xe0\xb8\x95",
				"\xb6" => "\xe0\xb8\x96",
				"\xb7" => "\xe0\xb8\x97",
				"\xb8" => "\xe0\xb8\x98",
				"\xb9" => "\xe0\xb8\x99",
				"\xba" => "\xe0\xb8\x9a",
				"\xbb" => "\xe0\xb8\x9b",
				"\xbc" => "\xe0\xb8\x9c",
				"\xbd" => "\xe0\xb8\x9d",
				"\xbe" => "\xe0\xb8\x9e",
				"\xbf" => "\xe0\xb8\x9f",
				"\xc0" => "\xe0\xb8\xa0",
				"\xc1" => "\xe0\xb8\xa1",
				"\xc2" => "\xe0\xb8\xa2",
				"\xc3" => "\xe0\xb8\xa3",
				"\xc4" => "\xe0\xb8\xa4",
				"\xc5" => "\xe0\xb8\xa5",
				"\xc6" => "\xe0\xb8\xa6",
				"\xc7" => "\xe0\xb8\xa7",
				"\xc8" => "\xe0\xb8\xa8",
				"\xc9" => "\xe0\xb8\xa9",
				"\xca" => "\xe0\xb8\xaa",
				"\xcb" => "\xe0\xb8\xab",
				"\xcc" => "\xe0\xb8\xac",
				"\xcd" => "\xe0\xb8\xad",
				"\xce" => "\xe0\xb8\xae",
				"\xcf" => "\xe0\xb8\xaf",
				"\xd0" => "\xe0\xb8\xb0",
				"\xd1" => "\xe0\xb8\xb1",
				"\xd2" => "\xe0\xb8\xb2",
				"\xd3" => "\xe0\xb8\xb3",
				"\xd4" => "\xe0\xb8\xb4",
				"\xd5" => "\xe0\xb8\xb5",
				"\xd6" => "\xe0\xb8\xb6",
				"\xd7" => "\xe0\xb8\xb7",
				"\xd8" => "\xe0\xb8\xb8",
				"\xd9" => "\xe0\xb8\xb9",
				"\xda" => "\xe0\xb8\xba",
				"\xdf" => "\xe0\xb8\xbf",
				"\xe0" => "\xe0\xb9\x80",
				"\xe1" => "\xe0\xb9\x81",
				"\xe2" => "\xe0\xb9\x82",
				"\xe3" => "\xe0\xb9\x83",
				"\xe4" => "\xe0\xb9\x84",
				"\xe5" => "\xe0\xb9\x85",
				"\xe6" => "\xe0\xb9\x86",
				"\xe7" => "\xe0\xb9\x87",
				"\xe8" => "\xe0\xb9\x88",
				"\xe9" => "\xe0\xb9\x89",
				"\xea" => "\xe0\xb9\x8a",
				"\xeb" => "\xe0\xb9\x8b",
				"\xec" => "\xe0\xb9\x8c",
				"\xed" => "\xe0\xb9\x8d",
				"\xee" => "\xe0\xb9\x8e",
				"\xef" => "\xe0\xb9\x8f",
				"\xf0" => "\xe0\xb9\x90",
				"\xf1" => "\xe0\xb9\x91",
				"\xf2" => "\xe0\xb9\x92",
				"\xf3" => "\xe0\xb9\x93",
				"\xf4" => "\xe0\xb9\x94",
				"\xf5" => "\xe0\xb9\x95",
				"\xf6" => "\xe0\xb9\x96",
				"\xf7" => "\xe0\xb9\x97",
				"\xf8" => "\xe0\xb9\x98",
				"\xf9" => "\xe0\xb9\x99",
				"\xfa" => "\xe0\xb9\x9a",
				"\xfb" => "\xe0\xb9\x9b"
				 );
 
     $string=strtr($string,$iso8859_11);
     return $string;
 }
			?>
