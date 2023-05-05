<?php
	header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json", true);	
	
//include("../.../lib/include.php");
include("../.../lib/function.php");
include("../.../lib/user_config.php");
include("../.../lib/connect.php");	
	
	
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

function findparent($id){
    global $db;
    $product = array();
    $sql = $db->query("SELECT ditp_type.type_id, ditp_type_lang.type_title
                        FROM ditp_type
                        LEFT JOIN ditp_type_lang ON ditp_type.type_id = ditp_type_lang.type_id 
                        WHERE ditp_type.type_parent_id='$id' ORDER BY ditp_type.type_id ");
        if($db->db_num_rows($sql)){
            while($G = $db->db_fetch_array($sql)){ 
                $G["type_title"]?$ti=iconv("tis-620","utf-8",$G["type_title"]):$ti=null;
                $pro = findparent($G['type_id']);
                if(count($pro)<1){
                    $pro=null;
                    array_push($product,array(
                        "ID" => (int)$G['type_id'],
                        "Title" => $ti
                    ));
                }else{
                    array_push($product,array(
                        "ID" => (int)$G['type_id'],
                        "Title" => $ti,
                        "Products" => $pro
                    ));
                }
                
            }
        }
     return $product;
    }

if(empty($_GET['id'])){
        $limit = 20;
		$sql_c = "SELECT ditp_type.type_id, ditp_type_lang.type_title
                  FROM ditp_type
                  LEFT JOIN ditp_type_lang ON ditp_type.type_id = ditp_type_lang.type_id 
                  WHERE ditp_type.type_parent_id=0 ORDER BY ditp_type.type_id ";
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
            $product = findparent($obResult["type_id"]);
            array_push($resultArray,array(
				"ID" => (int)$obResult["type_id"],
                "Title" => iconv("tis-620","utf-8",$obResult["type_title"]),
                "Product" => $product
            ));
           
		}
       /* $l = floor($coun1/$limit)*$limit;
        $n = $offset+$limit;
        $p = $offset-$limit;
        $t = $l/$limit;
        $pagi = array(
            'total'=>$t,
            'first' =>'http://www.ditp.go.th/ditp_web61/service/product.php?offset=0',
            'last' =>'http://www.ditp.go.th/ditp_web61/service/product.php?offset='.$l,
            'next' =>'http://www.ditp.go.th/ditp_web61/service/product.php?offset='.$n,
            'prev' =>'http://www.ditp.go.th/ditp_web61/service/product.php?offset='.$p
        );*/
       // $data = MSSQLEncodeTH2D($resultArray);
        $jdata = array('total'=>$coun1,
                        'offset'=>$offset,
                        'limit'=>$limit,
                        'data'=>$resultArray
                    );
                  /*  echo'<pre>';
                    print_r($jdata);
                    echo'</pre>';/*/
        echo json_encode($jdata);
        //echo json_last_error();
    }else{
		$sql_c = "SELECT type_id, type_title
                  FROM ditp_type_lang
                WHERE type_id=".$_GET['id'];
		$query_sql_c = $db->query($sql_c); 
        $resultArray = array();
		while($obResult = $db->db_fetch_array($query_sql_c))
		{
            array_push($resultArray,array(
				"ID" => (int)$obResult["type_id"],
				"Title" => iconv("tis-620","utf-8",$obResult["type_title"])
            ));
           
		} 
        echo json_encode($resultArray);
        //echo json_last_error();
    }
?>