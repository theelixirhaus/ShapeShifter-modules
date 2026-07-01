<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ss_block_title = isset( $block['title'] ) ? (string) $block['title'] : __( 'Pro Module', 'shapeshifter' );
?>
<div class="ss-pro-required" style="
	border: 1px dashed #c3c4c7;
	background: #f6f7f7;
	padding: 24px;
	text-align: center;
	color: #50575e;
	border-radius: 4px;
">
	<div style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #8c8f94; margin-bottom: 6px;">
		<span class="dashicons dashicons-lock" style="vertical-align: middle;"></span>
		<?php esc_html_e( 'Pro Module', 'shapeshifter' ); ?>
	</div>
	<div style="font-size: 16px; font-weight: 600; color: #1d2327; margin-bottom: 6px;">
		<?php echo esc_html( $ss_block_title ); ?>
	</div>
	<div style="font-size: 13px;">
		<?php esc_html_e( 'This module requires a ShapeShifter Pro license. Enter a valid license key on the ShapeShifter Modules settings page to activate it.', 'shapeshifter' ); ?>
	</div>
</div>
