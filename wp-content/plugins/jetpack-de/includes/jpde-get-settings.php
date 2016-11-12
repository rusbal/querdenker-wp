<?php
/**
 * Helper functions for getting setting values.
 *
 * @package    Jetpack German (de_DE)
 * @subpackage Settings
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/jetpack-de/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.7.0
 */

/**
 * Exit if accessed directly
 *
 * @since 1.7.0
 */
if ( ! defined( 'WPINC' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Helper function to determine if in a German locale based environment.
 *
 * @since  1.7.0
 *
 * @uses   get_option()
 * @uses   get_site_option()
 * @uses   get_locale()
 * @uses   ICL_LANGUAGE_CODE Constant of WPML premium plugin, if defined.
 *
 * @return bool If German-based locale, return TRUE, otherwise FALSE.
 */
function ddw_jpde_is_german() {

	/** Set array of German-based locale codes */
	$german_locales = array(
		'de_DE',
		'de_AT',
		'de_CH',
		'de_LU',
		'gsw'
	);

	/** Get possible WPLANG option values */
	$option_wplang      = get_option( 'WPLANG' );
	$site_option_wplang = get_site_option( 'WPLANG' );

	/**
	 * Check for German-based environment/ context in locale/ WPLANG setting
	 *    and/ or within WPML (premium plugin).
	 *
	 * NOTE: This is very important for multilingual sites and/or Multisite
	 *       installs.
	 */
	if ( ( in_array( get_locale(), $german_locales )
					|| ( $option_wplang && in_array( $option_wplang, $german_locales ) )
					|| ( $site_option_wplang && in_array( $site_option_wplang, $german_locales ) )
			)
			|| ( defined( 'ICL_LANGUAGE_CODE' ) && ( 'de' == ICL_LANGUAGE_CODE ) )
	) {

		/** Yes, we are in German-based environmet */
		return TRUE;

	} else {

		/** Non-German! */
		return FALSE;

	}  // end if

}  // end of function ddw_jpde_is_german


/**
 * Helper function for returning True or False if formal language variant is
 *    enabled.
 *
 * @since  1.7.0
 *
 * @uses   get_option() To get setting value from database.
 *
 * @return bool True, if formal language is used, otherwise false (= informal).
 */
function ddw_jpde_variant_is_formal() {
	
	/**
	 * Filter for custom set up for formal translation loading.
	 *
	 * Usage: add_filter( 'jpde_filter_set_formal', '__return_true' );
	 */
	return (bool) apply_filters( 'jpde_filter_set_formal', FALSE );

}  // end of function ddw_jpde_variant_is_formal


/**
 * Helper function for checking supported plugins by checking against unique
 *    classes, constants or functions.
 *
 * @since  1.7.0
 *
 * @param  string 	$identifier Name of a unique class, constant or function.
 *
 * @return bool True if class/ constant/ function exists, otherwise false.
 */
function ddw_jpde_unique_plugin_check( $identifier ) {
	
	$output = 'default';

	/** Check any unique class name */
	if ( class_exists( esc_attr( $identifier ) ) ) {

		$output = TRUE;

	}

		/** Check any unique constant name */
	elseif ( defined( esc_attr( $identifier ) ) ) {

		$output = TRUE;

	}

		/** Check any unique function name */
	elseif ( function_exists( esc_attr( $identifier ) ) ) {

		$output = TRUE;

	}  // end if

	/** Return the function */
	return $output;

}  // end of function ddw_jpde_unique_plugin_check


/**
 * Helper function
 *
 * @since 1.7.0
 */
function ddw_jpde_load_add_ons() {

	/**
	 * Filter for custom set up for translation loading of add-ons.
	 *
	 * Usage: add_filter( 'jpde_filter_load_add_ons', '__return_false' );
	 */
	return (bool) apply_filters( 'jpde_filter_load_add_ons', TRUE );

}  // end of function ddw_jpde_load_add_ons


/**
 * Helper function for setting a translation loading location - filterable.
 *
 * @since  1.7.0
 *
 * @return string Helper string, used for setting loading location.
 */
function ddw_jpde_loading_location() {

	/**
	 * Filter for custom set up for formal translation loading.
	 *
	 * Example usage:
	 *   add_filter( 'jpde_filter_loading_location', '__jpde_load_in_frontend_only' );
	 */
	$jpde_loading_location = apply_filters(
		'jpde_filter_loading_location',
		__jpde_load_in_both()
	);

	return esc_attr( $jpde_loading_location );

}  // end if ddw_jpde_loading_location


/**
 * Helper function for returning 'both' string.
 *
 * @since  1.7.0
 *
 * @return string String 'both'.
 */
function __jpde_load_in_both() {

	return 'both';

}  // end function


/**
 * Helper function for returning 'admin_only' string.
 *
 * @since  1.7.0
 *
 * @return string String 'admin_only'.
 */
function __jpde_load_in_admin_only() {

	return 'admin_only';

}  // end function


/**
 * Helper function for returning 'frontend_only' string.
 *
 * @since  1.7.0
 *
 * @return string String 'frontend_only'.
 */
function __jpde_load_in_frontend_only() {

	return 'frontend_only';

}  // end function