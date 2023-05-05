<?php
include("../EWT_ADMIN/comtop.php");
?> 

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

function genlen($data,$op){
	$s = explode($op,$data);
	return count($s);
}


function menu_child($m_id,$mp_id,$l){
	global $db ;

$s_menu_p = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$mp_id}_%' ORDER BY mp_id ASC");
$a_row = $db->db_num_rows($s_menu_p);

if($a_row > 0){
$txt = "";

if($l > 3){
$txt .='<ul >'.PHP_EOL;
}else{
$txt .='<ul >'.PHP_EOL;
}

while($a_menu = $db->db_fetch_array($s_menu_p)){
	$len = genlen($a_menu['mp_id'],"_");
	if($l+1 == $len){
		$s_menu_p2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_id LIKE '{$a_menu['mp_id']}_%' ORDER BY mp_id ASC");
		$a_row2 = $db->db_num_rows($s_menu_p2);
	
		if($a_row2){
			$open = 'class="sortableListsOpen move"';
		}else{
			$open = 'class="move"';
		}

if($a_row2 > 0){
	$txt .='<li id="item_'.$a_menu['mp_pid'].'"  data-value="'.$a_menu['mp_id'].'"  '.$open.' data-module="'.$mp_id.'">';
	$txt .='<div class="text-dark" >';
	if(!empty($a_menu['Oubgpic'])){
			$txt .='<i class="'.$a_menu['Oubgpic'].' text-dark"></i>&nbsp;';
	} 	
	$txt .=$a_menu['mp_name'].'</div>';
	$txt .= menu_child($m_id,$a_menu['mp_id'],$len);
	$txt .="</li>".PHP_EOL;
	}else{
		$txt .='<li id="item_'.$a_menu['mp_pid'].'" data-value="'.$a_menu['mp_id'].'" '.$open.' data-module="'.$mp_id.'">';
		$txt .='<div class="text-dark" >'.$a_menu['mp_name'].'</div>';
		$txt .='</li>'.PHP_EOL;
		}
				

		}
	}

$txt .="</ul>".PHP_EOL;
	}

	return $txt;
}
function chkMenuSub($s_mid,$s_pid)
{ 
global $db ;  
		$_sql 	= $db->query("SELECT * 
				   FROM menu_properties 
				   WHERE m_id = '{$s_mid}' AND mp_sub = '{$s_pid}'  
				   ");		
		$a_row	=  $db->db_num_rows($_sql);
		if($a_row)
		{
			return true;	
			}
			else
			{
				return false;	
			}
	}

function menu_child1($m_id,$mp_id,$l){
	global $db ;

$s_menu_p = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_sub = '{$mp_id}' ORDER BY mp_pos ASC");
$a_row = $db->db_num_rows($s_menu_p);

if($a_row > 0){
$txt = "";
$txt .='<ul class="" >'.PHP_EOL;

while($a_menu = $db->db_fetch_array($s_menu_p)){
	$len = genlen($a_menu['mp_id'],"_");
	//if($l+1 == $len){
		$s_menu_p2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_sub = '{$mp_id}' ORDER BY mp_pos ASC");
		$a_row2 = $db->db_num_rows($s_menu_p2);
	
		if($a_row2){
			$open = 'class="move "';
		}else{
			$open = 'class="move"';
		}
/*$txt .='<div class="" style="">
&nbsp;';
$txt .="<button type=\"button\" class=\"btn btn-default btn-circle btn-sm\" onClick=\"boxPopup('".linkboxPopup()."pop_add_item.php?m_id=".$a_menu['m_id']."&mp_pid=".$a_menu['mp_pid']."');\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit Submenu\">
<i class=\"fas fa-cogs\" aria-hidden=\"true\"></i>
</button>";
$txt .="<a onClick=\"JQDel_Item('".$a_menu['mp_pid']."');\" >
<button type=\"button\" class=\"btn btn-danger btn-circle btn-sm \" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete Submenu\" >
<i class=\"fas fa-trash-alt fa-1x text-white\" aria-hidden=\"true\"></i>
</button>
</a>
</div>";*/
if($a_row > 0)
{
	$edit = linkboxPopup().'pop_edit_item.php?m_id='.$a_menu['mp_id'].'&mp_pid='.$a_menu['mp_pid'];
	$txt .="<span class=\"sortableListsOpener text-right float-right \" style=\"pointer-events:auto;display:inline-block;margin-left:1px; margin-right: 5px; padding-top:8px;\">";
	if(!chkMenuSub($m_id,$a_menu['mp_pid']))
	{
	$txt .="<a onmousedown=\"JQDel_Item('".$a_menu['m_id']."','".$a_menu['mp_pid']."');\"  >
	<button type=\"button\" class=\"btn btn-circle remove\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete\" >
	<i class=\"fas fa-trash-alt fa-1x \" aria-hidden=\"true\"></i>
	</button>
	</a>";
	}
	$txt .="<button type=\"button\" class=\"btn btn-circle setting\" onmousedown=\"boxPopup('".$edit."');\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Edit\">
	<i class=\"fas fa-edit\" aria-hidden=\"true\"></i>
	</button>
	</span>";
	
	/*$txt .='<span class="sortableListsOpener text-right float-right" style="pointer-events:auto;display:inline-block;margin-left:1px;margin-right:5px;padding-top:8px;">';
	$txt .='<button type="button" class="btn  btn-circle remove" data-toggle="tooltip" data-placement="left" title="Delete" >';
	$txt .='<i class="fas fa-trash-alt " aria-hidden="true"></i>';
	$txt .='</button> ';
	$txt .='<button type="button" class="btn  btn-circle setting" onmousedown="boxPopup('.linkboxPopup().'pop_edit_item.php?m_id='.$a_menu['mp_id'].'&mp_pid='.$a_menu['mp_pid'].');" data-toggle="tooltip" data-placement="left" title="Edit">';
	$txt .='<i class="fas fa-edit " aria-hidden="true" ></i>';
	$txt .='</button>';
	$txt .='</span>';*/
	
	$txt .='<li id="'.$a_menu['mp_pid'].'"  data-value="'.$a_menu['mp_id'].'"  '.$open.' data-module="'.$mp_id.'">';
	$txt .='<div class="text-dark" >';
	if(!empty($a_menu['Oubgpic'])){
			$txt .='<i class="'.$a_menu['Oubgpic'].' text-dark"></i>&nbsp;';
	} 	
	$txt .='<b style="word-break: break-all;">'.$a_menu['mp_name'].'</b></div>';
	$txt .= menu_child1($m_id,$a_menu['mp_pid'],$len);
	$txt .="</li>".PHP_EOL;
	}else{
		$txt .='<li id="'.$a_menu['mp_pid'].'" data-value="'.$a_menu['mp_id'].'" '.$open.' data-module="'.$mp_id.'">';
		$txt .='<div class="text-dark" >'.$a_menu['mp_name'].'</div>';
		$txt .='</li>'.PHP_EOL;
		}
				

		//} 
	}

$txt .="</ul>".PHP_EOL;
	}

	return $txt;
}


$m_id = (int)(!isset($_GET['m_id']) ? 0 : $_GET['m_id']);
$m_id = sprintf("%04d",$m_id);

$_sql_list   = $db->query("SELECT m_id,m_name FROM menu_list WHERE m_id = '{$m_id}' ");		  
$a_rows_list = $db->db_num_rows($_sql_list);		
$a_menu      = $db->db_fetch_array($_sql_list);

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$m_id}' AND mp_sub = '0'  ORDER BY mp_pos ASC ");

