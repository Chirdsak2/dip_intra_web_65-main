<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");

$file_type = array('jpg','swf','flv','mp3','wmv','rar','zip');
$file_type2 = array('jpg','gif','png','bmp');
$Current_Dir= "../ewt/".$_SESSION["EWT_SUSER"]."/downloadMgt";

$dl_name=stripslashes(htmlspecialchars($_POST["dl_name"],ENT_QUOTES));
$dl_detail=stripslashes(htmlspecialchars($_POST["dl_detail"],ENT_QUOTES));  
$dl_date=stripslashes(htmlspecialchars($_POST["dl_date"],ENT_QUOTES));


$dl_details=$_POST["dl_details"];  
$dl_filename=$_POST["dl_filename"];  
$dl_filesize=$_POST["dl_filesize"];  
$tempdir=$_POST["tempdir"];  
$file_replace=$_POST["file_replace"];  



$dls_filesize=$_POST["dls_filesize"]*1024;
if($dls_filesize==0){$dls_filesize=5*1024 ; }
$dls_ext=stripslashes(htmlspecialchars($_POST["dls_ext"],ENT_QUOTES));

$gid = $_POST[gid];
$flag = $_POST["flag"];
$vdo_id = $_POST[vdo_id];

$fail_type=0;

function LooPDel($p){
			$dir=@opendir($p);
			while($data=@readdir($dir))
			{
				if(($data!=".")and($data!="..")and($data!="")){
					if(!@unlink($p."/".$data))
						{
							LooPDel($p."/".$data);
						}	
				}
			}
		@closedir($dir);
		@rmdir($p);
}


