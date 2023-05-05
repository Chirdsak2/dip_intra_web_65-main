<?php
session_start();
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$EWT_DB_USER = 'ewt_user';
$sql_chk = "select n_shareuse,n_sharename,n_shareid from article_list where n_id = '".$_GET["nid"]."'";
$query_chk = $db->query($sql_chk);
if($db->db_num_rows($query_chk)>0){
$R_chk = $db->db_fetch_array($query_chk);
$n_shareuse = $R_chk[n_shareuse];

if($n_shareuse != 'Y'){
$sql = $db->query("SELECT download_list.*,article_list.n_share,article_list.n_sharename,article_list.n_shareid FROM download_list inner join article_list on download_list.dl_gid = article_list.n_id WHERE dl_gid = '".$_GET["nid"]."'");
if($db->db_num_rows($sql)){
	$R = $db->db_fetch_array($sql);
	
	if($R[dl_name] == "Y" AND $_SESSION["EWT_MID"] == ""){
		?>
		<script language="javascript">
		alert("กรุณา Login ก่อนทำการ download");	
		self.location.href="ewt_login.php?fn=ewt_dl.php?nid=<?php echo $_GET["nid"]; ?>";
		</script>
		<?php
	exit;
	}

						if($_SERVER["REMOTE_ADDR"]){
						$ip_view = $_SERVER["REMOTE_ADDR"];
					}else{
						$ip_view = $_SERVER["REMOTE_HOST"];
					}
						$date_view = date("Y-m-d");
						$time_view = date("h:i:s");
	$db->query("INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('".$_GET["nid"]."','$ip_view','$date_view','$time_view','".$_SESSION["EWT_MID"]."') ");
			//cese shere from site other to child
			if($R[n_share] =='Y'){
			$db->query("USE ".$EWT_DB_USER);
			$sql = "select * from share_article where n_id ='".$_GET["nid"]."' and user_s ='".$EWT_FOLDER_USER."' and s_status ='Y'";
			$query = $db->query($sql);
			while($RR=$db->db_fetch_array($query)){
				$sql2 = "select db_db from user_info where EWT_User ='".$RR[user_t]."'";
				$query2 = $db->query($sql2);
				$N = $db->db_fetch_array($query2);
				$db_name_parent = $N[db_db];
				$db->query("USE ".$db_name_parent);
				$db->query("INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('".$RR[n_id_t]."','$ip_view','$date_view','$time_view','".$_SESSION["EWT_MID"]."') ");
				$db->query("USE ".$EWT_DB_USER);
			
			}
			$db->query("USE ".$EWT_DB_NAME);
			}
			header( 'Content-type: '.$R[dl_filetype] );
			header( 'Content-Length: ' .$R[dl_filesize] );
			header( 'Content-Disposition: filename="' . $R[dl_userfile] . '"' );
			header( 'Content-Description: Download Data' );
			header( 'Pragma: no-cache' );
			header( 'Expires: 0' );
		
		$fp = fopen ("../article_tmp/".$R[dl_sysfile], 'rb');
		
		$ata = fread( $fp, $R[dl_filesize]);
echo $ata;
@fclose($fp);
}
}else if($n_shareuse == 'Y'){//End if ='y'
				$db->query("USE ".$EWT_DB_USER);
				$sql_db = "select db_db from user_info where EWT_User ='".$R_chk[n_sharename]."'";
				$query_db = $db->query($sql_db);
				$N = $db->db_fetch_array($query_db);
				$db_name_parent = $N[db_db];
				
				//file parent id
				$sql_parent_id = "select n_id from share_article where share_article.sg_id='".$R_chk[n_shareid]."'";
				$query_parent_id = $db->query($sql_parent_id);
				$R_parent_id = $db->db_fetch_array($query_parent_id);
				$p_nid = $R_parent_id[n_id];
				$db->query("USE ".$db_name_parent);
				
			$sql = $db->query("SELECT download_list.*,article_list.n_share,article_list.n_sharename,article_list.n_shareid FROM download_list inner join article_list on download_list.dl_gid = article_list.n_id WHERE dl_gid = '".$p_nid."'");
			if($db->db_num_rows($sql)>0){
				$R = $db->db_fetch_array($sql);
				$dl_filetype = $R[dl_filetype];
				$dl_filesize = $R[dl_filesize];
				$dl_userfile = $R[dl_userfile];
				$dl_sysfile = $R[dl_sysfile];
				if($R[dl_name] == "Y" AND $_SESSION["EWT_MID"] == ""){
					?>
					<script language="javascript">
					alert("กรุณา Login ก่อนทำการ download");	
					self.location.href="ewt_login.php?fn=ewt_dl.php?nid=<?php echo $_GET["nid"]; ?>";
					</script>
					<?php
				exit;
				}
			
									if($_SERVER["REMOTE_ADDR"]){
									$ip_view = $_SERVER["REMOTE_ADDR"];
								}else{
									$ip_view = $_SERVER["REMOTE_HOST"];
								}
									$date_view = date("Y-m-d");
									$time_view = date("h:i:s");
				$db->query("INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('".$p_nid."','$ip_view','$date_view','$time_view','".$_SESSION["EWT_MID"]."') ");
			
						//cese shere from site other to child
							if($R[n_share] =='Y'){
							$db->query("USE ".$EWT_DB_USER);
							$sql = "select * from share_article where n_id ='".$R_parent_id[n_id]."' and user_s ='".$R_chk[n_sharename]."' and s_status ='Y'";
							$query = $db->query($sql);
							while($RR=$db->db_fetch_array($query)){
								$sql2 = "select db_db from user_info where EWT_User ='".$RR[user_t]."'";
								$query2 = $db->query($sql2);
								$N2 = $db->db_fetch_array($query2);
								$db_name_parent2 = $N2[db_db];
								$db->query("USE ".$db_name_parent2);
								$db->query("INSERT INTO news_view (news_id,ip_view,date_view,time_view,id_member) VALUE ('".$RR[n_id_t]."','$ip_view','$date_view','$time_view','".$_SESSION["EWT_MID"]."') ");
								$db->query("USE ".$EWT_DB_USER);
							
							}
							$db->query("USE ".$EWT_DB_NAME);
							}
						header( 'Content-type: '.$dl_filetype );
						header( 'Content-Length: ' .$dl_filesize);
						header( 'Content-Disposition: filename="' . $dl_userfile . '"' );
						header( 'Content-Description: Download Data' );
						header( 'Pragma: no-cache' );
						header( 'Expires: 0' );
					
					$fp = fopen ("../".$R_chk[n_sharename]."/article_tmp/".$dl_sysfile, 'rb');
					
					$ata = fread( $fp, $dl_filesize);
			echo $ata;
			@fclose($fp);
			$db->query("USE ".$EWT_DB_NAME);
			}
				
}//End if ='y'
}//End sql chk
$db->db_close(); 
?>