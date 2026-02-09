<?php
/**
 * Hero products data.
 *
 * @package Alkes_Katalog
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'alkes_get_field_string' ) ) {
	/**
	 * Get an ACF field value as a trimmed string with fallback.
	 *
	 * @param string $key      ACF field name.
	 * @param int    $post_id  Post ID.
	 * @param string $fallback Fallback value when empty.
	 * @return string
	 */
	function alkes_get_field_string( string $key, int $post_id, string $fallback = '' ): string {
		if ( ! function_exists( 'get_field' ) ) {
			return $fallback;
		}

		$val = get_field( $key, $post_id );

		if ( is_string( $val ) ) {
			$val = trim( $val );
			return ( '' !== $val ) ? $val : $fallback;
		}

		if ( is_numeric( $val ) ) {
			return (string) $val;
		}

		return $fallback;
	}
}

if ( ! function_exists( 'alkes_get_field_float' ) ) {
	/**
	 * Get an ACF field value as float with fallback.
	 *
	 * @param string $key      ACF field name.
	 * @param int    $post_id  Post ID.
	 * @param float  $fallback Fallback value when empty/invalid.
	 * @return float
	 */
	function alkes_get_field_float( string $key, int $post_id, float $fallback = 0.0 ): float {
		if ( ! function_exists( 'get_field' ) ) {
			return $fallback;
		}

		$val = get_field( $key, $post_id );

		if ( null === $val || '' === $val ) {
			return $fallback;
		}

		return is_numeric( $val ) ? (float) $val : $fallback;
	}
}

if ( ! function_exists( 'alkes_get_hero_products' ) ) {
	/**
	 * Get hero-highlight products.
	 *
	 * Recommended source of truth:
	 * - taxonomy produk_flag includes slug "hero" for hero-highlight products
	 * - ordering uses meta "hero_order" (numeric)
	 *
	 * @param int $limit Number of products to fetch.
	 * @return array<int, array<string, mixed>>
	 */
	function alkes_get_hero_products( int $limit = 5 ): array {
		$limit = max( 1, min( 12, $limit ) );

		$args = array(
			'post_type'              => 'produk',
			'post_status'            => 'publish',
			'posts_per_page'         => $limit,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,

			// Hero flag via taxonomy (lebih scalable daripada meta_query).
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			'tax_query'              => array(
				array(
					'taxonomy' => 'produk_flag',
					'field'    => 'slug',
					'terms'    => array( 'hero' ),
				),
			),

			// Manual ordering.
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_key'               => 'hero_order',
			'orderby'                => 'meta_value_num',
			'order'                  => 'ASC',
		);

		$q = new WP_Query( $args );

		$items = array();

		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();

				$id  = (int) get_the_ID();
				$img = get_the_post_thumbnail_url( $id, 'large' );

				if ( ! is_string( $img ) || '' === $img ) {
					continue; // Hero wajib punya image.
				}

				$items[] = array(
					'id'    => $id,
					'title' => (string) get_the_title(),
					'img'   => $img,
					'url'   => (string) get_permalink(),
					'badge' => alkes_get_field_string( 'hero_badge', $id, '' ),

					'price' => array(
						'display' => alkes_get_field_string( 'price_display', $id, 'contact' ),
						'from'    => alkes_get_field_float( 'price_from', $id, 0.0 ),
						'exact'   => alkes_get_field_float( 'price_exact', $id, 0.0 ),
						'note'    => alkes_get_field_string( 'price_note', $id, '' ),
					),

					'izin'  => array(
						'no'     => alkes_get_field_string( 'izin_edar_number', $id, '' ),
						'status' => alkes_get_field_string( 'izin_edar_status', $id, '' ),
					),
				);
			}

			wp_reset_postdata();
		}

		return $items;
	}
}
