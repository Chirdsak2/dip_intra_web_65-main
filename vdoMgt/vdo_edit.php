<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$sql_chk = $db->db_fetch_array($db->query("select site_info_max_file from site_info"));
include("../lib/config_path.php");
include("../header.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script>
function ChkInput(c){
   if(c.vdo_name.value==""){
       alert('กรุณากรอกชื่อ VIDEO');
	   c.vdo_name.focus();
       return false;
   }else if(c.vdo_group.value=="0"){
   		alert('กรุณาเลือกกลุ่ม');
	   c.vdo_group.focus();
       return false;
   /*}else if((c.vdo_filesource.value=="com" && (c.vdo_file1.value=="" && c.vdo_filename.value=="" )  ) || (c.vdo_filesource.value=="web" && c.vdo_file2.value=="")){
   		alert('กรุณาเลือกไฟล์'); 
       return false;*/
   }
}
</script>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>

<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">แก้ไขข้อมูลวิดีโอ</h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" > 
<a href="vdo_lists.php?gid=<?=$_GET['gid'];?>" target="_self">

<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>
</div>	
</div>
<hr />
</div>

<div class="clearfix">&nbsp;</div>


<?php 
		$sql = "SELECT * FROM vdo_list  WHERE vdo_id='{$_GET[vid]}'";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?> 

<form name="myForm" method="post" action="vdo_process.php" enctype="multipart/form-data">

<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="vdo_name"><?php echo "ชื่อวิดีโอ";?><span class="text-danger">*</span> : </label>
        <input class="form-control" name="vdo_name" type="text" id="vdo_name" size="60" value="<?=$data['vdo_name'];?>" />
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="vdo_creator"><?php echo "ที่มา"; ?> : </label>
		  <input class="form-control" name="vdo_creator" type="text" id="vdo_creator" size="60" value="<?=$data['vdo_creator'];?>">
        
      </div>
</div>
<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="vdo_info"><?php echo "URLของแหล่งที่มา";?> : </label>
        <input class="form-control" name="vdo_info" type="text" id="vdo_info" size="60" value="<?=$data['vdo_info'];?>" />
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="vdo_detail"><?php echo "รายละเอียด"; ?> : </label>
		  <textarea class="form-control" rows="5" id="vdo_detail" name="vdo_detail"><?=$data['vdo_detail'];?></textarea>
        
      </div>
</div>

<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="vdo_group"><?php echo "กลุ่มหมวดวิดีโอ";?><span class="text-danger">*</span> : </label>
       	  <select name="vdo_group" class="form-control">
	     <option value="0">--เลือกกลุ่ม--</option>  
		 <?php
	      		$sql = "SELECT * FROM vdo_group  ORDER BY vdog_id ASC";
				$query=$db->query($sql);
		  		while($data2=$db->db_fetch_array($query)){  ?> 
	     			<option value="<?php echo $data2[vdog_id]; ?>" <?php if($data[vdo_group]==$data2[vdog_id])echo 'selected';?>><?php echo $data2[vdog_name]; ?></option>  
			   <?php	} ?>
	  </select>	  
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
	  <label for="showvdo">เลือกประเภทการนำเข้าวิดีโอ : </label>	  	
	  <div class="checkbox">
	  <span <?php if($data['vdo_show_vdo']== '2'){ ?> style="display:none;" <?php } ?>>
	  <input name="showvdo" type="radio" id="showvdo"  onclick="show();" value="1" <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?> checked  <?php } ?> />&nbsp;&nbsp;นำเข้าจากไฟล์วิดีโอ &nbsp;&nbsp;  
	  </span>
	 <span <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?> style="display:none;" <?php } ?>>
	 <input name="showvdo" type="radio" id="showvdo1"  onclick="show();" value="2" <?php if($data['vdo_show_vdo']== '2'){ ?> checked  <?php } ?> />&nbsp;&nbsp;นำเข้าจาก URL YOUTUBE
	   </span>
	  </div>
	  </div>
	  </div>


<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12" id="filevideo1" <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?>  <?php }else{ ?> style="display:none;" <?php } ?> >
        <label for="vdo_filesource"><?php echo "เลือกไฟล์วิดีโอ";?><span class="text-danger">*</span> : </label>
       	  <select name="vdo_filesource" class="form-control" onChange="if(this.value=='com'){
		                              document.myForm.vdo_file1.style.display='';
									  document.myForm.vdo_file2.style.display='none';
									  document.all.sfile.style.display='none';
									}else{ 
		                              document.myForm.vdo_file1.style.display='none';
									  document.myForm.vdo_file2.style.display='';
									  document.all.sfile.style.display='';
									}
									
									">
	       <option value="com" <?php if($data['vdo_filesource']=='com')echo 'selected';?>>ไฟล์จากเครื่อง</option> 
		   <option value="web" <?php if($data['vdo_filesource']=='web')echo 'selected';?>>ไฟล์จากระบบ</option>   
</select>
</div>