$statement = "SELECT count(mp_id) AS b
			  FROM menu_properties {$wh} ";
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);

?>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo $txt_menu_menu_builder;?></h4>
<p></p> 
</div>

<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="menu_list.php"><?php echo $txt_menu_menu_main;?></a></li>
<li><?php echo $txt_menu_menu_builder;?></li> 
<li><?php echo $a_menu['m_name'];?></li> 
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<!--<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_menu.php');" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_menu_add;?>
</button>

<button type="button" class="btn btn-info  btn-ml " onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_menu.php');" >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?>
</button>-->

<a href="menu_list.php" target="_self" title="<?php echo $txt_ewt_back;?>">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  > 
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right pointer">
            <li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_menu.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_menu_add;;?></a></li>
          	<!--<li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search_menu.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_menu_search;?></a></li>-->
			<li><a href="menu_list.php" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?></a></li>
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

<div class="row">

<div class="col-md-2 col-sm-2 col-xs-12 m-b-sm" > 
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >

<div class="card-title text-left color-white"> 
<i class="fas fa-wrench color-white fa-1x"></i> Setting Item Menu
</div>
</div>
<div class="card-body">
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_item.php?m_id=<?php echo $m_id;?>');" title="<?php echo $txt_menu_add_item;?>"  target="_self">
<button type="button" class="btn btn-info btn-ml " >
<i class="fas fa-plus-square fa-1x text-white" aria-hidden="true"></i>
Add Item
</button>
</a>
</div>
</div>
</div>

