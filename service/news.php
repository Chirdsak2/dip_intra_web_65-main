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

function sub($cid){
			 global $db;
$_sql = "
      SELECT 
	  ditp_categories.cate_id ,
	  ditp_categories.cate_parent_id , 
	  ditp_categories_lang.cate_title,
      ditp_categories.cate_order	  
      FROM ditp_categories
      LEFT JOIN ditp_categories_lang on ditp_categories.cate_id = ditp_categories_lang.cate_id 
      WHERE ditp_categories.cate_parent_id = '{$cid}'
	  ORDER BY ditp_categories.cate_order ASC ,ditp_categories.cate_id ASC";
$q_cate = $db->query($_sql);
$a_rowCate = $db->db_num_rows($q_cate);
if($a_rowCate){
	$val = '';
while($a_catesub = $db->db_fetch_array($q_cate)){
	if($a_catesub['cate_id']){   
					$val .= ",'".$a_catesub['cate_id']."'";
					
					sub($a_catesub['cate_id']);
				}				
					}
	}
	return $val;
}


$cate_id = array();


function tochild($cid){
			 global $db;
			 global $cate_id;
$_sql = "
      SELECT 
	  ditp_categories.cate_id ,
	  ditp_categories.cate_parent_id , 
	  ditp_categories_lang.cate_title,
	  ditp_categories.cate_order
      FROM ditp_categories
      LEFT JOIN ditp_categories_lang on ditp_categories.cate_id = ditp_categories_lang.cate_id 
      WHERE ditp_categories.cate_parent_id = '{$cid}'
	  ORDER BY ditp_categories.cate_id ASC , ditp_categories.cate_order ASC";
$q_cate = $db->query($_sql);
$a_rowCate = $db->db_num_rows($q_cate);
if($a_rowCate){
while($a_catesub = $db->db_fetch_array($q_cate)){
	if($a_catesub['cate_id']){   
					array_push($cate_id,"'".$a_catesub['cate_id']."'");
					
					tochild($a_catesub['cate_id']);
	}				
					
				}
			 }
}			 
tochild($_GET['id']);	 



