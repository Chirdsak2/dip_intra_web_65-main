<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");


$_host = $_SERVER['HTTP_HOST'];	
	$_name = $_SERVER['SCRIPT_NAME'];
	$_url = $_SERVER['REQUEST_URI'];	
    $_protocal = 'http';
	 
	function getEwt($_url){
	
   $s_method = strtok($_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/";
		
		return  $chk_site;
	}
}
$_directory = getEwt($_url);

	

if($_GET['ad_id']){
	$wh = "AND ad_id = '{$_GET[ad_id]}'";
}
	
	
$s_detail = $db->query("SELECT * FROM article_detail WHERE n_id = '{$_GET[nid]}' {$wh} ");	 
$a_detail = $db->db_fetch_array($s_detail);

if($a_detail['ad_des'] != ''){
	
$a_ad_des = $a_detail['ad_des'];	
$txt = $a_ad_des; 
//$txt = preg_replace($_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/","images/",$txt);
//$txt = preg_replace("images/",$_protocal."://".$_host.$_directory."ewt/".$_SESSION["EWT_SUSER"]."/images/",$txt);

$txt = preg_replace('/(src=\")(.*)(\images)/','$1'.$_protocal.'://'.$_host.$_directory.'ewt/'.$_SESSION['EWT_SUSER'].'/$3',$txt);


}	
?>	
<form action="article_upload.php" method="post" enctype="multipart/form-data" name="formx<?php echo $a; ?>y<?php echo $b; ?>" >
<input name="wb" 	type="hidden" id="wb" 	value="<?='200'; ?>" />
<input name="hb" 	type="hidden" id="hb" 	value="<?='200'; ?>" />
<input name="ad_id" 	type="hidden" id="ad_id" 	value="<?=$_GET['ad_id']; ?>" />
<input name="ad_pic_b" 	type="hidden" id="ad_pic_b" value="<?=$_GET['ad_pic_b']; ?>" />
<input name="ad_pic_s" 	type="hidden" id="ad_pic_s" value="<?=$_GET['ad_pic_s']; ?>" />
<input name="nid" 		type="hidden" id="nid" 		value="<?=$_GET['nid']; ?>" />
<input name="posdisp" 	type="hidden" id="posdisp" 	value="x<?=$_GET['col'];?>y<?=$_GET['row'];?>" />
<input name="Flag" 		type="hidden" id="Flag" 	value="EUpload" />
<div class="dContainer" >   
    <div class="modal-dialog modal-lg">

      <div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut()" ><i class="far fa-times-circle fa-1x"></i></button>
          <h4 class="modal-title">แก้ไขรายละเอียด</h4>
        </div>
        <div class="modal-body" style='overflow-y : auto;  max-height:380px;'>
        <span id="warning"></span>
		<span id="warning1"></span>
		<div class="form-group row" >
		<div class="col-md-12 col-sm-12 col-xs-12">
		<?php if($_GET['row'] != "11" ){ ?>
		<input type="file" name="fileb" id="filer_input" class="form-control" onchange="JSCheck_Img(this.id,this.value);" <?php if($a_detail['ad_pic_b'] == '' OR $a_detail['ad_pic_s'] == '' ){ echo 'required'; }?> />
<?php 
$sql_Imsize = "SELECT site_info_max_img,site_type_img_file FROM site_info";
$query_Imsize = $db->query($sql_Imsize);
$rec_Imsize = $db->db_fetch_array($query_Imsize);
?>
<span class="text-danger"><code>
<?=$rec_Imsize['site_type_img_file'];?>
</code>
</span>
<br>
<span class="text-danger"><code>
ขนาดไฟล์ไม่เกิน <?=$rec_Imsize['site_info_max_img']; ?> MB.
</code></span>
		<?php } ?>	
		</div>
		</div>
		<div class="form-group row" >
		<div class="col-md-12 col-sm-12 col-xs-12">
		<textarea id="ad_des" class="form-control" name="ad_des"><?=$txt;?></textarea>
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
		allowedContent: true,
	  	customConfig: '../../js/ckeditor/custom_config.js'
  });

</script>	
<script>  
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
			var v = n[1].toLowerCase();
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