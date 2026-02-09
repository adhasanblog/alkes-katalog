<?php
/**
 * REST API endpoints.
 *
 * @package Alkes_Katalog
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'rest_api_init',
	function (): void {
		register_rest_route(
			'alkes/v1',
			'/search',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => 'alkes_rest_search_products',
				'permission_callback' => '__return_true',
				'args'                => array(
					'q'     => array(
						'required'          => true,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'limit' => array(
						'required'          => false,
						'sanitize_callback' => 'absint',
						'default'           => 6,
					),
				),
			)
		);
	}
);

if ( ! function_exists( 'alkes_rest_search_products' ) ) {
	/**
	 * Search products endpoint.
	 *
	 * Returns lightweight data for product search UI.
	 *
	 * @param WP_REST_Request $req REST request object.
	 * @return WP_REST_Response
	 */
	function alkes_rest_search_products( WP_REST_Request $req ): WP_REST_Response {
		$q     = trim( (string) $req->get_param( 'q' ) );
		$limit = (int) $req->get_param( 'limit' );

		if ( $limit <= 0 ) {
			$limit = 6;
		}

		if ( 10 < $limit ) {
			$limit = 10;
		}

		if ( mb_strlen( $q ) < 2 ) {
			return new WP_REST_Response(
				array(
					'items' => array(),
					'total' => 0,
				),
				200
			);
		}

		$query = new WP_Query(
			array(
				'post_type'      => 'produk',
				'post_status'    => 'publish',
				's'              => $q,
				'posts_per_page' => $limit,
				'no_found_rows'  => false,
			)
		);

		$items = array();

		foreach ( $query->posts as $p ) {
			$id = (int) $p->ID;

			$thumb = get_the_post_thumbnail_url( $id, 'thumbnail' );
			if ( ! is_string( $thumb ) ) {
				$thumb = '';
			}

			// Kategori label (ambil term terdalam).
			$cat   = '';
			$terms = get_the_terms( $id, 'kategori_produk' );

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				$best       = null;
				$best_depth = -1;

				foreach ( $terms as $t ) {
					$depth = count( get_ancestors( $t->term_id, 'kategori_produk' ) );
					if ( $best_depth < $depth ) {
						$best_depth = $depth;
						$best       = $t;
					}
				}

				if ( $best ) {
					$cat = (string) $best->name;
				}
			}

			// Harga (gunakan helper jika tersedia).
			$price_text = 'Hubungi untuk harga';

			if ( function_exists( 'get_field' ) && function_exists( 'alkes_price_text' ) ) {
				$display = (string) get_field( 'price_display', $id );
				$exact   = (float) get_field( 'price_exact', $id );
				$from    = (float) get_field( 'price_from', $id );

				$price_text = alkes_price_text( $display, $exact, $from );
			}

			$items[] = array(
				'id'    => $id,
				'title' => (string) get_the_title( $id ),
				'url'   => (string) get_permalink( $id ),
				'thumb' => $thumb,
				'cat'   => $cat,
				'price' => $price_text,
			);
		}

		return new WP_REST_Response(
			array(
				'items' => $items,
				'total' => (int) $query->found_posts,
			),
			200
		);
	}
}
