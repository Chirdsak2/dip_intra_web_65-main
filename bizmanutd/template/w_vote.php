<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
				$lang_sh1 = explode('___',$_GET[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			//echo $lang_sh ;
			include("language/language".$lang_sh.".php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>โหวตคำตอบ</title>
<link href="css/style.css" rel="stylesheet" type="text/css">
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
      <td width="72%" bgcolor="#CCCCCC" class="MemberHead"><?php echo $text_genwebboard_vote;?></td>
      <td width="28%" bgcolor="#CCCCCC" class="MemberHead"><nobr><?php echo ereg_replace ("<#V#>", $aid, $text_genwebboard_votetotal);?></nobr></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF"><nobr><input name="vote" type="radio" value="5">
        <?php echo $text_genwebboard_vote4;?>
        <input name="vote" type="radio" value="4">
        <?php echo $text_genwebboard_vote3;?>
        <input name="vote" type="radio" value="3" checked>
       <?php echo $text_genwebboard_vote2;?>
        <input name="vote" type="radio" value="2">
        <?php echo $text_genwebboard_vote1;?>
		<input name="vote" type="radio" value="1">
        <?php echo $text_genwebboard_vote0;?></nobr></td>
      <td rowspan="2" bgcolor="#FFFFFF"><p><?php if($vo==''){echo '0';}else{echo  $vo;}?>&nbsp;<?php echo ereg_replace ("<#V#>", number_format($percen,0, '.', ','), $text_genwebboard_votepersen);?></p></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="<?php echo $text_genwebboard_votesent;?>"></td>
    </tr>
  </table>
</form>
</body>
</html>
