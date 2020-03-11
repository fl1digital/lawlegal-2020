jQuery(document).ready(function() {

	jQuery('.sub-nav .column').hide(); 
	jQuery('.sub-nav h3:first').addClass('active').next().show(); 
	jQuery('.sub-nav h3').click(function(){
		if( jQuery(this).next().is(':hidden') ) {
			jQuery('.sub-nav h3').removeClass('active').next().slideUp(); 
			jQuery(this).toggleClass('active').next().slideDown(); 
		}
		return false; 
	});

});