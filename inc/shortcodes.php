<?php
defined( 'ABSPATH' ) || exit;

add_shortcode(
	'alkes_cta_wa_2_column',
	function () {

		ob_start();

		get_template_part(
			'template-parts/cta/cta-section-two-column',
			null,
			array(
				'title' => 'Hubungi Sejahtera Alkes',
				'desc'  => 'Untuk pertanyaan produk, kerja sama, atau kebutuhan pengadaan, hubungi kami lewat WhatsApp.',
			)
		);

		return ob_get_clean();
	}
);

add_shortcode(
	'alkes_cta_wa_compact',
	function () {

		ob_start();

		get_template_part(
			'template-parts/cta/cta-form',
			null,
			array(
				'title'          => 'Konsultasi Cepat',
				'desc'           => 'Untuk pertanyaan produk, kerja sama, atau kebutuhan pengadaan, hubungi kami lewat WhatsApp.',
				'require_change' => true,
			)
		);

		return ob_get_clean();
	}
);
