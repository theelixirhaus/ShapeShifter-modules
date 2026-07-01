<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init',      'ss_register_settings_field_group' );
add_action( 'acf/init',      'ss_register_settings_sidebar_field_group' );
add_action( 'acf/save_post', 'ss_invalidate_repathed_cache_on_save' );

function ss_register_settings_field_group(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$block_editor_fields = [
		[
			'key'      => 'field_ss_block_editor_tab',
			'label'    => __( 'Block Editor Preview', 'shapeshifter' ),
			'name'     => '',
			'type'     => 'tab',
			'placement'=> 'top',
			'endpoint' => 0,
		],
		 [
                "key"=> "field_6a222d4db7b74",
                "label"=> "<h3>Load your site styles into the Block Editor:</h3>",
                "name"=> "",
                "aria-label"=> "",
                "type"=> "Usage=>",
                "instructions"=> "<h4>Wordpress's Block Editor is a great modern feature, but previews your page with generic styling. Add your website's stylesheet in the field below to have it style your ShapeShifter modules just like the fontend of the site. This plugin will also stylize the Block Editor with a draggable and collapsable sidebar.</h4>",
                "required"=> 0,
                "conditional_logic"=> 0,
                
                "message"=> "",
                "new_lines"=> "wpautop",
                "esc_html"=> 0,
            ],
		[
			'key'          => 'field_ss_editor_css_url',
			'label'        => __( 'Site Style Sheet URL', 'shapeshifter' ),
			'name'         => 'ss_editor_css_url',
			'type'         => 'text',
			'instructions' => __( 'Stylesheet to load (and rescope) inside the Block Editor. Accepts an absolute URL (https://example.com/style.css) or a site-relative path starting with a slash (/style.css).', 'shapeshifter' ),
		],
		[
			'key'       => 'field_ss_clear_repath_cache',
			'label'     => __( 'Stylesheet Cache', 'shapeshifter' ),
			'name'      => '',
			'type'      => 'message',
			'message'   => ss_render_clear_repath_cache_button(),
			'esc_html'  => 0,
			'new_lines' => '',
		],
		[
			'key'           => 'field_ss_editor_bg_color',
			'label'         => __( 'Editor Preview Background Color', 'shapeshifter' ),
			'name'          => 'ss_editor_bg_color',
			'type'          => 'color_picker',
			'instructions'  => __( 'Background color shown behind blocks in the editor preview area.', 'shapeshifter' ),
			'return_format' => 'string',
		],
		[
			'key'           => 'field_ss_editor_draggable_panel',
			'label'         => __( 'Draggable Sidebar', 'shapeshifter' ),
			'name'          => 'ss_editor_draggable_panel',
			'type'          => 'true_false',
			'instructions'  => __( 'Enable the draggable resize handle on the editor sidebar.', 'shapeshifter' ),
			'ui'            => 1,
			'default_value' => 0,
		],
		[
			'key'          => 'field_ss_editor_extra_css',
			'label'        => __( 'Additional CSS for Editor Preview', 'shapeshifter' ),
			'name'         => 'ss_editor_extra_css',
			'type'         => 'textarea',
			'instructions' => __( 'CSS appended verbatim to the editor preview. Loaded only in wp-admin.', 'shapeshifter' ),
			'rows'         => 10,
			'new_lines'    => '',
		],
	];

	$license_fields = [
		[
			'key'      => 'field_ss_license_tab',
			'label'    => __( 'License', 'shapeshifter' ),
			'name'     => '',
			'type'     => 'tab',
			'placement'=> 'top',
			'endpoint' => 0,
		],
		[
			'key'          => 'field_ss_license_key',
			'label'        => __( 'License Key', 'shapeshifter' ),
			'name'         => 'ss_license_key',
			'type'         => 'text',
			'instructions' => __( 'Enter your ShapeShifter Pro license key to unlock all modules. Without a valid key, only the free modules (M1, M4, M5) are available.', 'shapeshifter' ),
		],
		[
			'key'       => 'field_ss_license_status',
			'label'     => __( 'License Status', 'shapeshifter' ),
			'name'      => '',
			'type'      => 'message',
			'message'   => ss_render_license_status(),
			'esc_html'  => 0,
			'new_lines' => '',
		],
	];

	$dpcss_fields = ss_load_darkphysicss_fields();

	$accordion_terminator = [
		[
			'key'      => 'field_ss_dpcss_accordion_end',
			'label'    => '',
			'name'     => '',
			'type'     => 'accordion',
			'endpoint' => 1,
		],
	];

	$combined = array_merge( $license_fields, $dpcss_fields, $accordion_terminator, $block_editor_fields );

	acf_add_local_field_group(
		[
			'key'                   => 'group_ss_settings',
			'title'                 => __( 'ShapeShifter Settings', 'shapeshifter' ),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 0,
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'shapeshifter-modules',
					],
				],
			],
			'fields'                => $combined,
		]
	);
}

