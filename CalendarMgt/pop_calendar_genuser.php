<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$db->query("USE " . $EWT_DB_USER);

// $_sql = $db->query("SELECT * FROM gen_user 
// 					INNER JOIN org_name ON org_name.org_id = gen_user.org_id 
// 					WHERE status ='1'
// 					ORDER BY gen_user.gen_user_id DESC LIMIT 0,5");
// $a_rows = $db->db_num_rows($_sql);
$_sql = "SELECT * FROM USR_MAIN WHERE USR_ID != 1
AND USR_MOVEMENT != 'ลาออก'
AND USR_MOVEMENT != 'ไล่ออก'
AND USR_MOVEMENT != 'เกษียณอายุ'
AND USR_MOVEMENT != 'ถึงแก่กรรม' 
ORDER BY USR_ID ASC 
OFFSET 0 ROWS FETCH NEXT 5 ROWS ONLY";
$user = $sso->getFetchAll($_sql);
//$s_count = $db->query($statement);
//$a_count = $db->db_fetch_array($s_count);
//$total_record = $a_count['b'];
//$total_page = (int)ceil($total_record / $perpage);
?>

<!-- <form id="form_main1" name="form_main1" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Add_Cate"> -->

	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup2').fadeOut();"><i class="far fa-times-circle fa-1x color-white"></i></button>
					<h4 class="modal-title color-white"><i class="fas fa-user-circle"></i> <?php echo "รายชื่อบุคคลากร"; ?></h4>
				</div>

				<div class="modal-body">
					<div class="card ">
						<div class="card-body">
							<!-- <?php
									//$i = 1;
									//while ($a_data = $db->db_fetch_array($_sql)) {
									?>
									<div class="form-group row">
									<div class="col-md-12 col-sm-12 col-xs-12 text-left">
									<img src="<?php echo $IMG_PATH; ?>images/grabme.svg">   
									<a class="pointer" onClick="JQSet_Cal_User('<?php echo $a_data['gen_user_id']; ?>','<?php echo $a_data['name_thai']; ?> <?php echo $a_data['surname_thai']; ?>');$('#box_popup2').fadeOut();">
									<img src="<?php echo org::getGenUserImg($a_data['gen_user_id']); ?>" alt="" class="img-circle img-rounded " style="width:24px;height:24px;">
									<?php echo $a_data['name_thai']; ?> <?php echo $a_data['surname_thai']; ?>
									</a>
									</div>
									</div>
									<?php //$i++;} 
									?>  -->

							<!-- <form id="form_search"> -->
								<input type="text" class="form-control" name="search_user" id="search_user" placeholder="ค้นหารายชื่อผู้ประสานงาน" oninput="searhUser();">
							<!-- </form> -->
							<hr>
							<table width="100%" border="0" align="center" class="table table-bordered">
								<thead id="list_search">
									<?php
									$i = 1;
									//while ($a_data = $db->db_fetch_array($_sql)) {
									foreach($user as $a_data){
										$user_file = "../ewt/prd_intra_web/profile/" . $a_data["USR_PICTURE"];
										$user_img = (empty($a_data["USR_PICTURE"]) ? "../EWT_ADMIN/images/user001.png" : $user_file);
										$sql = $db->query("SELECT gen_user_id FROM gen_user WHERE gen_user = '{$a_data['USR_USERNAME']}' LIMIT 1;");
										$u_data = $db->db_fetch_array($sql);
										//org::getGenUserImg($a_data['gen_user_id']); ?>
										<tr>
											<td>
												<img src="<?php echo $IMG_PATH; ?>images/grabme.svg">
												<a class="pointer" onClick="JQSet_Cal_User('<?php echo $u_data['gen_user_id']; ?>','<?php echo $a_data['USR_FNAME']; ?> <?php echo $a_data['USR_LNAME']; ?>');$('#box_popup2').fadeOut();">
													<img src="<?php echo $user_img; ?>" alt="" class="img-circle img-rounded" style="width:24px;height:24px;">
													&nbsp;<?php echo $a_data['USR_FNAME']; ?> <?php echo $a_data['USR_LNAME']; ?>
												</a>
											</td>
										</tr>
									<?php
										$i++;
									} ?>
								</thead>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer ">
					<!--<div class="col-md-12 col-sm-12 col-xs-12 text-center">
					<button onclick="JQAdd_faq_group($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
					<i class="fas fa-save"></i>&nbsp;<?php echo "บันทึก"; ?>
					</button>
					</div>-->
				</div>
			</div>

		</div>

	<!-- </div>
</form> -->

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

	function JQSet_Cal_User(cid, cname) {
		//alert(cname);
		document.getElementById('gen_user_id').value = cid;
		document.getElementById('calendar_contact').value = cname;
		//document.getElementById('txtshow').innerHTML = cname;
		document.getElementById('list_calendar_phone').style.display = 'block';
		document.getElementById('list_calendar_department').style.display = 'block';
		$("#box_popup2").fadeOut();
	}

	function JQCheck_Cate(form) {
		var name = form.attr('name');
		var check = $('input:checkbox[name=' + name + ']:checked').val();
		if (check == 'Y') {
			$('#category_parent').attr("disabled", false);
			$('#category_parent').attr("required", false);
		} else {
			$('#category_parent').attr("disabled", true);
			$('#category_parent').attr("required", true);
		}
		console.log(check);
	}

	function searhUser() {
		$.ajax({
			type: 'POST',
			url: 'pop_calendar_getuser.php',
			data: {
				search: $('#search_user').val(),
			},
			datatype: "text",
			success: function(data) {
				$('#list_search').html(data);
			},
			error: function() {
				console.log('Error');
			}
		});
	}
</script>