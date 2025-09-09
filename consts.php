<?php // phpcs:ignore Squiz.Commenting.FileComment.Missing

namespace Jcore\Huomio;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

const PLUGIN_BASE_DIR = __DIR__;
define( 'PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_BASE_URL', plugins_url( '', __FILE__ ) );
