<?php
include("authority.php");

?>
<?php
if($_REQUEST["Flag"] == "ADD"){
$Sel = $db->query("SELECT * FROM n_member WHERE m_email = '".$_POST["newsletteremail"]."'");
if(!$rows = mysql_num_rows($Sel)){ 
$SQL = $db->query("insert into n_member ( `m_id` , `m_email` , `m_active` , `m_reg` , `m_date` ) VALUES ('','".$_POST["newsletteremail"]."','','',NOW( ))");
$Sel1 = $db->query("SELECT m_id FROM n_member WHERE m_email = '".$_POST["newsletteremail"]."'");
$R = mysql_fetch_array($Sel1);
$db->write_log("create","enews","สร้างสมาชิก E-news letter   ".$_POST["newsletteremail"]);
}else{
$Flag = "ERROR";
}
}elseif($_POST["Flag"] == "ADD2"){
for($i=0;$i<$_POST["allgroup"];$i++){
$gp = "gp".$i;
$gp = $_POST[$gp];
if($gp != ""){
$INS = $db->query("INSERT INTO n_group_member ( m_id , g_id ) VALUES ( '".$_POST["memid"]."','$gp' )");
$db->write_log("create","enews","สร้างกลุ่มข่าวให้กับสมาชิก E-news letter");
}
}
?>
<script language="JavaScript">
window.opener.location.reload();
window.close();
</script>
<?php
}
?>
<html>
<head>
<title>Subscriber detail</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php if($Flag == "ERROR" || $_POST["Flag"] == ""){ ?>
<br>
  <br>
  <?php if($Flag == "ERROR"){ ?>
  <div align="center">
     <font color="#FF0000" >"<?php echo $_POST["newsletteremail"]; ?>" มีข้อมูลอยู่แล้ว.</font></div>
  <?php } ?>
<table width="90%" border="0" align="center" class="table table-bordered">
<form name="NewsLetterForm" method="post" action="" onSubmit="return ChkValueNewsLetter();">
  <tr bgcolor="#8D91A0" class="ewttablehead">
    <td height="35" colspan="2">เพิ่มสมาชิก</td>
    </tr>
  <tr bgcolor="ECEBF0">
    <td width="30%" bgcolor="#FFFFFF">Email</td>
    <td width="70%" bgcolor="#FFFFFF">
      <input class="form-control" style="width:80%;" name="newsletteremail" type="text" id="newsletteremail" >    </td>
  </tr>
  <tr bgcolor="ECEBF0">
    <td colspan="2" align="center" bgcolor="#FFFFFF">
	<input type="submit" name="Submit" value="ตกลง" class="btn btn-success btn-ml" />
      <input name="Flag" type="hidden" id="Flag" value="ADD"></td>
  </tr></form><script language="JavaScript">
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
	}
function validEMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			//return false;
			if (mailObj.value.search("^.+@.+\\..+$") != -1)
				return true;
			else return false;
 		}
		return true;
	}
function ChkValueNewsLetter(){
if(document.NewsLetterForm.newsletteremail.value == ""){
alert('Enter your email');
document.NewsLetterForm.newsletteremail.focus();
return false;
}else if(!validEMail(document.NewsLetterForm.newsletteremail)){
alert('Email format is invalid');
document.NewsLetterForm.newsletteremail.select();
return false;
}
}
</script>
</table>
<?php }else{ 
$sel = "select * from n_group,article_group where c_id = g_name and ";
$sel .= " `n_group`.`g_name` !=  '' order by g_id desc ";	
//$Sel1 = $db->query("SELECT * FROM n_group ORDER BY g_name ");
$Sel1 = $db->query($sel);
?>
<table width="85%" border="0" align="center" cellpadding="3" cellspacing="2" bordercolor="<?php echo $NLTHeadBG; ?>" class="ewttableuse">
  <form name="NewsLetterFormSubmit" method="post" action="member_add.php" onSubmit="return ChkValueNewsLetterSubmit();">
  <tr class="ewttablehead">
    <td height="35" align="center">เลือกกลุ่ม</td>
  </tr>
  <?php 
  $i=0;
  while($RR=mysql_fetch_array($Sel1)){ 
  ?>
  <tr>
    <td align="left" bgcolor="#FFFFFF" ><input type="checkbox" name="gp<?php echo $i; ?>" value="<?php echo $RR[g_id]; ?>">
     <?php echo $RR['c_name'];?></td>
  </tr>
  <?php 
  $i++;
} ?>
  <tr>
    <td height="35" align="right" bgcolor="#FFFFFF">
    <input name="Flag" type="hidden" id="Flag" value="ADD2"> <input name="allgroup" type="hidden" id="allgroup" value="<?php echo $i; ?>">
	<input name="memid" type="hidden" id="memid" value="<?php echo $R[m_id]; ?>">
      <input type="submit" name="Submit" value="Submit"></td>
  </tr>
  </form>
</table>
<script language="JavaScript">
function ChkValueNewsLetterSubmit(){
for(i=0;i<document.NewsLetterFormSubmit.allgroup.value;i++){
if(document.NewsLetterFormSubmit.elements["gp"+i].checked){
var c =1;
}
}
if(c != 1){
alert("Please choose your interested news group");
return false;
}
}
</script>
<?php } ?>
</body>
</html>
