<?php
include("../EWT_ADMIN/comtop_pop.php");
?>
<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_faq_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?="Article Icon";?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >
<ul class="list-group">
<?php

		$Current_Dir = "../ewt/".$_SESSION['EWT_SUSER']."/icon";
		$objFolder = opendir($Current_Dir);
		$i = 0;
		rewinddir($objFolder);
		while($file = readdir($objFolder)){
			  if(!(($file == ".") or ($file == "..") or ($file == "Thumbs.db") )){
			  		$FT= filetype($Current_Dir."/".$file);
			  		if($FT == "file"){
?>
<li class="list-group-item ">
<a class="pointer" onClick="JQarticle_Icon('<?=$file;?>','<?=$file;?>');$('#box_popup').fadeOut();">
<img src="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/icon/".$file; ?>"  border="0" align="absmiddle"> 
&nbsp; <?php echo $file; ?>
</a>
</li>

				  <?php
					  $i++;
				   }
			 }
		} 
?>
</ul>
		<?php
		closedir($objFolder);
?>

</div>
</div>
</div>
	
</div>
		
<div class="modal-footer ">
<!--<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_faq_group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?//="บันทึก";?>
</button>
</div>-->
</div>
</div>

</div>
 
</div>	 
</form>
	
<script>  
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	
});

function JQarticle_Icon(cid,cname){
	//alert(cname);
	document.getElementById('icon').value = cid;
	document.getElementById('iconname').innerHTML = '<img src="<?php echo "../ewt/".$_SESSION['EWT_SUSER']."/icon/";?>'+cname+'"  border="0" > ';
	
}

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_parent').attr("disabled",false);
		$('#category_parent').attr("required",false);
		}else{
			$('#category_parent').attr("disabled",true);
			$('#category_parent').attr("required",true);
		}	
	console.log(check);
}
</script>