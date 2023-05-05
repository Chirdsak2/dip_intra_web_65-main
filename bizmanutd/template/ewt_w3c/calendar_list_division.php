<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body >
<script language="javascript" type="text/javascript">
function create_Element(div_id,id,name,value,type){
	var target = document.getElementById(div_id);
	var newHidden = document.createElement("input");
	newHidden.name = name;
	newHidden.id = id;
	newHidden.value = value;
	newHidden.type = type;
	target.appendChild(newHidden); 
}
function delete_Element(form_id,div_id,obj_id,arrayName,type,chk_value){
	var target = document.getElementById(div_id)
    chk = document.getElementById(form_id).elements;
	for(var iii = 0;iii < chk.length;iii++){
		var el = chk[iii];
		if(el.type ==type && el.name == arrayName ){
			if(el.value==chk_value){
				el.disabled = "disabled";
				target.removeChild(document.getElementById(obj_id)); 
			}
		}
	}
}
/*function clear_chkbox(start,end,name){
	chk = document.getElementById('form1').elements;
	for(var iii = 0;iii < chk.length;iii++){
		var el = chk[iii];
		if(el.type == "checkbox"){
			el.checked = false;
		}
	}
}*/
</script>
<script language="javascript" type="text/javascript">
		var name =window.opener.document.getElementById('invite_division').value;
		var id  = window.opener.document.getElementById('invite_divid').value;
		var invite_name = new Array();
		var invite_id = new Array();
		invite_name_chk = name.split(",");
		invite_id_chk = id.split(",");
		//alert(invite_id_chk[0]);
</script>
<form name="form1" method="post" action="">

<table width="100%"  style="height:400px" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <th bgcolor="#F9F9F9" scope="col" valign="top"><br>
      <table width="90%" style="height:30px" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
          <th style="height:30px" bgcolor="#F4F4FF" align="left">&nbsp;
            <img src="images/icon_more.gif" width="12" height="7" alt="icon_more" > รายชื่อหน่วยงานที่เกี่ยวข้อง</strong></th>
        </tr>
        <tr>
          <th bgcolor="#FFFFFF" scope="col">
              <table width="95%" border="0">
            <tr>
              <th scope="col"><div align="left">&nbsp;
                <select name="search_select" id="search_select" onChange="if(this.value == ''){document.getElementById('search_text').style.display = 'none'; }else{document.getElementById('search_text').style.display = '';}">
				<option value="" <? if($_POST[search_select] == ""){print " selected ";}?>>- แสดงทั้งหมด -</option>
				<option value="1" <? if($_POST[search_select] == "1"){print " selected ";}?>> ชื่อหน่วยงาน</option>
                </select>
              &nbsp;
              <input name="search_text" type="text" id="search_text"  value="<?=$_POST[search_text]?>" <? if($search_select == ''){print ' style="display:none" ';}?>>
              &nbsp;
              <input type="submit" name="search" value="ค้นหา">
              </div></th>
            </tr>
            <tr>
              <th scope="col"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                <tr>
                  <th bgcolor="#FFFFFF" scope="col"><table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" align="center">
                    <tr>
                      <td width="9%"  style="height:25px" bgcolor="#F4F4FF" ><div align="center">เลือก</strong></div></td>
                      <td style="height:25px" bgcolor="#F4F4FF"><div align="center">ชื่อหน่วยงาน</strong></div></td>
                    </tr>
                    <?php
 	$page = $_POST[page];
	if(!$limit) $limit = 10;
	if($page == '' || $page < 1)$page =1;
	$page1=$page-1;
	if($page1 == '' || $page1 < 0)$page1 =0;
	
	if( $_POST[search_select] != "" && $_POST[search_text]!=""){
		$wh = " WHERE 1=1 ";
		if($_POST[search_select] == "1"){
			$text = str_replace(" ","%",trim($_POST[search_text]));
			$wh.= "AND ( name_org LIKE '%$text%')";
		}
	}else{
		$search_text == "";
	}
	
	$db->query("USE ".$EWT_DB_USER);
	$select = "select * from org_name $wh order by org_id";
	$query_main = $db->query($select);
	$num_rows = $db->db_num_rows($query_main);
	$num_all = $num_rows;
	if($num_all%$limit==0){
		@$page_all = $num_all/$limit;
	}else{
		@$page_all = (int)($num_all/$limit)+1;
	}
	if($page_all==0) $page_all = 1;
	if($page>=$page_all){$page1 = $page_all-1;$page=$page_all;}
	
	$sql_2 = $select." limit ".$page1*$limit.",$limit";
	$query = $db->query($sql_2);
	$num_rows_2 = $db->db_num_rows($query);
	
  	 if($num_rows_2 > 0){
 	 for($i=1;$i<=$num_rows_2;$i++){
  		$result = $db->db_fetch_array($query);
															$array_org_id = explode('_', $result[parent_org_id]);
															array_pop($array_org_id);
															$parent_org = implode('_', $array_org_id);
															$sql_parent_org = "select * from org_name where parent_org_id = '".$parent_org."'";
															$query_parent_org= $db->query($sql_parent_org);
															$num_rows_parent_org = $db->db_num_rows($query_parent_org);
															if($num_rows_parent_org > 0) {
																$result_parent_org = $db->db_fetch_array($query_parent_org);
																$text_org = $result_parent_org[name_org]."&nbsp;>&nbsp;"."<b>".$result[name_org]."</b>";
															} else {
																$text_org = "<b>".$result[name_org]."</b>";
															}
  ?>
                    <tr>
                      <td style="height:25px" bgcolor="#FFFFFF"><div align="center">
                          <input name="chk<?=$result[org_id]?>" type="checkbox" id="chk<?=$result[org_id]?>" value="<?=$result[org_id]?>" onClick="
	  if(this.checked == true){
	  	create_Element('create_hidden','<?=$result[org_id]?>','id[]','<?=$result[org_id]?>','hidden');
		create_Element('create_hidden','<?="name".$result[org_id]?>','name[]','<?=$result[name_org]?>','hidden');
	  }else{
	  	delete_Element('form1','create_hidden','<?=$result[org_id]?>','id[]','hidden','<?=$result[org_id]?>');
		delete_Element('form1','create_hidden','<?="name".$result[org_id]?>','name[]','hidden','<?=$result[org_id]?>');
	  }" 
	  <? if(count($_POST[id]) > 0) foreach($_POST[id] as $value){ if($result[org_id] == $value) print "checked";}?>
	  >
                       <script language="javascript" type="text/javascript">
	  <? if(count($_POST[id]) == 0 && count($_POST[name]) == 0 && $_POST[Submit2] != "บันทึก"){?>
	  	if( invite_id_chk.length > 0){
			for(var id_chk in invite_id_chk){
				var chk_chk = '<?=$result[org_id]?>';
				if(invite_id_chk[id_chk] == chk_chk){
					document.getElementById('chk'+chk_chk).checked = true;
				}
			}
		}
		<? }?>
	              </script>
                      </div>
					  </td>
                      <td style="height:25px" bgcolor="#FFFFFF"><div align="left"> <?=$text_org?> </div></td>
                    </tr>
                    
                    <? }
					?>
					<tr>
                      <td style="height:25px" colspan="2" bgcolor="#FFFFFF"><div align="right">หน้าที่ 
                        <select name="page" onChange="document.form1.submit();">
						<?php
							for($i=1;$i<=$page_all;$i++){
								if($i == $page) $selected = "selected";
								else $selected = "";
								print "<option value=\"$i\" $selected>$i</option>";
							}
						?>
                        </select>
                        / <?=$page_all?> หน้า &nbsp;
                      </div></td>
                      </tr>
 <?  }else{?>
                    <tr>
                      <td style="height:25px" colspan="2" bgcolor="#FFFFFF"><div align="center"><strong style="color:#FF0000">ไม่พบข้อมูล</strong></div></td>
                    </tr>
                    <? }?>
                  </table></th>
                </tr>
              </table></th>
            </tr>
          </table>
            <br></th>
        </tr>
      </table>
      <table width="100%" border="0" align="center" cellspacing="1">
        <tr>
          <th scope="col"><input type="submit" name="Submit2" value="บันทึก">
              <input type="button" name="Submit3" value="ยกเลิก" onClick="window.close();//clear_chkbox(1,<?//=$i?>,'chk');"></th>
        </tr>
      </table></th>
  </tr>
