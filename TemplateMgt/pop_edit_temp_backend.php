<?php
include("../EWT_ADMIN/comtop_pop.php");

$u_id = (int)(!isset($_GET['u_id']) ? 0 : $_GET['u_id']);
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_org_list')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Org">

<div class="container" >   
<div class="modal-dialog modal-lg"  >

<div class="modal-content ">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6" >
<button type="button" class="close" style="opacity: 0.9;" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"> <i class="fas fa-cogs"></i> <?='';?></h4>
</div>

<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">



<div class="col-xs-12 col-sm-12 col-md-12 m-t-md">     
<div class="card ">
<div class="card-header m-b-sm visible-xs" >
<div class="card-title text-left"><b></b></div>
</div>
<div class="card-body" >

<div class="form-group row " >
<label for="temp_title" class="col-sm-12 control-label"><b><?='ข้อความ';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?='ข้อความ';?>"  rows="6" id="temp_title" name="temp_title"  required="required" ></textarea>
</div>
</div>
<div class="form-group row " >
<label for="faq_title" class="col-sm-12 control-label"><b><?='ขนาดตัวอักษร';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >

</div>
</div>
<div class="form-group row " >
<label for="faq_title" class="col-sm-12 control-label"><b><?='สีตัวอักษร';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >

</div>
</div>
<div class="form-group row " >
<label for="faq_title" class="col-sm-12 control-label"><b><?='รูปแบบตัวอักษร';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >

</div>
</div>

<div class="form-group row " >
<label for="faq_title" class="col-sm-12 control-label"><b><?='สีพื้นหลัง';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >

</div>
</div>

<div class="form-group row " >
<label for="faq_title" class="col-sm-12 control-label"><b><?='ภาพพื้นหลัง';?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >

</div>
</div>
    
            </div>
        </div>
    </div>

</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Item($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>

</div>

</div>
 
</div>
</div>	 
</form>
	
