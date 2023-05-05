<?php
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
								<select name="addr_tamb<?php echo $gid;?>"  id="addr_tamb<?php echo $gid;?>"
															onFocus="
																if(document.getElementById('addr_amp<?php echo $gid;?>').value==''){
																	alert('กรุณาเลือกอำเภอ'); 
																}"
															>
                                <option value="">- เลือกตำบล -
                                  <?=$tab.$tab.$tab?>
                                  </option>
                                    <?
								$db->query("USE ".$EWT_DB_USER);
								$sql_tumpon = "select * from tumpon where p_code = '$prov' and a_code = '$amph' ORDER BY t_name ASC";
								$query_tumpon= $db->query($sql_tumpon);
								while($rec_tumpon= mysql_fetch_array($query_tumpon)){
								?>
								<option value="<?php echo $rec_tumpon[t_code];?>"><?php echo $rec_tumpon[t_name];?></option>
								<?
								}
								$db->query("USE ".$EWT_DB_NAME);
								?>
                              </select>
