// JavaScript Document
//rootWeb = "http://192.168.11.15/BP_web/";
SYSTEM_DB_TEXT = new Array('SELECT','INSERT','UPDATE','DELETE','USER','USERNAME','PASSWORD','FOR','WHERE','WHILE','LEVEL','PERMISSION','CHAR','VARCHAR','VARCHAR2','NCHAR','NVARCHAR','NVARCHAR2','DATE','FORMAT','DROP','DATABASE','TABLE','FIELD','IF','AND','OR','SERVER','INTERVAL','DAY','MONTH','YEAR','TIME','GROUP','GRANT');
defaultColor = '#CCFFCC';
function chkBrowser() {
	if(navigator.appName!="Microsoft Internet Explorer") {
			//window.location=rootWeb+"IEonly.htm";			
			document.print("This web site only supports IE browser");
	}
}

function load_divForm(url,divId,popup){ 

	if(popup) {
	   var objDiv = opener.document.getElementById(divId);
	} else {
	   var objDiv = document.getElementById(divId);
	}

	AjaxRequest.get(
			{
				'url':url
				,'onLoading':function() { }
				,'onLoaded':function() {  }
				,'onInteractive':function() {  }
				,'onComplete':function() {  }
				,'onSuccess':function(req) { objDiv.innerHTML = req.responseText;  }
			}
		);
}

function NumberOnly()
{
		//alert(event.keyCode);
		if( (event.keyCode < 48 || event.keyCode > 57) && event.keyCode != 13) {
			alert('กรุณากรอกเฉพาะตัวเลข');
			return false;						
		}
}
function NumericOnly(obj)
{		var arr_chk = '';
		//alert(event.keyCode);
		if(obj) { 
			arr_chk = obj.value.split('.'); 
			//alert(arr_chk.length);			
		}	

		if( (event.keyCode < 48 || event.keyCode > 57) && event.keyCode != 46 && event.keyCode != 13 ) {
			alert('กรุณากรอกเฉพาะตัวเลขหรือจุดทศนิยม');
			return false;						
		}
		if( arr_chk.length >= 2 && event.keyCode == 46 ) 
			return false;		
}
function NoDbCode(sqoute) {
		if(event.keyCode==34) {  // 34 is '"'
			return false;
		}
		if(sqoute && event.keyCode==39 ){
			return false;
		}
}
function NoSingQuote(){
		if(event.keyCode==39) {  // 39 is '
			return false;
		}
}
function noSubtract() {
		if(event.keyCode==45) {  // 45 is '-'
			return false;
		}		
		if(event.keyCode==34) {  // 34 is '"'
			return false;
		}
}
function checkMin(obj,obj2,obj3)
{		// RoundUp of time for entering a minute input ( obj -> Minute textbox , obj2 -> Hour textbox, obj3 -> Day textbox )
		if(obj.value > 59)
		{
				//alert("??????? 59 ??????????\n");						
				if(obj2.value=="") obj2.value=0;
				obj2.value = parseInt(obj2.value)+parseInt(1);
				obj.value = obj.value%60;						
		}
		if(obj2.value > 23)
		{
										
				if(obj3.value=="") obj3.value=0;
				obj3.value = parseInt(obj3.value)+parseInt(1);
				obj2.value = obj2.value%24;						
		}
}
function checkHr(obj,obj2)
{		// RoundUp of time for entering a hour input ( obj -> Hour textbox , obj2 -> Day textbox)
		if(obj.value > 23)
		{
				if(obj2.value=="") obj2.value=0;
				obj2.value = parseInt(obj2.value)+parseInt(1);
				obj.value = obj.value%24;						
		}
}
function list_selected(obj, SLvalue) {  // set default of combo list ( from POSTING )
	for(i=0;i<obj.length;i++) {
			if(obj.options[i].value == SLvalue) { 
				obj.options[i].selected = true;
				i=obj.length;
			}
	}	
}
function box_checked(obj, CHKvalue) {	// set default of check box ( from POSTING )
	if(CHKvalue!="" && obj.value==CHKvalue ) obj.checked = true;
}
function radio_checked(obj, CHKvalue, num) {	// set default of radio ( from POSTING )
	for(i=0;i<num;i++) {
			if(obj[i].value==CHKvalue) obj[i].checked = true;
	}
	//if(CHKvalue!="") obj.checked = true;
}
function comeback(obj,val) {
		obj.value = val;	
}
function BigChar(obj) {
	//alert(window.event.keyCode);
	if( event.keyCode >= 45 && event.keyCode <= 126 )
	{ obj.value = obj.value.toUpperCase(); }
}
function JobOnly() {
		if( (event.keyCode < 47 || event.keyCode > 57) && ( event.keyCode < 80 || event.keyCode > 82 )  ) 
		return false;
}
function RQonly() {
		if( (event.keyCode < 47 || event.keyCode > 57) && ( event.keyCode < 80 || event.keyCode > 82 )  && event.keyCode != 45 ) 
		return false;
}
/* $Id: functions.js,v 2.2 2004/01/05 16:10:15 garvinhicking Exp $ */


/**
 * Displays an confirmation box beforme to submit a "DROP/DELETE/ALTER" query.
 * This function is called while clicking links
 *
 * @param   object   the link
 * @param   object   the sql query to submit
 *
 * @return  boolean  whether to run the query or not
 */
function confirmLink(theLink, theSqlQuery)
{
    // Confirmation is not required in the configuration file
    // or browser is Opera (crappy js implementation)
    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
        return true;
    }

    var is_confirmed = confirm(confirmMsg + ' :\n' + theSqlQuery);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

    return is_confirmed;
} // end of the 'confirmLink()' function


/**
 * Displays an error message if a "DROP DATABASE" statement is submitted
 * while it isn't allowed, else confirms a "DROP/DELETE/ALTER" query before
 * sumitting it if required.
 * This function is called by the 'checkSqlQuery()' js function.
 *
 * @param   object   the form
 * @param   object   the sql query textarea
 *
 * @return  boolean  whether to run the query or not
 *
 * @see     checkSqlQuery()
 */
