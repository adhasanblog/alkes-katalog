<?php
defined( 'ABSPATH' ) || exit;

$current_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();
if ( ! $current_id ) {
	return;
}

$limit = isset( $args['limit'] ) ? (int) $args['limit'] : 4;
if ( $limit <= 0 ) {
	$limit = 4;
}

$terms = get_the_terms( $current_id, 'kategori_produk' );
if ( empty( $terms ) || is_wp_error( $terms ) ) {
	return;
}

// term terdalam
$best       = null;
$best_depth = -1;
foreach ( $terms as $t ) {
	$depth = count( get_ancestors( $t->term_id, 'kategori_produk' ) );
	if ( $depth > $best_depth ) {
		$best_depth = $depth;
		$best       = $t;
	}
}
if ( ! $best ) {
	return;
}

$q = new WP_Query(
	array(
		'post_type'              => 'produk',
		'post_status'            => 'publish',
		'posts_per_page'         => $limit,
		'post__not_in'           => array( $current_id ),
		'no_found_rows'          => true,
		'ignore_sticky_posts'    => true,
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false,

		// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		'tax_query'              => array(
			array(
				'taxonomy'         => 'kategori_produk',
				'field'            => 'term_id',
				'terms'            => array( (int) $best->term_id ),
				'include_children' => true,
			),
		),
	)
);


if ( ! $q->have_posts() ) {
	return;
}
?>

<section class="mt-10">
	<div class="flex items-end justify-between gap-4">
		<div>
			<h2 class="text-lg font-bold text-slate-900">Produk Terkait</h2>
			<p class="mt-1 text-sm text-slate-500">Alternatif lain dalam kategori yang relevan.</p>
		</div>
		<a
			href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ); ?>"
			class="text-sm font-semibold text-slate-600 hover:text-slate-900"
		>
			Lihat katalog →
		</a>
	</div>

	<div class="mt-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
		<?php
		while ( $q->have_posts() ) :
			$q->the_post();
			?>
			<?php get_template_part( 'template-parts/catalogue/product-card-lite' ); ?>
			<?php
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</section>
