<?php
/**
 * Plugin Name: ProTech Site URL
 * Description: Force home and siteurl from SITE_URL env var so CSS/JS load on the correct domain (e.g. http://20.199.10.163:8080).
 * Loaded as must-use so it runs before any option is read.
 */

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

$protech_site_url = getenv( 'SITE_URL' );
if ( $protech_site_url !== false && $protech_site_url !== '' ) {
	$protech_site_url = rtrim( $protech_site_url, '/' );
	add_filter( 'pre_option_home', function() use ( $protech_site_url ) {
		return $protech_site_url;
	}, 1 );
	add_filter( 'pre_option_siteurl', function() use ( $protech_site_url ) {
		return $protech_site_url;
	}, 1 );
}
