<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">	
<title>Gallery Category</title>
<?php
$sql1 = " SELECT category_id, category_name, category_detail FROM gallery_category 
		  ORDER BY category_name ";
$exec1 = $db->query($sql1);
$num_rows = $db->db_num_rows($exec1);

?>
</head>
<body>
      <table align="center" border="0" cellspacing="0" cellpadding="3">
		 <?php 
         $g=0;
         while($g<$num_rows) {  
           ?>
           <tr><?php
                 for($col=0;$col<4;$col++) { ?>  
                <td  valign="top" align="left">			
                    <?php 
                      if($g<$num_rows) {
                            $rec1=$db->db_fetch_array($exec1); 
                            $category_id = $rec1[category_id];
                            $category_name = $rec1[category_name];
                            $category_detail = $rec1[category_detail];
                                    
                            $sql2 = " SELECT category_id, gallery_image.img_id, img_path_s 
                            FROM gallery_cat_img 
                                INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id
                            WHERE category_id = '$category_id' AND TRIM(img_path_s) <> '' LIMIT 0,1 ";
                            
                            $exec2 = $db->query($sql2);
                            $rec2=$db->db_fetch_array($exec2);
                            
                            $img_path_s = $rec2[img_path_s];
                            
                            if(file_exists($img_path_s) && eregi("(.jpg)|(.gif)|(.png)|(.bmp)|(.swf)", $img_path_s)) { 
                             $src = "src=\"phpThumb.php?w=150&h=150&src=".$img_path_s."\"";				
                          } else {
                             $src = "";
                          }
                          ?>
                      <table  border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30" height="30"><img src="gallery/bor_01.jpg" width="30" height="30" ></td>
                        <td height="30" background="gallery/bor_03.jpg"><img src="gallery/bor_02.jpg" width="220" height="30" ></td>
                        <td width="30" height="30"><img src="gallery/bor_05.jpg" width="30" height="30" ></td>
                      </tr>
                      <tr>
                        <td width="30" valign="top" background="gallery/bor_11.jpg"><img src="gallery/bor_06.jpg" width="30" height="209" ></td>
                        <td align="center">  
                          <a href="ewt_gallery_view.php?category_id=<?php echo $category_id;?>">
                          <?php echo $category_name;?></a>
                          <br><br><a href="ewt_gallery_view.php?category_id=<?php echo $category_id;?>"><img <?php echo $src;?> width="150" height="150" border="0" alt="<?php echo eregi_replace('"','&quot;',$category_name);?>"></a>    
                          </td>
                            <td width="30" valign="bottom" background="gallery/bor_09.jpg"><img src="gallery/bor_10.jpg" width="30" height="223" ></td>
                          </tr>
                          <tr>
                            <td width="30" height="29"><img src="gallery/bor_13.jpg" width="30" height="29" ></td>
                            <td height="29" background="gallery/bor_15.jpg"><div align="right"><img src="gallery/bor_16.jpg" width="188" height="29" ></div></td>
                            <td width="30" height="29"><img src="gallery/bor_17.jpg" width="30" height="29" ></td>
                          </tr>
                        </table>
           <?php } // end if($g<$num_rows) ?>    
                </td>    
               <?php 
                    $g++;
                } // end for ?>
           </tr>
        <?php 
                
         } // end while ?> 
           
        </table>      
</body>
</html>
<?php
$db->db_close(); ?>
