<?php
defined( 'ABSPATH' ) || exit;

$alkes_post_id = get_the_ID();

// Featured image wajib jadi default main.
$featured_id    = get_post_thumbnail_id( $alkes_post_id );
$featured_full  = '';
$featured_thumb = '';
$featured_alt   = '';

if ( $featured_id ) {
	$featured_full  = (string) wp_get_attachment_image_url( $featured_id, 'large' );
	$featured_thumb = (string) wp_get_attachment_image_url( $featured_id, 'thumbnail' );
	$featured_alt   = (string) get_post_meta( $featured_id, '_wp_attachment_image_alt', true );
}

if ( '' === $featured_alt ) {
	$featured_alt = get_the_title( $alkes_post_id );
}

// Kumpulkan items: featured + ACF images.
$items = array();

if ( $featured_id && '' !== $featured_full ) {
	$thumb_url = $featured_thumb;
	if ( '' === $thumb_url ) {
		$thumb_url = $featured_full;
	}

	$items[] = array(
		'id'    => (int) $featured_id,
		'full'  => $featured_full,
		'thumb' => $thumb_url,
		'alt'   => $featured_alt,
	);
}

// ACF Free: image_1..image_6.
$media = array();
if ( function_exists( 'get_field' ) ) {
	$media = (array) get_field( 'media', $alkes_post_id );
}

$keys = array( 'image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6' );

foreach ( $keys as $k ) {
	if ( empty( $media[ $k ] ) || ! is_array( $media[ $k ] ) ) {
		continue;
	}

	$img      = $media[ $k ];
	$image_id = isset( $img['ID'] ) ? (int) $img['ID'] : 0;

	// Skip jika sama dengan featured.
	if ( $image_id && $featured_id && (int) $featured_id === $image_id ) {
		continue;
	}

	$full  = '';
	$thumb = '';

	if ( ! empty( $img['sizes']['large'] ) ) {
		$full = (string) $img['sizes']['large'];
	} elseif ( ! empty( $img['url'] ) ) {
		$full = (string) $img['url'];
	}

	if ( ! empty( $img['sizes']['thumbnail'] ) ) {
		$thumb = (string) $img['sizes']['thumbnail'];
	} elseif ( ! empty( $img['url'] ) ) {
		$thumb = (string) $img['url'];
	}

	if ( '' === $full ) {
		continue;
	}

	if ( '' === $thumb ) {
		$thumb = $full;
	}

	$alt = '';
	if ( ! empty( $img['alt'] ) ) {
		$alt = trim( (string) $img['alt'] );
	}
	if ( '' === $alt ) {
		$alt = get_the_title( $alkes_post_id );
	}

	$items[] = array(
		'id'    => $image_id,
		'full'  => $full,
		'thumb' => $thumb,
		'alt'   => $alt,
	);
}

if ( empty( $items ) ) {
	return;
}

$initial = $items[0];

// Lightbox JSON: hanya butuh list URL full.
$images_full = array();

foreach ( $items as $it ) {
	if ( ! empty( $it['full'] ) ) {
		$images_full[] = (string) $it['full'];
	}
}
$images_full = array_values( array_filter( $images_full ) );
?>

<div class="rounded-2xl bg-white ring-1 ring-black/5 p-4" data-gallery>
	<button
		type="button"
		class="relative block w-full overflow-hidden rounded-xl bg-slate-50 focus:outline-none"
		data-gallery-open
		aria-label="Preview gambar"
	>
		<img
			src="<?php echo esc_url( $initial['full'] ); ?>"
			alt="<?php echo esc_attr( $initial['alt'] ); ?>"
			class="w-full aspect-square object-contain"
			loading="eager"
			data-gallery-main
		/>
	</button>

	<?php if ( 1 < count( $items ) ) : ?>
		<div class="mt-3 flex gap-2 overflow-x-auto p-1 no-scrollbar" data-gallery-thumbs>
			<?php foreach ( $items as $i => $it ) : ?>
				<?php
				$active    = ( 0 === (int) $i ); // Yoda.
				$btn_class = 'ring-1 ring-black/10 hover:ring-black/20';
				if ( $active ) {
					$btn_class = 'ring-2 ring-slate-900';
				}
				?>
				<button
					type="button"
					class="shrink-0 rounded-lg bg-white p-1 <?php echo esc_attr( $btn_class ); ?>"
					data-gallery-thumb
					data-index="<?php echo esc_attr( $i ); ?>"
					aria-current="<?php echo $active ? 'true' : 'false'; ?>"
				>
					<img
						src="<?php echo esc_url( $it['thumb'] ); ?>"
						alt=""
						class="h-16 w-16 rounded-md object-contain bg-slate-50"
						loading="lazy"
					/>
				</button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<script type="application/json" data-gallery-data>
		<?php
		echo wp_json_encode(
			array(
				'images' => $images_full,
				'start'  => 0,
			)
		);
		?>
	</script>
</div>
