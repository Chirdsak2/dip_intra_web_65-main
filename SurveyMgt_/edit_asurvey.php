<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 

$s_psurvey = $db->query("SELECT * FROM p_survey WHERE s_id = '{$s_id}'");
$PR = $db->db_fetch_array($s_psurvey);
$SQL2 = $db->query("SELECT * FROM p_cate WHERE s_id = '{$s_id}' ORDER BY c_d");

include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../js/x0popup-master/dist/x0popup.min.css" rel="stylesheet" type="text/css">
<?php include('../EWT_ADMIN/link.php'); ?>
<script src="../js/ckeditor/ckeditor.js"></script> 
<script src="../js/x0popup-master/dist/x0popup.min.js"></script> 
<link rel="stylesheet" type="text/css" href="../js/jquery-confirm-master/css/jquery-confirm.css"/>
<script language="JavaScript" src="date-edit.js"></script>
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>

<body leftmargin="0" topmargin="0">
<?php include('top.php');?>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<!--<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">แก้ไขแบบฟอร์ม</h4>
</div>-->
<div class="container-fluid" >
<h2>แก้ไขแบบฟอร์มออนไลน์</h2>
<p></p> 
              
<ol class="breadcrumb">
<li><a href="index.php">บริหารแบบฟอร์มออนไลน์ (Form Generator)</a></li>
<li class="">แก้ไขแบบฟอร์มออนไลน์</li>       
</ol>

</div>

<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" >	  
<a href="add_survey1.php" target="_self">
<button type="button" class="btn btn-info  btn-md " >
<i class="fas fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;เพิ่มแบบฟอร์มออนไลน์
</button>
</a>
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
<form name="form1" method="post" action="edit_function.php" onSubmit="return checkvalid(this);">
<div class="panel panel-default" >
<div class="panel-heading form-inline" ><h4 class="">แก้ไขแบบฟอร์มออนไลน์</h4></div>
<div class="panel-body">	

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="end_page"><?php echo $lang_add_thankyou; ?> : </label>
		<div class="form-inline">
        <input class="form-control" name="end_page" type="text" id="end_page"  style="width:90%" value="<?=$PR['end_page']; ?>" />

		<!--<button type="button" class="btn btn-info  btn-lm " onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&filename=&o_value=window.opener.document.form1.end_page.value','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_add_choosepage; ?>
		</button>-->
		
		<button type="button" class="btn btn-warning  btn-lm " onClick="document.form1.end_page.value='more_formgenerator.php'" >
		<span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;<?php echo $lang_survey_default_value; ?>
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
<input name="std" type="hidden" id="std" value="<?=$DDT[2]."/".$DDT[1]."/".$DDT[0]; ?>">
<input name="ed" type="hidden" id="ed" value="<?=$EDT[2]."/".$EDT[1]."/".$EDT[0]; ?>">
<input name="Flag" type="hidden" id="Flag" value="3">

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_start"><?=$lang_edit_start;?><span class="text-danger">*</span> : </label>
            <div class='input-group date' id='datetimepicker'>
                <input type='text' class="form-control datepicker"  name="date_start"  id="date_start" value="<?php echo $DDT[2]."/".$DDT[1]."/".$DDT[0]; ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>



<div class="col-md-6 col-sm-6 col-xs-12">
<label for="date_last"><?=$lang_edit_end;?><span class="text-danger">*</span> : </label>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control datepicker"  name="date_last"  id="date_last" value="<?php echo $EDT[2]."/".$EDT[1]."/".$EDT[0]; ?>"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
	</div>
</div>
</div>
</div>
<hr>
<div class="clearfix">&nbsp;</div>

<div class="panel panel-default"  id="frm_edit_s">
<div class="panel-heading form-inline" >
<div class="row">
<div class="col-md-9 col-sm-9 col-xs-12 text-left" > 
<h4><?=$PR['s_title']; ?></h4>
</div>
<div class="col-md-3 col-sm-3 col-xs-12 text-right" > 	
<a onclick="boxPopup('<?=linkboxPopup();?>pop_edit_s.php?s_id=<?=$s_id;?>');" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_edit_topic; ?>" >
<button type="button" class="btn btn-warning btn-lm"   _onClick="window.open('edit_s.php?s_id=<?php echo $s_id; ?>','survey','width=500,height=200,resizable=1,status=0,scrollbars=1,location=0,top=40,left=200');" >
<span class="glyphicon glyphicon-pencil"></span>&nbsp;<?=$lang_survey_edit_topic; ?>
</button> 
</a>  
</div>
</div>	
</div>
	
