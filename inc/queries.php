<?php
defined( 'ABSPATH' ) || exit;

add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( is_admin() || ! $q->is_main_query() ) {
			return;
		}

		$is_produk_archive = is_post_type_archive( 'produk' );
		$is_kategori       = is_tax( 'kategori_produk' );

		// Search ke katalog produk: /produk/?s=... (form kamu action ke archive)
		$is_produk_search = $q->is_search() && (
				( 'produk' === $q->get( 'post_type' ) ) || $is_produk_archive
			);

		if ( ! $is_produk_archive && ! $is_kategori && ! $is_produk_search ) {
			return;
		}

		$sort = 'newest';

		// Nonce opsional: kalau ada sort + nonce valid, pakai nilainya.
		if ( isset( $_GET['sort'] ) ) {
			$nonce_ok = false;

			if ( isset( $_GET['_wpnonce'] ) ) {
				$nonce_ok = wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'alkes_sort' );
			}

			if ( true === $nonce_ok ) {
				$sort = sanitize_text_field( wp_unslash( $_GET['sort'] ) );
			}
		}

		$q->set( 'post_type', 'produk' );
		$q->set( 'post_status', 'publish' );
		$q->set( 'posts_per_page', 12 );

		switch ( $sort ) {
			case 'title_asc':
				$q->set( 'orderby', 'title' );
				$q->set( 'order', 'ASC' );
				break;

			case 'title_desc':
				$q->set( 'orderby', 'title' );
				$q->set( 'order', 'DESC' );
				break;

			case 'price_asc':
			case 'price_desc':
				$q->set( 'meta_key', 'price_exact' );
				$q->set( 'orderby', 'meta_value_num' );

				$order = 'DESC';
				if ( 'price_asc' === $sort ) {
					$order = 'ASC';
				}

				$q->set( 'order', $order );
				break;

			default:
				$q->set( 'orderby', 'date' );
				$q->set( 'order', 'DESC' );
				break;
		}
	}
);
