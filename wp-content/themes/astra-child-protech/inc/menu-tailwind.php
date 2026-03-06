<?php
/**
 * Menu : chargement garanti du style (inline) + Tailwind CDN et classes
 *
 * @package Astra_Child_Protech
 */

defined( 'ABSPATH' ) || exit;

/**
 * CSS critique du menu injecté dans la page (charge toujours avec le thème).
 */
function astra_child_protech_menu_inline_css() {
	$css = '
	/* Menu compact : barre noire basse, logo à gauche, liens centrés, bouton pill à droite */
	.ept-nav-bar {
		background: #000 !important;
		position: sticky;
		top: 0;
		z-index: 10000;
		min-height: 44px;
		width: 100%;
		box-shadow: 0 1px 8px rgba(0,0,0,0.4);
		display: flex;
		align-items: center;
		flex-wrap: nowrap;
		padding: 0 1rem;
		gap: 1rem;
		box-sizing: border-box;
	}
	.ept-nav-bar .main-header-menu {
		flex: 1 1 auto;
		min-width: 0;
		margin: 0;
		padding: 0;
		list-style: none;
		display: flex;
		align-items: center;
		flex-wrap: nowrap;
		gap: 0.25rem;
	}
	.ept-nav-bar .main-header-menu a {
		color: #fff !important;
		font-size: 0.8125rem;
		font-weight: 500;
		padding: 0.4rem 0.65rem;
		text-decoration: none !important;
		transition: color 0.2s;
	}
	.ept-nav-bar .main-header-menu a:hover { color: #FFEB3B !important; }
	.ept-nav-bar .main-header-menu .current-menu-item a,
	.ept-nav-bar .main-header-menu .ept-current-item a { color: #4CAF50 !important; font-weight: 600; }
	.ept-nav-bar .ept-nav-menu-wrap ul a {
		color: #fff !important;
		font-size: 0.8125rem;
		font-weight: 500;
		padding: 0.4rem 0.65rem;
		text-decoration: none !important;
		transition: color 0.2s;
	}
	.ept-nav-bar .ept-nav-menu-wrap ul a:hover { color: #FFEB3B !important; }
	.ept-nav-bar .ept-nav-menu-wrap .current-menu-item a,
	.ept-nav-bar .ept-nav-menu-wrap .ept-current-item a,
	.ept-nav-bar .ept-nav-menu-wrap .current_page_item a { color: #4CAF50 !important; font-weight: 600; }
	.ept-nav-bar-inner {
		display: flex;
		align-items: center;
		justify-content: flex-end;
		flex-shrink: 0;
		min-height: 44px;
		gap: 1rem;
	}
	.ept-nav-logo {
		font-size: 1.125rem;
		font-weight: 700;
		color: #FFC107 !important;
		text-decoration: none !important;
		flex-shrink: 0;
		display: flex;
		align-items: center;
	}
	.ept-nav-logo:hover { color: #FFEB3B !important; }
	.ept-nav-logo-img {
		display: block;
		height: 30px;
		width: auto;
		max-width: 160px;
		object-fit: contain;
		vertical-align: middle;
	}
	.ept-nav-bar .ept-nav-menu-wrap {
		flex: 1 1 auto;
		min-width: 0;
		display: flex !important;
		align-items: center;
		visibility: visible !important;
		opacity: 1 !important;
	}
	.ept-nav-bar .ept-nav-menu-wrap > ul,
	.ept-nav-bar .ept-nav-menu-wrap ul.main-header-menu,
	.ept-nav-bar .ept-nav-menu-wrap .menu ul {
		display: flex !important;
		flex: 1 1 auto;
		min-width: 0;
		margin: 0 !important;
		padding: 0 !important;
		list-style: none !important;
		align-items: center;
		flex-wrap: nowrap;
		gap: 0.25rem;
		visibility: visible !important;
		opacity: 1 !important;
	}
	.ept-nav-bar .ept-nav-menu-wrap ul li { margin: 0; }
	.ept-nav-bar .ept-nav-bar-logo { justify-content: flex-start; flex-shrink: 0; }
	.ept-nav-bar .ept-nav-bar-cta-wrap { justify-content: flex-end; flex-shrink: 0; }
	.ept-nav-menu {
		display: flex;
		align-items: center;
		flex-wrap: nowrap;
		gap: 0.1rem;
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.ept-nav-menu li { margin: 0; }
	.ept-nav-menu a {
		display: block;
		padding: 0.4rem 0.65rem;
		font-size: 0.8125rem;
		font-weight: 500;
		color: #fff !important;
		text-decoration: none !important;
		transition: color 0.2s;
	}
	.ept-nav-menu a:hover { color: #FFEB3B !important; }
	.ept-nav-menu .current-menu-item a,
	.ept-nav-menu .ept-current-item a { color: #4CAF50 !important; font-weight: 600; }
	.ept-nav-cta {
		display: inline-block;
		padding: 0.4rem 1rem;
		background: #FFC107 !important;
		color: #111111 !important;
		font-weight: 600;
		font-size: 0.8125rem;
		text-decoration: none !important;
		border-radius: 9999px;
		transition: background 0.2s;
		flex-shrink: 0;
	}
	.ept-nav-cta:hover { background: #FFEB3B !important; color: #111111 !important; }
	@media (max-width: 1023px) {
		.ept-nav-bar-inner { padding: 0 0.75rem; gap: 0.5rem; }
		.ept-nav-logo-img { height: 26px; max-width: 130px; }
		.ept-nav-menu a { padding: 0.35rem 0.5rem; font-size: 0.75rem; }
		.ept-nav-cta { padding: 0.35rem 0.75rem; font-size: 0.75rem; }
	}
	#ast-desktop-header,
	.ast-main-header-wrap,
	.ast-site-header-wrap,
	.ast-below-header,
	.ast-below-header-wrap { display: none !important; }
	#masthead { min-height: 0 !important; height: auto !important; padding-bottom: 0 !important; }
	';
	wp_add_inline_style( 'astra-child-protech', $css );
}
add_action( 'wp_enqueue_scripts', 'astra_child_protech_menu_inline_css', 16 );

/**
 * Tailwind Play CDN (développement / fallback design).
 */
function astra_child_protech_tailwind_cdn() {
	if ( is_admin() ) {
		return;
	}
	wp_enqueue_script(
		'tailwind-play-cdn',
		'https://cdn.tailwindcss.com',
		array(),
		'3.4',
		true
	);
	// Config Tailwind : couleurs charte graphique logo (vert, or, bleu, neutres)
	$config = 'tailwind.config = { theme: { extend: { colors: { protech: { green: "#2E7D32", "green-light": "#4CAF50", "green-bright": "#8BC34A", blue: "#1565C0", "blue-medium": "#2196F3", gold: "#FFC107", yellow: "#FFEB3B", black: "#111111", "gray-dark": "#37474F", "gray-mid": "#78909C", "gray-light": "#ECEFF1" } } } } }';
	wp_add_inline_script( 'tailwind-play-cdn', $config, 'before' );
}
add_action( 'wp_enqueue_scripts', 'astra_child_protech_tailwind_cdn', 5 );

/**
 * Walker personnalisé : ajoute des classes Tailwind au menu (en plus du CSS inline).
 */
class Astra_Child_Protech_Menu_Walker extends Walker_Nav_Menu {

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$is_current = in_array( 'current-menu-item', $classes, true );
		if ( $is_current ) {
			$classes[] = 'ept-current-item';
		}
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$output .= $indent . '<li class="' . esc_attr( $class_names ) . '">';
		$link_class = $is_current ? 'ept-current-link' : '';
		$atts = array(
			'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
			'target' => ! empty( $item->target ) ? $item->target : '',
			'rel'    => ! empty( $item->xfn ) ? $item->xfn : '',
			'href'   => ! empty( $item->url ) ? $item->url : '',
			'class'  => $link_class,
		);
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		$item_output  = ( $args instanceof \WP_Nav_Menu_Args ? $args->before : '' );
		$item_output .= '<a' . $attributes . '>';
		$item_output .= ( $args instanceof \WP_Nav_Menu_Args ? $args->link_before : '' ) . apply_filters( 'the_title', $item->title, $item->ID ) . ( $args instanceof \WP_Nav_Menu_Args ? $args->link_after : '' );
		$item_output .= '</a>';
		$item_output .= ( $args instanceof \WP_Nav_Menu_Args ? $args->after : '' );
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

/**
 * Utiliser notre Walker pour le menu primary (ajoute ept-current-item / ept-current-link).
 */
function astra_child_protech_nav_menu_args( $args ) {
	if ( isset( $args['theme_location'] ) && $args['theme_location'] === 'primary' ) {
		$args['walker'] = new Astra_Child_Protech_Menu_Walker();
	}
	return $args;
}
add_filter( 'wp_nav_menu_args', 'astra_child_protech_nav_menu_args', 20 );
