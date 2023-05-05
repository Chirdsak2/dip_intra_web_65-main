<?php
session_start();
	if($_SESSION["EWT_SMUSER"] != "" ){
				?>
				<script language="javascript">
				self.location.href = "EWT_ADMIN/main.php";		
				</script>
				<?php
			exit();
		}

	include("lib/include.php");
	
	function random_code($len){
		srand((double)microtime()*10000000);
		$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
		$ret_str = "";
		$num = strlen($chars);
		for($i = 0; $i < $len; $i++){ $ret_str .= $chars[rand()%$num]; }
		return $ret_str;
	}
	$myflag = random_code(10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" type="image/icon" href="EWT_ADMIN/images/logo_biz.png"/>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<link href="css/main.css" rel="stylesheet">
		<link href="css/responsive.css" rel="stylesheet">
		<title><?php echo $EWT_title ?></title>
		<SCRIPT LANGUAGE="JavaScript">
			function validLength(item,min,max){
				return (item.length >= min) && (item.length<=max)
			}

			function validEMail(mailObj){
				if (!validLength(mailObj.value,5,50))
				return false;
				if (mailObj.value.search("^.+@.+\\..+$") != -1)
				return true;
				else return false;
			}

			function emptyField(textObj) {
				if (textObj.value.length == 0)
				return true;
				for (var i=0; i<textObj.value.length; ++i) {
					var ch = textObj.value.charAt(i);
					if (ch != ' ' && ch != '	')
					return false;
				}
				return true;
			} 

		function  validateForm() {
			if (!emptyField(document.form1.EWT_User)) {
				if (!validLength(document.form1.EWT_User.value,1,100)) {
					alert("The length of Username is invalid");
					document.form1.EWT_User.focus();
					return false;
				}
			} else {
				alert("Please type your Username");
				document.form1.EWT_User.focus();
				return false;
			}

			if (!emptyField(document.form1.EWT_Password)) {
				if (!validLength(document.form1.EWT_Password.value,1,30)) {
				alert("The length of Password is invalid");
				document.form1.EWT_Password.focus();
				return false;
				}
			}else{
				alert("Please type your Password");
				document.form1.EWT_Password.focus();
				return false;
			}
			
			
			if($("#chkpic1").val() == ""){
				alert("กรุณากรอกตัวเลขเพื่อความปลอดภัย");
				$("#chkpic1").focus();
				return false;
			}
				
			if($("#chkpic1").val() != $("#chkpic2").val()){
				alert("กรุณากรอกตัวเลขให้ตรงกับภาพ");
				$("#chkpic1").focus();
				return false;
			}
			
			
			
			//run IE
			var mybrowser=navigator.userAgent;
			if(mybrowser.indexOf('MSIE')>0){
				winEWT = window.open('', 'EWT<?php echo $myflag; ?>', 'alwaysRaised=1,top=0,left=0,menuber=0,toolbar=0,location=0,directories=0,scrollbars=1,status=0,resizable=1,width='+ screen.availWidth +',height='+ screen.availHeight +'');
				winEWT.focus();

				window.opener=window.self; 
				closeWindow();
			}else{
				//winEWT = window.open('','_parent','');
				//window.close();
			}
		}

		function closeWindow() {
			window.open('','_parent','');
			winEWT.focus();
			window.close();
		}
		
		function Getmessage(){
			current_local_time = new Date();
			document.getElementById('logpic').innerHTML = "<img src=ewt_pic.php?#" + current_local_time.getDate() + 
			(current_local_time.getMonth()+1) + current_local_time.getYear() + current_local_time.getHours() + 
			current_local_time.getMinutes() +current_local_time.getSeconds() + "  align=absmiddle>";
			document.getElementById('chkpic1').select();
			
			$.get("ewt_pic_chang.php",{
				 ckp:"1"
			 },function(data){ 
				$('#chkpic2').val(data);
				$('#chkpic1').val("");
			});
		}
		function Get1(){
		$.get("ewt_pic_chang.php",{
				 ckp:"1"
			 },function(data){ 
				$('#chkpic2').val(data);
			});	
		}
		
		
		</SCRIPT>
		<style>
			a:link,a:active,a:visited{color:#fff;text-decoration:underline;}
			a:hover{color:red;}
		</style>
	</head>
	
	<body style="background-color:#014da1;">
		<section id="bg-login">
				<div class="container">
					<div class="row">
						<div class="center">
							<a href="index.php"><img src="images/logo.png" alt="logo"> </a>
						</div>
						<div class="text-center"><h2>สำนักงานคณะกรรมการการแข่งขันทางการค้า
 <br>OFFICE OF TRADE COMPETITION COMMISSION</h2>
						</div>
					</div>
					 <?php if($_GET["err"] == "1"){ ?>
					<div class="row center" style="padding:0"><font color="#FF0000"><b>ชื่อผู้ใช้งานและรหัสผ่านไม่ถูกต้อง</b></font></div>
					<?php } ?>
					<?php if($_GET["err"] == "2"){ ?>
					<div class="row center" style="padding:0"><font color="#FF0000"><b>ชคุณยังไม่ได้ถูกกำหนดสิทธิ์ในการใช้โปรแกรม</b></font></div>
					<?php } ?>
					<?php if($_SESSION["EWT_MID"] != ''){ ?>
					<div class="row center" style="padding:0"><font color="#FF0000"><b>เพื่อความปลอภัยในการใช้งานระบบบริหารเว็บไซต์<br>
								กรุณา login อีกครั้งเพื่อยืนยันตัวตนของท่าน</b></font></div>
					<?php } ?>
					<?php
						function chkBrowser($nameBroser){
							return preg_match("/".$nameBroser."/",$_SERVER['HTTP_USER_AGENT']);
						}
						// IE
						$targets = "";
						if(chkBrowser("MSIE")==1){
							$targets = "EWT".$myflag;
						}  
						/*if (strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0')!== false&& strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0;')!== false){
							// your code
							$targets = "EWT".$myflag;
						}*/
						
						
						
					?>
					<div class="row center" style="width:350px; margin:0 auto;">
					<!--form class="form-horizontal" id="frm-input" method="post" action="login.php" onSubmit="return chkinput();"-->
					<form class="form-horizontal" name="form1" method="post" action="login.php" onSubmit="return validateForm();" target="<?php echo $targets; ?>">
					<table class="table table-responsive" >
						<tr>
							<td class="textwhite" style="border:0px">Username :</td>
							<td style="border:0px"><input type="text" id="EWT_User" name="EWT_User" placeholder="Username" class="form-control" autocomplete="off" onclick="Get1();" OnFocus="Get1();"></td>

						</tr>
						<tr>
							<td class="textwhite" style="border:0px">Password :</td>
							<td style="border:0px"><input type="password" id="EWT_Password" name="EWT_Password" placeholder="Password" class="form-control" autocomplete="off" onclick="Get1();" OnFocus="Get1();"></td>

						</tr>
						<tr>
							<td class="textwhite" style="border:0px"></td>
							<td style="border:0px">
								<div id="logpic"><img src="ewt_pic.php"></div>
							</td>

						</tr>
						<tr>
							<td class="textwhite" style="border:0px"></td>
							<td style="border:0px" class="textwhite"><a href="#change"  onClick="Getmessage();">คลิกที่นี่</a> เพื่อเปลี่ยนรูปภาพ</td>

						</tr>
						<tr>
							<td class="textwhite" style="border:0px">กรอกรหัสตามภาพ</td>
							<td style="border:0px"><input type="text" name="chkpic1"  id="chkpic1" onclick="Get1();" placeholder="กรอกรหัสตามภาพ" class="form-control" autocomplete="off">
							<input type="hidden" name="chkpic2" id="chkpic2"></td>

						</tr>
						<tr>
							<td style="border:0px"></td>
							<td style="border:0px" class="paddingtop15"> 
							<input name="Flag" type="hidden" id="Flag" value="Login" />
                            <input name="password_hidden" type="password" style="display:none"  value="Welcome" size="10" />
							<button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
							</td>

						</tr>						
					</table>
					</form>
					</div>
					</div>
					<div class="txtwhitefooter">
						© Copyright 2017 - BizPotential.com - All Rights Reserved. 
					</div>
				</div><!-------con---->
			</section>
		<script src="js/jquery.js"></script>
		<!--script src="js/bootstrap.min.js"></script-->
		<script src="js/jquery.prettyPhoto.js"></script>
		<script src="js/jquery.isotope.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/wow.min.js"></script>
	</body>
</html>