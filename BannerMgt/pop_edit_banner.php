<?php
include("../EWT_ADMIN/comtop_pop.php");
include("../language/banner_language.php");


$ban_id = (int)(!isset($_GET['ban_id']) ? 0 : $_GET['ban_id']);
$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);

if(!empty($ban_cid)){ 
$s_banner_g = $db->query("SELECT * FROM banner_group  WHERE  banner_gid = '{$ban_cid}' ");
$a_banner_g = $db->db_fetch_array($s_banner_g);
$topic = $txt_banner_cate." : ".$a_banner_g['banner_name'];
}

$s_banner = $db->query("SELECT * FROM banner  WHERE  banner_id = '{$ban_id}' ");
$a_banner = $db->db_fetch_array($s_banner);

?>	
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_banner')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Banner">
<input type="hidden" name="banner_gid" id="banner_gid"  value="<?php echo $ban_cid;?>">
<input type="hidden" name="banner_id" id="banner_id"  value="<?php echo $ban_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?php echo $text_genbanner_formedit;?></h4>
</div>

<div class="modal-body">
<div class="card ">

<div class="card-header m-b-sm" >
<div class="card-title text-left"><b><?php echo $topic;?></b></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="banner_name" class="col-sm-6 control-label"><b><?php echo $text_genbanner_formname;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $text_genbanner_formname;?>" name="banner_name" type="text" id="banner_name"  value="<?php echo $a_banner['banner_name'];?>" >
</div>
</div>
<!-- ซ่อนไว้ก่อน <div class="form-group row " >
<label for="banner_detail" class="col-sm-6 control-label"><b><?php echo $text_genbanner_formdetail;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" > 
<textarea class="form-control" placeholder="<?php echo $text_genbanner_formdetail;?>"  rows="5" id="banner_detail" name="banner_detail"  ><?php echo $a_banner['banner_detail'];?></textarea>
</div>
</div> -->
<!--<div class="form-group row " >
<label for="banner_pic" class="col-sm-6 control-label"><b><?php echo $text_genbanner_formpic;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-10 col-sm-10 col-xs-12" >
<input class="form-control" placeholder="<?php echo $text_genbanner_formpic;?>"  name="banner_pic" type="text" id="banner_pic"  value="<?php echo $a_banner['banner_pic'];?>" >
</div>
<div class="col-md-2 col-sm-2 col-xs-12" >
<a onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.banner_pic.value','','width=800 , height=500');" >
<button type="button" class="btn btn-info  btn-sm " >
<i class="far fa-folder-open"></i>&nbsp;เลือกไฟล์
</button>
</a>
<!--<img src="images/folder_closed.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_formlink2;?>" style="cursor:hand" onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.banner_link.value','','width=800 , height=500');"> -> 
</div>
</div>-->
<div class="form-group row " >
<label for="banner_pic" class="col-sm-12 control-label"><b><?php echo $txt_banner_image;?> <span class="text-danger"><code>*</code></span>  :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input type="file" name="banner_pic" id="banner_pic" placeholder="<?php echo $txt_banner_image ;?>" class="form-control" onchange="JSCheck_Img_vdo(this.id,this.value);" <?php if(empty($a_banner['banner_pic'])){ echo 'required="required"'; } ?> />
<?php
if(!empty($a_banner['banner_pic'])){
?>
<span><code><?php echo $a_banner['banner_pic'];?></code></span><br>
<?php } ?>
<span class="text-danger">
<code>
ประเภทไฟล์ที่สามารถใช้ได้คือ jpg,gif,png,jpeg,mp4<!-- <?php echo EwtTypefile('img');?> -->
</code>
</span>
<br>
<span class="text-danger"><code>
ขนาดไฟล์ต้องไม่เกิน <?php echo EwtMaxfile('img');?> MB.
</code>
</span>
<span class="text-danger"><code>
ขนาดที่เหมาะสม กว้าง <?php echo $a_banner_g["banner_w"] ?> x ยาว <?php echo $a_banner_g["banner_h"];?> Pixel
</code>
</span>
</div>
</div>
<input name="banner_pic_old" type="hidden" id="banner_pic_old" value="<?php echo $a_banner['banner_pic'];?>">

