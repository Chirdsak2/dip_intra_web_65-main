<?php
include("../EWT_ADMIN/comtop_pop.php");

$event_id = (int)(!isset($_GET['event_id']) ? 0 : $_GET['event_id']);
$_sql = $db->query("SELECT * 
					FROM cal_registor_event 
					WHERE cal_event_id ='{$event_id}' 
					ORDER BY cal_registor_event.cal_registor_id DESC
					");
$a_rows = $db->db_num_rows($_sql);		
//$s_count = $db->query($statement);
//$a_count = $db->db_fetch_array($s_count);
//$total_record = $a_count['b'];
//$total_page = (int)ceil($total_record / $perpage);
?>

<form id="form_main1" name="form_main1" method="POST" action="<?=getLocation('func_add_faq_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate">

<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?="รายชื่อผู้ลงทะเบียนเข้าร่วมกิจกรรม";?></h4>
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="fas fa-file-export"></i>&nbsp;export <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
			<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_export_banner_stat_pdf.php');" ><i class="fas fa-file-pdf  text-danger text-medium"></i>&nbsp;<?="PDF";?></a></li>
		</ul>
</div>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >

<div class="col-md-12 col-sm-12 col-xs-12 text-left">
  
<table class="table table-bordered">
    <thead>
      <tr>
	    <th>#</th>
        <th>ชื่อ - สกุล</th>
        <th>หมายเลขบัตรประชาชน</th>
        <th>เบอร์โทร</th>
		<th>อีเมล์</th>
      </tr>
    </thead>
<?php
$i=1;
	while($a_data = $db->db_fetch_array($_sql)){
?>
<tbody>
      <tr>
	    <td><?=$i;?></td>
        <td><i class="fas fa-user-circle color-ewt"></i>&nbsp;<?=$a_data['cal_registor_name']; ?></td>
        <td><?=$a_data['cal_registor_idcard']; ?></td>
        <td><?=$a_data['cal_registor_tel']; ?></td>
		<td><?=$a_data['cal_registor_email']; ?></td>
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
<i class="fas fa-save"></i>&nbsp;<?="บันทึก";?>
</button>
</div>-->
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