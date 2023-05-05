<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css"></head>
<body leftmargin="0" topmargin="0">
<script>
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
<script>
		/*var name =window.opener.document.getElementById('invite_name').value;
		var id  = window.opener.document.getElementById('invite_id').value;
		var invite_name = new Array();
		var invite_id = new Array();
		invite_name_chk = name.split(",");
		invite_id_chk = id.split(",");
		//alert(invite_id_chk[0]);*/
</script>
<form name="form1" method="post" action="category_list.php">

<table width="100%" height="400" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <th bgcolor="#F9F9F9" scope="col" valign="top"><br>
      <table width="90%" height="30" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
          <th height="30" bgcolor="#F4F4FF" align="left">&nbsp;
            <img src="../images/icon_more.gif" width="12" height="7" align="absmiddle"> <strong>หมวดของรูปภาพ</strong></th>
        </tr>
        <tr>
          <th bgcolor="#FFFFFF" scope="col">
              <table width="95%" border="0">
            <tr>
              <th scope="col"><div align="left">&nbsp;
                <select name="search_select" id="search_select" onChange="if(this.value == ''){document.getElementById('search_text').style.display = 'none'; }else{document.getElementById('search_text').style.display = '';}">
				<option value="" <?php if($_POST[search_select] == ""){print " selected ";}?>>- แสดงทั้งหมด -</option>
				<option value="1" <?php if($_POST[search_select] == "1"){print " selected ";}?>> ชื่อหมวด </option>
                </select>
              &nbsp;
              <input name="search_text" type="text" id="search_text"  value="<?php echo $_POST[search_text]?>" <?php if($search_select == ''){print ' style="display:none" ';}?>>
              &nbsp;
              <input type="submit" name="search" value="ค้นหา">
              </div></th>
            </tr>
            <tr>
              <th scope="col"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                <tr>
                  <th bgcolor="#FFFFFF" scope="col"><table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" align="center">
                    <tr>
                      <td width="9%" height="25" bgcolor="#F4F4FF" ><div align="center"><strong>เลือก</strong></div></td>
                      <td height="25" bgcolor="#F4F4FF"><div align="center"><strong>หมวดของรูปภาพ</strong></div></td>
                    </tr>
                    <?php
 	$page = $_POST[page];
	if(!$limit) $limit = 5;
	if($page == '' || $page < 1)$page =1;
	$page1=$page-1;
	if($page1 == '' || $page1 < 0)$page1 =0;
	
	if( $_POST[search_select] != "" && $_POST[search_text]!=""){
		$wh = " WHERE 1=1 ";
		if($_POST[search_select] == "1"){
			$text = str_replace(" ","%",trim($_POST[search_text]));
			$wh.= "AND ( category_name LIKE '%$text%' )";
		}
	}else{
		$search_text == "";
	}
	
	//$db->query("USE ".$EWT_DB_USER);
	$select = "select * from gallery_category  $wh order by category_id";
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
  ?>
                    <tr>
                      <td height="25" bgcolor="#FFFFFF"><div align="center">
                          <input name="chk<?php echo $result[category_id]?>" type="checkbox" id="chk<?php echo $result[category_id]?>" value="<?php echo $result[category_id]?>" onClick="
	  if(this.checked == true){
	  	create_Element('create_hidden','<?php echo $result[category_id]?>','id[]','<?php echo $result[category_id]?>','hidden');
		//create_Element('create_hidden','<?php echo "name".$result[gen_user_id]?>','name[]','<?php echo $result[title_thai]." ".$result[name_thai]." ".$result[surname_thai]?>','hidden');
	  }else{
	  	delete_Element('form1','create_hidden','<?php echo $result[category_id]?>','id[]','hidden','<?php echo $result[category_id]?>');
		//delete_Element('form1','create_hidden','<?php echo "name".$result[gen_user_id]?>','name[]','hidden','<?php echo $result[title_thai]." ".$result[name_thai]." ".$result[surname_thai]?>');
	  }" 
	  <?php if(count($_POST[id]) > 0) foreach($_POST[id] as $value){ if($result[category_id] == $value) print "checked";}?>
	  >
                          <script>
	  <?php if(count($_POST[id]) == 0  && $_POST[Submit2] != "บันทึก"){?>
	  	/*if( invite_id_chk.length > 0){
			for(var id_chk in invite_id_chk){
				var chk_chk = '<?php echo $result[gen_user_id]?>';
				if(invite_id_chk[id_chk] == chk_chk){
					document.getElementById('chk'+chk_chk).checked = true;
				}
			}
		}*/
		<?php }?>
	              </script>
                      </div></td>
                      <td height="25" bgcolor="#FFFFFF"><div align="left">
                          <?php echo $result[category_name]?>
                      </div></td>
                    </tr>
                    
                    <?php }
					?>
					<tr>
                      <td height="25" colspan="2" bgcolor="#FFFFFF"><div align="right">หน้าที่ 
                        <select name="page" onChange="document.form1.submit();">
						<?php
							for($i=1;$i<=$page_all;$i++){
								if($i == $page) $selected = "selected";
								else $selected = "";
								print "<option value=\"$i\" $selected>$i</option>";
							}
						?>
                        </select>
                        / <?php echo $page_all?> หน้า &nbsp;
                      </div></td>
                      </tr>
 <?php  }else{?>
                    <tr>
                      <td height="25" colspan="2" bgcolor="#FFFFFF"><div align="center"><strong style="color:#FF0000">ไม่พบข้อมูล</strong></div></td>
                    </tr>
                    <?php }?>
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
              <input type="button" name="Submit3" value="ยกเลิก" onClick="window.close();//clear_chkbox(1,<?php echo $i?>,'chk');"></th>
        </tr>
      </table></th>
  </tr>
</table>
<div id="create_hidden"></div>
<?php if($Submit2 == "บันทึก"){?>
<script>
		window.opener.document.getElementById('invite_name').value  ="";
		window.opener.document.getElementById('invite_id').value  ="";
</script>
<?php }?>
<?php
	if(count($_POST[id]) > 0 ){
		for($i=0;$i<count($_POST[id]);$i++){
			if($_POST[id][$i] != "" ){
				?>
				<script>
					create_Element('create_hidden','<?php echo $_POST[id][$i]?>','id[]','<?php echo $_POST[id][$i]?>','hidden');
					//create_Element('create_hidden','<?php echo "name".$_POST[id][$i]?>','name[]','<?php echo $_POST[name][$i]?>','hidden');
				</script>				
				<?php
			}
		}
	}else{
		if($Submit2 == "บันทึก"){
		print "<script>window.close();</script>";
		}else{
	?>
	  <script>
	  	/*if( invite_id_chk.length > 0 && invite_name_chk.length >0){
			for(var id_chk in invite_id_chk){
				if(invite_id_chk[id_chk] != "" &&invite_id_chk[id_chk] != ""){
					create_Element('create_hidden',invite_id_chk[id_chk],'id[]',invite_id_chk[id_chk],'hidden');
					create_Element('create_hidden','name'+invite_id_chk[id_chk],'name[]',invite_name_chk[id_chk],'hidden');
				}
			}
		}*/
	  </script>
	<?php
		}
	}
?>
</form>
<br>
</body>
</html>
<?php
$db->db_close(); 
?>
