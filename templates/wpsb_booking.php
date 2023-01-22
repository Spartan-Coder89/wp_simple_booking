<?php

/**
 * Template Name: WP Simple Booking
 */

 get_header(); 
?>

<main>
  <section id="wpsb_booking">
    <div id="calendar" class="col_1"></div>
    <div class="col_2">
      <div id="time_available_list">
        <div class="time" data-start_time="9:00" data-end_time="9:30">8:30 AM - 9:30 AM</div>
        <div class="time" data-start_time="13:00" data-end_time="13:30">1:00 PM - 1:30 PM</div>
      </div>
    </div>
    <input type="hidden" id="timeslots_data" value="">
    <input type="hidden" id="wpsb_booking_page_nonce" value="<?php echo wp_create_nonce('wpsb_booking_page_nonce'); ?>">
  </section>
  <form action="" method="POST" id="hidden_form"></form>
</main>

<?php get_footer(); ?>