if(empty($_GET['id'])){
    $wh = "";
}else{
	
	$AA = explode(",",$_GET['id']);
	//print_r($AA);
	$ccc = count($AA);
	$i=0;
		while($ccc>$i){
			$sub = sub($AA[$i]);
			$sub_1 = $sub_1.$sub;
			$i++;
		}
	$X = implode(",",$cate_id);
		if(count($cate_id) > 1){ 
			$wh = "ditp_contents_cate.cate_id IN (".$_GET['id'].$sub_1.")";
		}else{
			$wh = "ditp_contents_cate.cate_id IN (".$_GET['id'].")";
		}			
}

 if(!empty($_GET['keyword'])){ 
$s_keyword = iconv('UTF-8','TIS-620',$_GET["keyword"]);
$whe = " AND ditp_contents_lang.contents_title LIKE '%".$s_keyword."%'"; 
 }
    if(empty($_GET['date_begin'])){ 
        $date_begin = ""; 
    }else{
        $date_begin = "ditp_contents.contents_date >= '".$_GET['date_begin']." 00:00:00' AND ";
    }
	
    if(empty($_GET['date_end'])){ 
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
	if (empty($_GET['contentid'])){
		$content_id = '';
	}else{
		$content_id = " AND ditp_contents.contents_id = '".$_GET['contentid']."'";
	}
 if(empty($_GET['id'])){       
$sql_c = "
        SELECT 
        ditp_contents.contents_id ,
        ditp_contents_lang.contents_title ,
        ditp_contents_lang.contents_information ,
        ditp_contents.contents_date,
        ditp_contents.contents_create_date,
        ditp_contents.contents_modified_date,
        ditp_contents.contents_create_by,
        ditp_contents.contents_hits ,
        ditp_contents.contents_image ,
        ditp_contents.contents_url,
        ditp_contents.contents_file,
        ditp_contents.contents_target 
        FROM  ditp_contents
        LEFT JOIN ditp_contents_lang on ditp_contents.contents_id = ditp_contents_lang.contents_id
        WHERE ".$date_begin.$date_end." ditp_contents.contents_status > 0 {$whe} {$content_id} ORDER BY ditp_contents.contents_create_date DESC ";
		
		
/*$sql_c = "SELECT 
`ditp_contents`.`contents_id`, 
`ditp_contents`.`source_id`, 
`ditp_contents`.`source_catid`, 
`ditp_contents`.`org_id`, 
`ditp_contents`.`contents_image`, 
`ditp_contents`.`contents_file`, 
`ditp_contents`.`contents_url`, 
`ditp_contents`.`contents_create_date`, 
`ditp_contents`.`contents_create_by`, 
`ditp_contents`.`contents_modified_date`, 
`ditp_contents`.`contents_modified_by`, 
`ditp_contents`.`contents_date`, 
`ditp_contents`.`contents_date_start`, 
`ditp_contents`.`contents_date_end`, 
`ditp_contents`.`contents_hits`, 
`ditp_contents`.`contents_target`, 
`ditp_contents`.`contents_version`, 
`ditp_contents`.`contents_status`, 
`ditp_contents_lang`.`lang_code`, 
`ditp_contents_lang`.`contents_title`, 
`ditp_contents_lang`.`contents_information`, 
`ditp_contents_lang`.`contents_description` 
FROM `ditp_contents` 
LEFT JOIN `ditp_contents_lang` ON (`ditp_contents`.`contents_id`=`ditp_contents_lang`.`contents_id` AND `ditp_contents_lang`.`lang_code`='TH') 
LEFT JOIN `ditp_contents_cate` ON (`ditp_contents_cate`.`contents_id`=`ditp_contents`.`contents_id`) 
LEFT JOIN `ditp_contents_country` ON (`ditp_contents_country`.`contents_id`=`ditp_contents`.`contents_id`) 
WHERE ditp_contents.contents_status > 0  
GROUP BY `ditp_contents`.`contents_id` 
ORDER BY `ditp_contents`.`contents_date` DESC";*/

 }else{		
$sql_c = "SELECT 
      ditp_contents.contents_id ,
      ditp_contents_cate.cate_id ,
      ditp_contents_lang.contents_title ,
      ditp_contents_lang.contents_information ,
      ditp_contents.contents_create_date,
      ditp_contents.contents_hits ,
      ditp_contents.contents_image ,
      ditp_contents.contents_url,
      ditp_contents.contents_file,
      ditp_contents.contents_target ,
      ditp_contacts.contact_region,
      ditp_contacts.contact_address2,
      ditp_contacts.contact_name,
      ditp_country.country_id,
      ditp_country.country_icon,
      ditp_country_lang.lang_code,
      ditp_country_lang.country_title
      FROM  ditp_contents_cate
      LEFT JOIN ditp_contents on ditp_contents_cate.contents_id = ditp_contents.contents_id
      LEFT JOIN ditp_contacts on ditp_contents.contents_contacts = ditp_contacts.contact_id
      LEFT JOIN ditp_contacts_country on ditp_contacts.contact_id = ditp_contacts_country.contact_id
      LEFT JOIN ditp_country on ditp_contacts_country.country_id = ditp_country.country_id
      LEFT JOIN ditp_country_lang on ditp_contacts_country.country_id = ditp_country_lang.country_id AND ditp_country_lang.lang_code ='EN'
      LEFT JOIN ditp_contents_lang on ditp_contents_cate.contents_id = ditp_contents_lang.contents_id
      WHERE ".$date_begin.$date_end." {$wh} {$whe} {$content_id} AND ditp_contents.contents_status > 0 
	  ORDER BY ditp_contents.contents_create_date DESC";	 		
		
 }			
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
            //cate
            $sql_c1 = "
            SELECT 
            ditp_contents_cate.cate_id ,
            ditp_categories_lang.cate_title
            FROM  ditp_contents_cate
            LEFT JOIN ditp_categories_lang ON ditp_contents_cate.cate_id = ditp_categories_lang.cate_id
            WHERE ditp_contents_cate.contents_id =".$obResult['contents_id']." ORDER BY ditp_contents_cate.cate_id";
            $query_sql_c1 = $db->query($sql_c1);
            $cate = "";
            $cate = array();
            $a=0;
            //if($db->db_num_rows($query_sql_c1)>0){
                while($obResult1 = $db->db_fetch_array($query_sql_c1)){
                array_push($cate,array(
                    "ID" => (int)$obResult1['cate_id'],
                    "Name" => iconv("tis-620","utf-8",$obResult1['cate_title'])
                ));   
                $catid = $obResult1['cate_id'];
                }
           // }
            //country
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
            //product
            $sql_c1 = "SELECT ditp_contents_type.type_id,
                            ditp_type_lang.type_title
                    FROM ditp_contents_type
                    LEFT JOIN ditp_type_lang ON ditp_contents_type.type_id = ditp_type_lang.type_id
                    WHERE ditp_contents_type.contents_id=".$obResult['contents_id'];
            $query_sql_c1 = $db->query($sql_c1);
            $type = "";
            $type = array();
            $a=0;
           // if($db->db_num_rows($query_sql_c1)>0){
                while($obResult1 = $db->db_fetch_array($query_sql_c1)){
                array_push($type,array(
                    "ID" => (int)$obResult1['type_id'],
                    "NameTH" => iconv("tis-620","utf-8",$obResult1['type_title'])
                ));   
                }
           // }
            //office
            $db->query("USE ".$EWT_DB_USER);
            $sql_c1 = "SELECT gen_user_id,name_thai,surname_thai FROM  `gen_user`  WHERE  gen_user_id='".$obResult["contents_create_by"]."'";
            $query_sql_c1 = $db->query($sql_c1);
            $offic = "";
            $offic = array();
            $a=0;
            while($obResult1 = $db->db_fetch_array($query_sql_c1)){
                $name = $obResult1['name_thai'].' '.$obResult1['surname_thai'];
            array_push($offic,array(
                "ID" => (int)$obResult1['gen_user_id'],
                "Name" => iconv("tis-620","utf-8",$name)
            ));   
            $catid = $obResult1['cate_id'];
            }
            $db->query("USE ".$EWT_DB_NAME);

            if($obResult['contents_file']=='' and $obResult['contents_url']=='#' || $obResult['contents_file']=='' and $obResult['contents_url']==''){
                $link = 'http://www.ditp.go.th/ewt_news_ditp2.php?content='.$obResult['contents_id'].'&cate='.$catid.'&d=0';
                $pdf = null;
            }else if($obResult['contents_file']!=''){
                $link = 'http://www.ditp.go.th/ewt_news_ditp2.php?content='.$obResult['contents_id'].'&cate='.$catid.'&d=0';
                $pdf = 'http://www.ditp.go.th/contents_attach/'.$obResult['contents_id'].'/'.$obResult['contents_file'];
            }else{
                $link = 'http://www.ditp.go.th/ewt_news_ditp2.php?content='.$obResult['contents_id'].'&cate='.$catid.'&d=0';
                $pdf = null;
            }
            //$offic = MSSQLEncodeTH2D($offic);
            if(count($type)<1){$type = null;}
            
           // $cate = MSSQLEncodeTH2D($cate);
           // $country = MSSQLEncodeTH2D($country);
		 
            array_push($resultArray,array(
				"ContentID" => (int)$obResult["contents_id"],
				"Title" => iconv("tis-620","utf-8",$obResult["contents_title"]),
                "AttachFile" => $pdf,
                "URL" => $link,
                "Category" => $cate,
                "Products" => $type,
                "Markets" =>  $country,
                "Office" => $offic,
                "PublishDate" => $obResult["contents_date"],
                "ExpiredDate" => null,
                "CreateDate" => $obResult["contents_create_date"],
                "UpdateDate" => $obResult["contents_modified_date"],
                "UploadUserId" => (int)$obResult["contents_create_by"],
                "_links" => $obResult["contents_target"]
            ));
           
        }

        $l = floor($coun1/$limit)*$limit;
        $n = $offset+$limit;
        $p = $offset-$limit;
        $t = ceil($coun1/$limit);
       $pagi = array(
            'total'=>$t,
            'first' =>'http://www.ditp.go.th/ditp_web61/service/newsmodel.php?offset=0',
            'last' =>'http://www.ditp.go.th/ditp_web61/service/newsmodel.php?offset='.$l,
            'next' =>'http://www.ditp.go.th/ditp_web61/service/newsmodel.php?offset='.$n,
            'prev' =>'http://www.ditp.go.th/ditp_web61/service/newsmodel.php?offset='.$p
        );
        $jdata = array('total'=>$coun1,
                        'offset'=>$offset,
                        'limit'=>$limit,
                        'data'=>$resultArray,
                        "pagination" => $pagi
                    );
       // echo'<pre>';
       //print_r($jdata);
       // echo'</pre>';
        echo json_encode($jdata);
       // echo json_last_error();
  
?>