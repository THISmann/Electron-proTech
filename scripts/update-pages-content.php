<?php
/**
 * Met à jour le contenu des pages WordPress à partir des fichiers HTML dans content-pages/
 * Supporte le renommage (title + slug) via array : 'old-slug' => array('file' => 'x.html', 'title' => 'Titre', 'slug' => 'nouveau-slug')
 * À exécuter : wp eval-file /app/scripts/update-pages-content.php --allow-root
 */

if ( ! defined( 'ABSPATH' ) && ! defined( 'WP_CLI' ) ) {
	exit;
}

$base  = '/app/content-pages';
$pages = array(
	'accueil'                => 'accueil.html',
	'realisations'           => 'realisations.html',
	'installation-solaire'  => 'installation-solaire.html',
	'maintenance-sav'        => 'maintenance-sav.html',
	'simulateur'             => 'simulateur.html',
	'references-temoignages' => 'references-temoignages.html',
	'a-propos'               => 'a-propos.html',
	'contact'                => 'contact.html',
	'blog'                   => 'blog.html',
	'page-d-exemple'         => array(
		'file'  => 'bloc.html',
		'title' => 'Bloc',
		'slug'  => 'bloc',
	),
);

foreach ( $pages as $slug => $config ) {
	$file    = is_array( $config ) ? $config['file'] : $config;
	$new_title = is_array( $config ) && ! empty( $config['title'] ) ? $config['title'] : null;
	$new_slug  = is_array( $config ) && ! empty( $config['slug'] ) ? $config['slug'] : null;

	$path = $base . '/' . $file;
	if ( ! is_readable( $path ) ) {
		if ( function_exists( 'WP_CLI' ) ) {
			WP_CLI::warning( "Fichier non lu : $path" );
		}
		continue;
	}
	$content = file_get_contents( $path );
	$post    = get_page_by_path( $slug, OBJECT, 'page' );
	if ( ! $post ) {
		if ( function_exists( 'WP_CLI' ) ) {
			WP_CLI::warning( "Page non trouvée : $slug" );
		}
		continue;
	}

	$update = array(
		'ID'           => $post->ID,
		'post_content' => $content,
	);
	if ( $new_title ) {
		$update['post_title'] = $new_title;
	}
	if ( $new_slug ) {
		$update['post_name'] = $new_slug;
	}

	$updated = wp_update_post( $update, true );
	if ( is_wp_error( $updated ) ) {
		if ( function_exists( 'WP_CLI' ) ) {
			WP_CLI::warning( "Erreur mise à jour $slug : " . $updated->get_error_message() );
		}
	} else {
		if ( function_exists( 'WP_CLI' ) ) {
			$msg = $new_slug ? "Page mise à jour et renommée : $slug → $new_slug (ID {$post->ID})" : "Page mise à jour : $slug (ID {$post->ID})";
			WP_CLI::success( $msg );
		}
	}
}
