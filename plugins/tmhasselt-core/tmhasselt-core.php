<?php
/**
 * Plugin Name:       Toastmasters Hasselt Core
 * Description:        Meeting-date engine, on-page SEO and structured data, and the block bindings and blocks the theme relies on. Lives outside the theme so it survives a theme swap.
 * Version:           1.0.4
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Author:            Toastmasters Hasselt
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tmhasselt
 *
 * @package tmhasselt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TMH_CORE_VERSION', '1.0.0' );
define( 'TMH_CORE_DIR', plugin_dir_path( __FILE__ ) );

require_once TMH_CORE_DIR . 'inc/meeting.php';
require_once TMH_CORE_DIR . 'inc/seo.php';
require_once TMH_CORE_DIR . 'inc/bindings.php';
require_once TMH_CORE_DIR . 'inc/blocks.php';
