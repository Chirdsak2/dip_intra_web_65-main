<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$Yn = date("Y")+543;
$dn = date("m-d");
$dn = $Yn."-".$dn;

	@$db->query("USE ".$EWT_DB_USER);
    $sqlu = "SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_MID"]."' AND status = '1' ";
	$queryu = $db->query($sqlu);
	
	$RU = $db->db_fetch_array($queryu);
	$mid = $_SESSION["EWT_MID"];
	$morg =$_SESSION["EWT_ORG"];
	$mmail = $_SESSION["EWT_MAIL"];
	$mname = $RU["name_thai"];
	$msname = $RU["surname_thai"];
	if($mmail==""){  /*$mmail="webmast@dmr.go.th";*/ }
		//$mpos = $RU["posittion"];
		@$db->query("USE $EWT_DB_NAME");
		$SQL2 = $db->query("SELECT * FROM p_survey_group WHERE s_id = '$s_id' and (sg_mid = '$mid' or sg_oid = '$morg') ");
		$allowUser = mysql_num_rows($SQL2);
		$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' and s_approve = 'Y' and ( '$dn' between s_start and s_end )");
		if(!$rows = mysql_num_rows($SQL1) and $allowUser==0){
			$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
			$PX = mysql_fetch_array($SQLX);
?>
   <script language="javascript">
       window.location.href="<?php if($PX[start_page]!=""){ echo $PX[start_page]; }else{ echo "survey_error.php"; } ?>";
	</script>
<?php
		}
		if($allowUser>0){
			$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
		}
		$PR = mysql_fetch_array($SQL1);
		
		$a_columns=array();
		$a_columns[0]='';
		$cntr=1;
		
		$AllData = "";
		$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");
		while($R=mysql_fetch_array($SQL)){
			if($R[c_gp] =="Y" ){
				$SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
				while($X = mysql_fetch_array($SSS)){
					$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
					$a=0;
					if($R[option1]=="A"){ 
						$ans = "ans".$X[q_id];
						$ans = $$ans;
						$AllData .= $ans."!@#%";
					}
					 while($Q = mysql_fetch_array($SQL2)){
						 if($R[option1]=="A"){
						}else{
							$ans = "ans".$X[q_id]."_".$a;
							$ans = $$ans;
							$AllData .= $ans."!@#%";
						}
						$a++;
					}
				}
			}else{
				
				$q_columns=$db->query('SHOW COLUMNS FROM '.$PR['s_table']);
				while($r_column=$db->db_fetch_array($q_columns)) {
					array_push($a_columns, $r_column[0]);
				}
				$SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC");
				//echo "SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC<hr>";
				while($X = mysql_fetch_array($SSS)){

					if($X[q_anstype]=="D"){
						$ans = "ans".$X[q_id];
						$ans = $$ans;
						$just = explode("#zz#",$X[q_req]);
					
						$filed_name = 'B'.$X[q_id];
						if($PR[end_page]!=""){ $alert = $PR[end_page]; }else{ $alert = "main.php?filename=index"; }
						if($just[1] == 'E'){
							//SI add check no duplicate email
								//echo 'X3=='.$X[3].' -- SELECT '.$a_columns[$cntr].' FROM '.$PR['s_table'].' WHERE '.$a_columns[$cntr].'=\''.$ans.'\'<hr>';
								$QE = $db->query('SELECT '.$filed_name.' FROM '.$PR['s_table'].' WHERE '.$filed_name.'=\''.$ans.'\'');
								$num_check=$db->db_num_rows($QE);
								if($num_check>0) {
								
									echo '<script type="text/javascript"> alert(\'E-mail : '.$ans.' มีผู้ใช้ตอบแบบสอบถามไปแล้ว\'); window.location.href="'.$alert.'"; </script>';
									exit;
								}
							$mail_to = $ans;
						}
						if($just[2] == 'QNR'){
							//SI add check no duplicate 
							
								$QNR = $db->query('SELECT '.$filed_name.' FROM '.$PR['s_table'].' WHERE '.$filed_name.'=\''.$ans.'\'');
								$num_check=$db->db_num_rows($QNR);
								if($num_check>0) {
									echo '<script type="text/javascript"> alert(\'ข้อมูลนี้ : '.$ans.' มีผู้ใช้ตอบแบบสอบถามไปแล้ว\'); window.location.href="'.$alert.'"; </script>';
									
									exit;
								}
						}
						$AllData .= $ans."!@#%";
					}else{
						$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
						if($X[q_anstype]=="A"){
							$oth = "";
							$p=0;
							while($Z = mysql_fetch_array($SSS1)){
								if($Z[a_other]=="Y"){
									$oth= "oth".$X[q_id]."_".$p;
									$oth = $$oth;
								}
								$p++;
							}
							$ans = "ans".$X[q_id];
							$ans = $$ans;
							if(trim($oth) != ""){
								$AllData .= $oth."!@#%";
							}else{
								$AllData .= $ans."!@#%";
							}
						}elseif($X[q_anstype]=="B"){
							$p = 0;
							while($Z = mysql_fetch_array($SSS1)){
								$oth = "";
								if($Z[a_other]=="Y"){ 
									$oth = "oth".$X[q_id]."_".$p;
									$oth = $$oth;
								} 
								$ans = "ans".$X[q_id]."_".$p;
								$ans = $$ans;
					 
								if($oth != ""){
									 $AllData .= $oth."!@#%";
								}else{
									$AllData .= $ans."!@#%";
								}
								$p++;
							}
						}elseif($X[q_anstype]=="C"){ 
							$ans = "ans".$X[q_id];
							$ans = $$ans;
							$AllData .= $ans."!@#%";
						}elseif($X[q_anstype]=="E"){ 
							$Path_true = 'download/survay_upload/survay'.$s_id;
							@mkdir ("download/survay_upload", 0777);
							$F = explode('.',$_FILES["file".$X[q_id].""]["name"]);
							$C = count($F);
							$CT = $C-1;
							$dir = strtolower($F[$CT]);
							$picname = 'survay'.date("YmdHis").".".$dir;
							@mkdir ($Path_true, 0777);
							copy($_FILES["file".$X[q_id].""]["tmp_name"],$Path_true."/".$picname);
							@chmod ($Path_true."/".$picname, 0777);
												//$ans = "ans".$X[q_id];
							 //$ans = $$ans;
							 $AllData .= $Path_true."/".$picname."!@#%";
						}elseif($X[q_anstype]=="F"){ 
							$ans = "start_date".$X[q_id];
							$ans = $$ans;
							$AllData .= $ans."!@#%";
						}elseif($X[q_anstype]=="G"){ 
							$db->query("USE ".$EWT_DB_USER);
							$sql_province = $rec_prov=$db->db_fetch_array($db->query("select p_name from province where p_code = '".$_POST["addr_prov".$X[q_id]]."'"));
							$sql_amphur = $rec_amphur=$db->db_fetch_array($db->query("select a_name from amphur where p_code = '".$_POST["addr_prov".$X[q_id]]."' and a_code = '".$_POST["addr_amp".$X[q_id]]."'"));
							$sql_tumpon = $rec_tumpon=$db->db_fetch_array($db->query("select t_name from tumpon where p_code = '".$_POST["addr_prov".$X[q_id]]."' and a_code = '".$_POST["addr_amp".$X[q_id]]."' and t_code = '".$_POST["addr_tamb".$X[q_id]]."' "));
							$db->query("USE ".$EWT_DB_NAME);
							$ans = $sql_province[p_name];//จังหวัด
							// $ans = $$ans;
							$AllData .= $ans."!@#%";
							$ans = $sql_amphur[a_name];//อำเภอ
							//$ans = $$ans;
							$AllData .= $ans."!@#%";
							$ans = $sql_tumpon[t_name];//ตำบล
							//$ans = $$ans;
							$AllData .= $ans."!@#%";
						}	// end q_anstype
					}
					$cntr++;
				}	//end while
			}
		}
		$AllData = substr($AllData,0,-4);

		$AllData = eregi_replace ( "!@#%" , "','" , $AllData );
		
		//=================================edit 28/7/2015=================================================
		//=================================PM edit 16/3/2016=================================================
		$sql0 = "INSERT INTO ".$PR[s_table]." VALUES ('','".$_SESSION[EWT_MID]."',NOW( )";
		$sql0 .= ",'".$AllData."'";
		$sql0 .= ")";
		$sql01 = $db->query($sql0);
		//echo  $sql0;
		$date_data = date('Y-m-d');
		if(getenv(HTTP_X_FORWARDED_FOR)){
			$IPn = getenv(HTTP_X_FORWARDED_FOR);
		}else{
			$IPn = getenv("REMOTE_ADDR");
		}

		/* recipients */
		
		$query_mail = mysql_query("SELECT * FROM p_survey WHERE s_id = '$s_id'");
		$to_rec  = mysql_fetch_array($query_mail);// note the comma
		$to = trim($to_rec[mail_data]);


