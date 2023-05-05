<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
@include("language/language.php");

$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");

include("libraries/fpdf.php");


$pdf=new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsab','','angsab.php');

$sql = $db->query("select * from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];

$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
$PR= $db->db_fetch_array($SQLX);

$height=7;
$pdf->x=15;
$pdf->SetFont('angsab', '',18);
 $pdf->Cell('180',$height,'แบบสอบถาม','',1,'C',0);

//Title of Survey Form
$pdf->SetXY(15,$pdf->y);
$pdf->SetFont('angsab', '',18);
//$pdf->MultiCell(180,$height,$PR[s_title],'LTRB',1,'J',0);
//$data_title=ereg_replace('<P>','',ereg_replace('</P>','',$PR[s_title])); 
$data_title=preg_replace($search, $replace, $PR[s_title]);
$pdf->MultiCell(180,$height,$data_title,'',1,'J',0);

$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");

 if($PR[file_page] != ""){ 
	 $pdf->SetXY(15,$pdf->y);
	 $pdf->SetFont('angsab', '',14);
	 $ps=explode('/',$PR[file_page]);  
	 $psf=$ps[sizeof($ps)-1];  
     $pdf->Cell('180',$height,'เอกสารแนบ : '.$psf,'LTRB',1,'L',0);
 }	
 
  while($R=$db->db_fetch_array($SQL)){  
      if($R[c_gp] =="Y" ){ 
     //Single Question
	       $pdf->SetXY(15,$pdf->y);
			$pdf->Cell('180',$height,'','T',1,'L',0);

	       $PartName1='ส่วนที่';
			$pdf->SetXY(15,$pdf->y);
			$pdf->SetFont('angsab', '',14);
			$data_sub=$PartName1." ".$R[c_d];
			if($R[c_name] !=""){ 
				$data_sub.=" : ".preg_replace($search, $replace, $R[c_name]);
			}

			$pdf->Cell('180',$height,$data_sub,'LTR',1,'L',0); 

			 if($R[c_title] !=""){ 
			     $DescName1='คำชี้แจง ';
			     $pdf->SetXY(15,$pdf->y);
			     $pdf->Cell('180',$height,$DescName1." : ".preg_replace($search, $replace, $R[c_title]),'LRB',1,'L',0); 
			 }
			 $pdf->SetXY(15,$pdf->y);
			 
			 
             //ตัวเลือกตอบ
			 $SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");
			 $Count_SQL2=$db->db_num_rows($SQL2);

			 $ans_width=80;//พื้นที่ความกว้างทั้งหมดสำหรับคำตอบ
			 $aftermod=80 % $Count_SQL2; // หาเศษ
			 $ans_width=$ans_width-$aftermod; // ปัดเศษออกไปจะได้หารได้ลงตัว
			 $field_width=floor($ans_width/$Count_SQL2);// หารด้วยจำนวนฟิลด์ 
			 
			 $HeadName1="ลำดับ";
			 $HeadName2="รายการ";
			 $pdf->Cell(10,$height,$HeadName1,'LRB',0,'C',0); 
			 $pdf->Cell(90+$aftermod,$height,$HeadName2,'LRB',0,'C',0);  //ปัดเศษทิ้งไปเท่าไหร่ให้เพิ่มความกว้างให้ฟิลด์รายการเท่านั้น
		    //$chklast=1;
			$LastLine=0;
			 while($Q = $db->db_fetch_array($SQL2)){ 
				// if( $chklast == $Count_SQL2) {   $LastLine=1; }else{ $LastLine=0; }
				 $pdf->Cell($field_width,$height,preg_replace($search, $replace, $Q[a_name]),'LRB',$LastLine,'C',0); 
				 $Arr_a_name[]=$Q[a_name];
				 //$chklast++;
			 }
              
			 $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	         while($X = mysql_fetch_array($SSS)){
					 $pdf->SetXY(15,$pdf->y+$height);
					 $pdf->Cell(10,$height,preg_replace($search, $replace, $X[q_name]),'LRB',0,'C',0); 
					 $data_qdes=preg_replace($search, $replace, $X[q_des]);
					 $pdf->Cell(90+$aftermod,$height,$data_qdes,'LRB',0,'L',0);
					 //$chklast=1;
					 //$LastLine=0;
					 for($i=0;$i<$Count_SQL2;$i++){
								 // if( $chklast == $Count_SQL2) {   $LastLine=1; }else{ $LastLine=0; }
								  if($R[option1]=="A"){ 
										  if($_POST["ans".$X[q_id]] == $Arr_a_name[$i]){ 
											   $pdf->Cell($field_width,$height,'OK','LRB',$LastLine,'C',0); 
										  }else{
											  $pdf->Cell($field_width,$height,'','LRB',$LastLine,'C',0); 
										  }
								  }else{ // check box
										 if($_POST["ans".$X[q_id]."_".$i] == $Arr_a_name[$i]){ 
											   $pdf->Cell($field_width,$height,'OK','LRB',$LastLine,'C',0); 
										  }else{
											  $pdf->Cell($field_width,$height,'','LRB',$LastLine,'C',0); 
										  }
								  }
								//$chklast++;
					 }//for
			 } //while
			 $pdf->SetXY(15,$pdf->y+$height);
	  }else{   
	 //Multi Question 
		    $pdf->y+=6;
		    $PartName1='ส่วนที่';
			$pdf->SetXY(15,$pdf->y);
			$pdf->SetFont('angsab', '',14);
			$data_sub=$PartName1." ".$R[c_d];
			if($R[c_name] !=""){ 
				$data_sub.=" : ".ereg_replace('<P>','',ereg_replace('</P>','',$R[c_name])); 
			} 
			$pdf->SetFillColor(255,0,0);
			//$pdf->SetDrawColor(255,0,0);  สีเส้นขอบ
			//$pdf->SetTextColor(255,0,0);    สีตัวอักษร
			$pdf->Cell('180',$height,preg_replace($search, $replace, $data_sub),'LTR',1,'L',0); 

			 if($R[c_title] !=""){ 
			     $DescName1='คำชี้แจง ';
			     $pdf->SetXY(15,$pdf->y);
			     $pdf->Cell('180',$height,$DescName1." : ".preg_replace($search, $replace, $R[c_title]),'LRB',1,'L',0); 
			 }

			 $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
			 while($X = $db->db_fetch_array($SSS)){
				 $data_quest=$X[q_name];
                 if($X[q_req]=="Y"){ 
					  $data_quest.=' * ';
				 }else{
				     $data_quest.='   ';
				 }
                 $data_quest.=preg_replace($search, $replace, $X[q_des]);
				 $pdf->SetXY(15,$pdf->y);
			     $pdf->Cell('180',$height,$data_quest,'LR',1,'L',0); 
				 $SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
				 if($X[q_anstype]=="D"){ /////////////////////////////////////////////////////////////////// D Text
					 $pdf->SetXY(15,$pdf->y);
					 $data_ansD='          '.$_POST["ans".$X[q_id]];
					 if($RrRows = $db->db_num_rows($SSS1)){
						 $Z = $db->db_fetch_array($SSS1);
						 if($Z[a_other]=="S"){
			                  $pdf->Cell('180',$height,$data_ansD,'LR',1,'L',0); 
						 }else{
						      $pdf->Cell('180',$height,$data_ansD,'LR',1,'L',0);
						 }
					 }else{
					     $pdf->Cell('180',$height,$data_ansD,'LR',1,'L',0);
					 }
				 }elseif($X[q_anstype]=="A"){////////////////////////////////////////////////////////////////A  Radio Box
					 $p=0;
					 $answer_ex = explode("#@form#img@#",$_POST["ans".$X[q_id]]); 
					 $data_ansA='          '.$answer_ex[0].' '.$_POST["oth".$X[q_id].'_'.$X[q_name]];
					 $pdf->SetXY(15,$pdf->y);
					 $pdf->Cell('180',$height,$data_ansA,'LR',1,'L',0);
				 }elseif($X[q_anstype]=="B"){////////////////////////////////////////////////////////////////B  Check Box
				    $p = 0;
					while($Z = $db->db_fetch_array($SSS1)){
						 $answer_ex = explode("#@form#img@#",$Z[a_name]); 
						 $data_ansB='          '.$answer_ex[0].' '.$_POST["oth".$X[q_id]."_".$p];
						 if($_POST["ans".$X[q_id]."_".$p] != ""){
							$pdf->SetXY(15,$pdf->y);
							$pdf->Cell('180',$height,$data_ansB,'LR',1,'L',0);
						 }
						 $p++;
					}
				 }elseif($X[q_anstype]=="C"){////////////////////////////////////////////////////////////////C  Listbox
						$answer_ex = explode("#@form#img@#",$_POST["ans".$X[q_id]]); 
						$data_ansC = '          '.$answer_ex[0].' '.$_POST["oth".$X[q_id]]; 
						$pdf->SetXY(15,$pdf->y);
						$pdf->Cell('180',$height,$data_ansC,'LR',1,'L',0);
				 }else if($X[q_anstype]=="E"){////////////////////////////////////////////////////////////////E picture
						$Z = $db->db_fetch_array($SSS1);
						$_FILES["file".$X[q_id].""]['size'];
						if($_FILES["file".$X[q_id].""]['size'] >($Z[a_other]*1024)){
								$alert1 = "*(ขนาดไฟล์ที่ท่านใช้มากกว่าที่กำหนดที่กำหนด ".$Z[a_other]." kb.)";
								$disable = "disabled";
						}
						//file uplode
						$chk = 0;
						$F = explode('.',$_FILES["file".$X[q_id].""]["name"]);
						$C = count($F);
						$CT = $C-1;
						$lfname = strtolower($F[$CT]);
						//print_r($F);
						$filetype = explode(',',$Z[a_name]);
						//print_r($filetype);
						for($f=0;$f<count($filetype);$f++){
							if(strtolower($filetype[$f])==$lfname){
							$chk = 1;
							break;
							}
						}
						if($chk  == 0){
							$alert = "*(ไฟล์ที่ท่านใช้นามสกุลไม่ตรงกับที่กำหนด  ".$Z[a_name].")";
							$disable = "disabled";
						}
						$data_ansE='          '.$_FILES["file".$X[q_id].""]["name"].$alert.$alert1;
						$pdf->SetXY(15,$pdf->y);
						$pdf->Cell('180',$height,$data_ansE,'LR',1,'L',0);
				 }else if($X[q_anstype]=="F"){ ////////////////////////////////////////////////////////////////F Calendra
						$pdf->SetXY(15,$pdf->y);
						$pdf->Cell('180',$height,'          '.$_POST["start_date".$X[q_id]],'LR',1,'L',0);
				 }else if($X[q_anstype]=="G"){ ////////////////////////////////////////////////////////////////G Address
						$db->query("USE ".$EWT_DB_USER);
						$sql_province = $rec_prov=$db->db_fetch_array($db->query("select p_name from province where p_code = '".$_POST["addr_prov".$X[q_id]]."'"));
						$sql_amphur = $rec_amphur=$db->db_fetch_array($db->query("select a_name from amphur where p_code = '".$_POST["addr_prov".$X[q_id]]."' and a_code = '".$_POST["addr_amp".$X[q_id]]."'"));
						$sql_tumpon = $rec_tumpon=$db->db_fetch_array($db->query("select t_name from tumpon where p_code = '".$_POST["addr_prov".$X[q_id]]."' and a_code = '".$_POST["addr_amp".$X[q_id]]."' and t_code = '".$_POST["addr_tamb".$X[q_id]]."' "));
						$db->query("USE ".$EWT_DB_NAME);

						
						$pdf->SetXY(15,$pdf->y);
						$pdf->Cell('180',$height,'          ตำบล '.$sql_tumpon[t_name],'LR',1,'L',0);
						$pdf->SetXY(15,$pdf->y);
						$pdf->Cell('180',$height,'          อำเภอ '.$sql_amphur[a_name],'LR',1,'L',0);
						$pdf->SetXY(15,$pdf->y);
						$pdf->Cell('180',$height,'          จังหวัด '.$sql_province[p_name],'LR',1,'L',0);
				 }
                 //$pdf->Image('mainpic/document_check.gif',$pdf->x,$pdf->y,png); 
				
			 }
			 $pdf->SetXY(15,$pdf->y);
			 $pdf->Cell('180',$height,'','T',0,'L',0);
	  }
  }
  
//$pdf->Output('survey.php','I');
$pdf->Output();
?>




