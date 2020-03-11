jQuery(document).ready(function() {
	
	jQuery(".imic-border-top, .imic-border-right, .imic-border-bottom, .imic-border-left, .imic-border-all").numeric();

	jQuery(".imic-border-style").select2({
		triggerChange: true,
		allowClear: true
	});

	jQuery('.imic-border-input').on('change', function() {
		var units = jQuery(this).parents('.imic-field:first').find('.field-units').val();
		if ( jQuery(this).parents('.imic-field:first').find('.imic-border-units').length !== 0 ) {
			units = jQuery(this).parents('.imic-field:first').find('.imic-border-units option:selected').val();
		}
		var value = jQuery(this).val();
		if( typeof units !== 'undefined' && value ) {
			value += units;
		}
		if ( jQuery(this).hasClass( 'imic-border-all' ) ) {
			jQuery(this).parents('.imic-field:first').find('.imic-border-value').each(function() {
				jQuery(this).val(value);
			});
		} else {
			jQuery('#'+jQuery(this).attr('rel')).val(value);
		}
	});
	jQuery('.imic-border-units').on('change', function() {
		jQuery(this).parents('.imic-field:first').find('.imic-border-input').change();
	});

});