<div class="form-group row " >
<label for="banner_link" class="col-sm-12 control-label"><b><?php echo $text_genbanner_formlink;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-7 col-sm-7 col-xs-12" >
<input class="form-control" placeholder="<?php echo $text_genbanner_formlink;?>" name="banner_link" type="text" id="banner_link"  value="<?php echo $a_banner['banner_link'];?>" >   
</div>
<div class="col-md-2 col-sm-2 col-xs-12" >
<a onClick="window.open('../FileMgt/article_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.banner_link.value','','width=800 , height=500');" >
<button type="button" class="btn btn-info  btn-sm " >
<i class="far fa-folder-open"></i>&nbsp;เลือกไฟล์
</button>
</a>
<!--<img src="images/folder_closed.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_formlink2;?>" style="cursor:hand" onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.banner_link.value','','width=800 , height=500');"> --> 
</div>
<div class="col-md-3 col-sm-3 col-xs-12" >
<select name="banner_traget" id="banner_traget" class="form-control "  >
<option value="_self"<?php if($a_banner['banner_traget']=='_self') echo ' selected="selected"'; ?>><?php echo $text_genbanner_optionlink1;?></option>
<option value="_blank"<?php if($a_banner['banner_traget']=='_blank') echo ' selected="selected"'; ?>><?php echo $text_genbanner_optionlink2;?></option>
</select>
</div>
</div>
<div class="form-group row " >
<label for="banner_alt" class="col-sm-6 control-label"><b><?php echo $text_genbanner_formalt;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $text_genbanner_formalt;?>"  name="banner_alt" type="text" id="banner_alt"  value="<?php echo $a_banner['banner_alt'];?>" >
</div>
</div>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="start_date"><b><?php echo "วันที่ในการแสดงผลเริ่มต้น";?> : </b></label>
            <div class='input-group date datepicker' id='datetimepicker1'>
                <input type='text' class="form-control cal" placeholder="<?php echo "วันที่ใช้ในการแสดงผลเริ่มต้น";?>" name="start_date"  id="start_date" value="<?php echo $a_banner['banner_show_start'];?>" >
                <span class="input-group-addon">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
			<span class="text-danger"><code>
Ex. 2019-01-01 
</code>
</span>
</div>

<div class="col-md-6 col-sm-6 col-xs-12">
<label for="end_date"><b><?php echo "วันที่ในการแสดงผลสิ้นสุด";?> : </b></label>
            <div class='input-group date datepicker' id='datetimepicker2'>
                <input type='text' class="form-control cal" placeholder="<?php echo "วันที่ใช้ในการแสดงผลสิ้นสุด";?>"  name="end_date"  id="end_date" value="<?php echo $a_banner['banner_show_end'];?>" >
                <span class="input-group-addon">
                    <i class="far fa-calendar-alt"></i>
                </span>
            </div>
			<span class="text-danger"><code>
Ex. 2019-01-01 
</code>
</span>
</div>
</div>


</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Banner($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>
</button>
</div>
</div>
</div>
 </div>
 
</div>
</div>	 
</form>	
<!-- Custom js -->
<script type="text/javascript" src="<?php echo $IMG_PATH;?>assets/js/custom.js"></script>
<script src="../js/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
<script>  
$(document).ready(function() {
		$('.cal').mask("0000-00-00"); 
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            //format: 'dd/mm/yyyy',
            //language: 'th-th',
			//thaiyear: true,
			format: 'yyyy-mm-dd',
			todayHighlight: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString()); 

$('#datetimepicker1').on('changeDate', function() {
		var event_date_start = $('#start_date').val();
		var event_date_end = $('#end_date').val();
		
		if(event_date_end != ''){
		if(event_date_end < event_date_start){
					$.alert({
						title: 'วันที่ในการแสดงผลเริ่มต้น  ไม่ถูกต้อง',
						content: 'กรุณาเลือก วันที่ในการแสดงผลเริ่มต้น ใหม่อีกครั้ง',
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
		var event_date_start = $('#start_date').val();
		var event_date_end = $('#end_date').val();
		
		if(event_date_end < event_date_start){
					$.alert({
						title: 'วันที่ในการแสดงผลสิ้นสุด ไม่ถูกต้อง',
						content: 'กรุณาเลือก วันที่ในการแสดงผลสิ้นสุด ใหม่อีกครั้ง',
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
function JQEdit_Banner(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'แก้ไขแบนเนอร์',
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
									$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}
</script>