<div class="col-md-6 col-sm-6 col-xs-12" id="filevideo" <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?>  <?php }else{ ?> style="display:none;" <?php } ?>>
<label for="vdo_filesource"><?php echo "ไฟล์วิดีโอ";?><span class="text-danger">*</span> : </label>
			<input name="vdo_file1" type="file" class="form-control" >
			<input name="vdo_file2" type="text"  size="30"  style="display:none;" class="form-control">	  
	        <input  type="hidden" name="vdo_filename" value="<?php echo $data['vdo_filename'];?>">			
			<a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.myForm.vdo_file2.value','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0');">
			<img  id="sfile" src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"  style="display:none;" ></a>	    
			
</div>	
<div class="col-md-6 col-sm-6 col-xs-12" <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?>  style="display:none;" <?php }else{ ?>  <?php } ?> id="fileyoutube1">
&nbsp;	
</div>
<div class="col-md-6 col-sm-6 col-xs-12"<?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?>  style="display:none;" <?php }else{ ?>  <?php } ?> id="fileyoutube">	
<label for="vdo_youtube">URL YOUTUBE<span class="text-danger">*</span> : </label>		
	  <input name="vdo_youtube" type="text" size="40" class="form-control" value="<?php echo $data['vdo_fileyoutube'];?>" />	
</div>

</div>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12" >
&nbsp;	
</div>
<div class="col-md-6 col-sm-6 col-xs-12" id="filevideo2" <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?>  <?php }else{ ?> style="display:none;" <?php } ?>>
<span class="style1">* ประเภทไฟล์ที่สามารถใช้ได้คือ  mp4 เท่านั้น<br>
			* ขนาดไฟล์ต้องไม่เกิน <?php echo $sql_chk["site_info_max_file"];?> KB.</span> 
</div>
<div class="col-md-6 col-sm-6 col-xs-12"<?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?>  style="display:none;" <?php }else{ ?>  <?php } ?> id="fileyoutube2">
<span class="style1">* ตัวอย่าง https://www.youtube.com/watch?v=Yx5ew-ck4B8</span>	
</div>
</div>

<div class="form-group row" id="fileimage">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="vdo_info"><?php echo "รูปภาพปกวิดีโอ";?> : </label>
<input name="vdo_imagefile1" type="file"  class="form-control"> 
<br>
	 <span class="style1">* ประเภทไฟล์ที่สามารถใช้ได้คือ jpg,gif,png และ bmp เท่านั้น <br>
* ขนาดไฟล์ต้องไม่เกิน <?php echo $sql_chk["site_info_max_file"];?> KB.</span>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<?php if($data['vdo_image']){ ?>
<img src="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/".$data['vdo_image'];?>" hspace="0" vspace="0" width="80px" height="80px<?php //echo $hi;?>" style="cursor:hand;border:1px #C3C3C3 double ;" />
<?php } ?>
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<input type="submit" name="Submit2" value="&nbsp;&nbsp;บันทึก&nbsp;&nbsp;" onClick="return ChkInput(document.myForm)" class="btn btn-success btn-ml">
<input name="flag" type="hidden"  value="edit"> 
	<input name="gid" type="hidden"  value="<?=$data['vdo_group'];?>"> 
	<input name="vdo_id" type="hidden"  value="<?=$_GET['vid'];?>"> 
<input type="reset" name="Submit3" value="&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;" class="btn btn-warning">
</div>
</div>





<!--<table width="90%" border="0" align="center" class="table table-bordered">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> แก้ไข VIDEO</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="30%">ชื่อ VIDEO <font color="#FF0000">*</font></td>
    <td width="70%"><input name="vdo_name" type="text" size="40" value="<?php echo $data[vdo_name];?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="30%">ผู้สร้าง</td>
    <td width="70%"><input name="vdo_creator" type="text" size="40" value="<?php echo $data[vdo_creator];?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="30%">URLของแหล่งที่มา </td>
    <td width="70%"><input name="vdo_info" type="text" size="40" value="<?php echo $data[vdo_info];?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="30%">รายละเอียด <font color="#FF0000"></font></td>
    <td width="70%"><textarea  name="vdo_detail" cols="40" rows="4"><?php echo $data[vdo_detail];?></textarea></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="30%">กลุ่ม <font color="#FF0000">*</font></td>
      <td width="70%">
	  <select name="vdo_group">
	     <option value="0">--เลือกกลุ่ม--</option>  
		 <?php
	      		/*$sql2 = "SELECT * FROM vdo_group  ORDER BY vdog_id ASC";
				$query2=$db->query($sql2);
		  		while($data2=$db->db_fetch_array($query2)){  ?> 
	     				<option value="<?php echo $data2[vdog_id]; ?>" <?php if($data[vdo_group]==$data2[vdog_id])echo 'selected';?>><?php echo $data2[vdog_name]; ?></option>  
			   <?php	} */?>
	    
	  </select>
	  </td>
  </tr>
