<?php
/**
 * Helper functions for the admin - plugin links.
 *
 * @package    Jetpack German (de_DE)
 * @subpackage Admin
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2013, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/jetpack-de/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.0.0
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
 * Setting internal plugin helper links constants
 *
 * @since 1.0.0
 *
 * @uses  ddw_jpde_is_german() Our helper function to detect German based environmet.
 */
define( 'JPDE_URL_TRANSLATE',		'http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/jetpack-de' );
define( 'JPDE_URL_WPORG_FAQ',		'http://wordpress.org/plugins/jetpack-de/faq/' );
define( 'JPDE_URL_WPORG_FORUM',		'http://wordpress.org/support/plugin/jetpack-de' );
define( 'JPDE_URL_WPORG_PROFILE',	'http://profiles.wordpress.org/daveshine/' );
define( 'JPDE_PLUGIN_LICENSE', 		'GPL-2.0+' );

if ( ddw_jpde_is_german() ) {

	define( 'JPDE_URL_DONATE',		'http://deckerweb.de/sprachdateien/spenden/' );
	define( 'JPDE_URL_PLUGIN',		'http://genesisthemes.de/plugins/jetpack-de/' );
	define( 'JPDE_IS_GERMAN',		TRUE );

} else {

	define( 'JPDE_URL_DONATE',		'http://genesisthemes.de/en/donate/' );
	define( 'JPDE_URL_PLUGIN',		'http://genesisthemes.de/en/wp-plugins/jetpack-de/' );
	define( 'JPDE_IS_GERMAN',		FALSE );

}  // end if


/**
 * Add "Settings" link to plugin page
 *
 * @since  1.0.0
 *
 * @param  $jpde_links
 *
 * @return strings Admin settings page link.
 */
function ddw_jpde_settings_page_link( $jpde_links ) {

	/** Define Jetpack/ SlimJetpack/ Jetpack Lite admin url */
	if ( is_plugin_active( 'slimjetpack/slimjetpack.php' ) || is_plugin_active( 'jetpack-lite/jetpack-lite.php' ) ) {
		$jpde_jp_admin_url = admin_url( 'options-general.php?page=jetpack' );
	} else {
		$jpde_jp_admin_url = admin_url( 'admin.php?page=jetpack' );
	}

	/** Jetpack setting page link */
	$jpde_settings_link = sprintf(
		'<a href="%s" title="%s">%s</a>',
		$jpde_jp_admin_url,
		__( 'Go to the Jetpack settings page', 'jetpack-german' ),
		__( 'Jetpack Settings', 'jetpack-german' )
	);

	/** Set the order of the links */
	array_unshift( $jpde_links, $jpde_settings_link );

	/** Display plugin settings links */
	return apply_filters( 'jpde_filter_settings_page_link', $jpde_links );

}  // end of function ddw_jpde_settings_page_link


add_filter( 'plugin_row_meta', 'ddw_jpde_plugin_links', 10, 2 );
/**
 * Add various support links to plugin page
 *
 * @since  1.0.0
 *
 * @param  $jpde_links
 * @param  $jpde_file
 *
 * @return strings Plugin links.
 */
function ddw_jpde_plugin_links( $jpde_links, $jpde_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {

		return $jpde_links;

	}  // end-if cap check

	/** List additional links only for this plugin */
	if ( $jpde_file == JPDE_PLUGIN_BASEDIR . 'jetpack-de.php' ) {

		$jpde_links[] = '<a href="' . esc_url( JPDE_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'jetpack-german' ) . '">' . __( 'FAQ', 'jetpack-german' ) . '</a>';

		$jpde_links[] = '<a href="' . esc_url( JPDE_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'jetpack-german' ) . '">' . __( 'Support', 'jetpack-german' ) . '</a>';

		$jpde_links[] = '<a href="' . esc_url( JPDE_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'jetpack-german' ) . '">' . __( 'Translations', 'jetpack-german' ) . '</a>';
		
		$jpde_links[] = '<a href="' . esc_url( JPDE_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'jetpack-german' ) . '"><strong>' . __( 'Donate', 'jetpack-german' ) . '</strong></a>';

		/** Add legal notice link for German locales */
		if ( JPDE_IS_GERMAN ) {

			$jpde_links[] = '<a href="' . JPDE_PLUGIN_URI . 'rechtshinweise/liesmich.html" target="_new" title="Rechtshinweise"><strong>*Rechtshinweise*</strong></a>';

		}  // end if isGerman check

	}  // end-if plugin links

	/** Output the links */
	return apply_filters( 'jpde_filter_plugin_links', $jpde_links );

}  // end of function ddw_jpde_plugin_links


