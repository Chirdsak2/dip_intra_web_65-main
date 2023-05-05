<?php
include("authority.php");
?>
<?php 
$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";

if($_POST["Flag"] == 'Add'){
if(($file_size >0) and ($file_size < 500000)){

$sel=$db->query("select * from n_file where f_name = '$file_name'");
if($Row = mysql_num_rows($sel)){ 
	$R = mysql_fetch_array($sel);
	$rfile = rand(1,9999);
copy($file,$Path_true."/".$rfile.".tmp");
echo"<form name='form1' method='post' action='file_function.php'>";
echo "<input name=\"f_id\" type=\"hidden\" value=\"".$R[f_id]."\">";
echo "<input name=\"Flag\" type=\"hidden\" value=\"Replace\">";
echo "<input name=\"filer\" type=\"hidden\" value=\"".$rfile.".tmp\">";
echo "<input name=\"filen\" type=\"hidden\" value=\"".$file_name."\">";
echo "<input name=\"filet\" type=\"hidden\" value=\"".$file_type."\">";
echo "<input name=\"files\" type=\"hidden\" value=\"".$file_size."\">";
echo"</form>";
?>
<script language="javascript">
var r = confirm(" <?php echo $file_name; ?> <?php echo $lang_file_already; ?>");
if(r==true){
document.form1.submit();
}else{
window.location.href="file_mod.php?filedel=<?php echo $rfile; ?>.tmp";
}
</script>
	<?php
}else{

	if(copy($file,$Path_true."/".$file_name)){

	$ins = "INSERT INTO `n_file` ( `f_id` , `f_name` , `f_type` , `f_date`, `f_size` )VALUES ('', '$file_name', '$file_type', NOW( ),'$file_size' )";
	$r = $db->query($ins);
unlink($file);
$db->write_log("create","enews","สร้างfile E-news letter  : ".$file_name);
		?>
<script language="javascript">
window.location.href="file_mod.php?msg=Y";
</script>
		<?php
	}else{ ?>
<script language="javascript">
	alert("can not upload file");
window.location.href="file_mod.php";
</script>
<?php
}
}
}else{
	@unlink($file);
?>
<script language="javascript">
alert("<?php echo$lang_file_limit_size; ?>");
window.location.href="file_mod.php";
</script>
	<?php
}
}elseif($Flag == 'Replace'){
if(@copy($Path_true."/".$filer,$Path_true."/".$filen)){
$r = $db->query("update n_file set f_type = '$filet',f_date= NOW( ),f_size='$files' where f_id = '$f_id'");
@unlink($Path_true."/".$filer);
$db->write_log("create","enews","สร้างfile E-news letter  : ".$filer);
		?>
<script language="javascript">
window.location.href="file_mod.php?msg=Y&filedel=<?php echo $filer; ?>";
</script>
		<?php
}else{
?>
<script language="javascript">
	alert("<?php echo $lang_file_cant_upload; ?>");
window.location.href="file_mod.php";
</script>
<?php
}
}elseif($flag == 'Delete'){
for($i=0;$i<$all;$i++){
	$gid = 'gid'.$i;
	$gid = $$gid;
	$fname = 'fname'.$i;
	$fname = $$fname;
if($gid <> ''){
@unlink($Path_true."/".$fname);
	$del = "delete from n_file where f_id = '$gid'";
	$r = $db->query($del);
	$db->write_log("delete","enews","ลบfile E-news letter  : ".$fname);
}
}

		?>
<script language="javascript">
window.location.href="file_mod.php?msg=Y";
</script>
		<?php
}
?>
