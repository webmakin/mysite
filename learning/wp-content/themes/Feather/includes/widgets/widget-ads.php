<?php class AdvWidget extends WP_Widget
{
    function AdvWidget(){
		$widget_ops = array( 'description' => esc_html__( 'Displays Advertisements', 'Feather' ) );
		$control_ops = array('width' => 400, 'height' => 500);
		parent::WP_Widget(false,$name = esc_html__( 'ET Advertisement', 'Feather' ),$widget_ops,$control_ops);
	}

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? 'About Me' : esc_html( $instance['title'] ) );
		$use_relpath = isset($instance['use_relpath']) ? $instance['use_relpath'] : false;
		$new_window = isset($instance['new_window']) ? $instance['new_window'] : false;
		$bannerPath[1] = empty($instance['bannerOnePath']) ? '' : esc_url($instance['bannerOnePath']);
		$bannerUrl[1] = empty($instance['bannerOneUrl']) ? '' : esc_url($instance['bannerOneUrl']);
		$bannerTitle[1] = empty($instance['bannerOneTitle']) ? '' : esc_attr($instance['bannerOneTitle']);
		$bannerAlt[1] = empty($instance['bannerOneAlt']) ? '' : esc_attr($instance['bannerOneAlt']);
		
		$bannerPath[2] = empty($instance['bannerTwoPath']) ? '' : esc_url($instance['bannerTwoPath']);
		$bannerUrl[2] = empty($instance['bannerTwoUrl']) ? '' : esc_url($instance['bannerTwoUrl']);
		$bannerTitle[2] = empty($instance['bannerTwoTitle']) ? '' : esc_attr($instance['bannerTwoTitle']);
		$bannerAlt[2] = empty($instance['bannerTwoAlt']) ? '' : esc_attr($instance['bannerTwoAlt']);
		
		$bannerPath[3] = empty($instance['bannerThreePath']) ? '' : esc_url($instance['bannerThreePath']);
		$bannerUrl[3] = empty($instance['bannerThreeUrl']) ? '' : esc_url($instance['bannerThreeUrl']);
		$bannerTitle[3] = empty($instance['bannerThreeTitle']) ? '' : esc_attr($instance['bannerThreeTitle']);
		$bannerAlt[3] = empty($instance['bannerThreeAlt']) ? '' : esc_attr($instance['bannerThreeAlt']);
		
		$bannerPath[4] = empty($instance['bannerFourPath']) ? '' : esc_url($instance['bannerFourPath']);
		$bannerUrl[4] = empty($instance['bannerFourUrl']) ? '' : esc_url($instance['bannerFourUrl']);
		$bannerTitle[4] = empty($instance['bannerFourTitle']) ? '' : esc_attr($instance['bannerFourTitle']);
		$bannerAlt[4] = empty($instance['bannerFourAlt']) ? '' : esc_attr($instance['bannerFourAlt']);
		
		$bannerPath[5] = empty($instance['bannerFivePath']) ? '' : esc_url($instance['bannerFivePath']);
		$bannerUrl[5] = empty($instance['bannerFiveUrl']) ? '' : esc_url($instance['bannerFiveUrl']);
		$bannerTitle[5] = empty($instance['bannerFiveTitle']) ? '' : esc_attr($instance['bannerFiveTitle']);
		$bannerAlt[5] = empty($instance['bannerFiveAlt']) ? '' : esc_attr($instance['bannerFiveAlt']);
		
		$bannerPath[6] = empty($instance['bannerSixPath']) ? '' : esc_url($instance['bannerSixPath']);
		$bannerUrl[6] = empty($instance['bannerSixUrl']) ? '' : esc_url($instance['bannerSixUrl']);
		$bannerTitle[6] = empty($instance['bannerSixTitle']) ? '' : esc_attr($instance['bannerSixTitle']);
		$bannerAlt[6] = empty($instance['bannerSixAlt']) ? '' : esc_attr($instance['bannerSixAlt']);
		
		$bannerPath[7] = empty($instance['bannerSevenPath']) ? '' : esc_url($instance['bannerSevenPath']);
		$bannerUrl[7] = empty($instance['bannerSevenUrl']) ? '' : esc_url($instance['bannerSevenUrl']);
		$bannerTitle[7] = empty($instance['bannerSevenTitle']) ? '' : esc_attr($instance['bannerSevenTitle']);
		$bannerAlt[7] = empty($instance['bannerSevenAlt']) ? '' : esc_attr($instance['bannerSevenAlt']);
		
		$bannerPath[8] = empty($instance['bannerEightPath']) ? '' : esc_url($instance['bannerEightPath']);
		$bannerUrl[8] = empty($instance['bannerEightUrl']) ? '' : esc_url($instance['bannerEightUrl']);
		$bannerTitle[8] = empty($instance['bannerEightTitle']) ? '' : esc_attr($instance['bannerEightTitle']);
		$bannerAlt[8] = empty($instance['bannerEightAlt']) ? '' : esc_attr($instance['bannerEightAlt']);

		echo $before_widget;

		if ( $title )
		echo $before_title . $title . $after_title;
