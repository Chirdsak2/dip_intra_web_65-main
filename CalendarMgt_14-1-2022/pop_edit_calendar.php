<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$event_id = (int)(!isset($_GET['event_id']) ? 0 : $_GET['event_id']);

$_sql = $db->query("SELECT 
					cal_event.*,
					cal_show_event.event_date_start,
					cal_show_event.event_date_end,
					cal_category.cat_name,
					cal_category.cat_color 
					FROM cal_event 
					INNER JOIN cal_show_event ON (cal_event.event_id = cal_show_event.event_id) 
					INNER JOIN cal_category ON (cal_category.cat_id = cal_event.cat_id)
					WHERE cal_event.event_id = '{$event_id}' ");
$a_data = $db->db_fetch_array($_sql);	
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_edit_calendar')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_calendar">
<input type="hidden" name="event_id" id="event_id"  value="<?=$event_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?=$txt_calendar_edit;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="calendar_title" class="col-sm-12 control-label"><b><?=$txt_calendar_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_calendar_title;?>"  rows="6" id="calendar_title" name="calendar_title"  required="required" ><?=$a_data['event_title'];?></textarea>
</div>
</div>
<div class="form-group row " >
<label for="calendar_detail" class="col-sm-12 control-label"><b><?=$txt_calendar_detail;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_calendar_detail;?>"  rows="6" id="calendar_detail" name="calendar_detail"  required="required" ><?=$a_data['event_detail'];?></textarea>
</div>
</div>

<div class="form-group row " >
<label for="calendar_category" class="col-sm-12 control-label"><b><?=$txt_calendar_cate;?> <span class="text-danger"><code>*</code></span> :</label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<select name="calendar_category" id="calendar_category" class="form-control" required="required">
<option value=""selected="" disabled="disabled"  ><?=$txt_calendar_select_cate;?></option> 
<?php
$_sql_cate = $db->query("SELECT cat_id,cat_name 
FROM cal_category 
WHERE webname_site = '{$_SESSION['EWT_SUSER']}' 
ORDER BY cat_id ASC");
while($a_data_cat = $db->db_fetch_row($_sql_cate)){
	$sel = ($a_data_cat[0] == trim($a_data['cat_id'])) ? "selected":"";
?>
<option value="<?=$a_data_cat[0];?>" <?=$sel;?> ><?=$a_data_cat[1];?></option>
<?php
	}
?>		  
</select>
</div>
</div>

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="event_date_start"><b><?=$txt_calendar_statdate;?><span class="text-danger"><code>*</code></span> : </b></label>
            <div class='input-group date datepicker' id='datetimepicker1'>
                <input readonly type='text' class="form-control " placeholder="<?=$txt_calendar_statdate;?>" name="event_date_start"  id="event_date_start" value="<?=$a_data['event_date_start'];?>" required="required" />
                <span class="input-group-addon ewt-bg-color color-white border-ewt">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="event_date_end"><b><?=$txt_calendar_enddate;?><span class="text-danger"><code>*</code></span> : </b></label>
            <div class='input-group date datepicker' id='datetimepicker2'>
                <input readonly type='text' class="form-control " placeholder="<?=$txt_calendar_enddate;?>"  name="event_date_end"  id="event_date_end" value="<?=$a_data['event_date_end'];?>" required="required" />
                <span class="input-group-addon ewt-bg-color color-white border-ewt">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
	</div>
</div>

<!--<div class="form-group row " >
<label for="event_link" class="col-sm-12 control-label"><b><?=$txt_calendar_attack;?>  :</b></label>
<div class="col-md-10 col-sm-10 col-xs-10 "  >
<input class="form-control" placeholder="<?=$txt_calendar_attack;?>"  name="event_link" id="event_link" type="text" value="<?=$a_data['event_link'];?>" >		
</div>
<div class="col-md-2 col-sm-2 col-xs-2 "  >
<a onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.event_link.value','','width=800 , height=500');" >
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
</button>	
</a>
</div>
</div>-->

<div class="form-group row " >
	<label for="event_relatelink" class="col-sm-12 control-label"><b>เชื่อมโยงบทความหรือ url ที่เกี่ยวข้อง  :</b></label>
	<div class="col-md-10 col-sm-10 col-xs-10" >
		<input type="text" name="event_relatelink" id="event_relatelink" class="form-control" value="<?php echo $a_data['event_relatelink']; ?>">
	</div>
	<div class="col-md-2 col-sm-2 col-xs-2" >
		<a href="#browse" onClick="win2 = window.open('../FileMgt/article_main.php?stype=link&Flag=Link&o_value=window.opener.document.form_main.event_relatelink.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');document.form1.browsefile[0].checked=true;win2.focus();">
		<button type="button" class="btn btn-info  btn-sm " >
		<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
		</button>
		</a>
	</div>
</div>

<div class="form-group row " >
<label for="event_link" class="col-sm-12 control-label"><b><?=$txt_calendar_attack;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input type="file" name="event_link" id="event_link" class="form-control" onchange="JSCheck_file(this.id,this.value);JSCheck_filenameTH(this.id,this.value);" />
<?php
if(!empty($a_data['event_link'])){
?>
<span><?=$a_data['event_link'];?></span><br>
<?php } ?>
<span class="text-danger">
<code>
ประเภทไฟล์ที่สามารถใช้ได้คือ <?=EwtTypefile('file');?>
</code>
</span>
<br>
<span class="text-danger"><code>
ขนาดไฟล์ต้องไม่เกิน <?=EwtMaxfile('file');?> MB.
</code>
</span>
</div>
</div>
<input name="event_link_old" type="hidden" id="event_link_old" value="<?=$a_data['event_link'];?>">

<?php
$_sql_cal_invite = $db->query("SELECT *
					FROM cal_invite 
					WHERE event_id = '{$event_id}' ");
$a_data_invite = $db->db_fetch_array($_sql_cal_invite);	
?>
<div class="form-group row " >
<label for="calendar_contact" class="col-sm-12 control-label"><b><?=$txt_calendar_contact;?>  :</b></label>
<div class="col-md-10 col-sm-10 col-xs-10" >
<a href="#browse" onClick="boxPopup2('<?=linkboxPopup();?>pop_calendar_genuser.php');" >
<input class="form-control" placeholder="<?=$txt_calendar_contact;?>" name="calendar_contact" type="text" id="calendar_contact"  value="<?=cal_contact($a_data_invite['person_id']);?>" />
</a> 
</div>
<div class="col-md-2 col-sm-2 col-xs-2 "  >
<span id="txtshow"></span>
<a href="#browse" onClick="boxPopup2('<?=linkboxPopup();?>pop_calendar_genuser.php');" >
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-folder-open"></i>&nbsp;<?=$txt_calendar_contact;?>
</button>
</a> 
<input name="gen_user_id" type="hidden" id="gen_user_id" value="">
<input name="gen_user_id_old" type="hidden" id="gen_user_id_old" value="<?=$a_data_invite['person_id'];?>">
</div>
</div>
<div id="box_popup2" class="layer-modal"></div>

<div class="form-group row " >
<label for="calendar_location" class="col-sm-12 control-label"><b><?=$txt_calendar_location;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$txt_calendar_location;?>"  rows="6" id="calendar_location" name="calendar_location"  required="required" ><?=$a_data['event_location'];?></textarea>
</div>
</div>


<!--<div class="form-group row " >
<label for="calendar_setregis" class="col-sm-12 control-label"><b><?//=$txt_calendar_setregis ;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
          <label>
			<input onclick="JQCheck_SetRegis($('#calendar_setregis'));"  name="calendar_setregis" id="calendar_setregis" type="checkbox" value="Y" <?php if($a_data['event_registor'] == 'Y'){ echo 'checked';} ?> >
            <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
			<b><?//=$txt_calendar_registor;?></b>
          </label>
</div>
</div>
</div>-->

<div class="form-group row " >
<label for="calendar_setregis" class="col-sm-12 control-label"><b><?=$txt_calendar_setregis ;?>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="radio" <?php if($a_data['event_registor'] != 'Y'){ echo "style=\"display:none;\""; } ?>>
  <label><input type="radio" name="calendar_setregis" id="calendar_setregis" value="Y" <?php if($a_data['event_registor'] == 'Y'){ echo 'checked';} ?>  onclick="JQCheck_SetRegis($('#calendar_setregis'));" /><?=$txt_calendar_registor;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio" <?php if($a_data['event_registor'] != 'M'){ echo "style=\"display:none;\""; } ?> >
  <label><input type="radio" name="calendar_setregis" id="calendar_setregis1"  value="M" <?php if($a_data['event_registor'] == 'M'){ echo 'checked';} ?> onclick="JQCheck_SetRegis($('#calendar_setregis1'));" /><?='ลงทะเบียนจากเว็บอื่น';?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>

<div class="form-group row " <?php if($a_data['event_registor'] != 'Y'){ echo "style=\"display:none;\""; } ?> id="c_num">
<label for="calendar_num" class="col-sm-12 control-label"><b><?=$txt_calendar_num;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control number"  placeholder="<?=$txt_calendar_num;?>" name="calendar_num" type="text" id="calendar_num"  value="<?=$a_data['event_registor_num'];?>"  />
</div>
</div>

<div class="form-group row " <?php if($a_data['event_registor'] != 'M'){ echo "style=\"display:none;\""; } ?> id="c_link">
<label for="calendar_link_to" class="col-sm-12 control-label"><b><?="ลิงค์ลงทะเบียนจากเว็บอื่น";?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control"  placeholder="<?="ลิงค์ลงทะเบียนจากเว็บอื่น";?>" name="calendar_link_to" type="text" id="calendar_link_to"  value="<?=$a_data['event_link_registor'];?>"  />
</div>
</div>

<div class="form-group row " style="display:none;" id="c_form" >
<label for="calendar_form" class="col-sm-12 control-label"><b><?=$txt_calendar_form;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >

</div>
</div>
<?php
if($a_data['event_show_start'] == '0000-00-00'){	
	$event_show_start = '';
}else{	
	$event_show_start = $a_data['event_show_start'];
}
if($a_data['event_show_end'] == '0000-00-00'){	
	$event_show_end = '';
}else{	
	$event_show_end = $a_data['event_show_end'];
}

?>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="start_date"><b><?=$txt_calendar_statdate_show;?> : </b></label>
            <div class='input-group date datepicker' id='txt_calendar_statdate_show'>
                <input readonly type='text' class="form-control " placeholder="<?=$txt_calendar_statdate_show;?>" name="start_date"  id="start_date" value="<?=$event_show_start;?>" >
                <span class="input-group-addon ewt-bg-color color-white border-ewt">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="end_date"><b><?=$txt_calendar_enddate_show;?> : </b></label>
            <div class='input-group date datepicker' id='txt_calendar_enddate_show'>
                <input readonly type='text' class="form-control " placeholder="<?=$txt_calendar_enddate_show;?>"  name="end_date"  id="end_date" value="<?=$event_show_end;?>" >
                <span class="input-group-addon ewt-bg-color color-white border-ewt">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
	</div>
</div>
<!--<div class="form-group row " >
<label for="faq_show" class="col-sm-12 control-label"><b><?=$txt_faq_show;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="radio">
  <label><input type="radio" name="faq_show" value="Y" checked><?=$txt_faq_status_show;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="faq_show" value="N" ><?=$txt_faq_status_notshow;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>

<div class="form-group row " >
<label for="faq_interesting" class="col-sm-12 control-label"><b><?=$txt_faq_interesting ;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
          <label>
			<input  name="faq_interesting" id="faq_interesting" type="checkbox" value="Y" >
            <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
			<?=$txt_faq_showinter;?>
          </label>
</div>
</div>
</div>-->

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Calendar($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>		
<script>  

$(function() {
        $.samaskHtml();
		$('.number').samask("00000");

 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'yyyy-mm-dd',
			todayHighlight: true,
            //language: 'th-th',
			//thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	

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
			
	

$('#txt_calendar_statdate_show').on('changeDate', function() {
		var start_date = $('#start_date').val();
		var end_date   = $('#end_date').val();
		if(end_date != ''){
		if(end_date < start_date){
					$.alert({
						title: 'วันที่เริ่มต้นการแสดงผลที่ปฏิทินกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่เริ่มต้นการแสดงผลที่ปฏิทินกิจกรรมใหม่อีกครั้ง',
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
				
				$('#start_date').val('');		
			}
		}		
	});
	
$('#txt_calendar_enddate_show').on('changeDate', function() {
		var start_date = $('#start_date').val();
		var end_date   = $('#end_date').val();
		
		if(end_date < start_date){
					$.alert({
						title: 'วันที่สิ้นสุดการแสดงผลที่ปฏิทินกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่สิ้นสุดการแสดงผลที่ปฏิทินกิจกรรมใหม่อีกครั้ง',
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
						$('#end_date').val('');		
					}
			});				
});

function JQCheck_SetRegis(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#c_num').show();
		$('#calendar_num').attr("required",true);

		}else{
			$('#c_num').hide();
			$('#calendar_num').attr("required",false);
			
		}	
	console.log(check);
}

function JQEdit_Calendar(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_calendar_edit;?>',
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
												console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														location.reload(true);			
														$('#box_popup').fadeOut();
													}														
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
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
</script>