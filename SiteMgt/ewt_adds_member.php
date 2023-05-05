<?php
session_start();
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);

if($_GET[ug]==''){
$_GET[ug] = $_SESSION["EWT_SUID"];
}

include("../lib/config_path.php");
include("../header.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script language="javascript1.2">
function show_txt(t){
	if(t=='0'){
		document.getElementById('fname').style.display = '';
		document.getElementById('org_id').style.display = 'none';
		document.getElementById('org_id').value = '';
	}else{
	document.getElementById('fname').style.display = 'none';
	document.getElementById('fname').value = '';
	document.getElementById('org_id').style.display = '';
	}
}
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
function txt_data(w) {
	var mytop = findPosY(document.form1.org_id) +document.form1.org_id.offsetHeight;
	var myleft = findPosX(document.form1.org_id);	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='nav_pad.php?d='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
			}
		}
	);
	
}
</script>
</head>

<body leftmargin="0" topmargin="0" >
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>


<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#E0DFE3">
<tr>
<td>
	<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#919B9C">
	<tr>
	<td bgcolor="#F7F7F7">
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
							<td width="100" align="center" background="../images/bg1_on.gif">ค้นหาเจ้าหน้าที่ </td>
                      <!--<td width="100" align="center" background="../images/bg3_off.gif"><a href="ewt_s_member2.php?ug=<?php echo $_GET["ug"]; ?>">แผนก/หน่วยงาน</a> </td> ->
							<td width="100" align="center" background="../images/bg3_off.gif"><a href="ewt_adds_member4.php?ug=<?php echo $_GET["ug"]; ?>">กลุ่มผู้ใช้งาน</a></td>
							<td background="../images/bg2_off.gif">&nbsp;</td>
							</tr>
					  </table>-->
<ul class="nav nav-tabs">
  <li class="active"><a href="#">ค้นหาเจ้าหน้าที่</a></li>
  <li><a href="ewt_adds_member4.php?ug=<?php echo $_GET['ug']; ?>">กลุ่มผู้ใช้งาน</a></li>
</ul>					  					  
</td>
</tr>
                    
<tr> 
<td> 
<div class="clearfix">&nbsp;</div>
<form name="form1" method="post" action="ewt_adds1_member.php" target="m_data" class="form-inline">	

<div class="form-group row form-inline">
<div class="col-md-4 col-sm-4 col-xs-4 form-inline ">
<label for="category_name">ค้นหาโดย : </label>
<select name="search_title" onChange="show_txt(this.value)" class="form-control" style="width:98%">
							  <option value="0">ชื่อ-สกุล</option>
							  <option value="1">หน่วยงาน</option>
</select> 
</div>

<div class="col-md-8 col-sm-8 col-xs-8 form-inline">
<label for="category_name"> &nbsp;</label>
<input name="fname" type="text" id="fname" class="form-control" />
<input name="org_id" type="text" id="org_id" onKeyUp="txt_data(this.value)"  autocomplete="off"  style="display:none" class="form-control" />
</div>
</div>

<div class="form-group row">	  
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<input type="submit" name="Submit2" value="Find Now..." class="btn btn-info" >
<!--<input type="button" name="CheckAD" value="Check New AD User "  class="btn btn-info" onClick="document.m_data.location.href='ad_checker.php'">-->
<input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>">
</div>
</div>
 </form>
					<!--<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <form name="form1" method="post" action="ewt_adds1_member.php" target="m_data">		
					<tr> 
                    <td width="5" background="../images/content_bg_line.gif"></td>
                    <td >&nbsp;&nbsp;&nbsp; ค้นหาโดย
                              <select name="search_title" onChange="show_txt(this.value)">
							  <option value="0">ชื่อ-สกุล</option>
							  <option value="1">หน่วยงาน</option>
                              </select> 
                              <input name="fname" type="text" id="fname" size="50">
							  <input name="org_id" type="text" id="org_id" onKeyUp="txt_data(this.value)" size="50" autocomplete="off"  style="display:none">
								 <!-- <select name="org_id"  id="org_id"  style="display:none">
								  <option value="">--โปรดเลือก--</option>
								  <?php
							//	  $sql_unit =$db->query("SELECT * FROM org_name");
							//	  while($rec = $db->db_fetch_array($sql_unit)){
							//		print "<option value='".$rec[org_id]."'>".$rec[name_org]."</option>";
							//	  }
								  ?>
								</select>->
                              <input type="submit" name="Submit2" value="Find Now..." >
                              <input type="button" name="CheckAD" value="Check New AD User " onClick="document.m_data.location.href='ad_checker.php'">
                                <input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>">
                              </td>
                          </tr>
						  </form>
                        </table>-->
					</td>
					</tr>
					
<tr> 
<td>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#919B9C">
<tr> 
<td bgcolor="#FFFFFF"><iframe name="m_data"  frameborder="0"  width="100%" height="220" scrolling="yes" ></iframe>
</td>
</tr>
</table>
</td>
</tr>

<tr> 
<td >
<div class="form-group row">	  
<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
					  <input class="btn btn-success btn-ml" name="btapply" type="button" disabled id="btapply" onClick="m_data.form1.submit();" value="&nbsp;&nbsp;OK&nbsp;&nbsp;">
					  <input class="btn btn-warning btn-ml" type="submit" name="Submit" value="&nbsp;&nbsp;Cancel&nbsp;&nbsp;" onClick="self.close();">
</div>
</div>

		
</td>
</tr>
 
 
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close();
?>
