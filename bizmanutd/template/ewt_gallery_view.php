<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

//phpThumb.php?w=100&h=100&src=
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	
<title>Gallery Images</title>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>
<body onLoad="MM_preloadImages('images/arrow_left_green.gif')">
<a href="ewt_gallery.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('icon_back','','images/arrow_left_green.gif',1)"><img src="images/arrow_left_blue.gif" alt="กลับ" name="icon_back" width="24" height="24" border="0" id="icon_back" align="absmiddle">Back</a> <?php 
$sql1 = " SELECT category_id, category_name, category_detail FROM gallery_category  WHERE category_id = '".$_GET["category_id"]."' 
		   ";
$exec1 = $db->query($sql1);
$rec1 = $db->db_fetch_array($exec1);
echo "<h4>".$rec1[category_name]."</h4>";
?>
<table border="0" cellspacing="0" cellpadding="3">
  <tr valign="top">
    <td width="440">
    <?php 
				$sql2 = " SELECT category_id, gallery_image.img_id, img_name, img_detail, img_path_s, img_path_b, img_vote 
					FROM gallery_cat_img 
						INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id
					WHERE category_id = '".$_GET["category_id"]."' ORDER BY  img_name, img_path_s";
					
					$exec2 = $db->query($sql2);
					$num_rows = $db->db_num_rows($exec2);
			?>
				<table border="0" cellspacing="0" cellpadding="3">
				 <?php 
                 $g=0;
				 $default_img = "";
                 while($g<$num_rows) {  
                   ?>
                   <tr><?php
                         for($col=0;$col<6;$col++) { ?>  
                        <td width="70" valign="top" align="center">			
                            <?php 
                              if($g<$num_rows) {
                                   $rec2=$db->db_fetch_array($exec2);
										
                                    $img_id = $rec2[img_id];
                                    $img_name = $rec2[img_name];
                                    $img_detail = $rec2[img_detail];
                                                                               
                                    $img_path_s = $rec2[img_path_s];
                                    $img_path_b = $rec2[img_path_b];
									$img_vote = $rec2[img_vote];
									
									if(!$default_img)  $default_img = $img_path_b;
								?>
                                  <?php //echo $img_name; <br><br> ?>
                                  <a href="#" onClick="document.getElementById('full_image').src = 'phpThumb.php?w=550&h=400&src=<?php echo $img_path_b;?>'; "><img src="phpThumb.php?w=65&h=65&src=<?php echo $img_path_s;?>" border="0" alt="<?php echo eregi_replace('"','&quot;',$img_name);?>"></a>    
                 <?php  
							  } // end if($g<$num_rows) ?>    
                        </td>    
                       <?php 
                            $g++;
                        } // end for ?>
                   </tr>
			 <?php 
                
        	  } // end while ?>    
             </table>
    &nbsp;</td>
    <td width="560" height="410">&nbsp;
    <?php if($default_img) { ?>
    <img id="full_image" src="phpThumb.php?w=550&h=400&src=<?php echo $default_img;?>">
    <?php } ?></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>