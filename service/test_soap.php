<html>
<head>
<title>test/title></title>
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


<?

	include("lib/nusoap.php");
	$client = new nusoap_client("http://thenewmenucom.ditp.go.th/TheNewService/ThenewService.asmx?wsdl",true); 
	$params = array(
			   'SecurityCode' => 'Thenewp@ssw0rd'
	);
	$data = $client->call('ExportProductBaht', $params);
	echo'<h2>WDSL</h2>';
	echo '<pre>http://thenewmenucom.ditp.go.th/TheNewService/ThenewService.asmx?wsdl</pre>';
	echo'<h2>Call</h2>';
	echo '<pre>ExportCountryUSD</pre>';
	echo'<h2>Params</h2>';
	echo '<pre>';
	print_r($params);
	echo '</pre>';
	echo '<pre>';
	print_r($data['ExportProductBahtResult']['diffgram']['DocumentElement']['TblCube']);
	echo '</pre><hr />';
	if(count($data) == 0)
	{
			echo "Not found data!";
	}
	else
	{
		echo'<h2>Result</h2>';
		?>
				<table border="1" width="100%" cellspacing="0" cellpadding="5" id="tbList" class="table table-striped table-bordered dataTable no-footer" role="grid" style="width: 100%;">
				  <tr>
					<td>No</td>
					<td>Product</td>
					<td>SumYear5_2015</td>
					<td>SumYear4_2016</td>
					<td>SumYear3_2017</td>
					<td>SumYear2_2017</td>
					<td>SumYear1_2018</td>
					<td>SumGrowth5_2015</td>
					<td>SumGrowth4_2016</td>
					<td>SumGrowth3_2017</td>
					<td>SumGrowth2_2017</td>
					<td>SumGrowth1_2018</td>
					<td>SumMarketShare5_2015</td>
					<td>SumMarketShare4_2016</td>
					<td>SumMarketShare3_2017</td>
					<td>SumMarketShare2_2017</td>
					<td>SumMarketShare1_2018</td>

					
					
				  </tr>
				<?
				foreach ($data['ExportProductBahtResult']['diffgram']['DocumentElement']['TblCube'] as $k => $result) {
					
				?>
					  <tr>
						<td><?=$result["No"];?></td>
						<td><?=$result["Product"];?></td>
						<td><?=$result["SumYear5_2015"];?></td>
						<td><?=$result["SumYear4_2016"];?></td>
						<td><?=$result["SumYear3_2017"];?></td>
						<td><?=$result["SumYear2_".(date("Y")-1)];?></td>
						<td><?=$result["SumYear1_".date("Y")];?></td>
						<td><?=$result["SumGrowth5_2015"];?></td>
						<td><?=$result["SumGrowth4_2016"];?></td>
						<td><?=$result["SumGrowth3_2017"];?></td>
						<td><?=$result["SumGrowth2_2017"];?></td>
						<td><?=$result["SumGrowth1_2018"];?></td>
						<td><?=$result["SumMarketShare5_2015"];?></td>
						<td><?=$result["SumMarketShare4_2016"];?></td>
						<td><?=$result["SumMarketShare3_2017"];?></td>
						<td><?=$result["SumMarketShare2_2017"];?></td>
						<td><?=$result["SumMarketShare1_2018"];?></td>

						
					  </tr>
				<?
				}
				echo '</table>';
	}

?>
</body>
</html>