<?php
DEFINE('path', 'assets/');
include(path.'config/config.inc.php');
$a_data = array_merge($_POST,$_FILES);


	$sid = $a_data['sid'];
	
	$date = new DateTime();
	
	$SQL1	=	"SELECT * FROM ". E_DB_NAME . ".p_survey WHERE s_id = '{$sid}'";
	//$sql_t = "select * from p_survey where s_id = '".$sid."'";
	//$exc_t = db::execute($sql_t);
	//$tables = $db->db_fetch_array($exc_t);
	
	$a_row	= db::getRowCount($SQL1);
	$tables = db::getFetch($SQL1,PDO::FETCH_ASSOC); 

	
	$arr = array();
	$arr_mail = array();
	$ans = array();

	
	$forpo ="SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM ". E_DB_NAME . ".p_cate,". E_DB_NAME . ".p_question WHERE p_cate.s_id = '{$sid}' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC";
	$SQL = db::execute($forpo);
	$a_row		= 	db::getRowCount($forpo);
	$a_pCate 	= 	db::getFetchAll($forpo,PDO::FETCH_ASSOC);
	
	if($a_pCate)  
	{
		foreach((array)$a_pCate as $R)      
		{	
		//while($R = $db->db_fetch_array($SQL))
		//{		
		array_push($arr_mail,"<b>ส่วนที่ ".$R['c_d']." ".strip_tags($R['c_name'])."</b>"); 
	
	if($R['c_gp'] == "Y") 
	{	
		//$SSS = db::execute("SELECT * FROM p_question WHERE c_id = '{$R['c_id']}' ORDER BY q_pos ASC"); 
		//while($X = $db->db_fetch_array($SSS))
		//{
		$SSS = "SELECT * FROM ". E_DB_NAME . ".p_question WHERE c_id = '{$R['c_id']}' ORDER BY q_pos ASC";
		$a_pQuestion = db::getFetchAll($SSS,PDO::FETCH_ASSOC);
		if($a_pQuestion) 
		{
			foreach((array)$a_pQuestion as $X)
			{	
				$SQL2	= "SELECT DISTINCT(p_ans.a_name) FROM ". E_DB_NAME . ".p_ans,". E_DB_NAME . ".p_question WHERE p_question.c_id = '{$R['c_id']}' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3";
				$a_pAns = db::getFetchAll($SQL2,PDO::FETCH_ASSOC);	
							
				/*$SQL2 = db::execute("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '{$R['c_id']}' 
				AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");*/
				$a=0;
				$i=1;			
				array_push($arr_mail,$R['c_d'].'.'.$X['q_name'].') '.strip_tags($X['q_des']));		
				
				
				if($a_pAns) 
				{
					foreach((array)$a_pAns as $Q)       
					{
					//while($Q = $db->db_fetch_array($SQL2))
					//{ 			
					if($R['option1'] == "A")
					{
			    		$ans = "ans".$X['q_id'];
			    		$ans = $_POST[$ans];
			    		$aa = explode('##',$ans);
						$ans = $aa[1];			    		
			    		if($i==1)
						{
							array_push($arr,$ans);
							array_push($arr_mail,"<font ='red'> - ".$ans."</font>");
							$i++;
						}			    		
		    		}
					else
					{
		    			$ansa = "ans".$X['q_id']."_".$a;
		    			$ansa = $_POST[$ansa];
						$aa = explode('##',$ansa);
						$ansa = $aa[1];
						array_push($arr,$ansa);
						if($ansa!="")
						{
							array_push($arr_mail,"<font ='red'> - ".$ansa."</font>");
						}
						
					}
		    		$a++;
					
					}##END foreach $Q
				}##END $a_pAns	
			}##END foreach $X
		}##END $a_pQuestion
	}
	else
	{ 
		//$SSS = db::execute("SELECT * FROM p_question WHERE c_id = '{$R['c_id']}' ORDER BY q_pos ASC"); 
		//while($X = $db->db_fetch_array($SSS))
		//{
		$SSS = "SELECT * FROM ". E_DB_NAME . ".p_question WHERE c_id = '{$R['c_id']}' ORDER BY q_pos ASC";	
		$a_pQuestion = db::getFetchAll($SSS,PDO::FETCH_ASSOC);
	

		if($a_pQuestion) 
		{
			foreach((array)$a_pQuestion as $X)
			{	
			$SSS1 = "SELECT * FROM ". E_DB_NAME . ".p_ans WHERE q_id = '{$X['q_id']}' ORDER BY option3 ASC";
			//$SSS1 = db::execute("SELECT * FROM p_ans WHERE q_id = '{$X['q_id']}' ORDER BY option3 ASC"); 											
			array_push($arr_mail,$R['c_d'].'.'.$X['q_name'].') '.strip_tags($X['q_des']));
			if($X['q_anstype']=="D")
			{ 
				//echo "ans".$X[q_id]."<br>";
				$ans = "ans".$X['q_id'];
				$ans = $_POST[$ans];
		    	array_push($arr,$ans);
		    	array_push($arr_mail,"<font ='red'> - ".$ans."</font>");
				
			}
			else if($X['q_anstype']=="E")
			{ 
				$a_row	= 	db::getRowCount($SSS1);
				if($a_row)
				{
				//if($RrRows = $db->db_num_rows($SSS1))
				//{
					$datet1 = date_format($date, 'YmdHis');					 
					if(!file_exists('download/survay_upload'))
					{
						@mkdir('download/survay_upload');
					}
						
			 		if(trim($_FILES["file1"]["tmp_name"]) != "")
					{
						$filename = $_FILES["file1"]["name"]; 
						$exp = explode('.' , $filename);
						$file = $datet1.".".$exp[count($exp)-1];						
						$isFile = is_uploaded_file($_FILES['file1']['tmp_name']); 
						
						if($isFile)
						{				
							$Path_true = 'download/survay_upload/'.$tables['s_table'];					
							if(!file_exists($Path_true))
							{
								@mkdir($Path_true);
							}										
						$isMove = move_uploaded_file ($_FILES['file1']['tmp_name'],$Path_true."/".$file);						
			 			array_push($arr,$Path_true."/".$file);
			 			array_push($arr_mail,"<font ='red'> - ".$file."</font>");											
						}
					}
					else
					{
						array_push($arr,' ');
					}			 		
				}##END rows
			}
			else if($X['q_anstype']=="F")
			{ 
				$ansp = "date".$X['q_id'];
			 	 $date_s = $_POST[$ansp];  
			 	 array_push($arr,$date_s);
			 	 array_push($arr_mail,"<font ='red'> - ".$date_s."</font>"); 				 
      		}
			else if($X['q_anstype']=="G")
			{ 
                $addr_no = "addr_no".$X['q_id'];
                $addr_no = $_POST[$addr_no];
				array_push($arr,$addr_no);
				
                $addr_prov = "addr_prov".$X['q_id'];
                $addr_prov = $_POST[$addr_prov];
                
                $s_province = "SELECT * FROM  ". E_DB_USER . ".province WHERE p_code = '{$addr_prov}' ";
				//$query_province = db::execute($sql_province);
				//$province = $db->db_fetch_array($query_province);
				$a_Zdata = db::getFetchAll($s_province,PDO::FETCH_ASSOC);
				if($a_Zdata) 
				{	
					foreach((array)$a_Zdata as $rec_province)
					{
						array_push($arr,$rec_province['p_name']); 
					}					
				}
                
                $addr_amp 	= 	"addr_amp".$X['q_id'];
                $addr_amp 	= 	$_POST[$addr_amp];
                $s_amp 	= 	"SELECT * FROM  ". E_DB_USER . ".amphur WHERE p_code = '{$addr_prov}' AND a_code = '{$addr_amp}' ";
				//$query_amp = db::execute($sql_amp);
				//$amp = $db->db_fetch_array($query_amp);
				$a_amp = db::getFetchAll($s_amp,PDO::FETCH_ASSOC);
				if($a_amp) 
				{	
					foreach((array)$a_amp as $rec_amp)
					{
						array_push($arr,$rec_amp['a_name']); 
					}					
				}
                           
                $addr_tamb = "addr_tamb".$X['q_id'];
                $addr_tamb = $_POST[$addr_tamb];
				$s_tum = "SELECT * FROM  ". E_DB_USER . ".tumpon WHERE p_code = '{$addr_prov}' AND a_code = '{$addr_amp}' AND t_code = '{$addr_tamb}' ";
				//$query_tum = db::execute($sql_tum);
				//$tum = $db->db_fetch_array($query_tum);
				$a_tum = db::getFetchAll($s_tum,PDO::FETCH_ASSOC);
				if($a_tum) 
				{	
					foreach((array)$a_tum as $rec_tum)
					{
						array_push($arr,$rec_tum['t_name']); 
					}					
				}
               				
				$addr_postcode 	=	"addr_postcode".$X['q_id'];
                $addr_postcode 	=	$_POST[$addr_postcode]; 
				array_push($arr,$addr_postcode);                              
                array_push($arr_mail,"<font ='red'> - ที่อยู่ : ".$addr_no." ตำบล/เขต : ".$addr_tamb." อำเภอ/แขวง : ".$amp["a_name"]." จังหวัด : ".$province["p_name"]." รหัสไปรษณีย์ : ".$addr_postcode."</font>");
                		    	
     		}
			else if($X['q_anstype']=="A")
			{   		
				$p = 0; 	
				$ans = "ans".$X['q_id'];
		    	$ans = $_POST[$ans];
				$aa = explode('##',$ans);
				$ans = $aa[1];
				
				$Z = db::getFetch($SSS1,PDO::FETCH_ASSOC);
				
				if($Z) 
				{
				//while($Z = $db->db_fetch_array($SSS1))
				//{					
					$ans2 = "";
					if($Z['a_other'] == "Y")
					{ 
						$ans2 = "oth".$X['q_id']."_".$p;
						$ans2 = $_POST['$ans2'];
					}					
					if($aa[0] == $p)
					{
						if($ans2!="")
						{
							array_push($arr,$ans2);
							array_push($arr_mail,"<font ='red'> - ".$ans2."</font>");
						}
						else
						{
							array_push($arr,$ans);
							array_push($arr_mail,"<font ='red'> - ".$ans."</font>");
						}
					}
					$p++;
				}
			}
			else if($X['q_anstype']=="B") 
			{
				$Z = db::getFetchAll($SSS1,PDO::FETCH_ASSOC);
				$sps = db::getRowCount($SSS1,PDO::FETCH_ASSOC);
				$p = 0; 

				foreach($Z as $value){
					if($Z) 
					{
						
					    $ansp = "ans".$X['q_id']."_".$p;
						$ansp = $_POST[$ansp]; 
						$aa = explode('##',$ansp);
						$ansp = $aa[1];
						
	
						if($Z['a_other']=="Y")
						{
							$ans2 = "oth".$X['q_id']."_".$p;
							$ans2 = $_POST[$ans2];
						} 
						
						if($ansp!="" || $ans2!="")
						{
							if($ans2=="")
							{
								array_push($arr,$ansp);
								array_push($arr_mail,"<font ='red'> - ".$ansp."</font>");
							}
							else
							{
								if($aa[0]==$p)
								{
									array_push($arr,$ans2);
									array_push($arr_mail,"<font ='red'> - ".$ans2."</font>");
								}
								else
								{
									array_push($arr,' ');
								}
							}
						}
						else
						{
							array_push($arr,' ');
						}
					}
					$p++;
				}##END array $Z		
			}
			else if($X['q_anstype']=="C")
			{ 
				//echo "anse".$X[q_id];			
				$ans = "ans".$X['q_id'];			
				$ans = $_POST[$ans];
		    	array_push($arr,$ans);
				array_push($arr_mail,"<font ='red'> - ".$ans."</font>");			
			}		
		}##while
	}##END array
	
 	}
		}// END while
	}

 	foreach($arr as $x=>$x_value)
	{
		// echo $x_value."<br>";
	}


	// function field_name($result, $field_offset)
	// {
	// 	//$properties = mysql_fetch_field($result, $field_offset);
	// 	//return is_object($properties) ? $properties->name : null;
	// }

	// function mysqli_field_name($result, $field_offset)
	// {
	// 	$properties = mysqli_fetch_field_direct($result, $field_offset);
	// 	return is_object($properties) ? $properties->name : null;
	// }

	$sql_n = "SELECT * FROM ". E_DB_NAME .".". $tables['s_table'];
	
	// $exc_n = db::execute($sql_n);
	// $a_tum = db::getFetchAll($sql_n,PDO::FETCH_ASSOC);
	
	
	//$num = $db->db_num_rows($exc_n);
	//$fieldcount = mysql_num_fields($exc_n);
	//$fieldcount = $exc_n->field_count; 
	
	$fieldcount = db::getColumnCount($sql_n);
	// var_dump($fieldcount);
	// exit();
	$date  = new DateTime();
	$datet = date_format($date, 'Y-m-d H:i:s');
	
	$sql = "INSERT INTO ". E_DB_NAME .".".  $tables['s_table']."(person_answer,time_stamp";
	$a_fieldname = db::getColumnMeta($sql_n);


	$i = 0;
	for($i=3;$i<$fieldcount;$i++)
	{
		$sql.=",".$a_fieldname[$i];	
	}

	$u_id = user::getUserID();  
	
	//$sql.="ip,date,time";
	$sql.=") VALUES ('{$u_id}','".$datet."'";
	//$sql.='".$_SERVER["REMOTE_ADDR"]."'";"
	
	$i = 0;
	for($i=3;$i<$fieldcount;$i++)
	{
		//$sql.=",'1'";	
		$sql.=",'".$arr[$i-3]."'";
		
	}
	$sql.=")";
	// echo $sql;
	
	// echo "<pre>";
	// print_r($a_data);
	// echo "</pre>";
	
	$query = db::getRowCount($sql);
	$s_ip = "INSERT INTO p_ip (p_id,ip,u_id) VALUES ('{$sid}','".getIP()."','{$u_id}') ";
	db::getRowCount($s_ip);
	
	// if($tables["end_page"]=="")
	// {
	// 	$tables["end_page"] = "more_form.php";
	// }

	echo "<script type=\"text/javascript\">";  
	// if($tables["start_page"]!=null)
	// {
	// 	echo "alert('".$tables["start_page"]."');";
	// 	echo "window.location.href = '".$tables["end_page"]."'; ";
	// }

	echo "window.location.href = 'more_form.php'; ";
	echo "</script>";
