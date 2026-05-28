<?php
/**
 * Theme bootstrap.
 *
 * @package vhs-retro-vision
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme assets.
 */
function vhs_retro_vision_enqueue_assets() {
	wp_enqueue_style(
		'vhs-retro-vision-effects',
		get_theme_file_uri( 'assets/css/vhs.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'vhs-retro-vision-club-calculator',
		get_theme_file_uri( 'assets/js/club-calculator.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'vhs_retro_vision_enqueue_assets' );

/**
 * Body class for scoped layout offsets.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function vhs_retro_vision_body_class( $classes ) {
	$classes[] = 'vhs-retro-vision';
	return $classes;
}
add_filter( 'body_class', 'vhs_retro_vision_body_class' );

/**
 * Render the 1000 lb / 454 kg planner calculator.
 *
 * Usage: [club_calculator]
 *
 * @return string
 */
function vhs_retro_vision_club_calculator_shortcode() {
	ob_start();
	?>
	<section class="club-calculator" data-club-calculator data-target="454" aria-label="1000 pound club calculator">
		<header class="club-calculator__header">
			<p class="club-calculator__eyebrow">1000 Pound Club Laskuri</p>
			<h2 class="club-calculator__title">Tavoite 454 kg</h2>
			<p class="club-calculator__lede">Saada kyykkya ja penkkia. Deadlift paivittyy automaattisesti jaljella olevaan painoon.</p>
		</header>

		<div class="club-calculator__grid">
			<div class="club-calculator__field">
				<label for="club-squat">Kyykky <span data-squat-value>120</span> kg</label>
				<input id="club-squat" type="range" min="0" max="320" value="120" step="1" data-squat-input />
			</div>

			<div class="club-calculator__field">
				<label for="club-bench">Penkki <span data-bench-value>100</span> kg</label>
				<input id="club-bench" type="range" min="0" max="240" value="100" step="1" data-bench-input />
			</div>

			<div class="club-calculator__field club-calculator__field--readonly">
				<p>Deadlift Tarvitaan</p>
				<p class="club-calculator__result"><strong data-deadlift-value>234</strong> kg</p>
			</div>
		</div>

		<div class="club-calculator__summary" aria-live="polite">
			<p>Yhteensa: <strong data-total-value>454</strong> / 454 kg</p>
			<p class="club-calculator__warning" data-over-warning hidden>Kyykky + penkki ylittaa 454 kg. Laske toista nostoa jatkaaksesi.</p>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
add_shortcode( 'club_calculator', 'vhs_retro_vision_club_calculator_shortcode' );

/**
 * Register editor patterns for newspaper sections.
 *
 * @return void
 */
function vhs_retro_vision_register_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}

	register_block_pattern(
		'vhs-retro-vision/kesae-kuntoon-teaser',
		array(
			'title'       => __( 'Kesae kuntoon: Headline + teaser', 'vhs-retro-vision' ),
			'description' => __( 'Front-page newspaper headline and teaser block for the Kesae kuntoon category.', 'vhs-retro-vision' ),
			'categories'  => array( 'featured', 'text' ),
			'content'     =>
				'<!-- wp:group {"className":"np-shell","layout":{"type":"constrained"}} -->' .
				'<div class="wp-block-group np-shell">' .
				'<!-- wp:paragraph {"className":"np-kicker"} --><p class="np-kicker">Paajuttu</p><!-- /wp:paragraph -->' .
				'<!-- wp:heading {"level":1,"className":"np-section-title"} --><h1 class="wp-block-heading np-section-title">KESAE KUNTOON: LEIKKAUSKAUDEN TILANNERAPORTTI</h1><!-- /wp:heading -->' .
				'<!-- wp:paragraph {"className":"np-deck"} --><p class="np-deck">Tama osio seuraa cutin etenemista viikko viikolta: treenit, painonmuutokset ja arjen valinnat kohti kovempaa kesakuntoa.</p><!-- /wp:paragraph -->' .
				'<!-- wp:paragraph {"className":"np-byline"} --><p class="np-byline"><a href="/category/kesae-kuntoon/">Avaa Kesae kuntoon</a></p><!-- /wp:paragraph -->' .
				'</div><!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'vhs_retro_vision_register_patterns' );

/**
 * Register custom block styles for editorial image treatment.
 *
 * @return void
 */
function vhs_retro_vision_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/image',
		array(
			'name'  => 'vintage-photo',
			'label' => __( 'Vintage Photo', 'vhs-retro-vision' ),
		)
	);

	register_block_style(
		'core/post-featured-image',
		array(
			'name'  => 'vintage-photo',
			'label' => __( 'Vintage Photo', 'vhs-retro-vision' ),
		)
	);
}
add_action( 'init', 'vhs_retro_vision_register_block_styles' );
