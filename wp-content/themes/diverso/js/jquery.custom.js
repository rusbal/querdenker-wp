jQuery(document).ready(function($){ 

	$('body').removeClass('no_js').addClass('yes_js'); 
	
	$('a.no-link').click(function(){return false;});
    
    $('#nav li > ul.sub-menu li').each(function(){
        n = $('ul.sub-menu', this).length;
        
        if(n) $(this).addClass('sub');
    });
    
    var show_dropdown = function()
    {        
        var options;
        
        containerWidth = $('#header').width();
        marginRight = $('#nav ul.level-1 > li').css('margin-right');
        submenuWidth = $('#nav ul.sub-menu').width();
        offsetMenuRight = $(this).position().left + submenuWidth;
        leftPos = -18;
        
        if ( offsetMenuRight > containerWidth )
            options = { left:leftPos - ( offsetMenuRight - containerWidth ) };    
        else
            options = {};
        
        $('ul.sub-menu:not(ul.sub-menu li > ul.sub-menu), ul.children:not(ul.children li > ul.children)', this).css(options).stop(true, true).fadeIn(300);    
    }
    
    var hide_dropdown = function()
    {
        $('ul.sub-menu:not(ul.sub-menu li > ul.sub-menu), ul.children:not(ul.children li > ul.children)', this).fadeOut(300);    
    }
        
    $('#nav ul > li').hover( show_dropdown, hide_dropdown );              
    
    $('#nav ul > li').each(function(){
        if( $('ul', this).length > 0 )
            $(this).children('a').append('<span class="sf-sub-indicator"> &raquo;</span>')
    }); 
    
    $('#nav li ul.sub-menu li, #nav li ul.children li').hover(
        function()
        {                  
            var options;
            
            containerWidth = $('#header').width();
            containerOffsetRight = $('#header').offset().left + containerWidth;
            submenuWidth = $('ul.sub-menu, ul.children', this).parent().width();
            offsetMenuRight = $(this).offset().left + submenuWidth * 2;
            leftPos = -10;
            
            if ( offsetMenuRight > containerOffsetRight )
                $(this).addClass('left');
                
            $('ul.sub-menu, ul.children', this).stop(true, true).fadeIn(300);
        },
    
        function()
        {
            $('ul.sub-menu, ul.children', this).fadeOut(300);
        }
    ); 
	
	// searchform on header    // autoclean labels
	$elements = $('#header #s, .autoclear');
    
	$elements.each(function(){
        if( $(this).val() != '' )	
			$(this).prev().css('display', 'none');
    }); 
    $elements.focus(function(){
        if( $(this).val() == '' )	
			$(this).prev().css('display', 'none');
    }); 
    $elements.blur(function(){ 
        if( $(this).val() == '' )	
        	$(this).prev().css('display', 'block');
    }); 

    $('a.socials, a.socials-small').tipsy({fade:true, gravity:'s'});
    
    $('.toggle-content:not(.opened), .content-tab:not(.opened)').hide(); 
    $('.tab-index a').click(function(){           
        $(this).parent().next().slideToggle(300, 'easeOutExpo');
        $(this).parent().toggleClass('tab-opened tab-closed');
        $(this).attr('title', ($(this).attr('title') == 'Close') ? 'Open' : 'Close');
        return false;
    });   
    
    // tabs
	$('#product-tabs').yiw_tabs({
        tabNav  : 'ul.tabs',
        tabDivs : '.containers',
        currentClass : 'active'
    });
	$('.tabs-container').yiw_tabs({
        tabNav  : 'ul.tabs',
        tabDivs : '.border-box'
    });
	$('.testimonials-list').yiw_tabs({
        tabNav  : 'ul.tabs',
        tabDivs : '.border-box',
        currentClass : 'active'
    }); 
    
    $('#slideshow images img').show();
    
    $('.shipping-calculator-form').show();
    
    // gallery hover
    $(".gallery-wrap .internal_page_item .overlay").css({opacity:0});
	$(".gallery-wrap .internal_page_item").live( 'mouseover mouseout', function(event){ 
		if ( event.type == 'mouseover' ) $('.overlay', this).show().stop(true,false).animate({ opacity: 1 }, "fast"); 
		if ( event.type == 'mouseout' )  $('.overlay', this).animate({ opacity: 0 }, "fast", function(){ $(this).hide() }); 
	});
	
	if ( $('body').hasClass('isMobile') && ! $('body').hasClass('iphone') && ! $('body').hasClass('ipad') )
        $('.sf-sub-indicator').parent().click(function(){   
            $(this).paretn().toggle( show_dropdown, function(){ document.location = $(this).children('a').attr('href') } )
        });
	
	// map tab
	$('.header-map .tab-label').click(function(){
        var mapWrap = $('#map-wrap');
        var text = $(this).text();
        var label = $(this);
        var height = $('#map').height();   
        
        if ( $(window).height() - 100 < height )
            height = $(window).height() - 100;
                                                  
        //console.log( text + ' - ' + header_map.tab_open + ' - ' + header_map.tab_close );
        
        if ( $(this).hasClass('closed') ) {
            mapWrap.show().animate({height:height}, 500, function(){
                label.removeClass('closed').addClass('opened').text(header_map.tab_close);
            });
            
        } else if ( $(this).hasClass('opened') ) {
            mapWrap.animate({height:0}, 500, function(){ 
                $(this).hide();
                label.removeClass('opened').addClass('closed').text(header_map.tab_open);
            });
        }             
        
        return false;
    });
    
    $('.home-sections .section').each(function(){
        if ( $('.section-content', this).height() < $('.section-title', this).height() )
            $(this).css('min-height', $('.section-title', this).height() );
    });
    
    $(window).resize(function(){
//         $('#twitter-slider .tweets-list li').each( function() {
//             var width = $(this).width() / $('#twitter-slider').width();
//             $(this).width( $('#twitter-slider').width() * width );
//         } );     
    });
});         

