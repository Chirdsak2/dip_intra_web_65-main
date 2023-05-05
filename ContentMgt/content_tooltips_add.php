<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("cms","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.close();
				</script>
				<?php
}
if($_GET[flag]=='edit_page'){
$sql = "select * from tips_list  where tips_list_id = '".$_GET[tips_id]."'";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
}
	?>
<html>
<head>
<title>Page Properties [<?php echo $R[filename];?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script language=JavaScript src='../scripts/innovaeditor.js'></script>
<script language="javascript1.2">
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
function txt_data() {
	
	var mytop = '80';//findPosY(document.getElementById("lang")) +document.getElementById("lang").offsetHeight;
	var myleft = '80';//findPosX(document.getElementById("lang"));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='content_tooltips_group.php?type=<?php echo $_GET[type];?>&filename=<?php echo $_GET[filename];?>&tips_id='+document.getElementById("tips_id").value+'&flag='+document.getElementById("flag").value;
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
	
}
</script>
<script language="javascript1.2">
function adddata(F){
var type = window.top.document.getElementById('type').value;
var filename = window.top.document.getElementById('filename').value;
	if(F == 'H'){
	self.location.href= "content_tooltips_list.php?type="+type+"&filename="+filename;
	}else if(F == 'A'){
	self.location.href= "content_tooltips_list_all.php?type="+type+"&filename="+filename+"&flag=add_page";
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<div id="nav" style="position:absolute;width:600px; z-index:1;display:none" ></div>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">New Tool Tips </span></td>
      </tr>
</table>
      <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
        <tr>
          <td align="right">
                <img src="../images/bar_home.gif" width="20" height="20" align="absmiddle"> <a href="##H"  onClick="adddata('H');">กลับหน้าหลัก </a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="#" onClick="txt_data()"><img id="lang" src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle">เพิ่มกลุ่ม</a>
              <hr>
          </td>
        </tr>
      </table>
	  <form name="form1" method="post" action="content_tooltips_function.php">
      <table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
        <tr bgcolor="#E7E7E7" >
          <td height="30" colspan="2" class="ewttablehead"> เพิ่ม Tool Tips </td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF">
          <td width="38%">Title</td>
          <td width="62%"><input name="title" type="text" size="40" value="<?php echo $R[tips_list_title];?>"></td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF">
          <td>Group</td>
          <td><div id="group_list"><select name="group_id">
		  <?php
		  $sql_g = "select tips_group_id,tips_group_name from tips_group";
		  $query_g = $db->query($sql_g);
		  while($RG = $db->db_fetch_array($query_g)){
		  ?>
              <option value="<?php echo $RG[tips_group_id];?>" <?php if($RG[tips_group_id] ==$R[tips_group_id] ){ echo 'selected';} ?> ><?php echo $RG[tips_group_name];?></option>
			  <?php  } ?>
          </select></div></td>
        </tr>

        <tr valign="top" bgcolor="#FFFFFF">
          <td>Detail</td>
          <td><textarea name="detail" cols="40" rows="5">
		  <?php
			  function encodeHTML($sHTML)
				{
				$sHTML=ereg_replace("&","&amp;",$sHTML);
				$sHTML=ereg_replace("<","&lt;",$sHTML);
				$sHTML=ereg_replace(">","&gt;",$sHTML);
				return $sHTML;
				}
			  if(isset($R[tips_list_detail]))
				{
				$sContent=stripslashes($R[tips_list_detail]); /*** remove (/) slashes ***/
				echo encodeHTML($sContent);
				}
		  ?>
			</textarea> <script>
		var oEdit1 = new InnovaEditor("oEdit1");
		
		oEdit1.width="100%";
		oEdit1.height="200";
		
    oEdit1.tabs=[
    ["tabHome", "", ["grpFont", "grpPara"]]
    ];

    oEdit1.groups=[
    ["grpFont", "", ["FontName", "FontSize", "BRK", "Bold", "Italic", "Underline","Strikethrough","Superscript","Subscript", "ForeColor", "BackColor"]],
    ["grpPara", "", ["Paragraph", "Indent", "Outdent", "LTR", "RTL", "BRK", "JustifyLeft", "JustifyCenter","JustifyRight","JustifyFull", "Numbering","Bullets", "XHTMLSource"]]
    ];
		oEdit1.mode="HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"
		
		oEdit1.REPLACE("detail");
		</script></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>&nbsp;</td>
          <td><input type="submit" name="Submit" value="Submit">
          <input type="hidden" name="type" value="<?php echo $_GET[type];?>">
		  <input type="hidden" name="filename" value="<?php echo $_GET[filename];?>">
		  <input type="hidden" name="flag" value="<?php echo $_GET[flag];?>">
		  <input type="hidden" name="tips_id" id="tips_id" value="<?php echo $_GET[tips_id];?>"></td>
        </tr>
      </table>
      
      </form>
</body>
</html>
<?php $db->db_close(); ?>
