<?php
session_start();
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>โหวตคำตอบ</title>
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" method="post" action="question_function.php">
<input name="flag" type="hidden" value="vote">
<input name="a_id" type="hidden" value="<?php echo $_GET["a_id"];?>">
  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#B2B2B2">
  <?php
  $vo=0;
  $aid= 0;
  $sql = "select sum(vote_choice) AS vote ,count(a_id) AS aid  from  w_vote where a_id ='".$_GET["a_id"]."' ";
  $query = $db->query($sql);
  $R = $db->db_fetch_array($query);
  $vo = $R[vote];
  $aid = $R[aid];
    if($vo != 0 && $aid != 0){
  $percen =($vo/($aid*5))*100;
  }else{
  $percen ='0';
  }
  ?>
    <tr>
      <!--<td width="58%" bgcolor="#CCCCCC" class="MemberHead">โหวตคำตอบ</td>-->
      <td width="42%" bgcolor="#CCCCCC" class="MemberHead">คะแนนโหวต(ทั้งหมด <?php echo  $aid;?> คน)</td>
    </tr>
    <tr>
      <!--<td align="center" bgcolor="#FFFFFF"><input name="vote" type="radio" value="4">
        มากที่สุด(4)
        <input name="vote" type="radio" value="3">
        มาก(3)
        <input name="vote" type="radio" value="2" checked>
        ปานกลาง(2)
        <input name="vote" type="radio" value="1">
        น้อย(1)</td>-->
      <td rowspan="2" bgcolor="#FFFFFF"><p><?php echo  $vo;?>  คะแนน( <?php echo number_format($percen,0, '.', ',');?>%) </p></td>
    </tr>
    <tr>
      <!--<td align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="ส่งคะแนนโหวต"></td>-->
    </tr>
  </table>
</form>
</body>
</html>
<?php $db->db_close(); ?>