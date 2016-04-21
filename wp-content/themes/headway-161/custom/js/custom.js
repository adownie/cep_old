jQuery(function() {
    jQuery("form").submit(function(e) {
        if (jQuery("input#send_to_mailchimp").is(":checked")) {  
                        
            jQuery.post("/wp-content/themes/headway-161/custom/_capture.php", jQuery(this).serialize());
        } else {
            return true;
        }
    });
    
});
 jQuery(function() {
	var linksList = jQuery("#navigation").html();
	jQuery("#here").html(linksList);

 });

