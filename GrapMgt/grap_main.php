<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";


?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="frm1" action="main_stat_index.php" method="post">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/banner_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">ข้อมูลกราฟ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("สร้างกราฟ");?>&module=banner&url=<?php echo urlencode("main_group_banner.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="graph_add.php" target="_self"><img src="../theme/main_theme/g_add.gif"  width="16" height="16"  align="absmiddle" border="0"> 
      สร้างกราฟ</a>
      <hr>
    </td>
  </tr>
</table>

<table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
  <tr> 
	<td  valign="top" align="center"> 
	<!--
				<table width="60%" border="0" cellspacing="1" cellpadding="3">
					<tr height="40">
					  <td >
					  <input type="submit" name="Submit" value="ค้นหา"></td>
					</tr>
				  </table>
	-->
				<table width="60%" cellpadding="5"  cellspacing="1" bgcolor="#B74900" class="ewttableuse" >
				<tr class="ewttablehead" >
				  <td width="4%" ></td>  
				  <td width="10%" align="center">วันที่</td>
				  <td width="10%" align="center">จำนวนคนไทย</td>
				  <td width="10%" align="center">จำนวนคนต่างชาติ</td>
				  <td width="10%" align="center">ภาพรวม</td>
				  </tr>
					<?php 
						$num = $db->db_num_rows($Execsql);
						if($num> 0){
								while($rs = $db->db_fetch_array($Execsql)){
									$sum = $rs[p_nthai]+$rs[p_nother];
								?>
								<tr bgcolor="#FFFFFF" align="center">
									<td><img src="../theme/main_theme/g_edit.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altedit;?>" style="cursor:hand" onClick="location.href='stat_add.php?flag=edit&p_id=<?php echo $rs[p_id]?>';">&nbsp;<img src="../theme/main_theme/g_garbage.png" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altdel;?>" style="cursor:hand" onClick="if(confirm('ยืนยันการลบสถิติ'))location.href = 'stat_process.php?flag=del&p_id=<?php echo $rs[p_id]?>'; "></td>
									<td><?php echo convert_datedb($rs[p_date]);?></td>
									<td><?php echo  number_format($rs[p_nthai]);?></td>
									<td><?php echo  number_format($rs[p_nother]);?></td>
									<td><?php echo  number_format($sum);?></td>
								</tr>
								<?php  }
						} ?>
						<?php if($rows > 0){ ?>
                    <tr bgcolor="#FFFFFF"> 
                      <td height="25" colspan="15" valign="top"><?php echo $text_general_page;?> :
                        
                      </td>
                    </tr>
                    <?php }else{?>
					<tr bgcolor="#FFFFFF"> 
                      <td height="30" colspan="15"  align="center"><font color="#FF0000"><?php echo $text_general_notfound;?></font></td>
                    </tr>
			<?php }?>
				   </table>
   </td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>
