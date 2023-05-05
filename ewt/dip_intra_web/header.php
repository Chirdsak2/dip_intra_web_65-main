<?php
$menu_view3 = menu::genMenuView3($template_management["site_mainmenu"], $template_id); 
$sql = "SELECT * FROM ".E_DB_NAME.".site_management WHERE template_id = '".$template_id."' AND lang_id = '1'";
$res = db::getFetch($sql);
dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);
$fname = $_SESSION['EWT_NAME'];
$lname = $_SESSION['EWT_SURNAME'];
$idCard = $_SESSION['EWT_Idcard'];
$UsrId = $_SESSION['EWT_USRID'];
$sql_profile = "SELECT * FROM M_PER_PROFILE
LEFT JOIN USR_MAIN ON M_PER_PROFILE.PER_IDCARD = USR_MAIN.USR_OPTION3
WHERE
M_PER_PROFILE.PER_IDCARD = '".$idCard."'
";
$result = dbdpis::getFetch($sql_profile);
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
?>

<style>
  .dropdown-menu {
    left: -170px;
  }

  .left_dropdown a {
    color: #82288c;
  }
  .box_text_alert{
    margin-left:2%;
  }
  .notification {
  background-color: #555;
  color: white;
  text-decoration: none;
  padding: 15px 26px;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}

.notification:hover {
  background: red;
}


  .badge {
    position: absolute;
    top: 29px;
    right: 408px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    color: blue;
}
</style>
<div class="container-fluid pl-0 pr-0 fixed-top">
  <nav class="navbar navbar-expand-lg navbar-light bg-white py-0">
    <div class="container">
      <a class="navbar-brand pb-2" href="index.php">
        <img src="<?php echo $res['site_logo']?>" title="<?php echo $res['site_logo']?>" alt="<?php echo $res['site_logo']?>" class="max-width-logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse shadow-sm collapse show p-2" id="navbarNavDropdown">
        <?php echo $menu_view3; ?>
        <li class="navbar"><a href="search.php" alt="ค้นหาข่าวสาร" title="ค้นหาข่าวสาร"><i class="fas fa-search"></i> </a></li>
        <ul class="navbar-nav">
          <li class="nav-item dropdown margin_navbar ml-2">
            <a class="nav-link dropdown-toggle a-black-link p-0 " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php if($result['USR_PICTURE']){?>
            <img src="<?php echo SSO_PATH ?>profile/<?php echo $result['USR_PICTURE']?>" class="pic-user rounded">
              <?php }else{?>
                <img src="<?php echo "assets/img/avatar-2.png" ?>" class="pic-user rounded">
                <?php }?> 
            </a>
            <div class="dropdown-menu left_dropdown" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="profile.php"> <i class="fas fa-user"></i> ข้อมูลผู้ใช้งาน </a>
              <!-- <a class="dropdown-item" href="tenure_information.php"> <i class="fas fa-briefcase"></i> ข้อมูลการดำรงตำแหน่ง </a> -->
              <a class="dropdown-item" href="private_floder.php"> <i class="fas fa-folder-open"></i> แฟ้มส่วนตัว </a>
              <a class="dropdown-item" href="Booking_status.php"> <i class="fas fa-check-square"></i> สถานะคำขอ </a>
			        <a class="dropdown-item" href="https://mail.diprom.go.th/"> <i class="fas fa-lock"></i> เปลี่ยนรหัสผ่าน </a>
              <a class="dropdown-item" href="logout.php"> <i class="fas fa-sign-out-alt"></i> ออกจากระบบ </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>


<!-- Modal แจ้งเตือน  -->
<div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="alert" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="shadow-sm  bg-white box_main_alert">
      <div class="modal-body">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                   <h1>ประกาศจากกรม</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row mt-2">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                   <h1>ประกาศจากกรม</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row mt-2">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                   <h1>ประกาศจากกรม</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
           <div class="col-xl-12 mt-2">
               <a href="more_alert.php"><button type="button" class="btn bg_alert_bottom text-white cursor-pointer">ดูการแจ้งเตือนเพิ่มเติม</button></a>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal mail -->
<div class="modal fade" id="alert_mail" tabindex="-1" role="dialog" aria-labelledby="alert" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="shadow-sm  bg-white box_main_alert">
      <div class="modal-body">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                   <h1>ประกาศจากเมล</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row mt-2">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                  <h1>ประกาศจากเมล</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="d-flex flex-row mt-2">
                <div>
                    <div class="box_alert"></div>
                </div>
                <div class="box_text_alert">
                    <h1>ประกาศจากเมล</h1>
                   <p>Lorem Ipsum is simply dummy text of the printing and</p>
                   <p>วันที่ : 26/6/2565</p>
                </div>
            </div>
          </div>
        </div>
        <div class="row">
           <div class="col-xl-12 mt-2">
               <a href="more_alert.php"><button type="button" class="btn bg_alert_bottom text-white cursor-pointer">ดูการแจ้งเตือนเพิ่มเติม</button></a>
           </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'popup-contact.php'; ?>