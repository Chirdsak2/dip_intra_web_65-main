<?php
$path = "../";
	session_start();
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	$db->query("USE ".$EWT_DB_USER);
	$uploaddir = "../../pic_upload/";
	$lang_sh1 = explode('___',$_GET[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
	@include("../language/language".$lang_sh.".php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<title><?php echo $proj_title;?></title>
<link href="../../../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<style type="text/css" >
<!--
.style1 {color: #FFFFFF}
-->
</style>
<?php
include("ewt_script.php");	
?></head>

<body>
<form  name="frm" method="post" action="">
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" ><img src="../mainpic/border_24.jpg" width="12" height="32" alt="border_24.jpg" ></td>
        <td align="center" style="background:url(../mainpic/border_25.jpg)"class="ewtfunction"><?php echo $text_genchat_lblstaff1;?></td>
        <td width="12"><img src="../mainpic/border_28.jpg" width="12" height="32" alt="border_28.jpg" ></td>
      </tr>
    </table></td>
  </tr>
</table>

  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><table width="90%" border="0" cellpadding="3" cellspacing="1">
          <tr>
            <?php
			$selete_user="SELECT  * 
                          FROM
  `gen_user`
  LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) 
  LEFT OUTER JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  Where  gen_user.gen_user_id='$gen_user_id'  ";
			$exec_user=$db->query($selete_user);
			$rst_user = $db->db_fetch_array($exec_user);

			if($rst_user[path_image]){
			   $path_image=$uploaddir.$rst_user[path_image];
			   if(file_exists($path_image)){
				$path_image = $path_image;
				}else{
				$path_image = "../mainpic/ImageFile.gif";
				}
			}else{
			   $path_image="../mainpic/ImageFile.gif";
			}
			$sql_title = "SELECT title_thai FROM title where title_id = '$rst_user[title_thai]'";
			$query_title = $db->query($sql_title);
			$rec = $db->db_fetch_array($query_title);
			$sql_title_en = "SELECT title_eng FROM title where title_id = '$rst_user[title_eng]'";
			$query_title_en = $db->query($sql_title_en);
			$rec_en = $db->db_fetch_array($query_title_en);
					if($lang_sh != ''){
							$rst_user["name_thai"] = select_lang_detail_ewt($rst_user[gen_user_id],$lang_shw,'name_thai','gen_user');
							$rst_user["surname_thai"] = select_lang_detail_ewt($rst_user[gen_user_id],$lang_shw,'surname_thai','gen_user');
							$rst_user["position_person"] = select_lang_detail_ewt($rst_user[gen_user_id],$lang_shw,'position_person','gen_user');
							$rst_user["name_org"] = select_lang_detail_ewt($rst_user[org_id],$lang_shw,'name_org','org_name');
							$rst_user["pos_name"] = select_lang_detail_ewt($rst_user[posittion],$lang_shw,'pos_name','position_name');
							$rst_user["email_person"] = select_lang_detail_ewt($rst_user[gen_user_id],$lang_shw,'email_person','gen_user');
							$rst_user["tel_in"] = select_lang_detail_ewt($rst_user[gen_user_id],$lang_shw,'tel_in','gen_user');
							$rst_user["officeaddress"] = select_lang_detail_ewt($rst_user[gen_user_id],$lang_shw,'officeaddress','gen_user');
							$rec[title_thai] = select_lang_detail_ewt($rec[title_id],$lang_shw,'title_thai','title');
								if($R_user["name_thai"] == ''){
								$result_title["title_thai"] =  '';
								}
							}
		?>
            <td width="160" align="right" bgcolor="#E7E7E7">&nbsp;&nbsp;<?php echo $text_genchat_name;?> :</td>
            <td  align="left" bgcolor="#FFFFFF"><?php echo $rec[title_thai].$rst_user[name_thai]."&nbsp;&nbsp;".$rst_user[surname_thai]; ?></td>
            <td width="120"  rowspan="5" align="center" bgcolor="#E7E7E7"><img src="<?php echo $path_image; ?>" width="98" height="98"  alt="<?php echo $rec[title_thai].$rst_user[name_thai]."&nbsp;&nbsp;".$rst_user[surname_thai]; ?>"></td>
          </tr>
          <tr style="display:none">
            <td width="160" align="right" bgcolor="#E7E7E7" class="Table-Text-Head">&nbsp; Name-Surname :</td>
            <td  align="left" bgcolor="#FFFFFF"><?php if($rst_user[name_eng] != ''){ echo $rec_en[title_eng].$rst_user[name_eng]."&nbsp;&nbsp;".$rst_user[surname_eng];} ?></td>
          </tr>
          <tr>
            <td width="160"  align="right" bgcolor="#E7E7E7" class="Table-Text-Head">&nbsp;&nbsp;<?php echo $text_genchat_position;?> :</td>
            <td align="left" bgcolor="#FFFFFF"><?php echo $rst_user[position_person]; ?></td>
          </tr>
          <tr>
            <td width="160"  align="right" bgcolor="#E7E7E7" class="Table-Text-Head">&nbsp;&nbsp;<?php echo $text_genchat_unit;?> :</td>
            <td  align="left" bgcolor="#FFFFFF"><?php echo $rst_user[name_org];?></td>
            </tr>
          <tr>
            <td width="160"  align="right" bgcolor="#E7E7E7" class="Table-Text-Head">&nbsp;&nbsp;<?php echo $text_genchat_unitposition ;?> : </td>
            <td  align="left" bgcolor="#FFFFFF"><?php if($rst_user[pos_name] != ''){echo $rst_user[pos_name];}else{ echo '-';}?></td>
            </tr>
          <tr>
            <td width="160" align="right" bgcolor="#E7E7E7" class="Table-Text-Head">&nbsp;&nbsp;<?php echo $text_genchat_email;?>  : </td>
            <td  align="left"  bgcolor="#FFFFFF"><?php echo $rst_user[email_person];?></td>
          </tr>


          <tr>
            <td width="160" align="right" bgcolor="#E7E7E7" class="Table-Text-Head">&nbsp;&nbsp;<?php echo $text_genchat_phonin;?> :</td>
            <td align="left"  bgcolor="#FFFFFF"><?php echo $rst_user[tel_in];?></td>
          </tr>

          <tr>
            <td width="160"  align="right" bgcolor="#E7E7E7" class="Table-Text-Head">&nbsp;&nbsp;<?php echo $text_genchat_placework;?> :</td>
            <td  align="left"  bgcolor="#FFFFFF"><?php echo $rst_user[officeaddress];?></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <div align="center"><br >
    <br >
    <input name="Submit" type="submit" class="submit"  style="width:100" onclick="window.close();" value="<?php echo $text_general_closethis;?>" >
  </div>
</form>
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</body>
</html>
