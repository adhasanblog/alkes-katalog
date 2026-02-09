<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-white text-gray-900' ); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}
?>

<header class="w-full sticky top-0 z-50">

	<!-- Topbar (utility) -->


	<!-- Main nav -->
	<div class="w-full bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/80 shadow-sm">
		<div class="container-1280">
			<div class="flex h-16 items-center justify-between">

				<!-- Brand -->
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3">
					<div class="h-9 w-9 rounded bg-gray-900"></div>
					<div class="leading-tight">
						<div class="font-bold">Sejahtera Alkes</div>
						<div class="text-xs text-gray-500">Katalog & Konsultasi WhatsApp</div>
					</div>
				</a>

				<!-- Homepage Menu (anchors) - desktop -->
				<nav class="hidden md:block" aria-label="Homepage navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'fallback_cb'    => false,
							'depth'          => 1,
							'menu_class'     => 'menu-home-primary flex items-center gap-6 text-sm font-medium text-gray-700',
						)
					);
					?>
				</nav>

				<!-- Actions -->
				<div class="flex items-center gap-3">
					<?php get_template_part( 'template-parts/header/searchbar' ); ?>

					<button
						type="button"
						class="inline-flex md:hidden items-center justify-center rounded-lg border border-gray-200 p-2.5 text-gray-700 hover:bg-gray-50"
						data-mobile-menu-btn
						aria-label="Open menu"
						aria-expanded="false"
					>
						<span class="sr-only">Open menu</span>
						<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
						</svg>
					</button>
				</div>
			</div>

			<!-- Mobile Menu -->
			<!-- Mobile Menu -->
			<div class="md:hidden hidden" data-mobile-menu>
				<div class="mt-3 rounded-xl bg-white shadow-lg ring-1 ring-black/5 overflow-hidden">
					<div class="p-3">
						<div class="px-2 pt-1 pb-2 text-xs font-semibold text-gray-500">
							Menu
						</div>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
								'fallback_cb'    => false,
								'depth'          => 1,
								'menu_class'     => 'menu-home-primary-mobile flex flex-col',
							)
						);
						?>

						<div class="mt-4 px-2 pb-2">
							<?php get_template_part( 'template-parts/header/searchbar' ); ?>
						</div>

					</div>
				</div>
			</div>


		</div>
	</div>
</header>
