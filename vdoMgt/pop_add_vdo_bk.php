<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$sql_chk = $db->db_fetch_array($db->query("SELECT site_info_max_file FROM site_info"));	
?>
<script>
function ChkInput(c){
   if(c.vdo_name.value==""){
	   alert('กรุณากรอกชื่อวิดีโอ');
	   c.vdo_name.focus();
       return false;
   }
  /* if(c.vdo_detail.value==""){
	   alert('กรุณากรอกรายละเอียด VIDEO');
	   c.vdo_detail.focus();
       return false;
   }*/
   if(c.vdo_group.value=="0"){
	   alert('กรุณาเลือกกลุ่มหมวดวิดีโอ');
	   c.vdo_group.focus();
       return false;
   }
   if(document.getElementById("showvdo").checked==true){
   if(document.myForm.vdo_file1.value=="" && document.myForm.vdo_file2.value==""){ 
	   alert('กรุณาเลือกไฟล์วิดีโอ'); 
       return false;
	 
   }
   }
   if(document.getElementById("showvdo1").checked==true){
   if(c.vdo_youtube.value==""){
	   alert('กรุณากรอก URL YOUTUBE');
	   c.vdo_youtube.focus();
       return false;
	
	 
   }
   }
  /*if(document.myForm.vdo_imagefile1.value==""){ 
	   alert('กรุณาเลือกรูปภาพปก VIDEO'); 
       return false;
	}*/
}

function show(){
	var b =document.getElementById("showvdo").value;
	var bc =document.getElementById("showvdo1").value;
	if(document.getElementById("showvdo").checked==true){
	document.getElementById("filevideo").style.display='';
	document.getElementById("filevideo1").style.display='';
	document.getElementById("filevideo2").style.display='';
	document.getElementById("fileyoutube").style.display='none';
	document.getElementById("fileyoutube1").style.display='none';
	document.getElementById("fileyoutube2").style.display='';
    }if(document.getElementById("showvdo1").checked==true){
	document.getElementById("filevideo").style.display='none';
	document.getElementById("filevideo1").style.display='none';
	document.getElementById("filevideo2").style.display='none';
	//document.getElementById("fileimage").style.display='none';
    document.getElementById("fileyoutube").style.display='';
	document.getElementById("fileyoutube1").style.display='';
	document.getElementById("fileyoutube2").style.display='';
	}
}
</script>	
<form name="myForm" method="post" action="vdo_process.php" enctype="multipart/form-data">

<div class="dContainer" >   
    <div class="modal-dialog modal-lg">

      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" >&times;</button>
          <h4 class="modal-title">แก้ไขรายละเอียด</h4>
        </div>
		
<div class="modal-body">
        <span id="warning"></span>
		<span id="warning1"></span>		
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
		  <textarea class="form-control" rows="5" id="vdo_detail" name="vdo_detail"></textarea>
        
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
		  		while($data=$db->db_fetch_array($query)){  ?> 
	     				<option value="<?php echo $data[vdog_id]; ?>" <?php if($_GET[gid]==$data[vdog_id])echo 'selected';?>><?php echo $data[vdog_name]; ?></option>  
			   <?php	} ?>
	  </select>	  
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
	  <label for="showvdo">เลือกประเภทการนำเข้าวิดีโอ : </label>	  	
	  <div class="checkbox">
	  <input name="showvdo" type="radio" id="showvdo"  onclick="show();" value="1" checked />&nbsp;&nbsp;นำเข้าจากไฟล์วิดีโอ &nbsp;&nbsp;  
	  <input name="showvdo" type="radio" id="showvdo1"  onclick="show();" value="2" />&nbsp;&nbsp;นำเข้าจาก URL YOUTUBE
	  </div>
	  </div>
	  </div>


<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12" id="filevideo1" >
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
	      <option value="com">ไฟล์จากเครื่อง</option> 
	      <option value="web">ไฟล์จากระบบ</option>  
</select>
</div>

