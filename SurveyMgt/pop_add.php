<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");;
include("lang_config.php");

$s_id = $_GET['s_id'];
$a_pos = countmax_wh('p_cate','c_d','s_id='.$s_id);	

?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add')?>" enctype="multipart/form-data" >
<div class="container" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
          <h4 class="modal-title"><?php echo $lang_survey_add_topic2; ?></h4>
        </div>
		

<div class="modal-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" >

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
<b><?php echo $lang_add3_part; ?></b>
</div>
</div>

<div class="card-body" >

<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="pa"><b><?php echo $lang_add3_part; ?><span class="text-danger">*</span> : </b></label>
<input class="form-control numberint" name="pa"  id="pa"  value="<?php echo $a_pos+1;?>"  required="required" />
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="name"><b><?php echo $lang_edit_partname;?><span class="text-danger">*</span> : </b></label>
<textarea   class="form-control" name="name"  id="name"  cols="40" rows="5"required="required"  ></textarea>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="des"><b><?php echo $lang_edit_partexplain;?><span class="text-danger">*</span> : </b></label>
<textarea   class="form-control" name="des"  id="des"  cols="40" rows="5" required="required" ></textarea>
</div>
</div>


<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="gr"><b><?php echo $lang_add_questiontype;?><span class="text-danger">*</span> : </b></label>
<div class="radio">
  <label><input type="radio" name="gr"  id="gr1"  value="N"  onClick="JQCheck_Type(this.value);" checked /><?php echo $lang_add_questiontype_separate;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="gr"  id="gr2"  value="Y" onClick="JQCheck_Type(this.value);" /><?php echo $lang_add_questiontype_single;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>

<div class="form-group row " id="div_type" style="display:none;">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="sel"><b><?php echo $lang_add_question_answertype;?><span class="text-danger">*</span> : </b></label>
<select name="sel" id="sel" onChange="JQChange_Box(this.value);" class="form-control"  disabled>
<option value=""selected="" disabled="disabled" ><?php echo $txt_complain_select_cate;?></option> 
    <option value="A">เลือกได้คำตอบเดียว</option>
    <option value="B">เลือกได้หลายคำตอบ</option>
</select>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="num"><b><?php echo $lang_add_questiontype_single_amount;?> <?php echo $lang_add_questiontype_single_answer;?></b></label>
<input name="num" type="text" disabled id="num" value="3" size="5" class="form-control numberint"> 
</div>
</div>



<input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id;?>" />
<input name="proc" type="hidden" id="proc" value="P" />
</div>

</div>
</div>

<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12 text-center" >
<button onclick="JQAdd($('#form_main'));" type="button" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_save; ?>" >
<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?php echo $lang_survey_save; ?>
</button> 
<!--<input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
<input name="reset" type="reset" value="ยกเลิก" class="btn btn-warning"  onClick="$('#box_popup').fadeOut();">
<button class="btn btn-warning btn-lm" onClick="$('#box_popup').fadeOut();" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_update; ?>" >
<span class="glyphicon glyphicon-remove"></span>&nbsp;<?php echo "ยกเลิก";?>-->
</button> 
</div>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</form>	
<script >
$(document).ready(function(){ 

$('.numberint').keypress(function (event) {
            return isNumberInt(event, this)
      });
	  
  });
  
function JQAdd(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
console.log(form.serialize());	

var pa = $("#pa").val();
var name = $("#name").val();
var des = $("#des").val();
var proc = $("#proc").val();
var num = $("#num").val();
var s_id = $("#s_id").val();
var sel = $("#sel").val();
var gr = $("input:radio[name=gr]:checked").val();


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
											type: method,
											url: action,					
											data: formData ? formData : form.serialize(),
											async: true,
											processData: false,
											contentType: false,
											success: function (data) {
												$('#box_popup').fadeOut();
												location.reload(location.href + "#frm_edit_s");	
												//location.reload();	
												//$("#frm_edit_s").load();
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
                   // });
	}
}

function JQCheck_Type(c){
var type = c;
	if(type=='N'){
	document.getElementById('sel').disabled = true;
	document.getElementById('num').disabled = true;
	document.getElementById('div_type').style.display='none';
	$('#sel').attr("required",false);
	}else if(type=='Y'){
		document.getElementById('sel').disabled = false;
		document.getElementById('num').disabled = false;
		document.getElementById('div_type').style.display='';
		$('#sel').attr("required",true);
	}
}

function ChangeBox(c){
if(document.form1.sel.value =="D"){
document.form1.num.disabled = true;
document.form1.just.disabled = false;
}else if(document.form1.sel.value =="B"){
document.form1.just.disabled = true;
document.form1.num.disabled = false;
}else{
document.form1.just.disabled = false;
document.form1.num.disabled = false;
}
}
</script>
