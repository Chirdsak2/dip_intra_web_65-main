<?php
include("../EWT_ADMIN/comtop_pop.php");

$org_id = (int)(!isset($_GET['org_id']) ? '' : $_GET['org_id']);
$omc_type = (!isset($_GET['omc_type']) ? '' : $_GET['omc_type']);
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_user_org_chart_list')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_User_Org_Chart">
<input type="hidden" name="org_id" id="org_id"  value="<?=$org_id;?>">
<input type="hidden" name="omc_type" id="omc_type"  value="<?=$omc_type;?>">
<input type="hidden" name="omc_uid" id="omc_uid"  value="<?=$_SESSION['EWT_SUID'];?>">
<div class="container-fluid" >   
<div class="modal-dialog modal-lg"  >

<div class="modal-content ">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6" >
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"> <i class="fas fa-plus-circle"></i> <?=$txt_org_chart_user_add;?></h4>
</div>

<div class="modal-body">
<div class="card ">
<div class="card-header" >
<div class="form-inline  "><b class="text-danger">คำชี้แจง : เลือก</b>
<div class="checkbox">
		<label>
		<input name="1" id="1" type="checkbox" value="0" checked />
        <span class="cr1" ><i class="cr-icon fas fa-check color-ewt"></i></span>
        </label></div><b class="text-danger">รายชื่อบุคคลากรที่ต้องการใช้กับ<?=$txt_org_chart_org_list;?>
 และ เลือก </b> <div class="radio">
		<label>
		<input name="" id="" type="radio" value="" checked />
        <span class="cr1" ><i class="cr-icon fas fa-check color-ewt"></i></span>
        </label></div><b class="text-danger">เลือกหัวหน้าสูงสุด	</b>
</div>
</div>
<div class="scrollbar scrollbar-near-moon thin" style="height:320px;">
<div class="card-body" >