<div class="panel-body">	
<div class="table-responsive">	
            <table width="100%" border="0" align="center" class="table table-bordered" >
            <tr style="background-color:#f5f5f5;"> 
            <td width="89%">&nbsp;</td>
            <td width="11%" colspan="2" align="center"></td>
            </tr>
 <?php
		$i = 0;
		  while($R = $db->db_fetch_array($SQL2)){ 
		 $SQL3 = $db->query("SELECT * FROM p_question WHERE c_id = '{$R[c_id]}' ORDER BY q_pos ASC");
		 $row = $db->db_num_rows($SQL3);
?>
            <tr class="bg-info"> 
			<td > 
			<li>
			<?=$lang_add3_part; ?> 
			<?=$R['c_d']; ?>: <?=$R['c_name'];?>
			</li>
			</td>
			<td>
			<!--<input name="Butt<?=$i;?>2" type="button" value="<?//=$lang_add3_edititem; ?> <?//=$R['c_d']; ?>" class="txt9" onClick="window.open('a_edit.php?post=<?php echo $R[c_d]; ?>&path=<?php echo $R[c_id]; ?>','part','width=750,height=600,resizable=1,status=0,scrollbars=1,location=0,top=40,left=200');">-->
			<a onclick="boxPopup('<?=linkboxPopup();?>pop_a_edit.php?post=<?=$R['c_d']; ?>&path=<?=$R['c_id']; ?>');" data-toggle="tooltip" data-placement="right" title="<?=$lang_add3_edititem; ?>" >
			<button type="button" class="btn btn-warning btn-sm"   _onClick="window.open('edit.php?post=<?=$R['c_d']; ?>&path=<?=$R['c_id']; ?>','survey','width=500,height=200,resizable=1,status=0,scrollbars=1,location=0,top=40,left=200');" >
			<span class="glyphicon glyphicon-pencil"></span>&nbsp;<?=$lang_add3_edititem; ?>&nbsp;<?=$R['c_d']; ?>
			</button> 
			</a>
			</td>
			<td >
			<?php if(($R['c_gp'] == "Y") and($row>0)){ ?>
			<!--<input name="Cutt<?=$i;?>" type="button" value="<?=$lang_add3_edititemquestion;?>" class="txt9" onClick="window.open('a_edit_ans1.php?post=<?php echo $R[c_d]; ?>&path=<?php echo $R[c_id]; ?>&type=<?php echo $R[c_gp]; ?>&s_id=<?php echo $s_id; ?>','ans1','width=750,height=600,resizable=1,status=0,scrollbars=1,location=0,top=20,left=200');">-->
			<button type="button" class="btn btn-warning btn-sm"  onClick="window.open('a_edit_ans1.php?post=<?=$R[c_d];?>&path=<?=$R['c_id']; ?>&type=<?=$R['c_gp']; ?>&s_id=<?=$s_id; ?>','ans1','width=750,height=600,resizable=1,status=0,scrollbars=1,location=0,top=20,left=200');" >
			<span class="glyphicon glyphicon-pencil"></span>&nbsp;<?=$lang_add3_edititemquestion; ?> <?=$R['c_d']; ?>
			</button>
			<?php 
			}else{ 
			echo "&nbsp;"; 
			} 
			?>
			</td>
			</tr>
<?php
			if($row > 0){
			$t = 0;
			while($RR = $db->db_fetch_array($SQL3)){
?>
			<tr bgcolor="#FFFFFF"> 
			<td><?=$RR['q_name'];?>&nbsp;<?=$RR['q_des']; ?>
			<div align="center"></div>                  
			</td>
			<td align="center">        
			<!--<input name="But<?=$i;?>" type="button" value="<?//=$lang_survey_edit_question;?> <?//=$RR['q_name'];?>" class="txt9" onClick="window.open('a_edit_question.php?post=<?php //echo $R[c_d]; ?>&path=<?php //echo $R[c_id]; ?>&type=<?php //echo $R[c_gp]; ?>&qid=<?php //echo $RR[q_id]; ?>','ques','width=750,height=650,resizable=1,status=0,scrollbars=1,location=0,top=20,left=200');"> -->                   
			<a onclick="boxPopup('<?=linkboxPopup();?>pop_a_edit_question.php?post=<?=$R['c_d']; ?>&path=<?=$R['c_id']; ?>&type=<?=$R['c_gp']; ?>&qid=<?=$RR['q_id']; ?>');" data-toggle="tooltip" data-placement="right" title="<?=$lang_survey_edit_question; ?>&nbsp;<?=$RR['q_name']; ?>" >
			<button type="button" class="btn btn-warning btn-sm"  >
			<span class="glyphicon glyphicon-pencil"></span>&nbsp;<?=$lang_survey_edit_question; ?>&nbsp;<?=$RR['q_name']; ?>
			</button> 
			</a>
			</td>
			<td align="center">                    
			<?php if($R['c_gp']=="N"){ ?>                    
			<input name="Cut<?=$i; ?>" type="button" value="<?php echo $lang_survey_edit_answer; ?> <?=$RR['q_name'];?>"  class="btn btn-warning btn-sm"  onClick="window.open('a_edit_ans.php?qname=<?=$RR[q_name]; ?>&qid=<?=$RR['q_id']; ?>&s_id=<?=$s_id; ?>','ans','width=750,height=650,resizable=1,status=0,scrollbars=1,location=0,top=20,left=200');">                  
			<!--<a onclick="boxPopup('<?=linkboxPopup();?>pop_a_edit_ans.php?qname=<?=$RR['q_name']; ?>&qid=<?=$RR['q_id'];?>&s_id=<?=$s_id;?>');" data-toggle="tooltip" data-placement="right" title="&nbsp;<?=$lang_survey_edit_answer; ?> <?=$RR['q_name']; ?>" >
			<button type="button" class="btn btn-warning btn-sm"   _onClick="window.open('edit.php?qname=<?=$RR['q_name']; ?>&qid=<?=$RR['q_id'];?>&s_id=<?=$s_id;?>','survey','width=500,height=200,resizable=1,status=0,scrollbars=1,location=0,top=40,left=200');" >
			<span class="glyphicon glyphicon-pencil"></span>&nbsp;<?=$lang_survey_edit_answer; ?> <?=$RR['q_name']; ?>
			</button> 
			</a>-->
			<?php 
			}else{ 
			echo "&nbsp;"; 
			} ?>                    
			</td>
			</tr>
<?php
	$t++;
		 }
			 ?>
            <tr style="background-color:#f5f5f5;"> 
			<td colspan="3">
			<?php echo $lang_add3_howmanyitems1; ?> 
			<?php echo $i+1; ?>
			<?php echo $lang_add3_howmanyitems2; ?>
			<?php echo $row; ?>
			<?php echo $lang_add3_howmanyitems3; ?> 
			<input name="ppp<?php echo $i; ?>" type="hidden" id="ppp<?php echo $i; ?>" value="<?php echo $row; ?>">
			</td>
			</tr>
			<?php }else{ ?>
			<tr> 
			<td colspan="3">
			<img src="dot.gif" width="7" height="7">&nbsp;<?php echo $lang_add3_noitem; ?>
			<div align="right"> </div>
			</td>
			</tr>
<?php
}
	$i++;
		   } 
