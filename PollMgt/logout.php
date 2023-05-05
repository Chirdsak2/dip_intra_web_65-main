<?php
session_start();
$adminlogin = "";

session_unregister("adminlogin");

session_destroy();
?>
<html>
<head>
<title>Vote Administrator</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: underline}
a:hover { color: #0099FF; text-decoration: underline}
-->
</style>
<link rel="stylesheet" href="onbody.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" class="work_title">
<div align="center"><br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
ท่านออกจากระบบเรียบร้อยแล้ว
<br>
<br>
<a href="index.php">กลับหน้าหลัก</a></div>
</body>
</html>
