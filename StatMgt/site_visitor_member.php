<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$con = stripslashes(urldecode($_GET["con"]));
?>
<html>
<head>
<title>Stat</title>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<h5>Member Visitor</h5><hr size="1">

<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#CECECE" class="ewttableuse">

<tr > 
	<td>สมาชิก</td>
	<td>จำนวนครั้ง</td>
</tr>
<?php
	$sql = $db->query("SELECT sv_mem_id,count(sv_id) as number FROM stat_visitor 
	                    WHERE sv_url = 'page' ".$con." 
						GROUP BY sv_mem_id
						ORDER BY count(sv_id)"); 
	while($R = mysql_fetch_row($sql)){ 
		 ?>
		 <tr bgcolor="#FFFFFF"> 
			<td>
			<?php 
			 if($R[0]=='0'){ 
			    echo "ผู้ใช้ภายนอกระบบ"; 
			}else{
			    //echo "ผู้ใช้ภายนอกระบบ "; echo "".$R[0]."";
				//$db->query("USE ".$EWT_DB_NAME);
				//$query=$db->query("USE ".$EWT_DB_NAME); 

				//$selete_user="SELECT  * FROM  `gen_user`
										  //LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
										  //LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) Where  gen_user.gen_user_id='$emp_id'  ";
			   //$exec_user=$db->query($selete_user);
			   //$rst_user = $db->db_fetch_array($exec_user);
			   //echo $rec[title_thai]." ".$rst_user[name_thai]."&nbsp;&nbsp;".$rst_user[surname_thai]; 
			   
				//$db->query("USE ".$EWT_DB_USER);

			}
		    ?>
			</td>
			<td><?php echo "".$R[1].""; ?></td>
		</tr>
		 <?php
	}
	?>
        <tr bgcolor="#FFFFFF"> 
          <td>  </td><td>  </td>
        </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
