<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");



if($start == ""){
$start = 0;
}

$sql = $db->query("SELECT lid,link_url FROM check_link ORDER BY lid ASC LIMIT ".$start.",1");

if($db->db_num_rows($sql)){

while($R = $db->db_fetch_row($sql)){

$url1 = "http://58.137.128.181/ewtadmin/ewt/dmr_web/";

if(eregi("http://", $R[1])) {
$url = $R[1];
}else{
$url = $url1.$R[1];
}

$line = "";
//echo "#".$R[0].":".$url."<br>";
$fp = @fopen($url ,"r");
if($fp){ 
$db->query("UPDATE check_link SET link_detail = 'OK' WHERE lid = '".$R[0]."' ");
}else{
$db->query("UPDATE check_link SET link_detail = 'NO' WHERE lid = '".$R[0]."' ");
}
@fclose($fp);


}
$start++;
$sql1 = $db->query("SELECT COUNT(filename) FROM check_link ");
$C = $db->db_fetch_row($sql1);

$allrow = $C[0];
$percent = number_format((($start/$allrow)*100),2);
$percent1 = number_format($percent,2);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body leftmargin="0" topmargin="0">
<p><font size="4" face="Tahoma" color=red><strong>Please wait ....................................Checking 
  all link.</strong></font></p>
<strong><font size="4" face="Tahoma"><?php echo $percent; ?>% checking... </font></strong> 
<table width="400" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="<?php echo $percent1; ?>%" border="0" cellpadding="1" cellspacing="1" bgcolor="#FF0000">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
$time = $allrow - $start;
if($time > 0 AND $time < 60){
$timet = number_format(($time/2),0)." Second(s)";
}elseif($time > 60 AND $time < 3600){
$timet = number_format(($time/60),0)." Minute(s)";
}elseif($time > 3600){
	$t1 = number_format(($time/3600),2);
	$t = explode(".",$t1);
$timet = $t[0]." Hour(s) and ".number_format((($time%3600)/120),0)." minute(s)";
}
?>
<strong><font size="4" face="Tahoma"><?php echo $timet; ?> left. </font></strong>
</body>
</html>
<?php
}else{
}
ob_flush();
$db->db_close();
?>
