<?php
//session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("lang_config.php");

include("../libraries/fpdf.php");

function cov($data){
	 $datacon = iconv( 'UTF-8','TIS-620',$data);
	 return $datacon;
 }


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

$pdf=new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsab','','angsab.php');

//$sql = $db->query("select * from block where BID = '".$BID."' ");
//$rec = $db->db_fetch_array($sql);
//$s_id=$rec[block_link];

$survey_id=0;
$s_id=$_GET[s_id];

$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id'");
$PR = mysql_fetch_array($SQL1);

$sendTB=$PR[s_table];

$SQLAns = $db->query("SELECT * FROM  $sendTB  WHERE survey_id = '$survey_id' ");
$FieldAns = mysql_num_fields($SQLAns);
$PRAns= $db->db_fetch_array($SQLAns);

$loop=0;
$Arr_Ans = array();
while( $loop<$FieldAns){
	 $FieldName=mysql_field_name($SQLAns,$loop);
     $Arr_Ans[]=$PRAns[$FieldName];
     $loop++;
}

$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
$PR= $db->db_fetch_array($SQLX);

$height=7;
$pdf->x=15;
$pdf->SetFont('angsab', '',18);
 $pdf->Cell('180',$height,cov('แบบสอบถาม'),'',1,'C',0);

//Title of Survey Form
$pdf->SetXY(15,$pdf->y);
$pdf->SetFont('angsab', '',18);
//$pdf->MultiCell(180,$height,$PR[s_title],'LTRB',1,'J',0);
$data_title = preg_replace($search, $replace, $PR[s_title]); 
//$data_title=ereg_replace('<P>','',ereg_replace('</P>','',$PR[s_title])); 
$pdf->MultiCell(180,$height,cov($data_title).'','',1,'J',0);

$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");

 if($PR[file_page] != ""){ 
	 $pdf->SetXY(15,$pdf->y);
	 $pdf->SetFont('angsab', '',14);
     //$pdf->Cell('180',$height,'เอกสารแนบ : '.$PR[file_page],'LTRB',1,'L',0);

	 $ps=explode('/',$PR[file_page]);  
	 $psf=$ps[sizeof($ps)-1];  
     $pdf->Cell('180',$height,cov('เอกสารแนบ : '.$psf),'LTRB',1,'L',0);
 }	

//เริ่มฟิลด์ที่ 2 เพราะว่า ฟิลด์ที่ 0 เป็น รหัส ฟิลด์ที่ 1 เป็น วันเวลา
 $AnsIndex=2;
 
