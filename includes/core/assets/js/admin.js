/*global jQuery, document, imic_opts, confirm, relid:true, console, jsonView */
(function($){
	'use strict';
	$.imic = $.imic || {}

	var the_body = $("body");

	$(document).ready(function(){

		jQuery.fn.isOnScreen = function() {
			if (!window) {
				return;
			}
			var win = jQuery(window);
			var viewport = {
				top: win.scrollTop(),
				left: win.scrollLeft()
			};
			viewport.right = viewport.left + win.width();
			viewport.bottom = viewport.top + win.height();
			var bounds = this.offset();
			bounds.right = bounds.left + this.outerWidth();
			bounds.bottom = bounds.top + this.outerHeight();
			return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
		};

		$.imic.required();

		the_body.on('check_dependencies', function(event,variable){		
			$.imic.check_dependencies(event,variable);
        });
	});
	
	$.imic.required = function(){

		// Hide the fold elements on load ,
		// It's better to do this by PHP but there is no filter in tr tag , so is not possible
		// we going to move each attributes we may need for folding to tr tag
		$('.hiddenFold , .showFold').each(function() {
			var current 	= $(this), 
            scope	        = current.parents('tr:eq(0)'),
            check_data      = current.data();

            if(current.hasClass('hiddenFold')){
				scope.addClass('hiddenFold').attr('data-check-field' , check_data.checkField)
					.attr('data-check-comparison' , check_data.checkComparison)
					.attr('data-check-value' , check_data.checkValue)
					.attr('data-check-id' , check_data.id).hide();
				//we clean here, so we won't get confuse 	
				current.removeClass('hiddenFold').removeAttr('data-check-field')
					.removeAttr('data-check-comparison')
					.removeAttr('data-check-value');	
			}else{
				scope.attr('data-check-field' , check_data.checkField)
					.attr('data-check-comparison' , check_data.checkComparison)
					.attr('data-check-value' , check_data.checkValue)
					.attr('data-check-id' , check_data.id);
				//we clean here, so we won't get confuse 	
				current.removeClass('showFold').removeAttr('data-check-field')
					.removeAttr('data-check-comparison')
					.removeAttr('data-check-value');	
			}
		});

		$( ".fold" ).promise().done(function() {
			// Hide the fold elements on load
			$('.foldParent').each(function() {
				// in case of a radio input, take in consideration only the checked value
				if ( $(this).attr('type') =='radio' && $(this).attr('checked') !='checked' ) {
					return;
				}
				var id = $(this).parents('.imic-field:first').data('id');
				if ( imic_opts.folds[ id ] ) {
					if ( !imic_opts.folds[ id ].parent  ) {
						$.imic.verify_fold($(this));
					}
				}
			});
		});

		the_body.on('change', '#imic-main select, #imic-main radio, #imic-main input[type=checkbox], #imic-main input[type=hidden]', function(e){
	        $.imic.check_dependencies(e,this);
	    });
	}

	$.imic.check_dependencies = function(e,variable){
		
		var current = $(variable),
	        scope	= current.parents('.imic-group-tab:eq(0)');
 
        if(!scope.length) scope = the_body;

	// Fix for Checkbox + Required issue
        if($(variable).prop('type') == "checkbox")
		$(variable).is(":checked") ? $(variable).val('1') : $(variable).val('0');

        var id		= current.parents('.imic-field:first').data('id'),
        dependent	= scope.find('tr[data-check-field="'+id+'"]'), 
        value1		= variable.value,
        is_hidden	= current.parents('tr:eq(0)').is('.hiddenFold');
		
        if(!dependent.length) return;

        dependent.each(function(){
            var current		= $(this), 
            check_data	= current.data(), 
            value2		= check_data.checkValue, 
            show		= false;
			
            if(!is_hidden){
                switch(check_data.checkComparison){
                	case '=':
                    case 'equals':
                    	//if value was array
                    	if (value2.toString().indexOf('|') !== -1){
                    		var value2_array = value2.split('|');
                    		if($.inArray( value1, value2_array ) != -1){
                    			show = true;
                    		}
                    	}else{
                        	if(value1 == value2) 
                        		show = true;
                    	}
                        break;
                    case '!=':    
                    case 'not':
                    	//if value was array
                    	if (value2.indexOf('|') !== -1){
                    		var value2_array = value2.split('|');
                    		if($.inArray( value1, value2_array ) == -1){
                    			show = true;
                    		}
                    	}else{
                        	if(value1 != value2) 
                        		show = true;
                    	}
                        break;
                    case '>':    
                    case 'greater':    
                    case 'is_larger':
                        if(parseFloat(value1) >  parseFloat(value2)) 
                        	show = true;
                        break;
                    case '<':
                    case 'less':    
                    case 'is_smaller':
                        if(parseFloat(value1) < parseFloat(value2)) 
                        	show = true;
                        break;
                    case 'contains':
                        if(value1.indexOf(value2) != -1) 
                        	show = true;
                        break;
                    case 'doesnt_contain':
                        if(value1.indexOf(value2) == -1) 
                        	show = true;
                        break;
                    case 'is_empty_or':
                        if(value1 == "" || value1 == value2) 
                        	show = true;
                        break;
                    case 'not_empty_and':
                        if(value1 != "" && value1 != value2) 
                        	show = true;
                        break;
                }
            }
				
            /*if(show == true && current.is('.hiddenFold')){
                current.css({
                    display:'none'
                }).removeClass('hiddenFold').find('select, radio, input[type=checkbox]').trigger('change');
                current.slideDown(300);
            }else if(show == false  && !current.is('.hiddenFold')){
                current.css({
                    display:''
                }).addClass('hiddenFold').find('select, radio, input[type=checkbox]').trigger('change');
                current.slideUp(300);
            }*/
           	$.imic.verify_fold($(variable)); 
        });
	}

	$.imic.verify_fold = function(item){
		var id = item.parents('.imic-field:first').data('id');
		var itemVal = item.val();
		var scope = (item.parents('.imic-groups-accordion-group:first').length > 0)?item.parents('.imic-groups-accordion-group:first'):item.parents('.imic-group-tab:eq(0)');

		if ( imic_opts.folds[ id ] ) {

			if ( imic_opts.folds[ id ].children ) {

				var theChildren = {};
				$.each(imic_opts.folds[ id ].children, function(index, value) {
					$.each(value, function(index2, value2) { // Each of the children for this value
						if ( ! theChildren[value2] ) { // Create an object if it's not there
							theChildren[value2] = { show:false, hidden:false };
						}
						
						if ( index == itemVal || theChildren[value2] === true ) { // Check to see if it's in the criteria
							theChildren[value2].show = true;
						}

						if ( theChildren[value2].show === true && scope.find('tr[data-check-id="'+id+'"]').hasClass("hiddenFold") ) {
							theChildren[value2].show = false; // If this item is hidden, hide this child
						}

						if ( theChildren[value2].show === true && scope.find('tr[data-check-id="'+imic_opts.folds[ id ].parent+'"]').hasClass('hiddenFold') ) {
							theChildren[value2].show = false; // If the parent of the item is hidden, hide this child
						}
						// Current visibility of this child node
						theChildren[value2].hidden = scope.find('tr[data-check-id="'+value2+'"]').hasClass("hiddenFold");
					});
				});

				$.each(theChildren, function(index) {

					var parent = scope.find('tr[data-check-id="'+index+'"]');
					
					if ( theChildren[index].show === true ) {

						parent.fadeIn('medium', function() {
							parent.removeClass('hiddenFold');
							if ( imic_opts.folds[ index ] && imic_opts.folds[ index ].children ) {
								// Now iterate the children
								$.imic.verify_fold(parent.find('select, radio, input[type=checkbox], input[type=hidden]'));
							}
						});

					} else if ( theChildren[index].hidden === false ) {
						
						parent.fadeOut('medium', function() {
							parent.addClass('hiddenFold');
							if ( imic_opts.folds[ index ].children ) {
								// Now iterate the children
								$.imic.verify_fold(parent.find('select, radio, input[type=checkbox], input[type=hidden]'));
							}
						});
					}
				});
			}
		}	
	}

})(jQuery);

