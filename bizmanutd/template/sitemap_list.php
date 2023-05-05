<?php
	session_start();
	header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
function rootnum($data){
$s = explode("_",$data);
$num = count($s);
return $num;
}
function GenPic($data){
    global $db;
    $num = rootnum($data);
				for($i=3;$i<$num;$i++){
					?>
					<img width="25" src="mainpic/o.gif" border="0" align="absmiddle" >
					<?php
				} 
}
	?>
<table width="95%" border="0" align="center" >
<?php
$sqlC = "select menu_sitemap_list.*,menu_properties.mp_name,menu_properties.Glink,menu_properties.Gtarget from menu_sitemap_list inner join menu_properties on menu_properties.mp_id=menu_sitemap_list.mp_id where s_id = '$sid' and menu_sitemap_list.mp_id  like '".$mp_id."_%' and sm_active = 'Y' order by mp_id";
	  $queryC = $db->query($sqlC);
	  while($RC = $db->db_fetch_array($queryC)){
	 				// if($RC["m_show"] == 'Y'){
					if($RC["m_realname"] != ''){
					$menunameC = $RC["m_realname"];
					}else{
					$menunameC = $RC[mp_name];
					}
?>
  <tr>
    <td>&nbsp;<?php GenPic($RC["mp_id"]) ;?>
	<?php if($RC["Glink"] != ''){?>
		<a href="<?php echo $RC["Glink"]?>" target="<?php $RC["Gtarget"]?>"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><img  src="mainpic/arrow2.gif" border="0" align="absmiddle" >&nbsp;<?php echo trim($menunameC);?></span></font></span></a>
		<?php }else{ ?><span class="text_normal"><font color="#000000"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?>"><img  src="mainpic/arrow2.gif" border="0" align="absmiddle" >&nbsp;<?php echo trim($menunameC);?></span></font></span><?php } ?>
	</td>
  </tr>
  <?php } 
 // }?>
</table>
<?php $db->db_close(); ?>
