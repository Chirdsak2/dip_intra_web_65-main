<?php
header ("Content-Type:text/html;charset=UTF-8");
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$category_id =  $_GET[category_id];
			if(($_GET[category_id]!= '') && ($_GET[category_id] != '0')){
				$sql =$db->query("select category_name,parent_id,col,row,height_s,width_s,category_vote,category_comment,category_send from gallery_category where category_id ='".$_GET[category_id]."'");
				$num_row = $db->db_num_rows($sql);
				$sql_gname =  $db->db_fetch_array($sql);
				//$name = ' >> '.findparent($sql_gname[parent_id]).$sql_gname[category_name];
				$col = $sql_gname[col];
				$row = $sql_gname[row];
				$hi = $sql_gname[height_s];
				$wi = $sql_gname[width_s];
			}
					$hiw = 70;
			$wiw = 70;
$sql = "SELECT * FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_cat_img.category_id = '".$category_id."' ORDER BY cat_img_id,gallery_image.img_id";
		$rows  = $db->db_num_rows($db->query($sql));
		if($rows > 0){
?>

<table width="96%" border="0" cellspacing="0" cellpadding="3">
  <tr valign="top">
    <td ><br ><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
      <tr>
        <td valign="middle" bgcolor="#CCCCCC" ><table width="100%" border="0"  cellpadding="3" cellspacing="1" >
          <?php

		$cal = $col;
		$w = number_format((100/$cal),0,'','');
		$sql_category =  $sql; //." LIMIT $offset,$limit ";
		$query_category = $db->query($sql_category);
		while($rs_img = $db->db_fetch_array($query_category)){

							$img_p = $rs_img[img_path_s];
							if (!file_exists($rs_img[img_path_s]) ) {
									$img_p = "mainpic/no-download.gif";
							}
							if(!$default_img)  $default_img = $img_p;
							if(!$img_id) $img_id = $rs_img[img_id];
							if(!$img_name) $img_name = $rs_img[img_name];
		if($i%$cal == 0 ) {?>
          <tr >
            <?php }?>
            <td width="<?php echo $w ;?>%" align="center" valign="top" ><a href="#G" onClick="document.getElementById('full_image').src = 'phpThumb.php?w=<?php echo $wi;?>&h=<?php echo $hi;?>&src=<?php echo $img_p;?>';document.getElementById('full_image').alt = '<?php echo $rs_img[img_name]?>';show_icon_link(<?php echo $rs_img[img_id];?>,<?php echo $sql_gname[category_vote];?>,<?php echo $sql_gname[category_send];?>,<?php echo $sql_gname[category_comment];?>); "><img src="<?php echo $img_p?>" width="<?php echo $wiw;?>"  height="<?php echo $hiw;?>" hspace="0" vspace="0" border="0" align="top"  style="border:2px #FFFFFF double ; padding:5px;" alt="<?php echo $rs_img[img_name]?>"></a> </td>
            <?php  if($i%$cal == ($cal-1)) {?>
          </tr>
          <?php }?>
          <?php
						$i++;
		}//end while
		$d = $i%$cal;
		for($b=$d;$b<$cal;$b++){
		?>
          <tr>
            <td width="<?php echo $w ;?>%" align="center" valign="top" >&nbsp;</td>
            <?php 
		}
		?>
          </tr>
        </table></td>
      </tr>
    </table>
  
&nbsp;</td>
    <td  align="center">
    <?php if($default_img) { ?>
	<table  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30" height="30"><img src="mainpic/gallery/bor_01.gif" width="30" height="30" ></td>
                        <td height="30" background="mainpic/gallery/bor_03.gif"><img src="mainpic/gallery/bor_02.gif" width="40" height="30" ></td>
                        <td width="30" height="30"><img src="mainpic/gallery/bor_05.gif" width="30" height="30" ></td>
                      </tr>
                      <tr>
                        <td width="30" valign="top" background="mainpic/gallery/bor_11.gif"><img src="mainpic/gallery/bor_06.gif" width="30" height="100" ></td>
                        <td align="center">  
                         <img id="full_image" src="phpThumb.php?w=<?php echo $wi;?>&h=<?php echo $hi;?>&src=<?php echo $default_img;?>" alt="<?php echo $img_name;?>">                        </td>
                            <td width="30" valign="bottom" background="mainpic/gallery/bor_09.gif"><img src="mainpic/gallery/bor_10.gif" width="30" height="100" ></td>
        </tr>
                          <tr>
                            <td width="30" height="29"><img src="mainpic/gallery/bor_13.gif" width="30" height="29" ></td>
                            <td height="29" background="mainpic/gallery/bor_15.gif"><div align="right"><img src="mainpic/gallery/bor_16.gif" width="40" height="29" ></div></td>
                            <td width="30" height="29"><img src="mainpic/gallery/bor_17.gif" width="30" height="29" ></td>
                          </tr>
                          <tr>
                            <td height="29" colspan="3" align="right"><span id="iconname">
							<a href="gallery_view_img_comment.php?category_id=<?php echo $category_id;?>&filename=<?php echo $_GET["filename"];?>&img_id=<?php echo $img_id;?>&BID=<?php echo $BID;?>"><?php if($sql_gname[category_vote] == '1'){?><img src="mainpic/lightbox/check.jpg" border="0" alt="คลิกเมื่อต้องการ Vote"><?php }?><?php if($sql_gname[category_comment] == '1'){?><img src="mainpic/lightbox/message.jpg" border="0" alt="คลิกเมื่อต้องการ Comment"><?php }?><?php if($sql_gname[category_send] == '1'){?><img src="mainpic/lightbox/mail.jpg" border="0" alt="คลิกเมื่อต้องการ ส่งต่อให้เพื่อน"><?php }?></a></span></td>
                          </tr>
      </table>
    
    <?php } ?></td>
  </tr>
</table>    <?php } ?>