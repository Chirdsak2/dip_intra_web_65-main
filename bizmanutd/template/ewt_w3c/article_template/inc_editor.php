<table  id="<?php echo $OPname; ?>" width="<?php echo  $edWP; ?>" height="<?php echo  $edHP; ?>" cellpadding="3" cellspacing="2" border="0" style="cursor:hand;border:#999999 dashed 1px;" onmouseover="this.style.borderColor='#FF0000'" onmouseout="this.style.borderColor='#999999'" title="Click To Edit"  onclick="<?php echo $OEname; ?>.location.href='article_editor_new.php?width=<?php echo $edWE;?>&height=<?php echo $edHE;?>&ad_id=<?php echo  $edID; ?>&OE=<?php echo  $OEname; ?>&OP=<?php echo  $OPname; ?>&OT=<?php echo  $OTname; ?>'; document.all.<?php echo $OEname; ?>.style.display=''; this.style.display='none';">
							  <tr>
									<td bgcolor="#FFFF99"  valign="top" onmouseover="this.style.backgroundColor='#FFCCCC';" onmouseout="this.style.backgroundColor='#FFFF99';"><span id="<?php echo $OTname;?>">
									<?php
									   if(trim($ed_detail) != "") {
										   echo stripslashes($ed_detail);
										}else{
										   echo "คลิ๊กที่นี่เพื่อแก้ไขข้อความ";
									   }
								  ?></span>
								  </td>
							  </tr>
</table>
<iframe style="display:none" scrolling="no"  frameborder="0" src="" name="<?php echo $OEname; ?>" id="<?php echo $OEname; ?>" width="<?php echo  $edWEP; ?>" height="<?php echo  $edHEP; ?>"></iframe>