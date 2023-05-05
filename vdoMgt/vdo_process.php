<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");
//$file_type = array('jpg','swf','flv','mp3','wma','wmv','wav','avi','mpeg');
$file_type = array('mp4');
$file_type2 = array('jpg','gif','png','bmp');
$vdo_name=stripslashes(htmlspecialchars($_POST["vdo_name"],ENT_QUOTES));
$vdo_detail=stripslashes(htmlspecialchars($_POST["vdo_detail"],ENT_QUOTES));  
$vdo_creator=stripslashes(htmlspecialchars($_POST["vdo_creator"],ENT_QUOTES));
$vdo_info=stripslashes(htmlspecialchars($_POST["vdo_info"],ENT_QUOTES));

$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download/file_vdo";
$Current_Dir3= "../ewt/".$_SESSION["EWT_SUSER"]."/download";
$Current_Dir2 = "file_vdo";

$info_type = 0;
$info_type2 = 0;
$gid = $_POST[gid];
$flag = $_POST["flag"];
$vdo_id = $_POST[vdo_id];
				function chkvdo_inserver($filename){
				global $gid;
				global $file_type;
				global $flag;
				global $vdo_id;
				global $info_type;
					$file_type_server = explode('.',$filename);
					$C = count($file_type_server);
					$CT = $C-1;
					$dir = strtolower($file_type_server[$CT]);
					for($x=0;$x<count($file_type);$x++){
						if(strtolower($dir) == $file_type[$x] ){
							$info_type = 1;
						}
					}
					if($info_type == 0 ){
					?>
						<script language="JavaScript">
							alert("Can not select \"<?php echo $filename; ?>\"!! File type failed");
							 //location.href='vdo_list.php?gid=<?php//php echo $gid;?>';
							 <?php if($flag =='add'){ ?>
								  location.href='vdo_add.php?gid=<?php echo $gid;?>';
							<?php }else if($flag =='edit'){ ?>
								 location.href='vdo_edit.php?vid=<?php echo $vdo_id;?>gid=<?php echo $gid;?>';
							<?php } ?>
						</script>
					<?php
					exit;
					}
				}
				function chkimg_outserver($filename,$filesize,$tmp_name){
				global $gid;
				global $file_type2;
				global $flag;
				global $vdo_id;
				global $info_type2;
				global $db;
				global $Current_Dir;
					$file_typeimg = explode(".",$filename);
					$C = count($file_typeimg);
					$CT = $C-1;
					$dir2 = strtolower($file_typeimg[$CT]);
					for($x=0;$x<count($file_type2);$x++){
						if(strtolower($dir2) == $file_type2[$x] ){
							$info_type2 = 1;
						}
					}
					if($info_type2 == 0 ){
					?>
						<script language="JavaScript">
							alert("Can not select \"<?php echo $filename; ?>\"!! File type failed");
							 //location.href='vdo_list.php?gid=<?php//php echo $gid;?>';
							 <?php if($flag =='add'){ ?>
								  location.href='vdo_add.php?gid=<?php echo $gid;?>';
							<?php }else if($flag =='edit'){ ?>
								 location.href='vdo_edit.php?vid=<?php echo $vdo_id;?>gid=<?php echo $gid;?>';
							<?php } ?>
						</script>
					<?php
					exit;
					}
					
					//chk size file
						$sql_chk = $db->db_fetch_array($db->query("select site_info_max_file from site_info"));
						if($filesize > 0 && $filesize <= ($sql_chk["site_info_max_file"] * 1024)){
							
									$nfile2 = "ivdo_".rand(0,9).rand(0,9).'_'.date("YmdHis");
									$vdoname2 = $nfile2.".".$dir2;
									copy($tmp_name,$Current_Dir."/".$vdoname2);
									@chmod ($Current_Dir."/".$vdoname2, 0777);
									$image_filename='download/file_vdo/'.$vdoname2;
							
						}else{
						?>
							<script language="JavaScript">
									alert("Can not upload Image \"<?php echo $filename; ?>\"!! File size over <?php echo $sql_chk[site_info_max_file]; ?> KB.");
									<?php if($flag =='add'){ ?>
										  location.href='vdo_add.php?gid=<?php echo $gid;?>';
									<?php }else if($flag =='edit'){ ?>
										 location.href='vdo_edit.php?vid=<?php echo $vdo_id;?>gid=<?php echo $gid;?>';
									<?php } ?>
							</script>
						 <?php exit;
						}
					return 	$image_filename;
				}
				function  chkvdo_outserver($filename,$filesize,$tmp_name){
				global $gid;
				global $file_type;
				global $db;
				global $flag;
				global $vdo_id;
				global $Current_Dir;
						@mkdir ($Current_Dir, 0777);
						$file_type_server = explode(".",$filename);
						$C = count($file_type_server);
						$CT = $C-1;
						$dir = strtolower($file_type_server[$CT]);
						for($x=0;$x<count($file_type);$x++){
							if($dir == $file_type[$x] ){
								$info_type = 1;
							}
						}
						if($info_type == 0 ){
						?>
							<script language="JavaScript">
							    //alert(<?php//php echo $info_type;?>);
								alert("Can not upload \"<?php echo $filename; ?>\"!! File type failed");
								 <?php if($flag =='add'){ ?>
								  location.href='vdo_add.php?gid=<?php echo $gid;?>';
								<?php }else if($flag =='edit'){ ?>
									 location.href='vdo_edit.php?vid=<?php echo $vdo_id;?>gid=<?php echo $gid;?>';
								<?php } ?>
							</script>
						<?php
						exit;
						}
						//chk size file
						$sql_chk = $db->db_fetch_array($db->query("select site_info_max_file from site_info"));
						if($filesize > 0 && $filesize <= ($sql_chk["site_info_max_file"] * 1024)){
								$F = explode(".",$filename);
								$C = count($F);
								$CT = $C-1;
								$dir = strtolower($F[$CT]);
								$nfile = "vdo_".rand(0,9).rand(0,9).'_'.date("YmdHis");
								$vdoname = $nfile.".".$dir;
								copy($tmp_name,$Current_Dir."/".$vdoname);
								@chmod ($Current_Dir."/".$vdoname, 0777);
								$vdo_filename='download/file_vdo/'.$vdoname;

						}else{
						?>
							<script language="JavaScript">
								alert("Can not upload \"<?php echo $filename; ?>\"!! File size over <?php echo $sql_chk[site_info_max_file]; ?> KB.");
								 <?php if($flag =='add'){ ?>
								  location.href='vdo_add.php?gid=<?php echo $gid;?>';
								<?php }else if($flag =='edit'){ ?>
									 location.href='vdo_edit.php?vid=<?php echo $vdo_id;?>gid=<?php echo $gid;?>';
								<?php } ?>
							</script>
						<?php
						exit;
						}
					return 	$vdo_filename;
				}
				
