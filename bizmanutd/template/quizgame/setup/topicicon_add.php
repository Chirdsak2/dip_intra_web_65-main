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
	
			$sql_chk = " SELECT topic_code FROM topic WHERE  topic_code = '".$_POST["prev_topic_code"]."'  ";
							// WHERE topic_name = '".$disp->convert_qoute_to_db($arrNewName[0])."'
			$exec_chk = $db->query($sql_chk);
			$num_chk = $db->num_rows($exec_chk);
			
			if($num_chk==0) {
					
					$sql_chk2 = " SELECT topic_code FROM topic WHERE  topic_code = '".$_POST["topic_code"]."'  ";
							// WHERE topic_name = '".$disp->convert_qoute_to_db($arrNewName[0])."'
					$exec_chk2 = $db->query($sql_chk2);
					$num_chk2 = $db->num_rows($exec_chk2);
			
					if($num_chk2==0) {
						$INSERT = " INSERT INTO topic (topic_name, topic_code, topic_use) VALUES ('".$disp->convert_qoute_to_db($_POST["topic_name"])."',  '".$_POST["topic_code"]."', '".$_POST["topic_use"]."' ) ";
						$db->query($INSERT); 
					}
			}	else {
			
					$UPDATE = " UPDATE topic SET   topic_name = '".$disp->convert_qoute_to_db($_POST["topic_name"])."' , topic_code = '".$_POST["topic_code"]."' , topic_use = '".$_POST["topic_use"]."' WHERE  topic_code = '".$_POST["prev_topic_code"]."' ";
					$db->query($UPDATE); 				
			}	
			
			
			
			$uploaddir = "../upload/icons/";
			
			if($_FILES["icon_file"]["size"] > 0 ) {
					
					$file_ext = strrchr(strtolower($_FILES['icon_file']['name']),"."); // เธซเธฒ เธเธฒเธกเธชเธเธธเธฅ เธเธญเธเนเธเธฅเน
					
						if($file_ext == ".swf"  ) {   // เธฃเธญเธเธฃเธฑเธเธฃเธนเธ .swf เน€เธ—เนเธฒเธเธฑเนเธ  
										
							
									$newname = "icon_".$_POST["topic_code"].$file_ext;																																			
									$uploadfile = $uploaddir.$newname; // for upload  ( included '../' )																						
									$error = 0;
										
									if(move_uploaded_file($_FILES['icon_file']['tmp_name'], $uploadfile)) { 
									
											$savename = "upload/icons/".$newname;
											
											$UPDATE = " UPDATE topic SET  icon_path = '".$savename."'  WHERE  topic_code = '".$_POST["topic_code"]."' ";
											$db->query($UPDATE); 		
									}
									
						} 
						else {
						
								?>
										<script type="text/javascript">
										alert('เธฃเธฐเธเธเธฃเธญเธเธฃเธฑเธเนเธเธฅเน .swf เน€เธ—เนเธฒเธเธฑเนเธ');
										//window.location = 'showtime_list.php'; 			
										</script>
										<?php
						}
			
			}
			
				?>
			<script type="text/javascript">
			alert('เธเธฑเธเธ—เธถเธเธเนเธญเธกเธนเธฅ เน€เธฃเธตเธขเธเธฃเนเธญเธขเนเธฅเนเธง');
			opener.location = 'topic_list.php'; 
			window.close();
			</script>
			<?php
	} // end accept
