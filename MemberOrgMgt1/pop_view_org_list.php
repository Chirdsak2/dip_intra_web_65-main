<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
DEFINE('HOST_SSO','http://203.151.166.132/PRD_INTRA_SSO/');
$u_id = (int)(!isset($_GET['u_id']) ? 0 : $_GET['u_id']);

$db->query("USE ".$EWT_DB_USER);

$s_sql = "SELECT * FROM USR_MAIN
LEFT JOIN USR_DEPARTMENT ON (USR_MAIN.DEP_ID = USR_DEPARTMENT.DEP_ID)  
LEFT JOIN USR_POSITION ON (USR_MAIN.POS_ID = USR_POSITION.POS_ID)  
WHERE USR_MAIN.USR_ID = {$u_id}";
$a_data = $sso->getFetch($s_sql);	

$user_file = "../ewt/prd_intra_web/profile/" . $a_data["USR_PICTURE"];
$user_img = (empty($a_data["USR_PICTURE"]) ? "../EWT_ADMIN/images/user001.png" : $user_file);
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
<div class="card-title text-left"><b><?=$a_data['USR_PREFIX'].' '.$a_data['USR_FNAME'].' '.$a_data['USR_LNAME'];?></b></div>
</div>
<div class="card-body" >

                <div class="row">
                    <div class=" col-sm-6 col-md-2">
                        <img src="<?=$user_img;?>" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-5">
                        <h4><?=$a_data['title_thai'].' '.$a_data['name_thai'].' '.$a_data['surname_thai'];?></h4>
						<p><i class="far fa-id-card"></i> 
						<?php if($a_data['POS_NAME']){ echo $a_data['POS_NAME']; }else{ echo '-'; }?>
						<?php if($a_data['POS_NAME']){ echo '<br>'.$a_data['POS_NAME']; }else{ echo ''; }?>
						</p>
                        <p><i class="fas fa-database"></i> <?php if($a_data['DEP_NAME']){ echo $a_data['DEP_NAME']; }else{ echo '-'; }?></p>
                    </div>
					<div class="col-sm-6 col-md-5">
                        <h4></h4>
                        <p><i class="fas fa-at"></i> <?php if($a_data['USR_EMAIL']){ echo $a_data['USR_EMAIL']; }else{ echo '-'; }?></p>
						<p><i class="fas fa-phone-square"></i>  <?php if($a_data['USR_TEL']){ echo $a_data['USR_TEL']; }else{ echo '-'; }?></p>
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
	
