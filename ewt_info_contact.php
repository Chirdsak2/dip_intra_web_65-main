<?php
include("lib/permission.php");
include("lib/include.php");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$IMG_PATH = 'EWT_ADMIN/';
$EWT_PATH = '';
$MAIN_PATH = 'EWT_ADMIN/';

 				$f1 = fopen("font_list.txt","r");
			  while($line1 = fgets($f1,1024)){
			  $fontL .= $line1; 
			  }
			  fclose($f1);
			 $FontA = explode("###",$fontL);  

$sql = "select * from contact";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);

	?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>EasyWebTime 8.9</title>
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<?php include('link.php'); ?>

<script>
function selColor(c,d){
				Win2=window.open('ewt_color.php?c_value='+ c +'&c_block=' + d + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
			}
			  	function CreColor(va,bg,pre,flag){
				  	bg.style.backgroundColor= va;
					if(flag == 'color'){
  						pre.style.color = va;
					}else{
						pre.style.backgroundColor = va;
					}
				}
</script>
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
 table {
	 font-size: 14px;
	 font-weight: 400;
 }  
 input {
	 
	 height:30px;
	 
 }

</style>
</head>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">&#3605;&#3633;&#3657;&#3591;&#3588;&#3656;&#3634;ข้อมูลสถานที่ติดต่อ </div>	


<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-10 col-sm-10 col-xs-12 form-inline" ></div>

<div class="col-md-2 col-sm-2 col-xs-12 float-right" style="text-align:right;" >
 
</div>	
</div>
</div>

<div class="clearfix">&nbsp;</div>	



<div class="panel panel-default" >
<div class="panel-heading form-inline" ></div>
<div class="panel-body">
 <form action="ewt_info_function.php" method="post" name="form1" id="form1">
          <input name="hdd_site_info_id" type="hidden" value="<?php echo $rec['contact_id']?>" />
          <input name="hdd_flag" type="hidden" value="site_contact" />
		  
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="contact_name"><?="ชื่อสถานที่ตั้ง";?> : </label>
        <input class="form-control" name="contact_name" type="text" id="contact_name"  value="<?=$rec_user['contact_name'];?>" />
		
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="contact_address"><?="ที่อยู่สถานที่ตั้ง"; ?> : </label>
		  <textarea name="contact_address" class="form-control" style="width:100%;"  cols="100" rows="6"><?php echo $rec[contact_address]?></textarea>
        
      </div>
</div>

<div class="form-group row">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <label for="contact_tel"><?php echo "เบอร์โทรศัพท์";?> : </label>
       <input name="contact_tel" style="width:100%;"   type="text" id="contact_tel" value="<?php echo $rec['contact_tel']?>" class="form-control" />
      </div>
	  <div class="col-md-4 col-sm-4 col-xs-12">
        <label for="txt_desc"><?php echo "เบอร์สำนักงาน"; ?> : </label>
		 <input name="contact_off_number" type="text" id="contact_off_number"  value="<?php echo $rec['contact_off_number']?>" class="form-control"/>       
      </div>
	  <div class="col-md-4 col-sm-4 col-xs-12">
        <label for="txt_desc"><?php echo "เบอร์โทรสาร"; ?> : </label>
		  <input name="contact_fax" style="width:100%;" type="text" id="contact_fax" value="<?php echo $rec['contact_fax']?>" class="form-control" />   
      </div>
</div>

<div class="form-group row">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <label for="contact_email"><?php echo "อีเมล์";?> : </label>
       <input name="contact_email" style="width:100%;"   type="text" id="contact_email" value="<?php echo $rec['contact_email']?>" class="form-control" />
      </div>
	  <div class="col-md-4 col-sm-4 col-xs-12">
        <label for="contact_line"><?php echo "Line ID"; ?> : </label>
		 <input name="contact_line" type="text" id="contact_line"  value="<?php echo $rec['contact_line']?>" class="form-control"/>       
      </div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <label for="contact_map"><?="ที่อยู่สถานที่ตั้ง"; ?> : </label>
		  <textarea name="contact_map" class="form-control" style="width:100%;"  cols="100" rows="6"><?php echo $rec[contact_map]?></textarea>
        
      </div>
</div>

<div class="form-group row">
      <div class="col-md-4 col-sm-4 col-xs-12">
        <label ><h3><?php echo "ช่องทางติดต่ออื่น ๆ";?></h3> </label>
      </div>
</div>
<?php
$B = explode("#@#",$rec['contact_other']);
?>	
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <label for="contact_other_fa"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAIPSURBVGhD7ZnLSwJRGMWl/ojqj9GpVtEDZgTtvWghVKsWQcuQWkUPCAqEoNBdrcqZygKF3mEPMip30SIqjKDIIiJvc/VzpPwEnSHvTNwDv5V3jufMfSzm2ri4uLj+l1yuxUpBCrY5JCXgEJXNMuO3O5VW2/BwBcTRJ7u0VuMQ5aggKYQxh4JLroZYpYnOhDoLB4gpK/Z0zQxdTogZU9LLrFTRPYGZsYTuGYhXvARRCWNmTFEzQbzi5ZDkbdSMITQTxCtef12koz9CRiZPyfTcBfH54xp9Q7voeIqpirg9YXIceySF5AvE0ecopinS2Bkit/dJiIzLEkVm5y8hbmFZosjxWf6S+vpKkfOrJ3J0lkjjnThFn6WYpsjdwxvEz4nOEjYWwzRFnl8+IH5OQ6NRdCyGaYq8Jj8hfk6WKFLnXCXtvRGN5Ft+kbGZ2I8xTV0bqBeFWRF63Jaq0SkTbnY9RTyDO6gXxTJFUilCGtrXUS+KZYo8JN5RnyzMitQ6FdLcvaGBnVre8RPtd1oc88nCrMhvLHv8/oYXAXgRzMwIvAjAi2BmRuBFAF4EMzMCkyJ/8cnUaBF9n0xFxY+aGWApeE1WQjc/6BnYQsdi6PuIbcJrBUGSXRCveGWu3JS9fDNm6LvooYKrt33EtNzs1rcsV0EsnVLfglrGrZotwAVl2cj8p+w2fBnKxcXFZTLZbN9S86sn1aGunQAAAABJRU5ErkJggg==">
			  <input type="checkbox" name="fa" value="Y" <?php if($B[0]){ echo "checked"; } ?> /></label>
		
		  <textarea name="contact_other_fa" class="form-control" style="width:100%;"  cols="100" rows="6"><?php echo substr($B[0],"1")?></textarea>
        
      </div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <label for="contact_other_tw"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAMqSURBVGhD7Zg7aBRBGMfX3TvBRrFQFMEHqFiIiDZ2QkC00cqAxCqYQkUQxMInIQRNIaYIiAFRUDGZWS6C2FloYWPlk4AgaqGixaF3N7OJz2z+s/ep590Y93ZnNxbzgz+7uex+r3nszDgWi8VisVhmi9LECpcH+z0mBz0uL7hMnirw2lbHDz16opUwnEN3CeFT89IbIcbkUgQ/4nHxAwmELWLyhceCnfR0nRuVhS6Xp5FsN/2SDBg56jExQH8mpsjEeth5q02gUUxMQWdUi7lc3MZ9gMTfOf7HBWQqGajSc+UAFTlOP7UPry1CQG9ago4jJr4gkY7ITuKegW4VVei34SGnN3Tpv7GBjYsNNuKLyTJapQv3O5DMpWgcJWK0urbZOLraXYcHy+iJf3O9PB+JfG62E09C/rxX44QsJgAD7U/DJFUpJnvitI7Hg11aG21JnE094cDQh1bDdblMPEK1O2eaNtE1DuvejSUmvkcFMwGqf17rpFFMvELV+osjYgO99gskckj7ThwxWSEzBvAnlsNotcXJ38TEe7TULVz70K/34TqgfS6OYIuiMAMC2wOjjbNXPsIHkkJIR5HJTVTdTlT3JLrPV63DjBTNkEbw5RKdg/wkhimS9KAqz/ROspcaYxRGelxeO6BzkoecUnUNhWGAe2EBU+gDnaNMxeQ4RWCQ+vI7WjzmJXwIe8m7YeprpsvQN51jo8KKVxWPPBtmdHJl0ZcbMR3vxSB8og3AmMQV8mqeAgu26J0aFlbKaitMbrMBjvwWx8Yl+sldhmC7iRnssT6A9MIAf4qV9FzyljHqMICJm7pAUkmtdEu1deQlP9S2E/35GrrC6/RrMLzffHqSNwiiAwm91AcYQ9g8eby2m8zlT3S8w8VVBJJ8eY/uBG0nkzmCPuyy2kEMyjupEoAwaTzMZ0zwyVWo+DCCvk/Lk/i7xJnEpMAH9YRaw5GnHOgNXSTSraZFbVDtiMlP0KAzJhaT9dmh6AebEdAQghlHS+nPbpvFZBli6EZd0Rnyfwc+jEhmG1qqx/XlMYyXc6rauPYh6CPqLMvhldVJTiUtFovFYrFYHGcazS5/dDE9KGwAAAAASUVORK5CYII="> 
			  <input type="checkbox" name="tw" value="Y" <?php if($B[1]){ echo "checked"; } ?> ></label>
		  <textarea name="contact_other_tw" class="form-control" style="width:100%;"  cols="100" rows="6"><?php echo substr($B[1],"1")?></textarea>
        
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12">
        <label for="contact_other_yt"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAUnSURBVGhD7VZrbBRVFC4mJmo0/tGfmqjxj0ZjYmKJwTR2Zy1QaQm0trON9DG7C0gt1iK1bB9KHwQqKqQVy6MxIiZAtbEYbNrgIxILCRiitb5iorZiaaLBuvPY2e5czzlz7/aRoZHO1m5xv+Ts3nvOved839w7c29aCimkkML/B17Z3+qVlX6vT8nnrjSvz/8G+WRlFXclP0BADRBnkqwcx35GcfENks8fQd/jBYF7aNBigMcXeICE+Pxj0F0iyYEM7IMN2SMWEWB7/YTkswr998N/LReyg4dBbOnd3sJAek5Z2S3clZyQZP8eTn4TbLVebEtF/qUPB4PXw0p18xhuvz+9RWVP2HOCy7j/Q+zDwziCfY9P8WF/QQDbS7JJKV0gahwIX2poaLgOfAr5ZWUE7APe/gXnJKUQfPIg4jInhnYA/ZMrpVRiH9qj2F+eV3p7UgpBANmjnBhsq0CO7YPPMJKTlY3Uh9Wg+NPBO5NWCBIgkvDpXZpXeSP6oL/4hEwSUy5zV0oI9hcM17QQ+AyHiLisHJTk9fdKPsUAMSadL3w8xM7jYSlEJqWQzKLS+5C47RemdFGsUHlQ+OADMQGChrG94EKAxENA6BwQ/ZS7CHj3ApInIP4FbJ9XpPzgrTy0BHyd4PsET3toN+F8T6GynMdTSDjYkY7b9P3775pq6OPhhYV5qC1dD1VdUEvytHDhKjO8NisWzs20yHLAPI+wqzKcI+ZjLsiJufW6qi+xFi+bWETaXisL53qunuxcDWpF2neX8vKJATvWdjOtgFPBeTTVl2uyjo6bOA33MPbu2oqJjR0NzBofdzTznU5HMmhm9zEaE+076RifzbA2p+Eexs6XD2PSyOs72ZVg9nQ5EkGLnuqlMRNnTjvGZzOszWm4h95UdwKTan6ZRQ60sWjPe0QMEf24j3z68xsciaC5EaI319I1JiEwGkN905JvDhAxhNFcZ/u2ljNjew1T5Rym5q+ktr7tOYpNFaJv2cSM1kamrvbE82EbXmxmHj3MjKYQC0vp8RjW5jTcQ6+vHhCJ0ZyEWJd+pz5uP/QhrPDfFBNCWDRq/wNiP35HhNW1WcwaG+VeG9GPeiZrQW1Owz302qrzIjEln6MQa/wvNnHuLLURWkk+rQLCUsMs9s1X1GaWBau6wq4FZwqn4R56TeWgEEHJ5ygEt5a2bg21EZhHCIt+dgqEPUVthPasYteC2pyGe2jVFd8LEZTchRB8hwRIyNcXqB0bGZ7cggCM4VwNanMa7pHIFbmSkJkQQhK6Inr9C2eECEo+D0Ji3w4y49WWuKmrJbtW3ZaznIZ76C9VnxYiKPk8CMEx6posFvttmFkXR5gW8Nm1oDan4R5Gc6hXiKDkswnB8+Ddt6j9r172gc+pjf9IXkDbWExzsTan4R56S8P7QgSakxB8koSoaf8DZgrBGJ4fAnhTMN8+aHcMg8V+/dlumxGm5mTatVrquzkN9zB2NR4SIii5g5Bo/0nbYcXYxKC9XWYKsVQVfixqx4YG7QMR3oW4AATEI5374rWwNqfhHsa+PbkiMVnWo7D068jUJzNs34pldCXBrYM+ipcVUEwtyLbH4vWlKJeuKeGVj03my86gKw2+Xzgu7gcz3tybzWkkBtrmwMWpBf4Lg4voMC+fOGid7XdoFcqYU8H5MHhwo1iTl0889PbWDcb2bf1wtgzgYaW9WDFEVl3+Az5BYVq5MqY9U/LHNAPftDEwR8zHXJiTcrftXs/LpZBCCilck0hL+wdeCfBYPSvaaAAAAABJRU5ErkJggg==">
			  <input type="checkbox" name="yt" value="Y" <?php if($B[2]){ echo "checked"; } ?> ></label>
		  <textarea name="contact_other_yt" class="form-control" style="width:100%;"  cols="100" rows="6"><?php echo substr($B[2],"1")?></textarea>
        
      </div>
</div>
</div>
</div>

<div class="panel-footer text-center" >
		<button type="submit" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?='บันทึก';?>" >
		<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?='บันทึก'; ?>
		</button> 
		
</div>

</form>
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
