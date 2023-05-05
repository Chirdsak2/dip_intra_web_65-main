<?php
include("assets/config.inc.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
	//include("../lib/seo_function.php");

	//$language    = $_POST[enews_language];
	//$language_id = language_id($language);

echo $email = (!isset($_POST['subscribemail']) ? 0 : $_POST['subscribemail']);
$status = (!isset($_POST['status']) ? 0 : $_POST['status']);
echo $save_newsletter = (!isset($_POST['proc']) ? 0 : $_POST['proc']);
	
if($status==2){
			$query_m = $db->query("SELECT * 
			                       from n_member 
														 where m_email = '$email' ");
			$num = $db->db_num_rows($query_m);
			if($num>0){
				$mid = $db->db_fetch_array($query_m);
				$db->query("delete from n_group_member where m_id = '".$mid["m_id"]."'");
				$db->query("delete from n_member where m_email = '".$email."' ");
			}
			?>
			<div class="modal-dialog popup-modal" role="document">
				<div class="modal-content">
				  <div class="modal-header blue">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
					<h4 class="modal-title " id="myModalSubscribe">ยกเลิกการรับข่าวสาร</h4>
				  </div>
				  <div class="modal-body">
					ท่านได้ยกเลิกการับข่าวสารเรียบร้อยแล้ว
				  </div>
				   <div class="modal-footer">
					<button type="button" class="btn btn-default antoclose2" data-dismiss="modal"> ปิด </button>
					
				  </div>
				</div>
			</div> 
			<?php
		}else{
			$query_m = $db->query("SELECT * 
			from n_member where m_email = '".$email."' AND m_active = 'N' ");
			$ac = $db->db_num_rows($query_m );
			if($ac>0){
?>

<div class="container" >   

<div class="modal-dialog popup-modal" role="document">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="ModalEnewsletter"> <?php //echo get_info_lang($language_id,"Subscribe_Header"); ?> </h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
</div>
				  <div class="modal-body">
					<div id="testmodal2" style="padding: 5px 20px;">
					<p style="color:;">Subscribe to receive news<br>Please confirm the news via email. <a href="mailto:<?=$email?>"><?=$email?></a>					</p>
					</div>
				  </div>
				   <div class="modal-footer">
					<button type="button" class="btn btn-xs btn-warning home-slider-btn-more" data-dismiss="modal"> Close </button>
					
				  </div>
				</div>
			</div> 
<?
}else{	

	$query_m = $db->query("SELECT * 
	                       FROM n_member 
												 WHERE m_email = '{$email}' and  m_active = 'Y' ");
	$num = $db->db_num_rows($query_m );
	$mid = $db->db_fetch_array($query_m);
	
?>

	<form action="../<?php echo $_SESSION['EWT_SUSER'];?>/popup/func_enew_subscribe.php" method="post" name="myForm" id="myForm">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title" id="ModalEnewsletter"><h3 style="color: #79988A;"> สมัครรับข้อมูลข่าวสาร</h3><?php //echo get_info_lang($language_id,"Subscribe_Header"); ?> </h4>
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x"></i></button>
				</div>

				

				<div class="modal-body">
					<?php if($num>0){ ?>
							<p style="font-weight:bold;bottom:20px;"><u> <?=$email.' มีอยู่ในระบบแล้ว';?></u></p>
					<?php } ?>
					<?php //}else{ ?>
					<h5 style="color: #79988A;">เลือกหมวดข่าวที่ท่านต้องการ</h5>
					<fieldset>

					<legend ></legend>

						
					
						<div class="row">
							<div class="col-md-12">
								<div class="margin-b-15">	
					
									<?php 
									
									$Sel = "SELECT * 
													from n_group 
													left join article_group on n_group.g_name = article_group.c_id 
													where `n_group`.`g_name` !=  ''
													order by g_id desc ";	
									$i = 0;
									$query1 = $db->query($Sel);
									while($R = $db->db_fetch_array($query1)){
										$SQL = $db->query("SELECT * 
																			from n_group_member 
																			where m_id = '{$mid[m_id]}' and g_id = '{$R[g_id]}'"
																			);
										$num_ck = $db->db_num_rows($SQL);
										if($R['c_name']!=""){
									?>
			
										<div class="checkbox">
											<label>
												<input type="checkbox" value="Y" name="chk<?php echo $i;?>" id="chk<?php echo $i;?>" 
													<?php if($num_ck>0){echo "checked";} ?>>
														<?php echo $R["c_name"];//echo lang_group($language,$R['c_id']);?> 
													<?php if($num_ck>0){ ?>
														<span style="color:red">[ <em class="fa fa-check" aria-hidden="true"></em> ]</span>	
													<?php } ?>
												
												<input type="hidden" name="c_id<?php echo $i;?>" id="c_id<?php echo $i;?>" value="<?=$R['g_id']?>">
											</label>
										</div>		
					
									<?php 
										$i++;
										}
									}
									?>
								</div>
							</div>
						</div>					
						<input type="hidden" name="all" id="all" value="<?=$i;?>">
						<input type="hidden" name="mid" value="<?=$mid['m_id']?>">
						<input type="hidden" name="email" value="<?=$email?>">
						</fieldset>	
					<?php //}?>
					</div>
						  
				<?php
					
					if($num <1 ){
						$str_b = '<i class="fa fa-check" aria-hidden="true"></i>ยืนยันการสมัคร';
					}else{
						$str_b = '<i class="fa fa-check" aria-hidden="true"></i>ตกลง';
					}
					
				
				?>
						
				
				  
				<div class="modal-footer">
					<!--<button type="button" class="btn btn-primary" onClick="checkinput2();">บันทึก</button>-->
					
					<button type="button" class="btn btn-xs btn-warning home-slider-btn-more" onclick="CheckGroup($('#myForm'));"
									<?php //if($num<1){ ?>onclick="CheckGroup($('#myForm'));" <?php //$str_b = '<i class="fa fa-check" aria-hidden="true"></i>ยืนยันการสมัคร';} 
										
									      //else{?>onClick="$('#box_popup').fadeOut();"<?php //$str_b = '<i class="fa fa-check" aria-hidden="true"></i>ตกลง';} ?>><!--SubmitGroup(); -->
						
						<?php   echo $str_b;//echo get_info_lang($language_id,"Subscribe_Submit"); ?>
					</button>
					
				<?php //if($num == 1 && $save_newsletter == "save_newsletter"){ ?>
				<!-- 
					<button type="button" class="btn btn-xs btn-info home-slider-btn-more"
					onClick="boxPopup('../../EnewsLetterMgt/pop_edit_enews_member.php?m_id=<?=$mid['m_id'];?>');"> 
						<i class="fa fa-plus" aria-hidden="true"></i>
						เพิ่มการรับข่าวสาร 
					</button>
				-->
				<?php //} ?>
				
				</div>
			
			</div>
			
		</div>
	</div>
	</form>
	
<?php 
		}
	} 
?>
<script>  
function CheckGroup(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: 'สมัครรับข้อมูลข่าวสาร',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: method,
											url: action,					
											data: formData ? formData : form.serialize(),
											async: true,
											processData: false,
											contentType: false,
											success: function (data) {												
												console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														location.reload(true);			
														$('#box_popup').fadeOut();
													}														
												});
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									//$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
}
</script>

   