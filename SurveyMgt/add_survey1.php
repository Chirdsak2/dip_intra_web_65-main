<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
include("lang_config.php"); 
?>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo $txt_form_add ;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="main_survey.php"><?php echo $txt_form_menu_main;?></a></li>
<li class=""><?php echo $txt_form_add ;?></li>        
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	
<a href="main_survey.php" target="_self">
<button type="button" class="btn btn-info  btn-md " >
<i class="fas fa-undo-alt" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $txt_ewt_back;?>
</button>
</a>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            
			<li><a href="main_survey.php" target="_self" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_ewt_back;?></a></li>
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->
<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<div class="panel panel-default" >
<div class="panel-heading form-inline" ><h4 class=""><?php echo $lang_add_survey;?></h4></div>
<div class="panel-body">

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_survey1')?>" enctype="multipart/form-data" >
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="topic"><?php echo $lang_add_subject ; ?><span class="text-danger">*</span> : </label>
		<textarea   class="form-control" name="topic"  id="topic"  cols="40" rows="5"  required ></textarea>
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="end_page"><?php echo $lang_add_thankyou; ?> : </label>
		<div class="form-inline">
        <input class="form-control" name="end_page" type="text" id="end_page"  style="width:90%" value="" />

		<!--<button type="button" class="btn btn-info  btn-lm " onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&filename=&o_value=window.opener.document.form1.end_page.value','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_add_choosepage; ?>
		</button>-->
		
		<button type="button" class="btn btn-warning  btn-lm " onClick="document.form_main.end_page.value='form_list.php'" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_survey_default_value; ?>
		</button>
		</div>
	  </div>
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?php echo $lang_add_error;?> : </label>
        <textarea   class="form-control" name="error_page"  id="error_page"  cols="40" rows="5" ></textarea>
      </div>
</div>
<div id="experiences">
<div class="form-group row">
	<div class="col-md-12 col-sm-12 col-xs-12">	 
	<label for="file_page1"><?php echo "เอกสารแนบ ";?> : <span onclick="fncaddRow1();"><i class="fa fa-plus-circle" style="color:#53e3a6;cursor: pointer;font-size:24px;"></i></span></label> 
	<div class="form-inline">
	<input class="form-control" name="file_page1" type="text" id="file_page" style="width:90%" value="" />  		
	<button type="button" class="btn btn-info  btn-lm " onClick="win2 = window.open('../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form_main.file_page.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');win2.focus();" >
	<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo "เลือกไฟล์";?>
	</button>		
	</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
	<label for="file_name1"><?php echo 'ชื่อเอกสารแนบ';?> :</label>
	<div class="form-inline">
	<input class="form-control" name="file_name1" type="text" id="file_name1" style="width:90%" value="" />  		
	</div>
	</div>
</div>	  
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="mail_data"><?php echo "emil ตอบกลับ "?> : </label>
		<input class="form-control checkmail" name="mail_data" type="text" id="mail_data" value="" />
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>

<input name="proc" type="hidden" id="proc" value="1">

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_start"><?php echo $lang_edit_start;?><span class="text-danger">*</span> : </label>
            <div class='input-group date datepicker' id='datetimepicker'>
                <input type='text' class="form-control "   name="date_start"  id="date_start" value="" required />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_last"><?php echo $lang_edit_end;?><span class="text-danger">*</span> : </label>
            <div class='input-group date datepicker' id='datetimepicker2'>
                <input type='text' class="form-control "  name="date_last"  id="date_last" value="" required />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>
</div>
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="topic">หมายเหตุ<span class="text-danger">*</span> : </label>
		<textarea   class="form-control" name="s_detail"  id="s_detail"  cols="40" rows="5"  required ></textarea>
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>

</div>
<input type="hidden" id="temp_num1" name="temp_num1" value="1" />
</form>
<div class="panel-footer text-center" >
<span onclick="JQAdd_survey1($('#form_main'));" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_save; ?>" >
		<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?php echo $lang_survey_save; ?>
		</span>
</div>
</div>


</div>
</div>

</div>
<!--END card-body-->
</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<link rel="stylesheet" href="../js/bootstrap-datepicker/css/bootstrap-datepicker.css" />
<link rel="stylesheet" href="../js/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

<script src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../js/bootstrap-datepicker/locales/bootstrap-datepicker.th.min.js"></script>
<script>
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th',
			todayBtn: false,
            thaiyear: true   			
        }).datepicker("setDate", new Date(today.getFullYear()+543, today.getMonth(), today.getDate()));   
});

