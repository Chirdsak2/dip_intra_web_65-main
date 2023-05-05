<html>
<head>
<title>Erly Warning</title>
<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.10/css/jquery.dataTables.css">
<style type="text/css">
body { font-family: "Arial"; font-size: 12px; padding: 20px; }
</style>
</head>

<body>


<?php

// header ('Content-Type: application/xml; charset=utf-8');
// header ('Content-type: text/html; charset=utf-8');
	include("lib/nusoap.php");
	$client = new nusoap_client("http://www.ditp.go.th/ditp_web61/service/WebServiceServer.php?wsdl",true); 
	//$client->soap_defencoding = 'UTF-8';
	//$client->decode_utf8 = false;
	$params = array(
			   'Erly' => 'ErlyKey'
	);
	$data = $client->call('ResultErly', $params);
	echo'<h2>WDSL</h2>';
	echo '<pre>http://www.ditp.go.th/ditp_web61/service/WebServiceServer.php?wsdl</pre>';
	echo'<h2>Call</h2>';
	echo '<pre>ResultErly</pre>';
	echo'<h2>Params</h2>';
	echo '<pre>';
	print_r($params);
	echo '</pre>';
	 echo '<pre>';
	 print_r($data);
	 echo '</pre><hr />';
	//aee
	

	
		echo'<h2>Result</h2>';
		?>
				<table border="1" width="100%" cellspacing="0" cellpadding="5" id="tbList" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;">
				  <tr>
					<td>No</td>
					<td>contents_title</td>
					<td>contents_information</td>
					<td>country_code</td>
					

					
					
				  </tr>
				<?php
				$i=0;
				foreach ($data as $k => $result) {
					$i++;
				?>
					  <tr>
						<td><?php echo $i;?></td>
						<td><?php echo $result["contents_title"];?></td>
						<td><?php echo $result["contents_information"];?></td>
						<td><?php echo $result["country_code"];?></td>
					  </tr>
				<?php
				}
				echo '</table>';
	

?>
</body>
</html>