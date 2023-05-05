<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
function group_name($gtips_id){
global $db;
$sql = "select tips_group_name from tips_group where tips_group_id='".$gtips_id."'";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
return $R[tips_group_name];
}
	?>
<table width="100%" height="100%" border="0" cellpadding="20" cellspacing="1" bgcolor="BEBEC2">
<tr> 
    <td align="center" height="20" bgcolor="#CCCCFF" class="text_head">Tool Tips </td>
  </tr>
  <tr> 
    <td align="center" valign="top" bgcolor="#FFFFFF">
	<?php
	if($_GET[flag]=='group'){
	if($_GET[page] != ''){
	$wh = "and  tips_main.tips_main_type_id = '".$_GET[page]."' ";
	}
	$sql = "select * from tips_list inner join tips_main on tips_main.tips_list_id = tips_list.tips_list_id inner join tips_group on tips_group.tips_group_id = tips_list.tips_group_id where tips_list.tips_group_id = '".$_GET[gtips_id]."' $wh GROUP BY  tips_list.tips_list_id ";
	$query = $db->query($sql);
	
	?>
	<table width="410" border="0" cellpadding="1" cellspacing="1">
	 <tr>
          <td bgcolor="FCFCFE" ><img src="mainpic/webboard_bullet.gif" width="17" height="13" align="absmiddle">&nbsp;<span class="text_head"><?php echo group_name($_GET[gtips_id]);?></span></td>
        </tr>
	<?php while($R = $db->db_fetch_array($query)){ ?>
        <tr>
          <td bgcolor="FCFCFE" class="text_normal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="mainpic/bb1.jpg" align="absmiddle">&nbsp;<a href="#G" onClick="show_detailsub(<?php echo $R[tips_list_id];?>,<?php echo $_GET[gtips_id];?>);"><span class="text_normal"><?php echo $R[tips_list_title];?></span></a></td>
        </tr>
		<?php } ?>
      </table>
	<?php
	}else	if($_GET[flag]=='tips' && $_GET[gtips_id] != ''){
	if($_GET[page] != ''){
	$wh = "and  tips_main.tips_main_type_id = '".$_GET[page]."' ";
	}
	$sql = "select * from tips_list inner join tips_main on tips_main.tips_list_id = tips_list.tips_list_id inner join tips_group on tips_group.tips_group_id = tips_list.tips_group_id where tips_list.tips_list_id = '".$_GET[tips_id]."' $wh GROUP BY  tips_list.tips_list_id ";
	$query = $db->query($sql);
	
	?>
	<table width="410" border="0" cellpadding="1" cellspacing="1">
	 <tr>
          <td bgcolor="FCFCFE" class="text_head"><img src="mainpic/webboard_bullet.gif" width="17" height="13" align="absmiddle">&nbsp;<?php echo group_name($_GET[gtips_id]);?></td>
        </tr>
	<?php while($R = $db->db_fetch_array($query)){ ?>
        <tr>
          <td bgcolor="FCFCFE" class="text_normal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="mainpic/bb1.jpg" align="absmiddle">&nbsp;<?php echo $R[tips_list_title];?></td>
        </tr>
        <tr>
          <td bgcolor="FCFCFE" class="text_normal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo nl2br($R[tips_list_detail]);?></td>
        </tr>
		<?php } ?>
      </table>
	<?php
	}else if($_GET[flag]=='tips_list' and $_GET[page] != ''){
	$sql = "select * from tips_list inner join tips_main on tips_main.tips_list_id = tips_list.tips_list_id inner join tips_group on tips_group.tips_group_id = tips_list.tips_group_id  where tips_main_type_id = '".$_GET[page]."' GROUP BY  tips_list.tips_list_id";
	$query = $db->query($sql);
	
	
	?>
		<table width="410" border="0" cellpadding="1" cellspacing="1">
	<?php while($R = $db->db_fetch_array($query)){ ?>
        <tr>
          <td bgcolor="FCFCFE" class="text_normal"><img src="mainpic/bb1.jpg" align="absmiddle">&nbsp;<?php echo $R[tips_list_title];?><br /><?php echo nl2br($R[tips_list_detail]);?></td>
        </tr>
        <tr>
          <td bgcolor="FCFCFE" class="text_normal"><hr /></td>
        </tr>
		<?php } ?>
      </table>
	<?php
	}else{
	?>
	<table width="410" height="260" border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td background="../../images/login/main.jpg" bgcolor="FCFCFE"><table width="100%" height="80" border="0" cellpadding="5" cellspacing="1">
              <tr>
                <td height="48" align="center" class="ewthead"><b></b></td>
              </tr>
              <tr>
                <td align="center">&nbsp;</td>
              </tr>
              <tr>
                <td height="25" align="center" class="ewtnormal"><strong>Copyright &copy;2008 BizPotential 
                  Corp.</strong></td>
              </tr>
            </table></td>
        </tr>
      </table>
	<?php } ?>
    </td>
  </tr>
  <tr> 
    <td align="center" height="20" bgcolor="#CCCCFF">&nbsp;</td>
  </tr>
</table>
<?php $db->db_close(); ?>
