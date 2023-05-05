<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
if($flag=='chang'){
$db->query("update w_question set c_id = '$wcad_new' where t_id ='$wtid'");
?>
<script  language="JavaScript1.2">
window.opener.location.href = "index_answer.php?wcad=<?php echo $wcad_new; ?>&wtid=<?php echo $wtid; ?>";
window.close();
</script>
<?php
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          
    <td valign="top" bgcolor="F7F7F7"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr> 
          <td colspan="2"  height="20"> <img src="../../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
            <strong>ย้ายไปยังหมวดหมู่กระทู้</strong></td>
        </tr>
        <?php
					$sql ="select * from w_cate where c_id <> '$wcad'";
					$query = $db->query($sql);
					while($rec = $db->db_fetch_array($query)){
					?>
        <tr bgcolor="#FFFFFF"> 
          <td width="10%" height="34" bgcolor="#FFFFFF"><a href="chang_grouupquestion.php?flag=chang&wcad=<?php echo $wcad;?>&wtid=<?php echo $wtid;?>&wcad_new=<?php echo $rec[c_id];?>">เลือก</a></td>
          <td width="90%"><strong><?php echo $rec[c_name];?></strong></td>
        </tr>
        <?php } ?>
      </table></td>
        </tr>
      </table>
</body>
</html>
<?php
$db->db_close();
?>
