<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

if($db->check_permission("org","u","")){ 
$type_right = 'Y';
}
$db->query("USE ".$EWT_DB_USER);

$right_org_id= org::getOrgGroup($_SESSION['EWT_SMID']);
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

					if($namesurname){
					   $name=split(' ',$namesurname);
					   if($name[0]  &&  $name[1]=='' ){
					   $condition.="(gen_user.name_thai  like '$name[0]%'  OR  gen_user.surname_thai  like '$name[0]%' or gen_user.name_eng  like '$name[0]%'  OR  gen_user.surname_eng  like '$name[0]%')   AND "; 
					   }
					   if($name[0]    &&   $name[1]){
						 $condition.=" (gen_user.name_thai  like '$name[0]%'  OR  gen_user.surname_thai  like '$name[1]%' or gen_user.name_eng  like '$name[0]%'  OR  gen_user.surname_eng  like '$name[0]%')   and "; 
					   }
					   $db->query("USE ".$_SESSION["EWT_SDB"]);
					   $db->write_log("search","member","ค้นหาสมาชิกชื่อ : ".$namesurname);
					   $db->query("USE ".$EWT_DB_USER);
					}
					
						if($org_id){
						  $condition.="(org_name.name_org  LIKE  '%".$org_id."%')   and  ";
						  $sql_chk = $db->db_fetch_array($db->query("select * from org_name where org_id ='".$_POST["org_id"]."' "));
						  $db->query("USE ".$_SESSION["EWT_SDB"]);
						  $db->write_log("search","member","ค้นหาหน่วยงาน : ".$sql_chk[name_org]);
						  $db->query("USE ".$EWT_DB_USER);
						}
					if($position_person){
						  $condition.="(gen_user.position_person  like  '%$position_person%')   and  ";
						  $db->query("USE ".$_SESSION["EWT_SDB"]);
						  $db->write_log("search","member","ค้นหาตำแหน่งทางวิชาการ : ".$position_person);
						  $db->query("USE ".$EWT_DB_USER);
						}
					if($pos_id){
						  $sql_chk = $db->db_fetch_array($db->query("select * from position_name where pos_id ='".$_POST["pos_id"]."' "));
						  $db->query("USE ".$_SESSION["EWT_SDB"]);
						  $db->write_log("search","member","ค้นหาตำแหน่งภายในหน่วยงาน : ".$sql_chk[pos_name]);
						  $db->query("USE ".$EWT_DB_USER);
						  $condition.="(position_name.pos_id  = '$pos_id')   and  ";
						}
					
					if($_SESSION["EWT_SMTYPE"] != "Y"  && $type_right  == 'Y'){
					$wh = " AND gen_user.org_id='".$right_org_id."'";
					}
					
$sql = "SELECT *
		FROM `gen_user`
		LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		WHERE  {$condition} `emp_type`.`emp_type_status` = '2' {$wh} 
		ORDER BY `gen_user`.`gen_user_id` DESC";
$s_sql = $db->query($sql." LIMIT {$start} , {$perpage}");
										
$statement = "SELECT count(gen_user_id) AS b 
			  FROM `gen_user` 
              LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
			  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		      LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
              WHERE {$condition} `emp_type`.`emp_type_status` = '2' {$wh} ";
			  
$a_rows  = $db->db_num_rows($s_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);	
?>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?=$txt_org_menu_list;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="org_dashboard.php"><?=$txt_org_menu_main;?></a></li>
<li class=""><?=$txt_org_menu_list;?></li>   
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	
<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_org_list.php');" >
<button type="button" class="btn btn-info  btn-ml"    title="<?=$txt_org_add;?>"  >
<i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_org_add;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_org_list.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_org_add;?></a></li>	
					
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->


