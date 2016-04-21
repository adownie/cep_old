function disable_enter(){
	jQuery("div#headway-visual-editor input").keypress(function(e) {
	     if (e.which == 13) {
	     	return false;
	     }
      });
}
function make_form_name(element){
	form_name = element.replace(/\./g, '-period-').replace(/\ /g, '-space-').replace(/\#/g, '-pound-').replace(/\,/g, '-comma-').replace(/\:/g, '-colon-');

	return form_name;
}

function make_selector_from_form_name(element){
	form_name = element.replace(/-period-/g, '.').replace(/-space-/g, ' ').replace(/-pound-/g, '#').replace(/-comma-/g, ',').replace(/-colon-/g, ':');

	return form_name;
}

function initiateSidebarScroll(){
	jQuery('#visual-editor-sidebar-content').jScrollPane();
}

function noLeaveVisualEditor(){	
	if(navigator.userAgent.indexOf("Chrome") == -1){
		window.onbeforeunload = function(){
			return "You have unsaved changes.  Are you sure you wish to leave the Visual Editor?";
		}
	}
}

jQuery(function(){
	
	jQuery('.headway-visual-editor-input').change(function(){
		noLeaveVisualEditor();
	});
	
	disable_enter(); 
		
	jQuery('a:not(a#close-editor, a.keep-active)').click(function(){ return false; });
		
	jQuery('div#headway-visual-editor form').attr('action', '');
	jQuery('div#headway-visual-editor form').attr('method', '');
	jQuery('div#headway-visual-editor form').attr('target', '');
	jQuery('div#headway-visual-editor form').attr('onsubmit', '');

	jQuery("div#headway-visual-editor input[type='submit']").click(function(){ return false; });

	jQuery('div#headway-visual-editor .gform_body input').attr('name', '');

	
	function headway_save_editor(form_data, redirect){		
		jQuery('span#headway-save-load').show().animate({'opacity':1}, 750, false); 		
		jQuery('input#headway-save-button').animate({'opacity':0}, 750, false);
				
		color_data = jQuery('.headway-visual-editor-color-input').serialize();
		font_data = jQuery('.headway-visual-editor-font-input').serialize();
		border_data = jQuery('.headway-visual-editor-border-input').serialize();
		
		jQuery.post( blog_url + '/?headway-visual-editor-action', color_data );
		jQuery.post( blog_url + '/?headway-visual-editor-action', font_data );
		jQuery.post( blog_url + '/?headway-visual-editor-action', border_data );		
				
		jQuery.post( blog_url + '/?headway-visual-editor-action', form_data, function(){ 
			if(typeof redirect != 'undefined'){
				window.location.replace(window.location.href);
			}
			
			jQuery('input#headway-save-button').animate({'opacity':1}, 750, false); 
			jQuery('span#headway-save-load').animate({'opacity':0}, 750, false, function(){ 
				jQuery(this).hide(); 
			});
			jQuery('div#save-message').show().animate({'opacity':1}, 750, false);
			
			jQuery('div#save-message').animate({'opacity':.99}, 11000).animate({'opacity':0}, 2500, false, function(){ 
				jQuery(this).hide(); 
			});
		});
		
		window.onbeforeunload = function(){
			return null;
		}
		
	}
	
	jQuery('input#headway-save-button').click(function(){
		form_data = jQuery('.headway-visual-editor-input').serialize();
	
		headway_save_editor(form_data);
	});
	
	jQuery('input#save-and-link-button').click(function(){
		jQuery('div#headway-visual-editor').append('<input type="hidden" name="save-and-link" id="save-and-link-hidden" class="headway-visual-editor-input" value="true" />');
		form_data = jQuery('.headway-visual-editor-input').serialize();
		jQuery('input#save-and-link-hidden').remove();
		
		jQuery('div#overlay').animate({'opacity':0}, 250, false, function(){ jQuery(this).hide(); });
		jQuery('div#save-and-link-box').animate({'opacity':0}, 250, false, function(){ jQuery(this).hide(); });
		
		headway_save_editor(form_data);
	});
	
	jQuery('input#set-default-leafs').click(function(){
		jQuery('div#headway-visual-editor').append('<input type="hidden" name="set-default-leafs" id="set-default-leafs-hidden" class="headway-visual-editor-input" value="true" />');
		form_data = jQuery('.headway-visual-editor-input').serialize();
		jQuery('input#set-default-leafs-hidden').remove();
		
		headway_save_editor(form_data);
	});
	
	jQuery('input#reset-leafs').click(function(){
		if(confirm('Are you sure you want to reset the leafs on this page?  There is no turning back.')){
			jQuery('div#headway-visual-editor').append('<input type="hidden" name="reset-leafs" id="reset-leafs-hidden" class="headway-visual-editor-input" value="true" />');
			form_data = jQuery('.headway-visual-editor-input').serialize();
			jQuery('input#reset-leafs-hidden').remove();
		
			headway_save_editor(form_data, true);
		}
	});
	
	
	
	
	
	
	jQuery('div#save-message a#save-message-close, div#save-message a#continue-editing').click(function(){
		jQuery('div#save-message').stop(true, true).animate({'opacity':0}, 750, false, function(){ 
			jQuery(this).hide(); 
			jQuery(this).css('top', '-9999px');
		});
	});
	
	jQuery('div.floaty-box:not(.no-drag)').draggable({ 
		opacity: 0.35, 
		handle:'h4.floaty-box-header',
		stack: { group: '.floaty-box', min: 9999 }
	});
	
	function readyHelpSelector(selector){
		
		jQuery('div#help-box-content').html('<p class="loading"><img src="' + theme_url + '/media/images/loading.gif" class="loading-image" /></p>');
		jQuery('div#help-box-content').load(blog_url+'/?headway-ajax-loader=true&use_auth=true&proxy='+ escape('http://headwaythemes.com/resources/inline-documentation/?id='+selector.val()), false, function(){
			jQuery('div#help-box-content a[href*="headwaythemes.com/documentation"]').click(
			    function(){
			        readyHelpLinks(jQuery(this));

			        return false;
			    }
			);
		});
	}
	
	function readyHelpLinks(link){
		jQuery('div#help-box-content').html('<p class="loading"><img src="' + theme_url + '/media/images/loading.gif" class="loading-image" /></p>');
	
		jQuery.ajax({
		  url: blog_url+'/?headway-ajax-loader=true&use_auth=true&proxy='+ escape('http://headwaythemes.com/resources/inline-documentation/?get-slug-id='+link.attr('href').replace('http://headwaythemes.com/', '')),
		  cache: false,
		  success: function(id){
		  	jQuery('select#help-selector').val(id);
		  }
		});
		

        jQuery('div#help-box-content').load(blog_url+'/?headway-ajax-loader=true&use_auth=true&proxy='+ escape('http://headwaythemes.com/resources/inline-documentation/?slug='+link.attr('href').replace('http://headwaythemes.com/', '')), false, function(){ 
			jQuery('div#help-box-content a[href*="headwaythemes.com/documentation"]').click(
			    function(){
			        readyHelpLinks(jQuery(this));

			        return false;
			    }
			);
	 	});
	}
	
	
	jQuery('h4.collapsable-header a').click(function(){
		collapsable = jQuery(this).parent().parent();

		if(collapsable.hasClass('collapsed')){
			collapsable.children('div.collapsable-content').show();
			collapsable.css({paddingBottom: '5px'});
			collapsable.removeClass('collapsed');
		} else {
			collapsable.children('div.collapsable-content').hide();
			collapsable.css({paddingBottom: 0});
			collapsable.addClass('collapsed');
		}
		
		initiateSidebarScroll();
		
	});

	jQuery('div#visual-editor-menu a:not(.no-link)').click(function(){
		if(!jQuery(this).hasClass('no-overlay')){
			if(jQuery('div#overlay').length == 0){
				jQuery('div#headway-visual-editor').append('<div id="overlay"></div>');
				jQuery('div#overlay').animate({opacity: 1}, 50);
			}
		}
		
		if(jQuery(this).attr('id') == 'help'){
			if(!jQuery('div#help-box-bar-left').hasClass('loaded')){
				jQuery('div#help-box-bar-left').load(blog_url+'/?headway-ajax-loader=true&use_auth=true&proxy='+ escape('http://headwaythemes.com/resources/inline-documentation/?dropdown=true'), false, function(){
					jQuery('div#help-box-bar-left select').change(function(){
						if(jQuery(this).val()){
							readyHelpSelector(jQuery(this));
						}
					});
				});
			
				jQuery('div#help-box-bar-left').addClass('loaded');
			}
		}

		jQuery('div#'+jQuery(this).attr('id')+'-box').show();
	});


	jQuery('a#visual-editor-sidebar-toggle').click(function(){
		if(jQuery('div#visual-editor-sidebar').hasClass('collapsed')){
			jQuery('div#headway-visual-editor').animate({marginLeft: 308}, 750);
			jQuery('div#visual-editor-sidebar').animate({left: 0}, 750);
			jQuery('div#visual-editor-sidebar').removeClass('collapsed');
		} else {
			jQuery('div#headway-visual-editor').animate({marginLeft: 0}, 750);
			jQuery('div#visual-editor-sidebar').animate({left: -308}, 750);
			jQuery('div#visual-editor-sidebar').addClass('collapsed');
		}
	});

	
	jQuery('div.tabs').tabs();
	jQuery('div.floaty-box:not(.floaty-box-close, #floaty-box-loader) h4.floaty-box-header').append('<a class="minimize window-top-right" href="#">&ndash;</a>');
	jQuery('div.floaty-box-close h4.floaty-box-header').append('<a class="close window-top-right" href="#">X</a>');
	jQuery('div.floaty-box-close h4.floaty-box-header a.close').click(function(){
		jQuery(this).parent().parent().hide();
		jQuery('div.overlay').animate({opacity: 0}, 50, false, function(){ jQuery('div.overlay').remove(); });
		return false;
	});
	
	jQuery('div.floaty-box h4.floaty-box-header a.minimize').click(function(){
		if(jQuery(this).parent().parent().hasClass('small-floaty-box')){
			jQuery(this).parent().parent().removeClass('small-floaty-box');
			jQuery(this).parent().siblings().removeClass('hidden');
			jQuery(this).html('&ndash;');
		} else {
			jQuery(this).parent().parent().addClass('small-floaty-box');

			jQuery(this).parent().siblings().addClass('hidden');
			jQuery(this).html('+');
		}
				
		return false;
	});


	jQuery('div#intro-overlay').click(function(){
		jQuery('div#intro-box, div#intro-overlay').animate({opacity: 0}, 50, false, function(){ jQuery('div#intro-overlay, div#intro-box').remove(); });
	});
	
	
	jQuery('form#layout-chooser select').change(function(){
		jQuery(this).siblings('select').val('');
	});

	
	jQuery('div#visual-editor-sidebar div.sub-box:not(.minimize) span.sub-box-heading').append('<a class="minimize window-top-right" href="#">&ndash;</a>');
	jQuery('div#visual-editor-sidebar div.minimize span.sub-box-heading').append('<a class="minimize window-top-right" href="#">+</a>');

	
	jQuery('span.sub-box-heading a.minimize').click(function(){
		this_container = jQuery(this).parent().parent();
		
		if(this_container.hasClass('minimize')){
			this_container.removeClass('minimize');
			jQuery(this).html('&ndash;');
		} else {
			this_container.addClass('minimize');
			jQuery(this).html('+');
		}
		
		initiateSidebarScroll();
		
		return false;
	});
	
	
	jQuery('textarea#live-css').keyup(function(){
		jQuery('#live-css-holder').html(jQuery(this).val());
	});
	
	
	jQuery('div#skins-tab ul.thumbnail-grid li a').click(function(){
		jQuery('div#skins-tab li.selected').removeClass('selected');
		jQuery(this).parent('li').addClass('selected');
		
		skin_id = jQuery(this).parent('li').attr('id');
		
		jQuery('#skin-notification').show();
		
		jQuery('select#skins-selector').val(skin_id);
		
		noLeaveVisualEditor();
		
	});


	jQuery('div#live-css-box').resizable({minWidth: 350, minHeight: 200, alsoResize: 'textarea#live-css'});
	

	
	jQuery('input#s').attr('name', '');
	
	jQuery.fn.reverse = [].reverse;
	
	jQuery('.tooltip').css('cursor', 'help').tooltip({track: true, delay: 0, showURL: false, fade: 250, positionLeft: false, extraClass: 'tooltip-default'});
	initiateSidebarScroll();
	
});

function str_replace(haystack, needle, replacement) {
	var temp = haystack.split(needle);
	return temp.join(replacement);
}
function removeBlankArrayItems(someArray) {
    var newArray = [];
    for(var index = 0; index < someArray.length; index++) {
        if(someArray[index]) {
            newArray.push(someArray[index]);
        }
    }
    return newArray;
}
