<?php
/**
 * Main plugin file.
 * Use Jetpack with proper German translations. Approved for client usage.
 *    Jetpack endlich in vernünftigem Deutsch. Kliententauglich.
 *
 * @package     Jetpack German (de_DE)
 * @author      David Decker
 * @copyright   Copyright (c) 2012-2013, David Decker - DECKERWEB
 * @license     GPL-2.0+
 * @link        http://deckerweb.de/twitter
 *
 * @wordpress-plugin
 * Plugin Name: Jetpack German (de_DE)
 * Plugin URI:  http://genesisthemes.de/en/wp-plugins/jetpack-de/
 * Description: Use Jetpack with proper German translations. Approved for client usage. Jetpack endlich in vernünftigem Deutsch. Kliententauglich.
 * Version:     1.7.0
 * Author:      David Decker - DECKERWEB
 * Author URI:  http://deckerweb.de/
 * License:     GPL-2.0+
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 * Text Domain: jetpack-german
 * Domain Path: /jpde-languages/
 *
 * Copyright (c) 2012-2013 David Decker - DECKERWEB
 *
 *     This file is part of Jetpack German (de_DE),
 *     a plugin for WordPress.
 *
 *     Jetpack German (de_DE) is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     Jetpack German (de_DE) is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Exit if accessed directly
 *
 * @since 1.0.0
 */
