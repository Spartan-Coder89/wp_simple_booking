<?php

/**
 * Template Name: WP Simple Booking
 */

 get_header(); 
?>

<main>
  <section id="wpsb_booking">
    <?php
      if (isset($_GET['success'])) {
        echo '<div id="notif">'. $_GET['success'] .'<span id="close_notif">x</span></div>';
      }
    ?>
    <div id="calendar" class="col_1"></div>
    <div class="col_2">
      <form id="booking_form" action="<?php echo admin_url('admin-post.php') .'?action=wpsb_booking'; ?>" method="POST">
        <div>
          <label>Email:</label>
          <input type="email" id="attendee_email" class="input_check" name="attendee_email" value="">
        </div>
        <div>
          <label>Fullname:</label>
          <input type="text" id="attendee_name" class="input_check" name="attendee_name" value="">
        </div>
        <div>
          <label>Type of meeting:</label>
          <select name="type_of_meeting" class="input_check">
            <option value="zoom">Zoom</option>
            <option value="google_meet">Google Meet</option>
            <option value="skype">Skype</option>
            <option value="office">Office</option>
          </select>
        </div>
        <input type="hidden" id="event_start" class="input_check" name="event_start" value="">
        <input type="hidden" id="event_end" class="input_check" name="event_end" value="">
        <input type="hidden" id="wpsb_booking_page_nonce" name="wpsb_booking_page_nonce" value="<?php echo wp_create_nonce('wpsb_booking_page_nonce'); ?>">
        <input type="hidden" id="return_url" name="return_url" value="<?php echo get_site_url() .'/wpsb_booking'; ?>">
        <input type="submit" value="Set Appointment">
      </form>

      <p class="timeslots_label">Timeslots Available:</p>
      <div id="time_available_list">
      </div>
    </div>
    <input type="hidden" id="timeslots_data" value="">
  </section>
</main>

<?php get_footer(); ?>