<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

// Register Custom Post Type
function custom_post_portfolio() {

	$labels = array(
		'name'                => _x( 'Портфолио', 'Post Type General Name', 'st' ),
		'singular_name'       => _x( 'Портфолио', 'Post Type Singular Name', 'st' ),
		'menu_name'           => __( 'Портфолио', 'st' ),
		'name_admin_bar'      => __( 'Портфолио', 'st' ),
		'parent_item_colon'   => __( 'Источник записи:', 'st' ),
		'all_items'           => __( 'Все материалы', 'st' ),
		'add_new_item'        => __( 'Добавление записи', 'st' ),
		'add_new'             => __( 'Добавить запись', 'st' ),
		'new_item'            => __( 'Новая запись', 'st' ),
		'edit_item'           => __( 'Редактирование записи', 'st' ),
		'update_item'         => __( 'Обновление записи', 'st' ),
		'view_item'           => __( 'Посмотреть проект', 'st' ),
		'search_items'        => __( 'Поиск записи', 'st' ),
		'not_found'           => __( 'Проекты не найдены', 'st' ),
		'not_found_in_trash'  => __( 'Не найдено в корзине', 'st' ),
	);
	$args = array(
		'label'               => __( 'post_portfolio', 'st' ),
		'description'         => __( 'Портфолио', 'st' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'post-formats', ),
        'taxonomies'          => array( 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 6,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
        // 'menu_icon'           => plugins_url( 'images/image.png', __FILE__ ),
		'capability_type'     => 'post',
	);
	register_post_type( 'post_portfolio', $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_post_portfolio' );

// Register Custom Taxonomy
function custom_taxonomy_portfolio() {

	$labels = array(
		'name'                       => _x( 'Категории', 'Taxonomy General Name', 'st' ),
		'singular_name'              => _x( 'Категория', 'Taxonomy Singular Name', 'st' ),
		'menu_name'                  => __( 'Категории', 'st' ),
		'all_items'                  => __( 'Все категории', 'st' ),
		'parent_item'                => __( 'Родитель категории', 'st' ),
		'parent_item_colon'          => __( 'Родитель категории:', 'st' ),
		'new_item_name'              => __( 'Имя новой категории', 'st' ),
		'add_new_item'               => __( 'Добавить категорию', 'st' ),
		'edit_item'                  => __( 'Изменить категорию', 'st' ),
		'update_item'                => __( 'Обновить категорию', 'st' ),
		'view_item'                  => __( 'Посмотреть', 'st' ),
		'separate_items_with_commas' => __( 'Отдельные категории запятыми', 'st' ),
		'add_or_remove_items'        => __( 'Добавить или удалить категорию', 'st' ),
		'choose_from_most_used'      => __( 'Выбрать из наиболее часто используемых', 'st' ),
		'popular_items'              => __( 'Популярные', 'st' ),
		'search_items'               => __( 'Поиск категории', 'st' ),
		'not_found'                  => __( 'Не найдено', 'st' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'taxonomy_portfolio', array( 'post_portfolio' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'custom_taxonomy_portfolio', 0 );