if ( ! defined( 'WPINC' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Set constant for the plugin directory */
define( 'JPDE_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Set constant path to the Plugin basename (folder) */
define( 'JPDE_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );

/** Set constant path to the Plugin URI */
define( 'JPDE_PLUGIN_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );


add_action( 'plugins_loaded', 'ddw_jpde_load_helpers', 8 );
/**
 * Load helper functions early, to have them available now :).
 *
 * @since 1.7.0
 */
function ddw_jpde_load_helpers() {

	require_once( JPDE_PLUGIN_DIR . 'includes/jpde-get-settings.php' );

}  // end function


add_action( 'init', 'ddw_jpde_init' );
/**
 * Load the text domain for translation of this plugin.
 * Load admin helper functions - only within 'wp-admin'.
 * 
 * @since 1.0.0
 *
 * @uses  load_plugin_textdomain()
 * @uses  is_admin()
 * @uses  current_user_can()
 */
function ddw_jpde_init() {

	/** Set filter for plugin's languages directory */
	$jpde_lang_dir = apply_filters( 'jpde_filter_lang_dir', JPDE_PLUGIN_BASEDIR . 'jpde-languages/' );

	/** If 'wp-admin' include translations plus admin helper functions */
	if ( is_admin() ) {

		/** Load plugin textdomain plus translation files */
		load_plugin_textdomain( 'jetpack-german', FALSE, $jpde_lang_dir );

		include_once( JPDE_PLUGIN_DIR . 'includes/jpde-admin.php' );

	}  // end-if is_admin() check

	/** Add "Settings Page" link to plugin page - only within 'wp-admin' */
	if ( is_admin() && current_user_can( 'manage_options' ) ) {

		add_filter(
			'plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_jpde_settings_page_link'
		);

	}  // end-if is_admin() & cap check

	/** Include deprecated classes/ functions */
	include_once( JPDE_PLUGIN_DIR . 'includes/jpde-deprecated.php' );

}  // end of function ddw_jpde_init


/**
 * Get the Blog/ Site upload location location for URL or path, and for
 *    Multisite or not.
 *
 * Takes account of multisite usage, and domain mapping.
 *
 * @author StudioPress
 * @link   http://www.studiopress.com/
 * @author David Decker - DECKERWEB
 * @link   http://deckerweb.de/twitter
 *
 * @since  1.7.0
 *
 * @uses   wp_upload_dir()
 *
 * @param  string 	$type Either 'url' or anything else e.g. 'path'.
 *
 * @return string String of path or URL of WordPress upload directory.
 */
function ddw_jpde_get_site_upload_location( $type ) {

	/** Get the uploads directory -- supports Multisite of course */
	$uploads = wp_upload_dir();
	$dir     = ( 'url' == $type ) ? $uploads[ 'baseurl' ] : $uploads[ 'basedir' ];

	/** Return Blog/ Site upload location */
	return apply_filters( 'jpde_filter_get_site_upload_location', $dir . '/' );

}  // end of function ddw_jpde_get_site_upload_location


/**
 * Loading logic for (various) textdomains, based on different locations of the
 *    language files.
 *
 * @since  1.7.0
 *
 * @uses   get_locale() Get WPLANG locale string.
 * @uses   ddw_jpde_variant_is_formal() Holds setting for preferred language variant.
 * @uses   WP_LANG_DIR Defined global language location/ folder.
 * @uses   ddw_jpde_get_site_upload_location() Helps determine the path/URL string for upload location.
 * @uses   WP_PLUGIN_DIR Defined global plugin location/ folder.
 * @uses   load_textdomain() Loads translation file for a given textdomain.
 *
 * @param  array 	$textdomains Array of used textdomains for a plugin.
 * @param  string 	$slug The given plugin folder/ file slug.
 * @param  bool 	$neutral If a plugin ignores formal/ informal variants, and is "neutral".
 *
 * @return string Function load_textdomain() with given parameters.
 */
function ddw_jpde_load_custom_translations( $textdomains, $slug, $neutral = false ) {
	
	/** Get locale setting from WordPress */
	$locale = get_locale();

	$mofilepath = '';

	/** Language variant checks - formal/ informal */
	if ( ddw_jpde_variant_is_formal() ) {

		$variant_slug = ( ! $neutral ) ? 'sie-version/' : '';

	} elseif ( ! ddw_jpde_variant_is_formal() ) {

		$variant_slug = ( ! $neutral ) ? 'du-version/' : '';

	}  // end if


	/** Making base slug filterable */
	$jpde_main_slug = 'jetpack-de';
	$jpde_main_slug = apply_filters( 'jpde_filter_main_slug', esc_attr( $jpde_main_slug ) );

	/** WP_LANG_DIR file path to check/ load */
	$jpde_wp_lang_dir_path = trailingslashit( WP_LANG_DIR ) . $jpde_main_slug . '/' . $slug . '/' . $variant_slug . $slug . '-' . $locale . '.mo';

	/** WP_LANG_DIR custom file path to check/ load - especially for backwards compatibility */
	$jpde_wp_lang_dir_custom_path = trailingslashit( WP_LANG_DIR ) . 'jetpack-de/custom/' . $slug . '-' . $locale . '.mo';

	/** (Site) UPLOAD_DIR file path to check/ load */
	$jpde_upload_dir_path = ddw_jpde_get_site_upload_location( 'path' ) . $jpde_main_slug . '/' . $slug . '/' . $variant_slug . $slug . '-' . $locale . '.mo';

	/** WP_PLUGIN_DIR file path to check/ load --- fallback to our plugin! */
	$jpde_plugindir_slug = apply_filters(
		'jpde_filter_plugindir_slug',
		trailingslashit( dirname( plugin_basename( __FILE__ ) ) )
	);

	$jpde_plugin_path = trailingslashit( WP_PLUGIN_DIR ) . $jpde_plugindir_slug . 'jp-pomo/' . $slug . '/' . $variant_slug . $slug . '-' . $locale . '.mo';


	/** (1) WP_LANG_DIR branch: */
	if ( is_readable( $jpde_wp_lang_dir_path ) ) {

		$mofilepath = $jpde_wp_lang_dir_path;

	}

		/** (2) WP_LANG_DIR custom branch: */
	elseif ( is_readable( $jpde_wp_lang_dir_custom_path ) ) {
		
		$mofilepath = $jpde_wp_lang_dir_custom_path;

	}

		/** (3) UPLOAD_DIR branch: */
	elseif ( is_readable( $jpde_upload_dir_path ) ) {
		
		$mofilepath = $jpde_upload_dir_path;

	}

		/** (4) Plugin standard branch: */
	elseif ( is_readable( $jpde_plugin_path ) ) {

		$mofilepath = $jpde_plugin_path;

	}  // end if/ elseif language location folders


	/** Prepare for output of translations */
	if ( $mofilepath ) {

		/** Repeat for every given textdomain of our array */
		foreach ( (array) $textdomains as $textdomain ) {

			/** Finally load every textdomain from the given .mo file path */
			load_textdomain( $textdomain, $mofilepath );

		}  // end foreach

	}  // end if

}  // end of function ddw_jpde_load_custom_translations


add_action( 'plugins_loaded', 'ddw_jpde_translation_loader', 9 );
/**
 * Translation loader for loading translations, depending on location
 *    (frontend & admin; frontend only; admin only). For "Jetpack"
 *    (main plugin), plus third-party add-ons.
 *
 * @since 1.7.0
 *
 * @uses  ddw_jpde_loading_location() Holds setting of preferred location.
 * @uses  ddw_jpde_load_add_ons() Holds setting if add-ons should be loaded too.
 * @uses  is_admin() Check if we are within admin.
 */
function ddw_jpde_translation_loader() {
	
	/** Bail early, if no German locale environment */
	if ( ! ddw_jpde_is_german() ) {
		return;
	}

	/** Get plugin general options */
	$jpde_loading_location = ddw_jpde_loading_location();
	$jpde_load_add_ons     = ddw_jpde_load_add_ons();


	/** 1) Load translations global - both, frontend & admin */
	if ( 'both' === $jpde_loading_location ) {

		add_action( 'plugins_loaded', 'ddw_jpde_do_load_translations_jetpack' );

		if ( $jpde_load_add_ons ) {

			add_action( 'plugins_loaded', 'ddw_jpde_do_load_translations_jp_thirdparty_addons' );

		}  // end if settings check

	}

		/** 2) Load translations only within admin */
	elseif ( is_admin() && 'admin_only' === $jpde_loading_location ) {

		add_action( 'plugins_loaded', 'ddw_jpde_do_load_translations_jetpack' );

		if ( $jpde_load_add_ons ) {

			add_action( 'plugins_loaded', 'ddw_jpde_do_load_translations_jp_thirdparty_addons' );

		}  // end if settings check

	}

		/** 3) Load translations only in frontend */
	elseif ( ! is_admin() && 'frontend_only' === $jpde_loading_location ) {

		add_action( 'plugins_loaded', 'ddw_jpde_do_load_translations_jetpack' );

		if ( $jpde_load_add_ons ) {

			add_action( 'plugins_loaded', 'ddw_jpde_do_load_translations_jp_thirdparty_addons' );

		}  // end if settings check

	}  // end if is_admin() & settings checks

}  // end of function ddw_jpde_translation_loader


/**
 * Load actual translations for Jetpack main plugin.
 *
 * @since 1.7.0
 *
 * @uses  ddw_jpde_load_custom_translations() Load the textdomain(s) for translation.
 */
function ddw_jpde_do_load_translations_jetpack() {

	/** Unload packaged translation files */
	unload_textdomain( 'jetpack' );

	/** Load our custom translations */
	ddw_jpde_load_custom_translations(
		array(
			'jetpack',
			'default',
			'nova',
			'minileven',
			'next-saturday'
		),
		'jetpack'
	);

}  // end of function ddw_jpde_do_load_translations_jetpack


/**
 * Load actual translations for some third-party Jetpack add-on plugins.
 *
 * @since 1.0.0
 *
 * @uses  ddw_jpde_unique_plugin_check() Check for existing plugins (that are active).
 * @uses  ddw_jpde_load_custom_translations() Load the textdomains for translation.
 */
function ddw_jpde_do_load_translations_jp_thirdparty_addons() {

	$jpde_slug_base = 'jetpack-';

	$jpde_thirdparty_addons = array(

		/** Rocketeer [free] */
		'rocketeer' => array(
			'unique_check' => 'Rocketeer',	// class
			'slug'         => 'rocketeer',
			'variant'      => 'neutral',
			'textdomains'  => array(
				'rocketeer',
				'default'
			),
		),

		/** Jetpack Popular Posts [free] */
		'jetpack-popular-posts' => array(
			'unique_check' => 'JPP_Widget',	// class
			'slug'         => 'jetpack-popular-posts',
			'variant'      => 'neutral',
			'textdomains'  => array(
				'jetpack-popular-posts',
				'default',
				'jetpack'
			),
		),

		/** Jetpack Post Views [free] */
		'jetpack-post-views' => array(
			'unique_check' => 'Jetpack_Post_Views',	// class
			'slug'         => 'jetpack-post-views',
			'textdomains'  => array(
				'jetpack-post-views'
			),
		),

	);  // end of array


	/** Apply our translation loader for each add-on, if active */
	foreach ( $jpde_thirdparty_addons as $jpde_tpaddon => $tpaddon_id ) {

		/** Check for above add-ons if they exist (are active) */
		if ( ddw_jpde_unique_plugin_check( $tpaddon_id[ 'unique_check' ] ) ) {

			$is_neutral = ( ! isset( $tpaddon_id[ 'variant' ] ) ) ? FALSE : TRUE;

			/** Actually load the various textdomains for displaying translations */
			ddw_jpde_load_custom_translations(
				(array) $tpaddon_id[ 'textdomains' ],
				$tpaddon_id[ 'slug' ],
				$is_neutral
			);

		}  // end if

	}  // end foreach

}  // end of function ddw_jpde_do_load_translations_jp_thirdparty_addons


/**
 * Returns current plugin's header data in a flexible way.
 *
 * @since  1.0.0
 *
 * @uses   get_plugins()
 *
 * @param  $jpde_plugin_value
 *
 * @return string Plugin data.
 */
function ddw_jpde_plugin_get_data( $jpde_plugin_value ) {

	/** Bail early if we are not in wp-admin */
	if ( ! is_admin() ) {
		return;
	}

	/** Include WordPress plugin data */
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	$jpde_plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$jpde_plugin_file = basename( ( __FILE__ ) );

	return $jpde_plugin_folder[ $jpde_plugin_file ][ $jpde_plugin_value ];

}  // end of function ddw_jpde_plugin_get_data