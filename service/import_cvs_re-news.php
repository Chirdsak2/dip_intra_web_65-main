<?php
session_start();
include("../../lib/function.php");
	
//include("../../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
	
include("../../language/menu_language.php");


$objCSV = fopen("re_news_TH.csv", "r");
while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
	
	$origDate = $objArr[3];

	$date = str_replace('/', '-', $origDate );
	$newDate = date("Y-m-d H:i:s", strtotime($date));
	$newDate."<br>";
	##ตรวจสอบค่าซ้ำ นำเข้า contents##
	$ch_url = iconv('UTF-8','TIS-620',$objArr[2]);
	$sql_con_ck = "SELECT * FROM ditp_contents WHERE contents_url = '".$ch_url."'";
	$query_con_ck = $db->query($sql_con_ck);
	$sql_con_num = $db->db_num_rows($query_con_ck);
	$sql_con = $db->db_fetch_array($query_con_ck);
	if($sql_con_num==0){
		##นำเข้า contents##
		$objArr[2] = iconv('UTF-8','TIS-620',$objArr[2]);
		$sql_con = "INSERT INTO ditp_contents (contents_image,contents_url,contents_create_date) 
				VALUES('".$objArr[1]."','".$objArr[2]."','".$newDate."')";
		//$query_con = $db->query($sql_con);
	}
	
	##หาค่า content_id##
	$sql_cate_id = "SELECT * FROM ditp_contents WHERE contents_url = '".$objArr[2]."'";
	$query_cate_id = $db->query($sql_cate_id);
	$sql_cate_id_num = $db->db_num_rows($query_cate_id);
	$sql_cate_id = $db->db_fetch_array($query_cate_id);
		
	if($sql_cate_id_num==1){
	##นำเข้า contents_cate##
		$sql_cate = "INSERT INTO ditp_contents_cate (contents_id,cate_id) 
				VALUES('".$sql_cate_id['contents_id']."','".$objArr[4]."')";
		//$query_cate = $db->query($sql_cate);
		
	##นำเข้า contents_lang##
	$objArr[6] = iconv('UTF-8','TIS-620',$objArr[6]);
	$objArr[6] = addslashes($objArr[6]);
		$sql_lang = "INSERT INTO ditp_contents_lang (contents_id,lang_code,contents_title) 
				VALUES('".$sql_cate_id['contents_id']."','".$objArr[5]."','".$objArr[6]."')";
		//$query_lang = $db->query($sql_lang);
		
		
		
		
	##นำเข้า contents_country##
		$sql_country = "INSERT INTO ditp_contents_country (contents_id,country_id) 
				VALUES('".$sql_cate_id['contents_id']."','75')";
		//$query_country = $db->query($sql_country);
		
	}
	
	##ลบ##	
	$sql = "SELECT * FROM ditp_contents_cate WHERE contents_id > '559228' AND cate_id = '445' ";
	$query = $db->query($sql);
	$num = $db->db_num_rows($query);
	while($de = $db->db_fetch_array($query)){
		
		$sql_del_lang = "DELETE FROM ditp_contents_lang WHERE contents_id = '".$de['contents_id']."' ";
		//$query_del_lang = $db->query($sql_del_lang);
		
		$sql_del_country = "DELETE FROM ditp_contents_lang WHERE contents_id = '".$de['contents_id']."' ";
		//$query_del_country = $db->query($sql_del_country);
		
		$sql_del_con = "DELETE FROM ditp_contents WHERE contents_id = '".$de['contents_id']."' ";
		//$query_del_con = $db->query($sql_del_con);
		
		$sql_del_cate = "DELETE FROM ditp_contents_cate WHERE contents_id = '".$de['contents_id']."' ";
		//$query_del_cate = $db->query($sql_del_cate);
		
	}
	
	
}
fclose($objCSV);

echo "Import Done.";
?>
</table>
</body>
</html>