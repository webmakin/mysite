<?php session_start();
/*
Template Name: Contact Page
*/
?>
<?php 
	$et_ptemplate_settings = array();
	$et_ptemplate_settings = maybe_unserialize( get_post_meta($post->ID,'et_ptemplate_settings',true) );
	
	$fullwidth = isset( $et_ptemplate_settings['et_fullwidthpage'] ) ? (bool) $et_ptemplate_settings['et_fullwidthpage'] : false;
	
	$et_regenerate_numbers = isset( $et_ptemplate_settings['et_regenerate_numbers'] ) ? (bool) $et_ptemplate_settings['et_regenerate_numbers'] : false;
		
	$et_error_message = '';
	$et_contact_error = false;
	
	if ( isset($_POST['et_contactform_submit']) ) {
		if ( !isset($_POST['et_contact_captcha']) || empty($_POST['et_contact_captcha']) ) {
			$et_error_message .= '<p>' . esc_html__('Make sure you entered the captcha. ','LightBright') . '</p>';
			$et_contact_error = true;
		} else if ( $_POST['et_contact_captcha'] <> ( $_SESSION['et_first_digit'] + $_SESSION['et_second_digit'] ) ) {			
			$et_numbers_string = $et_regenerate_numbers ? esc_html__('Numbers regenerated.','LightBright') : '';
			$et_error_message .= '<p>' . esc_html__('You entered the wrong number in captcha. ','LightBright') . $et_numbers_string . '</p>';
			
			if ($et_regenerate_numbers) {
				unset( $_SESSION['et_first_digit'] );
				unset( $_SESSION['et_second_digit'] );
			}
			
			$et_contact_error = true;
		} else if ( empty($_POST['et_contact_name']) || empty($_POST['et_contact_email']) || empty($_POST['et_contact_subject']) || empty($_POST['et_contact_message']) ){
			$et_error_message .= '<p>' . esc_html__('Make sure you fill all fields. ','LightBright') . '</p>';
			$et_contact_error = true;
		}
		
		if ( !is_email( $_POST['et_contact_email'] ) ) {
			$et_error_message .= '<p>' . esc_html__('Invalid Email. ','LightBright') . '</p>';
			$et_contact_error = true;
		}
	} else {
		$et_contact_error = true;
		if ( isset($_SESSION['et_first_digit'] ) ) unset( $_SESSION['et_first_digit'] );
		if ( isset($_SESSION['et_second_digit'] ) ) unset( $_SESSION['et_second_digit'] );
	}
	
	if ( !isset($_SESSION['et_first_digit'] ) ) $_SESSION['et_first_digit'] = $et_first_digit = rand(1, 15);
	else $et_first_digit = $_SESSION['et_first_digit'];
	
	if ( !isset($_SESSION['et_second_digit'] ) ) $_SESSION['et_second_digit'] = $et_second_digit = rand(1, 15);
	else $et_second_digit = $_SESSION['et_second_digit'];
	
	if ( !$et_contact_error ) {
		$et_email_to = ( isset($et_ptemplate_settings['et_email_to']) && !empty($et_ptemplate_settings['et_email_to']) ) ? $et_ptemplate_settings['et_email_to'] : get_site_option('admin_email');
				
		$et_site_name = is_multisite() ? $current_site->site_name : get_bloginfo('name');	
		
		$contact_name 	= wp_strip_all_tags( $_POST['et_contact_name'] );
		$contact_email 	= wp_strip_all_tags( $_POST['et_contact_email'] );

		$headers  = 'From: ' . $contact_name . ' <' . $contact_email . '>' . "\r\n";
		$headers .= 'Reply-To: ' . $contact_name . ' <' . $contact_email . '>';

		wp_mail( apply_filters( 'et_contact_page_email_to', $et_email_to ), sprintf( '[%s] ' . wp_strip_all_tags( $_POST['et_contact_subject'] ), $et_site_name ), wp_strip_all_tags( $_POST['et_contact_message'] ), apply_filters( 'et_contact_page_headers', $headers, $contact_name, $contact_email ) );
		
		$et_error_message = '<p>' . esc_html__('Thanks for contacting us','LightBright') . '</p>';
	}
