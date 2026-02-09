<?php
defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_post_type(
			'produk',
			array(
				'labels'       => array(
					'name'          => 'Produk',
					'singular_name' => 'Produk',
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'produk' ),
				'menu_icon'    => 'dashicons-cart',
				'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
				'show_in_rest' => true,
			)
		);
	}
);
