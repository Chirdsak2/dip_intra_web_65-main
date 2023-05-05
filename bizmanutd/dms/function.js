// JavaScript Document
function AddRoom(tbName){


	var tbObj=document.getElementById(tbName);
	var myNumRow=tbObj.rows.length;
	var myNumCol=tbObj.rows[0].cells.length;
	tbObj.insertRow(myNumRow-1);
	for(i=0;i<3;i++){
		tbObj.rows[myNumRow-1].insertCell();
	}
	tbObj.rows[myNumRow-1].height=22;
//	tbObj.rows[myNumRow-1].cells[0].width="53";
	tbObj.rows[myNumRow-1].cells[0].innerHTML="<div align=\"right\"><font color=\"#FFFFFF\" size=\"1\" face=\"MS Sans Serif, Tahoma, sans-serif\"><strong>Upload file</strong></font></div>";
//	tbObj.rows[myNumRow-1].cells[1].width="69";
	tbObj.rows[myNumRow-1].cells[1].innerHTML="<input type=\"file\" name=\"file[]\">";
//	tbObj.rows[myNumRow-1].cells[2].width="46";
	tbObj.rows[myNumRow-1].cells[2].innerHTML="<img src=\"images/delete.gif\" width=\"16\" height=\"16\" style=\"cursor:hand\" onclick=\"DeleteRoom(\'"+tbName+"\',\'"+(myNumRow-1)+"\');\">";

formatRoom(tbName);
}

function DeleteRoom(tbName,rowName){
	var tbObj=document.getElementById(tbName);
	tbObj.deleteRow(rowName);
	formatRoom(tbName);
}

function formatRoom(tbName){
	var tbObj=document.getElementById(tbName);
	var myNumRow=tbObj.rows.length;
	var myNumCol=tbObj.rows[0].cells.length;
	
	if((myNumRow>2)){
		for(j=0;j<myNumRow-1;j++){
			tbObj.rows[j].cells[2].innerHTML="<img src=\"images/delete.gif\" width=\"16\" height=\"16\" style=\"cursor:hand\"  onclick=\"DeleteRoom(\'"+tbName+"\',\'"+j+"\');\">";
		}//for
		
	}else{
			tbObj.rows[0].cells[2].innerHTML="<img src=\"images/delete1.gif\" width=\"16\" height=\"16\">";
	}
}