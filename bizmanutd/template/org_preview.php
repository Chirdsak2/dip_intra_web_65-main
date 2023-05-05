<?php
	session_start();
	header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql = "select  max(pos_level) as max_level  from position_name ";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
$level  = $R[max_level];
for($i=1;$i<=$level;$i++){
$y=0;
if($i>1){
$wh = "inner join gen_user_order   on 
gen_user.gen_user_id =  gen_user_order.gen_user_id";
$wh1="order by order_no ASC,up_user_id ASC";
}
	$sql_list = "select * from gen_user inner join position_name on gen_user.posittion = position_name.pos_id $wh  where position_name.pos_level = '".$i."' $wh1";
	$query_list = $db->query($sql_list);
	if($db->db_num_rows($query_list)>0){
		?>
	<table width="100%" border="0"><?php 
		while($L = $db->db_fetch_array($query_list)){
		if($y%3==0){ echo '<tr>'; }
			?><td align="center" valign="middle">
										<table width="<?php echo (900)/3;?>px"  border="0" cellspacing="0" cellpadding="0" class="orgchartperson" style="border:1px solid #FAC663; background-color:#FFF3D9; height:150px;"><tr><td align="center" valign="middle"><span class="text_nomal"><img src="img.php?p=<?php echo base64_encode($L[path_image]); ?>" name="previewField" width="75" height="75"  alt="<?php echo base64_encode($L[path_image]); ?>"><br><?php echo $L[name_thai]."   ".$L[surname_thai]."<br>".$L[pos_name];?></span></td>
											</tr>
										</table>
									</td>
			<?php
			if($y%3==2){ echo '<tr>'; }
			$y++;
		}
		echo '</table><hr><br>';
	}
}
?>
<?php $db->db_close(); ?>
