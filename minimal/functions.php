<?php
/**
 * Theme bootstrap.
 *
 * @package minimal
 */

add_action(
	'after_setup_theme',
	static function () {
		add_editor_style( 'style.css' );
	}
);

add_action(
	'init',
	static function () {
		register_block_style(
			'core/separator',
			array(
				'name'         => 'chain-hr',
				'label'        => __( 'Chain HR', 'minimal' ),
				'inline_style' => sprintf(
					'.wp-block-separator.is-style-chain-hr{background:transparent url("%1$s") left center/auto 72%% repeat-x;border:0;height:clamp(1.8rem,3.4vw,2.6rem);margin-left:auto;margin-right:auto;max-width:min(100%%,36rem);opacity:.95;width:100%%}',
					esc_url( get_theme_file_uri( 'chain-hr.svg' ) )
				),
			)
		);
	}
);
