<?php
include("admin.php");

if($c_id){
    $sell1 = $db->query("UPDATE poll_cat SET c_approve='Y' WHERE c_id = '$c_id'");
     $db->write_log("approve","poll","อนุมัติแบบสำรวจ");
 ?>

 <script language="javascript">
	alert("<?php echo $text_genpoll_Vote_ApproveFin; ?>");
	window.location.href="main.php";
</script>

<?php } ?>