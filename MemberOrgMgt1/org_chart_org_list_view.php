<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");
$db->query("USE ".$EWT_DB_USER);

$omc_type = (!isset($_GET['omc_type']) ? 'genuser' : $_GET['omc_type']);
$org_id   = (int)(!isset($_GET['org_id']) ? '' : $_GET['org_id']);

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$s_sql = $db->query("SELECT * FROM `org_name` WHERE parent_org_id LIKE '0001_%' ORDER BY org_order ASC,org_id ASC LIMIT {$start} , {$perpage}");
										
$statement = "SELECT count(org_id) AS b 
			  FROM `org_name` 
              WHERE parent_org_id LIKE '0001_%' ";
$i = 1;			  
$a_rows  = $db->db_num_rows($s_sql);		
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

<h4><?=$txt_org_chart_org_list;?> <?=org::getOrg($org_id);?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="org_dashboard.php"><?=$txt_org_menu_main;?></a></li>
<li><a href="org_chart.php"><?=$txt_org_menu_chart;?></a></li> 
<li><a href="org_chart_org_list.php"><?=$txt_org_chart_org_list;?></a></li>  
<li class=""><?=org::getOrg($org_id);?></li>  

</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	

<a href="org_chart_org_list.php"  target="_self" >
<button type="button" class="btn btn-info  btn-sm " >
<i class="fas fa-undo-alt"></i>&nbsp;<?=$txt_ewt_back;?>
</button>
</a>
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
		<li><a href="org_chart_org_list.php" target="_self" ><i class="fas fa-plus-circle"></i>&nbsp;<?=$txt_ewt_back;?></a></li>
		</ul>	
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->

<div class="card-body" >

<div class="row ">
<div class="col-md-4 col-sm-4 col-xs-12"  >
<div class="card ">
<div class="card-header ewt-bg-color m-b-sm" >
<div class="card-title  color-white">
<i class="fas fa-sitemap color-white fa-1x"></i> <span class="text-medium"><?=$txt_org_chart_org_list;?></span>

</div>
</div>
<div class="card-body  m-b-sm">
<span class="text-right">
<a onClick="boxPopup('<?=linkboxPopup();?>pop_add_user_org_chart_list.php?org_id=<?=$org_id;?>&omc_type=<?=$omc_type;?>');" >
<button type="button" class="btn btn-success  btn-md btn-block" data-toggle="tooltip" data-placement="top"   title="<?=$txt_org_chart_org_list;?>"  >
<i class="fas fa-plus color-white "></i><b class="text-white"> <?=$txt_org_chart_user_add;?></b>
</button>
</a>
</span>
<? /*<ul id="sortableLv1" class="sortableLv1  " style="width: 100%;">
<?php
$s_sql_user = $db->query("SELECT *
						  FROM `gen_user`
						  LEFT JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
		                  LEFT JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
		                  LEFT JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
		                  WHERE `gen_user`.`org_id` = '{$org_id}' ");	
$a_rows  = $db->db_num_rows($s_sql_user);

$path_image = $a_data['path_image'];
$uploaddir 	= "../ewt/pic_upload/";
if($path_image != ''){
	$path_image22 = $uploaddir.$path_image;
	if(file_exists($path_image22)){
		$path_image2 = $path_image22;
		}else{
		$path_image2 = "../images/ImageFile.gif";
			}
	}else{
	$path_image2 = "../images/ImageFile.gif";
	}
	
if($a_rows > 0){
$i = 0;
while($a_data = $db->db_fetch_array($s_sql_user)){
?>	
<li class="productCategoryLevel1 ui-state-disabled text-dark"  >
&nbsp;
<input type="hidden" name="gen_user_id[]" id="gen_user_id<?=$a_data['gen_user_id'];?>" value="<?=$a_data['gen_user_id'];?>">
<i class="fas fa-user text-dark"></i>
&nbsp;<?=org::getTitle($a_data['title_thai']).''.$a_data['name_thai'].' '.$a_data['surname_thai'];?>
</li>
<?php $i++;} }else{ ?>
	<li class="productCategoryLevel1 ui-state-disabled text-center "  >
	<p class="text-danger"><?=$txt_ewt_data_not_found;?></p>
	</li>
<?php } ?>		
	
</ul>*/ ?>
<input type="hidden" name="omc_uid" id="omc_uid"  value="<?=$_SESSION['EWT_SUID'];?>">
<input type="hidden" name="omc_type" id="omc_type"  value="<?=$omc_type;?>" >
<input type="hidden" name="org_id" id="org_id"  value="<?=$org_id;?>" >
<?php
if(org::genUserTop($org_id,$_SESSION['EWT_SUID'])){ 
?>
<ul id="sortableLv1-form" class="sortableLv1 m-t-sm " style="width: 100%;">
<li class="productCategoryLevel1 ui-state-disabled text-dark"  >
<b class="color-ewt">
<?=org::genUserTop($org_id,$_SESSION['EWT_SUID']);?>
</b>
</li>
</ul>
<?php } ?>
<ul class="sTree2 listsClass m-b-sm" id="sTree2" style="width: 100%;">
<?php
function omc_child($omc_org_id,$omc_uid,$omc_name,$l){
	global $db,$EWT_DB_USER ;
	
$s_sql_omc = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$omc_org_id}' AND  omc_uid = '{$omc_uid}' AND omc_name_sub = '{$omc_name}'  ORDER BY omc_order ASC ");
$a_rows = $db->db_num_rows($s_sql_omc);	

