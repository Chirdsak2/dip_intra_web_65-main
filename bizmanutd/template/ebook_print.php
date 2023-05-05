<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//===========================================================================
	if($ebook_id){ $ebook_id = checkNumeric($ebook_id); }
	if($_GET["ebook_id"]){ $_GET["ebook_id"] = checkNumeric($_GET["ebook_id"]); }
	if($_POST["ebook_id"]){ $_POST["ebook_id"] = checkNumeric($_POST["ebook_id"]); }
	//===========================================================================
	
define('FPDF_FONTPATH','font/');
$sql_info = $db->query("select * from ebook_info where ebook_code = '".$ebook_id."'");
$RG=$db->db_fetch_array($sql_info);
$wi = $RG[ebook_w];
$hi = $RG[ebook_h];
require('thaipdfclass_ebook.php');
require('mc_table_ebook.php');

$pdf=new ThaiPDF();

$sql = $db->query("select ebook_code,ebook_page_file from ebook_page where ebook_code  like '$ebook_id' ORDER BY ebook_page");


$i=1;
if($db->db_num_rows($sql)>0){
			while($R=$db->db_fetch_array($sql)){
			$pdf->AddPage(); 
			   $pdf->Image('ebook/'.$R[ebook_code].'/pages/'.$R[ebook_page_file],  0,  0); 

			   $i++;
			}
}
$pdf->Output();
?>