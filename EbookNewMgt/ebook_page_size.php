<?php
include("../EWT_ADMIN/comtop.php");

?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
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
<h4><?php echo $txt_ebook_menu_page_size;?></h4>
<p></p> 
</div>


<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >
<div class="col-md-12 col-sm-12 col-xs-12" >
<ol class="breadcrumb">
<li><?php echo $txt_ebook_menu_page_size;?></li> 
<li></li> 
</ol>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >	  
<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_ebook_page_size.php');"   target="_self">
<button type="button" class="btn btn-info  btn-ml"  title="<?php echo $txt_ebook_page_size_add;?>" >
<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_ebook_page_size_add;?>
</button>
</a>

<a  target="_self" onclick="boxPopup('<?php echo linkboxPopup();?>pop_search_page.php');" >   
<button type="button" class="btn btn-info  btn-ml"  title="<?php echo $txt_ebook_search_page;?>"  >
<i class="fas fa-search"></i>&nbsp;<?php echo $txt_ebook_search_page ;?>
</button>
</a>

</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
<div class="btn-group ">
        <button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right pointer">
		<li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_add_ebook_page_size.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_ebook_page_size_add;?></a></li>
        <li class=""><a onClick="boxPopup('<?php echo linkboxPopup();?>pop_search_page.php');" ><i class="fas fa-search"></i>&nbsp;<?php echo $txt_ebook_search_page;?></a></li>
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
<div class="panel-group" id="accordion">
<?php
$wh = '';
if(!empty($_GET['text']))
{
 	
	$wh .= " AND ( ebook_info.ebook_name  LIKE '%".$_GET['text']."%' ) ";
	
} 
 
$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;

$_sql = $db->query("SELECT * 
					FROM ebook_preset
					WHERE 1=1 {$wh} ORDER BY ebook_preset_id DESC LIMIT {$start} , {$perpage} ");

$statement = "	SELECT count(ebook_preset_id) AS b
				FROM ebook_preset	  
				WHERE 1=1
				{$wh} "; 
			  
$a_rows = $db->db_num_rows($_sql);		
$s_count = $db->query($statement);
$a_count = $db->db_fetch_array($s_count);
$total_record = $a_count['b'];
$total_page = (int)ceil($total_record / $perpage);

if($start==0){
$i=1;
}else{
$i=$start+1;	
}
	
if($a_rows)
{	
while($a_data = $db->db_fetch_array($_sql))
{
?>
<div class="panel panel-default" id="<?php echo $a_data['ebook_preset_id'];?>"  >
            <div class="panel-heading ewt-bg-success">
                <h4 class="panel-title">
				<!--<i class="fas fa-arrows-alt text-info move" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="<?php echo 'Move';?>" ></i>
				<input class="input-inline-sm text-center" name="org_order[]" id="fa_order<?php echo $a_data['org_order'];?>"  type="text" value="<?php echo $a_data['org_order'];?>" readonly />-->
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i;?>">
					:: <?php echo $a_data['ebook_preset_name'];?>
					</a>					
                </h4>
            </div>		
            <div id="collapseOne<?php echo $i;?>" class="panel-collapse collapse"> 
                <div class="panel-body">
                   	<div><b><?php echo $txt_ebook_file_size_title;?> :</b> <?php echo $a_data['ebook_preset_name'];?> </div><br>  
					<div><b><?php echo $txt_ebook_file_size_width;?> :</b> <?php echo $a_data['ebook_preset_w'];?> <b>pixels</b></div><br> 	
					<div><b><?php echo $txt_ebook_file_size_height;?> :</b> <?php echo $a_data['ebook_preset_h'];?> <b>pixels</b></div><br> 	
					<!--<div class="text-left">
					<span class="label label-primary "><?php //echo $txt_ewt_multilang; ?></span>
					<?php //if(show_icon_lang_ewt($a_data['gen_user_id'],'gen_user')) { ?>
					<!--<button  type="button" class="btn btn-default   btn-sm " data-toggle="tooltip" data-placement="top" title="" >-->
					<?php //=show_icon_lang_ewt($a_data['gen_user_id'],'gen_user'); ?>
					<!--</button>->
					<?php// } ?>
					</div>-->
				</div>	 
				<div class="panel-footer ewt-bg-white text-right">
				<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">	
				<!--<a onClick="txt_data('<?php echo $a_data['g_ebook_id'];?>','')" >
				<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $a_data['g_ebook_id'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang;?>" >
				<i class="fa fa-language" aria-hidden="true"></i>
				</button>
				</a>-->
			
				 
				<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_ebook_page_size.php?pre_id=<?php echo $a_data['ebook_preset_id'];?>');">
				<button type="button" class="btn btn-warning  btn-circle  btn-xs "  data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ebook_file_size_edit;?>" >
				<i class="fa fa-edit" aria-hidden="true"></i> 
				</button>
				</a>
				
				<a onClick="JQDel_Ebook_File('<?php echo $a_data['ebook_preset_id'];?>');">
				<button type="button" class="btn btn-danger  btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ebook_file_size_delete;?>"   >
				<i class="far fa-trash-alt" aria-hidden="true"></i>
				</button>
				</a>
					
				<!--<a onClick="JQSet_Lang_Calendar('<?php //=$a_data['event_id']; ?>','')" data-toggle="tooltip" data-placement="right" title="<?php //=$txt_ewt_create_multilang; ?>">
				<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?php //=$a_data['event_id']; ?>" >
				<i class="fa fa-language" aria-hidden="true"></i>
				</button>
				</a>-->

</div>
</div>
					
</div>
</div>
<?php 
	$i++;
	} 
}
else
{
?>
    <div class="panel panel-default ">
        <div class="panel-heading text-center">
            <h4 class="panel-title">
            <p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
            </h4>
        </div>
    </div>
<?php 
}
?>			
</div>
<?php echo pagination_ewt($statement,$perpage,$page,$url='?text='.$_GET['text'].'&');?>	



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
<style>
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
<script>
function JQDel_Ebook_Cate(id){
					$.confirm({
						title: '<?php echo $txt_ewt_confirm_del_title;?>',
						content: '<?php echo $txt_ewt_confirm_del_alert;?>',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'fas fa-exclamation-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo $txt_ewt_confirm_del;?>',
									btnClass: 'btn-warning',
									action: function () {
										$.ajax({
											type: 'GET',
											url: 'func_delete_ebook_cate.php',
											data:{'id': id,'proc':'DelOrgList'},
											success: function (data) {
												$.alert({
													title: '<?php echo $txt_ewt_action_del_alert;?>',
													theme: 'modern',
													content: '',
													boxWidth: '30%',												
													buttons: {
														  cancel: {
																text: '<?php echo $txt_ewt_submit;?>',
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
									text: '<?php echo $txt_ewt_cancel;?>'
									 									
								}
							},                          
                            animation: 'scale',
                            type: 'orange'
						
						});
                   // });
}

</script>



