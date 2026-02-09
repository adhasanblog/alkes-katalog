<?php
/**
 * Featured products data.
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
			if ( '' !== $val ) {
				return $val;
			}
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

if ( ! function_exists( 'alkes_get_featured_products' ) ) {
	/**
	 * Get featured products (produk_flag=unggulan) ordered by featured_order.
	 *
	 * @param int $limit Number of products to fetch.
	 * @return array<int, array<string, mixed>>
	 */
	function alkes_get_featured_products( int $limit = 8 ): array {
		$limit = max( 1, min( 24, $limit ) );

		// Cache to avoid running the query on every request.
		$cache_key = 'alkes_featured_products_' . $limit;
		$cached    = get_transient( $cache_key );

		if ( is_array( $cached ) ) {
			return $cached;
		}

		$args = array(
			'post_type'              => 'produk',
			'post_status'            => 'publish',
			'posts_per_page'         => $limit,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,

			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			'tax_query'              => array(
				array(
					'taxonomy' => 'produk_flag',
					'field'    => 'slug',
					'terms'    => array( 'unggulan' ),
				),
			),

			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_key'               => 'featured_order',
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

				$img_url = '';
				if ( is_string( $img ) && '' !== $img ) {
					$img_url = $img;
				}

				$items[] = array(
					'id'    => $id,
					'title' => (string) get_the_title(),
					'url'   => (string) get_permalink(),
					'img'   => $img_url,

					'price' => array(
						'display' => alkes_get_field_string( 'price_display', $id, 'contact' ),
						'from'    => alkes_get_field_float( 'price_from', $id, 0.0 ),
						'exact'   => alkes_get_field_float( 'price_exact', $id, 0.0 ),
					),

					'izin'  => array(
						'no'     => alkes_get_field_string( 'izin_edar_number', $id, '' ),
						'status' => alkes_get_field_string( 'izin_edar_status', $id, '' ),
					),
				);
			}

			wp_reset_postdata();
		}

		// Cache for 10 minutes (adjust as needed).
		set_transient( $cache_key, $items, 10 * MINUTE_IN_SECONDS );

		return $items;
	}
}
