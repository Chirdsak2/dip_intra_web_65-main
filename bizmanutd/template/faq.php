<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">

</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top"></td>
      <td width="100%"  valign="top"><table width="100%"   border="0" cellpadding="2" cellspacing="0" >
          <tr> 
            <td     align="right" height="25"> </td>
          </tr>
          <tr> 
            <td colspan="2" valign="top"> <DIV align="center"  > 
                <br><table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
				<?php
				$Execsql = $db->query("SELECT * FROM f_cat where f_use='Y'  ORDER BY f_no ASC");
$row = $db->db_num_rows($Execsql);
				?>
				<form name="form1" method="post" action="faq_search.php">
  <tr>
    <td align="right"><input name="filename" type="hidden" id="filename" value="<?php echo $filename; ?>"> 
                        <input type="text" name="keyword">
              <input type="submit" name="search" value="ค้นหา FAQ">
           </td>
  </tr></form>
</table>

                <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#6A2B00" class="normal_font">
                  <tr align="center" bgcolor="#FFDFCA"> 
                    <td height="30" class="head_font"><strong>หมวดของ FAQ </strong></td>
                    <td width="12%"><strong>จำนวน FAQ ในหมวด</strong></td>
                  </tr>
                  <?php
  if($row > 0){
   while($R = $db->db_fetch_array($Execsql)){ 
	$f_id = $R[f_id];
   $count = $db->query("SELECT * FROM faq WHERE f_id = '$f_id'   and faq_use='Y' ");
   $countrow = mysql_num_rows($count);
	
   ?>
                  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#FFF3E8'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
                    <td width="67%" valign="top" > 
                      <div align="left" class="head_font"><font color="000099"> <b>
                        &diams; <?php echo ($R[f_cate]); ?></b>
                        </font></div>
   <?php echo ($R[f_detail]); ?>
                    </td>
                    <td align="center">&nbsp;</td>
                  </tr>
                <?php   $sql_subcat="select * from f_subcat where f_id='$R[f_id]'  and f_use='Y'  ORDER BY f_sub_no ASC "  ;
					$query_subcat=$db->query($sql_subcat);
					while($R_SUB=$db->db_fetch_array($query_subcat)){
 ?>
				  <tr bgcolor="#FFFFFF"   style="cursor:'hand'" onMouseOver="this.style.backgroundColor='#FFF3E8'" onMouseOut="this.style.backgroundColor='#FFFFFF'">
					<td height="42" onClick="window.location.href='faq_list.php?f_id=<?php echo $f_id; ?>&f_sub_id=<?php echo $R_SUB[f_sub_id]; ?>&filename=<?php echo $filename; ?>'">														  
			 
			<div align="left" class="head_font"><font color="000099"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &rArr;  <?php echo ($R_SUB[f_subcate]); ?></b></font></div>
			          
			     <?php echo ($R_SUB[f_subdetail]); ?></td>

 <?php  
$count2 = $db->query("SELECT * FROM faq WHERE f_sub_id = '$R_SUB[f_sub_id]'  and faq.faq_use='Y'  ");
   $countrow2 = mysql_num_rows($count2);?>
		            <td height="42" align="center"><?php echo $countrow2; ?></td>
				  </tr>  

<?php } }}else{ ?>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="30" colspan="2"><div align="center"><font color="#FF0000"><strong>ไม่มีหมวดของ 
                        FAQ </strong></font></div></td>
                  </tr>
                  <?php } ?>
                </table>
                <br>
                </DIV></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
</div>
</body>
</html>
