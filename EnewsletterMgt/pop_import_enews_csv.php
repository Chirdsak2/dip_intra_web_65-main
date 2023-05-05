<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");


$Sel = "SELECT * FROM article_group ORDER  BY c_id";
$_sql = $db->query($Sel);				
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('pop_import_enews_csv_function')?>" enctype="multipart/form-data" >
<div class="container" >   
<div class="modal-dialog modal-lg" >
<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?=$txt_enews_import_enews;?></h4>
</div>

<div class="modal-body">
	<div class="card ">
		<div class="scrollbar scrollbar-near-moon thin">
			<div class="card-header ewt-bg-success m-b-sm" >
				<div class="card-title text-left"><b></b></div>
			</div>
			<div class="card-body" >
				<div class="form-group row ">
					<label for="enews_file">Import File CSV <span class="text-danger">*</span> : </label>	
					<div class="col-md-12 col-sm-12 col-xs-12" >		
						<input name="enews_file" id="enews_file" type="file" class="form-control file_upload"  accept="text/csv" onchange="JSCheck_CSV(this.id,this.value);" required />
						<input type="hidden" name="proc" id="proc" value="import_csv">
					</div>
				</div>
			</div>
		</div>	
	</div>
	<div class="modal-footer ">
		<div class="col-md-12 col-sm-12 col-xs-12 text-center">
			<button onclick="JQImport_Enews($('#form_main'));" type="button" class="btn btn-success  btn-ml " ><i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
			</button>
		</div>
	</div>
</div>

</div>
 
</div>
</div>	 
</form>
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>	
<script>  
function JQImport_Enews(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 
			 $.confirm({
						title: '<?=$txt_enews_import_enews;?>',
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
											data: formData,
											async: true,
											processData: false,
											contentType: false,
											success: function (data) {	
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														document.location.reload();
														$('#box_popup').fadeOut();
													}													
												});
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}
</script>