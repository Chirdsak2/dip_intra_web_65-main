<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");


 $data = $_REQUEST['data'];
 $gid = $_REQUEST['gid'];
 
 if (!empty($data)) {
			  $wh = " and vdo_name like '%$data%' ";
}
$sel = "SELECT * FROM vdo_list  WHERE vdo_group='$gid'  $wh ORDER BY vdo_id ASC";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 20;

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


		$sql = "SELECT * FROM vdo_group  WHERE vdog_id='$gid'";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?> 


<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?="หมวดวีดีโอ";?></h4>
<p></p> 

</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="vdo_group.php"><?="หมวดวีดีโอ";?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_vdo_group.php');" data-toggle="tooltip" data-placement="buttom" title="<?="เพิ่มหมวดวีดีโอ";?>"  target="_self">
<button type="button" class="btn btn-info  btn-ml">
<i class="fas fa-plus-circle"></i>&nbsp;<?="เพิ่มหมวดวีดีโอ";?>
</button>
</a>
<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_vdo.php?vdo_cid=<?=$vdo_cid;?>');" data-toggle="tooltip" data-placement="bottom" title="<?="เพิ่มวีดีโอ";?>"  target="_self">
<button type="button" class="btn btn-info  btn-ml">
<i class="fas fa-plus-circle"></i>&nbsp;<?="เพิ่มวีดีโอ";?>
</button>
</a>
<a  target="_self" onclick="boxPopup('<?=linkboxPopup();?>pop_search_vdo.php');" data-toggle="tooltip" data-placement="buttom" title="<?="Search Video";?>">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?="Search Video";?>
</button>
</a>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a onClick="boxPopup('<?=linkboxPopup();?>pop_add_faq_group.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?="เพิ่มหมวด FAQ";?></a></li>
			<li><a onClick="boxPopup('<?=linkboxPopup();?>pop_search_faq.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?="Search FAQ";?></a></li>
          	
		</ul>
</div>
</div>	
</div>
</div>

</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<div class="" id="frm_edit_s">	
<div id="frm_load">  


<table width="100%" border="0" align="center" class="table table-bordered">
<form name="myFrom" method="post" action="vdo_process.php">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="10%" height="30" align="center">&nbsp;</td>
    <td align="center">รายชื่อ VIDEO ในกลุ่ม  <?php echo $data[vdog_name];?></td>
    <td width="10%" align="center">ลบ</td>
  </tr>
  <?php 
  
  $x = $offset;
  if($rows>0){
       $i = 0;
  		while($data=$db->db_fetch_array($Execsql)){ ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center"><nobr><a href="vdo_edit.php?vid=<?php echo $data[vdo_id];?>&gid=<?php echo $_GET[gid]?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไข" border="0"></a> </nobr></td>
				<td><?php echo $data[vdo_name];?> (<?php echo number_format($data[vdo_count],0);?>)</td>
				<td align="center">
				<input name="del<?php echo $i; ?>" type="checkbox" id="del<?php echo $i; ?>" value="<?php echo $data[vdo_id]; ?>" >
    </td>
			  </tr>
  <?php 
         $i++;
  } ?>
			<tr align="right" bgcolor="#FFFFFF"> 
				<td colspan="2">&nbsp;</td>
				<td align="center">
          <input name="all" type="hidden" id="all2" value="<?php echo $i; ?>">
		  <input type="hidden" name="flag" value="del">
		  <input type="hidden" name="gid" value="<?php echo $_GET[gid]?>">
		  <input type="submit" name="Button" value="&nbsp;&nbsp;ลบ &nbsp;&nbsp;" class="btn btn-danger"  onClick="javascript: return confirm('คุณแน่ใจที่จะลบ vdo หรือไม่?');"></td>
		  </tr>
  <?php } ?>
			   <?php if($rows > 0){ ?>
                    <tr bgcolor="#FFFFFF"> 
                      <td height="25" colspan="15" valign="top"><?php echo $text_general_page;?> :
                        <?php
								// Begin Prev/Next Links 
								// Don't display PREV link if on first page 
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?offset=$prevoffset&data=$data&gid=$gid'>
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
											echo  "<a href=\"$PHP_SELF?offset=$newoffset&data=$data&gid=$gid\"". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href=\"$PHP_SELF?offset=$newoffset&data=$data&gid=$gid\">
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
include("../EWT_ADMIN/combottom.php");
?>