<div class="col-md-10 col-sm-10 col-xs-12 m-b-sm" > 
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3" >

<div class="card-title text-left color-white">
<i class="fas fa-bars color-white fa-1x"></i> Menu
</div>
</div>
<div class="card-body m-b-sm">
<?php /* ?>
<ul id="sTree2" class="sortableLv1 m-b-sm "  style="width: 100%;">
<?php
if($a_rows > 0){
while($a_data = $db->db_fetch_array($_sql)){	
		$len = genlen($a_data['mp_id'],"_");
if($len=="2"){
?>
<input type="hidden" name="mp_id" id="mp_id"  value="<?php echo $a_data['mp_id'];?>" >
<li class="productCategoryLevel1 p-sm m-b-sm"  style="padding-bottom:20px;" id="<?php echo $a_data['mp_id'];?>">
&nbsp;
<span class="">
<i class="fa fa-ellipsis-v text-medium text-dark"></i>
</span>
<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?php echo $a_data['mp_id'];?>" value="<?php echo $a_data['mp_id'];?>">

<b style="word-break: break-all;"><?php echo $a_data['mp_name'];?> </b>
<span class="iconAction">
<button type="button" class="btn btn-info btn-sm "  >
<i class="fa fa-edit fa-1x text-white" aria-hidden="true"></i>
</button>
</a>
&nbsp;
<!--<i class="far fa-eye fa-1x text-dark" title="Disable"></i>
<input type="hidden" name="hiddenProductCategoryLevel1ID[]" value="2363">
<input type="hidden" name="hiddenStatus[]" value="1">
&nbsp;-->
<a href="" onClick="JQDel_Faq_Cate($('#mp_id'));" data-toggle="tooltip" data-placement="right" title="<?php echo "Delete FAQ Category";?>">
<button type="button" class="btn btn-danger btn-sm "  >
<i class="fas fa-trash-alt fa-1x text-white" aria-hidden="true"></i>
</button>
</a>

</span>
</li>
<?php } } }else{?>	
<li class="productCategoryLevel1" >
<p class="text-danger text-center"><?php echo $text_general_notfound;?></p>
</li>
		
<?php } ?>
</ul>
<?php sortableListsOpen*/ ?>
<input type="hidden" name="m_id" id="m_id"  value="<?php echo $m_id;?>" >
<ul class="sTree2 listsClass m-b-sm" id="sTree2" style="width: 100%;">
<?php
if($a_rows > 0){
while($a_data = $db->db_fetch_array($_sql)){	
		$len = genlen($a_data['mp_id'],"_");
		//$s_menu_p2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$a_data['m_id']}' AND mp_id LIKE '{$a_data['mp_id']}_%' ORDER BY mp_id ASC");
		$s_menu_p2 = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$a_data['m_id']}' AND mp_sub = '{$a_data['mp_pid']}'  ORDER BY mp_pos ASC");
		$a_row2 = $db->db_num_rows($s_menu_p2);
		if($a_row2){
			$open = 'class=" move"'; 
		}else{
			$open = 'class="move "';
		}
if($a_rows){ 
?>
<!--<div class="iconAction1">
&nbsp;
<button type="button" class="btn btn-default btn-circle btn-sm " onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_item.php?m_id=<?php echo $a_data['m_id'];?>&mp_pid=<?php echo $a_data['mp_pid'];?>');" data-toggle="tooltip" data-placement="top" title="Edit Submenu">
<i class="fas fa-cogs" aria-hidden="true"></i>
</button>
<a onClick="JQDel_item('<?php echo $a_data['mp_pid'];?>');" >
<button type="button" class="btn btn-danger btn-circle btn-sm " data-toggle="tooltip" data-placement="top" title="Delete Submenu" >
<i class="fas fa-trash-alt fa-1x text-white" aria-hidden="true"></i>
</button>
</a>
</div>-->



 
<span class="sortableListsOpener text-right float-right" style="display:inline-block;margin-left:1px;margin-right:5px;padding-top:8px;">
<?php
if(!chkMenuSub($a_data['mp_id'],$a_data['mp_pid']))
{
?> 

<button type="button" class="btn  btn-circle remove" onmousedown="JQDel_Item('<?php echo $a_data['mp_id'];?>','<?php echo $a_data['mp_pid'];?>');" data-toggle="tooltip" data-placement="left" title="Delete" >
<i class="fas fa-trash-alt " aria-hidden="true"></i>
</button>
 
<?php 
} 
?>
<button type="button" class="btn  btn-circle setting" onmousedown="boxPopup('<?php echo linkboxPopup();?>pop_edit_item.php?m_id=<?php echo $a_data['m_id'];?>&mp_pid=<?php echo $a_data['mp_pid'];?>');" _onclick="boxPopup('<?php //echo getLinkPopup('admin/pop_menu_edit_item','m_id='.$m_id.'&mp_pid='.$_item['mp_pid']);?>');" data-toggle="tooltip" data-placement="left" title="Edit">
<i class="fas fa-edit " aria-hidden="true" ></i>
</button>
</span>
<li id="<?php echo $a_data['mp_pid'];?>" data-value="<?php echo $a_data['mp_id'];?>"  <?php echo $open;?>  data-module="<?php echo $a_data['mp_id'];?>" >



<div class="text-dark" >
<img src="<?php echo $IMG_PATH ;?>images/grabme.svg">
<?php if(!empty($a_data['Oubgpic'])){ ?>
<i class="<?php echo $a_data['Oubgpic'];?> text-dark"></i>&nbsp;
<?php } ?>
<b style="word-break: break-all;"><?php echo $a_data['mp_name'];?></b>
</div>

<?php /*<input type="hidden" name="mp_id" id="mp_id_<?php echo $a_data['mp_id'];?>"  value="<?php echo $a_data['mp_id'];?>" >
<span class="iconAction1">
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_item.php?mp_id=<?php echo $a_data['mp_id'];?>');" data-toggle="tooltip" data-placement="right" title="<?php echo "";?>">					
<button type="button" class="btn btn-default btn-circle btn-sm"  >
<i class="fa fa-edit fa-1x text-dark" aria-hidden="true"></i>
</button>
</a>
&nbsp;
<!--<i class="far fa-eye fa-1x text-dark" title="Disable"></i>
<input type="hidden" name="hiddenProductCategoryLevel1ID[]" value="2363">
<input type="hidden" name="hiddenStatus[]" value="1">
&nbsp;-->
<a onClick="JQDel_Faq_Cate($('#mp_id'));" >
<button type="button" class="btn btn-default btn-circle btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo "Delete";?>" >
<i class="fas fa-trash-alt fa-1x text-dark" aria-hidden="true"></i>
</button>
</a>
</span>*/?>  
<?php echo menu_child1($a_data['m_id'],$a_data['mp_pid'],$len);?>  
</li>
<?php }}} ?>
</ul>

