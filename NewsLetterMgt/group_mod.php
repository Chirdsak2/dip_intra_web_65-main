<?php
include("authority.php");
?>
<?php 

$Sel = "select * from n_group,article_group where c_id = g_name and ";
if ($ADMINL == "Y"){
			  $UsrPer = mysql_query("SELECT * FROM`admin_permission`Inner Join `admin` ON `admin`.`AID` = `admin_permission`.`AID` WHERE `admin`.`Usr` =  			'$aname'");
				
			  while($UsrPerArray = mysql_fetch_array($UsrPer)){
				$name =   $UsrPerArray["sdName"];
				$Sel .=  " g_name = '$name' OR ";
				
				}
	$Sel .= " `n_group`.`g_name` =  '' order by g_id desc ";			
				}else{
			$Sel .= " `n_group`.`g_name` !=  '' order by g_id desc ";	
				}


//echo $Sel;
//$r = $db->query($sel);
/***************** Start Seperate Page ****************/
 //    If $offset is set below zero (invalid) or empty, set to zero 
    if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = mysql_query($Sel);
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
$ExecShow = mysql_query($Show);
//$db->write_log("view","enews","เข้าสู่ การจัดการกลุ่มข่าว");

include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/enews_function.gif" width="32" height="32" align="absmiddle" border="0"> 
      <span class="ewtfunction">กลุ่มข่าว</span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("กลุ่มข่าว");?>&module=newsletter&url=<?php echo urlencode("group_mod.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <a href="#" onClick="window.open('group_add.php?flag=Add','GroupAdd','scrollbars=1,height=300,width=500');"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> <?php echo $lang_group_add; ?></a>
      <hr>
    </td>
  </tr>
</table>
<?php if($_GET["msg"] == 'Y') {?>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" bordercolor="#333333" bgcolor="ECEBF0" <?php if($msg == 'Y') {?>border="1"<?php }?>align="center">
    <tr>
      <td height="15">    
        <div align="center"><font face="MS Sans Serif" size="2"><b><font color="#000000" size="1"> 
<?php echo $lang_data_update; ?></font></b></font></div>
      </td>
  </tr>
</table>
</div>
<br>
  <?php }?>
<table width="90%" align="center" class="table table-bordered">
  <form name="form1" method="post" action="group_function.php">
    <tr bgcolor="B2B4BF" class="ewttablehead"> 
	  <td width="5%">&nbsp;</td>
      <td height="24"><?php echo $lang_group_name; ?></td>
      <td height="24" align="center"><?php echo $lang_group_member; ?></td>
      <td align="center">เฉพาะบุคลภายใน</td>
      <td align="center">บุคคลภายนอก</td>
     <!-- <td width="9%" height="27"> <div align="center"><font size="1"><b><font face="MS Sans Serif"><?php// echo $lang_group_modify; ?></font></b></font></div></td>-->
      <td width="5%" height="24" align="center"> <?php echo $lang_group_delete; ?></td>
    </tr>

<?php   if($totalrows>0){ ?>
<br>
<table width="95%" border="0" cellspacing="0" cellpadding="3" bgcolor="ECEBF0" height="20" align="center">
  <tr> 
    <td width="8%" align="right"><?php echo $lang_page_num; ?> </td>
    <td width="92%"><?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&limit=$limit&mname=".$mname."&email=$email'><font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><<</font></a>\n\n";
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
                  echo  "<a href='$PHP_SELF?offset=$newoffset&limit=$limit&mname=".$mname."&email=$email' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 
         
    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&limit=$limit&mname=".$mname."&email=$email'\>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\"\>>></font></a>\n"; 
    }
?> </td>
  </tr>
</table>
<?php } ?>


<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $lable;?>กลุ่มข่าว</h4>
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
            <th width="40%" style="text-align:center" > <?php echo $lang_group_name; ?></th>
            <th width="10%" style="text-align:center" > <?php echo $lang_group_member; ?></th>
			<th width="10%" style="text-align:center" > เฉพาะบุคลภายใน</th>
			<th width="10%" style="text-align:center" > บุคคลภายนอก</th>
            <th width="10%" style="text-align:center" ><?php echo $lang_group_delete; ?></th>
          </tr>
<?php
 if($totalrows != 0){
$i = 0;
while($R = mysql_fetch_array($ExecShow )){

$sel = "SELECT count(g_id) AS cgroup FROM n_group_member WHERE g_id = '{$R[g_id]}'";
	$cg = $db->query($sel);
	$cnum = mysql_fetch_array($cg);
?>
    <tr > 
      <td ><nobr><a href="#" onClick="window.open('group_edit.php?gid=<?php echo $R['g_id'];?>&flag=Edit','GroupEdit','height=300,width=500');"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไข" width="16" height="16" border="0"></a></nobr></td>
	  <td ><?php echo $R['c_name'];?></td>
      <td ><?php if($cnum[0]>0){ ?>
          <a href="#" onClick="window.open('group_detail.php?gid=<?php echo $R['g_id'];?>&gname=<?php echo $R['g_name'] ?>','GroupDetail','height=300,width=500');">
          <?php echo $cnum[0];?></a> 
          <?php }else{ echo $cnum[0]; } ?></td>
      <td >&nbsp;<?php if($R['g2'] == "1"){ echo "<img src=\"../images/check_24.gif\" width=\"24\" height=\"24\">"; } ?>&nbsp;</td>
      <td >&nbsp;
        <?php if($R['g2'] == "2"){ echo "<img src=\"../images/check_24.gif\" width=\"24\" height=\"24\">"; } ?>
        &nbsp;</td>
      <td > 
          <input type="checkbox" name="gid<?php echo $i;?>" value="<?php echo $R['g_id'];?>">      </td>
    </tr>
	
<?php 
$i++;
}
?>
<tr> 
<td colspan="5" bgcolor="#FFFFFF">&nbsp;     </td>
<td align="center" bgcolor="#FFFFFF">
          <input type="hidden" name="all" value="<?php echo $i;?>">
          <input type="hidden" name="flag" value="Delete">
          <input type="submit" name="Submit" value="  <?php echo $lang_group_delete; ?>  " <?php   if($totalrows==0){ echo "disabled"; }?> onClick="return confirm('<?php echo $lang_confirm_delete_group; ?>');"> </td>    
</tr>

<?php
}else{
?>
<tr><td colspan="7"><?php echo $lang_no_member; ?></td></tr>
<?php
}
?>
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
