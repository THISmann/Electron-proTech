<?php
/**
 * Astra Child proTech Solaire – Functions and hooks
 *
 * @package Astra_Child_Protech
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme version (for cache busting).
 */
define( 'ASTRA_CHILD_PROTECH_VERSION', '1.2.0' );

/**
 * Enqueue parent and child styles; preload fonts.
 */
function astra_child_protech_enqueue_styles() {
	wp_enqueue_style(
		'astra-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		ASTRA_CHILD_PROTECH_VERSION
	);
	wp_enqueue_style(
		'astra-child-protech',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'astra-parent' ),
		ASTRA_CHILD_PROTECH_VERSION
	);
	wp_enqueue_style(
		'astra-child-protech-vitrine',
		get_stylesheet_directory_uri() . '/assets/css/vitrine.css',
		array( 'astra-child-protech' ),
		ASTRA_CHILD_PROTECH_VERSION
	);

	// Preload Inter for performance (optional: add Poppins if preferred)
	wp_enqueue_style(
		'protech-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'astra_child_protech_enqueue_styles', 15 );

/**
 * Charge les overrides Electron ProTech en dernier pour battre Astra + Elementor.
 */
function astra_child_protech_enqueue_overrides() {
	$deps = array( 'astra-child-protech' );
	if ( wp_style_is( 'elementor-frontend', 'registered' ) ) {
		$deps[] = 'elementor-frontend';
	}
	wp_enqueue_style(
		'astra-child-protech-overrides',
		get_stylesheet_directory_uri() . '/assets/css/overrides.css',
		$deps,
		ASTRA_CHILD_PROTECH_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'astra_child_protech_enqueue_overrides', 999 );

/**
 * Register Elementor locations for child theme (full width, etc.).
 */
function astra_child_protech_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'astra_child_protech_register_elementor_locations' );

/**
 * Body class for scoping child styles + slug courant pour menu actif.
 */
function astra_child_protech_body_class( $classes ) {
	$classes[] = 'astra-child-protech';
	$obj = get_queried_object();
	if ( $obj && isset( $obj->post_name ) ) {
		$classes[] = 'ept-page-slug-' . sanitize_html_class( $obj->post_name );
	}
	if ( is_front_page() ) {
		$classes[] = 'ept-is-home';
	}
	return $classes;
}
add_filter( 'body_class', 'astra_child_protech_body_class' );

/**
 * Script : marquer le lien du menu correspondant à l’URL courante (fix menu actif).
 */
function astra_child_protech_enqueue_menu_script() {
	if ( is_admin() ) {
		return;
	}
	wp_enqueue_script(
		'astra-child-protech-menu-current',
		get_stylesheet_directory_uri() . '/assets/js/menu-current.js',
		array(),
		ASTRA_CHILD_PROTECH_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'astra_child_protech_enqueue_menu_script', 20 );

/**
 * Script : menu hamburger mobile (toggle, fermeture Escape/clic extérieur).
 */
function astra_child_protech_enqueue_hamburger_script() {
	if ( is_admin() ) {
		return;
	}
	wp_enqueue_script(
		'astra-child-protech-nav-hamburger',
		get_stylesheet_directory_uri() . '/assets/js/nav-hamburger.js',
		array(),
		ASTRA_CHILD_PROTECH_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'astra_child_protech_enqueue_hamburger_script', 21 );

/**
 * Script carrousel hero (5 slides) – actif dès que #hero-carousel-track est présent
 */
function astra_child_protech_enqueue_hero_carousel() {
	if ( is_admin() ) {
		return;
	}
	wp_enqueue_script(
		'astra-child-protech-hero-carousel',
		get_stylesheet_directory_uri() . '/assets/js/hero-carousel.js',
		array(),
		ASTRA_CHILD_PROTECH_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'astra_child_protech_enqueue_hero_carousel', 25 );

/**
 * Load modular includes (CPT, shortcodes, snippets).
 */
function astra_child_protech_load_inc() {
	$inc_dir = get_stylesheet_directory() . '/inc/';
	$files   = array(
		'cpt-realisations.php',
		'calculateur-economies.php',
		'whatsapp-float.php',
		'seo-schema.php',
		'header-top-bar.php',
		'menu-tailwind.php',
	);
	foreach ( $files as $file ) {
		$path = $inc_dir . $file;
		if ( is_readable( $path ) ) {
			require_once $path;
		}
	}
}
add_action( 'after_setup_theme', 'astra_child_protech_load_inc', 20 );

/**
 * Native lazy loading for images (WordPress 5.5+); ensure loading="lazy" on content images.
 */
function astra_child_protech_lazy_load_attributes( $attr, $attachment, $size ) {
	if ( is_admin() || ( isset( $attr['loading'] ) && $attr['loading'] === 'lazy' ) ) {
		return $attr;
	}
	// Above-the-fold images (e.g. hero) can keep default; rest get lazy
	if ( ! isset( $attr['loading'] ) ) {
		$attr['loading'] = 'lazy';
		$attr['decoding'] = 'async';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'astra_child_protech_lazy_load_attributes', 10, 3 );

/**
 * Add theme support for title-tag and responsive embeds (best practices 2026).
 */
function astra_child_protech_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'astra_child_protech_setup', 25 );
