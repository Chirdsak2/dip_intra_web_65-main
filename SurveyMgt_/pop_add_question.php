<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php"); 

echo $type =  $_GET['type'];
$post =  $_GET['post'];
$path =  $_GET['path'];

?>

<div class="dContainer" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
        <div class="modal-header">
           <button type="button" class="close" onclick="$('#box_popup').fadeOut();" >&times;</button>
          <h4 class="modal-title"><?=$lang_add_question_createquestion; ?> <?=$post; ?></h4>
        </div>
		
<form name="form1" method="post" >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">
<input name="type" type="hidden" id="type" value="<?=$type;?>">

<?php if($type == "N"){ ?>
<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="ch"><?=$lang_add_question_questionnumber; ?><span class="text-danger">*</span> : </label>
<input class="form-control numberint" name="ch"  id="ch"  value=""/>
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="name"><?=$lang_add_question_question;?><span class="text-danger">*</span> : </label>
<textarea   class="form-control" name="name"  id="name"  cols="40" rows="5" ></textarea>
</div>
</div>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
<label for="sel"><?=$lang_add_question_answertype;?><span class="text-danger">*</span> : </label>
<select name="sel" id="sel" onChange="ChangeBox();" class="form-control">
          <option value="A">Radio Box</option>
          <option value="B">Check Box</option>
          <option value="C">List Box</option>
          <option value="D">Text Box</option>
		  <option value="E">Browse File</option>
		  <option value="F">Calendar</option>
		  <option value="G">Area</option>
</select>
</div>
</div>
<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="num"><?=$lang_add_question_answerhowmany;?><span class="text-danger">*</span> : </label>
 <input name="num" type="text" id="num" size="5" class="form-control numberint">
</div>
</div>

<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="pos"><?=$lang_add_question_rank;?><span class="text-danger">*</span> : </label>
 <input name="pos" type="text" id="pos" value="<?=$pos;?>" class="form-control numberint">
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="just"><?=$lang_add_question_require;?><span class="text-danger">*</span> : </label>
<input name="just" type="checkbox" id="just" value="Y">
</div>
</div>

<div class="form-group row" id="email_tr" style="display:none;" >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="email_data"><?="รูปแบบข้อมูล";?> : </label>
<input name="email_data" type="radio" id="email_data1" value=""  checked> ข้อมูลตัวอักษรทั่วไป 
<input name="email_data" type="radio" id="email_data2" value="Y" > ข้อมูลรูปแบบ email 
<input name="email_data" type="radio" id="email_data3" value="N" > ข้อมูลรูปแบบตัวเลข

</div>
</div>

<div class="form-group row" id="email_tr1" style="display:none;" >
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="no_replate"><?='ไม่ต้องการให้ข้อมูลซ้ำ';?> : </label>
<input type="checkbox" name="no_replate" id="no_replate" value="QNR">
</div>
</div>
        <input name="proc" type="hidden" id="proc" value="Q">
        <input name="path" type="hidden" id="path" value="<?=$path; ?>">
		
<?php }elseif($type=="Y"){ ?>

<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="ch"><?=$lang_add_question_questionnumber; ?><span class="text-danger">*</span> : </label>
<input class="form-control numberint" name="ch"  id="ch"  value=""/>
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="name"><?=$lang_add_question_question;?><span class="text-danger">*</span> : </label>
<textarea   class="form-control" name="name"  id="name"  cols="40" rows="5" ></textarea>
</div>
</div>

<div class="form-group row">
<div class="col-md-2 col-sm-2 col-xs-12">
<label for="pos"><?=$lang_add_question_rank;?><span class="text-danger">*</span> : </label>
 <input name="pos" type="text" id="pos" value="<?=$pos;?>" class="form-control numberint">
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<label for="just"><?=$lang_add_question_require;?><span class="text-danger">*</span> : </label>
<input name="just" type="checkbox" id="just" value="Y" checked />
</div>
</div>

<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php
$SQL3 = $db->query("SELECT * FROM p_question WHERE c_id = '{$path}' ");
$row = $db->db_num_rows($SQL3);
if($row == 0){
?>
 <table class="table table-bordered">
    <thead>
      <tr class="info">	
		<th width="20%" class="text-center"></th>
        <th width="60%" class="text-center"><?=$lang_add_question_answerforpart;?> <?=$post;?></th>
		<th width="20%" class="text-center"> คะแนน/น้ำหนัก</th>
      </tr>
    </thead>
    <tbody>
<?php	 
$SQL2 = $db->query("SELECT * FROM p_cate WHERE c_id = '{$path}' ");
$R = $db->db_fetch_array($SQL2);
for($i=0;$i<$R['option2'];$i++){
?>
<tr>
        <td class="text-center" >
		<?=$lang_add_question_answerrank; ?> <?=$i+1 ?>
		</td>
		<td class="text-center" > 
		<input name="ans<?=$i;?>" type="text" id="ans<?=$i;?>" class="form-control"> 
		</td>
		<td class="text-center" > 
		<input name="weight<?=$i;?>" type="text" id="weight<?=$i;?>" value="0" class="form-control numberint" > 
		</td>
</tr>
<?php } } ?>
  </tbody>
    </table>
</div>
</div>		 		
        <input name="proc" type="hidden" id="proc" value="B">
        <input name="path" type="hidden" id="path" value="<?=$path;?>">
        <input name="all" type="hidden" id="all" value="<?=$R['option2'];?>">
<?php } ?>



