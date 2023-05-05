<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/config_path.php");

if($_POST['proc'] == 'save'){
    $timeH=$_POST['timeH']*3600;
    $timeM=$_POST['timeM']*60;
	$timeSet=$timeH+$timeM;
	$db->query("UPDATE site_info SET set_poll = '{$timeSet}' ");
}


$recValue = $db->db_fetch_array ($db->query("SELECT * FROM site_info")); 
//$PollSec = $recValue['set_poll'];
if($recValue['set_poll']!=0){
    $set_H = floor($recValue['set_poll']/3600);
	$set_M = floor(($recValue['set_poll']-($set_H*3600))/60);
}
include("../header.php");
?>

<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<?php include('link.php'); ?>

<style type="text/css">
<!--
.head_table {	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
}
.style3 {color: #0000FF}
-->
</style>
<script>
    function chkForm (f) {
		if (f.ebook_value.value=='') {
		   alert ("Please field Value Size");
		   f.ebook_value.focus ();
		   return false;
		   }		
	}
	 function cfmDel (ref) {
      if (confirm ("ลบใช่หรือไม่ ?")) {
	      self.location.href='proc_ebook.php?proc=delvalue&value_id='+ref;		   
	  }
   }
</script>
</head>
<body leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<?php
include('top.php');
?>

<!--<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 5px;">
<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">			
<div class="col-md-12 col-sm-12 col-xs-12" ><hr /> 
<img src="../theme/main_theme/ebook_function_size.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $text_genpoll_function2;?></span>
</div>    
</div>
</div>
</div>
</div>-->


<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 4;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $text_genpoll_Form1;?></h4>
</div>		


	
<div class="panel-body" >


<br>
<hr>
<div class="col-md-12 col-sm-12 col-xs-12">
<form class="form-inline"  name="form1" method="post" action="" align="center" >
  <div class="form-group">
    <label class="sr-only" for="timeH"> <?php echo $text_genpoll_FormH;?> :</label>
     <input class="form-control"   name="timeH" type="text"  size="7" maxlength="5" value="<?php echo number_format($set_H,0);?>">
              <?php echo $text_genpoll_FormH;?> 
  </div>
  <div class="form-group">
    <label class="sr-only" for="timeM"><?php echo $text_genpoll_FormM;?> :</label>
   <input class="form-control"  name="timeM" type="text"  size="7" maxlength="5" value="<?php echo number_format($set_M,0);?>">
              <?php echo $text_genpoll_FormRemark;?>
  </div>
  <div class="form-group">
  <input type="submit" name="saveButton" value="  <?php echo $text_genpoll_FormSave?>    "   class="btn btn-success btn-ml"/>
              <input type="reset" name="saveButton2" value="  <?php echo $text_genpoll_FormCancel?>   "   class="btn btn-warning"/>
              <input type="hidden" name="proc" value="save">
   </div>
</form>
</div>


</div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
<?php $db->db_close(); ?>
