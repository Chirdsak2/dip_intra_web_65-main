<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php"); 
?>
<div class="container" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
          <h4 class="modal-title"><?=$txt_vdo_search_vdo;?></h4>
        </div>
		
<form name="form_main" id="form_main" method="GET" action="<?=getLocation('vdo_list')?>"  >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">

<div class="form-group row " >
<label for="category_title" class="col-sm-12 control-label"><b><?=$txt_ewt_keyword;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_ewt_keyword;?>" name="category_title" type="text" id="category_title"  value="" required="required" />
</div>
</div>

<div class="form-group row " >
<label for="category_sub" class="col-sm-12 control-label"><b><?=$txt_vdo_cate;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<select name="category_parent" id="category_parent" class="form-control"  >
<option value=""selected="" disabled="disabled" ><?=$txt_vdo_select_cate;?></option> 
<?php
$_sql_cate = $db->query("SELECT vdog_id,vdog_name 
FROM vdo_group 
ORDER BY vdog_id ASC ");
while($a_data_faq = $db->db_fetch_row($_sql_cate)){
	$sel = ($a_data_faq[0] == trim($vdo_cid)) ? "selected":"";
?>
<option value="<?=$a_data_faq[0];?>" <?=$sel;?> ><?=$a_data_faq[1];?></option>
<?php
	}
?>		  
</select>
</div>
</div>

<input name="proc" type="hidden" id="proc" value="custom">
</div>

</div>
</form>	

<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<button onclick="JQSearch_Vdo($('#form_main'));" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$txt_ewt_submit;?>" >
<i class="fas fa-check-circle fa-1x"></i>&nbsp;<?=$txt_ewt_submit;?>
</button> 

<button onClick="$('#box_popup').fadeOut();" class="btn btn-warning btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$txt_ewt_cancel;?>" >
<i class="fas fa-times-circle fa-1x"></i>&nbsp;<?=$txt_ewt_cancel; ?>
</button> 
<!--<input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
<input name="reset" type="reset" value="ยกเลิก" class="btn btn-warning"  onClick="$('#box_popup').fadeOut();">
<button class="btn btn-warning btn-lm" onClick="$('#box_popup').fadeOut();" data-toggle="tooltip" data-placement="top" title="<?//=$lang_survey_update; ?>" >
<span class="glyphicon glyphicon-remove"></span>&nbsp;<?//="ยกเลิก";?>-->
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

function JQSearch_Vdo(form){	

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