<?php
/**
 * On-page SEO the site currently has none of: meta descriptions, Open Graph,
 * canonical URLs and Organization/Event structured data.
 *
 * Hand-rolled because every maintained SEO plugin requires PHP 7.4+, which the
 * old server did not have. Remove this file if a real SEO plugin is ever
 * installed, to avoid duplicate tags.
 *
 * @package tmhasselt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single source of truth for the club's contact address.
 *
 * @return string
 */
function tmh_club_email() {
	return apply_filters( 'tmh_club_email', 'hasselt.toastmasters@gmail.com' );
}

/**
 * Build a description for the current view.
 *
 * @return string
 */
function tmh_meta_description() {
	$default = 'Nederlandstalige spreekclub in Hasselt. Twee keer per maand oefen je presenteren en spreken voor publiek. Kom gratis en vrijblijvend kijken.';

	if ( is_front_page() ) {
		return $default;
	}

	if ( is_singular() ) {
		$post = get_queried_object();
		$text = has_excerpt( $post ) ? get_the_excerpt( $post ) : $post->post_content;
		$text = wp_strip_all_tags( strip_shortcodes( $text ) );
		$text = trim( preg_replace( '/\s+/u', ' ', $text ) );
		if ( '' !== $text ) {
			return wp_html_excerpt( $text, 155, '…' );
		}
	}

	if ( is_category() ) {
		$desc = trim( wp_strip_all_tags( category_description() ) );
		if ( '' !== $desc ) {
			return wp_html_excerpt( $desc, 155, '…' );
		}
		return sprintf(
			'%s bij Toastmasters Hasselt, de Nederlandstalige spreekclub in Hasselt.',
			single_cat_title( '', false )
		);
	}

	return $default;
}

/**
 * Write the document title.
 *
 * Without this the front page inherits the site tagline, which is the English
 * Toastmasters International slogan — the one line searchers see, in the wrong
 * language, on the site whose whole argument is that it is Dutch.
 *
 * @param array $parts Title parts.
 * @return array
 */
function tmh_document_title( $parts ) {
	if ( is_front_page() ) {
		$parts['title']  = 'Toastmasters Hasselt';
		$parts['tagline'] = 'Nederlandstalige spreekclub in Hasselt';
		unset( $parts['site'] );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'tmh_document_title' );

/**
 * Post types left behind by the previous theme. They hold no navigable content
 * and nothing links to them, but they are still public, still indexable and
 * still in the sitemap.
 *
 * @return array
 */
function tmh_orphan_post_types() {
	return array( 'portfolio', 'services', 'testimonials' );
}

/**
 * Keep the leftovers and the FAQ entries out of the index.
 *
 * Each FAQ answer also renders inside the accordion on the front page, so the
 * standalone posts are thin duplicates competing with it.
 *
 * @param array $robots Robots directives.
 * @return array
 */
function tmh_robots( $robots ) {
	if ( is_singular( tmh_orphan_post_types() ) || is_post_type_archive( tmh_orphan_post_types() ) ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
		return $robots;
	}

	if ( is_category( 'faq' ) ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
		return $robots;
	}

	/* wp_head runs before the loop in a block theme, so ask the queried object
	 * rather than the global post. */
	if ( is_singular( 'post' ) ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post && has_category( 'faq', $post ) ) {
			$robots['noindex'] = true;
			$robots['follow']  = true;
		}
	}

	return $robots;
}
add_filter( 'wp_robots', 'tmh_robots' );

/**
 * Drop the leftover post types from the sitemap.
 *
 * @param array $post_types Post types keyed by name.
 * @return array
 */
function tmh_sitemap_post_types( $post_types ) {
	foreach ( tmh_orphan_post_types() as $type ) {
		unset( $post_types[ $type ] );
	}
	return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'tmh_sitemap_post_types' );

/**
 * Drop the FAQ posts from the sitemap without touching the blog entries.
 *
 * @param array  $args      Query args.
 * @param string $post_type Post type.
 * @return array
 */
function tmh_sitemap_skip_faq( $args, $post_type ) {
	if ( 'post' !== $post_type ) {
		return $args;
	}
	$faq = get_category_by_slug( 'faq' );
	if ( $faq ) {
		$args['category__not_in'] = array( (int) $faq->term_id );
	}
	return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'tmh_sitemap_skip_faq', 10, 2 );

