<?php 
add_action( 'after_setup_theme', 'et_setup_theme' );
if ( ! function_exists( 'et_setup_theme' ) ){
	function et_setup_theme(){
		global $themename, $shortname;
		
		$themename = "Feather";
		$shortname = "feather";
		
		require_once(TEMPLATEPATH . '/epanel/custom_functions.php'); 

		require_once(TEMPLATEPATH . '/includes/functions/comments.php'); 

		require_once(TEMPLATEPATH . '/includes/functions/sidebars.php'); 

		load_theme_textdomain( $themename, get_template_directory() . '/lang' );

		require_once(TEMPLATEPATH . '/epanel/options_feather.php');

		require_once(TEMPLATEPATH . '/epanel/core_functions.php'); 

		require_once(TEMPLATEPATH . '/epanel/post_thumbnails_feather.php');
		
		require_once(TEMPLATEPATH . '/includes/additional_functions.php');
		
		include(TEMPLATEPATH . '/includes/widgets.php');
		
		add_action( 'pre_get_posts', 'et_home_posts_query' );
		
		add_action( 'et_epanel_changing_options', 'et_delete_featured_ids_cache' );
		add_action( 'delete_post', 'et_delete_featured_ids_cache' );	
		add_action( 'save_post', 'et_delete_featured_ids_cache' );
	}
}

function register_main_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu' ),
			'footer-menu' => __( 'Footer Menu' )
		)
	);
}
if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

/**
 * Gets featured posts IDs from transient, if the transient doesn't exist - runs the query and stores IDs
 */
function et_get_featured_posts_ids(){
	if ( false === ( $et_featured_post_ids = get_transient( 'et_featured_post_ids' ) ) ) {
		$featured_query = new WP_Query( apply_filters( 'et_featured_post_args', array(
			'posts_per_page'	=> (int) et_get_option( 'feather_featured_num' ),
			'cat'				=> get_catId( et_get_option( 'feather_feat_cat' ) )
		) ) );

		if ( $featured_query->have_posts() ) {
			while ( $featured_query->have_posts() ) {
				$featured_query->the_post();
				
				$et_featured_post_ids[] = get_the_ID();
			}

			set_transient( 'et_featured_post_ids', $et_featured_post_ids );
		}
		
		wp_reset_postdata();
	}
	
	return $et_featured_post_ids;
}

/**
 * Filters the main query on homepage
 */
function et_home_posts_query( $query = false ) {
	/* Don't proceed if it's not homepage or the main query */
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() ) return;
	
	if ( 'false' == et_get_option( 'feather_blog_style', 'false' )  ) {
		if ( 'on' == et_get_option( 'feather_display_recentwork_section', 'on' ) ) {
			$query->set( 'posts_per_page', et_get_option( 'feather_posts_media', '8' ) );
			
			$exclude_media_categories = et_get_option( 'feather_exlcats_media', false );
			if ( $exclude_media_categories ) $query->set( 'category__not_in', $exclude_media_categories );
		}
		
		return;
	}
	
	/* Set the amount of posts per page on homepage */
	$query->set( 'posts_per_page', et_get_option( 'feather_homepage_posts', '6' ) );
	
	/* Exclude categories set in ePanel */
	$exclude_categories = et_get_option( 'feather_exlcats_recent', false );
	if ( $exclude_categories ) $query->set( 'category__not_in', $exclude_categories );
	
	/* Exclude slider posts, if the slider is activated, pages are not featured and posts duplication is disabled in ePanel  */
	if ( 'on' == et_get_option( 'feather_featured', 'on' ) && 'false' == et_get_option( 'feather_use_pages', 'false' ) && 'false' == et_get_option( 'feather_duplicate', 'on' ) )
		$query->set( 'post__not_in', et_get_featured_posts_ids() );
}

/**
 * Deletes featured posts IDs transient, when the user saves, resets ePanel settings, creates or moves posts to trash in WP-Admin
 */
function et_delete_featured_ids_cache(){
	if ( false !== get_transient( 'et_featured_post_ids' ) ) delete_transient( 'et_featured_post_ids' );
}

if ( ! function_exists( 'et_get_the_author_posts_link' ) ){
	function et_get_the_author_posts_link(){
		global $authordata, $themename;
		$link = sprintf(
			'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
			get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
			esc_attr( sprintf( __( 'Posts by %s', $themename ), get_the_author() ) ),
			get_the_author()
		);
		return apply_filters( 'the_author_posts_link', $link );
	}
}

