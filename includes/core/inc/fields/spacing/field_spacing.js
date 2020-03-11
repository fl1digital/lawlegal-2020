jQuery(document).ready(function() {
	
	jQuery(".imic-spacing-top, .imic-spacing-right, .imic-spacing-bottom, .imic-spacing-left, .imic-spacing-all").numeric();

	jQuery(".imic-spacing-units").select2({
		width: 'resolve',
		triggerChange: true,
		allowClear: true
	});

	jQuery('.imic-spacing-input').on('change', function() {
		var units = jQuery(this).parents('.imic-field:first').find('.field-units').val();
		if ( jQuery(this).parents('.imic-field:first').find('.imic-spacing-units').length !== 0 ) {
			units = jQuery(this).parents('.imic-field:first').find('.imic-spacing-units option:selected').val();
		}
		var value = jQuery(this).val();
		if( typeof units !== 'undefined' && value ) {
			value += units;
		}
		if ( jQuery(this).hasClass( 'imic-spacing-all' ) ) {
			jQuery(this).parents('.imic-field:first').find('.imic-spacing-value').each(function() {
				jQuery(this).val(value);
			});
		} else {
			jQuery('#'+jQuery(this).attr('rel')).val(value);
		}
	});
	jQuery('.imic-spacing-units').on('change', function() {
		jQuery(this).parents('.imic-field:first').find('.imic-spacing-input').change();
	});

});