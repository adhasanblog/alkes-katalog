<?php get_header( 'home' ); ?>

	<main class="p-10">

		<?php

		$hero_products = alkes_get_hero_products( 5 );

		get_template_part(
			'template-parts/hero/hero',
			null,
			array(
				'products'    => $hero_products,
				'catalog_url' => home_url( '/produk/' ),
			)
		);

		?>

		<?php get_template_part( 'template-parts/hero/hero-mobile' ); ?>


		<?php

		get_template_part(
			'template-parts/home/categories',
			null,
			array( 'limit' => 8 )
		);


		?>

		<?php
		$featured = alkes_get_featured_products( 8 );

		get_template_part(
			'template-parts/home/featured-products',
			null,
			array( 'items' => $featured )
		);

		?>

		<?php get_template_part( 'template-parts/home/trust' ); ?>
		<?php get_template_part( 'template-parts/home/faq' ); ?>
		<?php get_template_part( 'template-parts/home/cta-wa' ); ?>

	</main>

<?php
get_footer();
