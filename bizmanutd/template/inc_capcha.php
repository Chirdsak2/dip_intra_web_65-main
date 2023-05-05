<?php $BID=1; ?>
<table  id="secbox<?php echo $BID;?>" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center"><label><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>">เพื่อความปลอดภัย กรุณากรอกตัวเลข</span></font></span><br><a href="#change"  onClick="Getmessage<?php echo $BID;?>();"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><u>คลิ๊กที่นี่</u> เพื่อเปลี่ยนรูป</span></font></span></a>
				</label><div id="logpic<?php echo $BID;?>"><img src="ewt_pic.php" align="absmiddle"></div> <input name="chkpic1<?php echo $BID;?>" type="text" id="chkpic1<?php echo $BID;?>"  size="4" /><label>
                 
				  <script language="javascript">
				function Getmessage<?php echo $BID;?>(){
					current_local_time = new Date();
					document.getElementById('logpic<?php echo $BID;?>').innerHTML = "<img src=ewt_pic.php?#" + current_local_time.getDate() + (current_local_time.getMonth()+1) + current_local_time.getYear() + current_local_time.getHours() + current_local_time.getMinutes() +current_local_time.getSeconds() + "  align=absmiddle>";
					document.getElementById('chkpic1<?php echo $BID;?>').select();

				  }	  
				  </script>
                </label></td>
              </tr>
            </table>
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" height="23"><label>
				  	<?php
	$db->query("USE ".$EWT_DB_USER);
		$sql_info = "select url,login_openid from user_info where EWT_User = '".$EWT_FOLDER_USER."'";
	$query_info = $db->query($sql_info);
	$rec_info  = $db->db_fetch_array($query_info);
	if($rec_info[url] != ''){
	$url = $rec_info[url];
	}else{
	$url = $_SERVER['HTTP_HOST'].'/';
	}
	$ststusopenid = $rec_info[login_openid];
	$db->query("USE ".$EWT_DB_NAME);
	if($ststusopenid == 'Y'){
	?>
				 <a href="#L" onclick="openid<?php echo $BID;?>();"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>">Openid Login</span></font></span></span></a>
		<?php } ?>
                <input name="fn" type="hidden" id="fn" value="main.php?filename=<?php echo $filename; ?>">
                 <input id="Flag" type="hidden" value="AcceptLogin" name="Flag" />
				 <input id="BID" type="hidden" value="<?php echo $BID;?>" name="BID" /></label></td>
              </tr>
            </table>