if($a_rows > 0){
$txt = "";
$txt .='<ul  >'.PHP_EOL;
$len = $l+1;
while($a_data = $db->db_fetch_array($s_sql_omc)){

		$s_menu_p2 = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$omc_org_id}' AND  omc_uid = '{$omc_uid}' AND omc_name_sub = '{$omc_name}'  ORDER BY omc_order ASC");
		$a_row2 = $db->db_num_rows($s_menu_p2);
	
		if($a_row2){
			$open = 'class="sortableListsOpen move m-b-sm "';
		}else{
			$open = 'class="move"';
		}
if($a_rows > 0){

	$txt .='<li id="'.$a_data['omc_name'].'"  data-value="'.$len.'"  '.$open.' data-module="'.$omc_name.'">';
	$txt .='<div >';	
	$txt .='<b style="word-break: break-all;" class="text-dark"><img src="'.org::getGenUserImg($a_data['omc_name']).'" alt="" class="img-circle img-rounded " style="width:24px;height:24px;" /> :: '.org::getGenUser($a_data['omc_name']).'</b></div>';
	$txt .= omc_child($omc_org_id,$omc_uid,$a_data['omc_name'],$len);
	$txt .="</li>".PHP_EOL;
	}else{
		$txt .='<li id="'.$a_data['omc_name'].'" data-value="'.$a_data['omc_name'].'" '.$open.' data-module="'.$omc_name.'">';
		$txt .='<div class="text-dark" >';	
	    $txt .='<b style="word-break: break-all;">:: '.org::getGenUser($a_data['omc_name']).'</b></div>';
		$txt .='</li>'.PHP_EOL;
		}			
		
	}
$txt .="</ul>".PHP_EOL;
	}
	return $txt;
}


$s_sql_omc = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$org_id}' AND  omc_uid = '{$_SESSION['EWT_SUID']}' AND omc_name_sub = '0'  ORDER BY omc_order ASC ");
$a_rows = $db->db_num_rows($s_sql_omc);	
if($a_rows > 0){
while($a_data = $db->db_fetch_array($s_sql_omc)){	
		
		$s_menu_p2 = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$org_id}' AND  omc_uid = '{$_SESSION['EWT_SUID']}' AND omc_name_sub = '{$a_data['omc_name']}'  ORDER BY omc_order ASC");
		$a_rows2 = $db->db_num_rows($s_menu_p2);
		if($a_data['omc_order'] == 0 && $a_data['omc_name_sub'] == 0 && $a_data['omc_leval'] == 0){
			$disabled = 'ui-state-disabled disabled';
			}else{
			$disabled = '';
			}
		if($a_rows2){
			$open = 'class="sortableListsOpen move m-b-sm '.$disabled.' "';
			}else{
				$open = 'class="move m-b-sm '.$disabled.' "';
			}
	
if($a_rows){
	if($a_data['omc_leval'] != '0'){
?>
<li id="<?=$a_data['omc_name'];?>" data-value="1"  <?=$open;?>  data-module="<?=$a_data['omc_name'];?>" >
<div  >
<b style="word-break: break-all;"  class="text-dark" ><img src="<?=org::getGenUserImg($a_data['omc_name']);?>" alt="" class="img-circle img-rounded " style="width:24px;height:24px;" /> :: <?=org::getGenUser($a_data['omc_name']);?></b>
</div>
<?=omc_child($a_data['omc_org_id'],$a_data['omc_uid'],$a_data['omc_name'],'1');?>
</li>
<?php 
}
	}
		} 
			} 
?>
</ul>

</div>
</div>
</div>
<div class="col-md-8 col-sm-8 col-xs-12"  >

