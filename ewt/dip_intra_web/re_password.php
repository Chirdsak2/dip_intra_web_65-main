<?php if (!empty($_GET["data"])) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PRD Intranet: ลืมรหัสผ่าน</title>
        <link rel="stylesheet" href="assets/login/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/login/assets/js/ionicons.min.css">
        <link rel="stylesheet" href="assets/login/assets/css/style.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/login/assets/css/prompt.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    </head>

    <body>
        <div class="login-dark">
            <form id="repasswordForm">
                <h2 class="sr-only">Login Form</h2>
                <div class="illustration">
                    <img src="assets/login/assets/img/logo.png">
                    <br>INTRANET
                </div>
                <div class="form-group">
                    <label for="username" hidden>รหัสผ่าน</label>
                    <input class="form-control" type="password" name="password" placeholder="รหัสผ่าน" required="required">
                </div>
                <div class="form-group">
                    <label for="password" hidden>ยืนยันรหัสผ่าน</label>
                    <input class="form-control" type="password" name="password_confirm" placeholder="ยืนยันรหัสผ่าน" required="required">
                </div>

                <div class="form-group">
                    <div class="text-center" id="list_re_password" style="display:none;">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small id="m_re_password"></small>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="hidden" name="get_email" id="get_email" value="<?php echo $_GET["data"]; ?>">
                    <button type="submit" class="btn btn-primary btn-block" role="button">ยืนยันเปลี่ยนรหัสผ่าน</button>
                </div>
            </form>
        </div>
    </body>
    <script src="assets/login/assets/js/jquery.min.js"></script>
    <script src="assets/login/assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/ajax/repassword.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script> 

    </html>
<?php } else { ?>
    <script>
        $.alert({
          title: 'การส่งข้อมูลไม่ถูกต้อง',
          content: "Warning!",
          icon: 'fa fa-exclamation-circle',
          theme: 'modern',
          type: 'orange',
          closeIcon: false,
          buttons: {
            ok: {
              btnClass: 'btn-orange'
            }
          }
        });
    </script>
<?php } ?>