jQuery.noConflict();
var confirmOnPageExit = function(e) {
		//return; // ONLY FOR DEBUGGING
		// If we haven't been passed the event get the window.event
		e = e || window.event;
		var message = imic_opts.save_pending;
		// For IE6-8 and Firefox prior to version 4
		if (e) {
			e.returnValue = message;
		}
		window.onbeforeunload = null;
		// For Chrome, Safari, IE8+ and Opera 12+
		return message;
	};

function verify_fold(item) {
	
	jQuery(document).ready(function($) {
		


		if (item.hasClass('imic-info') || item.hasClass('imic-typography')) {
			return;
		}

		var id = item.parents('.imic-field:first').data('id');
		//console.log(id);
		var itemVal = item.val();

		if ( imic_opts.folds[ id ] ) {

/*
		if ( imic_opts.folds[ id ].parent && jQuery( '#' + imic_opts.folds[ id ].parent ).is('hidden') ) {
			console.log('Going to parent: '+imic_opts.folds[ id ].parent+' for field: '+id);
			//verify_fold( jQuery( '#' + imic_opts.folds[ id ].parent ) );
		} 
*/
			if ( imic_opts.folds[ id ].children ) {
				//console.log('Children for: '+id);

				var theChildren = {};
				$.each(imic_opts.folds[ id ].children, function(index, value) {
					$.each(value, function(index2, value2) { // Each of the children for this value
						if ( ! theChildren[value2] ) { // Create an object if it's not there
							theChildren[value2] = { show:false, hidden:false };
						}
						//console.log('id: '+id+' childID: '+value2+' parent value: '+index+' itemVal: '+itemVal);
						if ( index == itemVal || theChildren[value2] === true ) { // Check to see if it's in the criteria
							theChildren[value2].show = true;
							//console.log('theChildren['+value2+'].show = true');
						}

						if ( theChildren[value2].show === true && jQuery('#' + id).parents("tr:first").hasClass("hiddenFold") ) {
							theChildren[value2].show = false; // If this item is hidden, hide this child
							//console.log('set '+value2+' false');
						}

						if ( theChildren[value2].show === true && jQuery( '#' + imic_opts.folds[ id ].parent ).hasClass('hiddenFold') ) {
							theChildren[value2].show = false; // If the parent of the item is hidden, hide this child
							//console.log('set '+value2+' false2');
						}
						// Current visibility of this child node
						theChildren[value2].hidden = jQuery('#' + value2).parents("tr:first").hasClass("hiddenFold");
					});
				});

				//console.log(theChildren);

				$.each(theChildren, function(index) {

					var parent = jQuery('#' + index).parents("tr:first");
					
					if ( theChildren[index].show === true ) {
						//console.log('FadeIn '+index);
						
						parent.fadeIn('medium', function() {
							parent.removeClass('hiddenFold');
							if ( imic_opts.folds[ index ] && imic_opts.folds[ index ].children ) {
								//verify_fold(jQuery('#'+index)); // Now iterate the children
							}
						});

					} else if ( theChildren[index].hidden === false ) {
						//console.log('FadeOut '+index);
						
						parent.fadeOut('medium', function() {
							parent.addClass('hiddenFold');
							if ( imic_opts.folds[ index ].children ) {
								//verify_fold(jQuery('#'+index)); // Now iterate the children
							}
						});
					}
				});
			}
		}
			
	});
}