if($_POST['flag'] =='add'){
	
if($_POST['showvdo']=='1'){
//chk data
if($_POST['vdo_filesource']=='web' and $vdo_file2<>''){
chkvdo_inserver($_POST['vdo_file2']);
$vdo_filename = $_POST['vdo_file2'];
}else if($_POST['vdo_filesource']=='com' and $_FILES['vdo_file1']['size']>0){
$vdo_filename = chkvdo_outserver($_FILES['vdo_file1']['name'],$_FILES['vdo_file1']['size'],$_FILES['vdo_file1']['tmp_name']);
}
}
//chk img
if($_POST['vdo_imagefile']<>'' and $_FILES['vdo_imagefile1']['size']==0 ){
$image_filename=$_POST['vdo_imagefile'];
}else if($_FILES["vdo_imagefile1"]['size']>0){
$image_filename = chkimg_outserver($_FILES['vdo_imagefile1']['name'],$_FILES['vdo_imagefile1']['size'],$_FILES['vdo_imagefile1']['tmp_name']);
}
/*if($_POST[vdo_filesource]=='com' && $_FILES["vdo_file1"]['size']==0){
						?>
							<script language="JavaScript">
								alert("Can not upload \"<?php echo $_FILES["vdo_imagefile1"]["name"]; ?>\"!! File size over setting server 2 MB.");
								  location.href='vdo_add.php?gid=<?php echo $gid;?>';
								
							</script>
						<?php
						exit;
}*/
//add data					  
$sql_insert = "INSERT INTO vdo_list (vdo_name,
										vdo_detail,
										vdo_filesource,
										vdo_filename,
										vdo_group,
										vdo_creator,
										vdo_info,
										vdo_image,										
										vdo_show_vdo,
										vdo_fileyoutube,
										vdo_createdate
										)  
										values ('".$vdo_name."',
										'".$vdo_detail."',
										'".$_POST['vdo_filesource']."',
										'".$vdo_filename."',
										'".$_POST['vdo_group']."',
										'".$vdo_creator."',
										'".$vdo_info."',
										'".$image_filename."',
										'".$_POST['showvdo']."',
										'".$_POST['vdo_youtube']."',
										NOW()
										)";
						  
