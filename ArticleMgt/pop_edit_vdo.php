<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

//print_r($_GET);
if($_GET['Flag'] == '' ){
$Fl = 'AddVdo';	
$title = "เพิ่มวีดีโอ";	
}else{
$Fl = 'EditVdo';		
$title = "แก้ไขวีดีโอ";	
}

$s_video = $db->query("SELECT * FROM article_video WHERE av_id = '{$_GET[vid]}' ");
$a_row = $db->db_num_rows($s_video);   
$a_video = $db->db_fetch_array($s_video);	
	
?>	
<form action="article_upload.php" method="post" enctype="multipart/form-data" name="form" >
<input name="nid" 		type="hidden" id="nid" 		value="<?=$_GET['nid']; ?>" />
<input name="vid" 		type="hidden" id="vid" 		value="<?=$_GET['vid']; ?>" />
<input name="Flag" 		type="hidden" id="Flag" 	value="<?=$Fl;?>" />

<div class="dContainer" >   
<div class="modal-dialog modal-ml">

<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" onclick="$('#box_popup').fadeOut()" >&times;</button>
<h4 class="modal-title"><?=$title;?></h4>
</div>

<div class="modal-body">
<span id="warning"></span>
<span id="warning1"></span>
<?php if($_GET['Flag'] == '' ){ ?>
<div class="form-group row"  id="vdomore">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="ประเภทไฟล์วิดีโอ";?> : </label> 
<div class="form-inline"> 	  
<input name="showvdo" type="radio" id="showvdo"  onclick="show();" value="1" checked />&nbsp;นำเข้าจากไฟล์วิดีโอ&nbsp;&nbsp;
<input name="showvdo" type="radio" id="showvdo1" onclick="show();" value="2" />&nbsp;นำเข้าจาก URL YOUTUBE	
</div>
</div>
</div>

<div class="form-group row" id="vdo">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic"><?="ไฟล์วิดีโอ";?><span class="text-danger">*</span> : </label>        
<input type="file" name="file" id="filer_input" multiple="multiple" class="form-control" onchange="Preview(this.id,this.value,'VDO');"  />
<br>
<span class="text-danger">* ประเภทไฟล์ที่สามารถใช้ได้คือ  mp4 เท่านั้น  (ขนาดไฟล์ต้องไม่เกิน 10 MB)</span>
</div>
</div>	

<div class="form-group row" style="display:none" id="vdo1">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="URL YOUTUBE";?> : </label> 
<input name="vdo_youtube" id="vdo_youtube" type="text" class="form-control"  />
<br>
<span class="text-danger">* ตัวอย่าง https://www.youtube.com/watch?v=Yx5ew-ck4B8</span>
</div>
</div>	

<?php }else{ ?>
<input name="showvdo" type="hidden"  value="<?=$a_video['av_type'];?>"/> 
<?php if($a_video['av_filename'] != "" OR $a_video['av_type'] == "V"  ){?>
<div class="form-group row" >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic"><?="ไฟล์วิดีโอ";?><span class="text-danger">*</span> : </label>        
<input type="file" name="file" id="filer_input" multiple="multiple" class="form-control" onchange="Preview(this.id,this.value,'VDO');"  />
<input name="file_old" type="hidden" id="file_old" value="<?=$a_video['av_filename'];?>"/> 
<br>
<span class="text-danger">* ประเภทไฟล์ที่สามารถใช้ได้คือ  mp4 เท่านั้น  (ขนาดไฟล์ต้องไม่เกิน 10 MB)</span>
</div>
</div>	
<?php }else{ ?>
<div class="form-group row"  >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="URL YOUTUBE";?> : </label> 
<input name="vdo_youtube" id="vdo_youtube" type="text" class="form-control" onkeypress="show();" value="<?=$a_video['av_filenameyoutube'];?>" />
<br>
<span class="text-danger">* ตัวอย่าง https://www.youtube.com/watch?v=Yx5ew-ck4B8</span>
</div>
</div>
 
<?php } } ?>

</div>
		
        <div class="modal-footer">
		<button type="submit" class="btn btn-success  btn-ml " id="btnsubmit" >
		<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;<?="บันทึก";?>
		</button>
 <input name="tVDO" type="hidden" id="tVDO" value="mp4"/> 
        </div>
      </div>
	 
    </div>
 </div>	 
 </form>	
<script>  
$('document').ready(function() {
	var val = $("input:radio[name=showvdo]:checked").val();
	if(val == '1'){
	$("#filer_input").attr("required", "true");	
	$("#vdo_youtube").removeAttr("required");	
	}else if(val == '2'){
		$("#vdo_youtube").attr("required", "true");
		$("#filer_input").removeAttr("required");
	}
});

function show(){
	var val = $("input:radio[name=showvdo]:checked").val();
	if(val == '1'){
	$("#vdo").css("display", "");
	$("#vdo1").css("display", "none");
	$("#filer_input").css("display", "");
	$("#vdo_youtube").css("display", "none");
 	$("#filer_input").attr("required", "true");	
	$("#vdo_youtube").removeAttr("required"); 	
    }else if(val == '2'){
		$("#vdo").css("display", "none");
	    $("#vdo1").css("display", "");
		$("#filer_input").css("display", "none");
		$("#vdo_youtube").css("display", "");
	 	$("#vdo_youtube").attr("required", "true");
		$("#filer_input").removeAttr("required");  	
	}
}

function Preview(id,fileInput,type) {
	    if(type == 'VDO'){
		var fileTypes = [$('#t'+type).val()]; 		
		}else if(type == 'IMG'){
		var fileTypes=["png","jpg","gif","bmp","jpeg"];	
		}

		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = 10485760;
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
		var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 10 MB.</div>";
		document.getElementById("warning1").innerHTML = sms1;
			$('#'+id).val("");
	
		}else{
		  document.getElementById("warning1").innerHTML = "";
	  }
	

							
}
</script>