<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("language/language.php");
include("lib/utilities_function.php");

$dl_id=$_REQUEST[dl_id];
$query =$db->query( "SELECT * FROM docload_list  INNER JOIN  docload_group ON  dl_dlgid=dlg_id WHERE dl_id = '$dl_id'  AND dl_open='Y' ");
$R=$db->db_fetch_array($query );
$countload=$R[dl_count];
$dl_gid=$R[dlg_id];
if($R[dl_id]==0){
  ?><script language="jscript">window.close();</script><?php exit;
}

if($_POST[Submit]!=''){
   $countload=$countload+1;
   $db->query( " UPDATE  docload_list  SET  dl_count = '$countload'  WHERE  dl_id = '$dl_id' ");
   //add stat
   if($_SERVER["REMOTE_ADDR"]){
						$IPn = $_SERVER["REMOTE_ADDR"];
					}else{
						$IPn = $_SERVER["REMOTE_HOST"];
					}
  $db->query("insert into docload_log (download_log_date,download_log_time,download_log_did,download_log_date_text,download_log_ip) 
  							values ('".date('Y-m-d')."','".date('H:i:s')."','".$dl_id."','".date('Y-m-d H:i:s')."','".$IPn."')");
    $filepath="download_doc/dl_".$dl_gid."/$R[dl_name]";
    $filename=$R[dl_name];
	$linesz= filesize($filepath);
	header( 'Content-type: application/x-www-form-urlencoded' );
	header( 'Content-Length: ' . $linesz );
	header( 'Content-Disposition: filename="'.$filename.'"' );
	header( 'Content-Description: Download Data' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' ); 
	
	$fp = fopen ($filepath, 'rb');
	
	$ata = fread( $fp, $linesz);
	echo $ata;
	@fclose($fp);
    ?> <!--<script language="javascript">  location.href='download_dl.php?filepath=<?php //echo $filepath?>&filename=<?php // echo $filename?>'; </script>--><?php
    exit;
}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link id="stext" href="css/normal.css" rel="stylesheet" type="text/css">
<link  href="css/interface.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
<title>Download...</title></head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td width="100%"><br>        
      <br>
      <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th scope="col">
		   <table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#B07331" class="normal_font">
				 <tr bgcolor="#FFFFFF">
				  <td colspan="2" valign="TOP"><img src="mainpic/load.gif" height="40"  align="absmiddle"><font size="10"><strong>Download</strong></font>  </td>   
				</tr>
			</table>
		      <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B07331" class="normal_font">
			<tr bgcolor="#3399FF" class="head_font">
              <td width="19%" bgcolor="#FFDA45" background="mainpic/toolbars.gif">ชื่อไฟล์</td>
              <td width="81%" bgcolor="#FFDA45" background="mainpic/toolbars.gif"> <strong><?php echo nl2br($R[dl_name]); ?></strong> </td>
            </tr>  
			<tr bgcolor="#FFFFFF">
              <td>ขนาด</td>
              <td> <?php echo  number_format($R[dl_filesize]/1024,2); ?> KB. </td>
            </tr>
            <tr bgcolor="#F7F7F7">
              <td>จำนวนดาวน์โหลด</td>
              <td width="81%" valign="top"> <?php echo number_format($R[dl_count],0); ?> ครั้ง</td>
            </tr>
            <tr bgcolor="#F7F7F7">
              <td>รายละเอียด</td>
              <td width="81%" valign="top"> <?php echo nl2br($R[dl_detail]); ?> </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td>วันที่สร้าง</td>
              <td><?php echo date_display($R[dl_createdate],'YmdHis','DT3Th');?></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td>วันที่แก้ไขล่าสุด</td>
              <td><?php echo date_display($R[dl_update],'YmdHis','DT3Th');?></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td>ข้อกำหนด</td>
              <td> <?php if($R[dlg_private]=='Y'){ echo "สำหรับสมาชิกเท่านั้น กรุณาเข้าสู่ระบบก่อนโหลดเอกสาร"; }else{echo '-';} ?> </td>
            </tr>
          </table></th>
        </tr>
        <tr  id="tr_print">
          <td align="center"><br>
<form name="form1" method="post" action="download_detail.php">
            <input type="button" name="Submit2" value="ปิดหน้าต่าง"  onClick="window.close();"> 
			
            <input type="hidden" name="dl_id" value="<?php echo $dl_id?>"  >
			
			<?php  if($R[dlg_private]=='Y'  &&  $_SESSION["EWT_MID"] == "" ){ ?>
			   <input type="button" name="Submit" value="ล๊อกอิน"  onClick="location.href='ewt_login.php'" >
			<?php }else{ ?> 
			    <input type="submit" name="Submit" value="ดาวน์โหลด"  >
			<?php } ?>
			
          </form></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>
