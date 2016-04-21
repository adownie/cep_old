jQuery(function(){
	
	function ready_leafs(leaf){
		leaf_nonobject = leaf;
		leaf = jQuery(leaf);
		
		leaf.css('position', 'relative');
		leaf.prepend('<div class="leaf-icon-container"><a href="" title="This is the ID of the leaf, which is used for duplicate sidebars and advanced coding." class="tooltip leaf-id"></a><div class="leaf-icon"></div></div>');
		leaf.prepend('<div class="leaf-control"><a class="leaf-height leaf-height-fluid tooltip" href="" title="Toggle fluid height of leaf.">Fluid Height</a><a class="leaf-align headway-leaf-right-enabled tooltip" href="" title="Toggle align to right.">Align Right</a><a class="edit tooltip" href="" title="Open the options for this leaf.">Edit</a><a class="delete tooltip" href="" title="Delete this leaf.">Delete</a></div><a href="#" class="precise-resize">Precise Resize</a>');
		leaf.each(function(){
			leaf_id = jQuery(this).attr('id').replace('leaf-', '');
			
			leaf_type = jQuery(this).attr('class').split(' ');
			leaf_type = leaf_type[0];

			leaf_icon = jQuery('a#add-'+leaf_type).siblings('img').attr('src');
			
			//If leaf type doesn't exist, show an X to show there's an error.
			if(typeof leaf_icon == 'undefined'){
				leaf_icon = theme_url+'/library/visual-editor/images/question_mark.png';
				
				jQuery('#leaf-'+leaf_id+' .leaf-control a:not(.delete)').css({ 'position':'absolute', 'top':'-9999px', 'left':'-9999px'});
				jQuery('#leaf-'+leaf_id+' .leaf-control').css('width', '16px');
			}
			
			jQuery('#leaf-'+leaf_id+' .leaf-icon').html('<img src="' + leaf_icon + '" width="16px" height="16px" />');

			
			jQuery('#leaf-'+leaf_id+' .leaf-id').text(leaf_id).click(function(){ return false; });
			
			url = blog_url+'/?headway-ajax-loader=true&id=' + leaf_id + '&request=leaf-sizes&callback=?';
			
			jQuery('#leaf-'+leaf_id+' .tooltip').tooltip({track: true, delay: 0, showURL: false, fade: 250,extraClass: "leaf-tooltip"});
			
			sizing = 'reset';
			
			jQuery.ajax({
			  url: url,
			  async: false,
			  dataType: 'json',
			  success: function (data) {
			    sizing = data;
			  }
			});	
							
			size = new Object;
			
			if(typeof sizing == 'undefined' || sizing['new-leaf'] == true){
				size['width'] = jQuery(this).width();
				size['height'] = jQuery(this).css('height').replace('px', '');
			} else {
				size['width'] = sizing['width'];
				size['height'] = sizing['height'];
			}
						
					
			jQuery(this).append('\
			<div class="leaf-dimensions">\
				<div class="dimension dimension-width">\
					<label for="' + jQuery(this).attr('id') + '_width">Width</label>\
					<input type="text" id="' + jQuery(this).attr('id') + '_width" name="dimensions[' + jQuery(this).attr('id') + '][width]" value="' + size['width'] + '" class="width-input headway-visual-editor-input" />\
					<span>px</span>\
				</div>\
				<div class="dimension dimension-height">\
					<label for="' + jQuery(this).attr('id') + '_height">Height</label>\
					<input type="hidden" id="' + jQuery(this).attr('id') + '_height_changed" name="dimensions[' + jQuery(this).attr('id') + '][height-changed]" value="false" class="headway-visual-editor-input" />\
					<input type="text" id="' + jQuery(this).attr('id') + '_height" name="dimensions[' + jQuery(this).attr('id') + '][height]" value="' + size['height'] + '" class="height-input headway-visual-editor-input" />\
					<span>px</span>\
				</div>\
			</div>');
			
			fluid_height_value = '';
			align_right_value = '';
			
			if(jQuery(this).hasClass('fluid-height')){
				fluid_height_value = 'true';
			}
			
			if(jQuery(this).hasClass('headway-leaf-right')){
				align_right_value = 'true';
			}
			
			jQuery(this).append('\
				<input type="hidden" name="leaf-switches[' + jQuery(this).attr('id') + '][fluid-height]" value="' + fluid_height_value + '" id="' + jQuery(this).attr('id') + '_fluid_height" class="headway-visual-editor-input" />\
				<input type="hidden" name="leaf-switches[' + jQuery(this).attr('id') + '][align-right]" value="' + align_right_value + '" id="' + jQuery(this).attr('id') + '_align_right" class="headway-visual-editor-input" />');
			
			title_value = jQuery(this).children('.leaf-top').text();
			
			if(jQuery(this).children('.leaf-top').length > 0){
				jQuery(this).children('.leaf-top').attr('title', 'Double-click to edit title.').addClass('tooltip').tooltip({track: true, delay: 0, showURL: false, fade: 250, positionLeft: false, extraClass: 'tooltip-default'});
				
				jQuery(this).prepend('<input type="text" value="' + title_value + '" id="' + jQuery(this).attr('id') + '_title" name="title[' + jQuery(this).attr('id') + ']" class="inline-title-edit headway-visual-editor-input" style="display:none;" />');
			}
			
		});
		
		jQuery('div.headway-leaf-right a.leaf-align').removeClass('headway-leaf-right-enabled');
		jQuery('div.fluid-height a.leaf-height').removeClass('leaf-height-fluid');

		jQuery(leaf_nonobject+' .leaf-height').click(function(){
			this_leaf = jQuery(this).parent().parent();
			
			if(this_leaf.hasClass('.fluid-height')){
				this_leaf.removeClass('fluid-height');	
				jQuery('#'+this_leaf.attr('id') + '_fluid_height').attr('value', 'false');
				jQuery(this).addClass('leaf-height-fluid');
			} else {
				this_leaf.addClass('fluid-height');
				jQuery(this).removeClass('leaf-height-fluid');
				jQuery('#'+this_leaf.attr('id') + '_fluid_height').attr('value', 'true');
			}
			
			noLeaveVisualEditor();
					
			return false;
		});



		jQuery(leaf_nonobject+' .leaf-align').click(function(){
			if(jQuery(this).hasClass('headway-leaf-right-enabled')){
				jQuery(this).parent().parent().addClass('headway-leaf-right');
				jQuery(this).removeClass('headway-leaf-right-enabled');
				jQuery('#' + jQuery(this).parent().parent().attr('id') + '_align_right').attr('value', 'true');
				
			} else {
				jQuery(this).parent().parent().removeClass('headway-leaf-right');	
				jQuery(this).addClass('headway-leaf-right-enabled');
				jQuery('#' + jQuery(this).parent().parent().attr('id') + '_align_right').attr('value', 'false');
			}
			
			noLeaveVisualEditor();
			
			return false;
		});


		leaf.hoverIntent({
			sensitivity: 5, 
			interval: 50, 
			over: function(){
				jQuery(this).children('.leaf-control').fadeIn(200);
				jQuery(this).children('.leaf-icon-container').fadeIn(200);
			}, 
			timeout: 50,
			out: function(){
				jQuery(this).children('.leaf-control').fadeOut(200);
				jQuery(this).children('.leaf-icon-container').fadeOut(200);
			}
		});


		jQuery(leaf_nonobject+' .leaf-control .delete').click(function(){
			leaf = jQuery(this).parent().parent();
			if(confirm('Are you sure you want to delete this leaf?') == true){
				leaf.remove();
				jQuery('div#control-'+leaf.attr('id')).remove();
				
				if(jQuery('#'+leaf.attr('id')+'_add').length > 0){
					jQuery('#'+leaf.attr('id')+'_add').remove();
				}
				
				
				var order = jQuery('#container').sortable('serialize'); 
				if(!order){
					jQuery('#container').sortable( {
						opacity:  0.35,
						forcePlaceholderSize: true,
						items: 'div.headway-leaf',
						scroll: false,
						tolerance: 'pointer',
						containment: 'window',
						update: function(){ 
							var order = jQuery('#container').sortable('serialize'); 
							jQuery('#layout-order').attr('value', order);
							
							noLeaveVisualEditor();
						}
					});
					order = jQuery('#container').sortable('serialize'); 
				}
				jQuery('#layout-order').attr('value', order);
				
				jQuery("#headway-visual-editor").prepend('<input type="hidden" class="headway-visual-editor-input" name="delete['+leaf.attr('id')+']" id="'+leaf.attr('id')+'_delete" value="true" />');
				
			}
			
			noLeaveVisualEditor();

			return false;
		});
		
		jQuery(leaf_nonobject+' div.leaf-top').disableSelection();
		jQuery(leaf_nonobject+' div.leaf-top').dblclick(function(){
			parent = jQuery(this).parent();
			parent_id = parent.attr('id');
			
			parent.children('div.leaf-control, div.leaf-icon-container').css('top', '-9999px');
			
			if(jQuery('#' + parent_id + '_title').length == 0){
				this_value = jQuery(this).text();

				jQuery(this).hide().addClass('title-edit');
				
				jQuery(parent).prepend('<input type="text" value="' + this_value + '" id="' + parent_id + '_title" name="title[' + parent_id + ']" class="inline-title-edit headway-visual-editor-input" />');
								
				jQuery('div.headway-leaf input.inline-title-edit').focus();

				jQuery('div.headway-leaf input.inline-title-edit').blur(function(){
					this_value = jQuery(this).val();
					jQuery(this).hide();

					if(jQuery(this).siblings('div.leaf-top').find('a').length > 0){
						jQuery(this).siblings('div.leaf-top').find('a').html(this_value);
						jQuery(this).siblings('div.leaf-top').show();
					} else {
						jQuery(this).siblings('div.leaf-top').text(this_value).show();
					}
					
					parent.children('div.leaf-control, div.leaf-icon-container').css('top', 'auto');
					
					
				});
			}
			else
			{
				jQuery('div.headway-leaf input.inline-title-edit').focus();

				jQuery('div.headway-leaf input.inline-title-edit').blur(function(){
					noLeaveVisualEditor();
					
					this_value = jQuery(this).val();
					jQuery(this).hide();

					if(jQuery(this).siblings('div.leaf-top').find('a').length > 0){
						jQuery(this).siblings('div.leaf-top').find('a').html(this_value);
						jQuery(this).siblings('div.leaf-top').show();
					} else {
						jQuery(this).siblings('div.leaf-top').text(this_value).show();
					}
					
					parent.children('div.leaf-control, div.leaf-icon-container').css('top', 'auto');
					
				});
				
				jQuery(this).hide();
				jQuery('#' + parent_id + '_title').show().focus();

			}
		});


		jQuery(leaf_nonobject+' .width-input').blur(function(){
			noLeaveVisualEditor();
			
			value = jQuery(this).val();
			
			if(parseInt(value) > parseInt(wrapper_width)-20){
				value = wrapper_width-20;
				jQuery(this).val(value);
			}
			
			leaf = jQuery(this).parent().parent().parent();

			leaf.css('width', value+'px');
			leaf.css('minWidth', value+'px');			
		});
		jQuery(leaf_nonobject+' .height-input').blur(function(){
			noLeaveVisualEditor();
			
			value = jQuery(this).val();
			leaf = jQuery(this).parent().parent().parent();
			
			jQuery('#'+jQuery(this).attr('id') + '_changed').val('true');

			leaf.css('height', value+'px');
			leaf.css('minHeight', value+'px');
		});

		
		jQuery(leaf_nonobject+' .leaf-control .edit').click(function(){
			leaf_id = jQuery(this).parent().parent().attr('id');	

			if(jQuery('div#control-' + leaf_id).length > 0){
				jQuery('div#control-' + leaf_id).show();
			}
			else {
				
				leaf_type = jQuery('div#' + leaf_id).attr('class').split(' ');				
				load_leaf_options(leaf_id, leaf_type[0]);
				
			}

			return false;
		});

		function bind_precise_resize(){
			jQuery(leaf_nonobject+' a.precise-resize').click(function(){
				this_leaf = jQuery(this).parent();
				this_dimensions = jQuery(this).siblings('div.leaf-dimensions');

				if(this_dimensions.length > 0){
					this_dimensions.show();	
				} else {
					this_leaf.append('\
						<div class="leaf-dimensions">\
							<div class="dimension dimension-width">\
								<label for="' + this_leaf.attr('id') + '_width">Width</label>\
								<input type="text" id="' + this_leaf.attr('id') + '_width" name="dimensions[' + this_leaf.attr('id') + '][width]" value="' + this_leaf.width() + '" class="width-input headway-visual-editor-input" />\
							</div>\
							<div class="dimension dimension-height">\
								<label for="' + this_leaf.attr('id') + '_height">Height</label>\
								<input type="text" id="' + this_leaf.attr('id') + '_height" name="dimensions[' + this_leaf.attr('id') + '][height]" value="' + this_leaf.height() + '" class="height-input headway-visual-editor-input" />\
							</div>\
						</div>');
				}

				jQuery(this).hide();

				return false;
			});
		}

		bind_precise_resize();
		
		if(jQuery('#container').hasClass('resize-container')){
			width = parseInt(jQuery('div#container').width())-30;
			leaf.resizable({
				maxWidth: width,
				resize: function(event, ui) { 
					this_id = jQuery(this).attr('id');
					width = ui.size.width;
					height = ui.size.height;
			
					jQuery(this).css('minWidth', width);
					jQuery(this).css('minHeight', height);
			
					jQuery('#' + jQuery(this).attr('id') + '_width').attr('value', ui.size.width);
					jQuery('#' + jQuery(this).attr('id') + '_height').attr('value', ui.size.height);
										
					jQuery('#' + jQuery(this).attr('id') + '_height_changed').attr('value', 'true');
					
					noLeaveVisualEditor();
					
				}
			});
			leaf.addClass('resize');

			jQuery('div#container '+ leaf_nonobject +' a.precise-resize').show();
		}
		
		disable_enter(); 

	}
	
	if(link == 'false'){
		ready_leafs('.headway-leaf');
	}
	
	function prepare_leaf_options(leaf_id, leaf_width){
		height = jQuery('div#control-'+leaf_id).height();
		
		jQuery('div#control-'+leaf_id).width(parseInt(leaf_width));
		jQuery('div#control-'+leaf_id).resizable({minWidth: leaf_width, minHeight: 200, alsoResize: 'div#control-'+leaf_id+' tr.textarea textarea, div#control-'+leaf_id+' ul.tabs'});
		jQuery('div#control-'+leaf_id).draggable({ 
			opacity: 0.35, 
			stack: { group: '.floaty-box', min: 9999 }, 
			handle:'h4.floaty-box-header',
			containment: 'window'
		});
		
		jQuery('div#control-'+leaf_id+' div.tabs').tabs();
	
		jQuery('div#control-'+leaf_id+' h4.floaty-box-header').append('<a class="close window-top-right" href="#">X</a>');


		jQuery('div#control-'+leaf_id+' h4.floaty-box-header a.close').click(function(){
			jQuery(this).parent().parent().hide();

			return false;
		});
		
		
		jQuery('div#control-'+leaf_id+' a.rotator-add-image').click(function(){
			table = jQuery(this).parent().parent().parent();
			
			if(jQuery(this).parent().parent().siblings('tr:last').length > 0){
				last_id = jQuery(this).parent().parent().siblings('tr:last').attr('class').replace('image-', '');
			} else {
				last_id = 0;
			}
			image_id = parseInt(last_id) + 1;
			leaf_id = jQuery(this).parent().attr('class');
			
			jQuery('div#control-item_'+leaf_id).css('height', 'auto');
			
			content = '\
				<tr id="' + leaf_id + '_rotator_image_' + image_id + '" class="image-' + image_id + '">\
					<th scope="row"><label for="' + leaf_id + '_rotator_image_' + image_id + '_url">Image ' + image_id + '</label></th>\
					<td>\
						<label for="' + leaf_id + '_rotator_image_' + image_id + '_url">Image URL</label><input type="text" name="leaf-options[' + leaf_id + '][images][' + image_id + '][path]" id="' + leaf_id + '_rotator_image_' + image_id + '_url" value="" class="headway-visual-editor-input" />\
						<label for="' + leaf_id + '_rotator_image_' + image_id + '_hyperlink">Image Hyperlink</label><input type="text" name="leaf-options[' + leaf_id + '][images][' + image_id + '][hyperlink]" id="' + leaf_id + '_rotator_image_' + image_id + '_hyperlink" value="" class="headway-visual-editor-input" />\
					</td>\
					<td>\
						<a href="" title="Delete This Image" class="rotator-delete-image"><img src="' + theme_url + '/library/admin/icons/minus.png" /></a>\
					</td>\
				</tr>';
				
			table.append(content);
			
			jQuery('tr#' + leaf_id + '_rotator_image_' + image_id + ' a.rotator-delete-image').click(function(){
				if(confirm('Are you sure?') == true) jQuery(this).parent().parent().remove();
				return false;
			});
			
			
			return false;
		});
		
		jQuery('div#control-'+leaf_id+' a.rotator-delete-image').click(function(){
			if(confirm('Are you sure?') == true) jQuery(this).parent().parent().remove();
			return false;
		});
	}
	function load_leaf_options(leaf_id, leaf_type, hide){
		if(hide){
			hide = ' style="display: none;"';
		}
		
				
		jQuery('div#headway-visual-editor').prepend('<div id="control-' + leaf_id + '" class="floaty-box leaf-options"' + hide + '><p class="loading"><img src="' + theme_url + '/media/images/loading.gif" class="loading-image" /></p></div>');
		
		jQuery.ajax({
			url: blog_url+'/?headway-ajax-loader=true&leaf=' + leaf_type + '&id=' + leaf_id + '&get-width=true',
			async: false,
			success: function (data) {				
			    leaf_width = data;
			}
		})
		
		if(typeof leaf_width == 'undefined'){
			leaf_width = 350;
		}
		
		jQuery('div#control-' + leaf_id).load(blog_url+'/?headway-ajax-loader=true&leaf=' + leaf_type + '&id=' + leaf_id, false, function(){
			prepare_leaf_options(leaf_id, leaf_width);
		});
		
		disable_enter();
	}

	jQuery('#toggle-resize').toggle(function(){
		width = parseInt(jQuery('div#container').width())-30;
		jQuery('.headway-leaf').resizable({
			maxWidth: width,
			minWidth: 95,
			resize: function(event, ui) { 
				this_id = jQuery(this).attr('id');
				width = ui.size.width;
				height = ui.size.height;

				jQuery(this).css('minWidth', width);
				jQuery(this).css('minHeight', height);

				jQuery('#' + jQuery(this).attr('id') + '_width').attr('value', ui.size.width);
				jQuery('#' + jQuery(this).attr('id') + '_height').attr('value', ui.size.height);
				
				jQuery('#' + jQuery(this).attr('id') + '_height_changed').attr('value', 'true');
				
				noLeaveVisualEditor();
				
			}
		});
		jQuery(this).text('Disable');
		jQuery('.headway-leaf').addClass('resize');
		jQuery('#container').addClass('resize-container');

		jQuery('div#container div.headway-leaf a.precise-resize').show();
		
		return false;
	}, function(){
		jQuery('.headway-leaf').resizable('destroy');
		jQuery(this).text('Enable');
		jQuery('.headway-leaf').removeClass('resize');
		jQuery('#container').removeClass('resize-container');
				
		jQuery('div#container div.headway-leaf a.precise-resize').hide();
		jQuery('div#container div.headway-leaf div.leaf-dimensions').hide();
		
		
		return false;
	});
	jQuery('#toggle-arrange').toggle(function(){		
		jQuery('#container').sortable( {
			opacity:  0.35,
			forcePlaceholderSize: true,
			items: 'div.headway-leaf',
			scroll: false,
			tolerance: 'pointer',
			update: function(){ 
				var order = jQuery('#container').sortable('serialize'); 
				jQuery('#layout-order').attr('value', order);
				
				noLeaveVisualEditor();
			}
		});
		
		jQuery('div#container div.headway-leaf').css('cursor', 'move');
		

		
	
		jQuery(this).text('Disable');

		
		return false;
	}, function(){
		jQuery('#container').sortable('destroy');
		jQuery(this).text('Enable');

		jQuery('div#container div.headway-leaf').css('cursor', 'pointer');
		
		
		return false;
	});

		
	jQuery('ul.add-leafs li a').click(function(){
		noLeaveVisualEditor();
		
		leaf_nice_type = jQuery(this).siblings('span').text().replace(' Leaf', '');
		leaf_class = jQuery(this).parent().attr('class').replace('add-', '').replace(' alt', '');
				
		last_leaf_id = last_leaf_id + 1;
		
		jQuery('#container').append('<div id="leaf-' + last_leaf_id + '" class="' + leaf_class + ' headway-leaf" style="position: relative; cursor: pointer;">\
			<div class="leaf-top" unselectable="on" style="-moz-user-select: none; cursor: pointer;">' + leaf_nice_type + '</div>\
			\
			<div class="leaf-content" style="cursor: pointer;">\
			\
				Customize the leaf settings to your heart\'s desire then save to view your changes.\
			\
			</div>\
		</div>');
		
		ready_leafs('#leaf-'+last_leaf_id);
		load_leaf_options('leaf-'+last_leaf_id, leaf_class, true);
		
		
		var order = jQuery('#container').sortable('serialize'); 
		if(!order){
			jQuery('#container').sortable( {
				opacity:  0.35,
				forcePlaceholderSize: true,
				items: 'div.headway-leaf',
				scroll: false,
				tolerance: 'pointer',
				containment: 'window',
				update: function(){ 
					var order = jQuery('#container').sortable('serialize'); 
					jQuery('#layout-order').attr('value', order);
					
					noLeaveVisualEditor();
				}
			});
			order = jQuery('#container').sortable('serialize'); 
		}
		
		jQuery('#layout-order').attr('value', order);
		
		jQuery("#headway-visual-editor").prepend('<input type="hidden" name="add[leaf-'+last_leaf_id+']" id="leaf-'+last_leaf_id+'_add" value="' + leaf_class + '" class="headway-visual-editor-input" />');
		
		disable_enter(); 
		
	});

});