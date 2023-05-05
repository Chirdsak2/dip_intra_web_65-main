<?php
include("lib/permission.php");
include("lib/include.php");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$IMG_PATH = 'EWT_ADMIN/';
$EWT_PATH = '';
$MAIN_PATH = 'EWT_ADMIN/';

 				$f1 = fopen("font_list.txt","r");
			  while($line1 = fgets($f1,1024)){
			  $fontL .= $line1; 
			  }
			  fclose($f1);
			 $FontA = explode("###",$fontL);  

$s_site_info = "select * from site_info";
$query = $db->query($s_site_info);
$rec = $db->db_fetch_array($query);
$db->query("USE ".$EWT_DB_USER);
$s_user = "select url,email from user_info where UID = '".$_SESSION["EWT_SUID"]."'";
$q_user = $db->query($s_user);
$a_user = $db->db_fetch_array($q_user);
$db->query("USE ".$EWT_DB_NAME);
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>EasyWebTime 8.9</title>
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<?php include('link.php'); ?>

<script>
function selColor(c,d){
				Win2=window.open('ewt_color.php?c_value='+ c +'&c_block=' + d + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
			}
			  	function CreColor(va,bg,pre,flag){
				  	bg.style.backgroundColor= va;
					if(flag == 'color'){
  						pre.style.color = va;
					}else{
						pre.style.backgroundColor = va;
					}
				}
</script>
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
 table {
	 font-size: 14px;
	 font-weight: 400;
 }  
 input {
	 
	 height:30px;
	 
 }
      a .icon {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: row;
                flex-direction: row;
            -ms-flex-wrap: nowrap;
                flex-wrap: nowrap;
            -ms-flex-align: center;
                align-items: center;
            -ms-flex-pack: center;
                justify-content: center;
            display: block;
            margin: 0 auto;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            color: #FFF;
            margin-bottom: 0.6em; }
</style>
</head>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<!--<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<hr />    
</div>				
<div class="col-md-12 col-sm-12 col-xs-12" >
		<img src="theme/main_theme/site_function_property.gif" width="32" height="32" align="absmiddle" />
		<span class="ewtfunction">&#3605;&#3633;&#3657;&#3591;&#3588;&#3656;&#3634;คุณสมบัติ&#3648;&#3623;&#3655;&#3610;&#3652;&#3595;&#3605;&#3660;</span> 
</div>
<div class="col-md-12 col-sm-12 col-xs-12" >
 <hr />            
</div>
</div>-->

<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">&#3605;&#3633;&#3657;&#3591;&#3588;&#3656;&#3634;คุณสมบัติ&#3648;&#3623;&#3655;&#3610;&#3652;&#3595;&#3605;&#3660;</h4>
</div>	


<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-10 col-sm-10 col-xs-12 form-inline" ></div>
<div class="col-md-2 col-sm-2 col-xs-12 float-right" style="text-align:right;" ></div>	
</div>
<hr>
</div>

<div class="clearfix">&nbsp;</div>	

<div class="panel panel-default" >
<div class="panel-heading form-inline" ></div>
<div class="panel-body">
<form action="ewt_info_function.php" method="post" name="form1" id="form1" >
<input name="hdd_site_info_id" type="hidden" value="<?=$rec['site_info_id']?>" />
<input name="hdd_flag" type="hidden" value="site_info" />
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="txt_url"><?php echo "Url Name";?> : </label>
        <input class="form-control" name="txt_url" type="text" id="txt_url"  value="<?=$a_user['url'];?>" /><br>
		 <span class="MemberNormalRed">ex:http://www.yahoo.com/ </span>
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="txt_title"><?php echo "Title"; ?> : </label>
		  <input class="form-control" name="txt_title" type="text" id="txt_title"  value="<?=$rec['site_info_title'];?>">
        
      </div>
</div>

<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="txt_txt_keywordurl"><?php echo "Keyword";?> : </label>
        <input class="form-control" name="txt_keyword" type="text" id="txt_keyword"  value="<?=$rec['site_info_keyword'];?>" />
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="txt_desc"><?php echo "Description"; ?> : </label>
		  <input class="form-control" name="txt_desc" type="text" id="txt_desc"  value="<?=$rec['site_info_description'];?>">
        
      </div>
</div>

<div class="form-group row form-inline">
      <div class="col-md-6 col-sm-6 col-xs-12 ">
        <label for="txt_max_Img"><?php echo "Max Image Size Upload / Image type allowed";?> : </label><br>
        <input class="form-control" name="txt_max_Img" type="text" id="txt_max_Img"  _style="width:15%;" value="<?=$rec['site_info_max_img'];?>" />
		MB.
		<input name="type_img_file"  id="type_img_file" class="form-control" type="text"  _style="width:79%;" value="<?php echo $rec['site_type_img_file']?>">
		<br> ex: jpg,gif 
		<br><span class="style2">คั่นข้อความด้วยเครื่องหมายจุลภาค(,) </span>
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12 ">
        <label for="txt_max_file"><?php echo "Max File Size Upload / File type allowed"; ?> : </label><br>
		  <input class="form-control" name="txt_max_file" type="text" id="txt_max_file" _style="width:15%;"  value="<?=$rec['site_info_max_file'];?>">
		  MB.
		  <input name="type_file"  id="type_file" class="form-control" type="text" _style="width:79%;" value="<?=$rec['site_type_file']?>">
		  <br> ex: doc,zip,exe
		  <br><span class="style2">คั่นข้อความด้วยเครื่องหมายจุลภาค(,) </span>
        
      </div>
</div>

<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="txtcountor"><?php echo "Start counter";?> : </label>
        <input class="form-control" name="txtcountor" type="text" id="txtcountor" style="width:20%;"  value="<?=$rec['set_countor'];?>" />
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
       
      </div>
</div>

</div>
</div>

<div class="panel-footer text-center" >
		<button type="submit" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?='บันทึก';?>" >
		<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?='บันทึก'; ?>
		</button> 
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
<?php
$db->db_close(); ?>
