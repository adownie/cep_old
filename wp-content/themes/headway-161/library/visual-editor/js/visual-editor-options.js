jQuery(function(){
	
	/* Header */
		/* Header Image */
		jQuery('a#upload-header-image').click(function(){
			jQuery('div#header-uploader-box').show();
		});
		
		if(!disable_site_config){
			jQuery('input#header-image').uploadify({
				'uploader'  : theme_url+'/library/resources/uploadify/uploadify.swf',
				'script'    : theme_url+'/library/visual-editor/lib/upload-header.php',
				'cancelImg' : theme_url+'/library/resources/uploadify/cancel.png',
				'buttonImg' : theme_url+'/library/visual-editor/images/header_uploader.jpg',
				'rollover'  : true,
				'auto'      : true,
				'folder'    : 'header-uploads',
				onComplete: function(event, queueID, fileObj, response, data){
								
					jQuery('#header-image-current').text(fileObj.name);
					jQuery('#header-image-current-row').show();
			
					if(jQuery('.header-link-image-inside').length == 0){
						
						
						rel_attr = jQuery('div#top .header-link-text-inside').attr('rel');
						title_attr = jQuery('div#top .header-link-text-inside').attr('title');
						link_attr = jQuery('div#top .header-link-text-inside').attr('href');

					
						jQuery('div#top').append('<a class="header-link-image-inside" rel="' + rel_attr + '" title="' + title_attr + '" href="' + link_attr + '"><img alt="' + title_attr + '" src="' + blog_url + upload_path + 'header-uploads/' + escape(fileObj.name) +'" /></a>');
				
						jQuery('div#top .header-link-image-inside').click(function(){
							return false;
						});
				
						jQuery('.header-link-text-inside').hide();

						jQuery('div#top').addClass('header-link-image');
						jQuery('div#top').removeClass('header-link-text');
						
						noLeaveVisualEditor();
						
					}
					else
					{
						jQuery('.header-link-image-inside img').attr('src', theme_url + '/library/resources/timthumb/thumbnail.php?src=' + upload_path + 'header-uploads/' + fileObj.name );
						jQuery('.header-link-image-inside').show();
				
						jQuery('.header-link-text-inside').hide();

						jQuery('div#top').addClass('header-link-image');
						jQuery('div#top').removeClass('header-link-text');
					}
			
					jQuery('#header-image-hidden').attr('value', fileObj.name);
		
				} 
			});
		}
		
		
		
		jQuery('input#import-file').uploadify({
			'uploader'  : theme_url+'/library/resources/uploadify/uploadify.swf',
			'script'    : theme_url+'/library/visual-editor/lib/upload-style.php',
			'cancelImg' : theme_url+'/library/resources/uploadify/cancel.png',
			'buttonImg' : theme_url+'/library/visual-editor/images/uploader_333.jpg',
			'rollover'  : true,
			'auto'      : true,
			'wmode'     : 'transparent',
			'folder'    : 'imported-styles',
			onComplete: function(event, queueID, fileObj, response, data){	

				fileName = escape(response);
								
				jQuery.ajax({
				  url: theme_url+'/library/visual-editor/lib/process-style.php?path='+fileName,
				  dataType: 'json',
				  success: function(data){
				  		var style = data;

						for (var i=0;i<style.length;i++)
						{
							value = style[i].value.toString();

							if(style[i].property_type == 'sizing') style[i].property_type = 'width';
							style[i].property = style[i].property.replace('-width', '');
														
							if(jQuery('#'+style[i].property_type+'-'+style[i].element+'-'+style[i].property).length == 0){
								continue;
							}
														
							if(style[i].property == 'font-weight' || style[i].property == 'text-transform'){
								font_check_function(jQuery('#'+style[i].property_type+'-'+style[i].element+'-'+style[i].property), value);
							}		
																			
							jQuery('#'+style[i].property_type+'-'+style[i].element+'-'+style[i].property).val(value).trigger('blur').trigger('change');
						}
						
						noLeaveVisualEditor();
						
				  }
				});
				

			} 
		});
		
		
		jQuery('#header-image-delete').click(function(){
			if(confirm('Are you sure?') == true){
				jQuery('#header-image-current').text('');
				jQuery('#header-image-current-row').hide();
				
				jQuery('#header-image-hidden').attr('value', 'DELETE');
			
				jQuery('.header-link-image-inside').hide();
				if(jQuery('.header-link-text-inside').length > 0){
					jQuery('.header-link-text-inside').show();
				
					jQuery('div#top').addClass('header-link-text');
					jQuery('div#top').removeClass('header-link-image');
				} else {
					jQuery('div#top').prepend('<a class="header-link-text-inside" rel="home" title="' + blog_name + '" href="' + blog_url + '" style="cursor: pointer;">' + blog_name + '</a>')
					
					jQuery('.header-link-text-inside').bind('click', function(){ return false; });
					
					jQuery('div#top').addClass('header-link-text');
					jQuery('div#top').removeClass('header-link-image');
				}
			}
			
			noLeaveVisualEditor();
			
		});
		
		
		jQuery('#header-image-margin').blur(function(){
			jQuery('div#top').css('margin', jQuery(this).val());
		});
		/* End (Header Image) */


		/* Header Items */
		jQuery('input#show-tagline').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('h1#tagline').show();
			}
			else
			{
				jQuery('h1#tagline').hide();
			}
		});

		jQuery('input#show-navigation').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('div#navigation').show();
			}
			else
			{
				jQuery('div#navigation').hide();
			}
		});

		jQuery('input#show-breadcrumbs').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('div#breadcrumbs').show();
			}
			else
			{
				jQuery('div#breadcrumbs').hide();
			}
		});
		/* End (Header Items) */
		
		/* Header Style */
		header_fluid_switch = false;
		header_fixed_switch = false;

		jQuery('#header-style-fluid').click(function(){
			noLeaveVisualEditor();
			
			if(!header_fluid_switch){
				jQuery('body').addClass('header-fluid');
				jQuery('body').removeClass('header-fixed');


				jQuery('div#header').addClass('header-sortable');
				jQuery('div#navigation').addClass('header-sortable');
				jQuery('div#breadcrumbs').addClass('header-sortable');				
				
				jQuery('#breadcrumbs').wrap('<div id="breadcrumbs-container" class="header-sortable-container"></div>');
				jQuery('#navigation').wrap('<div id="navigation-container" class="header-sortable-container"></div>');
				jQuery('#header').wrap('<div id="header-container" class="header-sortable-container"></div>');
				
				if(jQuery('#header-sortable-container').length > 0){
					jQuery('#header-sortable-container').prependTo('div#headway-visual-editor');
				} else {
					jQuery('div#headway-visual-editor').prepend('<div id="header-sortable-container"></div>');
				}
				

				jQuery('div#header-container').attr('rel', 'headerOrder_header');
				jQuery('div#navigation-container').attr('rel', 'headerOrder_navigation');
				jQuery('div#breadcrumbs-container').attr('rel', 'headerOrder_breadcrumbs');

				jQuery('.header-sortable-container').appendTo('div#header-sortable-container');
				
				jQuery('.header-sortable-container').addClass('header-sortable');
				jQuery('.header-sortable-container > div').removeClass('header-sortable').attr('rel', '');
		

				jQuery('#header').css('float', 'none');
				jQuery('#navigation').css('float', 'none');
				jQuery('#breadcrumbs').css('float', 'none');
				
				
				if(jQuery('#header-sortable-container').sortable().length > 0){
					jQuery('#header-sortable-container').sortable('destroy');
				
					jQuery('#header-sortable-container').sortable( {
						opacity:  0.75,
						forcePlaceholderSize: true,
						items: 'div.header-sortable',
						axis: 'y',
						scroll: false,
						update: function(){ 
							var header_order = jQuery('#header-sortable-container').sortable('serialize', {attribute: 'rel'}); 
							jQuery('#header-order').attr('value', header_order);
						}
					});
				}
				

				header_fluid_switch = true;
				header_fixed_switch = false;
			}

		});

		jQuery('#header-style-fixed').click(function(){
			noLeaveVisualEditor();
			
			if(!header_fixed_switch){
				jQuery('body').addClass('header-fixed');
				jQuery('body').removeClass('header-fluid');
				
				jQuery('div#header').addClass('header-sortable').attr('rel', 'headerOrder_header');
				jQuery('div#navigation').addClass('header-sortable').attr('rel', 'headerOrder_navigation');
				jQuery('div#breadcrumbs').addClass('header-sortable').attr('rel', 'headerOrder_breadcrumbs');
				

				if(jQuery('#header-sortable-container').length > 0){
					jQuery('#header-sortable-container').prependTo('div#wrapper');
				} else {
					jQuery('div#wrapper').prepend('<div id="header-sortable-container"></div>');
				}
				

				jQuery('.header-sortable').prependTo('div#header-sortable-container');
				
				jQuery('.header-sortable-container').remove();


				jQuery('#header').css('float', 'left');
				jQuery('#navigation').css('float', 'left');
				jQuery('#breadcrumbs').css('float', 'left');
				
				if(jQuery('#header-sortable-container').sortable().length > 0){
					jQuery('#header-sortable-container').sortable('destroy');
				
					jQuery('#header-sortable-container').sortable( {
						opacity:  0.75,
						forcePlaceholderSize: true,
						items: 'div.header-sortable',
						axis: 'y',
						scroll: false,
						update: function(){ 
							var header_order = jQuery('#header-sortable-container').sortable('serialize', {attribute: 'rel'}); 
							jQuery('#header-order').attr('value', header_order);
						}
					});
				}


				header_fixed_switch = true;
				header_fluid_switch = false;
			}

		});
		/* End (Header Style) */
		
		/* Header Arrange */
		jQuery('#toggle-header-arrange').toggle(function(){
			
			
			if(jQuery('body').hasClass('header-fluid')){
				jQuery('div#header-container').addClass('header-sortable').attr('rel', 'headerOrder_header');
				jQuery('div#navigation-container').addClass('header-sortable').attr('rel', 'headerOrder_navigation');
				jQuery('div#breadcrumbs-container').addClass('header-sortable').attr('rel', 'headerOrder_breadcrumbs');

				if(!jQuery('div#header-sortable-container').length > 0){
					jQuery('div#headway-visual-editor').prepend('<div id="header-sortable-container"></div>');

					jQuery('.header-sortable').appendTo('div#header-sortable-container');
				}
			} else {
				jQuery('div#header').addClass('header-sortable').attr('rel', 'headerOrder_header');
				jQuery('div#navigation').addClass('header-sortable').attr('rel', 'headerOrder_navigation');
				jQuery('div#breadcrumbs').addClass('header-sortable').attr('rel', 'headerOrder_breadcrumbs');

				if(!jQuery('div#header-sortable-container').length > 0){
					jQuery('div#wrapper').prepend('<div id="header-sortable-container"></div>');

					jQuery('.header-sortable').appendTo('div#header-sortable-container');
				}
			}
			

			jQuery('#header-sortable-container').sortable( {
				opacity:  0.75,
				forcePlaceholderSize: true,
				items: 'div.header-sortable',
				axis: 'y',
				scroll: false,
				update: function(){ 
					var header_order = jQuery('#header-sortable-container').sortable('serialize', {attribute: 'rel'}); 
					jQuery('#header-order').attr('value', header_order);
					
					noLeaveVisualEditor();
				}
			});

			jQuery('div#header-sortable-container div.header-sortable').css('cursor', 'move');

			jQuery(this).text('Disable Header Rearranging');


			return false;
		}, function(){
			jQuery('#header-sortable-container').sortable('destroy');

			jQuery(this).text('Enable Header Rearranging');

			jQuery('div#header-sortable-container div.header-sortable').css('cursor', 'pointer');


			return false;
		});
		/* End (Header Arrange) */
		
	/* End (Header) */
	
	
	/* Body */
		jQuery('a#upload-body-background-image').click(function(){
			jQuery('div#body-background-uploader-box').show();
		});
		
		
		if(!disable_site_config){
			jQuery('input#body-background-uploader').uploadify({
				'uploader'  : theme_url+'/library/resources/uploadify/uploadify.swf',
				'script'    : theme_url+'/library/visual-editor/lib/upload-background.php',
				'cancelImg' : theme_url+'/library/resources/uploadify/cancel.png',
				'buttonImg' : theme_url+'/library/visual-editor/images/header_uploader.jpg',
				'rollover'  : true,
				'auto'      : true,
				'folder'    : 'body-uploads',
				onComplete: function(event, queueID, fileObj, response, data){
					jQuery('#body-background-image-current').text(fileObj.name);
					jQuery('#body-background-image-current-row').show();
					
					background_image_url = blog_url + '/wp-content/uploads/headway/background-uploads/' + escape(fileObj.name);
										
					jQuery('body').css('backgroundImage', 'url(' + background_image_url + ')');
					
					jQuery('input#body-background-image-hidden').attr('value', fileObj.name);
					
					noLeaveVisualEditor();
					
				} 
			});
			
			jQuery('input#background-repeat').click(function(){
				jQuery('body').css('backgroundRepeat', 'repeat');
			});
			
			jQuery('input#background-repeat-x').click(function(){
				jQuery('body').css('backgroundRepeat', 'repeat-x');
			});
			
			jQuery('input#background-repeat-y').click(function(){
				jQuery('body').css('backgroundRepeat', 'repeat-y');
			});
			
			jQuery('input#background-no-repeat').click(function(){
				jQuery('body').css('backgroundRepeat', 'no-repeat');
			});
			
			jQuery('#body-background-image-delete').click(function(){
				if(confirm('Are you sure?') == true){
					jQuery('#body-background-image-current').text('');
					jQuery('#body-background-image-current-row').hide();

					jQuery('#body-background-image-hidden').attr('value', 'DELETE');

					jQuery('body').css('backgroundImage', 'url()');
				}
			});
			
		}
	
	/* End (Body) */


	/* Navigation */
		dragged = false;
		count = -1;
		this_array_stored = Array();
		
		
		function serialize_navigation(){
			jQuery('#header-navigation ul, #header-navigation').reverse().each(function(){
				parent_id = jQuery(this).parent().attr('id');
	
				this_array = str_replace(jQuery(this).sortable('serialize'), '&page[]=', '|');
				this_array = str_replace(this_array, 'page[]=', '');  

				count = count + 1;
				this_array_stored.push(this_array);

				if(this_array_stored[count-1]){
					this_cleaned_nav_order = removeBlankArrayItems(this_array_stored[count].replace(this_array_stored[count-1], '').split('|'));
				}
				else {
					this_cleaned_nav_order = removeBlankArrayItems(this_array_stored[count].split('|'));
				}

				
				if(jQuery('input#navigation-order-'+parent_id).length == 0 && parent_id != 'navigation'){
					jQuery('div#headway-visual-editor').prepend('<input type="hidden" value="" class="headway-visual-editor-input" name="nav_order[child]['+parent_id+']" id="navigation-order-'+parent_id+'" />');
				}
				
			
				if(parent_id != 'navigation'){
					jQuery('input#navigation-order-'+parent_id).attr('value', this_cleaned_nav_order.join('|'));
				} else {
					jQuery('#navigation-order').attr('value', this_cleaned_nav_order.join('|'));
				}
			
			});
		}
		
		
		function start_nav_sortable(){
			jQuery('ul.navigation, #inactive-navigation, ul.navigation ul').sortable( {
				items: 'li:not(.page-item-1)',
				opacity:  0.75,
				connectWith: '.navigation, .navigation ul',
				forcePlaceholderSize: true,
				forceHelperSize: true,
				scroll: false,
				tolerance: 'mouse',
				start: function(event, ui) { 
					dragged = true;
				},
				stop: function(event, ui) {
					setTimeout(function(){
						dragged = false;
					}, 50);
				},
				update: function(){ 	
														
					serialize_navigation();
					
					var navigation_order_inactive = removeBlankArrayItems(str_replace(str_replace(jQuery('#inactive-navigation').sortable('serialize'), '&page[]=', '|'), 'page[]=', '|').split('|')).join('|');	
					jQuery('#navigation-order-inactive').attr('value', navigation_order_inactive);
	
				}
			});
		}
		
		function navigation_item_click(e){
			if(e.parent().hasClass('current_page_item') || e.parent().hasClass('current_page_parent') || e.parent().hasClass('current_page_ancestor')){
				nav_id = e.parent().attr('class').split(' ').slice(0, 1);
			} else {
				nav_id = e.parent().attr('class').split(' ').slice(-1);
			}
			nav_name = escape(e.text());

			if(jQuery('div#navigation-control-' + nav_id).length > 0){ jQuery('div#navigation-control-' + nav_id).show(); }
			else { load_navigation_item_options(nav_id, nav_name); }

			return false;
		}
	
		jQuery('ul.navigation li:not(.page-item-1) a').bind('dblclick', function(e){
			navigation_item_click(jQuery(this));
		});
	
	
		jQuery('#toggle-navigation').toggle(function(){
			jQuery('body').addClass('nav-reorder');
			
			start_nav_sortable();

			jQuery("ul.navigation li a").unbind('dblclick');			
			jQuery("ul.navigation li a").unbind('click');			
			
			jQuery('ul.navigation li a').dblclick(function(){
				if(jQuery(this).parent().find('ul').hasClass('hover')){
					jQuery(this).parent().find('ul').removeClass('hover').removeClass('show');
				} else {
					jQuery(this).parent().find('ul').addClass('hover').addClass('show');		
				}
				
				return false;
			});
			jQuery('ul.navigation li a').click(function(){
				if(jQuery(this).siblings('ul').length == 0 && !dragged){
					jQuery(this).parent().append('<ul></ul>');
					jQuery(this).siblings('ul').addClass('show').addClass('hover');
					
					start_nav_sortable();
				}
				
				return false;
			});
			
			
			jQuery('ul.navigation li').each(function(){
				this_li = jQuery(this);
								
				if(!this_li.attr('id')){
					nav_id = this_li.attr('class').split(' ')[1].replace('-item', '');
					
					this_li.attr('id', nav_id);
				}
				
			});
			
			
			
			jQuery('ul.navigation li').css('cursor', 'move');

			jQuery(this).text('Disable');

			return false;
		}, function(){
			jQuery('body').removeClass('nav-reorder');
			
			jQuery('ul.navigation').sortable('destroy');
			jQuery(this).text('Enable');
			
			jQuery('ul.navigation li a').unbind('dblclick');
			jQuery('ul.navigation li a').unbind('click');

			jQuery('ul.navigation li:not(.page-item-1) a').bind('dblclick', function(e){
				navigation_item_click(jQuery(this));
			});

			if(typeof visual_editor != 'undefined'){
				if(visual_editor){
					registerElementClick('ul.navigation li a', 'Navigation Item', "Edit the navigation item color, background, and border.");
				}
			}
						
			jQuery('ul.navigation li a').bind('click', function(e){
				return false;
			});
			
			jQuery('ul.navigation ul.show').removeClass('show');

			jQuery('ul.navigation li').css('cursor', 'pointer');


			return false;
		});
		

	
		function load_navigation_item_options(nav_id, nav_name){
			jQuery('div#headway-visual-editor').append('<div id="navigation-control-' + nav_id + '" class="floaty-box navigation-item-options"><p class="loading"><img src="' + theme_url + '/media/images/loading.gif" class="loading-image" /></p></div>');
			jQuery('div#navigation-control-' + nav_id).load(blog_url+'/?headway-ajax-loader=true&nav-item=' + nav_id + '&nav-item-name='+nav_name, false, function(){
				prepare_navigation_item_options(nav_id, nav_name);
			});
		}
		
		
		function prepare_navigation_item_options(nav_id){
			height = jQuery('div#navigation-control-'+nav_id).height();
			jQuery('div#navigation-control-'+nav_id).resizable({minWidth: 350, minHeight: 150});
			jQuery('div#navigation-control-'+nav_id).draggable({ 
				opacity: 0.35, 
				handle:'h4.floaty-box-header',
				containment: 'window'
			});

			jQuery('div#navigation-control-'+nav_id+' div.tabs').tabs();

			jQuery('div#navigation-control-'+nav_id+' h4.floaty-box-header').append('<a class="close window-top-right" href="#">X</a>');

			jQuery('div#navigation-control-'+nav_id+' h4.floaty-box-header a.close').click(function(){
				jQuery(this).parent().parent().hide();
				return false;
			});

			jQuery('div#navigation-control-'+nav_id+' input#nav_item_'+nav_id+'_name').bind('keyup keydown blur', function(e){
				this_value = jQuery(this).val();
				this_h4 = jQuery('div#navigation-control-'+nav_id+' > h4.floaty-box-header span');
				this_link = jQuery('li.'+nav_id+' > a');

				if(this_value == '') this_value = 'Navigation Item';
				
				this_link.text(this_value);
				this_h4.text(this_value);
			});

		}
	/* End (Navigation) */
	
	
	/* Footer */
		jQuery('input#show-admin-link').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('a#footer-admin-link').show();
			}
			else
			{
				jQuery('a#footer-admin-link').hide();
			}
		});
		
		jQuery('input#show-edit-link').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('a#footer-edit-link').show();
			}
			else
			{
				jQuery('a#footer-edit-link').hide();
			}
		});
		
		jQuery('input#show-copyright').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('p#footer-copyright').show();
			}
			else
			{
				jQuery('p#footer-copyright').hide();
			}
		});
		
		jQuery('input#show-go-to-top-link').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('a#footer-go-to-top-link').show();
			}
			else
			{
				jQuery('a#footer-go-to-top-link').hide();
			}
		});
	
	
		jQuery('input#hide-headway-attribution').click(function(){
			if(jQuery(this).is(':checked')){
				jQuery('p#footer-headway-link').hide();
			}
			else
			{
				jQuery('p#footer-headway-link').show();
			}
		});
	
		/* Header Style */
		footer_fluid_switch = false;
		footer_fixed_switch = false;

		jQuery('#footer-style-fluid').click(function(){
			noLeaveVisualEditor();
			
			if(!footer_fluid_switch){
				jQuery('body').addClass('footer-fluid');
				jQuery('body').removeClass('footer-fixed');


				jQuery('div#footer').appendTo('div#headway-visual-editor');
				jQuery('div#footer').wrap('<div id="footer-container"></div>');




				footer_fluid_switch = true;
				footer_fixed_switch = false;
			}

		});

		jQuery('#footer-style-fixed').click(function(){
			noLeaveVisualEditor();
			
			if(!footer_fixed_switch){
				jQuery('body').addClass('footer-fixed');
				jQuery('body').removeClass('footer-fluid');


				jQuery('#footer').appendTo('div#wrapper');
				jQuery('#footer-container').remove();


				footer_fixed_switch = true;
				footer_fluid_switch = false;
			}

		});
		/* End (Header Style) */
		
		jQuery('#navigation-position-left').click(function(){
			noLeaveVisualEditor();
			
			if(jQuery('ul.navigation').hasClass('navigation-right')){
				jQuery('ul.navigation').removeClass('navigation-right');
			}
		});
		
		jQuery('#navigation-position-right').click(function(){
			noLeaveVisualEditor();
			
			jQuery('ul.navigation').addClass('navigation-right');
		});

	/* End (Footer) */
	
	
	/* Dimensions */
		jQuery('input#wrapper-width').blur(function(){
			elements = jQuery('div#wrapper, div#header, div#navigation, div#breadcrumbs, div#footer, div#container');
			wrapper_width = parseInt(jQuery(this).val());
			
			if(wrapper_width > 1200){
				wrapper_width = 1200;
				jQuery(this).val(wrapper_width);
			}
			
			if(wrapper_width < 500 || jQuery(this).val() == ''){
				wrapper_width = 500;
				jQuery(this).val(wrapper_width);
			}
			
			elements.css('width', parseInt(jQuery(this).val()));
		});
		jQuery('input#wrapper-margin').blur(function(){
			if(jQuery(this).val() == ''){
				jQuery(this).val('0');
			}
			
			jQuery('div#wrapper').css('margin', jQuery(this).val());
		});
	/* End (Dimensions) */

	

	jQuery('div#floaty-box-loader').fadeOut(200, function(){
		jQuery('div.floaty-box:not(#post-meta-options, #save-box, #floaty-box-loader, #help-box)').fadeIn(200);
	});
	
	jQuery('div#ie-box').fadeIn(200);
});