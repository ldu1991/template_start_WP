<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 770; /* pixels */
}

/**
 * Include the main Beyond.
 */
include_once( 'include/class-beyond.php' );

/**
 * Define basic properties in the Avada class.
 */
Beyond::$template_dir_path   = get_template_directory();
Beyond::$template_dir_url    = get_template_directory_uri();
Beyond::$stylesheet_dir_path = get_stylesheet_directory();
Beyond::$stylesheet_dir_url  = get_stylesheet_directory_uri();

/*
 * Include mobile detection
 */
require_once( 'include/class-beyond-mobiledetect.php' );

/*
 * Class Breadcrumbs
 */
include_once( 'include/class-beyond-breadcrumbs.php' );

/**
 * Instantiates the Beyond class.
 * Make sure the class is properly set-up.
 * The Beyond class is a singleton
 * so we can directly access the one true Beyond object using this function.
 *
 * @return object Beyond
 */
function Beyond() {
	return Beyond::get_instance();
}

/*
 * Instantiates the Breadcrumbs class.
 */
function breadcrumbs( $sep = ' » ', $l10n = array(), $args = array() ){
	$bc = new Breadcrumbs;
	echo $bc->get_crumbs( $sep, $l10n, $args );
}

/**
 * Filters the URI of the current theme stylesheet.
 */
function get_custom_stylesheet() {
	$stylesheet_uri = Beyond::$stylesheet_dir_url . '/assets/css/style.css';
	return apply_filters( 'stylesheet_uri', $stylesheet_uri, Beyond::$stylesheet_dir_url );
}

/**
 * Connection scripts and styles
 */
function set_scripts() {

    // StyleSheet
    wp_enqueue_style( 'theme-style', get_custom_stylesheet(), array(), Beyond()->get_theme_version(), all );

    // JavaScript
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'scripts', Beyond::$template_dir_url . '/assets/js/scripts.min.js', array(), Beyond()->get_theme_version(), true );

}
add_action( 'wp_enqueue_scripts', 'set_scripts' );

/**
 * Register supports
 */
if ( !function_exists( 'set_setup' ) ) {
    function set_setup() {

        // Localisation Support
        load_theme_textdomain('html5blank', get_template_directory() . '/languages');

    	// Let WordPress manage the document title.
    	add_theme_support( 'title-tag' );

    	// Add default posts and comments RSS feed links to head.
    	add_theme_support( 'automatic-feed-links' );

    	// Enable support for Post Thumbnails on posts and pages.
    	add_theme_support( 'post-thumbnails' );
    	add_image_size( 'thumbnail-once', 200, 200, true );

    	// This theme uses wp_nav_menu() in one location.
    	register_nav_menus( array(
    		'theme_menu' => __( 'Menu', 'ld' ),
    	) );

    	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
    	add_theme_support( 'html5', array(
    		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    	) );

        // Post formats
        add_theme_support( 'post-formats', array(
            'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'chat', 'audio'
        ) );

        // Register support woocommerce
        add_theme_support( 'woocommerce' );

    }
}
add_action( 'after_setup_theme', 'set_setup' );


// Theme customizer
include_once( 'include/dynamic_css.php' );

// Widget popular
include_once( 'include/widget/widget-popular.php' );

// Post type
include_once( 'include/post-type-1.php' );

// schema.org
include_once( 'include/schema.org.php' );

// Translit
include_once( 'include/translit.php' );


/*
 * Connection additions
 */
// Redux Framework - theme options
if ( !class_exists( 'reduxframework' ) && file_exists( dirname( __FILE__ ) . '/include/redux-framework/ReduxCore/framework.php' ) ) {
	require_once( dirname( __FILE__ ) . '/include/redux-framework/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/include/redux-config.php' ) ) {
	require_once( dirname( __FILE__ ) . '/include/redux-config.php' );
}

// Advanced custom fields pro

// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
function my_acf_settings_path( $path ) {
	// update path
	$path = Beyond::$stylesheet_dir_path . '/include/advanced-custom-fields/';
	// return
	return $path;
}

// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
function my_acf_settings_dir( $dir ) {
	// update path
	$dir = Beyond::$stylesheet_dir_url . '/include/advanced-custom-fields/';
	// return
	return $dir;
}

// Hide ACF field group menu item
// add_filter('acf/settings/show_admin', '__return_false');

// Include ACF
include_once( Beyond::$stylesheet_dir_path . '/include/advanced-custom-fields/acf.php' );

