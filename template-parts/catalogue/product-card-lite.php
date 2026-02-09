<?php
defined( 'ABSPATH' ) || exit;

// Kalau dipanggil dari loop WP_Query, ini akan ada.
// Kalau kamu sengaja passing args['post_id'], tetap didukung.
$produk_id = 0;

if ( isset( $args['post_id'] ) ) {
	$produk_id = (int) $args['post_id'];
}

if ( $produk_id <= 0 ) {
	$produk_id = (int) get_the_ID();
}

if ( $produk_id <= 0 ) {
	return;
}

$produk_title = get_the_title( $produk_id );
$produk_url   = get_permalink( $produk_id );

$img_url = get_the_post_thumbnail_url( $produk_id, 'medium' );
if ( empty( $img_url ) ) {
	$img_url = '';
}

$cat_label = '';
$terms     = get_the_terms( $produk_id, 'kategori_produk' );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$best       = null;
	$best_depth = -1;

	foreach ( $terms as $t ) {
		$depth = count( get_ancestors( $t->term_id, 'kategori_produk' ) );
		if ( $depth > $best_depth ) {
			$best_depth = $depth;
			$best       = $t;
		}
	}

	if ( $best ) {
		$cat_label = $best->name;
	}
}

$price_text = 'Hubungi untuk harga';
if ( function_exists( 'alkes_price_text' ) && function_exists( 'get_field' ) ) {
	$display    = (string) get_field( 'price_display', $produk_id );
	$exact      = (float) get_field( 'price_exact', $produk_id );
	$from       = (float) get_field( 'price_from', $produk_id );
	$price_text = alkes_price_text( $display, $exact, $from );
}
?>

<article class="group rounded-2xl bg-white ring-1 ring-black/5 overflow-hidden hover:shadow-md transition">
	<a href="<?php echo esc_url( $produk_url ); ?>" class="block">
		<div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
			<?php if ( '' !== $img_url ) : ?>
				<img
					src="<?php echo esc_url( $img_url ); ?>"
					alt="<?php echo esc_attr( $produk_title ); ?>"
					class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
					loading="lazy"
				/>
			<?php else : ?>
				<div class="h-full w-full flex items-center justify-center text-slate-300">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 7l2-2h14l2 2M3 7v14h18V7"/>
					</svg>
				</div>
			<?php endif; ?>

			<?php if ( '' !== $cat_label ) : ?>
				<div class="absolute left-3 top-3 inline-flex items-center rounded-full bg-white/90 backdrop-blur px-2.5 py-1 text-[11px] font-semibold text-slate-700 ring-1 ring-black/5">
					<?php echo esc_html( $cat_label ); ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="p-4">
			<h3 class="text-sm font-semibold text-slate-900 leading-snug line-clamp-2 group-hover:text-slate-700">
				<?php echo esc_html( $produk_title ); ?>
			</h3>

			<div class="mt-2 flex items-center justify-between gap-3">
				<div class="text-sm font-bold text-slate-900">
					<?php echo esc_html( $price_text ); ?>
				</div>

				<span class="text-xs font-semibold text-slate-500">Lihat</span>
			</div>
		</div>
	</a>
</article>
