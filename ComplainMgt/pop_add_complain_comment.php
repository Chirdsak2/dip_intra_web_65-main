<?php
include("../EWT_ADMIN/comtop_pop.php");

$com_id = (int)(!isset($_GET['com_id']) ? 0 : $_GET['com_id']);

$_sql = $db->query("SELECT *					
					FROM m_complain
					WHERE id = '{$com_id}' ");			  
$a_rows = $db->db_num_rows($_sql);		
$a_data = $db->db_fetch_array($_sql);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_complain_comment')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Comment">
<input type="hidden" name="com_id" id="com_id"  value="<?php echo $com_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title  color-white"> <?php echo $txt_complain_comment;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >

<div class="form-group row " >
<label for="comment_topic" class="col-sm-12 control-label"><b><?php echo $txt_complain_title;?> </span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php echo $a_data['topic'];?>
</div>
</div>

<div class="form-group row " >
<label for="complain_detail" class="col-sm-12 control-label"><b><?php echo $txt_complain_detail;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php echo $a_data['detail'];?>
</div>
</div>

<div class="form-group row " >
<label for="complain_name" class="col-sm-12 control-label"><b><?php echo $txt_complain_name;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php 
$name = explode('#@#',$a_data['name']);
echo $name[0]." - ".$name[1];
?>
</div>
</div>
<div class="form-group row " >
<label for="complain_detail" class="col-sm-12 control-label"><b><?php echo $txt_complain_email;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php echo $a_data['email'];?>
</div>
</div>
<div class="form-group row " >
<label for="complain_detail" class="col-sm-12 control-label"><b><?php echo $txt_complain_tel;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php echo $a_data['tel'];?>
</div>
</div>

<div class="form-group row " >
<label for="complain_detail" class="col-sm-12 control-label"><b><?php echo $txt_complain_attack;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php if(!empty($a_data['attach_img'])){ ?>
<a href="../ewt/<?php echo $_SESSION['EWT_SUSER']."/file_attach/".$a_data['attach_img'];?>" data-toggle="tooltip" data-placement="top" title="download" download >
<button type="button" class="btn btn-info btn-circle  btn-ml " >
<i class="fas fa-file-alt"></i> 
</button>

<?php echo $a_data['attach_img'];?>
</a>
<?php } ?>

</div>
</div>

<div class="form-group row " >
<label for="complain_detail" class="col-sm-12 control-label"><b><?php echo "วันที่";?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php echo $a_data['date'];?> <?php echo $a_data['time'];?>
</div>
</div>

<?php if($a_data['c_read'] == 'S'){ ?>
<div class="form-group row " >
<label for="complain_comment" class="col-sm-12 control-label"><b><?php echo $txt_complain_comment;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<textarea class="form-control" placeholder="<?php echo $txt_complain_comment;?>"  rows="6" id="complain_comment" name="complain_comment"  required="required" ></textarea>
</div>
</div>
<?php }else if($a_data['c_read'] == 'M'){ ?> 

<div class="form-group row " >
<label for="complain_comment" class="col-sm-12 control-label"><b><?php echo $txt_complain_comment;?> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<?php echo $a_data['reply'];?>
</div>
</div>

<?php } ?>
</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<?php if($a_data['c_read'] == 'S'){ ?>
<button onclick="JQAdd_Complain_Comment($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>
</button>
<?php }else if($a_data['c_read'] == 'M'){ ?> 

<?php } ?>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
	
<script>  
function JQAdd_Complain_Comment(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo $txt_complain_comment;?>',
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
													content: 'ส่งข้อมูลตอบกลับเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														//self.location.href="complain_builder.php?com_cid=6";	 
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