?>
            </table>
</div>
</div> 
<div class="panel-footer text-center" >
			<!--<input name="SubmitT" type="button" class="txt9" id="Submit1" value="<?=$lang_survey_previewpage;?>" onClick="window.open('survey_p.php?s_id=<?=$s_id;?>','preview','width=500,height=500,resizable=1,status=0,scrollbars=1,location=0,top=40,left=200');">-->
			<a  onclick="boxPopup('<?=linkboxPopup();?>pop_survey.php?s_id=<?=$s_id; ?>');" data-toggle="tooltip" data-placement="top" title="ดูแบบสอบถาม" >
			<button type="button" class="btn btn-info btn-lm" >
			<span class="glyphicon glyphicon-search"></span> <?="ดูแบบสอบถาม"; ?>
			</button>
			</a>			
			<!--<input type="submit" class="txt9" name="Submitz" value="<?//=$lang_survey_save; ?>">-->
            <button type="submit" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
			<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?=$lang_survey_save; ?>
			</button> 			
			<input name="s_id" type="hidden" id="s_id" value="<?=$s_id;?>">
            <input name="aal" type="hidden" id="aal2" value="<?=$i;?>">
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
<script>



function GoNext(){
for(c=1;c<document.form1.allT.value;c++){
if(document.form1.elements["name"+c].value ==""){
alert("<?php echo $lang_add3_pleasequestion; ?>");
document.form1.elements["name"+c].focus();
return false;
}
if(document.form1.elements["s_id"+c].value ==""){
alert("<?php echo $lang_add3_pleasepart; ?>");
document.form1.elements["s_id"+c].focus();
return false;
}
}
}

function ChangeBox(c){
if(document.form1.elements["sel"+c].value =="D"){
document.form1.elements["num"+c].disabled = true;
document.form1.elements["just"+c].disabled = false;
}else if(document.form1.elements["sel"+c].value =="B"){
document.form1.elements["just"+c].disabled = true;
document.form1.elements["num"+c].disabled = false;
}else{
document.form1.elements["just"+c].disabled = false;
document.form1.elements["num"+c].disabled = false;
}
}

function data(c){
if(document.form1.elements["s_id"+c].value =="xxx"){
document.form1.elements["sel"+c].disabled = true;
document.form1.elements["num"+c].disabled = true;
}
<?php
$query1 = $db->query("SELECT * FROM p_cate WHERE s_id = '$s_id' AND  c_gp='Y'");
while($W = mysql_fetch_array($query1)){ ?>
else if(document.form1.elements["s_id"+c].value =="<?php echo $W[c_id]; ?>"){
document.form1.elements["sel"+c].disabled = true;
document.form1.elements["num"+c].disabled = true;
}
<?php }
?>

else{
document.form1.elements["sel"+c].disabled = false;
document.form1.elements["num"+c].disabled = false;
}
}
</script>
<script>
function checkvalid(t){
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