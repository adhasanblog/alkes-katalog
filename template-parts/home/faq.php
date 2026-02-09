<?php
defined( 'ABSPATH' ) || exit;

$items = array(
	array(
		'q' => 'Apakah harga di website sudah final?',
		'a' => 'Sebagian produk menampilkan harga. Namun untuk produk tertentu harga bisa berubah tergantung varian, ketersediaan, dan kebutuhan instalasi. Konfirmasi via WhatsApp untuk penawaran final.',
	),
	array(
		'q' => 'Bagaimana memastikan produk legal / izin edar?',
		'a' => 'Kami menyediakan informasi izin edar/sertifikasi sesuai kategori produk. Untuk memastikan kecocokan model/varian, tim kami akan bantu verifikasi sebelum pembelian.',
	),
	array(
		'q' => 'Apakah bisa kirim ke luar kota?',
		'a' => 'Bisa. Kami melayani pengiriman ke seluruh Indonesia dengan packing aman. Estimasi dan ongkir disesuaikan dengan kota tujuan dan jenis produk.',
	),
	array(
		'q' => 'Apakah ada garansi dan after-sales?',
		'a' => 'Ada (tergantung produk). Kami bantu panduan penggunaan, klaim garansi, serta informasi sparepart jika diperlukan.',
	),
	array(
		'q' => 'Saya butuh rekomendasi untuk kantor/klinik. Bisa dibantu?',
		'a' => 'Bisa. Beri info kebutuhan (jenis fasilitas, estimasi pengguna/pasien, lokasi, dan budget) lalu kami rekomendasikan opsi yang paling relevan.',
	),
);
?>

<section id="faq" class="scroll-mt-24 w-full section-y bg-white">
	<div class="container-1280">
		<div class="max-w-2xl">
			<h2 class="text-2xl md:text-3xl font-bold tracking-tight">FAQ</h2>
			<p class="mt-2 text-gray-600">
				Jawaban cepat untuk pertanyaan yang paling sering muncul sebelum membeli.
			</p>
		</div>

		<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-4">
			<?php foreach ( $items as $it ) : ?>
				<details
					class="group rounded-2xl bg-slate-50 ring-1 ring-black/5 p-5 open:bg-white open:shadow-sm transition">
					<summary class="cursor-pointer list-none flex items-start justify-between gap-4">
						<span class="font-semibold text-gray-900"><?php echo esc_html( $it['q'] ); ?></span>

						<!-- modern chevron -->
						<span class="shrink-0 text-slate-400 transition group-open:rotate-180">
				<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
					stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
				<path d="M6 9l6 6 6-6"></path>
				</svg>
			</span>
					</summary>

					<div class="mt-3 text-sm text-gray-600 leading-relaxed">
						<?php echo esc_html( $it['a'] ); ?>
					</div>
				</details>
			<?php endforeach; ?>
		</div>

		<div class="mt-8">
			<a
				href="#cta-wa"
				class="inline-flex items-center justify-center rounded-xl bg-green-600 px-6 py-3 text-white font-semibold hover:bg-green-700 transition"
			>
				Masih ada pertanyaan? Chat WhatsApp
			</a>
		</div>
	</div>
</section>
