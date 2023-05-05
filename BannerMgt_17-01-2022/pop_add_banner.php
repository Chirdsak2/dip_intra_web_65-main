<?php
include("../EWT_ADMIN/comtop_pop.php");
include("../language/banner_language.php");

$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);
if(!empty($ban_cid)){ 
$s_banner_g = $db->query("SELECT * FROM banner_group  WHERE  banner_gid = '{$ban_cid}' ");
$a_banner_g = $db->db_fetch_array($s_banner_g);
$topic = $txt_banner_cate." : ".$a_banner_g['banner_name'];
}
?>	
<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_banner')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Banner">
<input type="hidden" name="banner_gid" id="banner_gid"  value="<?=$ban_cid;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?=$txt_banner_add;?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header m-b-sm" >
<div class="card-title text-left"><b><?=$topic;?></b></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="banner_name" class="col-sm-6 control-label"><b><?=$txt_banner_name;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_banner_name;?>" name="banner_name" type="text" id="banner_name"  value="" required="required" />
</div>
</div>
<div class="form-group row " >
<label for="banner_detail" class="col-sm-6 control-label"><b><?=$txt_banner_detail;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?=$$txt_banner_detail;?>"  rows="5" id="banner_detail" name="banner_detail"  ></textarea>
</div>
</div>
<div class="form-group row " >
<label for="banner_category" class="col-sm-12 control-label"><b><?=$txt_banner_cate;?> <span class="text-danger"><code>*</code></span> : <b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<select name="banner_category" id="banner_category" class="form-control" required="required" >
<option value=""selected="" disabled="disabled" ><?=$txt_banner_cate;?></option> 
<?php
$_sql_faq = $db->query("SELECT banner_gid,banner_name
FROM banner_group 
ORDER BY banner_gid ASC ");
while($a_data_faq = $db->db_fetch_row($_sql_faq)){
	$sel = ($a_data_faq[0] == trim($ban_cid)) ? "selected":"";
?>
<option value="<?=$a_data_faq[0];?>" <?=$sel;?> ><?=$a_data_faq[1];?></option>
<?php
	}
?>		  
</select>
</div>
</div>
<!--<div class="form-group row " >
<label for="banner_pic" class="col-sm-6 control-label"><b><?=$txt_banner_image ;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-10 col-sm-10 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_banner_image ;?>"  name="banner_pic" type="text" id="banner_pic"  value="" required="required" />
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
<label for="banner_pic" class="col-sm-12 control-label"><b><?=$txt_banner_image;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input type="file" name="banner_pic" id="banner_pic" placeholder="<?=$txt_banner_image ;?>" class="form-control" onchange="JSCheck_Img(this.id,this.value);" required="required" />
<?php
if(!empty($a_data['banner_pic'])){
?>
<span><?=$a_data['banner_pic'];?></span><br>
<?php } ?>
<span class="text-danger">
<code>
ประเภทไฟล์ที่สามารถใช้ได้คือ <?=EwtTypefile('img');?>
</code>
</span>
<br>
<span class="text-danger"><code>
ขนาดไฟล์ต้องไม่เกิน <?=EwtMaxfile('img');?> MB.
</code>
</span>
</div>
</div>


<div class="form-group row " >
<label for="banner_link" class="col-sm-6 control-label"><b><?=$txt_banner_link;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-7 col-sm-7 col-xs-12" >
<input class="form-control" placeholder="<?=$txt_banner_link;?>" name="banner_link" type="text" id="banner_link"  value="" required="required" />   
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
<select name="banner_traget" id="banner_traget" class="form-control"  >
          <option value="_self"><?php echo $text_genbanner_optionlink1;?></option>
          <option value="_blank"><?php echo $text_genbanner_optionlink2;?></option>
</select>
</div>
</div>
<div class="form-group row " >
<label for="banner_alt" class="col-sm-6 control-label"><b><?php echo $text_genbanner_formalt;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?=$text_genbanner_formalt;?>"  name="banner_alt" type="text" id="banner_alt"  value=""  />
</div>
</div>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="start_date"><b><?="วันที่ในการแสดงผลเริ่มต้น";?> : </b></label>
            <div class='input-group date' id='datetimepicker1'>
                <input type='text' class="form-control datepicker cal" placeholder="<?="วันที่ใช้ในการแสดงผลเริ่มต้น";?>" name="start_date"  id="start_date" value="" >
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
<label for="end_date"><b><?="วันที่ในการแสดงผลสิ้นสุด";?> : </b></label>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control datepicker cal" placeholder="<?="วันที่ใช้ในการแสดงผลสิ้นสุด";?>"  name="end_date"  id="end_date" value="" >
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
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Banner($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
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
<script src="../js/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
<script>  
$(document).ready(function() {
		$('.cal').mask("0000-00-00");
	
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            //format: 'dd/mm/yyyy',
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
});


function JQAdd_Banner(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'เพิ่มแบนเนอร์',
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