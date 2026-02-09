<?php
defined( 'ABSPATH' ) || exit;

get_header();

if ( ! have_posts() ) {
	get_footer();
	exit;
}

the_post();

the_post();

$produk_id    = (int) get_the_ID();
$produk_title = get_the_title( $produk_id );
$produk_url   = get_permalink( $produk_id );

// image
$img = get_the_post_thumbnail_url( $produk_id, 'large' );


// image
$img = get_the_post_thumbnail_url( $produk_id, 'large' );

// category label (term terdalam)
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

// ACF (sesuaikan field kamu)
$price_display   = function_exists( 'get_field' ) ? (string) get_field( 'price_display', $produk_id ) : '';
$price_exact     = function_exists( 'get_field' ) ? (float) get_field( 'price_exact', $produk_id ) : 0;
$price_from      = function_exists( 'get_field' ) ? (float) get_field( 'price_from', $produk_id ) : 0;
$offer_terms_raw = function_exists( 'get_field' ) ? (string) get_field( 'offer_terms' ) : '';
$offer_terms_raw = trim( $offer_terms_raw );

$izin_no     = function_exists( 'get_field' ) ? trim( (string) get_field( 'distribution_permit_number', $produk_id ) ) : '';
$izin_status = function_exists( 'get_field' ) ? trim( (string) get_field( 'distribution_permit_status', $produk_id ) ) : '';

$wa_number = function_exists( 'get_field' ) ? trim( (string) get_field( 'wa_number', $produk_id ) ) : '';

// helper price (dari inc/helpers.php)
$price_text = function_exists( 'alkes_price_text' )
	? alkes_price_text( $price_display, $price_exact, $price_from )
	: 'Hubungi untuk harga';
?>

<!-- Page Header (mirip archive) -->
<section class="relative mb-8 rounded-md bg-gradient-to-br from-slate-50 to-white ring-1 ring-black/5">
	<div class="container-1280 py-8 md:py-10">

		<div class="mt-4">
			<?php get_template_part( 'template-parts/catalogue/breadcrumb-single' ); ?>
		</div>

	</div>
</section>

