<?php
//include("administrator.php");
//include("inc.php");
include("lib/include.php");
include("../language/dict_language.php");
$db->query("USE ".$EWT_DB_USER);
$ip_data = getenv("REMOTE_ADDR");
$date_data = date('Y-m-d');

$dict_id=$_POST[dict_id];
$flag=$_POST[flag];

if($flag==''){
  $dict_id=$_GET[dict_id];
  $flag=$_GET[flag];
}

$DICT_WORD = stripslashes(htmlspecialchars($_POST[DICT_WORD],ENT_QUOTES));
$DICT_SEARCH = stripslashes(htmlspecialchars($_POST[DICT_SEARCH],ENT_QUOTES));
$DICT_SYNONYM = stripslashes(htmlspecialchars($_POST[DICT_SYNONYM],ENT_QUOTES));

if($flag == 'add'){
      $sql = "select * from dictionary where 
                       DICT_WORD like '$DICT_WORD'  AND  
					   DICT_SEARCH like '$DICT_SEARCH'  AND 
					   DICT_SYNONYM like '$DICT_SYNONYM'  ";
	$query = $db->query($sql);
	if($db->db_num_rows($query)>0){ ?>
		<script>
		 				alert('<?php echo $text_gendict_noadd;?>'); 
		 				self.location.href='dict_cate.php';
		 </script>
	<?php }else{
		 $add_sql = "INSERT INTO dictionary(DICT_WORD,DICT_SEARCH,DICT_SYNONYM) 
		 VALUES ('$DICT_WORD','$DICT_SEARCH','$DICT_SYNONYM')";
		 $db->query($add_sql);
		 $db->query("USE ".$EWT_DB_NAME);
		 $db->write_log("create","dict","เพิ่มคำศัพท์  ".$t_topic);
	}
}

if($flag == 'edit'){
       $sql = "select * from dictionary where 
                       DICT_WORD like '$DICT_WORD'  AND  
					   DICT_SEARCH like '$DICT_SEARCH'  AND 
					   DICT_SYNONYM like '$DICT_SYNONYM' AND  DICT_ID <> '$dict_id'  ";
     $query = $db->query($sql);
     if($db->db_num_rows($query)>0){ ?>
		 <script>
		 				alert('<?php echo $text_gendict_noadd;?>'); 
		 				self.location.href='dict_cate.php';
		 </script>
   <?php }else{
		  $update_sql = " update dictionary set 
		                         DICT_WORD='$DICT_WORD',
		                         DICT_SEARCH='$DICT_SEARCH',
								 DICT_SYNONYM='$DICT_SYNONYM' 
								 where (DICT_ID='$dict_id') ";
		  $db->query($update_sql);
		  $db->query("USE ".$EWT_DB_NAME);
		  $db->write_log("update","dict","แก้ไขคำศัพท์".$t_topic);
		  //echo $update_sql;
		  //exit();
    }
}


if($flag == 'del'){
		$rec = $db->db_fetch_array($db->query("select * from dictionary where (DICT_ID='$dict_id')"));
		$del_sql = " delete from dictionary where (DICT_ID='$dict_id') ";
		$db->query($del_sql);

		$db->query("USE ".$EWT_DB_NAME);
		$db->write_log("delete","dict","ลบคำศัพท์ ".$rec[DICT_WORD]);
}?>


		<script>
		 				alert('<?php echo $text_gendict_complete;?>'); 
		 				self.location.href='dict_cate.php';
		 </script>

<?php
$db->db_close(); 

?>
