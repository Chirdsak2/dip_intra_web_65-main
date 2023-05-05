<?php
session_start();
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$path_cal = "";

$sql_rude="SELECT * FROM vulgar_table ";
$query_rude=$db->query($sql_rude);
while($data = $db->db_fetch_array($query_rude)){ 
	 $array_rude[]=$data[vulgar_text];
}

function cencer_rude($str){
		global  $array_rude;
		for($i=0;$i<sizeof($array_rude);$i++){
				$str=ereg_replace($array_rude[$i],'...',$str);
				//str_replace($array_rude[$i],$str
		}
		return  $str;
}
$news_id = $_POST[news_id];
$detail = stripslashes(htmlspecialchars($_POST[detail],ENT_QUOTES));
$name_comment = stripslashes(htmlspecialchars($_POST[name_comment],ENT_QUOTES));
//select for shere
$sql = "select article_list.n_shareuse,article_list.n_sharename,article_list.n_shareid from article_list where n_id = '".$news_id."'";
$query = $db->query($sql);
$X = $db->db_fetch_array($query);
//cese shere from site other
		if($X[n_shareuse] =='Y'){
		$db->query("USE ".$EWT_DB_USER);
		$sql_X = "select db_db from user_info where EWT_User ='".$X[n_sharename]."'";
		$query_X = $db->query($sql_X);
		$N = $db->db_fetch_array($query_X);
		$db_name_parent = $N[db_db];
		//file parent id
		$sql_parent_id = "select user_t from share_article where share_article.sg_id='".$X[n_shareid]."'";
		$query_parent_id = $db->query($sql_parent_id);
		$R_parent_id = $db->db_fetch_array($query_parent_id);
		$db->query("USE ".$EWT_DB_NAME);
		}
if (!empty($news_id)	){
   $sql_max = "SELECT max(id_ans) as number_max FROM news_comment  WHERE news_id = '$news_id' AND status_comment = 'Y' ";
   $query_max  = mysql_query($sql_max);
   $res = $db->db_fetch_array($query_max);
   $id_ans =$res[number_max]+1;

	######## ตรวจสอบคำหยาบ ##############
   /*$sql_vulgar = "SELECT *  FROM vulgar_table ";
   $query_vulgar  = mysql_query($sql_vulgar);
   $i=0;
   	while ($res_vulgar = $db->db_fetch_array($query_vulgar)){
   		$vulgar[$i] = $res_vulgar[vulgar_text];
	$i++;
	}*/
	######## บันทึก comment ##############
	//$comment = str_replace($vulgar, '***', $detail);
	$comment = $detail;
	$status_comment ="Y";

					if($_SERVER["REMOTE_ADDR"]){
						$ip_comment = $_SERVER["REMOTE_ADDR"];
					}else{
						$ip_comment = $_SERVER["REMOTE_HOST"];
					}

	$sql  = " INSERT INTO news_comment (news_id,ip_comment,comment,name_comment,status_comment,id_ans,timestamp,id_member)";
	$sql .=" VALUE ('$news_id','$ip_comment','$comment','$name_comment','$status_comment',$id_ans,'".date('YmdHis')."','".$_SESSION["EWT_MID"]."')";
	$query = mysql_query($sql);
	
	//cese shere from site other to parent
		if($X[n_shareuse] =='Y'){
		$db->query("USE ".$db_name_parent);
		 $sql_max = "SELECT max(id_ans) as number_max FROM news_comment  WHERE news_id = '".$X[n_shareid]."' AND status_comment = 'Y' ";
		   $query_max  = mysql_query($sql_max);
		   $res = $db->db_fetch_array($query_max);
		   $id_ans =$res[number_max]+1;
		    $sql  = " INSERT INTO news_comment (news_id,ip_comment,comment,name_comment,status_comment,id_ans,timestamp,id_member)";
			$sql .=" VALUE ('".$R_parent_id[n_id]."','$ip_comment','$comment','$name_comment','$status_comment',$id_ans,'".date('YmdHis')."','".$_SESSION["EWT_MID"]."')";
			$query = mysql_query($sql);
		$db->query("USE ".$EWT_DB_NAME);
		}
			//cese shere from site other to child
		if($X[n_share] =='Y'){
			$db->query("USE ".$EWT_DB_USER);
			$sql_S= "select * from share_article where n_id ='".$news_id."' and user_s ='".$EWT_FOLDER_USER."' and s_status ='Y'";
			$query_S = $db->query($sql_S);
			while($RR=$db->db_fetch_array($query_S)){
				$sql2 = "select db_db from user_info where EWT_User ='".$RR[user_t]."'";
				$query2 = $db->query($sql2);
				$N = $db->db_fetch_array($query2);
				$db_name_parent = $N[db_db];
				$db->query("USE ".$db_name_parent);
				 $sql_max = "SELECT max(id_ans) as number_max FROM news_comment  WHERE news_id = '".$RR[n_id_t]."' AND status_comment = 'Y' ";
			   $query_max  = mysql_query($sql_max);
			   $res = $db->db_fetch_array($query_max);
			   $id_ans =$res[number_max]+1;
				$sql  = " INSERT INTO news_comment (news_id,ip_comment,comment,name_comment,status_comment,id_ans,timestamp,id_member)";
				$sql .=" VALUE ('".$RR[n_id_t]."','$ip_comment','$comment','$name_comment','$status_comment',$id_ans,'".date('YmdHis')."','".$_SESSION["EWT_MID"]."')";
				$query = mysql_query($sql);
				$db->query("USE ".$EWT_DB_USER);
			}
			$db->query("USE ".$EWT_DB_NAME);
		}
}
?>
<script language="JavaScript"  type="text/javascript">
 location.href='ewt_news.php?nid=<?php echo $news_id;?>';
</script>
<?php $db->db_close(); ?>  