<?php
$db->query("USE ".$EWT_DB_USER);
$s_data = array();
$_sql = $db->query("SELECT *
					FROM org_map_chart 
					WHERE omc_org_id = '{$org_id}' AND omc_uid = '{$_SESSION['EWT_SUID']}' AND omc_type = '{$omc_type}'
					ORDER BY omc_order ASC ");
$a_rows = $db->db_num_rows($_sql);
if($a_rows){	
while($a_data = $db->db_fetch_array($_sql)){
	array_push($s_data,$a_data['omc_name']); 
	}
	
if($a_rows  == count($s_data))
{ 	
	$supcheck = 'checked="checked"';
	}
}
$s_sql_user = $db->query("SELECT *
						  FROM `gen_user`
						  LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		                  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		                  LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		                  WHERE `gen_user`.`org_id` = '{$org_id}' ");	
$a_rows_user  = $db->db_num_rows($s_sql_user);
if($a_rows_user > 0){	

$s_sql_omc  = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$org_id}' AND  omc_uid = '{$_SESSION['EWT_SUID']}' AND omc_type = '{$omc_type}' AND omc_leval = '0'   ");
$a_data_omc	= $db->db_fetch_array($s_sql_omc);	
$genUserTop = $a_data_omc['omc_name'];

?>
<ul id="ditp_tree" class="demo1"  style="width: 100%;">

<li class="expanded " data-value="0" >
<div class="checkbox">&nbsp;&nbsp;
          <label>
			<input name="chk" id="chk"  type="checkbox" value="0" <?=$supcheck;?>  />
            <span class="cr1" ><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b  class="text-dark"> เลือกทั้งหมด</b>
          </label>
</div>
<ul>
<?


$i = 0;
while($_item = $db->db_fetch_array($s_sql_user)){	
	
if($genUserTop == $_item['gen_user_id'])
{
	$s_chk_top	=	'checked="checked"';		
	}else{
		$s_chk_top	=	'';		
	}
	
	
	if($a_rows_sup == $a_rows_user)
	{ 	
		$s_chk = 'checked="checked"';			
		}else{			
			$s_chk = (in_array($_item['gen_user_id'], $s_data))?' checked="checked"':'';
			$s_chk_radio = (in_array($_item['gen_user_id'], $s_data))?' ':'disabled';
			unset($s_data[$_item['gen_user_id']]);  			
			}
			
			
?>
<li class=" m-b-sm m-t-sm" >
<div class="checkbox">
<label>
<input type="checkbox" class="c_cate" <?=$s_chk; ?> onclick="FuncChk('<?php echo $_item['gen_user_id']; ?>');"  id="c_cate<?php echo $_item['gen_user_id']; ?>" name="c_cate[<?php echo $_item['gen_user_id']; ?>]"  value="<?php echo $_item['gen_user_id']; ?>" />
<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>
</label>
</div>
&nbsp;<b class="text-dark"> <?=org::getTitle($_item['title_thai']).''.$_item['name_thai'].' '.$_item['surname_thai'];?></b>
&nbsp;
<div class="radio"  id="radio<?php echo $_item['gen_user_id']; ?>" >
<label  >
<input type="radio" <?=$s_chk_top; ?> <?=$s_chk_radio; ?>  id="c_top<?php echo $_item['gen_user_id']; ?>" name="c_top"  value="<?php echo $_item['gen_user_id']; ?>" required="required"  />
<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>
</label>

</div>
</li>

<?php
$i++;
      }
?>
<label for="c_top" class="error" hidden>เลือกหัวหน้าสูงสุด</label>
</ul>
</li>
</ul>
<?php }else{ 

echo '<div class="text-center" ><b class="label label-danger text-small">'.$txt_ewt_data_not_found.'</b>'; 

 } ?>


</div>
</div>	
</div>
		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<?php if($a_rows_user > 0){ ?>
<button id="btnAdd" disabled onclick="JQAdd_User_Org_Chart_List($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?=$txt_ewt_save;?>
</button>
<?php } ?>
</div>
</div>
</div>

</div>
 
</div>
</div>	 
</form>

<script src="../js/Tree-Generator-jQuery-Bonsai/jquery.qubit.js"></script>
<link href="../js/Tree-Generator-jQuery-Bonsai/jquery.bonsai.css" rel="stylesheet">
<script src="../js/Tree-Generator-jQuery-Bonsai/jquery.bonsai.js"></script>	
<style>
<!--
.radio, .checkbox {
	display: inline-block ;
}
-->
</style>
<script> 
$('#ditp_tree').bonsai({
  expandAll: true,
  checkboxes: true // depends on jquery.qubit plugin
  //createInputs: 'checkbox' // takes values from data-name and data-value, and data-name is inherited
});

$(document).ready( function() {
	$('#chk0').change(function () {
		var name  = $(this).attr('name'); 
		$('input:checkbox[name='+name+']').prop('checked',$(this).prop('checked'));	
		
		if($( this ).is(':checked') == true){
		$('input:checkbox:checked').attr("disabled",true);
		$('#chk0').attr("disabled",false);
			}else if($( this ).is(':checked') == false){
				$('input:checkbox').attr("disabled",false);
			}
		//console.log(v);
	});
	
	$('#chk').change(function () {
		if($( this ).is(':checked') == true){
			$('input:radio').attr("disabled",false);
			$('#btnAdd').attr("disabled",false);
		}else if($( this ).is(':checked') == false){
				$('input:radio[name=c_top]').attr("disabled",true);
			    $('#btnAdd').attr("disabled",true);
			}
	});
});

function FuncChk(ID){
	var len = $('input:checkbox[class=c_cate]:checked').length;	
	if (len == '0'){
			$('#btnAdd').attr("disabled",true);
	}else{
		$('#btnAdd').attr("disabled",false);
	}

	if($('#c_cate'+ID).is(':checked') == true){	
			$('#c_top'+ID).attr("disabled",false);
		}else if($( '#c_cate'+ID ).is(':checked') == false){
			$('#c_top'+ID).attr("disabled",true);
		}
	
	}

function JQAdd_User_Org_Chart_List(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?=$txt_org_chart_user_add;?>',
						content: '<?=$txt_ewt_confirm_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?=$txt_ewt_confirm_submit;?>',
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
													content: '<?=$txt_ewt_action_alert;?>',
													boxWidth: '30%',
													onAction: function () {
														document.location.reload();
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
									text: '<?=$txt_ewt_cancel;?>',
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