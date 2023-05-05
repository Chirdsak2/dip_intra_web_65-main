<?php
session_start();
$path = "../";
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect_uncheck1.php");

$sql_chk = "select n_shareuse,n_sharename,n_shareid from article_list where n_id = '".$_GET["nid"]."'";
$query_chk = $db->query($sql_chk);
if($db->db_num_rows($query_chk)>0){
$R_chk = $db->db_fetch_array($query_chk);
$n_shareuse = $R_chk[n_shareuse];

if($n_shareuse != 'Y'){

$sql = $db->query("SELECT article_list.n_share,article_list.n_sharename,article_list.n_shareid,article_list.link_html FROM article_list  WHERE n_id = '".$_GET["nid"]."'");
if($db->db_num_rows($sql)){
	$R = $db->db_fetch_array($sql);
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
									
									
													$file = $R["link_html"];
													$typename = explode('.',$file);
													$C = count($typename);
												   $CT = $C-1;
												   $dir = strtolower($typename[$CT]);
												   $typename2 = explode('/',$typename[0]);
												   $C2 = count($typename2);
												   $CT2 = $C2-1;
												   $dl_userfile  = strtolower($typename2[$CT2]).'.'.$dir;
												   if($dir == 'pdf'){
													$mytype = 'application/pdf';
													}else if($dir == 'doc'){
													$mytype = 'application/msword';
													}else if($dir == 'ppt'){
													$mytype = 'application/vnd.ms-powerpoint';
													}else if($dir == 'xls'){
													$mytype = 'application/vnd.ms-excel';
													}else if($dir == 'mht'){
													$mytype = 'message/rfc822';
													}else if($dir == 'txt'){
													$mytype = 'text/plain';
													}
													$dl_filesize = @filesize($path.$file);
													if($dl_filesize == '' || $dl_filesize < 0){
													 ?>
													<script language="javascript1.2">
													self.location.href = "<?php echo $R["link_html"];?>";
													</script>
													<?
													}else{
													header( 'Content-type: '.$mytype );
													header( 'Content-Length: ' .$dl_filesize);
													header( 'Content-Disposition: filename="' . $dl_userfile . '"' );
													header( 'Content-Description: Download Data' );
													header( 'Pragma: no-cache' );
													header( 'Expires: 0' );
									
									$fp = fopen ($path.$R["link_html"], 'rb');
									$ata = fread( $fp, $dl_filesize);
							echo $ata;
							@fclose($fp);
							}
}
}else if($n_shareuse == 'Y'){//End if ='y'
				$db->query("USE ".$EWT_DB_USER);
				$sql_db = "select db_db,url from user_info where EWT_User ='".$R_chk[n_sharename]."'";
				$query_db = $db->query($sql_db);
				$N = $db->db_fetch_array($query_db);
				$db_name_parent = $N[db_db];
				$db_url_parent = $N[url];
				
				//file parent id
				$sql_parent_id = "select n_id from share_article where share_article.sg_id='".$R_chk[n_shareid]."'";
				$query_parent_id = $db->query($sql_parent_id);
				$R_parent_id = $db->db_fetch_array($query_parent_id);
				$p_nid = $R_parent_id[n_id];
				$db->query("USE ".$db_name_parent);
				
			$sql = $db->query("SELECT article_list.n_share,article_list.n_sharename,article_list.n_shareid,article_list.link_html,news_use  FROM article_list  WHERE n_id = '".$p_nid."'");
			if($db->db_num_rows($sql)>0){
				$R = $db->db_fetch_array($sql);
				
			
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
						$file = urldecode ($R["link_html"]);
						$typename = explode('.',$file);
						$C = count($typename);
				       $CT = $C-1;
				       $dir = strtolower($typename[$CT]);
					   $typename2 = explode('/',$typename[0]);
					   $C2 = count($typename2);
				       $CT2 = $C2-1;
				       $dl_userfile  = strtolower($typename2[$CT2]).'.'.$dir;
					   if($dir == 'pdf'){
						$mytype = 'application/pdf';
						}else if($dir == 'doc'){
						$mytype = 'application/msword';
						}else if($dir == 'ppt'){
						$mytype = 'application/vnd.ms-powerpoint';
						}else if($dir == 'xls'){
						$mytype = 'application/vnd.ms-excel';
						}else if($dir == 'mht'){
						$mytype = 'message/rfc822';
						}else if($dir == 'txt'){
						$mytype = 'text/plain';
						}
						$dl_filesize = @filesize($file);
						if($dl_filesize == '' || $dl_filesize < 0){
								if($R["news_use"] == "2" or $R["news_use"] == "3") { 
															$linkX= $db_url_parent."ewt_w3c/ewt_news.php?nid=".$p_nid."&filename=".$filename;
														} elseif($R["news_use"] == "4") { 
															$linkX = $db_url_parent."ewt_w3c/ewt_dl.php?nid=".$p_nid."&filename=".$filename;
														} else { 
															if(eregi($db_url_parent,$R["link_html"])){
															$linkX = explode($db_url_parent,$R["link_html"]);
															$linkX = $db_url_parent.'ewt_w3c/'.$linkX[1];
															}else if(eregi("http://",$R["link_html"])){
															$linkX = $R["link_html"];
															}else{
															$linkX = $db_url_parent.'ewt_w3c/'.$R["link_html"];
															}
														}
						?>
						<script language="javascript1.2">
						self.location.href = "<?php echo $linkX;?>";
						</script>
						<?
						}else{
						$dl_filesize = filesize($path.$file);
						header( 'Content-type: '.$mytype );
						header( 'Content-Length: ' .$dl_filesize);
						header( 'Content-Disposition: filename="' . $dl_userfile . '"' );
						header( 'Content-Description: Download Data' );
						header( 'Pragma: no-cache' );
						header( 'Expires: 0' );
						
						$fp = fopen ($path.$R["link_html"], 'rb');
					
						$ata = fread( $fp, $dl_filesize);
						echo $ata;
						@fclose($fp);
						}
			$db->query("USE ".$EWT_DB_NAME);
			}
				
}//End if ='y'
}//End sql chk
$db->db_close(); 
?>