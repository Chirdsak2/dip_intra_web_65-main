<?php
include("../EWT_ADMIN/comtop_pop.php");

$u_id = (int)(!isset($_GET['u_id']) ? 0 : $_GET['u_id']);

$db->query("USE ".$EWT_DB_USER);

$s_sql = $db->query("SELECT *
		FROM `gen_user`
		LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		WHERE `gen_user`.`gen_user_id` = '{$u_id}' ");
$a_data = $db->db_fetch_array($s_sql);				
?>

<form id="form_main" name="form_main" method="POST" action="<?=getLocation('func_add_org_list')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="Add_Org">

<div class="container" >   
<div class="modal-dialog modal-lg"  >

<div class="modal-content ">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6" >
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"> <i class="fas fa-search"></i> <?=$txt_org_view;?></h4>
</div>

<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">



<div class="col-xs-12 col-sm-12 col-md-12 m-t-md">     
<div class="card ">
<div class="card-header m-b-sm visible-xs" >
<div class="card-title text-left"><b><?=org::getTitle($a_data['title_thai']).''.$a_data['name_thai'].' '.$a_data['surname_thai'];?></b></div>
</div>
<div class="card-body" >

                <div class="row">
                    <div class=" col-sm-6 col-md-2">
                        <img src="<?=org::getGenUserImg($a_data['gen_user_id']);?>" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <h4><?=org::getTitle($a_data['title_thai']).''.$a_data['name_thai'].' '.$a_data['surname_thai'];?></h4>
						<p><i class="far fa-id-card"></i> 
						<?php if($a_data['pos_name']){ echo $a_data['pos_name']; }else{ echo '-'; }?>
						<?php if($a_data['position_person']){ echo '<br>'.$a_data['position_person']; }else{ echo ''; }?>
						</p>
                        <p><i class="fas fa-database"></i> <?php if($a_data['name_org']){ echo $a_data['name_org']; }else{ echo '-'; }?></p>
						
                  
                    </div>
					<div class="col-sm-6 col-md-5">
                        <h4></h4>
                        
                        <p><i class="fas fa-at"></i> <?php if($a_data['email_person']){ echo $a_data['email_person']; }else{ echo '-'; }?></p>
						<p><i class="fas fa-phone-square"></i>  <?php if($a_data['tel_in']){ echo $a_data['tel_in']; }else{ echo '-'; }?></p>
						<p><i class="fas fa-map-marker"></i> <cite title="<?=$a_data['officeaddress'];?>"><?php if($a_data['officeaddress']){ echo $a_data['officeaddress']; }else{ echo '-'; }?></cite></p>
                  
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>	
</div>
		
<!--<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">
<button onclick="JQAdd_faq($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?//=$txt_ewt_save;?>
</button>
</div>
</div>-->

</div>

</div>
 
</div>
</div>	 
</form>
	
