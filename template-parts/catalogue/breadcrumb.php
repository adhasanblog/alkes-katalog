<?php
defined( 'ABSPATH' ) || exit;

/**
 * Breadcrumb universal:
 * - Beranda
 * - Produk (jika konteks produk: archive/tax/single/search-produk)
 * - Tax chain (parent -> child) bila taxonomy kategori_produk
 * - Single produk: gunakan kategori terdalam -> lalu judul produk
 * - Search produk: label "Pencarian: xxx"
 * - Page: chain parent page -> judul page
 */

$items   = array();
$items[] = array(
	'label' => 'Beranda',
	'url'   => home_url( '/' ),
);

$current_id = (int) get_queried_object_id();

/**
 * Helper: ambil term terdalam.
 */
$get_deepest_term = function ( $terms, $taxonomy_slug ) {
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return null;
	}

	$best       = null;
	$best_depth = -1;

	foreach ( $terms as $t ) {
		$depth = count( get_ancestors( $t->term_id, $taxonomy_slug ) );
		if ( $depth > $best_depth ) {
			$best_depth = $depth;
			$best       = $t;
		}
	}

	return $best;
};

// ---- Context flags (mutually exclusive)
$is_produk_archive = is_post_type_archive( 'produk' );
$is_kategori_tax   = is_tax( 'kategori_produk' );
$is_single_produk  = is_singular( 'produk' );

$is_search        = is_search();
$is_search_produk = $is_search && ( 'produk' === get_query_var( 'post_type' ) );

// Page biasa (bukan front page, bukan single produk, bukan tax, bukan archive)
$is_page = is_page()
	&& ! is_front_page()
	&& ! $is_single_produk
	&& ! $is_kategori_tax
	&& ! $is_produk_archive
	&& ! $is_search_produk;

// ---- Branching (urut prioritas agar tidak tabrakan)

// 1) Single produk: Beranda / Produk / (Parent kategori) / (Child kategori) / Nama Produk
if ( $is_single_produk ) {
	$items[] = array(
		'label' => 'Produk',
		'url'   => get_post_type_archive_link( 'produk' ),
	);

	$terms   = get_the_terms( $current_id, 'kategori_produk' );
	$deepest = $get_deepest_term( $terms, 'kategori_produk' );

	if ( $deepest ) {
		$ancestors = array_reverse( get_ancestors( $deepest->term_id, 'kategori_produk' ) );

		foreach ( $ancestors as $aid ) {
			$ancestor_term = get_term( $aid, 'kategori_produk' );
			if ( $ancestor_term && ! is_wp_error( $ancestor_term ) ) {
				$items[] = array(
					'label' => $ancestor_term->name,
					'url'   => get_term_link( $ancestor_term ),
				);
			}
		}

		$items[] = array(
			'label' => $deepest->name,
			'url'   => get_term_link( $deepest ),
		);
	}

	$items[] = array(
		'label' => get_the_title( $current_id ),
		'url'   => '',
	);
} elseif ( $is_kategori_tax ) {
	// 2) Tax kategori produk: Beranda / Produk / Parent / Child
	$items[] = array(
		'label' => 'Produk',
		'url'   => get_post_type_archive_link( 'produk' ),
	);

	$queried_term = get_queried_object();

	if ( $queried_term && ! is_wp_error( $queried_term ) ) {
		$ancestors = array_reverse( get_ancestors( $queried_term->term_id, 'kategori_produk' ) );

		foreach ( $ancestors as $aid ) {
			$ancestor_term = get_term( $aid, 'kategori_produk' );
			if ( $ancestor_term && ! is_wp_error( $ancestor_term ) ) {
				$items[] = array(
					'label' => $ancestor_term->name,
					'url'   => get_term_link( $ancestor_term ),
				);
			}
		}

		$items[] = array(
			'label' => $queried_term->name,
			'url'   => '',
		);
	}
} elseif ( $is_search_produk ) {
	// 3) Search produk: Beranda / Produk / Pencarian: xxx
	$items[] = array(
		'label' => 'Produk',
		'url'   => get_post_type_archive_link( 'produk' ),
	);

	$items[] = array(
		'label' => 'Pencarian: ' . get_search_query(),
		'url'   => '',
	);
} elseif ( $is_produk_archive ) {
	// 4) Archive produk: Beranda / Produk
	$items[] = array(
		'label' => 'Produk',
		'url'   => '',
	);
} elseif ( $is_page ) {
	// 5) Page biasa: Beranda / Parent Page / Child Page
	$page_id   = $current_id;
	$ancestors = array_reverse( get_post_ancestors( $page_id ) );

	foreach ( $ancestors as $aid ) {
		$items[] = array(
			'label' => get_the_title( $aid ),
			'url'   => get_permalink( $aid ),
		);
	}

	$items[] = array(
		'label' => get_the_title( $page_id ),
		'url'   => '',
	);
} elseif ( is_singular() ) {
	// 6) Fallback umum: post biasa, category blog, dll
	$items[] = array(
		'label' => get_the_title( $current_id ),
		'url'   => '',
	);
}

$total_items = count( $items );
$last_index  = $total_items - 1;
?>

<nav class="text-sm text-gray-500" aria-label="Breadcrumb">
	<ol class="flex flex-wrap items-center gap-2 text-gray-600">
		<?php foreach ( $items as $i => $it ) : ?>
			<?php $is_last = ( $last_index === $i ); ?>
			<li class="flex items-center gap-2">
				<?php if ( ! empty( $it['url'] ) && ! $is_last ) : ?>
					<a class="hover:text-gray-900" href="<?php echo esc_url( $it['url'] ); ?>">
						<?php echo esc_html( $it['label'] ); ?>
					</a>
				<?php else : ?>
					<span class="text-gray-900 font-semibold"><?php echo esc_html( $it['label'] ); ?></span>
				<?php endif; ?>

				<?php if ( ! $is_last ) : ?>
					<span class="text-gray-400">/</span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
