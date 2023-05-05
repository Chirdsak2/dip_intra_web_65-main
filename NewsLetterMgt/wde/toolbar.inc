<table border="1" cellspacing="0" cellpadding="0" width="<?php echo $width?>">
  <tr>
	<td>
	  <table width="100%" border="1" cellspacing="0" cellpadding="0">
	    <tr>
		  <td class="body" height="22">
	 		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide" align="center" id="toolbar_code">
			  <tr>
				<td class="body" height="22">
				  <table border="0" cellspacing="0" cellpadding="1">
			  		<tr>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_cut.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick='document.execCommand("Cut");foo.focus();' title="Cut (Ctrl+X)" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_copy.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick='document.execCommand("Copy");foo.focus();' title="Copy (Ctrl+C)" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_paste.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick='document.execCommand("Paste");foo.focus();' title="Paste (Ctrl+V)" class=toolbutton>
				</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_undo.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick='document.execCommand("Undo");foo.focus();' title="Undo (Ctrl+Z)" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_redo.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick='document.execCommand("Redo");foo.focus();' title="Redo (Ctrl+Y)" class=toolbutton>
				</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
						<input unselectable="on" type="image" border="0" src="wde/button_mode.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick="SwitchMode()" title="Switch Editing Mode (CODE or WYSIWYG)" class=toolbutton>
					  </td>
					  <td>
				  		<input class=toolbutton onMouseDown=button_down(this); onMouseOver=button_over(this); title="Show Preview" onClick=ShowPreview(1) onMouseOut=button_out(this); type=image width="21" height="20" src="wde/button_preview.gif" border=0 unselectable="on">
				</td>
					</tr>
				  </table>
				</td>
			  </tr>
			  <tr>
		  		<td class="body" bgcolor="#000000"><img src="wde/1x1.gif" width="1" height="1"></td>
			  </tr>
			  <tr>
		  		<td class="body" height="27">
		  		  <table border="0" cellspacing="0" cellpadding="5">
			  		<tr>
					  <td class=body>&nbsp;
				  		</td>
					</tr>
				  </table>
				</td>
			  </tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bevel3" align="center" id="toolbar_full">
			  <tr>
		  		<td class="body" height="22">
				  <table border="0" cellspacing="0" cellpadding="1">
			  		<tr>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_cut.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Cut");foo.focus();' title="Cut (Ctrl+X)" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_copy.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='document.execCommand("Copy");foo.focus();' title="Copy (Ctrl+C)" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_paste.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Paste");foo.focus();' title="Paste (Ctrl+V)" class=toolbutton>
				</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_undo.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='document.execCommand("Undo");foo.focus();' title="Undo (Ctrl+Z)" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_redo.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='document.execCommand("Redo");foo.focus();' title="Redo (Ctrl+Y)" class=toolbutton>
				</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
						<input unselectable="on" type="image" border="0" src="wde/button_mode.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick="SwitchMode()" title="Switch Editing Mode (CODE or WYSIWYG)" class=toolbutton>
					  </td>
					  <td>
						<input class=toolbutton onMouseDown=button_down(this); onMouseOver=button_over(this); title="Show Preview" onClick=ShowPreview() onMouseOut=button_out(this); type=image width="21" height="20" src="wde/button_preview.gif" border=0 unselectable="on">
					  </td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_bold.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Bold");foo.focus();' title="Bold (Ctrl+B)" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_underline.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Underline");foo.focus();' title="Underline (Ctrl+U)" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_italic.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Italic");foo.focus();' title="Italic (Ctrl+I)" class=toolbutton>
				</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_numbers.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("InsertOrderedList");foo.focus();' title="Insert Number List" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_bullets.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("InsertUnorderedList");foo.focus();' title="Insert Bullet List" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_decrease_indent.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Outdent");foo.focus();' title="Decrease Indent" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_increase_indent.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("Indent");foo.focus();' title="Increase Indent" class=toolbutton>
				</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_align_down.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick="showMenu('alignMenu',72,24)" title="Alignment" class=toolbutton>
				</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_link.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doLink()' title="Create HyperLink (Text or Image must be selected first)" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_anchor.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doAnchor()' title="Insert / Modify Anchor" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_email.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doEmail()' title="Create Email Link (Text or Image must be selected first)" class=toolbutton>
				</td>
					</tr>
	  			  </table>
				</td>
			  </tr>
			  <tr>
		  		<td class="body" bgcolor="#000000"><img src="wde/1x1.gif" width="1" height="1"></td>
			  </tr>
			  <tr>
		  		<td class="body" height=22>
				  <table border="0" cellspacing="0" cellpadding="1">
			  		<tr>
					  <td>
					  <?php  
			  $f1 = fopen("../ContentMgt/font_list.txt","r");
			  while($line1 = fgets($f1,1024)){
			  $fontL .= $line1; 
			  }
			  fclose($f1);
			 $FontA = explode("###",$fontL);  
			  ?>
				  		<select onChange="(isAllowed()) ? foo.document.execCommand('FontName',false,this[this.selectedIndex].value) :foo.focus();foo.focus();this.selectedIndex=0" class="Text100" unselectable="on">
			  			  <option selected>Font</option>
			<?php
		$i = 0;
		 while($FontA[$i]){ ?>
		 <option value="<?php echo $FontA[$i]; ?>" <?php if($FontA[$i]==$Hfont){ echo "selected"; } ?>><?php echo $FontA[$i]; ?></option>
		<?php
		$i++;
		 } ?>
			
				  		</select>
				</td>
					  <td>
				  		<select onChange="(isAllowed()) ? foo.document.execCommand('FontSize',true,this[this.selectedIndex].value) :foo.focus();foo.focus();this.selectedIndex=0" class=Text45 unselectable="on">
			  			  <option SELECTED>Size
			  			  <option value="1">1
			  			  <option value="2">2
			  			  <option value="3">3
			  			  <option value="4">4
			  			  <option value="5">5
			  			  <option value="6">6
			  			  <option value="7">7
	  			  		</select>
				</td>
					  <td>
				  		<select onChange="(isAllowed()) ? doFormat(this[this.selectedIndex].value) : foo.focus();foo.focus();this.selectedIndex=0" class="Text60" unselectable="on">
				    	  <option selected>Format
				    	  <option value="<P>">Normal
						  <option value="SuperScript">SuperScript
						  <option value="SubScript">SubScript
				    	  <option value="<H1>">H1
				    	  <option value="<H2>">H2
				    	  <option value="<H3>">H3
				    	  <option value="<H4>">H4
				    	  <option value="<H5>">H5
				    	  <option value="<H6>">H6
				  		</select>
				</td>
					  <td>
				  		<select id=sStyles onChange="applyStyle(this[this.selectedIndex].value);foo.focus();this.selectedIndex=0;" class="Text90" unselectable="on">
				    	  <option selected>Style</option>
				    	  <option value="">None</option>
				  		</select>
				</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
						<input unselectable="on" type="image" border="0" src="wde/button_font_color.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick="showMenu('colorMenu',115,229)" title="Font Colour" class=toolbutton>
					  </td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_table_down.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick="(isAllowed()) ? showMenu('tableMenu',74,95) : foo.focus()" title="Table Functions" class=toolbutton>
						</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_form_down.gif" width="21" height="20" onMouseOver="button_over(this);" onMouseOut="button_out(this);" onMouseDown="button_down(this);" onClick="(isAllowed()) ? showMenu('formMenu',74,72) : foo.focus()" title="Form Functions" class=toolbutton>
						</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_hr.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick='doCommand("InsertHorizontalRule");foo.focus();' title="Insert Horizontal Line" class=toolbutton>
					</td>
					  <td><img src="wde/seperator.gif" width="2" height="20"></td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_image.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick="doImage()" title="Insert / Modify Image" class=toolbutton>
				</td>
					  <td>
				  		<input unselectable="on" type="image" border="0" src="wde/button_chars.gif" width="21" height="20" onmouseover="button_over(this);" onmouseout="button_out(this);" onmousedown="button_down(this);" onClick="InsertChars()" title="Insert Special Characters" class=toolbutton>
				</td>
					  <td>				
				  		<input class=toolbutton onmousedown=button_down(this); onmouseover=button_over(this); title="Clean HTML Code" onClick=cleanCode() onmouseout=button_out(this); type=image width="21" height="20" src="wde/button_clean_code.gif" border=0 unselectable="on">
				</td>
					  <td>
				  		<input class=toolbutton onMouseDown=button_down(this); onMouseOver=button_over(this); title="Show / Hide Guidelines" onClick=toggleBorders() onMouseOut=button_out(this); type=image width="21" height="20" src="wde/button_show_borders.gif" border=0 unselectable="on">
				</td>
					</tr>
				  </table>
				</td>
			  </tr>
	  		</table>
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr>
	<td>
	  <iframe id="foo" contentEditable onLoad=fooLoad(); height=<?php echo $height?> style="width:100%; visibility:show; background-color:white; padding:0; border:0 solid #000000; scrollbar-base-color:#dddddd; overflow=auto;"></iframe>
	</td>
  </tr>
  <tr>
	<td>
	  <div id="_status" style="width:100%; height:17px; background-color:#D4D0C8; font-family:verdana; font-size:10px; border-left: 1px solid buttonshadow;  border-right: 1px solid buttonhighlight;  border-top: 1px solid buttonshadow;  border-bottom: 1px solid buttonhighlight;"></div>
	</td>
  </tr>
</table>