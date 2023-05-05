<?php


	function check_type_number($id){
	
		if((preg_match('/^[0-9]*$/', $id)) && ($id>0)){
			return true;
		}
		else{
			return false;
		}
	
	}
	
	
	function room_name($c_id){
		
		global $db;
	
		$sql_group =" SELECT a.c_name
						FROM w_cate a 
						WHERE a.c_id='$c_id'
					";
		$result_group = $db->query($sql_group);
		$group        = $db->db_fetch_array($result_group);
	
		return $group[c_name];
	}
	
	function group_bread($c_id){
		
		global $db;
		$array = array();
	
		//array_push($array, $c_id);
	
		$sql_group =" SELECT a.c_id, a.c_parentid 
					FROM w_cate a 
					WHERE a.c_id='$c_id'
					";
					
		$result_group = $db->query($sql_group);
		$group        = $db->db_fetch_array($result_group);
	
		
		if($group[c_parentid]>0){
			array_push($array, $group[c_parentid]);
		}	
	
		while ($group[c_parentid]!=0){
	
			$sql_group =" SELECT a.c_id, a.c_parentid
						FROM w_cate a 
						WHERE a.c_id='$group[c_parentid]'
						";
			$result_group = $db->query($sql_group);
			$group        = $db->db_fetch_array($result_group);
	
			if($group[c_parentid]>0){
				array_push($array, $group[c_parentid]);
			}
				
		}
	
		$array = array_reverse($array);
		
	
		return $array;
	}

function subgroup_number($c_id){
	
	global $db;
	global $total_row;

	$sql_group =" SELECT a.c_id 
				FROM w_cate a 
				WHERE a.c_parentid='$c_id'
				";
				
	$result_group = $db->query($sql_group);
	$n_rows       = $db->db_num_rows($result_group);	

	if($n_rows>0){
		$total_row = $total_row+$n_rows;
		
		while($group = $db->db_fetch_array($result_group)){
			subgroup_number($group[c_id]);
		}
		
	}

	return $total_row;

}


function total_question_group($c_id){

	global $db;
	global $total_row;

	global $question_array;

	$sql_group =" SELECT a.c_id 
				FROM w_cate a 
				WHERE a.c_parentid='$c_id'
				";
				
	$result_group = $db->query($sql_group);
	$n_rows       = $db->db_num_rows($result_group);	

	if($n_rows>0){
		$total_row = $total_row+$n_rows;
		
		while($group = $db->db_fetch_array($result_group)){
			array_push($question_array,$group[c_id]);
			total_question_group($group[c_id]);
		}
		
	}

	return $question_array;

}

