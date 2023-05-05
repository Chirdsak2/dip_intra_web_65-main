<?php
header("charset='utf-8'");

$WSDL_Name='Parliament Report';
$url='http://192.168.0.113/ewtadmin0850/';

// Pull in the NuSOAP code
require_once('lib/nusoap/nusoap.php');
// Create the server instance
//$server = new soap_server();
$server = new soap_server();

// Initialize WSDL support
$server->configureWSDL($WSDL_Name, $url);

// Register the data structures used by the service
/*
$server->wsdl->addComplexType(
    'MyData',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'docid' => array('name' => 'docid', 'type' => 'xsd:string'),
        'docdate' => array('name' => 'docdate', 'type' => 'xsd:string')
        'docname' => array('name' => 'docname', 'type' => 'xsd:string')
        'docurl' => array('name' => 'docurl', 'type' => 'xsd:string')
    )
);*/

// Register the method to expose
$server->register('MeetingReport',										// method name
    array('LimitRecord' => 'xsd:string'),												// input parameters
    //array('return' => 'tns:MyData'),	 // output parameters
    array('docid' => 'xsd:string','docdate' => 'xsd:string','docname' => 'xsd:string','docurl' => 'xsd:string'),	 // output parameters
    'urn:reportwsdl',																		// namespace
    'urn:reportwsdl#MeetingReport',										// soapaction
    'rpc',																							// style
    'encoded',																				// use
    'Show report  to the caller by number of record that caller request.'											// documentation
);
// Define the method as a PHP function
function MeetingReport($LimitRecord) { 
        include("lib/user_config.php");
		$DB_WH='datawarehouse';

		$connect = mysql_connect($EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD) or die("Can not Connect database"); 
		mysql_select_db($DB_WH) or die("Can not select database"); 

       $sql="SET CHARACTER SET 'utf8' "; 	mysql_db_query($DB_WH,$sql);
	   $sql="SET collation_connection = 'utf8_general' "; 	mysql_db_query($DB_WH,$sql);

        if($LimitRecord!=''){ $limit= " limit 0,$LimitRecord";}
        $sql="SELECT * FROM data_wh WHERE `status` = 'U' order by date_update $limit";
        $query = mysql_db_query($DB_WH,$sql); 

	   $i=0;
	   //$htmlCode='<table border="1"><tr><td>Date</td><td>Report</td></tr>';
		while($res=mysql_fetch_array($query)){
			  //$htmlCode.="<tr><td>$res[date_update]</td><td>".$res[name]."</td></tr>";
				  $docid.=$res[data_wh_id]."[/]";
				  $docdate.=$res[date_update]."[/]";
				  $docname.=$res[name]."[/]";
				  $docurl.=$res[path_file]."[/]";
				  /*
				  $docid.="'".$res[data_wh_id]."',";
				  $docdate.="'".$res[date_update]."',";
				  $docname.="'".$res[name]."',";
				  $docurl.="'".$res[path_file]."',";

				  $docid[]=$res[data_wh_id];
				  $docdate[]=$res[date_update];
				  $docname[]=$res[name];
				  $docurl[]=$res[path_file];
				  */
		}
		 //$htmlCode.='</table>';
		 return array(
                'docid' => $docid,
                'docdate' => $docdate,
                'docname' =>  $docname,
                'docurl' =>  $docurl,
                );

}

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
