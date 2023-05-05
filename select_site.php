<?php
	session_start();
	include("lib/include.php");
	include("lib/function.php");
	include("lib/ewt_config.php");
	include("lib/connect.php");

	//$db->query("USE ".$EWT_DB_USER);

	if($_SESSION["EWT_SMID"] != ""){
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<script src="bootstrap/js/jquery.js"></script>
<script language="JavaScript">
/*function sel(c){
	$('#UID').val(c);
	$('#form1').submit();
}*///function
function sel(c){
	document.form1.UID.value = c;
	form1.submit();
}
</script>
<style>
	body{
		background:#014da1 url(images/bg.png);
		background-size: cover;
		background-position: top center;
		background-color: ##014da1;
		
	}

	
</style>
<title><?php echo $TITLE; ?></title>

</head>
<body>
<form name="form1" id="form1" method="post" action="login.php"  >
<input name="Flag" type="hidden" id="Flag" value="Select">
<input name="UID" type="hidden" id="UID">
<div class="container">
	<div class="row">
						<div class="center">
							<a href="index.php"><img src="images/logo.png" alt="logo"> </a>
						</div>
						<div class="text-center"><h2>สำนักงานปลัดกระทรวงการท่องเที่ยวและกีฬา
 <br>กระทรวงการท่องเที่ยวและกีฬา</h2>
						</div>
					</div>
	<?php
		$sql = "SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_SMID"]."' AND status = '1' ";
		$query = $db->query($sql);
		if($db->db_num_rows($query) > 0){
			$R = $db->db_fetch_array($query);
			$mid = $R["gen_user_id"];
			$mdiv = $R["org_id"];
			$mpos = $R["posittion"];
				$sql2 = "SELECT DISTINCT(permission.UID) FROM permission WHERE ( p_type = 'U' AND pu_id = '$mid' )  ";

			$query2 = $db->query($sql2);
			$N = $db->db_num_rows($query2);
	?>	
	
	<div style="border-radius:5px; padding:5px; border:2px solid #DDDDDD; background:#e6e6e6;">
		<h4>กรุณาเลือกไซต์ที่ต้องการใช้งาน :</h4>		
		<table class="table table-responsive table table-striped table-bordered bgwhite">
			<tr>
				<th>ชื่อเว็บไซต์</th>
				<th>ชื่อเข้าใช้งานเว็บไซต์</th>
				<th>ภาษา</th>
				<!--th>Website Name</th>
				<th>Website Code</th>
				<th>Language</th-->
			</tr>

			 <?php 
				while($U = $db->db_fetch_array($query2)){ 
				$sql3 = "SELECT * FROM user_info WHERE UID = '".$U[0]."' AND EWT_Status = 'Y' ";
				$query3 = $db->query($sql3);
					if($db->db_num_rows($query3) > 0){
					$RR = $db->db_fetch_array($query3);
			?>
			<tr>
				
				<td><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> 
					<a href="#select" onClick="sel('<?php echo $U[0]; ?>')"><?php echo $RR["WebsiteName"]; ?></a>
				</td>
				<td>
					<a href="#select" onClick="sel('<?php echo $U[0]; ?>')"><?php echo $RR["EWT_User"]; ?></a>
				</td>
				<td>
					<a href="#select" onClick="sel('<?php echo $U[0]; ?>')"><img src="images/th.jpg"></a>
					<!--a href="#select" onClick="sel('<?php /* echo $U[0]; ?>')"><img src="images/flags/<?php echo substr($RR["EWT_User"],-2); */?>.png" width="20px"></a-->
				</td>
			</tr>
			<?php 
					}
				}
				if($db->db_num_rows($query3) == 0){ ?>
					<script language="JavaScript">
					window.location.href = "index.php?err=2";
					</script>
					<?php
					exit;
				}
		   ?>
		</table>
	</div>
	<?php } ?>
</div>

<div class="txtwhitefooter">
	© Copyright 2017 - BizPotential.com - All Rights Reserved. 
</div>
</form>
</body>
</html>
<?php } $db->db_close(); ?>