function ss_register_settings_sidebar_field_group(): void {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		[
			'key'                   => 'group_ss_settings_sidebar',
			'title'                 => __( 'Information', 'shapeshifter' ),
			'menu_order'            => 1,
			'position'              => 'side',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'active'                => true,
			'show_in_rest'          => 0,
			'location'              => [
				[
					[
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'shapeshifter-modules',
					],
				],
			],
			'fields'                => [
				[
					'key'       => 'field_ss_sidebar_html',
					'label'     => '',
					'name'      => '',
					'type'      => 'message',
					'message'   => ss_render_settings_sidebar(),
					'esc_html'  => 0,
					'new_lines' => '',
				],
			],
		]
	);
}

function ss_render_settings_sidebar(): string {
	$version  = defined( 'SS_PLUGIN_VERSION' ) ? SS_PLUGIN_VERSION : '';
	$logo_url = defined( 'SS_ASSETS_URL' ) ? SS_ASSETS_URL . 'img/shapeshifter-logo.svg' : '';

	ob_start();
	?>
	<div class="ss-settings-sidebar">

		<!--  Side Bar Info. -->
		<img src="<?php echo esc_url( $logo_url ); ?>" alt="ShapeShifter" style="display:block;width:100%;height:auto;margin-bottom:12px;">

		<hr>

		<h4><?php esc_html_e( 'Resources', 'shapeshifter' ); ?></h4>
	
			<a href="https://shapeshifter-modules.com/documentation" target="_blank" rel="noopener">
				<?php esc_html_e( 'View documentation', 'shapeshifter' ); ?>
			</a><div style="margin-bottom:5px"></div>
			<a href="https://www.reddit.com/r/shapeshiftermodules/" target="_blank" rel="noopener">
				<?php esc_html_e( 'Reddit: r/shapeshiftermodules', 'shapeshifter' ); ?>
			</a><div style="margin-bottom:5px"></div>
			<a href="https://shapeshifter-modules.com/contact" target="_blank" rel="noopener"><?php esc_html_e( 'Report a bug or request a feature', 'shapeshifter' ); ?></a>
			<div style="margin-bottom:20px"></div>
	

		<hr>

		<h4><?php esc_html_e( 'Plugin Info', 'shapeshifter' ); ?></h4>
		<p style="margin-bottom:0;">
			<strong><?php esc_html_e( 'Version:', 'shapeshifter' ); ?></strong> <?php echo esc_html( $version ); ?><br>
			<strong><?php esc_html_e( 'Author:', 'shapeshifter' ); ?></strong> <a href="https://www.theelixirhaus.com" target="_blank">The Elixir Haus</a>
		</p>

	</div>
	<?php
	return (string) ob_get_clean();
}

