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

$s_id = $_GET['s_id'];

$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '{$s_id}' ");
$PR = $db->db_fetch_array($SQL1);

$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";
$fp1 = @fopen($Path_true."/form_topic_".$s_id.".html", "r");
//if(!$fp1){ die("Cannot write form_topic_".$s_id.".html"); }
while($html1 = @fgets($fp1, 1024)){
	$topic .= $html1;
}
@fclose($fp1);

$fp2 = @fopen($Path_true."/form_det_".$s_id.".html", "r");
//if(!$fp2){ die("Cannot write form_det_".$s_id.".html"); }
while($html2 = @fgets($fp2, 1024)){
	$s_detail .= $html2;
}
@fclose($fp2);
?>
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_s')?>" enctype="multipart/form-data" >
<div class="container" > 
<div class="modal-dialog modal-lg"  >
<div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
          <h4 class="modal-title"></h4>
        </div>

<div class="modal-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" >

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
<b>แก้ไขส่วนหัวข้อ</b>
</div>
</div>

<div class="card-body" >

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="name"><b><?php echo "หัวข้อแบบสำรวจ";?><span class="text-danger">*</span> : </b></label>
<textarea   class="form-control" name="name"  id="name"  cols="40" rows="5" required="required" ><?php echo $topic; ?></textarea>
</div>
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="end_page"><?php echo $lang_add_thankyou; ?> : </label>
		<div class="form-inline">
        <input class="form-control" name="end_page" type="text" id="end_page"  style="width:80%" value="<?php echo $PR['end_page'];?>" />

		<!--<button type="button" class="btn btn-info  btn-lm " onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&filename=&o_value=window.opener.document.form1.end_page.value','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_add_choosepage; ?>
		</button>-->
		
		<button type="button" class="btn btn-warning  btn-lm " onClick="document.form_main.end_page.value='form_list.php'" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_survey_default_value; ?>
		</button>
		</div>
	  </div>
</div>
<div id= "experiences">
<?php
$file = explode(";",$PR['file_page']);
$file_name = explode(";",$PR['s_file_name']);
for($i = 0;$i<count($file);$i++){
	if($i==0){
?>
<div class="form-group row">
	<div class="col-md-12 col-sm-12 col-xs-12">	 
	<label for="file_page"><?php echo "เอกสารแนบ ";?> : <span onclick="fncaddRow1();"><i class="fa fa-plus-circle" style="color:#53e3a6;cursor: pointer;font-size:24px;"></i></span></label> 
	<div class="form-inline">
	<input class="form-control" name="file_page<?php echo $i;?>" type="text" id="file_page<?php echo $i;?>" style="width:80%" value="<?php echo $file[$i]; ?>"   />  	
	<button type="button" class="btn btn-info  btn-lm " onClick="win2 = window.open('../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form_main.file_page<?php echo $i;?>.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');win2.focus();	" >
	<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo "เลือกไฟล์";?>
	</button>
	</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
	<label for="file_name<?php echo $i;?>"><?php echo 'ชื่อเอกสารแนบ';?> :</label>
	<div class="form-inline">
	<input class="form-control" name="file_name<?php echo $i;?>" type="text" id="file_name<?php echo $i;?>" style="width:80%" value="<?php echo $file_name[$i]; ?>" />  		
	</div>
	</div>
</div>
<?php }else{ ?>
<div class="form-group row">
	<div class="col-md-12 col-sm-12 col-xs-12" id="attact_file<?php echo $i;?>" >	 
	<label for="file_page<?php echo $i;?>"><?php echo "เอกสารแนบ ";?> : <span style="cursor:pointer" onclick="del_row('<?php echo $i;?>')"><i class="fa fa-minus-square" style="color:#ff0000;cursor: pointer;font-size:24px;"></i></span></label> 
	<div class="form-inline">
	<input class="form-control" name="file_page<?php echo $i;?>" type="text" id="file_page<?php echo $i;?>" style="width:80%" value="<?php echo $file[$i]; ?>"   />  		
	<button type="button" class="btn btn-info  btn-lm " onClick="win2 = window.open('../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form_main.file_page<?php echo $i;?>.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');win2.focus();	" >
	<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo "เลือกไฟล์";?>
	</button>
	</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
	<label for="file_name<?php echo $i;?>"><?php echo 'ชื่อเอกสารแนบ';?> :</label>
	<div class="form-inline">
	<input class="form-control" name="file_name<?php echo $i;?>" type="text" id="file_name<?php echo $i;?>" style="width:80%" value="<?php echo $file_name[$i]; ?>" /> 	
	</div>
	</div>
</div>
<?php } } ?>	
</div>
<input type="hidden" id="temp_num1" name="temp_num1" value="<?php if(count($file) == ""){ echo '1'; }else{ echo count($file); }?>" />
<div class="form-group row">
<div class="col-md-3 col-sm-3 col-xs-12">
<label for="des"><b><?php echo "ตำแหน่ง";?><span class="text-danger">*</span> : </b></label>
<input class="form-control numberint" name="des"  id="des"  value="<?php echo $PR['s_pos'];?>" required="required" />
</div>
</div>
<?php
	$DDT = explode("-",$PR['s_start']);
	$EDT = explode("-",$PR['s_end']);
