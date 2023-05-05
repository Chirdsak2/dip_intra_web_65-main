<?php
session_start();

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

define('FPDF_FONTPATH','font/');
require('thaipdfclass_r2.php');
require('mc_table_r2.php');
$pdf=new PDF_MC_Table();
$pdf1=new ThaiPDF();
$pdf->Open();

$pdf->SetThaiFont();
$pdf->SetHeader('' ,0, 'C', 1);
// สั่งแสดงผล +130

function DiffToText_new($diff){
	global $strDif;
	if ($diff>=86400){
				$x = floor($diff / 86400);
				$strDif.= " $x วัน";
				$diff = $diff - ($x * 86400);
				return DiffToText_new($diff);
	}elseif ($diff>=3600){
				$x = floor($diff / 3600);
				$strDif.= " $x ชั่วโมง";
				$diff = $diff - ($x * 3600);
				return DiffToText_new($diff);
	}elseif ($diff>=60){
				$x = floor($diff / 60);
				$strDif.= " $x นาที ";
				$diff = $diff - ($x * 60);
				return DiffToText_new($diff);
	}else if ($diff){
			if($diff > 0){
				$strDif.= " $diff วินาที ";
			}
	}
	return $strDif;
}

if($start_date == "" AND $end_date == ""){
	$con = "";
	$date_name = "";
}elseif($start_date != "" AND $end_date == ""){
	$st = explode("/",$start_date);
	$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	$date_name = "วันที่ ".$start_date;
}elseif($start_date == "" AND $end_date != ""){
	$st = explode("/",$end_date);
	$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	$date_name = "วันที่ ".$end_date;
}else{
	$st = explode("/",$start_date);
	$en = explode("/",$end_date);
	$con = " AND (t_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
	$date_name = "วันที่ ".$start_date."  ถึง วันที่ ".$start_date;
}
$pdf->str_date=$date_name;



$sql = mysql_query("select * from  w_question where 1=1  ".$con." order by t_date DESC,t_time DESC ");

$pdf->report_wb_header();
$i=1;
if($db->db_num_rows($sql)>0){
			while($R=$db->db_fetch_array($sql)){

					$date = explode("-",$R[t_date]);
					$time = explode(":",$R[t_time]);
					$d2 = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
					$d_df = mktime(0, 0, 0, date(m), date(d), date(Y));
					
					if($R[user_id] != '0'){
								$db->query("USE ".$EWT_DB_USER);
								$sql_img = "select * from gen_user,emp_type where gen_user.emp_type_id = emp_type.emp_type_id and gen_user_id = '".$R[user_id]."'";
								$query = $db->query($sql_img);
								$rec_img = $db->db_fetch_array($query);
								$db->query("USE ".$EWT_DB_NAME);
									$name_a = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
									$mail = $rec_img[email_person];
									$emp_type  = $rec_img[emp_type_name];
									$user_id = $rec_img[emp_id];
					}else{
									$name_a = $R[q_name]; 
									$mail = $R[q_email];
									$emp_type  = 'ประชาชน';
									$user_id = $R[t_id];
					}
					
					$sql_an = "select * from w_answer where t_id = '".$R[t_id]."' order by a_id ASC";
					$query_an = $db->query($sql_an);
					$rec = $db->db_fetch_array($query_an);
					$date_an = explode("-",$rec[a_date]);
					$time_an = explode(":",$rec[a_time]);

					if($db->db_num_rows($query_an)>0){
						$d1 = mktime($time_an[0], $time_an[1], $time_an[2], $date_an[1], $date_an[2], $date_an[0]);
						$color = "#FFFFFF";
						$remark="";
					}else{
						$d1 = 0;
						if(($d_df-$d2 ) >86400){
							$color = "#FF0000";
							$remark="รอคำตอบ";
						}else if(($d_df-$d2 ) < 86400){
							$color = "#66FF66";
							$remark="มาใหม่";
						}
					}
					$diff = $d1-$d2;

			   $pdf->SetXY(20,$pdf->GetY());
			   $pdf->Row(array($i,$R[t_name],$name_a,$mail,$R[t_date],$R[t_time],$rec[a_date],$rec[a_time],DiffToText_new($diff),$emp_type,$remark));
			   $strDif="";
			   $i++;
			}
}else{
				$pdf->SetXY(20,$pdf->GetY());
				$pdf->SetFont('CordiaNew','B',14);
				$pdf->Cell(261,10,"No Date",'LRB','','C');
}
$pdf->Output();

?>
