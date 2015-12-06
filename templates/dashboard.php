<?php
/**
 * Admin dashbaord template file.
 *
 * @package Batch_processing/Admin
 */

?>
<div class="wrap">
	<h2><?php esc_html_e( get_admin_page_title() ); ?></h2>
	
	<form class="batch-processing-form" method="post">
		<ul class="batch-processes">
			<?php
			if ( empty( $registered_batches ) ) :
				esc_html_e( 'No batches registered.' );
			else :
				foreach ( $registered_batches as $slug => $batch ) : ?>
					<li>
						<input type="radio" id="<?php echo esc_attr( $slug ); ?>" name="batch_process" class="batch-process-option" value="<?php echo esc_attr( $slug ); ?>">
						<label for="<?php echo esc_attr( $slug ); ?>">
							<?php echo esc_html( $batch['name'] ); ?>
							<small>
								<?php
								esc_html_e( 'last run: ' );

								if ( ! empty( $batch['last_run'] ) ) {
									echo esc_html( Batch_Process\time_ago( $batch['last_run'] ) );
								} else {
									esc_html_e( 'never' );
								}

								esc_html_e( '| status: ' );

								if ( ! empty( $batch['status'] ) ) {
									esc_html_e( $batch['status'] );
								} else {
									esc_html_e( 'hasn\'t been run' );
								}
								?>
							</small>
						</label>
					</li>
				<?php endforeach; ?>

				<p>
					<?php
					submit_button( 'Run Batch Process', 'primary', 'submit', false );
					submit_button( 'Reset Batch Process', 'secondary', 'reset', false );
					?>
				</p>
			<?php endif; ?>
		</ul>
	</form>
</div>

<div class="batch-processing-overlay">
	<div class="close">close</div>
	<div class="batch-overlay__inner"></div>
</div><!-- .batch-processing-overlay -->

<script type="text/html" id="tmpl-batch-processing-results">	
	<h2>{{ data.status }}: {{ data.batch }}</h2>
	<div class="progress-bar" data-progress="{{ data.progress }}">
		<span class="progress-bar__text">Progress: {{ data.progress }}%</span>
		<div class="progress-bar__visual"></div>
	</div>
</script>
