<?php // phpcs:ignore Squiz.Commenting.FileComment.Missing

namespace Jcore\Huomio;

use WP_Error;
use WP_Exception;
use WP_REST_Response;
use WP_REST_Server;
use WpOrg\Requests\Exception\InvalidArgument;

const NS = 'huomio/v1';

/**
 * Get the toast properties.
 *
 * @return array
 */
function get_toast_properties() {
	return array(
		'message' => array(
			'type'     => 'string',
			'required' => true,
		),
		'enabled' => array(
			'type'     => 'integer',
			'required' => true,
		),
	);
}

/**
 * Get the toast schema.
 *
 * @return array
 */
function get_toast_schema() {
	return array(
		'$schema'           => 'http://json-schema.org/draft-04/schema#',
		'title'             => 'toast',
		'type'              => 'object',
		'properties'        => get_toast_properties(),
		'required'          => true,
		'validate_callback' => 'Jcore\Huomio\validate_toast',
		'sanitize_callback' => 'Jcore\Huomio\sanitize_toast',
	);
}

/**
 * Validate the toast.
 *
 * @param mixed $param
 * @param mixed $request
 * @param mixed $key
 * @return WP_Error|bool
 */
function validate_toast( $param, $request, $key ) {
	if ( ! is_array( $param ) ) {
		return new WP_Error( 'invalid_toast', 'Toast must be an array', array( 'status' => 400 ) );
	}
	return rest_validate_request_arg( $param, $request, $key );
}

/**
 * Sanitize the toast.
 *
 * @param mixed $param
 * @return mixed
 */
function sanitize_toast( $param, $request, $key ) {
	return rest_sanitize_request_arg( $param, $request, $key );
}


/**
 * Register the rest api routes.
 */
function register_rest_api_routes() {

	register_rest_route(
		NS,
		'/toast',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'Jcore\Huomio\get_toast',
			'permission_callback' => function () {
				return current_user_can( 'manage_options' );
			},
		)
	);
	register_rest_route(
		NS,
		'/toast',
		array(
			'methods'             => WP_REST_Server::EDITABLE,
			'callback'            => 'Jcore\Huomio\update_toast',
			'permission_callback' => function () {
				return current_user_can( 'manage_options' );
			},
			'args'                => array(
				'toast' => get_toast_schema(),
			),
		)
	);
}
add_action( 'rest_api_init', 'Jcore\Huomio\register_rest_api_routes' );

/**
 * Get the toasts.
 *
 * @return WP_REST_Response
 */
function get_toast() {
	$toast    = fetch_current_toast();
	$response = new WP_REST_Response( $toast );
	$response->set_status( 200 );
	return rest_ensure_response( $response );
}

/**
 * Update the toast.
 *
 * @param WP_REST_Request $request The request object.
 * @return WP_REST_Response
 */
function update_toast( $request ) {
	$toast = $request->get_param( 'toast' );
	update_current_toast( $toast );
	$toast    = fetch_current_toast();
	$response = new WP_REST_Response( $toast );
	return rest_ensure_response( $response );
}
