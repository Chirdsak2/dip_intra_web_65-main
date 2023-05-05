<?php
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
$F = $db->db_fetch_array($sql_index);
$sql_file = $db->query("SELECT * FROM temp_magic WHERE filename = '".$_GET["filename"]."' ORDER BY position ASC");
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript">
function edittext(c){
	win2 = window.open('ewt_editor.php?filename=<?php echo $_GET["filename"];?>&text_id=' + c + '' ,'editCoding','top=60,left=80,width=640,height=480,resizable=1,status=0');
	win2.focus();
}
function editcoding(c){
	win2 = window.open('../../ContentMgt/content_coding.php?filename=<?php echo $_GET["filename"];?>&text_id=' + c + '' ,'editCoding','top=60,left=80,width=640,height=480,resizable=1,status=0');
	win2.focus();
}
function editgraph(c){
	win2 = window.open('../../ContentMgt/content_graph.php?filename=<?php echo $_GET["filename"];?>&graph_id=' + c + '' ,'editGraph','top=60,left=80,width=640,height=480,resizable=1,status=0');
	win2.focus();
}
function editarticle(c){
	win2 = window.open('../../ContentMgt/content_article.php?filename=<?php echo $_GET["filename"];?>&text_id=' + c + '' ,'editArticle','top=60,left=80,width=640,height=480,resizable=1,status=0');
	win2.focus();
}
function MoveUp(c){
						document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"moveupform\" method=\"post\" action=\"../../ContentMgt/content_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"MoveUp\"><input name=\"filename\" type=\"hidden\" id=\"filename\" value=\"<?php echo $_GET["filename"];?>\"><input name=\"text_id\" type=\"hidden\" id=\"text_id\" value=\""+ c +"\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
						moveupform.submit();
}
function MoveDown(c){
						document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"movedownform\" method=\"post\" action=\"../../ContentMgt/content_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"MoveDown\"><input name=\"filename\" type=\"hidden\" id=\"filename\" value=\"<?php echo $_GET["filename"];?>\"><input name=\"text_id\" type=\"hidden\" id=\"text_id\" value=\""+ c +"\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
						movedownform.submit();
}
	function button_over(eButton){
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "buttonhighlight solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "buttonhighlight solid 1px";
	}
				
	function button_out(eButton){
	eButton.style.borderColor = "F3F3EE";
	}
function delete_c(c){
	var r = confirm('Are you sure you want to delete this block and all its contents?');
		if(r == true){
						document.all.formtext.innerHTML = "<table width=\"100%\" height=\"100%\"><form name=\"delform\" method=\"post\" action=\"../../ContentMgt/content_function.php\"><input name=\"Flag\" type=\"hidden\" id=\"Flag\" value=\"delcontent\"><input name=\"filename\" type=\"hidden\" id=\"filename\" value=\"<?php echo $_GET["filename"];?>\"><input name=\"text_id\" type=\"hidden\" id=\"text_id\" value=\""+ c +"\"></form><tr><td><div align=\"center\"><font size=\"5\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>Please Wait...</strong></font></div></td></tr></table>";
						delform.submit();
		}
}
</script>
<link href="css/<?php echo $F[css_file]; ?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.unnamed1 {
	border: thick dashed;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" <?php if($_SESSION["EWT_HIDDEN_DESIGN"] == "N"){  if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; }  if($F["d_site_bg_p"] != ""){ echo "background=\"userpic/".$F["d_site_bg_p"]."\""; } } ?>>
<span id="formtext"></span>
<?php if($_SESSION["EWT_HIDDEN_DESIGN"] == "Y"){ ?>
<table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td valign="top" bgcolor="808080"><table width="100%" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="#000000">
        <tr>
          <td valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
		  <tr> 
                <td><font size="2" face="Tahoma"> <img src="../../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                  Page Name : [<?php echo $_GET["filename"]; ?>] <font color="#999999" size="1">Create 
                  on 01/01/2007 11:00:30 Last Update 11/05/2007 12:03.22</font></font></td>
  </tr>
<?php if($F[css_file] != ""){ ?>
  <tr> 
                <td><font size="2" face="Tahoma">Cascadind Style Sheet File : 
                  <?php echo $F[css_file]; ?></font></td>
  </tr>
  <?php
  }
  ?>
  </table>
<?php }else{ ?>
<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" colspan="3" ><?php echo stripslashes($F["d_top_content"]); ?></td>
        </tr>
        <tr valign="top" > 
          <td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" ></td>
          
    <td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>"  >
	<?php
	}
			$allrow = $db->db_num_rows($sql_file);
			$i = 1;
