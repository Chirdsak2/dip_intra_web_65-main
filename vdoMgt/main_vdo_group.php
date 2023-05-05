<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/config_path.php");
include("../header.php");

 $data = $_REQUEST['data'];
 if (!empty($data)) {
			  $wh = " where vdog_name like '%$data%' ";
}
$sel = "SELECT * FROM vdo_group  $wh ORDER BY vdog_id ASC";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = $db->query($Show); 


?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>

</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<?php
include('top.php');
?>

<!--table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/vdo_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ข้อมูลกลุ่ม VIDEO</span> </td>
  </tr>
</table>


<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ข้อมูลกลุ่ม VIDEO");?>&module=video&url=<?php echo urlencode("main_vdo_group.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp; <!--<a href="vdo_group_add.php" ><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> เพิ่มกลุ่มใหม่</a> ->
	<hr>
    </td>
  </tr>
</table>-->

<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">ข้อมูลกลุ่ม VIDEO</h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >

<form class="form-inline"  name="frm1" id="frm1" action="main_vdo_group.php" method="post">
<div class="form-group">
<label for="data" >ค้นหากลุ่ม VDO :</label>
<input type="hidden" name="curPage" value="1">
<input type="text" name="data"  id="data" value="<?php echo $data;?>" class="form-control" />
</div>
<input type="submit" name="Submit" value="ค้นหา" class="btn btn-success" />
</form>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" >
<!--<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("หน้าหลัก".$text_genbanner_function1);?>&module=banner&url=<?php echo urlencode("main_group_banner.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="banner_gadd.php?flag=add" target="_self"><img src="../theme/main_theme/g_add.gif"  width="16" height="16"  align="absmiddle" border="0"> 
      เพิ่มหมวด</a>
<a href="banner_gadd.php?flag=add" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-plus-sign "></span>  เพิ่มหมวด
	</button>
</a>  -->
</div>	
</div>
</div>

<div class="clearfix">&nbsp;</div>
	
<div class="col-md-12 col-sm-12 col-xs-12" >
				<table width="100%" border="0" align="center" class="table table-bordered">
				<form name="myFrom" method="post" action="vdog_process.php">
				  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
					<td width="10%" height="30" align="center">&nbsp;</td>
					<td width="80%" align="center" >รายชื่อกลุ่ม</td>
					<td width="10%" align="center">ลบ</td>
				  </tr>
				  <?php 
				  
				  $x = $offset;
				  if($rows>0){
					   $i = 0;
						while($data=$db->db_fetch_array($Execsql)){ ?>
							  <tr bgcolor="#FFFFFF"> 
								<td align="center"><nobr><a href="vdo_group_edit.php?gid=<?php echo $data[vdog_id];?>" ><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไข" border="0"></a> </nobr></td>
								<td><a href="vdo_list.php?gid=<?php echo $data[vdog_id];?>"><?php echo $data[vdog_name];?></a></td>
								<td align="center">
								<input name="del<?php echo $i; ?>" type="checkbox" id="del<?php echo $i; ?>" value="<?php echo $data[vdog_id]; ?>" ></td>
							  </tr>
				  <?php
						 $i++;
						 } ?>
							<tr align="right" bgcolor="#FFFFFF"> 
								<td colspan="2">&nbsp;</td>
								<td align="center"> 
									<input name="all" type="hidden" id="all2" value="<?php echo $i; ?>">
									<input type="hidden" name="flag" value="del">
									<input type="submit" name="Button" value="&nbsp;&nbsp;ลบ &nbsp;&nbsp;"  class="btn btn-danger" onClick="javascript: return confirm('คุณแน่ใจที่จะลบกลุ่ม หรือไม่?');"></td>
						  </tr>
				  <?php  } ?>
				  
				  <?php if($rows > 0){ ?>
                    <tr bgcolor="#FFFFFF"> 
                      <td height="25" colspan="15" valign="top"><?php echo $text_general_page;?> :
                        <?php
								// Begin Prev/Next Links 
								// Don't display PREV link if on first page 
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?offset=$prevoffset&data=$data'>
								<font  color=\"red\">$text_general_previous</font></a>\n\n";
								}
								$pages = intval($rows/$limit); 
								if ($rows%$limit) { 
										$pages++; 
								} 
								for ($i=1;$i<=$pages;$i++) { 
									if (($offset/$limit) == ($i-1)) { 
											echo "<b>[ $i ] </b>"; 
									} else { 
											$newoffset=$limit * ($i-1); 
											echo  "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\"". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\">
										<font color=\"red\">$text_general_next</font></a>"; 
								}
								?>
                      </td>
                    </tr>
                    <?php }else{?>
					<tr bgcolor="#FFFFFF"> 
                      <td height="30" colspan="15"  align="center"><font color="#FF0000"><?php echo $text_general_notfound;?></font></td>
                    </tr>
			<?php }?> 
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
$db->db_close(); ?>