?>	
<div class="adwrap">
<?php $i = 1; 
while ($i <= 8):
if ($bannerPath[$i] <> '') { ?>
<?php if ($bannerTitle[$i] == '') $bannerTitle[$i] = "advertisement";
	  if ($bannerAlt[$i] == '') $bannerAlt[$i] = "advertisement"; ?>
	<a href="<?php echo $bannerUrl[$i] ?>" <?php if ($new_window == 1) echo('target="_blank"') ?>><img src="<?php if ($use_relpath == 1) echo home_url(); else echo $bannerPath[$i]; ?><?php if ($use_relpath == 1 ) echo ("/" . $bannerPath[$i]); ?>" alt="<?php echo $bannerAlt[$i]; ?>" title="<?php echo $bannerTitle[$i]; ?>" /></a>
<?php }; $i++;
endwhile; ?>
</div> <!-- end adwrap -->
<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = stripslashes($new_instance['title']);
		$instance['use_relpath'] = 0;
		$instance['new_window'] = 0;
		if ( isset($new_instance['use_relpath']) ) $instance['use_relpath'] = 1;
		if ( isset($new_instance['new_window']) ) $instance['new_window'] = 1;
		$instance['bannerOnePath'] = esc_url_raw($new_instance['bannerOnePath']);
		$instance['bannerOneUrl'] = esc_url_raw($new_instance['bannerOneUrl']);
		$instance['bannerOneTitle'] = strip_tags($new_instance['bannerOneTitle']);
		$instance['bannerOneAlt'] = strip_tags($new_instance['bannerOneAlt']);
		
		$instance['bannerTwoPath'] = esc_url_raw($new_instance['bannerTwoPath']);
		$instance['bannerTwoUrl'] = esc_url_raw($new_instance['bannerTwoUrl']);
		$instance['bannerTwoTitle'] = strip_tags($new_instance['bannerTwoTitle']);
		$instance['bannerTwoAlt'] = strip_tags($new_instance['bannerTwoAlt']);
		
		$instance['bannerThreePath'] = esc_url_raw($new_instance['bannerThreePath']);
		$instance['bannerThreeUrl'] = esc_url_raw($new_instance['bannerThreeUrl']);
		$instance['bannerThreeTitle'] = strip_tags($new_instance['bannerThreeTitle']);
		$instance['bannerThreeAlt'] = strip_tags($new_instance['bannerThreeAlt']);
		
		$instance['bannerFourPath'] = esc_url_raw($new_instance['bannerFourPath']);
		$instance['bannerFourUrl'] = esc_url_raw($new_instance['bannerFourUrl']);
		$instance['bannerFourTitle'] = strip_tags($new_instance['bannerFourTitle']);
		$instance['bannerFourAlt'] = strip_tags($new_instance['bannerFourAlt']);
		
		$instance['bannerFivePath'] = esc_url_raw($new_instance['bannerFivePath']);
		$instance['bannerFiveUrl'] = esc_url_raw($new_instance['bannerFiveUrl']);
		$instance['bannerFiveTitle'] = strip_tags($new_instance['bannerFiveTitle']);
		$instance['bannerFiveAlt'] = strip_tags($new_instance['bannerFiveAlt']);
		
		$instance['bannerSixPath'] = esc_url_raw($new_instance['bannerSixPath']);
		$instance['bannerSixUrl'] = esc_url_raw($new_instance['bannerSixUrl']);
		$instance['bannerSixTitle'] = strip_tags($new_instance['bannerSixTitle']);
		$instance['bannerSixAlt'] = strip_tags($new_instance['bannerSixAlt']);
		
		$instance['bannerSevenPath'] = esc_url_raw($new_instance['bannerSevenPath']);
		$instance['bannerSevenUrl'] = esc_url_raw($new_instance['bannerSevenUrl']);
		$instance['bannerSevenTitle'] = strip_tags($new_instance['bannerSevenTitle']);
		$instance['bannerSevenAlt'] = strip_tags($new_instance['bannerSevenAlt']);
		
		$instance['bannerEightPath'] = esc_url_raw($new_instance['bannerEightPath']);
		$instance['bannerEightUrl'] = esc_url_raw($new_instance['bannerEightUrl']);
		$instance['bannerEightTitle'] = strip_tags($new_instance['bannerEightTitle']);
		$instance['bannerEightAlt'] = strip_tags($new_instance['bannerEightAlt']);

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance, array('title'=>'Advertisement', 'use_relpath' => false, 'new_window' => true, 'bannerOnePath'=>'', 'bannerOneUrl'=>'', 'bannerOneTitle'=>'', 'bannerOneAlt'=>'', 'bannerTwoPath'=>'', 'bannerTwoUrl'=>'', 'bannerTwoTitle'=>'', 'bannerTwoAlt'=>'','bannerThreePath'=>'', 'bannerThreeUrl'=>'','bannerThreeTitle'=>'', 'bannerThreeAlt'=>'','bannerFourPath'=>'', 'bannerFourUrl'=>'','bannerFourTitle'=>'', 'bannerFourAlt'=>'','bannerFivePath'=>'', 'bannerFiveUrl'=>'','bannerFiveTitle'=>'', 'bannerFiveAlt'=>'','bannerSixPath'=>'', 'bannerSixUrl'=>'','bannerSixTitle'=>'','bannerSixAlt'=>'', 'bannerSevenPath'=>'', 'bannerSevenUrl'=>'','bannerSevenTitle'=>'','bannerSevenAlt'=>'','bannerEightPath'=>'', 'bannerEightUrl'=>'','bannerEightTitle'=>'','bannerEightAlt'=>'') );

		$title = esc_html($instance['title']);
		$bannerPath[1] = esc_url($instance['bannerOnePath']);
		$bannerUrl[1] = esc_url($instance['bannerOneUrl']);
		$bannerTitle[1] = esc_attr($instance['bannerOneTitle']);
		$bannerAlt[1] = esc_attr($instance['bannerOneAlt']);
		
		$bannerPath[2] = esc_url($instance['bannerTwoPath']);
		$bannerUrl[2] = esc_url($instance['bannerTwoUrl']);
		$bannerTitle[2] = esc_attr($instance['bannerTwoTitle']);
		$bannerAlt[2] = esc_attr($instance['bannerTwoAlt']);
		
		$bannerPath[3] = esc_url($instance['bannerThreePath']);
		$bannerUrl[3] = esc_url($instance['bannerThreeUrl']);
		$bannerTitle[3] = esc_attr($instance['bannerThreeTitle']);
		$bannerAlt[3] = esc_attr($instance['bannerThreeAlt']);
		
		$bannerPath[4] = esc_url($instance['bannerFourPath']);
		$bannerUrl[4] = esc_url($instance['bannerFourUrl']);
		$bannerTitle[4] = esc_attr($instance['bannerFourTitle']);
		$bannerAlt[4] = esc_attr($instance['bannerFourAlt']);
		
		$bannerPath[5] = esc_url($instance['bannerFivePath']);
		$bannerUrl[5] = esc_url($instance['bannerFiveUrl']);
		$bannerTitle[5] = esc_attr($instance['bannerFiveTitle']);
		$bannerAlt[5] = esc_attr($instance['bannerFiveAlt']);
		
		$bannerPath[6] = esc_url($instance['bannerSixPath']);
		$bannerUrl[6] = esc_url($instance['bannerSixUrl']);
		$bannerTitle[6] = esc_attr($instance['bannerSixTitle']);
		$bannerAlt[6] = esc_attr($instance['bannerSixAlt']);
		
		$bannerPath[7] = esc_url($instance['bannerSevenPath']);
		$bannerUrl[7] = esc_url($instance['bannerSevenUrl']);
		$bannerTitle[7] = esc_attr($instance['bannerSevenTitle']);
		$bannerAlt[7] = esc_attr($instance['bannerSevenAlt']);
		
		$bannerPath[8] = esc_url($instance['bannerEightPath']);
		$bannerUrl[8] = esc_url($instance['bannerEightUrl']);
		$bannerTitle[8] = esc_attr($instance['bannerEightTitle']);
		$bannerAlt[8] = esc_attr($instance['bannerEightAlt']);

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>'; ?>
		
		<input class="checkbox" type="checkbox" <?php checked($instance['use_relpath'], true) ?> id="<?php echo $this->get_field_id('use_relpath'); ?>" name="<?php echo $this->get_field_name('use_relpath'); ?>" />
		<label for="<?php echo $this->get_field_id('use_relpath'); ?>">Use Relative Image Paths</label><br />
		<input class="checkbox" type="checkbox" <?php checked($instance['new_window'], true) ?> id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window'); ?>" />
		<label for="<?php echo $this->get_field_id('new_window'); ?>">Open in a new window</label><br /><br />

		<?php	# Banner #1 Image
		echo '<p><label for="' . $this->get_field_id('bannerOnePath') . '">' . 'Banner #1 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerOnePath') . '" name="' . $this->get_field_name('bannerOnePath') . '" type="text" value="' . $bannerPath[1] . '" /></p>';
		# Banner #1 Url
		echo '<p><label for="' . $this->get_field_id('bannerOneUrl') . '">' . 'Banner #1 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerOneUrl') . '" name="' . $this->get_field_name('bannerOneUrl') . '" type="text" value="' . $bannerUrl[1] . '" /></p>';
		# Banner #1 Title
		echo '<p><label for="' . $this->get_field_id('bannerOneTitle') . '">' . 'Banner #1 Title:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerOneTitle') . '" name="' . $this->get_field_name('bannerOneTitle') . '" type="text" value="' . $bannerTitle[1] . '" /></p>';
		# Banner #1 Alt
		echo '<p><label for="' . $this->get_field_id('bannerOneAlt') . '">' . 'Banner #1 Alt:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerOneAlt') . '" name="' . $this->get_field_name('bannerOneAlt') . '" type="text" value="' . $bannerAlt[1] . '" /></p>';
		# Banner #2 Image
		echo '<p><label for="' . $this->get_field_id('bannerTwoPath') . '">' . 'Banner #2 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTwoPath') . '" name="' . $this->get_field_name('bannerTwoPath') . '" type="text" value="' . $bannerPath[2] . '" /></p>';
		# Banner #2 Url
		echo '<p><label for="' . $this->get_field_id('bannerTwoUrl') . '">' . 'Banner #2 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTwoUrl') . '" name="' . $this->get_field_name('bannerTwoUrl') . '" type="text" value="' . $bannerUrl[2] . '" /></p>';
		# Banner #2 Title
		echo '<p><label for="' . $this->get_field_id('bannerTwoTitle') . '">' . 'Banner #2 Title:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTwoTitle') . '" name="' . $this->get_field_name('bannerTwoTitle') . '" type="text" value="' . $bannerTitle[2] . '" /></p>';
		# Banner #2 Alt
		echo '<p><label for="' . $this->get_field_id('bannerTwoAlt') . '">' . 'Banner #2 Alt:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerTwoAlt') . '" name="' . $this->get_field_name('bannerTwoAlt') . '" type="text" value="' . $bannerAlt[2] . '" /></p>';
		# Banner #3 Image
		echo '<p><label for="' . $this->get_field_id('bannerThreePath') . '">' . 'Banner #3 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerThreePath') . '" name="' . $this->get_field_name('bannerThreePath') . '" type="text" value="' . $bannerPath[3] . '" /></p>';
		# Banner #3 Url
		echo '<p><label for="' . $this->get_field_id('bannerThreeUrl') . '">' . 'Banner #3 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerThreeUrl') . '" name="' . $this->get_field_name('bannerThreeUrl') . '" type="text" value="' . $bannerUrl[3] . '" /></p>';
		# Banner #3 Title
		echo '<p><label for="' . $this->get_field_id('bannerThreeTitle') . '">' . 'Banner #3 Title:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerThreeTitle') . '" name="' . $this->get_field_name('bannerThreeTitle') . '" type="text" value="' . $bannerTitle[3] . '" /></p>';
		# Banner #3 Alt
		echo '<p><label for="' . $this->get_field_id('bannerThreeAlt') . '">' . 'Banner #3 Alt:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerThreeAlt') . '" name="' . $this->get_field_name('bannerThreeAlt') . '" type="text" value="' . $bannerAlt[3] . '" /></p>';
		# Banner #4 Image
		echo '<p><label for="' . $this->get_field_id('bannerFourPath') . '">' . 'Banner #4 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFourPath') . '" name="' . $this->get_field_name('bannerFourPath') . '" type="text" value="' . $bannerPath[4] . '" /></p>';
		# Banner #4 Url
		echo '<p><label for="' . $this->get_field_id('bannerFourUrl') . '">' . 'Banner #4 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFourUrl') . '" name="' . $this->get_field_name('bannerFourUrl') . '" type="text" value="' . $bannerUrl[4] . '" /></p>';
		# Banner #4 Title
		echo '<p><label for="' . $this->get_field_id('bannerFourTitle') . '">' . 'Banner #4 Title:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFourTitle') . '" name="' . $this->get_field_name('bannerFourTitle') . '" type="text" value="' . $bannerTitle[4] . '" /></p>';
		# Banner #4 Alt
		echo '<p><label for="' . $this->get_field_id('bannerFourAlt') . '">' . 'Banner #4 Alt:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFourAlt') . '" name="' . $this->get_field_name('bannerFourAlt') . '" type="text" value="' . $bannerAlt[4] . '" /></p>';
		# Banner #5 Image
		echo '<p><label for="' . $this->get_field_id('bannerFivePath') . '">' . 'Banner #5 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFivePath') . '" name="' . $this->get_field_name('bannerFivePath') . '" type="text" value="' . $bannerPath[5] . '" /></p>';
		# Banner #5 Url
		echo '<p><label for="' . $this->get_field_id('bannerFiveUrl') . '">' . 'Banner #5 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFiveUrl') . '" name="' . $this->get_field_name('bannerFiveUrl') . '" type="text" value="' . $bannerUrl[5] . '" /></p>';
		# Banner #5 Title
		echo '<p><label for="' . $this->get_field_id('bannerFiveTitle') . '">' . 'Banner #5 Title:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFiveTitle') . '" name="' . $this->get_field_name('bannerFiveTitle') . '" type="text" value="' . $bannerTitle[5] . '" /></p>';
		# Banner #5 Alt
		echo '<p><label for="' . $this->get_field_id('bannerFiveAlt') . '">' . 'Banner #5 Alt:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerFiveAlt') . '" name="' . $this->get_field_name('bannerFiveAlt') . '" type="text" value="' . $bannerAlt[5] . '" /></p>';
		# Banner #6 Image
		echo '<p><label for="' . $this->get_field_id('bannerSixPath') . '">' . 'Banner #6 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSixPath') . '" name="' . $this->get_field_name('bannerSixPath') . '" type="text" value="' . $bannerPath[6] . '" /></p>';
		# Banner #6 Url
		echo '<p><label for="' . $this->get_field_id('bannerSixUrl') . '">' . 'Banner #6 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSixUrl') . '" name="' . $this->get_field_name('bannerSixUrl') . '" type="text" value="' . $bannerUrl[6] . '" /></p>';
		# Banner #6 Title
		echo '<p><label for="' . $this->get_field_id('bannerSixTitle') . '">' . 'Banner #6 Title:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSixTitle') . '" name="' . $this->get_field_name('bannerSixTitle') . '" type="text" value="' . $bannerTitle[6] . '" /></p>';
		# Banner #6 Alt
		echo '<p><label for="' . $this->get_field_id('bannerSixAlt') . '">' . 'Banner #6 Alt:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSixAlt') . '" name="' . $this->get_field_name('bannerSixAlt') . '" type="text" value="' . $bannerAlt[6] . '" /></p>';
		# Banner #7 Image
		echo '<p><label for="' . $this->get_field_id('bannerSevenPath') . '">' . 'Banner #7 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSevenPath') . '" name="' . $this->get_field_name('bannerSevenPath') . '" type="text" value="' . $bannerPath[7] . '" /></p>';
		# Banner #7 Url
		echo '<p><label for="' . $this->get_field_id('bannerSevenUrl') . '">' . 'Banner #7 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSevenUrl') . '" name="' . $this->get_field_name('bannerSevenUrl') . '" type="text" value="' . $bannerUrl[7] . '" /></p>';
		# Banner #7 Title
		echo '<p><label for="' . $this->get_field_id('bannerSevenTitle') . '">' . 'Banner #7 Title:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSevenTitle') . '" name="' . $this->get_field_name('bannerSevenTitle') . '" type="text" value="' . $bannerTitle[7] . '" /></p>';
		# Banner #7 Alt
		echo '<p><label for="' . $this->get_field_id('bannerSevenAlt') . '">' . 'Banner #7 Alt:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerSevenAlt') . '" name="' . $this->get_field_name('bannerSevenAlt') . '" type="text" value="' . $bannerAlt[7] . '" /></p>';
		# Banner #8 Image
		echo '<p><label for="' . $this->get_field_id('bannerEightPath') . '">' . 'Banner #8 Image:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerEightPath') . '" name="' . $this->get_field_name('bannerEightPath') . '" type="text" value="' . $bannerPath[8] . '" /></p>';
		# Banner #8 Url
		echo '<p><label for="' . $this->get_field_id('bannerEightUrl') . '">' . 'Banner #8 Url:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerEightUrl') . '" name="' . $this->get_field_name('bannerEightUrl') . '" type="text" value="' . $bannerUrl[8] . '" /></p>';
		# Banner #8 Title
		echo '<p><label for="' . $this->get_field_id('bannerEightTitle') . '">' . 'Banner #8 Title:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerEightTitle') . '" name="' . $this->get_field_name('bannerEightTitle') . '" type="text" value="' . $bannerTitle[8] . '" /></p>';
		# Banner #8 Alt
		echo '<p><label for="' . $this->get_field_id('bannerEightAlt') . '">' . 'Banner #8 Alt:' . '</label><input class="widefat" id="' . $this->get_field_id('bannerEightAlt') . '" name="' . $this->get_field_name('bannerEightAlt') . '" type="text" value="' . $bannerAlt[8] . '" /></p>';
		echo '<p><small>If you don\'t want to display some banners - leave approptiate fields blank.</small></p>';
	}

}// end AdvWidget class

function AdvWidgetInit() {
	register_widget('AdvWidget');
}

add_action('widgets_init', 'AdvWidgetInit');

?>