<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title>Article Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function loading(c,d,e,f){
	if(e.innerHTML == ""){
		e.innerHTML = "Loading.........Please wait......................";
	load_data.location.href = "article_load1.php?nid=<?php  echo $_GET["nid"]; ?>&usr="+d+"&id="+c;
	f.src = "../images/minus.gif";
	}else{
		e.innerHTML = " ";
		f.src = "../images/plus.gif";
	}
	
}
function send(){
var c = document.getElementsByName("use").length;

for(i=0;i<c;i++){
		if(document.getElementsByName("use")[i].checked == true){
      document.getElementById("txtuse").value=document.getElementById("txtuse").value+ "@" + document.getElementsByName("use")[i].value;
		}	
    else{
      document.getElementById("txtnouse").value=document.getElementById("txtnouse").value+ "@" + document.getElementsByName("use")[i].value;
    }
	}
form1.submit();
}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<form name="form1" method="post" action="article_share_function1.php">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<?php
$sql_site = $db->query("SELECT UID,EWT_User FROM user_info WHERE EWT_User = '".$_SESSION["EWT_SUSER"]."' ");
$M = $db->db_fetch_row($sql_site);
?><input type="checkbox" name="use" value=""  style="display:none">		
<input type="hidden" name="UID" value="<?php echo $M[0]; ?>">
			<input type="hidden" name="USER" value="<?php echo $M[1]; ?>">
          	<input type="hidden" name="nid" value="<?php echo $_GET["nid"]; ?>">
			<input type="hidden" id="txtnouse" name="txtnouse" value="">
			<input type="hidden" id="txtuse" name="txtuse" value="">
      <td height="40"><strong>Update target to share article >></strong> 
        <input type="button" name="Button" value="Save" onClick="send();"><iframe name="load_data"  frameborder="0"  width="1" height="1" scrolling="no" >
        
        </iframe><hr size="1"></td>
  </tr>
  <tr>
          
    <td><img src="../images/workplace.gif" width="20" height="20" border="0" align="absmiddle"> 
      <strong>My Website</strong>
      </td>
  </tr>
  <?php
  $sql_group = $db->query("SELECT UID,WebsiteName,EWT_User FROM user_info WHERE EWT_Status = 'Y'");
  $i = 1;
  	while($R = $db->db_fetch_array($sql_group)){
  ?>
        <tr> 
          
    <td> <a  href="#get" onClick="loading('<?php echo $i; ?>','<?php echo $R[2]; ?>',document.all.tdview<?php echo $i; ?>,document.all.img<?php echo $i; ?>);"><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><img id="img<?php echo $i; ?>" src="../images/plus.gif" width="21" height="21" border="0" align="absmiddle"><img src="../images/share.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<b><?php echo $R[2]; ?> 
      (<?php echo $R[1]; ?>)</b></a> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="60"></td>
          <td   id="tdview<?php echo $i; ?>"></td>
        </tr>
      </table> </td>
  </tr>
  <?php $i++; } ?>
  </table></form>
</body>
</html>
<?php $db->db_close(); ?>
