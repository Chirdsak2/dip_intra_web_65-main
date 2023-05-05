<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 

include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../js/x0popup-master/dist/x0popup.min.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<script src="../js/ckeditor/ckeditor.js"></script> 
<script src="../js/x0popup-master/dist/x0popup.min.js"></script> 
<link rel="stylesheet" type="text/css" href="../js/jquery-confirm-master/css/jquery-confirm.css"/>

<script language="JavaScript" src='../ewt/scripts/innovaeditor.js'></script>
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>



<body leftmargin="0" topmargin="0">
<?php include('top.php');?>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<!--<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?=$lang_add_survey;?></h4>
</div>-->
<div class="container-fluid" >
<h2><?=$lang_add_survey;?></h2>
<p></p> 
              
<ol class="breadcrumb">
<li><a href="index.php">บริหารแบบฟอร์มออนไลน์ (Form Generator)</a></li>
<li><?=$lang_add_survey;?></li>    
</ol>

</div>

<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" >	
<a href="index.php" target="_self">
<button type="button" class="btn btn-info  btn-md " >
<i class="fas fa-undo-alt" aria-hidden="true"></i>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>
</div>	
</div>

</div>


<div class="col-md-12 col-sm-12 col-xs-12" >
<hr>
<div class="panel panel-default" >
<div class="panel-heading form-inline" ><h4 class=""><?=$lang_add_survey;?></h4></div>
<div class="panel-body">
<form name="form1" method="post" >
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="topic"><?=$lang_add_subject ; ?><span class="text-danger">*</span> : </label>
		<textarea   class="form-control" name="topic"  id="topic"  cols="40" rows="5" ></textarea>
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="end_page"><?php echo $lang_add_thankyou; ?> : </label>
		<div class="form-inline">
        <input class="form-control" name="end_page" type="text" id="end_page"  style="width:90%" value="" />

		<!--<button type="button" class="btn btn-info  btn-lm " onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&filename=&o_value=window.opener.document.form1.end_page.value','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_add_choosepage; ?>
		</button>-->
		
		<button type="button" class="btn btn-warning  btn-lm " onClick="document.form1.end_page.value='more_formgenerator.php'" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?=$lang_survey_default_value; ?>
		</button>
		</div>
	  </div>
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_error;?> : </label>
        <textarea   class="form-control" name="error_page"  id="error_page2"  cols="40" rows="5" ></textarea>
      </div>
</div>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">	 
        <label for="file_page"><?="เอกสารแนบ ";?> : </label> 
		<div class="form-inline">
		<input class="form-control" name="file_page" type="text" id="file_page2" style="width:90%" value=""   />  
		
		<button type="button" class="btn btn-info  btn-lm " onClick="win2 = window.open('../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form1.file_page.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');win2.focus();	" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?="เลือกไฟล์";?>
		</button>
	  </div>
	  </div>
</div>	  


<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="mail_data"><?="emil ตอบกลับ "?> : </label>
		<input class="form-control" name="mail_data" type="text" id="mail_data2" value="" />
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>	  
</div>

<input name="proc" type="hidden" id="proc" value="1">

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_start"><?=$lang_edit_start;?><span class="text-danger">*</span> : </label>
            <div class='input-group date' id='datetimepicker'>
                <input type='text' class="form-control datepicker" data-date-format="mm/dd/yyyy" data-date-language="th-th" name="date_start"  id="date_start" value=""/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_last"><?=$lang_edit_end;?><span class="text-danger">*</span> : </label>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control datepicker" data-date-format="mm/dd/yyyy" data-date-language="th-th"  name="date_last"  id="date_last" value=""/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>
</div>
</div>
</form>
<div class="panel-footer text-center" >
<button onclick="JQAdd_survey1();" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
		<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?=$lang_survey_save; ?>
		</button>
</div>
</div>




<!--<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="topic"><?=$lang_add_subject;?><span class="text-danger">*</span> : </label>
        <textarea   class="form-control" name="topic"  id="topic"  cols="60" rows="6" ></textarea>
      </div>
</div>	  
</div>
</div>