function total_question_number($c_id,$c_id_array){

	global $db;

	$line = "(c_id= '$c_id') OR ";

	for($i=0;$i<sizeof($c_id_array);$i++){
		$line .= "(c_id= '$c_id_array[$i]') OR ";
	}

	$line = rtrim($line," OR ");

	$sql_group = $db->query("SELECT t_id
							FROM w_question
							WHERE ($line)");

	$n_rows       = $db->db_num_rows($sql_group);	

	echo $n_rows;
}

function total_comment($t_id){
	
	global $db;

	$sql_comment  = $db->query("SELECT a_id
							    FROM w_answer
								WHERE t_id='$t_id'");

	$n_rows       = $db->db_num_rows($sql_comment);	

	return $n_rows;
}

function list_webboard_room($c_id){
	
	global $db;
	
	$stats_group = array();

	$sql_group =" SELECT a.c_id 
				  FROM w_cate a 
				  WHERE a.c_parentid='$c_id'
				";

	$result_group = $db->query($sql_group);
		
	while($group = $db->db_fetch_array($result_group)){
		array_push($stats_group, $group[c_id]);
	}
	
	return $stats_group;
}

function check_image($filename){
	
	$file_ext  = array_reverse (explode(".",$filename));
	$file_ext  = $file_ext[0];

	$check_ext = "No";
	$array_ext = array("jpg","png","gif");
	
	for($a=0;$a<sizeof($array_ext);$a++){
		if(strtolower($array_ext[$a])==strtolower($file_ext)){$check_ext = "Yes";}
	}

	if($check_ext == "Yes"){return true;}
	else{return false;}
}

function safety_clean($data){

	$data = Strip_tags($data);
	$data = str_replace("'","''",$data);
	$data = trim($data);

	return $data;
}

function question_html($data){

	$temp = $data;

	$temp = eregi_replace ( chr(13), "<br>" , $temp ) ;
	$temp = eregi_replace ( "\[b\]", "<b>" , $temp ) ;
	$temp = eregi_replace ( "\[/b\]", "</b>" , $temp ) ;
	$temp = eregi_replace ( "\[br\]", "<br>" , $temp ) ;
	$temp = eregi_replace ( "\[i\]", "<i>" , $temp ) ;
	$temp = eregi_replace ( "\[/i\]", "</i>" , $temp ) ;
	$temp = eregi_replace ( "\[u\]", "<u>" , $temp ) ;
	$temp = eregi_replace ( "\[/u\]", "</u>" , $temp ) ;
	$temp = eregi_replace ( "\[\-\-\-\]", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" , $temp ) ;
	$temp = eregi_replace ( "\[color=red\]", "<font color=red>" , $temp ) ;
	$temp = eregi_replace ( "\[color=green\]", "<font color=green>" , $temp ) ;
	$temp = eregi_replace ( "\[color=blue\]", "<font color=blue>" , $temp ) ;
	$temp = eregi_replace ( "\[color=orange\]", "<font color=FF6600>" , $temp ) ;
	$temp = eregi_replace ( "\[color=pink\]", "<font color=FF00FF>" , $temp ) ;
	$temp = eregi_replace ( "\[color=gray\]", "<font color=999999>" , $temp ) ;
	$temp = eregi_replace ( "\[/color\]", "</font>" , $temp ) ;
	$temp = eregi_replace ("\[img\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]])\[/img\]", "<img width='50%' src=\"\\1://\\2\\3\">",$temp ) ;
	$temp = eregi_replace ("\[url\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])\[/url\]","<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>",$temp ) ;
	$temp = eregi_replace ("([^[:space:]]*)@([^[:space:]]*)([[:alnum:]])","<a href=\"./mail2me/mail2me.php?wemail=\\1@\\2\\3&name=\\1@\\2\\3\" target=\"_blank\">\\1@\\2\\3</a>",$temp ) ;

	return $temp;
}

function question_status_text($t_id){
	
	global $db;
	
	$sql_status =" SELECT s_id 
				FROM w_question 
				WHERE t_id='$t_id'
				";
				
	$result_status = $db->query($sql_status);
	$status        = $db->db_fetch_array($result_status);
	
	if($status['s_id']==0){ ?>
		<span style="color:red;">ไม่อนุมัติ</span>
	<?php } else { ?>
		<span style="color:green;">อนุมัติ</span>
	<?php }

	
}


function comment_status_text($a_id){
	
	global $db;
	
	$sql_status =" SELECT s_id 
				FROM w_answer 
				WHERE a_id='$a_id'
				";

	$result_status = $db->query($sql_status);
	$status        = $db->db_fetch_array($result_status);
	
	if($status['s_id']==0){ ?>
		<span style="color:red;">ไม่อนุมัติ</span>
	<?php } else { ?>
		<span style="color:green;">อนุมัติ</span>
	<?php }
	
}

function question_status($t_id){
	
	global $db;
	
	$sql_status =" SELECT s_id 
				FROM w_question 
				WHERE t_id='$t_id'
				";
				
	$result_status = $db->query($sql_status);
	$status        = $db->db_fetch_array($result_status);
	
	return ($status['s_id']);

	
}


function comment_status($a_id){
	
	global $db;
	
	$sql_status =" SELECT s_id 
				FROM w_answer 
				WHERE a_id='$a_id'
				";

	$result_status = $db->query($sql_status);
	$status        = $db->db_fetch_array($result_status);
	
	return ($status['s_id']);
	
}

function comment_detail($a_id){
	
	global $db;
	
	$sql_status =" SELECT a_detail 
				FROM w_answer 
				WHERE a_id='$a_id'
				";

	$result_status = $db->query($sql_status);
	$status        = $db->db_fetch_array($result_status);
	
	return ($status['a_detail']);
	
}

?>