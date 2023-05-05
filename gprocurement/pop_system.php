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
	
	
$s_detail = $db->query("SELECT * FROM egp_list 
LEFT JOIN egp_process ON egp_list.egp_list_process = egp_process.egp_process_code 
LEFT JOIN egp_type ON egp_list.egp_list_type = egp_type.egp_type_code 
LEFT JOIN egp_dept ON egp_list.egp_list_dept = egp_dept.egp_dept_code 
WHERE egp_list_id = '{$_GET[id]}' {$wh} ");	 
$a_feed = $db->db_fetch_array($s_detail);

if($a_detail['ad_des'] != ''){
$txt = $a_detail["ad_des"]; 
}	
	
?>	
<form action="process.php" method="post" enctype="multipart/form-data" name="form" >
<input name="nid" 		type="hidden" id="nid" 		value="<?=$_GET['nid']; ?>" />
<input name="Flag" 		type="hidden" id="Flag" 	value="EUpload" />
<div class="dContainer" >   
    <div class="modal-dialog modal-lg">

      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><span style="font-size:42px;">&times;</span></button>
          <h4 class="modal-title">ประกาศจัดซื้อจัดจ้าง</h4>
        </div>
        <div class="modal-body">
        
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic"><?="หัวข้อ";?><span class="text-danger">*</span> : </label>        
<?=$a_feed['egp_list_title'];?>	
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic"><?="ประเภทประกาศ";?><span class="text-danger">*</span> : </label>        
<?=$a_feed['egp_type_name'];?>		
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic"><?="วีธีการจัดหา";?><span class="text-danger">*</span> : </label>        
<?=$a_feed['egp_process_name'];?>		
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic"><?="ชื่อหน่วยงาน";?><span class="text-danger">*</span> : </label>        
<?=$a_feed['egp_dept_name'];?>		
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic"><?="ไฟล์แนบ";?><span class="text-danger">*</span> : </label> 
<a href="<?=$a_feed['egp_list_url'];?>" target="blank">      
<button type="button" class="btn btn-info  btn-ml "  >
		<span class="glyphicon glyphicon-file "></span>&nbsp;<?="เปิดดูไฟล์";?>
		</button>	
		</a>
</div>
</div>

        </div>
        <div class="modal-footer">
		<button type="button" class="btn btn-danger  btn-ml " onclick="$('#box_popup').fadeOut()" >
		<span class="glyphicon glyphicon-remove"></span>&nbsp;<?="ปิด";?>
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