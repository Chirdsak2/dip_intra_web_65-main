<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
//include("language/language.php");
include("lib/utilities_function.php");
$month_STH=",ม.ค.,ก.พ.,มี.ค.,เม.ย.,พ.ค.,มิ.ย.,ก.ค.,ส.ค.,ก.ย.,ต.ค.,พ.ย.,ธ.ค.";
$month=explode(',',$month_STH);
if($_GET["filename"] != ""){
$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$d_idtemp = $F["template_id"];
}else{
$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
$FF = $db->db_fetch_array($sql_index);
$d_idtemp = $FF[d_id];
}
$lang_sh = explode('___',$F[filename]);
			if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
			include("language/language".$lang_sh.".php");
$temp = "SELECT * FROM design_list WHERE d_id = '".$d_idtemp."'";
$sql_temp= $db->query($temp);
$R = $db->db_fetch_array($sql_temp);
$design_id = $R["d_id"];

$mainwidth = 0;
$global_theme = $R["d_bottom_content"];

if($_POST[search]){

		$key_name=$_POST[key_name];
		$key_detail=$_POST[key_detail];
		$key_size1=$_POST[key_size1];
		$key_size2=$_POST[key_size2];
		$key_sizetype=$_POST[key_sizetype];
		$key_filetype=$_POST[key_filetype];
		$key_d1=$_POST[key_d1];
		$key_m1=$_POST[key_m1];
		$key_y1=$_POST[key_y1];
		
		$key_d2=$_POST[key_d2];
		$key_m2=$_POST[key_m2];
		$key_y2=$_POST[key_y2];
		$key_condition=$_POST[key_condition];
		
		$key_filesize1=$key_size1*pow (2 ,$key_sizetype);
		$key_filesize2=$key_size2*pow (2 ,$key_sizetype);
		
		$key_date1=$key_y1.$key_m1.$key_d1;
		$key_date2=$key_y2.$key_m2.$key_d2;
		
		$key_date1=($key_date1*1);
		$key_date2=($key_date2*1);
		
		if($key_date2==0){
		   $key_date2=$key_date1;
		}
		
		$key_date1=($key_date1*1)."000000";
		if(($key_date1*1)!=0){
		   $key_date2=($key_date2*1)."999999";
		}
 
        if($key_name!=''){  $wh.="$key_condition dl_name like '%$key_name%'  "; }
        if($key_detail!=''){ $wh.="$key_condition dl_detail like '%$key_detail%'  "; }
        if($key_size1 > 0  || $key_size2 > 0){ $wh.="$key_condition (dl_filesize >= '$key_filesize1'  AND dl_filesize <=  '$key_filesize2' )  "; }
        if($key_filetype!='-'){ $wh.="$key_condition dl_type = '$key_filetype'  "; }
        if($key_date1 > 0){ $wh.="$key_condition (dl_createdate >= '$key_date1'  AND dl_createdate <= '$key_date2' ) "; }
        if($key_date2 > 0){ $wh.="$key_condition (dl_update >= '$key_date1'  AND dl_update <= '$key_date2' )"; }
    $sel = "SELECT * FROM docload_list  WHERE  dl_open='Y'  AND ( dl_name like '#'  $wh )ORDER BY dl_createdate";
	
	if($key_condition=='OR'){
		    $sel = "SELECT * FROM docload_list  WHERE  dl_open='Y'  AND ( dl_name like '#'  $wh ) ORDER BY dl_createdate";
	}else{
	      $sel = "SELECT * FROM docload_list  WHERE  dl_open='Y'  $wh ORDER BY dl_createdate";
	}
}else{
    $sel = "SELECT * FROM docload_list  WHERE  dl_open='Y'  and dl_name like '#'  ";
}