</div> 
<div class="card-body" id="loader" style="display:none;">	
	<div class="container_loader">
	<div class="circle_loader circle-1"></div>
	<div class="circle_loader circle-2"></div>
	<div class="circle_loader circle-3"></div>
	<div class="circle_loader circle-4"></div>
	<div class="circle_loader circle-0"></div> 
	</div> 	 
</div>	
<div class="card-body m-t-xxl text-right">
<?php /*<button onclick="boxPopup('<?php echo linkboxPopup();?>pop_view_form.php?com_fid=<?php echo $com_fid;?>');" type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_ewt_viewform;?>
</button>
*/?>
<button onclick="JQAdd_Menu_Sub($('#form_main'));" type="button" class="btn btn-success  btn-ml " >
<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save;?>
</button>
<button onclick="boxPopup('<?php echo linkboxPopup();?>pop_menu_view.php?m_id=<?php echo $m_id;?>');" type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?php echo 'View';?>
</button>
</div>


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
</div>

<?php
include("../EWT_ADMIN/combottom.php");
?>
<script src="../js/sortable-jQuery-lists/jquery-sortable-lists.js"></script>
<script type="text/javascript" src="../js/bootstrap-iconpicker/dist/js/bootstrap-iconpicker.bundle.min.js"></script>
<link rel="stylesheet" href="../js/bootstrap-iconpicker/dist/css/bootstrap-iconpicker.css"/>

