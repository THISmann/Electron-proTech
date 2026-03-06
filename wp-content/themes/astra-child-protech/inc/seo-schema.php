<?php
/**
 * SEO & Schema.org: LocalBusiness, Article, FAQ + balises title/meta dynamiques
 *
 * @package Astra_Child_Protech
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output LocalBusiness JSON-LD on homepage.
 */
function astra_child_protech_schema_local_business() {
	if ( ! is_front_page() ) {
		return;
	}

	$name    = get_bloginfo( 'name' );
	$desc    = get_bloginfo( 'description' );
	$url     = home_url( '/' );
	$address = apply_filters( 'protech_schema_address', array(
		'@type'           => 'PostalAddress',
		'addressLocality' => 'Yaoundé',
		'addressRegion'   => 'Centre',
		'addressCountry'  => 'CM',
	) );
	$schema = array(
		'@context'    => 'https://schema.org',
		'@type'       => 'LocalBusiness',
		'name'        => $name,
		'description' => $desc,
		'url'         => $url,
		'address'     => $address,
		'areaServed'  => array(
			array( '@type' => 'Country', 'name' => 'Cameroun' ),
			array( '@type' => 'City', 'name' => 'Yaoundé' ),
			array( '@type' => 'City', 'name' => 'Douala' ),
			array( '@type' => 'City', 'name' => 'Bafoussam' ),
			array( '@type' => 'City', 'name' => 'Bamenda' ),
			array( '@type' => 'City', 'name' => 'Garoua' ),
		),
		'priceRange'  => '$$',
	);

	$schema = apply_filters( 'protech_schema_local_business', $schema );
	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
add_action( 'wp_head', 'astra_child_protech_schema_local_business', 5 );

/**
 * Article schema on single posts.
 */
function astra_child_protech_schema_article() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$schema = array(
		'@context'        => 'https://schema.org',
		'@type'           => 'Article',
		'headline'        => get_the_title(),
		'description'     => has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 30 ),
		'datePublished'   => get_the_date( 'c' ),
		'dateModified'    => get_the_modified_date( 'c' ),
		'author'          => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
		),
		'publisher'       => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
			'url'   => home_url( '/' ),
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
add_action( 'wp_head', 'astra_child_protech_schema_article', 5 );

/**
 * FAQ schema – filter to add from page/content (e.g. via shortcode or ACF).
 */
function astra_child_protech_schema_faq( $faq_items = array() ) {
	$faq_items = apply_filters( 'protech_schema_faq_items', $faq_items );
	if ( empty( $faq_items ) || ! is_array( $faq_items ) ) {
		return;
	}

	$list = array();
	foreach ( $faq_items as $item ) {
		if ( empty( $item['question'] ) || empty( $item['answer'] ) ) {
			continue;
		}
		$list[] = array(
			'@type'          => 'Question',
			'name'           => $item['question'],
			'acceptedAnswer' => array(
				'@type' => 'Answer',
				'text'  => $item['answer'],
			),
		);
	}
	if ( empty( $list ) ) {
		return;
	}

	$schema = array(
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $list,
	);
	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}

/**
 * Optional: output FAQ schema on specific page (e.g. page slug "faq" or "installation-solaire").
 */
function astra_child_protech_maybe_faq_schema() {
	if ( ! is_page() ) {
		return;
	}
	// Hook for theme/plugins to pass FAQ data; default empty.
	astra_child_protech_schema_faq( array() );
}
add_action( 'wp_head', 'astra_child_protech_maybe_faq_schema', 6 );

/**
 * Meta description dynamique pour pages clés (fallback si Rank Math absent).
 */
function astra_child_protech_meta_description() {
	// Ne pas afficher si Rank Math (ou autre SEO) gère déjà les meta.
	if ( defined( 'RANK_MATH_VERSION' ) || function_exists( 'rank_math' ) ) {
		return;
	}
	if ( ! is_front_page() && ! is_page() ) {
		return;
	}
	$desc = '';
	if ( is_front_page() ) {
		$desc = get_bloginfo( 'description' );
	} elseif ( is_page() ) {
		$desc = has_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 25 );
	}
	if ( $desc ) {
		$desc = esc_attr( wp_strip_all_tags( $desc ) );
		echo '<meta name="description" content="' . $desc . '">' . "\n";
	}
}
add_action( 'wp_head', 'astra_child_protech_meta_description', 1 );
