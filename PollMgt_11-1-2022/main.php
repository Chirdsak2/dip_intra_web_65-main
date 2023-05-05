<?php
include("admin.php");
include("../lib/set_lang.php");
function datetime($str){
  $y=substr($str,0,4);
  if($y)$y=($y*1)+543;
  $m=substr($str,4,2);
  $d=substr($str,6,2);
  $h=substr($str,8,2);
  $i=substr($str,10,2);
  $s=substr($str,12,2);
  
  $str="$d/$m/$y [$h:$i:$s]";
  if(trim($str)=="// [::]"){ return '-'; }else{ return  $str;}
  
}
?>
<?php
if($_SESSION["EWT_SMTYPE"] == "Y" or $db->check_permission("poll","a","") ){
	$SQL = $db->query("SELECT * FROM `poll_cat`  ");
}else{
	$SQL = $db->query("SELECT * FROM `poll_cat` WHERE c_uid = '" .$_SESSION["EWT_SMID"]."' ORDER BY c_id ");
}
$Rows = mysql_num_rows($SQL);

	
include("../lib/config_path.php");
include("../header.php");
?>

<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>

<?php include('link.php'); ?>

<script>
function addNew(){
var r = prompt('<?php echo $text_genpoll_prompt;?>','5');
if(r != "" && r != null){
if(r > 0 && r < 99){
win2 = window.open('add.php?num='+ r +'', 'add', 'alwaysRaised=1,menuber=0,toolbar=0,location=0,directories=0,personalbar=0,scrollbars=0,status=0,resizable=1,width=450,height=350');
win2.focus();
}
}
}
function delC(c,deltext){
var r = confirm('<?php echo $text_genpoll_alert_delete1;?>'+deltext+'<?php echo $text_genpoll_alert_delete2;?>');
if(r == true){
document.form2.c_id.value = c;
form2.submit();
}
}
function reset_poll(c,deltext){
var r = confirm('<?php echo 'คุณแน่ใจที่จะล้างค่าความคิดเห็นของแบบสำรวจนี้ใช่หรือไม่!!';?>');
if(r == true){
document.form1.c_id.value = c;
document.form1.flag.value = 'resetpoll';
form1.submit();
return false;
}
}

function approve(c){
      var a = confirm('<?php echo $text_genpoll_Vote_ApproveCon;?>');
		if(a==true){
		window.location.href="function_approve.php?c_id="+c;
		}
}
</script> 

</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
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
	<img src="../theme/main_theme/poll_function.gif" width="32" height="32" align="absmiddle"> 
	<span class="ewtfunction"><?php echo $text_genpoll_function;?></span> 
</div>    
</div>
</div>
</div>
</div>-->

<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 5px;">
<!--<span class="label label-primary" style="font-size:16px;padding:5px;" ><?php //echo $text_genpoll_Form1;?></span>	-->
<div class="panel-body" >

<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;" >
	<!--<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php //echo urlencode($text_genpoll_function);?>&module=poll&url=<?php //echo urlencode("main.php");?>', 'divForm', 300, 80, -1,433, 1);">
	<img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="add.php" ><img src="../theme/main_theme/g_add.gif" alt="<?php echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle"> <?php //echo $text_general_add;?></a> &nbsp;-->
<div class="row">
<div class="col-md-10 col-sm-10 col-xs-12"></div>
<div class="col-md-2 col-sm-2 col-xs-12" style="text-align:right;" >
	<a href="add.php" >
	<!--<button type="button" class="btn btn-info btn-block" /><img src="../theme/main_theme/g_add.gif" alt="<?php echo $text_general_add;?>" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $text_general_add;?></button>-->
	<button type="button" class="btn btn-info  btn-ml " >
        <span class="glyphicon glyphicon-plus-sign "></span> <?php echo $text_general_add;?>
	</button>
	</a>
</div>
</div>
</div>
<br>
<hr>
<div class="col-md-12 col-sm-12 col-xs-12">
<table width="100%"  align="center" class="table table-bordered">
  <form name="form1" method="post" action="main_function.php">
  <input name="c_id" type="hidden">
  <input name="flag" type="hidden">
  
    <tr align="center" class="ewttablehead"> 
      <th style="text-align: center" width="12%">&nbsp;</td>
      <th style="text-align: center" width="30%"><?php echo $text_genpoll_Vote_Topic;?></td>
      <th style="text-align: center" width="10%">ภาษาอื่น</td>
      <th style="text-align: center" width="8%"><?php echo $text_genpoll_Vote_Status;?></td>
      <th style="text-align: center" width="10%"><?php echo $text_genpoll_Vote_User;?></td>
      <th style="text-align: center" width="15%"><?php echo $text_genpoll_Vote_Create;?></td>
      <th style="text-align: center" width="15%"><?php echo $text_genpoll_Vote_Update;?></td>
    </tr>
	
