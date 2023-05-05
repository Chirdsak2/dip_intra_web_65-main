<?php
include("../EWT_ADMIN/comtop.php"); 
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" > 
<?php
include("menu-top.php");
$rss_id = (int)(!isset($_GET['rss_id']) ? '' : $_GET['rss_id']);
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$s_sql 	= $db->query("SELECT * FROM rss WHERE rss_id = '{$rss_id}' ");
$a_data = $db->db_fetch_array($s_sql);  

$_sql = $db->query("SELECT * FROM rss WHERE 1=1 {$wh} ORDER BY rss_id DESC LIMIT {$start} , {$perpage} ");
 
$statement = "SELECT count(rss_id) AS b
			  FROM rss 
			  WHERE 1=1
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

<h4><?php echo 'หน้าหลัก RssFeed';?></h4> 
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="rss_main.php" target="_self"><?php echo 'หน้าหลัก RssFeed';?></a></li>
<li><?php echo 'คลังข่าว';?> :: <?php echo $a_data['rss_title'];?> </li>  
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  > 	  
<!--<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_rss.php');"   target="_self">
<button type="button" class="btn btn-info  btn-ml"  title="<?php echo 'เพิ่ม Rss Feed';?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo 'เพิ่ม Rss Feed';?>
</button>
</a>
<a  target="_self" onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_menu.php');" >
<button type="button" class="btn btn-info  btn-ml "  title="<?php echo $txt_menu_search;?>"  >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?>
</button>
</a>-->
<a href="rss_main.php" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right pointer">
            <li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_rss.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo 'เพิ่ม RSS';?></a></li>
          	<li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search_menu.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?></a></li>
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->


<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left color-white">
<?php echo $a_data['rss_title'];?> 
</div>
</div>
<div class="card-body">
 <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>หัวข้อข่าว</th>
        <th>รูปภาพ</th>
        <th>รายละเอียด</th>
        <th>วันที่</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  </div>
  
</div> 
</div>
<?php echo pagination_ewt($statement,$perpage,$page,$url='?');?>				
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
	function JQDel_Rss(Id){ 
	    
	$.confirm({
		title: 'ลบ RssFeed',
		content: 'คุณต้องการลบ RssFeed หรือไม่?', 
		boxWidth: '80%',
		icon: 'fas fa-exclamation-circle',
		theme: 'modern',
		buttons: {
			confirm: {
				text: 'ยืนยันการลบ',
				btnClass: 'btn-warning',
				action: function () {
					$.ajax({
						type: 'POST',
						url: "func_del_rss.php",  					
						data: {id:Id,proc:"DelRss"},
						success: function (data) { 

							$.alert({
								title: '',
								theme: 'modern',
								content: 'ลบเมนูเรียบร้อย',
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
				text: 'ยกเลิก'													
			}
		},                          
		animation: 'scale',
		type: 'orange'						
		});
	}		
</script>