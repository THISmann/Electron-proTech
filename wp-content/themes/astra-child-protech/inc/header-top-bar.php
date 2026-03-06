<?php
/**
 * Header à deux barres : barre supérieure (dégradé + logo + utilitaires)
 *
 * @package Astra_Child_Protech
 */

defined( 'ABSPATH' ) || exit;

/**
 * Numéro de téléphone affiché dans la barre supérieure (format affiché libre).
 */
function astra_child_protech_header_phone() {
	return (string) apply_filters( 'protech_header_phone', '+237 6 00 00 00 00' );
}

/**
 * Fallback pour la navigation : affiche des liens vers les pages principales si aucun menu n'est assigné à "primary".
 * Utilise la même structure (ul.main-header-menu) que wp_nav_menu pour que le CSS s'applique.
 */
function astra_child_protech_nav_fallback( $args ) {
	$menu_class = isset( $args['menu_class'] ) ? $args['menu_class'] : 'main-header-menu';
	$slugs      = array(
		'accueil'                => __( 'Accueil', 'astra-child-protech' ),
		'a-propos'               => __( 'À propos', 'astra-child-protech' ),
		'realisations'           => __( 'Réalisations', 'astra-child-protech' ),
		'installation-solaire'   => __( 'Installation solaire', 'astra-child-protech' ),
		'maintenance-sav'        => __( 'Maintenance & SAV', 'astra-child-protech' ),
		'simulateur'             => __( 'Simulateur', 'astra-child-protech' ),
		'references-temoignages' => __( 'Références', 'astra-child-protech' ),
		'blog'                   => __( 'Blog', 'astra-child-protech' ),
		'contact'                => __( 'Contact', 'astra-child-protech' ),
	);
	$items = array();
	foreach ( $slugs as $slug => $label ) {
		$page = get_page_by_path( $slug, OBJECT, 'page' );
		if ( $page && 'publish' === $page->post_status ) {
			$url  = get_permalink( $page );
			$items[] = '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
		} elseif ( 'accueil' === $slug || 'contact' === $slug ) {
			$url  = 'accueil' === $slug ? home_url( '/' ) : home_url( '/contact/' );
			$items[] = '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
		}
	}
	if ( empty( $items ) ) {
		$items[] = '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Accueil', 'astra-child-protech' ) . '</a></li>';
		$items[] = '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html__( 'Contact', 'astra-child-protech' ) . '</a></li>';
	}
	echo '<ul class="' . esc_attr( $menu_class ) . '" role="menubar">' . "\n" . implode( "\n", $items ) . "\n" . '</ul>';
}

/**
 * Affiche la barre de navigation unique (fond noir, logo Electron ProTech, liens blancs, bouton CTA).
 */
function astra_child_protech_header_top_bar() {
	$home_url   = esc_url( home_url( '/' ) );
	$site_name  = get_bloginfo( 'name', 'display' );
	$logo_path  = get_stylesheet_directory() . '/assets/images/logo-electron-protech.png';
	$logo_url   = get_stylesheet_directory_uri() . '/assets/images/logo-electron-protech.png';
	$use_logo   = file_exists( $logo_path );
	$contact_p  = get_page_by_path( 'contact', OBJECT, 'page' );
	$contact_url = $contact_p ? get_permalink( $contact_p ) : home_url( '/contact/' );
	$contact_url = esc_url( $contact_url );
	?>
	<div class="ept-nav-bar">
		<div class="ept-nav-bar-inner ept-nav-bar-logo">
			<a href="<?php echo $home_url; ?>" rel="home" class="ept-nav-logo">
				<?php if ( $use_logo ) : ?>
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $site_name ); ?> – Dreams come true" class="ept-nav-logo-img" width="160" height="30">
				<?php else : ?>
					<?php echo esc_html( $site_name ); ?>
				<?php endif; ?>
			</a>
		</div>
		<button type="button" class="ept-nav-hamburger" aria-label="<?php esc_attr_e( 'Ouvrir le menu', 'astra-child-protech' ); ?>" aria-expanded="false" aria-controls="ept-nav-menu-dropdown" id="ept-nav-hamburger">
			<span class="ept-hamburger-bar"></span>
			<span class="ept-hamburger-bar"></span>
			<span class="ept-hamburger-bar"></span>
		</button>
		<nav class="ept-nav-menu-wrap" id="ept-nav-menu-dropdown" aria-label="<?php esc_attr_e( 'Navigation principale', 'astra-child-protech' ); ?>">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'main-header-menu ast-menu-shadow ast-nav-menu ast-flex submenu-with-border stack-on-mobile',
			) );
		} else {
			astra_child_protech_nav_fallback( array(
				'menu_class' => 'main-header-menu ast-menu-shadow ast-nav-menu ast-flex submenu-with-border stack-on-mobile',
			) );
		}
		?>
		</nav>
		<div class="ept-nav-bar-inner ept-nav-bar-cta-wrap">
			<a href="<?php echo $contact_url; ?>?sujet=audit" class="ept-nav-cta"><?php esc_html_e( 'Demander un audit', 'astra-child-protech' ); ?></a>
		</div>
	</div>
	<?php
}
add_action( 'astra_header_before', 'astra_child_protech_header_top_bar', 5 );
