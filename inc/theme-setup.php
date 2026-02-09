<?php
defined( 'ABSPATH' ) || exit;

add_action(
	'after_switch_theme',
	function () {
		update_option( 'alkes_theme_activated_at', time() );

		// kalau mau warning kalau ACF belum ada:
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			update_option( 'alkes_needs_acf', 1 );
		} else {
			delete_option( 'alkes_needs_acf' );
		}
	}
);


add_action(
	'after_setup_theme',
	function () {
		// Theme supports
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption' ) );

		// Menus
		register_nav_menus(
			array(
				'topbar'       => __( 'Topbar Menu', 'alkes-catalog' ),
				'home_primary' => __( 'Homepage Menu', 'alkes-catalog' ),
				'primary'      => __( 'Primary Menu', 'alkes-catalog' ),
				'footer'       => __( 'Footer Menu', 'alkes-catalog' ),
			)
		);
	}
);
