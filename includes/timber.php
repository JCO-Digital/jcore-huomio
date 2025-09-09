<?php // phpcs:ignore Squiz.Commenting.FileComment.Missing

namespace Jcore\Huomio;

use Timber\Timber;

/**
 * Filter for timber context.
 *
 * @param array $attributes The attributes for the block.
 * @param array $extra_attributes Extra attributes for the block.
 *
 * @return array
 */
function timber_block_context( $attributes, $extra_attributes = array() ) {
	$context                       = Timber::context_global();
	$context['wrapper_attributes'] = get_block_wrapper_attributes( $extra_attributes );

	return \array_merge( $context, $attributes );
}

add_filter(
	'timber/locations',
	function ( $paths ) {
		$paths['jcore-huomio'] = array(
			PLUGIN_BASE_DIR . '/src',
			PLUGIN_BASE_DIR . '/twig',
		);

		return $paths;
	}
);
