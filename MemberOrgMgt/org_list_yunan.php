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

/*
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
*/
$search_condition = "";
$search_pagin = "";

if($_GET["search"]=="Y"){

	$search_pagin .= "search=Y&";
	
	$fullname = trim($_GET["fullname"]);
	$search_pagin .= "fullname=".ready($_GET["fullname"])."&";
	if($fullname!=""){
		$find = explode(" ",$fullname);
		foreach($find AS $find_e){
			if($find_e!=""){
				$find_e = ready($find_e);
				$search_condition .= " AND ((gen_user.name_thai LIKE '%$find_e%') OR (gen_user.surname_thai LIKE '%$find_e%')) ";
			}
		}
	}
}
else{
	$search_pagin = "&";
}



if($_SESSION["EWT_SMTYPE"] != "Y"  && $type_right  == 'Y'){
$wh = " AND gen_user.org_id='".$right_org_id."'";
}

//{$condition} `emp_type`.`emp_type_status` = '2' {$wh}  $search_condition

$sql = "SELECT *
		FROM `gen_user`
		LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		WHERE  1=1 {$condition} {$wh} $search_condition
		ORDER BY `gen_user`.`gen_user_id` DESC";
$s_sql = $db->query($sql." LIMIT {$start} , {$perpage}");
							

//{$condition} `emp_type`.`emp_type_status` = '2' {$wh} $search_condition
$statement = "SELECT count(gen_user_id) AS b 
			  FROM `gen_user` 
              LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
			  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		      LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
              WHERE 1=1 {$condition} {$wh} $search_condition ";

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

<h4><?php echo $txt_org_menu_list;?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="org_dashboard.php"><?php echo $txt_org_menu_main;?></a></li>
<li class=""><?php echo $txt_org_menu_list;?></li>   
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_org_list.php');" >
<button type="button" class="btn btn-info  btn-ml"    title="<?php echo $txt_org_add;?>"  >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_org_add;?>
</button>
</a>

	<button type="button" class="btn btn-primary btn-ml search_module_button">
		<i class="fas fa-search"></i>&nbsp;ค้นหาบุคลากร
	</button>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_org_list.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_org_add;?></a></li>	
			<li><a href="javascript:void(0);" class="search_module_button"><i class="fas fa-search"></i>&nbsp;ค้นหาบุคลากร</a></li>
		</ul>
</div>
</div>	
</div>

		
		<?php /*
				<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
					<select class="form-control" name="use">
						<option value="">เลือก</option>
						<option value="Y">ใช้งาน</option>
						<option value="N">ไม่ใช้งาน</option>
					</select>
				</div>
		*/ ?>

	</div>
</div>
<!--END card-header -->


<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

