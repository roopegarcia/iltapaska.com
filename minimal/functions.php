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

		if ( ! get_option( 'users_can_register' ) ) {
			update_option( 'users_can_register', 1 );
		}
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

/**
 * Return the category slugs that should be hidden from guests.
 *
 * @return array<int, string>
 */
function minimal_members_only_category_slugs() {
	return apply_filters( 'minimal_members_only_category_slugs', array( 'bench-220' ) );
}

/**
 * Get members-only category IDs.
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
 * Check whether the given post is part of a members-only series.
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
 * Keep the protected series out of guest-facing archive and search queries.
 *
 * @param WP_Query $query Query instance.
 * @return void
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
 * Redirect guests away from protected content.
 *
 * @return void
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
 * Enqueue theme styling on the login and registration screens.
 *
 * @return void
 */
function minimal_login_styles() {
	wp_enqueue_style(
		'minimal-login',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);

	$logo_url   = get_theme_file_uri( 'log-o.png' );
	$custom_css = sprintf(
		'body.login{--wp--preset--color--iron-black:#f4efe5;--wp--preset--color--plate-black:#eee6d8;--wp--preset--color--old-paper:#211f1b;--wp--preset--color--chalk-grey:#6f665a;--wp--preset--color--rust-red:#8d3328;--wp--preset--font-family--book-serif:Georgia,"Times New Roman",Times,serif;--wp--preset--font-family--system-font:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;--wp--preset--font-family--notebook-mono:"SFMono-Regular",Consolas,"Liberation Mono",Menlo,monospace;--iltapaska-login-logo:url("%1$s")}',
		esc_url_raw( $logo_url )
	);

	wp_add_inline_style( 'minimal-login', $custom_css );
}
add_action( 'login_enqueue_scripts', 'minimal_login_styles' );

/**
 * Tweak the login header branding.
 *
 * @return string
 */
function minimal_login_header_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'minimal_login_header_url' );

/**
 * Use the site name for the login header link text.
 *
 * @return string
 */
function minimal_login_header_text() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'minimal_login_header_text' );

/**
 * Add a short editorial note to the login and registration screens.
 *
 * @param string $message Existing message markup.
 * @return string
 */
function minimal_login_message( $message ) {
	$action       = isset( $_REQUEST['action'] ) ? sanitize_key( wp_unslash( $_REQUEST['action'] ) ) : 'login';
	$login_url    = wp_login_url( home_url( '/' ) );
	$register_url = wp_registration_url();
	$note_class   = 'register' === $action ? 'minimal-login-note minimal-login-note--register' : 'minimal-login-note';

	if ( 'register' === $action ) {
		$note = sprintf(
			'<p class="%1$s">Register once, then read the Bench-220 notes without the password merry-go-round. Already have an account? <a href="%2$s">Log in</a>.</p>',
			esc_attr( $note_class ),
			esc_url( $login_url )
		);
	} else {
		$note = sprintf(
			'<p class="%1$s">Bench-220 is for registered readers. If you already have an account, log in. If not, <a href="%2$s">register here</a>.</p>',
			esc_attr( $note_class ),
			esc_url( $register_url )
		);
	}

	return $note . $message;
}
add_filter( 'login_message', 'minimal_login_message' );
