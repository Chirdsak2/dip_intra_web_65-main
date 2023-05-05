<div id="sideNav" class="sideNav">
<ul>
		<li><a href="<?=$EWT_PATH; ?>EWT_ADMIN/main.php" ><img src="<?=$IMG_PATH;?>images/visitor1.png" class="img-responsive sideNavImg" /><span class="text-center"> Dashboard</span></a></li>
		<li><a href="<?=link_view(); ?>" target="_blank"><img src="<?=$IMG_PATH;?>images/preview3.png" class="img-responsive sideNavImg" /><span class="text-center"> Site Preview</span></a></li>
		<?php if($_SESSION['EWT_SMTYPE'] == 'Y'){?><li><a href="<?=$EWT_PATH; ?>SitePropertiesMgt/" ><img src="<?=$IMG_PATH;?>images/SiteProperties.png" class="img-responsive sideNavImg" /> Site Properties</a></li><?php } ?>
		<?php if($_SESSION['EWT_SMTYPE'] == 'Y'){?><li><a href="<?=$EWT_PATH; ?>PermissionMgt/" ><img src="<?=$IMG_PATH;?>images/OrgManager.png" class="img-responsive sideNavImg" /> Permission</a></li><?php } ?>
		<?php if($db->check_permission("art","w","")){ ?><li><a href="<?=$EWT_PATH; ?>ArticleMgt/"><img src="<?=$IMG_PATH;?>images/Article.png" class="img-responsive sideNavImg" /> Article</a></li><?php } ?>
		<?php if($db->check_permission("Banner","w","")){ ?><li><a href="<?=$EWT_PATH; ?>BannerMgt/"><img src="<?=$IMG_PATH;?>images/banner.png" class="img-responsive sideNavImg" /> Banner</a></li><?php } ?>
		<?php if($db->check_permission("calendar","w","")){ ?><li><a href="<?=$EWT_PATH; ?>CalendarMgt/"><img src="<?=$IMG_PATH;?>images/calendar1.png" class="img-responsive sideNavImg" /> CalendarMgt</a></li><?php } ?>
		<?php if($db->check_permission("complain","w","")){ ?><li><a href="<?=$EWT_PATH; ?>ComplainMgt/"><img src="<?=$IMG_PATH;?>images/webboard.png" class="img-responsive sideNavImg" /> Complain</a></li><?php } ?>
		<?php if($db->check_permission("newsl","w","")){ ?><li><a href="<?=$EWT_PATH; ?>EnewsLetterMgt/"><img src="<?=$IMG_PATH;?>images/E-Newsletter.png" class="img-responsive sideNavImg" /> E-Newsletter</a></li><?php } ?>
		<?php if($db->check_permission("Ebook","w","")){ ?><li><a href="<?=$EWT_PATH; ?>EbookMgt/"><img src="<?=$IMG_PATH;?>images/e-book.png" class="img-responsive sideNavImg" /> E-Book</a></li><?php } ?>
		<?php if($db->check_permission("faq","w","")){ ?><li><a href="<?=$EWT_PATH; ?>FaqMgt/"><img src="<?=$IMG_PATH;?>images/FAQ.png" class="img-responsive sideNavImg" /><span class="text-center"> FAQ</span></a></li>	<?php } ?>			
		<?php if($db->check_permission("survey","w","")){ ?><li><a href="<?=$EWT_PATH; ?>SurveyMgt/"><img src="<?=$IMG_PATH;?>images/Form Generator.png" class="img-responsive sideNavImg" /> Form Generator</a></li><?php } ?>
		<?php if($db->check_permission("Gallery","w","")){ ?><li><a href="<?=$EWT_PATH; ?>GalleryNewMgt/"><img src="<?=$IMG_PATH;?>images/Gallery.png" class="img-responsive sideNavImg" /> Gallery</a></li><?php } ?>
		<?php /*if($db->check_permission("graph","w","")){ ?><li><a href="<?=$EWT_PATH; ?>GrapMgt/"><img src="<?=$IMG_PATH;?>images/Graph.png" class="img-responsive sideNavImg" /> Graph</a></li><?php }*/ ?>
		<?php if($db->check_permission("menu","w","")){ ?><li><a href="<?=$EWT_PATH; ?>MenuMgt/menu_index.php"><img src="<?=$IMG_PATH;?>images/Menu.png" class="img-responsive sideNavImg" /> Menu</a></li><?php } ?>
		<?php if($db->check_permission("org","w","")){ ?><li><a href="<?=$EWT_PATH; ?>MemberOrgMgt/"><img src="<?=$IMG_PATH;?>images/Artboard 20.png" class="img-responsive sideNavImg" /> Organization</a></li><?php } ?>
		<?php if($db->check_permission("poll","w","")){ ?><li><a href="<?=$EWT_PATH; ?>PollMgt/"><img src="<?=$IMG_PATH;?>images/Polls.png" class="img-responsive sideNavImg" /> Polls</a></li><?php } ?>
		<?php if($db->check_permission("vdo","w","")){ ?><li><a href="<?=$EWT_PATH; ?>vdoMgt/"><img src="<?=$IMG_PATH;?>images/Artboard 22.png" class="img-responsive sideNavImg" /> Video</a></li><?php } ?>
		<?php if($db->check_permission("webboard","w","")){ ?><li><a href="<?=$EWT_PATH; ?>WebboardNewMgt/"><img src="<?=$IMG_PATH;?>images/webboard.png" class="img-responsive sideNavImg" /> Webboard</a></li><?php } ?>
	</ul>
</div>