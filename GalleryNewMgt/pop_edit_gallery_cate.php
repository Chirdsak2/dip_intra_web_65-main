<?php
include("../EWT_ADMIN/comtop_pop.php");

$sql_de = $db->query("SELECT * FROM gallery_category WHERE category_id = '{$_GET['c_id']}' ORDER BY category_parent_id ASC");
$num_de = $db->db_num_rows($sql_de);

$sql_group = $db->query("SELECT * FROM gallery_category ORDER BY category_parent_id ASC");
$num_group = $db->db_num_rows($sql_group);
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_edit_gallery_cate')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Gallery_cate">
<input type="hidden" name="c_id" id="c_id"  value="<?php echo $_GET['c_id'];?>">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title">แก้ไขหมวดห้องภาพ</h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >
<?php if($num_de > 0){?>
<?php $DE = $db->db_fetch_array($sql_de);
	?>
<div class="form-group row " >
<label for="gal_cat_title" class="col-sm-12 control-label"><b>ชื่อหมวดหมู่<span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class = "form-control" type="text" value="<?php echo $DE['category_name']?>" id="gal_cat_title" name="gal_cat_title" required="required">
</div>
</div>

<div class="form-group row " >
<label for="gal_cat_detail" class="col-sm-12 control-label"><b>รายละเอียด</span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control"  rows="6" id="gal_cat_detail" name="gal_cat_detail"><?php echo $DE['category_detail']?></textarea>
</div>
</div>

<!--<div class="form-group row " >
<label for="gal_cat" class="col-sm-12 control-label"><b>ตำแหน่งภายใต้หมวด <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<select name="gal_cat" id="gal_cat" class="form-control">
<option value="" selected="">หมวดหลัก</option> 
<?php if($num_group > 0){?>
<?php while($group = $db->db_fetch_array($sql_group)){?>
<?php if($DE['parent_id'] == $group['category_id']){$pi = "selected";}else{$pi = "";}?>
<option value="<?=$group['category_id'];?>" <?php echo $pi;?>><?=$group['category_name'];?></option>
<?php } ?>
<?php } ?>
</select>
</div>
</div>

<label class="col-sm-12 control-label"><b>การแสดงผล คอลัมน์*แถว :</b></label>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
    <input class = "form-control" type = "number" value = "<?php echo $DE['col']?>" id= "gal_cat_col" name = "gal_cat_col" min = "0">
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
     <input class = "form-control" type = "number" value = "<?php echo $DE['row']?>" id= "gal_cat_row" name = "gal_cat_row" min = "0">
</div>
</div>

<label class="col-sm-12 control-label"><b>กำหนดขนาดภาพเล็ก :</b></label>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
    <input class = "form-control" type = "number" value = "<?php echo $DE['height_s']?>" id= "gal_cat_smh" name = "gal_cat_smh" min = "0">
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
     <input class = "form-control" type = "number" value = "<?php echo $DE['width_s']?>" id= "gal_cat_smw" name = "gal_cat_smw" min = "0">
</div>
</div>

<label class="col-sm-12 control-label"><b>กำหนดขนาดภาพใหญ่ :</b></label>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
    <input class = "form-control" type = "number" value = "<?php echo $DE['height_b']?>" id= "gal_cat_lgh" name = "gal_cat_lgh" min = "0">
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
     <input class = "form-control" type = "number" value = "<?php echo $DE['width_b']?>" id= "gal_cat_lgw" name = "gal_cat_lgw" min = "0">
</div>
</div>-->

<div class="form-group row " >
<label for="gal_cat_allow" class="col-sm-12 control-label"><b>การอนุญาติ :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="checkbox">
	<?php if($DE['category_vote']=="1"){$ch_v = "checked";}else{$ch_v = "";}?>
  <label><input type="checkbox" name="gal_cat_allow_vote" value="1" <?php echo $ch_v;?>>อนุญาตให้มีการ Vote
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="checkbox">
	<?php if($DE['category_send']=="1"){$ch_s = "checked";}else{$ch_s = "";}?>
  <label><input type="checkbox" name="gal_cat_allow_send" value="1" <?php echo $ch_s;?>>อนุญาตให้มีการส่งต่อให้เพื่อน
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="checkbox">
	<?php if($DE['category_comment']=="1"){$ch_m = "checked";}else{$ch_m = "";}?>
  <label><input type="checkbox" name="gal_cat_allow_ment" value="1" <?php echo $ch_m;?>>อนุญาตให้มีการ Comment
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>

<?php } ?>
</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Gallery_cate($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save ;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
	
<script>  

$(document).ready(function() {
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
});

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_sub').attr("disabled",false);
		}else{
			$('#category_sub').attr("disabled",true);
		}	
	console.log(check);
}
 
function JQEdit_Gallery_cate(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?='';?>',
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
												//var cdata= JSON.stringify(eval("("+data+")"));
												//var jsonObject = jQuery.parseJSON(cdata);
												//console.log(jsonObject);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														
														//self.location.href="poll_builder.php?c_id="+jsonObject;	
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

</script>
