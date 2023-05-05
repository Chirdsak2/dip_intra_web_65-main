<?php
$file_type = "vnd.ms-excel";
$file_ending = "xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition:  filename=export_excel.xls");
header( 'Content-Description: Download Data' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );
include("authority01.php");
?><?php 


if($do != ""){
$Sel= "select * from n_member,n_group_member where n_member.m_id = n_group_member.m_id and n_group_member.g_id = '$do' order by n_member.m_id desc";

$SQL = $db->query("SELECT * FROM n_group WHERE g_id = '$do'");
$RR = mysql_fetch_array($SQL);
$title = "ข้อมูลสมาชิกของกลุ่ม ".$RR[g_name];
}else{
$Sel= "select * from n_member order by m_id desc";
$title = "ข้อมูลสมาชิกทั้งหมด";
}

$ExecSel = $db->query($Sel);
$rows = mysql_num_rows($ExecSel);
$title .= " จำนวนทั้งหมด ".$rows." ข้อมูล";


//header info for browser: determines file type ('.doc' or '.xls')



echo("$title\n");


$sep = "\t"; 


echo "E-mail";
echo "\t";
echo "Date / Time";
echo "\t";
echo "Activate";
echo "\t";
echo "Group\t";
print("\n");

    while($R = mysql_fetch_array($ExecSel))
    {
		$qG = $db->query("SELECT c_name FROM n_group,article_group WHERE c_id = g_name AND n_group.g_name !=  '' AND g_id IN (SELECT g_id FROM n_group_member WHERE m_id='$R[m_id]')");
		$arrG=array();
		while($rG=$db->db_fetch_array($qG)) {
			array_push($arrG,$rG['c_name']);
		}
		$strG=implode(",",$arrG);
echo $R[m_email];
echo "\t";
echo $R[m_date];
echo "\t";
if($R[m_active]=="Y"){
echo "Yes";
}else{
echo "No";
}
echo "\t";
echo $strG."\t";
print("\n");
    }

?>
