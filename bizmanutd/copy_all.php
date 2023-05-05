<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

if(!file_exists("../ewt/update_to_all")){ 
	mkdir("../ewt/update_to_all",0777);
	chmod("../ewt/update_to_all",0777);
	}
	
function phpxcopy($s, $d){
$l = "/"; // Plz Change to '/' when your OS is Unix.
if(!file_exists($d)){ 
	mkdir($d,0777);
	chmod($d,0777);
	}
if(is_dir($s)){
	$dp = opendir($s);
	while($file = readdir($dp)){
	if(!($file == "." || $file == ".." || $file == "Thumbs.db")){
		$SPath = $s.$l.$file;
		$DPath = $d.$l.$file;
		if(is_dir($SPath)){
			phpxcopy($SPath, $DPath);
		}else{
			if(!copy($SPath, $DPath)){
					echo "Error : Failed to copy the folder or files";
					exit();
			}else{
			chmod($DPath,0777);
			}
      }
	}
	}
	closedir($dp);
}
return true;
}

if($_GET["Flag"] != ""){
	if($_GET["Flag"] == $_SESSION["FlagCopyAll"] AND $_GET["start"] != ""){
		
		$sql0 = $db->query("SELECT COUNT(EWT_User) FROM user_info WHERE EWT_Status = 'Y'");	
		$n = $db->db_fetch_row($sql0);
		$per = ($_GET["start"]/$n[0]);
		$perc = number_format(($per * 100),2);
		$sql1 = $db->query("SELECT EWT_User FROM user_info WHERE EWT_Status = 'Y' ORDER BY EWT_User ASC LIMIT ".$_GET["start"].",1");	
		if($db->db_num_rows($sql1) > 0){
		$R = $db->db_fetch_row($sql1);
			if(file_exists("../ewt/".$R[0])){ 
			echo "<h1><font color=green>Now processing on ".$R[0]."<br>Please wait........................................".$perc."%</font></h1>";
			phpxcopy("../ewt/update_to_all", "../ewt/".$R[0]);
			}else{
			echo "<h1><font color=red>Can not copy to ".$R[0]."<br>Folder not founds.</font></h1>";
			}
			$s = $_GET["start"] + 1;
					?>
					<script language="javascript">
					window.location.href = "copy_all.php?start=<?php echo $s; ?>&Flag=<?php echo $_GET["Flag"]; ?>";
					</script>
					<?php
					exit;
			
		}else{
		$_SESSION["FlagCopyAll"] = "";
		?>
		<script language="javascript">
		alert("Finish Copy");
		window.location.href = "copy_all.php";
		</script>
		<?php
		exit;
		}
		
	}
}else{

session_register("FlagCopyAll");
$_SESSION["FlagCopyAll"] = md5(date("His"));

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 16px;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td height="1" colspan="3"> 
      <?php include("com_top.php"); ?>
    </td>
  </tr>
  <tr valign="top"> 
    <td width="1"><?php include("com_left.php"); ?></td>
    <td>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td height="10" >
	<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
  <form action="copy_all.php" method="get"  name="form1">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>

          <tr > 
            <td width="89%"><div align="right" class="style1">
              <div align="left">Copy Front End Files to All Users in EWT</div>
            </div></td>
            <td width="11%">&nbsp;</td>
          </tr>
<tr >
            <td width="89%"><div align="right" class="style2">
              <div align="left">How to copy :-<strong><br>
                </strong>Put Update files/folders/or picture to ewtadmin/ewt/update_to_all And run program</div>
            </div></td>
            <td width="11%">&nbsp;</td> 
          </tr>
          <tr align="center"> 
            <td height="10" colspan="2"><input type="submit" name="Submit" value="Ready and Run">
              <input name="Flag" type="hidden" id="Flag" value="<?php echo $_SESSION["FlagCopyAll"]; ?>"><input name="start" type="hidden" id="start" value="0">
              <input type="reset" name="Submit2" value="Reset"></td>
          </tr>
		  </form>
</table>
	</td>
  </tr>
  <tr>
    <td valign="top" ><font size="2" face="Tahoma"><strong><?php echo $txt; ?></strong></font></td>
  </tr>
</table></td>
    <td width="1"><?php include("com_right.php"); ?></td>
  </tr>
  <tr valign="top"> 
    <td height="1" colspan="3"> 
      <?php include("com_bottom.php"); ?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
}
$db->db_close();
?>
