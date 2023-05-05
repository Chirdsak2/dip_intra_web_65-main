<?php
	if($_SERVER['REMOTE_ADDR']!='58.10.71.90' && $_SERVER['REMOTE_ADDR']!=$_GET['hdIP']) {
		echo '<span style="color:#FFFFFF;">'.$_SERVER['REMOTE_ADDR'].'</span>';
		exit;
	}
	include("../ewt/prd_web/lib/function.php");
	include("../ewt/prd_web/lib/user_config.php");
	include("../ewt/prd_web/lib/connect.php");
?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		$("#a").click(function() {
			$.ajax({
				type: "POST",
				url: 'queryingPage.php',     // this is the path from above
				data: 'table='+$("#table").val()+'&where='+$("#where").val()+'&db='+$("#db").val()+'&addr='+$("#addr").val()+'&full_query='+$("#full_query").val(),
				beforeSend: function(xhr) {
					document.getElementById('response').innerHTML='<img src="icon_loading.gif">';;
					//xhr.setRequestHeader("X-AjaxPro-Method", "HelloWorld");
				},
				success: function(s) {
					document.getElementById('response').innerHTML=s;
				}
			});
		});
		$("#b").click(function() {
			$.ajax({
				type: "POST",
				url: 'queryingPage.php',     // this is the path from above
				data: 'table='+$("#table").val()+'&where='+$("#where").val()+'&db='+$("#db").val()+'&addr='+$("#addr").val()+'&full_query=',
				beforeSend: function(xhr) {
					document.getElementById('response').innerHTML='<img src="icon_loading.gif">';;
					//xhr.setRequestHeader("X-AjaxPro-Method", "HelloWorld");
				},
				success: function(s) {
					document.getElementById('response').innerHTML=s;
				}
			});
		});
	});

</script>
<body>
<?php
	$db_list = mysql_list_dbs($connectdb);

	$i = 0;
	$cnt = mysql_num_rows($db_list);
	while ($i < $cnt) {
?>
		<a href="javascript:void(0);" onClick="window.location.href='showTables.php?hdIP=<?php echo $_GET['hdIP']; ?>&db=<?php mysql_db_name($db_list, $i); ?>&table='+$('#table').val()+'&where='+$('#where').val()+'&full_query='+$('#full_query').val();"><?php echo mysql_db_name($db_list, $i); ?></a> - 
<?php
			$i++;
	}

?>
<table cellpadding="0" cellspacing="0"><tr>
<td>
<table cellpadding="0" cellspacing="0"><tr>
<td>Table name:</td><td><input type="text" size="70" name="table" id="table" value="<?php echo $_GET['table']; ?>"/>&nbsp;&nbsp;DB:&nbsp;&nbsp;<input type="text" size="48" name="db" id="db" value="<?php echo $_GET['db']; ?>"/></td>
</tr>
<tr><td>Where:</td><td><textarea rows="6" cols="100" id="where"><?php echo $_GET['where']; ?></textarea></td>
</tr>
<tr><td>&nbsp;</td><td><input type="button" name="b" id="b" value="Query" size="40" /></td></tr>
<tr><td>Full Query:</td><td><textarea rows="6" cols="100" id="full_query"><?php echo $_GET['full_query']; ?></textarea></td>
</tr>
<tr><td>&nbsp;</td><td><input type="button" name="a" id="a" value="Query" size="40" /></td></tr>
</table></td><td style="vertical-align:top;">
<div style=" width:auto; height:auto; border:solid 1px black;"><select style="width:240px;" size="16" onChange="document.getElementById('table').value=this.value; document.getElementById('b').click();">
<?php
	
	if($_GET['db']!='') {
		$qTable=$db->query('SHOW TABLES FROM '.$_GET['db']);
		while($rTable=$db->db_fetch_array($qTable)) {
			echo '<option value="'.$rTable[0].'">'. $rTable[0].'</option>';
		}
	}
?></select></div>
</td>
</tr></table>
<input type="hidden" name="addr" id="addr" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" size="40" />
<div id="response" style="width:750px; height:200px; border:solid 1px #666; text-align:center;">Result box.</div>
</body>
</html>