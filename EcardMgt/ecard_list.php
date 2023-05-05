<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid"  >
<?php
include("menu-top.php"); 
?>
<div class="row m-b-sm">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
<!--start card -->
<div class="card">
<!--start card-header -->
<div class="card-header">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

<h4><?php echo 'การ์ดอวยพร';?></h4>
<p></p> 

</div>
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><a href="ecard_list.php"><?php echo 'การ์ดอวยพร';?></a></li>
<li class=""></li>       
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  

<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_ecard_list.php');">
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo 'เพิ่มการ์ดอวยพร';?>
</button> 

<!--<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php //echo linkboxPopup();?>pop_add_calendar.php?cal_cid=<?php //echo $cal_cid;?>');" title="<?php //echo $txt_calendar_add;?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php //echo $txt_calendar_add;?>
</button>

<button type="button" class="btn btn-info  btn-ml " onclick="boxPopup('<?php //echo linkboxPopup();?>pop_search_calendar.php');" title="<?php //echo $txt_calendar_search;?>" >
<i class="fas fa-search"></i>&nbsp;<?php //echo $txt_calendar_search;?>
</button>-->


</div>

<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  > 
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right pointer">
            <li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_calendar_group.php?cal_cid=<?php echo $cal_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_calendar_add_cate;?></a></li>
			<li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_calendar.php?cal_cid=<?php echo $cal_cid;?>');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_calendar_add;?></a></li>
          	<li><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search_banner.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_calendar_search;?></a></li>
			<li><a href="banner_group.php" target="_self" ><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back;?></a></li>
		</ul>
</div>
</div>	
</div>
</div>
</div>
<!--END card-header -->

<!--start card-body -->
<div class="card-body">
<div class="row ">
<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >
 <div class="row active-with-click">
<?php
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;
$wh = '';
$_sql = $db->query("SELECT * FROM ecard_list WHERE 1=1 {$wh} ORDER BY ec_id DESC LIMIT {$start} , {$perpage}"); 

$statement = "SELECT count(ec_id) AS b
			  FROM ecard_list 
			  WHERE 1=1
			  {$wh} 
			 ";			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage); 
$i = 0;
$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/assets/images/ecard/";
if($a_rows > 0)
{
	while($a_data = $db->db_fetch_array($_sql))
	{	
		if($a_data['ec_filename'])
		{
			$a_data['ec_filename'] = $dir_base.$a_data['ec_filename'];
		}
		else
		{
			$a_data['ec_filename'] = '../EWT_ADMIN/images/user001.png';    
		}
?>
	
        <div class="col-md-3 col-sm-3 col-xs-12">
            <article class="material-card Purple">
                <h2>
                    <span><?php echo $a_data['ec_name'];?></span>
                    <!--<strong>
                        <i class="fa fa-fw fa-star"></i>
                        The Deer Hunter
                    </strong>-->
                </h2>
                <div class="mc-content">
                    <div class="img-container">
                        <img class="img-responsive" src="<?php echo $a_data['ec_filename'];?>">
                    </div>
                    <div class="mc-description">
						<?php echo $a_data['ec_detail'];?>
                    </div>
                </div>
                <a class="mc-btn-action">
                    <i class="fa fa-bars" ></i>
                </a>
                <div class="mc-footer"> 
				<a onclick="boxPopup('<?php echo linkboxPopup();?>pop_view_ecard_list.php?ec_id=<?php echo $a_data['ec_id'];?>');"  > 
				<button type="button" class="btn btn-info  btn-circle btn-sm"  data-toggle="tooltip" data-placement="top" title="<?php echo 'View';?>" >
				<i class="fas fa-search"></i> 
				</button> 
				</a>
				<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_ecard_list.php?ec_id=<?php echo $a_data['ec_id'];?>')" > 
				<button type="button" class="btn btn-warning  btn-circle btn-sm"  data-toggle="tooltip" data-placement="top" title="<?php echo 'แก้ไขการ์ดอวยพร';?>" >
				<i class="fas fa-fw fa-edit" aria-hidden="true"></i> 
				</button> 
				</a>	
				<a onClick="JQDel_ECard('<?php echo $a_data['ec_id'];?>');"> 
				<button type="button" class="btn btn-danger  btn-circle btn-sm"  data-toggle="tooltip" data-placement="top" title="<?php echo 'ลบการ์ดอวยพร';?>" >
				<i class="fas fa-fw fa-trash-alt " aria-hidden="true"></i> 
				</button>
				</a>
                </div>
            </article>
        </div>
<?php 
	$i++;
	} 	
}
else
	{
?><div class="panel-group" id="accordion"> 
       <div class="panel panel-default ">
            <div class="panel-heading text-center">
                <h4 class="panel-title">
                   <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
                </h4>
            </div>
        </div>
	</div>	
<?php } ?>			
		
		
 </div> 
 
</div>
</div> 
 
</div>
<!--END card-body-->
</div>
<!--END card-->

</div>

</div>
</div>
<!-- END CONTAINER  --> 
<?php
include("../EWT_ADMIN/combottom.php");
?>
<link rel="stylesheet" href="../js/jQuery-Cards/dist/material-cards.css">      
<script>
    $(function() {
        $('.material-card > .mc-btn-action').click(function () {
            var card = $(this).parent('.material-card');
            var icon = $(this).children('i');
            icon.addClass('fa-spin-fast');

            if (card.hasClass('mc-active')) {
                card.removeClass('mc-active');

                window.setTimeout(function() {
                    icon
                        .removeClass('fa-arrow-left')
                        .removeClass('fa-spin-fast')
                        .addClass('fa-bars');

                }, 800);
            } else {
                card.addClass('mc-active');

                window.setTimeout(function() {
                    icon
                        .removeClass('fa-bars')
                        .removeClass('fa-spin-fast')
                        .addClass('fa-arrow-left');

                }, 800);
            }
        });
    });
	
	 
	function JQDel_ECard(id){
					 
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
											url: 'func_del_ecard_list.php',
											data:{'id': id,'proc':'DelEcardList'},
											success: function (data) {
												
												$.alert({
													title: 'บันทึกข้อมูลเรียบร้อย', 
													theme: 'modern',
													icon: 'far fa-check-circle',
													content: 'Success! ',
													type: 'green',
													typeAnimated: true,
													boxWidth: '30%',	
													buttons: {
														ok: {
															btnClass: 'btn-green'
															}     
														},
													onAction: function () {
														//self.location.href="complain_builder.php?com_cid=6";	
														location.reload(true);			
														$('#box_popup').fadeOut();
													}		
												});		
												
													
											}
										});											
																								
									}								
							
								},
								cancel: {
									text: 'ยกเลิก',
									action: function () {
									setTimeout(function () { 
													$('#loader').fadeOut();	
												}, 500); 
									}					
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
	}
</script>
<style>
<!--
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
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}
-->
</style>  