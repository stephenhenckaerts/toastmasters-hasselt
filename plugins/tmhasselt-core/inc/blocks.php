<?php
/**
 * Server-rendered blocks.
 *
 * @package tmhasselt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register every block under blocks/ that has a block.json.
 */
function tmh_register_blocks() {
	register_block_type( TMH_CORE_DIR . 'blocks/faq' );
}
add_action( 'init', 'tmh_register_blocks' );
