$(function() {
  $("#increase").click(function() {
	$("div,a,button,ol,ul,li,h1,h2,h3,h4,h5,h6,form,input,label,iframe,table,tr,td,textarea").children().each(function() {
	  var size = parseInt($(this).css("font-size"));
	  size = size + 1 + "px";
	  $(this).css({
		'font-size': size
	  });
	});
  });
});
$(function() {
  $("#normal").click(function() {
	$("div,a,button,ol,ul,li,h1,h2,h3,h4,h5,h6,form,input,label,iframe,table,tr,td,textarea").children().each(function() {
	  var size = parseInt($(this).css("font-size"));
	  size = ""/*size - 1 + "px";*/
	  $(this).css({
		'font-size': size
	  });
	});
  });
});
$(function() {
  $("#decrease").click(function() {
	$("div,a,button,ol,ul,li,h1,h2,h3,h4,h5,h6,form,input,label,iframe,table,tr,td,textarea").children().each(function() {
	  var size = parseInt($(this).css("font-size"));
	  size = size - 1 + "px";
	  $(this).css({
		'font-size': size
	  });
	});
  });
});