<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


				
$db->query("USE ".$EWT_DB_USER);
		$sql_url = $db->query("SELECT url FROM user_info WHERE EWT_User = '".$_POST["USER"]."' ");
		$U = $db->db_fetch_row($sql_url);
		$url = $U[0];
$db->query("USE ".$_SESSION["EWT_SDB"]);

for($i=0;$i<$_POST["allx"];$i++){
		$nid = $_POST["news".$i];
		$snews = $db->query("SELECT * FROM article_list WHERE n_id = '".$nid."' ");
		$N = $db->db_fetch_array($snews);
			if($N[news_use] == "1"){
				$rest = substr($N[link_html], 0, 7);
				if($rest == "http://"){
					$linkhtml = $N[link_html];
				}else{
					$linkhtml = $url.$N[link_html];
				}
			}
			if($N["picture"] == ""){ 
                $pic_news = $db->query("SELECT ad_pic_s FROM article_detail WHERE n_id = '".$nid."' AND ad_pic_s !='' ORDER BY at_type_col,at_type_row limit 0,1 "); 
                $pic = $db->db_fetch_array($pic_news); 
                 
                if($pic["ad_pic_s"] != ""){ 
                $ccc= explode(".",$pic["ad_pic_s"]); 
                $pic_name = "n".date('Ymd')."_".$nid.".".$ccc[1]; 
                copy("../ewt/".$EWT_FOLDER_USER.'/images/article/news'.$nid."/".$pic["ad_pic_s"],"../ewt/".$EWT_FOLDER_USER.'/images/article/news'.$nid."/".$pic_name); 
                $N['picture'] = $pic_name; 
                } 
            } 
			/*if($N[news_use] == "3"){
			$dec = base64_encode($_POST["USER"]."@@@".$nid);
			$linkhtml = "ewt_smnews.php?nid=".$dec;
			$N[news_use] = "1";
			}*/
			if($N[news_use] == "2" || $N[news_use] == "3"){
				$dec = base64_encode($_POST["USER"]."@@@".$nid);
				$linkhtml = "ewt_snews.php?s=".$dec;
				$N[news_use] = "1";
				//$url = "http://118.175.16.80/ewtadmin/ewt/".$_POST["USER"]."/ewt_news_body.php?nid=".$nid;
				$url = "http://110.164.193.4/ewtadmin/ewt/".$_POST["USER"]."/ewt_news_body.php?nid=".$nid;
				$line = "";
				//$fp = @fopen($url ,"r");
				/*if (!$fp = fopen($url, "r")) { 
         ?> 
         <!--<script language="JavaScript"> 
         alert("Cannot open file(<?php //echo $url;?>)"); 
         self.location.href = '<?php //echo $_POST["backto"]; ?>'; 
        </script>-->
         <?php 
         exit; 
            }*/ 
				if($fp){ 
				while($html = @fgets($fp, 1024)){
				$line .= $html;
				}
			}
			//echo $line;
			//exit;
				@fclose($fp);
				$line = eregi_replace("images/article/news","phpThumb.php?src=../".$_POST["USER"]."/images/article/news",$line);
	

				$fw = @fopen("../ewt/".$_POST["USER"]."/article/TEMP".$nid.".html", "w");
				$FlagW = @fwrite($fw, $line);
				@fclose($fw);
//$Current_Dir1 = "../ewt/".$_POST["USER"]."/article"; 
//@chmod($Current_Dir, 0777); 
//$Current_Dir = "../ewt/".$_POST["USER"]."/article/TEMP".$nid.".html"; 
//@mkdir ($Current_Dir1, 0777);  
//@mkdir ($Current_Dir, 0777);
//@chmod($Current_Dir, 0777); 
/*if (!$fw = fopen($Current_Dir, "w")) { 
         //print "Cannot open file ($filename)"; 
         ?> 
         <script language="JavaScript"> 
         alert("Cannot open file(<?php echo $Current_Dir;?>)"); 
         self.location.href = '<?php echo $_POST["backto"]; ?>'; 
        </script> 
         <?php 
         exit; 
            } 

         if (!fwrite($fw, $line)) { 
        //print "Cannot write to file ($filename)"; 
         ?> 
         <script language="JavaScript"> 
         alert("Cannot write to file(<?php echo $Current_Dir;?>)"); 
         self.location.href = '<?php echo $_POST["backto"]; ?>'; 
        </script> 
         <?php 
        exit; 
        } 
        //fclose($fp); 
        @fclose($fw); */
			}
			if($N[news_use] == "4"){
				//$linkhtml =$url."ewt_dl.php?nid=".$nid;
				$linkhtml =$url."ewt_news.php?nid=".$nid;
				$N[news_use] = "1";
			}
		$text[$i] = "INSERT INTO article_list ( n_id , UID , user_share , n_date , n_timestamp , n_topic , n_des , source , sourceLink , keyword , picture , news_use , at_id , link_html , target , expire , logo , share_date ,n_owner) VALUES ( '$N[n_id]', '$_POST[UID]', '$_POST[USER]', '$N[n_date]', '$_N[n_timestamp]', '$N[n_topic]', '$N[n_des]', '$N[source]', '$N[sourceLink]', '$N[keyword]', '$N[picture]', '$N[news_use]', '$N[at_id]', '$linkhtml', '$N[target]', '$N[expire]', '$N[logo]', NOW( ) , '$N[n_owner]')";
		$db->query("UPDATE article_list SET n_share = 'Y' WHERE n_id = '".$nid."' ");
}

$db->query("USE ".$EWT_DB_USER);

	for($i=0;$i<$_POST["allx"];$i++){
		$db->query($text[$i]);
	}