//กรณีมีคนรับอีเมล์
if($to != "" ){
		$from =$mmail;
		/* subject */
		$subject = "ข้อมูลการการทำแบบฟอร์มออนไลน์   วันที่ $date_data";
		
		/* message */
		

		if($mname){
		   $msg="คุณ $mname $msname ได้มาตอบแบบสอบถาม";
		}else{
		  $msg="เครื่อง IP: $IPn ได้ตอบแบบสอบถาม";
		}
      $formGen_name=ereg_replace('<P>','',$to_rec[s_title]);
      $formGen_name=ereg_replace('</P>','', $formGen_name);
		$message = '
		<html>
		<head>
		<title>'.$subject.'</title>
		</head>
		<body>
		<table >
			<tr><td>วันที่ : </td>  <td>'.$date_data.'</td></tr>
			<tr> <td>ข้อความที่ส่ง :</td><td>'.$msg.' ในหัวข้อ "'.$formGen_name.'"</td> </tr>
		</table>
		</body>
		</html>
		';
		
		//echo $message;
		/* additional headers */

		$allmail=explode(";",$to);
		for($k=0;$k<sizeof($allmail);$k++){
				/* To send HTML mail, you can set the Content-type header. */
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8\r\n";
				$headers .= "To: ".$allmail[$k]." \r\n";
				$headers .= "From: $from \r\n";
				 @mail($allmail[$k], $subject, $message, $headers);
		}
}



