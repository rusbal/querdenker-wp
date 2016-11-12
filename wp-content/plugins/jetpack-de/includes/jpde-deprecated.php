<?php
/**
 * Deprecated functions & classes.
 *
 * @package    Jetpack German (de_DE)
 * @subpackage Deprecated
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
 * Deprecated.
 * Load the German Jetpack translations by DECKERWEB.
 *
 * @since 1.0.0
 */
function ddw_jpde_load_textdomain() {

	_deprecated_function( __FUNCTION__, '1.7.0' );

}  // end function


/**
 * Deprecated.
 * Additional filter 'load_textdomain_mofile' to enforce the loading of the
 *    German Jetpack translations by DECKERWEB.
 *
 * @since 1.4.2
 *
 * @param string $moFile
 * @param string $domain
 */
function ddw_jpde_load_textdomain_file( $moFile, $domain ) {

	_deprecated_function( __FUNCTION__, '1.7.0' );

}  // end function


/**
 * Deprecated.
 * To fix textdomain errors in Jetpack, load additional German Jetpack
 *    translations by DECKERWEB.
 *
 * @since 1.4.0
 */
function ddw_jpde_load_textdomain_fixes() {

	_deprecated_function( __FUNCTION__, '1.7.0' );

}  // end function