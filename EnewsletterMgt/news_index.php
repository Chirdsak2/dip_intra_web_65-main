<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");

if($_GET[url] != ''){
$link = $_GET[url];
}else{
	if($_GET["proc"] == 1){
		$link = 'file_mod.php';
	}else if($_GET["proc"] == 2){  
		$link = 'temp_mod.php';
	}else if($_GET["proc"] == 3){
		$link = 'mail_send.php';
	}
}
?>
<br><br><br>
<div class="row m-b">
<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm"  >
<div class="card" >
<div class="card-body" >
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12" >	
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
	<tr> 
		<td height="20" bgcolor="#FFFFFF">
			<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr> 
					<td width="30%" height="58"><img src="../theme/main_theme/g_enews_64.gif" > <span class="animated fadeInDown text-large hidden-xs"><?php echo $text_genenew_module;?></span>
					</td>
					<td style="text-align:right;">
						  <!--<hr width="100%" size="1"  align="left"  color="#D8D2BD">-->
					<!--<span class="ewtsubmenu"><a href="member_mod.php" target="iframe_data"><img src="../theme/main_theme/enews_modulesub_member.gif" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_genrss_modulesub_member;?></a></span>&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="ewtsubmenu"><a href="group_mod.php" target="iframe_data"><img src="../theme/main_theme/enews_modulesub_groupnews.gif" border="0" width="16" height="16" align="absmiddle"> <?php echo $text_genrss_modulesub_group;?></a></span>-->&nbsp;&nbsp;&nbsp;&nbsp;
					<span class="ewtsubmenu"><a href="../EWT_ADMIN/main.php" class="btn btn-default btn-sm"><i class="fas fa-home"></i> <?=$txt_ewt_home ;?></a></span>
					<span class="ewtsubmenu"><a href="enews_main.php" class="btn btn-default btn-sm"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_main;?></a></span>
					<span class="ewtsubmenu"><a href="enews_cate.php" class="btn btn-default btn-sm"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_cate;?></a></span>
					<span class="ewtsubmenu"><a href="news_index.php?proc=1"  class="btn btn-default btn-sm"><li class="far fa-arrow-alt-circle-right"></li> <?php echo $text_genrss_modulesub_attact;?></a></span>
					<span class="ewtsubmenu"><a href="news_index.php?proc=2"  class="btn btn-default btn-sm"><!--<img src="../theme/main_theme/enews_modulesub_news.gif" width="16" height="16" align="absmiddle" border="0" >--><li class="far fa-arrow-alt-circle-right"></li> <?php echo $text_genrss_modulesub_news;?></a></span> 
					<span class="ewtsubmenu"><a href="news_index.php?proc=3"  class="btn btn-default btn-sm"><!--<img src="../theme/main_theme/enews_modulesub_email.gif" width="16" height="16" align="absmiddle" border="0">--><li class="far fa-arrow-alt-circle-right"></li> <?php echo $text_genrss_modulesub_email;?></a></span> 
					<!--enews_member.php--> 
					<span class="ewtsubmenu"><a href="enews_main.php" class="btn btn-default btn-sm"><i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?=$txt_enews_menu_member;?></a></span>
					 <!--<span class="ewtsubmenu"><a href="domain_mod.php" target="iframe_data"><img src="../theme/main_theme/enews_modulesub_domain.gif" width="16" height="16" align="absmiddle" border="0"><?php echo $text_genrss_modulesub_domain;?></a></span>&nbsp;&nbsp;&nbsp;&nbsp;
					 <span class="ewtsubmenu"><a href="history.php" target="iframe_data"><img src="../theme/main_theme/enews_modulesub_send.gif" width="16" height="16" align="absmiddle" border="0"> <?php echo $text_genrss_modulesub_santdata;?></a></span>&nbsp;&nbsp;&nbsp;&nbsp;
					 <span class="ewtsubmenu"><a href="mail_stat.php" target="iframe_data"><img src="../theme/main_theme/enews_modulesub_stat.gif" width="16" height="16" align="absmiddle" border="0"> <?php echo $text_genrss_modulesub_stat;?></a></span>-->		    </td>
				</tr>
			</table>
		</td>
	</tr>
	<tr> 
		<td height="10" bgcolor="#f0f3f4"></td>
	</tr>
	<tr> 
		<td valign="top" bgcolor="#FFFFFF" height="950">
			<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
			  <tr> 
				<td bgcolor="#FFFFFF"><iframe name="iframe_data" src="<?php echo $link;?>"  frameborder="0"  width="100%" height="100%" scrolling="no"></iframe></td>
			  </tr>
			</table>
		</td>
	</tr>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
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