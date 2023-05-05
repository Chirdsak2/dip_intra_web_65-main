<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function open_w(p,s,w,w_n){
var link = "page_mapping.php?filename="+p+"&&select="+s+"&&web="+w+"&&web1="+w_n;
win = window.open(link,'LanguageOpen','top=100,left=80,width=240,height=480,resizable=1,status=0,scrollbars=1');
win.window.focus();
}
function submit_form(f){
		var link_t = 'proc_language_setup_page.php';
		form1.action = link_t;
		form1.submit();
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">กำหนดหน้าแต่ละภาษา</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp;
        <hr>
    </td>
  </tr>
</table>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
  <tr> 
    <td align="center" valign="top"><table width="94%" border="0" cellpadding="0" cellspacing="0"><form name="form1" method="post" action="">
        <tr>
          <td>เลือก website :
            <select name="select_web" onChange="window.document.form1.submit();">
                <option value="0" >== เลือก website ==</option>
                <?php
				$sql = "select * from lang_setting where lang_setting_status = 'Y'";
				$query = $db->query($sql);
				while($rec = $db->db_fetch_array($query)){
				$show = "";
				if($rec[lang_setting_id] == $select_web){
				$show = "selected";
				}
				echo "<option value=\"".$rec[lang_setting_id]."\" ".$show.">".$rec[user_info_website]."</option>";
				}
				?>
              </select>          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><?php if(!empty($select_web) || $select_web<>0){ ?><table width="94%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000" class="ewttableuse">
		  <?php
		 		 $sql_db = "select * from lang_setting where lang_setting_status = 'Y' and lang_setting_id ='$select_web'";
				$query = $db->query($sql_db);
				$rec_db=$db->db_fetch_array($query);
		  ?>
		  <tr class="ewttablehead">
              <td width="15%" align="center" bgcolor="#E7E7E7"><strong>ชื่อ file</strong></td>
              <td width="85%" align="center" bgcolor="#E7E7E7"><strong>ชื่อ file (<?php echo $rec_db[lang_setting_lang]?>)</strong>
                <input name="hdd_lang" type="hidden" value="<?php echo $rec_db[lang_setting_lang]?>"></td>
            </tr>
		  <?php
		  	$sql = "select * from temp_index order by filename ASC";
		 	$query = $db->query($sql);
			 while($rec=$db->db_fetch_array($query)){
			 $sql_2 = "select * from lang_page where temp_index_filename = '".$rec[filename]."' and lang_setting_id ='$select_web'";
			 $query_2 = $db->query($sql_2);
			 $rec_2=$db->db_fetch_array($query_2);
		  ?>
            <tr>
              <td bgcolor="#FFFFFF"><?php echo $rec[filename]?></td>
              <td bgcolor="#FFFFFF"><a href="#" onClick="open_w('<?php echo $rec[filename]?>','<?php echo $select_web?>','web_name<?php echo $rec[filename]?>','web_name1<?php echo $rec[filename]?>');"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0"></a>&nbsp;&nbsp;
                <input name="web_name1<?php echo $rec[filename]?>" type="hidden" value="<?php echo $rec_2[temp_index_filename_website]?>"><span id="web_name<?php echo $rec[filename]?>"><?php echo $rec_2[temp_index_filename_website]?></span></td>
            </tr>
			<?php } ?>
            <tr>
              <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="บันทึก"  onClick="return submit_form(this.form);"></td>
              </tr>

          </table><?php } ?></td>
        </tr>
      </form></table>
      
	</td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
