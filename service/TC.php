<?php
header('Content-Type: text/html; charset=windows-874');
include("lib/nusoap.php");
	
	//$client = new nusoap_client("http://164.115.32.224/ISC-EXT/webservice.php?wsdl",true); 
	$client = new nusoap_client("https://information.boi.go.th/WSBCD/api.php?wsdl",true); 

	$params = array(
	'usrlogin'  => 'osos1',
	'usrpasswd' => 'AvKF+cF3CFM!F4HT',
	'comcode'   => '0105522011555',
);

	$client->soap_defencoding = 'ISO-8859-1';
	$client->decode_utf8 = false;
	
	$data = $client->call('CompanyInfo', $params);
	$err = $client->getError();
	if ($err) {
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		}
		echo "<br /><pre>" .$client. "</pre>";
		//echo "<h2>Request</h2>";
		//echo "<pre>" .htmlspecialchars($client->request, ENT_QUOTES). "</pre>";
		//echo "<h2>Response</h2>";
		//echo "<pre>" .htmlspecialchars($client->response, ENT_QUOTES). "</pre>";


	echo '<h2>WDSL</h2>';
	echo '<pre>https://information.boi.go.th/WSBCD/api.php?wsdl</pre>';
	echo '<h2>Call</h2>';
	echo '<pre>CompanyInfo</pre>';
	echo '<h2>Params</h2>';
	echo '<pre>';
	print_r($params);
	echo '</pre>';
	echo '<pre>';
echo print_r($data);
	echo '</pre><hr />';
	if(count($data) == 0)
	{
			echo "Not found data!";
	}else{
		
		echo "";
	}
?>