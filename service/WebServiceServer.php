<?
header ('Content-Type: application/xml; charset=utf-8');
header ('Content-type: text/html; charset=utf-8');


require_once("lib/nusoap.php");
 $namespace = "http://www.ditp.go.th/ditp_web61/service/WebServiceServer.php";

$server = new soap_server();
//$server->soap_defencoding = 'UTF-8';
//$server->decode_utf8 = false;
//$server->encode_utf8 = true;
//$server = new nusoap_server();
//$server->soap_defencoding = 'UTF-8'; 

 $server->configureWSDL("getErly");


$server->wsdl->schemaTargetNamespace = $namespace;


$varname = array(
		   'Erly' => "xsd:string"
);

//Add ComplexTypeaaa
$server->wsdl->addComplexType( 
	'DataList', 
	'complexType', 
	'struct', 
	'all', 
	'', 
	   array( 
			
			'contents_title'  => array('name' => 'contents_title', 'type'  => 'xsd:string'),
			'contents_information'  => array('name' => 'contents_information', 'type'  => 'xsd:string'),
			'country_code'  => array('name' => 'country_code', 'type'  => 'xsd:string')
   ) 
); 

//Add ComplexType
$server->wsdl->addComplexType( 
	'DataListResult', 
	'complexType', 
	'array', 
	'', 
	'SOAP-ENC:Array', 
	array(), 
	array( 
		array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'tns:DataList[]') 
	), 
	'tns:DataList' 
); 
// Register service and method
$server->register('ResultErly',$varname, 
	array('return' => 'tns:DataListResult')); 

	function Tis620ToUtf8($tis)
	{
	  for( $i=0 ; $i< strlen($tis) ; $i++ )
	  {
		$s = substr($tis, $i, 1);
		$val = ord($s);
		if( $val < 0x80 )
		{
		   $utf8 .= $s;
		}
		else if ( ( 0xA1 <= $val and $val <= 0xDA ) or ( 0xDF <= $val and $val <= 0xFB ) )
		{
		  $unicode = 0x0E00 + $val - 0xA0;
		  $utf8 .= chr( 0xE0 | ($unicode >> 12) );
		  $utf8 .= chr( 0x80 | (($unicode >> 6) & 0x3F) );
		  $utf8 .= chr( 0x80 | ($unicode & 0x3F) );
		}
	  }
	  return $utf8;
	}
function myfunction($ar)
{
  $resultArray = iconv("tis-620","utf8",$ar);
	return $resultArray;
}

function ConvertUTF8_($value){
    return iconv('tis-620','utf-8',$value);
}

function MSSQLEncodeTH($ar){ // for 1D
    $rows = array();
    foreach ($ar as $key => $value) {
        
        $rows[$key] = ConvertUTF8_($value);
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

function ResultErly($Erly)
{
	if($Erly=='ErlyKey'){

include("../.../lib/include.php");
include("../.../lib/function.php");
include("../.../lib/user_config.php");
include("../.../lib/connect.php");
$db->query("SET NAMES latin1");
		$sql_c = "SELECT	
		ditp_contents_lang.contents_title ,
		ditp_contents_lang.contents_information ,
		ditp_country.country_code
		FROM  ditp_contents_cate
		LEFT JOIN ditp_contents on ditp_contents_cate.contents_id = ditp_contents.contents_id
		LEFT JOIN ditp_contents_lang on ditp_contents_cate.contents_id = ditp_contents_lang.contents_id
		LEFT JOIN ditp_content_attach on ditp_contents_cate.contents_id = ditp_content_attach.contents_id
		LEFT JOIN ditp_contents_country on ditp_contents_cate.contents_id = ditp_contents_country.contents_id
		LEFT JOIN ditp_country on ditp_contents_country.country_id = ditp_country.country_id
		WHERE ditp_contents_cate.cate_id = 397";

		 
		 
		$query_sql_c = $db->query($sql_c);
		$coun1 = $db->db_num_rows($query_sql_c);
		$resultArray = array();
		while($obResult = $db->db_fetch_array($query_sql_c))
		{
			
			array_push($resultArray,$obResult);
		}
		

		return MSSQLEncodeTH2D($resultArray);
	}
}
 

$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
$server->service($POST_DATA);
exit(); 








?>