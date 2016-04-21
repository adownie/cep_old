function registerElementClick(element, nice_name){
	// Make sure the element isn't a div.headway-leaf (leaf).  Otherwise it'll kill the controls due to hierarchy.
	if(!jQuery(element).hasClass('headway-leaf')){
		jQuery(element).hover(function(){
			jQuery('div#inspector').html('<p><strong>' + nice_name + '</strong></p><p class="selector"><b>CSS Selector:</b> <code>' + element + '</code></p>');
		});
	}
	
	jQuery(element).click(function(event){
		design_widget = jQuery('div#design-editor-widget');
		
		if(!jQuery('#inspector-container').hasClass('hidden')){			
			event.stopPropagation();

			form_name = make_form_name(element);
						
			jQuery('div#colors').show();
			jQuery('.colors-inputs').hide();
			jQuery('table#colors-' + form_name).show();
			jQuery('span#colors-heading').text(nice_name);
			
						
			if(jQuery('option#option-'+make_form_name(element)).attr('fonts') == 'true'){
				jQuery('div#fonts').css('display', '');
			}
			else
			{
				jQuery('div#fonts').hide();
			}
			
			
			jQuery('.fonts-inputs').hide();
			jQuery('table#fonts-' + form_name).show();
			jQuery('span#fonts-heading').text(nice_name);
			jQuery('#option-' + form_name).attr('selected', 'selected');
		
			jQuery('p#callout').show();
			
			initiateSidebarScroll();
		}
		
		return false;

	});
}

function get_color_property(element){
	if(element.hasClass('color')) property = 'color';
	if(element.hasClass('background')) property = 'background';
	if(element.hasClass('border')) property = 'borderColor';
	if(element.hasClass('top-border')) property = 'borderTopColor';
	if(element.hasClass('right-border')) property = 'borderRightColor';
	if(element.hasClass('bottom-border')) property = 'borderBottomColor';
	if(element.hasClass('left-border')) property = 'borderLeftColor';
	
	return property;
}

function purge_name_junk(element){
	return element.replace('width-', '')
			  .replace('color-', '')
			  .replace('-bottom-border', '')
			  .replace('-left-border', '')
			  .replace('-top-border', '')
			  .replace('-right-border', '')
			  .replace('-border', '')
			  .replace('-color', '')
			  .replace('-background', '')
			  .replace('font-', '')
			  .replace('-font-family', '')
			  .replace('-font-size', '')
			  .replace('-line-height', '')
			  .replace('-letter-spacing', '')
			  .replace('-text-transform', '')
			  .replace('-font-weight', '')
			  .replace('-font-variant', '');
}


// Bind Font Select
jQuery('#element-selector').change(function(){	
	
		english_name = jQuery(this).find(':selected').text();
		id = jQuery(this).find(':selected').val();
		nice_id = make_form_name(id);
		
		jQuery('div#colors').show();
		jQuery('.colors-inputs').hide();
		jQuery('table#colors-' + nice_id).show();
		jQuery('span#colors-heading').text(english_name);

		if(jQuery('option#option-'+nice_id).attr('fonts') == 'true'){
			jQuery('div#fonts').css('display', '');
		}
		else
		{
			jQuery('div#fonts').hide();
		}

		jQuery('.fonts-inputs').hide();
		jQuery('table#fonts-' + nice_id).show();
		jQuery('span#fonts-heading').text(english_name);

		jQuery('p#callout').show();

});

// Bind Callout Button
jQuery('p#callout a').click(function(){
	jQuery(jQuery('#element-selector :selected').val()).highlightFade({speed: 1000});
	return false;
});


// Go through element select box to bind actions.
jQuery('select#element-selector option:not(#element-selector-blank)').each(function(){
	if(jQuery(this).val() != 'body'){
		registerElementClick(jQuery(this).val(), jQuery(this).text());
	}	
});


// Bind actions to color boxes. 
jQuery('table.colors-inputs input.color-text').blur(function(){
	if(jQuery(this).val().length == 3){
		incomplete = jQuery(this).val().split('');
		hex = incomplete[0]+incomplete[0]+incomplete[1]+incomplete[1]+incomplete[2]+incomplete[2];
	
		jQuery(this).val(hex);
	}
	
	if(jQuery(this).val().length == 2){
		incomplete = jQuery(this).val().split('');
		hex = incomplete[0]+incomplete[1]+incomplete[0]+incomplete[1]+incomplete[0]+incomplete[1];
	
		jQuery(this).val(hex);
	}
	
	if(jQuery(this).val().length == 1){
		incomplete = jQuery(this).val();
		hex = incomplete+incomplete+incomplete+incomplete+incomplete+incomplete;
	
		jQuery(this).val(hex);
	}
	
	//Get the ID only
	element_pre = purge_name_junk(jQuery(this).attr('id'));
	element = jQuery(make_selector_from_form_name(element_pre));
	
	if(element_pre == 'ul-period-navigation-space-li-space-a'){
		element = jQuery('ul.navigation li:not(.current_page_item) a');
	}
	
	
	//Figure Out Which Property
	property = get_color_property(jQuery(this));
	
	jQuery(this).val(jQuery(this).val());
	
	element.css(property, '#'+jQuery(this).val());
	
	
});

