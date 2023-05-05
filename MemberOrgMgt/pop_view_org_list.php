<?php
include("../EWT_ADMIN/comtop_pop.php");

$u_id = (int)(!isset($_GET['u_id']) ? 0 : $_GET['u_id']);

$db->query("USE " . $EWT_DB_USER);

$s_sql = $db->query("SELECT * FROM `gen_user`
LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
WHERE `gen_user`.`gen_user_id` = '{$u_id}' ");
$a_data = $db->db_fetch_array($s_sql);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_org_list') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Add_Org">

	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content ">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x  color-white"></i></button>
					<h4 class="modal-title color-white"> <i class="fas fa-search"></i> <?php echo $txt_org_view; ?></h4>
				</div>

				<div class="modal-body">

					<div class="row">

						<div class="col-xs-12 col-sm-12 col-md-12 m-t-md m-b">
							<div class="card ">
								<div class="card-header m-b-sm ">
									<div class="card-title text-left">
										<h4><?php echo org::getTitle($a_data['title_thai']) . '' . $a_data['name_thai'] . ' ' . $a_data['surname_thai']; ?></h4>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class=" col-sm-6 col-md-4">
											<img src="<?php echo org::getGenUserImg($a_data['gen_user_id']); ?>" alt="" class="img-rounded img-responsive" />
										</div>
										<div class="col-sm-6 col-md-8">

											<div class="m-b">
												<b>
													<i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
													<?php echo $txt_org_list_pos_name; ?>
												</b>
												&nbsp;:&nbsp;<?php !empty($a_data['pos_name']) ? $a_data['pos_name'] : '-'; ?>
												&nbsp;
											</div>
											<div class="m-b">
												<b>
													<i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
													<?php echo $txt_org_list_pos_person; ?></b>
												&nbsp;:&nbsp;<?php !empty($a_data['position_person']) ? $a_data['position_person'] : ''; ?>
												&nbsp;
												</b>
											</div>
											<div class="m-b">
												<b>
													<i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
													<?php echo $txt_org_list_org_name; ?>
												</b>&nbsp;:&nbsp;
												
												<?php if ($a_data['name_org']) {
													echo $a_data['name_org'];
												} else {
													echo '-';
												} ?>
												&nbsp;
											</div>
											<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
													<?php echo $txt_org_list_email; ?></b>&nbsp;:&nbsp;<?php if ($a_data['email_person']) {
																											echo $a_data['email_person'];
																										} else {
																											echo '-';
																										} ?>
												&nbsp;
											</div>
										</div>
										<!--<div class="col-sm-6 col-md-4">
                        <h4></h4>                      
                        <p><i class="fas fa-at"></i> <?php if ($a_data['email_person']) {
															echo $a_data['email_person'];
														} else {
															echo '-';
														} ?></p>
						<p><i class="fas fa-phone-square"></i>  <?php if ($a_data['tel_in']) {
																	echo $a_data['tel_in'];
																} else {
																	echo '-';
																} ?></p>
						<p><i class="fas fa-map-marker"></i> <cite title="<?php echo $a_data['officeaddress']; ?>"><?php if ($a_data['officeaddress']) {
																														echo $a_data['officeaddress'];
																													} else {
																														echo '-';
																													} ?></cite></p>                 
                </div>-->
									</div>
								</div>
							</div>
						</div>



						<!--<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-blue-light" onclick="self.location.href=''">
<div class="card-body">
<i class="icon "></i>
    <div class="content">
      <div class="title "><h3><?php echo 'คะแนนสะสม'; ?></h3></div>  
      <div class="value"><span class="sign"></span><span class="counter">300 </span></div>
	  <div class="title"><h5>คะแนน</h5></div>
    </div>
	<div class="content">
      <div class="title ">	 
	
	  </div>
    </div>
  </div>
</a>
</div>->

</div>
</div>		
<!--<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_faq($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<? //=$txt_ewt_save;
									?>
</button>
</div>
</div>-->

					</div>

				</div>

			</div>
</form>