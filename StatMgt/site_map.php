<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
header ("Content-Type:text/plain;Charset=UTF-8");
$con = stripslashes(urldecode($_GET["con"]));
?>
<html>
<head>
<title>Stat</title>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<!--script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA9Q9NjejluJ1OWJeRaQXVjxS3beyIozFKzt1Ld2K2ctSd4MzqwRReCkSEvUccIF6fTL9hm6wfBAQjDQ" type="text/javascript"></script-->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAI9AGtXsp-iRtHP_2d3jUDhSjJyDtBcRYgAuuDsM10YDRIevrrhQBTTe8leRXHeXorzjds_2ZqxaWmg" type="text/javascript"></script>
<SCRIPT type=text/javascript>
		//<![CDATA[
<?php
	$sql = $db->query("SELECT sv_country ,sv_latitude,sv_longitude,sv_region,sv_city ,count(sv_id) AS ct FROM stat_visitor WHERE sv_url = 'page' AND  sv_visitor = 'Y' AND sv_longitude != '0' AND sv_latitude != '0'  ".stripslashes($con)." GROUP BY sv_latitude,sv_longitude ORDER BY ct DESC");
			?>
		function load() {
			if (GBrowserIsCompatible()) {
				var map = new GMap2(document.getElementById("map"));
				<?php
					if($db->db_num_rows($sql) > 0){
					$i = 0;
					while($R = mysql_fetch_row($sql)){
					?>
					 var txt<?php echo $i; ?> = "<div style=\"text-align:center\">";
							txt<?php echo $i; ?> += "<?php echo $R[3]; ?><br><?php echo $R[4]; ?><br><?php echo $R[0]; ?><br>(<?php echo $R[5]; ?>)";
							txt<?php echo $i; ?> += "<" + "/div>";	
							var point<?php echo $i; ?> = new GLatLng(<?php echo $R[1]; ?>, <?php echo $R[2]; ?>);
					<?php
						if($i == "0"){
						?>
							map.setCenter(point<?php echo $i; ?>, 1);
						<?php
						}
						?>
						var marker<?php echo $i; ?> = new GMarker(point<?php echo $i; ?>);	
						GEvent.addListener(marker<?php echo $i; ?>, "click", function(){marker<?php echo $i; ?>.openInfoWindowHtml(txt<?php echo $i; ?>);});
						map.addOverlay(marker<?php echo $i; ?>);
						<?php
					$i++;
					}	
				}else{
				?>
				//var point = new GLatLng(13.75, 100.5167);
				//map.setCenter(point, 1);
				map.setCenter(new GLatLng(13.75, 100.5167), 2);
				<?php
				}
				?>
				map.enableScrollWheelZoom();
				map.addControl(new GSmallMapControl());
				map.addControl(new GScaleControl());
	//			marker.openInfoWindowHtml(txt);
			}
		}
		//]]>
		</SCRIPT>
<STYLE type=text/css>
#map {
	WIDTH: 400px; HEIGHT: 335px
}
</STYLE>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0"  onload="load()" onunload="GUnload()">
<DIV id=map></DIV>
</body>
</html>
<?php
$db->db_close(); ?>
