<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");

$txt = "";
$txta = "";
if($_POST["Flag"]=="SQL" AND $_POST["st_db"] != "" AND $_POST["en_db"] != ""){

    $result = mysql_list_tables($_POST["st_db"]);

    for ($i = 0; $i < mysql_num_rows($result); $i++){
		$tb = mysql_tablename($result, $i);
        $txt .= "<hr>Check >> ".$tb."<br>";

		$result1 = mysql_query("SHOW FIELDS FROM ".$tb);
		$columns1 = mysql_num_rows($result1);
		$field_ns = array();
		$field_ts = array();
		$field_ds = array();
		$field_us = array();
		$field_es = array();
		$y = 0;
		while($row = mysql_fetch_array($result1)){
			$field_ns[$y] = $row['Field'];
			$field_ts[$y] = $row['Type'];
			$field_ds[$y] = $row['Default'];
			$field_us[$y] = $row['Null'];
			$field_es[$y] = $row['Extra'];
		$y++;
		}
			$schema_c = "";
			$resultc = mysql_query("SHOW CREATE TABLE ".$tb);
            if ($resultc != FALSE && mysql_num_rows($resultc) > 0) {
                $tmpres        = mysql_fetch_array($resultc);
                $schema_c .= $tmpres[1];
            }
			if($schema_c != ""){
			$schema_c .= ";\n";
			}

	mysql_query("USE ".$_POST["en_db"]) or die(mysql_error());
		$result2 = mysql_query("SELECT COUNT( * ) FROM ".$tb);
		$columns2 = mysql_num_rows($result2);
		if($columns2 == "" OR $columns2 == 0){
			$txt .= "<font color=red>Table ".$tb." not found</font><br>";
			$txta .= $schema_c;

		}else{
				$txt .= "<table border=1>";
				$txt .= "<tr><td>Field(s)</td><td>Type(s)</td><td>&nbsp;</td><td>Field(t)</td><td>Type(t)</td></tr>\n";
					for ($z = 0; $z < $columns1; $z++) {

						$result3 = mysql_query("SHOW FIELDS FROM ".$tb." LIKE '".$field_ns[$z]."' ");
						
						if(mysql_num_rows($result3) > 0){
									$row2 = mysql_fetch_array($result3);
									if($field_ts[$z] != $row2['Type'] ){
									$txt .= "<tr style=color:red;font-size:18px;background-color:#FFFF00><td>".$field_ns[$z]."</td><td>".$field_ts[$z]."</td><td>&nbsp;</td><td>".$row2['Field']."</td><td>".$row2['Type']."</td></tr>\n";
									$schema_create = "";
										if ($field_us[$z] != 'YES') {
											$schema_create = " NOT NULL ";
										}
										if ($field_ds[$z] != '') {
										$schema_create .= " DEFAULT '".$field_ds[$z]."' ";
										}
									$txta .= "ALTER TABLE `".$tb."` CHANGE `".$field_ns[$z]."` `".$field_ns[$z]."` ".$field_ts[$z]." ".$field_es[$z]." ".$schema_create.";\n";
									}else{
									$txt .= "<tr style=color:blue><td>".$field_ns[$z]."</td><td>".$field_ts[$z]."</td><td>&nbsp;</td><td>".$row2['Field']."</td><td>".$row2['Type']."</td></tr>\n";
									}

						}else{
									$txt .= "<tr style=color:red;font-size:18px;background-color:#FFFF00><td>".$field_ns[$z]."</td><td>".$field_ts[$z]."</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
									$schema_create = "";
									if ($field_us[$z] != 'YES') {
										$schema_create = " NOT NULL ";
									}
									if ($field_ds[$z] != '') {
										$schema_create .= " DEFAULT '".$field_ds[$z]."' ";
									}
									$txta .= "ALTER TABLE `".$tb."` ADD `".$field_ns[$z]."` ".$field_ts[$z]." ".$field_es[$z]." ".$schema_create.";\n";
						}
						
					}

			$txt .= "</table>";
		}
	mysql_query("USE ".$_POST["st_db"]) or die(mysql_error());
	}
    mysql_free_result($result);

}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td height="10" >
	<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
              <form action="compare.php" method="post"  name="form1">
                <tr> 
                  <td>&nbsp;</td>
                </tr>
                <tr > 
                  <td><div align="center"><font  size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Compare 
                      DB : ต้นฉบับที่ถูกต้อง 
                      <input name="st_db" type="text" id="st_db" value="db_ewt">
                      ตัวงานที่มาเทียบ
                      <input name="en_db" type="text" id="en_db" value="<?php echo $_POST["en_db"]; ?>">
                      </strong></font></div></td>
                </tr>
                <tr align="center"> 
                  <td height="10"><input type="submit" name="Submit" value="Submit"> 
                    <input name="Flag" type="hidden" id="Flag" value="SQL"> <input type="reset" name="Submit2" value="Reset"></td>
                </tr>
              </form>
            </table>
	</td>
  </tr>
  <tr>
    <td valign="top" ><font size="2" face="Tahoma"><strong><?php echo $txt; ?></strong></font></td>
  </tr>
  <tr>
    <td align="center" valign="top" ><?php
	if($txta != ""){
	?>
	<textarea name="textarea"  rows="20" style="width:800px" readonly=true><?php echo $txta; ?></textarea>
	<?php
	}
	?>
            </td>
  </tr>
  </table>
</body>
</html>
<?php
$db->db_close();
?>
