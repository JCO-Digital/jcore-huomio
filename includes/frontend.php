<?php // phpcs:ignore Squiz.Commenting.FileComment.Missing

namespace Jcore\Huomio;

use Timber\Timber;

/**
 * Add the notification banner to the frontend.
 *
 * @return void
 */
function render_notification_banner() {
	$toast = fetch_current_toast();

	if ( ! isset( $toast->enabled ) || $toast->enabled !== 1 ) {
		return;
	}

	$context          = Timber::context();
	$context['toast'] = $toast;

	$html = Timber::compile( '@jcore-huomio/notification-banner.twig', $context );
	echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Extend the twig environment.
 *
 * @param mixed $functions The functions to extend.
 * @return mixed
 */
function extend_twig( mixed $functions ) {
	if ( ! is_array( $functions ) ) {
		return $functions;
	}
	$functions['render_notification_banner'] = array(
		'callable' => 'Jcore\Huomio\render_notification_banner',
	);
	return $functions;
}
add_filter( 'timber/twig/functions', 'Jcore\Huomio\extend_twig', 10, 1 );


/**
 * Enqueue the frontend assets.
 *
 * @return void
 */
function enqueue_frontend_assets() {
	$toast = fetch_current_toast();
	if ( ! isset( $toast->enabled ) || $toast->enabled !== 1 ) {
		return;
	}
	if ( ! file_exists( PLUGIN_BASE_DIR . '/build/huomio-frontend.asset.php' ) ) {
		return;
	}
	$asset_data = require PLUGIN_BASE_DIR . '/build/huomio-frontend.asset.php';
	wp_enqueue_script( 'jcore-huomio-frontend', PLUGIN_BASE_URL . '/build/huomio-frontend.js', $asset_data['dependencies'], $asset_data['version'], true );
}
add_action( 'wp_enqueue_scripts', 'Jcore\Huomio\enqueue_frontend_assets' );
