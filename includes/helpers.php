<?php // phpcs:ignore Squiz.Commenting.FileComment.Missing

namespace Jcore\Huomio;

use stdClass;

/**
 * Fetch the current toast.
 *
 * @return stdClass|object
 */
function fetch_current_toast() {
	$toast = get_option( 'jcore_huomio_toast' );
	if ( ! is_array( $toast ) ) {
		return new stdClass();
	}
	return (object) $toast;
}

/**
 * Update the current toast.
 *
 * @param array $toast The toast to update (EXPECTED TO BE VALIDATED AND SANITIZED).
 * @return void
 */
function update_current_toast( array $toast ) {
	update_option( 'jcore_huomio_toast', $toast );
}