add_action( 'load-edit.php', 'ddw_jpde_jetpack_cpt_load_help', 100 );
/**
 * Load plugin help tab on Jetpack's CPT pages.
 *
 * @since  1.1.0
 *
 * @uses   get_current_screen() Get current admin screen (hook).
 * @uses   WP_Screen::add_help_tab() Add help tabs.
 * @uses   WP_Screen::set_help_sidebar() Set help sidebar.
 * @uses   ddw_jpde_jetpack_help_sidebar_content() Content for help sidebar.
 *
 * @global mixed $jpde_jetpack_screen, $post
 */
function ddw_jpde_jetpack_cpt_load_help() {

	global $jpde_jetpack_screen, $post;

	$jpde_jetpack_screen = get_current_screen();

	/** Check for CPT screens */
	if ( ( 'edit' == $jpde_jetpack_screen->base
			|| 'post' == $jpde_jetpack_screen->base
			|| 'post-new' == $jpde_jetpack_screen->base
		) && ( 'feedback' == $jpde_jetpack_screen->post_type
				|| 'jetpack-comic' == $jpde_jetpack_screen->post_type
				|| 'nova_menu_item' == $jpde_jetpack_screen->post_type
				|| 'jetpack-testimonial' == $jpde_jetpack_screen->post_type
		)
	) {

		/** Add the help tab */
		$jpde_jetpack_screen->add_help_tab( array(
			'id'       => 'jpde-jetpack-help',
			'title'    => __( 'Jetpack German (de_DE)', 'jetpack-german' ),
			'callback' => 'ddw_jpde_jetpack_help_content',
		) );

		/** Add help sidebar */
		$jpde_jetpack_screen->set_help_sidebar( ddw_jpde_jetpack_help_sidebar_content() );

	}  // end-if screen check

}  // end of function ddw_jpde_jetpack_cpt_load_help


add_action( 'load-toplevel_page_jetpack', 'ddw_jpde_jetpack_help_tab', 5 );
add_action( 'load-jetpack_page_stats', 'ddw_jpde_jetpack_help_tab', 5 );
add_action( 'load-jetpack_page_omnisearch', 'ddw_jpde_jetpack_help_tab', 5 );
add_action( 'load-settings_page_sharing', 'ddw_jpde_jetpack_help_tab', 5 );
add_action( 'load-jetpack_page_rocketeer', 'ddw_jpde_jetpack_help_tab' );			// Add-On
add_action( 'load-settings_page_jetpack_post_views', 'ddw_jpde_jetpack_help_tab' );	// Add-On
/**
 * Create and display plugin help tab.
 *
 * @since  1.0.0
 *
 * @uses   get_current_screen()
 * @uses   WP_Screen::add_help_tab()
 * @uses   WP_Screen::set_help_sidebar()
 * @uses   ddw_jpde_jetpack_help_sidebar_content()
 *
 * @global mixed $jpde_jetpack_screen
 */
function ddw_jpde_jetpack_help_tab() {

	global $jpde_jetpack_screen;

	$jpde_jetpack_screen = get_current_screen();

	/** Display help tabs only for WordPress 3.3 or higher */
	if ( ! class_exists( 'WP_Screen' )
		|| ! $jpde_jetpack_screen
	) {
		return;
	}

	/** Add the help tab */
	$jpde_jetpack_screen->add_help_tab( array(
		'id'       => 'jpde-jetpack-help',
		'title'    => __( 'Jetpack German (de_DE)', 'jetpack-german' ),
		'callback' => 'ddw_jpde_jetpack_help_content',
	) );

	/** Add help sidebar */
	$jpde_jetpack_screen->set_help_sidebar( ddw_jpde_jetpack_help_sidebar_content() );

}  // end of function ddw_jpde_jetpack_help_tab


