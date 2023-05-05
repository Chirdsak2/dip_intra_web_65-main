<?php 
$hide_header = "Y";
include("../include/com_top.php");
$wh = "";
$fiter = "";


if($_GET["S_SAPA_NO"] != ""){
	$wh .= " AND WH_SAPA_NO = '".$_GET["S_SAPA_NO"]."' ";
	/*if($_GET["S_YEAR"] == ""){
		$str .= "<div style='width:76%;float:right;text-align:center;line-height: 27px;font-size: 18pt;'>สภาผู้แทนราษฎร ชุดที่  " . thainumDigit($_GET["S_SAPA_NO"])."</div>";
	}else{
		$str .= "<div style='width:76%;float:right;text-align:center;line-height: 27px;font-size: 18pt;'>สภาผู้แทนราษฎร ชุดที่  " . thainumDigit($_GET["S_SAPA_NO"])."&nbsp; ปีที่  " . thainumDigit($_GET["S_YEAR"]) . "</div>";
	}*/
}
if($_GET["S_SYSTEM"] != ""){
	/*$sql_s = $db->query("SELECT SYSTEM_NAME2 FROM LAW_SYSTEM WHERE SYSTEM_ID='".$_GET["S_SYSTEM"]."'");
	$sys1 = $db->db_fetch_array($sql_s);*/
	$wh .= " AND WAREHOUSE_REPORT.SYSTEM_ID='".$_GET["S_SYSTEM"]."'";
	//$str .= "<div style='width:76%;float:right;text-align:center;line-height: 27px;font-size: 18pt;'>รายงาน" . thainumDigit($sys1["SYSTEM_NAME2"])."</div>";
}
if($_GET["S_YEAR"] != ""){
	$wh .= " AND WH_YEAR = '".$_GET["S_YEAR"]."' ";
}
if($_GET["S_TITLE"] != ""){
	$wh .= " AND WH_TITLE LIKE '%".$_GET["S_TITLE"]."%' ";
}
if($_GET["S_PROPOSTYPE"] != ""){
	$wh .= " AND WH_PROPOSTYPE_ID = '".$_GET["S_PROPOSTYPE"]."' ";
}
if($_GET["S_PROPOS_NAME"] != ""){
	$join .= " LEFT JOIN DR70MASM ON DR70MASM.DR7SET=WAREHOUSE_REPORT.GSET AND DR70MASM.DR7RGNO=WAREHOUSE_REPORT.GNO AND DR70MASM.DR7RGYR=WAREHOUSE_REPORT.GYEAR
			LEFT JOIN TB70MPAL ON TB70MPAL.TB7SET=DR70MASM.DR7SET AND TB70MPAL.TB7MACD=DR70MASM.DR7MACD
			LEFT JOIN CONSTITUTION_PROPOSER ON CONSTITUTION_PROPOSER.CONPROP_REGCTSS_ID=TO_CHAR(WAREHOUSE_REPORT.DOC_ID) AND CONSTITUTION_PROPOSER.SYSTEM_ID=WAREHOUSE_REPORT.SYSTEM_ID";
	//$wh .= " AND WH_PROPOSER_NAME LIKE '%".$_GET["S_PROPOS_NAME"]."%' ";
	$wh .= " AND ((CONSTITUTION_PROPOSER.CONPROP_PERSON_NAME LIKE '%".$_GET["S_PROPOS_NAME"]."%') OR  (TB70MPAL.TB7TNM LIKE '%".$_GET["S_PROPOS_NAME"]."%'))";
}
if($_GET["S_PRIME"] != ""){
	$wh .= " AND WH_PRIME_ID = '".$_GET["S_PRIME"]."' ";
}
if($_GET["S_HPARL"] != ""){
	$wh .= " AND WH_HPARL_ID = '".$_GET["S_HPARL"]."' ";
}/*if($_GET["S_STATUS"] == "Y"){
	$wh .= " AND WH_DOC_MSTATUS = '".$_GET["S_STATUS"]."' ";
}else if($_GET["S_STATUS"] == "0"){
	$wh .= " AND WH_DOC_MSTATUS IS NULL ";
}*/
if($_GET["S_PARTY"] != ""){
	//$join .= " LEFT JOIN DR50MAST ON WAREHOUSE_REPORT.GSET = DR50MAST.DR5SET AND WAREHOUSE_REPORT.GNO=DR50MAST.DR5RGNO  AND WAREHOUSE_REPORT.GYEAR=DR50MAST.DR5RGYR LEFT JOIN LAW_PARTY ON ";
	$join .= " LEFT JOIN CONSTITUTION_PROPOSER ON CONSTITUTION_PROPOSER.CONPROP_REGCTSS_ID = TO_CHAR(WAREHOUSE_REPORT.DOC_ID ) AND CONSTITUTION_PROPOSER.SYSTEM_ID=WAREHOUSE_REPORT.SYSTEM_ID";
	$wh .= " AND ((WAREHOUSE_REPORT.WH_PARTY_NAME LIKE '%".$_GET["S_PARTY"]."%') OR (CONSTITUTION_PROPOSER.CONPROP_COMMENT = '".$_GET["S_PARTY"]."'))";

}

