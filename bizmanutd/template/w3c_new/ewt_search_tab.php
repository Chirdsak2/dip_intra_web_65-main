<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
					?>
<table width="100%"   border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="90%" height="25" >
								<?php if($search_mode!='2'){ ?><a href="#g" onClick="ajax_search('2');document.getElementById('nav').style.display='none';" ><?php } ?>ข่าว/บทความ<?php if($search_mode!='2'){ ?></a><?php } ?>&nbsp;|&nbsp;
								<?php if($search_mode!='1'){ ?><a href="#g" onClick="ajax_search('1');document.getElementById('nav').style.display='none';"><?php } ?>เนื้อหา<?php if($search_mode!='1'){ ?></a><?php } ?>&nbsp;|&nbsp;
								<?php if($search_mode!='3'){ ?><a href="#g" onClick="ajax_search('3');document.getElementById('nav').style.display='none';"><?php } ?>รูปภาพ<?php if($search_mode!='3'){ ?></a><?php } ?>&nbsp;|&nbsp;
								<?php if($search_mode!='4'){ ?><a href="#g" onClick="ajax_search('4');document.getElementById('nav').style.display='none';"><?php } ?>Webboard<?php if($search_mode!='4'){ ?></a><?php } ?>&nbsp;|&nbsp;
								<?php if($search_mode!='5'){ ?><a href="#g" onClick="ajax_search('5');document.getElementById('nav').style.display='none';"><?php } ?>FAQ<?php if($search_mode!='5'){ ?></a><?php } ?>&nbsp;|&nbsp;
								<?php if($search_mode!='0'){ ?><a href="#g" onClick="ajax_search('0');document.getElementById('nav').style.display='none';"><?php } ?>ค้นหาจากภายนอก<?php if($search_mode!='0'){ ?></a><?php } ?>
									</td>
								
							</tr>
						</table>