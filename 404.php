<?php
defined( 'ABSPATH' ) || exit;
get_header();

// Ambil produk unggulan: pakai flag ACF yang kamu sudah punya.
// Ganti 'hero_show' sesuai nama field ACF kamu (contoh: tampilkan_di_hero).
$featured_args = array(
	'post_type'      => 'produk',
	'post_status'    => 'publish',
	'posts_per_page' => 6,
	'no_found_rows'  => true,

	// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	'tax_query'      => array(
		array(
			'taxonomy' => 'produk_flag',
			'field'    => 'slug',
			'terms'    => array( 'unggulan' ),
		),
	),

	// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		'meta_key'   => 'featured_order',
	'orderby'        => array(
		'meta_value_num' => 'ASC',
		'date'           => 'DESC',
	),
);


$featured = new WP_Query( $featured_args );

?>

<main class="bg-slate-50 px-4 py-12 md:py-16">
	<div class="container-1280">

		<!-- 404 Banner -->
		<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-10">
			<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8">

				<div class="max-w-2xl">
					<div
						class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
						Error 404
					</div>

					<h1 class="mt-4 text-2xl md:text-3xl font-bold text-slate-900">
						Halaman tidak ditemukan
					</h1>

					<p class="mt-3 text-slate-500">
						Link yang Anda buka tidak tersedia atau sudah dipindahkan. Anda bisa kembali ke katalog produk
						atau lihat produk unggulan di bawah.
					</p>

					<div class="mt-6 flex flex-col sm:flex-row gap-3">
						<a
							href="<?php echo esc_url( home_url( '/' ) ); ?>"
							class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition"
						>
							Kembali ke Beranda
						</a>

						<a
							href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ); ?>"
							class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition"
						>
							Buka Katalog Produk
						</a>
					</div>
				</div>

				<!-- Visual kecil (opsional, ringan) -->
				<div class="hidden md:block">
					<div class="h-24 w-24 rounded-2xl bg-slate-900"></div>
					<div class="mt-3 text-xs text-slate-400">Sejahtera Alkes</div>
				</div>

			</div>
		</div>

		<!-- Featured Products -->
		<section class="mt-10 md:mt-12">
			<div class="flex items-end justify-between gap-4">
				<div>
					<h2 class="text-lg md:text-xl font-bold text-slate-900">Produk Unggulan</h2>
					<p class="mt-1 text-sm text-slate-500">Rekomendasi cepat untuk Anda lihat sekarang.</p>
				</div>

				<a
					href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ); ?>"
					class="text-sm font-semibold text-slate-700 hover:text-slate-900"
				>
					Lihat semua →
				</a>
			</div>

			<?php if ( $featured->have_posts() ) : ?>
				<div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
					<?php
					while ( $featured->have_posts() ) :
						$featured->the_post();
						?>
						<?php
						// Render card lite (template-part)
						get_template_part( 'template-parts/catalogue/product-card-lite' );
						?>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			<?php else : ?>
				<div class="mt-6 rounded-2xl border border-slate-100 bg-white p-6 text-slate-600">
					Belum ada produk unggulan yang ditandai. Silakan tandai beberapa produk sebagai unggulan agar muncul
					di sini.
				</div>
			<?php endif; ?>
		</section>

	</div>
</main>

<?php get_footer(); ?>
