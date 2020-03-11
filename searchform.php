<!--BEGIN #searchform-->
<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<input name="s" type="text" value="SEARCH" onfocus="if(this.value == '<?php _e('SEARCH', 'framework') ?>') { this.value = ''; }" onblur="if(this.value == '') { this.value = '<?php _e('SEARCH', 'framework') ?>'; }" class="input" />
                <input name="submit" type="submit" value="" class="button" />
<!--END #searchform-->
</form>
