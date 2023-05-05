<?php
	header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json", true);	
    //func แปลง tis => utf
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



//func หาสับลูก
function findparent($id){
    global $db;
    $country = array();
    $sql = $db->query("SELECT ditp_country.country_code, ditp_country.country_id 
                        FROM ditp_country
                        WHERE ditp_country.country_parent_id  = '$id' ORDER BY ditp_country.country_id ");
        if($db->db_num_rows($sql)){
            while($G = $db->db_fetch_array($sql)){ 
                $sql_c1 = "SELECT country_title FROM ditp_country_lang WHERE lang_code ='TH' AND country_id=".$G['country_id'];
                $query_sql_c1 = $db->query($sql_c1);
                $obResult1 = $db->db_fetch_array($query_sql_c1);
                $sql_c12 = "SELECT country_title FROM ditp_country_lang WHERE lang_code ='EN' AND country_id=".$G['country_id'];
                $query_sql_c12 = $db->query($sql_c12);
                $obResult12 = $db->db_fetch_array($query_sql_c12);
                $G["country_code"]?$code=iconv("tis-620","utf-8",$G["country_code"]):$code=null;
                if($code=='75'){
                    $code = (int)$code;
                }
                $obResult1["country_title"]?$th=iconv("tis-620","utf-8",$obResult1["country_title"]):$th=null;
                $obResult12["country_title"]?$en=iconv("tis-620","utf-8",$obResult12["country_title"]):$en=null;
                array_push($country,array(
                    "ID" => (int)$G['country_id'],
                    "Code" => $code,
                    "NameTH" => $th,
                    "NameEN" => $en
                ));
                //findparent($G['country_id']);	
            }
        }
     return $country;
    }

if(empty($_GET['id'])){
        $limit = 20;
		$sql_c = "SELECT country_code,country_id FROM ditp_country WHERE country_parent_id=0 ORDER BY country_id";
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

            $sql_c1 = "SELECT country_title FROM ditp_country_lang WHERE lang_code ='TH' AND country_id=".$obResult['country_id'];
            $query_sql_c1 = $db->query($sql_c1);
            $obResult1 = $db->db_fetch_array($query_sql_c1);
            $sql_c12 = "SELECT country_title FROM ditp_country_lang WHERE lang_code ='EN' AND country_id=".$obResult['country_id'];
            $query_sql_c12 = $db->query($sql_c12);
            $obResult12 = $db->db_fetch_array($query_sql_c12);
            $obResult["country_code"]?$code=iconv("tis-620","utf-8",$obResult["country_code"]):$code=null;
            if($code=='75'){
                $code = (int)$code;
            }
            $obResult1["country_title"]?$th=iconv("tis-620","utf-8",$obResult1["country_title"]):$th=null;
            $obResult12["country_title"]?$en=iconv("tis-620","utf-8",$obResult12["country_title"]):$en=null;
            $country = findparent($obResult['country_id']);
            array_push($resultArray,array(
				"ID" => (int)$obResult["country_id"],
                "NameTH" => $th,
                "NameEN" => $en,
                "Country" => $country
            ));
           
		}
       // $data = MSSQLEncodeTH2D($resultArray);
        $jdata = array('total'=>$coun1,
                        'offset'=>$offset,
                        'limit'=>$limit,
                        'data'=>$resultArray
                    );
                   /* echo'<pre>';
                    print_r($jdata);
                    echo'</pre>'; */           
        echo json_encode($jdata);
    }else{
		$sql_c = "SELECT country_code,country_id FROM ditp_country WHERE country_id=".$_GET['id'];
		$query_sql_c = $db->query($sql_c); 
        $resultArray = array();
		while($obResult = $db->db_fetch_array($query_sql_c))
		{
            $sql_c1 = "SELECT country_title FROM ditp_country_lang WHERE lang_code ='TH' AND country_id=".$obResult['country_id'];
            $query_sql_c1 = $db->query($sql_c1);
            $obResult1 = $db->db_fetch_array($query_sql_c1);
            $sql_c12 = "SELECT country_title FROM ditp_country_lang WHERE lang_code ='EN' AND country_id=".$obResult['country_id'];
            $query_sql_c12 = $db->query($sql_c12);
            $obResult12 = $db->db_fetch_array($query_sql_c12);
            $obResult["country_code"]?$code=iconv("tis-620","utf-8",$obResult["country_code"]):$code=null;
            $obResult1["country_title"]?$th=iconv("tis-620","utf-8",$obResult1["country_title"]):$th=null;
            $obResult12["country_title"]?$en=iconv("tis-620","utf-8",$obResult12["country_title"]):$en=null;
            array_push($resultArray,array(
				"ID" => (int)$obResult["country_id"],
                "Code" => $code,
                "NameTH" => $th,
                "NameEN" => $en
            ));
           
		} 
        echo json_encode($resultArray);
    }
?>