<?php
/*
Plugin Name: FourSquare Recent Checkins
Plugin URI: http://eskapism.se/playground/foursquare-recent-checkins/
Description: A widget that show your 5 most recent checkins at FourSquare. And on a map too. It's marvelous!
Author: Pär Thernström
Version: 1
Author URI: http://eskapism.se/
*/

/* widget code starts here */
class FourSquare_Recent_Checkins_Widget extends WP_Widget {
	function FourSquare_Recent_Checkins_Widget() {
		// widget actual processes
        parent::WP_Widget(false, $name = 'FourSquare Recent Checkins');
	}

	function form($instance) {
		// outputs the options form on admin
		$title = esc_attr($instance['title']);
		$rss = esc_attr($instance['rss']);
		$main_image_width = (int) $instance['main_image_width'];
		$main_image_height = (int) $instance['main_image_height'];
		$small_image_width = (int) $instance['small_image_width'];
		$small_image_height = (int) $instance['small_image_height'];
		$text_before = esc_attr($instance['text_before']);
		$text_after = esc_attr($instance['text_after']);
		
		// set some defaults
		// suitable for twenty ten by standard
		if (!$title) { $title = "FourSquare Recent Checkins"; }
		if (!$main_image_width) { $main_image_width = 184; }
		if (!$main_image_height) { $main_image_height = 150; }
		if (!$small_image_width) { $small_image_width = 184; }
		if (!$small_image_height) { $small_image_height = 75; }
		if (!$text_after) {
			$text_after = "<p>Powered by <a href='http://wordpress.org/extend/plugins/foursquare-recent-checkins/'>FourSquare Recent Checkins</a></p>";
		}

	    ?>
    	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title'); ?>:
	    	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
    	</p>
    	<p><label for="<?php echo $this->get_field_id('rss'); ?>"><?php _e('RSS-address'); ?>:
	    	<input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo $rss; ?>" /></label>
	    	<small>Find your RSS-feed by going to <a target="_blank" title="Open this URL in a new window/tab" href="http://foursquare.com/feeds">foursquare.com/feeds</a></small>
    	</p>
    	
    	<p>
    		<strong>Image for the last checkin</strong>
    	</p>
    	<p>
	    	<label for="<?php echo $this->get_field_id('main_image_width'); ?>"><?php _e('Width'); ?>:
	    	<input class="widefat" id="<?php echo $this->get_field_id('main_image_width'); ?>" name="<?php echo $this->get_field_name('main_image_width'); ?>" type="text" value="<?php echo $main_image_width; ?>" /></label>
    	</p>
    	<p>
    		<label for="<?php echo $this->get_field_id('main_image_height'); ?>"><?php _e('Height'); ?>:
	    	<input class="widefat" id="<?php echo $this->get_field_id('main_image_height'); ?>" name="<?php echo $this->get_field_name('main_image_height'); ?>" type="text" value="<?php echo $main_image_height; ?>" /></label>
    	</p>

    	<p>
    		<strong>Image for earlier checkins</strong>
    	</p>
    	<p>
    		<label for="<?php echo $this->get_field_id('small_image_width'); ?>"><?php _e('Width'); ?>:
	    	<input class="widefat" id="<?php echo $this->get_field_id('small_image_width'); ?>" name="<?php echo $this->get_field_name('small_image_width'); ?>" type="text" value="<?php echo $small_image_width; ?>" /></label>
    	</p>
    	<p>
    		<label for="<?php echo $this->get_field_id('small_image_height'); ?>"><?php _e('Height'); ?>:
	    	<input class="widefat" id="<?php echo $this->get_field_id('small_image_height'); ?>" name="<?php echo $this->get_field_name('small_image_height'); ?>" type="text" value="<?php echo $small_image_height; ?>" /></label>
    	</p>
    	
    	<p>
    		<strong>Text before and after widget</strong>
    	</p>
    	<p>
    		<label for="<?php echo $this->get_field_id('text_before'); ?>"><?php _e('Before widget'); ?>:
	    	<input class="widefat" id="<?php echo $this->get_field_id('text_before'); ?>" name="<?php echo $this->get_field_name('text_before'); ?>" type="text" value="<?php echo $text_before; ?>" /></label>
    	</p>
    	<p>
    		<label for="<?php echo $this->get_field_id('text_after'); ?>"><?php _e('After widget'); ?>:
	    	<input class="widefat" id="<?php echo $this->get_field_id('text_after'); ?>" name="<?php echo $this->get_field_name('text_after'); ?>" type="text" value="<?php echo $text_after; ?>" /></label>
    	</p>
    	
		<?php 
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['rss'] = strip_tags($new_instance['rss']);
		$instance['main_image_width'] = strip_tags($new_instance['main_image_width']);
		$instance['main_image_height'] = strip_tags($new_instance['main_image_height']);
		$instance['small_image_width'] = strip_tags($new_instance['small_image_width']);
		$instance['small_image_height'] = strip_tags($new_instance['small_image_height']);
		$instance['text_before'] = ($new_instance['text_before']);
		$instance['text_after'] = ($new_instance['text_after']);
		return $instance;
	}

