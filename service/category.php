<?php
	header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json", true);	
function findcate($id){
    global $db;
    $cate = array();
    
    $sql = $db->query("SELECT ditp_categories.cate_parent_id ,ditp_categories.cate_status ,ditp_categories.cate_id  , ditp_categories_lang.cate_title
        FROM ditp_categories
        LEFT JOIN ditp_categories_lang on ditp_categories.cate_id = ditp_categories_lang.cate_id 
        WHERE ditp_categories_lang.lang_code='TH' AND ditp_categories.cate_parent_id  = '$id'   ORDER BY ditp_categories.cate_id ");
        if($db->db_num_rows($sql)){
            while($G = $db->db_fetch_array($sql)){
                if($G['cate_status']==1){
                    $G["cate_title"]?$ti=iconv("tis-620","utf-8",$G["cate_title"]):$ti=null;
                    $cc = findcate($G['cate_id']);
                    if(count($cc)<1){
                        $cc=null;
                        array_push($cate,array(
                            "ID" => (int)$G['cate_id'],
                            "Title" => $ti
                        ));
                    }else{
                        array_push($cate,array(
                            "ID" => (int)$G['cate_id'],
                            "Title" => $ti,
                            "SubCate" => $cc
                        ));
                    }
                }
                
            }
        }
        return $cate;
}

function recursiveUTF8($arr) {
        if (!is_array($arr)) {
            return ConvertUTF8($arr);
        }
    
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $value = recursiveUTF8($value);
                $arr[$key] = $value;
                continue;
            }
    
            $arr[$key] = ConvertUTF8($value);
        }
    
        return $arr;
}


function MSSQLEncodeTH($ar){ // for 1D
    $rows = array();
    foreach ($ar as $key => $value) {
        
        $rows[$key] = ConvertUTF8($value);
    }
    return $rows;
}

function MSSQLEncodeTH2D($arr){  // for 2D
    $rows = array();
    if($arr)
        foreach($arr as $row ) {
            $rows[] = MSSQLEncodeTH($row);
        }
    return $rows;
}  
//include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");


if(empty($_GET['id'])){
        $limit = 20;
		$sql_c = "SELECT ditp_categories.cate_parent_id ,ditp_categories.cate_status ,ditp_categories.cate_id  , ditp_categories_lang.cate_title
        FROM ditp_categories
        LEFT JOIN ditp_categories_lang on ditp_categories.cate_id = ditp_categories_lang.cate_id 
        WHERE ditp_categories_lang.lang_code='TH' AND ditp_categories.cate_parent_id  = 0  ORDER BY ditp_categories.cate_id ";
        if (empty($_GET['offset']) || $_GET['offset'] < 0) { 
            $offset = 0; 
        }else{
            $offset = $_GET['offset'];
        }
        $query_sql_c = $db->query($sql_c);
        $coun1 = $db->db_num_rows($query_sql_c);
        $sql_c .= " LIMIT ".$offset.", ".$limit;
        $query_sql_c = $db->query($sql_c);
        $resultArray = array(); 
		while($obResult = $db->db_fetch_array($query_sql_c))
		{
            $cate = findcate($obResult["cate_id"]);
            array_push($resultArray,array(
				"ID" => (int)$obResult["cate_id"],
                "Title" => iconv("tis-620","utf-8",$obResult["cate_title"]),
                "SubCate" => $cate
            ));
           
		}
       // $data = MSSQLEncodeTH2D($resultArray);
     
        $jdata = array('total'=>$coun1,
                        'offset'=>$offset,
                        'limit'=>$limit,
                        'data'=>$resultArray
                    );  
                    /*echo'<pre>';
                    print_r($jdata);
                    echo'</pre>';*/
        echo json_encode($jdata);
        //echo json_last_error();
    }else{
		$sql_c = "SELECT ditp_categories_lang.cate_title,
                        ditp_categories_lang.cate_id
                FROM ditp_categories_lang
	WHERE ditp_categories_lang.lang_code='TH' AND ditp_categories_lang.cate_id = '{$_GET['id']}' ";
		$query_sql_c = $db->query($sql_c); 
        $resultArray = array();

		while($obResult = $db->db_fetch_array($query_sql_c))
		{
            array_push($resultArray,array(
				"ID" => (int)$obResult["cate_id"],
				"Title" => iconv("tis-620","utf-8",$obResult["cate_title"])
            ));	
           
		} 
        echo json_encode($resultArray);
        //echo json_last_error();
    }
?>