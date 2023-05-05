<?php
include("authority.php");
?>
<?php 

if($flag == 'Edit'){

	$sel = "select * from n_group where g_id = '$gid'";
	$r = $db->query($sel);
	$R = mysql_fetch_array($r);
}
?>
<html>
<head>
<title>Newsletter Group Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<SCRIPT language=JavaScript>
<!--
	 function emptyField(textObj) {
	   if (textObj.value.length == 0)
    		 return true;
	   for (var i=0; i<textObj.value.length; ++i) {
		     var ch = textObj.value.charAt(i);
		     if (ch != ' ' && ch != '	')
		        return false;
	   }
	   return true;
	 } 

	function  validateForm() {
if (emptyField(document.form1.g_name)){
				alert("<?php echo $lang_valid_name_group; ?>");
				document.form1.g_name.focus();
				return false;
		}

return true;
	}		
	function chk_count(){
	var num = document.form1.num.value;
	var count_t = 0;
		for(_i=0;_i<num;_i++){
			if(document.getElementById('article_'+_i).checked == true){
			count_t +=1;
			}else{
			count_t +=0;
			}
		}
		if(count_t==0){
		alert("กรุณาเลือกกลุ่มข่าว");
		return false;
		}
		return true;
	}																												//end function()
//-->
</script>
</head>

<body bgcolor="#FFFFFF">
<form name="form1" method="post" action="group_function.php" onSubmit="return chk_count();">
  <table width="95%" border="1" align="center" cellpadding="0" cellspacing="1" bordercolor="B2B4BF">
    <tr bgcolor="#33CCFF"> 
      <td height="30" bgcolor="B2B4BF"> <b><font face="MS Sans Serif" size="1">&nbsp;<?php echo $lang_group_title; ?></font></b></td>
    </tr>
    <tr> 
      <td> 
        <table width="100%" border="0" cellpadding="2" cellspacing="1">
		<?php
		$i=0;
		$sql = $db->query("select * from article_group");
		while($R = $db->db_fetch_array($sql)){
		$sql_news =$db->query("select * from n_group where g_name ='".$R[c_id]."'");
		if(mysql_num_rows($sql_news)==0){
		
		?>
          <tr bgcolor="ECEBF0"> 
            <td width="5%" height="20"><input type="checkbox" name="article_<?php echo $i;?>" value="<?php echo $R[c_id];?>"  id="article_<?php echo $i;?>"></td>
            <td width="95%" height="20"><?php echo $R[c_name];?></td>
          </tr>
		  <?php $i++; } } ?><input type="hidden" name="num" value="<?php echo $i;?>">	
        </table>
      </td>
    </tr>
    <tr bgcolor="#33CCFF"> 
      <td bgcolor="B2B4BF" height="27"> 
        <div align="right"> 
          <?php 
if($flag == 'Edit'){
?>
          <input type="hidden" name="flag" value="Edit">
	    	<input type="hidden" name="gid" value="<?php echo $R['g_id'];?>">	
			<input type="hidden" name="gn" value="<?php echo $R['g_name'];?>">	
<?php }else{ ?>
          <input type="hidden" name="flag" value="Add">
<?php } ?>
          <input type="submit" name="Submit" value="บันทัก">
        </div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
