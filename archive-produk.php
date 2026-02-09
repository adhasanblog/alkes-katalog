<?php
defined( 'ABSPATH' ) || exit;

get_header();
?>

	<main class="container-1280 section-y">

		<section class="relative mb-8 rounded-sm bg-gradient-to-br from-slate-50 to-white ring-1 ring-black/5">
			<div class="container-1280 py-8 md:py-10">

				<h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">
					Katalog Produk
				</h1>

				<p class="mt-2 max-w-2xl text-sm text-gray-600">
					Jelajahi katalog alat kesehatan dan buka detail produk sesuai kebutuhan Anda.
				</p>

				<div class="mt-4">
					<?php get_template_part( 'template-parts/catalogue/breadcrumb' ); ?>
				</div>

			</div>
		</section>

		<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-12">

			<aside class="lg:col-span-3">
				<?php get_template_part( 'template-parts/catalogue/sidebar' ); ?>
			</aside>

			<section class="lg:col-span-9">

				<div class="mb-4">
					<?php get_template_part( 'template-parts/catalogue/filters' ); ?>
				</div>

				<?php if ( have_posts() ) : ?>

					<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/catalogue/product-card' );
						endwhile;
						?>
					</div>

					<?php
					global $wp_query;

					$pagination = paginate_links(
						array(
							'total'   => (int) $wp_query->max_num_pages,
							'current' => max( 1, (int) get_query_var( 'paged' ) ),
							'type'    => 'list',
						)
					);
					?>

					<?php if ( ! empty( $pagination ) ) : ?>
						<div class="mt-8">
							<?php echo wp_kses_post( $pagination ); ?>
						</div>
					<?php endif; ?>

				<?php else : ?>

					<div class="rounded-sm bg-white ring-1 ring-black/5 p-8 text-center">
						<div class="text-lg font-semibold text-gray-900">Produk tidak ditemukan</div>
						<p class="mt-2 text-sm text-gray-600">
							Coba ubah urutan atau reset filter.
						</p>
						<a
							href="<?php echo esc_url( get_post_type_archive_link( 'produk' ) ); ?>"
							class="mt-4 inline-flex items-center justify-center rounded-sm border border-black/10 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
						>
							Reset
						</a>
					</div>

				<?php endif; ?>

			</section>

		</div>
	</main>

<?php
get_footer();
