<?php
/**
 * Functions to simplify interacting with the Batch Processing utility.
 *
 * @package Batch_Processing
 */

namespace Batch_Process;

/**
 * Register a new batch process.
 *
 * @param  array $args Arguments for the batch process.
 * @throws \Exception Only post & user are accepted $args['type'].
 */
function register( $args ) {
	switch ( $args['type'] ) {
		case 'post':
			$batch_process = new Posts();
			$batch_process->register( $args );
			break;

		default:
			throw new \Exception( 'Type not supported.' );
			break;
	}
}

/**
 * Get the batch hooks that have been added
 *
 * @return array
 */
function get_all_batches() {
	$batches = get_site_option( Batch::REGISTERED_BATCHES_KEY, array() );

	foreach ( $batches as $k => $batch ) {
		$batch_status = get_site_option( Batch::BATCH_HOOK_PREFIX . $k );
		$batches[ $k ]['last_run'] = $batch_status['timestamp'];
		$batches[ $k ]['status'] = $batch_status['status'];
	}

	return $batches;
}

/**
 * Update the registered batches.
 *
 * @param array $batches Batches you want to register.
 */
function update_registered_batches( $batches ) {
	return update_site_option( Batch::REGISTERED_BATCHES_KEY, $batches );
}

/**
 * Template function for showing time ago.
 *
 * @todo Move this to a template functions file.
 *
 * @param  timestamp $time Timestamp.
 */
function time_ago( $time ) {
	return human_time_diff( $time, current_time( 'timestamp' ) ) . ' ago';
}

/**
 * Clear all existing batches.
 */
function clear_existing_batches() {
	return update_site_option( Batch::REGISTERED_BATCHES_KEY, array() );
}