jQuery('table.colors-inputs input.color-text').ColorPicker({
		onChange: function(hsb, hex, rgb, el){	
						
			element_pre = purge_name_junk(jQuery(el).attr('id'));
			element = jQuery(make_selector_from_form_name(element_pre));

			if(element_pre == 'ul-period-navigation-space-li-space-a'){
				element = jQuery('ul.navigation li:not(.current_page_item) a');
			}
			
			property = get_color_property(jQuery(el));
			jQuery(el).val(hex);
			
			
			jQuery(element).css(property, '#'+hex);
		},
		onSubmit: function(hsb, hex, rgb, el) {
			element_pre = purge_name_junk(jQuery(el).attr('id'));
			element = jQuery(make_selector_from_form_name(element_pre));

			if(element_pre == 'ul-period-navigation-space-li-space-a'){
				element = jQuery('ul.navigation li:not(.current_page_item) a');
			}

			property = get_color_property(jQuery(el));
			jQuery(el).val(hex);

			element.css(property, '#'+hex)
		
		
			jQuery(el).val(hex);
			jQuery(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			jQuery(this).ColorPickerSetColor(this.value);
			noLeaveVisualEditor();
		}
}).bind('keyup', function(){
		jQuery(this).ColorPickerSetColor(this.value);
	
		element_pre = purge_name_junk(jQuery(this).attr('id'));
		element = jQuery(make_selector_from_form_name(element_pre));
		
		if(element_pre == 'ul-period-navigation-space-li-space-a'){
			element = jQuery('ul.navigation li:not(.current_page_item) a');
		}

		property = get_color_property(jQuery(this));

		element.css(property, '#'+jQuery(this).val());
});


// Bind action to border inputs.
jQuery('table.colors-inputs input.border-width').blur(function(){
	element_pre = purge_name_junk(jQuery(this).attr('id'));
	element = jQuery(make_selector_from_form_name(element_pre));
	
	if(element_pre == 'ul-period-navigation-space-li-space-a'){
		element = jQuery('ul.navigation li:not(.current_page_item) a');
	}
	
	if(jQuery(this).hasClass('border')) property = 'borderWidth';
	if(jQuery(this).hasClass('top-border')) property = 'borderTopWidth';
	if(jQuery(this).hasClass('right-border')) property = 'borderRightWidth';
	if(jQuery(this).hasClass('bottom-border')) property = 'borderBottomWidth';
	if(jQuery(this).hasClass('left-border')) property = 'borderLeftWidth';
			
	element.css(property, jQuery(this).val()+'px');
	
	noLeaveVisualEditor();
});


// Bind selects
jQuery('select.font-select').change(function(){	
	element_pre = purge_name_junk(jQuery(this).attr('id'));
	element = jQuery(make_selector_from_form_name(element_pre));
	
	if(element_pre == 'ul-period-navigation-space-li-space-a'){
		element = jQuery('ul.navigation li:not(.current_page_item) a');
	}
	
	if(jQuery(this).hasClass('font-family')) property = 'fontFamily';
	if(jQuery(this).hasClass('font-size')) property = 'fontSize';
	if(jQuery(this).hasClass('line-height')) property = 'lineHeight';
	if(jQuery(this).hasClass('letter-spacing')) property = 'letterSpacing';
	if(jQuery(this).hasClass('text-transform')) property = 'textTransform';

	
	if(property == 'fontSize' || property == 'lineHeight'){
		value = jQuery(this).val() + 'px';
	} else {
		value = jQuery(this).val();
	}
	
	jQuery(element).css(property, value);
	
	noLeaveVisualEditor();
});


// Bind Font Check Boxes
function font_check_function(input, value){
	element_pre = purge_name_junk(input.attr('id'));
	element = jQuery(make_selector_from_form_name(element_pre));
	
	if(element_pre == 'ul-period-navigation-space-li-space-a'){
		element = jQuery('ul.navigation li:not(.current_page_item) a');
	}
	
	if(input.hasClass('font-weight')) property = 'fontWeight';
	if(input.hasClass('font-variant')) property = 'fontVariant';
					
	if(value == 'normal'){
		input.attr('checked', false);
	} else {
		input.attr('checked', true);
	}
	
	if(property != 'fontFamily'){
		jQuery(element).css(property, value);
	}
	
	noLeaveVisualEditor();
}


jQuery('input.font-check').click(function(){
	element_pre = purge_name_junk(jQuery(this).attr('id'));
	element = jQuery(make_selector_from_form_name(element_pre));
	
	if(element_pre == 'ul-period-navigation-space-li-space-a'){
		element = jQuery('ul.navigation li:not(.current_page_item) a');
	}
	
	if(jQuery(this).hasClass('font-weight')) property = 'fontWeight';
	if(jQuery(this).hasClass('font-variant')) property = 'fontVariant';
	
					
	if(jQuery(this).is(":checked")){
		jQuery(element).css(property, jQuery(this).val());
	} else {     
		jQuery(element).css(property, 'normal');
	}
	
	noLeaveVisualEditor();
});

// Bind Mass Font Select
jQuery('select.mass-font-select').change(function(){
	mass_value = jQuery(this).val();
	
	property = 'fontFamily'; 
	type = 'font-family';

	jQuery('select.'+type+':not(.mass-font-change)').each(function(){
		jQuery(this).val(mass_value).attr("selected", "selected");
		
		element_pre = jQuery(this).attr('id').replace('font-', '').replace('-font-family', '').replace('-font-size', '').replace('-line-height', '');
		element = jQuery(make_selector_from_form_name(element_pre));

		property = 'fontFamily';
		
		value = jQuery(this).val();


		jQuery(element).css(property, value);
	});
	
	noLeaveVisualEditor();
});