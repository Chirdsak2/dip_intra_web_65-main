<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_block_function.php");
include("lang_config.php");
?>

<?php
	$part=$_SESSION['part'];
	$startd=$_SESSION['startd'];
	$endd=$_SESSION['endd'];
	$test=$_SESSION['test'];
?>
<div class="dContainer" > 
<div class="modal-dialog modal-lg" >

<div class="modal-content">
        <div class="modal-header">
           <!--<button type="button" class="close" onclick="$('#box_popup').fadeOut();" >&times;</button>-->
          <h4 class="modal-title"><?=$lang_add_survey; ?></h4>
        </div>
		
<form name="form1" method="post" >
<div class="modal-body">
<div class="scrollbar scrollbar-near-moon thin">
<?php for($i=1;$i<=$part;$i++){  ?>

<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_section2;?> <?=$i;?>  : </label>
     
      </div>
</div>
	
<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_sectionname;?> : </label>
        <textarea   class="form-control" name="error_page"  id="error_page"  cols="60" rows="6" ></textarea>
      </div>
</div>	  
</div>
</div>
<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_error;?> : </label>
        <textarea   class="form-control" name="error_page"  id="error_page"  cols="60" rows="6" ></textarea>
      </div>
</div>	  
</div>
</div>
<div class="form-group ">
<div class="form-inline">
<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="error_page"><?=$lang_add_error;?> : </label>
        <textarea   class="form-control" name="error_page"  id="error_page"  cols="60" rows="6" ></textarea>
      </div>
</div>	  
</div>
</div>


<?php } ?>
<input name="proc" type="hidden" id="proc" value="2">





<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $lang_add_survey?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
      <td align="right"> <a href="add_survey1.php" target="_self">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> 
        <a href="main_survey.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
        <?php echo $lang_design_back;?></a>
<hr>
    </td>