// ACF options
// include_once( Beyond::$stylesheet_dir_path . '/include/acf-config.php' );


/* ================================================
                 REGISTER SIDEBAR
================================================ */
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name'          => __( 'Sidebar Left', 'st' ),
        'description'   => __( '', 'st' ),
        'id'            => 'sidebar-left',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="widget-title" itemprop="name">',
		'after_title'   => '</span>',
	));

	register_sidebar(array(
		'name'          => __( 'Sidebar Right', 'st' ),
        'description'   => __( '', 'st' ),
        'id'            => 'sidebar-right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<span class="widget-title" itemprop="name">',
		'after_title'   => '</span>',
	));
}



/* ================================================
                WOOCOMMERCE SUPPORT
================================================ */
function woocommerce_category_image($cat) {
    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
    $image = wp_get_attachment_url( $thumbnail_id );
    if ( $image ) {
    return $image;
    }
}

add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' ); // remove woocommerce styles

// mini-cart header
add_filter( 'add_to_cart_fragments', 'ld_wc_add_to_cart_fragment' );
function ld_wc_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    ld_wc_cart_mini();
    $fragments['.min_cart_totals'] = ob_get_clean();
    return $fragments;
}

function ld_wc_cart_mini() { // call function mini-cart
    global $woocommerce;
    $link_total = get_option( 'wc_ct_link_display_total' );
    ?>
    <div class="min_cart_totals">
        <?php
        if ( 'total' == $link_total ) {
        	echo wp_kses_post( $woocommerce->cart->get_cart_total() );
        } elseif ( 'subtotal' == $link_total ) {
        	echo wp_kses_post( $woocommerce->cart->get_cart_subtotal() );
        }
        echo '<span class="contents">' . sprintf( _n( '%d товар', '%d товаров', intval( $woocommerce->cart->get_cart_contents_count() ), 'woocommerce-cart-tab' ), intval( $woocommerce->cart->get_cart_contents_count() ) ) . '</span>';
        ?>
    </div>
    <?php
}
// mini-cart header END


/* ================================================
                  CUSTOM COMMENT
================================================ */
function ld_comments($comment, $args, $depth){
    $GLOBALS['comment'] = $comment;
    if ( 'div' == $args['style'] ) {
    $tag = 'div';
    $add_below = 'comment';
    } else {
    $tag = 'li';
    $add_below = 'div-comment';
    }
   ?>
    <!-- the callback function contains only the opening tag <li> and it should not be closed. -->
    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">

        <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-body" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
        <?php endif; ?>



            <div class="avatar-author">
                <div class="avatar">
                    <img src="<?php echo get_avatar_url( $comment ); ?>" alt="<?php comment_author(); ?>">
                    <!--<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>-->
                </div><!-- .avatar -->
            </div><!-- .avatar-author -->

            <div class="comment">
                <div class="comment-body">
                    <?php if ($comment->comment_approved == '0') : ?>
                		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
                        <br />
                	<?php endif; ?>

                    <div class="author-editing">
                        <?php printf( __('<div itemprop="creator" class="author">%s</div>' ), get_comment_author_link() ); ?>
                        <div class="edit-reply">
                            <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

                            <?php edit_comment_link( __( '(Edit)' ), '&nbsp;&nbsp;', '' ); ?>
                        </div>
                    </div>

                    <span itemprop="text"><?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>

                    <time class="comment-date" itemprop="datePublished" datetime="<?php the_time('c'); ?>"><?php the_time('Y-m-d'); ?></time> в <?php echo (get_comment_time() ); ?>

                </div><!-- .comment-body -->
            </div><!-- .comment -->

        <?php if ( 'div' != $args['style'] ) : ?>
        </div><!-- .comm-class -->
        <?php endif; ?>
<?php }


/* ================================================
              LIMITING THE CHARACTERS
================================================ */
function st_title_chars($count, $after) { // the_title
    $title = get_the_title();
    if (mb_strlen($title) > $count) $title = mb_substr($title,0,$count);
    else $after = '';
    echo $title . $after;
}

function st_content_chars($count, $after) { // the_content
    $content = get_the_content();
    if (mb_strlen($content) > $count) $content = mb_substr($content,0,$count);
    else $after = '';
    echo $content . $after;
}


/**
 * Load Enqueued Scripts in the Footer
 */
function set_remove() {
remove_action( 'wp_head', 'wp_print_scripts' );
remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'wp_enqueue_scripts', 'set_remove' );

?>