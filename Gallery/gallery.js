jQuery(function($){
    $(".select-gallary-image").live('click', function() {

        var elementId = $(this).attr('id');
        var displayId = elementId.replace('select-image', 'display-image');
		var textId = elementId.replace('select-image', 'description');
        var inputId = elementId.replace('select-image', 'image');
        var fileFrame = wp.media.frames.file_frame = wp.media({
            multiple: true
        });

        fileFrame.on('select', function() {
			str='';
			str2='';
			$.each(eval(fileFrame.state().get('selection').toJSON()), function(key,value) {
				  str+=value.id+' ';
				  str2+='<li><img src="' + value.url + '" style="width:80px; height:50px; margin:3px 0 0 3px;cursor:move" />';
				  str2+='<a href="javascript:;" id="' + value.id + '" onclick="removeT(this)">X</a></li>';
					 
			});
			all_id=str.substring(0,str.length-1);
			$('#' + displayId).html(str2);
			$('#'+inputId).val(all_id);
			 
			if($(".gallarysort > li").length>0)
			{
				$(".gallarysort").sortable({ 
				 stop: function(event, ui){ 
					 str="";
					 $(this).find("li > a").each(function() {
						 valu=$(this).attr("id");
						 str+=valu+" ";
					 });
					 all_id=str.substring(0,str.length-1);
					 $(this).parent().find("p > input[type=hidden]").val(all_id);
				 }}).disableSelection();
		    }
				 
        });

        fileFrame.open();
		
    });	     
	
	
});

function removeT(obj)
{
	 val=jQuery(obj).parent().parent().parent().find('p > input[type=hidden]').val();
	 str=val.replace(obj.id,'');
	 str=str.replace(/\s\s+/g,' ');
	 str=jQuery.trim(str);
	 jQuery(obj).parent().parent().parent().find('p > input[type=hidden]').val(str);
	 jQuery(obj).parent().remove();
	 return false;
}	