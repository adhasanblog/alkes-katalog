<?php
defined( 'ABSPATH' ) || exit;
get_header();

while ( have_posts() ) :
	the_post();
	$page_title = get_the_title();
	?>

	<main class="section-y">
		<!-- Page Header -->
		<section class="mb-8 bg-slate-50 ring-1 ring-black/5">
			<div class="container-1280 py-8 md:py-10">
				<div class="flex flex-col gap-4">

					<h1 class="text-2xl md:text-3xl font-bold tracking-tight text-slate-900">
						<?php echo esc_html( $page_title ); ?>
					</h1>

					<?php get_template_part( 'template-parts/catalogue/breadcrumb' ); ?>

					<!-- optional: deskripsi page dari excerpt, tapi jangan tampil kalau kosong -->
					<?php if ( has_excerpt() ) : ?>
						<p class="max-w-3xl text-base text-slate-600">
							<?php echo esc_html( get_the_excerpt() ); ?>
						</p>
					<?php endif; ?>

				</div>
			</div>
		</section>

		<!-- Content -->
		<section>
			<div class="container-1280">
				<article class="bg-white ring-1 ring-black/5 p-6 md:p-8">
					<div class="prose prose-slate max-w-none prose-p:text-base prose-li:text-base no-underline prose-headings:m-0">
						<?php the_content(); ?>
					</div>
				</article>
			</div>
		</section>
	</main>

<?php endwhile; ?>

<?php get_footer(); ?>
