<?php

namespace Jcore\Huomio;
use Timber\Timber;

function timber_block_context( $attributes ) {
	$context                       = Timber::context_global();
	$context['wrapper_attributes'] = get_block_wrapper_attributes();

	return \array_merge( $context, $attributes );
}
