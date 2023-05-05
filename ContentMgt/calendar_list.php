<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "SET"){
			$bcode = base64_decode($_POST["B"]);
			$bid_a = explode("z",$bcode);
			$BID = $bid_a[1];
			$db->query("UPDATE block SET block_link = '".$_POST["chk_calendar"]."' WHERE BID = '".$BID."' ");
			
			$query_calg = $db->query("SELECT * FROM cal_config WHERE BID='$BID' ");
   			if($db->db_num_rows($query_calg)>0){
			      $db->query("UPDATE cal_config SET cal_group = '".$_POST["cal_group"]."' WHERE BID = '".$BID."' ");
			}else{
			      $db->query("INSERT INTO cal_config(BID,cal_group) values('$BID','$_POST[cal_group]')");
			}
   
			$db->write_log("update","main","แก้ไข block 	calendar");
			?>
			<script language="JavaScript">
			window.location.href = "calendar_list.php?B=<?php echo $_POST["B"]; ?>";
			//self.close();
			</script>
			<?php
}else{
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$chk = '';
$chk1 = '';
$sql_file = $db->query("SELECT block_name,block_link FROM block WHERE BID = '".$BID."'");
$R = $db->db_fetch_array($sql_file);
if($R[block_link]==""){
$chk = 'checked';
}else if($R[block_link]=="1"){
$chk1 = 'checked';
}
?>
<html>
<head>
<title><?php echo $EWT_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function selectG(c){
document.form1.selected.value = c;
form1.submit(); 
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
<form name="form1" method="post" action="calendar_list.php">
 <input name="Flag" type="hidden" id="Flag" value="SET">
 <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
  <tr bgcolor="#E6E6E6"> 
    <td width="70%"><strong>Calendar Config </strong></td>
  </tr>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td><strong>ตั้งค่าการแสดงผล</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td><input name="chk_calendar" type="radio"  value="" <?php echo $chk;?>>
      แสดงเป็นปฏิทิน</td>
  </tr>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'">
    <td><input name="chk_calendar" type="radio" value="1" <?php echo $chk1;?>>
      แสดงเป็นแถบรายการแยกระหว่างกิจกรรมที่มีการสมัครสมาชิกและกิจกรรม</td>
  </tr>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td><strong>กำหนดกลุ่มที่ต้องการแสดง</strong></td>
  </tr>
  
  <?php
    $a=array();
   $query_calg = $db->query("SELECT * FROM cal_config WHERE BID='$BID' ");
   if($db->db_num_rows($query_calg)>0){
	   $data = $db->db_fetch_array($query_calg);
	   if($data[cal_group]==""){
	       $all_checked='checked';
	   }else{
	      $a=explode(',',$data[cal_group]);
	   }
	   
  }else{
      $all_checked='checked';
  }
   ?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td><input name="chk_allgroup" type="checkbox"  value=""  <?php echo $all_checked;?> 
	onClick=" if(this.checked==true){
	document.form1.cal_group.value=''; 
	select_all(document.form1.max.value,'');
	}else{
	   this.checked='checked';
	}"> เลือกทั้งหมด <input type="hidden" size="30" value="<?php echo $data[cal_group]?>" name="cal_group"></td>
  </tr>
  <?php
   $query_calg = $db->query("SELECT * FROM cal_category  ORDER BY cat_id");
   while($data = $db->db_fetch_array($query_calg)){ 
       if(in_array($data[cat_id],$a)){
	       $checked='checked';
	   }else{
	       $checked='';
	   }
   ?>
       <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
           <td><input name="chk_group[]" type="checkbox"  id="chk_group" <?php echo $checked;?> value="<?php echo $data[cat_id]?>" onClick="count_select(document.form1.max.value)"> <?php echo $data[cat_name]?></td>
      </tr>
  <?php  
     $k++;
  }   ?>
  
  <tr align="center" bgcolor="#FFFFFF">
    <td colspan="2"><input type="hidden" name="max" value="<?php echo $k?>"><input type="submit" name="Submit" value="บันทึก"></td>
  </tr>
  </form>
</table>

<script language="JavaScript" >
     function select_all(intTotalItems,objCheckHeader){ 
		 if(intTotalItems>1){
				for(i=0;i<intTotalItems;i++){
					document.all.chk_group[i].checked = objCheckHeader;			
				}
		 }else{
		    document.all.chk_group.checked = objCheckHeader
		 }
    }
	
	 function count_select(intTotalItems){ 
	    var count=0;
		document.form1.cal_group.value='';
		 if(intTotalItems>1){
				for(i=0;i<intTotalItems;i++){
					if(document.all.chk_group[i].checked==true){
					    count=count+1;
						document.form1.cal_group.value=document.form1.cal_group.value+document.all.chk_group[i].value+',';
					}			
				}
		 }else{
			  if(document.all.chk_group.checked==true){
					    count=count+1;
			}		
		 }
		 if(intTotalItems==count){
		      select_all(document.form1.max.value,'');
		     document.all.chk_allgroup.checked = 'selected';
			 document.form1.cal_group.value='';
		 }else{
		    document.all.chk_allgroup.checked = '';
		 }
    }
	
</script>

</body>
</html>
<?php
}
$db->db_close(); ?>
