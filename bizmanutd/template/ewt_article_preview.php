<?php
session_start();
header ("Content-Type:text/html;charset=UTF-8");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

	//==============================================
	if($bid){
		$bid=checkNumeric($bid);
	}
	if($_GET["bid"]){
		$_GET["bid"]=checkNumeric($_GET["bid"]);
	}
	if($_POST["bid"]){
		$_POST["bid"]=checkNumeric($_POST["bid"]);
	}
	
	if($gid){
		$gid=checkNumeric($gid);
	}
	if($_GET["gid"]){
		$_GET["gid"]=checkNumeric($_GET["gid"]);
	}
	if($_POST["gid"]){
		$_POST["gid"]=checkNumeric($_POST["gid"]);
	}
	
	if($data){
		$data=checkNumeric($data);
	}
	if($_GET["data"]){
		$_GET["data"]=checkNumeric($_GET["data"]);
	}
	if($_POST["data"]){
		$_POST["data"]=checkNumeric($_POST["data"]);
	}
	//==============================================
	
include("../../ewt_article_preview.php");

echo  GenArticle($_GET["bid"],"",$_GET["gid"],$_GET["data"]);

$db->db_close(); ?>
