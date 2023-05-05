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

$type =  $_GET['type'];
$post =  $_GET['post'];
$path =  $_GET['path'];

?>

<div class="container" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"><?=$lang_add3_additem;?>	</h4>
</div>
<!--<form name="form1" id="form1" method="post" >-->
<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_question')?>" enctype="multipart/form-data" >
<div class="modal-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" >

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
<b><?=$lang_add_question_createquestion; ?><?=$post; ?></b>
</div>
</div>

<div class="card-body" >

<input name="type" type="hidden" id="type" value="<?=$type;?>">
<?php if($type == "N"){ ?>
<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="ch"><b><?=$lang_add_question_questionnumber; ?><span class="text-danger">*</span> : </b></label>
<input class="form-control numberint" name="ch"  id="ch"  value="" required="required"/>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="name"><b><?=$lang_add_question_question;?><span class="text-danger">*</span> : </b></label>
<textarea   class="form-control" name="name"  id="name"  cols="40" rows="5" required="required" ></textarea>
</div>
</div>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="sel"><b><?=$lang_add_question_answertype;?><span class="text-danger">*</span> : </b></label>
<select name="sel" id="sel" onChange="JQChange_Box(this.value);" class="form-control" required="required">
<option value=""selected="" disabled="disabled" ><?=$txt_complain_select_cate;?></option> 
          <option value="A">Radio Box</option>
          <option value="B">Check Box</option>
          <option value="C">List Box</option>
          <option value="D">Text Box</option>
		  <option value="E">Browse File</option>
		  <option value="F">Calendar</option>
		  <option value="G">Area</option>
</select>
</div>
</div>


<div class="form-group row" id="div_num" style="display:none;" >
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="num"><b><?=$lang_add_question_answerhowmany;?><span class="text-danger">*</span> : </b></label>
 <input name="num" type="text" id="num" size="5" class="form-control numberint">
</div>
</div>

<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="pos"><b><?=$lang_add_question_rank;?><span class="text-danger">*</span></b> : </label>
 <input name="pos" type="text" id="pos" value="<?=$pos;?>" class="form-control numberint">
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="just"><b><?=$lang_add_question_require;?></b> : </label>
<div class="checkbox">
  <label><input type="checkbox" name="just"  id="just"  value="Y"   /><?=$lang_add_question_require;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>

<div class="form-group row" id="email_tr" style="display:none;" >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="email_data"><?="รูปแบบข้อมูล";?> : </label>
<div class="radio">
  <label><input type="radio" name="email_data"  id="email_data1"  value=""  checked  /><?='ข้อมูลตัวอักษรทั่วไป';?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="email_data"  id="email_data2"  value="Y"    /><?='ข้อมูลรูปแบบอีเมล์';?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="email_data"  id="email_data3"  value="N"    /><?='ข้อมูลรูปแบบตัวเลข';?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>
<div class="form-group row" id="email_tr2" style="display:none;">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="de"><?=$lang_edit_textbox;?><span class="text-danger">*</span> : </label>
<div class="radio">
  <label><input type="radio" name="de"  id="de1"  value="S"   /><?=$lang_edit_singleline;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="de"  id="de2"  value="M"  /><?php echo $lang_edit_multiline; ?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>


<div class="form-group row" id="email_tr1" style="display:none;" >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="no_replate"><b><?='ไม่ต้องการให้ข้อมูลซ้ำ';?></b> : </label>
<input type="checkbox" name="no_replate" id="no_replate" value="QNR" />
</div>
</div>

<input name="proc" type="hidden" id="proc" value="Q">
<input name="path" type="hidden" id="path" value="<?=$path; ?>">
		
<?php }elseif($type=="Y"){ ?>

<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="ch"><b><?=$lang_add_question_questionnumber; ?></b><span class="text-danger">*</span> : </label>
<input class="form-control numberint" name="ch"  id="ch"  value="" required="required" />
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="name"><b><?=$lang_add_question_question;?></b><span class="text-danger">*</span> : </label>
<textarea class="form-control" name="name"  id="name"  cols="40" rows="5" required="required" ></textarea>
</div>
</div>

<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="pos"><b><?=$lang_add_question_rank;?></b><span class="text-danger">*</span> : </label>
 <input name="pos" type="text" id="pos" value="<?=$pos;?>" class="form-control numberint" required="required">
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="just"><b><?=$lang_add_question_require;?></b> : </label>
<div class="checkbox">
  <label><input type="checkbox" name="just"  id="just"  value="Y"   /><?=$lang_add_question_require;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php
$s_question = $db->query("SELECT * FROM p_question WHERE c_id = '{$path}' ");
$a_row = $db->db_num_rows($s_question);
if($a_row == 0){
?>
 <table class="table table-bordered">
    <thead>
      <tr class="info">	
		<th width="20%" class="text-center"></th>
        <th width="60%" class="text-center"><?=$lang_add_question_answerforpart;?> <?=$post;?></th>
		<th width="20%" class="text-center"> คะแนน/น้ำหนัก</th>
      </tr>
    </thead>
    <tbody>
<?php	 
$SQL2 = $db->query("SELECT * FROM p_cate WHERE c_id = '{$path}' ");
$R = $db->db_fetch_array($SQL2);
for($i=0;$i<$R['option2'];$i++){
?>
<tr>
        <td class="text-center" >
		<?=$lang_add_question_answerrank; ?> <?=$i+1 ?>
		</td>
		<td class="text-center" > 
		<input name="ans<?=$i;?>" type="text" id="ans<?=$i;?>" class="form-control"> 
		</td>
		<td class="text-center" > 
		<input name="weight<?=$i;?>" type="text" id="weight<?=$i;?>" value="0" class="form-control numberint" > 
		</td>
</tr>
<?php } } ?>
</tbody>
</table>
</div>
</div>		 		
        <input name="proc" type="hidden" id="proc" value="B">
        <input name="path" type="hidden" id="path" value="<?=$path;?>">
        <input name="all" type="hidden" id="all" value="<?=$R['option2'];?>">
<?php } ?>



