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

$s_sql = $db->query("SELECT * FROM `org_name` WHERE parent_org_id LIKE '0001_%' ORDER BY org_order ASC,org_id ASC LIMIT {$start} , {$perpage}");
										
$statement = "SELECT count(org_id) AS b 
			  FROM `org_name` 
              WHERE parent_org_id LIKE '0001_%' ";
$i = 1;			  
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

<h4><?=$txt_org_chart_org_group;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="org_dashboard.php"><?=$txt_org_menu_main;?></a></li>
<li><a href="org_chart.php"><?=$txt_org_menu_chart;?></a></li> 
<li class=""><?=$txt_org_chart_org_group;?></li>    
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	
<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_org_group.php');" >
<button type="button" class="btn btn-info  btn-sm"    title="<?=$txt_org_add_group;?>"  >
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_org_add_group;?>
</button>
</a>
<a href="org_chart.php"  target="_self" >
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_org_group.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_org_add_group;?></a></li>					
		<li><a href="org_chart.php" target="_self" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_ewt_back;?></a></li>
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

<? /*
<div class="table-responsive" id="frm_edit_s">	  
<table width="100%" class="table table-bordered">
<thead>
<tr class="success">
				<th width="5%" class="text-center" >&nbsp;</th>
                <th width="60%" class="text-center" ><?=$txt_org_group_name;?></th>
                <th width="15%" class="text-center" ><?=$txt_ewt_multilang;?></th>
				<th width="20%" class="text-center" ></th>
</tr>
</thead>
<tbody>
<?php
$perpage = 20;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$s_sql = $db->query("SELECT * FROM `org_name` WHERE parent_org_id LIKE '0001_%' ORDER BY org_id ASC LIMIT {$start} , {$perpage}");
										
$statement = "SELECT count(org_id) AS b 
			  FROM `org_name` 
              WHERE parent_org_id LIKE '0001_%' ";
$i = 1;			  
$a_rows  = $db->db_num_rows($s_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);
		if(!empty($a_rows)){
					while($a_data = $db->db_fetch_array($s_sql)){				
?>

<tr>
<td class="text-center" ><?=$i+$start.'.';?></td>
<td class="text-left" ><?=$a_data['name_org'];?></td>
<td class="text-center"><?php //echo show_icon_lang_ewt($a_data['org_id'],'org_name');?></td>
<td class="text-left">
<button type="button" class="btn btn-info  btn-circle  btn-sm " onclick="boxPopup('<?=linkboxPopup();?>pop_view_org_list.php?u_id=<?=$a_data['gen_user_id']?>');"  data-toggle="tooltip" data-placement="top" title="<?=$txt_org_view;?>" >
<i class="fas fa-search" aria-hidden="true"></i>
</button>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_org_list.php?u_id=<?=$a_data['gen_user_id'];?>');">
<button type="button" class="btn btn-warning  btn-circle  btn-xs "  data-toggle="tooltip" data-placement="top" title="<?=$txt_org_edit;?>" >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a>
<a onClick="JQDel_Gen_User('<?=$a_data['gen_user_id'];?>');" >
<button type="button" class="btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?=$txt_org_delete;?>"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>
<a onClick="txt_data('<?=$a_video['vdo_id'];?>','')" >
<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?=$a_video['vdo_id'];?>" data-toggle="tooltip" data-placement="top" title="<?=$txt_ewt_create_multilang;?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>
 </td>
</tr>
<?php
						 $i++;
								
						}//end while
					}else{
					?>
<tr> 
<td colspan="4"><p class="text-center text-danger"><?php echo $txt_ewt_data_not_found ; ?></p></td>
</tr>					
					<?php
					}
					?>	
</tbody>
</table>
</div>
*/ ?>



<div id="tree"></div>
</div>

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
<script src="https://balkangraph.com/js/latest/OrgChart.js"></script>
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
 
window.onload = function () {
OrgChart.templates.ana.field_0 = '<text   width="230" text-overflow="ellipsis" style="font-size: 20px;" fill="#ffffff" x="125" y="65" text-anchor="middle" >{val}</text>';
OrgChart.templates.ana.html = '<foreignobject class="node" style="font-size: 20px;color:#ffffff;" x="20" y="10" width="200" height="100" >{val}</foreignobject>';   
	
	var chart = new OrgChart(document.getElementById("tree"), {
		enableDragDrop: true,
		nodeBinding: {
                field_0: "name"
				
		},
		onUpdate: function (sender, oldNode, newNode) {	
				 console.log(sender);
				 console.log(newNode);

									$.ajax({
											type: 'POST',
											url: 'func_update_org_chart.php',											
											data:{proc:'Chart_Edit',page:newNode},
											success: function (data) {	
												//var Newdata= JSON.stringify(eval("("+data+")"));
												//var Obj = jQuery.parseJSON(Newdata);											
												console.log(data);	
												
												//location.reload(true);																							
					
											}
										});	
										
			},
		});	
		chart.load([{ id: 1, name: "สำนักงานคณะกรรมการการแข่งขันทางการค้า", html: "สำนักงานคณะกรรมการการแข่งขันทางการค้า" },
                { id: 2, pid: 1, name: "ฝ่ายสื่อสารองค์กร ", html: "ฝ่ายสื่อสารองค์กร" },
                { id: 4, pid: 2, name: "คณะอนุกรรมการตรวจสอบ", html: "คณะอนุกรรมการตรวจสอบ" }]);

};


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
											url: 'func_sortable_org_group.php',											
											data:{proc:'Sortable_Edit',page_id_array:page_id_array,start:'<?=$start;?>'},
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
      url: 'pop_set_lang_org_group.php?gid='+g+'&id='+w,
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
      url: 'pop_org_group_multilang.php?langid='+g+'&lang='+lang+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}		
    }); 
	$('#box_popup').fadeIn();	
}

function JQDel_Org_Group(id){
					$.confirm({
						title: '<?=$txt_ewt_confirm_del_title;?>',
						content: '<?=$txt_ewt_confirm_del_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?=$txt_ewt_confirm_del;?>',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_org_group.php',
											data:{'id': id,'proc':'DelOrgGroup'},
											success: function (data) {
												$.alert({
													title: '<?=$txt_ewt_action_del_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: '<?=$txt_ewt_submit;?>',
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
									text: '<?=$txt_ewt_cancel;?>'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}
</script>	