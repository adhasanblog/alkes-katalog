<?php
/**
 * One-time migration: move ACF meta is_featured=1 to taxonomy produk_flag=unggulan.
 *
 * @package Alkes_Katalog
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'init',
	function (): void {
		// Hanya admin & hanya sekali.
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( get_option( 'alkes_migrated_featured_to_tax', false ) ) {
			return;
		}

		// Pastikan taxonomy ada.
		if ( ! taxonomy_exists( 'produk_flag' ) ) {
			return;
		}

		// Pastikan term "unggulan" ada.
		$term = term_exists( 'unggulan', 'produk_flag' );
		if ( ! $term ) {
			$term = wp_insert_term( 'Unggulan', 'produk_flag', array( 'slug' => 'unggulan' ) );
		}
		if ( is_wp_error( $term ) ) {
			return;
		}

		$term_id = is_array( $term ) ? (int) $term['term_id'] : (int) $term;

		// Ini migrasi sekali jalan; meta filter dipakai untuk menemukan data legacy.
		$posts = get_posts(
			array(
				'post_type'      => 'produk',
				'post_status'    => 'publish',
				'fields'         => 'ids',
				'posts_per_page' => -1,
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_key'       => 'is_featured',
				// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'meta_value'     => '1',
			)
		);

		foreach ( $posts as $post_id ) {
			wp_set_object_terms( (int) $post_id, array( $term_id ), 'produk_flag', true );
		}

		update_option( 'alkes_migrated_featured_to_tax', 1, true );
	},
	20
);
