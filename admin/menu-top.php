<?php
## >> Get site-userinfo
$siteuserinfo_data = $db->query("SELECT url FROM $EWT_DB_USER.user_info WHERE EWT_User = 'gistda_web'");
$siteuserinfo_info = $db->db_fetch_array($siteuserinfo_data);

## >> Get module list- sidemenu
$moduleside_array = array();

$moduleside_data = $db->query("SELECT * 
						       FROM   $EWT_DB_USER.web_module_ewt
						       WHERE  m_status = 'Y'
						       ORDER BY m_order ASC, m_name ASC");
while($moduleside_info = $db->db_fetch_array($moduleside_data)){
	array_push($moduleside_array,$moduleside_info);
}
?>
<div id="sideNav" class="sideNav">
<ul>

	<?php
		foreach($moduleside_array AS $module){
			
			$show_module = "Y";

			## >> Allow only admin
			if($module["m_admin"]=="Y" && $_SESSION['EWT_SMTYPE'] != 'Y'){
				$show_module = "N";
			}
			
			## >> Check permission
			if($module["m_code"]!=""){
				if(!$db->check_permission($module["m_code"],"w","")){
					$show_module = "N";
				}
			}

			$target_rel  = "";
			
			## >> Module url
			if($module["m_name"]=="Site Preview"){
				$module_link = $siteuserinfo_info["url"];
				$target_rel  = 'target="_blank" rel="noopener noreferrer"';
			}
			else{
				$module_link = "../".$module["m_link"];
			}

			if($show_module == "Y"){
		?>
		<li>
			<a href="<?php echo $module_link; ?>" <?php echo $target_rel; ?>>
			<img src="../EWT_ADMIN/<?php echo $module["m_image"]; ?>" class="img-responsive sideNavImg" />
			<span class="text-center"> <?php echo $module["m_name"]; ?></span></a>
		</li>
		<?php 
			}
		} 
	?>

</ul>
</div>