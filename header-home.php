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
	<div class="w-full bg-slate-200/70 backdrop-blur-sm">
		<div class="container-1280">
			<div class="flex h-10 items-center justify-between">
				<div class="text-xs text-gray-600">
					Katalog Alkes • Konsultasi Cepat via WhatsApp
				</div>

				<nav class="hidden md:block" aria-label="Topbar navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'topbar',
							'container'      => false,
							'fallback_cb'    => false,
							'depth'          => 1,
							'menu_class'     => 'menu-topbar flex items-center gap-4 text-xs font-medium text-gray-600',
						)
					);
					?>
				</nav>
			</div>
		</div>
	</div>

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
							'theme_location' => 'home_primary',
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
					<a
						href="#cta-wa"
						class="hidden sm:inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition"
					>
						Konsultasi WhatsApp
					</a>

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

						<!-- Group: Pages -->
						<div class="px-2 pt-1 pb-2 text-xs font-semibold text-gray-500">
							Menu
						</div>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'topbar',
								'container'      => false,
								'fallback_cb'    => false,
								'depth'          => 1,
								'menu_class'     => 'menu-topbar-mobile flex flex-col',
							)
						);
						?>

						<div class="my-3 h-px bg-gray-100"></div>

						<!-- Group: Landing Sections -->
						<div class="px-2 pt-1 pb-2 text-xs font-semibold text-gray-500">
							Halaman Utama
						</div>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'home_primary',
								'container'      => false,
								'fallback_cb'    => false,
								'depth'          => 1,
								'menu_class'     => 'menu-home-primary-mobile flex flex-col',
							)
						);
						?>

						<div class="mt-4 px-2 pb-2">
							<a
								href="#cta-wa"
								class="inline-flex w-full items-center justify-center rounded-lg bg-green-600 px-4 py-3 text-white font-semibold hover:bg-green-700 transition"
							>
								Konsultasi WhatsApp
							</a>
							<div class="mt-2 text-center text-xs text-gray-500">
								Respon cepat jam kerja
							</div>
						</div>

					</div>
				</div>
			</div>


		</div>
	</div>
</header>
