<?php
defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function () {
		register_taxonomy(
			'kategori_produk',
			array( 'produk' ),
			array(
				'labels'            => array(
					'name'              => 'Kategori Produk',
					'singular_name'     => 'Kategori Produk',
					'search_items'      => 'Cari Kategori',
					'all_items'         => 'Semua Kategori',
					'parent_item'       => 'Kategori Induk',
					'parent_item_colon' => 'Kategori Induk:',
					'edit_item'         => 'Edit Kategori',
					'update_item'       => 'Update Kategori',
					'add_new_item'      => 'Tambah Kategori Baru',
					'new_item_name'     => 'Nama Kategori Baru',
					'menu_name'         => 'Kategori Produk',
				),
				'public'            => true,
				'hierarchical'      => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'rewrite'           => array(
					'slug'         => 'kategori-produk',
					'with_front'   => false,
					'hierarchical' => true,
				),
			)
		);
	}
);

add_action(
	'init',
	function () {
		register_taxonomy(
			'produk_flag',
			array( 'produk' ),
			array(
				'labels'            => array(
					'name'          => 'Label Produk',
					'singular_name' => 'Label Produk',
					'menu_name'     => 'Label Produk',
				),
				'public'            => false, // tidak perlu public
				'show_ui'           => true,  // muncul di admin
				'show_admin_column' => true,
				'hierarchical'      => false,
				'show_in_rest'      => true,
				'rewrite'           => false,
			)
		);
	},
	11
);
