<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
DEFINE('path', 'assets/');
include(path.'config/config.inc.php');
?>
<option value="">- เลือกตำบล - </option> 
<?php
	$s_tumpon = "select * from ".E_DB_USER.".tumpon where p_code = '".$_GET['p']."' and a_code = '".$_GET['am']."' ORDER BY t_name ASC";
	//$query_tumpon= $db->query($sql_tumpon);
	//while($rec_tumpon=$db->db_fetch_array($s_tumpon)){
	$a_tumpon = db::getFetchAll($s_tumpon,PDO::FETCH_ASSOC);
	if($a_tumpon) 
	{	
		foreach((array)$a_tumpon as $rec_tumpon)
		{	
?>
	<option value="<?php echo $rec_tumpon['t_code'];?>"><?php echo $rec_tumpon['t_name'];?></option> 
<?php
		}
	}
?>

