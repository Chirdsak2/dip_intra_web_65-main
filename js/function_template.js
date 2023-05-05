function show_d(d,e){
	if(d.src.search('bar_down.gif') > 0){
		document.getElementById(e).style.display = '';
		d.src = "../../images/bar_up.gif";
	}else{
		document.getElementById(e).style.display = 'none';
		d.src = "../../images/bar_down.gif";
	}
}
	function autosave(){
		auto_save.document.form1.tagdetect.value=document.all.Demo4.innerHTML;
		auto_save.form1.submit();
	}
	function edit_d(c){
	//	autosave();
		win2 = window.open('../../ContentMgt/block_update.php?B=' + c + '','BlockEdit','top=20,left=80,width=640,height=550,resizable=1,status=0,scrollbars=1');
		win2.focus();
	}
		function edit_d(c){
	//	autosave();
		win2 = window.open('../../ContentMgt/block_update.php?B=' + c + '','BlockEdit','top=20,left=80,width=640,height=550,resizable=1,status=0,scrollbars=1');
		win2.focus();
	}
	function delete_d(c){
		if(confirm("Are you sure to delete this WebBlock ?")){
			document.getElementById("EWTID_S"+c+"EWTID_E").outerHTML = "";
			auto_save.document.form1.DelBID.value= c;
			autosave();
		}
	}
		function showtable(c){
	for(i=1;i<7;i++){
		if(i != c){
		self.parent.look_properties.document.getElementById("tr0" +i).style.display='none';
		}else{
		self.parent.look_properties.document.getElementById("tr0" +i).style.display='';
		}
	}
	self.parent.look_properties.document.form2.tbshow.value='0'+c;
}