if ( ! function_exists( 'et_postinfo_meta' ) ){
	function et_postinfo_meta( $postinfo, $date_format, $comment_zero, $comment_one, $comment_more ){
		global $themename;
		
		$postinfo_meta = esc_html__('Posted',$themename);
		
		if ( in_array( 'author', $postinfo ) )
			$postinfo_meta .= ' ' . esc_html__('by',$themename) . ' ' . et_get_the_author_posts_link();

		if ( in_array( 'date', $postinfo ) )
			$postinfo_meta .= ' ' . esc_html__('on',$themename) . ' ' . get_the_time( $date_format );
			
		if ( in_array( 'categories', $postinfo ) )
			$postinfo_meta .= ' ' . esc_html__('in',$themename) . ' ' . get_the_category_list(', ');
			
		if ( in_array( 'comments', $postinfo ) )
			$postinfo_meta .= ' | ' . et_get_comments_popup_link( $comment_zero, $comment_one, $comment_more );
			
		echo $postinfo_meta;
	}
}

if ( ! function_exists( 'et_get_comments_popup_link' ) ){
	function et_get_comments_popup_link( $zero = false, $one = false, $more = false ){
		global $themename;
		
		$id = get_the_ID();
		$number = get_comments_number( $id );

		if ( 0 == $number && !comments_open() && !pings_open() ) return;
		
		if ( $number > 1 )
			$output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', $themename) : $more);
		elseif ( $number == 0 )
			$output = ( false === $zero ) ? __('No Comments',$themename) : $zero;
		else // must be one
			$output = ( false === $one ) ? __('1 Comment', $themename) : $one;
			
		return '<span class="comments-number">' . '<a href="' . esc_url( get_permalink() . '#respond' ) . '">' . apply_filters('comments_number', $output, $number) . '</a>' . '</span>';
	}
}

if ( ! function_exists( 'et_list_pings' ) ){
	function et_list_pings($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
	<?php }
}

add_filter( 'et_get_additional_color_scheme', 'et_remove_additional_stylesheet' );
function et_remove_additional_stylesheet( $stylesheet ){
	global $default_colorscheme;
	return $default_colorscheme;
}

// add Home link to the custom menu WP-Admin page
function et_add_home_link( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'et_add_home_link' );

add_action('wp_head','et_add_meta_javascript');
function et_add_meta_javascript(){
	global $shortname;
	echo '<!-- used in scripts -->';
	echo '<meta name="et_featured_auto_speed" content="'. esc_attr( get_option($shortname.'_slider_autospeed') ) .'" />';
			
	$disable_toptier = get_option($shortname.'_disable_toptier') == 'on' ? 1 : 0;
	echo '<meta name="et_disable_toptier" content="'. esc_attr( $disable_toptier ).'" />';
	
	$featured_slider_auto = get_option($shortname.'_slider_auto') == 'on' ? 1 : 0;
	echo '<meta name="et_featured_slider_auto" content="'. esc_attr( $featured_slider_auto ).'" />';
	
	echo '<meta name="et_theme_folder" content="'. esc_attr( get_bloginfo('template_directory') ).'" />';
}

