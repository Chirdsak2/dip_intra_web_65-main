<?php
include("../EWT_ADMIN/comtop.php");
$cid = (int)(!isset($_GET['cid']) ? '' : $_GET['cid']);
$nid = (int)(!isset($_GET['nid']) ? '' : $_GET['nid']);


if($_GET['flag']=='del'){
	$sql = "select fileattach_path from article_attach where fileattact_id = '".$_GET[at_id]."'";
	$query = $db->query($sql);
	$R = $db->db_fetch_array($query);
	$sql_c = $db->db_fetch_array($db->query("select count(fileattact_id) as num_c from article_attach where fileattach_path =  '".$R[fileattach_path]."' "));
	if($sql_c[num_c] == '1'){
				if (file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$R[fileattach_path])) {
				unlink("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$R[fileattach_path]);
				}
	}
	$db->query("DELETE FROM article_attach  where fileattact_id = '".$_GET[at_id]."'");
	?>
						<script language="javascript">
							alert("ลบเรียบร้อย");
							self.location.href = "article_upload_file.php?nid=<?php echo $_GET["nid"]; ?>&cid=<?php echo $_GET[cid];?>";
						</script>
<?php
}
?>
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
?>

<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<div class="card">
<div class="card-header">

<div class="container" style="width:98%;">
<h4><b>เอกสารแนบ</b></h4>
<p></p> 
              
<!--<ol class="breadcrumb">
<li><a href="index.php">ข่าว/บทความ</a></li>
<li class=""></li>       
</ol>-->

</div>

<div class="row m-b-sm">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right hidden-xs"  >
<a href="article_upload_file_add.php?flag=add&nid=<?=$nid;?>&cid=<?=$cid;?>" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-plus-circle"></i>&nbsp;<?="เพิ่มเอกสารแนบ";?>
</button>
</a>  
<a href="article_edit.php?nid=<?=$nid;?>&cid=<?=$cid;?>" target="_self">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
</button>
</a>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
		    <li><a href="article_upload_file_add.php?flag=add&nid=<?=$nid;?>&cid=<?=$cid;?>" ><i class="fas fa-plus-circle"></i>&nbsp;<?=" เพิ่มเอกสารแนบ";?></a></li>
			<li><a href="article_edit.php?nid=<?=$nid;?>&cid=<?=$cid;?>" ><i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?></a></li>
		</ul>
</div>
</div>	
</div>
</div>
<!--END card-header -->
<div class="card-body">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" >

<div class="table-responsive" id="frm_edit_s1">
<table  class="table table-bordered" width="100%"  align="center" >
<thead>
      <tr class="success" >
		<th  width="10%" class="text-center"></th>
        <th  width="90%" class="text-center">ชื่อเอกสารแนบ</th>
      </tr>
</thead>
<tbody>
<?php 	
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$wh = "where n_id = '{$nid}'";

$_sql = $db->query("select * from article_attach {$wh} ORDER BY fileattact_id ASC LIMIT {$start} , {$perpage} ");

$statement = "SELECT count(fileattact_id) AS b
			  FROM article_attach
			  {$wh}";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);		

while($R = $db->db_fetch_array($_sql)){		
?>
<tr> 
<td class="text-center">
<nobr>
<a href="article_upload_file_add.php?flag=edit&nid=<?=$nid;?>&at_id=<?=$R['fileattact_id'];?>&cid=<?=$cid;?>">
<button type="button" class="btn btn-info btn-circle btn-sm "  data-toggle="tooltip" data-placement="top" title="<?='แก้ไขเอกสารแนบ';?>"  >
<i class="far fa-edit" aria-hidden="true"></i>
</button>				
<!--<img src="../theme/main_theme/g_edit.gif" alt="แก้ไขเอกสารแนบ" width="16" height="16" border="0">-->
</a>

<a href="article_upload_file.php?flag=del&nid=<?=$nid;?>&at_id=<?=$R['fileattact_id'];?>&cid=<?=$cid;?>">
<button type="button" class="btn btn-danger  btn-circle  btn-sm "  data-toggle="tooltip" data-placement="top" title="<?='ลบเอกสารแนบ';?>" >
<i class="far fa-trash-alt" aria-hidden="true"></i>
</button>	  
<!--<img src="../theme/main_theme/g_del.gif" alt="ลบเอกสารแนบ" width="16" height="16" border="0" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');" onMouseOver="this.style.cursor='hand';">-->
</a> 
 
</nobr>	  
</td>
<td class="text-left"><?=$R['fileattach_name'];?></td>
</tr>
<?php 
}
if($a_rows==0){
?>
<tr> 
<td colspan="4" class="text-center">
<h4 >
<p class="text-danger"><?=$txt_ewt_data_not_found;?></p>
</h4>
</td>
</tr>
<?php
	}
?>

</tbody>	
</table>
</div>
</div>

<?=pagination_ewt($statement,$perpage,$page,'?nid='.$nid.'&cid='.$cid.'&search_txt='.$search_txt.'&');?>	
</div>
</div>


</div>
<!--END card-->
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