<tr valign="top" bgcolor="#FFFFFF"> 
<td width="30%"></td>
<td width="70%">
<span <?php if($data['vdo_show_vdo']== '2'){ ?> style="display:none;" <?php } ?>>
<input name="showvdo" type="radio" id="showvdo"  onclick="show();" value="1" <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?> checked  <?php } ?> /> นำเข้าจากไฟล์ VIDEO
<br></span>
<span <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?> style="display:none;" <?php } ?>>
<input name="showvdo" type="radio" id="showvdo1"  onclick="show();" value="2" <?php if($data['vdo_show_vdo']== '2'){ ?> checked  <?php } ?> /> นำเข้าจาก YOUTUBE </span>
</td>
</tr>
<tr valign="top" bgcolor="#FFFFFF" <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?>  <?php }else{ ?> style="display:none;" <?php } ?>> 
    <td width="30%">เลือกไฟล์ VIDEO <font color="#FF0000">*</font></td>
    <td width="70%">
	ไฟล์ปัจจุบัน : [<?php echo $data['vdo_filename'];?>]<br><br>
	<select name="vdo_filesource" 
	      onChange="if(this.value=='com'){
		                              document.myForm.vdo_file1.style.display='';
									  document.myForm.vdo_file2.style.display='none';
									  document.all.sfile.style.display='none';
									}else{ 
		                              document.myForm.vdo_file1.style.display='none';
									  document.myForm.vdo_file2.style.display='';
									  document.all.sfile.style.display='';
									}
									">
	 <option value="com" <?php if($data['vdo_filesource']=='com')echo 'selected';?>>ไฟล์จากเครื่อง</option> 
	 <option value="web" <?php if($data['vdo_filesource']=='web')echo 'selected';?>>ไฟล์จากระบบ</option>  
	</select>
	<input name="vdo_file1" type="file"  >
	<input name="vdo_file2" type="text"  size="30"  style="display:'none'" value="<?php if($data[vdo_filesource]=='web') echo $data['vdo_filename'];  ?>">
	<input  type="hidden" name="vdo_filename" value="<?php echo $data['vdo_filename'];?>">
	
	<a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.myForm.vdo_file2.value','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0');"><img  id="sfile" src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"  style="display:'none'" ></a>
	 <script language="JavaScript">
           <?php  if($data[vdo_filesource]=='com'){?>
					document.myForm.vdo_file1.style.display='';
					document.myForm.vdo_file2.style.display='none';
					document.all.sfile.style.display='none';
		   <?php }else{?>
					document.myForm.vdo_file1.style.display='none';
					document.myForm.vdo_file2.style.display='';
					document.all.sfile.style.display='';
		   <?php } ?>
	 </script>
	 
	 <br>
	 <span class="style1">* ประเภทไฟล์ที่สามารถใช้ได้คือ  mp4 เท่านั้น <br>
* ขนาดไฟล์ต้องไม่เกิน <?php echo $sql_chk['site_info_max_file'];?> KB.</span></td>
  </tr>
<tr valign="top" bgcolor="#FFFFFF" id="fileyoutube"  <?php if($data['vdo_show_vdo']== '' OR $data['vdo_show_vdo']== '1'){ ?>  style="display:none;" <?php }else{ ?>  <?php } ?>> 
<td width="30%">URL YOUTUBE <font color="#FF0000">*</font></td>
<td width="70%"><input name="vdo_youtube" type="text" size="40" value="<?php echo $data['vdo_fileyoutube'];?>">
<br><span class="style1">* ตัวอย่าง https://www.youtube.com/watch?v=Yx5ew-ck4B8</span></td>
</tr> 
<tr valign="top" bgcolor="#FFFFFF"> 
<td width="30%">รูปภาพปก VIDEO <font color="#FF0000"></font></td>
<td width="70%">
<table>
<tr>
<td>
ไฟล์ปัจจุบัน : [<?php echo $data['vdo_image'];?>]<br><br>
<input name="vdo_imagefile1" type="file" ><input  type="hidden" name="vdo_imagefile" value="<?php echo $data['vdo_image'];?>"><br>
<span class="style1">* ประเภทไฟล์ที่สามารถใช้ได้คือ jpg,gif,png และ bmp เท่านั้น <br>
* ขนาดไฟล์ต้องไม่เกิน <?php echo $sql_chk['site_info_max_file'];?> KB.</span>
</td>
<td>
<img src="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/".$data['vdo_image'];?>" hspace="0" vspace="0" width="80px" height="80px<?php //echo $hi;?>" style="cursor:hand;border:1px #C3C3C3 double ;" />
</td>
</tr>
</table>
</tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก" onClick="return ChkInput(document.myForm)">
	<input name="flag" type="hidden"  value="edit"> 
	<input name="gid" type="hidden"  value="<?php echo $data[vdo_group];?>"> 
	<input name="vdo_id" type="hidden"  value="<?php echo $_GET[vid];?>"> 
     <input type="reset" name="Submit3" value="ยกเลิก" onClick="location.href='vdo_list.php?gid=<?php echo $data[vdo_group];?>' "></td>
  </tr>
</table>-->

</form>
</div> 
<hr>
</div> 
<?php
include('footer.php');
?> 
</body>
</html>
<?php
$db->db_close(); ?>