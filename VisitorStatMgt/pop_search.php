<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");

include("../lib/config_path.php"); 
?>
<div class="dContainer" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
          <h4 class="modal-title"><?=''; ?></h4>
        </div>
		
<form name="form_main" id="form_main" method="GET" action="<?=getLocation('stat_index')?>"  >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">

<div class="form-group row">
<div class="col-md-4 col-sm-4 col-xs-12">
<label for="des"><?='Start Date'; ?></label>
<input type="text" class="form-control " name="startdate"  id="datepickerStart2"  value=""  />
<div id="datepickerStart" class="m-t-xs" ></div>
</div>

<div class="col-md-4 col-sm-4 col-xs-12">
<label for="des"><?='End Date'; ?></label>
<input type="text" class="form-control " name="enddate"  id="datepickerEnd2"  value=""  />
<div id="datepickerEnd" class="m-t-xs" ></div>
</div>

<div class="col-md-4 col-sm-4 col-xs-12">

<ul id="menulayer1">
        <li ><a href="#home" onclick="JQSearch_stat($('#form_main'),'TO');$('#box_popup').fadeOut();" >&nbsp;<?="Today";?></a></li>        
        <li ><a href="#home" onclick="JQSearch_stat($('#form_main'),'YE');$('#box_popup').fadeOut();" >&nbsp;<?="Yesterday";?></a></li>        
        <li ><a href="#home" onclick="JQSearch_stat($('#form_main'),'L7');$('#box_popup').fadeOut();" >&nbsp;<?="Last 7 Day";?></a></li>
		<li ><a href="#home" onclick="JQSearch_stat($('#form_main'),'L3');$('#box_popup').fadeOut();" >&nbsp;<?="Last 30 Day";?></a></li>
		<li ><a href="#home" onclick="JQSearch_stat($('#form_main'),'TM');$('#box_popup').fadeOut();" >&nbsp;<?="This Month";?></a></li>
		<li ><a href="#home" onclick="JQSearch_stat($('#form_main'),'LM');$('#box_popup').fadeOut();" >&nbsp;<?="Last Month";?></a></li>
		<li ><a class="active" href="#home" onclick="JQSearch_stat($('#form_main'),'CU');$('#box_popup').fadeOut();" >&nbsp;<?="Custom";?></a></li>
</ul>


</div>
</div>
<input name="proc" type="hidden" id="proc" value="custom">
</div>

</div>
</form>	

<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<button onclick="JQSearch_stat($('#form_main'),'CU');" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?='Submit'; ?>" >
<i class="fas fa-check-circle fa-1x"></i>&nbsp;<?='Submit'; ?>
</button> 

<button onClick="$('#box_popup').fadeOut();" class="btn btn-warning btn-lm" data-toggle="tooltip" data-placement="top" title="<?='Cancel'; ?>" >
<i class="fas fa-times-circle fa-1x"></i>&nbsp;<?='Cancel'; ?>
</button> 
<!--<input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
<input name="reset" type="reset" value="ยกเลิก" class="btn btn-warning"  onClick="$('#box_popup').fadeOut();">
<button class="btn btn-warning btn-lm" onClick="$('#box_popup').fadeOut();" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_update; ?>" >
<span class="glyphicon glyphicon-remove"></span>&nbsp;<?="ยกเลิก";?>-->
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

function JQSearch_stat(form,id){	

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