function confirmQuery(theForm1, sqlQuery1)
{
    // Confirmation is not required in the configuration file
    if (confirmMsg == '') {
        return true;
    }

    // The replace function (js1.2) isn't supported
    else if (typeof(sqlQuery1.value.replace) == 'undefined') {
        return true;
    }

    // js1.2+ -> validation with regular expressions
    else {
        // "DROP DATABASE" statement isn't allowed
        if (noDropDbMsg != '') {
            var drop_re = new RegExp('DROP\\s+(IF EXISTS\\s+)?DATABASE\\s', 'i');
            if (drop_re.test(sqlQuery1.value)) {
                alert(noDropDbMsg);
                theForm1.reset();
                sqlQuery1.focus();
                return false;
            } // end if
        } // end if

        // Confirms a "DROP/DELETE/ALTER" statement
        //
        // TODO: find a way (if possible) to use the parser-analyser
        // for this kind of verification
        // For now, I just added a ^ to check for the statement at
        // beginning of expression

        //var do_confirm_re_0 = new RegExp('DROP\\s+(IF EXISTS\\s+)?(TABLE|DATABASE)\\s', 'i');
        //var do_confirm_re_1 = new RegExp('ALTER\\s+TABLE\\s+((`[^`]+`)|([A-Za-z0-9_$]+))\\s+DROP\\s', 'i');
        //var do_confirm_re_2 = new RegExp('DELETE\\s+FROM\\s', 'i');
        var do_confirm_re_0 = new RegExp('^DROP\\s+(IF EXISTS\\s+)?(TABLE|DATABASE)\\s', 'i');
        var do_confirm_re_1 = new RegExp('^ALTER\\s+TABLE\\s+((`[^`]+`)|([A-Za-z0-9_$]+))\\s+DROP\\s', 'i');
        var do_confirm_re_2 = new RegExp('^DELETE\\s+FROM\\s', 'i');
        if (do_confirm_re_0.test(sqlQuery1.value)
            || do_confirm_re_1.test(sqlQuery1.value)
            || do_confirm_re_2.test(sqlQuery1.value)) {
            var message      = (sqlQuery1.value.length > 100)
                             ? sqlQuery1.value.substr(0, 100) + '\n    ...'
                             : sqlQuery1.value;
            var is_confirmed = confirm(confirmMsg + ' :\n' + message);
            // drop/delete/alter statement is confirmed -> update the
            // "is_js_confirmed" form field so the confirm test won't be
            // run on the server side and allows to submit the form
            if (is_confirmed) {
                theForm1.elements['is_js_confirmed'].value = 1;
                return true;
            }
            // "DROP/DELETE/ALTER" statement is rejected -> do not submit
            // the form
            else {
                window.focus();
                sqlQuery1.focus();
                return false;
            } // end if (handle confirm box result)
        } // end if (display confirm box)
    } // end confirmation stuff

    return true;
} // end of the 'confirmQuery()' function


/**
 * Displays an error message if the user submitted the sql query form with no
 * sql query, else checks for "DROP/DELETE/ALTER" statements
 *
 * @param   object   the form
 *
 * @return  boolean  always false
 *
 * @see     confirmQuery()
 */
function checkSqlQuery(theForm)
{
    var sqlQuery = theForm.elements['sql_query'];
    var isEmpty  = 1;

    // The replace function (js1.2) isn't supported -> basic tests
    if (typeof(sqlQuery.value.replace) == 'undefined') {
        isEmpty      = (sqlQuery.value == '') ? 1 : 0;
        if (isEmpty && typeof(theForm.elements['sql_file']) != 'undefined') {
            isEmpty  = (theForm.elements['sql_file'].value == '') ? 1 : 0;
        }
        if (isEmpty && typeof(theForm.elements['sql_localfile']) != 'undefined') {
            isEmpty  = (theForm.elements['sql_localfile'].value == '') ? 1 : 0;
        }
        if (isEmpty && typeof(theForm.elements['id_bookmark']) != 'undefined') {
            isEmpty  = (theForm.elements['id_bookmark'].value == null || theForm.elements['id_bookmark'].value == '');
        }
    }
    // js1.2+ -> validation with regular expressions
    else {
        var space_re = new RegExp('\\s+');
        if (typeof(theForm.elements['sql_file']) != 'undefined' &&
                theForm.elements['sql_file'].value.replace(space_re, '') != '') {
            return true;
        }
        if (typeof(theForm.elements['sql_localfile']) != 'undefined' &&
                theForm.elements['sql_localfile'].value.replace(space_re, '') != '') {
            return true;
        }
        if (isEmpty && typeof(theForm.elements['id_bookmark']) != 'undefined' &&
                (theForm.elements['id_bookmark'].value != null || theForm.elements['id_bookmark'].value != '') &&
                theForm.elements['id_bookmark'].selectedIndex != 0
                ) {
            return true;
        }
        // Checks for "DROP/DELETE/ALTER" statements
        if (sqlQuery.value.replace(space_re, '') != '') {
            if (confirmQuery(theForm, sqlQuery)) {
                return true;
            } else {
                return false;
            }
        }
        theForm.reset();
        isEmpty = 1;
    }

    if (isEmpty) {
        sqlQuery.select();
        alert(errorMsg0);
        sqlQuery.focus();
        return false;
    }

    return true;
} // end of the 'checkSqlQuery()' function


/**
 * Displays an error message if an element of a form hasn't been completed and
 * should be
 *
 * @param   object   the form
 * @param   string   the name of the form field to put the focus on
 *
 * @return  boolean  whether the form field is empty or not
 */
function emptyFormElements(theForm, theFieldName)
{
    var isEmpty  = 1;
    var theField = theForm.elements[theFieldName];
    // Whether the replace function (js1.2) is supported or not
    var isRegExp = (typeof(theField.value.replace) != 'undefined');

    if (!isRegExp) {
        isEmpty      = (theField.value == '') ? 1 : 0;
    } else {
        var space_re = new RegExp('\\s+');
        isEmpty      = (theField.value.replace(space_re, '') == '') ? 1 : 0;
    }
    if (isEmpty) {
        theForm.reset();
        theField.select();
        alert(errorMsg0);
        theField.focus();
        return false;
    }

    return true;
} // end of the 'emptyFormElements()' function


