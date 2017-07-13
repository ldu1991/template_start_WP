<?php
/**
 * @package LD
 */

if ( ! function_exists( 'ld_custom_css' ) ) {
    function ld_custom_css() {

        $bg_color = ld_options( 'header_bar_color', false, false );

    	$custom_css = "
    		body{
    			background: {$bg_color};
    		}";

    	wp_add_inline_style( 'theme-style', $custom_css );

    }
}
add_action( 'wp_enqueue_scripts', 'ld_custom_css' );