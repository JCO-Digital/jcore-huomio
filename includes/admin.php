<?php // phpcs:ignore Squiz.Commenting.FileComment.Missing

namespace Jcore\Huomio;

use Timber\Timber;

/**
 * Enqueue the admin assets.
 *
 * @return void
 */
function enqueue_admin_assets() {
	if ( ! file_exists( PLUGIN_BASE_DIR . '/build/huomio-admin.asset.php' ) ) {
		return;
	}
	$asset_data = require PLUGIN_BASE_DIR . '/build/huomio-admin.asset.php';
	wp_enqueue_script( 'jcore-huomio-admin', PLUGIN_BASE_URL . '/build/huomio-admin.js', $asset_data['dependencies'], $asset_data['version'], true );
	wp_enqueue_style( 'wp-components' );
	wp_set_script_translations( 'jcore-huomio-admin', 'jcore-huomio', PLUGIN_DIR_PATH . 'languages' );
}
add_action( 'admin_enqueue_scripts', '\Jcore\Huomio\enqueue_admin_assets' );

/**
 * Admin page.
 *
 * @return void
 */
function admin_page() {
	$context                  = Timber::context();
	$context['current_toast'] = fetch_current_toast();
	Timber::render( '@jcore-huomio/admin/index.twig', $context );
}

/**
 * Add the admin menu.
 *
 * @return void
 */
function add_admin_menu() {
	add_menu_page(
		__( 'Notification banner', 'jcore-huomio' ),
		__( 'Notification banner', 'jcore-huomio' ),
		'manage_options',
		'jcore-huomio',
		'\Jcore\Huomio\admin_page',
		'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiNmZmZmZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBjbGFzcz0ibHVjaWRlIGx1Y2lkZS1iZWxsLXJpbmctaWNvbiBsdWNpZGUtYmVsbC1yaW5nIj48cGF0aCBkPSJNMTAuMjY4IDIxYTIgMiAwIDAgMCAzLjQ2NCAwIi8+PHBhdGggZD0iTTIyIDhjMC0yLjMtLjgtNC4zLTItNiIvPjxwYXRoIGQ9Ik0zLjI2MiAxNS4zMjZBMSAxIDAgMCAwIDQgMTdoMTZhMSAxIDAgMCAwIC43NC0xLjY3M0MxOS40MSAxMy45NTYgMTggMTIuNDk5IDE4IDhBNiA2IDAgMCAwIDYgOGMwIDQuNDk5LTEuNDExIDUuOTU2LTIuNzM4IDcuMzI2Ii8+PHBhdGggZD0iTTQgMkMyLjggMy43IDIgNS43IDIgOCIvPjwvc3ZnPg==',
		100
	);
}
add_action( 'admin_menu', '\Jcore\Huomio\add_admin_menu' );