?>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_start"><?php echo $lang_edit_start;?><span class="text-danger">*</span> : </label>
            <div class='input-group date datepicker' id='datetimepicker'>
                <input type='text' class="form-control "   name="date_start"  id="date_start" value="<?php echo $DDT[2]."/".$DDT[1]."/".$DDT[0]; ?>" required />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_last"><?php echo $lang_edit_end;?><span class="text-danger">*</span> : </label>
            <div class='input-group date datepicker' id='datetimepicker2'>
                <input type='text' class="form-control "  name="date_last"  id="date_last" value="<?php echo $EDT[2]."/".$EDT[1]."/".$EDT[0]; ?>" required />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>
</div>
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="topic">หมายเหตุ<span class="text-danger">*</span> : </label>
		<textarea   class="form-control" name="s_detail"  id="s_detail"  cols="40" rows="5"  required ><?php echo $s_detail;?></textarea>
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>
<input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id;?>" />
<input name="proc" type="hidden" id="proc" value="P" />
</div>
</div>
</div>
</form>
<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<button onclick="JQEdit_s($('#form_main'));" type="button" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_save; ?>" >
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
        });   


$('.numberint').keypress(function (event) {
            return isNumberInt(event, this)
      });
	  
  });

function fncaddRow1(){
	var run=parseInt($('#temp_num1').val())+parseInt(1);
	var html='';
	html+='<div class="form-group row" id="attact_file'+run+'" >';
    html+='<div class="col-md-12 col-sm-12 col-xs-12">';
    html+='<label for="file_page'+run+'"><?php echo 'เอกสารแนบ';?> : <span  style="cursor:pointer" onclick="del_row('+run+')"><i class="fa fa-minus-square" style="color:#ff0000;cursor: pointer;font-size:24px;"></i></span></label> ';
	html+='<div class="form-inline">';
	html+='<input class="form-control" name="file_page'+run+'" type="text" id="file_page'+run+'" style="width:80%" value="" />  ';		
	html+='<button type="button" class="btn btn-info  btn-lm" onClick="win2 = window.open(\'../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form_main.file_page'+run+'.value\', \'WebsiteLink\', \'top=100\', \'left=100\', \'width=800\', \'height=500\', \'resizable=1\', \'status=0\'); win2.focus();" >';
	html+='<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo 'เลือกไฟล์';?> ';
	html+='</button> ';		
	html+='</div>';
	html+='</div>';
	html+='<div class="col-md-12 col-sm-12 col-xs-12">';
	html+='<label for="file_name'+run+'"><?php echo 'ชื่อเอกสารแนบ';?> : </label>';
	html+='<div class="form-inline">';
	html+='<input class="form-control" name="file_name'+run+'" type="text" id="file_name'+run+'" style="width:80%" value="" />  ';		
	html+='</div>';
	html+='</div>';
	html+='</div>';

	$("#experiences").append(html);
	$('#temp_num1').val(run);
   
	}
	
function del_row(id){
		//if(confirm('คุณต้องการลบรายการ?')){
		$('#attact_file'+id).remove();
		//$('#file_page'+id).val('del');
	//}
}	


function JQEdit_s(form){	
$('#name').val(CKEDITOR.instances.name.getData());	
$('#s_detail').val(CKEDITOR.instances.s_detail.getData());	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
console.log(form.serialize());	



var s_id = $("#s_id").val();
var name = $("#name").val();
var des = $("#des").val();
var proc = $("#proc").val();

// alert(name);
					$.confirm({
						title: 'แก้ไขส่วนหัวข้อ',
						content: 'คุณต้องการบันทึกการแก้ไขนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการแก้ไข',
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
<?php @$db->db_close(); ?>

<script>
  CKEDITOR.replace('name', {
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