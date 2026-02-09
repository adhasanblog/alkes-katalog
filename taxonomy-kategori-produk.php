<?php
defined( 'ABSPATH' ) || exit;

get_header();

$queried_term = get_queried_object(); // kategori aktif
$page_title   = single_term_title( '', false );
$desc         = term_description( $queried_term );
?>

<main class="bg-slate-50">
	<div class="container-1280 section-y">

		<!-- Header page (judul mengikuti kategori) -->
		<header class="mb-6">
			<div class="mt-3 rounded-sm bg-white ring-1 ring-black/5 p-6">
				<h1 class="text-3xl font-bold tracking-tight text-slate-900">
					<?php echo esc_html( $page_title ); ?>
				</h1>

				<?php if ( ! empty( $desc ) ) : ?>
					<div class="mt-2 text-sm text-slate-600 max-w-3xl">
						<?php echo wp_kses_post( $desc ); ?>
					</div>
				<?php else : ?>
					<p class="mt-2 mb-4 text-sm text-slate-600 max-w-3xl">
						Jelajahi produk dalam kategori ini dan buka detail untuk spesifikasi lengkap.
					</p>
				<?php endif; ?>

				<?php get_template_part( 'template-parts/catalogue/breadcrumb' ); ?>
			</div>
		</header>

		<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
			<!-- Sidebar -->
			<aside class="lg:col-span-3">
				<?php get_template_part( 'template-parts/catalogue/sidebar' ); ?>
			</aside>

			<!-- Content -->
			<section class="lg:col-span-9">
				<!-- Filter khusus kategori (tanpa chips taxonomy) -->
				<?php get_template_part( 'template-parts/catalogue/filters' ); ?>

				<?php if ( have_posts() ) : ?>
					<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
						<?php
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/catalogue/product-card' );
						endwhile;
						?>
					</div>

					<div class="mt-8">
						<?php
						the_posts_pagination(
							array(
								'mid_size'  => 1,
								'prev_text' => '‹',
								'next_text' => '›',
							)
						);
						?>
					</div>
				<?php else : ?>
					<div class="rounded-2xl bg-white ring-1 ring-black/5 p-8 text-slate-600">
						Belum ada produk pada kategori ini.
					</div>
				<?php endif; ?>
			</section>
		</div>

	</div>
</main>

<?php get_footer(); ?>