?>

	<?php get_header(); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="entry<?php if($fullwidth) echo(' no_sidebar');?>">
			<div class="entry-top"></div>
	
			<?php get_template_part('includes/share'); ?>
			
			<div class="post clearfix">
				<div class="content clearfix">
									
					<h1 class="title"><?php the_title(); ?></h1>
										
					<div class="clear"></div>
					
					<?php $thumb = '';
						  $width = 184;
						  $height = 184;
						  $classtext = '';
						  $titletext = get_the_title();
						
						  $thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'thumb');
						  $thumb = $thumbnail["thumb"]; ?>
						  
					<?php if($thumb <> '' && get_option('lightbright_page_thumbnails') == 'on') { ?>						
						<div class="thumb">
							<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
							
							<span class="overlay"></span>
						</div> <!-- end .thumb -->
					<?php }; ?>					
					
					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','LightBright').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					
					<div id="et-contact">

						<div id="et-contact-message"><?php echo($et_error_message); ?> </div>
						
						<?php if ( $et_contact_error ) { ?>
							<form action="<?php echo(get_permalink($post->ID)); ?>" method="post" id="et_contact_form">
								<div id="et_contact_left">
									<p class="clearfix">
										<label for="et_contact_name" class="et_contact_form_label"><?php esc_html_e('Name','LightBright'); ?></label>
										<input type="text" name="et_contact_name" value="<?php if ( isset($_POST['et_contact_name']) ) echo esc_attr($_POST['et_contact_name']); else esc_attr_e('Name','LightBright'); ?>" id="et_contact_name" class="input" />
									</p>
									
									<p class="clearfix">
										<label for="et_contact_email" class="et_contact_form_label"><?php esc_html_e('Email Address','LightBright'); ?></label>
										<input type="text" name="et_contact_email" value="<?php if ( isset($_POST['et_contact_email']) ) echo esc_attr($_POST['et_contact_email']); else esc_attr_e('Email Address','LightBright'); ?>" id="et_contact_email" class="input" />
									</p>
									
									<p class="clearfix">
										<label for="et_contact_subject" class="et_contact_form_label"><?php esc_html_e('Subject','LightBright'); ?></label>
										<input type="text" name="et_contact_subject" value="<?php if ( isset($_POST['et_contact_subject']) ) echo esc_attr($_POST['et_contact_subject']); else esc_attr_e('Subject','LightBright'); ?>" id="et_contact_subject" class="input" />
									</p>
								</div> <!-- #et_contact_left -->
								
								<div id="et_contact_right">
									<p class="clearfix">
										<?php 
											esc_html_e('Captcha: ','LightBright');	
											echo '<br/>';
											echo esc_attr($et_first_digit) . ' + ' . esc_attr($et_second_digit) . ' = ';
										?>
										<input type="text" name="et_contact_captcha" value="<?php if ( isset($_POST['et_contact_captcha']) ) echo esc_attr($_POST['et_contact_captcha']); ?>" id="et_contact_captcha" class="input" size="2" />
									</p>
								</div> <!-- #et_contact_right -->
								
								<div class="clear"></div>
								
								<p class="clearfix">
									<label for="et_contact_message" class="et_contact_form_label"><?php esc_html_e('Message','LightBright'); ?></label>
									<textarea class="input" id="et_contact_message" name="et_contact_message"><?php if ( isset($_POST['et_contact_message']) ) echo esc_textarea($_POST['et_contact_message']); else echo esc_textarea( __('Message','LightBright') ); ?></textarea>
								</p>
									
								<input type="hidden" name="et_contactform_submit" value="et_contact_proccess" />
								
								<input type="reset" id="et_contact_reset" value="<?php esc_attr_e('Reset','LightBright'); ?>" />
								<input class="et_contact_submit" type="submit" value="<?php esc_attr_e('Submit','LightBright'); ?>" id="et_contact_submit" />
							</form>
						<?php } ?>
					</div> <!-- end #et-contact -->
					
					<div class="clear"></div>
					
					<?php edit_post_link(esc_html__('Edit this page','LightBright')); ?>
			
				</div> <!-- end .content -->
		
				<div class="entry-bottom-top"></div>
	
				<div class="entry-meta clearfix">
					<p class="meta"><span class="main"><?php esc_html_e('Posted by','LightBright');?> <?php the_author_posts_link(); ?></span> <span class="comment-count"><?php comments_popup_link('0','1','%'); ?></span></p>
					<?php if(!is_single()) { ?>
						<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','LightBright'); ?></span></a>
					<?php }; ?>
				</div> <!-- end .entry-meta -->		
		
			</div> <!-- end .post -->
	
			<div class="entry-bottom"></div>
		</div> <!-- end .entry -->
	<?php endwhile; endif; ?>
	</div> <!-- end #main-area -->
		
	<?php if (!$fullwidth) get_sidebar(); ?>
			
<?php get_footer(); ?>