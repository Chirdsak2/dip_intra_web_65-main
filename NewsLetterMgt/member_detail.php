<?php
include("authority.php");
?>
<?php 

if($_POST["Flag"] == "Update"){
$db->query("DELETE FROM n_group_member WHERE m_id = '".$_POST["mid"]."'");
for($i=0;$i<$_POST["all"];$i++){
$chk = "chk".$i;
$chk = $_POST[$chk];
$id = "id".$i;
$id = $_POST[$id];
if($chk != ""){
$db->query("INSERT INTO n_group_member (m_id,g_id) VALUES ('".$_POST["mid"]."','$id')");
}
}
?>
<script language="JavaScript">
alert("Update data successfully.");
self.close();
</script>
<?php
}
$sel = "select * from n_group,article_group where c_id = g_name and ";
$sel .= " `n_group`.`g_name` !=  '' order by g_id desc ";	
$r = $db->query($sel);

include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
</head>
<body >
<div class="container" style="width: 100%;">
<div class="col-md-12 col-sm-12 col-xs-12" _style="border-color:#000000;background-color:#FFFFFF;border: 3px solid #FFC153;
    padding: 10px;
    border-radius: 15px;top:10px;">
<div class="clearfix">&nbsp;</div>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $lang_subscriber_detail; ?>( <?php echo $_REQUEST["email"];?> )</h4>
</div>	


<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12">
<table width="100%" align="center" class="table table-bordered">
	  <form name="form1" method="post" action="">
        <?php
$mid = $_REQUEST["mid"];
$i = 0;
while($R = mysql_fetch_array($r)){
$sqlx = $db->query("SELECT * FROM n_group_member WHERE m_id = '$mid' AND g_id = '$R[g_id]'");
$row = mysql_num_rows($sqlx);
?>
        <tr bgcolor="<?php if($row > 0){ echo "#5bc0de"; }else{ echo "#FFFFFF"; } ?>" >
          <td width="10%" style="text-align:center" > 
              
                <input type="checkbox" name="chk<?php echo $i; ?>" value="<?php echo $R['g_id'];?>" <?php if($row > 0){ echo "checked"; } ?>>
              
                <input name="id<?php echo $i; ?>" type="hidden" id="id<?php echo $i; ?>" value="<?php echo $R['g_id'];?>">
           
          </td>
          <td width="90%"   style="color:<?php if($row > 0){ echo "#FFFFFF"; }else{ echo ""; } ?>;" > <?php echo $R['c_name'];?></td>
        </tr>
        
        <?php 
$i++;
}?>
<tr  >
          <td>&nbsp;</td>
          <td align="center"><input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml" />
            <input type="reset" name="Submit2" value="ยกเลิก"  class="btn btn-warning"  onclick="window.close();"/>
            <input name="all" type="hidden" id="all" value="<?php echo $i; ?>">
            <input name="Flag" type="hidden" id="Flag" value="Update">
            <input name="mid" type="hidden" id="mid" value="<?php echo $mid; ?>"></td>
        </tr>
</form>
      </table>

</div>
</div>
</div>
</body>
</html>
<?php $db->db_close();  ?>