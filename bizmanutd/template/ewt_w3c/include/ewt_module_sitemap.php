<?php
function rootnum($data){
$s = explode("_",$data);
$num = count($s);
return $num;
}
function GenPic($data){
    global $db;
    $num = rootnum($data);
				for($i=2;$i<$num;$i++){
					?>
					<img width="25" src="../mainpic/o.gif" border="0"  alt="icon" >
					<?
				} 
}
function chk_child($data){
    global $db;
    $sql_child="SELECT menu_properties.mp_id FROM menu_properties inner join menu_sitemap_list on menu_sitemap_list.mp_id = menu_properties.mp_id  where menu_properties.mp_id  like '$data"."_%' and m_show = 'Y'";
    $sql_child = $db->query($sql_child);
	return $db->db_num_rows($sql_child);
}
function gensitemap_data($themeid,$mid,$sid,$column){
	global $db;
	global $mainwidth;
	global $global_theme;
	if($themeid != "0" AND $themeid != ""){
		$namefolder = "themes".($themeid);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
	}
	if (eregi("%", $bg_width)) { //ok
	 $bg_width2 = (100/$column).'%';
	}else{	//no ok
	 $bg_width2 = ($bg_width/$column);
	}
	 echo $design[0];
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<?php
	//parent
	$sqlM = "select menu_sitemap_list.*,menu_list.m_name from menu_sitemap_list inner join menu_list on menu_list.m_id=menu_sitemap_list.m_id where
s_id = '$sid' and menu_sitemap_list.m_id = '$mid' and sm_active = 'Y' ";
	$queryM = $db->query($sqlM);
	$M = $db->db_fetch_array($queryM);
	if($M[m_show] == 'Y'){
		if($M[m_realname] != ''){
		$menuname = $M["m_realname"];
		}else{
		$menuname = $M[m_name];
		}
	}
	?>
	  <tr>
		<td >&nbsp;<span class="text_head"><h1><?php echo $menuname;?></h1></span></td>
	  </tr>
	  <?php
	  //child
	  $sqlC = "select menu_sitemap_list.*,menu_properties.mp_name,menu_properties.Glink,menu_properties.Gtarget from menu_sitemap_list inner join menu_properties on menu_properties.mp_id=menu_sitemap_list.mp_id where s_id = '$sid' and menu_sitemap_list.mp_id  like '".$mid."_%' and sm_active = 'Y' order by mp_id";
	  $queryC = $db->query($sqlC);
	  while($RC = $db->db_fetch_array($queryC)){
	  if($RC["m_show"] == 'Y'){
		if($RC["m_realname"] != ''){
		$menunameC = $RC["m_realname"];
		}else{
		$menunameC = $RC[mp_name];
		}
	
	  ?>
	  <tr>
		<td >&nbsp;<?php GenPic($RC["mp_id"]) ;?>
		<?php if($RC["Glink"] != ''){
		  $RC["Glink"] = eregi_replace("&","&amp;",$RC["Glink"]);
		  ?>
		<a href="<?php echo $RC["Glink"]?>" target="<?php $RC["Gtarget"]?>" accesskey=<?php echo $db->genaccesskey();?>>&nbsp;<span class="text_normal"><?php echo trim($menunameC);?></span></a>
		<?php }else{ ?><span class="text_normal">&nbsp;<?php echo trim($menunameC);?></span><?php } ?></td>
	  </tr>
	  <?php 
	  	}
	   } ?>
	</table>
	<?php
	  echo $design[1];
}

