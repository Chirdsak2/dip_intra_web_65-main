<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
@include("../language/language".$_GET[lang_sh].".php");
					?>
<table width="100%"   border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="15%" height="25" >
								<?php if($search_mode!='2'){ ?><a href="#g" onClick="ajax_search('2');document.getElementById('nav').style.display='none';" ><font color="#0000FF"><?php } ?><?php echo $text_general_article;?><?php if($search_mode!='2'){ ?></font></a><?php } ?>&nbsp;|&nbsp;								</td>
							    <td width="15%" ><?php if($search_mode!='1'){ ?><a href="#g" onClick="ajax_search('1');document.getElementById('nav').style.display='none';"><font color="#0000FF"><?php } ?><?php echo $text_general_page2;?><?php if($search_mode!='1'){ ?></font></a><?php } ?>&nbsp;|&nbsp;</td>
							    <td width="15%" ><?php if($search_mode!='3'){ ?><a href="#g" onClick="ajax_search('3');document.getElementById('nav').style.display='none';"><font color="#0000FF"><?php } ?><?php echo $text_general_galary;?><?php if($search_mode!='3'){ ?></font></a><?php } ?>&nbsp;|&nbsp;</td>
							    <td width="15%" ><?php if($search_mode!='4'){ ?><a href="#g" onClick="ajax_search('4');document.getElementById('nav').style.display='none';"><font color="#0000FF"><?php } ?><?php echo $text_general_webboard;?><?php if($search_mode!='4'){ ?></font></a><?php } ?>&nbsp;|&nbsp;</td>
							    <td width="15%" ><?php if($search_mode!='5'){ ?><a href="#g" onClick="ajax_search('5');document.getElementById('nav').style.display='none';"><font color="#0000FF"><?php } ?><?php echo $text_general_fag;?><?php if($search_mode!='5'){ ?></font></a><?php } ?>&nbsp;|&nbsp;</td>
								<td width="25%" ><?php if($search_mode!='0'){ ?><a href="#g" onClick="ajax_search('0');document.getElementById('nav').style.display='none';"><font color="#0000FF"><?php } ?><?php echo $text_general_google;?><?php if($search_mode!='0'){ ?></font></a><?php } ?>	</td>
							</tr>
						</table>
