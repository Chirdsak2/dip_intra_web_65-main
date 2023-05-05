<?php
if($_GET["FlagE"] == "excel"){
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition:  filename=form_excel.xls");
header( 'Content-Description: Download Data' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );



}
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
function DiffToText_new($diff)
            {
          /*  if (floor($diff/31536000))
                        {
                        $x = floor($diff / 31536000);
                        echo " $x ปี ";
                        $diff = $diff - ($x * 31536000);
                        return DiffToText_new($diff);
                        }
            elseif (floor($diff/2678400))
                        {
                        $x = floor($diff / 2678400);
                        echo " $x เดือน ";
                        $diff = $diff - ($x * 2678400);
                        return DiffToText_new($diff);
                        }
            else*/if (floor($diff/86400))
                        {
                        $x = floor($diff / 86400);
						if($x  > 0){
                        echo " $x วัน";
                        $diff = $diff - ($x * 86400);
                        return DiffToText_new($diff);
						}
                        }
            elseif (floor($diff/3600))
                        {
                        $x = floor($diff / 3600);
                        echo " $x ชั่วโมง";
                        $diff = $diff - ($x * 3600);
                        return DiffToText_new($diff);
                        }

            elseif (floor($diff/60))
                        {
                        $x = floor($diff / 60);
                        echo " $x นาที ";
                        $diff = $diff - ($x * 60);
                        return DiffToText_new($diff);
                        }
            else if ($diff)
                        echo " $diff วินาที ";
            }
if(empty($start_date) && $Flag ==''){
$start_date = date("d/m/").(date("Y")+543);
}
if(empty($end_date) && $Flag ==''){
$end_date = date("d/m/").(date("Y")+543);
}
?>
<html>
<head>
<title>Stat</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<?php
$sql = mysql_query("select* from  w_question where 1=1  ".$con." ");
$sql_ct = mysql_query("select * from  w_question where 1=1  ".$con." LIMIT 0,1");
$A = mysql_fetch_row($sql_ct);

?>
<table width="100%" border="1" cellpadding="2" cellspacing="1" bgcolor="#000000" >
      <tr bgcolor="#FFFFFF">
        <td colspan="2" >รายการ</td>
        <td width="13%" align="center" >จำนวนผู้อ่าน</td>
      </tr>
	  <?php 
	  $query = $db->query("select * from w_cate where c_use = 'Y'");
	  while($rec = $db->db_fetch_array($query)){
	  ?>
     <tr bgcolor="#FFFFFF">
        <td colspan="4" ><img src="../images/arrow_r.gif" width="7" height="7"><?php echo $rec[c_name]; ?></td>
  </tr>
	  <?php 
	  $sql_q = mysql_query("select* from  w_question where 1=1 and c_id = '".$rec[c_id]."'  ");
	  $num_q = $db->db_num_rows($sql_q);
	  while($rec_q = $db->db_fetch_array($sql_q)){
	  ?>
     <tr bgcolor="#FFFFFF">
        <td width="2%" >&nbsp;</td>
        <td width="72%" >-<?php echo $rec_q[t_name];?></td>
        <td align="center" ><?php echo $rec_q[t_count]; ?></td>
      </tr>
	  <?php 
	  	}
		if($num_q == 0){
		?>
		<tr bgcolor="#FFFFFF">
        <td >&nbsp;</td>
        <td colspan="3" ><span class="style1">---ไม่พบหัวข้อกระทู้----</span></td>
      </tr>
		<?php
		}
	  } ?>
</table>

</body>
</html>
<?php
$db->db_close(); ?>
