<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);

define('FPDF_FONTPATH','font/');
require('thaipdfclass_r2.php');
require('mc_table_r2.php');
$pdf=new PDF_MC_Table();
$pdf1=new ThaiPDF();
$pdf->Open();
$division_name = "";
$pdf->SetThaiFont();
$pdf->SetHeader('' ,0, 'C', 1);
// สั่งแสดงผล +130
$sql = $db->query("SELECT title.title_thai,gen_user.name_thai,gen_user.surname_thai,gen_user.gen_user,gen_user.gen_pass,org_name.name_org,org_name.parent_org_id,gen_user.name_eng ,gen_user.surname_eng  FROM gen_user INNER JOIN title ON title.title_id = gen_user.title_thai INNER JOIN org_name ON org_name.org_id = gen_user.org_id ORDER BY org_name.parent_org_id ASC ");//WHERE gen_user.gen_by = 'xxx' 
$headdiv = "";
$pg = "1";

while($R = mysql_fetch_row($sql)){
if(strlen($R[6]) != 9){
	$pg = "1";
	$plen = substr($R[6], 0, 9);
		$sql_org = $db->query("SELECT name_org FROM org_name WHERE parent_org_id = '$plen' ");
		if($db->db_num_rows($sql_org) == 0){
			$division_name = "หน่วยงาน ".$R[5];
		}else{
			$Or = $db->db_fetch_row($sql_org);
			$division_name = "หน่วยงาน ".$Or[0].' '.$R[5];
		}
}else{
$division_name = "หน่วยงาน ".$R[5];
}
if($R[5] != $headdiv ){
$pg = "1";
$pdf->AddPage();
$headdiv = $R[5];
}


//$pdf->Header($division_name);

$pdf->Row(array($R[0]." ".$R[1]." ".$R[2],""));
$i++;
}
$pdf->Output();

?>
