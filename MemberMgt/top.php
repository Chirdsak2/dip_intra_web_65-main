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
<img src="<?=$IMG_PATH ;?>images/Artboard 20.png" class="animated fadeInDown"> 

</div>
<div class="col-md-10 col-sm-10 col-xs-12" style="text-align:left;">   
<h3><span class="home-cms pull-left animated fadeInDown">Organization Management</span></h3>  
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
<?php if($db->check_permission("org","u","")){ ?>
<a href="MemberList.php">
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-circle-arrow-right"></span> ข้อมูลบุคลากร
</button>
</a>
<?php } if($db->check_permission("org","o","")){ ?>
<a href="unitList.php">
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-circle-arrow-right"></span> หน่วยงาน
</button>
</a>
<?php } if($db->check_permission("org","p","")){ ?>
<a href="PositionList.php">
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-circle-arrow-right"></span> ตำแหน่ง
</button>
</a>
<?php } if($db->check_permission("org","g","")){ ?>
<a href="GroupList_in.php">
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-circle-arrow-right"></span> กลุ่มบุคลากร
</button>
</a>
<?php } if($db->check_permission("org","m","")){ ?>
<a href="TitleList.php">
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-circle-arrow-right"></span> คำนำหน้าชื่อ
</button>
</a>
<?php } ?>


							<!--<?php if($db->check_permission("org","u","")){ ?>
							<span class="ewtsubmenu" ><nobr><a href="MemberList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" border="0" width="16" height="16" align="absmiddle"> ข้อมูลบุคลากร</a></nobr></span>&nbsp;
							
							<!--<span class="ewtsubmenu"><nobr><a href="MemberList_outside.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle">บริหารข้อมูลสมาชิกจากภายนอก</a></nobr></span>&nbsp;->
							<?php } if($db->check_permission("org","o","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="unitList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> หน่วยงาน</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","p","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="PositionList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> ตำแหน่ง</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","g","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="GroupList_in.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> กลุ่มบุคลากร</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","m","")){ ?>
							<!-- <span class="ewtsubmenu"><nobr><a href="GroupList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle">บริหารกลุ่มบุคคลภายนอก</a></nobr></span>&nbsp;->
							<span class="ewtsubmenu"><nobr><a href="TitleList.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> คำนำหน้าชื่อ</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","l","")){ ?>
							<?php  //if($_SESSION["EWT_SMID"] == "" || $_SESSION["EWT_SMTYPE"] == 'Y'){ ?>
							<span class="ewtsubmenu"><a href="../SiteMgt/lu_main.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> กำหนดหัวหน้า/ลูกน้อง</a></span>&nbsp;
							<?php //} ?>
							
							<?php } if($db->check_permission("org","c","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="ManageOrgPreson.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle"> แผนผังบุคลากร</a></nobr></span>&nbsp;
							
							<?php } if($db->check_permission("org","t","")){ ?>
							<span class="ewtsubmenu"><nobr><a href="site_group.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle">  กลุ่มสิทธิ์</a></nobr></span>&nbsp;
							
							<?php }if($db->check_permission("org","x","")){  ?>
								<?php
						if($_SESSION["EWT_SMID"] != "" || $_SESSION["EWT_SMTYPE"] != 'Y'){ 
						$db->query("USE ".$EWT_DB_USER);
							$sql = "SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_SMID"]."' AND status = '1' ";
							$query = $db->query($sql);
							if($db->db_num_rows($query) > 0){
								$R = $db->db_fetch_array($query);
								$mdiv = $R["org_id"];
							}
						$db->query("USE ".$_SESSION["EWT_SDB"]);
						}
							?>
							<span class="ewtsubmenu"><nobr><a href="<?php if($_SESSION["EWT_SMID"] == "" || $_SESSION["EWT_SMTYPE"] == 'Y'){  ?>managememberperson.php<?php }else{?>managememberperson_list.php?org_id=<?php echo $mdiv;?><?php }?>" target="iframe_data"><img src="../theme/main_theme/bullet.gif"  border="0" width="16" height="16" align="absmiddle">  จัดเรียงบุคคลากร</a></nobr></span>&nbsp;
							<?php } ?>-->


</div>
</div>
<hr />
</div>
</div>
</div>