<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_error;?> : </label>
        <textarea   class="form-control" name="error_page"  id="error_page"  cols="60" rows="6" ></textarea>
      </div>
</div>	  
</div>
</div>

<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="mail_data"><?=$lang_add_start;?><span class="text-danger">*</span> : </label>
		<input class="form-control"  name="date_start" type="text" size="10" id="date_start"> <a href="#show" onClick="return showCalendar('date_start', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="absmiddle"></a>
      </div>	  
</div>
</div>
</div>

<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="mail_data"><?=$lang_add_end;?><span class="text-danger">*</span> : </label>
		<input  class="form-control" name="date_last" type="text" size="10" id="date_last"> <a href="#show" onClick="return showCalendar('date_last', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="absmiddle"></a>
      </div>	  
</div>
</div>
</div>


<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="end_page"><?php echo $lang_add_thankyou; ?> : </label>
        <input class="form-control" name="end_page" type="text" id="end_page" size="40"  value="" />
      </div>
</div>
<div class="form-group row">
	  <div class="col-md-12 col-sm-12 col-xs-12">
		<button type="button" class="btn btn-info  btn-lm " onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&filename=&o_value=window.opener.document.form1.end_page.value','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_add_choosepage; ?>
		</button>
		
		<button type="button" class="btn btn-warning  btn-lm " onClick="document.form1.end_page.value='survey_thank.php'" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_survey_default_value; ?>
		</button>
		
	  </div>
</div>
</div>
</div>

<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="file_page"><?="เอกสารแนบ ";?> : </label>
		<input class="form-control" name="file_page" type="text" id="file_page2" size="40" value=""   />
		</div>
</div>
<div class="form-group row">
	  <div class="col-md-12 col-sm-12 col-xs-12">		
		<button type="button" class="btn btn-info  btn-lm " onClick="win2 = window.open('../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form1.file_page.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');win2.focus();	" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?="เลือกไฟล์";?>
		</button>
	  </div>	  
</div>
</div>
</div>

<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="mail_data"><?=$lang_add_mail;?> : </label>
		<input class="form-control" name="mail_data" type="text" id="mail_data2" size="40" value="<?=$PR['mail_data'];?>" />
		<p><?//=$lang_add_Remarkmail;?></p>
		
      </div>
	  
</div>
</div>
</div>
<input name="proc" type="hidden" id="proc" value="1">

</form>

<div class="form-group text-center">
<div class="form-inline">
<div class="form-group row">
		<button onclick="JQAdd_survey1();" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
		<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?=$lang_survey_save; ?>
		</button>		
