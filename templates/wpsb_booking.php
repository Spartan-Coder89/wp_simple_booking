<?php

/**
 * Template Name: WP Simple Booking
 */

 get_header(); 
?>

<main>
  <section id="wpsb_booking">
    <div id="calendar" class="col_1"></div>
    <div id="time_available_list" class="col_2">
      <div class="time" data-start_time="9:00" data-end_time="9:30">8:30 AM - 9:30 AM</div>
      <div class="time" data-start_time="13:00" data-end_time="13:30">1:00 PM - 1:30 PM</div>
    </div>
    <input type="hidden" id="available_time" value="">
  </section>
  <form action="" method="POST" id="hidden_form"></form>
</main>

<?php get_footer(); ?>