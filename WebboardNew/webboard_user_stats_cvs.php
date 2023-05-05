<?php
include("../EWT_ADMIN/comtop.php");

echo "<br><br><br><br><br><br><br><br>";
/* function list_room($c_id,$depth){
global $db;
global $depth;
  
$sql_subcate = "SELECT * FROM w_cate WHERE c_parentid = '$c_id'"; 
$result_subcate = $db->query($sql_subcate);
$order_subcate = 1;
  	while($subcate = $db->db_fetch_array($result_subcate)){
		?>
				<?php for($e=0;$e<($depth+1);$e++){?><?php } ?> <?php echo "รหัสห้อง  ".$subcate[c_id]." ชื่อห้อง ".$subcate[c_name]." จากห้องรหัสหลัก คือ ".$subcate[c_parentid]."<br>"; 
					
					fwrite($objWrite,"\"$subcate[c_id]\",\"$subcate[c_name]\",\"$subcate[c_parentid]\" \n");
				?>
					

		<?php 
			$sql_q = mysql_query("SELECT * from  w_question where c_id = '$subcate[c_id]'  ");
			$num_q = $db->db_num_rows($sql_q);
			while($rec_q = $db->db_fetch_array($sql_q)){
			?>
				>><?php for($e=0;$e<($depth+1);$e++){?><?php } ?> <?php echo " รหัสคำถาม ".$rec_q[t_id]." หัวข้อกระทู้ ".$rec_q[t_name];?><?php echo " จำนวนผู้เข้าชม ".$rec_q[t_count]."<br>"; ?>
			<?php 
				fwrite($objWrite,"\"$rec_q[t_id]\",\"$rec_q[t_name]\",\"$rec_q[t_count]\" \n");
			}
			
			if($num_q == 0){
				?>
				&nbsp;<span class="style1">---ไม่พบหัวข้อกระทู้----</span><br>
				<?php
				fwrite($objWrite,"\"ไม่พบหัวข้อกระทู้\" \n");
			}
		?>

		<?php 

		
		$sql_subcate1 = "SELECT * FROM w_cate 
						WHERE c_parentid = '$subcate[c_id]'";

		$result_subcate1 = $db->query($sql_subcate1);
		$subcate1_row    = mysql_num_rows($result_subcate1);

		
		if($subcate1_row>0){
		$depth++;
		list_room($subcate[c_id],$depth);
		
		}
		else{
		
		}
    
	$order_subcate++;
	}
	$depth--;
}
$filName = "user_stat.csv";
$objWrite = fopen($filName, "w");
list_room($_GET[c_id], 1); 
fclose($objWrite);
echo "Generate CSV Done.<br><a href=$filName>Download</a>"; */

$sql = $db->query("SELECT * FROM w_cate");
$filName = "user_stat.csv";
$objWrite = fopen("user_stat.csv", "w");
while($data = $db->db_fetch_array($sql)){
	fwrite($objWrite,"\"$data[c_id]\",\"$data[c_name]\",\"$data[c_parentid]\" \n");
	$sql_sub = $db->query("SELECT * from  w_question where c_id = '$data[c_id]'");
	while($data_sub = $db->db_fetch_array($sql_sub)){
		fwrite($objWrite,"\" \",\"$data_sub[t_id]\",\"$data_sub[t_name]\",\"$data_sub[t_count]\" \n");
	}
}
fclose($objWrite);
echo "Generate CSV Done.<br><a href=$filName>Download</a>";
?>