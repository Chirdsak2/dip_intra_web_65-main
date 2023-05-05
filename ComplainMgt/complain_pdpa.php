<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$com_fid = (int)(!isset($_GET['com_fid']) ? 0 : $_GET['com_fid']);


$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT *
					FROM m_complain_pdpa 
					WHERE pdpa_status = 'Y'
					{$wh} 
					ORDER BY pdpa_pos ASC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(pdpa_id) AS b
			  FROM m_complain_pdpa 
			  WHERE pdpa_status = 'Y'
			  {$wh} ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);

?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo 'ข้อกำหนด PDPA';?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="complain_form.php"><?php echo 'ข้อกำหนด PDPA';?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"> 
<button type="button" class="btn btn-info  btn-ml"  onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_complain_pdpa.php');"  title="<?php echo $txt_complain_add_cate;?>"  target="_self">
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo 'ข้อกำหนด PDPA';?>
</button>  

</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_complain_pdpa.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo 'ข้อกำหนด PDPA';?></a></li>		
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

<div class="card ">
<div class="card-header m-b-sm ewt-bg-color b-t-l-3 b-t-r-3" >
<div class="card-title text-left">
</div>
</div>
<div class="card-body">
<div class="panel-group" id="accordion">
<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($_sql)){
?>	
<div class="panel panel-default " id="<?php echo $a_data['pdpa_id'];?>">
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
				<i class="fas fa-arrows-alt text-info move" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="<?php echo 'Move';?>" ></i>
				<input class="input-inline-sm text-center" name="pdpa_pos[]" id="pdpa_pos<?php echo $a_data['pdpa_pos'];?>"  type="text" value="<?php echo $a_data['pdpa_pos'];?>" readonly />
				
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					<i class="fas fa-comment-dots"></i>
					<?php echo $a_data['pdpa_detail'];?>
					</a>					
                </h4>
            </div>
		
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                   	<div class="m-b-sm"><b><i class="far fa-comment-alt"></i>&nbsp;:&nbsp;<?php echo $a_data['pdpa_detail'];?></b></div>					
					
					<div class="m-b-sm" >
					
			
					</div>
                </div>
				<div class="panel-footer ewt-bg-white text-right">

				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">


<button type="button" class="btn btn-danger  btn-circle  btn-sm " onClick="JQDelete_ComplainForm('<?php echo $a_data['pdpa_id']?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_complain_delete_form;?>" >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
<button type="button" class="btn btn-warning  btn-circle btn-sm"  onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_complain_pdpa.php?pdpa_id=<?php echo $a_data['pdpa_id']?>');"  title="<?php echo $txt_complain_add_cate;?>"  target="_self">
<i class="far fa-edit"></i>&nbsp;
</button>  
				</div>
				</div>
            </div>
        </div>
<?php $i++;} }else{?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php } ?>		
		
</div>

</div>
</div>	
<?php echo pagination_ewt($statement,$perpage,$page,$url='?');?>	
</div>
</div>

</div>
<!--END card-body-->
</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
<!--
.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.drop-placeholder  {
	background-color: rgba(240,243,244,1.0);
	height: 4.0em;
	border: 4px dotted #cccccc !important;
	border-radius: 3px;
	margin-top: 5px!important;
    box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
	-webkit-box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
	-moz-box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
}	
-->
</style>
<script>

$(function  () {

	$("#accordion").sortable({
	placeholder: 'drop-placeholder',
	update: function (event, ui) {									
		var page_id_array = new Array();
			$('#accordion div.panel').each(function(){
				page_id_array.push($(this).attr("id"));
			});	
			console.log(page_id_array);			
									$.ajax({
											type: 'POST',
											url: 'func_sortable_complain_pdpa.php',											
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

function JQDelete_ComplainForm(id){
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
											url: 'func_delete_complain_form.php',
											data:{'id': id,'proc':'DelComF'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'url:text.html',
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
function JQDelete(id){
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'glyphicon glyphicon-exclamation-sign',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_vdo.php',
											data:{'id': id,'proc':'DelVdo'},
											success: function (data) {
												$.alert({
													title: '',
													content: 'url:text.html',
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
                   // });
}

</script>