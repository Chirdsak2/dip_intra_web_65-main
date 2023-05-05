<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);

define('FPDF_FONTPATH','font/');
require('thaipdfclass_r1.php');
require('mc_table_r1.php');
$pdf=new PDF_MC_Table();
$pdf1=new ThaiPDF();
$pdf->Open();

$pdf->SetThaiFont();

$pdf->SetHeader('' ,0, 'C', 1);

// สั่งแสดงผล +130
$sql = $db->query("SELECT title.title_thai,gen_user.name_thai,gen_user.surname_thai,gen_user.gen_user,gen_user.gen_pass,org_name.name_org,org_name.parent_org_id FROM gen_user INNER JOIN title ON title.title_id = gen_user.title_thai INNER JOIN org_name ON org_name.org_id = gen_user.org_id WHERE gen_user.gen_user != '' ORDER BY org_name.parent_org_id ASC ");
$i=0;
while($R = mysql_fetch_row($sql)){
	if($i%2 == 0){
	$pdf->AddPage();
	$plus = 0;
	}else{
	$plus = 130;
	}

$pdf->SetFont('CordiaNew','B',16);
$pdf->SetXY((20+$plus),10);
$pdf->Cell('','',('ข้อมูลเข้าใช้งานระบบบริการข้อมูลอิเล็กทรอนิกส์'));
$pdf->SetXY((20+$plus),18);
$pdf->Cell('','',('กรมทรัพยากรธรณี'));
$pdf->SetFont('CordiaNew','',16);
$pdf->SetXY((20+$plus),34);
$pdf->Cell('','',('ชื่อ-นามสกุล   '.$R[0].' '.$R[1].' '.$R[2]));
$pdf->SetXY((20+$plus),42);
if(strlen($R[6]) != 9){
	$plen = substr($R[6], 0, 9);
		$sql_org = $db->query("SELECT name_org FROM org_name WHERE parent_org_id = '$plen' ");
		if($db->db_num_rows($sql_org) == 0){
			$pdf->Cell('','',('หน่วยงาน       '.$R[5]));
		}else{
			$Or = $db->db_fetch_row($sql_org);
			$pdf->Cell('','',('หน่วยงาน       '.$Or[0]));
			$pdf->SetXY((20+$plus),50);
			$pdf->Cell('','',('                      '.$R[5]));
		}
}else{
$pdf->Cell('','',('หน่วยงาน       '.$R[5]));
}
			$pdf->SetFont('CordiaNew','',14);
			$pdf->SetXY((10+$plus),62);
			$pdf->Cell('','',(''));
			$pdf->SetFont('CordiaNew','',16);
$pdf->SetXY((10+$plus),70);
$pdf->SetWidths(array(92));
$pdf->Row(array("\nศูนย์สารสนเทศทรัพยากรธรณี มีความยินดีขอมอบรหัส สำหรับใช้บริการระบบบริการข้อมูลอิเล็กทรอนิกส์ ทั้งในส่วนทางอินเตอร์เน็ตและอินทราเน็ต :-\n"));
$pdf->SetXY((20+$plus),120);
$pdf->SetFont('CordiaNew','',18);
$pdf->Cell('','',('ชื่อผู้ใช้งาน :  '.$R[3]));
$pdf->SetXY((20+$plus),130);
$pdf->Cell('','',('รหัสผ่าน    :  '.$R[4]));
$pdf->SetXY((20+$plus),140);
$pdf->Cell('','',('URL          :  http://www.dmr.go.th'));
$pdf->SetXY((10+$plus),160);
$pdf->SetWidths(array(92));
$pdf->SetFont('CordiaNew','',16);
$pdf->Row(array("\nข้อควรระวัง\nชื่อผู้ใช้งานและรหัสผ่านต้องเก็บไว้เป็นความลับเฉพาะตัว แม้แต่เจ้าหน้าที่ผู้อื่นก็ไม่มีสิทธิ์รับรู้จากท่าน เมื่อจำรหัสได้แล้วโปรดทำลายเอกสารนี้ด้วย\nหากมีข้อขัดข้องโปรดติดต่อ ศูนย์สารสนเทศทรัพยากรธรณี\nโทร 02 6219698     fax 02 6219699      ในเวลาราชการ\n"));
$i++;
}
$pdf->Output();

?>