/**
 * Ensures a value submitted in a form is numeric and is in a range
 *
 * @param   object   the form
 * @param   string   the name of the form field to check
 * @param   integer  the minimum authorized value
 * @param   integer  the maximum authorized value
 *
 * @return  boolean  whether a valid number has been submitted or not
 */
function checkFormElementInRange(theForm, theFieldName, min, max)
{
    var theField         = theForm.elements[theFieldName];
    var val              = parseInt(theField.value);

    if (typeof(min) == 'undefined') {
        min = 0;
    }
    if (typeof(max) == 'undefined') {
        max = Number.MAX_VALUE;
    }

    // It's not a number
    if (isNaN(val)) {
        theField.select();
        alert(errorMsg1);
        theField.focus();
        return false;
    }
    // It's a number but it is not between min and max
    else if (val < min || val > max) {
        theField.select();
        alert(val + errorMsg2);
        theField.focus();
        return false;
    }
    // It's a valid number
    else {
        theField.value = val;
    }

    return true;
} // end of the 'checkFormElementInRange()' function

function checkTableEditForm(theForm, fieldsCnt)
{
    for (i=0; i<fieldsCnt; i++)
    {
        var id = "field_" + i + "_2";
        var elm = getElement(id);
        if (elm.value == 'VARCHAR' || elm.value == 'CHAR') {
            elm2 = getElement("field_" + i + "_3");
            val = parseInt(elm2.value);
            elm3 = getElement("field_" + i + "_1");
            if (isNaN(val) && elm3.value != "") {
                elm2.select();
                alert(errorMsg1);
                elm2.focus();
                return false;
            }
        }
    }
    return true;
} // enf of the 'checkTableEditForm()' function


/**
 * Ensures the choice between 'transmit', 'zipped', 'gzipped' and 'bzipped'
 * checkboxes is consistant
 *
 * @param   object   the form
 * @param   string   a code for the action that causes this function to be run
 *
 * @return  boolean  always true
 */
function checkTransmitDump(theForm, theAction)
{
    var formElts = theForm.elements;

    // 'zipped' option has been checked
    if (theAction == 'zip' && formElts['zip'].checked) {
        if (!formElts['asfile'].checked) {
            theForm.elements['asfile'].checked = true;
        }
        if (typeof(formElts['gzip']) != 'undefined' && formElts['gzip'].checked) {
            theForm.elements['gzip'].checked = false;
        }
        if (typeof(formElts['bzip']) != 'undefined' && formElts['bzip'].checked) {
            theForm.elements['bzip'].checked = false;
        }
    }
    // 'gzipped' option has been checked
    else if (theAction == 'gzip' && formElts['gzip'].checked) {
        if (!formElts['asfile'].checked) {
            theForm.elements['asfile'].checked = true;
        }
        if (typeof(formElts['zip']) != 'undefined' && formElts['zip'].checked) {
            theForm.elements['zip'].checked = false;
        }
        if (typeof(formElts['bzip']) != 'undefined' && formElts['bzip'].checked) {
            theForm.elements['bzip'].checked = false;
        }
    }
    // 'bzipped' option has been checked
    else if (theAction == 'bzip' && formElts['bzip'].checked) {
        if (!formElts['asfile'].checked) {
            theForm.elements['asfile'].checked = true;
        }
        if (typeof(formElts['zip']) != 'undefined' && formElts['zip'].checked) {
            theForm.elements['zip'].checked = false;
        }
        if (typeof(formElts['gzip']) != 'undefined' && formElts['gzip'].checked) {
            theForm.elements['gzip'].checked = false;
        }
    }
    // 'transmit' option has been unchecked
    else if (theAction == 'transmit' && !formElts['asfile'].checked) {
        if (typeof(formElts['zip']) != 'undefined' && formElts['zip'].checked) {
            theForm.elements['zip'].checked = false;
        }
        if ((typeof(formElts['gzip']) != 'undefined' && formElts['gzip'].checked)) {
            theForm.elements['gzip'].checked = false;
        }
        if ((typeof(formElts['bzip']) != 'undefined' && formElts['bzip'].checked)) {
            theForm.elements['bzip'].checked = false;
        }
    }

    return true;
} // end of the 'checkTransmitDump()' function


/**
 * This array is used to remember mark status of rows in browse mode
 */
var marked_row = new Array;


/**
 * Sets/unsets the pointer and marker in browse mode
 *
 * @param   object    the table row
 * @param   interger  the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background color
 * @param   string    the color to use for mouseover
 * @param   string    the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 */
function setPointer(theRow, theRowNum, theAction, theDefaultColor, thePointerColor, theMarkColor)
{
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;
    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        currentColor = theCells[0].style.backgroundColor;
        domDetect    = false;
    } // end 3

    // 3.3 ... Opera changes colors set via HTML to rgb(r,g,b) format so fix it
    if (currentColor.indexOf("rgb") >= 0) 
    {
        var rgbStr = currentColor.slice(currentColor.indexOf('(') + 1,
                                     currentColor.indexOf(')'));
        var rgbValues = rgbStr.split(",");
        currentColor = "#";
        var hexChars = "0123456789ABCDEF";
        for (var i = 0; i < 3; i++)
        {
            var v = rgbValues[i].valueOf();
            currentColor += hexChars.charAt(v/16) + hexChars.charAt(v%16);
        }
    }

    // 4. Defines the new color
    // 4.1 Current color is the default one
    if (currentColor == ''
        || currentColor.toLowerCase() == theDefaultColor.toLowerCase()) {
        if (theAction == 'over' && thePointerColor != '') {
            newColor              = thePointerColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
            // Garvin: deactivated onclick marking of the checkbox because it's also executed
            // when an action (like edit/delete) on a single item is performed. Then the checkbox
            // would get deactived, even though we need it activated. Maybe there is a way
            // to detect if the row was clicked, and not an item therein...
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
        }
    }
    // 4.1.2 Current color is the pointer one
    else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
             && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
        if (theAction == 'out') {
            newColor              = theDefaultColor;
        }
        else if (theAction == 'click' && theMarkColor != '') {
            newColor              = theMarkColor;
            marked_row[theRowNum] = true;
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = true;
        }
    }
    // 4.1.3 Current color is the marker one
    else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
        if (theAction == 'click') {
            newColor              = (thePointerColor != '')
                                  ? thePointerColor
                                  : theDefaultColor;
            marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                  ? true
                                  : null;
            // document.getElementById('id_rows_to_delete' + theRowNum).checked = false;
        }
    } // end 4

    // 5. Sets the new color...
    if (newColor) {
        var c = null;
        // 5.1 ... with DOM compatible browsers except Opera
        if (domDetect) {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            } // end for
        }
        // 5.2 ... with other browsers
        else {
            for (c = 0; c < rowCellsCnt; c++) {
                theCells[c].style.backgroundColor = newColor;
            }
        }
    } // end 5

    return true;
} // end of the 'setPointer()' function

