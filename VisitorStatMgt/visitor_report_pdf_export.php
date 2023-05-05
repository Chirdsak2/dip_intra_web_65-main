<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../assets/configs/function.inc.php");
global $db;

$date = new DateTime();
$clone = clone $date;
$clone2 = clone $date;
if (!empty($_GET['proc'])) {
    if ($_GET['proc'] == 'TO') {
        $con = " AND (sv_date = '" . $date->format('Y-m-d') . "') ";
    } else if ($_GET['proc'] == 'YE') {
        $clone->modify('-1 day');
        $con = " AND (sv_date = '" . $clone->format('Y-m-d') . "') ";
    } else if ($_GET['proc'] == 'L7') {
        $clone->modify('-7 day');
        $con = " AND (sv_date BETWEEN '" . $clone->format('Y-m-d') . "' AND '" . $date->format('Y-m-d') . "')";
    } else if ($_GET['proc'] == 'L3') {
        $clone->modify('-30 day');
        $con = " AND (sv_date BETWEEN '" . $clone->format('Y-m-d') . "' AND '" . $date->format('Y-m-d') . "')";
    } else if ($_GET['proc'] == 'TM') {
        $clone->modify('-30 day');
        $con = " AND (sv_date BETWEEN '" . $clone->format('Y-m-d') . "' AND '" . $date->format('Y-m-d') . "')";
    } else if ($_GET['proc'] == 'LM') {
        $clone->modify('-1 month');
        $clone2->modify('-2 month');
        $con = " AND (sv_date BETWEEN '" . $clone2->format('Y-m-d') . "' AND '" . $clone->format('Y-m-d') . "')";
    } else if ($_GET['proc'] == 'CU') {
        $s = explode("/", $_GET['startdate']);
        $n = explode("/", $_GET['enddate']);
        $con = " AND (sv_date BETWEEN '" . $s[2] . "-" . $s[1] . "-" . $s[0] . "' AND '" . $n[2] . "-" . $n[1] . "-" . $n[0] . "')";
    }
} else {
    $con = " AND (sv_date = '" . $date->format('Y-m-d') . "') ";
}

$intRejectTime = 10; // Minute
$s_delonline = "DELETE FROM stat_online WHERE DATE_ADD(so_onlinelasttime, INTERVAL {$intRejectTime} MINUTE) <= NOW() ";
$_q_delonline = $db->query($s_delonline);

//ผู้เข้าชมเว็บไซต์ที่ใช้งานอยู่
$s_count_rt = "SELECT so_session_id FROM stat_online GROUP BY so_session_id ";
$_q_count_rt = $db->query($s_count_rt);
$_rec_rt = $db->db_fetch_row($_q_count_rt);
$_row_rt = $db->db_num_rows($_q_count_rt);

