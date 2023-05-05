<?php
	header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json", true);	
    //func แปลง tis => utf
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




if(empty($_GET['id'])){
    $id = "";
}else{
    $id = " AND ditp_contents.contents_id=".$_GET['id'];
}
    if (empty($_GET['date_begin'])) { 
        $date_begin = ""; 
    }else{
        $date_begin = "ditp_contents.contents_date>='".$_GET['date_begin']." 00:00:00' AND ";
    }
    if (empty($_GET['date_end'])) { 
        $date_end = ""; 
    }else{
        $date_end ="ditp_contents.contents_date<='".$_GET['date_end']." 99:99:99' AND ";
    }
    if(empty($_GET['date_begin']) && empty($_GET['date_end'])){
        $date_begin = "ditp_contents.contents_date<='".date("Y-m-d H:i:s")."' AND ";
    }
    if (empty($_GET['limit'])) { 
        $limit = 20; 
    }else{
        $limit = $_GET['limit'];
    }
		$sql_c = "SELECT ditp_contents.contents_id, 
                        ditp_contents.contents_create_date,
                        ditp_contents.contents_modified_date,
                        ditp_contents_lang.contents_title, 
                        ditp_contents_lang.contents_information
                FROM ditp_contents_cate
                LEFT JOIN ditp_contents ON ditp_contents_cate.contents_id = ditp_contents.contents_id
                LEFT JOIN ditp_contents_lang ON ditp_contents_cate.contents_id = ditp_contents_lang.contents_id
                WHERE ".$date_begin.$date_end."  ditp_contents.contents_status > 0 ".$id." AND ditp_contents_cate.cate_id =397  ORDER BY ditp_contents.contents_create_date DESC ";
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
            $sql_c1 = "SELECT DISTINCT   
            ditp_country.country_code,
            ditp_country.country_id
                FROM ditp_contents_country
                LEFT JOIN ditp_country ON ditp_contents_country.country_id = ditp_country.country_id
                WHERE ditp_country.country_code != '75' AND ditp_contents_country.contents_id=".$obResult['contents_id'];
            $query_sql_c1 = $db->query($sql_c1); 
            $country = "";
            $country = array();
            $a=0;
            if($db->db_num_rows($query_sql_c1)>0){
            while($obResult1 = $db->db_fetch_array($query_sql_c1)){
            $sql_c11 = "SELECT country_title FROM ditp_country_lang WHERE lang_code ='TH' AND country_id=".$obResult1['country_id'];
            $query_sql_c11 = $db->query($sql_c11);
            $obResult11 = $db->db_fetch_array($query_sql_c11);
            $sql_c12 = "SELECT country_title FROM ditp_country_lang WHERE lang_code ='EN' AND country_id=".$obResult1['country_id'];
            $query_sql_c12 = $db->query($sql_c12);
            $obResult12 = $db->db_fetch_array($query_sql_c12);

            $obResult1["country_code"]?$code=iconv("tis-620","utf-8",$obResult1["country_code"]):$code=null;
            if($code=='75'){
                $code = (int)$code;
            }
            $obResult11["country_title"]?$th=iconv("tis-620","utf-8",$obResult11["country_title"]):$th=null;
            $obResult12["country_title"]?$en=iconv("tis-620","utf-8",$obResult12["country_title"]):$en=null;
            array_push($country,array(
                "Code" => $code,
                "NameTH" => $th,
                "NameEN" => $en,
            ));   
            }}else{
            $country = null;
            }
            array_push($resultArray,array(
				"ID" => (int)$obResult["contents_id"],
				"Title" => iconv("tis-620","utf-8",$obResult["contents_title"]),
                "Information" => iconv("tis-620","utf-8",$obResult["contents_information"]),
                "Markets" =>  $country,
                "DateCreated" => $obResult["contents_create_date"],
                "DateUpdated" => $obResult["contents_modified_date"]
            ));
           
		}
        $l = floor($coun1/$limit)*$limit;
        $n = $offset+$limit;
        $p = $offset-$limit;
        $t = ceil($coun1/$limit);
        $pagi = array(
            'total'=>$t,
            'first' =>'http://www.ditp.go.th/ditp_web61/service/earlywarningmodel.php?offset=0',
            'last' =>'http://www.ditp.go.th/ditp_web61/service/earlywarningmodel.php?offset='.$l,
            'next' =>'http://www.ditp.go.th/ditp_web61/service/earlywarningmodel.php?offset='.$n,
            'prev' =>'http://www.ditp.go.th/ditp_web61/service/earlywarningmodel.php?offset='.$p
        );
       // $data = MSSQLEncodeTH2D($resultArray);
        $jdata = array('total'=>$coun1,
                        'offset'=>$offset,
                        'limit'=>$limit,
                        'data'=>$resultArray,
                        "pagination" => $pagi
                    );
        echo json_encode($jdata);
    
?>