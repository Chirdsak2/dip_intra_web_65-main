<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
$db->query("USE ".$EWT_DB_USER);

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$s_sql = $db->query("SELECT * FROM `title` ORDER BY `title_order` ASC LIMIT {$start} , {$perpage}");
										
$statement = "SELECT count(title_id) AS b FROM `title` WHERE 1=1 ";
		  
$a_rows  = $db->db_num_rows($s_sql);		
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

<h4><?php echo $txt_org_menu_nametitle;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="org_dashboard.php"><?php echo $txt_org_menu_main;?></a></li>
<li class=""><?php echo $txt_org_menu_nametitle;?></li>   
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_org_title.php');" >
<button type="button" class="btn btn-info  btn-ml"    title="<?php echo $txt_org_title_add;?>"  >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_org_title_add;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
         <li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_org_title.php);" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_org_title_add;?></a></li>
			
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->

<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<?php
/*<div class="table-responsive" id="frm_edit_s">	  
<table width="100%" class="table table-bordered">
<thead>
<tr class="success">
				<th width="5%" class="text-center" >&nbsp;</th>
                <th width="65%" class="text-center" >ชื่อหน่วยงาน (ลำดับเดิม)</th>
                <th width="10%" class="text-center" >ลำดับการเรียง</th>
                <th width="10%" class="text-center" >ภาษาอื่น</th>
				<th width="10%" class="text-center" ></th>
</tr>
</thead>
<tbody>
<?php
$perpage = 20;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$s_sql = $db->query("SELECT * FROM `title` ORDER BY title_id ASC LIMIT {$start} , {$perpage}");
										
$statement = "SELECT count(title_id) AS b 
			  FROM `title` 
               ";
			  
$a_rows  = $db->db_num_rows($s_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
		if(!empty($a_rows)){
					while($a_data = $db->db_fetch_array($s_sql)){				
?>

<tr>
<td ></td>
<td ><?php echo $a_data['title_thai'];?></td>
<td ></td>
<td ><?php //echo show_icon_lang_ewt($a_data['org_id'],'org_name');?></td>
<td > </td>
</tr>
<?php } } ?>
</tbody>
</table>
</form>

</div>*/ 
?>

<div class="panel-group" id="accordion">
<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($s_sql)){
?>	
<div class="panel panel-default " id="<?php echo $a_data['title_id'];?>"  >
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
				<i class="fas fa-arrows-alt text-info move" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="<?php echo 'Move';?>" ></i>
				<input class="input-inline-sm text-center" name="title_order[]" id="title_order<?php echo $a_data['title_order'];?>"  type="text" value="<?php echo $a_data['title_order'];?>" readonly />
				
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					<i class="fas fa-list-alt"></i>
					<?php echo $a_data['title_thai'];?>
	
					</a>					
                </h4>
            </div>
		
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                   	<div><b><?php echo $txt_org_title_name;?> :</b> <?php echo $a_data['title_thai'];?></div><br> 
					<div><?php echo org::chkStatusOrg($a_data['title_status']);?></div><br> 					
					<div class="text-left">
					<span class="label label-primary "><?php echo $txt_ewt_multilang; ?></span>
					<?php //if(show_icon_lang_ewt($a_data['title_id'],'title')) { ?>
					<!--<button  type="button" class="btn btn-default   btn-sm " data-toggle="tooltip" data-placement="top" title="" >-->
					<?php //echo show_icon_lang_ewt($a_data['title_id'],'title');?>
					<!--</button>-->
					<?php //} ?>
					</div> 
				</div>	
				<div class="panel-footer ewt-bg-white text-right">
				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
				
<a onClick="txt_data('<?php echo $a_data['title_id'];?>','')" >
<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $a_data['title_id'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang;?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_org_title.php?title_id=<?php echo $a_data['title_id'];?>');">
<button type="button" class="btn btn-warning  btn-circle  btn-xs "  data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_title_edit;?>" >
<i class="fa fa-edit" aria-hidden="true"></i>  
</button>
</a>
<a onClick="JQDel_Org_Title('<?php echo $a_data['title_id'];?>');" >
<button type="button" class="btn btn-danger   btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_title_delete;?>"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>


					
<!--<a onClick="JQSet_Lang_Calendar('<?php //=$a_data['event_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?php //=$txt_ewt_create_multilang;?>">
<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?php //=$a_data['event_id'];?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>--> 

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
<?php echo pagination_ewt($statement,$perpage,$page,'?search_txt='.$search_txt.'&'); ?> 
</div>
</div>
</div>
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE ".$EWT_DB_NAME);

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
											url: 'func_sortable_org_title.php',											
											data:{proc:'Sortable_Edit',page_id_array:page_id_array,start:'<?php echo $start;?>'},
											success: function (data) {	
												var Newdata= JSON.stringify(eval("("+data+")"));
												var Obj = jQuery.parseJSON(Newdata);											
												console.log(Obj.message);
												
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

function txt_data(w,g) {	
	$.ajax({
      type: 'GET',
      url: 'pop_set_lang_org_title.php?gid='+g+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}	
    }); 	
$('#box_popup').fadeIn();		
}

function txt_data1(w,g,lang) {
	$.ajax({
      type: 'GET',
      url: 'pop_org_title_multilang.php?langid='+g+'&lang='+lang+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}		
    }); 
	$('#box_popup').fadeIn();	
}

function JQDel_Org_Title(id){
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
											url: 'func_delete_org_title.php',
											data:{'id': id,'proc':'DelOrgTitle'},
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