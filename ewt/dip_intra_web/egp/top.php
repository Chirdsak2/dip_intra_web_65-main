<?php
header ("Content-Type:text/html;Charset=UTF-8");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//print_r($_SESSION);
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ประกาศจัดซื้อจัดจ้างภาครัฐ</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet">

	<script  src="../js/date-picker.js" type="text/javascript"></script>
<style>
a:link {
    text-decoration: none;
	color:#000000;
}

a:visited {
    text-decoration: none;
	color:#000000;
}

a:hover {
    text-decoration: none;
	color:#000000;
}

a:active {
   text-decoration: none;
   color:#000000;
}
body {
	font-family: 'Prompt', sans-serif;
	font-size: 16px;
	overflow-x: hidden !important;
	color: #000000;
	padding:0px !important;
	margin:0px !important;
}
.font_ahrf a:link {
   color:#000000;
}
.font_ahrf a:visited {
   color:#000000;
}
.font_ahrf a:hover {
   color:#838282;
}
.font_ahrf a:active {
   color:#838282;
}
.bg_navbar{
	background-color:#FFFFFF;
}
.navbar-inverse .btn-link:focus, .navbar-inverse .btn-link:hover {
     color: #9d9d9d;
	 text-decoration: none;
}
.btn-link, .btn-link:active, .btn-link:focus, .btn-link:hover{
	 color: #000000;	
}
.navbar-inverse .btn-link {
    color: #000000;
}
.navbar {
	   
}
/*--------------------*/
/* MODAL */
/*--------------------*/

.option_doc {
  color:#7F7F7F;
  padding:3px;
}
.layer-modal{
  z-index:3000;
  display:none;
  padding-top:60px;
  position:fixed;
  left:0;
  right:0;
  top:0;
  width:100%;
  height:100%;
  overflow:auto;
  background-color:rgb(0,0,0);
  background-color:rgba(0,0,0,0.4);
}
.form-doc {
  position: relative;
  background-color: #fff;
  -webkit-background-clip: padding-box;
  background-clip: padding-box;
  border: 1px solid rgba(0, 0, 0, .2);
  border-radius: .3rem;
  outline: 0;
}
.card-animate-zoom {
  -webkit-animation:animatezoom 0.6s;
  animation:animatezoom 0.6s;
  }
.pop-header {
    padding: 5px 15px;
    border-bottom: 1px solid #e5e5e5;

}
.pop-title {
    margin: 0;
    line-height: 1.5;
}
.pop-body {
    position: relative;
    padding: 15px;
}
.pop-footer {
    padding: 15px;
    text-align: right;
    border-top: 1px solid #e5e5e5;
}
</style>
</head>
<body>
<!--<nav class="navbar navbar-inverse navbar-fixed-top bg_navbar">
<div class="container-fluid">
<div class="navbar-header">
<img alt="Brand" src="http://process3.gprocurement.go.th/EPROCRssFeedWeb/images/header_eGP1.jpg">
</div>  
</div>-->
<div class="row">
<div class="col-sm-12">
<a href="index.php?ID=<?=$_GET['ID'];?>" target="_self">
<button type="button" class="btn btn-link"  >
<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;<?="ประกาศจัดซื้อจัดจ้าง";?>
</button>
</a>
<!--<a href="gprocurement_type.php" target="_self">
<button type="button" class="btn btn-link  btn-ml"   >
<span class="glyphicon glyphicon-triangle-right"></span>&nbsp;<?="ประเภทประกาศ";?>
</button>
</a>
<a href="gprocurement_process.php" target="_self">
<button type="button" class="btn btn-link  btn-ml" >
<span class="glyphicon glyphicon-triangle-right"></span>&nbsp;<?="วิธีการจัดหา";?>
</button>
</a>	
<a href="gprocurement_dept.php" target="_self">
<button type="button" class="btn btn-link  btn-ml"   >
<span class="glyphicon glyphicon-triangle-right"></span>&nbsp;<?="รหัสหน่วยงานรัฐ";?>
</button>
</a>
<a href="gprocurement_deptsub.php" target="_self">
<button type="button" class="btn btn-link  btn-ml"  >
<span class="glyphicon glyphicon-triangle-right"></span>&nbsp;<?="รหัสหน่วยจัดซื้อย่อย";?>
</button>
</a>-->
</div>
</div>
<!--</nav>-->
