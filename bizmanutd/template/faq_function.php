<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$today=date("Y-m_d");
if($flag == "addfaq"){
		$fdetail = eregi_replace(chr(13)," <br> ", $fdetail );
		$fans = eregi_replace(chr(13)," <br> ", $fans );
		$fname = eregi_replace(chr(13)," <br> ", $fname );
$db->query("INSERT INTO faq_user (faq_user_id,f_id,faq_user_name,faq_user_detail,faq_user_ask,faq_user_ans,f_sub_id,faq_date,faq_status) VALUES ('','$f_id','$fname','$fdetail','$fask','$fans','$f_sub_id','$today','0')");
?>
<script language="JavaScript">
	alert("เพิ่มข้อมูล  FAQ เรียบร้อยแล้ว รออนุมัติ");
window.close();
</script>
	<?php
}
if($flag == "addfaq_sub"){
		$fdetail = eregi_replace(chr(13)," <br> ", $fdetail );
		$fans = eregi_replace(chr(13)," <br> ", $fans );
		$fname = eregi_replace(chr(13)," <br> ", $fname );
$db->query("INSERT INTO faq_answer (f_id,faq_user_name,faq_user_email,faq_user_detail,faq_user_ans,fa_id,faq_date) VALUES ('0','$fask','$email','$fdetail','$fask','$fa_id','$today')");
?>
<script language="JavaScript">
	alert("เพิ่มข้อมูล  FAQ เรียบร้อยแล้ว ");
window.close();
</script>
	<?php
}
?>
