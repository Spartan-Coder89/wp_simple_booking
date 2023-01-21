<?php 

class Calendar
{ 
  /**
   * Create the page wpsb_booking if it does not exists
   */
  function setup_page() {
    
    if (empty(get_page_by_path('wpsb_booking'))) {
      
      $post_id = wp_insert_post([
        'post_title' => 'WP Simple Booking',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_name' => 'wpsb_booking'
      ]);

      update_post_meta(get_post($post_id)->ID, '_wp_page_template', plugin_dir_path(__DIR__) .'templates/wpsb_booking.php');
    }
  }

  /**
   * Add custom page template to list of options
   */
  function custom_page_templates($templates) {

    $templates[plugin_dir_path(__DIR__) .'templates/wpsb_booking.php'] = 'WP Simple Booking';
    return $templates;
  }

  /**
   * Load custom page template if selected
   */
	public function load_custom_page_template($template) {

		global $post;

    $file = plugin_dir_path(__DIR__) .'templates/wpsb_booking.php';
    $current_template = get_post_meta( $post->ID, '_wp_page_template', true );

		if (!$post or ($current_template != $file)) {
			return $template;
		}

		if (file_exists($file)) {
			return $file;
		}

		return $template;
	}

}