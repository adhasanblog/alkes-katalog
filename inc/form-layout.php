<?php

add_action(
	'add_meta_boxes',
	function () {
		remove_meta_box(
			'produk_flagdiv', // ID default metabox taxonomy
			'produk',         // post type
			'side'
		);
	},
	20
);
