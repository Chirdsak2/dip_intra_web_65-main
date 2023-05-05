<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	include("ewt_template.php");
?><?php echo $template_design[0];?><?php
			$mainwidth = $F["d_site_content"];
			?>
			<table width="100%" border="0" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF">
        <tr> 
          <td height="10">
		  <br><br>
		  <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#660000">
  <tr>
    <td align="center" bgcolor="#FFBF80"><font size="2" face="Tahoma"><strong>ขอบคุณที่ตอบแบบสอบถาม</strong></font></td>
  </tr>
</table>
		  </td>
        </tr>
      </table>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>