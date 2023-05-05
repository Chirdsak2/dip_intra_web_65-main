<?php	
    header("Expires: ".gmdate("D, d M Y H:i:s")."GMT");
    header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
		
	$path = "../";
	$path_comp = "../";
	
	include($path."include/config.inc.php");
	include($path."include/class_db.php");
	include($path."include/class_display.php");
//	include($path."include/class_application.php");
	
   $CLASS['db']   = new db();
   $CLASS['db']->connect ();
   $CLASS['disp'] = new display();
   //$CLASS['app'] = new application();   
		   
	$db   = $CLASS['db'];
    $disp = $CLASS['disp'];
	//$app = $CLASS['app'];
	
	
	$this_year = date("Y")+543;
	
	if(!$show_year) $show_year = $this_year;
	
	
	if($_POST["accept"]) { 
	
			$sql_chk = " SELECT slevel_id, slevel_name FROM score_level  WHERE  slevel_id = '".$_POST["slevel_id"]."'  ";
						
			$exec_chk = $db->query($sql_chk);
			$num_chk = $db->num_rows($exec_chk);
			
			if($num_chk==0) {
					
				
						$INSERT = " INSERT INTO score_level (slevel_name, score_min, score_max) VALUES ('".$disp->convert_qoute_to_db($_POST["slevel_name"])."',  '".($_POST["score_min"]*1)."', '".($_POST["score_max"]*1)."' ) ";
						$db->query($INSERT); 
					
			}	else {
			
					$UPDATE = " UPDATE score_level SET   slevel_name = '".$disp->convert_qoute_to_db($_POST["slevel_name"])."' , score_min = '".($_POST["score_min"]*1)."' , score_max = '".($_POST["score_max"]*1)."' WHERE  slevel_id = '".$_POST["slevel_id"]."' ";
					$db->query($UPDATE); 				
			}	
			
			
			
			$uploaddir = "../upload/level_bg/";						
			
			if($_FILES["bg_file"]["size"] > 0 ) {
					
					$file_ext = strrchr(strtolower($_FILES['bg_file']['name']),"."); // เธซเธฒ เธเธฒเธกเธชเธเธธเธฅ เธเธญเธเนเธเธฅเน
					
								
									$newname = "bg_".$_POST["slevel_id"].$file_ext;																																			
									$uploadfile = $uploaddir.$newname; // for upload  ( included '../' )																						
									$error = 0;
										
									if(move_uploaded_file($_FILES['bg_file']['tmp_name'], $uploadfile)) { 
									
											$savename = "upload/level_bg/".$newname;
											
											$UPDATE = " UPDATE score_level SET  bg_path1 = '".$savename."'  WHERE  slevel_id = '".$_POST["slevel_id"]."' ";
											$db->query($UPDATE); 		
									}														
			
			}
			
			$uploaddir = "../upload/level_gauge/";

			if($_FILES["gauge_file"]["size"] > 0 ) {
					
					$file_ext = strrchr(strtolower($_FILES['gauge_file']['name']),"."); // เธซเธฒ เธเธฒเธกเธชเธเธธเธฅ เธเธญเธเนเธเธฅเน
					
						if($file_ext == ".swf"  ) {   // เธฃเธญเธเธฃเธฑเธเธฃเธนเธ .swf เน€เธ—เนเธฒเธเธฑเนเธ  
										
							
									$newname = "gauge_".$_POST["slevel_id"].$file_ext;																																			
									$uploadfile = $uploaddir.$newname; // for upload  ( included '../' )																						
									$error = 0;
										
									if(move_uploaded_file($_FILES['gauge_file']['tmp_name'], $uploadfile)) { 
									
											$savename = "upload/level_gauge/".$newname;
											
											$UPDATE = " UPDATE score_level SET  gauge_path1 = '".$savename."'  WHERE  slevel_id = '".$_POST["slevel_id"]."' ";
											$db->query($UPDATE); 		
									}
									
						} 
						else {
						
								?>
										<script type="text/javascript">
										alert('เธฃเธฐเธเธเธฃเธญเธเธฃเธฑเธเธซเธฅเธญเธ”เธเธฐเนเธเธ เน€เธเนเธเนเธเธฅเน Flash (.swf) เน€เธ—เนเธฒเธเธฑเนเธ');											
										</script>
										<?php
						}
			
			}
			
				?>
			<script type="text/javascript">
			alert('เธเธฑเธเธ—เธถเธเธเนเธญเธกเธนเธฅ เน€เธฃเธตเธขเธเธฃเนเธญเธขเนเธฅเนเธง');
			opener.location = 'scorelevel_list.php'; 
			window.close();
			</script>
			<?php
	} // end accept
