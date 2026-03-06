<?php
/**
 * Custom Post Type: Réalisations (Projets solaires)
 *
 * Champs natifs + meta ACF-ready : kWc, client, secteur, économies, payback, images avant/après.
 *
 * @package Astra_Child_Protech
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register post type "realisations".
 */
function astra_child_protech_register_cpt_realisations() {
	$labels = array(
		'name'               => _x( 'Réalisations', 'post type general name', 'astra-child-protech' ),
		'singular_name'      => _x( 'Réalisation', 'post type singular name', 'astra-child-protech' ),
		'menu_name'          => _x( 'Réalisations', 'admin menu', 'astra-child-protech' ),
		'add_new'            => _x( 'Ajouter', 'réalisation', 'astra-child-protech' ),
		'add_new_item'       => __( 'Ajouter une réalisation', 'astra-child-protech' ),
		'edit_item'          => __( 'Modifier la réalisation', 'astra-child-protech' ),
		'new_item'           => __( 'Nouvelle réalisation', 'astra-child-protech' ),
		'view_item'          => __( 'Voir la réalisation', 'astra-child-protech' ),
		'search_items'       => __( 'Rechercher des réalisations', 'astra-child-protech' ),
		'not_found'          => __( 'Aucune réalisation trouvée', 'astra-child-protech' ),
		'not_found_in_trash' => __( 'Aucune réalisation dans la corbeille', 'astra-child-protech' ),
	);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => true,
		'rest_base'           => 'realisations',
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'projets' ),
		'capability_type'     => 'post',
		'has_archive'         => true,
		'hierarchical'        => false,
		'menu_position'       => 20,
		'menu_icon'           => 'dashicons-portfolio',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
	);

	register_post_type( 'realisation', $args );
}
add_action( 'init', 'astra_child_protech_register_cpt_realisations' );

/**
 * Register taxonomy "secteur" for realisations (industrie, agro, hotel, institution, hors-reseau).
 */
function astra_child_protech_register_taxonomy_secteur() {
	$labels = array(
		'name'          => _x( 'Secteurs', 'taxonomy general name', 'astra-child-protech' ),
		'singular_name' => _x( 'Secteur', 'taxonomy singular name', 'astra-child-protech' ),
		'search_items'  => __( 'Rechercher secteurs', 'astra-child-protech' ),
		'all_items'     => __( 'Tous les secteurs', 'astra-child-protech' ),
		'edit_item'     => __( 'Modifier le secteur', 'astra-child-protech' ),
		'update_item'   => __( 'Mettre à jour le secteur', 'astra-child-protech' ),
		'add_new_item'  => __( 'Ajouter un secteur', 'astra-child-protech' ),
	);

	register_taxonomy(
		'secteur_realisation',
		array( 'realisation' ),
		array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'secteur' ),
		)
	);
}
add_action( 'init', 'astra_child_protech_register_taxonomy_secteur' );

/**
 * Register meta fields (native, ACF-compatible keys so ACF can take over if used).
 * Keys: _protech_kwc, _protech_client, _protech_economies_pct, _protech_payback_ans, _protech_image_avant, _protech_image_apres
 */
function astra_child_protech_register_realisation_meta() {
	$meta = array(
		'_protech_kwc'            => array( 'type' => 'number', 'sanitize' => 'floatval' ),
		'_protech_client'         => array( 'type' => 'string', 'sanitize' => 'sanitize_text_field' ),
		'_protech_economies_pct'  => array( 'type' => 'number', 'sanitize' => 'floatval' ),
		'_protech_payback_ans'    => array( 'type' => 'number', 'sanitize' => 'floatval' ),
		'_protech_image_avant'    => array( 'type' => 'integer', 'sanitize' => 'absint' ),
		'_protech_image_apres'    => array( 'type' => 'integer', 'sanitize' => 'absint' ),
	);

	foreach ( $meta as $key => $config ) {
		register_post_meta(
			'realisation',
			$key,
			array(
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => $config['type'],
				'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
				},
			)
		);
	}
}
add_action( 'init', 'astra_child_protech_register_realisation_meta' );

/**
 * Helper: get realisation meta (safe for templates).
 *
 * @param int $post_id Post ID.
 * @return array Associative array of meta values.
 */
function astra_child_protech_get_realisation_meta( $post_id = 0 ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	if ( ! $post_id || get_post_type( $post_id ) !== 'realisation' ) {
		return array();
	}
	return array(
		'kwc'           => (float) get_post_meta( $post_id, '_protech_kwc', true ),
		'client'        => (string) get_post_meta( $post_id, '_protech_client', true ),
		'economies_pct' => (float) get_post_meta( $post_id, '_protech_economies_pct', true ),
		'payback_ans'   => (float) get_post_meta( $post_id, '_protech_payback_ans', true ),
		'image_avant'   => (int) get_post_meta( $post_id, '_protech_image_avant', true ),
		'image_apres'   => (int) get_post_meta( $post_id, '_protech_image_apres', true ),
	);
}
