<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);
@include("language/language.php");
//$process=$HTTP_POST_VARS['process'];
//$a_url=$HTTP_POST_VARS['a_url'];
//$a_site=$HTTP_POST_VARS['a_site'];
//$a_description=$HTTP_POST_VARS['a_description'];
//$gid=$HTTP_POST_VARS['gid'];
$id = $_GET[id];
if($id != ''){
$lable = 'แก้ไข';
}else{
$lable = 'เพิ่ม';
}

						$recedit=$db->db_fetch_array($db->query("SELECT * FROM n_address WHERE id='".$id."'"));
						$a_site=$recedit['a_site'];
						$a_description=$recedit['a_description'];
						$a_url=$recedit['a_url'];
						$chkgid=$recedit['a_groupid'];
?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript">
function ChkAddress(f){
	if (f.a_site.value==''){
	  alert("<?php echo $text_genaddress_alertsitename;?>");
	  f.a_site.focus();
	}else if (f.a_url.value=='http://'){
	  alert("<?php echo $text_genaddress_alertUrl;?>");
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
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="mainpic/m_address.gif" width="24" height="24" align="absmiddle"> <span class="myhead_02">บริหารข้อมูล Address</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp;<a href="address_main.php"><img src="mainpic/m_home.gif" width="24" height="24" border="0" align="absmiddle">กลับ</a>
      <hr>
    </td>
  </tr>
</table>
<form name="form1" action="address_function.php" method="post" onSubmit="return ChkAddress(this);">
              <input type="hidden" name="process" value="<?php echo $_GET[process];?>">
			  <input type="hidden" name="id" value="<?php echo $id;?>">
              <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
                <tr>
                  <td bgcolor="#CCCCCC" colspan="2"><strong><?php echo $lable;?>ข้อมูล Address</strong></td>
                </tr>
                <tr>
                  <td width="21%" bgcolor="#FFFFFF"><strong><?php echo $text_genaddress_textsitename;?> :</strong></td>
                  <td width="79%" bgcolor="#FFFFFF"><input type="text" name="a_site" class="textbox" size="50" id="a_site" value="<?php echo $a_site;?>"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><strong><?php echo $text_genaddress_textDescription;?> : </strong></td>
                  <td bgcolor="#FFFFFF"><input type="text" name="a_description" class="textbox" size="50" id="a_description" value="<?php echo $a_description;?>"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF"><strong><?php echo $text_genaddress_textURL;?> :</strong></td>
                  <td bgcolor="#FFFFFF"><input type="text" name="a_url" class="textbox" size="50" value="<?php if($a_url==''){ echo 'http://';}else{ echo $a_url;}?>" id="a_url"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" valign="top"><strong><?php echo $text_genaddress_textGroup;?> :</strong></td>
                  <td bgcolor="#FFFFFF"><!--<iframe name="list_send" src="groupaddress_list.php?chkgid=<?php//php echo $chkgid;?>" frameborder="0" width="100%" align="top" height="100" scrolling="yes"></iframe>-->
                   
                      <select name="gid" id="gid">
					  <option value="">----ไม่เลือกกลุ่ม----</option>
					  <?php 
					  $sqlgroup="SELECT * FROM n_groupaddress WHERE gen_user_id ='".$HTTP_SESSION_VARS['EWT_MID']."' ORDER BY ganame ASC";
					  $querygroup=$db->query($sqlgroup);
					  $numgroup= $db->db_num_rows($querygroup);
					  while($recgroup=$db->db_fetch_array($querygroup)){
					  
					  ?>
					  <option value="<?php echo $recgroup['id'];?>" <?php if($chkgid==$recgroup['id']){ echo "selected"; }else{ echo "";}?>><?php echo $recgroup['ganame'];?></option>
					  <?php
					  }
					  ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" align="center" colspan="2"><input type="submit"name="Input2" class="submit" value="<?php echo $text_genaddress_buttonSave;?>">
                    &nbsp;</td>
                </tr>
              </table>
</form>
</body>
</html>
<?php  $db->db_close(); ?>
