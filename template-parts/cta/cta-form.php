<?php
defined( 'ABSPATH' ) || exit;

/**
 * Args:
 * - title (string)
 * - desc (string)
 * - default_message (string)
 * - wa_number (string)  // optional, fallback ke default
 * - require_change (bool) // true = tombol disabled sampai user edit
 * - variant (string) // 'section' | 'sidebar' (opsional untuk styling kecil)
 */

$wa_number = '6289692665509';
if ( isset( $args['wa_number'] ) && is_string( $args['wa_number'] ) && ( '' !== $args['wa_number'] ) ) {
	$wa_number = $args['wa_number'];
}

$cta_title = 'Chat WhatsApp';
if ( isset( $args['title'] ) && is_string( $args['title'] ) && ( '' !== $args['title'] ) ) {
	$cta_title = $args['title'];
}

$cta_desc = 'Tanya stok, harga, dan estimasi pengiriman.';
if ( isset( $args['desc'] ) && is_string( $args['desc'] ) && ( '' !== $args['desc'] ) ) {
	$cta_desc = $args['desc'];
}

$default_message = "Halo, saya ingin bertanya.\n\nKeperluan:\n- Nama/Instansi:\n- Lokasi:\n- Kebutuhan singkat:\n\nTerima kasih.";
if ( isset( $args['default_message'] ) && is_string( $args['default_message'] ) && ( '' !== $args['default_message'] ) ) {
	$default_message = $args['default_message'];
}

$require_change = false;
if ( ! empty( $args['require_change'] ) ) {
	$require_change = true;
}

$variant = 'section';
if ( isset( $args['variant'] ) && is_string( $args['variant'] ) && ( '' !== $args['variant'] ) ) {
	$variant = $args['variant'];
}

$box_class = 'rounded-sm bg-white ring-1 ring-black/5 p-5 md:p-6';
if ( 'sidebar' === $variant ) {
	$box_class = 'rounded-sm bg-white ring-1 ring-black/5 p-4';
}
?>

<section
	class="<?php echo esc_attr( $box_class ); ?>"
	data-wa-box
	data-wa-number="<?php echo esc_attr( $wa_number ); ?>"
	data-wa-require-change="<?php echo $require_change ? '1' : '0'; ?>"
>
	<?php if ( ( '' !== $cta_title ) || ( '' !== $cta_desc ) ) : ?>
		<div class="mb-3">
			<?php if ( '' !== $cta_title ) : ?>
				<div class="text-base font-semibold text-slate-900">
					<?php echo esc_html( $cta_title ); ?>
				</div>
			<?php endif; ?>

			<?php if ( '' !== $cta_desc ) : ?>
				<p class="mt-1 text-sm text-slate-600">
					<?php echo esc_html( $cta_desc ); ?>
				</p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<textarea
		class="w-full min-h-[140px] rounded-sm border border-slate-200 p-3 text-base text-slate-900 focus:outline-none focus:ring-2 focus:ring-green-500"
		data-wa-message
	><?php echo esc_textarea( $default_message ); ?></textarea>

	<a
		href="#cta-action"
		target="_blank"
		rel="noopener noreferrer"
		class="mt-3 inline-flex w-full no-underline items-center justify-center rounded-sm bg-green-600 px-4 py-3 text-white text-base font-semibold hover:bg-green-700 transition"
		data-wa-send
	>
		Kirim via WhatsApp
	</a>

	<div class="mt-2 text-sm text-slate-500" data-wa-status></div>
</section>
