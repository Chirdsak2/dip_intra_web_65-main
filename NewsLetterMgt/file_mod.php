<?php
include("authority.php");
?>
<?php 

$Sel= "select * from n_file order by f_id desc";
function chksize($chk){
if($chk==1){
echo "1 byte";
}elseif(($chk>0)and($chk<999)and($chk!=1)){
echo $chk." bytes";
}elseif($chk==1000){
echo "1 KB.";
}elseif($chk>1000){
$chk1 = $chk/1000;
echo $chk1." KB.";
}
}
$db->write_log("view","enews","เข้าสู่ การจัดการไฟล์แนบ");
?>
<html>
<head>
<title>Newsletter Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
a {  font-family: "MS Sans Serif"; color: #FF6633; text-decoration: none}
-->
</style>
</head>
<script language="JavaScript">
function Chk(){
if(document.form2.file.value == ""){
alert("<?php echo $lang_file_select; ?>");
document.form2.file.focus();
return false;
}
}
</script>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/enews_function.gif" width="32" height="32" align="absmiddle" border="0"> 
      <span class="ewtfunction">ไฟล์แนบ</span> </td>
  </tr>
</table>
<form name="form2" enctype="multipart/form-data" method="post" action="file_function.php" onSubmit="return Chk();">
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td height="27" align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ไฟล์แนบ");?>&module=newsletter&url=<?php echo urlencode("file_mod.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php 
			include($UserPath."lib".$sign."newslim.dll");
			if($limnews > $totalrows){ ?><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> <?php echo $lang_file_add; ?>
              
                <input  class="form-control" style="width:30%;" type="file" name="file">
                          <input name="Submit2" type="submit" value="<?php echo $lang_add; ?>" class="btn btn-success btn-ml" >
                          <input name="Flag" type="hidden" id="Flag" value="Add">
		<?php }else{ ?>
		<font color="#FF0000"><?php echo $lang_file_limit; ?> <?php echo  $limnews; ?></font>
		<?php } ?>
        <hr>    </td>
    </tr>
</table>
</form>
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
<br>
<?php
$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";
if($filedel != ""){
@unlink($Path_true."/".$filedel);
}
?>
<table width="95%" align="center" class="table table-bordered">
		
          <form name="form1" method="post" action="file_function.php">
          <tr bgcolor="B2B4BF" class="ewttablehead"> 
            <td width="47%" height="27"> <?php echo $lang_file_name; ?>            </td>
            <td width="24%" height="27" align="center"> <?php echo $lang_file_type; ?>            </td>
            <td width="23%" height="27" align="center"> <?php echo $lang_file_size; ?>            </td>
            <td width="6%" height="27" align="center"> <?php echo $lang_file_delete; ?>            </td>
          </tr>
          <?php
		  if($totalrows != 0){
$i = 0;
while($R = mysql_fetch_array($ExecShow )){
	$sel = "select count(g_id) as cgroup from n_group_member where g_id = '$R[g_id]'";
	$cg = $db->query($sel);
	$cnum = mysql_fetch_array($cg);
?>
          <tr bgcolor="ECEBF0"> 
            <td width="47%" height="29" bgcolor="#FFFFFF">
              <a href="<?php echo $Path_true."/".$R['f_name'];?>" target="_blank"><?php echo $R['f_name'];?></a></td>
            <td width="24%" height="29" bgcolor="#FFFFFF"> 
              <?php echo $R['f_type'];?></td>
            <td width="23%" height="29" bgcolor="#FFFFFF"> 
			  <?php echo chksize($R[f_size]); ?>            </td>
            <td width="6%" height="29" align="center" bgcolor="#FFFFFF"> 
                <input name="fname<?php echo $i; ?>" type="hidden" id="fname<?php echo $i; ?>" value="<?php echo $R['f_name'];?>">
                <input type="checkbox" name="gid<?php echo $i;?>" value="<?php echo $R['f_id'];?>">
            </td>
          </tr>
          <?php 
$i++;
}
}else{
?>
<tr bgcolor="#CC3300"> 
            <td height="29" colspan="4" align="center" bgcolor="#FFFFFF"><?php echo $lang_file_noitem; ?></td>
          </tr>
<?php } ?>
<tr align="right" bgcolor="B2B4BF"> 
      <td colspan="4" bgcolor="#FFFFFF"> 
          <input type="hidden" name="all" value="<?php echo $i;?>">
          <input type="hidden" name="flag" value="Delete">
          <input class="btn btn-danger btn-ml"  type="submit" name="Submit" value="  <?php echo $lang_file_delete; ?>  " <?php   if($totalrows==0){ echo "disabled"; }?> onClick="return confirm('คุณต้องการลบไฟล์ที่เลือกหรือไม่?');">
    
      </td>
  </tr></form>
</table>  
<?php   if($totalrows>0){ ?>
<br>
<table width="95%" border="0" cellspacing="0" cellpadding="3" bgcolor="ECEBF0" height="20" align="center">
  <tr> 
    <td width="10%" align="center"><?php echo $lang_page_num; ?> </td>
    <td width="90%"><?php
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
?> </td>
  </tr>
</table>
<?php } ?>

</body>
</html>
