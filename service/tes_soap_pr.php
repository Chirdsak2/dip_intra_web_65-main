<html>
<head>
<title>test/title></title>
</head>
<body>


<?

	include("lib/nusoap.php");
	$client = new nusoap_client("http://thenewmenucom.ditp.go.th/TheNewService/ThenewService.asmx?wsdl",true); 
	$params = array(
			   'SecurityCode' => 'Thenewp@ssw0rd'
	);
	$data = $client->call('ExportCountryUSD', $params);
	$arr_country=array();
	foreach ($data['ExportCountryUSDResult']['diffgram']['DocumentElement']['TblCube'] as $k => $result) {
		$arr_country[]=$result["Country"];
	}
	
	echo '<pre>';
			print_r($arr_country);
			echo '</pre><hr />';
	/////////
	$client = new nusoap_client("http://thenewmenucom.ditp.go.th/TheNewService/ThenewService.asmx?wsdl",true); 
	foreach($arr_country as $kk => $val){
		// for($i=1;$i<=20;$i++){
			$params = array(
					   'SecurityCode' => 'Thenewp@ssw0rd',
					   'CountryCode'=> $val
			);
			$data = $client->call('ExportCountryAndProductBahtTop20', $params);

			// echo '<pre>';
			// print_r($data);
			// echo '</pre><hr />';
			if(count($data) == 0)
			{
					echo "Not found data!";
			}
			else
			{
				?>
						<table width="500" border="1">
						  <tr>
							<td>No</td>
							<td>Country</td>
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
						foreach ($data['ExportCountryAndProductBahtTop20Result']['diffgram']['DocumentElement']['TblCube'] as $k => $result) {
							
						?>
							  <tr>
								<td><?=$result["No"];?></td>
								<td><?=$result["Country"];?></td>
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
		// }
	}
?>
</body>
</html>