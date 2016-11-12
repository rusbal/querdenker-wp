jQuery(document).ready(function($){                
        var yiw_this_object = null;
        
        $('.upload-image').live('click', function(){    
        	yiw_this_object = $(this);
        	return false;
        });
    
    	window.send_to_editor = function(html) {
            var upField = yiw_this_object.prev();
            var upId = yiw_this_object.next();
            
    	    imgurl = $('a', '<div>' + html + '</div>').attr('href');
 			idimg = $('img', html).attr('class').match(/wp-image-(\d+)/);
            upField.val(imgurl);
            upId.val(idimg[1]);
            
            tb_remove();
    	}     
    	
    	$('.expand-list').click(function(){
            $( '#' + $(this).attr('rel') ).slideToggle(200);
            return false;
        });
}); 