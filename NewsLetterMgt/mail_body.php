<?php
include("authority.php");
?>
<?php 

$Sel = "select * from n_history order by h_id desc";
//$r = $db->query($sel);
/***************** Start Seperate Page ****************/
 //    If $offset is set below zero (invalid) or empty, set to zero 
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 40;
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = mysql_query($Sel);
$nof = mysql_num_fields($ExecSel); 
$totalrows = mysql_num_rows($ExecSel);
	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $Sel." LIMIT $offset, $limit ";
$ExecShow = mysql_query($Show);
?>
<html>
<head>
<title>Newsletter Group Modify Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0">
<br>
<?php
if($hid){
			$Sel = "select * from n_history where h_id='$hid' ";
			$ExecSel = mysql_query($Sel);
			$R = mysql_fetch_array($ExecSel );
			?>
			<table width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#B2B4BF" bgcolor="#ECEBF0" >
				<tr> <td width="10%" bgcolor="#B2B4BF"><b>Subject</b></td><td><?php echo $R['h_subject'];?></td></tr>
				<tr> <td width="10%" bgcolor="#B2B4BF"><b>Date</b></td><td><?php echo $R['h_date'];?></td></tr>
				<tr> <td width="10%" bgcolor="#B2B4BF"><b>Time</b></td><td><?php echo $R['h_time'];?></td></tr>
				<tr> <td bgcolor="#B2B4BF"><b>Sender</b></td><td><?php echo $R['h_from_n'];?> &lt;<?php echo $R['h_from_e'];?>&gt;</td></tr>
				<tr> <td bgcolor="#B2B4BF"><b>Body</b></td><td><?php echo $R['h_body'];?></td></tr>
			</table>
<?php } ?>


<?php
if($nid){
			$Sel = "select * from n_send where h_id='$nid' order by s_id ";
			$ExecSel = mysql_query($Sel);
			
			?>
			<table width="95%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#B2B4BF" bgcolor="ECEBF0" >
				<tr bgcolor="#B2B4BF"> 
					<td width="20%"><b>วันที่</b></td>
					<td width="20%"><b>เวลา</b></td>
					<td width="60%"><b>E - Mail</b></td>
				</tr>
				<?php while($R = mysql_fetch_array($ExecSel)){?>
				<tr> 
						<td><?php echo $R['s_date'];?></td>
						<td><?php echo $R['s_time'];?></td>
						<td><?php echo $R['s_email'];?></td>
				</tr>
				<?php } ?>
			</table>
<?php } ?>

</body>
</html>
