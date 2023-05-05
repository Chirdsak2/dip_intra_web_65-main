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

<form id="form_main1" name="form_main1" method="POST" action="<?=getLocation('func_add_faq_group')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Cate">

<div class="container" >   
<div class="modal-dialog modal-ml" >

<div class="modal-content">
<div class="modal-header ">
<button type="button" class="close" onclick="$('#box_popup2').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
<h4 class="modal-title"> <?="รายชื่อบุคคลากร";?></h4>
</div>

<div class="modal-body">

<div class="card ">
<div class="scrollbar scrollbar-near-moon thin">
<div class="card-header ewt-bg-success m-b-sm" >
<div class="card-title text-left"><b></b></div>
</div>

<div class="card-body" >
<?php
$i=1;
	while($a_data = $db->db_fetch_array($_sql)){
?>
<div class="col-md-12 col-sm-12 col-xs-12 text-left">
<img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle">
<a class="pointer" onClick="JQSet_Cal_User('<?=$a_data['gen_user_id'];?>','<?=$a_data['name_thai']; ?> <?=$a_data['surname_thai']; ?>');$('#box_popup2').fadeOut();">
<i class="fas fa-user-circle color-ewt"></i>&nbsp; 
<?=$a_data['name_thai']; ?> <?=$a_data['surname_thai']; ?>
</a>
</div>
<?php 
	$i++;
 }
?>	

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