while($R = $db->db_fetch_array($sql_file)){
?>
            <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="CCCCCC">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEEEEE">
			<tr> 
                      <td height="16" bgcolor="#FFFFFF"> <table width="100%" height="20" border="0" cellpadding="0" cellspacing="0">
                          <tr bgcolor="F3F3EE"> 
                            <td width="50" rowspan="3" bgcolor="#FFFFFF"><img src="../../images/<?php if($R["object"] == "Text"){ echo "c_text.gif"; }elseif($R["object"] == "Coding"){ echo "c_coding.gif"; }elseif($R["object"] == "Graph"){ echo "c_chart.gif"; }elseif($R["object"] == "Article"){ echo "c_article.gif"; } ?>" width="24" height="24" hspace="5" vspace="0" border="0" align="absmiddle" ></td>
                            <td width="77" height="24" rowspan="3" align="right" valign="top" bgcolor="#FFFFFF"><img src="../../images/c_bar.gif" width="71" height="23"></td>
                            <td height="21" align="right" valign="top" bgcolor="F3F3EE"> 
                              <a href="#text<?php echo $R["text_id"]; ?>" onClick="<?php if($R["object"] == "Text"){ ?>edittext('<?php echo $R["text_id"]; ?>')<?php  }elseif($R["object"] == "Coding"){  ?>editcoding('<?php echo $R["text_id"]; ?>')<?php  }elseif($R["object"] == "Graph"){  ?>editgraph('<?php echo $R["link_id"]; ?>')<?php }elseif($R["object"] == "Article"){  ?>editarticle('<?php echo $R["text_id"]; ?>')<?php } ?>"><img src="../../images/bar_edit.gif" width="20" height="20" align="absmiddle"  border="1" style="border-Color:F3F3EE"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Edit Content"></a> 
                              <?php if($allrow > 1){ 
						if($i > 1){ 
						?>
                              <a href="#up" onClick="MoveUp('<?php echo $R["text_id"]; ?>')"><img src="../../images/bar_up.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Move Content Up"></a> 
                              <?php
						}else{
						?>
						<img src="../../images/bar_up_off.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE">
						<?php
						}
						 if($i != $allrow){ ?>
                              <a href="#down" onClick="MoveDown('<?php echo $R["text_id"]; ?>')"><img src="../../images/bar_down.gif" width="20" height="20"  align="absmiddle" border="1" style="border-Color:F3F3EE"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Move Content Down"></a> 
                              <?php }else{
							  ?>
							  <img src="../../images/bar_down_off.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE">
							  <?php
							   }
							  
							  }else{
							  ?>
							  <img src="../../images/bar_up_off.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE">  <img src="../../images/bar_down_off.gif" width="20" height="20" align="absmiddle" border="1" style="border-Color:F3F3EE">
							  <?php
							  }
							   ?>
                              <a id="#text<?php echo $R["text_id"]; ?>" href="#del" onClick="delete_c('<?php echo $R["text_id"]; ?>')"><img src="../../images/bar_delete.gif" width="20" height="20"  align="absmiddle" border="1" style="border-Color:F3F3EE"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Delete Content Block"></a> 
                            </td>
                          </tr>
                          <tr bgcolor="#CCCCCC"> 
                            <td height="1" valign="bottom"></td>
                          </tr>
                          <tr bgcolor="F3F3EE"> 
                            <td height="5" valign="bottom" bgcolor="#FFFFFF"></td>
                          </tr>
                        </table></td>
              </tr>
              <tr> 
                      <td height="20"  bgcolor="<?php echo $F["d_body_bg_c"]; ?>"> 
                        <?php if($R["object"] == "Text" ){ 
				if($R[html_content] == ""){ ?>
                        <br>
<table width="300" height="120" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="E7E7E7" style="border: thick dashed;">
                          <tr>
                            <td align="center" bgcolor="#FFFFFF"><font color="#CCCCCC" size="4" face="Tahoma"><strong>Put 
                              Your Content Here</strong></font></td>
                          </tr>
                        </table>
                        <br>
                        <?php }else{ echo $R[html_content]; }
				}elseif($R["object"] == "Coding"){ 
				if($R[html_content] == ""){ ?>
                        <br>
<table width="300" height="120" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFEAEA" style="border: thick dashed;">
                          <tr>
                            <td align="center" bgcolor="#FFFFFF"><font color="#FFE0D9" size="4" face="Tahoma"><strong>Put 
                              Your Coding Here</strong></font></td>
                          </tr>
                        </table>
                        <br>
                        <?php }else{ echo $R[html_content]; }
				}elseif($R["object"] == "Graph"){ 
				$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$R["link_id"]."'");
					if($db->db_num_rows($sql_graph)){
					$G = $db->db_fetch_array($sql_graph);
				?>
                        <div align="<?php echo $G["graph_align"]; ?>"><img src="../../ContentMgt/graph_view.php?graph_id=<?php echo $R["link_id"]; ?>" width="<?php echo $G["graph_width"]; ?>" height="<?php echo $G["graph_height"]; ?>"></div>
				        <?php
					}
				 }elseif($R["object"] == "Article"){ 
				$sql_article_group = $db->query("SELECT * FROM article_group INNER JOIN article_apply ON article_group.c_id = article_apply.c_id  WHERE article_apply.text_id = '".$R["text_id"]."'  AND article_apply.a_active = 'Y' ORDER BY article_apply.a_pos ASC");
				if($db->db_num_rows($sql_article_group) > 0){
					while($AG = $db->db_fetch_array($sql_article_group)){
				?>
                        <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <?php if($AG["amd_mode"] == "basic" OR $AG["amd_mode"] == ""){ ?><td width="0%" valign="top"><?php if($AG["AMBulletBP"] != ""){ echo "<img name=\"img01\" src=\"".$Website."/images/".$AG["AMBulletBP"]."\">"; } ?></td><?php } ?>
    <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	<?php if($AG["amd_mode"] == "basic" OR $AG["amd_mode"] == ""){ ?>
              <tr > 
                <td colspan="2"  bgcolor="<?php echo $AG["AMHeadBG"]; ?>" <?php if($AG["AMHeadP"] != ""){ echo "background=\"".$Website."/images/".$AG["AMHeadP"]."\""; } ?>>
                  <?php if($AG["AMBulletSP"] != ""){ echo "<img  src=\"".$Website."/images/".$AG["AMBulletSP"]."\">"; } ?>
                  <font face="<?php echo $AG["AMHeadF"]; ?>" color="<?php echo $AG["AMHeadC"]; ?>" size="<?php echo $AG["AMHeadS"]; ?>"><span id="name01" style="display:'';<?php if($AG["AMHeadB"]=="Y"){ echo ";font-Weight:bold"; } ?><?php if($AG["AMHeadI"]=="Y"){ echo ";font-Style:italic"; } ?>"><?php echo $AG["c_name"]; ?></span></font></td>
              </tr>
			  <?php } ?>
			  <?php if($AG["amd_mode"] == "html"){ ?>
			  <tr>
                <td colspan="2" ><?php echo stripslashes($AG["code_html"]); ?></td>
              </tr>
			  <?php } ?>
		<?php	  $sql_article = $db->query("SELECT n_topic,n_date FROM article_list WHERE c_id = '".$AG["c_id"]."' ORDER BY n_date DESC,n_timestamp DESC");
						 	while($A = $db->db_fetch_array($sql_article)){
							$date = explode("-",$A["n_date"]);
							?>
              <tr id="bg02" bgcolor="<?php echo $AG["AMBodyBG"]; ?>"> 
                <td valign="top">
                  <?php if($AG["AMBodyBP"] != ""){ echo "<img name=\"img03\" src=\"".$Website."/images/".$AG["AMBodyBP"]."\">"; } ?>
                </td>
                <td width="100%" valign="top"><font face="<?php echo $AG["AMBodyF"]; ?>" color="<?php echo $AG["AMBodyC"]; ?>" size="<?php echo $AG["AMBodyS"]; ?>"><span id="name02" style="display:'';<?php if($AG["AMBodyB"]=="Y"){ echo ";font-Weight:bold"; } ?><?php if($AG["AMBodyI"]=="Y"){ echo ";font-Style:italic"; } ?>"><?php echo $A["n_topic"]; ?></span></font></td>
              </tr>
			  <?php } ?>
              <tr valign="top" bgcolor="<?php echo $AG["AMBodyBG"]; ?>">
                <td></td>
                <td><div align="right">
                    <?php if($AG["AMMorePic"] != ""){ echo "<img name=\"img04\" src=\"".$Website."/images/".$AG["AMMorePic"]."\">"; } ?>
                    <font face="<?php echo $AG["AMBottomF"]; ?>" color="<?php echo $AG["AMBottomC"]; ?>" size="<?php echo $AG["AMBottomS"]; ?>"><span id="name03" style="display:'';<?php if($AG["AMBottomB"]=="Y"){ echo ";font-Weight:bold"; } ?><?php if($AG["AMBottomI"]=="Y"){ echo ";font-Style:italic"; } ?>"><?php echo $AG["AMMORE"]; ?></span></font></div></td>
              </tr>
            </table></td>
  </tr>
  <tr bgcolor="<?php echo $AG["AMBOTTOMBG"]; ?>" id="bg04" style="height:<?php echo $AG["AMBOTTOMH"]; ?>" <?php if($AG["AMBOTTOMP"] != ""){ echo "background=\"".$Website."/images/".$AG["AMBOTTOMP"]."\""; } ?>>
    <td colspan="2" ></td>
    </tr>
</table> 
                        <?php
					}
					}else{
					?><br>
<table width="300" height="120" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#D7D7FF" style="border: thick dashed;">
                          <tr>
                            <td align="center" bgcolor="#FFFFFF"><font color="#B0B0FF" size="4" face="Tahoma"><strong>Manage 
                              Your Article Here</strong></font></td>
                          </tr>
                        </table><br>
<?php
					}
				 }
				 ?>
                      </td>
              </tr>
              
            </table>
			</td>
  </tr>
</table>

            
			<table width="10" height="5" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td></td>
              </tr>
            </table>
  <?php $i++; } ?>
  
  <?php if($_SESSION["EWT_HIDDEN_DESIGN"] == "Y"){ ?>
  <br>
</td>
        </tr>
      </table></td>
  </tr>
</table>
  <?php }else{ ?>
	</td>
          <td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" ></td>
        </tr>
        <tr valign="top" > 
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" colspan="3" ><?php echo stripslashes($F["d_bottom_content"]); ?></td>
        </tr>
      </table>
	  <?php } ?>
</body>
</html>
<?php $db->db_close(); ?>