$db->query($sql_insert);
$db->write_log("create","vdo","เพิ่ม vdo   ".$_POST["vdo_name"]);
?>
<script>
alert('<?php echo $text_genbanner_complete1;?>');
location.href='vdo_lists.php?gid=<?php echo $_POST['gid'];?>';
</script>
<?php

}else if($_POST["flag"] =='edit'){
$sql_update = "SELECT * FROM vdo_list WHERE vdo_id = '$_POST[vdo_id]' ";
$query=$db->query($sql_update);
$data=$db->db_fetch_array($query);

$vdo_file_name="../ewt/".$_SESSION["EWT_SUSER"]."/".$data['vdo_filename'];
$img_file_name="../ewt/".$_SESSION["EWT_SUSER"]."/".$data['vdo_image'];
if($data['vdo_filesource'] == 'com'){
	if($_FILES["vdo_imagefile1"]['size']>0){
			@unlink($img_file_name);
			//echo $img_file_name;
	}
}	
	if($_FILES["vdo_file1"]['size']>0){
			@unlink($vdo_file_name);
	}
	
if($_POST['showvdo']=='1'){
//chk data
if($_POST['vdo_filesource']=='web' AND $vdo_file2 <>''){
chkvdo_inserver($_POST['vdo_file2']);
$vdo_filename = $_POST['vdo_file2'];
}else if($_POST['vdo_filesource']=='com' AND $_FILES['vdo_file1']['size']>0){
$vdo_filename = chkvdo_outserver($_FILES['vdo_file1']['name'],$_FILES['vdo_file1']['size'],$_FILES['vdo_file1']['tmp_name']);
}
	}
//chk img
if($_POST['vdo_imagefile'] <> '' AND $_FILES['vdo_imagefile1']['size'] == 0){
$image_filename=$_POST['vdo_imagefile'];
}else if($_FILES['vdo_imagefile1']['size']>0){
$image_filename = chkimg_outserver($_FILES['vdo_imagefile1']['name'],$_FILES['vdo_imagefile1']['size'],$_FILES['vdo_imagefile1']['tmp_name']);
}
/*if($_POST['vdo_filesource']=='com' && $_FILES['vdo_file1']['size']==0){
?>
<script>
alert("Can not upload \"<?php echo $_FILES['vdo_imagefile1']['name']; ?>\"!! File size over support server 2 MB.");
location.href='vdo_add.php?gid=<?php echo $gid;?>';
</script>
<?php
exit;
}*/
$sql_update = "UPDATE vdo_list SET 
	vdo_name = '".$vdo_name."',
	vdo_detail='".$vdo_detail."',
	vdo_filesource='".$_POST['vdo_filesource']."' ,
	vdo_filename='".$vdo_filename."',
    vdo_group='".$_POST['vdo_group']."' ,
    vdo_creator='".$vdo_creator."' ,
    vdo_info='".$vdo_info."' ,
    vdo_image='".$image_filename."',
	vdo_show_vdo='".$_POST['showvdo']."',
	vdo_fileyoutube='".$_POST['vdo_youtube']."'
	WHERE vdo_id = '".$_POST['vdo_id']."' ";
$db->query($sql_update);
$db->write_log("update","vdo","แก้ไข vdo   ".$_POST["vdo_name"]);

 ?>
     <script>
		 alert('<?php echo $text_genbanner_complete2;?>');
         location.href='vdo_lists.php?gid=<?php echo $_POST['gid'];?>';
     </script>
   <?php
}
if($_POST[flag] == 'del'){
	for($i=0;$i<$_POST[all];$i++){
		$del="del$i";
        if($$del){
            $sql= "SELECT * FROM vdo_list  WHERE vdo_id= '".$$del."'  " ;
			$query=$db->query($sql);
			$data=$db->db_fetch_array($query);
			
			$vdo_file_name="../ewt/".$_SESSION["EWT_SUSER"]."/".$data[vdo_filename];
			$img_file_name="../ewt/".$_SESSION["EWT_SUSER"]."/".$data[vdo_image];
			if($data[vdo_filesource] == 'com'){
			@unlink($vdo_file_name);
			}
			@unlink($img_file_name);

			//echo  $img_file_name;

		   $db->query("DELETE FROM vdo_list WHERE vdo_id = '".$$del."' ");
		}
	}

		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='vdo_lists.php?gid=<?php echo $_POST[gid];?>';
     </script>
   <?php
}
exit;