<?php /*<div class="table-responsive" id="frm_edit_s">	  
<table width="100%" class="table table-bordered">
<thead>
<tr class="success">

                      <th width="5%" class="text-center">&nbsp; </th>
                      <th width="30%" class="text-center"><?php echo $txt_org_list_name_thai.'-'.$txt_org_list_surname_thai;?></th>
                      <th width="30%" class="text-center"><?php echo $txt_org_list_org_name;?></th>
                      <!--<th width="20%" class="text-center">ตำแหน่งภายในหน่วยงาน</th>
                      <th width="15%" class="text-center">ตำแหน่งทางวิชาการ</th>-->
                      <th width="10%" class="text-center"><?php echo $txt_org_list_status;?></th>
                      <th width="10%" class="text-center"><?php echo $txt_ewt_multilang;?></th>
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
<td class="text-center" ><?php echo $i+$start.'.';?></td>
<td class="text-left"><?php echo $a_data['name_thai'];?> <?php echo $a_data['surname_thai'];?></td>
<td class="text-left"><?php echo $a_data['name_org'];?></td>
<!--<td class="text-left"><?php //if($a_data[pos_name] != ''){echo $a_data[pos_name];}else{ echo '-';}?></td>
<td class="text-left"><?php //echo $a_data[position_person];?></td>-->
<td class="text-center"><?php echo org::chkStatusUser($a_data['status']);?></td>
<td class="text-left"></td>
<td class="text-left">
<button type="button" class="btn btn-info  btn-circle  btn-sm " onclick="boxPopup('<?php echo linkboxPopup();?>pop_view_org_list.php?u_id=<?php echo $a_data['gen_user_id']?>');"  data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_view;?>" >
<i class="fas fa-search" aria-hidden="true"></i>
</button>
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_org_list.php?u_id=<?php echo $a_data['gen_user_id'];?>');">
<button type="button" class="btn btn-warning  btn-circle  btn-xs "  data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_edit;?>" >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a>
<a onClick="JQDel_Gen_User('<?php echo $a_data['gen_user_id'];?>');" >
<button type="button" class="btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_delete;?>"   >
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
*/ ?>
<div class="panel-group" id="accordion">
<?php
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($s_sql)){
?>	
<div class="panel panel-default " id="<?php echo $a_data['gen_user_id'];?>"  >
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
				<!--<i class="fas fa-arrows-alt text-info move" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="<?php echo 'Move';?>" ></i>
				<input class="input-inline-sm text-center" name="org_order[]" id="fa_order<?php echo $a_data['org_order'];?>"  type="text" value="<?php echo $a_data['org_order'];?>" readonly />-->
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					<img src="<?php echo org::getGenUserImg($a_data['gen_user_id']);?>" alt="" class="img-circle img-rounded " style="width:24px;height:24px;" />
					:: <?php echo org::getTitle($a_data['title_thai']).' '.$a_data['name_thai'].' '.$a_data['surname_thai'];?>
	
					</a>					
                </h4>
            </div>
		
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse">
                <div class="panel-body">
                   	<div><b><?php echo $txt_org_list_org_name;?> :</b> <?php echo $a_data['name_org'];?></div><br> 
					<div><b><?php echo $txt_org_list_pos_name;?> :</b> <?php if($a_data['pos_name']){ echo $a_data['pos_name']; }else{ echo '-'; }?></div><br>
					<div><b><?php echo $txt_org_list_pos_person;?> :</b> <?php if($a_data['position_person']){ echo $a_data['position_person']; }else{ echo '-'; }?></div><br> 
					<div><b><?php echo $txt_org_list_email;?> :</b> <?php if($a_data['email_person']){ echo $a_data['email_person']; }else{ echo '-'; }?></div><br> 
					<div><b><?php echo $txt_org_list_tel_in;?> :</b> <?php if($a_data['tel_in']){ echo $a_data['tel_in']; }else{ echo '-'; }?></div><br> 
					<div><?php echo org::chkStatusOrg($a_data['org_status']);?></div><br> 					
					<div class="text-left">
					<span class="label label-primary "><?php echo $txt_ewt_multilang; ?></span>
					<?php //if(show_icon_lang_ewt($a_data['gen_user_id'],'gen_user')) { ?>
					<!--<button  type="button" class="btn btn-default   btn-sm " data-toggle="tooltip" data-placement="top" title="" >-->
					<?php //=show_icon_lang_ewt($a_data['gen_user_id'],'gen_user'); ?>
					<!--</button>-->
					<?php// } ?>
					</div>
				</div>	
				<div class="panel-footer ewt-bg-white text-right">
				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
				
<a onClick="txt_data('<?php echo $a_data['gen_user_id'];?>','')" >
<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $a_data['gen_user_id'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang;?>" >
<i class="fa fa-language" aria-hidden="true"></i>
</button>
</a>

<button type="button" class="btn btn-warning  btn-circle"  data-toggle="tooltip" data-placement="top" title="<?php echo 'คะแนนสะสม';?>" onclick="self.location.href='org_point.php?u_id=<?php echo $a_data['gen_user_id'];?>'" >
<i class="fas fa-parking" aria-hidden="true"></i>
</button>



<button type="button" class="btn btn-info  btn-circle  btn-sm " onclick="boxPopup('<?php echo linkboxPopup();?>pop_view_org_list.php?u_id=<?php echo $a_data['gen_user_id']?>');"  data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_view;?>" >
<i class="fas fa-search" aria-hidden="true"></i>
</button>
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_org_list_yunan.php?u_id=<?php echo $a_data['gen_user_id'];?>');">
<button type="button" class="btn btn-warning  btn-circle  btn-xs "  data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_edit;?>" >
<i class="fa fa-edit" aria-hidden="true"></i>
</button>
</a>
<a onClick="JQDel_Gen_User('<?php echo $a_data['gen_user_id'];?>');" >
<button type="button" class="btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_delete;?>"   >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>
</a>


					
<!--<a onClick="JQSet_Lang_Calendar('<?php //=$a_data['event_id']; ?>','')" data-toggle="tooltip" data-placement="right" title="<?php //=$txt_ewt_create_multilang; ?>">
<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?php //=$a_data['event_id']; ?>" >
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
                   <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
<?php } ?>		
	
</div>
</div>
<?php echo pagination_ewt($statement,$perpage,$page,'?'.$search_pagin);?>	
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
						title: '<?php echo $txt_ewt_confirm_del_title;?>',
						content: '<?php echo $txt_ewt_confirm_del_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo $txt_ewt_confirm_del;?>',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_org_list.php',
											data:{'id': id,'proc':'DelOrgList'},
											success: function (data) {
												$.alert({
													title: '<?php echo $txt_ewt_action_del_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: '<?php echo $txt_ewt_submit;?>',
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
									text: '<?php echo $txt_ewt_cancel;?>'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}
</script>

<?php
## >> Include search modal

$search_button_class = "search_module_button";
$search_title        = "ค้นหาบุคลากร";
$search_action       = "../MemberOrgMgt/org_list.php";
$search_parameter    = array(array("name"=>"fullname",
								   "type"=>"text",
								   "label"=>"ชื่อ-สกุล บุคลากร"));
include "../include/module_search.php";
?>