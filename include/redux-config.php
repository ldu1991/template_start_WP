<?php
if ( ! class_exists( 'Redux' ) ) {
	return;
}
$opt_name = "ld_options";
$theme = wp_get_theme();
$args = array(
    'disable_tracking'     => true,
	'opt_name'             => $opt_name,
	'display_name'         => $theme->get( 'Name' ),
	'display_version'      => $theme->get( 'Version' ),
	'menu_type'            => 'menu',
	'allow_sub_menu'       => true,
	'menu_title'           => __( 'Theme options', 'ld' ),
	'page_title'           => __( 'Theme options', 'ld' ),
	'google_api_key'       => '',
	'google_update_weekly' => false,
	'async_typography'     => true,
	//'disable_google_fonts_link' => true,
	'admin_bar'            => true,
	'admin_bar_icon'       => 'dashicons-portfolio',
	'admin_bar_priority'   => 50,
	'global_variable'      => '',
	'dev_mode'             => false,
	'update_notice'        => false,
	'customizer'           => true,
	//'open_expanded'     => true,
	//'disable_save_warn' => true,
	'page_priority'        => 1,
	'page_parent'          => 'themes.php',
	'page_permissions'     => 'manage_options',
	'menu_icon'            => '',
	'last_tab'             => '',
	'page_icon'            => 'icon-themes',
	'page_slug'            => '',
	'save_defaults'        => true,
	'default_show'         => false,
	'default_mark'         => '',
	'show_import_export'   => true,
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,
	'output_tag'           => true,
	// 'footer_credit'     => '',
	'database'             => '',
	'use_cdn'              => true,

	// HINTS
	'hints'                => array(
		'icon'          => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color'    => 'lightgray',
		'icon_size'     => 'normal',
		'tip_style'     => array(
			'color'   => 'red',
			'shadow'  => true,
			'rounded' => false,
			'style'   => '',
		),
		'tip_position'  => array(
			'my' => 'top left',
			'at' => 'bottom right',
		),
		'tip_effect'    => array(
			'show' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'mouseover',
			),
			'hide' => array(
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'click mouseleave',
			),
		),
	)
);

Redux::setArgs( $opt_name, $args );

// -> START General
Redux::setSection( $opt_name, array(
	'title'            => __( 'General', 'ld' ),
	'id'               => 'basic',
	'desc'             => __( 'Just general options', 'ld' ),
	'customizer_width' => '400px',
	'icon'             => 'el el-home'
) );

Redux::setSection( $opt_name, array(
	'title'            => __( 'Header', 'ld' ),
	'id'               => 'header',
	'subsection'       => true,
	'customizer_width' => '700px',
	'fields'           => array(
		array(
				'id'        => 'logo',
				'type'      => 'media',
				'title'     => __('Logo header', 'ld'),
				'subtitle'      => __('Main logo, that will appear in the header. ', 'ld'),
		),
		array(
				'id'        => 'logo-retina',
				'type'      => 'media',
				'title'     => __('Retina Logo', 'beyond'),
				'subtitle'  => __('Select an image file for the retina version of the logo. It should be exactly 2x the size of the main logo.', 'beyond'),
		),        
		array(
				'id'        => 'favicon',
				'type'      => 'media',
				'title'     => __('Favicon', 'ld'),
				'subtitle'      => __('Firefox, Chrome, Safari, IE 11+ and Opera. 192x192 pixels in size. ', 'ld'),
		),
		array(
				'id'        => 'mobile-favicon',
				'type'      => 'media',
				'title'     => __('Favicon for iOS and Android', 'ld'),
				'subtitle'      => __('Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. ', 'ld'),
		),
		array(
				'id'        => 'header-bar-color',
				'type'      => 'color',
				'title'     => __('Mobile browser bar color', 'ld'),
				'subtitle'  => __("Chrome 39+ for Android on Lollipop.", 'ld'),
				'default'   => '#000',
				'validate'  => 'color',
		),

	)
) );