function gensitemap_data2($themeid,$mid,$sid,$column){
	global $db;
	global $mainwidth;
	global $global_theme;
	if($themeid != "0" AND $themeid != ""){
		$namefolder = "themes".($themeid);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$buffer = "";
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
	}
	if (eregi("%", $bg_width)) { //ok
	 $bg_width2 = (100/$column).'%';
	}else{	//no ok
	 $bg_width2 = ($bg_width/$column);
	}
	 echo $design[0];
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<?php
	//parent
	$sqlM = "select menu_sitemap_list.*,menu_list.m_name from menu_sitemap_list inner join menu_list on menu_list.m_id=menu_sitemap_list.m_id where
s_id = '$sid' and menu_sitemap_list.m_id = '$mid' and sm_active = 'Y' ";
	$queryM = $db->query($sqlM);
	$M = $db->db_fetch_array($queryM);
	if($M[m_show] == 'Y'){
		if($M[m_realname] != ''){
		$menuname = $M["m_realname"];
		}else{
		$menuname = $M[m_name];
		}
	}

	?>
	  <tr>
		<td ><span class="text_head">&nbsp;<h1><?php echo $menuname;?></h1></span></td>
	  </tr>
	  <?php
	  //child
	  $sqlC = "select menu_sitemap_list.*,menu_properties.mp_name,menu_properties.Glink,menu_properties.Gtarget from menu_sitemap_list inner join menu_properties on menu_properties.mp_id=menu_sitemap_list.mp_id where s_id = '$sid' and menu_sitemap_list.mp_id  like '".$mid."_%' and sm_active = 'Y' order by mp_id";
	  $queryC = $db->query($sqlC);
	  while($RC = $db->db_fetch_array($queryC)){
	  		if(rootnum($RC["mp_id"])==2){
				  if($RC["m_show"] == 'Y'){
					if($RC["m_realname"] != ''){
					$menunameC = $RC["m_realname"];
					}else{
					$menunameC = $RC[mp_name];
					}
					$id_sub ='p'.$RC["mp_id"];
					$num_child = chk_child($RC["mp_id"]);
					if($num_child>0){$icon_showMS = '<img src="mainpic/plus_a.gif" id="img_plus'.$id_sub.'" style="cursor:hand"  align="absmiddle" onclick="show_hidden(\''.$id_sub.'\',\''.$RC["mp_id"].'\',\''.$sid.'\');"/>';}else{$icon_showMS = '<img  src="mainpic/arrow2.gif" border="0" align="absmiddle" >';}
	  ?>
					  <tr >
						<td>&nbsp;<?php GenPic($RC["mp_id"]) ;?>
						<?php if($RC["Glink"] != ''){?><a href="<?php echo $RC["Glink"]?>" target="<?php $RC["Gtarget"]?>" accesskey=<?php echo $db->genaccesskey();?>><span class="text_normal">&nbsp;<?php echo trim($menunameC);?></span></a><DIV id="p<?php echo $RC["mp_id"];?>" style="display:none"></DIV>
						<?php }else{ ?><span class="text_normal">&nbsp;<?php echo trim($menunameC);?></span><DIV id="p<?php echo $RC["mp_id"];?>" style="display:none"></DIV><?php } ?></td>
					  </tr>
	  <?php 
	  			}
	  		}
	   } ?>
	</table>
	<?php
	  echo $design[1];
}
?>
<script language="javascript1.2" type="text/javascript">
function show_hidden(id,mid,sid){
	if(document.getElementById(id).style.display == 'none'){
		document.getElementById('img_plus'+id).src = 'mainpic/minus_a.gif';
			document.getElementById(id).style.display = '';
			var objDiv = document.getElementById(id);
			objDiv.style.display = '';
			url='sitemap_list.php?mp_id='+mid+'&sid='+sid;
			AjaxRequest.get(
				{
					'url':url
					,'onLoading':function() { }
					,'onLoaded':function() { }
					,'onInteractive':function() { }
					,'onComplete':function() { }
					,'onSuccess':function(req) { 
							objDiv.innerHTML = req.responseText; 
					}
				}
			);
	}else{
			document.getElementById(id).style.display = 'none';
		document.getElementById('img_plus'+id).src = 'mainpic/plus_a.gif';
			
	}
}
</script>