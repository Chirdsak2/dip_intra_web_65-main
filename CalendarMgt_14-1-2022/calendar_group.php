<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");
?>  
<link rel="stylesheet" href="../js/pick-a-color/build/1.2.3/css/pick-a-color-1.2.3.min.css">	 
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);



function banner_category($ban_cid){
	 global $db,$EWT_DB_NAME;
	 $s_category = $db->query("SELECT * FROM banner_group WHERE banner_gid = '{$ban_cid}' ");	
	 if($db->db_num_rows($s_category)){
		$a_category = $db->db_fetch_array($s_category);											
		$a_data = $a_category['banner_name'];
			
	 	}		
		return $a_data;
}



$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * 
					FROM cal_category 
					WHERE webname_site = '{$_SESSION['EWT_SUSER']}' {$wh} 
					ORDER BY cat_id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(cat_id) AS b
			  FROM cal_category 
			  WHERE webname_site = '{$_SESSION['EWT_SUSER']}' {$wh} ";
			  
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

<h4><?=$txt_calendar_cate;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="calendar_list.php"><?=$txt_calendar_cate;?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?=linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?=$cal_cid;?>');">
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_calendar_add_cate;?>
</button>

<!--<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?=linkboxPopup();?>pop_add_calendar.php?cal_cid=<?=$cal_cid;?>');" title="<?=$txt_calendar_add;?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_calendar_add;?>
</button>

<button type="button" class="btn btn-info  btn-ml " onclick="boxPopup('<?=linkboxPopup();?>pop_search_calendar.php');" title="<?=$txt_calendar_search;?>" >
<i class="fas fa-search"></i>&nbsp;<?=$txt_calendar_search;?>
</button>-->


</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right pointer">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?=$cal_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_calendar_add_cate;?></a></li>
			<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_calendar.php?cal_cid=<?=$cal_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_calendar_add;?></a></li>
          	<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_search_banner.php');" ><i class="fas fa-search"></i>&nbsp;<?=$txt_calendar_search;?></a></li>
			<li><a href="banner_group.php" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?></a></li>
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
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left">
</div>
</div>
<div class="card-body">
<div class="panel-group" id="accordion">
<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($_sql)){
	
	$_cal_event = $db->query("SELECT cal_event.*
							  FROM cal_event 
						      INNER JOIN cal_show_event ON (cal_event.event_id = cal_show_event.event_id)
						      WHERE cat_id = '{$a_data['cat_id']}' ");
	$a_row_event = $db->db_num_rows($_cal_event);	
					
?>	
<div class="panel panel-default ">
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?=$i;?>">
					<i class="fas fa-folder"></i>
					<?=$a_data['cat_name'];?> 
					</a>					
                </h4>
            </div>
		
<div id="collapseOne<?=$i;?>" class="panel-collapse collapse">
<div class="panel-body">
<span class="text-danger"> จำนวนปฏิทินกิจกรรมภายในหมวด  <?=$a_row_event;?>	 กิจกรรม </span>

<div><br><h4><span class="label label-primary "><?=$txt_ewt_multilang; ?></span></h4>
<?php if(show_icon_lang($a_data['cat_id'],'cal_category')) { ?>
<button  type="button" class="btn btn-default  btn-ml " <?=$disabled;?> data-toggle="tooltip" data-placement="top" title="<?=$a_data['lang_config_name'];?>" ><?=show_icon_lang($a_data['cat_id'],'cal_category');?></button>
<?php } ?>
</div>
</div>
<div class="panel-footer ewt-bg-white text-right">

				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
<a onClick="txt_data('<?=$a_data['cat_id'];?>','')" >
<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?=$a_data['cat_id'];?>" data-toggle="tooltip" data-placement="top" title="<?=$txt_ewt_create_multilang;?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>

<a onClick="JQDelete_Calendar_Cat(<?=$a_data['cat_id']?>);"  > 
<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?=$txt_calendar_delete_cate;?>"  >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>

<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_calendar_group.php?cat_id=<?=$a_data['cat_id'];?>');" >					
<button type="button" class="btn btn-default btn-circle btn-sm "  data-toggle="tooltip" data-placement="top" title="<?=$txt_calendar_edit_cate;?>" >
<i class="far fa-edit" aria-hidden="true"></i>
</button>
</a>
					
<!--<a onClick="JQSet_Lang_Calendar('<?//=$a_data['event_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?//=$txt_ewt_create_multilang;?>">
<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?//=$a_data['event_id'];?>" >
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
                   <p class="text-danger"><?=$txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php } ?>		
		
</div>

</div>
</div>
<?=pagination_ewt($statement,$perpage,$page,$url='?');?>
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

<script src="../js/pick-a-color/build/dependencies/tinycolor-0.9.15.min.js"></script>
<script src="../js/pick-a-color/build/1.2.3/js/pick-a-color-1.2.3.min.js"></script>	                                                                                                                                                                                                  <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
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
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
-->
</style>
<script>
function JQDelete_Calendar_Cat(id){
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
											url: 'func_delete_calendar_group.php',
											data:{'id': id,'proc':'DelCalGroup'},
											success: function (data) {
												$.alert({
													title: '',
													theme: 'modern',
													content: 'ลบข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														
														location.reload(true);			
														$('#box_popup').fadeOut();
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
function txt_data(w,g) {	
	$.ajax({
      type: 'GET',
      url: 'pop_set_lang_cal_category.php?gid='+g+'&id='+w,
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
      url: 'pop_cal_category_multilang.php?langid='+g+'&lang='+lang+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}
		
    }); 
	
$('#box_popup').fadeIn();	
	 //window.location.href='../multilangMgt/article_group.php?langid='+g+'&lang='+lang+'&id='+ w;
}
</script>