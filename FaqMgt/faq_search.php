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

<h4><?=$txt_faq_search;?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="faq_dashboard.php"><?=$txt_faq_menu_main;?></a></li>
<li><?=$txt_faq_search;?>   </li>  
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

<a  target="_self" onclick="boxPopup('<?=linkboxPopup();?>pop_search_faq.php');" >
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-search"></i>&nbsp;<?=$txt_faq_search;?>
</button>
</a>

</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
           <li><a onclick="boxPopup('<?=linkboxPopup();?>pop_search_faq.php');" ><i class="fas fa-search"></i>&nbsp;<?=$txt_faq_search;?></a></li>
          	
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->


<?php
$wh1 = '';

if(!empty($_GET['category_parent'])){

	$wh1 .= "AND ( f_sub_id = '".$_GET['category_parent']."' )";
	
}
if(!empty($_GET['category_title'])){
	
	$wh1 .= " AND ( fa_name  LIKE '%".$_GET['category_title']."%' OR  fa_ans  LIKE '%".$_GET['category_title']."%')";
	
}

//echo $wh1;
if(!empty($wh1)){
	
	$wh = "".$wh1;
}



$perpage = 12;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * FROM faq WHERE ( faq_use = 'Y' OR  faq_use = 'N' )  {$wh} ORDER BY fa_id DESC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(fa_id) AS b
			  FROM faq 
			  WHERE ( faq_use = 'Y' OR  faq_use = 'N' ) {$wh} ";
			  
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
<div class="title" ><i class="fas fa-hashtag"></i> <?="FAQ";?></div>
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
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?=$i;?>">
					<i class="far fa-question-circle"></i>
				
					<span class="hidden-xs" >
					<?=showWord($a_data['fa_name'],'140');?>
					</span>
					<span class="visible-xs" style="width:80%;" >
					<?=showWord($a_data['fa_name'],'40');?>
					</span>
					</a>	
					</a>					
                </h4>
            </div>
            <div id="collapseOne<?=$i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                <div><b><i class="far fa-question-circle"></i>&nbsp;:&nbsp;<?php echo $a_data['fa_name'];?></b></div>			
                <div><b>รายละเอียดคำถาม&nbsp;:&nbsp;</b><?php echo $a_data['fa_detail'];?> </div>
                <span><em class="far fa-comment-alt"></em>&nbsp;:&nbsp;<?=$a_data['fa_ans'];?></span>
				
                </div>
				<div class="panel-footer ewt-bg-white text-right">
				<a onClick="JQDel_Faq('<?=$a_data['fa_id'];?>');">
				<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?=$txt_faq_delete;?>"   >
				<i class="far fa-trash-alt" aria-hidden="true"></i>
				</button>
				</a>
				<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_faq.php?fa_id=<?=$a_data['fa_id'];?>&faq_cid=<?=$faq_cid;?>');">
				<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?=$txt_faq_edit;?>"   >
				<i class="fa fa-edit text-dark  pointer" aria-hidden="true"></i>
				</button>
				</a>
				</div>
            </div>
        </div>
<?php  $i++; }}else{?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?=$text_general_notfound;?></p>
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
        color: #F58723;
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
</style>
<script>
$(function  () {
 $("#accordion").sortable({
placeholder: 'drop-placeholder'
});

});

</script>