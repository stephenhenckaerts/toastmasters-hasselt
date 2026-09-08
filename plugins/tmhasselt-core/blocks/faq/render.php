<?php
/**
 * Render the FAQ accordion from the `faq` category.
 *
 * The club edits these answers as ordinary posts in that category, oldest
 * first. Mirrors the query the classic front-page template used.
 *
 * @package tmhasselt
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner block content (unused).
 * @var WP_Block $block      Block instance.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tmh_count = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 12;

$tmh_faq = new WP_Query(
	array(
		'category_name'       => 'faq',
		'posts_per_page'      => $tmh_count,
		'orderby'             => 'date',
		'order'               => 'ASC',
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

$tmh_wrapper = get_block_wrapper_attributes( array( 'class' => 'tmh-faq' ) );

if ( ! $tmh_faq->have_posts() ) {
	printf(
		'<div %s><p>%s</p></div>',
		$tmh_wrapper, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() is safe.
		esc_html__( 'Er staan nog geen vragen in de categorie FAQ.', 'tmhasselt' )
	);
	return;
}

echo '<div ' . $tmh_wrapper . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() is safe.

$tmh_i = 0;
while ( $tmh_faq->have_posts() ) {
	$tmh_faq->the_post();
	$tmh_i++;
	?>
	<details class="tmh-faq__item"<?php echo 1 === $tmh_i ? ' open' : ''; ?>>
		<summary class="tmh-faq__q"><?php echo esc_html( get_the_title() ); ?></summary>
		<div class="tmh-faq__a"><?php echo wp_kses_post( apply_filters( 'the_content', get_the_content() ) ); ?></div>
	</details>
	<?php
}

echo '</div>';

wp_reset_postdata();
