<?php
/**
 * Copyright 2008 Chris Abernethy
 *
 * This file is part of IdeaScale.
 *
 * IdeaScale is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * IdeaScale is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with IdeaScale.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * Integrate IdeaScale crowdsourcing into WordPress without having to directly edit any template code.
 */
class IdeaScale
{

    /**
     * An instance of the options structure containing all options for this
     * plugin.
     *
     * @var IdeaScale_Structure_Options
     */
    var $_options = null;

    /**************************************************************************/
    /*                         Singleton Functionality                        */
    /**************************************************************************/

    /**
     * Retrieve the instance of this class, creating it if necessary.
     *
     * @return IdeaScale
     */
    function instance()
    {
        static $instance = null;
        if (null == $instance) {
            $c = __CLASS__;
            $instance = new $c;
        }
        return $instance;
    }

    /**
     * The constructor initializes the options object for this plugin.
     */
    function IdeaScale()
    {
        $this->_options = new IdeaScale_Structure_Options('ideascale_options');
    }

    /**************************************************************************/
    /*                     Plugin Environment Management                      */
    /**************************************************************************/

    /**
     * This initialization method instantiates an instance of the plugin and
     * performs the initialization sequence. This method is meant to be called
     * statically from the plugin bootstrap file.
     *
     * Example Usage:
     * <pre>
     * IdeaScale::run(__FILE__)
     * </pre>
     *
     * @param string $plugin_file The full path to the plugin bootstrap file.
     */
    function run($plugin_file)
    {
        $plugin = IdeaScale::instance();

        // Activation and deactivation hooks have special registration
        // functions that handle sanitization of the given filename. It
        // is recommended that these be used rather than directly adding
        // an action callback for 'activate_<filename>'.

        register_activation_hook  ($plugin_file, array(&$plugin, 'hookActivation'));
        register_deactivation_hook($plugin_file, array(&$plugin, 'hookDeactivation'));

        // Set up action callbacks.
        add_action('admin_menu'                 , array(&$plugin, 'registerOptionsPage'));
        add_action('ideascale_save_options', array(&$plugin, 'saveOptionsPage'));
        add_action('wp_footer'                  , array(&$plugin, 'footerAction'));
        add_filter('plugin_action_links'        , array(&$plugin, 'renderOptionsLink'), 10, 2);
        add_action('do_meta_boxes'              , array(&$plugin, 'registerMetaBoxes'), 10, 3);
        add_action('wp_insert_post'             , array(&$plugin, 'updatePost'));
        add_action('plugins_loaded'             , array(&$plugin, 'pluginsLoaded'));
    }

    /**
     * This is the plugin activation hook callback. It performs setup actions
     * for the plugin and should be smart enough to know when the plugin has
     * already been installed and is simply being re-activated.
     */
    function hookActivation()
    {
        // If 'version' is not yet set in the options array, this is a first
        // time install scenario. Perform the initial database and options
        // setup.
        if (null === $this->getOption('version')) {
            $this->_install();
            return;
        }

        // If the plugin version stored in the options structure is older than
        // the current plugin version, initiate the upgrade sequence.
        if (version_compare($this->getOption('version'), '1.3', '<')) {
            $this->_upgrade();
            return;
        }
    }

    /**
     * This is the plugin deactivation hook callback, it performs teardown
     * actions for the plugin.
     */
    function hookDeactivation()
    {
    }

    /**
     * This method is called when the plugin needs to be installed for the first
     * time.
     */
    function _install()
    {
        global $wpdb;

        // Create fields in the posts table to hold per-post plugin options.
        $wpdb->query(sprintf("
            ALTER TABLE %s
               ADD COLUMN `%s` tinyint(1) unsigned NOT NULL DEFAULT 0
          ", $wpdb->posts
           , $wpdb->escape('ideascale_inactive')
        ));

        // Set the default options.
        $this->setOption('version', '1.3');
        $this->setOption('inline-code', null);
        $this->setOption('icon-code', null);
        $this->_options->save();
    }

    /**
     * Remove all traces of this plugin from the WordPress database. This
     * includes removing custom fields from the wp_posts table as well as any
     * options in the wp_options table. This method should <em>only</em> be
     * called if the plugin is also going to be deactivated.
     */
    function _uninstall()
    {
        global $wpdb;

        // Remove the per-post plugin option fields from the wp_posts table.
        $wpdb->query(sprintf("
            ALTER TABLE %s
              DROP `%s`
        " , $wpdb->posts
          , $wpdb->escape('ideascale_inactive')
        ));

        // Remove all plugin options from the wp_options table.
        $this->_options->delete();
    }

