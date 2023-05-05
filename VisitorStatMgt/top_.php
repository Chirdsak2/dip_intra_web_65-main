<?php
include('../EWT_ADMIN/menu.php');
//include('../EWT_ADMIN/navbar.php');?>

<div class="container-fluid" >
	
<div class="row m-b" style="padding-top:65px;">
<div class="col-md-12 col-sm-12 col-xs-12" >	
<div class="card">
<div class="card-body" style="top:10px;">
	
<div class="row ">
<div class="col-md-6 col-sm-6 col-xs-6">
<img src="<?=$IMG_PATH ;?>images/visitor4.png" class="animated fadeInDown" style="height: 60px;width: 60px;"> 
<span class="home-cms  animated fadeInDown text-large hidden-xs">Stat Visitor Management</span>
</div>

<div class="col-md-6 col-sm-6 col-xs-6 float-right text-right hidden-xs" style="top:18px;"> 
<a href="../EWT_ADMIN/ewt_main.php" >
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-home"></span> Home
</button>
</a>
<a href="stat_index.php">
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-circle-arrow-right"></span> Stat Visitor Dashboard
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-6 float-right text-right  visible-xs row m-b-sm ">
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">menu <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="../EWT_ADMIN/ewt_main.php" ><i class="glyphicon glyphicon-circle-arrow-right"></i>&nbsp;<?="Home";?></a></li>
            <li><a href="stat_index.php"><i class="glyphicon glyphicon-circle-arrow-right"></i>&nbsp;<?="Stat Visitor Dashboard";?></a></li>
        </ul>
</div>
</div>
</div>
</div>
</div>
</div>
</div>