add_action('et_header_top','et_feather_control_panel');
function et_feather_control_panel(){
	global $themename;
	
	$admin_access = apply_filters( 'et_showcontrol_panel', current_user_can('switch_themes') );
	if ( !$admin_access ) return;
	if ( get_option('feather_show_control_panel') <> 'on' ) return;
	global $et_bg_texture_urls, $et_google_fonts; ?>
	<div id="et-control-panel">
		<div id="control-panel-main">
			<a id="et-control-close" href="#"></a>
			<div id="et-control-inner">
				<h3 class="control_title"><?php esc_html_e('Example Colors',$themename); ?></h3>
				<a href="#" class="et-control-colorpicker" id="et-control-background"></a>
				
				<div class="clear"></div>
				
				<?php 
					$sample_colors = array( '6a8e94', '8da49c', 'b0b083', '859a7c', 'c6bea6', 'b08383', 'a4869d', 'f5f5f5', '4e4e4e', '556f6a', '6f5555', '6f6755' );
					for ( $i=1; $i<=12; $i++ ) { ?>
						<a class="et-sample-setting" id="et-sample-color<?php echo $i; ?>" href="#" rel="<?php echo esc_attr($sample_colors[$i-1]); ?>" title="#<?php echo esc_attr($sample_colors[$i-1]); ?>"><span class="et-sample-overlay"></span></a>
				<?php } ?>
				<p><?php esc_html_e('or define your own in ePanel',$themename); ?></p>
				
				<h3 class="control_title"><?php esc_html_e('Texture Overlays',$themename); ?></h3>
				<div class="clear"></div>
				
				<?php 
					$sample_textures = $et_bg_texture_urls;
					for ( $i=1; $i<=count($et_bg_texture_urls); $i++ ) { ?>
						<a title="<?php echo esc_attr($sample_textures[$i-1]); ?>" class="et-sample-setting et-texture" id="et-sample-texture<?php echo $i; ?>" href="#" rel="bg<?php echo $i+1; ?>"><span class="et-sample-overlay"></span></a>
				<?php } ?>
				
				<p><?php esc_html_e('or define your own in ePanel',$themename); ?></p>
				
				<?php 
					$google_fonts = $et_google_fonts;
					$font_setting = 'Lobster';
					$body_font_setting = 'Droid+Sans';
					if ( isset( $_COOKIE['et_feather_header_font'] ) ) $font_setting = $_COOKIE['et_feather_header_font'];
					if ( isset( $_COOKIE['et_feather_body_font'] ) ) $body_font_setting = $_COOKIE['et_feather_body_font'];
				?>
				
				<h3 class="control_title"><?php esc_html_e('Fonts',$themename); ?></h3>
				<div class="clear"></div>
				
				<label for="et_control_header_font"><?php esc_html_e('Header',$themename); ?>
					<select name="et_control_header_font" id="et_control_header_font">
						<?php foreach( $google_fonts as $google_font ) { ?>
							<?php $encoded_value = urlencode($google_font); ?>
							<option value="<?php echo esc_attr($encoded_value); ?>" <?php selected( $font_setting, $encoded_value ); ?>><?php echo esc_html($google_font); ?></option>
						<?php } ?>
					</select>
				</label>
				<a href="#" class="et-control-colorpicker et-font-control" id="et-control-headerfont_bg"></a>
				<div class="clear"></div>
				
				<label for="et_control_body_font"><?php esc_html_e('Body',$themename); ?>
					<select name="et_control_body_font" id="et_control_body_font">
						<?php foreach( $google_fonts as $google_font ) { ?>
							<?php $encoded_value = urlencode($google_font); ?>
							<option value="<?php echo esc_attr($encoded_value); ?>" <?php selected( $body_font_setting, $encoded_value ); ?>><?php echo esc_html($google_font); ?></option>
						<?php } ?>
					</select>
				</label>
				<a href="#" class="et-control-colorpicker et-font-control" id="et-control-bodyfont_bg"></a>
				<div class="clear"></div>
				
			</div> <!-- end #et-control-inner -->
		</div> <!-- end #control-panel-main -->
	</div> <!-- end #et-control-panel -->
<?php
}

add_action( 'template_redirect', 'et_load_feather_scripts' );
function et_load_feather_scripts(){
	$et_slider_type = apply_filters( 'et_slider_type', get_option('feather_slider_type') );
	$template_dir = get_bloginfo('template_directory');
	
	wp_enqueue_script('jquery_cycle', $template_dir . '/js/jquery.cycle.all.min.js', array('jquery'), '1.0', false);
	
	$admin_access = apply_filters( 'et_showcontrol_panel', current_user_can('switch_themes') );
	if ( $admin_access && get_option('feather_show_control_panel') == 'on' ) {
		wp_enqueue_script('et_colorpicker', $template_dir . '/epanel/js/colorpicker.js', array('jquery'), '1.0', true);
		wp_enqueue_script('et_eye', $template_dir . '/epanel/js/eye.js', array('jquery'), '1.0', true);
		wp_enqueue_script('et_cookie', $template_dir . '/js/jquery.cookie.js', array('jquery'), '1.0', true);
		wp_enqueue_script('et_control_panel', get_bloginfo('template_directory') . '/js/et_control_panel.js', array('jquery'), '1.0', true);
	}
}

add_action( 'wp_head', 'et_set_bg_properties' );
function et_set_bg_properties(){
	global $et_bg_texture_urls;
	
	$bgcolor = '';
	$bgcolor = ( isset( $_COOKIE['et_feather_bgcolor'] ) && get_option('feather_show_control_panel') == 'on' ) ? $_COOKIE['et_feather_bgcolor'] : get_option('feather_bgcolor');
	
	$bgtexture_url = '';
	$bgimage_url = '';
	if ( get_option('feather_bgimage') == '' ) {
		if ( isset( $_COOKIE['et_feather_texture_url'] ) && get_option('feather_show_control_panel') == 'on' ) $bgtexture_url =  $_COOKIE['et_feather_texture_url'];
		else {
			$bgtexture_url = get_option('feather_bgtexture_url');
			if ( $bgtexture_url == 'Default' ) $bgtexture_url = '';
			else $bgtexture_url = get_bloginfo('template_directory') . '/images/body-bg' . ( array_search( $bgtexture_url, $et_bg_texture_urls )+2 ) . '.png';
		}
	} else {
		$bgimage_url = get_option('feather_bgimage');
	}
	
	$style = '';
	$style .= '<style type="text/css">';
	if ( $bgcolor <> '' ) $style .= 'body { background-color: #' . esc_attr($bgcolor) . '; }';
	if ( $bgtexture_url <> '' ) $style .= 'body { background-image: url(' . esc_attr($bgtexture_url) . '); }';
	if ( $bgimage_url <> '' ) $style .= 'body { background-image: url(' . esc_attr($bgimage_url) . '); background-position: top center; background-repeat: no-repeat; }';
	$style .= '</style>';
	
	if ( $bgcolor <> '' || $bgtexture_url <> '' || $bgimage_url <> '' ) echo $style;
}

