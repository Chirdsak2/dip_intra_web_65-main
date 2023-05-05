<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$db->query("USE ".$EWT_DB_USER);

if($_POST['flag'] != ''){
if($pos_id != ''){
$wh = "and pos_id <> '{$pos_id}'";
}

$sql_chk = "SELECT * FROM position_name  WHERE pos_name = '{$pos_name}' $wh ";
$query = $db->query($sql_chk);
if($db->db_num_rows($query)>0){
	echo "<script>";
	echo "alert('ตำแหน่งหน่วยงานนี้มีอยู่แล้ว ท่านไม่สามารถบันทึกได้ กรุณาตรวจสอบ!!!!!!');";
	echo "document.location.href='PositionList.php'" ;
	echo "</script>";
	exit;
	}
	
	if($_POST["flag"] == 'add'){
		$insert="INSERT INTO  position_name (pos_name,pos_level ) VALUES ('{$pos_name}','{$up_rank}')";	
		$db->query($insert);
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		$db->write_log("create","member","เพิ่มตำแหน่งหน่วยงาน : ".$pos_name);
		$db->query("USE ".$EWT_DB_USER);
	}else{
		$update="UPDATE position_name SET  pos_name='{$pos_name}',pos_level='{$up_rank}' WHERE pos_id = '{$pos_id}' ";
		$db->query($update);
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		$db->write_log("update","member","แก้ไขตำแหน่งหน่วยงาน : ".$pos_name);
		$db->query("USE ".$EWT_DB_USER);
	}
	echo "<script>";
	echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
	echo "document.location.href='PositionList.php'" ;
	echo "</script>";
}

	$select_main="SELECT  * FROM  `position_name` WHERE  pos_id='{$pos_id}' ";
	$exec_main = $db->query($select_main);
	$rst_main = $db->db_fetch_array($exec_main);
			
	$pos_name=$rst_main['pos_name'];
	$up_rank=$rst_main['pos_level'];
	if($_GET['cmd']=='add'){
	$sqlmax = $db->db_fetch_array($db->query("SELECT max(pos_level) AS rankmax FROM position_name "));
	$up_rank = $sqlmax['rankmax']+1;
	}
if($_GET['cmd'] == 'add'){
$lable = 'เพิ่ม';
}else{
$lable = 'แก้ไข';
}
?>

<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $lable;?>ข้อมูลตำแหน่งหน่วยงาน</span> </td>
  </tr>
</table>-->

<?php
	if($_GET["cmd"]=='add'){
	$linkk = "PositionAdd.php?org_id=".$_GET["org_id"]."&cmd=".$_GET["cmd"];
	}else{
		$linkk = "PositionAdd.php?cmd=".$_GET["cmd"]."&pos_id=".$_GET["pos_id"];
}
?>
<!--<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($lable."ข้อมูลตำแหน่งหน่วยงาน  ".$pos_name);?>&module=org&url=<?php echo urlencode($linkk);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="PositionList.php?org_id=<?php echo $org_id?>"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> 
      กลับ</a>
    <hr> </td>
  </tr>
</table>-->

<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $lable;?>ข้อมูลตำแหน่งหน่วยงาน</h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
</div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >

<!--<a href="unitAdd.php?cmd=add&parent_org_id_send=0001" title="เพิ่มข้อมูลหน่วยงาน">
<button type="button" class="btn btn-info" >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?php //echo $lable;?>ข้อมูลหน่วยงาน
</button>	  	  
</a>-->
<a href="PositionList.php?org_id=<?=$org_id?>" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>


</div>
</div>
<hr />
</div>	
<div class="clearfix">&nbsp;</div>

<div class="col-md-12 col-sm-12 col-xs-12" >
<form name="frm" method="post" action="" enctype="multipart/form-data" onSubmit="return CHK(document.frm);" target="urltest">
<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="pos_name"><?php echo "ตำแหน่งงาน";?><span class="text-danger">*</span> : </label>
        <input class="form-control" name="pos_name" type="text" id="pos_name"  value="<?=trim($pos_name);?>" />
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="up_rank"><?php echo "ลำดับความสำคัญของตำแหน่ง"; ?><span class="text-danger">*</span> : </label>
		  <input class="form-control" name="up_rank" type="text" id="up_rank"  value="<?=trim($up_rank);?>">
         <input type="hidden" name="org_id" value="<?=$org_id;?>"/>
      </div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<input type="submit" name="Submit2" value="&nbsp;&nbsp;บันทึก&nbsp;&nbsp;" class="btn btn-success btn-ml" />
<input type="hidden" name="flag" value="<?=$cmd;?>"/>
<input type="hidden" name="pos_id" value="<?=$pos_id;?>"/>
<input type="reset" name="Submit3" value="&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;" class="btn btn-warning" />
</div>
</div>
 </form>
</div>



                <!--<form name="frm" method="post" action="" onSubmit="return CHK(this);">
                <table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse" style="border-collapse:collapse">
                    <tr class="ewttablehead">
                      <td height="20" colspan="2" >ข้อมูลตำแหน่งหน่วยงาน</td>
                    </tr>
                    <tr>
                      <td width="31%" bgcolor="#FFFFFF">ตำแหน่งงาน : <font color="#FF0000">*</font></td>
                      <td width="69%" bgcolor="#FFFFFF"><input name="pos_name" type="text" value="<?php echo $pos_name;?>" size="30"></td>
                    </tr>
                    <tr >
                      <td bgcolor="#FFFFFF" >ลำดับความสำคัญของตำแหน่ง :<font color="#FF0000">*</font></td>
                      <td bgcolor="#FFFFFF"><input name="up_rank" type="text" id="up_rank"  value="<?php echo $up_rank;?>" size="5" onKeyUp="chkformatnum(this)">
                      <input type="hidden" name="org_id" value="<?php echo $org_id;?>"/></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center" bgcolor="#FFFFFF" ><input name="save" type="submit" class="submit" style="width:80"  value="บันทึก" />
                        <input type="hidden" name="flag" value="<?php echo $cmd;?>"/>
					  <input type="hidden" name="pos_id" value="<?php echo $pos_id;?>"/></td>
                    </tr>
                </table>
              </form>-->
			  
</div>
<hr />
</div>			  
</div>
					
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script >
 function isNum (charCode) 
   {
       if (charCode >= 48 && charCode <= 57 )
	       return true;
      else
	     return false;
   }
 function chkFormatNam (str) {//0-9
  strlen = str.length;
  for (i=0;i<strlen;i++)
  {
      var charCode = str.charCodeAt(i);
	  if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
		  return false;
	  }
   }
   return true;
}
function chkformatnum(t){ 
		_MyObj = t;
		_MyObj_Name = t.name;
		_MyObj_Value = t.value;
		_MyObj_Strlen =_MyObj_Value.length; 
		if( _MyObj_Strlen >1 && _MyObj_Value.substr(0,1)==0){
			t.value = _MyObj_Value.substr(1);
		}
		if(!chkFormatNam (t.value)){
				alert('กรุณากรอกจำนวนเงินด้วยตัวเลขเท่านั้น');
				t.value = 0;
				t.focus();
	} 
}
function CHK(t){
if(t.pos_name.value == ''){
alert('กรุณากรอกตำแหน่งงาน');
return false;
}
if(t.up_rank.value == ''){
alert('กรุณากรอกลำดับความสำคัญของตำแหน่ง');
return false;
}
return true;
}
</script>
