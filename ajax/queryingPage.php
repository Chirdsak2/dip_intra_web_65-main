<?php
	if($_SERVER['REMOTE_ADDR']!=$_POST['addr']) {
		exit;
	}
?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head><body>
<?php
session_start();
$myPath='../../../';
/*Prepair connection*/
$myPath='../';
include("../ewt/prd_web/lib/function.php");
include("../ewt/prd_web/lib/user_config.php");
include("../ewt/prd_web/lib/connect.php");
	/*$q=mysql_query('SHOW FULL COLUMNS FROM organization');
	while($r=mysql_fetch_array($q)) {
		echo $r[0].'<br/>';
	}
    echo '<br/>';
    
    $q=mysql_query('SHOW FULL COLUMNS FROM org_qualityfull');
	while($r=mysql_fetch_array($q)) {
		echo $r[0].'<br/>';
	}
    echo '<br/>';
    
	$q=mysql_query('SHOW FULL COLUMNS FROM room_dev');
	while($r=mysql_fetch_array($q)) {
		echo $r[0].'<br/>';
	}
    echo '<br/>';*/
    if($_POST['db']=='') {
		$db->query('USE '.$EWT_DB_USER);
	} else {
		$db->query('USE '.$_POST['db']);
	}
	//$db->query('ALTER TABLE lab_guaranteed DROP COLUMN lab_category_id');
	if($_POST['full_query']!='') {
		$qData=$db->query(stripslashes($_POST['full_query']));
		$sizeR=0;
		echo '<table cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td>';
	} else {
		$table=$_POST['table'];
		$where=stripslashes($_POST['where']);
		$q=$db->query('SHOW FULL COLUMNS FROM '.$table);
		$sizeR=$db->db_num_rows($q);
		echo '<table cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td>';
		while($r=$db->db_fetch_array($q)) {
			echo '<td style="border:solid 1px green; padding:5px;background-color:#999;" title="Type:'.$r[1].' / Collation:'.$r[2].' / Null:'.$r[3].' / Key:'.$r[4].' / Default:'.$r[5].'">'.$r[0].'&nbsp;</td>';
		}
		$qData=$db->query('SELECT * FROM '.$table.' '.$where.' LIMIT 50');
	}
	$cntr=1;
	while($rData=$db->db_fetch_array($qData)) {
		echo '</tr><tr>';
		if($sizeR==0) {
			$sizeR=sizeof($rData);
		}
		echo '<td style="border:solid 1px green; padding:5px; background-color:#999;">'.$cntr.'</td>';
		for($i=0; $i<$sizeR; $i++) {
			echo '<td style="border:solid 1px green; padding:5px;">'.iconv('UTF-8', 'UTF-8', $rData[$i]).'&nbsp;</td>';
		}
		$cntr++;
	}
	echo '</tr></table>';
	$db->query('USE '.$EWT_DB_NAME);
?>
</body></html>