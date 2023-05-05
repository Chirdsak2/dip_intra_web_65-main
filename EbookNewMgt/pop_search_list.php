<?php
include("../EWT_ADMIN/comtop_pop.php");
?>
<div class="container" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">

<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_ebook_search ;?></h4>
</div>

	
<form name="form_main" id="form_main" method="GET" action="<?php echo getLocation('ebook_list')?>"  > 
<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-body" >

<div class="form-group row " >
<label for="text" class="col-sm-12 control-label"><b><?php echo $txt_ewt_keyword; ?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_ewt_keyword;?>" name="text" type="text" id="text"  value="" required="required" />
</div>
</div>
<input name="proc" type="hidden" id="proc" value="search" >
<input name="c_id" type="hidden" id="c_id" value="<?php $_GET['c_id'];?>" > 
</div>
</div>
</div> 
</form>	
<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<button onclick="JQSearch_Cate($('#form_main'));" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_submit;?>" >
<i class="fas fa-check-circle fa-1x"></i>&nbsp;<?php echo $txt_ewt_submit; ?>
</button> 
<button onClick="$('#box_popup').fadeOut();" class="btn btn-warning btn-lm" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_cancel;?>" >
<i class="fas fa-times-circle fa-1x"></i>&nbsp;<?php echo $txt_ewt_cancel; ?>
</button> 
 
</div>
</div>
</div>


</div>
</div>
</div>
<script>


$(function() {
	
	$('#datepickerStart')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'en-en',
			//thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        }).datepicker("setDate", "0");
	$('#datepickerStart2').val($('#datepickerStart').datepicker('getFormattedDate'));		
	

	$('#datepickerStart').on('changeDate', function() {
    $('#datepickerStart2').val($('#datepickerStart').datepicker('getFormattedDate'));
	});
	
	$('#datepickerEnd')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'en-en',
			//thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        }).datepicker("setDate", "0");
	$('#datepickerEnd2').val($('#datepickerEnd').datepicker('getFormattedDate'));		
	

	$('#datepickerEnd').on('changeDate', function() {
    $('#datepickerEnd2').val($('#datepickerEnd').datepicker('getFormattedDate'));
	});
});

function JQSearch_Cate(form,id){	

//var fail = CKSubmitData(form);
var fail = false;
	if (fail == false) {
		var action  = form.attr('action'); 
		//alert(id);
		$('#proc').val(id);	
		form.submit();			
										/*$.ajax({
											type: 'GET',
											url: action,					
											data: form.serialize(),
											success: function (data) {
												//console.log(data);
												//self.location.href="stat_index.php?s_id="+ data;											
												//$('#box_popup').fadeOut();
												//alert("Data Save: " + data);																																	
												//location.reload();
												
											}
										});	*/																									
							
	} 
}
</script>