<?php
session_start();
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
if($_GET[ug]==''){
$_GET[ug] == $_SESSION["EWT_SUID"];
}

include("../lib/config_path.php");
include("../header.php");	
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
</head>

<body>

<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="E0DFE3">
<tr>
<td>

<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
<tr>
<td bgcolor="F7F7F7">

<table width="98%"  border="0" cellpadding="3" cellspacing="0" align="center">
<tr>
<td height="50"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="middle"> 
<strong>Add User</strong>
</td>
</tr>
<tr>
<td valign="top">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr height="25"> 
<td align="center" >

<!--<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr height="25"> 
<td width="100" align="center" background="../images/bg1_off.gif"><a href="ewt_adds_member.php?ug=<?php echo $_GET["ug"]; ?>">รายบุคคล</a> </td>
                      <!--<td width="100" align="center" background="../images/bg1_off.gif"><a href="ewt_s_member2.php?ug=<?php echo $_GET["ug"]; ?>">แผนก/หน่วยงาน</a> </td> ->
					 <td width="100" align="center" background="../images/bg1_on.gif">กลุ่มผู้ใช้งาน</td>
                      <td background="../images/bg2_off.gif">&nbsp;</td>
                    </tr>
</table>-->
<ul class="nav nav-tabs">
<li><a href="ewt_adds_member.php?ug=<?php echo $_GET['ug']; ?>">กลุ่มผู้ใช้งาน</a></li>
<li class="active"><a href="#">รายบุคคล</a></li> 
</ul>
<div class="clearfix">&nbsp;</div>
</td>
</tr>
                    
<tr> 
<td>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
<tr> 
<td bgcolor="#FFFFFF">
<iframe name="m_data1" src="ewt_adds4_member.php?ug=<?php echo $_GET["ug"]; ?>"  frameborder="0"  width="100%" height="300" scrolling="yes" ></iframe>
</td>
</tr>
</table>
</td>
</tr>
					
<tr > 
<td>
<div class="form-group row">	  
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
					  <input class="btn btn-success btn-ml" name="btapply" type="button" disabled id="btapply" onClick="m_data1.form1.submit();" value="&nbsp;&nbsp;OK&nbsp;&nbsp;">
					  <input class="btn btn-warning btn-ml" type="submit" name="Submit" value="&nbsp;&nbsp;Cancel&nbsp;&nbsp;" onClick="self.close();">
</div>
</div>					 
</td>
</tr>
</table>
</td>
</tr>
</table>


</td>
</tr>
</table>
</td>
</tr>
</table>

</body>
</html>
<?php
$db->db_close();
?>