function imic_change(variable) {
	//We need this for switch and image select fields , jquery dosn't catch it on fly
	//if(variable.is('input[type=hidden]') || variable.hasClass('spinner-input') || variable.hasClass('slider-input') || variable.hasClass('upload') || jQuery(variable).parents('fieldset:eq(0)').is('.imic-container-image_select') ) {
		
		jQuery('body').trigger('check_dependencies' , variable);
	//}
		
	if (variable.hasClass('compiler')) {
		jQuery('#imic-compiler-hook').val(1);
		//console.log('Compiler init');
	}


	if (variable.hasClass('foldParent')) {
		//verify_fold(variable);
	}
	window.onbeforeunload = confirmOnPageExit;
	if (jQuery(variable).parents('fieldset.imic-field:first').hasClass('imic-field-error')) {
		jQuery(variable).parents('fieldset.imic-field:first').removeClass('imic-field-error');
		jQuery(variable).parent().find('.imic-th-error').slideUp();
		var parentID = jQuery(variable).closest('.imic-group-tab').attr('id');
		var hideError = true;
		jQuery('#' + parentID + ' .imic-field-error').each(function() {
			hideError = false;
		});
		if (hideError) {
			jQuery('#' + parentID + '_li .imic-menu-error').hide();
			jQuery('#' + parentID + '_li .imic-group-tab-link-a').removeClass('hasError');
		}
	}
	jQuery('#imic-save-warn').slideDown();
}
jQuery(document).ready(function($) {
	jQuery('.imic-action_bar, .imic-presets-bar').on('click', function() {
		window.onbeforeunload = null;
	}); /**	Tipsy @since v1.3 DEPRICATE? */
	if (jQuery().tipsy) {
		$('.tips').tipsy({
			fade: true,
			gravity: 's',
			opacity: 0.7
		});
	}

	$('#toplevel_page_'+imic_opts.slug+' .wp-submenu a').click(function(e) {
		//if ( $(this).hasClass('wp-menu-open') ) {
			e.preventDefault();
			var url = $(this).attr('href').split('&tab=');
			$('#'+url[1]+'_section_group_li_a').click();
			console.log(url[1]);
			return false;	
		//}
	});

/**
		Current tab checks, based on cookies
	**/
	jQuery('.imic-group-tab-link-a').click(function() {
		relid = jQuery(this).data('rel'); // The group ID of interest
		// Set the proper page cookie
		$.cookie('imic_current_tab', relid, {
       		expires: 7,
       		path: '/'
       	});

		$('#toplevel_page_'+imic_opts.slug+' .wp-submenu a.current').removeClass('current');
		$('#toplevel_page_'+imic_opts.slug+' .wp-submenu li.current').removeClass('current');

		$('#toplevel_page_'+imic_opts.slug+' .wp-submenu a').each(function() {
			var url = $(this).attr('href').split('&tab=');
			if (url[1] == relid) {
				$(this).addClass('current');
				$(this).parent().addClass('current');
			}
		});

		// Remove the old active tab
		var oldid = jQuery('.imic-group-tab-link-li.active .imic-group-tab-link-a').data('rel');
		jQuery('#' + oldid + '_section_group_li').removeClass('active');
		// Show the group
		jQuery('#' + oldid + '_section_group').hide();
		jQuery('#' + relid + '_section_group').fadeIn(300, function() {
			stickyInfo(); // race condition fix
		});
		jQuery('#' + relid + '_section_group_li').addClass('active');
	});
	// Get the URL parameter for tab

	function getURLParameter(name) {
		return decodeURI((new RegExp(name + '=' + '(.+?)(&|$)').exec(location.search) || [, ''])[1]);
	}
	// If the $_GET param of tab is set, use that for the tab that should be open
	var tab = getURLParameter('tab');
	if (tab !== "") {
		if ($.cookie("imic_current_tab_get") !== tab) {
			$.cookie('imic_current_tab', tab, {
				expires: 7,
				path: '/'
			});
			$.cookie('imic_current_tab_get', tab, {
				expires: 7,
				path: '/'
			});
			jQuery('#' + tab + '_section_group_li').click();
		}
	} else if ($.cookie('imic_current_tab_get') !== "") {
		$.removeCookie('imic_current_tab_get');
	}
	var sTab = jQuery('#' + $.cookie("imic_current_tab") + '_section_group_li_a');
	// Tab the first item or the saved one
	if ($.cookie("imic_current_tab") === null || typeof($.cookie("imic_current_tab")) === "undefined" || sTab.length === 0) {
		jQuery('.imic-group-tab-link-a:first').click();
	} else {
		sTab.click();
	}
	// Default button clicked
	jQuery('input[name="' + imic_opts.opt_name + '[defaults]"]').click(function() {
		if (!confirm(imic_opts.reset_confirm)) {
			return false;
		}
		window.onbeforeunload = null;
	});
	jQuery('#expand_options').click(function(e) {
		e.preventDefault();
		var trigger = jQuery('#expand_options');
		var width = jQuery('#imic-sidebar').width();
		var id = jQuery('#imic-group-menu .active a').data('rel') + '_section_group';
		if (trigger.hasClass('expanded')) {
			trigger.removeClass('expanded');
			jQuery('#imic-main').removeClass('expand');
			jQuery('#imic-sidebar').stop().animate({
				'margin-left': '0px'
			}, 500);
			jQuery('#imic-main').stop().animate({
				'margin-left': width
			}, 500);
			jQuery('.imic-group-tab').each(function() {
				if (jQuery(this).attr('id') !== id) {
					jQuery(this).fadeOut('fast');
				}
			});
			// Show the only active one
		} else {
			trigger.addClass('expanded');
			jQuery('#imic-main').addClass('expand');
			jQuery('#imic-sidebar').stop().animate({
				'margin-left': -width - 2
			}, 500);
			jQuery('#imic-main').stop().animate({
				'margin-left': '0px'
			}, 500);
			jQuery('.imic-group-tab').fadeIn();
		}
		return false;
	});
	jQuery('#imic-import').click(function(e) {
		if (jQuery('#import-code-value').val() === "" && jQuery('#import-link-value').val() === "") {
			e.preventDefault();
			return false;
		}
	});
	if (jQuery('#imic-save').is(':visible')) {
		jQuery('#imic-save').slideDown();
	}
	if (jQuery('#imic-imported').is(':visible')) {
		jQuery('#imic-imported').slideDown();
	}
	jQuery(document.body).on('change', 'input, textarea, select', function() {
		if (!jQuery(this).hasClass('noUpdate')) {
			imic_change(jQuery(this));
		}
	});
	jQuery('#imic-import-code-button').click(function() {
		if (jQuery('#imic-import-link-wrapper').is(':visible')) {
			jQuery('#imic-import-link-wrapper').fadeOut('fast');
			jQuery('#import-link-value').val('');
		}
		jQuery('#imic-import-code-wrapper').fadeIn('slow');
	});
	jQuery('#imic-import-link-button').click(function() {
		if (jQuery('#imic-import-code-wrapper').is(':visible')) {
			jQuery('#imic-import-code-wrapper').fadeOut('fast');
			jQuery('#import-code-value').val('');
		}
		jQuery('#imic-import-link-wrapper').fadeIn('slow');
	});
	jQuery('#imic-export-code-copy').click(function() {
		if (jQuery('#imic-export-link-value').is(':visible')) {
			jQuery('#imic-export-link-value').fadeOut('slow');
		}
		jQuery('#imic-export-code').toggle('fade');
	});
	jQuery('#imic-export-link').click(function() {
		if (jQuery('#imic-export-code').is(':visible')) {
			jQuery('#imic-export-code').fadeOut('slow');
		}
		jQuery('#imic-export-link-value').toggle('fade');
	});

	/**
		BEGIN Sticky footer bar
	**/
	var stickyHeight = jQuery('#imic-footer').height();
	jQuery('#imic-sticky-padder').css({
		height: stickyHeight
	});

	function stickyInfo() {
		var stickyWidth = jQuery('#info_bar').width() - 2;
		if (!jQuery('#info_bar').isOnScreen() && !jQuery('#imic-footer-sticky').isOnScreen()) {
			jQuery('#imic-footer').css({
				position: 'fixed',
				bottom: '0',
				width: stickyWidth
			});
			jQuery('#imic-footer').addClass('sticky-footer-fixed');
			jQuery('#imic-sticky-padder').show();
		} else {
			jQuery('#imic-footer').css({
				background: '#eee',
				position: 'inherit',
				bottom: 'inherit',
				width: 'inherit'
			});
			jQuery('#imic-sticky-padder').hide();
			jQuery('#imic-footer').removeClass('sticky-footer-fixed');
		}
	}
	jQuery(window).scroll(function() {
		stickyInfo();
	});
	jQuery(window).resize(function() {
		stickyInfo();
	});
	jQuery('#imic-save, #imic-imported').delay(4000).slideUp();
	jQuery('#imic-field-errors').delay(8000).slideUp();
	jQuery('.imic-save').click(function() {
		window.onbeforeunload = null;
	});
	/**
		END Sticky footer bar
	**/

	/**
		BEGIN dev_mode commands
	**/	
	$('#consolePrintObject').on('click', function() {
		console.log(jQuery.parseJSON(jQuery("#imic-object-json").html()));
	});

	if (typeof jsonView === 'function') {
		jsonView('#imic-object-json', '#imic-object-browser');
	}
	/**
		END dev_mode commands
	**/	

	/**
		BEGIN error and warning notices
	**/	
	// Display errors on page load
	if (imic_opts.errors !== undefined) {
		jQuery("#imic-field-errors span").html(imic_opts.errors.total);
		jQuery("#imic-field-errors").show();
		jQuery.each(imic_opts.errors.errors, function(sectionID, sectionArray) {
			jQuery("#" + sectionID + "_section_group_li_a").prepend('<span class="imic-menu-error">' + sectionArray.total + '</span>');
			jQuery("#" + sectionID + "_section_group_li_a").addClass("hasError");
			jQuery.each(sectionArray.errors, function(key, value) {
				console.log(value);
				jQuery("#" + imic_opts.opt_name+'-'+value.id).addClass("imic-field-error");
				jQuery("#" + imic_opts.opt_name+'-'+value.id).append('<div class="imic-th-error">' + value.msg + '</div>');
			});
		});
	}
	// Display warnings on page load
	if (imic_opts.warnings !== undefined) {
		jQuery("#imic-field-warnings span").html(imic_opts.warnings.total);
		jQuery("#imic-field-warnings").show();
		jQuery.each(imic_opts.warnings.warnings, function(sectionID, sectionArray) {
			jQuery("#" + sectionID + "_section_group_li_a").prepend('<span class="imic-menu-warning">' + sectionArray.total + '</span>');
			jQuery("#" + sectionID + "_section_group_li_a").addClass("hasWarning");
			jQuery.each(sectionArray.warnings, function(key, value) {
				jQuery("#" + imic_opts.opt_name+'-'+value.id).addClass("imic-field-warning");
				jQuery("#" + imic_opts.opt_name+'-'+value.id).append('<div class="imic-th-warning">' + value.msg + '</div>');
			});
		});
	}
	/**
		END error and warning notices
	**/	



	/**
		BEGIN Control the tabs of the site to the left. Eventually (perhaps) across the top too.
	**/
	//jQuery( ".imic-section-tabs" ).tabs();
	jQuery('.imic-section-tabs div').hide();
	jQuery('.imic-section-tabs div:first').show();
	jQuery('.imic-section-tabs ul li:first').addClass('active');
 
	jQuery('.imic-section-tabs ul li a').click(function(){
		jQuery('.imic-section-tabs ul li').removeClass('active');
		jQuery(this).parent().addClass('active');
		var currentTab = $(this).attr('href');
		jQuery('.imic-section-tabs div').hide();
		jQuery(currentTab).fadeIn();
		return false;
	});
	/**
		END Control the tabs of the site to the left. Eventually (perhaps) across the top too.
	**/


});
