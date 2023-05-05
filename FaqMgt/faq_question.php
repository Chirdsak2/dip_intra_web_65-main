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
<h4><?php echo $txt_faq_q;?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="faq_dashboard.php"><?php echo $txt_faq_menu_main;?></a></li>
<li><?php echo $txt_faq_q;?></li>     
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a  target="_self" onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_faq.php');" >
<button type="button" class="btn btn-info  btn-md " >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_faq_search;?>
</button>
</a>
<!--<a href="faq_dashboard.php" onClick="" target="_self"  >
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?>
</button>
</a>-->
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
           <li><a onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_faq.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_faq_search;?></a></li>
          <li><a href="faq_dashboard.php" ><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?></a></li>	
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

$_sql = $db->query("SELECT * FROM faq WHERE faq_use = 'A' {$wh} ORDER BY fa_id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(fa_id) AS b
			  FROM faq 
			  WHERE faq_use = 'A' {$wh} ";
			  
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

<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">
<div class="title" ><i class="fas fa-hashtag"></i> <?php echo $txt_faq_q;?></div>
</div>
</div>
<div class="card-body">

<div class="panel-group" id="accordion">
<?php
$i = 0;
if($a_rows > 0){
while($a_data = $db->db_fetch_array($_sql)){	
?>
        <div class="panel panel-default ">
            <div class="panel-heading ">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					<i class="far fa-question-circle"></i>
					<?php echo $a_data['fa_name'];?>
					</a>					
                </h4>
            </div>
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                  <?php echo $a_data['fa_detail'];?> 
                </div>
				<div class="panel-footer ewt-bg-white text-right">
				<!--<a onClick="boxPopup('<?//=linkboxPopup();?>pop_edit_faq_group.php?fa_id=<?php echo $a_data['fa_id'];?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $text_genbanner_altedit;?>">
				<i class="far fa-edit" aria-hidden="true"></i>
				</a>
				<a href="" onClick="" data-toggle="tooltip" data-placement="right" title="">
				<i class="far fa-trash-alt" aria-hidden="true"></i>
				</a>-->
				<a onClick="JQDel_Faq_Q('<?php echo $a_data['fa_id'];?>');">
				<button type="button" class="btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo 'ลบ FAQ'?>"   >
				<i class="far fa-trash-alt" aria-hidden="true"></i>
				</button>
				</a>
				<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_faq_q.php?fa_id=<?php echo $a_data['fa_id'];?>&faq_cid=<?php echo $faq_cid;?>');">
				<button type="button" class="btn btn-warning  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo 'แก้ไข FAQ'?>"   >
				<i class="fa fa-edit  pointer" aria-hidden="true"></i>
				</button>
				</a>
				<!--<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
					<a onClick="JQDel_Faq_Q('<?php echo $a_data['fa_id'];?>');" class="ewt-icon ewt-icon-del text-dark" data-toggle="tooltip" data-placement="right" title="<?php echo 'ลบ FAQ'?>"></a>
					<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_faq_q.php?fa_id=<?php echo $a_data['fa_id'];?>&faq_cid=<?php echo $faq_cid;?>');" class="ewt-icon ewt-icon-edit text-dark" data-toggle="tooltip" data-placement="right" title="<?php echo 'แก้ไข FAQ'?>" ></a>
					<a href="#set-1" class="ewt-icon ewt-icon-view text-dark" data-toggle="tooltip" data-placement="right" title="<?php echo 'แสดงผล FAQ'?>" ></a>
				</div>-->
				</div>
            </div>
        </div>
<?php  $i++;} }else{?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?php echo $text_general_notfound;?></p>
                </h4>
            </div>
        </div>
<?php } ?>		
		
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
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
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
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
</style>
<script>
/*$(function  () {
 $("#accordion").sortable({
placeholder: 'drop-placeholder'
});

});*/
function JQDel_Faq_Q(id){
					$.confirm({
						title: '<?php echo $txt_ewt_confirm_del_title;?>',
						content: '<?php echo $txt_ewt_confirm_del_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo $txt_ewt_confirm_del;?>',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_faq_q.php',
											data:{'id': id,'proc':'DelFaqQ'},
											success: function (data) {
												$.alert({
													title: '<?php echo $txt_ewt_action_del_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: '<?php echo $txt_ewt_submit;?>',
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
									text: '<?php echo $txt_ewt_cancel;?>'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}

</script>