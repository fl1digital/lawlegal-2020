/*global jQuery, document, imic_opts, ajaxurl */
(function($) {
    'use strict';
    $.imic = $.imic || {};
    $(document).ready(function() {
        $.imic.edd();
    });
    $.imic.edd = function() {
        jQuery('.imic-edd-input').change(function() {
            jQuery(this).parent().find('.imic-edd-status').val('');
        });
        jQuery(document).on("click", ".imic-EDDAction", function(e) {
            e.preventDefault();
            var parent = jQuery(this).parents('.imic-container-edd_license:first');
            var id = jQuery(this).attr('data-id');
            var theData = {};
            parent.find('.imic-edd').each(function() {
                theData[jQuery(this).attr('id').replace(id + '-', '')] = jQuery(this).val();
            });
            theData.edd_action = jQuery(this).attr('data-edd_action');
            theData.opt_name = imic_opts.opt_name;
            jQuery.post(
            ajaxurl, {
                'action': 'imic_edd_' + imic_opts.opt_name + '_license',
                'data': theData
            }, function(response) {
                response = jQuery.parseJSON(response);
                jQuery('#' + id + '-status').val(response.status);
                jQuery('#' + id + '-status_notice').html(response.status);
                if (response.response === "valid") {
                    //jQuery('#'+id+'-notice').switchClass( "big", "blue", 1000, "easeInOutQuad" );
                    jQuery('#' + id + '-notice').attr('class', "imic-info-field imic-success");
                    jQuery('#' + id + '-activate').fadeOut('medium', function() {
                        jQuery('#' + id + '-deactivate').fadeIn().css("display", "inline-block");
                    });
                } else if (response.response === "deactivated") {
                    jQuery('#' + id + '-notice').attr('class', "imic-info-field imic-warning");
                    jQuery('#' + id + '-deactivate').fadeOut('medium', function() {
                        jQuery('#' + id + '-activate').fadeIn().css("display", "inline-block");
                    });
                } else { // Inactive or bad
                    jQuery('#' + id + '-deactivate').fadeOut('medium', function() {
                        jQuery('#' + id + '-notice').attr('class', "imic-info-field imic-critical");
                        jQuery('#' + id + '-activate').fadeIn().css("display", "inline-block");
                    });
                }
            });
        });
    };
})(jQuery);