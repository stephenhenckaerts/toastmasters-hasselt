<?php
/**
 * Block binding source `tmhasselt/meeting`.
 *
 * Lets block markup in the theme's patterns show the next meeting date without
 * a build step. Bind a paragraph or heading `content` attribute to this source
 * with a `key` argument; the whole attribute value is replaced, so keys that
 * need a full sentence return the full sentence.
 *
 * Example pattern markup:
 *
 *     <!-- wp:paragraph {"metadata":{"bindings":{"content":{
 *         "source":"tmhasselt/meeting","args":{"key":"next_date"}}}}} -->
 *     <p>datum volgt</p>
 *     <!-- /wp:paragraph -->
 *
 * @package tmhasselt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolve one binding key to a display string.
 *
 * @param array $source_args    The `args` object from the block's binding config.
 * @param mixed $block_instance Unused.
 * @param string $attribute_name Unused.
 * @return string
 */
function tmh_meeting_binding_value( $source_args, $block_instance = null, $attribute_name = '' ) {
	$key  = isset( $source_args['key'] ) ? $source_args['key'] : 'next_date';
	$next = tmh_next_meeting();

	if ( null === $next ) {
		return 'strip_line' === $key || 'next_date' === $key ? 'datum volgt' : '';
	}

	switch ( $key ) {
		case 'next_date':
			return tmh_dutch_date( $next );

		case 'next_date_year':
			return tmh_dutch_date( $next, true );

		case 'next_relative':
			return tmh_relative_date( $next );

		case 'next_sub':
			return sprintf( 'om 20:00 · %s', tmh_relative_date( $next ) );

		case 'next_iso':
			return $next->format( 'Y-m-d\TH:i' );

		case 'strip_line':
			return sprintf( '%s, 20:00–22:00', tmh_dutch_date( $next ) );

		case 'practical_next':
			return sprintf( 'Elke maand, van 20:00 tot 22:00. Volgende keer op %s.', tmh_dutch_date( $next ) );

		case 'then_sentence':
			$upcoming = tmh_upcoming_meetings( 2 );
			if ( empty( $upcoming[1] ) ) {
				return '';
			}
			return sprintf( 'Daarna is het %s.', tmh_dutch_date( $upcoming[1] ) );

		case 'cadence':
			$upcoming = tmh_upcoming_meetings( 2 );
			$line     = 'We komen samen op de eerste en derde dinsdag van elke maand, om 20:00.';
			if ( ! empty( $upcoming[1] ) ) {
				$line .= sprintf( ' Daarna is het %s.', tmh_dutch_date( $upcoming[1] ) );
			}
			return $line;

		default:
			return tmh_dutch_date( $next );
	}
}

/**
 * Register the source.
 */
function tmh_register_meeting_binding() {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}

	register_block_bindings_source(
		'tmhasselt/meeting',
		array(
			'label'              => __( 'Volgende meeting', 'tmhasselt' ),
			'get_value_callback' => 'tmh_meeting_binding_value',
		)
	);
}
add_action( 'init', 'tmh_register_meeting_binding' );
