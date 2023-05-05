<?php
include("../EWT_ADMIN/comtop_pop.php");

$m_id = (int)(!isset($_GET['m_id']) ? 0 : $_GET['m_id']);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_item_menu')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_ITEM">
<input type="hidden" name="m_id" id="m_id"  value="<?php echo $m_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title  color-white"><i class="fas fa-plus-circle"></i> <?php echo $txt_menu_item_add;?></h4>
</div>

<div class="modal-body">

<div class="card ">

<div class="card-body" >


<!--<div class="form-group row " >
<label for="menu_title" class="col-sm-12 control-label"><b><?php echo $txt_menu_add_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_menu_add_title;?>" name="menu_title" type="text" id="menu_title"  value="" required="required" />
</div>
</div>-->

<div class="form-group row "> 
<div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mb-3">
<label for="menu_show"><b><?php echo $txt_menu_status;?> </b></label> :  
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="menu_show" id="menu_show" <?php if($a_data['mp_show'] == 'Y' || $a_data['mp_show'] == ''){ echo 'checked="checked"'; } ?> />
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>
<!--<div class="form-group row " >
<label for="menu_title" class="col-sm-12 control-label"><b><?php echo $txt_menu_add_title;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<input class="form-control" placeholder="<?php echo $txt_menu_add_title;?>" name="menu_title" type="text" id="menu_title"  value="" required="required" />
</div>
</div>-->
<div class="form-group row "> 
<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
<label for="menu_title"><b><?php echo 'Text Title Item';?></b></label><span class="text-danger " ><code>&#42;</code></span> :
<textarea class="form-control" placeholder="<?php echo 'Text Title Item';?>"  rows="3" id="menu_title" name="menu_title"  required="required" ></textarea>
<div class="valid-feedback">    
</div>
</div>
</div>

<div class="form-group row " >
<label for="menu_link" class="col-sm-12 control-label"><b><?php echo $txt_menu_add_link;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-10 col-sm-10 col-xs-10" >
<input class="form-control" placeholder="<?php echo $txt_menu_add_link;?>" name="menu_link" type="text" id="menu_link"  value="" required="required" />
</div>
<div class="col-md-2 col-sm-2 col-xs-12" >
<a onClick="window.open('../FileMgt/article_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.menu_link.value','','width=800 , height=500');" >
<button type="button" class="btn btn-info  btn-sm " >
<i class="far fa-folder-open"></i>&nbsp;เลือกไฟล์
</button> 
</a>
</div>
</div>

<div class="form-group row "><!--
<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
	
<label for="item_align" class="col-sm-12 control-label"><b><?php echo 'Text alignment';?></b> : </label> 
<div class="btn-group btn-group-lg" > 
  <a href="#" class="btn btn-info choosealign active" data-value="left"  data-toggle="tooltip" data-placement="top" title="<?php echo 'left';?>"><i class="fas fa-align-left"></i></a>
  <a href="#" class="btn btn-info choosealign " data-value="center"  data-toggle="tooltip" data-placement="top" title="<?php echo 'center';?>"><i class="fas fa-align-center"></i></a>
  <a href="#" class="btn btn-info choosealign" data-value="right"  data-toggle="tooltip" data-placement="top" title="<?php echo 'right';?>"><i class="fas fa-align-right"></i></a>
</div>
<input type="hidden" name="item_align" id="item_align"  value="" >	
</div>
<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
<label for="item_formatting" class="col-sm-12 control-label"><b><?php echo 'Text formatting';?></b> : </label> 
<div class="btn-group btn-group-lg" >
  <a href="#" class="btn btn-info chooseformat " data-value="bold"  data-toggle="tooltip" data-placement="top" title="<?php echo 'bold';?>"><i class="fas fa-bold"></i></a>
  <a href="#" class="btn btn-info chooseformat" data-value="italic"  data-toggle="tooltip" data-placement="top" title="<?php echo 'italic';?>"><i class="fas fa-italic"></i></a>
  <a href="#" class="btn btn-info chooseformat" data-value="underline"  data-toggle="tooltip" data-placement="top" title="<?php echo 'underline';?>"><i class="fas fa-underline"></i></a>
</div>


<input type="hidden" name="item_bold" id="item_bold"  value="">	
<input type="hidden" name="item_italic" id="item_italic"  value="">
<input type="hidden" name="item_underline" id="item_underline"  value="">	

</div>
 -->

<div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 mb-3">
<label for="item_traget" class="col-sm-12 control-label"><b>ลักษณะการเชื่อมต่อ</b> <span class="text-danger " ><code>&#42;</code></span> : </label> 
<select name="item_traget" id="item_traget" class="form-control" required="required"  >
	<option value="_self"><b>เปิดหน้าต่างเดิม</b></option>
	<option value="_blank"><b>เปิดหน้าต่างใหม่</b></option>
</select>
</div>


</div>


