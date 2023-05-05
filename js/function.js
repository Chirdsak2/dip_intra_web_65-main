// JavaScript Document
function AddRoom(tbName){


	var tbObj=document.getElementById(tbName);
	var myNumRow=tbObj.rows.length;
	var myNumCol=tbObj.rows[0].cells.length;
	tbObj.insertRow(myNumRow-1);
	for(i=0;i<3;i++){
		tbObj.rows[myNumRow-1].insertCell();
	}
	tbObj.rows[myNumRow-1].height=30;
//	tbObj.rows[myNumRow-1].cells[0].width="53";
	tbObj.rows[myNumRow-1].cells[0].style.backgroundColor="F7F7F7";
	tbObj.rows[myNumRow-1].cells[0].innerHTML="Upload File:";
//	tbObj.rows[myNumRow-1].cells[1].width="69";
	tbObj.rows[myNumRow-1].cells[1].innerHTML="<input type=\"file\" name=\"file[]\" onchange = \"changePic(this);\" onClick=\"changePic(this);\">";
//	tbObj.rows[myNumRow-1].cells[2].width="46";
	tbObj.rows[myNumRow-1].cells[2].innerHTML="<img src=\"../images/error.gif\" width=\"16\" height=\"16\" style=\"cursor:hand\" onclick=\"DeleteRoom(\'"+tbName+"\',\'"+(myNumRow-1)+"\');\">";

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
			tbObj.rows[j].cells[2].innerHTML="<img src=\"../images/error.gif\" width=\"16\" height=\"16\" style=\"cursor:hand\"  onclick=\"DeleteRoom(\'"+tbName+"\',\'"+j+"\');\">";
		}//for
		
	}else{
			tbObj.rows[0].cells[2].innerHTML="<img src=\"../images/error1.gif\" width=\"16\" height=\"16\">";
	}
}
//นำเอาไปใช้หน้า E-book Management ครับ
function AddRoom2(tbName){

	var tbObj=document.getElementById(tbName);
	var myNumRow=tbObj.rows.length;
	var myNumCol=tbObj.rows[0].cells.length;
	tbObj.insertRow(myNumRow-1);
	for(i=0;i<3;i++){
		tbObj.rows[myNumRow-1].insertCell();
	}
	tbObj.rows[myNumRow-1].height="25";
	tbObj.rows[myNumRow-1].cells[0].width="7%";
	tbObj.rows[myNumRow-1].cells[0].style.backgroundColor="#E0DFE3";
	tbObj.rows[myNumRow-1].cells[0].innerHTML="Upload File:";
	tbObj.rows[myNumRow-1].cells[1].width="20%";
	tbObj.rows[myNumRow-1].cells[1].style.backgroundColor="F7F7F7";
	tbObj.rows[myNumRow-1].cells[1].innerHTML="<input type=\"file\" name=\"pageFile[]\" onChange=\"chkFile(this);\">";
	tbObj.rows[myNumRow-1].cells[2].width="73%";
	tbObj.rows[myNumRow-1].cells[2].style.backgroundColor="F7F7F7";
	tbObj.rows[myNumRow-1].cells[2].innerHTML="<img src=\"../images/error.gif\" width=\"16\" height=\"16\" style=\"cursor:hand\" onclick=\"DeleteRoom(\'"+tbName+"\',\'"+(myNumRow-1)+"\');\">";
formatRoom(tbName);
}

//นำเอาไปใช้หน้า Document Download Management ครับ
function AddRoom3(tbName){

	var tbObj=document.getElementById(tbName);
	var myNumRow=tbObj.rows.length;
	var myNumCol=tbObj.rows[0].cells.length;
	tbObj.insertRow(myNumRow-1);
	for(i=0;i<3;i++){
		tbObj.rows[myNumRow-1].insertCell();
	}
	tbObj.rows[myNumRow-1].height=30;
//	tbObj.rows[myNumRow-1].cells[0].width="53";
	tbObj.rows[myNumRow-1].cells[0].style.backgroundColor="F7F7F7";
	tbObj.rows[myNumRow-1].cells[0].innerHTML="Upload File:";
//	tbObj.rows[myNumRow-1].cells[1].width="69";
	tbObj.rows[myNumRow-1].cells[1].innerHTML="<input type=\"file\" name=\"dl_file[]\" >";
//	tbObj.rows[myNumRow-1].cells[2].width="46";
	tbObj.rows[myNumRow-1].cells[2].innerHTML="<img src=\"../images/error.gif\" width=\"16\" height=\"16\" style=\"cursor:hand\" onclick=\"DeleteRoom(\'"+tbName+"\',\'"+(myNumRow-1)+"\');\">";

   formatRoom(tbName);
}
