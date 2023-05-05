<?php
include("authority.php");
?>
<?php 
$do = $_GET['do'];
if($do != ""){
$Sel= "select * from n_member,n_group_member where n_member.m_id = n_group_member.m_id and n_group_member.g_id = '{$do}' order by n_member.m_id desc";
}else{
$Sel= "select * from n_member order by m_id desc";
}
//$r = $db->query($sel);
//$db->write_log("view","enews","เข้าสู่ การจัดการสมาชิก");
include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
</head>
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<?php include("../FavoritesMgt/favorites_include.php");?>

<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/enews_function.gif" width="32" height="32" align="absmiddle" border="0"> 
      <span class="ewtfunction">สมาชิก</span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("สมาชิก");?>&module=newsletter&url=<?php echo urlencode("member_mod.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#123" onClick="window.open('member_add.php','MemberADD','height=300,width=500,scrollbars=1,resizable=1');"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มสมาชิกใหม่ </a>
      <hr>
    </td>
  </tr>
</table>


<?php if($_GET["msg"] == 'Y') {?>
  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#333333" bgcolor="ECEBF0" <?php if($msg == 'Y') {?>border="1"<?php }?>align="center">
    <tr>
      <td height="15">    
<div align="center">
<font face="MS Sans Serif" size="2"><b><font color="#000000" size="1"> 
<?php echo $lang_data_update; ?></font></b></font></div>
      </td>
  </tr>
</table>
</div>
<br>
<?php }?>
  
  
<?php
/***************** Start Seperate Page ****************/
 //    If $offset is set below zero (invalid) or empty, set to zero 
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($Sel);
$nof = mysql_num_fields($ExecSel); 
$totalrows = mysql_num_rows($ExecSel);
	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $Sel." LIMIT $offset, $limit ";
//echo $Show;
//exit();
$ExecShow = $db->query($Show);
?>


<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
 <?php
			  $sel = "select * from n_group,article_group where c_id = g_name and ";
			  $sel .= " `n_group`.`g_name` !=  '' order by g_id desc ";	
			  //$SQL = $db->query("SELECT * FROM n_group order by g_name");
			  $SQL = $db->query($sel);
			  ?>
  <tr> 
    <td width="75%" align="left">
	<select name="menu1" onChange="MM_jumpMenu('self',this,0)" class="form-control" style="width:30%;" >
    <option value="member_mod.php"><?php echo $lang_all_group; ?></option>
	<?php while($RR = mysql_fetch_array($SQL)){ ?>
	<option value="member_mod.php?do=<?php echo $RR[g_id]; ?>" <?php if($do==$RR[g_id]){ echo "selected"; } ?>><?php echo $RR[c_name]; ?></option>
	<?php } ?>
    </select>
	</td>
    <td align="left"> <?php echo $lang_amount_member; ?><?php echo $totalrows; ?>      </td></td>
  </tr>
</table>
<br>



<table width="90%" align="center" class="table table-bordered">
          <form name="form1" method="post" action="member_function.php">
          <tr class="ewttablehead">
		  <td width="5%" align="center">&nbsp;</td> 
            <td align="center"> <?php echo $lang_member_email; ?>            </td>
            <td  align="center"> <?php echo $lang_member_timestamp; ?></td>
            <td align="center"><?php echo $lang_member_activate; ?></td>
            <td width="5%"  align="center"> <?php echo $lang_member_del; ?></td>
          </tr>
          <?php
		  if($totalrows>0){
$i = 0;
while($R = mysql_fetch_array($ExecShow)){
?>
          <tr > 
		  <td  align="center" bgcolor="#FFFFFF"  ><nobr><a href="#123" onClick="win2=window.open('member_detail.php?mid=<?php echo $R[0];?>&email=<?php echo $R[1];?>','MemberDetail','height=500,width=700,scrollbars=1,resizable=1');win2.focus();"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" alt="เรียกดู"></a></nobr></td>
            <td bgcolor="#FFFFFF"  >
              <?php echo $R['m_email'];?></td>
            
            <td  align="center" bgcolor="#FFFFFF"> 
                <?php echo $R['m_date'];?>            </td>
            <td  align="center" bgcolor="#FFFFFF">
              <input name="m_id<?php echo $i; ?>" type="hidden" id="m_id<?php echo $i; ?>" value="<?php echo $R['m_id'];?>">
              <select name="act<?php echo $i; ?>" class="form-control" style="width:40%;" >
              <option>No</option>
              <option value="Y" <?php if($R[m_active]=="Y"){ echo "selected"; }?>>Yes</option>
              </select>            </td>
            <td  align="center" bgcolor="#FFFFFF"> 
                <input type="checkbox" name="mid<?php echo $i;?>" value="<?php echo $R['m_id'];?>">            </td>
          </tr>
          <?php 
$i++;
}
}else{
?>
<tr> 
            <td height="29" colspan="5" align="center" bgcolor="#FFFFFF"><?php echo $lang_no_member; ?></td>
          </tr>
<?php
}
?>
<tr> 
      <td colspan="5" bgcolor="#FFFFFF"> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%"><?php   if($totalrows==0){ echo "&nbsp;"; }else{ ?><a href="xls_gen.php?do=<?php echo $do; ?>" target="_blank"><?php echo $lang_export_to_excel; ?></a><?php } ?></td>
              <td width="50%" align="right"><input type="hidden" name="all" value="<?php echo $i;?>">
                <input type="hidden" name="flag" value="Delete">
              <input  class="btn btn-success btn-ml" type="submit" name="Submit" value="ปรับปรุงข้อมูล" <?php   if($totalrows==0){ echo "disabled"; }?> onClick="return confirm('<?php echo $lang_confirm_change_member; ?>');"></td>
            </tr>
          </table>      </td>
  </tr></form>
</table>

<?php 
if($totalrows>0){ ?>

<table width="95%" border="0" cellspacing="0" cellpadding="3" bgcolor="ECEBF0" height="20" align="center">
  <tr> 
    <td width="10%" align="center"><?php echo $lang_page_num; ?></td>
    <td width="90%"> 
	
	<?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&limit=$limit&do=".$do."'><font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><<</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($totalrows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($totalrows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">$i </font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&limit=$limit&do=".$do." ' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 
         
    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&limit=$limit&do=".$do."'\>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\"\>>></font></a>\n"; 
    }
?></td>
  </tr>
</table>


<?php } ?>
-->




