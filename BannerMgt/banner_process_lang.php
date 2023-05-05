<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");

if($_POST[flag] == 'set_lang'){
$namefolder = 'banner_'.$_POST[lang].'_'.$_POST[banner_id];
$txt .= "<?php   \n";
$txt .= "$"."banner_name = '".$_POST[banner_name]."';"."\n";
$txt .= "$"."banner_detail = '".$_POST[banner_detail]."';"."\n";
$txt .= "$"."txt_alt = '".$_POST[txt_alt]."';"."\n";
$txt .= "    ?>";
$Current_Dir1 = HTTP_HOST."language/".$namefolder.".php"; //"../ewt/".$_SESSION["EWT_SUSER"]."/language/".$namefolder.".php";
	if (!$fp = fopen($Current_Dir1, 'w')) {
         //print "Cannot open file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot open file(<?php echo $Current_Dir1;?>)");
		</script>
		 <?php
         exit;
   		 }
		 if (!fwrite($fp, $txt)) {
        //print "Cannot write to file ($filename)";
		 ?>
		 <script language="JavaScript">
		 alert("Cannot write to file(<?php echo $Current_Dir1;?>)");
		</script>
		 <?php
        exit;
  	  }
		fclose($fp);
		echo "<script language=\"javascript\">";
		echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='main_banner.php?banner_gid=".$_POST[banner_gid]."';" ;
		echo "</script>";	
}

$db->db_close(); ?>
