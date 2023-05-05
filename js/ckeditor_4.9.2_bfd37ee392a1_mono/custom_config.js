CKEDITOR.editorConfig = function( config ) {
	config.language = 'en';
	config.height= 400;
    config.width = '100%';
	config.uiColor = '#FFFFFF';
	config.extraPlugins = 'image';
	config.filebrowserUploadUrl = '../../js/ckeditor/ckupload.php';
	config.image_removeLinkByEmptyURL= true;
	config.image_previewText = CKEDITOR.tools.repeat( 'ตัวอย่างรูปภาพ ', 100 );
	//config.codeSnippet_theme = 'pojoaque';
	
	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		'/',
		{ name: 'forms', groups: [ 'forms' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];
	config.removeButtons = 'Anchor,Save,Templates,NewPage,Preview,Print,SelectAll,Find,Replace,Flash,PageBreak,Iframe,ShowBlocks,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField';
};


 
  