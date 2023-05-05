<?php
include("../EWT_ADMIN/comtop_pop.php");
?>
<div class="container" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
          <h4 class="modal-title"><?=$txt_poll_search; ?></h4>
        </div>
		
<form name="form_main" id="form_main" method="GET" action="<?=getLocation('poll_list')?>"  >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">

<div class="form-group row " >
<label for="keyword" class="col-sm-12 control-label"><b><?=$txt_ewt_keyword; ?> <span class="text-danger"><code>*</code></span>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_ewt_keyword;?>" name="keyword" type="text" id="keyword"  value="" required="required" />
</div>
</div>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="event_date_start"><b><?=$txt_poll_statdate;?> <span class="text-danger"></span> : </b></label>
            <div class='input-group date datepicker' id='datetimepicker1'>
                <input readonly type='text' class="form-control " placeholder="<?=$txt_poll_statdate;?>" name="date_start"  id="date_start" value=""  />
                <span class="input-group-addon ewt-bg-color color-white border-ewt">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="event_date_end"><b><?=$txt_poll_enddate;?> <span class="text-danger"></span> : </b></label>
            <div class='input-group date datepicker' id='datetimepicker2'>
                <input readonly type='text' class="form-control " placeholder="<?=$txt_poll_enddate;?>"  name="date_end"  id="date_end" value="" />
                <span class="input-group-addon ewt-bg-color color-white border-ewt">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
	</div>
</div>


</div>

</div>
</form>	

<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<button onclick="JQSearch_Poll($('#form_main'));" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$txt_ewt_submit;?>" >
<i class="fas fa-check-circle fa-1x"></i>&nbsp;<?=$txt_ewt_submit; ?>
</button> 

<button onClick="$('#box_popup').fadeOut();" class="btn btn-warning btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$txt_ewt_cancel;?>" >
<i class="fas fa-times-circle fa-1x"></i>&nbsp;<?=$txt_ewt_cancel; ?>
</button> 

</button> 
</div>
</div>
</div>


</div>
</div>
</div>
<script>


$(function() {
	
 $('.datepicker')	
        .datepicker({
            format: 'yyyy-mm-dd',
			todayHighlight: true,
			//thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        }).
		
	$('#datetimepicker1').on('changeDate', function() {
		var event_date_start = $('#event_date_start').val();
		var event_date_end = $('#event_date_end').val();
		
		if(event_date_end != ''){
		if(event_date_end < event_date_start){
					$.alert({
						title: 'วันที่เริ่มต้นกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่เริ่มต้นกิจกรรมใหม่อีกครั้ง',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						animation: 'scale',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
				
				$('#event_date_start').val('');		
			}
		}		
	});
	
$('#datetimepicker2').on('changeDate', function() {
		var event_date_start = $('#event_date_start').val();
		var event_date_end = $('#event_date_end').val();
		
		if(event_date_end < event_date_start){
					$.alert({
						title: 'วันที่สิ้นสุดกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่สิ้นสุดกิจกรรมใหม่อีกครั้ง',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						animation: 'scale',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
						$('#event_date_end').val('');		
					}
			});	
			
});

function JQSearch_Poll(form,id){	

var fail = CKSubmitData(form);
//var fail = false;
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