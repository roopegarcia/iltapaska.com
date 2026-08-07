<?php
/**
 * Theme setup and assets.
 *
 * @package Minimal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load the display typeface. The CSS font stack remains usable if Google Fonts
 * is unavailable or blocked by the visitor.
 */
function minimal_enqueue_fonts() {
	wp_enqueue_style(
		'minimal-special-elite',
		'https://fonts.googleapis.com/css2?family=Special+Elite&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'minimal_enqueue_fonts' );
add_action( 'enqueue_block_editor_assets', 'minimal_enqueue_fonts' );

/**
 * Register optional block styles used by the journal.
 */
function minimal_register_block_styles() {
	register_block_style(
		'core/quote',
		array(
			'name'  => 'margin-note',
			'label' => __( 'Margin note', 'minimal' ),
		)
	);
}
add_action( 'init', 'minimal_register_block_styles' );

/**
 * Keep the editor close to the front-end presentation and preserve the existing
 * registration setting used by the members-only Bench-220 series.
 */
function minimal_setup() {
	add_editor_style( 'style.css' );

	if ( ! get_option( 'users_can_register' ) ) {
		update_option( 'users_can_register', 1 );
	}
}
add_action( 'after_setup_theme', 'minimal_setup' );

/**
 * Return the category slugs hidden from visitors who are not signed in.
 *
 * @return array<int, string>
 */
function minimal_members_only_category_slugs() {
	return apply_filters( 'minimal_members_only_category_slugs', array( 'bench-220' ) );
}

/**
 * Resolve the members-only categories to IDs for archive queries.
 *
 * @return array<int>
 */
function minimal_members_only_category_ids() {
	$category_ids = array();

	foreach ( minimal_members_only_category_slugs() as $slug ) {
		$term = get_category_by_slug( $slug );

		if ( $term instanceof WP_Term ) {
			$category_ids[] = (int) $term->term_id;
		}
	}

	return array_values( array_unique( array_filter( $category_ids ) ) );
}

/**
 * Determine whether a post belongs to the members-only series.
 *
 * @param int|WP_Post|null $post Post object or ID.
 * @return bool
 */
function minimal_is_members_only_post( $post = null ) {
	$post = get_post( $post );

	if ( ! $post instanceof WP_Post ) {
		return false;
	}

	return has_category( minimal_members_only_category_slugs(), $post );
}

/**
 * Exclude members-only entries from public lists, feeds, and search results.
 *
 * @param WP_Query $query Query instance.
 */
function minimal_filter_members_only_queries( $query ) {
	if ( is_admin() || ! $query->is_main_query() || is_user_logged_in() ) {
		return;
	}

	$category_ids = minimal_members_only_category_ids();

	if ( ! $category_ids ) {
		return;
	}

	if ( $query->is_home() || $query->is_archive() || $query->is_search() || $query->is_feed() ) {
		$excluded = array_map( 'intval', (array) $query->get( 'category__not_in', array() ) );
		$query->set( 'category__not_in', array_values( array_unique( array_merge( $excluded, $category_ids ) ) ) );
	}
}
add_action( 'pre_get_posts', 'minimal_filter_members_only_queries' );

/**
 * Send guests who request protected content to the WordPress login screen.
 */
function minimal_redirect_members_only_content() {
	if ( is_user_logged_in() ) {
		return;
	}

	if ( is_singular() && minimal_is_members_only_post() ) {
		wp_safe_redirect( wp_login_url( get_permalink() ) );
		exit;
	}

	if ( is_category( minimal_members_only_category_slugs() ) ) {
		wp_safe_redirect( wp_login_url( get_category_link( get_queried_object_id() ) ) );
		exit;
	}
}
add_action( 'template_redirect', 'minimal_redirect_members_only_content' );

/**
 * Point the login header back to the journal.
 *
 * @return string
 */
function minimal_login_header_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'minimal_login_header_url' );

/**
 * Use the journal name as the login header text.
 *
 * @return string
 */
function minimal_login_header_text() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'minimal_login_header_text' );

/**
 * Explain why the Bench-220 series requires an account.
 *
 * @param string $message Existing login message.
 * @return string
 */
function minimal_login_message( $message ) {
	$action       = isset( $_REQUEST['action'] ) ? sanitize_key( wp_unslash( $_REQUEST['action'] ) ) : 'login';
	$login_url    = wp_login_url( home_url( '/' ) );
	$register_url = wp_registration_url();

	if ( 'register' === $action ) {
		$note = sprintf(
			'<p class="minimal-login-note">Register once, then read the Bench-220 notes without the password merry-go-round. Already have an account? <a href="%1$s">Log in</a>.</p>',
			esc_url( $login_url )
		);
	} else {
		$note = sprintf(
			'<p class="minimal-login-note">Bench-220 is for registered readers. If you already have an account, log in. If not, <a href="%1$s">register here</a>.</p>',
			esc_url( $register_url )
		);
	}

	return $note . $message;
}
add_filter( 'login_message', 'minimal_login_message' );