/**
 * Create and display plugin help tab content.
 *
 * @since  1.0.0
 *
 * @uses   ddw_jpde_plugin_get_data()
 *
 * @global mixed $jpde_jetpack_screen, $pagenow
 */
function ddw_jpde_jetpack_help_content() {

	echo '<h3>' . __( 'Plugin', 'jetpack-german' ) . ': ' . __( 'Jetpack German (de_DE)', 'jetpack-german' ) . ' <small>v' . esc_attr( ddw_jpde_plugin_get_data( 'Version' ) ) . '</small></h3>';

		$jpde_legal_style = 'style="color: #cc0000;"';

		/** FAQ/Legal info for German users */
		if ( JPDE_IS_GERMAN ) {

			echo '<h4>Allgemeine Datenschutz-bezogene bzw. rechtliche Hinweise:</h4>' .
				'<ul>';

			echo '<li ' . $jpde_legal_style . '"><em><strong>Haftungsausschluss:</strong> Durch den Einsatz dieses Plugins und der damit angebotenen Sprachdateien entstehen KEINE Garantien für eine korrekte Funktionsweise oder etwaige Verpflichtungen durch den Übersetzer bzw. Plugin-Anbieter! — Alle Angaben ohne Gewähr. Änderungen und Irrtümer ausdrücklich vorbehalten. Verwendung des Plugins inkl. Sprachdateien geschieht ausschliesslich auf eigene Verantwortung!</em></li>' .
				'<li><strong ' . $jpde_legal_style . '><em>Hinweis 1:</em></strong> Dieses Plugin ist ein reines Sprach-/ Übersetzungs-Plugin, es hat nichts mit Datenschutz bzw. "Rechtssicherheit" zu tun. Für alle datenschutz-rechtlichen Fragen ist der Webseiten-Betreiber zuständig, nicht die "Sprachdatei"!</li>' .
				'<li><strong ' . $jpde_legal_style . '><em>Hinweis 2:</em></strong> Eine RechtsBERATUNG zu diesem Themenkomplex kann NUR durch einen ANWALT erfolgen (am besten auf Online-Recht spezilisierte Anwälte!). -- Ich als Übersetzer und Plugin-Entwickler kann via Sprachdatei KEINE Datenschutz- bzw. "Rechtssicherheit" garantieren, dies können nur Webseiten-Betreiber selbst, mit anwaltlicher Unterstützung!</li>';

			echo '</ul>';

		}  // end if isGerman check


		echo '<h4>Spezielle Plugin-bezogene Hinweise:</h4>' .
			'<ul>' .
				'<li><strong ' . $jpde_legal_style . '><em>Übersetzung des Statistik-Moduls sowie des Jetpack-eigenen Kommentarformulars:</em></strong> Beides ist bisher leider gar nicht möglich, da dies direkt von WordPress.com geladen wird - bei den Kommentaren sogar in einem Iframe. Ein Zugriff darauf ist nicht möglich! Die deutsche Interface-Übersetzung von WordPress.com - sofern vorhanden - ist bisher ausschließlich in der informellen DU-Anrede verfügbar. Ein Einfluß darauf über die Sprachdatei bzw. dieses Sprach-Plugin ist <u>nicht</u> möglich, daher auch keine eigene Anpassung oder Umstellung auf SIE-Anrede! &mdash; Am besten Feedback und Beschwerden/ Eingaben dazu schreiben im <a href="http://wordpress.org/support/plugin/jetpack" target="_new" title="offizielles Jetpack-Forum (Engl.)">offiziellen Jetpack-Forum (Engl.)</a> bzw. bei <a href="http://en.forums.wordpress.com/tags/jetpack" target="_new" title="WordPress.com Support-Forum (Engl.)">WordPress.com</a>/ <a href="http://de.forums.wordpress.com/tags/jetpack" target="_new" title="deutsches WordPress.com Support-Forum">deutsches Forum</a>. <em>&mdash;Danke!</em></li>';

		/** Check for formal language file - to add certain help texts */
		if ( ! is_readable( WP_LANG_DIR . '/jetpack-de/formal/jetpack-de_DE.mo' ) && JPDE_IS_GERMAN ) {

			echo '<li><em><strong>Wie kann die SIE-Version der Sprachdatei aktiviert werden?</strong></em>' .
				'<br />&raquo; Einfach eine entsprechende Sprachdatei mit diesem Dateinamen <code>jetpack-de_DE.mo</code> in folgenden Ordner von WordPress einfügen: <code>/wp-content/languages/jetpack-de/formal/</code> &ndash; dann lädt das Plugin automatisch diese Datei und ignoriert alle anderen!' .
				'<br />&raquo; Die Bonus-Datei dafür ist im Plugin-Ordner <code>/bonus_sie-version/</code> enthalten :-)' .
				'<br />&raquo; Dieser Ablageort wird von Plugin-Aktualisierungen nicht unterstützt und muss daher selbst gepflegt werden.</li>';

		}  // end-if file check

		/** Check for custom language file - to add certain help texts */
		if ( ! is_readable( WP_LANG_DIR . '/jetpack-de/custom/jetpack-de_DE.mo' ) && JPDE_IS_GERMAN ) {

			echo '<li><em><strong>Wie kann ich meine eigene Sprachdatei nutzen?</strong></em>' .
				'<br />&raquo; Einfach eine entsprechende Sprachdatei mit diesem Dateinamen <code>jetpack-de_DE.mo</code> in folgenden Ordner von WordPress einfügen: <code>/wp-content/languages/jetpack-de/custom/</code> &ndash; dann lädt das Plugin automatisch diese Datei und ignoriert alle anderen!' .
				'<br />&raquo; Dieser Ablageort wird von Plugin-Aktualisierungen nicht unterstützt und muss daher selbst gepflegt werden.</li>';

		}  // end-if file check

		echo '<li><em>' . __( 'Other, recommended Jetpack plugins', 'jetpack-german' ) . '</em>:';

			/** Optional: recommended plugins */
			if ( ! class_exists( 'CWS_Manual_Control_for_Jetpack_Plugin' ) ) {

				echo '<br />&raquo; <a href="http://wordpress.org/plugins/manual-control/" target="_new" title="Manual Control for Jetpack">Manual Control for Jetpack</a> &mdash; Jetpack aktiviert automatisch neue Module, ohne nach der Berechtigung zu fragen. Dieses Plugin stoppt dieses Verhalten!';

			}  // end-if plugin check

			if ( ! class_exists( 'Rocketeer' ) ) {

				echo '<br />&raquo; <a href="http://wordpress.org/plugins/rocketeer/" target="_new" title="Rocketeer">Rocketeer</a> &mdash; Viel übersichtlichere, erweitertete Kontrolle über alle Jetpack Module.';

			}  // end-if plugin check

			if ( ! function_exists( 'fbe_export_to_csv' ) ) {

				echo '<br />&raquo; <a href="http://wordpress.org/plugins/jetpack-feedback-exporter/" target="_new" title="Jetpack Feedback Exporter">Jetpack Feedback Exporter</a> &mdash; Ermöglicht den Export von Jetpack Feedback-Daten (Kontaktformular) als CSV-Datei.';

			}  // end-if plugin check

			if ( ! function_exists( 'CF7DBPlugin_i18n_init' ) ) {

				echo '<br />&raquo; <a href="http://wordpress.org/plugins/contact-form-7-to-database-extension/" target="_new" title="Jetpack/ Contact Form 7 to Database Extension">Jetpack/ Contact Form 7 to Database Extension</a> &mdash; Speichert Einträge des Jetpack Kontaktformular-Moduls (Feedback) als Datenbank-Daten und macht diese daher exportfähig. Kann mitunter sehr nützlich sein!';

			}  // end-if plugin check

		echo '<br />&raquo; <a href="http://wordpress.org/plugins/search.php?q=jetpack" target="_new" title="' . __( 'More free plugins/extensions at WordPress.org', 'jetpack-german' ) . ' &hellip;">' . __( 'More free plugins/extensions at WordPress.org', 'jetpack-german' ) . ' &hellip;</a></li>' .
		'</ul>' .
		'<p><strong>' . __( 'Important plugin links:', 'jetpack-german' ) . '</strong>' . 
		'<br /><a href="' . esc_url( JPDE_URL_PLUGIN ) . '" target="_new" title="' . __( 'Plugin website', 'jetpack-german' ) . '">' . __( 'Plugin website', 'jetpack-german' ) . '</a> | <a href="' . esc_url( JPDE_URL_WPORG_FAQ ) . '" target="_new" title="' . __( 'FAQ', 'jetpack-german' ) . '">' . __( 'FAQ', 'jetpack-german' ) . '</a> | <a href="' . esc_url( JPDE_URL_WPORG_FORUM ) . '" target="_new" title="' . __( 'Support', 'jetpack-german' ) . '">' . __( 'Support', 'jetpack-german' ) . '</a> | <a href="' . esc_url( JPDE_URL_TRANSLATE ) . '" target="_new" title="' . __( 'Translations', 'jetpack-german' ) . '">' . __( 'Translations', 'jetpack-german' ) . '</a> | <a href="' . esc_url( JPDE_URL_DONATE ) . '" target="_new" title="' . __( 'Donate', 'jetpack-german' ) . '"><strong ' . $jpde_legal_style . '>' . __( 'Donate', 'jetpack-german' ) . '</strong></a>';

		/** Legal notice link for German locales */
		if ( JPDE_IS_GERMAN ) {

			echo ' | <a href="' . JPDE_PLUGIN_URI . 'rechtshinweise/liesmich.html" target="_new" title="Rechtshinweise"><strong>*Rechtshinweise*</strong></a>';

		}  // end if isGerman check

		echo '</p>';

		echo '<p><a href="http://www.opensource.org/licenses/gpl-license.php" target="_new" title="' . esc_attr( JPDE_PLUGIN_LICENSE ). '">' . esc_attr( JPDE_PLUGIN_LICENSE ). '</a> &copy; 2012-' . date( 'Y' ) . ' <a href="' . esc_url( ddw_jpde_plugin_get_data( 'AuthorURI' ) ) . '" target="_new" title="' . esc_attr__( ddw_jpde_plugin_get_data( 'Author' ) ) . '">' . esc_attr__( ddw_jpde_plugin_get_data( 'Author' ) ) . '</a></p>';

}  // end of function ddw_jpde_jetpack_help_tab_content