</table>


  <table width="94%"   align="center" cellpadding="5" cellspacing="1"  class="ewttableuse">
    <tr height="30"> 
      <td colspan="2"> <div align="right"> <?php echo $lang_add_start2 ?> ( <?php echo $startd; ?> 
          ) <?php echo $lang_add_end2 ?> ( <?php echo $endd; ?> )</div></td>
    </tr>
    <?php for($i=1;$i<=$part;$i++){  ?>
    <tr class="ewttablehead" valign="top"> 
      <td colspan="2"> <div align="left"><strong> <?php echo $lang_add_section2 ?> 
          <?php echo $i; ?> .</strong></div></td>
    </tr>
    <tr valign="top" height="70"> 
      <td width="30%" bgcolor="#FFFFFF"> <?php echo $lang_add_sectionname ?> <?php echo $i; ?> 
        .</td>
      <td width="70%" bgcolor="#FFFFFF"> <textarea name="name<?php echo $i; ?>" cols="40" rows="5" wrap="VIRTUAL" id="name<?php echo $i; ?>"></textarea> 
        <script>
		var oEdit1<?php echo $i; ?> = new InnovaEditor("oEdit1<?php echo $i; ?>");
		oEdit1<?php echo $i; ?>.width="100%";
		oEdit1<?php echo $i; ?>.height="200";
		    oEdit1<?php echo $i; ?>.tabs=[
    ["tabHome", "", ["grpFont", "grpPara"]]
    ];

    oEdit1<?php echo $i; ?>.groups=[
    ["grpFont", "", ["FontName", "FontSize", "BRK", "Bold", "Italic", "Underline","Strikethrough","Superscript","Subscript", "ForeColor", "BackColor"]],
    ["grpPara", "", ["Paragraph", "Indent", "Outdent", "LTR", "RTL", "BRK", "JustifyLeft", "JustifyCenter","JustifyRight","JustifyFull", "Numbering","Bullets"]]
    ];
		oEdit1<?php echo $i; ?>.mode="HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"
		oEdit1<?php echo $i; ?>.REPLACE("name<?php echo $i; ?>");
		</script> </td>
    </tr>
    <tr height="70" valign="top"> 
      <td width="120" bgcolor="#FFFFFF"> <?php echo $lang_add_description ?> </td>
      <td bgcolor="#FFFFFF"> <textarea name="des<?php echo $i; ?>" cols="40" rows="5" wrap="VIRTUAL" id="des<?php echo $i; ?>"></textarea> 
        <script>
		var oEdit2<?php echo $i; ?> = new InnovaEditor("oEdit2<?php echo $i; ?>");
		oEdit2<?php echo $i; ?>.width="100%";
		oEdit2<?php echo $i; ?>.height="200";
		 oEdit2<?php echo $i; ?>.tabs=[
    ["tabHome", "", ["grpFont", "grpPara"]]
    ];

    oEdit2<?php echo $i; ?>.groups=[
    ["grpFont", "", ["FontName", "FontSize", "BRK", "Bold", "Italic", "Underline","Strikethrough","Superscript","Subscript", "ForeColor", "BackColor"]],
    ["grpPara", "", ["Paragraph", "Indent", "Outdent", "LTR", "RTL", "BRK", "JustifyLeft", "JustifyCenter","JustifyRight","JustifyFull", "Numbering","Bullets", "XHTMLSource"]]
    ];
		oEdit2<?php echo $i; ?>.mode="HTMLBody"; //Editing mode. Possible values: "HTMLBody" (default), "XHTMLBody", "HTML", "XHTML"
		oEdit2<?php echo $i; ?>.REPLACE("des<?php echo $i; ?>");
		</script> </td>
    </tr>
    <tr height="25"> 
      <td width="120" bgcolor="#FFFFFF"> <?php echo $lang_add_questiontype ?> </td>
      <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr> 
            <td width="2%"> <input name="gr<?php echo $i; ?>" type="radio" value="N"  onClick="document.form1.sel<?php echo $i; ?>.disabled=true;document.form1.num<?php echo $i; ?>.disabled=true;" checked> 
            </td>
            <td width="19%" bgcolor="#FFFFFF"><?php echo $lang_add_questiontype_separate ?></td>
            <td width="2%" bgcolor="#FFFFFF"> <input type="radio" name="gr<?php echo $i; ?>" value="Y" onClick="document.form1.sel<?php echo $i; ?>.disabled=false;document.form1.num<?php echo $i; ?>.disabled=false;"> 
            </td>
            <td width="18%" bgcolor="#FFFFFF"><?php echo $lang_add_questiontype_single ?></td>
            <td width="9%" bgcolor="#FFFFFF"> <select name="sel<?php echo $i; ?>" id="sel<?php echo $i; ?>" disabled>
                <option value="A">Radio Box</option>
                <option value="B">Check Box</option>
              </select> </td>
            <td width="16%" bgcolor="#FFFFFF"><?php echo $lang_add_questiontype_single_amount ?></td>
            <td width="3%" bgcolor="#FFFFFF"> <input name="num<?php echo $i; ?>" type="text" disabled id="num<?php echo $i; ?>" value="3" size="5"> 
            </td>
            <td width="31%" bgcolor="#FFFFFF"><?php echo $lang_add_questiontype_single_answer ?></td>
          </tr>
        </table></td>
    </tr>
    <?php } ?>
    <tr height="30"> 
      <td colspan="2" bgcolor="#666666"> <div align="right"> <font face="MS Sans Serif"> 
          <input type="submit" name="Submit" value="<?php echo $lang_add_next ?>">
          <input name="Flag" type="hidden" id="Flag" value="2">
          </font></div></td>
    </tr>
  </table>  
</form>


<div class="modal-footer">
<div class="form-group row text-center">
<div class="col-md-12 col-sm-12 col-xs-12" >
<button onclick="JQAdd_survey2();" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_save; ?>" >
<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?=$lang_survey_save; ?>
</button> 
<!--<input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
<input name="reset" type="reset" value="ยกเลิก" class="btn btn-warning"  onClick="$('#box_popup').fadeOut();">
<button class="btn btn-warning btn-lm" onClick="$('#box_popup').fadeOut();" data-toggle="tooltip" data-placement="top" title="<?=$lang_survey_update; ?>" >
<span class="glyphicon glyphicon-remove"></span>&nbsp;<?="ยกเลิก";?>-->
</button> 
</div>
</div>
</div>


</div>
</div>
</div>