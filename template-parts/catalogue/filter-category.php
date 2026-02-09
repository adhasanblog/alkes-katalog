<?php
defined( 'ABSPATH' ) || exit;

// Context URL (untuk Reset)
$is_tax_context = is_tax( 'kategori_produk' );
$current_term   = null;

if ( $is_tax_context ) {
	$current_term = get_queried_object();
}

$base_url = get_post_type_archive_link( 'produk' );
if ( $is_tax_context && $current_term && ! is_wp_error( $current_term ) ) {
	$base_url = get_term_link( $current_term );
}

// Sort param: ambil dari query vars (bukan $_GET)
global $wp_query;

$current_sort = 'newest';
if ( isset( $wp_query->query_vars['sort'] ) ) {
	$current_sort = sanitize_text_field( (string) $wp_query->query_vars['sort'] );
}

// Kalau sort tidak ada di query_vars, coba dari query string yang sudah diparsing WP
if ( 'newest' === $current_sort ) {
	$maybe_sort = get_query_var( 'sort' );
	if ( is_string( $maybe_sort ) && ( '' !== $maybe_sort ) ) {
		$current_sort = sanitize_text_field( $maybe_sort );
	}
}

// Sort options (sinkron dengan archive-produk.php)
$sort_options = array(
	'newest'     => 'Terbaru',
	'price_asc'  => 'Harga: Terendah ke Tertinggi',
	'price_desc' => 'Harga: Tertinggi ke Terendah',
	'title_asc'  => 'Nama: A - Z',
	'title_desc' => 'Nama: Z - A',
);

// Count dari query utama
$shown = isset( $wp_query->post_count ) ? (int) $wp_query->post_count : 0;
$total = isset( $wp_query->found_posts ) ? (int) $wp_query->found_posts : 0;

// Pagination info (lebih akurat)
$page_num = (int) get_query_var( 'paged' );
if ( $page_num < 1 ) {
	$page_num = 1;
}

// posts_per_page: ambil dari query utama -> option WP -> fallback 12
$posts_per_page = 0;

if ( isset( $wp_query->query_vars['posts_per_page'] ) && ! empty( $wp_query->query_vars['posts_per_page'] ) ) {
	$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
}

if ( $posts_per_page <= 0 ) {
	$posts_per_page = (int) get_option( 'posts_per_page' );
}

if ( $posts_per_page <= 0 ) {
	$posts_per_page = 12;
}

$start = ( $total > 0 ) ? ( ( ( $page_num - 1 ) * $posts_per_page ) + 1 ) : 0;
$end   = ( $total > 0 ) ? min( $page_num * $posts_per_page, $total ) : 0;

// Preserve query params lain saat submit sort (misal search "s")
// Ambil dari query var WP (bukan $_GET)
$preserved = array();

$search_query = get_search_query( false );
if ( is_string( $search_query ) && ( '' !== $search_query ) ) {
	$preserved['s'] = $search_query;
}
?>

<div class="w-full mb-4">
	<div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">

		<!-- Left: results meta -->
		<div class="flex flex-col gap-1">
			<div class="text-sm font-semibold text-slate-900">
				Urutkan & Tampilkan
			</div>
			<div class="text-xs text-slate-400">
				<?php if ( $total > 0 ) : ?>
					Menampilkan <?php echo esc_html( $start ); ?>–<?php echo esc_html( $end ); ?> dari <?php echo esc_html( $total ); ?> produk
				<?php else : ?>
					Tidak ada produk untuk ditampilkan
				<?php endif; ?>
			</div>
		</div>

		<!-- Right: sort + reset -->
		<div class="flex items-center gap-3 border-t md:border-t-0 border-slate-100 pt-4 md:pt-0">
			<label for="sort" class="text-sm font-medium text-slate-500 whitespace-nowrap">
				Urutkan:
			</label>

			<form method="get" action="<?php echo esc_url( $base_url ); ?>">
				<?php foreach ( $preserved as $k => $v ) : ?>
					<input type="hidden" name="<?php echo esc_attr( $k ); ?>" value="<?php echo esc_attr( $v ); ?>">
				<?php endforeach; ?>

				<div class="relative">
					<select
						id="sort"
						name="sort"
						class="appearance-none bg-slate-50 border border-slate-200 text-slate-700 text-sm font-medium py-2.5 pl-4 pr-10 rounded-xl
						focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-400 cursor-pointer transition-shadow shadow-sm hover:shadow-md"
						onchange="this.form.submit()"
					>
						<?php foreach ( $sort_options as $key => $label ) : ?>
							<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $current_sort, $key ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>

					<div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
						</svg>
					</div>
				</div>
			</form>

			<a
				href="<?php echo esc_url( $base_url ); ?>"
				class="px-4 py-2 bg-white text-slate-700 border border-slate-200 text-sm font-medium rounded-xl hover:bg-slate-50 transition-colors whitespace-nowrap"
			>
				Reset
			</a>
		</div>

	</div>
</div>
