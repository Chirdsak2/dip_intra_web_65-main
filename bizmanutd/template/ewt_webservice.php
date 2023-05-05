<?php
// Pull in the NuSOAP code
header("charset='utf-8'");
require_once('lib/nusoap/nusoap.php');

//$host='10.152.7.15';
//$webuser='parliament_report';
//$ewtadmin='ewtadmin';

$host='192.168.0.113';
$webuser='demo_0850';
$ewtadmin='ewtadmin0850';


$url="http://$host/$ewtadmin/ewt/$webuser/ewt_webwsdl.php?wsdl";
$url2="http://$host/$ewtadmin/ewt/$webuser/ewt_webwsdl.php";

 
// Create the client instance
$client = new soapclient($url, true);
// Check for an error
$err = $client->getError();
if ($err) {
    // Display the error
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    // At this point, you know the call that follows will fail
}
// Call the SOAP method
$result = $client->call('MeetingReport', array('LimitRecord' => '10'));
// Check for a fault
if ($client->fault) {
    echo '<h2>Fault</h2><pre>';
    print_r($result);
    echo '</pre>';
} else {
    // Check for errors
    $err = $client->getError();
    if ($err) {
        // Display the error
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else {
        // Display the result
        echo '<font size="4"><B>รายงานการประชุม</B></font><br>';
        //print_r($result);
		$docid=explode('[/]',$result[docid]);
		$docdate=explode('[/]',$result[docdate]);
		$docname=explode('[/]',$result[docname]);
		$docurl=explode('[/]',$result[docurl]);
		$docmid=explode('[/]',$result[docmid]);
        
		 $htmlCode='<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
									<tr align="center" bgcolor="#CCCCCC">
										<td>ลำดับที่</td>
										<td>วันที่แก้ไขล่าสุด</td>
										<td>รายงาน</td> 
									</tr>';
		//<td>ไฟล์</td>
		$record=sizeof($docid)-1;
		if($_REQUEST[limit]>0){
		$record=$_REQUEST[limit];
		}
		 for($i=0;$i<$record;$i++){
		     $htmlCode.='
					<tr bgcolor="#FFFFFF"  align="center">
							<td>'.($i+1).'</td>
							<td>'.$docdate[$i].'</td>
							<td  align="left"><a href="ewt_servicedetail.php?mid='.$docmid[$i].'" target="_blank">'.$docname[$i].'</a></td>
					</tr>
				 ';
					// <td>'.$docurl[$i].'</td>
		 }
        $htmlCode.='</table>';
		echo  $htmlCode;
    }
}
// Display the request and response
//echo '<h2>Request</h2>';
//echo '<pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
//echo '<h2>Response</h2>';
//echo '<pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
// Display the debug messages
//echo '<h2>Debug</h2>';
//echo '<pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>
<a href="<?php echo $url;?>" target="_blank">ไฟล์ WSDL</a>
<a href="<?php echo $url2;?>" target="_blank">รายละเอียด</a>
