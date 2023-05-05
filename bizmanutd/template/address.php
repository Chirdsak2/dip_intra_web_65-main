<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);
@include("language/language.php");
$process=$HTTP_POST_VARS['process'];
$allrecord=$HTTP_POST_VARS['allrecord'];
$id=$HTTP_POST_VARS['id'];

?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript">
function ChkAddress(f){
	if (f.a_site.value==''){
	  alert("กรุณากรอก Sitename");
	  f.a_site.focus();
	}else if (f.a_url.value=='http://'){
	  alert("กรุณากรอก URL ");
	  f.a_url.focus();
	}else {
	  return true;
	}
	return false;
}
	function checkfeeall(totalrec){
		if(document.getElementById('chkfeeall').checked == true){
			for(i=1; i<=totalrec.value; i++){
				document.getElementById("chkfee"+i).checked=true;		
			}
		}else{
			for(i = 1; i<=totalrec.value;i++){
				document.getElementById("chkfee"+i).checked=false;
			}
		}
	}
	function checkfeeeach(totalrec){
		var num = 0
		for(i = 1; i<=totalrec.value;i++){
			if(document.getElementById("chkfee"+i).checked==true){
				num = num+1
			}
		}
		if(num==totalrec.value){
			document.getElementById('chkfeeall').checked = true;
		}else{
			document.getElementById('chkfeeall').checked = false;
		}
	}	

</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><br>
                  <table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666"><?php echo $text_genaddress_headtitle;?></font></strong></font>
                  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
				   <span class="mytext_normal">
				   <strong>
				   <a href="address_main.php" target="address_body"><img src="mainpic/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> บริหารข้อมูล Address</a>&nbsp;&nbsp;&nbsp;&nbsp;
				    <a href="groupaddress_list.php" target="address_body"><img src="mainpic/folder_closed.gif" width="16" height="16" border="0"  align="absmiddle">บริหารกลุ่ม Address</a>
				</strong>
				</span>					</td>
                    </tr>
                  </table>
                  <br>
				  
<table width="100%" height="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="address_body" src="address_main.php"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table>
     </td>
              </tr>
            </table></td>
          <td width="5" height="100%" background="mainpic/bg_r.gif">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>

</body>
</html>
<?php  $db->db_close(); ?>
