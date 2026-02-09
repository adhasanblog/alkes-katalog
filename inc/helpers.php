<?php
/**
 * Theme helper functions.
 *
 * @package Alkes_Katalog
 */

defined( 'ABSPATH' ) || exit;


if ( ! function_exists( 'alkes_format_idr' ) ) {
	/**
	 * Format number as Indonesian Rupiah string.
	 *
	 * @param float|int|string $n Amount to format.
	 * @return string Formatted number for IDR (e.g. "1.000.000").
	 */
	function alkes_format_idr( $n ): string {
		return number_format( (float) $n, 0, ',', '.' );
	}
}

if ( ! function_exists( 'alkes_price_text' ) ) {
	/**
	 * Build a human-readable price label.
	 *
	 * Expected modes: contact, from, exact, quote.
	 *
	 * @param string    $display Display mode.
	 * @param float|int $exact   Exact price.
	 * @param float|int $from    Starting price.
	 * @return string Price label text.
	 */
	function alkes_price_text( $display, $exact, $from ): string {
		$display = strtolower( trim( (string) $display ) );
		$exact   = (float) $exact;
		$from    = (float) $from;

		if ( ( 'exact' === $display ) && ( $exact > 0 ) ) {
			return 'Rp ' . alkes_format_idr( $exact );
		}

		if ( ( 'from' === $display ) && ( $from > 0 ) ) {
			return 'Mulai Rp ' . alkes_format_idr( $from );
		}

		if ( 'quote' === $display ) {
			return 'Quotation (B2B)';
		}

		return 'Hubungi untuk harga';
	}
}


/**
 * Parse specification text into key/value lines.
 *
 * Input commonly uses newline-delimited "Key: Value" pairs.
 *
 * @param string $raw Raw specification text.
 * @return array<int, array{0:string,1:string}> Parsed pairs as [key, value].
 */
function alkes_parse_spec_lines( $raw ): array {
	$raw   = str_replace( array( "\r\n", "\r" ), "\n", (string) $raw );
	$lines = array_filter( array_map( 'trim', explode( "\n", $raw ) ) );
	$rows  = array();

	foreach ( $lines as $line ) {
		// split pertama kali ":" agar value boleh punya ":" lagi
		$pos = strpos( $line, ':' );
		if ( false === $pos ) {
			continue;
		}

		$k = trim( substr( $line, 0, $pos ) );
		$v = trim( substr( $line, $pos + 1 ) );

		if ( ( '' === $k ) || ( '' === $v ) ) {
			continue;
		}

		$rows[] = array( $k, $v );
	}

	return $rows;
}

/**
 * Get default WhatsApp phone number for CTA.
 *
 * @return string Phone number (digits only recommended).
 */
function alkes_get_default_wa_number(): string {
	// nanti bisa diganti customizer. untuk sekarang hardcode / option
	$num = get_option( 'alkes_wa_default', '6289692665509' );
	return preg_replace( '/\D+/', '', (string) $num );
}


/**
 * Get WhatsApp phone number for a given product.
 * Falls back to default WA number when product-specific number is missing.
 *
 * @param int $post_id Product post ID.
 * @return string Phone number.
 */
function alkes_get_product_wa_number( int $post_id ): string {
	// jika kamu punya ACF field: wa_number (text)
	$custom = '';

	if ( function_exists( 'get_field' ) ) {
		$custom = (string) get_field( 'wa_number', $post_id );
	}

	$custom = preg_replace( '/\D+/', '', (string) $custom );

	if ( '' !== $custom ) {
		return $custom;
	}

	return alkes_get_default_wa_number();
}

/**
 * Build WhatsApp message text for a product inquiry.
 *
 * @param string $product_name Product title/name.
 * @param string $product_url  Product URL.
 * @return string Message text (not URL-encoded).
 */
function alkes_build_wa_message_product( string $product_name, string $product_url ): string {
	return implode(
		"\n",
		array(
			'Halo, saya ingin tanya produk berikut:',
			'',
			'Produk: ' . $product_name,
			'Link: ' . $product_url,
			'',
			'Mohon info harga, stok, dan estimasi pengiriman. Terima kasih.',
		)
	);
}

/**
 * Build wa.me URL with encoded message.
 *
 * @param string $phone   Phone number (any format; will be normalized to digits).
 * @param string $message Message text (will be rawurlencoded).
 * @return string WhatsApp wa.me URL.
 */
function alkes_build_wa_url( string $phone, string $message ): string {
	$phone = preg_replace( '/\D+/', '', $phone );
	$text  = rawurlencode( $message );

	return "https://wa.me/{$phone}?text={$text}";
}

/**
 * Determine ACF plugin status used by theme checks.
 *
 * Common return values: 'active', 'inactive', 'missing'.
 *
 * @return string Status string.
 */
function alkes_get_acf_status(): string {
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		return 'active';
	}

	include_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( file_exists( WP_PLUGIN_DIR . '/advanced-custom-fields/acf.php' ) ) {
		return 'installed';
	}

	return 'missing';
}
