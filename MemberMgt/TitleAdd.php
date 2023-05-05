<?php
header ("Content-Type:text/plain;charset=UTF-8"); 
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST["flag"] != ''){

	$wh = "and title_id<>'$title_id' ";
	
$sql_chk = "select * from title where ((title_thai = '$title_name_th' and title_eng = '$title_name_en') or (title_thai != '$title_name_th' and title_eng = '$title_name_en')) $wh";
$query = $db->query($sql_chk);
	if($db->db_num_rows($query)>0){
	echo "<script language=\"javascript\">";
	echo "alert('คำนำหน้าชื่อนี้มีอยู่แล้ว ท่านไม่สามารถบันทึกได้ กรุณาตรวจสอบ!!!!!!');";
	echo "document.location.href='TitleList.php'" ;
	echo "</script>";
	exit;
	}
	 if($_POST["flag"] == 'add'){
			$insert="insert into  title (title_thai,title_eng ) 
												   values('$title_name_th','$title_name_en')";	
			 $db->query($insert);
			 $db->query("USE ".$_SESSION["EWT_SDB"]);
			 $db->write_log("create","member","สร้างคำนำหน้า : ".$title_name_th."(".$title_name_en.")");
			 $db->query("USE ".$EWT_DB_USER);
			 echo "<script language=\"javascript\">";
			echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='TitleList.php'" ;
			echo "</script>";
		
	}else{
			$update="update title set   title_thai='$title_name_th',
																 title_eng='$title_name_en'
									Where title_id = '$title_id' ";
			$db->query($update);
			$db->query("USE ".$_SESSION["EWT_SDB"]);
			 $db->write_log("update","member","แก้ไขคำนำหน้า : ".$title_name_th."(".$title_name_en.")");
			 $db->query("USE ".$EWT_DB_USER);
			echo "<script language=\"javascript\">";
			echo "alert('แก้ไขข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='TitleList.php'" ;
			echo "</script>";
	}
}
if($_GET["cmd"] == 'add'){
$lable = 'เพิ่ม';
}else{
$lable = 'แก้ไข';
}

	$select_main="SELECT  * FROM  `title` Where  title_id='$title_id' ";
	$exec_main = $db->query($select_main);
	$rst_main = $db->db_fetch_array($exec_main);
			
	$title_thai=$rst_main[title_thai];
	$title_eng=$rst_main[title_eng];
	
include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
</head>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<?php include("../FavoritesMgt/favorites_include.php");?>
<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $lable;?>คำนำหน้าชื่อ </span> </td>
  </tr>
</table>-->
<?php
if($_GET["cmd"]=='add'){
$linkk="TitleAdd.php?cmd=add";
}else{
$linkk="TitleAdd.php?cmd=edit&title_id=".$_GET["title_id"];
}
?>
<!--<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($lable."คำนำหน้าชื่อ ".$title_thai);?>&module=org&url=<?php echo urlencode($linkk);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="TitleList.php"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> 
      กลับ</a>
    <hr> </td>
  </tr>
</table>-->


<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $lable;?>คำนำหน้าชื่อ</h4>
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
<a href="TitleList.php" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>


</div>
</div>
<hr />
</div>	
<div class="clearfix">&nbsp;</div>

<div class="col-md-12 col-sm-12 col-xs-12" >
<form name="frm" method="post" action="" onSubmit="return CHK(this);">
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
        <label for="title_name_th"><?php echo "คำนำหน้าชื่อ";?><font color="#FF0000">*</font> : </label>
        <input class="form-control" name="title_name_th" type="text" id="title_name_th"  value="<?=trim($title_thai);?>" />
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
   <label for="title_name_en"><?php echo "คำนำหน้าชื่ออังกฤษ";?><font color="#FF0000">*</font> : </label>
        <input class="form-control" name="title_name_en" type="text" id="title_name_en"  value="<?=trim($title_eng);?>" />
</div>	  
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<input type="submit" name="Submit2" value="&nbsp;&nbsp;บันทึก&nbsp;&nbsp;" class="btn btn-success btn-ml" />
<input type="hidden" name="flag" value="<?=$cmd;?>"/>
<input type="hidden" name="group_id" value="<?=$title_id;?>"/>
<input type="reset" name="Submit3" value="&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;" class="btn btn-warning" />
</div>
</div>
</form>
</div>

                <!--<form name="frm" method="post" action="" onSubmit="return CHK(this);">
                <table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse" style="border-collapse:collapse">
                    <tr class="ewttablehead">
                      <td height="20" colspan="2" >ข้อมูลคำนำหน้าชื่อ</td>
                    </tr>
                    <tr>
                      <td width="31%" bgcolor="#FFFFFF">คำนำหน้าชื่อ  : <font color="#FF0000">*</font></td>
                      <td width="69%" bgcolor="#FFFFFF"><input name="title_name_th" type="text" id="title_name_th" value="<?php echo $title_thai;?>" size="30"></td>
                    </tr>
                    <tr >
                      <td bgcolor="#FFFFFF">คำนำหน้าชื่ออังกฤษ  : <font color="#FF0000">*</font></td>
                      <td width="69%" bgcolor="#FFFFFF"><input name="title_name_en" type="text" id="title_name_en" value="<?php echo $title_eng;?>" size="30"></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center" bgcolor="#FFFFFF" ><input name="save" type="submit" class="submit" style="width:80"  value="บันทึก" />
                        <input type="hidden" name="flag" value="<?php echo $cmd;?>"/>
					  <input type="hidden" name="title_id" value="<?php echo $title_id;?>"/></td>
                    </tr>
                </table>
              </form>-->
			  
			  
			  
</body>
</html>
<script >
function CHK(t){
if(t.title_name_th.value == ''){
alert('กรุณากรอกคำนำหน้าชื่อไทย');
return false;
}
//if(t.title_name_en.value == ''){
//alert('กรุณากรอกคำนำหน้าชื่ออังกฤษ');
//return false;
//}
return true;
}
</script>
<?php
$db->db_close(); ?>