<?php
/**
 * Theme bootstrap.
 *
 * @package iltapaska-news
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue theme assets.
 *
 * @return void
 */
function iltapaska_news_enqueue_assets() {
	wp_enqueue_style(
		'iltapaska-news-style',
		get_theme_file_uri( 'assets/css/vhs.css' ),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'iltapaska-news-club-calculator',
		get_theme_file_uri( 'assets/js/club-calculator.js' ),
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'iltapaska_news_enqueue_assets' );

/**
 * Body class for style scoping.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function iltapaska_news_body_class( $classes ) {
	$classes[] = 'iltapaska-news';
	return $classes;
}
add_filter( 'body_class', 'iltapaska_news_body_class' );

/**
 * Render the 1000 lb / 454 kg planner calculator.
 *
 * Usage: [club_calculator]
 *
 * @return string
 */
function iltapaska_news_club_calculator_shortcode() {
	ob_start();
	?>
	<section class="club-calculator" data-club-calculator data-target="454" aria-label="1000 pound club calculator">
		<header class="club-calculator__header">
			<p class="club-calculator__eyebrow">1000 Pound Club Laskuri</p>
			<h2 class="club-calculator__title">Paljonko puuttuu 454 kilosta?</h2>
			<p class="club-calculator__lede">Syota kyykky ja penkki. Laskuri nayttaa deadliftiin tarvittavan tuloksen.</p>
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
				<p>Deadlift tarvitaan</p>
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
add_shortcode( 'club_calculator', 'iltapaska_news_club_calculator_shortcode' );

/**
 * Register image block styles.
 *
 * @return void
 */
function iltapaska_news_register_block_styles() {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/image',
		array(
			'name'  => 'tabloid-photo',
			'label' => __( 'Tabloid Photo', 'iltapaska-news' ),
		)
	);

	register_block_style(
		'core/post-featured-image',
		array(
			'name'  => 'tabloid-photo',
			'label' => __( 'Tabloid Photo', 'iltapaska-news' ),
		)
	);
}
add_action( 'init', 'iltapaska_news_register_block_styles' );