<div id="tree" class="tree"></div>
<div id="container"></div>

</div>
</div>

</div>
</div>
</div>
</div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE ".$EWT_DB_NAME);
include("../EWT_ADMIN/combottom.php");
?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/sankey.js"></script>
<script src="https://code.highcharts.com/modules/organization.js"></script>

<script src="../js/sortable-jQuery-lists/jquery-sortable-lists.js"></script>
<script src="https://balkangraph.com/js/latest/OrgChart.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
h4{
	font-size:14px;
}
.unselectable {
  user-drag: none; 
  user-select: none;
  -moz-user-select: none;
  -webkit-user-drag: none;
  -webkit-user-select: none;
  -ms-user-select: none;
}

ul.sTree2, #sTree2 li {
	list-style-type:none;
	_color:rgba(255,193,83,1.0);
	/*border:1px solid #d3d3d3;*/
}

ul.sTree2, #sTree2, #sTreePlus { 
    padding-left:50px;
	padding:0; 
	background-color:#FFFFFF; 
	padding-bottom:40px;
}

#sTree2 li, #sTreePlus li, ul#sortableListsBase li {
	padding-left:40px;
	margin:5px; 
	border:1px solid #d3d3d3;
	/*background-color:#d3d3d3;*/
}

#sTree2 li div {
	padding:10px;
	/*background-color:#FFFFFF;*/
}

#sTree2 li, ul, div { 
	border-radius: 3px; 
	}
	
.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
.faqHeader {
    font-size: 27px;
    margin: 20px;
}
.panel-heading [data-toggle="collapse"]:after {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
    content: "\f105"; /* "play" icon */
    float: right;
    color: #FFC153;
    font-size: 24px;
    line-height: 22px;
    /* rotate "play" icon from > (right arrow) to down arrow */
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -ms-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    transform: rotate(-90deg);
}
.panel-heading [data-toggle="collapse"].collapsed:after {
     /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
     -webkit-transform: rotate(90deg);
     -moz-transform: rotate(90deg);
     -ms-transform: rotate(90deg);
     -o-transform: rotate(90deg);
     transform: rotate(90deg);
     color: #454444;
}

</style>

<?php
$db->query("USE ".$EWT_DB_USER);
$s_sql_chart  = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$org_id}' AND  omc_uid = '{$_SESSION['EWT_SUID']}' AND omc_type = '{$omc_type}' ORDER BY omc_leval ASC ,omc_order ASC ");
$a_rows_chart = $db->db_num_rows($s_sql_chart);	

$s_sql_chart1  = $db->query("SELECT * FROM org_map_chart WHERE omc_org_id = '{$org_id}' AND  omc_uid = '{$_SESSION['EWT_SUID']}' AND omc_type = '{$omc_type}' ORDER BY omc_leval ASC ,omc_order ASC ");
$a_rows_chart1 = $db->db_num_rows($s_sql_chart1);	
?>

<script>
 
/*indow.onload = function () {
//OrgChart.templates.ana.field_0 = '<text   width="230" text-overflow="ellipsis" style="font-size: 12px;" fill="#ffffff" x="125" y="65" text-anchor="middle" >{val}</text>';
//OrgChart.templates.ana.html = '<foreignobject class="node" style="font-size: 20px;color:#ffffff;" x="20" y="10" width="200" height="100" >{val}</foreignobject>';   
	
	var chart = new OrgChart(document.getElementById("tree"), {
		  toolbar: {
                layout: false,
                zoom: true,
                fit: false,
                expandAll: false
            },
		  //template: "diva",
		  enableDragDrop: true,
          enableSearch: false,
		  scaleInitial: 0.6,
          //mouseScrool: OrgChart.action.none,
		  //showXScroll: OrgChart.scroll.visible,
		  orderBy: "orderId",
		  //scaleMax: 10,	  
          nodeBinding: {
                field_0: "name",
                field_1: "title",
                img_0: "img"
          },
		nodes: [
		    { id: 1, orderId: 1, name: "Teerapong ", title: "เจ้าหน้าที่พนักงานบัญชี" ,img: "https://balkangraph.com/js/img/6.jpg"  },
			{ id: 2, pid: 1, orderId: 3, name: "Teerapong11 ", title: "เจ้าหน้าที่พนักงานบัญชี" ,img: "https://balkangraph.com/js/img/6.jpg" },
			{ id: 3, pid: 1, orderId: 2, name: "Teerapong1", title: "เจ้าหน้าที่พนักงานบัญชี" ,img: "https://balkangraph.com/js/img/6.jpg"  },
			{ id: 4, pid: 1, orderId: 2, name: "Teerapong1", title: "เจ้าหน้าที่พนักงานบัญชี" ,img: "https://balkangraph.com/js/img/6.jpg"  }
			]	
         
		  /*onUpdate: function (sender, oldNode, newNode) {	
				 console.log(sender);
				 console.log(newNode);

									$.ajax({
											type: 'POST',
											url: 'func_update_org_chart.php',											
											data:{proc:'Chart_Edit',page:newNode},
											success: function (data) {	
												//var Newdata= JSON.stringify(eval("("+data+")"));
												//var Obj = jQuery.parseJSON(Newdata);											
												console.log(data);	
												
												//location.reload(true);																							
					
											}
										});	
										
			},*
		});
        
	   
		/*chart.load([{ id: 1, orderId: 1, name: "Teerapong ", title: "เจ้าหน้าที่พนักงานบัญชี" ,img: "https://balkangraph.com/js/img/6.jpg"  },
					{ id: 2, pid: 1, orderId: 3, name: "Teerapong ", title: "เจ้าหน้าที่พนักงานบัญชี" ,img: "https://balkangraph.com/js/img/6.jpg" },
					{ id: 3, pid: 1, orderId: 2, name: "Teerapong1", title: "เจ้าหน้าที่พนักงานบัญชี" ,img: "https://balkangraph.com/js/img/6.jpg"  } ]);*
};*/

