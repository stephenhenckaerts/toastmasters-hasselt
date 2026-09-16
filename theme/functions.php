<?php
/**
 * Toastmasters Hasselt block theme setup.
 *
 * Global colour, type, spacing and layout are in theme.json. This file only
 * enqueues the font faces and the supplementary stylesheet, registers the
 * block pattern category, and keeps a couple of front-end tweaks the old
 * classic theme had. The meeting-date engine, the SEO head tags and the
 * JSON-LD live in the "Toastmasters Hasselt Core" plugin.
 *
 * Targets PHP 7.4 (the live host floor): no syntax newer than 7.4.
 *
 * @package tmhasselt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TMH_VERSION', '2.0.5' );

/**
 * Theme supports. Block themes get most of this automatically; the html5 and
 * feed-link declarations are still worth being explicit about.
 */
function tmh_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);

	load_theme_textdomain( 'tmhasselt', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'tmh_setup' );

/**
 * Fonts and the supplementary stylesheet, on the front end and in the editor.
 *
 * Google Fonts is the only external host. Everything else is local.
 */
function tmh_assets() {
	wp_enqueue_style(
		'tmh-fonts',
		'https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,400;0,600;0,700;1,400&family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'tmh-app',
		get_template_directory_uri() . '/assets/css/app.css',
		array( 'tmh-fonts' ),
		TMH_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'tmh_assets' );
add_action( 'enqueue_block_assets', 'tmh_assets' );

/**
 * Preconnect to the font file host so the display face is not render-blocking.
 *
 * @param array  $urls     URLs to print for resource hints.
 * @param string $relation Relation type.
 * @return array
 */
function tmh_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'tmh_resource_hints', 10, 2 );

/**
 * Excerpt tuning for the blog archive cards.
 *
 * @return int
 */
function tmh_excerpt_length() {
	return 32;
}
add_filter( 'excerpt_length', 'tmh_excerpt_length' );

/**
 * @return string
 */
function tmh_excerpt_more() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'tmh_excerpt_more' );

add_filter( 'show_admin_bar', '__return_false' );

/**
 * Keep FAQ posts out of the blog index. They are edited as ordinary posts in
 * the "faq" category and shown as the accordion on the front page; they should
 * not also appear in the /blog/ list. The /faq/ category archive still works.
 *
 * @param WP_Query $query The query.
 */
function tmh_exclude_faq_from_blog( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_home() || ( $query->is_archive() && ! $query->is_category( 'faq' ) && ! $query->is_tax() ) ) {
		$faq = get_category_by_slug( 'faq' );
		if ( $faq ) {
			$query->set( 'category__not_in', array( (int) $faq->term_id ) );
		}
	}
}
add_action( 'pre_get_posts', 'tmh_exclude_faq_from_blog' );

/**
 * Pattern category for the club's own sections.
 */
function tmh_pattern_category() {
	register_block_pattern_category(
		'tmhasselt',
		array( 'label' => __( 'Toastmasters Hasselt', 'tmhasselt' ) )
	);
}
add_action( 'init', 'tmh_pattern_category' );

/**
 * Warn in wp-admin if the required plugin is not active.
 */
if ( ! function_exists( 'tmh_next_meeting' ) ) {
	add_action(
		'admin_notices',
		function () {
			echo '<div class="notice notice-error"><p>'
				. esc_html__( 'Het thema Toastmasters Hasselt heeft de plugin “Toastmasters Hasselt Core” nodig. Activeer die plugin.', 'tmhasselt' )
				. '</p></div>';
		}
	);
}
