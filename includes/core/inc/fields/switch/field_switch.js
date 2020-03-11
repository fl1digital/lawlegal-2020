/* global imic_change */
(function($){
	"use strict";
    
    $.imic = $.imic || {};
	
    $(document).ready(function () {
         $.imic.switch();
    });

    /**
	 * Switch
	 * Dependencies		: jquery
	 * Feature added by	: Smartik - http://smartik.ws/
	 * Date				: 03.17.2013
	 */
    $.imic.switch = function(){
    	$(".cb-enable").click(function() {
			if ($(this).hasClass('selected')) {
				return;
			}
			var parent = $(this).parents('.switch-options');
			$('.cb-disable', parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox-input', parent).val(1);
			imic_change($('.checkbox-input', parent));
			//fold/unfold related options
			var obj = $(this);
			var $fold = '.f_' + obj.data('id');
			$($fold).slideDown('normal', "swing");
		});
		$(".cb-disable").click(function() {
			if ($(this).hasClass('selected')) {
				return;
			}
			var parent = $(this).parents('.switch-options');
			$('.cb-enable', parent).removeClass('selected');
			$(this).addClass('selected');
			$('.checkbox-input', parent).val(0);
			imic_change($('.checkbox-input', parent));
			//fold/unfold related options
			var obj = $(this);
			var $fold = '.f_' + obj.data('id');
			$($fold).slideUp('normal', "swing");
		});
		//disable text select(for modern chrome, safari and firefox is done via CSS)
		//if (($.browser.msie && $.browser.version < 10) || $.browser.opera) { 
		$('.cb-enable span, .cb-disable span').find().attr('unselectable', 'on');
		//}
    }
})(jQuery);