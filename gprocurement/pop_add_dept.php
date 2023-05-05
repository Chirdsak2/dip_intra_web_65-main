<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

if($_GET['ad_id']){
	$wh = "AND ad_id = '{$_GET[ad_id]}'";
}
	
	
$s_egp_dept = $db->query("SELECT * FROM egp_dept WHERE egp_dept_id = '{$_GET[id]}' AND egp_dept_sub = '0' ");	 
$a_egp_dept = $db->db_fetch_array($s_egp_dept);

if($a_detail['ad_des'] != ''){
$txt = $a_detail["ad_des"]; 
}	

if($_GET['proc']){
	
$PROCESS = 'AddDept';

}else{	

	$PROCESS = 'EditDept';		
}	
?>	
<form action="process.php" method="post" enctype="multipart/form-data" name="form" >
<input name="id" 		type="hidden" id="id" 		value="<?=$_GET['id']; ?>" />
<input name="proc" 		type="hidden" id="proc" 	value="<?=$PROCESS;?>" />
<div class="dContainer" >   
    <div class="modal-dialog modal-lg">

      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><span style="font-size:42px;">&times;</span></button>
          <h4 class="modal-title">หน่วยงานรัฐ</h4>
        </div>
        <div class="modal-body">
        
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic1"><?="รหัส";?><span class="text-danger">*</span> : </label>        
<input name="topic1" type="text" id="topic1"  class="form-control" required value="<?=$a_egp_dept['egp_dept_code']; ?>" />	
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic2"><?="ชื่อหน่วยงานรัฐ";?><span class="text-danger">*</span> : </label>        
<input name="topic2" type="text" id="topic2"  class="form-control" required  value="<?=$a_egp_dept['egp_dept_code']; ?>"/>	
</div>
</div>
        </div>
        <div class="modal-footer">
		<button type="submit" class="btn btn-success  btn-ml " >
		<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;<?="บันทึก";?>
		</button>
 
        </div>
      </div>
	 
    </div>
 </div>	 
 </form>
<script>
  CKEDITOR.replace('ad_des', {
	  	customConfig: '../js/ckeditor/custom_config.js'

  });

</script>	
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
		var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 300 MB.</div>";
		document.getElementById("warning1").innerHTML = sms1;
			$('#'+id).val("");
	
		}else{
		  document.getElementById("warning1").innerHTML = "";
	  }
		
							
}
</script>