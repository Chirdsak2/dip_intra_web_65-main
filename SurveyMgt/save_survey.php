<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
include("lang_config.php");

$s_id = get('s_id', 0);

$SQL = $db->query("SELECT * FROM p_survey WHERE s_id = '{$s_id}' "); 
$PR = $db->db_fetch_array($SQL);

$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";
$fp1 = @fopen($Path_true."/form_topic_".$s_id.".html", "r");
//if(!$fp1){ die("Cannot write form_topic_".$s_id.".html"); }
while($html1 = @fgets($fp1, 1024)){
	$topic .= $html1;
}
@fclose($fp1);
?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo $txt_form_add ;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="main_survey.php"><?php echo $txt_form_menu_main;?></a></li>
<li class=""><?php echo $txt_form_add ;?></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a href="main_survey.php" target="_self">
<button type="button" class="btn btn-info  btn-md " >
<i class="fas fa-undo-alt" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $txt_ewt_back;?>
</button>
</a>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
			<li><a href="main_survey.php" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?></a></li>
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


<form name="form1" method="post" action="function_save.php" onSubmit="return checkvalid();">
<div class="panel panel-default" >
<div class="panel-heading form-inline" ><h4 class=""><?php echo $lang_add_survey;?></h4></div>
<div class="panel-body">

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="topic"><?php echo $lang_add_subject ; ?> : </label>
		<textarea   class="form-control" name="topic"  id="topic"  cols="40" rows="5" ><?php echo $topic;?></textarea>
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="end_page"><?php echo $lang_add_thankyou; ?> : </label>
		<div class="form-inline">
        <input class="form-control" name="end_page" type="text" id="end_page"  style="width:90%" value="<?php echo $PR['end_page']; ?>" />

		<!--<button type="button" class="btn btn-info  btn-lm " onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&filename=&o_value=window.opener.document.form1.end_page.value','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_add_choosepage; ?>
		</button>-->
		
		<button type="button" class="btn btn-warning  btn-lm " onClick="document.form1.end_page.value='survey_thank.php'" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_survey_default_value; ?>
		</button>
		</div>
	  </div>
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?php echo $lang_add_error;?> : </label>
        <textarea   class="form-control" name="error_page"  id="error_page2"  cols="40" rows="5" ><?php echo $PR['start_page'];?></textarea>
      </div>
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">	 
        <label for="file_page"><?php echo "เอกสารแนบ ";?> : </label> 
		<div class="form-inline">
		<input class="form-control" name="file_page" type="text" id="file_page2" style="width:90%" value="<?php echo $PR['file_page']; ?>"   />  
		
		<button type="button" class="btn btn-info  btn-lm " onClick="win2 = window.open('../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form1.file_page.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');win2.focus();	" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo "เลือกไฟล์";?>
		</button>
	  </div>
	  </div>
</div>	  


<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="mail_data"><?php echo "email ตอบกลับ "?> : </label>
		<input class="form-control" name="mail_data" type="text" id="mail_data2" value="<?php echo $PR['mail_data'];?>" />
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>
<?php
	$DDT = explode("-",$PR['s_start']);
	$EDT = explode("-",$PR['s_end']);
?>
<input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id; ?>">
<input name="Flag" type="hidden" id="Flag" value="1">
<input name="design" type="hidden" id="design" value="<?php echo $PR['design'];?>">

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_start"><?php echo $lang_edit_start;?><span class="text-danger">*</span> : </label>
            <div class='input-group date' id='datetimepicker'>
                <input type='text' class="form-control datepicker"  name="date_start"  id="date_start" value="<?php echo $DDT[2]."/".$DDT[1]."/".$DDT[0]; ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_last"><?php echo $lang_edit_end;?><span class="text-danger">*</span> : </label>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control datepicker"  name="date_last"  id="date_last" value="<?php echo $EDT[2]."/".$EDT[1]."/".$EDT[0]; ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>
</div>
</div>

<div class="panel-footer text-center" >
<button type="submit" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="right" title="<?php echo $lang_survey_save; ?>" >
<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?php echo $lang_survey_save; ?>
</button> 
</div>
</div>

	
</div>
</form>


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
<script>
  CKEDITOR.replace('topic', {
  allowedContent: true,
    customConfig: '../js/ckeditor/custom_config.js'
  });

</script>