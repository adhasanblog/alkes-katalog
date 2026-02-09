<?php
defined( 'ABSPATH' ) || exit;

$taxonomy_slug = 'kategori_produk';
$limit         = isset( $args['limit'] ) ? (int) $args['limit'] : 8;

$terms = get_terms(
	array(
		'taxonomy'   => $taxonomy_slug,
		'hide_empty' => true,
	)
);

if ( is_wp_error( $terms ) || empty( $terms ) ) {
	return;
}

// Filter hanya leaf terms (tidak punya child yang juga punya produk)
$leaf_terms = array_filter(
	$terms,
	function ( $t ) use ( $taxonomy_slug ) {
		$children = get_terms(
			array(
				'taxonomy'   => $taxonomy_slug,
				'hide_empty' => true,
				'parent'     => $t->term_id,
				'fields'     => 'ids',
			)
		);

		return empty( $children );
	}
);

// Urutkan berdasarkan jumlah produk (desc)
usort(
	$leaf_terms,
	function ( $a, $b ) {
		return (int) $b->count <=> (int) $a->count;
	}
);

$leaf_terms = array_slice( $leaf_terms, 0, $limit );
if ( empty( $leaf_terms ) ) {
	return;
}
?>

<section id="Category" class="scroll-mt-24 w-full section-y bg-white">
	<div class="container-1280">
		<div class="flex items-end justify-between gap-6">
			<div>
				<h2 class="text-2xl md:text-3xl font-bold tracking-tight">Kategori Produk</h2>
				<p class="mt-2 text-gray-600">
					Pilih kategori untuk melihat katalog dan konsultasi cepat via WhatsApp.
				</p>
			</div>

			<a
				href="<?php echo esc_url( home_url( '/produk/' ) ); ?>"
				class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-slate-900"
			>
				Lihat semua →
			</a>
		</div>

		<div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
			<?php foreach ( $leaf_terms as $cat_term ) : ?>
				<?php
				$url = get_term_link( $cat_term );
				if ( is_wp_error( $url ) ) {
					continue;
				}

				// ACF term image (set return = URL)
				$image = function_exists( 'get_field' ) ? get_field( 'category_image', $cat_term ) : '';
				$count = (int) $cat_term->count;
				?>
				<a
					href="<?php echo esc_url( $url ); ?>"
					class="group rounded-2xl bg-slate-50 ring-1 ring-black/5 hover:bg-white hover:shadow-sm transition overflow-hidden"
				>
					<div class="flex items-stretch">
						<!-- Thumbnail -->
						<div class="w-20 sm:w-24 bg-white">
							<?php if ( ! empty( $image ) ) : ?>
								<img
									src="<?php echo esc_url( $image ); ?>"
									alt="<?php echo esc_attr( $cat_term->name ); ?>"
									class="h-full w-full object-cover"
									loading="lazy"
									decoding="async"
								/>
							<?php else : ?>
								<div class="h-full w-full bg-gradient-to-br from-slate-200 to-slate-100"></div>
							<?php endif; ?>
						</div>

						<!-- Content -->
						<div class="flex-1 p-4">
							<div class="flex items-start justify-between gap-3">
								<div class="min-w-0">
									<div class="font-semibold text-gray-900 leading-snug line-clamp-2">
										<?php echo esc_html( $cat_term->name ); ?>
									</div>
									<div class="mt-1 text-xs text-gray-600">
										<?php echo esc_html( $count ); ?> produk
									</div>
								</div>

								<div class="shrink-0 flex items-center text-slate-400 transition group-hover:text-slate-900">
									<svg
										class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
										viewBox="0 0 24 24"
										fill="none"
										stroke="currentColor"
										stroke-width="2"
										stroke-linecap="round"
										stroke-linejoin="round"
										aria-hidden="true"
									>
										<path d="M5 12h14"></path>
										<path d="M13 5l7 7-7 7"></path>
									</svg>
								</div>

							</div>

							<?php if ( ! empty( $cat_term->description ) ) : ?>
								<div class="mt-2 text-sm text-gray-600 line-clamp-2">
									<?php echo esc_html( $cat_term->description ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</a>
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
