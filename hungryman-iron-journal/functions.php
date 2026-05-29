<?php
/**
 * Theme bootstrap.
 *
 * @package hungryman-iron-journal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end assets.
 *
 * @return void
 */
function hungryman_iron_journal_enqueue_assets() {
	wp_enqueue_style(
		'hungryman-iron-journal-theme',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'hungryman_iron_journal_enqueue_assets' );

/**
 * Add class for scoped theme styles.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function hungryman_iron_journal_body_class( $classes ) {
	$classes[] = 'hungryman-iron-journal';
	return $classes;
}
add_filter( 'body_class', 'hungryman_iron_journal_body_class' );

/**
 * Register reusable weekly post pattern.
 *
 * @return void
 */
function hungryman_iron_journal_register_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern(
		'hungryman-iron-journal/weekly-training-journal',
		array(
			'title'       => __( 'Weekly Training Journal', 'hungryman-iron-journal' ),
			'description' => __( 'Structured weekly post with recurring sections and Iron Archive embed area.', 'hungryman-iron-journal' ),
			'categories'  => array( 'text', 'featured' ),
			'content'     =>
				'<!-- wp:group {"className":"weekly-log-shell","layout":{"type":"constrained"}} -->' .
				'<div class="wp-block-group weekly-log-shell">' .
				'<!-- wp:heading {"level":2,"className":"weekly-log-heading"} --><h2 class="wp-block-heading weekly-log-heading">Current Stats</h2><!-- /wp:heading -->' .
				'<!-- wp:list {"className":"weekly-log-list"} --><ul class="weekly-log-list"><li>Bodyweight: </li><li>Estimated Body Fat: </li><li>Sleep Average: </li></ul><!-- /wp:list -->' .
				'<!-- wp:heading {"level":2,"className":"weekly-log-heading"} --><h2 class="wp-block-heading weekly-log-heading">This Week in Training</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph {"className":"weekly-log-block"} --><p class="weekly-log-block">Main sessions, volume notes, and what moved well under the bar.</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":2,"className":"weekly-log-heading"} --><h2 class="wp-block-heading weekly-log-heading">Food / Nutrition Notes</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph {"className":"weekly-log-block"} --><p class="weekly-log-block">Calories, protein consistency, hunger patterns, and practical meal notes.</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":2,"className":"weekly-log-heading"} --><h2 class="wp-block-heading weekly-log-heading">Mental Notes</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph {"className":"weekly-log-block"} --><p class="weekly-log-block">Mindset, confidence under heavy sets, and recovery pressure.</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":2,"className":"weekly-log-heading"} --><h2 class="wp-block-heading weekly-log-heading">Work / Modern Life Notes</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph {"className":"weekly-log-block"} --><p class="weekly-log-block">Work stress, family logistics, and how training fit real life this week.</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":2,"className":"weekly-log-heading"} --><h2 class="wp-block-heading weekly-log-heading">Iron Archive</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph {"className":"weekly-log-block"} --><p class="weekly-log-block">Drop in an old-school clip and annotate what still holds up.</p><!-- /wp:paragraph -->' .
				'<!-- wp:group {"className":"iron-vhs-embed","layout":{"type":"constrained"}} --><div class="wp-block-group iron-vhs-embed"><!-- wp:embed {"url":"https://www.youtube.com/watch?v=dQw4w9WgXcQ","type":"video","providerNameSlug":"youtube","responsive":true,"className":"is-style-iron-vhs"} --><figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube is-style-iron-vhs"><div class="wp-block-embed__wrapper">https://www.youtube.com/watch?v=dQw4w9WgXcQ</div></figure><!-- /wp:embed --></div><!-- /wp:group -->' .
				'</div><!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'hungryman_iron_journal_register_patterns' );

/**
 * Register VHS treatment style variation for embeds.
 *
 * @return void
 */
function hungryman_iron_journal_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/embed',
		array(
			'name'  => 'iron-vhs',
			'label' => __( 'Iron VHS', 'hungryman-iron-journal' ),
		)
	);
}
add_action( 'init', 'hungryman_iron_journal_register_block_styles' );