</table>
<div id="create_hidden"></div>
<?php if($Submit2 == "บันทึก"){?>
<script language="javascript" type="text/javascript">
//alert('<?//php echo $Submit2;?>');
		window.opener.document.getElementById('invite_division').value  ="";
		window.opener.document.getElementById('invite_divid').value  ="";
</script>
<? }?>
<?php
	if(count($_POST[id]) > 0 && count($_POST[name]) > 0 && !$_POST[search]){
		for($i=0;$i<count($_POST[id]);$i++){
			if($_POST[id][$i] != "" && $_POST[name][$i] !=""){
				?>
				<script>
					create_Element('create_hidden','<?=$_POST[id][$i]?>','id[]','<?=$_POST[id][$i]?>','hidden');
					create_Element('create_hidden','<?="name".$_POST[id][$i]?>','name[]','<?=$_POST[name][$i]?>','hidden');
					<?php if($Submit2 == "บันทึก"){?>
					_inv     = window.opener.document.getElementById('invite_division').value  ;
					_inv_id = window.opener.document.getElementById('invite_divid').value  ;
					if(_inv){
						window.opener.document.getElementById('invite_division').value = _inv+',<? echo $_POST[name][$i];?>';
						window.opener.document.getElementById('invite_divid').value = _inv_id+',<? echo $_POST[id][$i];?>';
					} else {
						window.opener.document.getElementById('invite_division').value = '<? echo $_POST[name][$i];?>';
						window.opener.document.getElementById('invite_divid').value = '<? echo $_POST[id][$i];?>';
					}
					
				<?php }?>
				</script>				
				<?php
			}
		}
		/*print "<script>window.close();</script>";*/
	}else{
		if($Submit2 == "บันทึก"){
		/*print "<script>window.close();</script>";*/
		}else{
	?>
<script language="javascript" type="text/javascript">
	  	if( invite_id_chk.length > 0 && invite_name_chk.length >0){
			for(var id_chk in invite_id_chk){
				if(invite_id_chk[id_chk] != "" &&invite_id_chk[id_chk] != ""){
					create_Element('create_hidden',invite_id_chk[id_chk],'id[]',invite_id_chk[id_chk],'hidden');
					create_Element('create_hidden','name'+invite_id_chk[id_chk],'name[]',invite_name_chk[id_chk],'hidden');
				}
			}
		}
	  </script>
	<?
		}
	}
?>
</form>
<br>
<a href="http://validator.w3.org/check?uri=referer"><img src="images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</body>
</html>
<?php
$db->db_close(); 
?>