/*
 * Sets/unsets the pointer and marker in vertical browse mode
 *
 * @param   object    the table row
 * @param   interger  the row number
 * @param   string    the action calling this script (over, out or click)
 * @param   string    the default background color
 * @param   string    the color to use for mouseover
 * @param   string    the color to use for marking a row
 *
 * @return  boolean  whether pointer is set or not
 *
 * @author Garvin Hicking <me@supergarv.de> (rewrite of setPointer.)
 */
function setVerticalPointer(theRow, theRowNum, theAction, theDefaultColor1, theDefaultColor2, thePointerColor, theMarkColor) {
    var theCells = null;

    // 1. Pointer and mark feature are disabled or the browser can't get the
    //    row -> exits
    if ((thePointerColor == '' && theMarkColor == '')
        || typeof(theRow.style) == 'undefined') {
        return false;
    }

    // 2. Gets the current row and exits if the browser can't get it
    if (typeof(document.getElementsByTagName) != 'undefined') {
        theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        theCells = theRow.cells;
    }
    else {
        return false;
    }

    // 3. Gets the current color...
    var rowCellsCnt  = theCells.length;
    var domDetect    = null;
    var currentColor = null;
    var newColor     = null;

    // 3.1 ... with DOM compatible browsers except Opera that does not return
    //         valid values with "getAttribute"
    if (typeof(window.opera) == 'undefined'
        && typeof(theCells[0].getAttribute) != 'undefined') {
        currentColor = theCells[0].getAttribute('bgcolor');
        domDetect    = true;
    }
    // 3.2 ... with other browsers
    else {
        domDetect    = false;
    } // end 3

    var c = null;
    // 5.1 ... with DOM compatible browsers except Opera
    for (c = 0; c < rowCellsCnt; c++) {
        if (domDetect) {
            currentColor = theCells[c].getAttribute('bgcolor');
        } else {
            currentColor = theCells[c].style.backgroundColor;
        }

        // 4. Defines the new color
        // 4.1 Current color is the default one
        if (currentColor == ''
            || currentColor.toLowerCase() == theDefaultColor1.toLowerCase()
            || currentColor.toLowerCase() == theDefaultColor2.toLowerCase()) {
            if (theAction == 'over' && thePointerColor != '') {
                newColor              = thePointerColor;
            } else if (theAction == 'click' && theMarkColor != '') {
                newColor              = theMarkColor;
                marked_row[theRowNum] = true;
            }
        }
        // 4.1.2 Current color is the pointer one
        else if (currentColor.toLowerCase() == thePointerColor.toLowerCase()
                 && (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])) {
            if (theAction == 'out') {
                if (c % 2) {
                    newColor              = theDefaultColor1;
                } else {
                    newColor              = theDefaultColor2;
                }
            }
            else if (theAction == 'click' && theMarkColor != '') {
                newColor              = theMarkColor;
                marked_row[theRowNum] = true;
            }
        }
        // 4.1.3 Current color is the marker one
        else if (currentColor.toLowerCase() == theMarkColor.toLowerCase()) {
            if (theAction == 'click') {
                newColor              = (thePointerColor != '')
                                      ? thePointerColor
                                      : ((c % 2) ? theDefaultColor1 : theDefaultColor2);
                marked_row[theRowNum] = (typeof(marked_row[theRowNum]) == 'undefined' || !marked_row[theRowNum])
                                      ? true
                                      : null;
            }
        } // end 4

        // 5. Sets the new color...
        if (newColor) {
            if (domDetect) {
                theCells[c].setAttribute('bgcolor', newColor, 0);
            }
            // 5.2 ... with other browsers
            else {
                theCells[c].style.backgroundColor = newColor;
            }
        } // end 5
    } // end for

     return true;
 } // end of the 'setVerticalPointer()' function

/**
 * Checks/unchecks all tables
 *
 * @param   string   the form name
 * @param   boolean  whether to check or to uncheck the element
 *
 * @return  boolean  always true
 */
function setCheckboxes(the_form, do_check)
{
    var elts      = (typeof(document.forms[the_form].elements['selected_db[]']) != 'undefined')
                  ? document.forms[the_form].elements['selected_db[]']
                  : (typeof(document.forms[the_form].elements['selected_tbl[]']) != 'undefined')
          ? document.forms[the_form].elements['selected_tbl[]']
          : document.forms[the_form].elements['selected_fld[]'];
    var elts_cnt  = (typeof(elts.length) != 'undefined')
                  ? elts.length
                  : 0;

    if (elts_cnt) {
        for (var i = 0; i < elts_cnt; i++) {
            elts[i].checked = do_check;
        } // end for
    } else {
        elts.checked        = do_check;
    } // end if... else

    return true;
} // end of the 'setCheckboxes()' function


/**
  * Checks/unchecks all options of a <select> element
  *
  * @param   string   the form name
  * @param   string   the element name
  * @param   boolean  whether to check or to uncheck the element
  *
  * @return  boolean  always true
  */
function setSelectOptions(the_form, the_select, do_check)
{
    var selectObject = document.forms[the_form].elements[the_select];
    var selectCount  = selectObject.length;

    for (var i = 0; i < selectCount; i++) {
        selectObject.options[i].selected = do_check;
    } // end for

    return true;
} // end of the 'setSelectOptions()' function

/**
  * Allows moving around inputs/select by Ctrl+arrows
  *
  * @param   object   event data
  */