</div>
<hr>
<div class="clearfix">&nbsp;</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<button onclick="JQAdd_question($('#form_main'));"  type="button" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?=$lang_survey_save; ?>
</button> 
<!--<input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
<input name="reset" type="reset" value="ยกเลิก" class="btn btn-warning"  onClick="$('#box_popup').fadeOut();">
<button class="btn btn-warning btn-lm" onClick="$('#box_popup').fadeOut();" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_update; ?>" >
<span class="glyphicon glyphicon-remove"></span>&nbsp;<?="ยกเลิก";?>-->
</button> 
</div>
</div>

</div>
</form>	

<!--<div class="modal-footer"></div>-->


</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script >
$(document).ready(function(){ 

$('.numberint').keypress(function (event) {
            return isNumberInt(event, this)
      });
	  
  });
  
  
function JQAdd_question(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
//console.log(form.serialize());		
	$.confirm({
						title: '<?='เพิ่มคำถาม';?>',
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
											success: function (data) {											//alert(data);	
												console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														console.log(data);	
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="complain_builder.php?com_cid="+data;											
												//$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									//$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					}
}					
								 
function JQAdd_question1(form){	

var fail = CKSubmitData(form);
if (fail == false) {	

var type = $("#type").val();

if(type == 'N'){

var ch = $("#ch").val();
var name = $("#name").val();
var sel = $("#sel").val();
var num = $("#num").val();
var pos = $("#pos").val();
var just = $("input:checkbox[name=just]:checked").val();
var de = $("input:radio[name=de]:checked").val();
var email_data = $("input:radio[name=email_data]:checked").val();
var no_replate = $("#no_replate").val();
var path = $("#path").val();
var proc = $("#proc").val();

}
if(type == 'Y'){
	
var ch = $("#ch").val();
var name = $("#name").val();
var pos = $("#pos").val();
var just = $("input:checkbox[name=just]:checked").val();
var path = $("#path").val();
var proc = $("#proc").val();	

var all = $("#all").val();

var ans = [];
var weight = [];

for(var i=0; i < all; i++){

	ans.push($("#ans"+i).val());
	weight.push($("#weight"+i).val());
}

	
}

if(type == 'N'){
	
var dataString = {'ch': ch,'name': name,'sel': sel,'num': num,'pos': pos,'just': just,'email_data': email_data,'de': de,'no_replate': no_replate,'path': path,'proc':proc};

}else if(type == 'Y'){
	
var	dataString = {'ch': ch,'name': name,'pos': pos,'just': just,'proc':proc,'path':path,'all':all,'ans':ans,'weight':weight};

}

console.log(dataString);
console.log(weight);

			  $.confirm({
						title: 'เพิ่มคำถาม',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-question-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: 'POST',
											url: 'func_add_question.php',					
											//data:{'ch': ch,'name': name,'sel': sel,'num': num,'pos': pos,'just': just,'email_data': email_data,'no_replate': no_replate,'path': path,'proc':proc},
											data: dataString,
											success: function (data) {
												console.log(data);	
												//alert(data);
												$('#box_popup').fadeOut();
												//location.reload(location.href + "#frm_edit_s");	
												//location.reload(location.href + " #frm_edit_s");	
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
function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var type_data = $('input:radio[name='+name+']:checked').val();
	
	if(type_data == '0'){
		$('#show_complain_category').hide();
		$('#complain_category').attr("disabled",true);
		$('#complain_category').attr("required",false);
		}else{
			$('#show_complain_category').show();
			$('#complain_category').attr("disabled",false);
			$('#complain_category').attr("required",true);
		}	
	console.log(type_data);
}
 
function JQChange_Box(c){
//alert(c);
//var sel = $("#sel").val();
var sel = c;
		if(sel =="D"){
				document.getElementById('num').disabled = true;
				document.getElementById('just').disabled = false;
				//document.form1.num.disabled = true;
				//document.form1.just.disabled = false;
				document.getElementById('email_tr').style.display='';
				document.getElementById('email_tr1').style.display='';
				document.getElementById('email_tr2').style.display='';
				document.getElementById('div_num').style.display='none';
		}else if(sel =="G"){
				document.getElementById('num').disabled = true;
				document.getElementById('just').disabled = false;
				//document.form1.num.disabled = true;
				//document.form1.just.disabled = false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
				document.getElementById('email_tr2').style.display='none';
				document.getElementById('div_num').style.display='none';
		}else if(sel =="F"){
				document.getElementById('num').disabled = true;
				document.getElementById('just').disabled = false;
				//document.form1.num.disabled = true;
				//document.form1.just.disabled = false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
				document.getElementById('email_tr2').style.display='none';
				document.getElementById('div_num').style.display='none';
		}else if(sel =="E"){
				document.getElementById('num').disabled = true;
				document.getElementById('just').disabled = false;
				//document.form1.num.disabled = true;
				//document.form1.just.disabled = false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
				document.getElementById('email_tr2').style.display='none';
				document.getElementById('div_num').style.display='none';
		}else if(sel =="C"){
				document.getElementById('num').disabled = false;
				document.getElementById('just').disabled = false;
				//document.form1.just.disabled = true;
				//document.form1.num.disabled = false;
				document.getElementById('email_data1').checked=false;
				document.getElementById('email_data2').checked=false;
				document.getElementById('email_data3').checked=false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
				document.getElementById('email_tr2').style.display='none';
				document.getElementById('div_num').style.display='';
				$('#num').attr("required",true);
		
		}else if(sel =="B"){
				document.getElementById('num').disabled = false;
				document.getElementById('just').disabled = false;
				//document.form1.just.disabled = true;
				//document.form1.num.disabled = false;
				document.getElementById('email_data1').checked=false;
				document.getElementById('email_data2').checked=false;
				document.getElementById('email_data3').checked=false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
				document.getElementById('email_tr2').style.display='none';
				document.getElementById('div_num').style.display='';
				$('#num').attr("required",true);
		}else if(sel =="A"){
				document.getElementById('num').disabled = false;
				document.getElementById('just').disabled = false;
				//document.form1.just.disabled = true;
				//document.form1.num.disabled = false;
				document.getElementById('email_data1').checked=false;
				document.getElementById('email_data2').checked=false;
				document.getElementById('email_data3').checked=false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
				document.getElementById('email_tr2').style.display='none';
				document.getElementById('div_num').style.display='';
				$('#num').attr("required",true);
		
		}else{
				document.getElementById('num').disabled = false;
				document.getElementById('just').disabled = false;
				document.getElementById('email_data1').checked=false;
				document.getElementById('email_data2').checked=false;
				document.getElementById('email_data3').checked=false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
				document.getElementById('email_tr2').style.display='none';
				document.getElementById('div_num').style.display='none';
				//document.form1.just.disabled = false;
				//document.form1.num.disabled = false;
		}
}


  

</script>
