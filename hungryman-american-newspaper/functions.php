<?php
/**
 * Theme bootstrap.
 *
 * @package hungryman-american-newspaper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end assets.
 *
 * @return void
 */
function hungryman_american_newspaper_enqueue_assets() {
	wp_enqueue_style(
		'hungryman-american-newspaper-theme',
		get_theme_file_uri( 'assets/css/theme.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'hungryman_american_newspaper_enqueue_assets' );

/**
 * Add a scoped body class for theme styles.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function hungryman_american_newspaper_body_class( $classes ) {
	$classes[] = 'hungryman-american-newspaper';
	return $classes;
}
add_filter( 'body_class', 'hungryman_american_newspaper_body_class' );

/**
 * Register reusable weekly post pattern.
 *
 * @return void
 */
function hungryman_american_newspaper_register_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern(
		'hungryman-american-newspaper/weekly-column',
		array(
			'title'       => __( 'Weekly Newspaper Column', 'hungryman-american-newspaper' ),
			'description' => __( 'A structured weekly training and life column.', 'hungryman-american-newspaper' ),
			'categories'  => array( 'text', 'featured' ),
			'content'     =>
				'<!-- wp:group {"className":"newspaper-ledger","layout":{"type":"constrained"}} -->' .
				'<div class="wp-block-group newspaper-ledger">' .
				'<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Current Stats</h2><!-- /wp:heading -->' .
				'<!-- wp:list --><ul><li>Bodyweight: </li><li>Estimated Body Fat: </li><li>Sleep Average: </li></ul><!-- /wp:list -->' .
				'<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">This Week in Training</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph --><p>Main sessions, working weights, volume, and what the bar reported back.</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Food / Nutrition Notes</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph --><p>Calories, protein, hunger, convenience, and any heroic failures in the kitchen.</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Mental Notes</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph --><p>The private weather report.</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Work / Modern Life Notes</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph --><p>Work, family logistics, and whatever modern life tried to sell as urgent.</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Iron Archive</h2><!-- /wp:heading -->' .
				'<!-- wp:paragraph --><p>An old lift, clip, book note, or training idea worth saving from the landfill.</p><!-- /wp:paragraph -->' .
				'</div><!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'hungryman_american_newspaper_register_patterns' );

/**
 * Register image styles.
 *
 * @return void
 */
function hungryman_american_newspaper_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/image',
		array(
			'name'  => 'press-photo',
			'label' => __( 'Press Photo', 'hungryman-american-newspaper' ),
		)
	);
}
add_action( 'init', 'hungryman_american_newspaper_register_block_styles' );
