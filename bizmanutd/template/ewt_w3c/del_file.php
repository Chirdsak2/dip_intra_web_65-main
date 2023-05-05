<?php
		 $path = "";
		include ($path.'include/config.inc.php');
		
		//$filedel = $UserPath."w3c\\checked\\".$filepathname;		
		
		//echo "$filedel <br>";
		//echo file_exists($filedel);
		if($_GET["page_type"]==2) {  // Template 
				$filedel = $dir2.$filepathname;		
		} else {
				$filedel = $dir1.$filepathname;		
		}
		
		if($filepathname && file_exists($filedel) ) {
			  unlink($filedel);		
			  //exit;	  			  
		}
		
?><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="javascript">
		parent.location = '<?php echo $prev_url;?>?filename=<?php echo $_GET["filename"];?>&page_type=<?php echo $_GET["page_type"];?>';
</script>
