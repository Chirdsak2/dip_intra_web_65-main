<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");

$s_id = $_GET['s_id'];

$SQL = $db->query("SELECT * FROM p_survey WHERE s_id = '{$s_id}' "); 
$PR = $db->db_fetch_array($SQL);

include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../js/x0popup-master/dist/x0popup.min.css" rel="stylesheet" type="text/css">
<?php include('../EWT_ADMIN/link.php'); ?>
<script src="../js/ckeditor/ckeditor.js"></script> 
<script src="../js/x0popup-master/dist/x0popup.min.js"></script> 
<link rel="stylesheet" type="text/css" href="../js/jquery-confirm-master/css/jquery-confirm.css"/>
<script language="JavaScript" src="date-picker.js"></script>
<script language="JavaScript" src='../scripts/innovaeditor.js'></script>


<body leftmargin="0" topmargin="0">
<?php include('top.php');?>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?=$lang_add_survey;?></h4>
</div>

<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" >
<!--<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php //echo urlencode("หน้าหลัก".$text_genbanner_function1);?>&module=banner&url=<?php //echo urlencode("main_group_banner.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="banner_gadd.php?flag=add" target="_self"><img src="../theme/main_theme/g_add.gif"  width="16" height="16"  align="absmiddle" border="0"> 
      เพิ่มหมวด</a>
<a href="article_gadd.php?p=0" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
<span class="glyphicon glyphicon-plus-sign "></span>  เพิ่มกลุ่มข่าวและบทความ
</button>
</a> --> 	  
<a href="add_survey1.php" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<span class="glyphicon glyphicon-plus-sign "></span>  เพิ่มแบบฟอร์ม
</button>
</a>
<a href="index.php" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>
</div>	
</div>
<hr>
</div>
<div class="clearfix">&nbsp;</div>


<div class="col-md-12 col-sm-12 col-xs-12" >


<form name="form1" method="post" action="function_save.php" onSubmit="return checkvalid();">
<div class="panel panel-default" >
<div class="panel-heading form-inline" ><h4 class=""><?=$lang_add_survey;?></h4></div>
<div class="panel-body">

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="topic"><?=$lang_add_subject ; ?> : </label>
		<textarea   class="form-control" name="topic"  id="topic"  cols="40" rows="5" ><?=$PR['s_title'];?></textarea>
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="end_page"><?php echo $lang_add_thankyou; ?> : </label>
		<div class="form-inline">
        <input class="form-control" name="end_page" type="text" id="end_page"  style="width:90%" value="<?=$PR['end_page']; ?>" />

		<!--<button type="button" class="btn btn-info  btn-lm " onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&filename=&o_value=window.opener.document.form1.end_page.value','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_add_choosepage; ?>
		</button>-->
		
		<button type="button" class="btn btn-warning  btn-lm " onClick="document.form1.end_page.value='survey_thank.php'" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?=$lang_survey_default_value; ?>
		</button>
		</div>
	  </div>
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_error;?> : </label>
        <textarea   class="form-control" name="error_page"  id="error_page2"  cols="40" rows="5" ><?=$PR['start_page'];?></textarea>
      </div>
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">	 
        <label for="file_page"><?="เอกสารแนบ ";?> : </label> 
		<div class="form-inline">
		<input class="form-control" name="file_page" type="text" id="file_page2" style="width:90%" value="<?=$PR['file_page']; ?>"   />  
		
		<button type="button" class="btn btn-info  btn-lm " onClick="win2 = window.open('../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form1.file_page.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');win2.focus();	" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?="เลือกไฟล์";?>
		</button>
	  </div>
	  </div>
</div>	  


<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="mail_data"><?="emil ตอบกลับ "?> : </label>
		<input class="form-control" name="mail_data" type="text" id="mail_data2" value="<?=$PR['mail_data'];?>" />
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>
<?php
	$DDT = explode("-",$PR['s_start']);
	$EDT = explode("-",$PR['s_end']);
?>
<input name="s_id" type="hidden" id="s_id" value="<?=$s_id; ?>">
<input name="Flag" type="hidden" id="Flag" value="1">
<input name="design" type="hidden" id="design" value="<?=$PR['design'];?>">

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_start"><?=$lang_edit_start;?><span class="text-danger">*</span> : </label>
            <div class='input-group date' id='datetimepicker'>
                <input type='text' class="form-control datepicker"  name="date_start"  id="date_start" value="<?=$DDT[2]."/".$DDT[1]."/".$DDT[0]; ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_last"><?=$lang_edit_end;?><span class="text-danger">*</span> : </label>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control datepicker"  name="date_last"  id="date_last" value="<?=$EDT[2]."/".$EDT[1]."/".$EDT[0]; ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>
</div>
</div>

<div class="panel-footer text-center" >
<button type="submit" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_save; ?>" >
<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?=$lang_survey_save; ?>
</button> 
</div>
</div>
<hr>
<div class="clearfix">&nbsp;</div>
	
</div>
</form>

</div>
</div>
</div>
</div>
<div id="box_popup" class="layer-modal"></div>
<?php
include('footer.php');
?>
</body>
</html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.th.min.js"></script>
<script>
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
            thaiyear: true ,
			changeYear: true,			
        })
		.datepicker("setDate", new Date(today.getFullYear()+543, today.getMonth(), today.getDate()));       
});
</script>
<script >

function checkvalid(){

if(document.form1.topic.value==""){
	alert("<?php echo $lang_add_warn_subject ?>");
	return false;
	
}else if(document.form1.date_start.value==""){
	alert("<?php echo $lang_add_warn_start ?>");
	return false;

}else{
	return true;
	}
}

</script>
<?php @$db->db_close(); ?>