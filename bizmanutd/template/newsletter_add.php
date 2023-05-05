<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

function random_codex($len){
	srand((double)microtime()*10000000);
	$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
	$ret_str = "";
	$num = strlen($chars);
	
	for($i=0;$i<$len;$i++){
		$ret_str .= $chars[rand()%$num];
	}
	
	return $ret_str;
}
$process=$HTTP_POST_VARS['process'];
$allgroup=$HTTP_POST_VARS['allgroup']; 
?>
<html>
<head>
<title>Add To Favorite</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet"  href="css/style.css" type="text/css">
<script src="js/selectlist2.js" language="javascript1.2"></script>
<script src="js/AjaxRequest.js" language="javascript1.2"></script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="90%" border="0" cellspacing="1" cellpadding="1" align="center">
  <tr>
    <td> <br>
		<?php
			if($process=='new'){ 
					$sql_user = "select email_person from gen_user where gen_user_id ='".$_SESSION["EWT_MID"]."'";
					$query_user = $db->query($sql_user);
					$rec_user = $db->db_fetch_array($query_user);
					
				    $Randompassword = random_codex(8);

                    $db->query("USE ".  $EWT_DB_NAME);
					$db->query("insert into n_member ( `m_id` , `m_email` , `m_active` , `m_reg` , `m_date` ) 
					             VALUES ('','$rec_user[email_person]','Y','$Randompassword',NOW( ))");
 
					$Sel1 = $db->query("SELECT m_id FROM n_member WHERE m_email = '$rec_user[email_person]'");
					$R = mysql_fetch_array($Sel1); 
					
					for($i=0;$i<$allgroup;$i++){
							$gp = "gp".$i;
							$gp = $$gp;
							if($gp != ""){  $db->query("INSERT INTO n_group_member ( m_id , g_id ) VALUES ( '$R[m_id]','$gp' )"); }
					}
					?>
					<script language="javascript"> 
                                window.opener.document.location.href='ewt_mysite.php' ;
								window.close();
					</script>
					<?php
			}else{
		?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		  <tr bgcolor="#FFFFFF"> 
              <td colspan="2"><img src="mainpic/mail2.gif" align="absmiddle">  <font size="3"><strong>สมัครบริการรับจดหมายข่าว</strong></font></td>
		  </tr>
	 </table> <br>
		   
	<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  bgcolor="#999999" >
  		<form name="NewsLetterFormSubmit" method="post" action="<?php $HTTP_SERVER_VARS['PHP_SELF']?>" >
 		 <tr>
  			<td><strong>เลือกกลุ่มข่าวที่คุณต้องการรับ</strong></td>
  		</tr>
  		<?php  $i=0;  ?>
  		<tr>
    		<td height="70" bgcolor="#FFFFFF" >
      			<table width="100%" border="0">
  				<?php
				
				$db->query("USE ".  $EWT_DB_NAME);
				$Sel = $db->query("SELECT * FROM n_group,article_group where c_id = g_name ORDER BY g_name ");
				while($RR=mysql_fetch_array($Sel)){ 
  						//$Sel2 = $db->query("SELECT * FROM n_group_member WHERE m_id = '$R[m_id]' AND g_id ='$RR[g_id]'");
						//$rowy = mysql_num_rows($Sel2);
				?>
					<tr>
						<td >
							<input type="checkbox" name="gp<?php echo $i; ?>" value="<?php echo $RR[g_id]; ?>" <?php if($rowy>0){ echo "checked"; } ?>> 
							<?php echo $RR[c_name]; ?>
						</td>
					</tr>
					  <?php 
					  $i++;
			} ?>
            </table>
</td>
</tr>
  <tr>
    <td >
	 <input name="process" type="hidden" id="process" value="new">
	 <input name="allgroup" type="hidden" id="allgroup" value="<?php echo $i;?>">
	  <input type="submit" name="Submit" value="สมัครสมาชิก"></td>
  </tr>
  </form>
</table>
		<?php }?>
	</td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
