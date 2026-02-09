<?php
defined( 'ABSPATH' ) || exit;

$taxonomy_slug = 'kategori_produk';

/**
 * 1) Tentukan active term:
 * - taxonomy page → queried term
 * - single produk → term terdalam dari produk
 */
$active_id = 0;

if ( is_tax( $taxonomy_slug ) ) {
	$queried_term = get_queried_object();
	if ( $queried_term && ! is_wp_error( $queried_term ) ) {
		$active_id = (int) $queried_term->term_id;
	}
}

if ( ( 0 === $active_id ) && is_singular( 'produk' ) ) {
	$produk_id = (int) get_the_ID();
	$terms     = get_the_terms( $produk_id, $taxonomy_slug );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		$deepest   = null;
		$depth_max = -1;

		foreach ( $terms as $t ) {
			$depth = count( get_ancestors( $t->term_id, $taxonomy_slug ) );
			if ( $depth > $depth_max ) {
				$depth_max = $depth;
				$deepest   = $t;
			}
		}

		if ( null !== $deepest ) {
			$active_id = (int) $deepest->term_id;
		}
	}
}

/**
 * 2) Ambil semua kategori yang punya produk
 */
$all_terms = get_terms(
	array(
		'taxonomy'   => $taxonomy_slug,
		'hide_empty' => true,
	)
);

if ( empty( $all_terms ) || is_wp_error( $all_terms ) ) {
	return;
}

/**
 * 3) Map parent → children
 */
$parents  = array();
$children = array();

foreach ( $all_terms as $t ) {
	if ( 0 === (int) $t->parent ) {
		$parents[ (int) $t->term_id ] = $t;
	} else {
		$children[ (int) $t->parent ][] = $t;
	}
}



if ( ! function_exists( 'alkes_should_open_parent' ) ) {
	/**
	 * Determine whether a parent term panel should be expanded.
	 *
	 * Opens when the parent itself is active, or when it is an ancestor of the active term.
	 *
	 * @param int    $parent_id     Parent term ID.
	 * @param string $taxonomy_slug Taxonomy slug.
	 * @param int    $active_id     Active term ID.
	 * @return bool
	 */
	function alkes_should_open_parent( int $parent_id, string $taxonomy_slug, int $active_id ): bool {
		if ( 0 === $active_id ) {
			return false;
		}

		if ( $parent_id === $active_id ) {
			return true;
		}

		$ancestors = get_ancestors( $active_id, $taxonomy_slug );
		return in_array( $parent_id, array_map( 'intval', $ancestors ), true );
	}
}

?>

<aside class="rounded-sm bg-white ring-1 ring-black/5">

	<!-- Header -->
	<div class="px-4 py-4 border-b border-slate-100">
		<div class="text-sm font-semibold text-slate-900">Kategori Produk</div>
		<div class="mt-1 text-xs text-slate-400">
			Telusuri produk berdasarkan kategori.
		</div>
	</div>

	<!-- Navigation -->
	<nav class="p-2">
		<?php foreach ( $parents as $pid => $parent ) : ?>
			<?php
			$has_children = ! empty( $children[ $pid ] );

			$open = false;
			if ( $has_children ) {
				$open = alkes_should_open_parent( $pid, $taxonomy_slug, $active_id );
			}

			$parent_url = get_term_link( $parent );
			if ( is_wp_error( $parent_url ) ) {
				$parent_url = '#';
			}

			$parent_active = ( (int) $active_id === (int) $parent->term_id );

			$row_class = 'text-slate-700 hover:bg-slate-50 hover:text-slate-900';
			if ( $parent_active ) {
				$row_class = 'bg-slate-900 text-white';
			}

			$toggle_hover_class = 'hover:bg-slate-100';
			if ( $parent_active ) {
				$toggle_hover_class = 'hover:bg-white/10';
			}

			$expanded_attr = 'false';
			if ( $open ) {
				$expanded_attr = 'true';
			}

			$panel_class = 'hidden';
			if ( $open ) {
				$panel_class = '';
			}

			$icon_class = '';
			if ( $open ) {
				$icon_class = 'rotate-180';
			}
			?>

			<div class="mb-1">

				<!-- Parent Row -->
				<div class="flex items-center justify-between gap-2 px-3 py-2.5 rounded-xl transition-colors <?php echo esc_attr( $row_class ); ?>">

					<!-- Parent Link -->
					<a
						href="<?php echo esc_url( $parent_url ); ?>"
						class="flex-1 min-w-0 text-sm font-semibold truncate"
						title="<?php echo esc_attr( $parent->name ); ?>"
					>
						<?php echo esc_html( $parent->name ); ?>
					</a>

					<?php if ( $has_children ) : ?>
						<!-- Toggle -->
						<button
							type="button"
							class="inline-flex h-8 w-8 items-center justify-center rounded-lg <?php echo esc_attr( $toggle_hover_class ); ?>"
							data-cat-toggle
							aria-expanded="<?php echo esc_attr( $expanded_attr ); ?>"
							aria-controls="cat-<?php echo esc_attr( $pid ); ?>"
							aria-label="Toggle kategori <?php echo esc_attr( $parent->name ); ?>"
						>
							<svg
								class="h-4 w-4 transition-transform duration-200 <?php echo esc_attr( $icon_class ); ?>"
								viewBox="0 0 24 24"
								fill="none"
								stroke="currentColor"
							>
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
							</svg>
						</button>
					<?php endif; ?>

				</div>

				<!-- Children -->
				<?php if ( $has_children ) : ?>
					<div
						id="cat-<?php echo esc_attr( $pid ); ?>"
						class="mt-1 space-y-1 pl-2 pr-1 <?php echo esc_attr( $panel_class ); ?>"
						data-cat-panel
					>
						<?php foreach ( $children[ $pid ] as $child ) : ?>
							<?php
							$child_url = get_term_link( $child );
							if ( is_wp_error( $child_url ) ) {
								$child_url = '#';
							}

							$child_active = ( (int) $active_id === (int) $child->term_id );

							$child_class = 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 border-l-transparent';
							if ( $child_active ) {
								$child_class = 'bg-slate-50 text-slate-900 border-l-slate-900';
							}
							?>
							<a
								href="<?php echo esc_url( $child_url ); ?>"
								class="block px-3 py-2 text-sm rounded-xl border-l-2 <?php echo esc_attr( $child_class ); ?>"
							>
								<?php echo esc_html( $child->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</div>
		<?php endforeach; ?>
	</nav>
</aside>
