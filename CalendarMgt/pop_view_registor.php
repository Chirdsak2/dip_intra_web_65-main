<?php
include("../EWT_ADMIN/comtop_pop.php");

$event_id = (int)(!isset($_GET['event_id']) ? 0 : $_GET['event_id']);
$_sql = $db->query("SELECT * 
					FROM cal_registor_event 
					WHERE cal_event_id ='{$event_id}' 
					ORDER BY cal_registor_event.cal_registor_id DESC
					");
$a_rows = $db->db_num_rows($_sql);		 
?>

<form id="form_main1" name="form_main1" method="POST" action="<?php echo getLocation('func_add_faq_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">  
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x color-white"></i></button>
<h4 class="modal-title color-white"><i class="fa fa-th-list" aria-hidden="true"></i> <?php echo "รายชื่อผู้ลงทะเบียนเข้าร่วมกิจกรรม";?></h4>

</div>

<div class="modal-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right m-b-sm"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fas fa-file-export"></i>&nbsp;export <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <!--<li class="pointer"><a onClick="boxPopup('<?php echo linkboxPopup();?>export_survey_xlsx.php');" ><i class="fas fa-file-excel text-success  text-medium"></i>&nbsp;<?php echo "Excel";?></a></li>
			<li class="pointer"><a onClick="boxPopup('<?php echo linkboxPopup();?>export_survey_pdf.php');" ><i class="fas fa-file-pdf  text-danger text-medium"></i>&nbsp;<?php echo "PDF";?></a></li>-->
			<li class="pointer"><a href="export_cal_registor_xlsx.php?event_id=<?php echo $event_id;?>" download ><i class="fas fa-file-excel text-success  text-medium"></i>&nbsp;<?php echo "Excel";?></a></li>

		</ul>
</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 "  >
<div class="table-responsive">     
	<table class="table table-striped">  
    <thead>
      <tr>
	    <th class="text-center" style="width:5%;">#</th>
        <th class="text-center" style="width:40%;">ชื่อ - สกุล</th>
        <th class="text-center" style="width:20%;">เบอร์โทร</th>
		<th class="text-center" style="width:20%;">อีเมล์</th>
      </tr>
    </thead>
<?php
$i=1;
	while($a_data = $db->db_fetch_array($_sql)){
?>
<tbody>
      <tr>
	    <td><?php echo $i;?></td>
        <td><i class="fas fa-user-circle color-ewt"></i>&nbsp;<?php echo $a_data['cal_registor_name']; ?></td>
        <td><?php echo $a_data['cal_registor_tel']; ?></td>
		<td><?php echo $a_data['cal_registor_email']; ?></td>
      </tr>	
</tbody>
<?php 
$i++;
 }
?>
</table>	

</div>
</div>
</div> 	
</div>
		
<div class="modal-footer ">
<!--<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_faq_group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo "บันทึก";?>
</button>
</div>
<div class="btn-group float-right text-right">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fas fa-file-export"></i>&nbsp;export <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
			<li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_export_banner_stat_pdf.php');" ><i class="fas fa-file-pdf  text-danger text-medium"></i>&nbsp;<?php echo "PDF";?></a></li>
		</ul> 
</div>-->
<div class="col-md-12 col-sm-12 col-xs-12 text-center">  
<button onclick="$('#box_popup').fadeOut();" type="button" class="btn btn-warning  btn-ml"> 
<i class="far fa-times-circle fa-1x  color-white"></i>&nbsp;<?php echo 'Close';?> 
</button>
</div>
</div>
</div>

</div>
 
</div>	 
</form>
	
<script>  
$(document).ready(function() {
 var today = new Date();
 $('.datepicker')		
        .datepicker({
            format: 'dd/mm/yyyy',
            language: 'th-th',
			thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
            rightArrow: '<i class="fas fa-angle-double-right"></i>',
        })
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	
});

function JQSet_Cal_User(cid,cname){
	//alert(cname);
	document.getElementById('gen_user_id').value = cid;
	document.getElementById('calendar_contact').value = cname;
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