//echo  $sel;
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
//$limit = $CO[c_number];
$limit =20;
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = $db->query($Show); 
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Download</title>
<?php
include("ewt_script.php");	
?>
</head>
<body  leftmargin="0" topmargin="0" <?php if($R["d_site_bg_c"] != ""){ echo "bgcolor=\"".$R["d_site_bg_c"]."\""; } ?> <?php if($R["d_site_bg_p"] != ""){ echo "background=\"".$R["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $R["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $R["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $R["d_top_height"]; ?>" bgcolor="<?php echo $R["d_top_bg_c"]; ?>" background="<?php echo $R["d_top_bg_p"]; ?>" colspan="3" id="ewt_main_structure_top">
			<?php
			$mainwidth = $R["d_site_width"];
			?>
		  <?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $R["d_site_left"]; ?>" bgcolor="<?php echo $R["d_left_bg_c"]; ?>" background="<?php echo $R["d_left_bg_p"]; ?>">
		<?php
		$mainwidth = $R["d_site_left"];
		?>
		  <?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $R["d_site_content"]; ?>" bgcolor="<?php echo $R["d_body_bg_c"]; ?>" height="160" background="<?php echo $R["d_body_bg_p"]; ?>">
		<?php
		$mainwidth = $R["d_site_content"];
		?>
<?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		
      <?php } ?>
 
 
 
 
 
 
 
 
 
 
<?php  echo $design[0];?>
<table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#FFFFFF" class="styleMe">
<?php
//$Execsql1 = $db->query("SELECT * FROM f_subcat WHERE f_sub_id = '$f_sub_id'");
//$QQ= mysql_fetch_array($Execsql1);
?>
 <tr>
   <td>
       <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
	   <form name="formSearchFile" method="post" action="search_download_adv.php?filename=<?php echo $_REQUEST["filename"];?>">
          <tr>
    			<td width="30%" valign="top" align="right">ชื่อไฟล์ : </td>
			   <td width="70%" height="25" align="left" valign="top"><input type="text" name="key_name" class="styleMe" value="<?php echo $key_name;?>"></td>
  		</tr>
		<tr>
    			<td   valign="top" align="right">รายละเอียด : </td>
			   <td   height="25" align="left" valign="top"><input type="text" name="key_detail" class="styleMe" value="<?php echo $key_detail;?>"></td>
  		</tr>
		<tr>
    			<td   valign="top" align="right">ช่วงขนาดไฟล์ : </td>
			   <td  height="25" align="left" valign="top">
			   <input type="text" name="key_size1" class="styleMe"  size="3" value="<?php echo $key_size1?>"> ถึง
			   <input type="text" name="key_size2" class="styleMe" size="3"  value="<?php echo $key_size2?>">
			   <select name="key_sizetype">
			       <option value="0" <?php if($key_sizetype=='0') echo 'selected'; ?>>Byte</option>
			       <option value="10" <?php if($key_sizetype=='10') echo 'selected'; ?>>KB.</option>
			       <option value="20" <?php if($key_sizetype=='20') echo 'selected'; ?>>MB.</option>
			   </select>
			   </td>
  		</tr>
		<tr>
    			<td   valign="top" align="right">ชนิดไฟล์ : </td>
			   <td  height="25" align="left" valign="top"> 
			   	<select name="key_filetype">
			       <option value="-">นามสกุลไฟล์</option>
				<?php
				     $query_type = $db->query("SELECT distinct dl_type FROM docload_list ");
                    while($data_qt=$db->db_fetch_array($query_type)){ ?>
			       <option value="<?php echo $data_qt[dl_type]; ?>" <?php if($key_filetype==$data_qt[dl_type]) echo 'selected'; ?>>.<?php echo $data_qt[dl_type]; ?></option>
				   <?php } ?>
			   </select>
			   </td>
  		</tr>
		<tr>
    			<td   valign="top" align="right" nowrap="nowrap">ช่วงวันที่อัพโหลด : </td>
			   <td  height="25" align="left" valign="top" nowrap="nowrap">
			   <select name="key_d1">
			           <option value="00">-</option>
					   <?php for($ii=1;$ii<=31;$ii++){      if($ii<10){    $dd='0'.$ii;  	 }else{    $dd=$ii;    }  ?>
					   <option value="<?php echo $dd;?>" <?php if($key_d1==$dd) echo 'selected'; ?>><?php echo $dd;?></option>
						<?php }?>
			   </select>
			   <select name="key_m1">
			           <option value="00">-</option>
					   <?php for($ii=1;$ii<=12;$ii++){      if($ii<10){    $dd='0'.$ii;  	 }else{    $dd=$ii;    }  ?>
					   <option value="<?php echo $dd;?>" <?php if($key_m1==$dd) echo 'selected'; ?>><?php echo $month[$ii];?></option>
						<?php }?>
			   </select>
			   <select name="key_y1">
			           <option value="0000">-</option>
					   <?php for($ii=date('Y');$ii>=date('Y')-10;$ii--){      if($ii<10){    $dd='0'.$ii;  	 }else{    $dd=$ii;    }  ?>
					   <option value="<?php echo $dd;?>" <?php if($key_y1==$dd) echo 'selected'; ?>><?php echo ($dd+543);?></option>
						<?php }?>
			   </select>
			   ถึง <select name="key_d2">
			           <option value="00">-</option>
					   <?php for($ii=1;$ii<=31;$ii++){      if($ii<10){    $dd='0'.$ii;  	 }else{    $dd=$ii;    }  ?>
					   <option value="<?php echo $dd;?>" <?php if($key_d2==$dd) echo 'selected'; ?>><?php echo $dd;?></option>
						<?php }?>
			   </select>
			   <select name="key_m2">
			           <option value="00">-</option>
					   <?php for($ii=1;$ii<=12;$ii++){      if($ii<10){    $dd='0'.$ii;  	 }else{    $dd=$ii;    }  ?>
					   <option value="<?php echo $dd;?>" <?php if($key_m2==$dd) echo 'selected'; ?>><?php echo $month[$ii];?></option>
						<?php }?>
			   </select>
			   <select name="key_y2">
			           <option value="0000">-</option>
					   <?php for($ii=date('Y');$ii>=date('Y')-10;$ii--){      if($ii<10){    $dd='0'.$ii;  	 }else{    $dd=$ii;    }  ?>
					   <option value="<?php echo $dd;?>" <?php if($key_y2==$dd) echo 'selected'; ?>><?php echo ($dd+543);?></option>
						<?php }?>
			   </select>
			   </td>
  		</tr>
		<tr>
    		<td   valign="top" align="right">เงื่อนไขการค้นหา : </td> 
   <td  height="25" align="left" valign="top">
	<input type="radio" value="AND"  name="key_condition"  <?php if($key_condition=='AND') echo 'checked'; ?>> และ
	<input type="radio" value="OR"  name="key_condition"  <?php if($key_condition!='AND') echo 'checked'; ?>> หรือ </td>
  </tr>
		<tr>
    			<td  valign="top" align="right"></td>
			   <td width="60%" height="25" align="left" valign="top">
				  <input name="search_mode" type="hidden" id="search_mode" value="1">
				  <input name="oper" type="hidden" id="oper" value="OR">
				  <input type="submit" name="search" value="ค้นหาไฟล์เอกสาร" class="styleMe" onClick="return chkSchButt(document.formSearchFile)">
				</td>
  		</tr>
  </form>
  <script>    function chkSchButt(c){  
   if(c.key_name.value!='' ||  c.key_detail.value!='' ||   c.key_size1.value!='' ||   c.key_size2.value!='' ||  c.key_filetype.value!='-' ||  c.key_d1.value!='00' ||    c.key_m1.value!='00'  ||    c.key_y1.value!='0000'  ){ 
   		return true; 
   }else{ 
   		return false;}  
   } </script>
      </table>   </td>
 </tr>
  <tr>
          <td height="260" colspan="2" valign="top"> <span style="FONT-SIZE: 10pt; COLOR: #993300; FONT-FAMILY: Tahoma"><strong> 
            <?php
	
$sql = $db->query("select * from block where BID = '".$_GET[BID]."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];
			if($rec[block_themes] !=0){
				$themes = $rec[block_themes];
			}else{
				$themes = $global_theme;
			}
if($themes!= '0' && $themes != ''){
		$namefolder = "themes".($themes);
		@include("themesdesign/".$namefolder."/".$namefolder.".php");
		 //if($themes_type == 'F'){
				$buffer = "";
			if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
				$fd = @fopen ($Current_Dir1.$themes_file, "r");
				 while (!@feof ($fd)) {
					$buffer .= @fgets($fd, 4096);
				 }
				@fclose ($fd);
				$exp = "<"."?#htmlshow#?".">";
				$design = explode($exp,$buffer);
		 }
		
}else{
	$head_font_color='#666666';
	$bg_color='#6A2B00';
	$Current_Dir1='mainpic/';
	$bg_img='';
	$head_img='toolbars.gif';
	$head_height=30;
	$body_color='#FFFFFF';
	$body_font_color='#000099';
}
	
	function current_level($fid){
	global $db;
	$sql = "select * from docload_group where dlg_id = '$fid' ";
	//echo  $sql;
	$query = $db->query($sql); 
	$R = mysql_fetch_array($query);
	if($R[dlg_id] > 0){  current_level($R[dlg_parent]); }
	if($fid<>0){
		 echo ' > <a href="download_list.php?filename='.$filename.'&f_sub_id='.$R[dlg_id].'">'.$R[dlg_name].'</a>';
	}
}
	$f_sub_id=$_GET[f_sub_id] ;
	
	//$Execsql1 = $db->query("SELECT * FROM f_cat  inner join f_subcat  on   f_cat.f_id =f_subcat.f_id WHERE f_sub_id = '$f_sub_id'");
	$Execsql1 = $db->query("SELECT * FROM docload_group WHERE dlg_id = '$f_sub_id' ");
	$QQ= $db->db_fetch_array($Execsql1);
	?>
            <a href="main.php?filename=<?php echo $filename ?>">ดาวน์โหลด</a>
			<strong>	<?php 	echo current_level($f_sub_id); ?></strong><hr>

            <table cellspacing="0" cellpadding="0" width="100%" border="0">
              <tbody>
                <tr> 
                  <td align="center"> <table border="0" width="<?php if($bg_width!= ''){ echo $bg_width;}else{ echo '90%';}?>" align="center" cellpadding="3" cellspacing="1"  bgcolor="<?php echo $bg_color;?>" background="<?php echo $Current_Dir1.$bg_img;?>" id="tbbg" >
                      <tr> 
                        <td  align="center"  id="Htdcolor"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font  color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span  id="Hfont" style="font-size: <?php echo $head_font_size;?>"><strong>ชื่อเอกสาร</span></font></td>
                        <td align="center"  id="Htdcolor"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font  color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span  id="Hfont" style="font-size: <?php echo $head_font_size;?>"><strong>ขนาด (KB.)</span></font></td>
                        <td align="center"  id="Htdcolor"  height="<?php echo $head_height;?>" bgcolor="<?php echo $head_color;?>" background="<?php echo $Current_Dir1.$head_img;?>"><font  color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><span  id="Hfont" style="font-size: <?php echo $head_font_size;?>"><strong>จำนวนโหลด</span></font></td>
                      </tr>
                      <?php
	  if($rows > 0){
   while($Q = $db->db_fetch_array($Execsql)){ 
	?>
                      <tr > 
                        <td width="79%" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"> 
                         <?php if($Q[dl_type] == "jpg" || $Q[dl_type] == "gif" || $Q[dl_type] == "png"  || $Q[dl_type] == "jpeg"  || $Q[dl_type] == "bmp" ){ 
						       $filepath="download_doc/dl_".$Q[dl_dlgid]."/$Q[dl_name]";
						        //echo "<img src=\"$filepath\"  height=\"50\" align=\"absmiddle\"><br>"; 
								?><img src="phpThumb.php?src=<?php echo $filepath;?>&h=80&w=80" border="1"><br><?php
							  }//else{ 
							  echo "&diams;&nbsp;"; ?>
                          &nbsp;<a href="#view"  onClick="c=window.open('download_detail.php?dl_id=<?php echo $Q['dl_id'];?>','showass','scrollbars=yes,width=650,height=450');c.focus();" <?php if($Q[faq_top] == "Y"){ echo "style=\"background-color=\""; } ?>> 
                          <b> <font  color="<?php echo $body_font_color;?>" face="<?php echo $body_font_face;?>" ><span id="Bfont" style="font-size: <?php echo $body_font_size;?>">
                          <?php echo $Q[dl_name]; ?><br><?php echo $Q[dl_detail]; ?>
                          </span></font> </b></a><br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span id="Bfont2" style="font-size: <?php echo $body_font_size2;?>">วันที่สร้าง : <?php echo date_display($Q[dl_createdate],'YmdHis','DT3Th');?></span></font></em> 
                          <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span id="Bfont2" style="font-size: <?php echo $body_font_size2;?>">วันที่แก้ไขล่าสุด : <?php echo date_display($Q[dl_update],'YmdHis','DT3Th');?></span></font></em></td>
                        <td width="18%" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>"><?php echo number_format($Q[dl_filesize]/1024,2); ?></td>
                        <td width="18%" align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img*1;?>"><?php echo number_format($Q[dl_count],0); ?></td>
                      </tr>
                      <?php }}else{ ?>
                      <tr bgcolor="#F7F7F7"> 
                        <td colspan="3" align="center" bgcolor="#F7F7F7"><font color="#FF0000"><strong>No category found in Download</strong></font></td>
                      </tr>
                      <tr bgcolor="#F7F7F7"> 
                        <td colspan="3" bgcolor="#F7F7F7">&nbsp;</td>
                      </tr>
                      <?php } ?>
                    </table></td>
                </tr>
                <tr> 
                  <td background="images/new_design/krom1_11.jpg"></td>
                </tr>
              </tbody>
            </table>
			<?php  echo $design[1];?> 
			
			
			
			
			
			
			
			</td>
    </tr>
  <?php  if($rows > 0){ ?>
  <tr>
    <td height="25" colspan="2" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><strong><?php echo $text_general_page;?> :</strong>      <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&f_id=$f_id&f_sub_id=$f_sub_id&filename=$filename&BID=$BID'>
<font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ".$text_general_previous."</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($rows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($rows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">[ $i ] </font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&f_id=$f_id&f_sub_id=$f_sub_id&filename=$filename&BID=$BID' ". 
                  "onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&f_id=$f_id&f_sub_id=$f_sub_id&filename=$filename&BID=$BID' >
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\"> ".$text_general_next.">></font></a>"; 
    }
?></td>
  </tr>
</table></td>
    </tr>
  <?php } ?>
</table>    </td>
          <td id="ewt_main_structure_right" width="<?php echo $R["d_site_right"]; ?>" bgcolor="<?php echo $R["d_right_bg_c"]; ?>" background="<?php echo $R["d_right_bg_p"]; ?>">	  
		<?php
		$mainwidth = $R["d_site_right"];
		?>
		<?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?>		  </td>
        </tr>
        <tr valign="top" > 
          <td  id="ewt_main_structure_bottom" height="<?php echo $R["d_bottom_height"]; ?>" bgcolor="<?php echo $R["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $R["d_bottom_bg_p"]; ?>">
		  <?php
			$mainwidth = $R["d_site_width"];
			?>
			<?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id ."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
      </table>
	  
</body>
</html>
<?php $db->db_close(); ?>