if($_GET["S_STATUS"] != "" ){
	if($_GET["S_SYSTEM"] == 3){
		$s = explode(',',$_GET["S_STATUS"]);
		$sql_step = "SELECT * FROM TBT0STAT WHERE TBTSTA1='".$s[0]."' AND TBTSTA2 = '".$s[1]."'";
	}else{
		$sql_step = "SELECT * FROM LAW_SYSTEM_STATUS WHERE STA_ID='".$_GET["S_STATUS"]."'";
	}
	
	
	$query_step = $db->query($sql_step);
	$A = $db->db_fetch_array($query_step);
	
	/*if($A["STA_SQL"] != ""){
		$cond = " AND ".$A["STA_SQL"];
	}	*/
	
	if($A["STA_STATUS_OLD"] != ""){
		if($_GET["S_SYSTEM"] == 3){
			$STATUS_OLD = " OR (TBTSTA1 = '".$A["STA_STATUS_OLD"]."')";
		}else if($_GET["S_SYSTEM"] == 8){
			$STATUS_OLD = " OR (YR23STAT = '".$A["STA_STATUS_OLD"]."')";
		}else if($_GET["S_SYSTEM"] == 9){
			$STATUS_OLD = " OR (QR_STATUS = '".$A["STA_STATUS_OLD"]."')";
		}
	}
	//$join .= " LEFT JOIN LAW_SYSTEM_STATUS ON LAW_SYSTEM_STATUS.SYSTEM_ID=WAREHOUSE_REPORT.SYSTEM_ID ";
	$wh .= " AND (WAREHOUSE_REPORT.LAW_W_STEP_ID IN (".$A["STA_SYSTEM"].") ".$cond.$STATUS_OLD.") ";

}
if($_GET["S_CATEGORY"] != ""){
	/*$A = explode(",",$_GET["S_CATEGORY"]);
	$wh .= " AND ((WH_CAT_ID = '".$A[0]."' AND WH_FLAG IS NULL)";
	if($A[1] != ""){
		$wh .= " OR (WH_CAT_ID_OLD = '".$A[1]."' AND WH_FLAG='OLD'))";
	}*/
	if($_GET["S_SYSTEM"] != "9"){
		$sql_status = "SELECT * FROM LAW_CATEGORY_STATUS WHERE CAT_ID = '".$_GET["S_CATEGORY"]."'";
		$query_status = $db->query($sql_status);
		$S = $db->db_fetch_array($query_status);

		$wh_category = " AND ((WH_CAT_ID = '".$_GET["S_CATEGORY"]."' AND WH_FLAG IS NULL)";
		
		if($_GET["S_SYSTEM"] == '3' OR $_GET["S_SYSTEM"] == '8'){
			if($S["CAT_CODE"] != ""){
				//$CAT_CODE = " TBTSTA4 = '".$S["CAT_CODE"]."'";
				$CAT_CODE = " TBTSTA4 = '".$S["CAT_CODE"]."' AND TBTSTA1 = '".$S["CAT_CODE_TBTSTA1"]."'";
			}
			if($S["CAT_CODE_YATI"] != ""){
				$CAT_CODE_YATI = " YR23STAT ='".$S["CAT_CODE_YATI"]."'";
			}
			if(($S["CAT_CODE"] != "") AND ($S["CAT_CODE_YATI"] != "")){
				$or = " OR ";
			}
			$wh_category .= " OR (".$CAT_CODE.$or.$CAT_CODE_YATI.")";
		}
		$wh_category .= ")";
	}else{
		$join .= " INNER JOIN QR50STATUS ON QR50STATUS.QR50STAT =  WAREHOUSE_REPORT.QR_STATUS ";
		
		$wh_category = " AND ((WH_FLAG ='OLD' AND QR_STATUS IN (SELECT QR50STAT FROM QR50STATUS WHERE QR_STATUS_NEW IN (SELECT STA_ID FROM LAW_SYSTEM_STATUS WHERE SYSTEM_ID='9' AND CAT_ID='".$_GET["S_CATEGORY"]."') AND QR50QRTP=WAREHOUSE_REPORT.QR_TYPE)) OR (WH_FLAG IS NULL AND WH_CAT_ID IN (SELECT CAT_ID FROM LAW_SYSTEM_STATUS WHERE CAT_ID ='".$_GET["S_CATEGORY"]."')))";
		
		$groupby = " GROUP BY WH_SAPA_NO, WH_YEAR, WH_BOOK_NO, WH_TITLE, WH_FLAG, WAREHOUSE_REPORT.LAW_W_STEP_ID, WAREHOUSE_REPORT.SYSTEM_ID, TBTSNM4, YR23STNM, QR_TYPE, QR_STATUS_NAME, WAREHOUSE_REPORT.DOC_ID, GYEAR, GNO, GSET";
	}
}
foreach($_GET as $key => $value){
	if(!($key=='SYSTEM_ALL')){
		$param_link.=$key.'='.$value.'&';
	}
}


			$sql = gen_search_sql($S_SYSTEM," WH_ID,WH_SAPA_NO,
										WH_YEAR,
										WH_BOOK_NO,
										WH_TITLE,
										WH_FLAG,
										WAREHOUSE_REPORT.LAW_W_STEP_ID,
										WAREHOUSE_REPORT.SYSTEM_ID,
										TBTSNM4,
										YR23STNM,
										QR_TYPE,
										QR_STATUS_NAME,
										WAREHOUSE_REPORT.DOC_ID,
										GYEAR,
										GNO,
										GSET ",""," WAREHOUSE_REPORT.WH_SAPA_NO DESC NULLS LAST,WAREHOUSE_REPORT.WH_YEAR DESC NULLS LAST,WAREHOUSE_REPORT.WH_BOOK_NO DESC NULLS LAST ");
			$query = $db->query($sql);
			$num_rows = $db->db_num_rows($query);
		?>
		<?php 
		$margin_left ="7";
		$margin_right ="7";
		$margin_top = "30";
		$margin_bottom ="10";
		$header_pdf = "<h3><div><div style='width:10%;float:right;text-align:right;font-size: 16pt;font-weight: normal;'>".thainumDigit("หน้า {PAGENO} / {nb}")."</div><div style='width:10%;float:right;'></div></div><span style='text-align:center;line-height: 27px;font-size: 18pt;'>สารบบ" . show_process1($SYSTEM_ID) . "</span><hr style='color:black' /></h3>";
		$link_submit = "../pdf_l.php"; echo show_export(); ?>
				<div id="export_data">
				<table width="100%" border="0">
					<tr>
						<td><?php 
							$sql_system = "";
							$sql_system = "SELECT SYSTEM_ID,SYSTEM_NAME,SYSTEM_TABLE FROM LAW_SYSTEM WHERE SYSTEM_ID='".$_GET["S_SYSTEM"]."'";
							$query_system = $db->query($sql_system);
							$sys = $db->db_fetch_array($query_system);
							echo "<h3>".$sys["SYSTEM_NAME"]."</h3>";?></td>
						<td align="right"><h3>รวม  <?php echo thainumDigit($num_rows);?> ฉบับ</h3></td>
					</tr>
				</table>
				<table class="table table-striped table-bordered table-condensed" width="100%">
				<thead>
				  <tr valign="middle">
					<td width="10%"><div align="center"><strong>ลำดับ</strong></div></td>
					<td width="10%"><div align="center"><strong>สภาฯชุดที่</strong></div></td>
					<td width="10%"><div align="center"><strong>ปี(พ.ศ.)</strong></div></td>
					<td width="15%"><div align="center"><strong>เลขทะเบียนรับ</strong></div></td>
					<td width="35%"><div align="center"><strong><?php if($_GET["S_SYSTEM"] == "9"){ echo "ชื่อกระทู้ถาม";}else{ echo "ชื่อเรื่อง";}?></div></td>
					<td width="20%"><div align="center"><strong>สถานภาพ</strong></div></td>
				  </tr>
				</thead>
				<tbody>

				
				<?php
				$a=1;
				
				if($num_rows > 0){
				while($rec = $db->db_fetch_array($query)){
					$link="../workflow/workflow_report1.php";
					$query1 = $db->query("SELECT * FROM LAW_SYSTEM WHERE SYSTEM_ID = '".$rec["SYSTEM_ID"]."'");
					$rec_m = $db->fetch_array($query1);	
					if($rec_m["SYSTEM_LINK_REPORT"] != ""){
						if($rec["SYSTEM_ID"] == 9){
							$sql_question = "SELECT * FROM QUESTION_REGIST WHERE DOC_ID='".$rec["DOC_ID"]."'";
							$query_question = $db->query($sql_question);
							$q = $db->db_fetch_array($query_question);
							if($q["QUEREG_TYPE"] == 1){
								//$report_name = "report_09_1_pdf.php";
								$report_name = "report_09_01.php";
							}else if($q["QUEREG_TYPE"] == 2){
								//$report_name = "report_09_2_pdf.php";
								$report_name = "report_09_02.php";
							}else if($q["QUEREG_TYPE"] == 3){
								//$report_name = "report_09_3_pdf.php";
								$report_name = "report_09_03.php";
							}
						}else{
							$report_name = $rec_m["SYSTEM_LINK_REPORT"];
						}
					}
					
					
				  ?>
				  <tr>
					<td width="10%"><div align="center"><?php echo ($a+$offset);?></div></td>
					<td width="10%"><div align="center"><?php echo $rec["WH_SAPA_NO"]; ?></div></td>
					<td width="10%"><div align="center"><?php echo $rec["WH_YEAR"]; ?></div></td>
					<td width="15%"><div align="center"><?php echo $rec["WH_BOOK_NO"]; ?></div></td>
					<td width="35%"><?php echo $rec["WH_TITLE"]; ?></td>
					<td width="20%"><?php 
						
						if($rec["WH_FLAG"] == ""){
								//echo $rec["LAW_W_STEP_ID"];
								$sql_status = "SELECT STA_ID,STA_NAME,STA_SQL FROM LAW_SYSTEM_STATUS WHERE SYSTEM_ID='".$rec["SYSTEM_ID"]."' AND STA_ID IN (SELECT STA_ID FROM LAW_SYSTEM_STATUS WHERE STA_SYSTEM LIKE '%,".$rec["LAW_W_STEP_ID"].",%')" ;
								$query_status = $db->query($sql_status);
								$num_rows = $db->num_rows($query_status);
								if($num_rows > 1){
									$i=1;
									while($D = $db->db_fetch_array($query_status)){
										$sql_master = "";
										//echo $D["STA_SQL"];
										$STA_SQL = str_replace("&#039;","'",$D["STA_SQL"]);
										$sql_master = "SELECT DOC_ID FROM ".$sys["SYSTEM_TABLE"]." WHERE DOC_ID='".$rec["DOC_ID"]."' ".$STA_SQL;
										//echo "<br>";
										$query_master = $db->query($sql_master);
										$num_rows1 = $db->num_rows($query_master);
										if($num_rows1 > 0){
											$status = $D["STA_NAME"];
										}
										$i++;
									}
								
								}else{
									$D = $db->db_fetch_array($query_status);
									$status = $D["STA_NAME"];
								}
							}else if($rec["WH_FLAG"] == "OLD"){
								if($rec["SYSTEM_ID"] == "3"){
									$status = $rec["TBTSNM4"];
								}else if($rec["SYSTEM_ID"] == "8"){
									$status = $rec["YR23STNM"];
								}else if($rec["SYSTEM_ID"] == "9"){
									$status = $rec["QR_STATUS_NAME"];
								}
							}
							echo $status;
						
						
					?></td>
				  </tr>
				  <?php
				  $a++;
				}}else{?>
				  <tr>
					<td colspan="8" style="text-align:center;color:red;">ไม่พบข้อมูล</td>
				  </tr>
				<?php } ?>
				</tbody>
			</table>
	</div>
	
<?php	//}	
include("../include/com_bottom.php");
?>