//กรณีต้องการให้ระบบตอบกลับ
if($_REQUEST[user_mail]){
      $subject = "ข้อมูลการการทำแบบฟอร์มออนไลน์   วันที่ $date_data";
	  $msg="คุณได้เข้าตอบจากเครื่องหมายเลข IP: $IPn ";
	  $message = '
		<html>
		<head>
		<title>'.$subject.'</title>
		</head>
		<body>
		<table >
			<tr><td>วันที่ : </td>  <td>'.$date_data.'</td></tr>
			<tr> <td>ข้อความที่ส่ง :</td><td>'.$msg.' ในหัวข้อ "'.$formGen_name.'"</td> </tr>
		</table>
		</body>
		</html>
		';

		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";
		$headers .= "To: ".$_REQUEST[user_mail]." \r\n";
		$headers .= "From: $from \r\n";
		@mail($_REQUEST[user_mail], $subject, $message, $headers);
}



		//echo $message.'<br>['.$to.']<br>'.$headers;
		
		$sql = "insert into p_ip (p_id,ip)values('".$s_id."','".$IPn."') ";
		$db->query($sql);

		if($PR[start_page]!=""){
			?><script language="JavaScript" >
				alert('<?php echo $PR[start_page];?>');
			</script><?php
		}
				?><script language="JavaScript" >
			    window.location.href="<?php if($PR[end_page]!=""){ echo $PR[end_page]; }else{ echo "main.php?filename=index"; } ?>";
                </script>
				<?php
$db->close();
?>