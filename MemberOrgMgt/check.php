<?php
if($_GET["url"] != ""){
	if(!eregi("http://", $_GET["url"])){
		$url = "http://".$_GET["url"];
	}else{
		$url = $_GET["url"];
	}
		$fp = @fopen($url ,"r");
		if($fp){ 
		$pass = "Y";
		}else{
		?>
		<script language="javascript">
		alert("ตรวจสอบ <?php echo $url; ?> ข้อมูลไม่ถูกต้อง !");
		</script>
		<?php
		}
		@fclose($fp);
}
?>