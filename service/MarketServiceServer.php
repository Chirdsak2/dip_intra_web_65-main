<?


require_once("lib/nusoap.php");
 $namespace = "http://www.ditp.go.th/ditp_web61/service/MarketServiceServer.php";

$server = new soap_server();
 $server->configureWSDL("getMarketWorld");


$server->wsdl->schemaTargetNamespace = $namespace;


$varname = array(
		   'Market' => "xsd:string"
);

//Add ComplexTypeaaa
$server->wsdl->addComplexType( 
	'DataList', 
	'complexType', 
	'struct', 
	'all', 
	'', 
	   array( 
			'cate_id'  => array('name' => 'cate_id', 'type'  => 'xsd:string'),
			'contents_id'  => array('name' => 'contents_id', 'type'  => 'xsd:string'),
			'cate_title'  => array('name' => 'cate_title', 'type'  => 'xsd:string'),
			'contents_title'  => array('name' => 'contents_title', 'type'  => 'xsd:string'),
			'contents_information'  => array('name' => 'contents_information', 'type'  => 'xsd:string'),
			'contents_create_date'  => array('name' => 'contents_create_date', 'type'  => 'xsd:string'),
			'contents_hits'  => array('name' => 'contents_hits', 'type'  => 'xsd:string'),
			'contents_image'  => array('name' => 'contents_image', 'type'  => 'xsd:string'),
			'contents_url'  => array('name' => 'contents_url', 'type'  => 'xsd:string'),
			'contents_target'  => array('name' => 'contents_target', 'type'  => 'xsd:string'),
			'contents_modified_date'  => array('name' => 'contents_modified_date', 'type'  => 'xsd:string'),
			'files_filename'  => array('name' => 'files_filename', 'type'  => 'xsd:string'),
			'files_filetype'  => array('name' => 'files_filetype', 'type'  => 'xsd:string'),
			'contact_region'  => array('name' => 'contact_region', 'type'  => 'xsd:string'),
			//'contact_address2'  => array('name' => 'contact_address2', 'type'  => 'xsd:string'),
			'contact_name'  => array('name' => 'contact_name', 'type'  => 'xsd:string'),
			//'country_id'  => array('name' => 'country_id', 'type'  => 'xsd:string'),
			'country_icon'  => array('name' => 'country_icon', 'type'  => 'xsd:string'),
			//'lang_code'  => array('name' => 'lang_code', 'type'  => 'xsd:string'),
			'country_title'  => array('name' => 'country_title', 'type'  => 'xsd:string')
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
$server->register('ResultMarket',$varname, 
	array('return' => 'tns:DataListResult')); 

 
function ResultMarket($Market)
{
	if($Market=='MarketKey'){
		$c_id=413;
	}else if($Market=='ProductKey'){
		$c_id=414;
	}else if($Market=='VisitKey'){
		$c_id=415;
	}else if($Market=='MarketallKey'){
		$c_id='413 OR ditp_contents_cate.cate_id = 414 OR ditp_contents_cate.cate_id = 415 ';
	}
	if($Market=='MarketKey' or $Market=='ProductKey' or $Market=='VisitKey' or $Market=='MarketallKey'){
include("../.../lib/permission1.php");
include("../.../lib/include.php");
include("../.../lib/function.php");
include("../.../lib/user_config.php");
include("../.../lib/connect.php");
include("../.../language/menu_language.php");
		$sql_c = "SELECT 
					 ditp_contents.contents_id ,
					 ditp_categories_lang.cate_title,
					ditp_contents_cate.cate_id ,
					ditp_contents_lang.contents_title ,
					ditp_contents_lang.contents_information ,
					ditp_contents.contents_create_date,
					ditp_contents.contents_hits ,
					ditp_contents.contents_image ,
					ditp_contents.contents_url,
					ditp_contents.contents_target ,
					ditp_contents.contents_modified_date ,
					ditp_content_attach.files_filename ,
					ditp_content_attach.files_filetype,
					ditp_contacts.contact_region,
					ditp_contacts.contact_address2,
					ditp_contacts.contact_name,
					ditp_country.country_id,
					ditp_country.country_icon,
					ditp_country_lang.lang_code,
					ditp_country_lang.country_title
					FROM  ditp_contents_cate
					LEFT JOIN ditp_categories_lang on ditp_contents_cate.cate_id = ditp_categories_lang.cate_id
					LEFT JOIN ditp_contents on ditp_contents_cate.contents_id = ditp_contents.contents_id
					LEFT JOIN ditp_contacts on ditp_contents.contents_contacts = ditp_contacts.contact_id
					LEFT JOIN ditp_contacts_country on ditp_contacts.contact_id = ditp_contacts_country.contact_id
					LEFT JOIN ditp_country on ditp_contacts_country.country_id = ditp_country.country_id
					LEFT JOIN ditp_country_lang on ditp_contacts_country.country_id = ditp_country_lang.country_id AND ditp_country_lang.lang_code ='EN'
					LEFT JOIN ditp_contents_lang on ditp_contents_cate.contents_id = ditp_contents_lang.contents_id
					LEFT JOIN ditp_content_attach on ditp_contents_cate.contents_id = ditp_content_attach.contents_id
					WHERE ditp_contents_cate.cate_id = ".$c_id." ORDER BY ditp_contents.contents_id ";
		$query_sql_c = $db->query($sql_c);
		$coun1 = $db->db_num_rows($query_sql_c);
		$resultArray = array();
		while($obResult = $db->db_fetch_array($query_sql_c))
		{
			
			array_push($resultArray,$obResult);
		}


		return $resultArray;
	}
}
 

$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
$server->service($POST_DATA);
exit(); 
?>