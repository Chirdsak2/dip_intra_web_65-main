<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");
include("lang_config.php");

$s_id = get('s_id', 0);
?>
<div class="dContainer" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
        <div class="modal-header">
           <!--<button type="button" class="close" onclick="$('#box_popup').fadeOut();" >&times;</button>-->
          <h4 class="modal-title"><?=$lang_survey_add_topic2; ?><?//=$lang_add_survey; ?></h4>
        </div>
		
<form id="form_main2" name="form_main2" method="POST" action="<?=getLocation('func_add_survey2')?>"  enctype="multipart/form-data" >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">
<?php for($i=1;$i<=1;$i++){  ?>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_section2;?> <?=$i;?>  : </label>
     
      </div>
</div>
	
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_sectionname;?> <?=$i;?> : </label>
        <textarea   class="form-control" name="name"  id="name"  cols="60" rows="6" ></textarea>

      </div>
</div>	  

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_description;?> : </label>
        <textarea   class="form-control" name="des"  id="des"  cols="60" rows="6" ></textarea>
      </div>
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
	  <div class="form-inline">
        <label for="gr"><?=$lang_add_questiontype;?> : </label>
        <input name="gr" type="radio" value="N" class="" onClick="document.form_main2.sel.disabled=true;document.form_main2.num.disabled=true;" checked  /> 
		<?=$lang_add_questiontype_separate;?>
		<input name="gr" type="radio" value="Y" class="" onClick="document.form_main2.sel.disabled=false;document.form_main2.num.disabled=false;" /> 
		<?=$lang_add_questiontype_single;?>
		
		<select name="sel" id="sel" class="form-control" disabled >
                <option value="">กรุณาเลือกชนิดคำตอบ</option>
                <option value="A">เลือกได้คำตอบเดียว</option>
                <option value="B">เลือกได้หลายคำตอบ</option>
       </select>
	  </div>
      </div>
</div>
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
	  <div class="form-inline">
        <label for="sel"><?=$lang_add_questiontype_single_amount ?> : </label>
        <input name="num" type="text" id="num" value="3" style="width:60px;" class="form-control" disabled /> <?=$lang_add_questiontype_single_answer;?> 
      </div>
	  </div>
</div>
<?php } ?>
<input name="proc" type="hidden" id="proc" value="2">
<input name="s_id" type="hidden" id="s_id" value="<?=$s_id;?>">

</form>


<div class="modal-footer">
<div class="form-group row text-center">
<div class="col-md-12 col-sm-12 col-xs-12" >
<span onclick="JQAdd_survey2($('#form_main2'));" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?=$lang_survey_save; ?>
</span> 

</div>
</div>
</div>


</div>
</div>
</div>

<script>

function JQAdd_survey2(form){	

var fail = CKSubmitData(form);
	
if (fail == false) {
	 
var action  = form.attr('action'); 
//alert(action);					
											
			 $.confirm({
						title: 'เพิ่มส่วนใหม่',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: action,					
											data: form.serialize(),
											success: function (data) {
												//console.log(data);
												//alert("Data Save: " + data);												
												self.location.href="edit_survey.php?s_id="+ data;											
												$('#box_popup').fadeOut();
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
									   
}			
</script>