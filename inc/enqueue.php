<?php
defined( 'ABSPATH' ) || exit;

add_action(
	'wp_enqueue_scripts',
	function () {
		$theme_dir = get_stylesheet_directory();
		$theme_uri = get_stylesheet_directory_uri();

		$manifest_path = $theme_dir . '/assets/dist/.vite/manifest.json';
		$dist_uri      = $theme_uri . '/assets/dist/';

		if ( ! file_exists( $manifest_path ) ) {
			return;
		}
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local file read (Vite manifest), not a remote URL.
		$body = file_get_contents( $manifest_path );
		if ( false === $body || '' === trim( $body ) ) {
			return;
		}

		$manifest = json_decode( $body, true );
		if ( ! is_array( $manifest ) ) {
			return;
		}

		$css_key = 'assets/src/css/app.css';
		$js_key  = 'assets/src/js/global.js';

		// --- CSS
		if ( isset( $manifest[ $css_key ] ) && ! empty( $manifest[ $css_key ]['file'] ) ) {
			$css_file = (string) $manifest[ $css_key ]['file'];
			$css_ver  = '';

			$css_path = $theme_dir . '/assets/dist/' . $css_file;
			if ( file_exists( $css_path ) ) {
				$css_ver = (string) filemtime( $css_path );
			}

			wp_enqueue_style(
				'alkes-app',
				$dist_uri . $css_file,
				array(),
				$css_ver
			);
		}

		// --- JS
		if ( isset( $manifest[ $js_key ] ) && ! empty( $manifest[ $js_key ]['file'] ) ) {
			$js_file = (string) $manifest[ $js_key ]['file'];
			$js_ver  = '';

			$js_path = $theme_dir . '/assets/dist/' . $js_file;
			if ( file_exists( $js_path ) ) {
				$js_ver = (string) filemtime( $js_path );
			}

			wp_enqueue_script(
				'alkes-global',
				$dist_uri . $js_file,
				array(),
				$js_ver,
				true
			);

			// Load Vite imported chunks (kalau ada)
			if ( ! empty( $manifest[ $js_key ]['imports'] ) && is_array( $manifest[ $js_key ]['imports'] ) ) {
				foreach ( $manifest[ $js_key ]['imports'] as $import_key ) {
					if ( ! empty( $manifest[ $import_key ]['file'] ) ) {
						$import_file = (string) $manifest[ $import_key ]['file'];
						$import_path = $theme_dir . '/assets/dist/' . $import_file;
						$import_ver  = file_exists( $import_path ) ? (string) filemtime( $import_path ) : '';

						$handle = 'alkes-chunk-' . md5( $import_file );

						wp_enqueue_script(
							$handle,
							$dist_uri . $import_file,
							array(),
							$import_ver,
							true
						);
					}
				}
			}
		}
	}
);
