
jQuery(function(){
	jQuery('div#visual-editor-loader, div#overlay').animate({'opacity':0}, 800, false, function(){ 
		jQuery('div#visual-editor-loader, div#overlay').remove();
	 });
});