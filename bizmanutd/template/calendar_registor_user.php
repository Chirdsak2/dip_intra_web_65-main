<?php header ("Content-Type:text/plain;charset=UTF-8"); ?>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>

 <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td width="5%" align="center" bgcolor="#999999"><strong>No.</strong></td>
    <td width="20%" align="center" bgcolor="#999999"><strong>ชื่อ</strong></td>
    <td width="25%" align="center" bgcolor="#999999"><strong>นามสกุล</strong></td>
    <td width="25%" align="center" bgcolor="#999999"><strong>ตำแหน่ง</strong></td>
    <td width="25%" align="center" bgcolor="#999999"><strong>เบอร์โทรศัพท์</strong></td>
  </tr>
  <?php $x=1;  for($i=0;$i<$num_row;$i++){?>
  <tr>
    <td align="center" bgcolor="#FFFFFF"><?php echo $x++;?></td>
    <td align="center" bgcolor="#FFFFFF"><input name="name_registor<?php echo $i;?>" type="text" id="name_registor<?php echo $i;?>"></td>
    <td align="center" bgcolor="#FFFFFF"><input name="lastname_registor<?php echo $i;?>" type="text" id="lastname_registor<?php echo $i;?>"></td>
    <td align="center" bgcolor="#FFFFFF"><input name="position_registor<?php echo $i;?>" type="text" id="position_registor<?php echo $i;?>"></td>
    <td align="center" bgcolor="#FFFFFF"><input name="phone_registor<?php echo $i;?>" type="text" id="phone_registor<?php echo $i;?>"></td>
  </tr>
    <?php  }?>
</table>
