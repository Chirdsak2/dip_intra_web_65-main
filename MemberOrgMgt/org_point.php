<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid"  >
<?php
include("menu-top.php");
$db->query("USE ".$EWT_DB_USER);
?> 

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo 'คะแนนสะสม'  ;?></h4>
<p></p> 

</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="org_dashboard.php"><?php echo $txt_org_menu_main;?></a></li>
<li><a href="org_list.php"><?php echo $txt_org_menu_list;?></a></li>
<li class=""><?php echo 'คะแนนสะสม'  ;?></li>   
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
</div>
	
</div>
</div>

</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >


<div class="row">

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner card-blue-light" onclick="self.location.href='org_list.php'">
<!--Users Who have initiated at lest one session during the date range.    -->
<div class="card-body">
<i class="icon fas fa-parking fa-4x"></i>

    <div class="content">
      <div class="title"><h3><?php echo 'คะแนนสะสม' ;?></h3></div>
      <div class="value"><span class="sign"></span><span class="counter">300</span></div>
	  <div class="title"><h5><?php echo 'คะแนน';?></h5></div>
    </div>
	<div class="content">
      <div class="title">
	
	  </div>
    </div>
</div>
</a>
</div>	

<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 m-b-sm">
<a class="card card-banner " onclick="self.location.href='org_list.php'">
<!--Users Who have initiated at lest one session during the date range.    -->
<div class="card-body">
<i class="icon fas fa-shopping-basket fa-4x"></i> 

    <div class="content">
      <div class="title"><h3><?php echo 'การแลกคะแนน' ;?></h3></div>
      <div class="value"><span class="sign"></span><span class="counter">2</span></div>
	  <div class="title"><h5><?php echo 'ครั้ง';?></h5></div>
    </div>
	<div class="content">
      <div class="title">
	
	  </div>
    </div>
</div>
</a>
</div>	

	
</div>	



</div>

</div>

</div>
<!--END card-body -->
</div>
<!--END card -->

</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE ".$EWT_DB_NAME);
include("../EWT_ADMIN/combottom.php");
?>
                                                                                                                                                                                                       <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