$all = count($_POST["use"]);
	for($y=0;$y<$all;$y++){
		$chk = $_POST["use"][$y];
		if($chk != ""){
			$ex = explode("_",$chk);
				$UID_t = $ex[0];
				$CID = $ex[1];
				$sql = $db->query("SELECT EWT_User FROM user_info WHERE UID = '".$UID_t."' ");
				$S = $db->db_fetch_row($sql);
				$User_t = $S[0];
				for($i=0;$i<$_POST["allx"];$i++){
					$nid = $_POST["news".$i];
					$db->query("INSERT INTO share_article ( n_id , UID_s , user_s , UID_t , user_t , c_id , s_date , s_status , a_date ) VALUES ('$nid', '$_POST[UID]', '$_POST[USER]', '$UID_t', '$User_t', '$CID', '".date("Y-m-d")."', 'W', '' )");
					
					//select max id
					$sql_max = $db->query("SELECT MAX(sg_id) FROM share_article  ");//WHERE c_id = '".$N[c_id]."' AND n_topic = '".$N[n_topic]."'
					$M = $db->db_fetch_row($sql_max);
					$sgid = $M[0];
					
					
					$db->query("USE ".$_SESSION["EWT_SDB"]."");
					$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '$nid' ");
					$R = $db->db_fetch_array($sql_edit);
					$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '$CID' ");
					$Rgroup = $db->db_fetch_array($sql_group);
					$db->write_log("share","article","share article     " .$R[n_topic] ." ให้ website ".$User_t ." group article ".$Rgroup[c_name]);
					$db->query("USE ".$EWT_DB_USER);
					//ค้นหาtb
					$sql_tb = $db->query("select * from user_info where UID ='".$UID_t."'");
					$T = $db->db_fetch_array($sql_tb);
					$db_main = $T[db_db];
					$db->query("USE ".$db_main."");
					$sql_uid = $db->query("select * from article_auto where UID='".$_POST[UID]."' and c_id = '".$CID."'");
					$num = $db->db_num_rows($sql_uid);
					if($num>0){
					$db->query("USE ".$EWT_DB_USER);
					
							$snews = $db->query("SELECT * FROM article_list INNER JOIN share_article ON article_list.n_id = share_article.n_id AND article_list.UID = share_article.UID_s   AND article_list.user_share = share_article.user_s WHERE share_article.sg_id = '".$sgid."' ");
							$N = $db->db_fetch_array($snews);
					
							$db->query("USE ".$db_main);
							$db->query("INSERT INTO article_list ( c_id , n_date , n_timestamp , n_topic , n_des , source , sourceLink , keyword , picture , news_use , at_id , link_html , target , expire , logo , access , n_share , n_shareuse , n_sharename , n_shareid,n_approve,n_approvedate ,n_owner,n_date_start,n_date_end) VALUES ( '$N[c_id]', '$N[n_date]', '$_N[n_timestamp]', '$N[n_topic]', '$N[n_des]', '$N[source]', '$N[sourceLink]', '$N[keyword]', '$N[picture]', '1', '', '$N[link_html]', '$N[target]', '$N[expire]', '$N[logo]', '', NULL , 'Y', '$N[user_s]', '$nid','Y','".date("Y-m-d")."', '$N[n_owner]', '$N[n_date_start]', '$N[n_date_end]')");
							
							$sql_max = $db->query("SELECT MAX(n_id) FROM article_list WHERE c_id = '".$N[c_id]."' AND n_topic = '".$N[n_topic]."' ");
							$M = $db->db_fetch_row($sql_max);
							$snid = $M[0];
							$db->query("USE ".$EWT_DB_USER);
							$db->query("UPDATE share_article SET s_status = 'Y',n_id_t = '$snid' WHERE sg_id = '".$sgid."' ");
								//sant mail
									$rest = substr($N[link_html], 0, 7);
									if($rest == "http://"){
									 $Blink = $N[link_html];
									}else{
									 $Blink = $db_url_link.$N[link_html];
									}
									$email_member = array();
									$body = "<font face='MS Sans Serif' size=2>ถึงท่านสมาชิกทุกท่าน  มีข่าวสารใหม่ขอแจ้งให้ทราบดังนี้<br><a href=".$Blink." target =".$N[target].">".$N[n_topic]."</a></font>";
								$db->query("USE ".$db_main);
										$G=$db->db_fetch_array($db->query("select * from article_group  WHERE c_id = '".$N[c_id]."' "));
										$subject = "เรื่อง".$G['c_name'];
										//File user login
										$db->query("USE ".$EWT_DB_USER);
										$sql_info =$db->db_fetch_array($db->query("select * from gen_user where gen_user_id='".$_SESSION["EWT_SMID"]."'"));
										$db->query("USE ".$db_main);
										$name = $sql_info[name_thai].''.$sql_info[surname_thai];
										$db->query("INSERT INTO n_history (h_subject,h_from_n,h_from_e,h_body,h_attach,h_date,h_time,h_user) VALUES ('".addslashes($subject)."','".addslashes($name)."','".addslashes($sql_info[email_kh])."','".addslashes($body)."','',NOW( ),NOW( ),'0')");
										$hid = mysql_insert_id();
										$sql_group_enew =$db->query( "select * from n_group,n_group_member,n_member where n_group.g_id=n_group_member.g_id and n_group_member.m_id=n_member.m_id and g_name= '".$N[c_id]."' and m_active ='Y'");
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
					}
					$db->query("USE ".$EWT_DB_USER);
				}
		}
	}
?>
<script language="javascript">
alert("Share article complete");
self.location.href = '<?php echo $_POST["backto"]; ?>';
</script>
<?php
			$db->db_close(); ?>
