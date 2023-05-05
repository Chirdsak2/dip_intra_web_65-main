	var imageWin
	var inserttableWin
	var previewWin
	var modifytableWin
	var insertFormWin
	var textFieldWin
	var hiddenWin
	var buttonWin
	var checkboxWin
	var radioWin
	var charWin
	var linkWin
	var emailWin
	var anchorWin

	var selectedTD
	var selectedTR
	var selectedTBODY
	var selectedTable
	var selectedImage
	var selectedForm
	var selectedTextField
	var selectedTextArea
	var selectedHidden
	var selectedbutton
	var selectedCheckbox
	var selectedRadio
	var tableDefault
	tableDefault = 0

	var editDefault
	editDefault = 0
	var fileCache
	fileCache = 0
	var statusMode = ""
	var statusBorders = ""
	var toggle = "off"
	var borderShown = "no"
	var fooURL 
	var reloaded
	reloaded = 0

	// if mode == 1 then process <HTML><HEAD> tags etc, otherwise only code INSIDE body tag
	var headMode = "<?php echo $mode?>"

	var htmlCode = "<?php echo $HTMLCode?>"

	window.onload = doLoad
	window.onerror = stopError
	var loaded = false

	function getWDE(loc) {
		if (Mode == "2") { 
			SwitchMode()
		}
		
		if (borderShown == "yes") {
			toggleBorders()
		}

		if (headMode == "1")
		{
			document.wdeForm.wdeOutput.value = foo.document.documentElement.outerHTML
		} else {
			document.wdeForm.wdeOutput.value = foo.document.body.innerHTML
		}
		wdeForm.action = loc
		wdeForm.submit()
	}

	function stopError() {
		return true;
	}

	var oPopup = window.createPopup();
	function showMenu(menu, width, height)
	{
    var lefter = event.clientX;
    var topper = event.clientY;
	var oPopBody = oPopup.document.body;
	oPopBody.style.backgroundColor = "white";
    oPopBody.style.border = "solid black 1px";

	if (menu == "formMenu")
	{
		if (isCursorInForm()) {
			modifyForm1.disabled = false
			modifyForm1.style.filter = ""
		} else {
			modifyForm1.disabled = true
			modifyForm1.style.filter = "Alpha(Opacity=20)"
		}
	}

	if (menu == "tableMenu")
	{
		if (isCursorInTableCell() || isTableSelected())
		{
			modifyTable.disabled = false
			modifyTable.style.filter = ""
		} else {
			modifyTable.disabled = true
			modifyTable.style.filter = "Alpha(Opacity=20)"
		}

		if (isCursorInTableCell())
		{
			modifyCell.disabled = false
			modifyCell.style.filter = ""
			rowAbove.disabled = false
			rowAbove.style.filter = ""
			rowBelow.disabled = false
			rowBelow.style.filter = ""
			deleteRow.disabled = false
			deleteRow.style.filter = ""
			colAfter.disabled = false
			colAfter.style.filter = ""
			colBefore.disabled = false
			colBefore.style.filter = ""
			deleteCol.disabled = false
			deleteCol.style.filter = ""
			increaseSpan.disabled = false
			increaseSpan.style.filter = ""
			decreaseSpan.disabled = false
			decreaseSpan.style.filter = ""
		} else {
			modifyCell.disabled = true
			modifyCell.style.filter = "Alpha(Opacity=20)"
			rowAbove.disabled = true
			rowAbove.style.filter = "Alpha(Opacity=20)"
			rowBelow.disabled = true
			rowBelow.style.filter = "Alpha(Opacity=20)"
			deleteRow.disabled = true
			deleteRow.style.filter = "Alpha(Opacity=20)"
			colAfter.disabled = true
			colAfter.style.filter = "Alpha(Opacity=20)"
			colBefore.disabled = true
			colBefore.style.filter = "Alpha(Opacity=20)"
			deleteCol.disabled = true
			deleteCol.style.filter = "Alpha(Opacity=20)"
			increaseSpan.disabled = true
			increaseSpan.style.filter = "Alpha(Opacity=20)"
			decreaseSpan.disabled = true
			decreaseSpan.style.filter = "Alpha(Opacity=20)"
		}
	}

	var HTMLContent = eval(menu).innerHTML
    oPopBody.innerHTML = HTMLContent
    oPopup.show(lefter, topper, width, height, document.body);

	return false;
	}

	function doLoad() {
		foo.document.designMode = 'On';
		foo.document.write(htmlCode);
		foo.document.close()
		showStatus()
		toggleBorders()
		displayUserStyles()
	}

	function fooLoad() {
		
	}

	function doCommand(cmd) {
		if (isAllowed())
		{
			document.execCommand(cmd)
		}
	}

	function showStatus() {
		if (Mode == "2") {
			statusMode = "&nbsp;Mode: CODE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
		} else {
			statusMode = "&nbsp;Mode: WYSIWYG"
		}

		if (borderShown == "yes") {
			statusBorders = "Guidelines: ON  "
		} else {
			statusBorders = "Guidelines: OFF"
		}

		_status.innerHTML = statusMode + "&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;" +  statusBorders
	}

	function cleanCode(clean) {
	var code;                    

	if (clean || confirm("Are you sure you want to clean HTML code?")){
		
		if (borderShown == "yes") {
			toggleBorders()
		}

		code = foo.document.body.innerHTML;
		code = code.replace(/<p([^>])*>(&nbsp;)*\s*<\/p>/gi,"")
		code = code.replace(/<span([^>])*>(&nbsp;)*\s*<\/span>/gi,"")
		code = code.replace(/<([\w]+) class=([^ |>]*)([^>]*)/gi, "<$1$3")
		code = code.replace(/<([\w]+) style="([^"]*)"([^>]*)/gi, "<$1$3")   
		code = code.replace(/<\\?\??xml[^>]>/gi, "")
		code = code.replace(/<\/?\w+:[^>]*>/gi, "")

	if (clean) {
        return code;
      }
      else {  
		foo.document.body.innerHTML = code;
		foo.focus();
      }
	}
}

	function isAllowed() {
		foo.focus()
		return true
	}
			

	function applyStyle(styleValue) {
		if (isAllowed())
		{

		var done
		var selectedArea = foo.document.selection.createRange()
		if (styleValue != "") {
			styleValue = styleValue.substring(1, styleValue.length)
		}

		if (foo.document.selection.type == "Control") {
			applyStyleTo = selectedArea.commonParentElement()
		}  else {
			if (foo.document.selection.createRange().htmlText == "") {
				applyStyleTo = selectedArea.parentElement()
			} else {
				if ((selectedArea.parentElement().tagName.toUpperCase() == "SPAN") || (selectedArea.parentElement().tagName.toUpperCase() == "A")) {
					applyStyleTo = selectedArea.parentElement()
					if ((styleValue == "") && (selectedArea.parentElement().tagName.toUpperCase() == "SPAN")) {
						applyStyleTo.removeNode(false);
						done = true
					}
				} else {
					if (styleValue != "") {
						selectedArea.pasteHTML("<span class=" + styleValue + ">" + selectedArea.htmlText + "</span>")
					}
					done = true
				}
			}
		}
		if (done != true) {
			applyStyleTo.className = styleValue
		}

		}
	}

	function displayUserStyles() {
		var theStyle = new Array();
		var theStyleText = new Array();
		var styleExists
		noOfSheets = top.foo.document.styleSheets.length
		if (noOfSheets > 0) {
			for (i=1;i<=noOfSheets;i++) {
				noOfStyles = top.foo.document.styleSheets(noOfSheets-1).rules.length
					for (x=0;x<noOfStyles;x++){
						styleValue = top.foo.document.styleSheets(noOfSheets-1).rules(x).selectorText

						// stylesheet rule contains a . (ignore any styles that dont contain a . they are NOT user styles)
						if (styleValue.indexOf(".") >= 0) {

							// stylesheet rule doesnt contain :
							if (styleValue.indexOf(":") < 0) {

								// style contains a . at beginning
								if (styleValue.indexOf(".") == 0) {
									styleText = styleValue.substring(1,styleValue.length)
									theStyle[theStyle.length] = styleValue
									theStyleText[theStyleText.length] = styleText

								} else {
									// style contains a . not at beginning
									if (styleValue.indexOf(".") > 0) {
										styleText = styleValue.substring(styleValue.indexOf(".")+1,styleValue.length)
										styleValue = styleValue.substring(styleValue.indexOf("."),styleValue.length)

										theStyleText[theStyleText.length] = styleText									
										theStyle[theStyle.length] = styleValue
									}						
								}

							// contains BOTH a . and a :
							} else {
								styleValue = styleValue.substring(styleValue.indexOf("."),styleValue.indexOf(":"))
							
								for (i=0;i<theStyle.length;i++) {
									if (styleValue == theStyle[i]) {
										styleExists = true
									}
								}
							
								if (styleExists != true) {
									theStyle[theStyle.length] = styleValue

									styleText = styleValue.substring(styleValue.indexOf(".")+1,styleValue.length)
									theStyleText[theStyleText.length] = styleText
								}

								styleExists = false
							}

						}

					} // End for

					for (z=0; z <= theStyle.length-1; z++) {						
						newOption = document.createElement("option");
			  			newOption.value = theStyle[z];
						newOption.text = theStyleText[z];
						sStyles.add(newOption)
					} 

			} // End For
		} // End if
	} // End function

	function scrollUp() {
		top.foo.scrollBy(0,0);
	}

	function toggleBorders() {
		var allForms = foo.document.body.getElementsByTagName("FORM");
		var allInputs = foo.document.body.getElementsByTagName("INPUT");
		var allTables = foo.document.body.getElementsByTagName("TABLE");
		var allLinks = foo.document.body.getElementsByTagName("A");

		if (borderShown == "no") {
			toggle = "off" 
		} else { 
			toggle = "on" 
		}

		// Do forms
		for (a=0; a < allForms.length; a++) {
			if (toggle == "off") {
				allForms[a].style.border = "1px dotted #FF0000"
			} else {
				allForms[a].removeAttribute("style")
			}
		}

		// Do hidden fields
		for (b=0; b < allInputs.length; b++) {
			if (toggle == "off") {
				if (allInputs[b].type.toUpperCase() == "HIDDEN") {
					allInputs[b].style.border = "1px dashed #000000"
					allInputs[b].style.width = "15px"
					allInputs[b].style.height = "15px"
					allInputs[b].style.backgroundColor = "#FDADAD"
					allInputs[b].style.color = "#FDADAD"
				}
			} else {
				if (allInputs[b].type.toUpperCase() == "HIDDEN")
					allInputs[b].removeAttribute("style")
			}
		}


		// Do tables
		for (i=0; i < allTables.length; i++) {
				if (toggle == "off") {
					allTables[i].style.border = "1px dotted #BFBFBF"
				} else {
					allTables[i].removeAttribute("style")
				}
				allRows = allTables[i].rows
				for (y=0; y < allRows.length; y++) {
				 	allCellsInRow = allRows[y].cells
						for (x=0; x < allCellsInRow.length; x++) {
							if (toggle == "off") {
								allCellsInRow[x].style.border = "1px dotted #BFBFBF"
							} else {
								allCellsInRow[x].removeAttribute("style")
							}
						}
				}
		}

		// Do anchors
		for (a=0; a < allLinks.length; a++) {
			if (toggle == "off") {
				if (allLinks[a].href.toUpperCase() == "") {
					allLinks[a].style.border = "1px dashed #000000"
					allLinks[a].style.width = "20px"
					allLinks[a].style.height = "16px"
					allLinks[a].style.backgroundColor = "#FFFFCC"
					allLinks[a].style.color = "#FFFFCC"	
				}
			} else {
				allLinks[a].removeAttribute("style")
				
			}
		}

		// Do Editable Content
		if (editDefault == 1)
		{
			allElem =  foo.document.getElementsByName("webedit")
			for (a=0; a < allElem.length; a++) {
				if (toggle == "off") {
					allElem[a].style.backgroundColor = "#FFF4FF"
				} else {
					allElem[a].removeAttribute("style")
				}
			}
		}
		

		if (toggle == "off") {
			borderShown = "yes"
		} else {
			borderShown = "no"
		}
		
//	foo.document.body.innerHTML = foo.document.body.innerHTML

		scrollUp()
		showStatus()
	}

	function doFormat(fType) {
		if ((fType != "SuperScript") && (fType != "SubScript")) {
			foo.document.execCommand('formatBlock',false,fType)
		} else {
			foo.document.execCommand(fType)
		}
	}

	function InsertRowAbove() {
		if (isCursorInTableCell()){
			var numCols = 0
			allCells = selectedTR.cells
			for (var i=0;i<allCells.length;i++) {
			 	numCols = numCols + allCells[i].getAttribute('colSpan')
			}

			var newTR = selectedTable.insertRow(selectedTR.rowIndex)
	
			for (i = 0; i < numCols; i++) {
			 	newTD = newTR.insertCell()
				newTD.innerHTML = "&nbsp;"
				if (borderShown == "yes")
				{
					newTD.style.border = "1px dotted #BFBFBF"
				}
			}
		}	
		
	} // End function

	function InsertRowBelow() {

		if (isCursorInTableCell()){
		
			var numCols = 0

			allCells = selectedTR.cells
			for (var i=0;i<allCells.length;i++) {
			 	numCols = numCols + allCells[i].getAttribute('colSpan')
			}

			var newTR = selectedTable.insertRow(selectedTR.rowIndex+1)

			for (i = 0; i < numCols; i++) {
			 	newTD = newTR.insertCell()
				newTD.innerHTML = "&nbsp;"
				if (borderShown == "yes")
				{
					newTD.style.border = "1px dotted #BFBFBF"
				}
			}
		}

	} // End function

	function IncreaseColspan() {
		if (isCursorInTableCell()) {

			var colSpanTD = selectedTD.getAttribute('colSpan')
			allCells = selectedTR.cells

			if (selectedTD.cellIndex + 1 != selectedTR.cells.length) {
				var addColspan = allCells[selectedTD.cellIndex+1].getAttribute('colSpan')
				selectedTD.colSpan = colSpanTD + addColspan
				selectedTR.deleteCell(selectedTD.cellIndex+1)
			}	
		}

	} // End function

	function DecreaseColspan() {

		if (isCursorInTableCell()) {
			if (selectedTD.colSpan != 1) {
				newTD = selectedTR.insertCell(selectedTD.cellIndex+1)
				selectedTD.colSpan = selectedTD.colSpan - 1	
				if (borderShown == "yes")
				{
					newTD.style.border = "1px dotted #BFBFBF"
				}
			}
		}

	} // End function

	function DeleteRow() {
		if (isCursorInTableCell()) {
			selectedTable.deleteRow(selectedTR.rowIndex)
		}
	}

	function DeleteCol() {
        	if (isCursorInTableCell()) {
			moveFromEnd = (selectedTR.cells.length-1) - (selectedTD.cellIndex)
			allRows = selectedTable.rows
			for (var i=0;i<allRows.length;i++) {
				endOfRow = allRows[i].cells.length - 1
				position = endOfRow - moveFromEnd
				if (position < 0) {
					position = 0
				} // End If
				

				allCellsInRow = allRows[i].cells
				
				if (allCellsInRow[position].colSpan > 1) {
					allCellsInRow[position].colSpan = allCellsInRow[position].colSpan - 1
				} else { 
					allRows[i].deleteCell(position)
				}

			} // End For	

        	} // End If

	} // End Function

	function InsertColAfter() {
        	if (isCursorInTableCell()) {
			moveFromEnd = (selectedTR.cells.length-1) - (selectedTD.cellIndex)
			allRows = selectedTable.rows
			for (i=0;i<allRows.length;i++) {
			rowCount = allRows[i].cells.length - 1
			position = rowCount - moveFromEnd
			if (position < 0) {
				position = 0
			}
				newCell = allRows[i].insertCell(position+1)
				newCell.innerHTML = "&nbsp;"
				if (borderShown == "yes")
				{
					newCell.style.border = "1px dotted #BFBFBF"
				}
			}	
        	}
	} // End Function


	function InsertColBefore() {
        	if (isCursorInTableCell()) {
			moveFromEnd = (selectedTR.cells.length-1) - (selectedTD.cellIndex)
			allRows = selectedTable.rows
			for (i=0;i<allRows.length;i++) {
				rowCount = allRows[i].cells.length - 1
				position = rowCount - moveFromEnd
				if (position < 0) {
					position = 0
				}
				newCell = allRows[i].insertCell(position)
				newCell.innerHTML = "&nbsp;"
				if (borderShown == "yes")
				{
					newCell.style.border = "1px dotted #BFBFBF"
				}
			}	
        	}
	}

	function isImageSelected() {
		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "IMG") {
				selectedImage = foo.document.selection.createRange()(0);
				return true;
			}	
		}
	}

	function isTableSelected() {
		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "TABLE") {
				selectedTable = foo.document.selection.createRange()(0);
				return true;
			}	
		}
	} // End Function

	function isCursorInTableCell() {
		if (document.selection.type != "Control") {
                          var elem = document.selection.createRange().parentElement()
                          while (elem.tagName.toUpperCase() != "TD" && elem.tagName.toUpperCase() != "TH")
                          {
                            elem = elem.parentElement
                            if (elem == null)
                              break
                          }
				if (elem) {
					selectedTD = elem
					selectedTR = selectedTD.parentElement
					selectedTBODY =  selectedTR.parentElement
					selectedTable = selectedTBODY.parentElement
					return true
				}
		}
	} // End function

	function isCursorInForm() {
		if (document.selection.type != "Control") {
                          var elem = document.selection.createRange().parentElement()
                          while (elem.tagName != "FORM")
                          {
                            elem = elem.parentElement
                            if (elem == null)
                              break
                          }
				if (elem) {
					selectedForm = elem
					return true
				}
		}
	} // End function

	var Mode = "1";
	var toggleWasOn
	var fontChange
	function SwitchMode () {

		 if (Mode == "1") {
			if (borderShown == "yes") {
				toggleBorders()
				toggleWasOn = "yes"
			} else {
				toggleWasOn = "no"
			}

			toolbar_full.className = "hide";
			toolbar_code.className = "bevel3";

			// get details to replace back when done
			fontFamily = foo.document.body.style.fontFamily
			fontSize = foo.document.body.style.fontSize
			text = foo.document.body.text
			bgColor = foo.document.body.bgcolor
			background = foo.document.body.background

			// Put HTML in editor
			if (headMode == "1")
			{
				code = foo.document.documentElement.outerHTML
			} else {
				code = foo.document.body.innerHTML
			}

			re = /&amp;/g
			re2 = /href="http:\/\/$URL/g
			re3 = /src="http:\/\/$URL/g

			replaceHref = 'href="'
			replaceImage = 'src="'

			code = code.replace(re,'&')
			code = code.replace(re2,replaceHref)
			code= code.replace(re3,replaceImage)

			foo.document.body.innerText = code

			// nice looking source editor
			foo.document.body.style.fontFamily = "Courier"
			foo.document.body.style.fontSize = "10pt"
			foo.document.body.bgColor = '#FFFFFF';
			foo.document.body.text = '#000000';
			foo.document.body.background = '';
			fontChange = true	
			
			Mode = "2";
		} else {

			loaded = false;
			foo.document.write(foo.document.body.innerText);
			foo.document.close()

			if (fontChange == true) {

				if (fontFamily != "") {
					foo.document.style.fontFamily = fontFamily
				} else {
					foo.document.body.style.removeAttribute("fontFamily")
				}
	
				if (fontSize != "") {
					foo.document.style.fontSize = fontSize
				} else {
					foo.document.body.style.fontSize = ""
				}

				if (bgColor != "")
				{
					foo.document.bgColor = bgColor
				} else {
					foo.document.body.removeAttribute("bgColor")
				}
				
				if (text != "")
				{
					foo.document.text = text
				} else {
					foo.document.body.removeAttribute("text")
				}
				
				if (background != "")
				{
					foo.document.body.background = background
				} else {
					foo.document.body.removeAttribute("background")
				}
			}

			toolbar_full.className = "bevel3";
			toolbar_code.className = "hide";

			Mode = "1";

			if (toggleWasOn == "yes") {
				toggleBorders()
				toggleWasOn = "no"
			}
		}
		showStatus()
	}

	function doLink() {
		if (isAllowed())
		{
			if (isSelection()) { 
				var leftPos = (screen.availWidth-700) / 2
				var topPos = (screen.availHeight-500) / 2 
		 		linkWin = window.open('wde/insert_link.html','','width=500,height=400,scrollbars=yes,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
			} else
				return
		}
	}

	function doImage() {
		if (isAllowed())
		{

		if (isImageSelected()) {	 
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-400) / 2 
			imageWin = window.open('wde/modify_image.html','','width=500,height=430,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		} else {
			var leftPos = (screen.availWidth-700) / 2
			var topPos = (screen.availHeight-500) / 2 
			//imageWin = window.open(window.location + '?wde=InsertImage','','width=700,height=500,scrollbars=yes,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
			imageWin = window.open('temp_add.php?wde=InsertImage','','width=700,height=500,scrollbars=yes,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function ShowInsertTable() {
		if (isAllowed())
		{
		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-400) / 2 
 		inserttableWin = window.open('wde/insert_table.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}
	}

	function ShowPreview(source) {

		baseRef = foo.location.href
		ax=baseRef.lastIndexOf('\/')+1;
		if(ax!=-1) baseRef=baseRef.substring(0,ax);

		if (borderShown == "yes") {
			toggleBorders()
			toggleWasOn = "yes"
		} else {
			toggleWasOn = "no"
		}

		if (editDefault ==1)
		{
			revertEditable()
		}

		var previewHTML
		if (source == 1)
		{
			previewHTML = foo.document.body.innerText
		} else {
			previewHTML = foo.document.documentElement.outerHTML
		}

		if (editDefault ==1)
		{
			makeEditable()
		}
		
		if (toggleWasOn == "yes") {
			toggleBorders()
			toggleWasOn = "no"
		}

		var leftPos = (screen.availWidth-780) / 2
		var topPos = (screen.availHeight-580) / 2 
 		previewWin = window.open('','','width=780,height=580,scrollbars=yes,resizable=yes,titlebar=0,top=' + topPos + ',left=' + leftPos);

		previewWin.document.write("<Base href=" + baseRef + ">")
		previewWin.document.write(previewHTML)
		previewWin.document.close()
		
	}

	function ModifyTable() {
		if (isAllowed())
		{

		if (isTableSelected() || isCursorInTableCell()) {
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-400) / 2 
	 		modifytableWin = window.open('wde/modify_table.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function ModifyCell() {
		if (isAllowed())
		{

		if (isCursorInTableCell()) {
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-400) / 2 
	 		modifytableWin = window.open('wde/modify_cell.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function modifyForm() {
		if (isAllowed)
		{

		if (isCursorInForm()) {
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-400) / 2 
	 		modifyFormWin = window.open('wde/modify_form.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function insertForm() {
		if (isAllowed())
		{
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-400) / 2 
	 		insertFormWin = window.open('wde/insert_form.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}
	}

	function InsertChars() {
		if (isAllowed())
		{
			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-400) / 2 
	 		charWin = window.open('wde/insert_chars.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}
	}

	function doAnchor() {
			if (isAllowed())
			{

			var leftPos = (screen.availWidth-500) / 2
			var topPos = (screen.availHeight-400) / 2 
		
			if ((foo.document.selection.type == "Control") && (foo.document.selection.createRange()(0).tagName == "A") && (foo.document.selection.createRange()(0).href == ""))
			{
				anchorWin = window.open('wde/modify_anchor.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
			} else {
	 			anchorWin = window.open('wde/insert_anchor.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
			}

			}
	}

	function isSelection() {
			if (foo.document.selection.type == "Text") {
				return true;
			} else {
				if ((foo.document.selection.type == "Control") && (foo.document.selection.createRange()(0).tagName.toUpperCase() == "IMG")) {
					return true
				} else {
					return false
				}
			}
	}

	function doEmail() {
		if (isAllowed())
		{
			if (isSelection()) { 
				var leftPos = (screen.availWidth-500) / 2
				var topPos = (screen.availHeight-400) / 2 
	 			emailWin = window.open('wde/insert_email.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
			} else
				return
		}
	}

	function doTextField() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-400) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if ((oControlRange(0).type.toUpperCase() == "TEXT") || (oControlRange(0).type.toUpperCase() == "PASSWORD")) {
					selectedTextField = foo.document.selection.createRange()(0);
					textFieldWin = window.open('wde/modify_textfield.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			textFieldWin = window.open('wde/insert_textfield.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doHidden() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-400) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if (oControlRange(0).type.toUpperCase() == "HIDDEN") {
					selectedHidden = foo.document.selection.createRange()(0);
					hiddenWin = window.open('wde/modify_hidden.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			hiddenWin = window.open('wde/insert_hidden.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doTextArea() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-400) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "TEXTAREA") {
					selectedTextArea = foo.document.selection.createRange()(0);
					textFieldWin = window.open('wde/modify_textarea.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				return true;
			}	
		} else {
			textFieldWin = window.open('wde/insert_textarea.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doButton() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-400) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if ((oControlRange(0).type.toUpperCase() == "RESET") || (oControlRange(0).type.toUpperCase() == "SUBMIT") || (oControlRange(0).type.toUpperCase() == "BUTTON")) {
					selectedButton = foo.document.selection.createRange()(0);
					buttonWin = window.open('wde/modify_button.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			buttonWin = window.open('wde/insert_button.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doCheckbox() {
		if (isAllowed())
		{

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-400) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if (oControlRange(0).type.toUpperCase() == "CHECKBOX") {
					selectedCheckbox = foo.document.selection.createRange()(0);
					checkboxWin = window.open('wde/modify_checkbox.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			checkboxWin = window.open('wde/insert_checkbox.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function doRadio() {
		if (isAllowed()) {

		var leftPos = (screen.availWidth-500) / 2
		var topPos = (screen.availHeight-400) / 2 

		if (foo.document.selection.type == "Control") {
			var oControlRange = foo.document.selection.createRange();
			if (oControlRange(0).tagName.toUpperCase() == "INPUT") {
				if (oControlRange(0).type.toUpperCase() == "RADIO") {
					selectedRadio = foo.document.selection.createRange()(0);
					radioWin = window.open('wde/modify_radio.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
				}
				return true;
			}	
		} else {
			radioWin = window.open('wde/insert_radio.html','','width=500,height=400,scrollbars=no,resizable=no,titlebar=0,top=' + topPos + ',left=' + leftPos);
		}

		}
	}

	function button_over(eButton){
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "buttonhighlight solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "buttonhighlight solid 1px";
	}
				
	function button_out(eButton){
		eButton.style.borderColor = "threedface";
	}

	function button_down(eButton){
		eButton.style.borderBottom = "buttonhighlight solid 1px";
		eButton.style.borderLeft = "buttonshadow solid 1px";
		eButton.style.borderRight = "buttonhighlight solid 1px";
		eButton.style.borderTop = "buttonshadow solid 1px";
	}

	function button_up(eButton){
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "buttonhighlight solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "buttonhighlight solid 1px";
		eButton = null; 
	}

	function closePopups() {
		if (imageWin) imageWin.close()
		if (propWin) propWin.close()
		if (inserttableWin) inserttableWin.close()
		if (previewWin) previewWin.close()
		if (modifytableWin) modifytableWin.close()
		if (insertFormWin) insertFormWin.close()
		if (textFieldWin) textFieldWin.close()
		if (hiddenWin) hiddenWin.close()
		if (buttonWin) buttonWin.close()
		if (checkboxWin) checkboxWin.close()
		if (radioWin) radioWin.close()
		if (charWin) charWin.close()
		if (linkWin) linkWin.close()
		if (emailWin) emailWin.close()
		if (anchorWin) anchorWin.close()
	}