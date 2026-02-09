<?php
defined( 'ABSPATH' ) || exit;

/**
 * ACF Required
 */
function alkes_acf_is_active(): bool {
	return function_exists( 'acf_add_local_field_group' );
}

add_action(
	'after_setup_theme',
	function () {
		require_once get_template_directory() . '/inc/acf-field-groups.php';
	}
);

/**
 * Admin notice kalau ACF belum terpasang/aktif
 */
add_action(
	'admin_notices',
	function () {
		// Hanya admin
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$status = alkes_get_acf_status();

		if ( 'active' === $status ) {
			return;
		}

		$plugin_slug = 'advanced-custom-fields';
		$plugin_file = 'advanced-custom-fields/acf.php';

		if ( 'missing' === $status ) {
			$action_url   = wp_nonce_url(
				self_admin_url( "update.php?action=install-plugin&plugin={$plugin_slug}" ),
				"install-plugin_{$plugin_slug}"
			);
			$button_label = 'Install ACF';
		} else {
			$action_url   = wp_nonce_url(
				self_admin_url( "plugins.php?action=activate&plugin={$plugin_file}" ),
				"activate-plugin_{$plugin_file}"
			);
			$button_label = 'Aktifkan ACF';
		}
		?>

		<div class="notice notice-error">
			<p>
				<strong>Theme Alkes Catalog membutuhkan plugin Advanced Custom Fields (ACF).</strong><br>
				Tanpa ACF, field produk (harga, galeri, spesifikasi, hero, dll) tidak akan berfungsi.
			</p>
			<p>
				<a href="<?php echo esc_url( $action_url ); ?>" class="button button-primary">
					<?php echo esc_html( $button_label ); ?>
				</a>
			</p>
		</div>

		<?php
	}
);

/**
 * (Opsional) Block akses Custom Post Type "produk" jika ACF belum aktif
 */
add_action(
	'admin_init',
	function () {
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen && ( 'produk' === $screen->post_type ) ) {
			wp_safe_redirect( admin_url( 'plugins.php' ) );
			exit;
		}
	}
);

add_filter(
	'acf/settings/save_json',
	function () {
		return get_template_directory() . '/acf-json';
	}
);

add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		$paths[] = get_template_directory() . '/acf-json';
		return $paths;
	}
);

add_action(
	'acf/save_post',
	function ( $post_id ) {

		// hanya produk
		if ( get_post_type( $post_id ) !== 'produk' ) {
			return;
		}

		// hindari autosave & revision (ini penting)
		if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
			return;
		}

		// pastikan taxonomy ada
		if ( ! taxonomy_exists( 'produk_flag' ) ) {
			return;
		}

		// pastikan term "unggulan" ada
		$term = term_exists( 'unggulan', 'produk_flag' );
		if ( ! $term ) {
			$term = wp_insert_term( 'Unggulan', 'produk_flag', array( 'slug' => 'unggulan' ) );
			if ( is_wp_error( $term ) ) {
				return;
			}
		}

		// ambil value ACF setelah tersimpan
		$value = get_field( 'is_featured', $post_id ); // 1/0

		if ( 1 === (int) $value ) {
			wp_set_object_terms( $post_id, array( 'unggulan' ), 'produk_flag', true );
		} else {
			wp_remove_object_terms( $post_id, array( 'unggulan' ), 'produk_flag' );
		}
	},
	30
); // naikkan priority supaya ACF sudah selesai simpan
