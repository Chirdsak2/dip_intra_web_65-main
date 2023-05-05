<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");

if($_GET[url] != ''){
$link = $_GET[url];
}else{
$link = 'mail_send.php';
}
?>
<br><br><br><br>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
	<tr> 
		<td height="20" bgcolor="#FFFFFF">
			<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr> 
					<td width="60" height="58"><img src="../theme/main_theme/g_ebook_64.gif"> </td>
					<td><span class="ewthead">E-Book Management</span>
					  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
					  <span class="ewtsubmenu"><a href="bookg_mgt.php" target="iframe_data"><img src="../theme/main_theme/ebook_modulesub_main.gif" width="16" height="16" align="absmiddle" border="0"> การจัดการ กลุ่ม E-Book </a></span>&nbsp;&nbsp;&nbsp;&nbsp;
					  <span class="ewtsubmenu"><a href="mgt_value.php" target="iframe_data"><img src="../theme/main_theme/ebook_modulesub_size.gif" width="16" height="16" align="absmiddle" border="0"> กำหนดความจุไฟล์ </a></span>&nbsp;&nbsp;&nbsp;&nbsp;
					  <span class="ewtsubmenu"><a href="mgt_preset.php" target="iframe_data"><img src="../theme/main_theme/ebook_modulesub_preset.gif" width="16" height="16" align="absmiddle" border="0">  การจัดการขนาดไฟล์ </a></span>&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr> 
		<td height="10" bgcolor="#f0f3f4"></td>
	</tr>
	<tr> 
		<td valign="top" bgcolor="#FFFFFF" height="320">
			<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
			  <tr> 
				<td bgcolor="#FFFFFF"><iframe name="iframe_data" src="<?php echo $link;?>"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
			  </tr>
			</table>
		</td>
	</tr>
</table>
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script src="../js/mask-input-jquery/docs/jquery.samask-masker.js"></script>
<script src="../js/pick-a-color/build/dependencies/tinycolor-0.9.15.min.js"></script>
<script src="../js/pick-a-color/build/1.2.3/js/pick-a-color-1.2.3.min.js"></script>	                                                                                                                                                                                                        <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<?php
$db->db_close(); ?>