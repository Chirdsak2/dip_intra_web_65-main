<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
//$db->query("USE ".$EWT_DB_USER);
@include("language/language.php");
$text_genecard_textdetail="รายการส่ง";
$process=$HTTP_POST_VARS['process'];
$allrecord=$HTTP_POST_VARS['allrecord'];
$id=$HTTP_POST_VARS['id'];

?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">

</head>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="mainpic/mail2.gif" width="24" height="24" align="absmiddle"><span class="myhead_02">ประวัติการส่ง E-card</span></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr /></td>
  </tr>
</table>

<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="15%" height="30" align="center">วันที่</td>
      <td width="20%" >รายการ</td>
      <td width="50%"  align="center">ผู้รับ</td>
      <td width="10%"  align="center">สถานะผู้รับ</td>
  </tr>
  <?php 
//$dir = @opendir("../ewt/".$_SESSION["EWT_SUSER"]."/ecard/");
$sql="SELECT * FROM ecard_history  INNER JOIN ecard_list ON  ec_id=ech_ecardid  WHERE  ech_gen_userid  = '$_SESSION[EWT_MID]' ORDER BY ech_id DESC";
$query=$db->query($sql);
  		 while($R = $db->db_fetch_array($query)){
		 $file=$R[ec_filename];
		 $fileID=$R[ec_id];
		 
		 //$send_date=$R[ech_datetime];
		 $y=substr($R[ech_datetime],0,4);
		 $m=substr($R[ech_datetime],4,2);
		 $d=substr($R[ech_datetime],6,2);
		 $h=substr($R[ech_datetime],8,2);
		 $i=substr($R[ech_datetime],10,2);
		 $s=substr($R[ech_datetime],12,2);
		 $send_date=$d.'/'.$m.'/'.$y.' ('.$h.':'.$i.':'.$s.')';
		 $send_from=$R[ech_from];
		 $send_to=$R[ech_to];
		 if($R[ech_status]=='Y'){
		     $history_status="อ่านแล้ว";
		}else{
		     $history_status="ยังไม่ได้อ่าน";
		}
  		 //while (($file = readdir($dir)) !== false) { 
		 //if($file != "." AND $file != ".."){
		 	//$exp = explode(".",$file);
			//$exp[1] = strtolower($exp[1]);
		 ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center"><nobr><?php echo $send_date; ?></nobr></td>
				<td><?php
				//if($exp[1] != "swf"){
				if($R[ec_fileext] != "swf"){ ?>
				     <img src="phpThumb.php?src=ecard/<?php echo $file; ?>&h=50&w=50" >
				<?php }else{ ?>
				  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" height="50">
                    <param name="movie" value="ecard/<?php echo $file; ?>">
                    <param name="quality" value="high">
                    <embed src="ecard/<?php echo $file; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="50" height="50"></embed>
		        </object><?php } ?></td>
				<td align="left" valign="top"><?php echo $send_to; ?></td>
				<td align="center" valign="top"  ><?php echo $history_status; ?></td>
			  </tr>
  <?php
         $i++;
		 //}
		 }
		 	if($db->db_num_rows($query) == 0){  ?>
			  <tr bgcolor="#FFFFFF"><td colspan="6" align="center"> <strong>ไม่พบข้อมูล</strong> </td></tr>
			<?php }
		  //closedir($dir);
		  ?>
</table>
</body>
</html>
<?php  $db->db_close(); ?>