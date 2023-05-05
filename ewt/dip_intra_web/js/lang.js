function ChangeLanguage(lang,filename){
 					document.all.formtextchangelang.innerHTML = "<form name=\"changeform\" method=\"post\" action=\"ewt_language_block.php\"><input name=\"language\" type=\"hidden\" id=\"language\" value=\""+ lang +"\"><input name=\"filename\" type=\"hidden\" id=\"filename\" value=\""+ filename +"\"><input name=\"page\" type=\"hidden\" id=\"page\" value=\"" + this.location + "\"></form>";
changeform.submit();
 }
 