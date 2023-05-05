<?php

if($_GET[page]=='main.php' || $_GET[page]=='site_preview.php'){
?>
<script language="javascript1.2" type="text/javascript">
window.location.href="showprintFriendly.php?filename=<?php echo $_GET[filename];?>&flag=1";
</script>
<?php  }

if($_GET[page]=='ewt_news.php'){
?>
<script language="javascript1.2" type="text/javascript">
window.location.href="showprintFriendly.php?nid=<?php echo $_GET[nid];?>&flag=2";
</script>
<?php  }
if($_GET[page]=='ewt_snews.php'){
?>
<script language="javascript1.2" type="text/javascript">
window.location.href="showprintFriendly.php?s=<?php echo $_GET[s];?>&flag=3";
</script>
<?php  }
if($_GET[page]=='more_news.php'){
?>
<script language="javascript1.2" type="text/javascript">
window.location.href="showprintFriendly.php?cid=<?php echo $_GET[cid];?>&flag=4";
</script>
<?php  }

if($_GET[page]=='search_result.php'){
?>
<script language="javascript1.2" type="text/javascript">
window.location.href="showprintFriendly.php?keyword=<?php echo $_GET[keyword];?>&search_mode=<?php echo $_GET[search_mode];?>&flag=5";
</script>
<?php  }
 ?>