Highcharts.theme = {
    chart: {
        backgroundColor: null,
        style: {
            //fontFamily: 'Prompt, sans-serif',
			fontSize: '16px'
        }
    },
    title: {
        style: {
			fontFamily: 'Prompt, sans-serif',
            fontSize: '16px',
            fontWeight: 'bold',
            textTransform: 'uppercase'
        }
    },
    tooltip: {
        borderWidth: 0,
		style: {
			fontFamily: 'Prompt, sans-serif',
            fontSize: '11px',
            fontWeight: 'bold',
            textTransform: 'uppercase'
        }
    }
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);

Highcharts.chart('container', {
    chart: {
		height: '100%',
		inverted: true
    },
    title: {
        text: '<?=org::getOrg($org_id);?>'
    },
    series: [{
        type: 'organization',
        name: '<?=org::getOrg($org_id);?>',
        keys: ['from', 'to'],
        data: [
<?php 
if($a_rows_chart > 0){
	$i = 0;
	while($a_data_chart = $db->db_fetch_array($s_sql_chart)){	
		if($i > 0){
			if($a_data_chart['omc_leval'] == 0){ ?>		
            ['0', '<?=$a_data_chart[omc_name];?>'],
			<?php }else{ ?>	
			['<?=$a_data_chart[omc_name_sub];?>','<?=$a_data_chart[omc_name];?>'],
			<?php } } $i++;} }  ?>			
        ], 
		
        nodes: [
<?php 
	if($a_rows_chart1 > 0){
		while($a_data_chart1 = $db->db_fetch_array($s_sql_chart1)){	
			if($a_data_chart1['omc_leval'] == 0){ ?>		
			{
            id: '0',
            title: '',
            name: '<p class="pointer" onClick="boxPopup(\'<?=linkboxPopup();?>pop_view_org_list.php?u_id=<?=$a_data_chart1[omc_name];?>\');" ><?=org::getGenUser($a_data_chart1[omc_name]);?></p>',
			color: '#007ad0',
			dataLabels: {
				color: 'white'
			},
			borderColor: '#007ad0',
            image: '<?=org::getGenUserImg($a_data_chart1[omc_name]);?>'                   			
			},
			<?php }else{ ?>	
			{
            id: '<?=$a_data_chart1[omc_name];?>',
            title: '',
            name: '<p class="pointer" onClick="boxPopup(\'<?=linkboxPopup();?>pop_view_org_list.php?u_id=<?=$a_data_chart1[omc_name];?>\');" ><?=org::getGenUser($a_data_chart1[omc_name]);?></p>',
			color: '#007ad0',
			dataLabels: {
				color: 'white'
			},
			<?php 
			if($a_data_chart1['omc_leval'] == 1){
			?>
			//layout: 'hanging',
			//column: 4,
			<?php 
			}
			if($a_data_chart1['omc_leval'] > 1){
			?>		
			//layout: 'hanging',
			<?php } ?>
            image: '<?=org::getGenUserImg($a_data_chart1[omc_name]);?>',                   						
			},		
	   <?php } } }  ?>	
		],		
        colorByPoint: false,
        //color: '#007ad0',
		color: 'white',
        dataLabels: {
            color: '#000000'
        },
        borderColor: '#cccccc',
        nodeWidth: 80
    }],
		tooltip: {
			outside: true
    },
		/*exporting: {
			allowHTML: false,
			sourceWidth: 800,
			sourceHeight: 600
    }*/
});