<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<?/*<div class="table-responsive" id="frm_edit_s">	  
<table width="100%" class="table table-bordered">
<thead>
<tr class="success">

                      <th width="5%" class="text-center">&nbsp; </th>
                      <th width="30%" class="text-center"><?=$txt_org_list_name_thai.'-'.$txt_org_list_surname_thai;?></th>
                      <th width="30%" class="text-center"><?=$txt_org_list_org_name;?></th>
                      <!--<th width="20%" class="text-center">ตำแหน่งภายในหน่วยงาน</th>
                      <th width="15%" class="text-center">ตำแหน่งทางวิชาการ</th>-->
                      <th width="10%" class="text-center"><?=$txt_org_list_status;?></th>
                      <th width="10%" class="text-center"><?=$txt_ewt_multilang;?></th>
					  <th width="25%" class="text-center">&nbsp;</th>
</tr>
</thead>
<tbody>
<?php
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

					if($namesurname){
					   $name=split(' ',$namesurname);
					   if($name[0]  &&  $name[1]=='' ){
					   $condition.="(gen_user.name_thai  like '$name[0]%'  OR  gen_user.surname_thai  like '$name[0]%' or gen_user.name_eng  like '$name[0]%'  OR  gen_user.surname_eng  like '$name[0]%')   AND "; 
					   }
					   if($name[0]    &&   $name[1]){
						 $condition.=" (gen_user.name_thai  like '$name[0]%'  OR  gen_user.surname_thai  like '$name[1]%' or gen_user.name_eng  like '$name[0]%'  OR  gen_user.surname_eng  like '$name[0]%')   and "; 
					   }
					   $db->query("USE ".$_SESSION["EWT_SDB"]);
					   $db->write_log("search","member","ค้นหาสมาชิกชื่อ : ".$namesurname);
					   $db->query("USE ".$EWT_DB_USER);
					}
					
						if($org_id){
						  $condition.="(org_name.name_org  LIKE  '%".$org_id."%')   and  ";
						  $sql_chk = $db->db_fetch_array($db->query("select * from org_name where org_id ='".$_POST["org_id"]."' "));
						  $db->query("USE ".$_SESSION["EWT_SDB"]);
						  $db->write_log("search","member","ค้นหาหน่วยงาน : ".$sql_chk[name_org]);
						  $db->query("USE ".$EWT_DB_USER);
						}
					if($position_person){
						  $condition.="(gen_user.position_person  like  '%$position_person%')   and  ";
						  $db->query("USE ".$_SESSION["EWT_SDB"]);
						  $db->write_log("search","member","ค้นหาตำแหน่งทางวิชาการ : ".$position_person);
						  $db->query("USE ".$EWT_DB_USER);
						}
					if($pos_id){
						  $sql_chk = $db->db_fetch_array($db->query("select * from position_name where pos_id ='".$_POST["pos_id"]."' "));
						  $db->query("USE ".$_SESSION["EWT_SDB"]);
						  $db->write_log("search","member","ค้นหาตำแหน่งภายในหน่วยงาน : ".$sql_chk[pos_name]);
						  $db->query("USE ".$EWT_DB_USER);
						  $condition.="(position_name.pos_id  = '$pos_id')   and  ";
						}
					
					if($_SESSION["EWT_SMTYPE"] != "Y"  && $type_right  == 'Y'){
					$wh = " AND gen_user.org_id='".$right_org_id."'";
					}
					
$sql = "SELECT *
		FROM `gen_user`
		LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		WHERE  {$condition} `emp_type`.`emp_type_status` = '2' {$wh} 
		ORDER BY `gen_user`.`gen_user_id` DESC";
$s_sql = $db->query($sql." LIMIT {$start} , {$perpage}");
										
$statement = "SELECT count(gen_user_id) AS b 
			  FROM `gen_user` 
              LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
			  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		      LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
              WHERE {$condition} `emp_type`.`emp_type_status` = '2' {$wh} ";
			  
$a_rows  = $db->db_num_rows($s_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);								
					$i = 1;
					if(!empty($a_rows)){
					while($a_data = $db->db_fetch_array($s_sql)){
	
?>
<tr>
<td class="text-center" ><?=$i+$start.'.';?></td>
<td class="text-left"><?php echo $a_data['name_thai'];?> <?php echo $a_data['surname_thai'];?></td>
<td class="text-left"><?php echo $a_data['name_org'];?></td>
<!--<td class="text-left"><?php //if($a_data[pos_name] != ''){echo $a_data[pos_name];}else{ echo '-';}?></td>
<td class="text-left"><?php //echo $a_data[position_person];?></td>-->
<td class="text-center"><?php echo org::chkStatusUser($a_data['status']);?></td>
<td class="text-left"></td>
<td class="text-left">
<button type="button" class="btn btn-info  btn-circle  btn-sm " onclick="boxPopup('<?=linkboxPopup();?>pop_view_org_list.php?u_id=<?=$a_data['gen_user_id']?>');"  data-toggle="tooltip" data-placement="top" title="<?=$txt_org_view;?>" >
<i class="fas fa-search" aria-hidden="true"></i>
</button>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_org_list.php?u_id=<?=$a_data['gen_user_id'];?>');">
<button type="button" class="btn btn-warning  btn-circle  btn-xs "  data-toggle="tooltip" data-placement="top" title="<?=$txt_org_edit;?>" >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a>
<a onClick="JQDel_Gen_User('<?=$a_data['gen_user_id'];?>');" >
<button type="button" class="btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?=$txt_org_delete;?>"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>
</td>
</tr>
<?php
						 $i++;
								
						}//end while
					}else{
					?>
<tr> 
<td colspan="7"><p class="text-center text-danger"><?php echo $txt_ewt_data_not_found ; ?></p></td>
</tr>					
					<?php
					}
					?>				
</tbody>						
</table>
</div>
*/?>
<div class="panel-group" id="accordion">
<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($s_sql)){
?>	
<div class="panel panel-default " id="<?=$a_data['gen_user_id'];?>"  >
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
				<!--<i class="fas fa-arrows-alt text-info move" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="<?='Move';?>" ></i>
				<input class="input-inline-sm text-center" name="org_order[]" id="fa_order<?=$a_data['org_order'];?>"  type="text" value="<?=$a_data['org_order'];?>" readonly />-->
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?=$i;?>">
					<img src="<?=org::getGenUserImg($a_data['gen_user_id']);?>" alt="" class="img-circle img-rounded " style="width:24px;height:24px;" />
					:: <?=org::getTitle($a_data['title_thai']).''.$a_data['name_thai'].''.$a_data['surname_thai'];?>
	
					</a>					
                </h4>
            </div>
		
            <div id="collapseOne<?=$i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                   	<div><b><?=$txt_org_list_org_name;?> :</b> <?=$a_data['name_org'];?></div><br> 
					<div><b><?=$txt_org_list_pos_name;?> :</b> <?php if($a_data['pos_name']){ echo $a_data['pos_name']; }else{ echo '-'; }?></div><br>
					<div><b><?=$txt_org_list_pos_person;?> :</b> <?php if($a_data['position_person']){ echo $a_data['position_person']; }else{ echo '-'; }?></div><br> 
					<div><b><?=$txt_org_list_email;?> :</b> <?php if($a_data['email_person']){ echo $a_data['email_person']; }else{ echo '-'; }?></div><br> 
					<div><b><?=$txt_org_list_tel_in;?> :</b> <?php if($a_data['tel_in']){ echo $a_data['tel_in']; }else{ echo '-'; }?></div><br> 
					<div><?=org::chkStatusOrg($a_data['org_status']);?></div><br> 					
					<div class="text-left">
					<span class="label label-primary "><?=$txt_ewt_multilang; ?></span>
					<?php //if(show_icon_lang_ewt($a_data['gen_user_id'],'gen_user')) { ?>
					<!--<button  type="button" class="btn btn-default   btn-sm " data-toggle="tooltip" data-placement="top" title="" >-->
					<?//=show_icon_lang_ewt($a_data['gen_user_id'],'gen_user');?>
					<!--</button>-->
					<?php// } ?>
					</div>
				</div>	
				<div class="panel-footer ewt-bg-white text-right">
				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
				
<a onClick="txt_data('<?=$a_data['gen_user_id'];?>','')" >
<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?=$a_data['gen_user_id'];?>" data-toggle="tooltip" data-placement="top" title="<?=$txt_ewt_create_multilang;?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>
<button type="button" class="btn btn-info  btn-circle  btn-sm " onclick="boxPopup('<?=linkboxPopup();?>pop_view_org_list.php?u_id=<?=$a_data['gen_user_id']?>');"  data-toggle="tooltip" data-placement="top" title="<?=$txt_org_view;?>" >
<i class="fas fa-search" aria-hidden="true"></i>
</button>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_edit_org_list.php?u_id=<?=$a_data['gen_user_id'];?>');">
<button type="button" class="btn btn-warning  btn-circle  btn-xs "  data-toggle="tooltip" data-placement="top" title="<?=$txt_org_edit_group;?>" >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a>
<a onClick="JQDel_Gen_User('<?=$a_data['gen_user_id'];?>');" >
<button type="button" class="btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?=$txt_org_delete_group;?>"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>


					
<!--<a onClick="JQSet_Lang_Calendar('<?//=$a_data['event_id'];?>','')" data-toggle="tooltip" data-placement="right" title="<?//=$txt_ewt_create_multilang;?>">
<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?//=$a_data['event_id'];?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>-->

				</div>
				</div>
            </div>
        </div>
<?php $i++;} }else{?>

       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?=$txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php } ?>		
	
