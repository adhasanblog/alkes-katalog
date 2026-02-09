<?php defined( 'ABSPATH' ) || exit; ?>
<?php $archive_url = get_post_type_archive_link( 'produk' ); ?>

<form
	class="relative w-full max-w-sm lg:max-w-md"
	data-nav-search
	data-nav-search-form
	action="<?php echo esc_url( $archive_url ); ?>"
	method="get"
>
	<div class="relative">
		<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
				stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
			</svg>
		</div>


		<input
			type="text"
			name="s"
			data-search-input
			placeholder="Cari produk alkes..."
			class="w-full h-10 pl-10 pr-10 bg-slate-50 border border-slate-200 rounded-sm text-sm text-slate-700 placeholder-slate-400
			shadow-sm focus:outline-none focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition"
			autocomplete="off"
		/>

		<input type="hidden" name="post_type" value="produk">

		<div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-2">
			<div data-search-spinner class="hidden animate-spin h-5 w-5 text-slate-400">
				<svg fill="none" viewBox="0 0 24 24">
					<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
				</svg>
			</div>

			<button type="button" data-search-clear class="hidden text-slate-400 hover:text-slate-600"
					aria-label="Clear">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
					<path fill-rule="evenodd"
							d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
							clip-rule="evenodd"/>
				</svg>
			</button>
		</div>
	</div>

	<div data-search-results
		class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-sm shadow-xl border border-slate-100 overflow-hidden z-[9999]">
		<div class="py-2">
			<p class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Produk</p>
			<div data-search-items></div>
		</div>

		<a data-search-all
			href="<?php echo esc_url( $archive_url ); ?>"
			target="_blank" rel="noopener"
			class="hidden block bg-slate-50 px-4 py-3 text-center text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors border-t border-slate-100"
		>
			Lihat semua hasil
		</a>
	</div>

	<div data-search-empty
		class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-sm shadow-xl border border-slate-100 p-6 text-center z-[9999]">
		<p class="text-slate-800 font-medium">Produk tidak ditemukan</p>
		<p class="text-sm text-slate-400 mt-1">Coba kata kunci lain.</p>
	</div>
</form>