/**
 * Helper function for returning the Help Sidebar content.
 *
 * @since  1.1.0
 *
 * @uses   ddw_jpde_plugin_get_data()
 *
 * @return string/HTML of help sidebar content.
 */
function ddw_jpde_jetpack_help_sidebar_content() {

	$jpde_help_donate = '<p><a href="' . esc_url( JPDE_URL_DONATE ) . '" target="_new" title="* Spenden für Übersetzungen *"><strong>* Spenden für Übersetzungen *</strong></a></p><br />';

	$jpde_help_sidebar = '<p><strong>' . __( 'More about the plugin author', 'jetpack-german' ) . '</strong></p>' .
				'<p>' . __( 'Social:', 'jetpack-german' ) . '<br /><a href="http://twitter.com/deckerweb" target="_blank" title="@ Twitter">Twitter</a> | <a href="http://www.facebook.com/deckerweb.service" target="_blank" title="@ Facebook">Facebook</a> | <a href="http://deckerweb.de/gplus" target="_blank" title="@ Google+">Google+</a> | <a href="' . esc_url( ddw_jpde_plugin_get_data( 'AuthorURI' ) ) . '" target="_blank" title="@ deckerweb.de">deckerweb</a></p>' .
				'<p><a href="' . esc_url( JPDE_URL_WPORG_PROFILE ) . '" target="_blank" title="@ WordPress.org">@ WordPress.org</a></p>';

	return apply_filters( 'jpde_filter_help_sidebar_content', $jpde_help_donate . $jpde_help_sidebar );

}  // end of function ddw_jpde_jetpack_help_sidebar_content