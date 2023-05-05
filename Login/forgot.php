<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ลืมรหัสผ่าน</title>
    <meta name="description" content="DMR">
    <meta name="keywords" content="DMR">
    <!-- Bootstrap & Styling-->
    <link rel="stylesheet" href="../assets/css/bootstrap/bootstrap.min.css">
    <!--link(rel="stylesheet", href="css/bootstrap/bootstrap-grid.min.css")-->
    <!--link(rel="stylesheet", href="css/bootstrap/bootstrap-reboot.min.css")-->
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/plugin/font-awesome.css">
    <!--HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries-->
    <!--[if lt IE 9]
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    [endif]-->
  </head>
  <body>
    <!--Header-->
    <section class="login">
      <div class="container">
        <div class="box-wrapper">
          <div class="box box-border">
            <div class="box-body">
              <h4 class="text-center">ลืมรหัสผ่าน</h4>
              <form method="POST" action="process.php">
                <div class="form-group">
                  <label>กรอก Email</label>
                  <input class="form-control" type="email" name="email" required>
                </div>
                <div class="form-group text-right">
                  <button class="btn btn-primary btn-block">Reset Password</button>
                </div>
                <div class="form-group text-center"><a href="login.php">กลับสู่หน้าหลัก</a></div>
				<input type="hidden" name="proc" value="forgot" >
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--Footer-->
  </body>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins)-->
  <script src="../assets/js/jquery-3.3.1.min.js"></script>
  <!--Include all compiled plugins (below), or include individual files as needed-->
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/moment.min.js"></script>
  <script src="../assets/js/custom.js"></script>
</html>