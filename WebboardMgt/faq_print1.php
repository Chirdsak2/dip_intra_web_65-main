<?php
session_start();

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

define('FPDF_FONTPATH','font/');
require('thaipdfclass_r2.php');
require('mc_table_r1.php');
$pdf=new PDF_MC_Table();
$pdf1=new ThaiPDF();
$pdf->Open();

$pdf->SetThaiFont();
$pdf->SetHeader('' ,0, 'C', 1);
// สั่งแสดงผล +130
$sql_group = $db->query("select * from f_subcat where f_sub_id ='".$_GET[fid]."'");
$RG = $db->db_fetch_array($sql_group);
$group = $RG[f_subcate];
	$start_date = $_REQUEST["start_date"];
	$end_date = $_REQUEST["end_date"];
	if($start_date == "" AND $end_date == ""){
	$con = "";
	$date_name = "";
	}elseif($start_date != "" AND $end_date == ""){
	$st = explode("/",$start_date);
	$con = " AND (faq_stat_dateate = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	$date_name = "วันที่".$start_date;
	}elseif($start_date == "" AND $end_date != ""){
	$st = explode("/",$end_date);
	$con = " AND (faq_stat_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	$date_name = "วันที่".$end_date;
	}else{
	$st = explode("/",$start_date);
	$en = explode("/",$end_date);
	$con = " AND (faq_stat_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
	$date_name = "วันที่".$start_date."ถึง วันที่".$end_date;
	}
			if($_GET["orderby"]!=''){
				 $orderby=$_GET["orderby"];
				  if($_GET["adesc"]=='DESC'){  $adesc='ASC';  }else{  $adesc='DESC';  }
				   $orderby_now = 'ORDER BY  '.$orderby.'  '.$adesc;
			}else{
				$orderby_now = "ORDER BY sum_fa_id DESC ";
			}
$pdf->str_date=$date_name;

  $sql=$db->query("SELECT faq.fa_id, faq.fa_name,COUNT(faq_stat.faq_stat_id) AS countstat FROM faq LEFT JOIN faq_stat ON faq.fa_id = faq_stat.fa_id   $con WHERE f_sub_id = '".$_REQUEST[fid]."'  GROUP BY faq.fa_id, faq.fa_name ORDER BY countstat DESC");

$pdf->report_wb_header();
$i=1;
if($db->db_num_rows($sql)>0){
			while($R=$db->db_fetch_array($sql)){
			   $pdf->SetXY(20,$pdf->GetY());
			   $pdf->Row(array($i,$R[fa_name],$R[countstat]));
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