/*if($_POST[vdo_filesource]=='web' and $vdo_file2<>''){
					$file_type_server = explode('.',$_POST[vdo_file2]);
					$C = count($file_type_server);
					$CT = $C-1;
					$dir = strtolower($file_type_server[$CT]);
					for($x=0;$x<count($file_type);$x++){
						if(strtolower($dir) == $file_type[$x] ){
							$info_type = 1;
						}
					}
					if($info_type == 0 ){
					?>
						<script language="JavaScript">
							alert("Can not select \"<?php echo $_POST[vdo_file2]; ?>\"!! File type failed");
							 location.href='vdo_list.php?gid=<?php echo $_POST[gid];?>';
						</script>
					<?php
					exit;
					}
					$vdo_filename=$_POST[vdo_file2];
}else if($_POST[vdo_filesource]=='com' and $_FILES["vdo_file1"]['size']>0){
						@mkdir ($Current_Dir, 0777);
						$file_type_server = explode(".",$_FILES["vdo_file1"]["name"]);
						$C = count($file_type_server);
						$CT = $C-1;
						$dir = strtolower($file_type_server[$CT]);
						for($x=0;$x<count($file_type);$x++){
							if($dir == $file_type[$x] ){
								$info_type = 1;
							}
						}
						if($info_type == 0 ){
						?>
							<script language="JavaScript">
							    //alert(<?php echo $info_type;?>);
								alert("Can not upload \"<?php echo $_FILES["vdo_file1"]["name"]; ?>\"!! File type failed");
								 location.href='vdo_add.php?gid=<?php echo $_POST[gid];?>';
							</script>
						<?php
						exit;
						}
						//chk size file
						$sql_chk = $db->db_fetch_array($db->query("select site_info_max_file from site_info"));
						if($_FILES["vdo_file1"]['size'] > 0 && $_FILES["vdo_file1"]['size'] <= ($sql_chk["site_info_max_file"] * 1024)){
								$F = explode(".",$_FILES["vdo_file1"]["name"]);
								$C = count($F);
								$CT = $C-1;
								$dir = strtolower($F[$CT]);
								$nfile = "vdo_".rand(0,9).rand(0,9).'_'.date("YmdHis");
								$vdoname = $nfile.".".$dir;
								copy($_FILES["vdo_file1"]["tmp_name"],$Current_Dir."/".$vdoname);
								@chmod ($Current_Dir."/".$vdoname, 0777);
								$vdo_filename='download/file_vdo/'.$vdoname;

						}else{
						?>
							<script language="JavaScript">
								alert("Can not upload \"<?php echo $_FILES["vdo_file1"]["name"]; ?>\"!! File size over <?php echo $sql_chk[site_info_max_file]; ?> KB.");
								 location.href='vdo_add.php?gid=<?php echo $_POST[gid];?>';
							</script>
						<?php
						exit;
						}
}

$info_type2 = 0;
if($_FILES["vdo_imagefile1"]['size']>0){
		$file_typeimg = explode(".",$_FILES["vdo_imagefile1"]["name"]);
		$C = count($file_typeimg);
		$CT = $C-1;
		$dir2 = strtolower($file_typeimg[$CT]);
		for($x=0;$x<count($file_type2);$x++){
			if(strtolower($dir2) == $file_type2[$x] ){
				$info_type2 = 1;
			}
		}
		if( $_FILES["vdo_imagefile1"]['size']>=($sql_chk["site_info_max_file"] * 1024)  ){
		     $info_type2 = 0;
		}
}else if( $_POST[vdo_imagefile]<>''){
   $info_type2 = 1;
}



if($info_type2==0 ){?>
		<script language="JavaScript">
				alert("Can not upload Image \"<?php echo $_FILES["vdo_imagefile1"]["name"]; ?>\"!! File size over <?php echo $sql_chk[site_info_max_file]; ?> KB.");
				<?php if($_POST["flag"] =='add'){ ?>
					  location.href='vdo_add.php?gid=<?php echo $_POST[gid];?>';
				<?php }else if($_POST["flag"] =='edit'){ ?>
					 location.href='vdo_edit.php?vid=<?php echo $_POST[vdo_id];?>gid=<?php echo $_POST[gid];?>';
				<?php } ?>
		</script>
	 <?php exit;
}else{

	if($_POST[vdo_imagefile]<>'' and $_FILES["vdo_imagefile1"]['size']==0 ){
			$image_filename=$_POST[vdo_imagefile];
	}else{
			$nfile2 = "ivdo_".rand(0,9).rand(0,9).'_'.date("YmdHis");
			$vdoname2 = $nfile2.".".$dir2;
			copy($_FILES["vdo_imagefile1"]["tmp_name"],$Current_Dir."/".$vdoname2);
			@chmod ($Current_Dir."/".$vdoname2, 0777);
			$image_filename='download/file_vdo/'.$vdoname2;
	}
}*/