function ss_load_darkphysicss_fields(): array {
	$path = SS_INC . 'acf/schemas/dark-physicss-field-schema.json';
	if ( ! file_exists( $path ) ) {
		return [];
	}

	$raw    = file_get_contents( $path );
	$groups = json_decode( $raw, true );

	if ( ! is_array( $groups ) ) {
		return [];
	}
	if ( isset( $groups['key'] ) ) {
		$groups = [ $groups ];
	}

	$fields = [];
	foreach ( $groups as $group ) {
		if ( ! is_array( $group ) || empty( $group['fields'] ) ) {
			continue;
		}
		foreach ( $group['fields'] as $field ) {
			$fields[] = $field;
		}
	}

	$tab_swapped = false;
	foreach ( $fields as &$field ) {
		if ( ! $tab_swapped && ( $field['type'] ?? '' ) === 'tab' ) {
			$field['label'] = __( 'DarkPhysiCSS Config', 'shapeshifter' );
			$tab_swapped    = true;
		}
	}
	unset( $field );

	if ( ! $tab_swapped ) {
		array_unshift(
			$fields,
			[
				'key'      => 'field_ss_dpcss_tab',
				'label'    => __( 'DarkPhysiCSS Config', 'shapeshifter' ),
				'name'     => '',
				'type'     => 'tab',
				'placement'=> 'top',
				'endpoint' => 0,
			]
		);
	}

	return $fields;
}

function ss_invalidate_repathed_cache_on_save( $post_id ): void {
	if ( $post_id !== 'options' ) {
		return;
	}
	if ( class_exists( 'SS_CSS_Repather' ) ) {
		SS_CSS_Repather::clear_cache();
	}
	if ( class_exists( 'SS_CSS_Breakpoint_Rewriter' ) ) {
		SS_CSS_Breakpoint_Rewriter::clear_cache();
	}
}

function ss_render_license_status(): string {
	if ( ! class_exists( 'SS_License' ) ) {
		return '<p>' . esc_html__( 'License system not loaded.', 'shapeshifter' ) . '</p>';
	}

	$status = SS_License::status();
	$valid  = ( $status['valid'] ?? false ) === true;
	$reason = $status['reason'] ?? '';

	if ( $valid ) {
		$checked = isset( $status['checked_at'] )
			? human_time_diff( (int) $status['checked_at'] )
			: '';
		$msg = $checked
			? sprintf(
				/* translators: %s: human-readable time since last check */
				__( 'License is active. Last verified %s ago.', 'shapeshifter' ),
				$checked
			)
			: __( 'License is active.', 'shapeshifter' );
		return '<p style="color:#1a7e3a;font-weight:600;">' . esc_html( $msg ) . '</p>';
	}

	$reasons = [
		'unchecked'       => __( 'License has not been verified yet. Save this page to validate.', 'shapeshifter' ),
		'no_key'          => __( 'No license key entered. Pro modules are disabled.', 'shapeshifter' ),
		'config_missing'  => __( 'SS_LICENSE_API_URL is not defined in wp-config.php.', 'shapeshifter' ),
		'transport_error' => __( 'Could not reach the license server.', 'shapeshifter' ),
		'rejected'        => __( 'License was rejected by the server.', 'shapeshifter' ),
	];

	$msg = $reasons[ $reason ] ?? __( 'License is not active.', 'shapeshifter' );
	if ( ! empty( $status['message'] ) && in_array( $reason, [ 'transport_error', 'rejected' ], true ) ) {
		$msg .= ' ' . $status['message'];
	}

	return '<p style="color:#a00;font-weight:600;">' . esc_html( $msg ) . '</p>';
}

function ss_render_clear_repath_cache_button(): string {
	$url = wp_nonce_url(
		admin_url( 'admin-post.php?action=ss_clear_repath_cache' ),
		'ss_clear_repath_cache'
	);

	$count   = 0;
	$newest  = 0;
	if ( class_exists( 'SS_CSS_Repather' ) ) {
		$dir = SS_CSS_Repather::get_cache_dir();
		if ( is_dir( $dir ) ) {
			foreach ( glob( $dir . '*.css' ) ?: [] as $file ) {
				$count++;
				$newest = max( $newest, (int) filemtime( $file ) );
			}
		}
	}

	$status = $count === 0
		? __( 'Cache is empty.', 'shapeshifter' )
		: sprintf(
			/* translators: 1: number of cached files, 2: human-readable time since last write */
			_n( '%1$d cached file, last written %2$s ago.', '%1$d cached files, last written %2$s ago.', $count, 'shapeshifter' ),
			$count,
			human_time_diff( $newest )
		);

	return '<p>' . esc_html( $status ) . '</p>'
		. '<a href="' . esc_url( $url ) . '" class="button button-secondary">'
		. esc_html__( 'Clear Stylesheet Cache', 'shapeshifter' )
		. '</a>';
}
