<?php
session_start();

$EWT_PATH = '../';
$IMG_PATH = '';
$MAIN_PATH = '';

include("../lib/include.php");
include("../lib/ewt_config.php");
include("../lib/function.php");
include("../lib/config_path.php");

$db = new PHPDB($EWT_DB_TYPE, $EWT_ROOT_HOST, $EWT_ROOT_USER, $EWT_ROOT_PASSWORD, $EWT_DB_USER);
$connectdb = $db->CONNECT_SERVER();
$db->query("SET NAMES 'utf8' ");

## >> Check login
##================================================================================================##

$EWT_PORTAL_USER = "N";
$current_datetime  = date("Y-m-d H:i:s");

## >> Update expired token
$db->query("UPDATE $EWT_DB_USER.login_history_user 
			SET token_status  = 'N' 
			WHERE expire_date <= '$current_datetime'
			  AND token_status  = 'Y'");

## >> Check cookie's validity
$login_token       = ready($_COOKIE[$EWT_USER_TOKEN_BACKEND]);
$login_type        = ready($_COOKIE[$EWT_USER_LOGINTYPE_BACKEND]);

$token_data = $db->query("SELECT * FROM $EWT_DB_USER.login_history_user 
                          WHERE login_token = '$login_token' COLLATE utf8_bin 
						    AND expire_date > '$current_datetime'
							AND token_status  = 'Y' 
							AND login_through = '$login_type'");

if ($db->db_num_rows($token_data) > 0) {
	$token_info = $db->db_fetch_array($token_data);
	$user_id    = $token_info["user_id"];

	if ($login_type == "Normal") {
		## >> Check user
		$user_data = $db->query("SELECT * FROM $EWT_DB_USER.gen_user 
		                         WHERE gen_user_id = '$user_id' AND `status` = '1'");
		if ($db->db_num_rows($user_data) > 0) {
			$a_user_info     = $db->db_fetch_array($user_data);


			## >> Check permission
			$mid 	=	ready($a_user_info['gen_user_id']);
			$mdiv	=	ready($a_user_info['org_id']);
			$mpos 	=	ready($a_user_info['posittion']);
			$mtype 	=	ready($a_user_info['emp_type_id']);

			## >> Check user's permission
			## U is for user type permission
			## A is for group type permission

			$s_sql2 = 	"SELECT DISTINCT(permission.UID) 
						 FROM permission 
						 INNER JOIN user_info ON user_info.UID = permission.UID 
						 WHERE (( p_type = 'U' AND pu_id = '$mid') OR (p_type = 'A' AND pu_id = '$mtype' )) 
						 AND s_id = '0' AND EWT_Status = 'Y' ";
			$s_result2 = $db->query($s_sql2);
			$a_rows2   = $db->db_num_rows($s_result2);

			## Case: No permission
			if ($a_rows2 == 0) {
				$EWT_PORTAL_USER = "N";
			}
			## Case: Has one site permission
			else if ($a_rows2 == 1) {

				$a_data2 = $db->db_fetch_array($s_result2);

				$s_sql3		= "SELECT * FROM user_info WHERE UID = '{$a_data2[0]}' AND EWT_Status = 'Y' ";
				$s_result3 	= $db->query($s_sql3);
				$a_rows3   	= $db->db_num_rows($s_result3);
				if ($a_rows3 > 0) {
					$a_data3 = $db->db_fetch_array($s_result3);

					$_SESSION['EWT_SUID'] 	= 	$a_data3['UID'];
					$_SESSION['EWT_SUSER'] 	= 	'prd_intra_web'; //$a_data3['EWT_User'];
					$_SESSION['EWT_SDB'] 	= 	$a_data3['db_db'];
					$_SESSION['EWT_SMID'] 	= 	$mid;
					$_SESSION['EWT_SMDIV']  =   $mdiv;
					$_SESSION['EWT_SMUSER'] =	$a_user_info['gen_user'];
					#$_SESSION['EWT_SESSID'] = 	$_REQUEST['PHPSESSID'];

					$s_sql_chk 		= "	SELECT COUNT(permission.p_id) 
										FROM permission  
										WHERE (( p_type = 'U' AND pu_id = '{$mid}' ) OR ( p_type = 'A' AND pu_id = '{$mtype}' )) 
										AND permission.s_type = 'suser' 
										AND permission.UID = '{$a_data2[0]}' ";
					$s_result_chk	= $db->query($s_sql_chk);
					$CH = $db->db_fetch_array($s_result_chk);
					if ($CH[0] > 0) {
						$_SESSION['EWT_SMTYPE'] = "Y";
					} else {
						$_SESSION['EWT_SMTYPE'] = "N";
					}
					$EWT_PORTAL_USER = "Y";
				} else {
					$EWT_PORTAL_USER = "N";
				}
			}
			## Case: Have multiple sites' permissions
			else if ($a_rows2 > 1) {
				$_SESSION['EWT_SMID'] 	= $mid;
				$_SESSION['EWT_SMDIV']  =  $mdiv;
				$_SESSION['EWT_SMUSER'] = $EWT_User;
				//header("location: select_site.php");
				$a_array['url'] = 'select_site';
				//echo json_encode($a_array);

				$EWT_PORTAL_USER = "Y";
				$EWT_SELECT_SITE = "Y";
			}
		}
	} else if ($login_type == "Site_Admin") {
		## >> Check user
		$user_data = $db->query("SELECT * FROM $EWT_DB_USER.user_info 
		                         WHERE UID = '$user_id' AND EWT_STATUS = 'Y'");
		if ($db->db_num_rows($user_data) > 0) {
			$portal_userinfo = $db->db_fetch_array($user_data);
			$EWT_PORTAL_USER = "Y";

			$_SESSION['EWT_SUID'] 	= $portal_userinfo['UID'];
			$_SESSION['EWT_SUSER'] 	= 'prd_intra_web'; //$portal_userinfo['EWT_User'];
			$_SESSION['EWT_SDB'] 	= $portal_userinfo['db_db'];
			$_SESSION['EWT_SMID'] 	= '';
			$_SESSION['EWT_SMUSER'] = $portal_userinfo['EWT_User'];
			$_SESSION['EWT_SMTYPE'] = "Y";
			$_SESSION['EWT_SMDIV']  =  $portal_userinfo['org_id'];
		}
	}
}

## >> Expire cookie only if intial value is none
if ($EWT_PORTAL_USER == "N" && trim($_COOKIE[$EWT_USER_TOKEN_BACKEND]) != "") {
	$_COOKIE[$EWT_USER_TOKEN_BACKEND]     = '';
	$_COOKIE[$EWT_USER_LOGINTYPE_BACKEND] = '';

	setcookie(
		$EWT_USER_TOKEN_BACKEND,
		'',
		[
			'expires' =>  time() + (0),
			'path' => '/',
			'domain' => $EWT_COOKIE_DOMAIN,
			'secure' => $EWT_COOKIE_SECURE,
			'httponly' => $EWT_COOKIE_HTTPONLY,
			'samesite' => $EWT_COOKIE_SAMESITE
		]
	); // 86400 = 1 day
	setcookie(
		$EWT_USER_LOGINTYPE_BACKEND,
		'',
		[
			'expires' =>  time() + (0),
			'path' => '/',
			'domain' => $EWT_COOKIE_DOMAIN,
			'secure' => $EWT_COOKIE_SECURE,
			'httponly' => $EWT_COOKIE_HTTPONLY,
			'samesite' => $EWT_COOKIE_SAMESITE
		]
	); // 86400 = 1 day
	unset($login_token);
	unset($login_type);
	unset($_SESSION['EWT_SUID']);
	unset($_SESSION['EWT_SUSER']);
	unset($_SESSION['EWT_SDB']);
	unset($_SESSION['EWT_SMID']);
	unset($_SESSION['EWT_SMUSER']);
	unset($_SESSION['EWT_SMTYPE']);
	unset($_SESSION['EWT_SMDIV']);
} else if ($EWT_PORTAL_USER == "Y" && trim($_COOKIE[$EWT_USER_TOKEN_BACKEND]) != "") {

	if ($EWT_SELECT_SITE == "Y") {
		header("location:../select_site.php");
		exit();
	} else {
		header("location:../EWT_ADMIN/main.php");
		exit();
	}
}

##=====================================================================================================##
$makerandomletter = makerandomletter(10);

## >> Set CSRF
setCSRF("login_form_" . $makerandomletter);
$login_csrf = $_SESSION["login_form_" . $makerandomletter];

##=====================================================================================================##
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>เข้าสู่ระบบบริหารเว็บไซต์</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Bizpotential,Login EasyWebTime 8.9">
	<meta name="keywords" content="Bizpotential,Login EasyWebTime 8.9">

	<link rel="shortcut icon" type="image/icon" href="../EWT_ADMIN/images/prd-logo.png" />
	<!-- Bootstrap & Styling-->
	<!-- bootstrap 3.3.7 -->
	<link href="../EWT_ADMIN/css/bootstrap.css" rel="stylesheet" />
	<!-- END -->

	<!-- Main Style -->
	<!--link(rel="stylesheet", href="css/bootstrap/bootstrap-grid.min.css")-->
	<!--link(rel="stylesheet", href="css/bootstrap/bootstrap-reboot.min.css")-->
	<link rel="stylesheet" href="assets/css/global.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- font-awesome Style -->
	<link rel="stylesheet" href="../EWT_ADMIN/assets/css/font-awesome/css/all.css" />
	<!-- END -->
	<!-- animate Style -->
	<link rel="stylesheet" href="../EWT_ADMIN/assets/css/animate.min.css" />
	<!-- END -->
	<link rel="stylesheet" type="text/css" href="../js/jquery-confirm-master/css/jquery-confirm.css" />
	<script src="../js/jquery.min.js"></script>

</head>

<body>

	<!--Header-->
	<section class="login">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="text-center">
						<a href="login.php">
							<img class="img-fluid logo_login" src="assets/img/logo.png" alt="logo">
						</a>
					</div>
					<div class="welcome--text" style="color:#2c1b71;">
						<h4 class="heading">ยินดีต้อนรับเข้าสู่ระบบบริหารจัดการเว็บไซต์ <br> WEB PORTAL DIPROM </h4>
					</div>
				</div>
			</div>
			<div class="box-wrapper">
				<div class="box box-border">
					<div class="box-body">
						<form id="login_form" name="login_form" method="post" action="login.php" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="login_username" style="color:#2c1b71;"><b>Username</b></label>
										<input class="form-control" type="text" id="login_username" name="login_username" required />
										<div class="alert_text" id="alert_text_username"></div>
									</div>
									<div class="form-group">
										<label for="login_password" class="fw" style="color:#2c1b71;"><b>Password </b><!--<a class="pull-right" style="color:#FFFFFF;" href="forgot.php">ลืมรหัสผ่าน??</a>--></label>
										<input class="form-control" type="password" id="login_password" name="login_password" required />
										<div class="alert_text" id="alert_text_password"></div>
									</div>
								</div>

								<div class="col-md-12 col-sm-12 col-xs-12">
									<?php
									$genpic_id = "login_" . $makerandomletter;
									gen_pic($genpic_id);
									?>

									<div class="title-line"></div>
									<div class="form-group text-right">
										<button id="login_submit" class="btn btn-primary btn-block" type="button"><i class="fas fa-sign-in-alt"></i> Login</button>
									</div>
									<input type="hidden" name="flag" value="login">
									<input type="hidden" name="login_form" value="<?php echo $login_csrf; ?>">
									<input type="hidden" name="csrf_id" value="<?php echo $makerandomletter; ?>">
									<div id="alert_text_login_status" style="margin-top:1px;min-height:1px;"></div>

								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="text-center " style="color:#2c1b71;">
						<!--						<?php /*© Copyright © 2019, BizPotential.com - All Rights Reserved.*/ ?>-->
					</div>
				</div>
			</div>
	</section>
	<!--Footer-->
</body>
<!--	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
<script src="../EWT_ADMIN/js/bootstrap.js"></script>
<script type="text/javascript" src="../js/jquery-confirm-master/js/jquery-confirm.js"></script>

</html>

<script type="text/javascript">
	$("#login_submit").click(function() {
		$("#login_submit").prop("disabled", true);
		$(".alert_text").html("");
		$("#alert_text_login_status").html('<span style="color:#ffffff;">..กำลังดำเนินการ โปรดรอซักครู่..</span>');

		var formData = new FormData($("#login_form")[0]);

		$.ajax({
			url: "login_process.php",
			method: "post",
			data: formData,
			processData: false,
			contentType: false,
			success: function(data) {

				//$("#data_sample").html(data);
				var data = JSON.parse(data);
				console.log(data);

				setTimeout(function() {

					if (data[0].flag == "general_error") {
						$("#alert_text_login_status").html("");
						$("#login_submit").prop("disabled", false);
						$("#alert_text_login_status").html(data[0].data_array.text);
					} else if (data[0].flag == "error") {
						$("#alert_text_login_status").html(data[0].data_array.text);
						$("#login_submit").prop("disabled", false);
						var error_array = data[0].data_array.specific;
						for (var i = 0; i < error_array.length; i++) {
							$("#" + error_array[i].input_id).html(error_array[i].input_text);
						}
						//$("#formview_errorlist").html(data[0].data_array.list);
					} else if (data[0].flag == "success") {
						$("#alert_text_login_status").html(data[0].data_array.text);
						location.href = data[0].data_array.redirect;
						// redirect
					}

				}, 1000);
			}
		})
	})
</script>

<div id="data_sample"></div>