?>
<?php 
	$sql1 = " SELECT * FROM  topic   WHERE topic_code = '".$_GET["topic_code"]."'  ";
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
<title>เน€เธเธดเนเธก/เนเธเนเนเธ เธซเธกเธงเธ”เธเธณเธ–เธฒเธก</title>

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
	
	qText = Trim(frm.topic_code.value);	
	
	if( qText.length<3 || qText.search(/\W/) != -1  ) {  // เธ–เนเธฒเน€เธเธญ เธญเธฑเธเธเธฃเธฐ เธ—เธตเนเนเธกเนเนเธเน a-z A-Z เธซเธฃเธทเธญ 0-9
		 alert('เธเธฃเธธเธ“เธฒเธเธฃเธญเธ Topic Code เธญเธขเนเธฒเธเธเนเธญเธข 3 เธ•เธฑเธงเธญเธฑเธเธฉเธฃ เนเธฅเธฐเนเธเนเธ เธฒเธฉเธฒเธญเธฑเธเธเธคเธฉ a-z, A-Z เธซเธฃเธทเธญเธ•เธฑเธงเน€เธฅเธ 0-9');
		 document.getElementById('div_allow').innerHTML = '';
		 frm.topic_code.focus();
		 return false;
	}
	text_allow = document.getElementById('div_allow').innerHTML; 	

	
	 if(text_allow.search("Duplicated") != -1 ) {
		alert('เธเธฃเธธเธ“เธฒเธเธฃเธญเธ Topic Code เธ—เธตเนเธขเธฑเธเนเธกเนเธเนเธณเนเธเธฃ');
		frm.topic_code.focus();
		return false;
	}
	
	if(frm.topic_name.value == '') {
		alert('เธเธฃเธธเธ“เธฒเธฃเธฐเธเธธเธเธทเนเธญเธซเธกเธงเธ”');
		frm.topic_name.focus();
		return false;
	}
	
	<?php if(!$rec1[icon_path]) { ?>
	
				if(frm.icon_file.value == '') {
					alert('เธเธฃเธธเธ“เธฒ upload เนเธเธฅเน Flash เธ—เธตเนเธกเธตเธเธฒเธฃเธเธณเธซเธเธ”เธเนเธฒ\n\n_global.icon_selected = '+frm.topic_code.value+'\n\nเนเธ Event เธเธธเนเธก');
					frm.icon_file.focus();
					return false;
				}
	<?php } ?>
}
</script>
</head>
<body leftmargin="5" topmargin="5" rightmargin="5" >
<H3>เน€เธเธดเนเธก/เนเธเนเนเธ เธซเธกเธงเธ”เธเธณเธ–เธฒเธก</H3>
<form name="frm" method="post" enctype="multipart/form-data"  ><input name="prev_topic_code" type="hidden" value="<?php echo $_GET["topic_code"];?>">


<table  border="1" bordercolor="#0066FF" cellspacing="0" cellpadding="2">
  <tr >  	
	<td width="100" bgcolor="#0099FF"  align="center" ><strong>Topic Code</strong></td>
    <td width="250" ><input name="topic_code" type="text" class="textBox" size="20" value="<?php echo $rec1[topic_code];?>" onKeyPress="return chkCharEng(this.value);" onBlur=" 
	qText = Trim(frm.topic_code.value);	
	if(qText.length>=3){	
		document.getElementById('div_allow').innerHTML = 'Please Wait...<br>'; 
		url='<?php echo $path;?>ajax/chkdup_code.php?topic_code='+frm.topic_code.value;
		load_divForm(url,'div_allow');
	} " >
	&nbsp;&nbsp;<span  id="div_allow" ></span><br><br><span style="color:#FF0000">เธเธฃเธธเธ“เธฒเนเธเนเธ เธฒเธฉเธฒเธญเธฑเธเธเธคเธฉ A-Z เธซเธฃเธทเธญ 0-9 เน€เธ—เนเธฒเธเธฑเนเธ</span></td>       
  </tr>
 <tr >  	
	<td bgcolor="#0099FF"  align="center"><strong>เธเธทเนเธญเธซเธกเธงเธ”</strong></td>
    <td ><input name="topic_name" type="text" class="textBox" size="30" value="<?php echo $rec1[topic_name];?>"></td>       
  </tr>
  <tr >  	
	<td bgcolor="#0099FF"  align="center"><strong>Flash Icon</strong></td>
    <td >
	<?php  if($rec1[icon_path] && file_exists($path.$rec1[icon_path])) { ?>
							<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,19,0" width="130" height="130"  >
  <param name="movie" value="<?php echo $path.$rec1[icon_path];?>">
  <param name="quality" value="high">
  <param name="wmode" value="transparent">
  <embed src="<?php echo $path.$rec1[icon_path];?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="130" height="130" wmode="transparent" swLiveConnect="true"></embed>
</object><br>
						<?php } ?>
	<input name="icon_file" type="file" class="textBox" size="30" > </td>       
  </tr>
  <tr >  	
	<td bgcolor="#0099FF"  align="center"><strong>เธชเธ–เธฒเธเธฐ</strong></td>
    <td ><input name="topic_use" type="radio" value="1" <?php if($rec1[topic_use]=='1') { echo "checked";}?> > เนเธเนเธเธฒเธ <input name="topic_use" type="radio" value=""  <?php if(!$rec1[topic_use]) { echo "checked";}?>> เนเธกเนเนเธเนเธเธฒเธ </td>       
  </tr>
  <tr > 
</table><br>
<input name="accept" type="submit" value="เธเธฑเธเธ—เธถเธ" onClick="return chkInput()">
</form>
</body>
</html>