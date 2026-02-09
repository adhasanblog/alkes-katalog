<?php
defined( 'ABSPATH' ) || exit;

$products    = $args['products'] ?? array();
$catalog_url = $args['catalog_url'] ?? home_url( '/produk/' );
?>

<section class="w-full section-y bg-white hidden lg:block">
	<div class="container-1280">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">

			<!-- Copy -->
			<div>
				<div
					class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
					Katalog Alkes • Konsultasi WhatsApp
				</div>

				<h1 class="mt-4 text-3xl md:text-4xl lg:text-5xl font-bold leading-tight">
					Distributor Alat Kesehatan untuk
					<span class="text-slate-700">Klinik, Kantor, dan Fasilitas Publik</span>
				</h1>

				<p class="mt-5 text-base md:text-lg text-gray-600">
					Produk bersertifikat, garansi jelas, dan rekomendasi sesuai kebutuhan.
					Pembelian diarahkan via WhatsApp untuk respon cepat.
				</p>

				<div class="mt-8 flex flex-col sm:flex-row gap-3">
					<a
						href="#cta-wa"
						class="inline-flex items-center justify-center rounded-lg bg-green-600 px-6 py-3 text-white font-semibold hover:bg-green-700 transition"
						data-wa-trigger
					>
						Konsultasi via WhatsApp
					</a>

					<a
						href="<?php echo esc_url( $catalog_url ); ?>"
						class="inline-flex items-center justify-center rounded-lg border border-gray-200 px-6 py-3 font-semibold text-gray-800 hover:bg-gray-50 transition"
					>
						Lihat Katalog Produk
					</a>
				</div>

				<div class="mt-8 grid grid-cols-2 gap-3 text-sm text-gray-600">
					<div class="rounded-lg bg-slate-50 p-3">✅ Bersertifikat</div>
					<div class="rounded-lg bg-slate-50 p-3">✅ Garansi resmi</div>
					<div class="rounded-lg bg-slate-50 p-3">✅ Kirim seluruh Indonesia</div>
					<div class="rounded-lg bg-slate-50 p-3">✅ Dukungan after-sales</div>
				</div>
			</div>

			<!-- Visual -->
			<div class="relative">
				<div class="rounded-2xl bg-slate-50 p-4 overflow-hidden">
					<div class="relative aspect-[4/3] w-full rounded-xl bg-white shadow-sm overflow-hidden">

						<!-- Clickable image to product -->
						<a href="#" data-hero-link class="absolute inset-0 block">
							<img
								data-hero-image
								class="h-full w-full object-cover"
								src=""
								alt="Produk Alkes"
								loading="eager"
								decoding="async"
							/>
						</a>

						<!-- Subtle bottom gradient (helps readability & cohesion) -->
						<div
							class="pointer-events-none absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/20 to-transparent"></div>

						<!-- Badge (separate from card) -->
						<div
							class="absolute top-4 left-4 z-10 rounded-full bg-slate-900/70 backdrop-blur px-3 py-1 text-xs font-semibold text-white"
							data-hero-badge
						>
							Produk unggulan
						</div>

						<!-- Action Card (title + price + CTA) -->
						<div class="absolute bottom-4 left-4 sm:bottom-6 sm:left-6 w-[300px] sm:w-[320px]">
							<div
								class="rounded-xl bg-white/60 backdrop-blur-sm shadow-md ring-1 ring-black/10 px-3 py-3">

								<!-- Title as anchor -->
								<a
									href="#"
									class="block text-sm font-semibold leading-snug text-gray-900 hover:underline"
									data-hero-title
								>
									Nama Produk
								</a>

								<!-- Price -->
								<div class="mt-2">
									<div class="text-xs text-gray-500">Harga</div>
									<div class="text-sm font-bold text-gray-900" data-hero-price>—</div>
									<div class="mt-1 text-xs text-gray-600" data-hero-izin></div>
								</div>

								<!-- CTA -->
								<a
									href="#cta-wa"
									class="mt-3 inline-flex w-full items-center justify-center rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700 transition"
									data-hero-wa
									data-wa-mode="product"
									data-wa-trigger
								>
									Konsultasi via WhatsApp
								</a>


							</div>
						</div>

						<?php if ( ! empty( $products ) ) : ?>
							<script type="application/json" id="hero-products-data">
							<?php echo wp_json_encode( $products ); ?>


							</script>
						<?php endif; ?>

					</div>
				</div>
			</div>

		</div>
	</div>
</section>
