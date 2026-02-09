<?php
defined( 'ABSPATH' ) || exit;
?>

<section id="trust" class="scroll-mt-24 w-full section-y bg-white">
	<div class="container-1280">
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">

			<div>
				<h2 class="text-2xl md:text-3xl font-bold tracking-tight">Legalitas & Kepercayaan</h2>
				<p class="mt-2 text-gray-600">
					Kami fokus pada transparansi: dokumen, garansi, dan alur pembelian yang jelas melalui WhatsApp.
				</p>

				<div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
					<div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4">
						<div class="text-sm font-semibold text-gray-900">Produk terverifikasi</div>
						<div class="mt-1 text-sm text-gray-600">
							Setiap produk memiliki informasi izin edar/sertifikasi sesuai kategori.
						</div>
					</div>

					<div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4">
						<div class="text-sm font-semibold text-gray-900">Garansi & after-sales</div>
						<div class="mt-1 text-sm text-gray-600">
							Dukungan instalasi, penggunaan, dan ketersediaan sparepart (jika berlaku).
						</div>
					</div>

					<div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4">
						<div class="text-sm font-semibold text-gray-900">Pengiriman aman</div>
						<div class="mt-1 text-sm text-gray-600">
							Packing aman untuk alat medis dan pengiriman ke seluruh Indonesia.
						</div>
					</div>

					<div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-4">
						<div class="text-sm font-semibold text-gray-900">Konsultasi kebutuhan</div>
						<div class="mt-1 text-sm text-gray-600">
							Rekomendasi disesuaikan dengan kebutuhan fasilitas, anggaran, dan SOP.
						</div>
					</div>
				</div>

				<div class="mt-8 flex flex-col sm:flex-row gap-3">
					<a
						href="#cta-wa"
						class="inline-flex items-center justify-center rounded-xl bg-green-600 px-6 py-3 text-white font-semibold hover:bg-green-700 transition"
					>
						Konsultasi WhatsApp
					</a>
					<a
						href="<?php echo esc_url( home_url( '/tentang-kami/' ) ); ?>"
						class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-6 py-3 font-semibold text-gray-900 hover:bg-gray-50 transition"
					>
						Tentang Perusahaan
					</a>
				</div>
			</div>

			<!-- Right: proof (packing / shipment / docs by WA) -->
			<div class="rounded-2xl bg-slate-50 ring-1 ring-black/5 p-6">
				<div class="text-sm font-semibold text-gray-900">Bukti Pengiriman & Dokumentasi</div>
				<p class="mt-2 text-sm text-gray-600">
					Dokumentasi proses (packing, pengiriman, dan serah terima). Dokumen legalitas resmi dapat dikirim
					via WhatsApp saat dibutuhkan.
				</p>

				<div class="mt-5 grid grid-cols-2 gap-3">
					<!-- Dummy images: ganti nanti -->
					<figure class="overflow-hidden rounded-xl bg-white ring-1 ring-black/5">
						<img
							src="https://images.unsplash.com/photo-1600490036275-35f5f1656861?auto=format&fit=crop&w=900&q=80"
							alt="Packing aman untuk pengiriman"
							class="h-32 w-full object-cover"
							loading="lazy"
							decoding="async"
						/>
						<figcaption class="px-3 py-2 text-xs text-gray-600">Packing aman & rapi</figcaption>
					</figure>

					<figure class="overflow-hidden rounded-xl bg-white ring-1 ring-black/5">
						<img
							src="https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?auto=format&fit=crop&w=900&q=80"
							alt="Pengiriman barang"
							class="h-32 w-full object-cover"
							loading="lazy"
							decoding="async"
						/>
						<figcaption class="px-3 py-2 text-xs text-gray-600">Pengiriman terjadwal</figcaption>
					</figure>

					<figure class="overflow-hidden rounded-xl bg-white ring-1 ring-black/5">
						<img
							src="https://images.unsplash.com/photo-1580674285054-bed31e145f59?auto=format&fit=crop&w=900&q=80"
							alt="Pengecekan produk sebelum kirim"
							class="h-32 w-full object-cover"
							loading="lazy"
							decoding="async"
						/>
						<figcaption class="px-3 py-2 text-xs text-gray-600">QC sebelum kirim</figcaption>
					</figure>

					<figure class="overflow-hidden rounded-xl bg-white ring-1 ring-black/5">
						<img
							src="https://images.unsplash.com/photo-1566576721346-d4a3b4eaeb55?auto=format&fit=crop&w=900&q=80"
							alt="Dokumentasi serah terima"
							class="h-32 w-full object-cover"
							loading="lazy"
							decoding="async"
						/>
						<figcaption class="px-3 py-2 text-xs text-gray-600">Dokumentasi serah terima</figcaption>
					</figure>
				</div>

				<div class="mt-6 rounded-xl bg-white/70 ring-1 ring-black/5 p-4">
					<div class="text-xs font-semibold text-gray-600">Catatan</div>
					<div class="mt-1 text-sm text-gray-700">
						Untuk verifikasi izin edar/sertifikasi, tim kami dapat mengirim dokumen resmi via WhatsApp
						sesuai model/varian yang dipilih.
					</div>
				</div>
			</div>


		</div>
	</div>
</section>
