<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$faq_cid = (int)(!isset($_GET['faq_cid']) ? 0 : $_GET['faq_cid']);

function faq_parent($faq_id){
	 global $db,$EWT_DB_NAME;
	 $s_parent = $db->query("SELECT * FROM faq_category WHERE faq_cate_id = '{$faq_id}' ");	
	 if($db->db_num_rows($s_parent)){
		 $a_parent = $db->db_fetch_array($s_parent);							
			//$txt = "<li class=\"breadcrumb-item active\">".$a_parent['c_name']."</li>";					
			$txt = "<li class=\"active\" aria-current=\"page\"> <a href = \"faq_subgroup.php?faq_cid=".$a_parent["faq_cate_id"]."\">".$a_parent['faq_cate_title']."</a></li>";			
			if($a_parent['faq_cate_parent'] != "0" AND $a_parent['faq_cate_parent'] != ""){				
				$txt = faq_parent($a_parent['faq_cate_parent']).$txt;				
			}			
	 	}		
		return $txt;
}
function faq_category($faq_id){
	 global $db,$EWT_DB_NAME;
	 $s_category = $db->query("SELECT * FROM faq_category WHERE faq_cate_id = '{$faq_id}' ");	
	 if($db->db_num_rows($s_category)){
		$a_category = $db->db_fetch_array($s_category);											
		$a_data = $a_category['faq_cate_title'];
			
	 	}		
		return $a_data;
}
function faqsub_back($faq_id){
	global $db,$EWT_DB_NAME;
	 $s_category = $db->query("SELECT * FROM faq_category WHERE faq_cate_id = '{$faq_id}' ");
	 $a_category = $db->db_fetch_array($s_category);
	 if($a_category['faq_cate_parent'] == "0"){		 
	 $a_data = "faq_group.php"; 
	 }else{		 
		 $a_data = "faq_subgroup.php?faq_cid=".$a_category['faq_cate_parent'];
	 }
return $a_data;	 
}
?> 

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?='FAQ Sub-category';?></h4>
<p></p> 

</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="faq_dashboard.php"><?=$txt_faq_menu_main;?></a></li>
<li><a href="faq_group.php"><?=$txt_faq_cate;?></a></li> 
<?=faq_parent($faq_cid);?>   
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_faq_group.php?faq_cid=<?=$faq_cid;?>');" title="<?=$txt_faq_cate_add;?>"  target="_self">
<button type="button" class="btn btn-info  btn-sm">
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_faq_cate_add;?>
</button>
</a>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_faq.php?faq_cid=<?=$faq_cid;?>');"  title="<?=$txt_faq_add;?>"  target="_self">
<button type="button" class="btn btn-info  btn-sm">
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_faq_add;?>
</button>
</a>
<a  target="_self" onclick="boxPopup('<?=linkboxPopup();?>pop_search_faq.php');" title="<?=$txt_faq_search;?>">
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-search"></i>&nbsp;<?=$txt_faq_search;?>
</button>
</a>
<a href="<?=faqsub_back($faq_cid);?>" onClick="" target="_self" title="<?=$txt_ewt_back;?>">
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_faq_group.php?faq_cid=<?=$faq_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_faq_cate_add;?></a></li>
			<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_faq.php?faq_cid=<?=$faq_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_faq_add;?></a></li>
			<li><a href="<?=faqsub_back($faq_cid);?>" ><i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?></a></li>        	
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->


<?php

$perpage = 12;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * FROM faq_category WHERE faq_cate_status = 'Y' AND faq_cate_parent = '{$faq_cid}'  {$wh} ORDER BY faq_cate_id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(faq_cate_id) AS b
			  FROM faq_category {$wh} ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