<?php
/***************** Start Seperate Page ****************/
 //    If $offset is set below zero (invalid) or empty, set to zero 
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($Sel);
$nof = mysql_num_fields($ExecSel); 
$totalrows = mysql_num_rows($ExecSel);
	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $Sel." LIMIT $offset, $limit ";
//echo $Show;
//exit();
$ExecShow = $db->query($Show);
?>


<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $lable;?>สมาชิก</h4>
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
</a>
<a href="GroupList_in.php" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>-->


</div>
</div>
</div>
<br />	
<hr />



<div class="col-md-12 col-sm-12 col-xs-12" >
<table width="100%" align="center" class="table table-bordered">
<form name="form1" method="post" action="member_function.php">
          <tr class="ewttablehead">
			<th width="10%" style="text-align:center" >&nbsp;</th> 
            <th width="50%" style="text-align:center" > <?php echo $lang_member_email; ?></th>
            <th width="10%" style="text-align:center" > <?php echo $lang_member_timestamp; ?></th>
            <th width="20%" style="text-align:center" ><?php echo $lang_member_activate; ?></th>
            <th width="10%" style="text-align:center" > <?php echo $lang_member_del; ?></th>
          </tr>
<?php
if($totalrows>0){
$i = 0;
while($R = $db->db_fetch_array($ExecShow)){	
?>
<tr> 
<td  align="center" bgcolor="#FFFFFF">
<nobr><a href="#123" onClick="win2=window.open('member_detail.php?mid=<?php echo $R[0];?>&email=<?php echo $R[1];?>','MemberDetail','height=500,width=700,scrollbars=1,resizable=1');win2.focus();"><img src="../theme/main_theme/g_view.gif" width="16" height="16" border="0" alt="เรียกดู"></a></nobr></td>
<td bgcolor="#FFFFFF"  ><?php echo $R['m_email'];?>
</td>
<td  align="center" bgcolor="#FFFFFF"> 
<?php echo $R['m_date'];?>            
</td>
<td  align="center" bgcolor="#FFFFFF">
<input name="m_id<?php echo $i; ?>" type="hidden" id="m_id<?php echo $i; ?>" value="<?=$R['m_id'];?>">
              <select name="act<?php echo $i; ?>" class="form-control" style="width:40%;" >
              <option>No</option>
              <option value="Y" <?php if($R['m_active']=="Y"){ echo "selected"; }?>>Yes</option>
              </select>            
</td>
<td  align="center" bgcolor="#FFFFFF"> 
<input type="checkbox" name="mid<?php echo $i;?>" value="<?php echo $R['m_id'];?>">           
</td>
</tr>
<?php 
$i++;
}
}else{
?>
<tr><td height="29" colspan="5" align="center" bgcolor="#FFFFFF"><?php echo $lang_no_member; ?></td></tr>
<?php
}
?>
<tr> 
<td colspan="5" bgcolor="#FFFFFF"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="50%"><!--<?php   if($totalrows==0){ echo "&nbsp;"; }else{ ?><a href="xls_gen.php?do=<?php echo $do; ?>" target="_blank"><?php echo $lang_export_to_excel; ?></a><?php } ?>--></td>
<td width="50%" align="right">
<input type="hidden" name="all" value="<?php echo $i;?>">
<input type="hidden" name="flag" value="Delete">
<input  class="btn btn-success btn-ml" type="submit" name="Submit" value="ปรับปรุงข้อมูล" <?php   if($totalrows==0){ echo "disabled"; }?> onClick="return confirm('<?php echo $lang_confirm_change_member; ?>');"></td>
</tr>
</table>      
</td>
</tr>
</form>
</table>
</div>

</div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
<?php
$db->db_close();
?>