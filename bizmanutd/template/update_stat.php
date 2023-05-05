<?php
//exit;
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");

function Dot2LongIP ($IPaddr)
{
    if ($IPaddr == "") {
        return 0;
    } else {
        $ips = split ("\.", "$IPaddr");
        return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
    }
}

	$sql = $db->query("SELECT MIN(sv_id),sv_ip FROM stat_visitor WHERE sv_visitor IS NULL GROUP BY sv_ip,sv_date ORDER BY sv_id");
		while($R = $db->db_fetch_row($sql)){

		$ipno = Dot2LongIP($R[1]);
		$db->query("USE ".$EWT_DB_USER);
		$sql_country = $db->query("SELECT * FROM location WHERE " . $ipno . " BETWEEN IP_FROM AND IP_TO LIMIT 0,1");
//		echo "SELECT * FROM location WHERE " . $ipno . " BETWEEN IP_FROM AND IP_TO LIMIT 0,1<br>";
		$C = $db->db_fetch_row($sql_country);
			$mycountry = $C[3];
			$mydomain = $C[9];
			$myisp = addslashes($C[8]);
			$myregion = $C[4];
			$mycity = $C[5];
			$mylatitude = $C[6];
			$mylonditude = $C[7];
			if($mycountry  == ""){
			$mycountry  = "-";
			}

		$db->query("USE ".$EWT_DB_NAME);
		$db->query("UPDATE stat_visitor SET sv_visitor = 'Y',sv_country='$mycountry',sv_domain='$mydomain',sv_isp='$myisp',sv_region='$myregion',sv_city='$mycity',sv_latitude='$mylatitude',sv_longitude='$mylonditude' WHERE sv_id = '$R[0]'");
		echo "UPDATE stat_visitor SET sv_visitor = 'Y',sv_country='$mycountry',sv_domain='$mydomain',sv_isp='$myisp',sv_region='$myregion',sv_city='$mycity',sv_latitude='$mylatitude',sv_longitude='$mylonditude' WHERE sv_id = '$R[0]' <br>";

		}
		echo "Done";
 $db->db_close(); 
?>