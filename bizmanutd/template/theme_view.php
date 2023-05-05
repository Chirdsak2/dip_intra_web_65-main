<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$sql = $db->query("select * from themes where themes_id = '".$_GET[themes_id]."'");
$rec = $db->db_fetch_array($sql);
$themes_namethems = $rec[themes_namethems];
$themes_type = $rec[themes_type];
$themes_file = $rec[themes_file];
$Current_Dir1 = "themesdesign/".$themes_namethems."/";
$bg_img = $rec[bg_img];
$bg_color = $rec[bg_color];
$bg_width = $rec[bg_width];
$head_img = $rec[head_img];
$head_color = $rec[head_color];
$head_font_face = $rec[head_font_face];
$head_font_size = $rec[head_font_size];
$head_font_color = $rec[head_font_color];
$head_height = $rec[head_height];
$body_bg_img = $rec[body_bg_img];
$body_color = $rec[body_color];
$body_font_face = $rec[body_font_face];
$body_font_size = $rec[body_font_size];
$body_font_color = $rec[body_font_color];
$bottom_img = $rec[bottom_img];
$bottom_color = $rec[bottom_color];
$bottom_height = $rec[bottom_height];
$head_font_face2 = $rec[head_font_face2];
$head_font_size2 = $rec[head_font_size2];
$head_font_color2 = $rec[head_font_color2];
$body_font_face2 = $rec[body_font_face2];
$body_font_size2 = $rec[body_font_size2];
$body_font_color2 = $rec[body_font_color2];
$body_font_face3 =$rec[body_font_face3];
$body_font_size3 = $rec[body_font_size3];
$body_font_color3 = $rec[body_font_color3];

$head_font_bold = $rec[head_font_bold];
$head_font_italic = $rec[head_font_italic];
$head_font_bold2 = $rec[head_font_bold2];
$head_font_italic2 = $rec[head_font_italic2];
$body_font_bold = $rec[body_font_bold];
$body_font_italic = $rec[body_font_italic];
$body_font_bold2 = $rec[body_font_bold2];
$body_font_italic2 = $rec[body_font_italic2];
$body_font_bold3 = $rec[body_font_bold3];
$body_font_italic3 = $rec[body_font_italic3];

$bg_width = (100-$bg_width).'%';
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.style1 {
	color: #FF6600;
	font-weight: bold;
	font-size: 14px;
}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="theme_function.php" enctype="multipart/form-data">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="mainpic/BrushSZ.gif" width="25" height="25" align="absmiddle"> 
      <span class="ewtfunction style2">Preview block design</span> </td>
  </tr>
</table>
<table width="94%"  border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999" class="ewttableuse">
    <br>
    <tr class="ewttablehead">
      <td bgcolor="#CCCCCC" ><span class="style1">Preview</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">
	  <?php
	  
	 /* if($themes_type == 'F'){
	  				$buffer = "";
					$fd = @fopen ($Current_Dir1.$themes_file, "r");
					while (!@feof ($fd)) {
						$buffer .= @fgets($fd, 4096);
					}
					@fclose ($fd);
					echo $buffer;
					$str=explode("<?php#htmlshow#?>",$buffer);
					
		}else if($themes_type =='S' or $themes_type =='' ){	
		*/
		$usefile=0;
		
		//if(file_exists($Current_Dir1.$themes_file) and $themes_file!=''){
		if($fd = @fopen ($Current_Dir1.$themes_file, "r")){
		    $buffer = "";
		    while (!@feof ($fd)) {
						$buffer .= @fgets($fd, 4096);
			}
			@fclose ($fd);
			//echo $buffer;
			$str=explode("<?php#htmlshow#?>",$buffer);
			$usefile=1;
		}
		
		if($usefile==1){echo $str[0];}
			
	  ?>
	  <table border="0" width="<?php echo $bg_width;?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" style="border:dashed 1px;">
        <tr>
          <td  style="border:dashed 1px;" height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"  ><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span style="font-size: <?php echo $head_font_size;?><?php  if($head_font_italic=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">ข้อความส่วนหัวที่ 1</span></font> <br>
         <font color="<?php echo $head_font_color2;?>"  face="<?php echo $head_font_face2;?>"><span style="font-size: <?php echo $head_font_size2;?><?php  if($head_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($head_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"> ข้อควมส่วนหัวที่ 2 </span></font></td>
        </tr>
        <tr>
          <td height="70" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><table width="100%" border="0">
            <tr>
              <td style="border:dashed 1px;"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>" ><span style="font-size: <?php echo $body_font_size;?><?php  if($body_font_italic=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold=='Y'){ ?>;font-weight:bold<?php } ?>">ข้อความส่วนเนื้อหาที่ 1</span></font><br>
               <font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?><?php  if($body_font_italic2=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold2=='Y'){ ?>;font-weight:bold<?php } ?>"> ข้อความส่วนเนื้อหาที่ 2</span></font><br>
                <font color="<?php echo $body_font_color3;?>"  face="<?php echo $body_font_face3;?>" ><span style="font-size: <?php echo $body_font_size3;?><?php  if($body_font_italic3=='Y'){ ?> ;font-style:italic<?php } if($body_font_bold3=='Y'){ ?>;font-weight:bold<?php } ?>">ข้อความส่วนเนื้อหาที่ 3
</span></font></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="<?php echo $bottom_height ;?>" background="<?php echo $Current_Dir1.$bottom_img;?>"   bgcolor="<?php echo $bottom_color;?>" style="border:dashed 1px;">&nbsp;</td>
        </tr>
      </table>
	  <?php
	  if($usefile==1){echo $str[1];}
	  //} ?>
	  </td>
    </tr>
  </table>

</form>
</body>
</html>
<?php
$db->db_close(); ?>