?>
<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<div class="" id="frm_edit_s">	
<div id="frm_load">  	  
<?php
/*
?>
<table width="100%" class="table table-bordered" >
<thead>
<tr class="success">
<th width="20%" ></th>  
<th class="text-center">หมวดย่อย FAQ</th>
</tr>
</thead>
<tbody>
<?php
if($a_rows > 0){
while($a_data = $db->db_fetch_array($_sql)){	
?>
<input type="hidden" name="category_id" id="category_id"  value="<?=$a_data['faq_cate_id'];?>" >
<tr >
<td class="text-center">
<a href="faq_list.php?faq_cid=<?=$a_data['faq_cate_id'];?>" data-toggle="tooltip" data-placement="right" title="<?="ดูข้อมูลรายการ FAQ";?>">
<button type="button" class="btn btn-success btn-circle  btn-xs " >
<i class="fa fa-th-list" aria-hidden="true"></i>
</button>
</a>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_faq_group.php?faq_cid=<?=$a_data['faq_cate_id'];?>');" data-toggle="tooltip" data-placement="right" title="<?=$text_genbanner_altedit;?>">
<button type="button" class="btn btn-warning  btn-circle  btn-xs " >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a>
<a href="" onClick="JQDel_Faq_Cate($('#category_id'));" data-toggle="tooltip" data-placement="right" title="">
<button type="button" class="btn btn-danger  btn-circle  btn-xs " >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>
<a href="faq_subgroup.php?faq_cid=<?=$a_data['faq_cate_id'];?>" data-toggle="tooltip" data-placement="right" title="<?="หมวดย่อย FAQ";?>">
<button type="button" class="btn btn-info  btn-circle  btn-xs " >
<i class="fas fa-folder-plus" aria-hidden="true"></i>
</button>
</a>
</td>
<td class="text-left"><i class="fas fa-folder" aria-hidden="true"></i> <?=$a_data['faq_cate_title'];?></td>
</tr >
<?php } }else{?>
<tr >
<td colspan="2" class="text-center"><p class="text-danger"><?=$text_general_notfound;?></p></td>
</tr >
<?php } ?>
</tbody>
</table>
<?php*/
?>

<div class="card">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">
<div class="title" ><i class="fas fa-hashtag"></i> <?="FAQ Category&nbsp;:&nbsp;".faq_category($faq_cid);?> </div>
</div>
</div>
<div class="card-body">

<ul id="sortableLv1" class="sortableLv1 " style="width: 100%;">
<?php
if($a_rows > 0){
while($a_data = $db->db_fetch_array($_sql)){	
?>
<input type="hidden" name="category_id" id="category_id"  value="<?=$a_data['faq_cate_id'];?>" >
<li class="productCategoryLevel1" id="<?=$a_data['faq_cate_id'];?>">
&nbsp;
<span class="">
<i class="fa fa-ellipsis-v text-medium text-dark"></i>
</span>

<input class="input-inline-sm text-center" name="category_order[]" id="category_order<?=$a_data['faq_cate_order'];?>"  type="text" value="<?=$a_data['faq_cate_order'];?>" readonly />
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?=$a_data['faq_cate_order'];?>" value="<?=$a_data['faq_cate_id'];?>">

<i class="fas fa-folder text-medium text-dark"></i>
<b style="word-break: break-all;"><?=$a_data['faq_cate_title'];?> </b>
<span class="iconAction">
<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_faq_group.php?faq_cid=<?=$a_data['faq_cate_id'];?>');" >
<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?="Edit FAQ Category";?>"   >
<i class="fa fa-edit  text-dark  pointer" aria-hidden="true"></i>
</button>
</a>
<!--<i class="far fa-eye fa-1x text-dark" title="Disable"></i>
<input type="hidden" name="hiddenProductCategoryLevel1ID[]" value="2363">
<input type="hidden" name="hiddenStatus[]" value="1">
&nbsp;-->
<a onClick="JQDel_Faq_Cate('<?=$a_data['faq_cate_id'];?>');" >
<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?="Delete FAQ Category";?>"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>
<a href="faq_list.php?faq_cid=<?=$a_data['faq_cate_id'];?>" >
<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?="ดูข้อมูลรายการ FAQ";?>"   >
<i class="fa fa-th-list  text-dark" aria-hidden="true"></i>
</button>
</a>
<a href="faq_subgroup.php?faq_cid=<?=$a_data['faq_cate_id'];?>" >
<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?="หมวดย่อย FAQ";?>"   >
<i class="fas fa-folder-plus text-dark" aria-hidden="true"></i>
</button>
</a>

<!--<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_faq_group.php?faq_cid=<?=$a_data['faq_cate_id'];?>');" data-toggle="tooltip" data-placement="right" title="<?="Edit FAQ Category";?>">
<i class="fa fa-edit  text-medium text-dark" aria-hidden="true"></i>
</a>
&nbsp;
<i class="far fa-eye fa-1x text-dark" title="Disable"></i>
<input type="hidden" name="hiddenProductCategoryLevel1ID[]" value="2363">
<input type="hidden" name="hiddenStatus[]" value="1">
&nbsp;
<a href="" onClick="JQDel_Faq_Cate($('#category_id'));" data-toggle="tooltip" data-placement="right" title="<?="Delete FAQ Category";?>">
<i class="fas fa-trash-alt  text-medium text-dark" aria-hidden="true"></i>
</a>
&nbsp;
<a href="faq_list.php?faq_cid=<?=$a_data['faq_cate_id'];?>" data-toggle="tooltip" data-placement="right" title="<?="ดูข้อมูลรายการ FAQ";?>">
<i class="fa fa-th-list  text-medium text-dark" aria-hidden="true"></i>
</a>
&nbsp;
<a href="faq_subgroup.php?faq_cid=<?=$a_data['faq_cate_id'];?>" data-toggle="tooltip" data-placement="right" title="<?="หมวดย่อย FAQ";?>">
<i class="fas fa-folder-plus text-medium text-dark" aria-hidden="true"></i>
</a>-->
</span>
</li>
<?php } }else{?>	
<li class="productCategoryLevel1" >
<p class="text-danger text-center"><?=$text_general_notfound;?></p>
</li>
		
<?php } ?>
</ul>	

