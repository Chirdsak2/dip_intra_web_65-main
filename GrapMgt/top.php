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
<img src="<?=$IMG_PATH ;?>images/graph.png" class="animated fadeInDown"> 

</div>
<div class="col-md-10 col-sm-10 col-xs-12" style="text-align:left;">   
<h3><span class="home-cms pull-left animated fadeInDown">Graph Management</span></h3>  
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
<a href="graph_list.php">
<button type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-circle-arrow-right"></span>  หน้าหลักกราฟ
</button>
</a>
</div>
</div>
<hr />
</div>
</div>
</div>