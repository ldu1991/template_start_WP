<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * The main theme class.
 */
class Beyond {

	/**
	 * The template directory path.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $template_dir_path = '';

	/**
	 * The template directory URL.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $template_dir_url = '';

	/**
	 * The stylesheet directory path.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $stylesheet_dir_path = '';

	/**
	 * The stylesheet directory URL.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $stylesheet_dir_url = '';

	/**
	 * The one, true instance of the Beyond object.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;

	/**
	 * Mobil detect.
	 * isMobile()
     * isTablet()
     * isiOS()
     * isAndroidOS()
     * ...
     *
	 * @access public
	 * @var object
	 */
	public $mibil_detect;

	/**
	 * Device type.
	 *
	 * @access public
	 * @var string
	 */
    public $device_type;

	/**
	 * The theme version.
	 *
	 * @static
	 * @access public
	 * @var string
	 */
	public static $version = '3.4.2';

	/**
	 * Access the single instance of this class.
	 *
	 * @return Beyond
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new Beyond();
		}
		return self::$instance;
	}

	/**
	 * The class constructor
	 */
	private function __construct() {

		// Set static vars.
		if ( '' === self::$template_dir_path ) {
			self::$template_dir_path = get_template_directory();
		}
		if ( '' === self::$template_dir_url ) {
			self::$template_dir_url = get_template_directory_uri();
		}
		if ( '' === self::$stylesheet_dir_path ) {
			self::$stylesheet_dir_path = get_stylesheet_directory();
		}
		if ( '' === self::$stylesheet_dir_url ) {
			self::$stylesheet_dir_url = get_stylesheet_directory_uri();
		}

        $this->mibil_detect  = new Mobile_Detect;
        $this->device_type   = ($this->mibil_detect->isMobile() ? ($this->mibil_detect->isTablet() ? 'tablet' : 'phone') : 'computer');

	}

	/**
	 * Gets the theme version.
	 *
	 * @since 5.0
	 *
	 * @return string
	 */
	public static function get_theme_version() {
		return self::$version;
	}

	/**
	 * Get the Logotype.
	 *
	 * @return string
	 */
    function get_logo($logo, $logo_retina) {
        $logo_url = ld_options( $logo, false, 'url' );
        $logo_retina_url = ld_options( $logo_retina, false, 'url' );
        if ($this->device_type == 'phone' || $this->device_type == 'tablet') {
            $mobile = true;
        } else {
            $mobile = '';
        }

        if( (!empty($logo_url) && empty($mobile)) || (empty($logo_retina_url) && !empty($logo_url) && !empty($mobile)) ) {
            $logotype = '<a class="logo-1x" href="'. esc_url( home_url( '/' ) ). '" rel="homepage" itemprop="headline"><img src="'.$logo_url.'" alt="'. get_bloginfo( 'name' ) .'"></a>';
        } elseif( (!empty($logo_retina_url) && !empty($mobile)) || (!empty($logo_retina_url) && empty($logo_url) && empty($mobile)) ) {
            $logotype = '<a class="logo-2x" href="'. esc_url( home_url( '/' ) ). '" rel="homepage" itemprop="headline"><img src="'.$logo_retina_url.'" alt="'. get_bloginfo( 'name' ) .'"></a>';
        } else {
            $logotype = '<a class="logo-no" href="'. esc_url( home_url( '/' ) ). '" rel="homepage" itemprop="headline">'. get_bloginfo( 'name' ) .'</a>';
        }
        echo $logotype;
    }

	/**
	 * Get the Logotype.
	 *
	 * @return string
	 */
    function get_nav( $menu_class = '', $menu_id = '', $location = 'theme_menu', $depth = 0 ) {
        wp_nav_menu( array(
        	'theme_location'  => $location,
        	'container'       => false,
        	'menu_class'      => $menu_class,
        	'menu_id'         => $menu_id,
        	'echo'            => true,
        	'fallback_cb'     => 'wp_page_menu', // __return_empty_string
        	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        	'depth'           => $depth,
        	'walker'          => '',
        ) );
    }

	/**
	 * Get the Pagination.
	 *
	 * @return string
	 */
    function get_pagination($prev_next = true, $prev = '« Previous', $next = 'Next »', $total_query = '') {
        add_filter('navigation_markup_template', 'custom_navigation_template', 10, 2 );
        function custom_navigation_template( $template, $class ){
        	return '
        	<nav class="navigation">
        		<div class="nav-links">%3$s</div>
        	</nav>
        	';
        }

    	global $wp_query;
        if (!empty($total_query)) {
            $total = $total_query;
        } else {
            $total = $wp_query;
        }
    	$big = 999999999;

        $args = array(
        	'base'         => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        	'format'       => '?page=%#%',
        	'total'        => $total->max_num_pages,
        	'current'      => max( 1, get_query_var('paged') ),
        	'show_all'     => false,
        	'end_size'     => 1,
        	'mid_size'     => 1,
        	'prev_next'    => $prev_next,
        	'prev_text'    => $prev,
        	'next_text'    => $next,
        	'type'         => 'plain',
        	'add_args'     => false,
        	'add_fragment' => '',
        	'before_page_number' => '',
        	'after_page_number'  => ''
        );

        echo paginate_links( $args );
    }

}