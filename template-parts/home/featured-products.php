<?php
defined( 'ABSPATH' ) || exit;

// Ambil items, pastikan aman dari error undefined index.
$items = array();
if ( isset( $args['items'] ) && is_array( $args['items'] ) ) {
	$items = $args['items'];
}

// Jika kosong, tidak perlu render apapun.
if ( empty( $items ) ) {
	return;
}

if ( ! function_exists( 'alkes_price_label' ) ) {
	/**
	 * Helper function untuk menampilkan label harga.
	 * Menggunakan Long Ternary atau If/Else standar untuk menghindari error Short Ternary.
	 *
	 * @param mixed $price Data harga.
	 * @return string Label harga.
	 */
	function alkes_price_label( $price ): string {
		// Default mode
		$mode = 'contact';

		// Cek mode display
		if ( is_array( $price ) && isset( $price['display'] ) ) {
			$display = strtolower( trim( (string) $price['display'] ) );
			if ( '' !== $display ) {
				$mode = $display;
			}
		}

		// Ambil nilai exact dan from dengan pengecekan isset standar
		$exact = ( is_array( $price ) && isset( $price['exact'] ) ) ? (float) $price['exact'] : 0.0;
		$from  = ( is_array( $price ) && isset( $price['from'] ) ) ? (float) $price['from'] : 0.0;

		// Logika return (Tanpa Short Ternary)
		if ( 'exact' === $mode && $exact > 0 ) {
			return 'Rp ' . number_format( (int) $exact, 0, ',', '.' );
		}

		if ( 'from' === $mode && $from > 0 ) {
			return 'Mulai Rp ' . number_format( (int) $from, 0, ',', '.' );
		}

		if ( 'quote' === $mode ) {
			return 'Quotation (B2B)';
		}

		return 'Hubungi untuk harga';
	}
}
?>

<section id="FeaturedProducts" class="scroll-mt-24 w-full section-y bg-white">
	<div class="container-1280">
		<div class="flex items-end justify-between gap-6">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold tracking-tight">Produk Unggulan</h2>
				<p class="mt-2 text-gray-600">
					Rekomendasi produk yang paling sering dicari untuk kantor, klinik, dan fasilitas publik.
				</p>
			</div>

			<a
				href="<?php echo esc_url( home_url( '/produk/' ) ); ?>"
				class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900"
			>
				Lihat semua →
			</a>
		</div>

		<div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
			<?php foreach ( $items as $p ) : ?>

				<article class="group rounded-2xl bg-white ring-1 ring-black/5 hover:shadow-sm transition overflow-hidden">
					<a href="<?php echo esc_url( $p['url'] ); ?>" class="block">
						<div class="aspect-[4/3] bg-slate-50">
							<?php if ( ! empty( $p['img'] ) ) : ?>
								<img
									src="<?php echo esc_url( $p['img'] ); ?>"
									alt="<?php echo esc_attr( $p['title'] ); ?>"
									class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-[1.02]"
									loading="lazy"
									decoding="async"
								/>
							<?php endif; ?>
						</div>
					</a>

					<div class="p-4">
						<a
							href="<?php echo esc_url( $p['url'] ); ?>"
							class="font-semibold leading-snug text-gray-900 hover:underline line-clamp-2"
						>
							<?php echo esc_html( $p['title'] ); ?>
						</a>

						<div class="mt-2 text-sm font-bold text-gray-900">
							<?php
							$price_data = array();
							if ( isset( $p['price'] ) && is_array( $p['price'] ) ) {
								$price_data = $p['price'];
							}
							echo esc_html( alkes_price_label( $price_data ) );
							?>
						</div>

						<?php
						// Logika Izin Edar (Disederhanakan tanpa Short Ternary)
						$izin_text = '';
						$izin_no   = isset( $p['izin']['no'] ) ? trim( (string) $p['izin']['no'] ) : '';
						$izin_stat = isset( $p['izin']['status'] ) ? trim( (string) $p['izin']['status'] ) : '';

						if ( '' !== $izin_no ) {
							$izin_text = 'Izin edar: ' . $izin_no;
						} elseif ( '' !== $izin_stat ) {
							$izin_text = 'Izin edar: ' . $izin_stat;
						}
						?>

						<?php if ( '' !== $izin_text ) : ?>
							<div class="mt-1 text-xs text-gray-600">
								<?php echo esc_html( $izin_text ); ?>
							</div>
						<?php endif; ?>

						<?php
						// Pastikan ID ada sebelum memanggil tombol WA
						$product_id = isset( $p['id'] ) ? $p['id'] : 0;
						if ( $product_id ) {
							get_template_part(
								'template-parts/product/wa-button',
								null,
								array(
									'post_id' => $product_id,
									'label'   => 'Chat WhatsApp',
									'class'   => 'mt-4 w-full inline-flex items-center justify-center rounded-xl bg-green-600 py-3 text-sm font-semibold text-white hover:bg-green-700 transition',
								)
							);
						}
						?>
					</div>
				</article>

			<?php endforeach; ?>
		</div>

		<a
			href="<?php echo esc_url( home_url( '/produk/' ) ); ?>"
			class="mt-8 sm:hidden inline-flex w-full items-center justify-center rounded-xl border border-gray-200 px-4 py-3 font-semibold text-gray-900 hover:bg-gray-50 transition"
		>
			Lihat semua produk
		</a>
	</div>
</section>
