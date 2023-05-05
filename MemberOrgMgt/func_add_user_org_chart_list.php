<?php
include("../EWT_ADMIN/comtop_pop.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Add_User_Org_Chart'){
	
$db->query("USE ".$EWT_DB_USER);	

	
$s_data  		=	array();
$s_data_update  =	array();
$s_data_chart  	= 	array();
$s_data_sub  	= 	array();
$s_data_top  	=	array();

$s_sql = $db->query("SELECT *
					FROM org_map_chart 
					WHERE omc_org_id = '{$a_data['org_id']}' AND omc_uid = '{$a_data['omc_uid']}' AND omc_type = '{$a_data['omc_type']}'
					ORDER BY omc_order ASC ");
$a_rows = $db->db_num_rows($s_sql);
if($a_rows){	
while($a_data_chart  = $db->db_fetch_array($s_sql)){
	
	array_push($s_data_chart,$a_data_chart['omc_name']);
	
	}
}

	foreach($s_data_chart as $_item_del)
	{
		if(in_array($_item_del, $a_data['c_cate'])){
		
		}else{
			del('org_map_chart',"omc_org_id='".$a_data['org_id']."' AND omc_uid='".$a_data['omc_uid']."' AND omc_name='".$_item_del."' ");
		}
	}
	
if($a_data['c_cate'])
{
		 $i = 1; 
          foreach($a_data['c_cate'] as $_item)
          {	
		  
if(in_array($_item, $s_data_chart)){
$s_sql_omc	=	$db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$a_data['org_id']}' AND omc_uid = '{$a_data['omc_uid']}' AND omc_type = '{$a_data['omc_type']}' AND omc_name = '{$_item}'  ");
$a_rows_omc	=	$db->db_num_rows($s_sql_omc);
$a_data_omc =	$db->db_fetch_array($s_sql_omc);
	if($a_rows_omc == 0){
		del('org_map_chart',"omc_org_id='".$a_data['org_id']."' AND omc_uid='".$a_data['omc_uid']."' AND omc_name='".$_item."' ");
	}else{
//$s_data['omc_order']  	=	$a_data_omc['omc_order'];
//$s_data['omc_leval']  	=	$a_data_omc['omc_leval'];

//update('org_map_chart',$s_data,array('omc_name'=>$_item));
		}
}else{
		
$s_data['omc_uid']  	 =	$a_data['omc_uid'];
$s_data['omc_org_id']  	 =	$a_data['org_id'];
$s_data['omc_order']  	 =	count($a_data['c_cate']);
$s_data['omc_type']  	 =	$a_data['omc_type'];
$s_data['omc_name']  	 =	$_item;
$s_data['omc_name_sub']  = 	0;
$s_data['omc_leval']  	 =	1;

insert('org_map_chart',$s_data);
}	
 $i++;
 
	if($a_data['c_top'] == $_item)
	{ 
	$s_sql_omc  = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$a_data['org_id']}' AND omc_uid = '{$a_data['omc_uid']}' AND omc_type = '{$a_data['omc_type']}' AND omc_leval = '0'  ");
	$a_data_omc = $db->db_fetch_array($s_sql_omc);

	$s_data_top['omc_order']  	=	count($a_data['c_cate']);
	$s_data_top['omc_leval']  	=	1;

	update('org_map_chart',$s_data_top,array('omc_name'=>$a_data_omc['omc_name']));
	
		$s_data_update['omc_order']  	 =	0;
		$s_data_update['omc_leval']  	 =	0; 
        $s_data_update['omc_name_sub']   =	0;
		update('org_map_chart',$s_data_update,array('omc_name'=>$_item));

			$s_data_sub['omc_name_sub']  =	0;
		
			$s_sql_omc  = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$a_data['org_id']}' AND omc_uid = '{$a_data['omc_uid']}' AND omc_type = '{$a_data['omc_type']}' AND omc_name_sub = '{$a_data['c_top']}' ORDER BY omc_order ASC ");
			while($a_data_omc = $db->db_fetch_array($s_sql_omc)){
				update('org_map_chart',$s_data_sub,array('omc_name'=>$a_data_omc['omc_name']));
			}		
		}
		
			}
		}else{
			del('org_map_chart',"omc_org_id='".$a_data['org_id']."' AND omc_uid='".$a_data['omc_uid']."' ");
			}
		
unset($a_data);
unset($s_data);

$a_array['status'] 	= true;
$a_array['message'] = "success";

echo json_encode($a_array);	
exit;

	}else{
		$a_array['status'] 	= false;
		$a_array['message'] = "error";

		echo json_encode($a_array);	
		exit;		
	} 
?>