function onKeyDownArrowsHandler(e) {
    e = e||window.event;
    var o = (e.srcElement||e.target);
    if (!o) return;
    if (o.tagName != "TEXTAREA" && o.tagName != "INPUT" && o.tagName != "SELECT") return;
    if (!e.ctrlKey) return;
    if (!o.id) return;

    var pos = o.id.split("_");
    if (pos[0] != "field" || typeof pos[2] == "undefined") return;

    var x = pos[2], y=pos[1];

    // skip non existent fields
    for (i=0; i<10; i++)
    {
        switch(e.keyCode) {
            case 38: y--; break; // up
            case 40: y++; break; // down
            case 37: x--; break; // left
            case 39: x++; break; // right
            default: return;
        }

        var id = "field_" + y + "_" + x;
        var nO = document.getElementById(id);
        if (nO) break;
    }

    if (!nO) return;
    nO.focus();
    if (nO.tagName != 'SELECT') {
        nO.select();
    }
    e.returnValue = false;
}

/**
  * Inserts multiple fields.
  *
  */
function insertValueQuery() {
    var myQuery = document.sqlform.sql_query;
    var myListBox = document.sqlform.dummy;

    if(myListBox.options.length > 0) {
        var chaineAj = "";
        var NbSelect = 0;
        for(var i=0; i<myListBox.options.length; i++) {
            if (myListBox.options[i].selected){
                NbSelect++;
                if (NbSelect > 1)
                    chaineAj += ", ";
                chaineAj += myListBox.options[i].value;
            }
        }

        //IE support
        if (document.selection) {
            myQuery.focus();
            sel = document.selection.createRange();
            sel.text = chaineAj;
            document.sqlform.insert.focus();
        }
        //MOZILLA/NETSCAPE support
        else if (document.sqlform.sql_query.selectionStart || document.sqlform.sql_query.selectionStart == "0") {
            var startPos = document.sqlform.sql_query.selectionStart;
            var endPos = document.sqlform.sql_query.selectionEnd;
            var chaineSql = document.sqlform.sql_query.value;

            myQuery.value = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
        } else {
            myQuery.value += chaineAj;
        }
    }
}

/**
  * listbox redirection
  */
function goToUrl(selObj, goToLocation){
    eval("document.location.href = '" + goToLocation + "pos=" + selObj.options[selObj.selectedIndex].value + "'");
}

/**
 * getElement
 */
function getElement(e,f){
    if(document.layers){
        f=(f)?f:self;
        if(f.document.layers[e]) {
            return f.document.layers[e];
        }
        for(W=0;i<f.document.layers.length;W++) {
            return(getElement(e,fdocument.layers[W]));
        }
    }
    if(document.all) {
        return document.all[e];
    }
    return document.getElementById(e);
}

/**
  * Refresh the WYSIWYG-PDF scratchboard after changes have been made
  */
function refreshDragOption(e) {
    myid = getElement(e);
    if (myid.style.visibility == 'visible') {
        refreshLayout();
    }
}

/**
  * Refresh/resize the WYSIWYG-PDF scratchboard
  */
function refreshLayout() {
        myid = getElement('pdflayout');

        if (document.pdfoptions.orientation.value == 'P') {
            posa = 'x';
            posb = 'y';
        } else {
            posa = 'y';
            posb = 'x';
        }

        myid.style.width = pdfPaperSize(document.pdfoptions.paper.value, posa) + 'px';
        myid.style.height = pdfPaperSize(document.pdfoptions.paper.value, posb) + 'px';
}

/**
  * Show/hide the WYSIWYG-PDF scratchboard
  */
function ToggleDragDrop(e) {
    myid = getElement(e);

    if (myid.style.visibility == 'hidden') {
        init();
        myid.style.visibility = 'visible';
        myid.style.display = 'block';
        document.edcoord.showwysiwyg.value = '1';
    } else {
        myid.style.visibility = 'hidden';
        myid.style.display = 'none';
        document.edcoord.showwysiwyg.value = '0';
    }
}

/**
  * PDF scratchboard: When a position is entered manually, update
  * the fields inside the scratchboard.
  */
function dragPlace(no, axis, value) {
    if (axis == 'x') {
        getElement("table_" + no).style.left = value + 'px';
    } else {
        getElement("table_" + no).style.top  = value + 'px';
    }
}

/**
  * Returns paper sizes for a given format
  */
