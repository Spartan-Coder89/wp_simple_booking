<?php

/**
 * Plugin Name: WP Simple Booking
 * Plugin URI: https://simonjiloma.com
 * Description: Simple booking system for wordpress
 * Author: Simon Jiloma
 * Author URI: https://simonjiloma.com
 * Version: 0.0.1
 */

if (!defined('ABSPATH')) {
  die;
}

include_once 'classes/calendar.php';

class WP_Simple_Booking extends Calendar
{
  function __construct() {

    add_action('admin_menu', array($this, 'create_admin_page'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts_styles'));

    add_action('init', array($this, 'setup_page'));
    add_action('admin_post_wpsb_timeslots', array($this, 'save_timeslots'));

    if (!empty(get_page_by_path('wpsb_booking'))) {
      add_filter('theme_page_templates', array($this, 'custom_page_templates'));
      add_filter('template_include', array($this, 'load_custom_page_template'));
      add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_styles'));
    }
  }

  /**
   * Create the admin page
   */
  function create_admin_page() {

    add_menu_page( 
      __('Availability Time', 'textdomain' ), 
      'WP Simple Booking', 
      'manage_options', 
      'wp_simple_booking', 
      array($this, 'wp_simple_booking_callback')
    );
  }

  /**
   * Callback for the admin page
   */
  function wp_simple_booking_callback() {
    include_once 'templates/admin_page.php';
  }

  /**
   * Save available timeslots
   */
  function save_timeslots() {

    if (!isset($_POST['wpsb_admin_post_nonce'])) {
      return;
    }
  
    if (!wp_verify_nonce($_POST['wpsb_admin_post_nonce'], 'wpsb_admin_post_nonce')) {
      return;
    }
  
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    if (!isset($_POST['wpsb_timeslots'])) {
      return;
    }

    //  Expects an array as parameter
    function sanitize_input($arr) {

      foreach ($arr as $key => $value) {
    
        if (is_array($value)) {
          $arr[$key] = sanitize_input($value);
        } else {
          $arr[$key] = htmlspecialchars(strip_tags($value));
        }
      }
    
      return $arr;
    }
    
    //  Sanitize values recursively
    $wpsb_timeslots = $_POST['wpsb_timeslots'];
    $wpsb_timeslots = sanitize_input($wpsb_timeslots);

    //  Save
    update_option('_wpsb_timeslots', $wpsb_timeslots);

    wp_safe_redirect($_POST['redirect_url']);
    exit;
  }

  /**
   * Enqueue scripts and styles to wpsb_booking page
   */
  function enqueue_scripts_styles() {

    if (is_page('wpsb_booking')) {
      wp_enqueue_style('wpsb_css', plugin_dir_url(__FILE__) .'assets/css/wpsb_booking.css');
      wp_enqueue_script( 'fullcalendar_js', 'https://cdn.jsdelivr.net/npm/fullcalendar@6.0.3/index.global.min.js', null, 0.1, true );
      wp_enqueue_script( 'wpsb_js', plugin_dir_url(__FILE__) .'assets/js/wpsb_booking.js', null, 0.1, true );
    }
  }

  /**
   * Enqueue admin scripts and styles to wpsb_booking page
   */
  function enqueue_admin_scripts_styles($hook) {
    
    if ($hook == 'toplevel_page_wp_simple_booking') {
      wp_enqueue_style('admin_wpsb_css', plugin_dir_url(__FILE__) .'assets/css/admin_wpsb_booking.css');
      wp_enqueue_script('admin_wpsb_js', plugin_dir_url(__FILE__) .'assets/js/admin_wpsb_booking.js', null, 0.1, true);
    }
  }
}

$wp_simple_booking = new WP_Simple_Booking;