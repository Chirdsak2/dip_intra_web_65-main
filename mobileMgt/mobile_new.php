<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/rude_language.php");

$a_cate = array();
$sql_cate = $db->query("SELECT * FROM mobile_contents left join article_group on article_group.c_id=mobile_contents.c_id order by mobile_contents.mcont_order");
while($cate = $db->db_fetch_array($sql_cate)) {
  $a_cate[] = $cate['c_id'];
}

function getGroup($s_id=0)
{
  global $db, $a_cate;
  $sql_file = $db->query("SELECT * FROM article_group WHERE c_parent = '".$s_id."'");
  $row = $db->db_num_rows($sql_file);
  if($row)
  {
    $s_html = '<ul>';
    while($cate = $db->db_fetch_array($sql_file)) {
      $chk = (in_array($cate['c_id'], $a_cate))?' checked="checked"':'';
      $s_html.='<li><label><input type="checkbox" name="c_id['.$cate['c_id'].']" '.$chk.' value="'.$cate['c_id'].'" />'.$cate['c_name'].'</label>'.getGroup($cate['c_id']).'</li>'.PHP_EOL;
    }
    $s_html.= '</ul>'.PHP_EOL;
  }
  return $s_html;
}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style>
ul {
  list-style-type: none;
  padding: 0;
}
li {
  padding: 0;
}
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/rude_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">Mobile</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
     <hr>
    </td>
  </tr>
</table>
  <table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top">
  <form name="form" method="post" action="mobile_function.php">
<?php
  echo getGroup(0);
?>
  <input type="hidden" name="flag" value="new" />
  <button type="submit">บันทึก</button>
  </form>
		
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
</div>
</body>
</html>
<?php $db->db_close(); ?>
