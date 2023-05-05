<?php
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
								<select name="addr_amp<?php echo $gid;?>"  id="addr_amp<?php echo $gid;?>"
															onFocus="
																if(document.getElementById('addr_prov<?php echo $gid;?>').value==''){
																	alert('กรุณาเลือกจังหวัด'); 
																	document.getElementById('addr_prov<?php echo $gid;?>').focus();
																}"
																onChange="
																txt_area( document.getElementById('addr_prov<?php echo $gid;?>').value,this.value,'<?php echo $gid;?>');
																"
															>
                                <option value="">- เลือกอำเภอ -
                                  <?=$tab.$tab.$tab?>
                                  </option>
                                    <?
								$db->query("USE ".$EWT_DB_USER);
								$sql_tumpon = "select * from amphur where p_code = '$prov' ORDER BY a_name ASC";
								$query_tumpon= $db->query($sql_tumpon);
								while($rec_tumpon= mysql_fetch_array($query_tumpon)){
								?>
								<option value="<?php echo $rec_tumpon[a_code];?>"><?php echo $rec_tumpon[a_name];?></option>
								<?
								}
								$db->query("USE ".$EWT_DB_NAME);
								?>
                              </select>
							  
