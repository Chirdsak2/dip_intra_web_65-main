
<?php
## >> Style
$current_style = $_GET["current_style"];
$style_array   = array("null","black","yellow");
if(!in_array($current_style,$style_array)){
	$current_style = "null";
}

if($current_style=="null"){
?>
<style>
	/*.modal-header{background-color:;}
	.modal-header{border:}
	.modal-body{background-color:;}
	.modal-body{border:;}
	.modal-content{background-color:;}
	.modal-content{border:;}
	.modal-dialog{border:;}
	.close{color:;}*/
</style>
<?php
}
else if($current_style=="black"){
?>
<style>
	.modal-header{background-color:#000000;}
	.modal-header{border:1px solid #ffffff;}
	.modal-body{background-color:#000000;}
	.modal-body{border:1px solid #ffffff;}
	.modal-content{background-color:#000000;}
	.modal-content{border:1px solid #ffffff;}
	.modal-dialog{border:#000000;}
	.close{color:#ffffff;}
	.btn-secondary{background-color:#000000;}
	.btn-secondary{color:#ffffff;}
	.btn-secondary{border:1px solid #ffffff;}
	.btn-success{background-color:#000000;}
	.btn-success{color:#ffffff;}
	.btn-success{border:1px solid #ffffff;}
	.linebt{border-bottom:1px solid #ffffff;}
	.txt-dark-color{color:#ffffff;}
	
</style>
<?php
}
else if($current_style=="yellow"){
?>
<style>
	.modal-header{background-color:#000000;}
	.modal-header{border:1px solid #ffff00;}
	.modal-body{background-color:#000000;}
	.modal-body{border:1px solid #ffff00;}
	.modal-content{background-color:#000000;}
	.modal-content{border:1px solid #ffff00;}
	.modal-dialog{border:#000000;}
	.close{color:#ffff00;}
	.btn-secondary{background-color:#000000;}
	.btn-secondary{color:#ffff00;}
	.btn-secondary{border:1px solid #ffff00;}
	.btn-success{background-color:#000000;}
	.btn-success{color:#ffff00;}
	.btn-success{border:1px solid #ffff00;}
	.linebt{border-bottom:1px solid #ffff00;}
	.txt-dark-color{color:#ffff00;}
</style>
<?php
}
?>