<style>
<!--
#sTree2 li 
{
	list-style-type:none;
	color:#b5e853;
	}
#sTree2, #sTreePlus 
{ 
    padding-left:50px;
	padding:0; 
	background-color:#FFFFFF; 
	padding-bottom:100px;
	}
#sTree2 li, #sTreePlus li
{  
	padding-left:25px;
	padding-top:5px;
	padding-bottom:1px;
	_margin:5px; 
	margin-top:3px;
	margin-bottom:3px;
	border:1px solid rgba(22, 33, 74, 0.09);
	pointer-events: auto;
	/*background-color:#d3d3d3;*/
	}
#sTree2 li:hover 
{
    border: 2px dashed #8dcffd;
	}		
ul#sortableListsBase li 
{
	_padding-left:50px;
	_margin:5px; 
	_border:1px solid #cccccc;
	}
#sTree2 li div 
{
	padding:10px;
	/*background-color:#FFFFFF;*/
	}

#sTree2 li
{ 
	border-radius: 5px; 
	}
#sTree2 li ul
{	
	pointer-events: none;
	}
#sTree2, #sTreePlus 
{ 
	padding-top:20px;
	_margin:20px;
	}	
.c1 { color:#b5e853; }
.c2 { color:#63c0f5; }
.c3 { color: #f77720; }
.c4 { color: #888; }
.c5 { color: #666667; }
.c6 { color: #888; }

img.descPicture 
{
	display:block;
	width:100%;
	margin:0 7px 30px 0;
	float:left;
	cursor:pointer; 
	/*transition: all 0.5s ease;*/
	}
img.descPicture.descPictureClose 
{ 
	width:150px;
	}
.drop-placeholder-allo
{
	background-color:#90e593;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border-radius: 3px;
	border: 3px dotted #cccccc !important;
	margin-top: 10px;
	margin-bottom: 10px;
	}
.drop-placeholder  {
	background-color: rgba(240,243,244,1.0);
	height: 4.0em;
	border: 4px dotted #cccccc !important;
	border-radius: 3px;
	margin-top: 5px!important;
    box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
	-webkit-box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
	-moz-box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
}	
-->
</style>
<style> 
body {
  overflow: hidden;
}

.container_loader {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40vh;
  overflow: hidden;
}

.circle_loader {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  margin: 7px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.circle_loader:before {
  content: "";
  width: 20px;
  height: 20px;
  border-radius: 50%;
  opacity: 0.7;
  animation: scale 2s infinite cubic-bezier(0, 0, 0.49, 1.02);
}
.circle-1 {
  background-color: #49b8e5;
}
.circle-1:before {
  background-color: #49b8e5;
  animation-delay: 200ms;
}
.circle-2 {
  background-color: #1e98d4;
}
.circle-2:before {
  background-color: #1e98d4;
  animation-delay: 400ms;
}
.circle-3 {
  background-color: #2a92d0;
}
.circle-3:before {
  background-color: #2a92d0;
  animation-delay: 600ms;
}
.circle-4 {
  background-color: #3a88c8;
}
.circle-4:before {
  background-color: #3a88c8;
  animation-delay: 800ms;
}
.circle-0 {
  background-color: #507cbe; 
}
.circle-0:before {
  background-color: #507cbe;
  animation-delay: 1000ms;
}
@keyframes scale {
  0% {
    transform: scale(1);
  }
  50%, 75% {
    transform: scale(2.5);
  }
  78%, 100% {
    opacity: 0;
  }
}

</style>  
<script>
function JQAdd_Menu_Sub(form){

var fail = CKSubmitData(form);
if (fail == false) {	
	var action  = form.attr('action'); 
	var method  = form.attr('method'); 
	var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({
						title: '<?php echo "Setting Item Menu";?>',
						content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันการบันทึก',
									btnClass: 'btn-blue',
									action: function () {
										$.ajax({
											type: method,
											url: action,					
											data: formData ? formData : form.serialize(),
											async: true,
											processData: false,
											contentType: false,
											success: function (data) {												
												//console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: 'บันทึกข้อมูลเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														self.location.href="menu_list.php";
														//location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});
												//$("#frm_edit_s").load(location.href + " #frm_edit_s");
												//alert("Data Save: " + data);												
												//self.location.href="complain_builder.php?com_cid="+data;											
												//$('#box_popup').fadeOut();
												
											}
										});																										
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									//$('#box_popup').fadeOut(); 	
									}									
								}
							},                          
                            animation: 'scale',
                            type: 'blue'
						
						});
					} 
								
	
}

$(function  () {
	
$('#sTree2').hide(); 
$('#loader').show();   
	 
	$('#sTree2 li span').on( 'mousedown', function( e )
	{
	var target = $( e.target );
	var el = target.closest( 'li' ),rEl = $( this );
	console.log( rEl );	
	var li = $( this ).closest( 'li' );
		if ( li.hasClass( 'sortableListsClosed' ) )
		{
			console.log( li );
		}
		else
		{
			console.log( li );
		}
		return false; // Prevent default
	});
			/*var options = {
				currElClass: 'drop-placeholder',
				placeholderClass: 'drop-placeholder',
				listsClass:'',
				isAllowed: function(cEl, hint, target)
					{
						hint.css('background-color', '#99ff99');
						return true;
					}
			};*/			
var options = {
		ignoreClass: 'clickable',
		revert: true,
		cursor: 'move',
		insertZonePlus: true,
		insertZone: 50,
	    scroll: 20,
		currElClass: 'drop-placeholder',
		placeholderClass: 'drop-placeholder',
		/*insertZonePlus: true,
	    scroll: 50,
		currElClass: 'drop-placeholder',
		placeholderClass: 'drop-placeholder',*/
		//placeholderCss: {'background-color':'yellow'},
		//hintCss: {'background-color':'#bbf'},
        //onChange: function( cEl )
        //{
            //console.log( 'onChange' );
        //},
        complete: function( cEl ) 
        {
            //console.log( 'complete' );
			//console.log($('#sTree2').sortableListsToArray());
			//var page_id_array = new Array();
			//$('#sTree2 li').each(function(){
				//page_id_array.push($(this).attr("id"));
			//});
			
			var m_id = $('#m_id').val();
			var page_id_array = $('#sTree2').sortableListsToArray();
			//console.log(page_id_array);	
									$.ajax({
											type: 'POST',
											url: 'func_sortable_menu.php',											
											data:{proc:'Sortable_Edit',page_id_array:page_id_array,m_id:m_id},
											
											beforeSend: function() {
												$('#sTree2').hide(); 
												$('#loader').show();   
											},																
											success: function (data) {																											
												//alert('Data Exported Successfully!'); 
												//console.log(data);
												setTimeout(function () { 
													//$('.circle_loader').hide(); 	
													location.reload(true)
													//$('#sTree2').fadeIn();
												}, 1000);
												//console.log(data);	
												//location.reload(true);																							
												//$("#frm_edit_s").load(location.href + " #frm_load");												
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												//document.location.reload();
											}
										});	
			
			//console.log($('#sTree2').sortableListsToHierarchy());
			//console.log($('#sTree2').sortableListsToString());
        },
		/*isAllowed: function( cEl, hint, target )
		{
			// Be carefull if you test some ul/ol elements here.
			// Sometimes ul/ols are dynamically generated and so they have not some attributes as natural ul/ols.
			// Be careful also if the hint is not visible. It has only display none so it is at the previouse place where it was before(excluding first moves before showing).
			if( target.data('module') === 'c' && cEl.data('module') !== 'c' )
			{
				hint.css('background-color', '#ff9999');
				return false;
			}
			else
			{
				//hint.css('background-color', '#99ff99');
				return true;
			}
		},*/
		isAllowed: function(cEl, hint, target)
					{
						//hint.class('drop-placeholder');
						//hint.css('background-color', '#99ff99');
						hint.css('background-color','#46b8da');
						hint.css('height','3.5em');
						hint.css('padding-top','12px');
						hint.css('padding-bottom','12px');
						hint.css('border-radius','3px');
						hint.css('border','1px solid  #3295d3');
						hint.css('margin-top','10px');
						hint.css('margin-bottom','10px');
						return true;
					},
		opener: {
            active: true,
            as: 'html',  // if as is not set plugin uses background image
            close: '<i class="fas fa-minus-square pointer c3"></i>',  // or 'fa-minus c3',  // or './imgs/Remove2.png',
            open: '<i class="fas fa-plus-square pointer"></i>',  // or 'fa-plus',  // or'./imgs/Add2.png',
            openerCss: {
                'display': 'inline-block',
                //'width': '18px', 'height': '18px',
                'float': 'left',
                'margin-left': '-25px',
                'margin-right': '10px',
                'background-position': 'center center', 
				'background-repeat': 'no-repeat',
                'font-size': '1.0em'
            }
		}
		
	};

$('#sTree2').sortableLists(options);

			//console.log($('#sTree2').sortableListsToArray());
			//console.log($('#sTree2').sortableListsToHierarchy());
			//console.log($('#sTree2').sortableListsToString());
			
	setTimeout(function () { 
		$('#loader').hide(); 
		$('#sTree2').show(); 	
	}, 1200);		 
});

function JQDel_Item(mid,mpid)
{
			 var url = "func_del_menu.php";
			 //alert(url);
					$.confirm({
						title: 'ลบข้อมูล',
						content: 'คุณต้องการลบรายการนี้หรือไม่?',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: 'ยืนยันลบข้อมูล',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'POST',
											url: url,
											data:{proc:'DelItem',m_id:mid,mp_pid:mpid},			
											success: function (data) {
												
												$.alert({
													title: '',
													theme: 'modern',
													content: 'ลบเมนูย่อยเรียบร้อย',
													boxWidth: '30%',
													onAction: function () {
														location.reload(true);			
														$('#box_popup').fadeOut();
														}
													});
																																		
											}
										});	
										
									}														
								},
								cancel: {
									text: 'ยกเลิก'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'						
						});
	}
	
function JQDel_Menu(m_id){

	$.confirm({
		title: 'ลบเมนู',
		content: 'คุณต้องการลบเมนูหรือไม่?',
		boxWidth: '30%',
		icon: 'fas fa-exclamation-circle',
		theme: 'modern',
		buttons: {
			confirm: {
				text: 'ยืนยันการลบ',
				btnClass: 'btn-warning',
				action: function () {
					$.ajax({
						type: 'POST',
						url: "func_del_menu.php",					
						data: {m_id:m_id,proc:"DelMenu"},
						success: function (data) {

							$.alert({
								title: '',
								theme: 'modern',
								content: 'ลบเมนูเรียบร้อย',
								boxWidth: '30%',
								onAction: function () {
									location.reload(true);			
									$('#box_popup').fadeOut();
								}
							});
																
							$('#box_popup').fadeOut();
						}
					});																										
				}								
			
			},
			cancel: {
				text: 'ยกเลิก'
													
			}
		},                          
		animation: 'scale',
		type: 'orange'
						
	});
}	
</script>