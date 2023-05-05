<?php
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?><body leftmargin="0" topmargin="0">
<table width="280" height="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#666666"  >
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><div style="overflow:-moz-scrollbars-vertical; overflow-x:auto;overflow-y:auto; width:100%; height:100%; " >
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse" style="border-collapse:collapse">
                
                <tr>
                  <td colspan="2" align="right" bgcolor="#FFFFFF"><a href="javascript:void(0);" onClick="document.getElementById('nav').style.display='none';document.getElementById('posittion').style.display='';document.getElementById('emp_type_id').style.display='';"><img src="../theme/main_theme/g_del.gif" border="0" width="16" height="16" alt="ปิดหน้าต่าง"></a></td>
                </tr>
				<?php
				///  level  1
				
				$select_main="Select * From  org_name  Where parent_org_id LIKE '0001_%' GROUP BY parent_org_id";
	            $exec_main = $db->query($select_main);
				
				$a=1;
				$row_main= $db->db_num_rows($exec_main);
				//2=>"#DDDDDD",3=>"#E4E4E4",
				$color_ar = array(2=>"#EAEAEA",3=>"#EEEEEE",4=>"#F2F2F2",5=>"#F7F7F7",6=>"#FBFBFB",7=>"#FDFDFD",8=>"#FFFFFF");
			    if($row_main){
				while($a<=$row_main){
						$bgcolor = "";
						$tab = "";
						/*if($parent_org_id){
							$count_level_old = explode("_",$parent_org_id);
							$count_exp_old = count($count_level_old);
						}*/
						$rst_main = $db->db_fetch_array($exec_main);
						$org_id=$rst_main[org_id]; 
						$org_type_id=$rst_main[org_type_id];
						$name_org=$rst_main[name_org]; 
						$parent_org_id=$rst_main[parent_org_id];
						$title_name=$rst_main[title_name]; 
						$desription=$rst_main[desription];
						$tel=$rst_main[tel]; 
						$email=$rst_main[email]; 
						$fax=$rst_main[fax];
						$chk_parent = ""; $num_chk_parent = ""; $query_chk_parent ="";
						$sql_chk_parent = "SELECT parent_org_id FROM org_name WHERE parent_org_id LIKE '".$parent_org_id."_%' order by parent_org_id ";
						$query_chk_parent = $db->query($sql_chk_parent);
						$num_chk_parent = $db->db_num_rows($query_chk_parent);
						if($num_chk_parent>0){
							if($a>1) $index_obj.=",";
							$index_obj.= "'_$parent_org_id'";
							if($i_obj2 > 0) $objects2.= ",";
							$i_obj2++;
							$objects2.=" '_$parent_org_id' : [ ";
							for($i_chk_parent = 0 ;$i_chk_parent < $num_chk_parent;$i_chk_parent++){
								$rs_chk_parent = $db->db_fetch_array($query_chk_parent);
								if($i_chk_parent > 0) $objects2.=",";
								$objects2.=" '$rs_chk_parent[parent_org_id]' ";
							}
							$objects2.=" ] ";
						}
						
						unset($count_level);
						$count_level = explode("_",$parent_org_id);
						
						/*$count_exp_new = count($count_level)-1;
						if($count_exp_old){
							$count_exp_old=$count_exp_old-1;
						}*/

						if(count($count_level)<=2){
							$bgcolor = "#E4E4E4";	
						}else{
							for($i = 2 ;$i<count($count_level);$i++){
								$tab.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
								$bgcolor =$color_ar[$i];
							}
						}// end else  count_level
						$bgcolor = "#F2F2F2";	
				?>
                <tr id="tr_<?php echo $parent_org_id?>" <?php if(count($count_level)!=2){print "style=\"display:none\"";}?>  >
                <td height="20" align="left" bgcolor="#FFFFFF"><?php print $tab;if($num_chk_parent>0) {?><img src="../images/plus.gif"  id="img_<?php echo $parent_org_id?>"  align="absmiddle" style="cursor:pointer" onClick="expend('<?php echo $parent_org_id?>',this);" /><?php }else{?><img src="../images/blank.gif" height="21"  width="21" align="absmiddle" style="cursor:pointer"  /><?php }?><img src="../images/blank.gif" height="9"  width="9" align="absmiddle"   /><img src="../images/arrow_r.gif" align="absmiddle" >&nbsp;<a href="##" onClick="document.frm.org_name.focus();document.frm.org_name.value='<?php echo $name_org;?>';document.frm.org_id.value='<?php echo $org_id; ?>';document.getElementById('nav').style.display='none';document.getElementById('posittion').style.display='';document.getElementById('emp_type_id').style.display='';"><?php echo $name_org;?></a></td></tr>
                <?php 
		   $a++;
		}// while  level1
			$index_obj = "[".$index_obj."]";
			//print "<br>";print "<br>";
			$objects2 = "{ ".$objects2." }";
			}else{
				?>
				
                <tr>
                  <td height="50" colspan="2" align="center" bgcolor="#FFFFFF">ไม่มีข้อมูล</td>
                </tr>
                <?php }?>
</table>
    </div>
</td>
  </tr>
</table>
<input name="index_obj" id="index_obj" type="hidden" value="<?php echo $index_obj;?>">
<input name="objects2"  id="objects2"  type="hidden" value="<?php echo $objects2;?>">
<script>
					
				</script>
