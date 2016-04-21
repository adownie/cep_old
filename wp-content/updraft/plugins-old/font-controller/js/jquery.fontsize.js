jQuery.fn.fontsizemanager = function () {
	var startFontSize = parseFloat(jQuery("body").css("font-size"));
	jQuery('.fontsizemanager_add').css("cursor","pointer");
	jQuery('.fontsizemanager_minus').css("cursor","pointer");
	jQuery('.fontsizemanager_reset').css("cursor","pointer");
	jQuery('.fontsizemanager_add').click(function() {
		var newFontSize = parseFloat(jQuery("body").css("font-size"))
		newFontSize=newFontSize*1.2;
		jQuery('body').css("font-size",newFontSize);
	});
	jQuery('.fontsizemanager_minus').click(function() {
		var newFontSize = parseFloat(jQuery("body").css("font-size"))
		newFontSize=newFontSize*0.8;
		jQuery('body').css("font-size",newFontSize);			 
	});
	jQuery('.fontsizemanager_reset').click(function() {
		jQuery('body').css("font-size",startFontSize);			 
	});
}