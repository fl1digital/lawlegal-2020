jQuery(document).ready(function() {
	
	jQuery(".imic-dimensions-height, .imic-dimensions-width").numeric();

	jQuery(".imic-dimensions-units").select2({
		width: 'resolve',
		triggerChange: true,
		allowClear: true
	});

	jQuery('.imic-dimensions-input').on('change', function() {
		var units = jQuery(this).parents('.imic-field:first').find('.field-units').val();
		if ( jQuery(this).parents('.imic-field:first').find('.imic-dimensions-units').length !== 0 ) {
			units = jQuery(this).parents('.imic-field:first').find('.imic-dimensions-units option:selected').val();
		}
		if( typeof units !== 'undefined' ) {
			jQuery('#'+jQuery(this).attr('rel')).val(jQuery(this).val()+units);
		} else {
			jQuery('#'+jQuery(this).attr('rel')).val(jQuery(this).val());
		}
	});

	jQuery('.imic-dimensions-units').on('change', function() {
		jQuery(this).parents('.imic-field:first').find('.imic-dimensions-input').change();
	});

});