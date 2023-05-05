<?php
include("../EWT_ADMIN/comtop_pop.php");
 
$s_egp_process = $db->query("SELECT * FROM egp_process WHERE egp_process_id = '{$_GET[proc_id]}' ");	 
$a_egp_process = $db->db_fetch_array($s_egp_process);
	
if($_GET['proc'] == 'AddProc' ){
	
$PROCESS = 'AddProc';

}else{
	
	$PROCESS = 'EditProc';		
}	
?>	
<form action="process.php" method="post" enctype="multipart/form-data" name="form" >
<input name="id" 	type="hidden" id="id" 	value="<?php echo $_GET['proc_id']; ?>" />
<input name="proc" 	type="hidden" id="proc" value="<?php echo $PROCESS;?>" />
<div class="container" >     
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_egp_proc_add;?></h4>
</div>
<div class="modal-body">      
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >
     
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic1"><?php echo $txt_egp_proc_code;?><span class="text-danger">*</span> : </label>        
<input name="topic1" type="text" id="topic1"  class="form-control" required value="<?php echo $a_egp_process['egp_process_code']; ?>" />	
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="topic2"><?php echo $txt_egp_proc_name;?><span class="text-danger">*</span> : </label>        
<input name="topic2" type="text" id="topic2"  class="form-control" required value="<?php echo $a_egp_process['egp_process_name']; ?>" />	
</div>
</div>
</div>
</div>
</div>
<div class="modal-footer "> 
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<button type="submit" class="btn btn-success  btn-ml " >
		<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;<?php echo $txt_ewt_save ;?>
		</button>
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
		var sms1 = "<div class=\"alert alert-warning\"><strong>Warning!</strong> Please enter the image size less then 300 MB.</div>";
		document.getElementById("warning1").innerHTML = sms1;
			$('#'+id).val("");
	
		}else{
		  document.getElementById("warning1").innerHTML = "";
	  }
		
							
}
</script>