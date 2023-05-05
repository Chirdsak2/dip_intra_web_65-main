<?php
session_start();
$EWT_PATH = "../";
include("../language.php");
$set_calendar_registor = 'Y';

	if($_SESSION["EWT_SMUSER"] == "" ){
				?>
				<script language="javascript">
				self.location.href = "../index.php";		
				</script>
				<?php
			exit();
		}
?>