<div class="form-group row">
<!-- <label for="menu_icon" class="col-sm-12 control-label"><b><?php echo $txt_menu_add_icon;?> <span class="text-danger"></span> :</b></label> -->
<!--<div class="btn-group">
                            <button type="button" class="btn ewt-bg-color color-white border-ewt iconpicker-component"><i
                                    class="fa" id="icon_fa"></i></button>
                            <button type="button" class="icp icp-dd btn ewt-bg-color color-white border-ewt dropdown-toggle"
                                    data-selected="fa-car" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu"></div>
                        </div>-->
<!-- <div class="">						
<div class="btn-group  btn-group-lg">
<button class="btn btn-info  color-white " data-placement="right" id="icp-dd"  type="button" ></button> 				
</div>
<input type="hidden" name="menu_icon" id="menu_icon"  value="">		
</div> -->

<!--<div class="form-group row " >
<label for="menu_show" class="col-sm-12 control-label"><b><?php echo $txt_faq_show;?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="radio">
  <label><input type="radio" name="menu_show" value="Y" checked><?php echo $txt_faq_status_show;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
<div class="radio">
  <label><input type="radio" name="menu_show" value="N" ><?php echo $txt_faq_status_notshow;?>
  <span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
  </label>
</div>
</div>
</div>-->


<!-- <div class="form-group row " style="margin-top:20px;">
	<div class="col-md-12 col-sm-12 col-xs-12" >
		<label>
			<b>แสดง Pop-up ก่อนไปยังหน้าปลายทาง:</b>
		</label>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12" >
		<div class="checkbox">
			<label>
				<input id="popup_use" name="popup_use" type="checkbox" value="Y"> ใช้งาน
				<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
			</label>
		</div>
	</div>
</div> -->

<div class="form-group row popup_section" hidden>
	<div class="col-md-12 col-sm-12 col-xs-12" >
		<div>
			<label for="popup_info"><b>ข้อมูล Pop-up: </b></label>   
		</div>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">     
			<textarea type="text" class="form-control" placeholder="" id="popup_info" name="popup_info" 
			></textarea>
		</div>
		<script>
			CKEDITOR.replace('popup_info', {
				allowedContent: true,
				customConfig: '../../js/ckeditor/custom_config.js',
				on: {
					change: function( evt ) {
						var newContent = this.getData()				
						document.getElementById('popup_info').value = newContent;
					}
				}
			});
		</script>	
	</div>
</div>

</div>
</div>	

		
<div class="modal-footer "> 
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_Menu_Item($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save ;?>
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
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	

	$("#popup_use").click(function(){
		if($(this).is(':checked')==true){
			$(".popup_section").prop("hidden",false);
		}
		else{
			$(".popup_section").prop("hidden",true);
		}
	})
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

 $(function () {
	 $('#icp-dd').iconpicker();
		$('#icp-dd').on('change', function(e) {
			//console.log(e.icon);
			$('#menu_icon').val(e.icon);	
		});
	 
      /*$('.icp-dd').iconpicker({
        //title: 'Dropdown with picker',
        //component:'.btn > i'
		
      });*/
	  
	var ChoAlign = $('.btn.choosealign').hasClass( 'active' );
	if(ChoAlign == true)
	{
		$('#item_align').val($('.btn.choosealign.active').data( 'value' ));			
		}			
	$('.btn.choosealign').click(function( e ) {		
			var rEl = $( this );			
			var Act    = $('.btn.choosealign').hasClass( 'active' );
			if(Act == true)
			{
			$('.btn.choosealign').removeClass( 'active' );
				}		
		    rEl.each( function() 
			{			
				$( this ).attr("data-id", rEl.data( 'value' )).addClass( 'active' );
				//console.log( rEl );
				$('#item_align').val(rEl.data( 'value' ));				
				});		
		});	
	/*$('.btn.chooseformat').click(function( e ) {		
			var rEl = $( this );
			var Act    = $('.btn.chooseformat').hasClass( 'active' );
			if(Act == true)
			{
			$('.btn.chooseformat').removeClass( 'active' );
				}		
		    rEl.each( function() 
			{			
				$( this ).attr("data-id", rEl.data( 'value' )).addClass( 'active' );
				//console.log( rEl.data( 'value' ) );				
				$('#item_formatting').val(rEl.data( 'value' ));
				});		
		});	*/
	$('.btn.chooseformat').click(function( e ) {		
			var rEl = $( this );			
		    rEl.each( function() 
			{				
				$( this ).attr("data-id", rEl.data( 'value' )).toggleClass('active');				
				var Act  = $( this ).attr("data-id", rEl.data( 'value' )).hasClass( 'active' );
				if(Act == true)
				{			
				$('#item_'+rEl.data( 'value' )).val(rEl.data( 'value' ));
					}else{
					$('#item_'+rEl.data( 'value' )).val('');	
					}
				});		
		});			 
	  
	  
});

function JQAdd_Menu_Item(form){	
//var vcal = $('#icon_fa').attr("class");
		//$('#menu_icon').val(vcal);
		//alert(vcal);
var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 
//console.log(form.serialize());  
 
			 $.confirm({
						title: '<?php echo "เพิ่มเมนูย่อย";?>',
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
												//console.log(data);
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