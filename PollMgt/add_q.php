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

<?php
if($_GET[c_id]){
	$c_id=$_GET[c_id];
}else if($_POST[c_id]){
	$c_id=$_POST[c_id];
}
 
 				if($_POST[a_id]){ //ลบแบบรายการเดียว
				   $db->query("Delete from poll_ans where a_id= '$_POST[a_id]' ");
				}
	if($_POST[Submit] or $_POST[Clear]){
		if($_POST[Clear]){
			 $db->query("Delete from poll_ans where c_id= '$c_id' ");
		}else{ 
		//print_r($_POST);
		//exit();
				$topic = addslashes($_POST[topic]); //คำถาม
				$detail = addslashes($_POST[detail]); //รายละเอียด
				
				
				
				if($_POST[date_start]==''){
				    $startdate='';
				}else{
					$sd=explode('/',$_POST[date_start]);
					//$startdate=($sd[2]-543)."-".$sd[1]."-".$sd[0].' '.$_POST[hr_start].":".$_POST[m_start].":00";
					$startdate=($sd[2]-543)."-".$sd[1]."-".$sd[0];
				}
				if($_POST[date_stop]==''){
					$stopdate='';
				}else{
					$ed=explode('/',$_POST[date_stop]);
					//$stopdate=($ed[2]-543)."-".$ed[1]."-".$ed[0].' '.$_POST[hr_stop].":".$_POST[m_stop].":00";
					$stopdate=($ed[2]-543)."-".$ed[1]."-".$ed[0];
				}
				if($_POST[hr_start]!='' && $_POST[m_start] !=""){
				$starttime=$_POST[hr_start].":".$_POST[m_start].":00";
				}
				if($_POST[hr_stop]!='' && $_POST[m_stop] !=""){
				$stoptime=$_POST[hr_stop].":".$_POST[m_stop].":00";
				}
				$time= '';
				if($_POST[flag]!='Y'){
					$time = date('YmdHis');
				}
				$db->query("UPDATE poll_cat  SET c_name='$topic',c_detail='$detail',c_lastupdate='$time' ,
				                   c_start='$startdate'  ,c_stop='$stopdate'  ,c_timestart='$starttime'  ,c_timestop='$stoptime' 
				WHERE c_id='$c_id'");// update คำถาม

				for($i=0;$i<$_POST[num];$i++){
					$ans_name = "ans_name".$i;
					$ans_name = $$ans_name;
					$ans_name = addslashes($ans_name);
					$ans_id = "ans_id".$i;
					$ans_id = $$ans_id;
					if($ans_id != '' && $ans_id != '0'){//กรณีที่มี ข้อมูลการ update
					$db->query("UPDATE poll_ans SET c_id = '".$c_id."' ,a_name = '".$ans_name."' where  a_id = '".$ans_id."'");
					}else{
					$sql_ans = $db->query("INSERT INTO `poll_ans` ( `a_id` , `c_id` , `a_name` , `a_counter` ) VALUES ('', '$c_id', '$ans_name', '')");
					}
				}
				if($_POST[newans]){
					 $newans=$_POST[newans];
					 $db->query("INSERT INTO `poll_ans` ( `a_id` , `c_id` , `a_name` , `a_counter` ) VALUES ('', '$c_id', '$newans', '')");
				}
			}
			?><script language="javascript">location.href='add_q.php?c_id=<?php echo $c_id;?>&flag=Y';</script><?php
	}



$sql = $db->query("SELECT * FROM poll_cat where c_id  = '$c_id' ");
$R = mysql_fetch_array($sql);
$LastTopic=$R[c_name];
$LastDetail=$R[c_detail];
$date_time_s = explode(' ',$R[c_start]);
$date_time_e = explode(' ',$R[c_stop]);
	$date_s = explode('-',$date_time_s[0]);
 $y=$date_s[0];
  $y=($y*1)+543;
  $m= $date_s[1];
  $d= $date_s[2];
  if($R[c_start] !=""){
	$LastStart=$d."/".$m."/".$y;
  }
 $date_e = explode('-',$date_time_e[0]); 
  $y= $date_e[0];
  $y=($y*1)+543;
  $m=$date_e[1];
  $d=$date_e[2];
   if($R[c_stop] !=""){
  $LastStop=$d."/".$m."/".$y; 
  }
  $time_s = explode(":",$R[c_timestart]);
  $hrs=$time_s[0];
  $ms=$time_s[1];
  $time_e = explode(":",$R[c_timestop]);
  $hre=$time_e[0];
  $me=$time_e[1];
  
  

?>

<!--<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genpoll_Vote_NewQ.' :: '.$LastTopic);?>&module=poll&url=<?php echo urlencode("add_q.php?c_id=".$_GET["c_id"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="add.php" ><img src="../theme/main_theme/g_add.gif" alt="<?php echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_general_add;?></a> &nbsp;
        <hr>
    </td>
  </tr>
</table>-->


<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 5px;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $text_genpoll_Vote_NewQ;?></h4>
</div>	
	
<div class="panel-body" >
<form name="form1" method="post" action="" onSubmit="return Chkvalue();">

<div class="form-group row">
      <div class="col-xs-6">
        <label for="topic"><?php echo $text_genpoll_Vote_Topic;?><span class="text-danger">*</span> : </label>
        <input class="form-control" name="topic" type="text" id="topic" size="60" value="<?=$LastTopic;?>">
      </div>
	  <div class="col-xs-6">
        <label for="topic"><?php echo $text_genpoll_Vote_Detail;?> : </label>
		<textarea class="form-control" rows="5" id="detail" name="detail"><?php echo $LastDetail?></textarea>
        
      </div>
</div>
<div class="form-group row ">	  
<div class="col-xs-12 form-inline">
        <label for="date_start"><?php echo $text_genpoll_Vote_Start ?> : </label>
		<input class="form-control"  name="date_start" type="text" size="10" id="date_start" value="<?php echo $LastStart?>"> <?php//php echo date('d/m/').(date('Y')+543); ?>
		<a href="#show" onClick="return showCalendar('date_start', 'dd-mm-y');"> 
		<img src="show-calendar.gif" width="24" height="24" border="0" align="middle" /></a>
		เวลา
		<select  name="hr_start" class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<24;$hr++){ ?>  
		<option value="<?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?>" <?php if($hrs==str_pad($hr,2,"0",STR_PAD_LEFT)){echo 'selected';}?>><?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>
		:
		<select  name="m_start" class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<60;$hr++){ ?>  
		<option value="<?php echo str_pad($hr,2,"0", STR_PAD_LEFT);?>" <?php if($ms==str_pad($hr,2,"0",STR_PAD_LEFT)){echo 'selected';}?>><?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>
		<span class="text-danger">
		<?php echo $text_genpoll_Vote_StartR ?> </span>
</div>
</div>
<div class="form-group row">		  
<div class="col-xs-12 form-inline">
        <label for="date_stop"><?php echo $text_genpoll_Vote_Start ?> : </label>
        <input class="form-control"  name="date_stop" type="text" size="10" id="date_stop" value="<?php echo $LastStop?>" > 
		<a href="#show" onClick="return showCalendar('date_stop', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="middle"></a> 
		
		เวลา  
		<select  name="hr_stop"  class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<24;$hr++){ ?>  
		<option value="<?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?>" <?php if($hre==str_pad($hr,2,"0",STR_PAD_LEFT)){echo 'selected';}?>><?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select> 
		
		:
		<select  name="m_stop"  class="form-control" style="width:10%;" >
		<option value=""></option>
		<?php  for($hr=0;$hr<60;$hr++){ ?>  
	    <option value="<?php echo str_pad($hr, 2,"0",STR_PAD_LEFT);?>" <?php if($me==str_pad($hr,2,"0",STR_PAD_LEFT)){echo 'selected';}?>><?php echo str_pad($hr,2,"0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>
		<span class="text-danger">
		<?php echo $text_genpoll_Vote_StopR ?></span>

		</div>
</div>	

<div class="form-group row">		  
<div class="col-xs-12 form-inline">
<label for="topic"><?php echo $text_genpoll_Vote_Choice;?> : </label>
</div>
</div>

<div class="form-group row">
<div class="col-xs-2 form-inline" style="color:#FFFFFF;text-align:center;background-color:#FFC153;border: 1px solid #ddd;padding: 10px;border-radius: 4px;">
<label for="topic">ลบ</label>
</div>		  
<div class="col-xs-2 form-inline" style="color:#FFFFFF;text-align:center;background-color:#FFC153;border: 1px solid #ddd;padding: 10px;border-radius: 4px;">
<label for="topic"><?php echo $text_genpoll_Vote_Choice2;?></label>
</div>
<div class="col-xs-8 form-inline" style="color:#FFFFFF;text-align:center;background-color:#FFC153;border: 1px solid #ddd;padding: 10px;border-radius: 4px;">
<label for="topic"><?php echo $text_genpoll_Vote_Detail;?></label>
</div>
</div>

<?php 
	$sql2="SELECT * FROM poll_ans WHERE  c_id = '{$c_id}' ORDER BY a_id ";
	$query2 = $db->query($sql2);
	$num = mysql_num_rows($query2);
	//for($i=0;$i<$num;$i++){ 
	 $i=0;
	while($das=mysql_fetch_array($query2)){ ?>
<div class="form-group row">
<div class="col-xs-2 form-inline "  style="text-align:center;">
<a href="#del" onClick="if(confirm('ยืนยันการลบตัวเลือก '+document.form1.ans_name<?php echo $i; ?>.value)){document.form1.a_id.value='<?php echo $das[a_id];?>'; document.form1.submit();}"><img src="../theme/main_theme/g_del.gif" alt="<?php echo $text_general_delete;?>" width="16" height="16" style="background-color:#DBDBDB" border="0"></a>
</div>		  
<div class="col-xs-2 form-inline"  style="text-align:center;">
<?php echo $i+1; ?>
</div>
<div class="col-xs-8 form-inline" >
<input class="form-control" style="width:100%;"  name="ans_name<?=$i; ?>" type="text"  id="ans_name<?=$i; ?>"  value="<?=$das['a_name'];?>" />
<input type="hidden" name="ans_id<?=$i; ?>" id="ans_id<?=$i;?>" size="50" value="<?=$das['a_id']?>" />
</div>
</div>
<?php  $i++; } ?>

<div class="form-group row">
<div class="col-xs-12 form-inline" style="color:#FFFFFF;text-align:center;background-color:#FFC153;border: 1px solid #ddd;padding: 10px;border-radius: 4px;">
<label for="topic"></label>
</div>		  
</div>

<div class="form-group row">
<div class="col-xs-6">
        <label for="topic"><?php echo $text_genpoll_Vote_Choice3;?> : </label>
        <input class="form-control" name="newans" type="text"  id="newans" />
</div>
<div class="col-xs-6" style="text-align:right;">
<input class="btn btn-success btn-ml"  type="submit" name="Submit" value="<?=$text_genpoll_Button_Save;?>"  onClick="/*return confirm('ยืนยันการบันทึก');*/">
	  <input  class="btn btn-danger" type="submit" name="Clear" value="<?=$text_genpoll_Button_Clear;?>"  onClick="return confirm('ยืนยันการลบตัวเลือกทั้งหมดหรือไม่');">
      <input name="num" type="hidden" id="num" value="<?=$num; ?>">
	  <input name="c_id" type="hidden" id="c_id" value="<?=$c_id; ?>">
	  <input name="a_id" type="hidden" id="a_id" value="">
	  <input name="flag" type="hidden" id="flag" value="<?=$_GET['flag']; ?>">
</div>
</div>


<div class="form-group row">
<div class="col-xs-12 form-inline" style="color:#FFFFFF;text-align:right;background-color:#FFC153;border: 1px solid #ddd;padding: 10px;border-radius: 4px;">
 <input class="btn btn-success btn-ml"  type="button" name="Complete" value="<?php echo $text_genpoll_Button_Finish;?>" onClick="if(confirm('ต้องการจบขั้นตอนการสร้างแบบสอบถามหรือไม่?')){location.href='main.php'};">
</div>		  
</div>




</form>
</div>
</div>
<!--<table width="90%" align="center" class="table table-bordered">
  <form name="form1" method="post" action="" onSubmit="return Chkvalue();">
   <tr align="center" class="ewttablehead"> 
      <td  colspan="2" align="left">&nbsp; <?php echo $text_genpoll_Vote_NewQ;?></td>
    </tr>
	
   <tr bgcolor="#FFFFFF"> 
      <td width="30%"><?php echo $text_genpoll_Vote_Topic;?></td>
      <td  width="70%"><input name="topic" type="text" class="form-control" style="width:50%;" id="topic" size="60" value="<?php echo $LastTopic?>"></td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td ><?php echo $text_genpoll_Vote_Detail;?></td>
      <td ><input name="detail" type="text" class="form-control" style="width:50%;" id="detail" size="60" value="<?php echo $LastDetail?>"></td>
    </tr>
	<tr bgcolor="#FFFFFF" height="25"> 
      <td><?php echo $text_genpoll_Vote_Start ?></td>
      <td> 
	  <input class="form-control" style="width:20%;" name="date_start" type="text" size="10"  id="date_start" value="<?php echo $LastStart?>"> <a href="#show" onClick="return showCalendar('date_start', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="absmiddle"></a>
		<select  name="hr_start" class="form-control" style="width:10%;">
		<option value=""></option>
		<?php  for($hr=0;$hr<24;$hr++){ ?>  
		<option value="<?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?>" <?php if($hrs==str_pad($hr,2,"0",STR_PAD_LEFT)){echo 'selected';}?>><?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select> :
		<select  name="m_start" class="form-control" style="width:10%;">
		<option value=""></option>
		<?php  for($hr=0;$hr<60;$hr++){ ?>  
		<option value="<?php echo str_pad($hr,2,"0", STR_PAD_LEFT);?>" <?php if($ms==str_pad($hr,2,"0",STR_PAD_LEFT)){echo 'selected';}?>><?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>
		<?php echo $text_genpoll_Vote_StartR ?>      </td>
    </tr>
    <tr bgcolor="#FFFFFF" height="25"> 
      <td><?php echo $text_genpoll_Vote_Stop ?></td>
      <td > 
	  <input class="form-control" style="width:20%;" name="date_stop" type="text" size="10" id="date_stop"  value="<?php echo $LastStop?>"> <a href="#show" onClick="return showCalendar('date_stop', 'dd-mm-y');"> 
        <img src="show-calendar.gif" width=24 height=24 border=0 align="absmiddle"></a>
		<select  name="hr_stop" class="form-control" style="width:10%;">
		<option value=""></option>
		<?php  for($hr=0;$hr<24;$hr++){ ?>  
		<option value="<?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?>" <?php if($hre==str_pad($hr,2,"0",STR_PAD_LEFT)){echo 'selected';}?>><?php echo str_pad($hr,2,"0",STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select> :
		<select  name="m_stop" class="form-control" style="width:10%;">
		<option value=""></option>
		<?php  for($hr=0;$hr<60;$hr++){ ?>  
		<option value="<?php echo str_pad($hr, 2,"0",STR_PAD_LEFT);?>" <?php if($me==str_pad($hr,2,"0",STR_PAD_LEFT)){echo 'selected';}?>><?php echo str_pad($hr,2,"0", STR_PAD_LEFT);?></option> 
		<?php } ?>
		</select>
		<?php echo $text_genpoll_Vote_StopR ?>      </td>
    </tr>
	 <tr bgcolor="#FFFFFF"> 
      <td  valign="top"><?php echo $text_genpoll_Vote_Choice;?></td>
      <td  >
	  
	  <table width="100%" align="center" class="table table-bordered">
	   <tr align="center" class="ewttablehead">
	   <td width="5%">&nbsp;</td>
        <td width="25%"><?php echo $text_genpoll_Vote_Choice2;?></td>
        <td width="70%"><?php echo $text_genpoll_Vote_Detail;?></td>
        </tr>
	<?php 
	$sql2="SELECT * FROM poll_ans WHERE  c_id = '$c_id' ORDER BY a_id ";
	$query2 = $db->query($sql2);
	$num = mysql_num_rows($query2);
	//for($i=0;$i<$num;$i++){ 
	 $i=0;
	while($das=mysql_fetch_array($query2)){ ?>
      <tr bgcolor="#FFFFFF">
        <td  align="center"><a href="#del" onClick="if(confirm('ยืนยันการลบตัวเลือก '+document.form1.ans_name<?php echo $i; ?>.value)){document.form1.a_id.value='<?php echo $das[a_id];?>'; document.form1.submit();}"><img src="../theme/main_theme/g_del.gif" alt="<?php echo $text_general_delete;?>" width="16" height="16" style="background-color:#DBDBDB" border="0"></a></td>
        <td   align="center"><?php echo $i+1; ?></td>
        <td >
		<input class="form-control" style="width:50%;" name="ans_name<?php echo $i; ?>" type="text"  id="ans_name<?php echo $i; ?>" size="50" value="<?php echo $das[a_name]?>">
        <input type="hidden" name="ans_id<?php echo $i; ?>" id="ans_id<?php echo $i; ?>" size="50" value="<?php echo $das[a_id]?>"></td>
       </tr>
  <?php 
    $i++; 
  } ?>
  <tr bgcolor="#FFFFFF">
        <td  align="center"></td>
        <td align="center"><?php echo $text_genpoll_Vote_Choice3;?></td>
        <td ><input class="form-control" style="width:50%;" name="newans" type="text" class="normal_font" id="newans" size="50"></td>
    </tr>
    </table>
	<input class="btn btn-success btn-ml"  type="submit" name="Submit" value="<?php echo $text_genpoll_Button_Save;?>"  onClick="/*return confirm('ยืนยันการบันทึก');*/">
	  <input  class="btn btn-warning" type="submit" name="Clear" value="<?php echo $text_genpoll_Button_Clear;?>"  onClick="return confirm('ยืนยันการลบตัวเลือกทั้งหมดหรือไม่');">
      <input name="num" type="hidden" id="num" value="<?php echo $num; ?>">
	  <input name="c_id" type="hidden" id="c_id" value="<?php echo $c_id; ?>">
	  <input name="a_id" type="hidden" id="a_id" value="">
	  <input name="flag" type="hidden" id="flag" value="<?php echo $_GET[flag]; ?>">
	</td>
    </tr>
	<tr bgcolor="#FFFFFF"> 
      <td ></td>
      <td align="right">
	  <input class="btn btn-success btn-ml"  type="button" name="Complete" value="<?php echo $text_genpoll_Button_Finish;?>" class="normal_font" onClick="if(confirm('ต้องการจบขั้นตอนการสร้างแบบสอบถามหรือไม่?')){location.href='main.php'};"></td>
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
alert("Please insert topic");
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
/*if(document.form1.date_start.value != "" && document.form1.date_stop.value== ""){
alert("Please insert end date");
document.form1.date_stop.focus();
return false;
}
if(document.form1.date_start.value == "" && document.form1.date_stop.value!= ""){
alert("Please insert start date ");
document.form1.date_start.focus();
return false;
}*/
}
</script>