function pdfPaperSize(format, axis) {
    switch (format.toUpperCase()) {
        case '4A0':
            if (axis == 'x') return 4767.87; else return 6740.79;
            break;
        case '2A0':
            if (axis == 'x') return 3370.39; else return 4767.87;
            break;
        case 'A0':
            if (axis == 'x') return 2383.94; else return 3370.39;
            break;
        case 'A1':
            if (axis == 'x') return 1683.78; else return 2383.94;
            break;
        case 'A2':
            if (axis == 'x') return 1190.55; else return 1683.78;
            break;
        case 'A3':
            if (axis == 'x') return 841.89; else return 1190.55;
            break;
        case 'A4':
            if (axis == 'x') return 595.28; else return 841.89;
            break;
        case 'A5':
            if (axis == 'x') return 419.53; else return 595.28;
            break;
        case 'A6':
            if (axis == 'x') return 297.64; else return 419.53;
            break;
        case 'A7':
            if (axis == 'x') return 209.76; else return 297.64;
            break;
        case 'A8':
            if (axis == 'x') return 147.40; else return 209.76;
            break;
        case 'A9':
            if (axis == 'x') return 104.88; else return 147.40;
            break;
        case 'A10':
            if (axis == 'x') return 73.70; else return 104.88;
            break;
        case 'B0':
            if (axis == 'x') return 2834.65; else return 4008.19;
            break;
        case 'B1':
            if (axis == 'x') return 2004.09; else return 2834.65;
            break;
        case 'B2':
            if (axis == 'x') return 1417.32; else return 2004.09;
            break;
        case 'B3':
            if (axis == 'x') return 1000.63; else return 1417.32;
            break;
        case 'B4':
            if (axis == 'x') return 708.66; else return 1000.63;
            break;
        case 'B5':
            if (axis == 'x') return 498.90; else return 708.66;
            break;
        case 'B6':
            if (axis == 'x') return 354.33; else return 498.90;
            break;
        case 'B7':
            if (axis == 'x') return 249.45; else return 354.33;
            break;
        case 'B8':
            if (axis == 'x') return 175.75; else return 249.45;
            break;
        case 'B9':
            if (axis == 'x') return 124.72; else return 175.75;
            break;
        case 'B10':
            if (axis == 'x') return 87.87; else return 124.72;
            break;
        case 'C0':
            if (axis == 'x') return 2599.37; else return 3676.54;
            break;
        case 'C1':
            if (axis == 'x') return 1836.85; else return 2599.37;
            break;
        case 'C2':
            if (axis == 'x') return 1298.27; else return 1836.85;
            break;
        case 'C3':
            if (axis == 'x') return 918.43; else return 1298.27;
            break;
        case 'C4':
            if (axis == 'x') return 649.13; else return 918.43;
            break;
        case 'C5':
            if (axis == 'x') return 459.21; else return 649.13;
            break;
        case 'C6':
            if (axis == 'x') return 323.15; else return 459.21;
            break;
        case 'C7':
            if (axis == 'x') return 229.61; else return 323.15;
            break;
        case 'C8':
            if (axis == 'x') return 161.57; else return 229.61;
            break;
        case 'C9':
            if (axis == 'x') return 113.39; else return 161.57;
            break;
        case 'C10':
            if (axis == 'x') return 79.37; else return 113.39;
            break;
        case 'RA0':
            if (axis == 'x') return 2437.80; else return 3458.27;
            break;
        case 'RA1':
            if (axis == 'x') return 1729.13; else return 2437.80;
            break;
        case 'RA2':
            if (axis == 'x') return 1218.90; else return 1729.13;
            break;
        case 'RA3':
            if (axis == 'x') return 864.57; else return 1218.90;
            break;
        case 'RA4':
            if (axis == 'x') return 609.45; else return 864.57;
            break;
        case 'SRA0':
            if (axis == 'x') return 2551.18; else return 3628.35;
            break;
        case 'SRA1':
            if (axis == 'x') return 1814.17; else return 2551.18;
            break;
        case 'SRA2':
            if (axis == 'x') return 1275.59; else return 1814.17;
            break;
        case 'SRA3':
            if (axis == 'x') return 907.09; else return 1275.59;
            break;
        case 'SRA4':
            if (axis == 'x') return 637.80; else return 907.09;
            break;
        case 'LETTER':
            if (axis == 'x') return 612.00; else return 792.00;
            break;
        case 'LEGAL':
            if (axis == 'x') return 612.00; else return 1008.00;
            break;
        case 'EXECUTIVE':
            if (axis == 'x') return 521.86; else return 756.00;
            break;
        case 'FOLIO':
            if (axis == 'x') return 612.00; else return 936.00;
            break;
    } // end switch
}
function DateDiff(date1,F1, date2,F2)
{			
		//var str1 = date1.substr(6,4)+'/'+date1.substr(3,2)+'/'+date1.substr(0,2);  original 
		//var str2 = date2.substr(6,4)+'/'+date2.substr(3,2)+'/'+date2.substr(0,2); 
		
	date_err = 0;
	if(date1.length == 10 && date2.length == 10 ) {
			if(F1 == 'Y-m-d') {
				var day1 = date1.split("-");
				var str1 = day1[0]+"/"+day1[1]+"/"+day1[2];
			}else if(F1 == 'd/m/Y') {
				var day1 = date1.split("/");
				var str1 = day1[2]+"/"+day1[1]+"/"+day1[0];
			}else {
				alert("unknown date1 format");
				date_err=1;
			}
			if(F2 == 'Y-m-d') {
				var day2 = date2.split("-");
				var str2 = day2[0]+"/"+day2[1]+"/"+day2[2];
			}else if(F2 == 'd/m/Y') {
				var day2 = date2.split("/");
				var str2 = day2[2]+"/"+day2[1]+"/"+day2[0];
			}else {
				alert("unknown date2 format");
				date_err=1;
			}		
		if(!date_err) {
			var s = new Date(Date.parse(str1)) ;
			var e = new Date(Date.parse(str2)) ;
			var bufferA = Date.parse( s ) ;    var bufferB = Date.parse( e ) ;
			var number = bufferB-bufferA ;
			diffday = parseInt(number / 86400000) ;
			return diffday;
		}
	} else {
			alert("date input isn't 10 characters format");
	}
}
function numRound(C, decimal)
{
		if(!decimal) decimal=0;
		
		zerofill = '';
  		//return Math.round(C*Math.pow(10,2)) / Math.pow(10,2);
			
		 ANS = Math.round(C*Math.pow(10,decimal)) / Math.pow(10,decimal);
		
		 mod = ANS - Math.round(ANS); // check fraction
		 
		if(decimal>0 &&  mod == 0) {  // if have decimal and fraction = 0 			 
				for(var i=1;i<=decimal;i++) {
					zerofill += '0';
				}
				ANS = ANS+'.'+zerofill; // fill zero until = qty of decimal
				//alert(ANS);			 
		}
		 return ANS;
}
function divide(X,Y, dividerObj, label, fillzero, inform){
	if(X=='') X=0;
	
	if(Y>0) { // if divider  > 0
		answer=numRound(eval(X/Y));  
							 				
		if(answer != 0 || fillzero==1 )  // if ans <> 0 or show  '0' value
		return answer;  // return ans to text box
		else
		return '';
	} else {
		if(inform) {
			alert(label);
		}
		dividerObj.focus();		
		return '';
	}
}
function prepareClose(cnt, sec) {
	if(cnt==sec) {
		window.close();
	}	
	cnt++;
	setTimeout("prepareClose("+cnt+","+sec+")",1000);
}
function img_preview(fileObj, imgObj) {
		if(fileObj.value != "" ) { 
	   
			str_chk = fileObj.value.toLowerCase();
			pos_chk = str_chk.length-4;
				
			if( str_chk.lastIndexOf(".jpg") != pos_chk && str_chk.lastIndexOf(".gif") != pos_chk && str_chk.lastIndexOf(".pdf") != pos_chk && 
				str_chk.lastIndexOf(".zip") != pos_chk && str_chk.lastIndexOf(".doc") != pos_chk && str_chk.lastIndexOf(".xls") != pos_chk  && 
				str_chk.lastIndexOf(".rar") != pos_chk	) {
				//warn+= "??????????????????????????????? ???? .doc , .xls, ???? .pdf \n";
				alert("??????????????????????????????? ???? .jpg , .gif, .pdf ???? .xls \n");
				//fileObj.readonly="false";
				//fileObj.value="";
				fileObj.focus();
				//return false;
			} else if( str_chk.lastIndexOf(".jpg") == pos_chk || str_chk.lastIndexOf(".gif") == pos_chk ) {
				imgObj.src = fileObj.value;
				//alert(imgObj.dynsrc);
			} else if( str_chk.lastIndexOf(".pdf") == pos_chk ) {
				 imgObj.src = '../images/pdfimg.jpg';
			} else if( str_chk.lastIndexOf(".doc") == pos_chk ) {
				 imgObj.src = '../images/docimg.jpg';
			} else if( str_chk.lastIndexOf(".xls") == pos_chk || str_chk.lastIndexOf(".rar") == pos_chk ) {
				 imgObj.src = '../images/xlsimg.jpg';
			} else if( str_chk.lastIndexOf(".zip") == pos_chk ) {
				 imgObj.src = '../images/zipimg.jpg';
			} else {
				 imgObj.src = '../images/blank.jpg';
			}			
		}		
}
	winopen=new Array();
	function openPopup(_fileName,_winIndex,_width,_height) {
		_winName="win"+_winIndex;
		_info = "toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,dependent=yes,height="+_height+",width="+_width+",left="+(window.screen.width/2-(_width/2))+",top="+((window.screen.height/2-(_height/2))-20);
		if (winopen[_winIndex] != null)
			winopen[_winIndex].close();  
		winopen[_winIndex]=window.open(_fileName,_winIndex,_info);
		
		return winopen[_winIndex];
	}
	
	function openPopupFullScreen(_fileName,_winIndex,_resizable) {
		_winName="win"+_winIndex;
		_info = "toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable="+_resizable+",dependent=yes,height="+window.screen.height+",width="+window.screen.width+",left=0,top=0";
			
		if (winopen[_winIndex] != null)
			winopen[_winIndex].close();  
		winopen[_winIndex]=window.open(_fileName,'',_info);
	}
	
	function show_result(obj, valHTML) {
		obj.innerHTML = valHTML;
	}
	function chkLang(lang, objFocus) {
			if(lang=='TH') {
				if((event.keyCode < 3585 || event.keyCode > 3673) && ( event.keyCode != 32 ) && ( event.keyCode != 13 ) && ( event.keyCode != 95 ) ) {
					alert('กรุณากรอกเป็นภาษาไทยเท่านั้น');
					objFocus.focus();                       // 13 is ENTER , 95 is _
					return false;
				}
			} else {
				if(event.keyCode >= 3585 && event.keyCode <= 3673) {
					alert('กรุณากรอกเป็นภาษาอังกฤษเท่านั้น');
					objFocus.focus();
					return false;
				}
			}			
	}
	function chkFieldName(objFocus) {
		if((event.keyCode < 48 || event.keyCode > 57) && ( event.keyCode < 65 || event.keyCode > 90 ) && ( event.keyCode < 97 || event.keyCode > 122 ) && ( event.keyCode != 13 ) && ( event.keyCode != 95 ) ) 	
		{ 	
			alert('กรุณากรอกชื่อด้วย A-Z, a-z, _ หรือ 0-9 เท่านั้น');
			objFocus.focus();
			return false;
		}			 
	}
	function chkSystemText(objName1, objName2 ) {
		
			bufText1 = objName1.value.toUpperCase();
			/*if( objName2 != "" ) {
				bufText2 =  objName2.value.toUpperCase();
			}*/
			for(var j=0;j<SYSTEM_DB_TEXT.length;j++) {
				if( bufText1 == SYSTEM_DB_TEXT[j] ) {
					 alert("โปรดอย่าใช้คำสงวน (reserve word) ในการตั้งชื่อ");
					 objName1.focus();				 
					 return false;
				}
				/*if(objName2 != "") {
					if( bufText2 == SYSTEM_DB_TEXT[j] ) {
						 alert("โปรดอย่าใช้คำสงวน (reserve word)");
					 	objName2.focus();				 
					 	return false;
					}
				}*/
			}
			 return true; // don't delete
		
	}
