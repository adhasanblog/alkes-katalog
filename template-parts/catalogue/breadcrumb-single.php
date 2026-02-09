<?php
defined( 'ABSPATH' ) || exit;

$taxonomy_slug = 'kategori_produk';
$produk_id     = (int) get_the_ID();
$produk_title  = get_the_title( $produk_id );

// Ambil term produk (pilih yang terdalam)
$terms      = get_the_terms( $produk_id, $taxonomy_slug );
$best       = null;
$best_depth = -1;

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	foreach ( $terms as $t ) {
		$depth = count( get_ancestors( $t->term_id, $taxonomy_slug ) );
		if ( $depth > $best_depth ) {
			$best_depth = $depth;
			$best       = $t;
		}
	}
}

// Bangun chain: parent(s) -> child (term terdalam)
$chain = array();
if ( $best ) {
	$ancestors = array_reverse( get_ancestors( $best->term_id, $taxonomy_slug ) ); // dari root ke atas

	foreach ( $ancestors as $aid ) {
		$tax_term = get_term( $aid, $taxonomy_slug );
		if ( $tax_term && ! is_wp_error( $tax_term ) ) {
			$chain[] = $tax_term;
		}
	}

	$chain[] = $best; // child terakhir
}

$home_url    = home_url( '/' );
$archive_url = get_post_type_archive_link( 'produk' );
?>

<nav class="text-xs text-gray-500" aria-label="Breadcrumb">
	<ol class="flex flex-wrap items-center gap-y-1">
		<li class="flex items-center">
			<a class="hover:text-gray-700" href="<?php echo esc_url( $home_url ); ?>">Beranda</a>
			<span class="mx-2 text-gray-300">/</span>
		</li>

		<?php if ( $archive_url ) : ?>
			<li class="flex items-center">
				<a class="hover:text-gray-700" href="<?php echo esc_url( $archive_url ); ?>">Produk</a>
				<span class="mx-2 text-gray-300">/</span>
			</li>
		<?php endif; ?>

		<?php if ( ! empty( $chain ) ) : ?>
			<?php foreach ( $chain as $t ) : ?>
				<?php
				$term_url = get_term_link( $t );
				if ( is_wp_error( $term_url ) ) {
					continue;
				}
				?>
				<li class="flex items-center">
					<a class="hover:text-gray-700" href="<?php echo esc_url( $term_url ); ?>">
						<?php echo esc_html( $t->name ); ?>
					</a>
					<span class="mx-2 text-gray-300">/</span>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>

		<li class="text-gray-700 font-medium line-clamp-1">
			<?php echo esc_html( $produk_title ); ?>
		</li>
	</ol>
</nav>
