jQuery(function() {
		jQuery("#tabs").tabs();
		
		jQuery("a.variable").draggable({ revert: true, helper: 'clone', revertDuration: 150, opacity: 0.6, cursor: 'move' });

		jQuery("table#posts-meta-options input").droppable({
			hoverClass: 'input-hover',
			drop: function(event, ui) {
				variable = jQuery(ui.draggable).text();
				this_val = jQuery(this).val();
				jQuery(this).val(this_val + variable + ' ');
			}
		});
		
		jQuery('input#reset-headway').click(function(){
			return confirm('Are you sure you want to reset Headway?  All changes and settings will be lost.');
		});
		
		jQuery('input#reset-leaf-template').click(function(){
			return confirm('Are you sure you want to reset the default leafs?');
		});
	
		jQuery('input#js-jquery').change(function(){
			if(jQuery(this).is(':checked')){
				jQuery('label.dependency-jquery').addClass('dependency-show');
			} else {
				jQuery('label.dependency-jquery').removeClass('dependency-show');
				jQuery('label.dependency-jquery input').attr('checked', false);
			}
		});
		
		jQuery('label.dependency-jquery-ui input').change(function(){
			if(jQuery(this).is(':checked')){
				jQuery('input#js-jquery-ui').attr('checked', true);
			}
		});
		
		jQuery('label.dependency-jquery-ui-draggable input').change(function(){
			if(jQuery(this).is(':checked')){
				jQuery('input#js-jquery-ui-draggable').attr('checked', true);
			}
		});
		
		jQuery('label.dependency-jquery-ui-droppable input').change(function(){
			if(jQuery(this).is(':checked')){
				jQuery('input#js-jquery-ui-droppable').attr('checked', true);
			}
		});
		
		jQuery('label.dependency-prototype input').change(function(){
			if(jQuery(this).is(':checked')){
				jQuery('input#js-prototype').attr('checked', true);
			}
		})
});