while($R=$db->db_fetch_array($SQL)){  
		
		if($R[c_gp] =="Y" ){ 
		//Single Question
				$pdf->SetXY(15,$pdf->y);
				$pdf->Cell('180',$height,'','',1,'L',0);

			   $PartName1='ส่วนที่';
				$pdf->SetXY(15,$pdf->y);
				$pdf->SetFont('angsab', '',14);
				$data_sub=$PartName1." ".$R[c_d];
				if($R[c_name] !=""){ 
					$data_sub.=" : ".ereg_replace('<P>','',ereg_replace('</P>','',$R[c_name])); 
				}
				$data_sub=preg_replace($search, $replace, $data_sub);
				$pdf->Cell('180',$height,cov($data_sub),'LTR',1,'L',0); 

				 if($R[c_title] !=""){ 
					 $DescName1=cov('คำชี้แจง ');
					 $pdf->SetXY(15,$pdf->y);
					 $pdf->Cell('180',$height,cov($DescName1." : ").ereg_replace('<P>','',ereg_replace('</P>','',cov($R[c_title]))),'LRB',1,'L',0); 
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
				 $pdf->Cell(10,$height,cov($HeadName1),'LRB',0,'C',0); 
				 $pdf->Cell(90+$aftermod,$height,cov($HeadName2),'LRB',0,'C',0);  //ปัดเศษทิ้งไปเท่าไหร่ให้เพิ่มความกว้างให้ฟิลด์รายการเท่านั้น

				 // ตัวอย่างเช่น  มีฟิลด์ทั้งหมด 6 ฟิลด์  $ans_width=80  จะได้ 80 หารด้วย 6 จะได้ 13 เหลือเศษ 2 
				 //(ได้ 6 ช่อง กว้างช่องละ 13 หน่วย 13x6 = 78) 
				 // $aftermod จะมีค่า = 2  และนำไปบวกกับขนาดของช่อง รายการ จะได้ 90+2 = 92
 
				//$chklast=1;
				$LastLine=0;
				$Arr_a_name=array();
				 while($Q = $db->db_fetch_array($SQL2)){ 
						// if( $chklast == $Count_SQL2) {   $LastLine=1; }else{ $LastLine=0; }
						 $pdf->Cell($field_width,$height,cov($Q[a_name]),'LRB',$LastLine,'C',0); 
						 $Arr_a_name[]=$Q[a_name];
						 //$chklast++;
				}
              
				$SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
				while($X = $db->db_fetch_array($SSS)){ 
						 $pdf->SetXY(15,$pdf->y+$height);
						 $pdf->Cell(10,$height,cov($X[q_name]),'LRB',0,'C',0); 
						 $data_qdes=ereg_replace('<P>','',ereg_replace('</P>','',$X[q_des])); 
						 $pdf->Cell(90+$aftermod,$height,cov($data_qdes),'LRB',0,'L',0);
						 //$chklast=1;
						 //$LastLine=0;
						 for($i=0;$i<$Count_SQL2;$i++){
								 // if( $chklast == $Count_SQL2) {   $LastLine=1; }else{ $LastLine=0; }
								 $DATA_Answer=$Arr_Ans[$AnsIndex];  
								  if($R[option1]=="A"){ 
										  if($DATA_Answer == $Arr_a_name[$i]){ 
											   $pdf->Cell($field_width,$height,'OK','LRB',$LastLine,'C',0); 
										  }else{
											  $pdf->Cell($field_width,$height,'','LRB',$LastLine,'C',0); 
										  }
								  }else{
										 if($DATA_Answer == $Arr_a_name[$i]){ 
											   $pdf->Cell($field_width,$height,'OK','LRB',$LastLine,'C',0); 
											   $AnsIndex++;
										  }else{
											  $pdf->Cell($field_width,$height,'','LRB',$LastLine,'C',0); 
											  $AnsIndex++;
										  }
								  }
								//$chklast++;
							}//for 
							 if($R[option1]=="A"){  $AnsIndex++; }
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
				$data_sub=preg_replace($search, $replace, $data_sub);
				$pdf->Cell('180',$height,cov($data_sub),'LTR',1,'L',0); 

				 if($R[c_title] !=""){ 
					 $DescName1=cov('คำอธิบาย ');
					 $pdf->SetXY(15,$pdf->y);
					 $pdf->Cell('180',$height,cov($DescName1." : ").ereg_replace('<P>','',ereg_replace('</P>','',cov($R[c_title]))),'LRB',1,'L',0); 
				 }

				$SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
				while($X = $db->db_fetch_array($SSS)){
						$data_quest=$X[q_name].". ";
						$data_quest.= preg_replace($search, $replace, $X[q_des]);
						if($X[q_req]=="Y"){ 
								$data_quest.=' * ';
						}else{
								$data_quest.='   ';
						}
						$pdf->SetXY(15,$pdf->y);
						$pdf->Cell('180',$height,cov($data_quest),'LR',1,'L',0); 
						$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
						if($X[q_anstype]=="D"){ /////////////////////////////////////////////////////////////////// D Text
								$DATA_Answer=$Arr_Ans[$AnsIndex];
								$pdf->SetXY(15,$pdf->y);
								$data_ansD='          '.$DATA_Answer;
								if($RrRows = $db->db_num_rows($SSS1)){
										$Z = $db->db_fetch_array($SSS1);
										 if($Z[a_other]=="S"){
											  $pdf->Cell('180',$height,cov($data_ansD),'LR',1,'L',0); 
										 }else{
											  $pdf->Cell('180',$height,cov($data_ansD),'LR',1,'L',0);
										 }
								 }else{
									 $pdf->Cell('180',$height,$data_ansD,'LR',1,'L',0);
								 }
								 $AnsIndex++;
						}elseif($X[q_anstype]=="A"){////////////////////////////////////////////////////////////////A Radio
                                 $DATA_Answer=$Arr_Ans[$AnsIndex];
								 //$p=0;
								 //$answer_ex = explode("#@form#img@#",$_POST["ans".$X[q_id]]); 
								 $data_ansA='         '.$answer_ex[0].' '.$DATA_Answer;
								 $pdf->SetXY(15,$pdf->y);
								 $pdf->Cell('180',$height,cov($data_ansA),'LR',1,'L',0);
                                 $AnsIndex++;
						}elseif($X[q_anstype]=="B"){////////////////////////////////////////////////////////////////B Check
								$p = 0;
								while($Z = $db->db_fetch_array($SSS1)){
									     $DATA_Answer=$Arr_Ans[$AnsIndex];
										//$answer_ex = explode("#@form#img@#",$Z[a_name]); 
										$data_ansB='          '.$answer_ex[0].' '.$DATA_Answer;
										 if($DATA_Answer != ""){
													$pdf->SetXY(15,$pdf->y);
													$pdf->Cell('180',$height,cov($data_ansB),'LR',1,'L',0);
													
										 }
										 $AnsIndex++;
										$p++;
								}
						}elseif($X[q_anstype]=="C"){////////////////////////////////////////////////////////////////C  Listbox
						        $DATA_Answer=$Arr_Ans[$AnsIndex];
								//$answer_ex = explode("#@form#img@#",$_POST["ans".$X[q_id]]); 
								$data_ansC = '          '.$answer_ex[0].' '.$DATA_Answer; 
								$pdf->SetXY(15,$pdf->y);
								$pdf->Cell('180',$height,cov($data_ansC),'LR',1,'L',0);
								$AnsIndex++;
						}else if($X[q_anstype]=="E"){////////////////////////////////////////////////////////////////E Picture
						        $ps=explode('/',$Arr_Ans[$AnsIndex]);  
						        $DATA_Answer=$ps[sizeof($ps)-1];  
								$data_ansE='          '.$DATA_Answer;
								$pdf->SetXY(15,$pdf->y);
								$pdf->Cell('180',$height,cov($data_ansE),'LR',1,'L',0);
								//$pdf->Image($data_ansE,20,20,gif); 
								$AnsIndex++;
						 }else if($X[q_anstype]=="F"){ ////////////////////////////////////////////////////////////////F Calendra
							    $DATA_Answer=$Arr_Ans[$AnsIndex];  
								$pdf->SetXY(15,$pdf->y);
								$pdf->Cell('180',$height,cov('          '.$DATA_Answer),'LR',1,'L',0);
								$AnsIndex++;
						 }else if($X[q_anstype]=="G"){ ////////////////////////////////////////////////////////////////G Address

						        $DATA_Answer=$Arr_Ans[$AnsIndex];  
								$pdf->SetXY(15,$pdf->y);
								$pdf->Cell('180',$height,cov('          ตำบล '.$DATA_Answer),'LR',1,'L',0);
								$AnsIndex++;

								$DATA_Answer=$Arr_Ans[$AnsIndex];  
								$pdf->SetXY(15,$pdf->y);
								$pdf->Cell('180',$height,cov('          อำเภอ '.$DATA_Answer),'LR',1,'L',0);
								$AnsIndex++;

								$DATA_Answer=$Arr_Ans[$AnsIndex];  
								$pdf->SetXY(15,$pdf->y);
								$pdf->Cell('180',$height,cov('          จังหวัด '.$DATA_Answer),'LR',1,'L',0);
								$AnsIndex++;
						}
						//$pdf->Image('mainpic/document_check.gif',$pdf->x,$pdf->y,png); 
				
				}
				$pdf->SetXY(15,$pdf->y);
				$pdf->Cell('180',$height,''.cov($sql_province[p_name]),'T',0,'L',0);

		}
		
}
  
//$pdf->Output('survey.php','I');
$pdf->Output();
?>




