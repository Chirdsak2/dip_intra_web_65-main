<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
$dayname = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
function convert_date($date,$a){
global $monthname;
$d = explode("-",$date);
if($a == "/"){
$nd = $d[2]."/".$d[1]."/".($d[0] + 543);
}else{
$nd = $d[2]." ".$monthname[number_format($d[1],0)]." ".($d[0] + 543);
}
return $nd;
}
if($start_date == "" AND $end_date == ""){
$con = " AND (sv_date = '".date("Y-m-d")."') ";
$title = "";
}elseif($start_date != "" AND $end_date == ""){
$st = explode("/",$start_date);
$con = " AND (sv_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$title = "วันที่ ".$start_date;
}elseif($start_date == "" AND $end_date != ""){
$st = explode("/",$end_date);
$con = " AND (sv_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$title = "วันที่". $end_date;
}else{
$st = explode("/",$start_date);
$en = explode("/",$end_date);
$con = " AND (sv_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
$title = "วันที่ ".$start_date ."ถึงวันที่". $end_date;
}

?>
<html>
<head>
<title>Stat</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript"  type="text/javascript" src="lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="lib_carendar/calendar-th.js"></script>
<link href="lib_carendar/style_calendar.css" rel="stylesheet" type="text/css">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">Visitor per Week</span></td>
  </tr>
</table>
<table width="96%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30">Visitor per Week</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
						$graph_name = array();
						$graph_data = array();
						$calweek = JulianToJD($st[1],$st[0],($st[2] -543));
			  for($m=0;$m<7;$m++){ 
		$stw = explode("/",JDToJulian($calweek));
		$dateofweek = $stw[2]."-".$stw[0]."-".$stw[1];
		$calweek++;
		$sql_time = $db->query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y'  AND sv_date = '".$dateofweek."' ");
		$ccount = mysql_fetch_row($sql_time);
				array_push($graph_name,$dayname[$m]);
				array_push($graph_data,$ccount[0]);
				}
				$graph_height  = "450";
  				$graph_width  = "800";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
	</td>
  </tr>
</table>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30">จำนวนผู้เข้าชมเว็บไซต์</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql1 = $db->query("SELECT count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." ORDER BY ct DESC LIMIT 0,50");
	$R1 = mysql_fetch_row($sql1);
				array_push($graph_name,"Total Visitor");
				array_push($graph_data,$R1[0]);
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
	</td>
  </tr>
</table></td>
    <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30">จำนวนผู้เข้าชมเว็บไซต์</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
 	$sql2 = $db->query("SELECT count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_new = 'Y' ".$con."  ORDER BY ct DESC LIMIT 0,50");
	$R2 = mysql_fetch_row($sql2);
				array_push($graph_name,"New Visitor");
				array_push($graph_data,$R2[0]);
				array_push($graph_name,"Old Visitor");
				array_push($graph_data,($R1[0] - $R2[0]));
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
	</td>
  </tr>
</table></td>
  </tr>
</table>


<table width="96%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30">page rank</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_menu , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_menu != '' ".$con." GROUP BY sv_menu ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "450";
  				$graph_width  = "800";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
	</td>
  </tr>
</table>
<table width="96%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30">Time Rank</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center">
	<?php
						$graph_name = array();
						$graph_data = array();
			  for($m=0;$m<24;$m++){ 
		$mstart = sprintf("%02d",$m).":00";
		$mend = sprintf("%02d",$m).":59";
		$sql_time = $db->query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_url = 'page'  AND  sv_visitor = 'Y'  ".$con."  AND (sv_time BETWEEN '".$mstart.":00"."' AND '".$mend.":59"."')");
		$ccount = mysql_fetch_row($sql_time);
				array_push($graph_name,$mstart."-".$mend);
				array_push($graph_data,$ccount[0]);
				}
				$graph_height  = "450";
  				$graph_width  = "800";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
	</td>
  </tr>
</table>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">Country</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_country , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." GROUP BY sv_country ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
    <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">ISP</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_isp , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." GROUP BY sv_isp ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
     <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">OS</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_os , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." GROUP BY sv_os ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
    <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">Resolution</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_resolution , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." GROUP BY sv_resolution ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">Browser</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_browser , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." GROUP BY sv_browser ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
    <td><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">Domain</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_domain , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' ".$con." GROUP BY sv_domain ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
  </tr>
  
  <tr>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">Local UIP</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	$sql = $db->query("SELECT sv_ip , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y'   AND sv_country = 'THAILAND' ".$con." GROUP BY sv_ip ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">International UIP</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center" > 
                        <?php
			$graph_name = array();
			$graph_data = array();
	$sql = $db->query("SELECT sv_ip , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y'   AND sv_country != 'th' ".$con." GROUP BY sv_ip ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%" valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="31">Language</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	//		$graph_link = array();
	$sql = $db->query("SELECT sv_language , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_language != '' ".$con." GROUP BY sv_language ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="30">Search engine</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <?php
			$graph_name = array();
			$graph_data = array();
	$sql = $db->query("SELECT sv_search , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND sv_search != '' ".$con." GROUP BY sv_search ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
			//	array_push($graph_link,$link);
	}
				$graph_height  = "400";
  				$graph_width  = "450";
				$graph_group = "Y";
				$graph_rotate = "1";
				include("../ewt_graph_include.php");
	
	?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="31">Keyword</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"> 
            <iframe  src="site_keyword.php?con=<?php echo urlencode(addslashes($con)); ?>"  frameborder="0"  width="450" height="400" scrolling="yes" ></iframe>
          </td>
        </tr>
      </table></td>
    <td valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
        <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
          <td width="5%" height="31">Referer</td>
        </tr>
        <tr bgcolor="#FFFFFF"> 
          <td> 
            <?php
	$sql = $db->query("SELECT sv_referer , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y'  AND  sv_referer != '' ".$con." GROUP BY sv_referer ORDER BY ct DESC LIMIT 0,50");
	while($R = mysql_fetch_row($sql)){
				$ref = "";
				if(strlen($R[0]) > 60){
				$ref = substr($R[0],0,60)."...";
				}else{
				$ref = $R[0];
				}
				echo "<li> <a href=\"".$R[0]."\" target=\"_blank\">".$ref." </a>(".$R[1].")</li>";
	}
	
	?>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