<?php
  if($Rows > 0){
  $i = 0;
   while($pollR = mysql_fetch_array($SQL)){ ?>
    <tr bgcolor="#FFFFFF"> 
      <td>
	  
	  <?php if($pollR[c_approve]=='Y'){?>
	  <a href="#vote" onClick="window.open('vote.php?cad_id=<?php echo $pollR[c_id]; ?>', '', 'alwaysRaised=1,menuber=0,toolbar=0,location=0,directories=0,personalbar=0,scrollbars=1,status=0,resizable=1,width=550,height=410');"><img src="../theme/main_theme/g_view.gif" alt="<?php echo $text_general_View;?>" width="16" height="16" border="0" align="absmiddle" ></a>
	  <?php }else if($db->check_permission("poll","a","")){?>
	  <a href="#vote" onClick="approve('<?php echo $pollR[c_id]; ?>');"><img src="../theme/main_theme/g_approve.gif" alt="<?php echo $text_genpoll_Vote_Approve;?>" width="16" height="16" border="0" align="absmiddle" ></a>
	 <?php }?>
	  
	  <a href="add_q.php?c_id=<?php echo $pollR[c_id]; ?>"><img src="../theme/main_theme/g_edit.gif" alt="<?php echo $text_general_edit;?>" width="16" height="16" border="0" align="absmiddle" ></a> 
	     <?php if($pollR[c_use] == "Y"){  ?>
        <img src="../theme/main_theme/g_del.gif" alt="<?php echo $text_general_delete;?>" width="16" height="16" style="background-color:#DBDBDB" align="absmiddle"  > 
        <?php }else{  ?>
		
	 <?php 
	  $allow_del_sql=" SELECT * FROM block inner join block_function on block.BID = block_function.BID 
	                                     WHERE block_type='poll' and block_link = '$pollR[c_id]' " ;
      if( mysql_num_rows($db->query($allow_del_sql)) > 0){?> 
		  <img src="../theme/main_theme/g_disdel.gif" alt="<?php echo $text_general_delete;?>" width="16" height="16" border="0" align="absmiddle" > 
	 <?php }else{ ?>
	      <a href="#" onClick="delC('<?php echo $pollR[c_id]; ?>','<?php echo $pollR[c_name] ?>');"><img src="../theme/main_theme/g_del.gif" alt="<?php echo $text_general_delete;?>" width="16" height="16" border="0" align="absmiddle" ></a> 
	  <?php }   ?>
		
        
        <?php } ?> 
		<a href="#G" onClick="txt_data('<?php echo $pollR[c_id]; ?>','')"><img id="lang<?php echo $pollR[c_id]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a> 
		<?php if($pollR[c_approve]=='Y'){?><a href="#" onClick="reset_poll('<?php echo $pollR[c_id]; ?>','<?php echo $pollR[c_name] ?>');"><img src="../theme/main_theme/g_reset.gif" alt="ล้างความคิดเห็นเป็น &quot;0&quot;" width="14" height="14" border="0" align="absmiddle"></a><?php } ?> </td>
      <td><?php echo stripslashes($pollR[c_name]); ?> </td>
      <td><?php echo show_icon_lang($pollR[c_id],'poll');?></td>
      <td align="center"><?php if($pollR[c_approve]=='Y'){echo $text_genpoll_Vote_Approved;}else{echo $text_genpoll_Vote_Wait;}?></td>
      <td align="center"><?php echo $pollR[c_creater];?></td>
      <td align="center"><?php echo datetime($pollR[c_timestamp]) ;?></td>
      <td align="center"><?php echo datetime($pollR[c_lastupdate]);?></td>
    </tr>
    <?php $i++; } ?>
    <?php }else{ ?>
    <tr> 
      <td colspan="6" align="center"><font color="#FF0000"><?php echo $text_genpoll_No_Data;?></font></td>
    </tr>
    <?php } ?>
  </form>
</table>
</div>
<form action="function_delete.php" method="post" name="form2">
<input name="c_id" type="hidden">
</form>
</div>
</div>
<?php
include('footer.php');
?>

</body>
</html>

<script>
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
		function txt_data(w,g) {
	
	var mytop = findPosY(document.getElementById("lang"+w)) +document.getElementById("lang"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("lang"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='../language_set.php?gid='+g+'&id='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function txt_data1(w,g,lang) {

	 window.location.href='../multilangMgt/poll_list.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>

