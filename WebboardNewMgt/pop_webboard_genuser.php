<?php
include("../EWT_ADMIN/comtop_pop.php");
$db->query("USE ".$EWT_DB_USER);

$_sql = $db->query("SELECT * 
					FROM gen_user 
					INNER JOIN org_name ON org_name.org_id = gen_user.org_id 
					WHERE status ='1' 
					ORDER BY gen_user.gen_user_id DESC
					");
$a_rows = $db->db_num_rows($_sql);		
//$s_count = $db->query($statement);
//$a_count = $db->db_fetch_array($s_count);
//$total_record = $a_count['b'];
//$total_page = (int)ceil($total_record / $perpage);
?>
 
<form id="form_main1" name="form_main1" method="POST" action="<?php echo getLocation('func_add_faq_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate">
<div class="container" >   
<div class="modal-dialog modal-lg" >  

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">  
<button type="button" class="close" onclick="$('#box_popup2').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-user-circle"></i> <?php echo "รายชื่อบุคคลากร";?></h4>
</div>

<div class="modal-body">
<div class="panel-group" id="accordion">
<?php
	$i=1;
	while($a_data = $db->db_fetch_array($_sql))
	{
?>
       <div class="panel panel-default ">
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
					<img src="<?php echo $IMG_PATH ;?>images/grabme.svg">   
					<a class="pointer" onClick="JQSet_Cal_User('<?php echo $a_data['gen_user_id'];?>','<?php echo $a_data['name_thai']; ?> <?php echo $a_data['surname_thai']; ?>');$('#box_popup2').fadeOut();">
					<img src="<?php echo org::getGenUserImg($a_data['gen_user_id']);?>" alt="" class="img-circle img-rounded " style="width:24px;height:24px;">
					<?php echo $a_data['name_thai']; ?> <?php echo $a_data['surname_thai']; ?>
					</a>					
                </h4>
            </div>
		</div>
<?php 
	$i++;
 }
?>	

</div>		
</div>
</div>

</div>
 
</div>	 
</form>

<script>  
$(document).ready(function() {

 	
});

function JQSet_Cal_User(cid,cname){
	//alert(cname);
	document.getElementById('gen_user_id').value = cid;
	document.getElementById('a_contact').value = cname;
	//document.getElementById('txtshow').innerHTML = cname;
	
}

function JQCheck_Cate(form){
	var name  = form.attr('name'); 
	var check = $('input:checkbox[name='+name+']:checked').val();	
	if(check == 'Y'){
		$('#category_parent').attr("disabled",false);
		$('#category_parent').attr("required",false);
		}else{
			$('#category_parent').attr("disabled",true);
			$('#category_parent').attr("required",true);
		}	
	console.log(check);
}
</script>
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