	function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        ?>
 		<?php echo $before_widget; ?>
        <?php if ( $title ) { echo $before_title . $title . $after_title; } ?>
		<?php
		// content here
		$rss = esc_attr($instance['rss']);
		$main_image_width = $instance['main_image_width'];
		$main_image_height = $instance['main_image_height'];
		$small_image_width = $instance['small_image_width'];
		$small_image_height = $instance['small_image_height'];
		$text_before = $instance['text_before'];
		$text_after = $instance['text_after'];

		add_filter( 'wp_feed_cache_transient_lifetime', 'foursquare_recent_checkins_wp_feed_cache_transient_lifetime');
		$rss = fetch_feed($rss);
		remove_filter('wp_feed_cache_transient_lifetime', 'foursquare_recent_checkins_wp_feed_cache_transient_lifetime');
		
		if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
		    $maxitems = $rss->get_item_quantity(5); 
		    
		    if ($text_before) {
		    	echo $text_before;
		    }
		    
		    echo "<ul>";
		    for ($i=0; $i<$maxitems; $i++) {

		    	$item = $rss->get_item($i);
		    	
		    	$link = esc_html($item->get_permalink());
		    	$description = esc_html($item->get_description());

				#$date = $item->get_local_date();
				#echo $date;
				$date_unix = strtotime($item->get_date());

				$date_locale = date_i18n(get_option('date_format'), $date_unix);
				$time_locale = date_i18n(get_option('time_format'), $date_unix);
				
				$date_str = "";
				
				// if today
				if (date("Ymd", $date_unix) == date("Ymd", time())) {
					$date_str .= $time_locale . " " . __("today");
				} else {
					$date_str .= sprintf( __('%1$s at %2$s'), $date_locale,  $time_locale);
				}
				
		    	$lat = $item->get_latitude();
		    	$lng = $item->get_longitude();
		    	
		    	if ($i == 0) {
			    	// big image
			    	$img_src = "http://maps.google.com/maps/api/staticmap?sensor=false&size={$main_image_width}x{$main_image_height}&zoom=16&markers=xicon:http://foursquare.com/img/categories/shops/default.png|$lat,$lng";
					$img = "<img src='$img_src' alt='' width='$main_image_width' height='$main_image_height' >";
			    } else {
					// small image
					$img_src = "http://maps.google.com/maps/api/staticmap?sensor=false&size={$small_image_width}x{$small_image_height}&zoom=15&markers=size:small|xicon:http://foursquare.com/img/categories/shops/default.png|$lat,$lng";
				    $img = "<img src='$img_src' alt='' width='$small_image_width' height='$small_image_height' >";
			    }
		    	
				$class = " class='checkin checkin-num-$i ";
				if ($i==0) {
					$class .= " checkin-first ";
				} else {
					$class .= " checkin-notfirst ";
				}
				if ($i%2==0) {
					$class .= " checkin-odd ";
				} else {
					$class .= " checkin-even ";
				}
				
				$class .= "'";
		    	// and here the output goes..
				echo "<li $class>";
				echo "<span class='map'><a href='$link'>$img</a></span> ";
				echo "<span class='date'>$date_str</span> ";
				echo "<span cass='description'><a href='$link'>$description</a></span>";
				echo "</li>";
		    	
		    }
		    echo "</ul>";

		    if ($text_after) {
		    	echo $text_after;
		    }
		    
		endif;
		
		?>
        <?php echo $after_widget; ?>
        <?php
	}

}
#register_widget('My_Widget');
add_action('widgets_init', create_function('', 'return register_widget("FourSquare_Recent_Checkins_Widget");'));

// For how long should we cache the checkins. Maybe set through an option?
function foursquare_recent_checkins_wp_feed_cache_transient_lifetime($time) {
	return 3600;
}
