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
    <td><img src="mainpic/mail2.gif" width="24" height="24" align="absmiddle"><span class="myhead_02">ส่ง E-card</span></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr /></td>
  </tr>
</table>

<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">ส่ง</td>
      <td width="20%" >รายการ</td>
      <td width="70%">รายละเอียด</td>
  </tr>
  <?php 

//$dir = @opendir("../ewt/".$_SESSION["EWT_SUSER"]."/ecard/");
$sql="SELECT * FROM ecard_list";
$query=$db->query($sql);
  		 while($R = $db->db_fetch_array($query)){
		 $file=$R[ec_filename];
		 $fileID=$R[ec_id];
  		 //while (($file = readdir($dir)) !== false) { 
		 //if($file != "." AND $file != ".."){
		 	//$exp = explode(".",$file);
			//$exp[1] = strtolower($exp[1]);
		 ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center"><nobr><a href="ecard_send.php?fid=<?php echo $fileID; ?>" ><img src="mainpic/b_dp.jpg" alt="ส่ง E-Card" border="0"></a> </nobr></td>
				<td><?php
				if($R[ec_fileext] != "swf"){ ?>
				     <img src="phpThumb.php?src=ecard/<?php echo $file; ?>&h=150&w=150" >
				<?php }else{ ?>
				  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="150" height="150">
                    <param name="movie" value="ecard/<?php echo $file; ?>">
                    <param name="quality" value="high">
                    <embed src="ecard/<?php echo $file; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="150" height="150"></embed>
		        </object><?php } ?></td>
				<td align="left" valign="top">
				ชื่อไฟล์ : <?php echo $R[ec_name];?><br>
                 ไฟล์ระบบ : <?php echo $R[ec_filename];?><br>
                 ชนิดไฟล์ : <?php echo $R[ec_filetype];?><br>
                  ขนาดไฟล์ : <?php echo number_format($R[ec_filesize]/1024,2);?> KB.
				</td>
			
			  </tr>
  <?php
         $i++;
		 //}
		 }
		 	if($db->db_num_rows($query) == 0){  ?>
			  <tr bgcolor="#FFFFFF"><td colspan="3" align="center"> <strong>ไม่พบข้อมูล</strong> </td></tr>
			<?php }
		  //closedir($dir);
		  ?>
</table>
</body>
</html>
<?php  $db->db_close(); ?>