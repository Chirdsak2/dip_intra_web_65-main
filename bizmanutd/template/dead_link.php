<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

function pc_link_extractor($s,$filename) {
	global $db,$PHPSESSID;
//  $a = array();
  if (preg_match_all('/<a\\s+.*?href=[\\"\\\']?([^\\"\\\' >]*)[\\"\\\']?[^>]*>(.*?)<\\/a>/i',$s,$matches,PREG_SET_ORDER)) {
    foreach($matches as $match) {
		if(!eregi("mailto:", $match[1])){
	  $db->query("INSERT INTO check_link (filename,link_name,link_url,link_detail,session) VALUES ('".$filename."','".addslashes($match[2])."','".addslashes($match[1])."','','".$PHPSESSID."')");
		}
    }
  }
  return true;
}

$url = "http://58.137.128.181/ewtadmin/ewt/dmr_web/";

if($start == ""){
$start = 0;
}

$sql = $db->query("SELECT filename FROM temp_index LIMIT ".$start.",1");

if($db->db_num_rows($sql)){

$R = $db->db_fetch_row($sql);

$url .= "main.php?filename=".$R[0];

$fp = @fopen($url ,"r");
if($fp){ 
while($html = @fgets($fp, 1024)){
$line .= $html;
}
}
@fclose($fp);

$sql1 = $db->query("SELECT COUNT(filename) FROM temp_index ");
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
<p><font size="4" face="Tahoma"><strong>Please wait ....................................Checking 
  all page.</strong></font></p>
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
</body>
</html>
<?php
$a = pc_link_extractor($line,$R[0]);
$start ++;
?>
<script language="javascript">
window.location.href = "dead_link.php?start=<?php echo $start; ?>";	
</script>
<?php
}else{
?>
<script language="javascript">
window.location.href = "dead_link2.php";	
</script>
<?php
}
$db->db_close();
?>
