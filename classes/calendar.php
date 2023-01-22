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
	function load_custom_page_template($template) {

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

  /**
   * Rest API for retrieving slots
   */
  function calendar_rest_api() {
    register_rest_route( 'wpsb_booking/v1', '/timeslots/', array(
      'methods' => 'GET',
      'callback' => array($this, 'calendar_rest_api_callback'),
    ));
  }

  /**
   * Callback for calendar rest api
   */
  function calendar_rest_api_callback(WP_REST_Request $request) {

    if (!isset($request['wpsb_booking_page_nonce'])) {
      return;
    }

    if (!wp_verify_nonce( $request['wpsb_booking_page_nonce'], 'wpsb_booking_page_nonce' )) {
      return;
    }

    $return_value = null;

    if (!empty(get_option('_wpsb_timeslots'))) {

      $wpsb_timeslots = get_option('_wpsb_timeslots');

      if (is_array($wpsb_timeslots) and !empty($wpsb_timeslots)) {

        $restructured = array();

        foreach ($wpsb_timeslots as $key => $value) {

          $expl_value = explode('T', $value);
          $date = $expl_value[0];
          $time = $expl_value[1];

          $restructured[$date][] = $time;
        }

        $return_value = $restructured;
      }
    }
    
    return $return_value;
  }
}