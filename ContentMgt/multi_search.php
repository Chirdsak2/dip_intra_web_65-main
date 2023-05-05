<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$db->query("USE ".$EWT_DB_USER);

$sql="SELECT * FROM multi_search ";
?>
 
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
 
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="15%" height="47" align="center">ms_module</td>
    <td width="15%" >ms_topic</td>
    <td width="25%" >ms_keyword</td>
    <td width="15%" >ms_picture</td>
    <td width="15%" align="center">ms_link_id</td>
    <td width="15%" align="center">ms_update</td>
  </tr>
<?php
 $query=$db->query($sql);
while($R=$db->db_fetch_array($query)){
 ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><?php echo $R[ms_module]?></td>
    <td><?php echo $R[ms_topic]?></td>
    <td><?php echo substr($R[ms_keyword],0,20)?>......(<?php echo strlen($R[ms_keyword])?>) Character</td>
    <td><?php echo $R[ms_picture]?></td>
    <td><?php echo $R[ms_link_id]?></td>
    <td><?php echo $R[ms_update]?></td>
  </tr>
  <?php  $i++; 
    } ?> 
</table> 


 
</body>
</html>
<?php @$db->db_close(); ?>