<?php
	header ('Content-type: text/html; charset=utf-8');
	$path = "../../../";
	include($path."include/config_header_top.php");
	$url_back = "../pedia_pic.php";

/** PHPExcel */
require_once '../PHPExcel/Classes/PHPExcel.php';

/** PHPExcel_IOFactory - Reader */
include '../PHPExcel/Classes/PHPExcel/IOFactory.php';


$filename = $_FILES["fileex"]["name"];
copy($_FILES["fileex"]["tmp_name"],"ex/".$filename);

$inputFileName = "ex/".$filename;  
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);  
$objReader = PHPExcel_IOFactory::createReader($inputFileType);  
$objReader->setReadDataOnly(true);  
$objPHPExcel = $objReader->load($inputFileName);  


$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
$highestRow = $objWorksheet->getHighestRow();
$highestColumn = $objWorksheet->getHighestColumn();

$headingsArray = $objWorksheet->rangeToArray('A3:'.$highestColumn.'3',null, true, true, true);
$headingsArray = $headingsArray[3];

$r = -1;
$namedDataArray = array();
for ($row = 4; $row <= $highestRow; ++$row) {
    $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
    if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
        ++$r;
        foreach($headingsArray as $columnKey => $columnHeading) {
            $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
        }
    }
}

$dataRow1 = $objWorksheet->rangeToArray('A1'); 
$namedDataArray1 = $dataRow1[0];
$dept = explode(" : ",$namedDataArray1[0]);

/*echo '<pre>';
echo $dept[1];
echo '</pre><hr />';*/

/*echo '<pre>';
var_dump($namedDataArray);
echo '</pre><hr />';*/


$sum = 0;
foreach ($namedDataArray as $result) {
	
	if($result["จำนวนสัตว์"]!=null && $result["จำนวนสัตว์"]>0){
		$fields = array("dept_id" => ($dept[1]),
						"zoo_list_id" => ($result["รหัสสัตว์"]),
						"number" => ($result["จำนวนสัตว์"]),
						"create_timestamp" => $TIMESTAMP);
		$id = $db->db_insert("epm_zoo_import",$fields,'1');
		
		$sql2 = "SELECT * FROM epm_zoo_data where  zoo_list_id = '".$result["รหัสสัตว์"]."' and dept_id = '".$dept[1]."'";
		$query2 = $db->query($sql2);
		$num_rows = $db->db_num_rows($query2);
		
		$sql3 = "SELECT * FROM epm_zoo_list where zoo_list_id = '".$result["รหัสสัตว์"]."' and zoo_list_name_th = '".$result["ชื่อสัตว์ภาษาไทย"]."'";
		$query3 = $db->query($sql3);
		$num3 = $db->db_num_rows($query3);
		
		if($num3>0){
			if($num_rows>0){
				$fields = array("zoo_number" => ($result["จำนวนสัตว์"]),"update_timestamp" => $TIMESTAMP);
				$db->db_update("epm_zoo_data",$fields," zoo_list_id = '".$result["รหัสสัตว์"]."' and dept_id = '".$dept[1]."'");
			}else{
				$sql2 = "SELECT * FROM epm_zoo_list where zoo_list_id = '".$result["รหัสสัตว์"]."'";
				$query2 = $db->query($sql2);
				$val = $db->db_fetch_array($query2);
				
				$fields = array("dept_id" => ($dept[1]),
											"zoo_list_id" => ($result["รหัสสัตว์"]),
											"zoo_number" => ($result["จำนวนสัตว์"]),
											"zoo_cate_id" => ($val["zoo_cate_id"]),
											"active_status" => ("1"));		
				$id = $db->db_insert("epm_zoo_data",$fields,'1');
			}
			$fields = array("create_timestamp" => $TIMESTAMP,"update_timestamp" => $TIMESTAMP);
			$db->db_update("epm_zoo_data",$fields," zoo_list_id = '".$result["รหัสสัตว์"]."'");
		}
		
	}
	
	
	//$sum = $sum + $result["จำนวนสัตว์"];
}
	
	unlink("ex/".$filename); 
	
	
	echo "	<form name=\"form_back\" method=\"post\" action=\"../pedia_list_data.php\">
				<input name=\"menu_id\" type=\"hidden\" value=\"".$menu_id."\" />
				<input name=\"menu_sub_id\" type=\"hidden\" value=\"".$menu_sub_id."\" />
				<input name=\"page\" type=\"hidden\" id=\"page\" value=".$page.">
				</form>";
		
	echo "<script>";
	echo "form_back.submit();";
	echo "</script>";
?>