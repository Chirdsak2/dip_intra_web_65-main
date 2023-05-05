<?php
include("../EWT_ADMIN/comtop.php");

if($_POST["flag"] == "change"){
	
	$Execsql = $db->query("UPDATE w_admin SET t_user = '$user',t_pass = '$pass'");
	?>
	<script language="JavaScript">
		alert("แก้ไขข้อมูลเรียบร้อยแล้ว");
	window.location.href = "webboard_main.php";
	</script>
	<?php
	exit;
	}
	if($_POST["flag"] == "config"){
	
	$Execsql=$db->query("SELECT * FROM w_config");
	if($db->db_num_rows($Execsql)>0){ 
				$Execsql = $db->query("UPDATE w_config SET c_approve = '".$_POST["wtype"]."',c_number = '".$_POST[nump]."',c_mail = '".$_POST[wemail]."',c_img='".$_POST[Img]."',c_link='".$_POST[txt_time]."',c_sizeupload='".$_POST[txt_size]."',c_vote='".$_POST[wvote]."',c_voteshow ='".$_POST[txtshowdate]."',c_showip='".$_POST[wip]."',c_name = '".$_POST['c_name']."' WHERE c_config = '1'");
	}else{
				$Execsql = $db->query("INSERT INTO 
				w_config(c_approve,c_number,c_mail,c_img,c_link,c_sizeupload,c_vote,c_voteshow,c_showip) 
				VALUES('".$_POST[wtype]."','".$_POST[nump]."','".$_POST[wemail]."','".$_POST[Img]."','".$_POST[txt_time]."','".$_POST[txt_size]."','".$_POST[wvote]."','".$_POST[txtshowdate]."','".$_POST[wip]."' )");
	}
	$db->write_log("update","webboard","ตั้งค่ากระทู้");
	?>
	<script language="JavaScript">
		alert("แก้ไขข้อมูลเรียบร้อยแล้ว");
	window.location.href = "webboard_admin.php";
	</script>
	<?php
	exit;
	}

$_sql = $db->query("SELECT * FROM w_config WHERE  c_config = '1'");					
$a_data = $db->db_fetch_array($_sql); 
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
include("lib/webboard_function.php");

?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<h4><?php echo 'ตั้งค่าเว็บบอร์ด';?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?php echo 'ตั้งค่าเว็บบอร์ด';?></li>
</ol>
</div>
</div>
</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >
<div class="card">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >
<div class="card-title text-left">

<div class="title" ><i class="fas fa-hashtag"></i> <?php //echo 'ตั้งค่าเว็บบอร์ด';?></div>
</div>
</div>
<div class="card-body">
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_webboard_config')?>" enctype="multipart/form-data" >

<div class="form-group row " >
<label for="c_approve"  class="col-sm-4 control-label text-right" ><b><?php echo "อนุมัติก่อนขึ้นแสดง";?> <span class="text-danger"><code>*</code></span> :</b></label>   
<div class="col-md-4 col-sm-4 col-xs-12" > 
<div >
<label class="switch">
  <input type="checkbox" value="1" name="c_approve" id="c_approve" <?php if($a_data['c_approve'] == '1'){ echo 'checked="checked"'; } ?>>
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label> 
</div>
</div>
</div>
<div class="form-group row " >
<label for="c_showip"  class="col-sm-4 control-label text-right" ><b><?php echo "แสดงหมายเลขเครื่อง (IP)";?> <span class="text-danger"><code>*</code></span> :</b></label>   
<div class="col-md-4 col-sm-4 col-xs-12" > 
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="c_showip" id="c_showip" <?php if($a_data['c_showip'] == 'Y'){ echo 'checked="checked"'; } ?>> 
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>
<div class="form-group row" > 
<label for="c_show_question"  class="col-sm-4 control-label text-right" ><b><?php echo "แสดงชื่อผู้ตั้งกระทู้";?> <span class="text-danger"><code>*</code></span> :</b></label>   
<div class="col-md-4 col-sm-4 col-xs-12" > 
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="c_show_question" id="c_show_question" <?php if($a_data['c_show_question'] == 'Y'){ echo 'checked="checked"'; } ?>>
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>
<div class="form-group row" > 
<label for="c_show_answer"  class="col-sm-4 control-label text-right" ><b><?php echo "แสดงชื่อผู้แสดงความคิดเห็น";?> <span class="text-danger"><code>*</code></span> :</b></label>   
<div class="col-md-4 col-sm-4 col-xs-12" > 
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="c_show_answer" id="c_show_answer" <?php if($a_data['c_show_answer'] == 'Y'){ echo 'checked="checked"'; } ?>>
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div>
<!-- <div class="form-group row" > 
<label for="c_show_answer"  class="col-sm-4 control-label text-right" ><b><?php echo "แสดงชื่อนามสมมุติ";?> <span class="text-danger"><code>*</code></span> :</b></label>   
<div class="col-md-4 col-sm-4 col-xs-12" > 
<div >
<label class="switch">
  <input type="checkbox" value="Y" name="c_show_webb_name" id="c_show_webb_name" <?php if($a_data['c_show_webb_name'] == 'Y'){ echo 'checked="checked"'; } ?>>
  <span class="slider round"></span>
  <span class="absolute-no">NO</span>
</label>
</div>
</div>
</div> -->


<!--<div class="form-group row " >
<label for="menu_link" class="col-sm-4 control-label text-right"><b><?php //echo 'กำหนดขนาดไฟล์';?> <span class="text-danger"><code>*</code></span> :</b></label>
<div class="col-md-4 col-sm-4 col-xs-12" >
<div class="input-group">
<input class="form-control" placeholder="<?php //echo  'กำหนดขนาดไฟล์';?>" name="c_size" type="text" id="c_size" value="" required="required" aria-describedby="basic-addon2" onKeyUp="chkformatnum(this)" >
 <span class="input-group-addon" id="basic-addon2">MB.</span>
</div>
</div>
</div>--> 


<input type="hidden" name="proc" id="proc"  value="Edit_Config">


<div class="text-center">
<button onclick="JQEdit_Config($('#form_main'));" type="button" class="btn btn-success  btn-ml " > 
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save ;?> 
</button>
</div>
</form>	
</div>

</div> 
	
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
 <!-- */
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
/* --> 
</style>



<script>
function JQEdit_Config(form){  	
//$('#loader').fadeIn();	
var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'ตั้งค่าเว็บบอร์ด',  
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: method,
											url: action,					
											data: formData ? formData : form.serialize(),
											async: true,
											processData: false,
											contentType: false,
											success: function (data) {	
												//$("#loader").fadeOut(5000);  
												console.log(data);															
												$.alert({
													title: 'บันทึกข้อมูลเรียบร้อย',
													theme: 'modern',
													icon: 'far fa-check-circle',
													content: 'Success! ',
													type: 'green',
													typeAnimated: true,
													boxWidth: '30%',	
													buttons: {
														ok: {
															btnClass: 'btn-green'
															}     
														},
													onAction: function () {
														//self.location.href="complain_builder.php?com_cid=6";	
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});																																
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									//$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}

function fixdate(t){
if(t.value == '0'){
document.getElementById('showdate').style.display ='' ; 
}else{
document.getElementById('showdate').style.display ='none' ; 
}
}
function CHK(){
if(document.form1.user.value == ""){
alert("กรุณาใส่ username");
document.form1.user.focus();
return false;
}
if(document.form1.pass.value == ""){
alert("กรุณาใส่ password");
document.form1.pass.focus();
return false;
}

if(document.form1.cpass.value != document.form1.pass.value){
alert("กรุณายืนยัน password ตรงกัน");
document.form1.cpass.select();
return false;
}
}
function CHK1(){
if(document.form2.nump.value == ""){
alert("กรุณาใส่จำนวนกระทู้ในหมวดต่อหนึ่งหน้า");
document.form2.nump.focus();
return false;
}
}
 function isNum (charCode) 
   {
       if (charCode >= 48 && charCode <= 57 )
	       return true;
      else
	     return false;
   }
 function chkFormatNam (str) {//0-9
  strlen = str.length;
  for (i=0;i<strlen;i++)
  {
      var charCode = str.charCodeAt(i);
	  if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
		  return false;
	  }
   }
   return true;
}
function chkformatnum(t){ 
		_MyObj = t;
		_MyObj_Name = t.name;
		_MyObj_Value = t.value;
		_MyObj_Strlen =_MyObj_Value.length; 
		if( _MyObj_Strlen >1 && _MyObj_Value.substr(0,1)==0){
			t.value = _MyObj_Value.substr(1);
		}
		if(!chkFormatNam (t.value)){
				alert('กรุณากรอกตัวเลขเท่านั้น');
				t.value = 0;
				t.focus();
	} 
}
</script>
<?php @$db->db_close(); ?>