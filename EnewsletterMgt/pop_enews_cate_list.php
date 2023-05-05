<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");

$m_id = (int)(!isset($_GET['m_id']) ? 0 : $_GET['m_id']);


$Sel = "SELECT * FROM article_group ORDER  BY c_name asc";
$_sql = $db->query($Sel);				
?>

<form id="form_main" name="form_main" method="POST" action="pop_enews_cate_function.php" enctype="multipart/form-data" >
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?=$txt_enews_menu_cate;?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >
<div class="form-group row" >
	<div class="col-md-12 col-sm-12 col-xs-12">
		<table width="100%" align="center" class="table table-bordered">
			<form name="form1" method="post" action="pop_enews_cate_function.php">
				<?php
				$i = 0;
				while($R = $db->db_fetch_array($_sql)){
				$sqlx = $db->query("SELECT * FROM n_group WHERE g_name='".$R["c_id"]."'");
				$row = $db->db_num_rows($sqlx);?>
				<tr bgcolor="<?php //if($row > 0){ echo "#5bc0de"; }else{ echo "#FFFFFF"; } ?>" >
				  <td width="10%" style="text-align:left" > 
							<div class="checkbox">&nbsp;&nbsp;
							<label>
							<input type="checkbox" id="chk<?php echo $i; ?>" name="chk<?php echo $i; ?>"  value="Y" <?php  if($row > 0){ echo "checked"; } ?> />
							<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b> <?php echo $R['c_name']; ?></b>
							</label>
							</div>
							<input type="hidden" name="c_id<?php echo $i; ?>" id="c_id<?php echo $i; ?>"  value="<?php echo $R['c_id'];?>">
				  </td>
				</tr>
				<?php 
				$i++;
				}?>
				
				<input type="hidden" name="all" id="all"  value="<?=$i;?>">
			</form>
		</table>

</div>

</div>

</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQEdit_Enews_Article_Group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>
	
<script>  
function JQEdit_Enews_Article_Group(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_enews_setting_enews;?>',
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