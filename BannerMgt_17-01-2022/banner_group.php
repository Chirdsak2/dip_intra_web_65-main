<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");


$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
$data = $_REQUEST['data'];
 if (!empty($data)) {
			  $wh = " where banner_name like '%{$data}%' ";
}

$sel = "SELECT * FROM banner_group {$wh} order by banner_gid";

$perpage = 12;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * FROM banner_group {$wh} ORDER BY banner_cate_order ASC,banner_gid DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(banner_gid) AS b
			  FROM banner_group {$wh} ";
$a_rows = $db->db_num_rows($_sql);				
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = ceil($total_record / $perpage);

?>


<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<h4><?php echo $txt_banner_cate;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="banner_group.php"><?php echo $txt_banner_cate;?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_banner_group.php?ban_cid=<?php echo $ban_cid;?>');">
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_banner_add_cate;?>
</button>

<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_banner.php?ban_cid=<?php echo $ban_cid;?>');">
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_banner_add;?>
</button>

<button type="button" class="btn btn-info  btn-ml " onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_banner.php');" >
<i class="fas fa-search"></i>&nbsp;<?php echo "ค้นหาแบนเนอร์";?>
</button>

</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_banner_group.php?ban_cid=<?php echo $ban_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_banner_cate;?></a></li>
			<li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_banner.php?ban_cid=<?php echo $ban_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_banner_add;?></a></li>          	
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<!--<div class="table-responsive">	  
<table width="100%" border="0"  align="center" class="table table-bordered" >
<thead>
<tr class="success">
<th width="10%" ></th>  
<th class="text-center">กลุ่มป้ายโฆษณา</th>
</tr>
</thead>
<tbody>
<?php 
//$a_rows = $db->db_num_rows($s_article);
//if($a_rows > 0){
///while($a_banner = $db->db_fetch_array($s_article)){
	
								//$sql_count = "SELECT count(*) as num FROM banner where banner_gid ='{$a_banner['banner_gid']}' order by banner_id";
								//$rec = $db->db_fetch_array($db->query($sql_count));
?>
<tr >
<td  class="text-center">
<a href="banner_list.php?gid=<?//=$a_banner['banner_gid'];?>" data-toggle="tooltip" data-placement="right" title="<?//="ดูข้อมูลรายการ";?>">
<button type="button" class="btn btn-success btn-circle  btn-xs " >
<i class="fa fa-th-list" aria-hidden="true"></i>
</button>
</a> 
<a onClick="boxPopup('<?//=linkboxPopup();?>pop_edit_banner_group.php?gid=<?//=$a_banner['banner_gid'];?>');" data-toggle="tooltip" data-placement="right" title="<?//=$text_genbanner_altedit;?>">
<button type="button" class="btn btn-warning  btn-circle  btn-xs " >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a>
<a href="" onClick="if(confirm('<?//=$text_genbanner_confirm_del;?>'))location.href = 'banner_gprocess.php?flag=del&banner_id=<?//=$a_banner['banner_gid']?>'; " data-toggle="tooltip" data-placement="right" title="<?//=$text_genbanner_altdel;?>">
<button type="button" class="btn btn-danger  btn-circle  btn-xs " >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>
</td>
<td >
<a href="banner_list.php?gid=<?//=$a_banner['banner_gid'];?>"><?//=$a_banner['banner_name'];?>(<?php //echo $rec['num'];?>)</a>
</td>
</tr>
<?php // }
		//} 
?>
<?php //if($a_rows > 0){ ?>

<?php //}else{?>
<tr> 
<td colspan="2" class="text-center"><p class="text-danger"><?//=$text_general_notfound;?></p></td>
</tr>
<?php //}?>
		</tbody>
		</table>
		</div>-->
	
<div class="card">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">

<div class="title" ><i class="fas fa-hashtag"></i> <?php echo $txt_banner_cate;?></div>
</div>
</div>
<div class="card-body">

<ul id="sortableLv1" class="sortableLv1 " style="width: 100%;">
<?php
if($a_rows > 0){
while($a_data = $db->db_fetch_array($_sql)){	

$_sql_banner = $db->query("SELECT * FROM banner WHERE banner_gid = '{$a_data['banner_gid']}' ");
$a_rows_banner = $db->db_num_rows($_sql_banner);

?>
<input type="hidden" name="category_id" id="category_id"  value="<?php echo $a_data['banner_gid'];?>" >
<li class="productCategoryLevel1 move" id="<?php echo $a_data['banner_gid'];?>">
&nbsp;
<span class="">
<i class="fa fa-ellipsis-v text-medium text-dark"></i>
</span>

<input class="input-inline-sm text-center" name="category_order[]" id="category_order<?php echo $a_data['banner_cate_order'];?>"  type="text" value="<?php echo $a_data['banner_cate_order'];?>" readonly />
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?php echo $a_data['banner_cate_order'];?>" value="<?php echo $a_data['banner_cate_order'];?>">

<i class="fas fa-folder text-medium text-dark"></i>
<b style="word-break: break-all;"><?php echo $a_data['banner_name'];?> </b>
<span class="iconAction">
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_banner_group.php?ban_cid=<?php echo $a_data['banner_gid'];?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $txt_banner_edit_cate;?>">
<i class="fa fa-edit  text-medium text-dark pointer" aria-hidden="true"></i>
</a>
&nbsp;
<!--<i class="far fa-eye fa-1x text-dark" title="Disable"></i>
<input type="hidden" name="hiddenProductCategoryLevel1ID[]" value="2363">
<input type="hidden" name="hiddenStatus[]" value="1">
&nbsp;-->
<?php
if(empty($a_rows_banner)){ 
?>
<a  onClick="JQDel_Banner_Cate('<?php echo $a_data['banner_gid'];?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $txt_banner_del_cate;?>">
<i class="fas fa-trash-alt  text-medium text-dark pointer" aria-hidden="true"></i>
</a>
<?php }else{  ?>
<i class="fas fa-trash-alt  text-medium" style="color:#CCCC;" aria-hidden="true"></i>

<?php } ?>
&nbsp;
<a href="banner_list.php?ban_cid=<?php echo $a_data['banner_gid'];?>" data-toggle="tooltip" data-placement="right" title="<?php echo $txt_banner_list;?>">
<i class="fa fa-th-list  text-medium text-dark" aria-hidden="true"></i>
</a>
&nbsp;
</span>
</li>
<?php } }else{?>	
<li class="productCategoryLevel1" >
<p class="text-danger text-center"><?php echo $text_general_notfound;?></p>
</li>
		
<?php } ?>
</ul>	

</div>
</div>
	
		
		
</div>
</div>
</div>
<!--END card-BODY -->

</div>
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>

<div id="data_sample"></div>

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
				url: 'func_sortable_banner_group.php',											
				data:{proc:'Sortable_Edit',page_id_array:page_id_array},
				success: function (data) {	
					//$("#data_sample").html(data);											
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


function JQDel_Banner_Cate(id){
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
											type: 'POST',
											url: 'func_delete_banner_cate.php',
											data:{'id': id,'proc':'DelBanCate'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'ลบข้อมูลเรียบร้อย',
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
</script>