<?php
defined( 'ABSPATH' ) || exit;

$wa_number = '6289692665509';

?>

<div class="container-1280 bg-slate-900 py-8">
	<div class="rounded-sm bg-white/5 ring-1 ring-white/10 p-6 md:p-10">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

			<!-- LEFT -->
			<div>
				<h2 class="text-2xl md:text-3xl font-bold tracking-tight text-white">
					Konsultasi & Pemesanan via WhatsApp
				</h2>
				<p class="mt-2 text-base text-white/80">
					Kirim kebutuhan Anda, kami bantu rekomendasi produk dan penawaran terbaik.
				</p>

				<div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3 text-base text-white/80">
					<div class="rounded-sm bg-white/5 ring-1 ring-white/10 p-4">⚡ Respon cepat</div>
					<div class="rounded-sm bg-white/5 ring-1 ring-white/10 p-4">📦 Pengiriman aman</div>
					<div class="rounded-sm bg-white/5 ring-1 ring-white/10 p-4">🧾 Info legalitas by WA</div>
					<div class="rounded-sm bg-white/5 ring-1 ring-white/10 p-4">🛠️ After-sales (jika berlaku)</div>
				</div>
			</div>

			<!-- RIGHT: pakai komponen CTA tunggal -->
			<div>
				<?php
				get_template_part(
					'template-parts/cta/cta-form',
					null,
					array(
						'wa_number'       => $wa_number,
						'title'           => 'Template pesan (boleh edit)',
						'desc'            => 'Semakin jelas kebutuhan Anda, semakin cepat kami bisa rekomendasikan produk yang tepat.',
						'default_message' => "Halo, saya ingin konsultasi produk alkes.\n\nKebutuhan:\n- Jenis fasilitas:\n- Lokasi pengiriman:\n- Budget kisaran:\n- Produk yang diminati (jika ada):\n\nTerima kasih.",
						'require_change'  => true,
						'variant'         => 'inline', // biar tidak “section look”
					)
				);
				?>
			</div>

		</div>
	</div>
</div>
