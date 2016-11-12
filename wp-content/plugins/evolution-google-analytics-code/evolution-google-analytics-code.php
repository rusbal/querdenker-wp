<?php
/*
Plugin Name: Evolution Google Analytics Code
Plugin URI: http://hechtmediaarts.com/evolution-google-analytics/
Description: With this plugin you can add the Google Analytics Code in no time to your header or footer.
Version: 1.0.3
Author: Andreas Hecht
Author URI: http://hechtmediaarts.com/
License: GPL2
*/

class EvolutionAnalyticsSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Evolution Google Analytics Settings', 
            'Evolution Google Analytics', 
            'manage_options', 
            'evolution-google-analytics', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'analytics_options' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Evolution Google Analytics Code</h2>
                <div id="poststuff" class="metabox-holder has-right-sidebar">               
                    <div class="container postbox postbox-container"  style="width: 60%">
                    <h3 class="hndle">Settings</h3>
                    <div class="inside">          
                <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'analytics_group' );   
                do_settings_sections( 'my-setting-admin' );
                submit_button(); 
            ?>
            </form>
            </div> 
            </div>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'analytics_group', // Option group
            'analytics_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Paste your Google Analytics Code in one of the textareas below', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'evolution_analytics_head', // ID
            'Add your Google Analytics Code to header: wp_head();', // Title 
            array( $this, 'evolution_analytics_head_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'evolution_analytics_footer', 
            'Add your Google Analytics Code to footer: wp_footer();', 
            array( $this, 'evolution_analytics_footer_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );      
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['evolution_analytics_head'] ) )
            $new_input['evolution_analytics_head'] = $input['evolution_analytics_head'];

        if( isset( $input['evolution_analytics_footer'] ) )
            $new_input['evolution_analytics_footer'] = $input['evolution_analytics_footer'];

        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print '';  // Nothing to say here
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function evolution_analytics_head_callback()
    {
        printf(
            '<textarea style="width: 350px; height: 150px;" type="text" id="evolution_analytics_head" name="analytics_options[evolution_analytics_head]">%s</textarea>',
            isset( $this->options['evolution_analytics_head'] ) ? esc_attr( $this->options['evolution_analytics_head']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function evolution_analytics_footer_callback()
    {
        printf(
            '<textarea style="width: 350px; height: 150px;" type="text" id="evolution_analytics_footer" name="analytics_options[evolution_analytics_footer]">%s</textarea>',
            isset( $this->options['evolution_analytics_footer'] ) ? esc_attr( $this->options['evolution_analytics_footer']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new EvolutionAnalyticsSettingsPage();


/**
 * 
 * Add analytics code to wp_head()
 * @uses wp_head()
 * 
 */ 
function evolution_print_analytics_code_header() 
{

    $my_options = get_option( 'analytics_options' );

            echo $my_options['evolution_analytics_head'];

}
add_action( 'wp_head', 'evolution_print_analytics_code_header' );


/**
 * 
 * Add analytics code to wp_footer()
 * @uses wp_footer()
 * 
 */
function evolution_print_analytics_code_footer() 
{

    $my_options = get_option( 'analytics_options' );

            echo $my_options['evolution_analytics_footer'];
}
add_action( 'wp_footer', 'evolution_print_analytics_code_footer' );