</div>
</div>
<?=pagination_ewt($statement,$perpage,$page,'?search_txt='.$search_txt.'&');?>	
</div>
</div>
</div>
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE ".$EWT_DB_NAME);

include("../EWT_ADMIN/combottom.php");
?>
<style>
.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
.faqHeader {
    font-size: 27px;
    margin: 20px;
}
.panel-heading [data-toggle="collapse"]:after {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
    content: "\f105"; /* "play" icon */
    float: right;
    color: #FFC153;
    font-size: 24px;
    line-height: 22px;
    /* rotate "play" icon from > (right arrow) to down arrow */
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -ms-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    transform: rotate(-90deg);
}
.panel-heading [data-toggle="collapse"].collapsed:after {
     /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
     -webkit-transform: rotate(90deg);
     -moz-transform: rotate(90deg);
     -ms-transform: rotate(90deg);
     -o-transform: rotate(90deg);
     transform: rotate(90deg);
     color: #454444;
}
</style>
<script>
function txt_data(w,g) {	
	$.ajax({
      type: 'GET',
      url: 'pop_set_lang_org_list.php?gid='+g+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}	
    }); 	
$('#box_popup').fadeIn();		
}

function txt_data1(w,g,lang) {
	$.ajax({
      type: 'GET',
      url: 'pop_org_list_multilang.php?langid='+g+'&lang='+lang+'&id='+w,
	  beforeSend: function() {
        $('#box_popup').html('');
      },
		success: function (data) {
			$('#box_popup').html(data);
		}		
    }); 
	$('#box_popup').fadeIn();	
}

function JQDel_Gen_User(id){
					$.confirm({
						title: '<?=$txt_ewt_confirm_del_title;?>',
						content: '<?=$txt_ewt_confirm_del_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?=$txt_ewt_confirm_del;?>',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_org_list.php',
											data:{'id': id,'proc':'DelOrgList'},
											success: function (data) {
												$.alert({
													title: '<?=$txt_ewt_action_del_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: '<?=$txt_ewt_submit;?>',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: '<?=$txt_ewt_cancel;?>'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}
</script>