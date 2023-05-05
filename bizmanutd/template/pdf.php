<?php
$url_name = htmlspecialchars($HTTP_REFERER);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Export to PDF</title>
<script type="text/javascript">
window.status='Export to PDF';
</script>
</head>

<frameset rows="0,*"" frameborder="NO" border="0" framespacing="0">
  <frame src="" name="topFrame" id="topFrame" title="topFrame" />
  <frame src="http://203.150.224.248/capture/pdf.php?url=<?php echo $url_name; ?>" name="mainFrame" id="mainFrame" title="mainFrame" />
</frameset>
<noframes><body>
</body>
</noframes></html>