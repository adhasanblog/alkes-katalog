<?php

add_filter(
	'use_block_editor_for_post_type',
	function ( $use_block_editor, $post_type ) {
		if ( 'produk' === $post_type ) {
			return false; // pakai Classic Editor
		}

		return $use_block_editor;
	},
	10,
	2
);
