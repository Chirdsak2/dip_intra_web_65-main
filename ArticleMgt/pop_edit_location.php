<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");


if($_GET['proc'] == '' ){
$Fl = 'AddLoc';	
$title = "เพิ่มแหล่งที่มา";	
}else{
$Fl = 'EditLoc';		
$title = "แก้ไขแหล่งที่มา";	
}

$s_video = $db->query("SELECT * FROM article_video WHERE av_id = '{$_GET[vid]}' ");
$a_row = $db->db_num_rows($s_video);   
$a_video = $db->db_fetch_array($s_video);	
	
?>	
<form action="article_upload.php" method="post" enctype="multipart/form-data" name="form" >
<input name="nid" 		type="hidden" id="nid" 		value="<?=$_GET['nid']; ?>" />
<input name="proc" 		type="hidden" id="proc" 	value="<?=$Fl;?>" />

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
<?php 
if($_GET['proc'] == '' ){
?>
<div class="form-group row"  >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="แหล่งที่มา";?> : </label> 
<input name="n_address1" type="text" class="form-control" value=""  />
<br>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="Url";?> : </label> 
<input name="n_address2" type="text" class="form-control" value=""  />
<br>
</div>
</div>
<?php }else{ ?>
<div class="form-group row"  >
<?php
//echo $_GET[i];
$s_article = $db->query("SELECT * FROM article_list WHERE n_id='{$nid}' ");
$a_row = $db->db_num_rows($s_article);

$a_article = $db->db_fetch_array($s_article);
	
if($a_article['n_address']){
$n_address = explode("###",$a_article['n_address']);
for($i = 0; $i < count($n_address); $i++ ){	
if($i==$_GET[i]){  
$article = explode("#@#",$n_address[$i]);

?>
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="แหล่งที่มา";?> : </label> 
<input name="n_address1<?=$i;?>" type="text" class="form-control" value="<?=$article[0];?>" required />
<br>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
<label for=""><?="Url";?> : </label> 
<input name="n_address2<?=$i;?>" type="text" class="form-control" value="<?=$article[1];?>" required />
<br>
</div>
<input name="num" type="hidden" id="num" value="<?=$i;?>" />
<?
}
	}
		}
?>
</div>
<?php } ?>

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

function show(){
	var val = $("input:radio[name=showvdo]:checked").val();
	if(val == '1'){
	$('#vdo').show();
	$('#vdo1').hide();
    }else if(val == '2'){
		$('#vdo1').show();
		$('#vdo').hide();
	}
}

function Preview(id,fileInput,type) {
	    if(type == 'VDO'){
		var fileTypes = [$('#t'+type).val()]; 		
		}else if(type == 'IMG'){
		var fileTypes=["png","jpg","gif","bmp"];		
		}

		var file = $("#"+id)[0]; 
        var size = file.files[0].size;
		var maxsize = 1014572800;
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