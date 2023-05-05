<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
include("../lib/set_lang.php");
	/*if($cmd_pos == "del"){
		$sql = $db->query("delete from user_position WHERE up_id LIKE '".$up_id."'");
		
			echo "<script language=\"javascript\">";
			echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='unitList.php';";
			echo "</script>";
	}*/
	if($cmd == "del"){
				function GenLen($data,$op){
					$s = explode($op,$data);
					return count($s);
				}
				
/*		$sqlimg = "select * from org_name WHERE parent_org_id LIKE '".$parent_org_id_send."%'";
		$query = $db->query($sqlimg);
		$rec = $db->db_fetch_array($query);
		@unlink("pic_org/".$rec[org_pics]);	
		@unlink("pic_org/".$rec[org_map]);	
		@unlink("pic_org/".$rec[org_area]);	
		$sql = $db->query("delete from org_name WHERE parent_org_id LIKE '".$parent_org_id_send."%'");
		$sql_chk = $db->db_fetch_array($db->query("select * from org_name where  parent_org_id  LIKE '".$parent_org_id_send."'"));
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		$db->write_log("delete","member","ลบหน่วยงาน : ".$sql_chk[name_org]);
		$db->query("USE ".$EWT_DB_USER);
		
		
		*/
		
		$db->query("DELETE FROM org_name WHERE parent_org_id LIKE '".$parent_org_id_send."%' ");
$len = GenLen($parent_org_id_send,"_");
$len--;
$numr = strlen($parent_org_id_send);
$rest = substr($parent_org_id_send, 0, -4);

	if($EWT_DB_TYPE == "MYSQL"){
		$sql = $db->query("SELECT * FROM org_name WHERE parent_org_id LIKE '$rest%' AND parent_org_id > '".$parent_org_id_send."'  AND length(parent_org_id) >= '$numr' ORDER BY parent_org_id ASC");
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql = $db->query("SELECT * FROM org_name WHERE parent_org_id LIKE '$rest%' AND parent_org_id > '".$parent_org_id_send."'  AND len(parent_org_id) >= '$numr' ORDER BY parent_org_id ASC");
	}

while($R = $db->db_fetch_array($sql)){
$data = explode("_",$R[parent_org_id]);
$num_array = count($data);
$field_change = $data[$len]-1;
$field_change = sprintf("%04d",$field_change);
$total = "";
for($i=0;$i<$num_array;$i++){
if($i == $len ){
$total .= $field_change."_";
}else{
$total .= $data[$i]."_";
}
 }
 $total = substr($total, 0, -1);
$sel = "UPDATE org_name SET parent_org_id = '$total' WHERE org_id = '$R[org_id]' ";
$db->query($sel);
}


		?>
			<script language="javascript">
			alert('ลบข้อมูลเรียบร้อยแล้ว');
			document.location.href='unitList.php';
			</script>";
		<?php
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">จัดเรียงบุคคลากร</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"> <a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("จัดเรียงบุคคลากร");?>&module=org&url=<?php echo urlencode("managememberperson.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;
      <hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse" style="border-collapse:collapse">
                <tr class="ewttablehead">
				<td width="15%" align="center" >&nbsp;</td>
                  <td height="20" align="left" >&nbsp;ชื่อหน่วยงาน</td>
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
                <tr id="tr_<?php echo $parent_org_id?>" <?php if(count($count_level)!=2){print "style=\"display:none\"";}?>>
				 <td align="center" bgcolor="#FFFFFF" valign="top">&nbsp;</td>
                <td height="20" align="left" bgcolor="#FFFFFF"><?php print $tab;if($num_chk_parent>0) {?><img src="../images/plus.gif"  id="img_<?php echo $parent_org_id?>"  align="absmiddle" style="cursor:pointer" onClick="expend('<?php echo $parent_org_id?>',this);" /><?php }else{?><img src="../images/blank.gif" height="21"  width="21" align="absmiddle" style="cursor:pointer"  /><?php }?><img src="../images/blank.gif" height="9"  width="9" align="absmiddle"   /><img src="../images/arrow_r.gif" align="absmiddle" >&nbsp;<a href="managememberperson_list.php?org_id=<?php echo $org_id;?>"><?php echo $name_org;?></a>                </tr>
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
<script>
					
					function expend(obj_index,img){
					var index_obj = new Array();
					var obj = "";
					index_obj = <?php echo $index_obj?>;
					obj = <?php echo $objects2?>;
					var object = obj;
					
						var object_index = "_"+obj_index;
						var object_chk = eval("object."+object_index);
						if(img.src.search("minus.gif") != -1) img.src = "../images/plus.gif";
						else  img.src = "../images/minus.gif";
						for(var i_exp = 0;i_exp < object_chk.length;i_exp++){
							var object_chk2 = eval("object._"+object_chk[i_exp]);
							chk_expand("img_"+object_chk[i_exp],object,object_chk2);
							if(document.getElementById("tr_"+object_chk[i_exp]).style.display != "none") 
							document.getElementById("tr_"+object_chk[i_exp]).style.display = "none";
							else
							document.getElementById("tr_"+object_chk[i_exp]).style.display = "";
						}
					}
					function chk_expand(id_img,object,object_chk2){
						if(  object_chk2 ){
								if(object_chk2.length > 0){
									if(document.getElementById(id_img).src.search("plus") != -1){
										for(var i_exp2 = 0;i_exp2 < object_chk2.length;i_exp2++){
											if(document.getElementById("tr_"+object_chk2[i_exp2]).style.display == "none") 
											document.getElementById("tr_"+object_chk2[i_exp2]).style.display = "";
											var object_chk3 = eval("object._"+object_chk2[i_exp2]);
											chk_expand("img_"+object_chk2[i_exp2],object_chk3);
										}
									}
								}
							}
					}
				</script>
				
</body>
</html>

<?php

$db->db_close(); ?>
<script language="javascript1.2">
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
		function txt_data(w,g) {
	
	var mytop = findPosY(document.getElementById("lang"+w)) +document.getElementById("lang"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("lang"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='../language_set.php?gid='+g+'&id='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function txt_data1(w,g,lang) {

	 window.location.href='../multilangMgt/unitlist.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>