if($_POST["flag"] =='add'){

		 $Current_UploadDir = "../ewt/".$_SESSION["EWT_SUSER"]."/download_doc/dl_$gid";
		 $rowsfile = count($dl_details);
		  for($i=0;$i<$rowsfile;$i++){
			  if (!file_exists($Current_UploadDir."/".$dl_filename[$i]) or $file_replace[$i] == "Y" ) {
				  //echo  $dl_details[$i].$dl_filename[$i].$dl_filesize[$i].$file_replace[$i].'<br>';
				  $newfilename= strtolower($dl_filename[$i]);
				  copy($tempdir.'/'.$dl_filename[$i],$Current_UploadDir."/".$newfilename); 

				  $F = explode(".",$newfilename);
				   $C = count($F);
				   $CT = $C-1;
				   $extension = $F[$CT];

                 $sql_chk_row="SELECT * FROM  docload_list WHERE dl_name= '".$dl_filename[$i]."' AND dl_dlgid = '$gid'   ";
                 $query_chk_row=$db->query($sql_chk_row);
				 $rows=$db->db_num_rows($query_chk_row);

                  if($file_replace[$i] == "Y" and $rows==1){
					     $sql_insert="UPDATE docload_list  SET  dl_filesize='".$dl_filesize[$i]."'  , dl_update = '".date('YmdHis')."',
						                         dl_detail='".$dl_details[$i]."'
						                          WHERE dl_name= '".$dl_filename[$i]."'  and  dl_dlgid = '$gid'   ";
				  }else{
						  $sql_insert="INSERT INTO docload_list(dl_dlgid,dl_name,dl_detail,dl_filesize,dl_createdate,dl_type,dl_open)
						  VALUES('$gid','".$dl_filename[$i]."','".$dl_details[$i]."','".$dl_filesize[$i]."','".date('YmdHis')."','$extension','Y') ";
				  } 
				  $db->query($sql_insert);
				  $db->write_log("create","uplodefile","สร้าง File   ".$dl_filename[$i]);
			  }
		  }
		  //echo "<br>clear $tempdir";
		  LooPDel($_REQUEST[tempdir]);
  
		 ?>  <script language="JavaScript">
						  alert('การอัพโหลดเสร็จสมบูรณ์แล้ว');
						  location.href='download_list.php?gid=<?php echo $_POST[gid];?>';
			  </script> <?php
			exit;

}else if($_POST["flag"] =='edit'){
        
        $Current_UploadDir = "../ewt/".$_SESSION["EWT_SUSER"]."/download_doc/dl_$gid";
		$Replace=$_POST["Replace"];  

		$d=explode('/',$_POST[dl_date]);

		$sql_update="UPDATE docload_list SET   dl_detail='$dl_detail', dl_update='".date('Ymdhis')."', dl_dlgid='$_POST[dl_group]' ,dl_open = '$_POST[dl_open]' 	WHERE dl_id='$_POST[dl_id]' ";
		$db->query($sql_update);
		$db->write_log("create","download","แก้ไข File download   ".$_POST["dl_name"]);

		$sql_update = "select * from docload_list where dl_id = '$_POST[dl_id]' ";
		$query=$db->query($sql_update);
		$data=$db->db_fetch_array($query);

		$old_file_name=$Current_UploadDir."/".$data[dl_name];

        //ถ้ามีการเปลี่ยนกลุ่ม
		if($gid != $_POST[dl_group]){
			$Current_UploadDir2 = "../ewt/".$_SESSION["EWT_SUSER"]."/download_doc/dl_".$_POST[dl_group];
			$old_file_name2=$Current_UploadDir2."/".$data[dl_name];
		}

		$sql = "SELECT * FROM docload_setting";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
		$file_filesize =  $data[dls_filesize];
		$file_ext =  $data[dls_ext];
		$file_type = explode(',',$file_ext);

		if($_FILES[dl_file][size]>0){
				@mkdir ($Current_UploadDir, 0777);
				$file_type_server = explode(".",$_FILES[dl_file][name]);
				$C = count($file_type_server);
				$CT = $C-1;
				$extension = strtolower($file_type_server[$CT]);
		}

		if($_FILES[dl_file][size]>$file_filesize){
				?>  <script language="JavaScript">
									  alert('ไฟล์มีขนาดเกิดกำหนด <?php echo number_format($file_filesize/1024,2);?> Kb'); 
									  location.href='download_edit.php?fid=<?php echo $_POST[dl_id];?>&gid=<?php echo $_POST[gid];?>';
					</script> <?php
		}

		if(in_array($extension,$file_type) and ($_FILES[dl_file][size]>0 and $_FILES[dl_file][size]<=$file_filesize)){

					$newfilename= strtolower($_FILES["dl_file"]["name"]);
			        $dl_name=$newfilename;
					$dl_filesize=$_FILES[dl_file][size];
					//$real_filetype=$_FILES[dl_file][type];

			    if (file_exists($Current_UploadDir."/".$_FILES["dl_file"]["name"])) {
					// เจอไฟล์ซ้ำ 
					if($_POST["Replace"]=='Y'){
					   //ทับได้
					   copy($_FILES["dl_file"]["tmp_name"],$Current_UploadDir."/".$_FILES["dl_file"]["name"]);
					}
				}else{
					//ไม่เจอไฟล์ซ้ำ
					@unlink($old_file_name);
					 copy($_FILES["dl_file"]["tmp_name"],$Current_UploadDir."/".$_FILES["dl_file"]["name"]);
				}

				$sql_update="UPDATE docload_list SET   dl_name='$dl_name',  dl_filesize='$dl_filesize'
		            WHERE dl_id='$_POST[dl_id]' ";
		        $db->query($sql_update);

				@chmod ($Current_UploadDir."/".$dl_name, 0777);

				//ถ้ามีการเปลี่ยนกลุ่ม
				if($gid != $_POST[dl_group]){
					$Current_UploadDir2 = "../ewt/".$_SESSION["EWT_SUSER"]."/download_doc/dl_".$_POST[dl_group];
					$old_file_name2=$Current_UploadDir2."/".$data[dl_name];
                    copy($old_file_name,$old_file_name2);
					@unlink($old_file_name);
				}
		}
			?>  <script language="JavaScript">
							  alert('แก้ไขไฟล์เสร็จสมบูรณ์');
							  location.href='download_list.php?gid=<?php echo $_POST[gid];?>';
			</script> <?php
			exit;
		
}else if($_POST["flag"] =='setting'){
	$rChkS=$db->db_fetch_array($db->query('SELECT site_info_max_file FROM site_info'));
	if($_POST['dls_filesize']>$rChkS[0]) {
		echo '<script type="text/javascript"> alert("ไม่สามารถกำหนดขนาดได้เกินที่คุณสมบัติเว็บไซต์กำหนด"); window.location.href="'.$_SERVER['HTTP_REFERER'].'"; </script>';
		exit;
	}
               $sql_chk= "SELECT * FROM docload_setting";
			   $query=$db->query($sql_chk);
			   if($db->db_num_rows($query)==0){
			         $sql_insert= "INSERT INTO docload_setting(dls_filesize,dls_ext) VALUES('$dls_filesize','$dls_ext') ";
                     $db->query($sql_insert);
			   }else{
			         $sql_update= "UPDATE docload_setting SET  dls_filesize='$dls_filesize' ,dls_ext = '$dls_ext' ";
                     $db->query($sql_update);
			   }
 
				$db->write_log("setting","download","ตั้งค่า File upload ");

			    ?>  <script language="JavaScript">
					  alert('ท่านได้ทำการตั้งค่าข้อมูลเรียบร้อยแล้ว');
					  location.href='download_setting.php';
		         </script> <?php
				exit;
}


if($_POST[flag] == 'del'){
	    $Current_UploadDir = "../ewt/".$_SESSION["EWT_SUSER"]."/download_doc/dl_$gid";
		
		for($i=0;$i<$_POST[all];$i++){
			$del="del$i";
			if($$del){
				$sql= "SELECT * FROM docload_list  WHERE dl_id= '".$$del."'  " ;
				$query=$db->query($sql);
				$data=$db->db_fetch_array($query);

				$old_file_name=$Current_UploadDir."/".$data[dl_name];
				@unlink($old_file_name);
               $db->query("DELETE FROM docload_list WHERE dl_id = '".$$del."' ");
			}
		}

		?>
      <script language="JavaScript">
		  alert('<?php echo $text_genbanner_complete3;?>');
          location.href='download_list.php?gid=<?php echo $_POST[gid];?>';
     </script>
   <?php
	exit;
}

$db->db_close(); 

?>
