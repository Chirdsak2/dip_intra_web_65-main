<?php
header('Content-Type: text/html; charset=utf-8');
DEFINE('path', 'assets/');
include(path.'config/config.inc.php');
?>
<option value="">- เลือกอำเภอ -</option>
<?php
	$s_amphur = "select * from ".E_DB_USER.".amphur where p_code = '".$_GET['p']."' ORDER BY a_name ASC"; 
	//$query_amphur= $db->query($sql_amphur);
	//while($rec_amphur=$db->db_fetch_array($query_amphur)){
	$a_amphur = db::getFetchAll($s_amphur,PDO::FETCH_ASSOC); 
	if($a_amphur) 
	{	
		foreach((array)$a_amphur as $rec_amphur)
		{		
	?>
	<option value="<?php echo $rec_amphur['a_code'];?>"><?php echo $rec_amphur['a_name'];?></option>
	<?php
		}
	}
?>