function chkEnable( obj, arr_tgt_obj, objtype, r){
 
//alert(obj.name+','+arr_tgt_obj+','+objtype);


 if(objtype==null) objtype='';

 		if( objtype.toLowerCase() == 'radio') {
			 //alert(obj[r].checked);
			if(obj[r].checked) {
				setEnable(arr_tgt_obj, 1);
			} else {
				setEnable(arr_tgt_obj, 0);
			}			
		} else if( objtype.toLowerCase() == 'checkbox' ) {
			//alert(obj.name);
			
			if(obj.checked) {
				/*for(var i=0;i<arr_tgt_obj.length;i++) {										
						arr_tgt_obj[i].disabled = false;
						arr_tgt_obj[i].style.filter = '';											
				}*/
				
				setEnable(arr_tgt_obj, 1);
			} else {
				/*for(var i=0;i<arr_tgt_obj.length;i++) {										
						arr_tgt_obj[i].disabled = true;
						arr_tgt_obj[i].style.filter = 'gray';											
				}*/
				setEnable(arr_tgt_obj, 0);
			}
		} else if( objtype.toLowerCase() == 'text') {
			 //alert(obj[r].checked);
			if(obj.value != '') {
				setEnable(arr_tgt_obj, 1);
			} else {
				setEnable(arr_tgt_obj, 0);
			}			
		}
}
function setEnable(arr_obj, bool) {
  if(bool) {
	for(var i=0;i<arr_obj.length;i++) {		
		if(arr_obj[i].type.toLowerCase() == 'text') {
			arr_obj[i].disabled = false;
			arr_obj[i].style.filter = '';	
		} else if(arr_obj[i].type.toLowerCase() == 'checkbox') {
			arr_obj[i].checked = true;	
		}
	}
  } else {
	 for(var i=0;i<arr_obj.length;i++) {
		 if(arr_obj[i].type.toLowerCase() == 'text') {
			arr_obj[i].value = ''; 
			arr_obj[i].disabled = true;
			arr_obj[i].style.filter = 'gray';	
		 } else if(arr_obj[i].type.toLowerCase() == 'checkbox') {
			arr_obj[i].checked = false;	
		 }
	 } 
  }
}
function setreadOnly(obj, bool) {
	//alert(obj.name+' => '+obj.Class); not work 
	//alert(obj.name+' => '+obj.style.filter); not support if obj is not disabled
	if(bool) {
		//obj.disabled = 'true';
		//obj.Class = 'qtyRead';		
		obj.readOnly = true;	
		obj.style.backgroundColor = '#EBEBEB';		
	} else {
		//obj.Class = '';
		obj.readOnly = false;
		obj.style.backgroundColor = '';
	}
	//alert(obj.readOnly);
	//alert(obj.name+' => '+obj.style.filter);
	//alert(obj.name+' => '+obj.class);
	
}
function cal_basic(obj1,obj2,objAns,operator,decimal){	
	var X=obj1.value*1;
	var Y=obj2.value*1;	
	var Z='';
	
	if(!decimal) decimal = 0;
	//alert(decimal);
	switch (operator) {
		case '+': Z = X+Y; break;
		case '-': Z = X-Y; break;
		case '*': Z = X*Y; break;
		case '/': if(Y>0) {
					Z = X/Y; 
				  }
				  else {
					Z = '';
				  }
				  break;
	}
	objAns.value = numRound(Z, decimal);
}
function set_bgColor_child(objChk, objTgt, color) {
		if(!color) color = defaultColor;
	
		if(objChk.readOnly==false) {
				objTgt.bgColor = color;
		}	
}
begin_pos = 1;
normal_color = '';
found = 0;
function searchUnit() {

		//document.getElementById('body1').style.cursor = 'wait'; no work
		
		/* arr_keyword = document.getElementById('keyword').value.split(' ');
		keytext = '';
		
		for(var j=0;j<arr_keyword.length;j++) {
			keytext += '('+arr_keyword[j]+')+';
		}
		if(keytext != '') {
			keytext = keytext.substr(0,keytext.length-1);
		}
		alert(keytext); */
		
		//br = '';
		//posY = 0;
		//alert(begin_pos);
if(document.getElementById('keyword').value != '' ) {

	  if(document.frm.total_unit.value>0) {
			
			if(found) {
				// normal_color != ''
				if(begin_pos>1) k = begin_pos-1; else k = begin_pos;			
				 document.getElementById('row'+k).bgColor=normal_color;
			}
			
			if(begin_pos > document.frm.total_unit.value) {
							begin_pos=1;
			}
			for(var i=begin_pos;i<=document.frm.total_unit.value;i++) {
					//br+='<BR>';	
					//posY+=30;			
					if( document.frm['d_unit_name'+i].value.search(document.getElementById('keyword').value) != -1 || document.frm['d_unit_code'+i].value.search(document.getElementById('keyword').value) != -1 ) {
						normal_color = document.getElementById('row'+i).bgColor;
						
						document.getElementById('row'+i).bgColor='#CCFFFF';
						document.frm['chkbox'+i].focus();
						//move_box(obj, offset, repeat )
						found=1;
						// document.getElementById('body1').style.cursor = ''; no work
						begin_pos=i+1;									
						//document.getElementById('sch').innerHTML='<BR><BR>'+br+'<table bgcolor="#FFCC99" border="0" cellspacing="0" cellpadding="2" ><tr><td align="center" >ค้นหา</td></tr><tr><td align="center"><input name="keyword" type="text" id="keyword" size="15" border="1" height="15" ></td></tr><tr><td align="center"><img src="../images/text_view.gif" alt="ทำการค้นหา" style="cursor:hand" onClick="searchUnit();"></td></tr></table>';											
						//document.getElementById('sch').style.top=50+posY;
						//document.getElementById('sch').style.top=document.body.scrollTop;
						//alert(document.getElementById('sch').style.top);
						//return false;  // good
						return i;
					}
			}
			if(i > document.frm.total_unit.value) {
							//document.getElementById('body1').style.cursor = ''; no work
							found=0;
							alert('ไม่พบข้อความที่ค้นหา');
							begin_pos=1;
							return i;
			}
	   }	
	} else {
			alert('กรุณากรอกคำค้นหา');
	}
}
function searchSchool() {

  if(document.getElementById('keyword').value != '' ) {

	  if(document.frm.tot_school.value>0) {
			
			if(found) {
				// normal_color != ''
				if(begin_pos>1) k = begin_pos-1; else k = begin_pos;			
				 document.getElementById('row'+k).bgColor=normal_color;
			}
			
			if(begin_pos > document.frm.tot_school.value) {
							begin_pos=1;
			}
			for(var i=begin_pos;i<=document.frm.tot_school.value;i++) {
					//br+='<BR>';	
					//posY+=30;			
					if( document.frm['school_name'+i].value.search(document.getElementById('keyword').value) != -1 || document.frm['school_code'+i].value.search(document.getElementById('keyword').value) != -1 ) {
						normal_color = document.getElementById('row'+i).bgColor;
						
						document.getElementById('row'+i).bgColor='#CCFFFF';
						document.frm['chkbox'+i].focus();
						//move_box(obj, offset, repeat )
						found=1;
						// document.getElementById('body1').style.cursor = ''; no work
						begin_pos=i+1;															
						return i;
					}
			}
			if(i > document.frm.tot_school.value) {
							//document.getElementById('body1').style.cursor = ''; no work
							found=0;
							alert('ไม่พบข้อความที่ค้นหา');
							begin_pos=1;
							return i;
			}
	   }	
	} else {
			alert('กรุณากรอกคำค้นหา');
	}
}
function move_box(obj, offsetX, offsetY, repeat ) {

	//if(document.body.scrollTop>200) {		
		obj.style.left=(document.body.clientWidth*1)-offsetX;
		obj.style.top=(document.body.scrollTop*1)+offsetY;
		obj1 = obj;
		offsetX1 = offsetX;
		offsetY1 = offsetY;
	//}
	if(repeat) {  // ถ้าเรียกฟังก์ชั่น ซ้ำ
		repeat1 = repeat;
		setTimeout("move_box(obj1, offsetX1, offsetY1, repeat1)",10);
	} else {
		// ทำงานครั้งเดียว
		return 1;
	}
}
function winclose() {
	window.close();
}