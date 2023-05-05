<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");

if($_POST['flag']=='new')
{
  $a_cate = array();
  $sql_cate = $db->query("SELECT * FROM mobile_contents");
  while($cate = $db->db_fetch_array($sql_cate)) {
    $a_cate[$cate['c_id']] = $cate['c_id'];
  }
  if($_POST['c_id'])
  {
    foreach($_POST['c_id'] as $_item)
    {
      if(in_array($_item, $a_cate))
      {
        unset($a_cate[$_item]);
      }
      else
      {
        $sql = "insert into mobile_contents (c_id, mcont_status) values ('".$_item."', '1')";
        $db->query($sql);
      }
    }
  }
  if($a_cate)
  {
    foreach($a_cate as $_item)
    {
      $sql = "delete from mobile_contents where c_id='".$_item."'";
      $db->query($sql);
   }
  }
?>
    <script language="javascript">
      alert('บันทึกเรียบร้อย');
      self.location.href = "mobile_contents.php";
    </script>
<?php
}
else if($_POST['flag']=='setting')
{
  if($_POST['logo'])
  {
    $sql = "update mobile_config set mconf_value='".$_POST['logo']."' where mconf_code='logo'";
    $db->query($sql);
  }
?>
    <script language="javascript">
      alert('บันทึกเรียบร้อย');
      self.location.href = "mobile_setting.php";
    </script>
<?php
}
else if($_POST['flag']=='order')
{
  if($_POST['c_name'])
  {
    foreach($_POST['c_name'] as $_key=>$_item)
    {
      $sql = "update mobile_contents set mcont_order='".$_item."' where c_id='".$_key."'";
      $db->query($sql);
    }
  }
?>
    <script language="javascript">
      alert('บันทึกเรียบร้อย');
      self.location.href = "mobile_contents.php";
    </script>
<?php
}

$db->db_close();

?>