?>
<?php 
	$sql1 = " SELECT * FROM score_level  WHERE  slevel_id = '".$_GET["slevel_id"]."'  ";
	$exec1 = $db->query($sql1);
	$num1=$db->num_rows($exec1);	
 	if($num1) {
		$rec1 = $db->fetch_array($exec1);
		
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/basestyle.css" rel="stylesheet" type="text/css">
<title>เน€เธเธดเนเธก/เนเธเนเนเธ เธฃเธฐเธ”เธฑเธเธเธฐเนเธเธ</title>

<script type="text/javascript" src="../js/AjaxRequest.js"></script>	
<script type="text/javascript" src="../js/functions.js"></script>	
<script type="text/javascript" src="../js/swfobject.js"></script>
<script type="text/javascript">

function chkCharEng(str) {
			
			char1 = String.fromCharCode(event.keyCode);
			//alert(String.fromCharCode(event.keyCode));
			//alert(char1.search(/\W/));
		
			if( char1.search(/\W/) != -1  ) {  // เธ–เนเธฒเน€เธเธญ เธญเธฑเธเธเธฃเธฐ เธ—เธตเนเนเธกเนเนเธเน a-z A-Z เธซเธฃเธทเธญ 0-9 _
				alert('เธเธฃเธธเธ“เธฒเนเธเนเธ เธฒเธฉเธฒเธญเธฑเธเธเธคเธฉ a-z, A-Z เธซเธฃเธทเธญเธ•เธฑเธงเน€เธฅเธ 0-9');
				return false;			
			}
}

function chkInput() {
	
	
	
	if(frm.slevel_name.value == '') {
		alert('เธเธฃเธธเธ“เธฒเธฃเธฐเธเธธเธเธทเนเธญเธฃเธฐเธ”เธฑเธเธเธฐเนเธเธ');
		frm.slevel_name.focus();
		return false;
	}
	
	<?php if(!$rec1[bg_path1]) { ?>
	
				if(frm.bg_file.value == '' || ( frm.bg_file.value.search(".jpg") == -1 && frm.bg_file.value.search(".gif") == -1 && frm.bg_file.value.search(".png") == -1 && frm.bg_file.value.search(".swf") == -1) ) {
					alert('เธเธฃเธธเธ“เธฒ upload เนเธเธฅเนเธ เธฒเธเธเธทเนเธเธซเธฅเธฑเธเธเธญเธเน€เธเธกเธชเน เธเธเธฒเธ” 800x600 pixels');
					frm.bg_file.focus();
					return false;
				}
	<?php } ?>
	
	<?php if(!$rec1[gauge_path1]) { ?>
	
				if(frm.gauge_file.value == '' || frm.gauge_file.value.search(".swf") == -1 ) {
					alert('เธเธฃเธธเธ“เธฒ upload เนเธเธฅเน Flash เธ เธฒเธเน€เธเธฅเธทเนเธญเธเนเธซเธงเธ—เธตเนเธกเธตเธเธณเธเธงเธเน€เธเธฃเธก 50-60 เน€เธเธฃเธก  เธเธเธฒเธ” 150x410 pixels');
					frm.gauge_file.focus();
					return false;
				}
	<?php } ?>
	
	if(!confirm('เธขเธทเธเธขเธฑเธเธเธฒเธฃเธเธฑเธเธ—เธถเธเธฃเธถเนเธกเน')) {
		  return false;
	}
}
</script>
</head>
<body leftmargin="5" topmargin="5" rightmargin="5" >
<H3>เน€เธเธดเนเธก/เนเธเนเนเธ เธฃเธฐเธ”เธฑเธเธเธฐเนเธเธ</H3>
<form name="frm" method="post" enctype="multipart/form-data"  ><input name="slevel_id" type="hidden" value="<?php echo $_GET["slevel_id"];?>">


<table  border="1" bordercolor="#0066FF" cellspacing="0" cellpadding="2">
  <tr >  	
	<td width="100" bgcolor="#0099FF"  align="center" ><strong>เธเธทเนเธญเธฃเธฐเธ”เธฑเธเธเธฐเนเธเธ</strong></td>
    <td width="250" ><input name="slevel_name" type="text" class="textBox" size="20" value="<?php echo $rec1[slevel_name];?>" ></td>       
  </tr>
 <tr >  	
	<td bgcolor="#0099FF"  align="center"><strong>เธเนเธงเธเธเธฐเนเธเธ</strong></td>
    <td ><input name="score_min" type="text" class="qty" size="10" value="<?php echo $rec1[score_min];?>"> - <input name="score_max" type="text" class="qty" size="10" value="<?php echo $rec1[score_max];?>"></td>       
  </tr>
  <tr >  	
	<td bgcolor="#0099FF"  align="center"><strong>เธ เธฒเธเธเธทเนเธเธซเธฅเธฑเธ</strong></td>
    <td >
	<?php  if($rec1[bg_path1] && file_exists($path.$rec1[bg_path1])) { ?>
							<img src="<?php echo $path;?>images/text_view.gif" border="0" align="absmiddle" onClick="view = window.open('<?php echo $path.$rec1[bg_path1];?>','view','menubar=no,location=no,scrollbars=yes,status=yes, resizable=yes, left=100,top=100, width=800, height=600'); view.focus();" style="cursor:pointer"><br>
						<?php } ?>
	<input name="bg_file" type="file" class="textBox" size="30" ><br>เธ•เนเธญเธเธเธฒเธฃเนเธเธฅเนเธ เธฒเธเธเธทเนเธเธซเธฅเธฑเธเธเธญเธเน€เธเธกเธชเน เธเธเธฒเธ” 800x600 pixels</td>       
  </tr>
  <tr >  	
	<td bgcolor="#0099FF"  align="center"><strong>เธซเธฅเธญเธ”เธเธฐเนเธเธ</strong></td>
    <td >
	<?php  if($rec1[gauge_path1] && file_exists($path.$rec1[gauge_path1])) { ?>
							<img src="<?php echo $path;?>images/text_view.gif" border="0" align="absmiddle" onClick="view = window.open('<?php echo $path.$rec1[gauge_path1];?>','view','menubar=no,location=no,scrollbars=yes,status=yes, resizable=yes, left=300,top=100, width=155, height=410'); view.focus();" style="cursor:pointer"><br>
						<?php } ?>
	<input name="gauge_file" type="file" class="textBox" size="30" ><br>เธ•เนเธญเธเธเธฒเธฃเนเธเธฅเน Flash เธ เธฒเธเน€เธเธฅเธทเนเธญเธเนเธซเธงเธ—เธตเนเธกเธตเธเธณเธเธงเธเน€เธเธฃเธก 50-60 เน€เธเธฃเธก  เธเธเธฒเธ” 150x410 pixels</td>       
  </tr>
</table><br>
<input name="accept" type="submit" value="เธเธฑเธเธ—เธถเธ" onClick="return chkInput()">
</form>
</body>
</html>