//if($_POST["flag"] =='add'){

/*
	 if(getenv(HTTP_X_FORWARDED_FOR)) {
		$IPn = getenv(HTTP_X_FORWARDED_FOR);
	}else{
		$IPn = getenv("REMOTE_ADDR");
	}
$sql_insert = "insert into banner_group  (banner_parentgid,banner_name,banner_timestamp,banner_uid,banner_uname,banner_ip) values ('0','".$_POST["banner_gname"]."','".date('YmdHis')."','" .$_SESSION["EWT_SUID"]."','".$_SESSION["EWT_SUSER"]."','$IPn')";
*/
 
/*$sql_insert = "insert into vdo_list (vdo_name,vdo_detail,vdo_filesource,vdo_filename,vdo_group,vdo_creator,vdo_info,vdo_image)  
                          values ('$vdo_name','$vdo_detail','$_POST[vdo_filesource]','$vdo_filename','$_POST[vdo_group]','$vdo_creator','$vdo_info','$image_filename')";
$db->query($sql_insert);
$db->write_log("create","vdo","เพิ่ม vdo   ".$_POST["vdo_name"]);

 $file_vdo=$Current_Dir."/vdo_".$_POST[vdo_group].'.xml';
@unlink($file_vdo);
/*
$txt ='<'.'?xml version="1.0" encoding="tis-620" ?'.'> ';
$txt .= "<playlist version=\"1\" xmlns=\"http://xspf.org/ns/0/\">
	<title>Sample XSPF Playlist</title>
	<info>http://www.jeroenwijering.com/?item=Flash_Media_Player</info>
	<annotation>Sample playlist for the media player in XSPF format</annotation>
	<trackList>";

	//$sql = "SELECT * FROM vdo_group  WHERE vdog_id = '$_POST[vdo_group]' ";
    //$query=$db->query($sql);
	//$data1=$db->db_fetch_array($query);

		//$txt .='<track>
			//<title>'.$data1[vdog_name].'</title>
			//<creator>'.$data1[vdog_creator].'</creator>
			//<location>'.$data1[vdog_location].'</location>
			<info>'.$data1[vdog_info].'</info>
		//</track>';

	$sql = "SELECT * FROM vdo_list  WHERE vdo_group = '$_POST[vdo_group]' ";
    $query=$db->query($sql); 

	while($data2=$db->db_fetch_array($query)){  
     $txt .='
		<track>
			<title>'.$data2[vdo_name].'</title>
			<location>'.$data2[vdo_filename].'</location>
			<creator>'.$data2[vdo_creator].'</creator>
			<info>'.$data2[vdo_info].'</info>
		</track>';
	}

	$txt .='</trackList> </playlist>';

     $fp = fopen($file_vdo, 'w');
     fwrite($fp, $txt);
     fclose($fp);
	 */

 /*?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete1;?>');
          location.href='vdo_list.php?gid=<?php echo $_POST[gid];?>';
     </script>
   <?php
}*/
if($_POST["flag"] =='edit'){

$sql_update = "select * from vdo_list where vdo_id = '$_POST[vdo_id]' ";
$query=$db->query($sql_update);
$data=$db->db_fetch_array($query);

$vdo_file_name="../ewt/".$_SESSION["EWT_SUSER"]."/".$data[vdo_filename];
$img_file_name="../ewt/".$_SESSION["EWT_SUSER"]."/".$data[vdo_image];

if($_FILES["vdo_imagefile1"]['size']>0){
		@unlink($img_file_name);
		echo $img_file_name;
}

if($_FILES["vdo_file1"]['size']>0){
		@unlink($vdo_file_name);
}

$sql_update = "update
vdo_list set vdo_name = '$vdo_name',
	vdo_detail='$vdo_detail',
	vdo_filesource='$_POST[vdo_filesource]' ,
	vdo_filename='$vdo_filename',
    vdo_group='$_POST[vdo_group]' ,
    vdo_creator='$vdo_creator' ,
    vdo_info='$vdo_info' ,
    vdo_image='$image_filename' 
where vdo_id = '$_POST[vdo_id]' ";

$db->query($sql_update);
$db->write_log("update","vdo","แก้ไข vdo   ".$_POST["vdo_name"]);

 $file_vdo=$Current_Dir."/vdo_".$_POST[vdo_group].'.xml';
@unlink($file_vdo);
/*
$txt ='<'.'?xml version="1.0" encoding="Windows-874"?'.'>';
$txt .= "<playlist version=\"1\" xmlns=\"http://xspf.org/ns/0/\">
	<title>Sample XSPF Playlist</title>
	<info>http://www.jeroenwijering.com/?item=Flash_Media_Player</info>
	<annotation>Sample playlist for the media player in XSPF format</annotation>
	<trackList>";

	//$sql = "SELECT * FROM vdo_group  WHERE vdog_id = '$_POST[vdo_group]' ";
    //$query=$db->query($sql);
	//$data1=$db->db_fetch_array($query);

		//$txt .='<track>
			//<title>'.$data1[vdog_name].'</title>
			//<creator>'.$data1[vdog_creator].'</creator>
			//<location>'.$data1[vdog_location].'</location>
			//<info>'.$data1[vdog_info].'</info>
		//</track>';

	$sql = "SELECT * FROM vdo_list  WHERE vdo_group = '$_POST[vdo_group]' ";
    $query=$db->query($sql); 

	while($data2=$db->db_fetch_array($query)){  
     $txt .='
		<track>
			<title>'.$data2[vdo_name].'</title>
			<location>'.$data2[vdo_filename].'</location>
			<creator>'.$data2[vdo_creator].'</creator>
			<info>'.$data2[vdo_info].'</info>
		</track>';
	}

	$txt .='</trackList>
	</playlist>';
	
     $fp = fopen($file_vdo, 'w');
     fwrite($fp, $txt);
     fclose($fp);
*/
 ?>
      <script language="JavaScript">
		 alert('<?php echo $text_genbanner_complete2;?>');
          location.href='vdo_list.php?gid=<?php echo $_POST[gid];?>';
     </script>
   <?php
}