    /**
     * This method is called when the internal plugin state needs to be
     * upgraded.
     */
    function _upgrade()
    {
        // Upgrade Example
        //$old_version = $this->getOption('version');
        //if (version_compare($old_version, '3.5', '<')) {
        //    // Do upgrades for version 3.5
        //    $this->setOption('version', '3.5');
        //}
        $this->setOption('version', '1.3');
        $this->_options->save();
    }

    /**************************************************************************/
    /*                          Action Hook Callbacks                         */
    /**************************************************************************/

    /**
     * Render the meta-boxes for this plugin in the advanced section of both
     * the post and page editing screens.
     *
     * @param string $page The type of page being loaded (page, post, link or comment)
     * @param string $context The context of the meta box (normal, advanced)
     * @param StdClass $object The object representing the page type
     */
    function registerMetaBoxes($page, $context, $object)
    {
        if (in_array($page, array('page', 'post'))) {
            add_meta_box(
                attribute_escape('ideascale') // id attribute
              , wp_specialchars('IdeaScale')   // metabox title
              , array(&$this, 'renderMetaBox')     // callback function
              , $page                              // page type
            );
        }
    }

    /**
     * This action hook callback is called after a post or page is created or
     * updated.
     *
     * @param integer $post_id
     */
    function updatePost($post_id)
    {
        global $wpdb;

        // Don't update the wp_posts fields if this is a quick-edit.
        if (@$_POST['action'] == 'inline-save') {
            return;
        }

        $wpdb->query(sprintf("
            UPDATE %s
            SET `%s` = '%s'
            WHERE ID = %d
        ", $wpdb->posts
         , $wpdb->escape('ideascale_inactive'), $wpdb->escape(@$_POST['ideascale_inactive'])
         , $post_id
        ));

    }

    /**
     * This is the admin_menu activation hook callback, it adds a sub-menu
     * navigation item for this plugin to the plugins.php page and links it to
     * the renderOptionsPage() method.
     *
     * Plugins wishing to change this default behavior should override this
     * method to create the appropriate options pages.
     */
    function registerOptionsPage()
    {
        $page = add_submenu_page(
            'plugins.php'                     // parent
          , wp_specialchars('IdeaScale')  // page_title
          , wp_specialchars('IdeaScale')  // menu_title
          , 'manage_options'                  // access_level
          , 'ideascale'                  // file
          , array(&$this, 'renderOptionsPage') // function
        );
    }

    /**
     * This action hook callback is called in the footer of a template.
     */
    function footerAction()
    {
        if(is_single() || is_page()) {
            global $post;
            if(!$post->{'ideascale_inactive'}) {
                echo stripslashes($this->getOption('icon-code'));
            }
        }
    }

    /**
     * This action hook callback is called after all plugins are loaded. It is
     * useful for registering other callbacks that cannot be executing while
     * plugins are loading, e.g., register_sidebar_widget().
     */
    function pluginsLoaded()
    {
        // Register sidebar widgets.
        wp_register_sidebar_widget(
            sanitize_title('IdeaScale'),
            'IdeaScale',
            array(&$this, 'renderSidebarWidget'),
            array('description' => 'IdeaScale inline widget.')
        );
    }

    /**************************************************************************/
    /*                          Filter Hook Callbacks                         */
    /**************************************************************************/

    /**
     * This is the 'plugin_action_links' hook callback, it adds a single link
     * to the options page that was registered by the registerOptionsPage()
     * method. The link is titled 'Settings', and will appear as the first link
     * in the list of plugin links.
     *
     * @param array $links
     * @param string $file
     * @return array
     */
    function renderOptionsLink($links, $file)
    {
        static $plugin_dir = null;
        if(null === $plugin_dir) {
            $plugin_dir = plugin_basename(__FILE__);
            $plugin_dir = substr($plugin_dir, 0, stripos($plugin_dir, '/'));
        }

        if (dirname($file) == $plugin_dir) {
            $view = new IdeaScale_Structure_View('options-link.phtml');
            $view->set('link_href' , 'plugins.php?page=ideascale');
            $view->set('link_title', sprintf(__('%s Settings', 'ideascale'), 'IdeaScale'));
            $view->set('link_text' , __('Settings', 'ideascale'));
            ob_start();
            $view->render();
            array_unshift($links, ob_get_clean());
        }
        return $links;
    }

