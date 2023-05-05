<?php
session_start();
include("../../lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

if($_POST["flag"] == 'add'){
//เพิ่มข่าว
$topic = stripslashes(htmlspecialchars($_POST["txt_topic"],ENT_QUOTES));
$cid = $_POST["cbb_group"];
$source = $_POST["txt_form"];
$sourceurl = $_POST["txt_url"];
$description = "";
$keyword = '';
$picture = '';
$detail_use = $_POST["detail_use"];
	if($detail_use == '1'){
		if($_POST["browsefile"]=='1'){
			$link = addslashes($_POST["link"]);
			$at_id = '0';
		}else if($_POST["browsefile"]=='2'){
			$at_id = '0';
			$filename = $_POST["filebrowse"];
			$Current_Dir2 = "download/article";
			$Current_Dir3 = "download/article";
			@mkdir ($Current_Dir2, 0777);
			if($_FILES["filebrowse"]['size'] > 0 ){
					$F = explode(".",$_FILES["filebrowse"]["name"]);
					$C = count($F);
					$CT = $C-1;
					$dir = strtolower($F[$CT]);
	
					//find type File
	
					$sql_type_file = "select site_type_file from site_info where site_info_id ='1'";
					$query_type_file = $db->query($sql_type_file);
					$R_type_file = $db->db_fetch_array($query_type_file);
					$type_file = $R_type_file[site_type_file];
					$pos = strpos($type_file,$dir);
					if($pos === FALSE){
							?>
							<script language="javascript1.2">
							alert('ท่านสามารถแนบประเภทไฟล์เอกสาร  <?php echo $type_file;?> เท่านั้น');
							self.location.href = "article_new.php?cid=<?php echo $_POST["cid"]; ?>";
							</script>
							<?php
					}else{
						$nfile = "article_".date("YmdHis");
						$picname = $nfile.".".$dir;
						copy($_FILES["filebrowse"]["tmp_name"],$Current_Dir2."/".$picname);
						@chmod ($Current_Dir2."/".$picname, 0777);
						$link = $Current_Dir3."/".$picname;
					}
			}//file size
		}//file
		
	}else if($detail_use == '2'){
				$x=1;
				$y=0;
				$chsize = "Y";
				$ad_pic_h = $_POST["hx".$x."y".$y];
				$ad_pic_w = $_POST["wx".$x."y".$y];
				$ad_des = addslashes(stripslashes($_REQUEST["dx".$x."y".$y]));
				$ad_font = $_POST["fx".$x."y".$y];
				$ad_size = $_POST["sx".$x."y".$y];
				$ad_bold = $_POST["bx".$x."y".$y];
				$ad_italic = $_POST["ix".$x."y".$y];
				$ad_color = $_POST["cx".$x."y".$y];
				$ad_align = $_POST["ax".$x."y".$y];
				$ad_pic_s = $_POST["spx".$x."y".$y];
				$ad_pic_b = $_POST["bpx".$x."y".$y];
				$remove = $_POST["rx".$x."y".$y];
				$ad_id = $_POST["adx".$x."y".$y];
				$create_t = $_POST["tx".$x."y".$y];
				$INSERT = "insert into article_detail (at_type_col,at_type_row,ad_pic_s,ad_pic_h,ad_pic_w,ad_pic_b,ad_des,ad_font,ad_size,ad_bold,ad_italic,ad_color,ad_align) values ('1','1','$ad_pic_s','$ad_pic_h', '$ad_pic_w','$ad_pic_b','$ad_des','$ad_font','$ad_size', '$ad_bold','$ad_italic','$ad_color','$ad_align')";
				$db->query($INSERT);
				$id_detail = mysql_insert_id();
				$link = '';
				$at_id = '10';
	}
	$date_n = (date('Y')+543)."-".date("m")."-".date("d");
	$date_e = (date('Y')+543)."-".date("m")."-".(date("d")+5);
	$insert = "INSERT INTO article_list (c_id,n_date,n_time,n_timestamp,n_topic,n_des,source,sourceLink,keyword,picture,news_use,at_id,link_html,target,expire,logo,n_new_modi,n_last_modi,n_owner,n_date_start,n_date_end,n_owner_org,n_approve,n_approvedate,show_count)  VALUES ('".$cid."','$date_n','$time_n','".date("Y-m-d H:i:s")."','$topic','$description','$source','$source_url','$keyword','$picture','".$detail_use."','$at_id','$link','_blank','$date_e','','".date('YmdHis')."','".date('YmdHis')."','".$_SESSION["EWT_MID"]."','','','','','','')";
$db->query($insert);
$nid = mysql_insert_id();
$db->query("update article_detail set n_id ='".$nid."' where ad_id = '".$id_detail."'");
	//multi search function
				/*$db->ms_module='A'; 
				$db->ms_link_id=$nid;
				$db->multi_search_update();*/
				?>
			<script language="javascript">
				self.location.href = "sendprnews.php";
			</script>
		<?php
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language=JavaScript src='scripts/innovaeditor.js'></script>
<script language="javascript">
function chk(){
var obj =document.form1;
	if(obj.txt_topic.value == ''){
		alert("กรุณาใส่หัวข้อข่าว!!");
		obj.txt_topic.focus();
		return false; 
	}
	if(obj.cbb_group.value == ''){
		alert("กรุณาเลือกหมวด!!");
		return false; 
	}
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" >
<table width="110%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td align="center" valign="top" bgcolor="#FFFFFF"><br>
                  <table width="90%" border="0"  cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td align="left" bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666">ระบบฝากข่าวประชาสัมพันธ์</font></strong></font><br />
					<hr>
					  <img src="mainpic/bl_orange.gif">&nbsp;<a href="sendprnews.php" >ฝากข่าวประชาสัมพันธ์</a> </td>
                    </tr>
                  </table>
                  <br>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td height="447" align="center" valign="top"><form name="form1" enctype="multipart/form-data" method="post" action="sendprnews_add.php"  onSubmit="return chk()">
      <table width="90%" border="0"  cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
        <tr>
          <td valign="top" ><!--gggg-->
              <table width="100%" border="0"  cellpadding="3" cellspacing="1" bgcolor="#999999">
                <tr>
                  <td colspan="2" bgcolor="#CCCCCC"><strong>เพิ่มข่าว/บทความ</strong></td>
                </tr>
                <tr>
                  <td width="27%" bgcolor="#FFFFFF">หัวข้อข่าว : </td>
                  <td width="73%" align="left" bgcolor="#FFFFFF"><input name="txt_topic" type="text" id="txt_topic" size="40">
                    <span class="style1">*</span></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF">หมวด : </td>
                  <td align="left" bgcolor="#FFFFFF">
				  <?php 
				$sql = "select article_group.c_name,article_group.c_id from article_group inner join article_group_module on article_group_module.c_id = article_group.c_id";
				  $query = $db->query($sql);
				  ?>
				  <select name="cbb_group" id="cbb_group">
				  <?php
				 
				  while($R = $db->db_fetch_array($query)){
				  ?>
				  <option value="<?php echo $R["c_id"];?>"><?php echo $R["c_name"];?></option>
				  <?php
				  }
				  ?>
                  </select>                  </td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF">ที่มา/แหล่งข่าว : </td>
                  <td align="left" bgcolor="#FFFFFF"><input name="txt_form" type="text" id="txt_form" size="40"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF">URL ของที่มา/แหล่งข่าว : </td>
                  <td align="left" bgcolor="#FFFFFF"><input name="txt_url" type="text" id="txt_url" size="40"></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF">Link ของข่าว/บทความ : </td>
                  <td align="left" bgcolor="#FFFFFF"><input name="detail_use" type="radio" value="1" checked onClick="document.all.trb01.style.display='';document.all.trb02.style.display='none';">
                    เชื่อมต่อไปยังหน้าเว็บหรือไฟล์เอกสาร 
                    <input type="radio" name="detail_use" value="2" onClick="document.all.trb01.style.display='none';document.all.trb02.style.display='';">
                    เลือกใส่ข้อความ</td>
                </tr>
                          <tr valign="top" id="trb01"> 
            <td bgcolor="#FFFFFF"></td>
            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
                <tr valign="top"> 
                  <td width="28%" bgcolor="#FFFFFF"><input name="browsefile" type="radio" value="1" checked="checked">
                  ใส่ URL ของ web </td>
            <td width="72%" align="left" bgcolor="#FFFFFF"><input name="link" type="text" id="link" size="45" onFocus="document.form1.browsefile[0].checked=true"  value="http://"></td>
                </tr>
                <tr valign="top">
                  <td bgcolor="#FFFFFF"><input name="browsefile" type="radio" value="2">
                    เลือกไฟล์จากเครื่อง</td>
                  <td align="left" bgcolor="#FFFFFF"><input type="file" name="filebrowse"  onClick="document.form1.browsefile[1].checked=true"></td>
                </tr>
              </table> </td>
          </tr>
                          <tr valign="top" id="trb02" style="display:none">
                            <td bgcolor="#FFFFFF"></td>
                            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                              <tr><td><textarea name="dx1y0" cols="80" rows="12" id="dx1y0" >
	<?php
			  function encodeHTML($sHTML)
				{
				$sHTML=ereg_replace("&","&amp;",$sHTML);
				$sHTML=ereg_replace("<","&lt;",$sHTML);
				$sHTML=ereg_replace(">","&gt;",$sHTML);
				return $sHTML;
				}
			  if(isset($C1["ad_des"]))
				{
				$sContent=stripslashes($C1["ad_des"]); /*** remove (/) slashes ***/
				echo encodeHTML($sContent);
				}
		  ?>
			</textarea>
     <script>
    var oEdit1 = new InnovaEditor("oEdit1");

    oEdit1.width="500";
    oEdit1.height="400";

  oEdit1.features=["FullScreen","LTR","RTL",  "Absolute",    "Characters","ClearAll","BRK",
    "Cut","Copy","Paste","PasteWord","PasteText",
    "Undo","Redo","Hyperlink","Bookmark",
    "JustifyLeft","JustifyCenter","JustifyRight","JustifyFull",
    "Numbering","Bullets","Indent","Outdent",
    "Line","RemoveFormat","BRK",
    "StyleAndFormatting","ListFormatting",
    "BoxFormatting","ParagraphFormatting","CssText","Styles",
    "Paragraph","FontName","FontSize",
    "Bold","Italic","Underline","Strikethrough",
    "ForeColor","BackColor"];
oEdit1.useTab = false;
    oEdit1.mode="XHTMLBody"; 

    oEdit1.REPLACE("dx1y0");
  </script></td></tr>
                              </table></td>
                          </tr>
                <tr>
                  <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="Submit">
                    <input type="hidden" name="flag" value="add"></td>
                </tr>
              </table>
            <!--gggg-->
          </td>
        </tr>
      </table>
        </form>
    </td>
              </tr>
            </table></td>
          <td width="5" height="100%" background="mainpic/bg_r.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>
</td></tr></table>
</body>
</html>
<?php  $db->db_close(); ?>