Redux::setSection( $opt_name, array(
	'title'            => __( 'Footer', 'ld' ),
	'id'               => 'footer',
	'subsection'       => true,
	'customizer_width' => '700px',
	'fields'           => array(
		array(
            'id'        => 'copyright',
            'type'      => 'text',
            'title'     => __('Copyright', 'ld'),
            'subtitle'  => __(' ', 'ld'),
		),
		array(
				'id'        => 'logo_footer',
				'type'      => 'media',
				'title'     => __('Logo footer', 'ld'),
				'subtitle'      => __('Main logo, that will appear in the footer. ', 'ld'),
		),
		array(
            'id'        => 'copyright_developer',
            'type'      => 'text',
            'title'     => __('Copyright Developer', 'ld'),
            'subtitle'  => __(' ', 'ld'),
		),
	)
) );


// If Redux is running as a plugin, this will remove the demo notice and links
//add_action( 'redux/loaded', 'remove_demo' );

// Function to test the compiler hook and demo CSS output.
// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
//add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

// Change the arguments after they've been declared, but before the panel is created
//add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

// Change the default value of a field after it's been set, but before it's been useds
//add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

// Dynamically add a section. Can be also used to modify sections/fields
//add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

if ( ! function_exists( 'compiler_action' ) ) {
	function compiler_action( $options, $css, $changed_values ) {
		echo '<h1>The compiler hook has run!</h1>';
		echo "<pre>";
		print_r( $changed_values );
		echo "</pre>";
		//print_r($options);
		//print_r($css);
	}
}

if ( ! function_exists( 'redux_validate_callback_function' ) ) {
	function redux_validate_callback_function( $field, $value, $existing_value ) {
		$error   = false;
		$warning = false;

		if ( $value == 1 ) {
			$error = true;
			$value = $existing_value;
		} elseif ( $value == 2 ) {
			$warning = true;
			$value   = $existing_value;
		}

		$return['value'] = $value;

		if ( $error == true ) {
			$return['error'] = $field;
			$field['msg']    = 'your custom error message';
		}

		if ( $warning == true ) {
			$return['warning'] = $field;
			$field['msg']      = 'your custom warning message';
		}

		return $return;
	}
}

if ( ! function_exists( 'redux_my_custom_field' ) ) {
	function redux_my_custom_field( $field, $value ) {
		print_r( $field );
		echo '<br/>';
		print_r( $value );
	}
}

if ( ! function_exists( 'dynamic_section' ) ) {
	function dynamic_section( $sections ) {
		//$sections = array();
		$sections[] = array(
			'title'  => __( 'Section via hook', 'ld' ),
			'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'ld' ),
			'icon'   => 'el el-paper-clip',
			'fields' => array()
		);

		return $sections;
	}
}

if ( ! function_exists( 'change_arguments' ) ) {
	function change_arguments( $args ) {
		//$args['dev_mode'] = true;

		return $args;
	}
}

if ( ! function_exists( 'change_defaults' ) ) {
	function change_defaults( $defaults ) {
		$defaults['str_replace'] = 'Testing filter hook!';

		return $defaults;
	}
}

if ( ! function_exists( 'remove_demo' ) ) {
	function remove_demo() {
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', array(
				ReduxFrameworkPlugin::instance(),
				'plugin_metalinks'
			), null, 2 );
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
		}
	}
}

if ( ! function_exists( 'ld_options' ) ) {
	function ld_options( $id, $fallback = false, $param = false ) {
		global $ld_options;
		if ( $fallback == false ) $fallback = '';
		$output = ( isset($ld_options[$id]) && $ld_options[$id] !== '' ) ? $ld_options[$id] : $fallback;
		if ( !empty($ld_options[$id]) && $param ) {
			$output = $ld_options[$id][$param];
		}
		return $output;
	}
}

if ( ! function_exists( 'redux_disable_dev_mode_plugin' ) ) {
    function redux_disable_dev_mode_plugin( $redux ) {
        if ( $redux->args['opt_name'] != 'redux_demo' ) {
            $redux->args['dev_mode'] = false;
            $redux->args['forced_dev_mode_off'] = false;
        }
    }

    add_action( 'redux/construct', 'redux_disable_dev_mode_plugin' );
}

if ( ! class_exists( 'ReduxFramework_extension_vendor_support' ) ) {
    if ( file_exists( dirname( __FILE__ ) . '/redux-framework/redux-vendor-support/extension_vendor_support.php' ) ) {
        require dirname( __FILE__ ) . '/redux-framework/redux-vendor-support/extension_vendor_support.php';
        new ReduxFramework_extension_vendor_support();
    }
}