<?php
defined( 'ABSPATH' ) || exit;

$taxonomy_slug = 'kategori_produk';
$queried_term  = get_queried_object();

$home_url    = home_url( '/' );
$archive_url = get_post_type_archive_link( 'produk' );

$chain = array();

if ( $queried_term && ! is_wp_error( $queried_term ) && is_tax( $taxonomy_slug ) ) {
	$ancestors = array_reverse( get_ancestors( $queried_term->term_id, $taxonomy_slug ) );

	foreach ( $ancestors as $aid ) {
		$tax_term = get_term( $aid, $taxonomy_slug );
		if ( $tax_term && ! is_wp_error( $tax_term ) ) {
			$chain[] = $tax_term;
		}
	}

	$chain[] = $queried_term;
}

$chain_count = count( $chain );
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

		<?php foreach ( $chain as $i => $t ) : ?>
			<?php
			$url = get_term_link( $t );
			if ( is_wp_error( $url ) ) {
				continue;
			}

			$is_last = ( ( $chain_count - 1 ) === $i );
			?>

			<?php if ( $is_last ) : ?>
				<li class="text-gray-700 font-medium"><?php echo esc_html( $t->name ); ?></li>
			<?php else : ?>
				<li class="flex items-center">
					<a class="hover:text-gray-700" href="<?php echo esc_url( $url ); ?>">
						<?php echo esc_html( $t->name ); ?>
					</a>
					<span class="mx-2 text-gray-300">/</span>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ol>
</nav>