if($_POST[flag] == 'del'){
	for($i=0;$i<$_POST[all];$i++){
		$del="del$i";
        if($$del){
            $sql= "SELECT * FROM vdo_list  WHERE vdo_id= '".$$del."'  " ;
			$query=$db->query($sql);
			$data=$db->db_fetch_array($query);

			$vdo_file_name="../ewt/".$_SESSION["EWT_SUSER"]."/".$data[vdo_filename];
			$img_file_name="../ewt/".$_SESSION["EWT_SUSER"]."/".$data[vdo_image];

			@unlink($vdo_file_name);
			@unlink($img_file_name);

			//echo  $img_file_name;

		   $db->query("DELETE FROM vdo_list WHERE vdo_id = '".$$del."' ");
		}
	}

$file_vdo=$Current_Dir."/vdo_".$_POST[gid].'.xml';
@unlink($file_vdo);


/*
	$sql = "SELECT * FROM vdo_list  WHERE vdo_group = '".$_POST[gid]."' ";
    $query=$db->query($sql); 
if($db->db_num_rows($query)>0){
$txt ='<'.'?xml version="1.0" encoding="Windows-874"?'.'>';
$txt .= "<playlist version=\"1\" xmlns=\"http://xspf.org/ns/0/\">
	<title>Sample XSPF Playlist</title>
	<info>http://www.jeroenwijering.com/?item=Flash_Media_Player</info>
	<annotation>Sample playlist for the media player in XSPF format</annotation>
	<trackList>";

	//$sql = "SELECT * FROM vdo_group  WHERE vdog_id = '".$_POST[gid]."' ";
   // $query=$db->query($sql);
	//$data1=$db->db_fetch_array($query);

		//$txt .='<track>
			//<title>'.$data1[vdog_name].'</title>
			//<creator>'.$data1[vdog_creator].'</creator>
			//<location>'.$data1[vdog_location].'</location>
			//<info>'.$data1[vdog_info].'</info>
		//</track>';

	$sql = "SELECT * FROM vdo_list  WHERE vdo_group = '".$_POST[gid]."' ";
    $query=$db->query($sql); 

	while($data2=$db->db_fetch_array($query)){  
     $txt .='
		<track>
			<title>'.$data2[vdo_name].'</title>
			<location>'.$data2[vdo_filename].'</location>
			<creator>'.$data2[vdo_creator].'</creator>
			<info>'.$data2[vdo_info].'</info>
		</track>';
	}

	$txt .='</trackList>
	</playlist>';
	
     $fp = fopen($file_vdo, 'w');
     fwrite($fp, $txt);
     fclose($fp);
	 
	}
	
	*/
		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='vdo_lists.php?gid=<?php echo $_POST[gid];?>';
     </script>
   <?php
}

$db->db_close(); ?>
