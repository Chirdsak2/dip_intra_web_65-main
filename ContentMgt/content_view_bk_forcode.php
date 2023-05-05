<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}


$group = "SELECT * FROM temp_main_group WHERE Main_Group_ID = '".$_GET["gid"]."'";
$sql_group= $db->query($group);
$G = $db->db_fetch_array($sql_group);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
			function hlah(c){
				var d = document.form1.num.value;
				for(i=0;i<d;i++){
				if(i == c){
					document.getElementById('ah'+i).style.backgroundColor = "#E6E6E6";
				}else{
					document.getElementById('ah'+i).removeAttribute("style");
				}
				}
			}
			function get_flag(c,d,e){
				var n = document.form1.rm_flag.value;
				if(c != n){
					document.form1.rm_flag.value = c;
					document.form1.rm_name.value = d;
					document.form1.rm_num.value = e;
				}else{
						document.form1.rm_flag.value = c;
				//	document.form1.rm_name.value = d;
					document.form1.rm_num.value = e;
					document.getElementById('rm_div'+e).innerHTML = "<input name=\"rm_new\" type=\"text\" value=\""+ document.form1.rm_name.value +"\" size=\"6\" onBlur=\"get_rm(this)\">";
					document.form1.rm_new.select();
				}
				}

				function get_rm(c){
					if (c.value.search("^[A-Za-z0-9_]+$")){
				alert("Folder name is limited to English character  (upper and lower case), number, and underscore only!");
				document.getElementById('rm_div'+document.form1.rm_num.value).innerHTML = document.form1.rm_name.value;
					}else if(c.value == document.form1.rm_name.value){
						document.getElementById('rm_div'+document.form1.rm_num.value).innerHTML = document.form1.rm_name.value;
					}else{
					document.getElementById('rm_div'+document.form1.rm_num.value).innerHTML = c.value;
					document.form1.rm_name.value = c.value;
					}
				}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<u>F</u>ile</td>
  </tr>
  <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <?php
  if(strlen($G["Main_Position"]) == 9){
  				$up_link = "content_index.php";
				$up_title = "My Website";
  }else{
  		$up = substr($G["Main_Position"], 0, -5);
		$sql_up = $db->query("SELECT * FROM temp_main_group WHERE Main_Position = '".$up."'");
		$U = $db->db_fetch_array($sql_up);
		  		$up_link = "content_view.php?gid=".$U["Main_Group_ID"];
				$up_title = $U["Main_Group_Name"];	
  }
  ?>
  <tr>
    <td height="25" bgcolor="F3F3EE">&nbsp;&nbsp;&nbsp;<a href="<?php echo $up_link; ?>" title="<?php echo $up_title; ?>"><img src="../images/content_folder_up.gif" width="24" height="24" border="0" align="absmiddle"> 
      Up</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="content_index.php"><img src="../images/content_home.gif" width="24" height="24" border="0" align="absmiddle"> 
      Home</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/content_new_folder.gif" width="24" height="24" border="0" align="absmiddle"> 
      New Folder &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="content_search.php"><img src="../images/content_folder_search.gif" width="24" height="24" border="0" align="absmiddle"> 
      Search</a> </td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr> 
    <td height="20" bgcolor="F3F3EE"><table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td width="10%">Address : </td>
          <td width="83%"><table width="90%" border="0" cellpadding="2" cellspacing="1" bgcolor="66667E">
              <tr>
                <td bgcolor="#FFFFFF"><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> 
                  <?php echo $G["Main_Group_Name"]; ?></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
    <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <?php
  $num = strlen($G["Main_Position"]);
  $num_len = $num + 5;
  	if($EWT_DB_TYPE == "MYSQL"){
		$sql_folder = "SELECT * FROM temp_main_group WHERE Main_Position LIKE '".$G["Main_Position"]."_%' AND length(Main_Position) = '$num_len' ORDER BY Main_Position ASC";
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql_folder = "SELECT * FROM temp_main_group WHERE Main_Position LIKE '".$G["Main_Position"]."_%' AND len(Main_Position) = '$num_len' ORDER BY Main_Position ASC";
	}
  
  $sql_group = $db->query($sql_folder);
  $i=0;
  ?>
  <form name="form1" method="post" action="">
  <tr>
    <td valign="top">
	<DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"><br>
          <table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" >
  <?php
  	while($R = $db->db_fetch_array($sql_group)){
		if($i%4 == 0){
			echo "<tr bgcolor=\"#FFFFFF\">";
		}
  ?>
         
         <td width="25%" align="center" id="ah<?php echo $i; ?>" onClick="hlah('<?php echo $i; ?>')" onDblClick="self.location.href='content_view.php?gid=<?php echo $R["Main_Group_ID"]; ?>';"><img src="../images/content_folder.gif" width="24" height="24" border="0" align="absmiddle"><div id="rm_div<?php echo $i;?>" onClick="get_flag('<?php echo $R["Main_Group_ID"]; ?>','<?php echo $R["Main_Group_Name"]; ?>','<?php echo $i;?>')"><?php echo $R["Main_Group_Name"]; ?></div> 
            </a> </td>
  <?php
  		if($i%4 == 3){
			echo "</tr>";
		}
   $i++; } ?>
    <?php
  $sql_page = $db->query("SELECT * FROM temp_index WHERE Main_Group_ID = '".$G[Main_Group_ID]."' ORDER BY filename ASC");
  	while($P = $db->db_fetch_array($sql_page)){
			if($i%4 == 0){
				echo "<tr bgcolor=\"#FFFFFF\">";
			}
  ?>
            <td width="25%" align="center"  id="ah<?php echo $i; ?>"  onClick="hlah('<?php echo $i; ?>')"><img src="../images/content_page.gif" width="24" height="24" border="0" align="absmiddle"><div><?php echo $P["filename"]; ?></div>
            </td>
  <?php 
    		if($i%4 == 3){
				echo "</tr>";
			}
  $i++; } ?>
  <?php 
 			 if($i%4 == 1){
				echo "<td width=25%></td><td width=25%></td><td width=25%></td></tr>";
			}elseif($i%4 == 2){
				echo "<td width=25%></td><td width=25%></td></tr>";
			}elseif($i%4 == 3){
				echo "<td width=25%></td></tr>";
			}
  ?>
</table>
<?php 
if($i == 0){
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="0">
          <tr> 
              <td height="50" align="center">This folder is empty.</td>
  </tr>
</table>
<?php  }  ?>
</DIV>
</td>
  </tr>
  <input name="num" type="hidden" id="num" value="<?php echo $i; ?>">
  <input name="rm_flag" type="hidden" id="rm_flag" value="0">
  <input name="rm_name" type="hidden" id="rm_name" value="">
  <input name="rm_num" type="hidden" id="rm_num" value="0">
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
