<?php 
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname;
		$themename = "LightBright";
		$shortname = "lightbright";
	
		require_once(TEMPLATEPATH . '/epanel/custom_functions.php'); 

		require_once(TEMPLATEPATH . '/includes/functions/comments.php'); 

		require_once(TEMPLATEPATH . '/includes/functions/sidebars.php'); 

		load_theme_textdomain('LightBright',get_template_directory().'/lang');

		require_once(TEMPLATEPATH . '/epanel/options_lightbright.php');

		require_once(TEMPLATEPATH . '/epanel/core_functions.php'); 

		require_once(TEMPLATEPATH . '/epanel/post_thumbnails_lightbright.php');
		
		include(TEMPLATEPATH . '/includes/widgets.php');
		
		require_once(TEMPLATEPATH . '/includes/functions/custom_posts.php');
		
		add_action( 'pre_get_posts', 'et_posts_query' );
	}
}

/**
 * Filters the main query
 */
function et_posts_query( $query = false ) {
	/* Don't proceed if it's not homepage or the main query */
	if ( is_admin() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;
	
	/* Set the amount of posts per page on homepage */
	if ( is_home() ) $query->set( 'posts_per_page', et_get_option( 'lightbright_homepage_posts', '6' ) );
	
	if ( ! is_singular() ) $query->set( 'post_type', array( 'note', 'photo', 'quote', 'video', 'customlink', 'audio', 'post' ) );
}

add_action('wp_head','et_portfoliopt_additional_styles',100);
function et_portfoliopt_additional_styles(){ ?>
	<style type="text/css">
		#et_pt_portfolio_gallery { margin-left: -15px; }
		.et_pt_portfolio_item { margin-left: 21px; width: 192px; }
		.et_portfolio_small { margin-left: -40px !important; }
		.et_portfolio_small .et_pt_portfolio_item { margin-left: 32px !important; }
		.et_portfolio_large { margin-left: -10px !important; }
		.et_portfolio_large .et_pt_portfolio_item { margin-left: 15px !important; }
		
		.et_portfolio_more_icon, .et_portfolio_zoom_icon { top: 49px; }
		.et_portfolio_more_icon { left: 54px; }
		.et_portfolio_zoom_icon { left: 95px; }
		.et_portfolio_small .et_pt_portfolio_item { width: 102px; }
		.et_portfolio_small .et_portfolio_more_icon { left: 11px; }
		.et_portfolio_small .et_portfolio_zoom_icon { left: 49px; }
		.et_portfolio_large .et_pt_portfolio_item { width: 312px; }
		.et_portfolio_large .et_portfolio_more_icon, .et_portfolio_large .et_portfolio_zoom_icon { top: 85px; }
		.et_portfolio_large .et_portfolio_more_icon { left: 119px; }
		.et_portfolio_large .et_portfolio_zoom_icon { left: 158px; }
	</style>
<?php }

function register_main_menus() {
	register_nav_menus( array(
		'primary-menu' => 'Primary Navigation',
	) );
};
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}
	
add_filter( 'et_fullpath', 'et_change_fullpath' );
function et_change_fullpath( $thumb ){
	global $post;
	if ( is_page() ) return $thumb;
	if ( get_post_meta( $post->ID, 'thumb', true ) ) $thumb = get_post_meta( $post->ID, 'thumb', true );
	return $thumb;
} ?>