<main class="container-1280 section-y pt-0">
	<div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

		<!-- Sidebar -->
		<aside class="lg:col-span-3">
			<?php get_template_part( 'template-parts/catalogue/sidebar' ); ?>
		</aside>

		<!-- Content -->
		<article class="lg:col-span-9">

			<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

				<!-- Gallery -->
				<?php get_template_part( 'template-parts/product/gallery' ); ?>


				<!-- Summary -->
				<div class="rounded-md bg-white ring-1 ring-black/5 p-6">

					<h1 class="text-xl md:text-2xl font-bold tracking-tight text-gray-900">
						<?php echo esc_html( $produk_title ); ?>
					</h1>


					<div class="mt-3 text-2xl font-bold text-slate-900">
						<?php echo esc_html( $price_text ); ?>
					</div>

					<div class="mt-3 prose prose-slate max-w-none
					prose-headings:font-semibold
					prose-h2:text-lg
					prose-h3:text-md
					prose-h4:text-base
					prose-p:text-base
					prose-li:text-base
					prose-table:text-base">
						<?php the_excerpt(); ?>
					</div>

					<div class="mt-5 grid grid-cols-1 gap-2">
						<!-- Primary: Detail/Spesifikasi (scroll) -->
						<a
							href="#spesifikasi"
							class="w-full inline-flex items-center justify-center gap-2 rounded-xl
					border border-slate-300 bg-white px-4 py-3 text-sm font-semibold
					text-slate-800 transition-colors hover:bg-slate-50 hover:border-slate-400"
						>
							Download Spesifikasi
						</a>

						<!-- Secondary: WA (product mode) -->
						<?php
						get_template_part(
							'template-parts/product/wa-button',
							null,
							array(
								'post_id' => get_the_ID(),
								'label'   => 'Chat WhatsApp untuk Produk Ini',
								'class'   => 'inline-flex items-center justify-center rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white hover:bg-green-700 transition',
							)
						);
						?>

					</div>

					<?php if ( $cat_label ) : ?>
						<p class="mt-2 text-sm text-slate-600">
							Kategori: <span
								class="font-semibold text-slate-800"><?php echo esc_html( $cat_label ); ?></span>
						</p>
					<?php endif; ?>
					<?php if ( $izin_no || $izin_status ) : ?>
						<div class="mt-2 text-sm text-slate-600">
							<?php if ( $izin_no ) : ?>
								Izin edar: <span
									class="font-semibold text-slate-800"><?php echo esc_html( $izin_no ); ?></span>
							<?php else : ?>
								Izin edar: <span
									class="font-semibold text-slate-800"><?php echo esc_html( $izin_status ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<div class="mt-4 text-xs text-slate-400">
						Tanya stok, ketersediaan, pengiriman, dan rekomendasi sesuai fasilitas.
					</div>
				</div>

			</div>

			<!-- Content sections -->
			<section class="rounded-md bg-white ring-1 ring-black/5 p-6 mt-5">

				<!-- Tabs header -->
				<div class="flex gap-2 border-b border-slate-200 mb-4">
					<button
						class="px-4 py-2 text-base font-semibold border-b-2 border-slate-900 text-slate-900"
						data-tab-btn
						data-tab-target="tab-desc"
						aria-selected="true"
					>
						Deskripsi Produk
					</button>

					<button
						class="px-4 py-2 text-base font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700"
						data-tab-btn
						data-tab-target="tab-spec"
						aria-selected="false"
					>
						Spesifikasi
					</button>

					<button
						class="px-4 py-2 text-base font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700"
						data-tab-btn
						data-tab-target="tab-offer"
						aria-selected="false"
					>
						Kondisi Penawaran
					</button>
				</div>

				<!-- Tab panels -->
				<div>

					<!-- Deskripsi -->
					<div id="tab-desc" data-tab-panel>
						<div class="prose prose-slate max-w-none
					prose-headings:font-semibold
					prose-h2:text-lg
					prose-h3:text-md
					prose-h4:text-base
					prose-p:text-base
					prose-li:text-base
					prose-table:text-base">
							<?php the_content(); ?>
						</div>
					</div>

					<!-- Spesifikasi -->
					<div id="tab-spec" data-tab-panel class="hidden">
						<?php
						$spec       = function_exists( 'get_field' ) ? (array) get_field( 'spec', $produk_id ) : array();
						$spec_table = isset( $spec['spec_table'] ) ? trim( (string) $spec['spec_table'] ) : '';
						$spec_note  = isset( $spec['spec_note'] ) ? trim( (string) $spec['spec_note'] ) : '';


						$rows = alkes_parse_spec_lines( $spec_table );
						?>

						<?php if ( ! empty( $rows ) ) : ?>
							<div class="overflow-hidden rounded-sm border border-slate-200">
								<div class="overflow-x-auto">
									<table class="min-w-full text-base">
										<tbody class="divide-y divide-slate-200">
										<?php foreach ( $rows as [$k, $v] ) : ?>
											<tr class="hover:bg-slate-50/60">
												<th
													scope="row"
													class="w-[44%] md:w-[36%] bg-slate-50 px-4 py-3 text-left font-semibold text-slate-700 align-top"
												>
													<?php echo esc_html( $k ); ?>
												</th>
												<td class="px-4 py-3 text-slate-900 align-top">
													<?php echo esc_html( $v ); ?>
												</td>
											</tr>
										<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>

							<?php if ( $spec_note ) : ?>
								<p class="mt-3 text-xs text-slate-500">
									<?php echo esc_html( $spec_note ); ?>
								</p>
							<?php endif; ?>

						<?php else : ?>
							<div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
								Spesifikasi belum diisi untuk produk ini.
							</div>
						<?php endif; ?>

					</div>

					<!-- Kondisi Penawaran -->
					<div id="tab-offer" class="hidden" data-tab-panel>
						<?php if ( '' !== $offer_terms_raw ) : ?>
							<?php
							// render jadi list dari per-baris
							$lines = preg_split( '/\r\n|\r|\n/', $offer_terms_raw );
							$lines = array_values( array_filter( array_map( 'trim', $lines ) ) );
							?>
							<div class="flex items-start gap-3 mb-4">
								<p class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
									Informasi ini bisa berbeda tergantung produk/varian.</p>
							</div>

							<ul class="space-y-2">
								<?php foreach ( $lines as $line ) : ?>
									<li class="flex gap-2 text-base text-slate-700">
										<span class="mt-1.5 h-2 w-2 rounded-full bg-slate-800 flex-none"></span>
										<span><?php echo esc_html( $line ); ?></span>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php else : ?>
							<p class="text-sm text-slate-500">Belum ada kondisi penawaran untuk produk ini.</p>
						<?php endif; ?>
					</div>

				</div>

			</section>

			<?php
			get_template_part(
				'template-parts/catalogue/related-products',
				null,
				array(
					'post_id' => get_the_ID(),
					'limit'   => 4,
				)
			);
			?>


		</article>

	</div>
</main>

<?php get_footer(); ?>
