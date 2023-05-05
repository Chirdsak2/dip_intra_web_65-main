<?php
include('../EWT_ADMIN/menu.php');?>
 <nav class="navbar-biz">
<div class="container" style="width: 100%;">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="col-md-6 col-sm-6 col-xs-12">
<h4 class="home-cms pull-left">Welcome to EasyWebTime 8.9</h4>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="collapse navbar-collapse navbar-right">
<div class="home-cms">
  <p class="aBiz"><span class="icon-notification pad4"></span>Site  :  <?php echo $_SESSION["EWT_SUSER"]; ?></p>
  <p class="aBiz"><span class="icon-user pad4"></span>User : <?php echo $_SESSION["EWT_SMUSER"]; ?></p>
</div>
</div>
</div>
</div>
</div>
</nav>

<div class="container" style="width: 98%;" >
<div class="col-md-12 col-sm-12 col-xs-12" _style="border-color:#000000;background-color:#FFFFFF;border: 3px solid #FFC153;
    padding: 10px;
    border-radius: 15px;top:10px;">
	
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="col-md-1 col-sm-1 col-xs-12">
<img src="<?=$IMG_PATH ;?>images/OrgManager.png" class="animated fadeInDown"> 

</div>
<div class="col-md-10 col-sm-10 col-xs-12" style="text-align:left;">   
<h3><span class="home-cms pull-left animated fadeInDown">Permission Management</span></h3>  
 </div>
</div>



<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 5px;">
<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-2 col-sm-2 col-xs-12">
</div>

<div class="col-md-10 col-sm-10 col-xs-12" style="text-align:right;"> 
<a href="../EWT_ADMIN/ewt_main.php" >
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-home"></span> Home
</button>
</a>
<a href="ewt_permission0.php">
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-circle-arrow-right"></span>  กำหนดสิทธิ์ผู้ใช้งานระบบ
</button>
</a>
<a href="ewt_permission_g.php">
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-circle-arrow-right"></span>  กำหนดสิทธิ์กลุ่มผู้ใช้งาน
</button>
</a>
<!--<span class="ewtsubmenu"><a href="ewt_permission0.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            กำหนดสิทธิ์ผู้ใช้งานระบบ</a></span> 
            <?php
			if($_SESSION["EWT_SMTYPE"] == "Y"){
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;<span class="ewtsubmenu"><a href="ewt_permission_all.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            ผู้ใช้ระบบทั้งหมด</a></span> 
			
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="ewtsubmenu"><a href="ewt_permission_g.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            กำหนดสิทธิ์กลุ่มผู้ใช้งาน</a></span> 
            <?php
			}
			?>
            <?php
			if($_SESSION["EWT_SMID"] != ""){
			?>
            &nbsp;&nbsp;&nbsp;&nbsp; <span class="ewtsubmenu"><a href="send_permission.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            กำหนดสิทธิ์ให้ผู้อื่น</a></span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="ewtsubmenu"><a href="wait_permission.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            ติดตามผลการดำเนินงาน</a></span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="ewtsubmenu"><a href="approve_permission.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            ตรวจสอบคำขอ</a></span> 
            <?php
			}
			if($_SESSION["EWT_SMTYPE"] == "Y"){
			?>
			<span class="ewtsubmenu"><a href="ewt_permission_ldap.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            กำหนดกลุ่ม LDAP</a></span> 
			<?php } ?>-->
</div>
</div>
<hr />
</div>
</div>
</div>