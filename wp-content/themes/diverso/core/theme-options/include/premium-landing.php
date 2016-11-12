<style type="text/css">
#landing { width:800px; }
#landing p { text-align:center }

/* call to actions buttons */
#landing ul.actions {list-style-type:none;width:241px;height:70px;margin:30px auto 20px;padding:0;}
#landing ul.actions li {width:241px;height:64px;float:left;display:block;padding:0 6px;}
#landing ul.actions li a {display:block;width:241px;height:64px;}
#landing ul.actions li.live a {background:url('<?php echo get_template_directory_uri() ?>/admin-options/include/landing/livedemo.gif') no-repeat top center;}
#landing ul.actions li.view a {background:url('<?php echo get_template_directory_uri() ?>/admin-options/include/landing/premium.gif') no-repeat top center;}       
#landing ul.actions li a:hover {background-position:bottom center;}

/* buy now */
#landing ul.actions li input.eStore_buy_now_button {display:block;margin:0;padding:0;border:0;width:241px;height:64px;background:url('<?php echo get_template_directory_uri() ?>/admin-options/include/landing/buynow.gif') no-repeat top center;cursor:pointer;text-indent:-9999px;}
#landing ul.actions li input.eStore_buy_now_button:hover {background-position:bottom center;}
#landing .eStore_paypal_checkout_button:hover,.eStore_button:hover,.eStore_remove_item_button:hover,.eStore_empty_cart_button:hover,.eStore_buy_now_button:hover,.eStore_subscribe_button:hover {opacity:1!important;}

/* buy now limited offer */
.buy-now-limited input.eStore_buy_now_button {border:0;background:url('<?php echo get_template_directory_uri() ?>/admin-options/include/landing/limited.jpg') no-repeat top center;cursor:pointer;text-indent:-9999px;display:block;width:587px;height:349px;margin:60px auto;padding:0;}
</style>

<div id="landing">
    <p>
        <a href="http://www.freeminimalwptheme.com/?ap_id=panel&c_id=panel" target="_blank">
            <img src="<?php echo get_template_directory_uri() ?>/admin-options/include/landing/header.jpg" alt="Beauty & Clean - <?php _e( 'Why do you have to upgrade to the premium version?', 'yiw' ) ?>" />
        </a>
    </p>
    
    <ul class="actions">
        <li class="view"><a target="_blank" title="View the Premium version of Beauty and Clean" href="http://www.freeminimalwptheme.com/?ap_id=panel&c_id=panel"></a></li>
    </ul>
    
    <p>
        <a href="http://www.freeminimalwptheme.com/?ap_id=panel&c_id=panel" target="_blank">
            <img src="<?php echo get_template_directory_uri() ?>/admin-options/include/landing/body.jpg" alt="<?php _e( 'Access to our free support forum - Videoscreencast - 2 slider types + 6 different home page - Extensive Theme Options - Unlimited colour schemes - C�fon font replacemente with 10 fonts - Unlimited sidebars - Unlimited contact forms - 70+ shortcodes - Extensive documentation.', 'yiw' ) ?>" />
        </a>
    </p>
    
    <p>
        <a href="http://www.freeminimalwptheme.com/?ap_id=panel&c_id=panel" target="_blank">
            <img src="<?php echo get_template_directory_uri() ?>/admin-options/include/landing/limited.jpg" alt="<?php _e( 'Today only 37 $ limited offer to only 20 buyers.', 'yiw' ) ?>" />
        </a>
    </p>
    
    <ul class="actions">
        <li class="view"><a target="_blank" title="View the Premium version of Beauty and Clean" href="http://www.freeminimalwptheme.com/?ap_id=panel&c_id=panel"></a></li>
    </ul>
</div>