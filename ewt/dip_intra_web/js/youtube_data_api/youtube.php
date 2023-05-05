<?php
if (isset($_GET['channelId'])) {
   $channel_id = $_GET['channelId'];
  // Call set_include_path() as needed to point to your client library.
  require_once ('Google/src/Google_Client.php');
  require_once ('Google/src/contrib/Google_YouTubeService.php');

  /* Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
  Google APIs Console <http://code.google.com/apis/console#access>
  Please ensure that you have enabled the YouTube Data API for your project. */
  $DEVELOPER_KEY = 'API Key'; // Application API Key

  $client = new Google_Client();
  $client->setDeveloperKey($DEVELOPER_KEY);

  $youtube = new Google_YoutubeService($client);
 // print_r($youtube);

  try {
	
    $searchResponse = $youtube->channels->listChannels('id,snippet,statistics', array(
   'id'=>$channel_id
   ));
//echo '<pre>';
//print_r($searchResponse);
//print_r($searchResponse['items'][0]['snippet']['title']);die;
     $result = '<h1>Channel Details </h1>';
				$result .= '<img src="'.$searchResponse['items'][0]['snippet']['thumbnails']['medium']['url'].'">';
				$result .= '<br/>Channel Name : ' . $searchResponse['items'][0]['snippet']['title'];
				$result .= '<br/>Total View of Channel : ' . $searchResponse['items'][0]['statistics']['viewCount'];
				$result .= '<br/>Total Comment of Channel : ' . $searchResponse['items'][0]['statistics']['commentCount'];
				$result .= '<br/>Total no. of video in Channel : ' . $searchResponse['items'][0]['statistics']['videoCount'];	
               echo '<div>'.$result.'</div>';				

   } catch (Google_ServiceException $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
      htmlspecialchars($e->getMessage()));
  }
}
?>

<!doctype html>
<html>
  <head>
    <title>YouTube Search</title>
<link href="//www.w3resource.com/includes/bootstrap.css" rel="stylesheet">
<style type="text/css">
body{margin-top: 50px; margin-left: 50px}
</style>
  </head>
  <body>
    <form method="GET">
  <div>
    Enter Your YouTube Channel ID <input type="search" id="channelId" name="channelId" placeholder="Enter Search Term">
  </div>
  <input type="submit" value="Search">
</form>
   
</body>
</html>
