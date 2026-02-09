<?php
defined( 'ABSPATH' ) || exit;

/**
 * Args:
 * - post_id (int) required
 * - class (string) optional
 * - label (string) optional
 * - target_blank (bool) optional default true
 */

$product_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : 0;
if ( ! $product_id ) {
	return;
}

$label = isset( $args['label'] ) ? (string) $args['label'] : 'Chat WhatsApp';
$class = isset( $args['class'] ) ? (string) $args['class'] : 'inline-flex items-center justify-center rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700 transition';
$blank = array_key_exists( 'target_blank', $args ) ? (bool) $args['target_blank'] : true;

$product_name = get_the_title( $product_id );
$product_url  = get_permalink( $product_id );

$phone   = function_exists( 'alkes_get_product_wa_number' ) ? alkes_get_product_wa_number( $product_id ) : '';
$message = function_exists( 'alkes_build_wa_message_product' ) ? alkes_build_wa_message_product( $product_name, $product_url ) : '';
$wa_url  = function_exists( 'alkes_build_wa_url' ) ? alkes_build_wa_url( $phone, $message ) : '#';
?>

<a
	href="<?php echo esc_url( $wa_url ); ?>"
	class="<?php echo esc_attr( $class ); ?>"
	<?php if ( $blank ) : ?>
		target="_blank" rel="noopener noreferrer"
	<?php endif; ?>
	aria-label="<?php echo esc_attr( 'Chat WhatsApp tentang ' . $product_name ); ?>"
>
	<?php echo esc_html( $label ); ?>
</a>