/**
 * Head tags: description, canonical, Open Graph, Twitter.
 */
function tmh_head_meta() {
	$desc  = tmh_meta_description();
	$title = wp_get_document_title();

	$url = home_url( add_query_arg( array() ) );
	if ( is_singular() ) {
		$url = get_permalink();
	} elseif ( is_front_page() ) {
		$url = home_url( '/' );
	}

	$image = get_template_directory_uri() . '/assets/img/zaal.jpg';
	if ( is_singular() && has_post_thumbnail() ) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		if ( $thumb ) {
			$image = $thumb[0];
		}
	}

	echo "\n\t" . '<meta name="description" content="' . esc_attr( $desc ) . '">';
	echo "\n\t" . '<link rel="canonical" href="' . esc_url( $url ) . '">';
	echo "\n\t" . '<meta property="og:type" content="' . ( is_singular() && ! is_front_page() ? 'article' : 'website' ) . '">';
	echo "\n\t" . '<meta property="og:site_name" content="Toastmasters Hasselt">';
	echo "\n\t" . '<meta property="og:locale" content="nl_BE">';
	echo "\n\t" . '<meta property="og:title" content="' . esc_attr( $title ) . '">';
	echo "\n\t" . '<meta property="og:description" content="' . esc_attr( $desc ) . '">';
	echo "\n\t" . '<meta property="og:url" content="' . esc_url( $url ) . '">';
	echo "\n\t" . '<meta property="og:image" content="' . esc_url( $image ) . '">';
	echo "\n\t" . '<meta name="twitter:card" content="summary_large_image">';
	echo "\n";
}
add_action( 'wp_head', 'tmh_head_meta', 2 );

/**
 * Organization + Event structured data.
 *
 * Event markup describes the guest-open club evenings only.
 */
function tmh_structured_data() {
	if ( ! is_front_page() ) {
		return;
	}

	$org_id = home_url( '/' ) . '#organization';

	$place = array(
		'@type'   => 'Place',
		'name'    => 'Sportcentrum Olympia',
		'address' => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Kuringersteenweg 242',
			'addressLocality' => 'Hasselt',
			'postalCode'      => '3500',
			'addressCountry'  => 'BE',
		),
	);

	$graph = array(
		array(
			'@type'              => 'Organization',
			'@id'                => $org_id,
			'name'               => 'Toastmasters Hasselt',
			'alternateName'      => 'Nederlandstalige spreekclub Hasselt',
			'url'                => home_url( '/' ),
			'email'              => tmh_club_email(),
			'description'        => tmh_meta_description(),
			'inLanguage'         => 'nl-BE',
			'parentOrganization' => array(
				'@type' => 'Organization',
				'name'  => 'Toastmasters International',
				'url'   => 'https://www.toastmasters.org/',
			),
			'areaServed'         => array(
				array( '@type' => 'City', 'name' => 'Hasselt' ),
				array( '@type' => 'AdministrativeArea', 'name' => 'Limburg' ),
			),
			'location'           => $place,
			'sameAs'             => array(
				'https://www.toastmasters.org/Find-a-Club/01049050-toastmastershasselt',
				'https://toastmasters.be/find-a-club/flanders/',
			),
		),
	);

	foreach ( tmh_upcoming_meetings( 6 ) as $meeting ) {
		$end = $meeting->modify( '+2 hours' );

		$graph[] = array(
			'@type'               => 'Event',
			'name'                => 'Open clubavond — presenteren oefenen in het Nederlands',
			'description'         => 'Kom gratis kijken. Je hoeft niet te spreken.',
			'startDate'           => $meeting->format( DateTime::ATOM ),
			'endDate'             => $end->format( DateTime::ATOM ),
			'eventStatus'         => 'https://schema.org/EventScheduled',
			'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
			'inLanguage'          => 'nl-BE',
			'isAccessibleForFree' => true,
			'organizer'           => array( '@id' => $org_id ),
			'location'            => $place,
			'offers'              => array(
				'@type'         => 'Offer',
				'price'         => '0',
				'priceCurrency' => 'EUR',
				'availability'  => 'https://schema.org/InStock',
				'url'           => home_url( '/#kom-langs' ),
			),
		);
	}

	$json = wp_json_encode(
		array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
	);

	echo "\n" . '<script type="application/ld+json">' . $json . '</script>' . "\n";
}
add_action( 'wp_head', 'tmh_structured_data', 5 );
