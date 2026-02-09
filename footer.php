<?php
defined( 'ABSPATH' ) || exit;
?>

<footer class="mt-16 border-t border-black/5 bg-white">
	<div class="container-1280 py-12">
		<div class="grid grid-cols-1 md:grid-cols-3 gap-10">

			<!-- Brand -->
			<div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-3">
					<div class="h-10 w-10 rounded-xl bg-gray-900"></div>
					<div class="leading-tight">
						<div class="font-bold text-gray-900">Sejahtera Alkes</div>
						<div class="text-sm text-gray-600">Katalog Alkes • Konsultasi via WhatsApp</div>
					</div>
				</a>

				<p class="mt-4 text-sm text-gray-600 leading-relaxed">
					Katalog alat kesehatan untuk kebutuhan kantor, klinik, dan fasilitas publik. Pemesanan dan
					konsultasi dilakukan melalui WhatsApp untuk respon cepat.
				</p>

				<div class="mt-5 flex flex-wrap gap-2">
					<span
						class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-black/5">
			Respon cepat
			</span>
					<span
						class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-black/5">
			Pengiriman Indonesia
			</span>
					<span
						class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-black/5">
			Garansi (jika berlaku)
			</span>
					<span
						class="inline-flex items-center rounded-full bg-slate-50 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-black/5">
			Verifikasi legalitas
			</span>
				</div>
			</div>

			<!-- Footer menu -->
			<div>
				<div class="text-sm font-semibold text-gray-900">Menu</div>

				<div class="mt-4">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'container'      => false,
							'fallback_cb'    => false,
							'menu_class'     => 'flex flex-col gap-2 text-sm',
							'link_before'    => '<span class="text-gray-700 hover:text-gray-900">',
							'link_after'     => '</span>',
						)
					);
					?>

					<?php if ( ! has_nav_menu( 'footer' ) ) : ?>
						<div class="text-sm text-gray-600">
							Atur menu di: Appearance → Menus → Footer Menu.
						</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Contact -->
			<div>
				<div class="text-sm font-semibold text-gray-900">Kontak</div>

				<div class="mt-4 space-y-3 text-sm text-gray-700">
					<div>
						<div class="text-xs font-semibold text-gray-500">WhatsApp</div>
						<a
							class="inline-flex items-center gap-2 font-semibold text-green-700 hover:text-green-800"
							href="#cta-wa"
						>
							Konsultasi via WhatsApp
						</a>
					</div>

					<div>
						<div class="text-xs font-semibold text-gray-500">Email</div>
						<a class="hover:underline" href="mailto:cs@sejahteraalkes.com">cs@sejahteraalkes.com</a>
					</div>

					<div>
						<div class="text-xs font-semibold text-gray-500">Alamat</div>
						<div class="text-gray-700">
							Jakarta Timur (showroom) — alamat detail via WhatsApp.
						</div>
					</div>

					<div class="pt-2">
						<div class="text-xs font-semibold text-gray-500">Legal</div>
						<div class="flex flex-col gap-2">
							<a class="hover:underline" href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy
								Policy</a>
							<a class="hover:underline" href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>">Disclaimer</a>
						</div>
					</div>
				</div>
			</div>

		</div>

		<div
			class="mt-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-t border-black/5 pt-6">
			<div class="text-xs text-gray-500">
				© <?php echo esc_html( wp_date( 'Y' ) ); ?> Sejahtera Alkes. All rights reserved.
			</div>

			<div class="text-xs text-gray-500">
				Katalog online — pembelian melalui WhatsApp.
			</div>
		</div>
	</div>
</footer>

<div
	class="fixed inset-0 z-[9999] hidden"
	data-lightbox
	aria-hidden="true"
>
	<!-- Overlay -->
	<div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]" data-lightbox-overlay></div>

	<!-- Panel -->
	<div class="relative h-full w-full flex items-center justify-center p-4">
		<div
			class="relative w-full max-w-4xl rounded-2xl bg-white shadow-2xl overflow-hidden"
			data-lightbox-panel
			role="dialog"
			aria-modal="true"
			aria-label="Preview gambar produk"
			tabindex="-1"
		>
			<!-- Top bar -->
			<div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
				<div class="text-sm font-semibold text-slate-800" data-lightbox-counter>1 / 1</div>

				<button
					type="button"
					class="inline-flex h-9 w-9 items-center justify-center rounded-lg hover:bg-slate-50 text-slate-600"
					data-lightbox-close
					aria-label="Tutup"
				>
					<!-- X icon -->
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
						stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
					</svg>
				</button>
			</div>

			<!-- Image stage -->
			<div class="relative bg-slate-50">
				<img
					src=""
					alt=""
					class="w-full max-h-[75vh] object-contain"
					data-lightbox-img
				/>

				<!-- Prev/Next -->
				<button
					type="button"
					class="absolute left-3 top-1/2 -translate-y-1/2 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/90 hover:bg-white shadow ring-1 ring-black/5 text-slate-700"
					data-lightbox-prev
					aria-label="Sebelumnya"
				>
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
						stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
					</svg>
				</button>

				<button
					type="button"
					class="absolute right-3 top-1/2 -translate-y-1/2 inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white/90 hover:bg-white shadow ring-1 ring-black/5 text-slate-700"
					data-lightbox-next
					aria-label="Berikutnya"
				>
					<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
						stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
					</svg>
				</button>
			</div>
		</div>
	</div>
</div>


<?php wp_footer(); ?>
</body>
</html>
