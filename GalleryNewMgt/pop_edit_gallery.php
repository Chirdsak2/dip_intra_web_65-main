<?php
include("../EWT_ADMIN/comtop_pop.php");
$sql_de = $db->query("SELECT gallery_image.* FROM gallery_image LEFT JOIN gallery_cat_img ON gallery_cat_img.img_id = gallery_image.img_id WHERE category_id= '".$_GET['c_id']."' and gallery_image.img_id = '".$_GET['id']."'");
$num_de = $db->db_num_rows($sql_de);
//$a_img =  $db->db_fetch_array($sql_de);

$sql_group = $db->query("SELECT * FROM gallery_category WHERE category_id = '".$_GET['c_id']."' ORDER BY category_parent_id ASC");
$num_G = $db->db_num_rows($sql_group);
?>
<script>
//document.getElementById('radio_1').style.display = 'none';
//document.getElementById("radio_2").style.display = 'none';
function radio_hs($id){
	if($id == "1"){
		document.getElementById('radio_1').style.display = '';
		document.getElementById("radio_2").style.display='none';
	}else if($id == "2"){
		document.getElementById('radio_1').style.display = 'none';
		document.getElementById("radio_2").style.display='';
	}
}
</script>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_edit_gallery')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Edit_Gallery">
<input type="hidden" name="id" id="id"  value="<?php echo $_GET['id'];?>">
<input type="hidden" name="img_path_old" id="img_path_old"  value="<?//=$a_img['img_path_b'];?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title">แก้ไขรูปภาพ</h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >

<?php if($num_de > 0){?>
<?php while($DE = $db->db_fetch_array($sql_de)){?>

<div class="form-group row " >
<label for="gal_title" class="col-sm-12 control-label"><b>ชื่อภาพ<span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class = "form-control" type = "text" value = "<?php echo $DE['img_name'];?>" id= "gal_title" name = "gal_title">
</div>
</div>

<div class="form-group row " >
<label for="gal_detail" class="col-sm-12 control-label"><b>รายละเอียด</span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control"  rows="6" id="gal_detail" name="gal_detail"><?php echo $DE['img_detail'];?></textarea>
</div>
</div>

<div class="form-group row " >
<label for="gal_src" class="col-sm-12 control-label"><b>รูปภาพ<span class="text-danger"><code>*</code></span> : </b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >

<div>
<label>ไฟล์เดิม : </label>
<button type="button" class="btn btn-default  btn-circle  btn-sm " onClick="window.open('../ewt/otcc_web/<?php echo $DE['img_path_b'];?>','','width=800 , height=500');" data-toggle="tooltip" data-placement="top" title="ไฟล์เดิม" >
<i class="fas fa-search" aria-hidden="true"></i>
</div>

<div class="radio">
  <label><input type="radio" name="gal_src" value="com" onclick="radio_hs(2);" checked>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>ภาพจากคอมพิวเตอร์
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="gal_src" value="sys" onclick="radio_hs(1);"  />
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>ภาพจากระบบ
  </label>
</div>

</div>
</div>

<div class="form-group row " id="radio_1" style="display:none;">
<label for="gal_src" class="col-sm-12 control-label"><b>ภาพจากระบบ<span class="text-danger"><code>*</code></span> : </b></label>
<div class="col-md-11 col-sm-11 col-xs-11" >
<input class = "form-control" type = "text" placeholder = "ภาพจากระบบ" id="pic_sys" name="pic_sys">
</div>
<div class="col-md-1 col-sm-1 col-xs-1" >
<button type="button" class="btn btn-default  btn-circle  btn-sm " onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.pic_sys.value','','width=800 , height=500');" data-toggle="tooltip" data-placement="top" title="ไฟล์เดิม" >
<i class="far fa-folder-open" aria-hidden="true"></i>
<!--<img src="images/folder_img.gif" height="20" width="20" align="absmiddle" alt="เลือกภาพ" style="cursor:hand" onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.pic_sys.value','','width=800 , height=500');">-->
</div>
</div>


<div class="form-group row " id="radio_2"  >
<label for="gal_src" class="col-sm-12 control-label"><b>ภาพจากคอมพิวเตอร์<span class="text-danger"><code>*</code></span> : </b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class = "form-control" type = "file" placeholder = "ภาพจากคอมพิวเตอร์" id= "pic_com" name = "pic_com">
</div>
</div>

<div class="form-group row " >
<label for="gal_cat" class="col-sm-12 control-label"><b>หมวด <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
	<?php 
	if($num_G > 0){
		while($G = $db->db_fetch_array($sql_group)){
			echo $G['category_name'];
		}
	}
	?>
</div>
</div>


<?php } ?>
<?php } ?>
</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Gallery($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save ;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
<?php
	if($_POST['gal_src']=="sys" AND $_POST['pic_sys']!==" "){
		$img = "pic_sys";
	}else if($_POST['gal_src']=="com" AND $_POST['pic_sys']!==" "){
		$img = "pic_com";
	}
?>	
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
 
function JQEdit_Gallery(form){	

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