//ผู้เข้าชมเว็บไซต์ในหน้าใด
$s_url = $db->query("SELECT sv_menu,sv_fullurl,count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' 
AND (sv_menu != '' ) {$con} GROUP BY sv_menu ORDER BY ct DESC LIMIT 0,5");

//IP (Internet Protocal Address)
$s_isp = $db->query("SELECT sv_ip,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_ip != '' {$con} 
GROUP BY sv_ip 
ORDER BY ct DESC LIMIT 0,5");

//ระบบปฏิบัติการ (Operating System)
$s_os = $db->query("SELECT sv_os,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_os != '' {$con} 
GROUP BY sv_os 
ORDER BY ct DESC LIMIT 0,5");

//เว็บบราวเซอร์ (Web Browser)
$s_wb = $db->query("SELECT sv_browser,count(sv_id) AS browser 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_browser != '' {$con} 
GROUP BY sv_browser 
ORDER BY browser DESC LIMIT 0,5");

//ความละเอียดหน้าจอ (Resolution)
$s_res = $db->query("SELECT sv_resolution,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_resolution != ''{$con} 
GROUP BY sv_resolution 
ORDER BY ct DESC LIMIT 0,5");

//ภาษาที่ใช้ (Accept Language)
$s_lan = $db->query("SELECT sv_language,count(sv_id) AS ct 
FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_language != '' {$con} 
GROUP BY sv_language 
ORDER BY ct DESC LIMIT 0,5");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Visitor PDF</title>
</head>

<body onLoad='javascript:window.print();'>
    <?php
    //require_once '/vendor/autoload.php';

    // $mpdf = new \Mpdf\Mpdf([
	// 	'default_font_size' => 16,
	// 	'default_font' => 'sarabun'
	// ]);

    $txt = '';
    $txt .= '<table style="width: 100%;" border="1">';

    $txt .= '<tr>';
    $txt .= '<th colspan="2" style="background-color:#39c3da; color:#fff">';
    $txt .= 'รายงานการเข้าชมเว็บไซต์';
    $txt .= '</th>';

    $txt .= '<tr>';
    $txt .= '<th align="left">';
    $txt .= 'ผู้เข้าชมเว็บไซต์อย่างน้อย 1 เซซชันในช่วงวันที่ที่กำหนด';
    $txt .= '</th>';

    $txt .= '<td>';
    $txt .= count_users($con) . ' Users';
    $txt .= '</td>';
    $txt .= '</tr>';

    $txt .= '<tr>';
    $txt .= '<th align="left">';
    $txt .= 'จำนวนผู้เข้าชมเว็บไซต์ครั้งแรกระหว่างช่วงวันที่ที่เลือก';
    $txt .= '</th>';

    $txt .= '<td>';
    $txt .= count_new_users($con) . ' New Users';
    $txt .= '</td>';
    $txt .= '</tr>';

    $txt .= '<tr>';
    $txt .= '<th align="left">';
    $txt .= 'จำนวนรวมของเซสชันภายในช่วงวันที่';
    $txt .= '</th>';

    $txt .= '<td>';
    $txt .= count_session($con) . ' Sessions';
    $txt .= '</td>';
    $txt .= '</tr>';

    $txt .= '</table>';

    $txt .= '<hr>';

    //------------------------------------------------------------------------------------//

    $txt .= '<table style="width: 100%;" border="1">';

    $txt .= '<tr>';
    $txt .= '<th colspan="2" style="background-color:#39c3da; color:#fff">';
    $txt .= 'ผู้เข้าชมเว็บไซต์ที่ใช้งานอยู่';
    $txt .= '</th>';
    $txt .= '</tr>';

    $txt .= '<tr>';
    $txt .= '<th align="left">';
    $txt .= 'จำนวน';
    $txt .= '</th>';

    $txt .= '<td>';
    $txt .= number_format($_row_rt, 0) . ' Users';
    $txt .= '</td>';
    $txt .= '</tr>';

    $txt .= '</table>';

    $txt .= '<hr>';

    //------------------------------------------------------------------------------------//

    $txt .= '<table style="width: 100%;" border="1">';

    $txt .= '<tr>';
    $txt .= '<th colspan="2" style="background-color:#39c3da; color:#fff">';
    $txt .= 'การเข้าชมตามอุปกรณ์';
    $txt .= '</th>';
    $txt .= '</tr>';

    $txt .= '<tr>';
    $txt .= '<th align="left">';
    $txt .= 'Desktop';
    $txt .= '</th>';

    $txt .= '<td>';
    $txt .= count_device('1', $con) . ' เครื่อง';
    $txt .= '</td>';
    $txt .= '</tr>';

    $txt .= '<tr>';
    $txt .= '<th align="left">';
    $txt .= 'Tablet';
    $txt .= '</th>';

    $txt .= '<td>';
    $txt .= count_device('2', $con) . ' เครื่อง';
    $txt .= '</td>';
    $txt .= '</tr>';

    $txt .= '<tr>';
    $txt .= '<th align="left">';
    $txt .= 'Mobile';
    $txt .= '</th>';

    $txt .= '<td>';
    $txt .= count_device('3', $con) . ' เครื่อง';
    $txt .= '</td>';
    $txt .= '</tr>';

    $txt .= '</table>';

    $txt .= '<hr>';

    //------------------------------------------------------------------------------------//

    $txt .= '<table style="width: 100%;" border="1">';

    $txt .= '<tr>';
    $txt .= '<th colspan="2" style="background-color:#39c3da; color:#fff">';
    $txt .= 'ผู้เข้าชมเว็บไซต์หน้าใด #Top 5';
    $txt .= '</th>';
    $txt .= '</tr>';

    while ($a_url = $db->db_fetch_row($s_url)) {
        $txt .= '<tr>';
        $txt .= '<th align="left">';
        $txt .= $a_url[0];
        $txt .= '</th>';

        $txt .= '<td>';
        $txt .= $a_url[2];
        $txt .= '</td>';
        $txt .= '</tr>';
    }

    $txt .= '</table>';

    $txt .= '<hr>';

    //------------------------------------------------------------------------------------//

    $txt .= '<table style="width: 100%;" border="1">';

    $txt .= '<tr>';
    $txt .= '<th colspan="2" style="background-color:#39c3da; color:#fff">';
    $txt .= 'IP (Internet Protocal Address) #Top 5';
    $txt .= '</th>';
    $txt .= '</tr>';

    while ($a_isp = $db->db_fetch_row($s_isp)) {
        $txt .= '<tr>';
        $txt .= '<th align="left">';
        $txt .= $a_isp[0];
        $txt .= '</th>';

        $txt .= '<td>';
        $txt .= $a_isp[1];
        $txt .= '</td>';
        $txt .= '</tr>';
    }

    $txt .= '</table>';

    $txt .= '<br><br>';

    //------------------------------------------------------------------------------------//

    $txt .= '<table style="width: 100%;" border="1">';

    $txt .= '<tr>';
    $txt .= '<th colspan="2" style="background-color:#39c3da; color:#fff">';
    $txt .= 'ระบบปฏิบัติการ (Operating System) #Top 5';
    $txt .= '</th>';
    $txt .= '</tr>';

    while ($a_os = $db->db_fetch_row($s_os)) {
        $txt .= '<tr>';
        $txt .= '<th align="left">';
        $txt .= $a_os[0];
        $txt .= '</th>';

        $txt .= '<td>';
        $txt .= $a_os[1];
        $txt .= '</td>';
        $txt .= '</tr>';
    }

    $txt .= '</table>';

    $txt .= '<hr>';

    //------------------------------------------------------------------------------------//

    $txt .= '<table style="width: 100%;" border="1">';

    $txt .= '<tr>';
    $txt .= '<th colspan="2" style="background-color:#39c3da; color:#fff">';
    $txt .= 'เว็บบราวเซอร์ (Web Browser) #Top 5';
    $txt .= '</th>';
    $txt .= '</tr>';

    while ($a_wb = $db->db_fetch_row($s_wb)) {
        $txt .= '<tr>';
        $txt .= '<th align="left">';
        $txt .= $a_wb[0];
        $txt .= '</th>';

        $txt .= '<td>';
        $txt .= $a_wb[1];
        $txt .= '</td>';
        $txt .= '</tr>';
    }

    $txt .= '</table>';

    $txt .= '<hr>';

    //------------------------------------------------------------------------------------//

    $txt .= '<table style="width: 100%;" border="1">';

    $txt .= '<tr>';
    $txt .= '<th colspan="2" style="background-color:#39c3da; color:#fff">';
    $txt .= 'ความละเอียดหน้าจอ (Resolution) #Top 5';
    $txt .= '</th>';
    $txt .= '</tr>';

    while ($a_res = $db->db_fetch_row($s_res)) {
        $txt .= '<tr>';
        $txt .= '<th align="left">';
        $txt .= $a_res[0];
        $txt .= '</th>';

        $txt .= '<td>';
        $txt .= $a_res[1];
        $txt .= '</td>';
        $txt .= '</tr>';
    }

    $txt .= '</table>';

    $txt .= '<hr>';

    //------------------------------------------------------------------------------------//

    $txt .= '<table style="width: 100%;" border="1">';

    $txt .= '<tr>';
    $txt .= '<th colspan="2" style="background-color:#39c3da; color:#fff">';
    $txt .= 'ภาษาที่ใช้ (Accept Language) #Top 5';
    $txt .= '</th>';
    $txt .= '</tr>';

    while ($a_lan = $db->db_fetch_row($s_lan)) {
        $txt .= '<tr>';
        $txt .= '<th align="left">';
        $txt .= $a_lan[0];
        $txt .= '</th>';

        $txt .= '<td>';
        $txt .= $a_lan[1];
        $txt .= '</td>';
        $txt .= '</tr>';
    }

    $txt .= '</table>';

    //------------------------------------------------------------------------------------//

    // $mpdf->WriteHTML($txt);
    // $mpdf->Output();
    echo $txt;
    ?>
</body>

</html>