function fncaddRow1(){
	var run=parseInt($('#temp_num1').val())+parseInt(1);
	var html='';
	html+='<div class="form-group row" id="attact_file'+run+'" >';
    html+='<div class="col-md-12 col-sm-12 col-xs-12">';
    html+='<label for="file_page"><?php echo 'เอกสารแนบ';?> : <span  style="cursor:pointer" onclick="del_row('+run+')"><i class="fa fa-minus-square" style="color:#ff0000;cursor: pointer;font-size:24px;"></i></span></label> ';
	html+='<div class="form-inline">';
	html+='<input class="form-control" name="file_page'+run+'" type="text" id="file_page'+run+'" style="width:90%" value="" />  ';		
	html+='<button type="button" class="btn btn-info  btn-lm" onClick="win2 = window.open(\'../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form_main.file_page'+run+'.value\', \'WebsiteLink\', \'top=100\', \'left=100\', \'width=800\', \'height=500\', \'resizable=1\', \'status=0\'); win2.focus();" >';
	html+='<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo 'เลือกไฟล์';?> ';
	html+='</button> ';		
	html+='</div>';
	html+='</div>';
	html+='<div class="col-md-12 col-sm-12 col-xs-12">';
	html+='<label for="file_name'+run+'"><?php echo 'ชื่อเอกสารแนบ';?> : </label>';
	html+='<div class="form-inline">';
	html+='<input class="form-control" name="file_name'+run+'" type="text" id="file_name'+run+'" style="width:90%" value="" />  ';		
	html+='</div>';
	html+='</div>';
	html+='</div>';

	/*html+='<div class="col-md-12 form-group" id="attact_filename'+run+'" >';
    html+='<label class="col-md-12" style ="padding-left:40px;" for="address">ชื่อเอกสาร</label>';
    html+='<div class="col-md-9" style ="padding-left:40px;"><input type="text" class="form-control" id="txtnamefile'+run+'" name="txtnamefile[]" placeholder=" ชื่อเอกสาร "  /></div>';
	html+='<div class="col-md-2"><input type="text" class="form-control" id="txtnum'+run+'" name="txtnum[]" placeholder=" ลำดับที่ "  value="" onkeyup="fncchkFormatNam(this.id,this.value);"/></div>';
	html+='<div class="col-md-1"><span  style="cursor:pointer" onclick="del_row('+run+')"><i class="fa fa-minus-square" style="color:#ff0000;cursor: pointer;font-size:24px;"></i></span></div>';
    html+='</div>';
	html+='<div class="col-md-12 form-group" id="attact_file'+run+'" >';
    html+='<label class="col-md-12" style ="padding-left:80px;" for="address">อัพโหลดเอกสารแนบ</label>';
    html+='<div class="col-md-12" style ="padding-left:80px;"><input type="file" class="form-control" name="file[]" id="file'+run+'" onchange="fncsizefile(this.id,this.value)" /><p class="text-red3">(ขนาดไฟล์ต้องไม่เกิน 10 MB)</p></div>';
    html+='<div class=""></div>';
	html+='</div>';*/
	
	$("#experiences").append(html);
	$('#temp_num1').val(run);
   
	}
	
function del_row(id){
		//if(confirm('คุณต้องการลบรายการ?')){
		$('#attact_filename'+id).remove();
		$('#attact_file'+id).remove();
		$('#txtnamefile'+id).val('del');
		$('#file'+id).val('del');	
	//}
}	

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

function JQAdd_survey1(form){	

			
/*var topic = $("#topic").val();
var date_start = $("#date_start").val();
var date_last = $("#date_last").val();
var error_page = $("#error_page").val();
var end_page = $("#end_page").val();
var file_page = $("#file_page").val();
var mail_data = $("#mail_data").val();

var proc = $("#proc").val();

if(topic == ""){			
			var Data = 'หัวข้อแบบฟอร์ม';			
			$("#topic").focus();
			$.alert({
						title: 'กรุณากรอกข้อมูล',
						content: Data,
						icon: 'glyphicon glyphicon-exclamation-sign',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});						
			return false;
		}
if(date_start == ""){			
			var Data = 'วันเริ่มต้น';			
			$("#date_start").focus();
			$.alert({
						title: 'กรุณากรอกข้อมูล',
						content: Data,
						icon: 'glyphicon glyphicon-exclamation-sign',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});						
			return false;
		}
if(date_last == ""){			
			var Data = 'วันสิ้นสุด';			
			$("#date_last").focus();
			$.alert({
						title: 'กรุณากรอกข้อมูล',
						content: Data,
						icon: 'glyphicon glyphicon-exclamation-sign',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});						
			return false;
		}

			  $.confirm({
						title: 'เพิ่มแบบฟอร์ม',
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
											url: 'func_add_survey1.php',					
											data:{'topic': topic,
												  'date_start': date_start,
												  'date_last': date_last,
												  'error_page': error_page,
												  'end_page': end_page,
												  'file_page': file_page,
												  'mail_data': mail_data,
												  'proc':proc
												  },
											success: function (data) {
												//alert("Data Save: " + data);
												setTimeout(function(){
													    window.location.href="edit_survey.php?s_id="+ data;
													
												}, 1000);
												//$('#box_popup').fadeOut();
												//location.reload();
												//boxPopup('<?php echo linkboxPopup();?>pop_add_survey2.php');

												$("#frm_edit_s").load(location.href + " #frm_edit_s");
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
                   // });*/
	
$('#topic').val(CKEDITOR.instances.topic.getData());	
$('#s_detail').val(CKEDITOR.instances.s_detail.getData());	
var fail = CKSubmitData(form);
		
 if (fail == false) {
	 
var action  = form.attr('action'); 
//alert(action);
console.log(form.serialize());
  
			 $.confirm({
						title: 'เพิ่มแบบฟอร์ม',
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
												console.log(data);
												//alert("Data Save: " + data);
												//setTimeout(function(){
													    //self.location.href="edit_survey.php?s_id="+ data +"&create=<?php echo url_encode('1');?>";
													
												//}, 1000);
												//$('#box_popup').fadeOut();
												//location.reload();
												boxPopup('<?php echo linkboxPopup();?>pop_add_survey2.php?s_id='+ data);
												
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
<script>
  CKEDITOR.replace('topic', {
  allowedContent: true,
    customConfig: '../../js/ckeditor/custom_config.js'
  });
</script>
<script>
  CKEDITOR.replace('s_detail', {
  allowedContent: true,
    customConfig: '../../js/ckeditor/custom_config.js'
  });

</script>