<div class="col-md-6 col-sm-6 col-xs-12" id="filevideo">
<label for="vdo_filesource"><?php echo "ไฟล์วิดีโอ";?><span class="text-danger">*</span> : </label>
			<input name="vdo_file1" type="file" class="form-control" >
			<input name="vdo_file2" type="text"  size="30"  style="display:none;" class="form-control">	    
			<a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.myForm.vdo_file2.value','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0');">
			<img  id="sfile" src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"  style="display:none;" ></a>	    
			
</div>	
<div class="col-md-6 col-sm-6 col-xs-12" style="display:none;" id="fileyoutube1">
&nbsp;	
</div>
<div class="col-md-6 col-sm-6 col-xs-12" style="display:none;" id="fileyoutube">	
<label for="vdo_youtube">URL YOUTUBE<span class="text-danger">*</span> : </label>		
	  <input name="vdo_youtube" type="text" size="40" class="form-control">	
</div>

</div>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12" >
&nbsp;	
</div>
<div class="col-md-6 col-sm-6 col-xs-12" id="filevideo2">
	<br>
			<span class="text-danger">* ประเภทไฟล์ที่สามารถใช้ได้คือ  mp4 เท่านั้น<br>
			* ขนาดไฟล์ต้องไม่เกิน <?='10';//=$sql_chk["site_info_max_file"];?> MB.</span> 
</div>
<div class="col-md-6 col-sm-6 col-xs-12" style="display:none;" id="fileyoutube2">
	  <br>
	  <span class="text-danger">* ตัวอย่าง https://www.youtube.com/watch?v=Yx5ew-ck4B8</span>	
</div>
</div>

<div class="form-group row" id="fileimage">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="vdo_info"><?php echo "รูปภาพปกวิดีโอ";?> : </label>
<input name="vdo_imagefile1" type="file"  class="form-control"> 
<br>
	 <span class="text-danger">* ประเภทไฟล์ที่สามารถใช้ได้คือ jpg,gif,png และ bmp เท่านั้น <br>
* ขนาดไฟล์ต้องไม่เกิน <?='10';//$sql_chk["site_info_max_file"];?> MB.</span>
</div>
</div>
</div>

<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<input type="submit" name="Submit2" value="&nbsp;&nbsp;บันทึก&nbsp;&nbsp;" onClick="return ChkInput(document.myForm);" class="btn btn-success btn-ml"/>
<input name="flag" type="hidden"  value="add"/> 
<input name="gid" type="hidden"  value="<?=$_GET['gid'];?>"/> 
<input type="reset" name="Submit3" value="&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;" class="btn btn-warning" onClick="$('#box_popup').fadeOut();"/>
</div>
</div>
</div>
      </div>
	 
    </div>
 </div>
 
 
</form>	
<script>  
function Preview(id,fileInput,type) {
	    if(type == 'VDO'){
		var fileTypes = [$('#t'+type).val()]; 		
		}else if(type == 'IMG'){
		var fileTypes=["png","jpg","gif","bmp"];		
		}

		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = 314572800;
		var name = $('#'+id).val();
		var n = name.split('.');
		var m = 0;
						
        for(var i = 0; i < n.length; i++) { 	
			var v = n[1];
		}
			for(var x = 0; x < fileTypes.length; x++) {
				var f = fileTypes[x];
				if(v.match(f)) {
					var m = 1;
					document.getElementById("warning").innerHTML = "";
				}
			}
			if(m == '0'){
				var sms = "<div class=\"login col-md-12 col-sm-12 alert alert-warning\"><strong>Warning!</strong> รูปแบบนามสกุลของไฟล์เอกสารไม่ถูกต้อง\nกรุณาเลือกรูปแบบใหม่  เช่น :\n"+fileTypes.join(", ")+"</div>";
				document.getElementById("warning").innerHTML = sms;				
				//alert(sms);
				$('#'+id).val("");
				//$('#'+id).focus(); 
				scrollTo(body, 0, 100);	
			}
			
	if(size > maxsize){
		var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 10 GB.</div>";
		document.getElementById("warning1").innerHTML = sms1;
			$('#'+id).val("");
	
		}else{
		  document.getElementById("warning1").innerHTML = "";
	  }
		
							
}
</script>