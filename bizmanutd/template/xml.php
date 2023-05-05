<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	$sql_txt = "SELECT * FROM article_list WHERE c_id = '1' AND n_approve= 'Y'  ORDER BY n_id DESC";

	$sql = $db->query($sql_txt);

	echo '<?phpxml version="1.0" encoding="UTF-8" ?>
<rss version="2.0">
  <channel>
    <title>Update News</title>
    <link>http://www.nccc.thaigov.net/nccc/1.php</link>
    <description></description>
    <language>th-TH</language>
    <pubDate>'.date('D,d M Y H:i:s e').'</pubDate>
    <lastBuildDate>'.date('D,d M Y H:i:s').'</lastBuildDate>
    <docs></docs>
    <generator>Weblog Editor 2.0</generator>
    <managingEditor>editor@example.com</managingEditor>
    <webMaster>webmaster@example.com</webMaster>
    <ttl>5</ttl>';
	while($R=$db->db_fetch_array($sql)){
		$time = explode(" ",$R[book_create]);
		$yy = substr($R[book_timestamp],0,4);
		$mm = substr($R[book_timestamp],4,2);
		$dd = substr($R[book_timestamp],6,2);
		$h = explode(":",$time[3]);
    echo '<item>
      <title>'.$R[n_topic].'</title>
      <link>http://www.nccc.thaigov.net/nccc/</link>
      <description>'.$R[n_detail].'</description>
      <pubDate>'.date('D,d M Y H:i:s').'</pubDate>
      <guid>http://www.nccc.thaigov.net/nccc/</guid>
    </item>';
	}
 echo '</channel>
</rss>';
 @$db->db_close();
	?>