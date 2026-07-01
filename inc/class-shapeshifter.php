<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ShapeShifter {

	private static bool $booted = false;

	public static function boot(): void {
		if ( self::$booted ) {
			return;
		}
		self::$booted = true;

		require_once SS_INC . 'helpers.php';

		require_once SS_INC . 'licensing/class-ss-license.php';
		SS_License::init();

		require_once SS_INC . 'licensing/class-ss-pro-notice.php';
		SS_Pro_Notice::init();

		require_once SS_INC . 'cpt/register-ss-module-cpt.php';
		require_once SS_INC . 'shortcodes/module-shortcode.php';
		require_once SS_INC . 'lightboxes/render-module-lightboxes.php';

		require_once SS_INC . 'acf/class-ss-acf-guard.php';
		SS_ACF_Guard::init();

		if ( SS_ACF_Guard::is_active() ) {
			require_once SS_INC . 'acf/register-settings-page.php';
			require_once SS_INC . 'acf/register-module-fields.php';
			require_once SS_INC . 'acf/register-settings-fields.php';
			require_once SS_INC . 'acf/migrate-legacy-options.php';
			require_once SS_INC . 'blocks/register-blocks.php';
			require_once SS_INC . 'blocks/m2-masonry-footer-script.php';
			require_once SS_INC . 'darkphysicss/enqueue-compiled-styles.php';
			require_once SS_INC . 'darkphysicss/output-font-code.php';
			require_once SS_INC . 'darkphysicss/class-ss-css-breakpoint-rewriter.php';
			require_once SS_INC . 'darkphysicss/enqueue-rewritten-css.php';
		}

		require_once SS_INC . 'block-editor/class-ss-css-repather.php';
		require_once SS_INC . 'block-editor/inject-repathed-css.php';
		require_once SS_INC . 'block-editor/admin-head-styles.php';
		require_once SS_INC . 'block-editor/clear-cache.php';

		require_once SS_INC . 'enqueue/enqueue-frontend.php';
		require_once SS_INC . 'enqueue/enqueue-block-editor.php';
	}
}
