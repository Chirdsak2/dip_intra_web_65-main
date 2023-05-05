<?php
session_start();

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

define('FPDF_FONTPATH','font/');
require('thaipdfclass_r2.php');
require('mc_table_r3.php');
$pdf=new PDF_MC_Table();
$pdf1=new ThaiPDF();
$pdf->Open();

$pdf->SetThaiFont();
$pdf->SetHeader('' ,0, 'C', 1);
// สั่งแสดงผล +130

	$start_date = $_REQUEST["start_date"];
	$end_date = $_REQUEST["end_date"];
	if($start_date == "" AND $end_date == ""){
	$con = "";
	}elseif($start_date != "" AND $end_date == ""){
	$st = explode("/",$start_date);
	$con = " WHERE (faq_stat_dateate = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	}elseif($start_date == "" AND $end_date != ""){
	$st = explode("/",$end_date);
	$con = " WHERE (faq_stat_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	}else{
	$st = explode("/",$start_date);
	$en = explode("/",$end_date);
	$con = " WHERE (faq_stat_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
	}
			if($_GET["orderby"]!=''){
				 $orderby=$_GET["orderby"];
				  if($_GET["adesc"]=='DESC'){  $adesc='ASC';  }else{  $adesc='DESC';  }
				   $orderby_now = 'ORDER BY  '.$orderby.'  '.$adesc;
			}else{
				$orderby_now = "ORDER BY sum_fa_id DESC ";
			}
$pdf->str_date=$date_name;

$sql = mysql_query("SELECT  faq.fa_id,  count(faq_stat.fa_id) AS sum_fa_id,  faq.fa_name FROM  faq  LEFT JOIN faq_stat ON (faq.fa_id = faq_stat.fa_id) $con
GROUP BY  faq.fa_id,  faq.fa_name $orderby_now");

$pdf->report_wb_header();
$i=1;
if($db->db_num_rows($sql)>0){
			while($R=$db->db_fetch_array($sql)){
			   $pdf->SetXY(20,$pdf->GetY());
			   $pdf->Row(array($i,$R[fa_name],$R[sum_fa_id]));
			   $strDif="";
			   $i++;
			}
}else{
				$pdf->SetXY(20,$pdf->GetY());
				$pdf->SetFont('CordiaNew','B',14);
				$pdf->Cell(245,10,"No Date",'LRB','','C');
}
$pdf->Output();

?>