</div>

</div>
</form>	

<div class="modal-footer">
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<button onclick="JQAdd_question();" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?=$lang_survey_save; ?>
</button> 
<!--<input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
<input name="reset" type="reset" value="ยกเลิก" class="btn btn-warning"  onClick="$('#box_popup').fadeOut();">
<button class="btn btn-warning btn-lm" onClick="$('#box_popup').fadeOut();" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_update; ?>" >
<span class="glyphicon glyphicon-remove"></span>&nbsp;<?="ยกเลิก";?>-->
</button> 
</div>
</div>
</div>


</div>
</div>
</div>

<script >
$(document).ready(function(){ 

$('.numberint').keypress(function (event) {
            return isNumberInt(event, this)
      });
	  
  });
  
  
function ChangeBox(c){

var sel = $("#sel").val();

		if(sel =="D"){
				document.getElementById('num').disabled = true;
				document.getElementById('just').disabled = false;
				//document.form1.num.disabled = true;
				//document.form1.just.disabled = false;
				document.getElementById('email_tr').style.display='';
				document.getElementById('email_tr1').style.display='';
		}else if(sel =="G"){
				document.getElementById('num').disabled = true;
				document.getElementById('just').disabled = false;
				//document.form1.num.disabled = true;
				//document.form1.just.disabled = false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
		}else if(sel =="F"){
				document.getElementById('num').disabled = true;
				document.getElementById('just').disabled = false;
				//document.form1.num.disabled = true;
				//document.form1.just.disabled = false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
		}else if(sel =="E"){
				document.getElementById('num').disabled = true;
				document.getElementById('just').disabled = false;
				//document.form1.num.disabled = true;
				//document.form1.just.disabled = false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
		}else if(sel =="B"){
				document.getElementById('num').disabled = false;
				document.getElementById('just').disabled = true;
				//document.form1.just.disabled = true;
				//document.form1.num.disabled = false;
				document.getElementById('email_data').checked=false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
		}else{
				document.getElementById('num').disabled = false;
				document.getElementById('just').disabled = false;
				document.getElementById('email_data').checked=false;
				document.getElementById('email_tr').style.display='none';
				document.getElementById('email_tr1').style.display='none';
				//document.form1.just.disabled = false;
				//document.form1.num.disabled = false;
		}
}
</script>
