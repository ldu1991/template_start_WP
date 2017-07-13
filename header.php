<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

?><!DOCTYPE HTML>
<html <?php language_attributes(); ?>>

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1, shrink-to-fit=no">
    <?php if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( false !== strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) ) ) : ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <?php endif; ?>

    <?php
        $favicon = ld_options( 'favicon', false, 'url' );
        $mobile_favicon = ld_options( 'mobile-favicon', false, 'url' );
        $header_bar_color = ld_options( 'header-bar-color', false, false );
    ?>

    <?php if (!empty($favicon)) { ?>
        <link rel="shortcut icon" href="<?php echo $favicon;?>">
    <?php } ?>
    <?php if (!empty($mobile_favicon)) { ?>
        <link rel="apple-touch-icon-precomposed" href="<?php echo $mobile_favicon;?>">
    <?php } ?>
    <?php if (!empty($header_bar_color)) { ?>
        <meta name="theme-color" content="<?php echo $header_bar_color; ?>">
    <?php } ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
 
    <header itemscope itemtype="http://schema.org/WPHeader">
        <div class="container">
            <div class="row">
                <div class="logo-nav-search col-xs-12">
                    <div class="logo">
                        <?php Beyond()->get_logo( 'logo', 'logo-retina' ); ?>
                        <div style="display: none" itemprop="description"></div>
                    </div>

                    <div id="slickmenu"></div>
                    <nav class="nav-search" itemscope itemtype="http://schema.org/SiteNavigationElement" role='navigation'>
                        <?php Beyond()->get_nav('menu', 'menuId'); ?>

                        <?php get_search_form(); ?>
                    </nav>

                </div>
            </div>
        </div>
    </header>