add_action( 'wp_head', 'et_set_font_properties' );
function et_set_font_properties(){
	$font_style = '';
	$font_color = '';
	$font_family = '';
	$font_color_string = '';
	
	if ( isset( $_COOKIE['et_feather_header_font'] ) && get_option('feather_show_control_panel') == 'on' ) $et_header_font =  $_COOKIE['et_feather_header_font'];
	else {
		$et_header_font = get_option('feather_header_font');
		if ( $et_header_font == 'Lobster' ) $et_header_font = '';
	}
	
	if ( isset( $_COOKIE['et_feather_header_font_color'] ) && get_option('feather_show_control_panel') == 'on' ) 	
		$et_header_font_color =  $_COOKIE['et_feather_header_font_color'];
	else 
		$et_header_font_color = get_option('feather_header_font_color');
	
	if ( $et_header_font <> '' || $et_header_font_color <> '' ) {
		$et_header_font_id = strtolower( str_replace( '+', '_', $et_header_font ) );
		$et_header_font_id = str_replace( ' ', '_', $et_header_font_id );
		
		if ( $et_header_font <> '' ) { 
			$font_style .= "<link id='" . esc_attr($et_header_font_id) . "' href='" . esc_url( "http://fonts.googleapis.com/css?family=" . str_replace( ' ', '+', $et_header_font )  . ( 'Raleway' == $et_header_font ? ':100' : '' ) ) . "' rel='stylesheet' type='text/css' />";
			$font_family = "font-family: '" . esc_html(str_replace( '+', ' ', $et_header_font )) . "', Arial, sans-serif !important; ";
		}
		
		if ( $et_header_font_color <> '' ) {
			$font_color_string = "color: #" . esc_html($et_header_font_color) . "; ";
		}
		
		$font_style .= "<style type='text/css'>h1,h2,h3,h4,h5,h6 { ". $font_family .  " }</style>";
		$font_style .= "<style type='text/css'>h1,h2,h3,h4,h5,h6 { ". esc_html($font_color_string) .  " }
		#featured h2 a, #footer h4.widgettitle { color: #fff !important; }
		</style>";
		
		echo $font_style;
	}
	
	$font_style = '';
	$font_color = '';
	$font_family = '';
	$font_color_string = '';
	
	if ( isset( $_COOKIE['et_feather_body_font'] ) && get_option('feather_show_control_panel') == 'on' ) $et_body_font =  $_COOKIE['et_feather_body_font'];
	else {
		$et_body_font = get_option('feather_body_font');
		if ( $et_body_font == 'Droid+Sans' ) $et_body_font = '';
	}
	
	if ( isset( $_COOKIE['et_feather_body_font_color'] ) && get_option('feather_show_control_panel') == 'on' ) 	
		$et_body_font_color =  $_COOKIE['et_feather_body_font_color'];
	else 
		$et_body_font_color = get_option('feather_body_font_color');
	
	if ( $et_body_font <> '' || $et_body_font_color <> '' ) {
		$et_body_font_id = strtolower( str_replace( '+', '_', $et_body_font ) );
		$et_body_font_id = str_replace( ' ', '_', $et_body_font_id );
		
		if ( $et_body_font <> '' ) { 
			$font_style .= "<link id='" . esc_attr($et_body_font_id) . "' href='" . esc_url( "http://fonts.googleapis.com/css?family=" . str_replace( ' ', '+', $et_body_font ) . ( 'Raleway' == $et_body_font ? ':100' : '' ) ) . "' rel='stylesheet' type='text/css' />";
			$font_family = "font-family: '" . esc_html(str_replace( '+', ' ', $et_body_font )) . "', Arial, sans-serif !important; ";
		}
		
		if ( $et_body_font_color <> '' ) {
			$font_color_string = "color: #" . esc_html($et_body_font_color) . "; ";
		}
		
		$font_style .= "<style type='text/css'>body, .blurb h3.title, #footer h4.widgettitle, .widget h4.title { ". $font_family .  " !important }</style>";
		$font_style .= "<style type='text/css'>body { ". esc_html($font_color_string) .  " }</style>";
		
		echo $font_style;
	}
} ?>