    /**
     * Save the results of a post from the options page.
     */
    function saveOptionsPage()
    {
        global $wpdb;

        if (isset($_POST['action']) && 'update' == $_POST['action']) {

            check_admin_referer('update-options');

            // Non-Booleans
            $this->setOption('inline-code', $_POST['ideascale_inline_code']);
            $this->setOption('icon-code'  , $_POST['ideascale_icon_code']);

            $this->_options->save();

            // Render the header message partial
            $this->_messageHelper(__('Settings have been saved.', 'ideascale'));

        }
    }

    /**************************************************************************/
    /*                           Indirect Callbacks                           */
    /**************************************************************************/

    /**
     * Render the metabox content for this plugin.
     *
     * @param StdClass $object The object representing the page type
     * @param array $box An array containing the id, title and callback used when
     *                   registering the meta box being displayed.
     */
    function renderMetaBox($object, $box)
    {
        $view = new IdeaScale_Structure_View('metabox.phtml');
        $view->set('plugin_label', 'ideascale');
        $view->set('inactive'    , $object->{'ideascale_inactive'});
        $view->render();
    }

    /**
     * This method fires the custom <label>_save_options action hook and registers
     * the renderAdminFooter() method as an 'in_admin_footer' action hook before
     * rendering the actual options page.
     */
    function renderOptionsPage()
    {
        // Invoke the action hook for saving the options page.
        do_action('ideascale_save_options');

        // Register the in_admin_footer action hook. This is done here so that
        // it only gets registered for the options page for this plugin, and
        // not every plugin.
        add_action('in_admin_footer', array(&$this, 'renderAdminFooter'));

        $view = new IdeaScale_Structure_View('options-page.phtml');
        $view->set('heading'     , sprintf(__('%s Settings', 'ideascale'), 'IdeaScale'));
        $view->set('nonce_action', 'update-options');
        $view->set('plugin_label', 'ideascale');

        $view->set('inline-code' , stripslashes($this->getOption('inline-code')));
        $view->set('icon-code'   , stripslashes($this->getOption('icon-code')));

        $view->render();
    }

    /**
     * Renders the sidebar widget code.
     *
     * @param array $args
     */
    function renderSidebarWidget($args)
    {
        extract($args);
        if(is_single() || is_page()) {
            global $post;
            if(!$post->{'ideascale_inactive'}) {
                echo $before_widget;
                echo $before_title;
                echo "IdeaScale";
                echo $after_title;
                echo stripslashes($this->getOption('inline-code'));
                echo $after_widget;
            }
        }
    }

    /**
     * Action hook callback meant to be used with the 'in_admin_footer' hook.
     * This callback renders plugin author information into the admin footer.
     * Whenever possible, this should only be used on the admin page for this
     * plugin.
     */
    function renderAdminFooter()
    {
        $view = new IdeaScale_Structure_View('options-footer.phtml');
        $view->set('plugin_href'   , 'http://www.chrisabernethy.com/wordpress-plugins/ideascale/');
        $view->set('plugin_text'   , 'IdeaScale');
        $view->set('plugin_version', '1.3');
        $view->set('author_href'   , 'http://www.chrisabernethy.com/');
        $view->set('author_text'   , 'Chris Abernethy');
        $view->render();
    }

    /**************************************************************************/
    /*                            Utility Methods                             */
    /**************************************************************************/

    /**
     * Render the given message using the message.phtml partial. This is typically
     * used to render confirmation messages in the admin area.
     *
     * @param string $message The message to display.
     */
    function _messageHelper($message)
    {
        $view = new IdeaScale_Structure_View('message.phtml');
        $view->set('message', $message);
        $view->render();
    }

    /**
     * This accessor grants read access to the internal options object so that
     * the isPrivate method can check option values when it is called as a
     * static method.
     *
     * @param string $option_name
     * @return Mixed
     */
    function getOption($option_name)
    {
        return $this->_options->get($option_name);
    }

    /**
     * This accessor grants write access to the internal options object so that
     * option values can be changed.
     *
     * @param string $option_name
     * @param mixed $option_value
     */
    function setOption($option_name, $option_value)
    {
        $this->_options->set($option_name, $option_value);
    }

};

/* EOF */