<?php
	session_start();

	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	$db->query("USE datawarehouse");
	//add log open file

	//เลือกเอกสารตาม id
	$sql = "select * from attach_file where attach_file_id = '".$_POST[aid]."'";

	$query = $db->query($sql);
	$R = $db->db_fetch_array($query);
				$dl_filetype = $R[attach_filetype];
				$dl_filesize = $R[attach_filesize];
				$dl_userfile = $R[attach_file_used];
				$dl_sysfile = $R[attach_file];

			header( 'Content-type: '.$dl_filetype);
			header( 'Content-Length: ' .$dl_filesize);
			header( 'Content-Disposition: filename="' . $dl_userfile . '"' );
			header( 'Content-Description: Download Data' );
			header( 'Pragma: no-cache' );
			header( 'Expires: 0' );
		$fp = @fopen ("../../data_warehouse/file/".$dl_sysfile, 'rb');

		$ata = @fread( $fp, $dl_filesize);
		echo $ata;
		@fclose($fp);


$db->db_close(); ?>
