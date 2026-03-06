<?php
/**
 * Supprime la page contact-2 et renomme Bloc → Blog avec contenu blog.
 * À exécuter : wp eval-file /app/scripts/delete-contact2-and-update-blog.php --allow-root
 */

if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_CLI' ) ) {
	exit;
}

// 1. Supprimer la page contact-2
$contact2 = get_page_by_path( 'contact-2', OBJECT, 'page' );
if ( $contact2 ) {
	wp_delete_post( $contact2->ID, true );
	if ( function_exists( 'WP_CLI' ) ) {
		WP_CLI::success( "Page supprimée : contact-2 (ID {$contact2->ID})" );
	}
} else {
	if ( function_exists( 'WP_CLI' ) ) {
		WP_CLI::warning( "Page contact-2 introuvable" );
	}
}

// 2. Renommer Bloc → Blog et mettre le contenu blog
$bloc = get_page_by_path( 'bloc', OBJECT, 'page' );
if ( $bloc ) {
	$path = '/app/content-pages/blog.html';
	if ( ! is_readable( $path ) ) {
		if ( function_exists( 'WP_CLI' ) ) {
			WP_CLI::warning( "Fichier blog.html introuvable" );
		}
	} else {
		$content = file_get_contents( $path );
		$updated = wp_update_post( array(
			'ID'           => $bloc->ID,
			'post_title'   => 'Blog',
			'post_name'    => 'blog',
			'post_content' => $content,
		), true );
		if ( is_wp_error( $updated ) ) {
			if ( function_exists( 'WP_CLI' ) ) {
				WP_CLI::warning( "Erreur : " . $updated->get_error_message() );
			}
		} else {
			if ( function_exists( 'WP_CLI' ) ) {
				WP_CLI::success( "Page Bloc renommée en Blog et contenu mis à jour (ID {$bloc->ID})" );
			}
		}
	}
} else {
	if ( function_exists( 'WP_CLI' ) ) {
		WP_CLI::warning( "Page bloc introuvable" );
	}
}
