<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'ss_settings' );
delete_option( 'ss_settings_migrated_to_acf' );
delete_option( 'ss_acf_notice_dismissed' );
delete_option( 'deluxe_block_editor_options' );

global $wpdb;
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '\\_transient\\_ss\\_%' OR option_name LIKE '\\_transient\\_timeout\\_ss\\_%'" );
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE 'options\\_ss\\_editor\\_%' OR option_name LIKE '\\_options\\_ss\\_editor\\_%'" );