</div>
</div>
</div>
	
</div>			
</div>
</div>

</div>
<!--END card-body -->
</div>
<!--END card -->

</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<style>

.input-inline-sm{
	height: 30px;
    padding: 5px 10px;
    line-height: 1.5;
    border-radius: 3px;
	width: 3.5em;
	word-break: break-all;	
	color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
	transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    display: inline-block;	
}
.sortableLv1 {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 100%;
}
.sortableLv1 li {
    margin: 0 3px 3px 3px;
    padding: 0.6em;
    padding-left: 1.5em;
    font-size: 1em;
    background: none;
    cursor: -moz-grab;
    cursor: -webkit-grab;
    cursor: grab;
	
}
.sortableLv1 li span {
    position: absolute;
    margin-left: -1.3em;
	margin-top: 5px;
}
.productCategoryLevel1, .productCategoryLevel3 {
    position: relative;
    border: 1px solid #d3d3d3 !important;
    background: #fff !important;
    border-radius: 3px;
}

.iconAction {
    position: absolute;
    margin-top: 5px;
    right: 15px;
}

.sortableLv2 {
    list-style-type: none;
    margin-top: 5px;
    margin-left: -30px;
    width: 100%;
}
.sortableLv2 li {
    margin: 0 3px 3px 3px;
    padding: 0.4em;
    padding-left: 1.5em;
    font-size: 1em;
    margin-right: -37px;
    cursor: -moz-grab;
    cursor: -webkit-grab;
    cursor: grab;
}
.productCategoryLevel2 {
    position: relative;
    border: 1px solid #e5e5e5 !important;
    background: #f6f3f3 !important;
    border-radius: 3px;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
@media only screen and (min-width: 200px) and (max-width: 480px){
.sortableLv1 li span {
    position: relative;
    margin-left: -1.3em;
	margin-top: 5px;
	display:inline-block;	
}
.iconAction {
    position: absolute;
    padding-left: 30px;
	display: inline-block;	
}

}
</style>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>

<script>
$(function  () {

	$("#sortableLv1").sortable({
	placeholder: 'drop-placeholder',
	update: function (event, ui) {									
		var page_id_array = new Array();
			$('#sortableLv1 li').each(function(){
				page_id_array.push($(this).attr("id"));
			});		
			console.log(page_id_array);			
									$.ajax({
											type: 'POST',
											url: 'func_sortable_faq_group.php',											
											data:{proc:'Sortable_Edit',page_id_array:page_id_array},
											success: function (data) {												
												console.log(data);	
												location.reload(true);																							
												//$("#frm_edit_s").load(location.href + " #frm_load");												
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												//document.location.reload();
											}
										});	
										
		}		
	});
});


function JQDel_Faq_Cate(id){
	
	$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_faq_q.php',
											data:{'id': id,'proc':'Del_Faq_Cate'},
											success: function (data) {
												$.alert({
													title: 'ลบข้อมูลเรียบร้อย',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: 'ตกลง',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
}


function JQAdd_faq_group(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?="เพิ่มหมวด FAQ";?>',
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

function JQEdit_faq_group(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?="แก้ไขหมวด FAQ";?>',
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
											 try
												{
												var cdata= JSON.stringify(eval("("+data+")"));
												var jsonObject = jQuery.parseJSON(cdata);												
											console.log(cdata);	
											$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														$('#box_popup').fadeOut();
														if(jsonObject.faq_cate_parent == '0'){
															self.location.href="faq_group.php";																													
														}else{	
															self.location.href="faq_subgroup.php?faq_cid="+jsonObject.faq_cate_parent;	
														}													
													}																					
												});
												
												//$("#frm_edit_s").load(location.href + "frm_edit_s");
												//alert("Data Save: " + location.href);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												//document.location.reload();
												//window.location.reload();												
											}									
											catch(e){
												}															
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