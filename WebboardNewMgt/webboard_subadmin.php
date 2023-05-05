<?php
include("../EWT_ADMIN/comtop.php");
include("lib/webboard_function.php");
//============
//  Removing
//============



if($_POST["proc"]=="del_sadmin"){
	
	if($_POST[t_id]){
		if(check_type_number($_POST[t_id])==true){
			$query_sadmin_del = "DELETE FROM w_admin WHERE t_id='".$_POST[t_id]."'";
			$sadmin_del = $db->query($query_sadmin_del);
			
			$query_permisssion_del = "DELETE FROM w_permission WHERE t_id='".$_POST['hdd_uid']."'";
			$permisssion_del = $db->query($query_permisssion_del);
		}
	}
	
	?>
		<script>
			location.href = "webboard_subadmin.php";
		</script>

	<?php	
	exit();
}
else if($_POST[proc]=="approve_room"){
	
	if($_POST[c_id]){
		$sql_approve = "UPDATE w_cate SET c_use='Y' WHERE c_id='$_POST[c_id]'";
		$db->query($sql_approve);
	}
	
	?>
		<script>
			location.href = "webboard_main.php";
		</script>

	<?php	
	exit();
}
else if($_POST[proc]=="disapprove_room"){

	if($_POST[c_id]){
		$sql_approve = "UPDATE w_cate SET c_use='' WHERE c_id='$_POST[c_id]'";
		$db->query($sql_approve);
	}
	
	?>
		<script>
			location.href = "webboard_main.php";
		</script>

	<?php	
	exit();

}
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;
//$wh = "WHERE c_parentid='0'";
$_sql = $db->query("SELECT DISTINCT t_name,t_id FROM w_admin {$wh} ORDER BY t_id DESC LIMIT {$start},{$perpage} ");

$statement = "SELECT count(t_id) AS b
			  FROM w_admin
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
<h4><?php echo 'ผู้ดูแลหมวดกระทู้';?></h4> 
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li>ผู้ดูแลหมวดกระทู้</li>
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_webboard_admin.php');">
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo 'เพิ่มผู้ดูแลหมวดกระทู้';?>
</button> 
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
	<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">
			<i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span>
		</button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li>
			<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_webboard_admin.php');" >
			<i class="fas fa-plus-circle"></i>&nbsp;<?php echo 'เพิ่มผู้ดูแลหมวดกระทู้';?>
			</a>
			</li>		
			<li>
			<a href="banner_group.php" target="_self" >
			<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?>
			</a>
			</li>
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
<div class="panel-group" id="accordion">
<?php
if($a_rows > 0)
{
		$i = 0;
	while($a_data = $db->db_fetch_array($_sql))
	{
	$db->query("USE ".$EWT_DB_USER);
	$sql_sp = $db->query("select * from gen_user LEFT OUTER JOIN org_name ON gen_user.org_id = org_name.org_id INNER JOIN emp_type ON emp_type.emp_type_id = gen_user.emp_type_id  where gen_user_id = '".$a_data[t_id]."'");
	$SP = $db->db_fetch_array($sql_sp);
		?>
		<div class="panel-body text-left">
		<div class = "col-md-2 col-sm-4 col-xs-6"> 
			<a href ="webboard_edit_subadmin.php?t_id=<?php echo $a_data['t_id']?>">
			<button type="button" class="btn btn-default  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="แก้ไข" >
			<i class="fas fa-edit" aria-hidden="true"></i>
			</button>
			</a>
			<button type="button" class="btn btn-default  btn-circle  btn-sm del_sadmin" data-toggle="tooltip" data-placement="top" title="ลบ" value="<?php echo $a_data['t_id']?>">
			<i class="far fa-trash-alt " aria-hidden="true"></i>
			</button>
		</div>
		
		<div class = "col-md-10 col-sm-8 col-xs-6">
			<?php echo $a_data['t_name']." (".$SP['name_org'].") (กลุ่ม : ".$SP['emp_type_name']." )";?>
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
	<?php } 
		$db->query("USE ".$_SESSION['EWT_SDB']);
	?>		
				
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
<span id="manage_info"></span>
<script>

	$(".del_sadmin").click(function(){
		var t_id = this.value;
		if(confirm("<?php echo $txt_webboard_delete_room_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_form"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="del_sadmin"></form>');
			$("#manage_form").submit();
		}
	});

	$(".approve_room").click(function(){
		//var comment = $("#comment_desc").val();
		var c_id = this.value;
		if(confirm("<?php echo $txt_webboard_approve_room_ask ; ?>")){
			$("#manage_info").html('<form method="post" id="manage_room"><input type="hidden" name="c_id" value="'+c_id+'"><input type="hidden" name="proc" value="approve_room"></form>');
			$("#manage_room").submit();
		}
	});

	$(".disapprove_room").click(function(){
		//var comment = $("#comment_desc").val();
		var c_id = this.value;
		if(confirm("<?php echo $txt_webboard_disapprove_room_ask ; ?>")){
			$("#manage_info").html('<form method="post" id="manage_room"><input type="hidden" name="c_id" value="'+c_id+'"><input type="hidden" name="proc" value="disapprove_room"></form>');
			$("#manage_room").submit();
		}
	});

</script>