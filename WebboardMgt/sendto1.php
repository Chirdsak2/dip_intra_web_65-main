<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");

if($_POST["Flag"] == "Send"){

if($_POST["typer"] == "P"){
			$db->query("USE ".$EWT_DB_USER);
			$sql_user = "select name_thai,surname_thai,email_person from gen_user where gen_user_id = '".$_POST["professor"]."'";
			$query_user = $db->query($sql_user);
			$rec_user = $db->db_fetch_array($query_user);
			$myname = $rec_user["name_thai"]." ".$rec_user["surname_thai"];
			$myemail = $rec_user["email_person"];
}else{
			$myname = $_POST["name"];
			$myemail = $_POST["s_email"];
}
$myname = iconv( 'UTF-8' ,'UTF-8', $myname );
$db->query("USE ".$EWT_DB_USER);
$sql_user = "select url from user_info where UID = '".$_SESSION["EWT_SUID"]."'";
$query_user = $db->query($sql_user);
$rec_user = $db->db_fetch_array($query_user);
$db->query("USE ".$EWT_DB_NAME);
$Execsql1 = $db->query("SELECT * FROM w_question WHERE t_id = '".$_POST["wtid"]."'");
$R= mysql_fetch_array($Execsql1);
$R["t_name"] = iconv( 'UTF-8' ,'UTF-8', $R["t_name"] );
$myurl = $rec_user["url"]."index_answer_prof.php?wtid=".$_POST["wtid"];
$body = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />เน€เธฃเธตเธขเธ ".$myname;
$body .= "<br><br>เน€เธฃเธตเธขเธเน€เธเธดเธเธ•เธญเธเธเธณเธ–เธฒเธกเธซเธฑเธงเธเนเธญ \"".$R["t_name"]."\"<br>เธ—เธตเน <a href=\"".$myurl."\" target=\"_blank\">".$myurl."</a><br><br><br>เธเธญเธเธเธฃเธฐเธเธธเธ“เน€เธเนเธเธญเธขเนเธฒเธเธชเธนเธ<br><br>เธเธนเนเธ”เธนเนเธฅเธฃเธฐเธเธ";

include('../NewsLetterMgt/libmail.php');
$m = new Mail();
$m->From("Webboard Admin<webmaster@moe.go.th>");
$m->Subject("เน€เธฃเธตเธขเธ ".$myname);
$m->Body($body,"text/html");
$m->To(trim($myemail));
$m->Send();


?>
<script type="text/javascript">
alert("Send data success");	
window.close();
</script>
<?php
exit;

}
@$db->db_close(); ?>