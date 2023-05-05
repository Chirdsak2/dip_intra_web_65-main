<?php
ini_set("memory_limit", "-1");
set_time_limit(0); 
include("../EWT_ADMIN/comtop_pop.php");

$rss_id = (int)(!isset($_GET['rss_id']) ? '' : $_GET['rss_id']);

$s_sql 	 = $db->query("SELECT * FROM rss WHERE rss_id = '{$rss_id}' "); 
$a_data  = $db->db_fetch_array($s_sql);  
$rss_url = $a_data['rss_url']; 
$rss_images = $a_data['rss_images']; 

if($rss_url)
{
$curl = curl_init(); 
curl_setopt($curl, CURLOPT_URL, $rss_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($curl, CURLOPT_TIMEOUT, 10);

$content = curl_exec($curl);
if ($content == false || $content == "") {
    //echo curl_error($curl)." --- ".curl_errno($curl);
} else {
    //echo $content;
}

curl_close($curl); 

$parsed_xml = simplexml_load_string($content);
$num = count($parsed_xml->channel->item); 

$channel_title = $parsed_xml->channel->title;
$channel_link = $parsed_xml->channel->link;
$channel_description = $parsed_xml->channel->description;	
$channel_lastBuildDate = $parsed_xml->channel->lastBuildDate; 	     
?>
<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_rss')?>" enctype="multipart/form-data" >
<input type="hidden" name="proc" id="proc"  value="">
<input type="hidden" name="rss_id" id="rss_id"  value="<?php echo $rss_id;?>">
<div class="container" >   
<div class="modal-dialog modal-lg" >

<div class="modal-content">
<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6"> 
<button type="button" class="close" onclick="$('#box_popup').fadeOut();" ><i class="far fa-times-circle fa-1x  color-white"></i></button>
<h4 class="modal-title color-white"><i class="fas fa-rss-square"></i> <?php echo $a_data['rss_title'];?></h4>  
</div>

<div class="modal-body">
<div class="card ">
<div class="card-body" >
<?php 
if($rss_images != 'Y')
{
?>
<div class="table-responsive">     
	<table class="table table-striped"> 
    <thead>
      <tr>
		<th class="text-center" style="width:5%;"><b>#</b></th>  
        <th class="text-center" style="width:35%;"><b>หัวข้อข่าว</b></th>  
        <th class="text-center" style="width:35%;"><b>รายละเอียด</b></th> 
		<th class="text-center" style="width:25%;"><b>วันที่</b></th>   
      </tr>
    </thead>
    <tbody>
<?php
for($i=0; $i < $a_data['rss_row']; $i++)
{
	$title =  $parsed_xml->channel->item[$i]->title;
	$link =  $parsed_xml->channel->item[$i]->link;
	$description = $parsed_xml->channel->item[$i]->description;
	$pubDate = $parsed_xml->channel->item[$i]->pubDate;
?>
	<tr>
		<td><?php echo ($i+1);?></td> 
        <td><?php echo $title;?></td>
        <td class="text-left"><?php echo $description;?> </td> 
		<td class="text-ceneter"><?php echo $pubDate;?> </td>      	
	</tr>
<?php	
			
	}

?>
	</tbody>
	</table>
</div>


<?php }else{ ?>	

<div class="table-responsive">     
	<table class="table table-striped"> 
    <thead>
      <tr>
		<th class="text-center" style="width:5%;"><b>#</b></th> 
		<th class="text-center" style="width:35%;"><b>รูปภาพ</b></th> 		
        <th class="text-center" style="width:35%;"><b>หัวข้อข่าว</b></th>         
		<th class="text-center" style="width:25%;"><b>วันที่</b></th>   
      </tr>
    </thead>
    <tbody>
<?php
for($i=0; $i < $a_data['rss_row']; $i++)
{
	$title =  $parsed_xml->channel->item[$i]->title;
	$link =  $parsed_xml->channel->item[$i]->link;
	$description = $parsed_xml->channel->item[$i]->description;
	$pubDate = $parsed_xml->channel->item[$i]->pubDate;
	$img = $parsed_xml->channel->item[$i]->image;
?>
	<tr>
		<td><?php echo ($i+1);?></td>  
		<td class="text-left"><img src="<?php echo $img;?>" class="img-thumbnail" alt="Cinque Terre" width="304" height="236"></td> 
        <td><?php echo $title;?></td>
		<td class="text-ceneter"><?php echo $pubDate;?> </td>      	
	</tr>
<?php	
			
	}

?>
	</tbody>
	</table>
</div>

<?php				
	}
?>
</div>		
<div class="modal-footer ">
<div class="col-md-12 col-sm-12 col-xs-12 text-center">  
<button onclick="$('#box_popup').fadeOut();" type="button" class="btn btn-warning  btn-ml"> 
<i class="far fa-times-circle fa-1x  color-white"></i>&nbsp;<?php echo 'Close';?> 
</button>
</div>
</div>

</div>
</div>
</div>
 </div>
</div>	 
</form>
<?php } ?>	
<script>  
$(document).ready(function() {

/*var urlExists = function(url, callback) {

    if ( ! $.isFunction(callback)) {
       throw Error('Not a valid callback');
    }   

    $.ajax({
        type: 'HEAD',
        url: url,
        success: $.proxy(callback, this, true),
        error: $.proxy(callback, this, false)      
    });

};*/
	
});
$(function() {
	$('#btnValidate').click(function() {
	var txt = $('#txturl').val();
	var re = '/(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/';
	if (re.test(txt)) {
	alert('Valid URL')
	}
	else 
	{
	alert('Please Enter Valid URL');
	return false;
	}
	});
});
function JQEdit_Ebook(form){	

var fail = CKSubmitData(form);
if (fail == false) {	
var action  = form.attr('action'); 
var method  = form.attr('method'); 
var formData = false;
  if (window.FormData){
      formData = new FormData(form[0]);
  } 														
			 $.confirm({ 
						title: 'แก้ไข Rss Feed', 
						content: '<?php echo $txt_ewt_confirm_alert;?> ',
						//content: 'url:form.html',
						boxWidth: '30%',
						icon: 'far fa-question-circle',
                        theme: 'modern',
						buttons: {
								confirm: {
									text: '<?php echo $txt_ewt_confirm_submit;?>',
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
												console.log(data);
												$.alert({
													title: '',
													theme: 'modern',
													content: '<?php echo $txt_ewt_action_alert;?>',
													boxWidth: '30%',
													type: 'blue', 
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
									text: '<?php echo $txt_ewt_cancel;?>',
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
</script>