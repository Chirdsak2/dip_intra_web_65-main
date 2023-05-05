<?php
include("admin.php");
include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<script language=JavaScript src='../scripts/innovaeditor.js'></script>
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>

<?php include('link.php'); ?>


</head>
<body leftmargin="0" topmargin="0">
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
<img src="../theme/main_theme/poll_function.gif" width="32" height="32" align="middle"> 
      <span class="ewtfunction"><?php echo $text_genpoll_function;?></span>
</div>    
</div>
</div>
</div>
</div>-->


<!--<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php //echo urlencode($text_genpoll_Vote_New);?>&module=poll&url=<?php //echo urlencode("add.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="add.php" ><img src="../theme/main_theme/g_add.gif" alt="<?php //echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle"> <?php //echo $text_general_add;?></a> &nbsp;
        <hr>
    </td>
  </tr>
</table>-->


<?php
if($_POST[topic]){

   if(getenv(HTTP_X_FORWARDED_FOR)) {
		$IPn = getenv(HTTP_X_FORWARDED_FOR);
	}else{
		$IPn = getenv("REMOTE_ADDR");
	}


				if($_POST[date_start]==''){
				    $startdate='';
				}else{
					$sd=explode('/',$_POST[date_start]);
					$startdate=($sd[2]-543)."-".$sd[1]."-".$sd[0].' '.$_POST[hr_start].":".$_POST[m_start].":00";
				}
				if($_POST[date_stop]==''){
					$stopdate='';
				}else{
					$ed=explode('/',$_POST[date_stop]);
					$stopdate=($ed[2]-543)."-".$ed[1]."-".$ed[0].' '.$_POST[hr_stop].":".$_POST[m_stop].":00";
				}
				if($_POST[hr_start]!='' && $_POST[m_start] !=""){
				$starttime=$_POST[hr_start].":".$_POST[m_start].":00";
				}
				if($_POST[hr_stop]!='' && $_POST[m_stop] !=""){
				$stoptime=$_POST[hr_stop].":".$_POST[m_stop].":00";
				}
	
    $topic=$_POST[topic];
	$topic = addslashes($topic);
	$add1 = $db->query("INSERT INTO `poll_cat` ( `c_id` , `c_name`, `c_detail` , `c_use` , `c_timestamp`,`c_uid`,`c_creater`,`c_ip`,`c_start`,`c_stop`,`c_timestart`,`c_timestop`) 
	VALUES ('', '".$_POST[topic]."','".$_POST[detail]."', '$c_use','".date('YmdHis')."','" .$_SESSION["EWT_SMID"]."','".$_SESSION["EWT_SMUSER"]."','$IPn','$startdate','$stopdate','$starttime','$stoptime')");
	
	$sql = $db->query("SELECT * FROM poll_cat ORDER BY c_id DESC");
	$R = mysql_fetch_array($sql);
	$LastID=$R[c_id];
	$db->write_log("create","poll","สร้างแบบสำรวจความคิดเห็น(poll)   ".$topic);
	?><script >location.href='add_q.php?c_id=<?php echo $LastID;?>&flag=Y';</script>
	
<?php
}
?>


<!--<div class="panel panel-default" style="background-color:#FFC153;border: 2px solid #FFC153;
    border-radius: 4px;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;">
<h4 style="color:#FFFFFF;"><?php //echo $text_genpoll_Vote_New;?></h4>
</div>
</div>-->

<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 5px;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $text_genpoll_Vote_New;?></h4>
</div>	
	
<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
</div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >

<!--<a href="unitAdd.php?cmd=add&parent_org_id_send=0001" title="เพิ่มข้อมูลหน่วยงาน">
<button type="button" class="btn btn-info" >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?php //echo $lable;?>ข้อมูลหน่วยงาน
</button>	  	  
</a>-->
<a href="main.php" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>


</div>
</div>
</div>	
<br>
<hr>

<div class="col-md-12 col-sm-12 col-xs-12" >
<form name="form1" method="post" action="" onSubmit="return Chkvalue();">
<div class="form-group row">
      <div class="col-xs-6">
        <label for="topic"><?php echo $text_genpoll_Vote_Topic;?><span class="text-danger">*</span> : </label>
        <input class="form-control" name="topic" type="text" id="topic" size="60">
      </div>
	  <div class="col-xs-6">
        <label for="topic"><?php echo $text_genpoll_Vote_Detail;?> : </label>
		<textarea class="form-control" rows="5" id="detail" name="detail"></textarea>
        
      </div>
</div>
<div class="form-group row ">	  
<div class="col-xs-12 form-inline">
        <label for="date_start"><?php echo $text_genpoll_Vote_Start ?> : </label>
		<input class="form-control"  name="date_start" type="text" size="10" value="" id="date_start"> <?php//php echo date('d/m/').(date('Y')+543); ?>
		<a href="#show" onClick="return showCalendar('date_start', 'dd-mm-y');"> <img src="show-calendar.gif" width="24" height="24" border="0" align="middle" /></a>
		เวลา
		<select  name="hr_start" class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<24;$hr++){ ?>  
		<option value="<?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>
		:
		<select  name="m_start" class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<60;$hr++){ ?>  
		<option value="<?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>
		
		<?php echo $text_genpoll_Vote_StartR ?> 
</div>
</div>
<div class="form-group row">		  
<div class="col-xs-12 form-inline">
        <label for="date_stop"><?php echo $text_genpoll_Vote_Start ?> : </label>
        <input class="form-control"  name="date_stop" type="text" size="10" id="date_stop"> 
		<a href="#show" onClick="return showCalendar('date_stop', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="absmiddle"></a> 
		
		เวลา  
		<select  name="hr_stop"  class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<24;$hr++){ ?>  
		<option value="<?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select> 
		
		:
		<select  name="m_stop"  class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<60;$hr++){ ?>  
		<option value="<?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>
		
		<?php echo $text_genpoll_Vote_StopR ?>

		</div>
</div>	  
<div class="form-group row">
	   <div class="col-xs-12" style="text-align:right;">
        <input type="submit" name="Submit" value="ขั้นต่อไป>>"   class="btn btn-success btn-ml" />
		<input name="num" type="hidden" id="num" value="" /> 
      </div>
	 	  
</div>

</form>
</div>
</div>
<hr>
</div>
<!--<table width="90%" align="center" class="table table-bordered">
  <form name="form1" method="post" action="" onSubmit="return Chkvalue();">
   <tr align="center" class="ewttablehead"> 
      <td  colspan="2" align="left">&nbsp; <?php echo $text_genpoll_Vote_New;?></td>
    </tr>
	
   <tr bgcolor="#FFFFFF"> 
      <td width="38%"><?php echo $text_genpoll_Vote_Topic;?></td>
      <td  width="62%"><input class="form-control" style="width:40%;" name="topic" type="text" class="normal_font" id="topic" size="60"></td>
    </tr>
   <tr bgcolor="#FFFFFF"> 
      <td width="38%"><?php echo $text_genpoll_Vote_Detail;?></td>
      <td  width="62%"><input class="form-control" style="width:40%;" name="detail" type="text" class="normal_font" id="detail" size="60"></td>
    </tr>
	<tr bgcolor="#FFFFFF" height="25"> 
      <td><?php echo $text_genpoll_Vote_Start ?></td>
      <td> <input class="form-control" style="width:30%;" name="date_start" type="text" size="10" value="" id="date_start"> <?php//php echo date('d/m/').(date('Y')+543); ?>
      <a href="#show" onClick="return showCalendar('date_start', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="absmiddle"></a> เวลา     
		<select  name="hr_start" class="form-control" style="width:10%;">
		<option value=""></option>
		<?php  for($hr=0;$hr<24;$hr++){ ?>  
		<option value="<?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select> :
		<select  name="m_start" class="form-control" style="width:10%;">
		<option value=""></option>
		<?php  for($hr=0;$hr<60;$hr++){ ?>  
		<option value="<?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>
		<?php echo $text_genpoll_Vote_StartR ?> 
		</td>
    </tr>
    <tr bgcolor="#FFFFFF" height="25"> 
      <td><?php echo $text_genpoll_Vote_Stop ?></td>
      <td > <input class="form-control" style="width:30%;"  name="date_stop" type="text" size="10" id="date_stop"> 
      <a href="#show" onClick="return showCalendar('date_stop', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="absmiddle"></a> เวลา  
		<select  name="hr_stop"  class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<24;$hr++){ ?>  
		<option value="<?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select> :
		<select  name="m_stop"  class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<60;$hr++){ ?>  
		<option value="<?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($hr, 2, "0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>    
		<?php echo $text_genpoll_Vote_StopR ?></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td width="38%"></td>
      <td  width="62%"><input type="submit" name="Submit" value="ขั้นต่อไป>>"   class="btn btn-success btn-ml" />
      <input name="num" type="hidden" id="num" value=""></td>
    </tr>
</form>
</table>-->

<?php
include('footer.php');
?>
</body>
</html>
<script>
function Chkvalue(){
if(document.form1.topic.value == ""){
alert("กรุณาใส่หัวข้อ");
document.form1.topic.focus();
return false;
}
var y = document.form1.num.value;
for(i=0;i<y;i++){
if(document.form1.elements["ans_name"+i].value == ""){
alert("Please insert choice");
document.form1.elements["ans_name"+i].focus();
return false;
}
}
}
</script>