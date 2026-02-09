<?php
defined( 'ABSPATH' ) || exit;

$produk_id    = (int) get_the_ID();
$produk_title = get_the_title( $produk_id );
$produk_url   = get_permalink( $produk_id );

// Image
$img_url = get_the_post_thumbnail_url( $produk_id, 'large' );
if ( empty( $img_url ) ) {
	$img_url = ''; // kamu bisa isi fallback image kalau mau
}

// Category label (ambil term terdalam jika ada)
$cat_label = '';
$terms     = get_the_terms( $produk_id, 'kategori_produk' );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	// pilih term yang paling "dalam": yang punya parent paling panjang
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

// Price (ACF)
$price_display = function_exists( 'get_field' ) ? (string) get_field( 'price_display', $produk_id ) : '';
$price_exact   = function_exists( 'get_field' ) ? (float) get_field( 'price_exact', $produk_id ) : 0;
$price_from    = function_exists( 'get_field' ) ? (float) get_field( 'price_from', $produk_id ) : 0;

$price_text = alkes_price_text( $price_display, $price_exact, $price_from );

// WA number optional
$wa_number = function_exists( 'get_field' ) ? trim( (string) get_field( 'wa_number', $produk_id ) ) : '';
?>

<article
	class="bg-white rounded-sm shadow-sm border border-slate-100 overflow-hidden group transition-all duration-300 hover:shadow-lg">
	<!-- Media -->
	<a href="<?php echo esc_url( $produk_url ); ?>" class="block">
		<div class="relative h-72 overflow-hidden bg-slate-100">

			<!-- watermark / brand stamp -->
			<!--            <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none select-none">-->
			<!--        <span class="text-2xl font-bold text-white/20 -rotate-12 tracking-widest border border-white/30 px-4 py-2 rounded-lg backdrop-blur-[2px]">-->
			<!--          SEJAHTERAALKES-->
			<!--        </span>-->
			<!--            </div>-->

			<?php if ( $img_url ) : ?>
				<img
					src="<?php echo esc_url( $img_url ); ?>"
					alt="<?php echo esc_attr( $produk_title ); ?>"
					class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
					loading="lazy"
				/>
			<?php else : ?>
				<div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
					No Image
				</div>
			<?php endif; ?>

			<div class="absolute inset-4 border border-white/20 rounded-2xl pointer-events-none z-10"></div>

			<!-- kecil, aman: label kategori -->
			<?php if ( $cat_label ) : ?>
				<div
					class="absolute top-5 left-5 bg-white/90 backdrop-blur-sm text-slate-700 text-xs font-semibold px-3 py-1.5 rounded-full shadow-sm z-20">
					<?php echo esc_html( $cat_label ); ?>
				</div>
			<?php endif; ?>
		</div>
	</a>

	<!-- Content -->
	<div class="p-5">
		<a href="<?php echo esc_url( $produk_url ); ?>" class="block">
			<h3 class="text-base font-semibold text-slate-900 mb-2 leading-snug group-hover:text-slate-700 transition-colors line-clamp-2">
				<?php echo esc_html( $produk_title ); ?>
			</h3>
		</a>

		<div class="flex items-end justify-between gap-3 mb-4">
			<div class="text-lg font-bold text-slate-900">
				<?php echo esc_html( $price_text ); ?>
			</div>
		</div>

		<!-- CTA WA -->
		<div class="mt-4 grid grid-cols-1 gap-2">

			<!-- Detail Produk (primary intent di katalog) -->
			<a
				href="<?php echo esc_url( $produk_url ); ?>"
				class="w-full inline-flex items-center justify-center gap-2 rounded-xl
			border border-slate-300 bg-white px-4 py-3 text-sm font-semibold
			text-slate-800 transition-colors
			hover:bg-slate-50 hover:border-slate-400 active:scale-[0.98]"
			>
				Lihat Detail Produk
			</a>

			<!-- WhatsApp (secondary) -->
			<?php
			get_template_part(
				'template-parts/product/wa-button',
				null,
				array(
					'post_id' => $produk_id,
					'label'   => 'Chat WhatsApp',
					'class'   => 'w-full inline-flex items-center justify-center rounded-xl bg-green-600 py-3 text-sm font-semibold text-white hover:bg-green-700 transition',
				)
			);
			?>


		</div>


		<div class="mt-3 text-xs text-slate-400">
			Klik untuk tanya stok, harga, dan estimasi pengiriman.
		</div>
	</div>
</article>