</div>
</div>
</div>-->


 <!--<table width="70%" height="80%" border="0" align="center" cellpadding="5" cellspacing="1" bordercolor="B2B4BF" class="ewttableuse">
    <tr class="ewttablehead"> 
      <td colspan="2"> <?php echo $lang_add_survey ?> </td>
    </tr>
    <tr bgcolor="#FFFFFF" valign="top"> 
      <td width="38%"><?php echo $lang_add_subject ?> <font color="#FF0000">*</font></td>
      <td width="62%"> <textarea name="topic" cols="40" rows="5" wrap="VIRTUAL" id="topic">  <?php
			  function encodeHTML($sHTML)
				{
				$sHTML=ereg_replace("&","&amp;",$sHTML);
				$sHTML=ereg_replace("<","&lt;",$sHTML);
				$sHTML=ereg_replace(">","&gt;",$sHTML);
				return $sHTML;
				}
			  if(isset($PR[q_des]))
				{
				$sContent=stripslashes($PR[q_des]); /*** remove (/) slashes ***/
				echo encodeHTML($sContent);
				}
		  ?>
			</textarea> <script>
		var oEdit1 = new InnovaEditor("oEdit1");
		
		oEdit1.width="100%";
		oEdit1.height="200";
		
    oEdit1.tabs=[
    ["tabHome", "", ["grpFont", "grpPara"]]
    ];

    oEdit1.groups=[
    ["grpFont", "", ["FontName", "FontSize", "BRK", "Bold", "Italic", "Underline","Strikethrough","Superscript","Subscript", "ForeColor", "BackColor"]],
    ["grpPara", "", ["Paragraph", "Indent", "Outdent", "LTR", "RTL", "BRK", "JustifyLeft", "JustifyCenter","JustifyRight","JustifyFull", "Numbering","Bullets"]]
    ];
		oEdit1.mode="HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"
		
		oEdit1.REPLACE("topic");
		</script> </td>
    </tr>
    <tr bgcolor="#FFFFFF" height="25"> 
      <td><?php echo $lang_add_start ?> <font color="#FF0000">*</font></td>
      <td> <input name="date_start" type="text" size="10" id="date_start"> <a href="#show" onClick="return showCalendar('date_start', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="absmiddle"></a>      </td>
    </tr>
    <tr bgcolor="#FFFFFF" height="25"> 
      <td><?php echo $lang_add_end ?> <font color="#FF0000">*</font></td>
      <td > <input name="date_last" type="text" size="10" id="date_last"> <a href="#show" onClick="return showCalendar('date_last', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="absmiddle"></a>      </td>
    </tr>
    <tr bgcolor="#FFFFFF" height="25" style="display:none"> 
      <td><?php echo $lang_add_section?></td>
      <td> <input name="part1" type="text" id="part1" value="1" size="5"> <?php echo $lang_add_section_unit ?>      </td>
    </tr>
	<tr bgcolor="#FFFFFF" height="25" > 
      <td><?php echo $lang_add_error ?></td>
      <td> <textarea name="error_page" cols="40" id="error_page"></textarea>      </td>
    </tr>
    <tr bgcolor="#FFFFFF" height="25"> 
      <td><?php echo $lang_add_thankyou?></td>
      <td><input name="end_page" type="text" id="end_page" value="index.php" size="40">
      <a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.form1.end_page.value','WebsiteLink','top=100,left=100,width=660,height=500,resizable=1,status=0');win2.focus();	"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a>      </td>
    </tr>
    <tr bgcolor="#FFFFFF" height="25"> 
      <td><?php echo $lang_add_doc?></td>
      <td> <input name="file_page" type="text" id="file_page" value="" size="40"> 
        <a href="#browse" onClick="win2 = window.open('../FileMgt/download_insert.php?stype=link&Flag=Link&o_value=window.opener.document.form1.file_page.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');win2.focus();	"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a>      </td>
    </tr>
    <tr bgcolor="#FFFFFF" height="25"> 
      <td><?php echo $lang_add_mail?></td>
      <td> <input name="mail_data" type="text" id="mail_data" value="" size="50"> <br>
              <?php echo $lang_add_Remarkmail ?>      </td>
    </tr>
    <tr bgcolor="#FFFFFF" height="25"> 
      <td>&nbsp;</td>
      <td> <input type="submit" name="Submit" value="<?php echo $lang_add_create ?>"> 
        <input name="Flag" type="hidden" id="Flag" value="1"> </td>
    </tr>
  </table>  
  <br>-->





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
            todayBtn: true,
            language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true  			
        })
		.datepicker("setDate", new Date(today.getFullYear(), today.getMonth(), today.getDate()));       
});
</script>
<script>

function checkvalid(t){

if(document.form1.topic.value==""){
	alert("<?php echo $lang_add_warn_subject ?>");
//document.form1.topic.focus();
	return false;
	
}
 if(document.form1.date_start.value==""){
	alert("<?php echo $lang_add_warn_start ?>");
	document.form1.date_start.focus();
	return false;

}
 if(document.form1.date_last.value==""){
	alert("<?php echo $lang_add_warn_end ?>");
	document.form1.date_last.focus();
	return false;
	
}
 if(document.form1.part1.value==""){
	alert("<?php echo $lang_add_warn_section ?>");
	document.form1.part1.focus();
	return false;

}
	if(form1.mail_data.value != '' && !validEMail(form1.mail_data.value.toLowerCase())){
				alert('กรุณาระบุ e-mail ให้ถูกต้อง!');
				return false;
		}

	return true;
}
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
}
function validEMail(mo){
		if (validLength(mo,1,50)){
			if (mo.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
				return true;
			else return false;
 		}
		return true;
}
</script>
<?php @$db->db_close(); ?>