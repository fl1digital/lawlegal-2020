/* global imic_change */
(function($){
    "use strict";
    
    $.imic.multi_text = $.group || {};
	
    $(document).ready(function () {
        //multi text functionality
        $.imic.multi_text();
    });

    $.imic.multi_text = function(){
    	$('.imic-multi-text-remove').live('click', function(){
			imic_change($(this));
			$(this).prev('input[type="text"]').val('');
			$(this).parent().slideUp('medium', function(){$(this).remove();});
		});
		
		$('.imic-multi-text-add').click(function(){
			var new_input = $('#'+$(this).attr('rel-id')+' li:last-child').clone();
			$('#'+$(this).attr('rel-id')).append(new_input);
			$('#'+$(this).attr('rel-id')+' li:last-child').removeAttr('style');
			$('#'+$(this).attr('rel-id')+' li:last-child input[type="text"]').val('');
			$('#'+$(this).attr('rel-id')+' li:last-child input[type="text"]').attr('name' , $(this).attr('rel-name'));
		});
    }

})(jQuery);    
