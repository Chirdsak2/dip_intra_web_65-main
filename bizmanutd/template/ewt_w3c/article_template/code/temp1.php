<?php
for($i=1;$i<11;$i++){
$db->query("INSERT INTO article_detail ( n_id , at_type_col , at_type_row , ad_pic_s , ad_pic_h , ad_pic_w , ad_pic_b , ad_des , ad_font , ad_size , ad_bold , ad_italic , ad_color, ad_align ) VALUES ( '$nid', '1', '".$i."', '', '200', '200', '', NULL , 'MS Sans Serif', '1', NULL , NULL , '#000000', 'center')");
$db->query("INSERT INTO article_detail ( n_id , at_type_col , at_type_row , ad_pic_s , ad_pic_h , ad_pic_w , ad_pic_b , ad_des , ad_font , ad_size , ad_bold , ad_italic , ad_color, ad_align ) VALUES ( '$nid', '2', '".$i."', '', '200', '200', '', NULL , 'MS Sans Serif', '1', NULL , NULL , '#000000', 'left')");
}
?>