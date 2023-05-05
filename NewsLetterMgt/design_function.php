<?php include("../protect1.php"); ?>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($FuncG6 != "G6"){ Header("Location:../admin_error.php?E=Err2"); exit; }
if(eregi("G6",$HTTP_GET_VARS['FuncG6'])){ Header("Location:../admin_error.php?E=Err2"); exit; }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($Flaggo=="del"){
$limitNewsD = "<"."?"."\n";
$limitNewsD .= "$"."enewsletter"." = "."\"".$seltemp."\"".";"."\n";
$limitNewsD .= "?".">";
$fw1 = @fopen($UserPath."enewsletter.dll", "w");
if(!$fw1){ die("Cannot write default"); }
$FlagW1 = fwrite($fw1,$limitNewsD);
@fclose($fw1);

for($i=0;$i<$all;$i++){
$chk = "chk".$i;
$chk = $$chk;
if($chk!=""){
@unlink($UserPath."temp".$sign.$chk.".dll");
}
}
?>
<script language="JavaScript">
window.location.href="design.php?msg=Y";
</script>
	<?php
	}else{
		if($NoBGH != "Y"){
if(($newslfileh_size > 0)and($newslfileh_size < 200000)){
copy($newslfileh,$UserPath."images".$sign.$newslfileh_name);
$NLTHeadPName = $newslfileh_name;
unlink($newslfileh);
}else{
$NLTHeadPName = $NLTHeadP;
}
		}else{
		$NLTHeadPName = "";
		}

				if($NoBGB != "Y"){
if(($newslfileb_size > 0)and($newslfileb_size < 200000)){
copy($newslfileb,$UserPath."images".$sign.$newslfileb_name);
$NLTBodyPName = $newslfileb_name;
unlink($newslfileb);
}else{
$NLTBodyPName = $NLTBodyP;
}
		}else{
		$NLTBodyPName = "";
		}
if($NLTHeadS == ""){
$NLTHeadST = "";
}elseif($NLTHeadS == "8"){
$NLTHeadST = "1";
}elseif($NLTHeadS == "10"){
$NLTHeadST = "2";
}elseif($NLTHeadS == "12"){
$NLTHeadST = "3";
}elseif($NLTHeadS == "14"){
$NLTHeadST = "4";
}elseif($NLTHeadS == "18"){
$NLTHeadST = "5";
}elseif($NLTHeadS == "24"){
$NLTHeadST = "6";
}elseif($NLTHeadS == "36"){
$NLTHeadST = "7";
}
if($NLTBodyS == ""){
$NLTBodyST = "";
}elseif($NLTBodyS == "8"){
$NLTBodyST = "1";
}elseif($NLTBodyS == "10"){
$NLTBodyST = "2";
}elseif($NLTBodyS == "12"){
$NLTBodyST = "3";
}elseif($NLTBodyS == "14"){
$NLTBodyST = "4";
}elseif($NLTBodyS == "18"){
$NLTBodyST = "5";
}elseif($NLTBodyS == "24"){
$NLTBodyST = "6";
}elseif($NLTBodyS == "36"){
$NLTBodyST = "7";
}

$fwr = "<"."?"."\n";
//Head
$fwr .= "$"."NLTTBW = \"".$NLTTBW."\";"."\n";
$fwr .= "$"."NLTHeadH = \"".$NLTHeadH."\";"."\n";
$fwr .= "$"."NLTHeadP = \"".$NLTHeadPName."\";"."\n";  //pic head
$fwr .= "$"."NLTHeadBG = \"".$NLTHeadBG."\";"."\n";
$fwr .= "$"."NLTHeadT = \"".$NLTHeadT."\";"."\n";
$fwr .= "$"."NLTHeadF = \"".$NLTHeadF."\";"."\n";
$fwr .= "$"."NLTHeadS = \"".$NLTHeadST."\";"."\n";
$fwr .= "$"."NLTHeadBGTC = \"".$NLTHeadBGTC."\";"."\n";
$fwr .= "$"."NLTHeadB = \"".$NLTHeadB."\";"."\n";
$fwr .= "$"."NLTHeadI = \"".$NLTHeadI."\";"."\n";
//Body
$fwr .= "$"."NLTBodyBG = \"".$NLTBodyBG."\";"."\n";
$fwr .= "$"."NLTBodyP = \"".$NLTBodyPName."\";"."\n";  //body pic
$fwr .= "$"."NLTBodyTD = \"".$NLTBodyTD."\";"."\n";
$fwr .= "$"."NLTBodyTA = \"".$NLTBodyTA."\";"."\n";
$fwr .= "$"."NLTBodyTC = \"".$NLTBodyTC."\";"."\n";
$fwr .= "$"."NLTBodyTS = \"".$NLTBodyTS."\";"."\n";
$fwr .= "$"."NLTBodyTL = \"".$NLTBodyTL."\";"."\n";
$fwr .= "$"."NLTBodyF = \"".$NLTBodyF."\";"."\n";
$fwr .= "$"."NLTBodyS = \"".$NLTBodyST."\";"."\n";
$fwr .= "$"."NLTBodyBGT = \"".$NLTBodyBGT."\";"."\n";
$fwr .= "$"."NLTBodyB = \"".$NLTBodyB."\";"."\n";
$fwr .= "$"."NLTBodyI = \"".$NLTBodyI."\";"."\n";
$fwr .= "?".">";
$fw0 = @fopen($UserPath."temp".$sign.$filenameS.".dll", "w");
if(!$fw0){ die("Cannot write ".$UserPath."temp".$sign.$filenameS.".dll"); }
$FlagW0 = fwrite($fw0, $fwr);
@fclose($fw0); 

if($usethistemp == "Y"){
$limitNewsD = "<"."?"."\n";
$limitNewsD .= "$"."enewsletter"." = "."\"".$filenameS."\"".";"."\n";
$limitNewsD .= "?".">";
$fw1 = @fopen($UserPath."enewsletter.dll", "w");
if(!$fw1){ die("Cannot write default"); }
$FlagW1 = fwrite($fw1,$limitNewsD);
@fclose($fw1);
}

?>
<script language="JavaScript">
window.opener.location.href="design.php?msg=Y";
window.close();
</script>
	<?php
}
?>