function yiw_lightbox()
{   
    if (typeof jQuery.fn.prettyPhoto != "function")
        return;
    
    jQuery('a.thumb').hover(
                            
        function()
        {
            jQuery('<a class="zoom">zoom</a>').appendTo(this).css({
				dispay:'block', 
				opacity:0, 
				height:jQuery(this).children('img').height(), 
				width:jQuery(this).children('img').width(),
				'top':jQuery(this).css('padding-top'),
				'left':jQuery(this).css('padding-left'),
				padding:0}).animate({opacity:0.4}, 500);
        },
        
        function()
        {           
            jQuery('.zoom').fadeOut(500, function(){jQuery(this).remove()});
        }
    );
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({
        slideshow:5000,
        theme: yiw_prettyphoto_style, 
        autoplay_slideshow:false,
        deeplinking: false,
        show_title:false
    });
} 

// tabs plugin
(function($) {
    $.fn.yiw_tabs = function(options) {
        // valori di default
        var config = {
            'tabNav': 'ul.tabs',
            'tabDivs': '.containers',
            'currentClass': 'current'
        };      
 
        if (options) $.extend(config, options);
    	
    	this.each(function() {   
        	var tabNav = $(config.tabNav, this);
        	var tabDivs = $(config.tabDivs, this);
        	var activeTab;
        	var maxHeight = 0;
        	
        	// height of tabs
//         	$('li', tabNav).each(function(){
//                 var tabHeight = $(this).height();
//                 if ( tabHeight > maxHeight )
//                     maxHeight = tabHeight;
//             });
//             $('li h4', tabNav).each(function(){
//                 $(this).height(maxHeight-40);
//             });
        	
            tabDivs.children('div').hide();
    	
    	    if ( $('li.'+config.currentClass+' a', tabNav).length > 0 )
               activeTab = '#' + $('li.'+config.currentClass+' a', tabNav).attr('href').split('#')[1]; 
        	else
        	   activeTab = '#' + $('li:first-child a', tabNav).attr('href').split('#')[1];
                        
        	$(activeTab).show().addClass('showing');
            $('li:first-child a', tabNav).parents('li').addClass(config.currentClass);
            
            var change_tab = function(el, id) {
        		$('li.'+config.currentClass, tabNav).removeClass(config.currentClass);
        		el.parents('li').addClass(config.currentClass);
        		
        		$('.showing', tabDivs).fadeOut(200, function(){
        			el.removeClass('showing');
        			$(id).fadeIn(200).addClass('showing');
        		});
            }
        	
        	$('a', tabNav).click(function(){
        		var id = '#' + $(this).attr('href').split('#')[1];
        		var thisLink = $(this);
        		
        		change_tab(thisLink, id);
        		
        		return false;
        	});   
        	
        	$('a[href^="#"]', tabDivs).click(function(){
                var hash = $(this).attr('href');
                
                if ( $(hash, tabDivs).length == 0 )
                    return true;
                
                change_tab( $('a[href="'+hash+'"]'), hash );
                
                return false;
            });
        });
    }
})(jQuery);  