$(function  () {			
	var options = {
		insertZonePlus: true,
	    scroll: 20,
		currElClass: 'drop-placeholder',
		placeholderClass: 'drop-placeholder',		
		//placeholderCss: {'background-color':'yellow'},
		//hintCss: {'background-color':'#bbf'},
        onChange: function( cEl )
        {	 
			console.log( 'onChange' );

        },
		onDragStart: function(e, el)
		{
			
		},
        complete: function( cEl )
        {
            console.log( 'complete' );
			
			var org_id 		=	$('#org_id').val();
			var omc_type 	= 	$('#omc_type').val();
			var omc_uid 	= 	$('#omc_uid').val();
			var page_id_array 		= 	$('#sTree2').sortableListsToArray();
			var ListsToHierarchy 	= 	$('#sTree2').sortableListsToHierarchy();
			//console.log(page_id_array);	
									$.ajax({
											type: 'POST',
											url: 'func_sortable_org_chart_list.php',											
											data:{proc:'Sortable_Edit',ListsToHierarchy:ListsToHierarchy,page_id_array:page_id_array,org_id:org_id,omc_type:omc_type,omc_uid:omc_uid},
											success: function (data) {												
											//console.log(data);	
											location.reload(true);
											
											}
										});	
        },
		isAllowed: function(cEl, hint, target)
					{
						//hint.class('drop-placeholder');
						hint.css('background-color', '#99ff99');
						return true;
					},
		opener: {
            active: true,
            as: 'html',  // if as is not set plugin uses background image
            close: '<i class="fas fa-minus-square pointer text-danger c3"></i>',  // or 'fa-minus c3',  // or './imgs/Remove2.png',
            open: '<i class="fas fa-plus-square pointer text-success"></i>',  // or 'fa-plus',  // or'./imgs/Add2.png',
            openerCss: {
                'display': 'inline-block',
                //'width': '18px', 'height': '18px',
                'float': 'left',
                'margin-left': '-35px',
                'margin-right': '30px',
                'background-position': 'center center', 
				'background-repeat': 'no-repeat',
                'font-size': '1.2em'
            },
			//openerClass: 'yourClassName'
		},
		ignoreClass: 'clickable'
	};
	
$('#sTree2').sortableLists(options);
			//console.log($('#sTree2').sortableListsToArray());
			//console.log($('#sTree2').sortableListsToHierarchy());
			//console.log($('#sTree2').sortableListsToString());
	});


/*$(function  () {
	$("#sortableLv1").sortable({
	placeholder: 'drop-placeholder',
	update: function (event, ui) {									
		var page_id_array = new Array();
			$('#sortableLv1 div.panel').each(function(){
				page_id_array.push($(this).attr("id"));
			});	
			console.log(page_id_array);			
									$.ajax({
											type: 'POST',
											url: 'func_sortable_org_group.php',											
											data:{proc:'Sortable_Edit',page_id_array:page_id_array,start:'<?=$start;?>'},
											success: function (data) {	
												var Newdata= JSON.stringify(eval("("+data+")"));
												var Obj = jQuery.parseJSON(Newdata);											
												console.log(Obj.message);
												
												location.reload(true);																							
												//$("#frm_edit_s").load(location.href + " #frm_load");												
												//alert("Data Save: " + data);												
												//self.location.href="article_list.php?cid="+data;											
												//$('#box_popup').fadeOut();
												//document.location.reload();
											}
										});	
										
		}		
	});
});*/

function JQDel_Org_Group(id){
					$.confirm({
						title: '<?=$txt_ewt_confirm_del_title;?>',
						content: '<?=$txt_ewt_confirm_del_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?=$txt_ewt_confirm_del;?>',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_org_group.php',
											data:{'id': id,'proc':'DelOrgGroup'},
											success: function (data) {
												$.alert({
													title: '<?=$txt_ewt_action_del_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: '<?=$txt_ewt_submit;?>',
									 							btnClass: 'btn-blue',
																action: function () {	
																location.reload();	
																}
														  }													     
													}
																						
												});
													
											}
										});											
										//FuncDelete(id);											
										//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
									}								
							
								},
								cancel: {
									text: '<?=$txt_ewt_cancel;?>'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}
</script>	