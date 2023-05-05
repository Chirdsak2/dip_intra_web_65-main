<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$con = stripslashes(urldecode($_GET["con"]));
$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
function convert_date($date,$a,$plus){
global $monthname;
$d = explode("-",$date);
if($a == "/"){
$nd = number_format($d[2],0)."/".$d[1]."/".($d[0] + $plus);
}else{
$nd = number_format($d[2],0)." ".$monthname[number_format($d[1],0)]." ".($d[0] + $plus);
}
return $nd;
}
if($start_date == "" AND $end_date == ""){
$con = " AND (sv_date = '".date("Y-m-d")."') ";
$title = "วันที่ ".convert_date(date("Y-m-d")," ",543);
$sw["y"] = date("Y");
$sw["m"] = date("m");
$sw["d"] = date("d");
$searchs = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$searche = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
}elseif($start_date != "" AND $end_date == ""){
$st = explode("/",$start_date);
$con = " AND (sv_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$title = "วันที่ ".convert_date($st[2]."-".$st[1]."-".$st[0]," ",0);
$sw["y"] = ($st[2] -543);
$sw["m"] = $st[1];
$sw["d"] = $st[0];
$searchs = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$searche = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
}elseif($start_date == "" AND $end_date != ""){
$st = explode("/",$end_date);
$con = " AND (sv_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$title = "วันที่ ".convert_date($st[2]."-".$st[1]."-".$st[0]," ",0);
$sw["y"] = ($st[2] -543);
$sw["m"] = $st[1];
$sw["d"] = $st[0];
$searchs = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$searche = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
}else{
$st = explode("/",$start_date);
$en = explode("/",$end_date);
$con = " AND (sv_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
$title = "จากวันที่ ".convert_date($st[2]."-".$st[1]."-".$st[0]," ",0)." ถึงวันที่ ". convert_date($en[2]."-".$en[1]."-".$en[0]," ",0);
$sw["y"] = ($st[2] -543);
$sw["m"] = $st[1];
$sw["d"] = $st[0];
$searchs = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$searche = JulianToJD($en[1],$en[0],($en[2] -543));
}

$calweek = JulianToJD($sw["m"],$sw["d"],$sw["y"]);
$calweek2 = $calweek + 2;
$days = $calweek2%7;
$stweek = ($calweek - $days);
$enweek = $stweek+6;
$stw = explode("/",JDToJulian($stweek));
$enw = explode("/",JDToJulian($enweek));
$startweek = $stw[1]."/".$stw[0]."/".($stw[2]+543);
$endweek = $enw[1]."/".$enw[0]."/".($enw[2]+543);
$startmonth = "01/".$sw["m"]."/".($sw["y"]+543);
$date_string = mktime(0,0,0,$sw["m"],1,$sw["y"]);
$eday1 = date("t",$date_string);
$endmonth = $eday1."/".$sw["m"]."/".($sw["y"]+543);
$startyear = "01/01/".($sw["y"]+543);
$endyear = "31/12/".($sw["y"]+543);
$monthx2 = $sw["m"]."-".$sw["y"];
?>
<html>
<head>
<title>Stat</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
สถิติการเข้าเว็บไซต์  <?php echo $title; ?>
<?php 
$sql = $db->query("SELECT sv_menu , count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_menu != '' ".$con." ");
 ?>
</body>
</html>
<?php
$db->db_close(); ?>
